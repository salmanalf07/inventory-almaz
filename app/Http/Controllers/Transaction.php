<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\PackingTransaction;
use App\Models\Stock;
use App\Models\Transaction as ModelsTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Transaction extends Controller
{
    public function json(Request $request)
    {
        $dataa = DetailTransaction::with('Transaction', 'Part.customer')
            ->whereHas('Transaction', function ($query) use ($request) {
                if ($request->datein && $request->dateen) {
                    $query->whereDate('date_transaction', '>=', $request->datein)
                        ->whereDate('date_transaction', '<=', $request->dateen);
                } else {
                    $query->whereDate('date_transaction', '=', date("Y-m-d"));
                }
            });
        $data = $dataa->orderBy('created_at', 'DESC');


        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '
                    <button id="edit" data-id="' . $data->Transaction->id . '" class="btn btn-warning">Update</button>
                    <button id="delete" data-id="' . $data->Transaction->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi', 'no_partin'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date_transaction' => ['required', 'string', 'max:255'],
                'no_rak' => ['required', 'string', 'max:255'],
                'time_start' => ['required', 'string', 'max:255'],
                'operator' => ['required', 'string', 'max:255'],
            ]);


            $record = ModelsTransaction::latest()->first();
            if ($record === null) {
                $no_transaction = 1;
            } else {
                if (date("Y-m-d", strtotime($record->created_at)) != date("Y-m-d")) {
                    $no_transaction = 1;
                } else {
                    $no_transaction = $record->no_transaction + 1;
                }
            }

            $get_user = User::where("name", $request->user_id)->first();

            $post = new ModelsTransaction();
            $post->user_id = $get_user->id;
            $post->no_transaction = $no_transaction;

            $post->date_transaction = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_transaction)));
            $post->no_rak = $request->no_rak;
            $post->time_start = date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_start)));
            $post->operator = $request->operator;
            $post->grand_total = str_replace(",", "", $request->grand_total);
            $post->total_sa = $request->total_sa;
            $post->save();


            $part_id = collect($request->part_id)->filter()->all();
            $cust_id = collect($request->cust_id)->filter()->all();
            $type = collect($request->type)->filter()->all();
            $qty_in = collect($request->qty_in)->filter()->all();
            $sa = array_filter($request->sa, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($part_id); $count++) {
                $postt = new DetailTransaction();
                $postt->transaction_id = $post->id;
                $postt->cust_id = $cust_id[$count];
                $postt->part_id = $part_id[$count];
                $postt->type = $type[$count];
                $postt->qty_in  = str_replace(",", "", $qty_in[$count]);
                $postt->sa  = str_replace(",", "", $sa[$count]);
                $postt->price  = str_replace(",", "", $price[$count]);
                $postt->save();

                $posttt = new PackingTransaction();
                $posttt->detransaction_id = $postt->id;
                $posttt->save();
            }

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsTransaction::with('user', 'detail_transaction.Part')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'date_transaction' => ['required', 'string', 'max:255'],
                'no_rak' => ['required', 'string', 'max:255'],
                'time_start' => ['required', 'string', 'max:255'],
                'operator' => ['required', 'string', 'max:255'],

            ]);
            $get_user = User::where("name", $request->user_id)->first();

            $post = ModelsTransaction::find($id);
            $post->user_id = $get_user->id;
            $post->no_transaction = $request->no_transaction;
            $post->date_transaction = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_transaction)));
            $post->no_rak = $request->no_rak;
            if ($post->time_start != date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_start)))) {
                $post->time_start = date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_start)));
            }
            $post->operator = $request->operator;
            $post->grand_total = str_replace(",", "", $request->grand_total);
            $post->total_sa = $request->total_sa;
            $post->save();

            $detail_id = collect($request->detail_id)->filter()->all();
            $part_id = collect($request->part_id)->filter()->all();
            $cust_id = collect($request->cust_id)->filter()->all();
            $qty_in = collect($request->qty_in)->filter()->all();
            $sa = array_filter($request->sa, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($detail_id); $count++) {
                $recent = DetailTransaction::where(['id' => $detail_id[$count]]);
                $recentt = $recent->first();
                $qty_up = str_replace(",", "", $qty_in[$count]);
                $price_up = str_replace(",", "", $price[$count]);
                if ($recentt->qty_in != str_replace(",", "", $qty_in[$count])) {
                    $qty_up = str_replace(",", "", $qty_in[$count]) - $recentt->qty_in;
                    $price_up = str_replace(",", "", $price[$count]) - $recentt->total_price;
                }
                $recent->update([
                    'cust_id' => $cust_id[$count],
                    'part_id' => $part_id[$count],
                    'qty_in'  => str_replace(",", "", $qty_up),
                    'sa'  => str_replace(",", "", $sa[$count]),
                    'price'  => str_replace(",", "", $price_up),
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now'))
                ]);
            }

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = ModelsTransaction::find($id);
        $post->delete();

        $get = DetailTransaction::where(['transaction_id' => $id])->get();

        foreach ($get as $data) {
            $del_detail = DetailTransaction::find($data->id);
            $del_detail->delete();

            $del_packing = PackingTransaction::where('detransaction_id', $data->id);
            $del_packing->delete();
        }

        return response()->json($post);
    }

    public function rekap_production(Request $request)
    {
        $dataa = DetailTransaction::with('customer', 'Transaction', 'Part');
        if ($request->cust_id != "#") {
            $dataa->whereHas('Transaction', function ($query) use ($request) {
                $query->where('cust_id', $request->cust_id);
            });
        }
        if ($request->dateinn && $request->dateenn) {
            $dataa->whereHas('Transaction', function ($query) use ($request) {
                $query->whereDate('date_transaction', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->dateinn))))
                    ->whereDate('date_transaction', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->dateenn))));
            });
        }
        if ($request->status != "#") {
            $dataa->whereHas('Transaction', function ($query) use ($request) {
                $query->where('status', $request->status);
            });
        }

        $data = $dataa->get();

        return DataTables::of($data)
            ->toJson();
    }
}
