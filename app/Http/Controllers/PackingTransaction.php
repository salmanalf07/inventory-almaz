<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\PackingTransaction as ModelsPackingTransaction;
use App\Models\Stock;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

use function PHPSTORM_META\type;

class PackingTransaction extends Controller
{
    public function json(Request $request)
    {
        $dataa = ModelsPackingTransaction::with('detail_transaction', 'detail_transaction.Transaction', 'detail_transaction.Part', 'detail_transaction.Part.customer')
            ->whereHas('detail_transaction.Transaction', function ($query) use ($request) {
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
                    '<button id="edit" data-id="' . $data->detail_transaction->Transaction->id . '" class="btn btn-warning">Update</button>';
            })
            ->rawColumns(['aksi', 'no_partin'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function edit(Request $request)
    {
        $get = Transaction::with('user', 'detail_transaction.Part', 'detail_transaction.Packing')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'time_end' => ['required', 'string', 'max:255'],
                'operator' => ['required', 'string', 'max:255'],

            ]);

            $post = Transaction::find($id);
            $post->time_end = date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_end)));
            $post->status = $request->status;
            $post->save();

            $detail_id = collect($request->detail_id)->filter()->all();
            $qty_out = collect($request->qty_out)->filter()->all();
            $total_ng = array_filter($request->total_ng, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $type_ng = collect($request->type_ng)->filter()->all();

            for ($count = 0; $count < count($detail_id); $count++) {
                $recent = ModelsPackingTransaction::where(['detransaction_id' => $detail_id[$count]]);
                $recentt = $recent->first();
                $qty_up = str_replace(",", "", $qty_out[$count]) - $recentt->qty_out;
                $ng_up = str_replace(",", "", $total_ng[$count]) - $recentt->total_ng;
                $recent->update([
                    'qty_out'  => str_replace(",", "", $qty_up),
                    'total_ng'  => str_replace(",", "", $ng_up),
                    'type_ng' => $type_ng[$count],
                    'operator' => $request->operator,
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now'))
                ]);

                $recenttt = $recent->with('detail_transaction')->first();
                if ($stock = Stock::where('part_id', $recenttt['detail_transaction']->part_id)->first()) {
                    $stock = Stock::where('part_id', $recenttt['detail_transaction']->part_id)->first();
                    Stock::where('part_id', $recenttt['detail_transaction']->part_id)
                        ->update([
                            'part_id' => $recenttt['detail_transaction']->part_id,
                            'qty'  => $stock['qty'] + str_replace(",", "", $qty_out[$count]),
                        ]);
                } else {
                    $datawip = array(
                        'part_id' => $recenttt['detail_transaction']->part_id,
                        'qty'  => str_replace(",", "", $qty_out[$count]),
                        'created_at' => date("Y-m-d H:i:s", strtotime('now'))
                    );
                    Stock::insert($datawip);
                };
            }

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function report_partin(Request $request)
    {
        $dataa = DetailTransaction::with('PartIn', 'Parts.customer');
        if ($request->cust_id != "#" && $request->type != "#") {
            $dataa->whereRelation('Parts', 'cust_id', '=', $request->cust_id);
            $dataa->where('type', '=', $request->type);
            $dataa->whereHas('PartIn', function ($query) use ($request) {
                $query->whereDate('date_in', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_in', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->part_id != "#" && $request->type != "#") {
            $dataa->where([
                ['part_id', '=', $request->part_id],
                ['type', '=', $request->type],
            ]);
            $dataa->whereHas('PartIn', function ($query) use ($request) {
                $query->whereDate('date_in', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_in', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->type != "#") {
            $dataa->where([
                ['type', '=', $request->type],
            ]);
            $dataa->whereHas('PartIn', function ($query) use ($request) {
                $query->whereDate('date_in', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_in', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->part_id != "#") {
            $dataa->where([
                ['part_id', '=', $request->part_id],
            ]);
            $dataa->whereHas('PartIn', function ($query) use ($request) {
                $query->whereDate('date_in', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_in', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->cust_id != "#") {
            $dataa->whereRelation('Parts', 'cust_id', '=', $request->cust_id);
            $dataa->whereHas('PartIn', function ($query) use ($request) {
                $query->whereDate('date_in', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_in', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } else {
            $dataa->whereHas('PartIn', function ($query) use ($request) {
                $query->whereDate('date_in', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_in', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        }


        $data = $dataa->get();


        return DataTables::of($data)
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }
}
