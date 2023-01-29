<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\DetailSJ;
use App\Models\Order as ModelsOrder;
use App\Models\SJ;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Order extends Controller
{
    public function json()
    {
        $data = ModelsOrder::with('customer', 'DetailOrder.Parts')->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('count', function ($data) {
                $order = SJ::select('id')->where([
                    ['order_id', '=', $data->id],
                ])->get();

                $count = SJ::select('grand_total')->whereIn("id", $order->toArray())->sum('grand_total');
                return $count;
            })
            ->addColumn('aksi', function ($data) {
                return
                    '<div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
                </button>
                <div class="dropdown-menu">
                <button id="count" data-id="' . $data->id . '" class="dropdown-item">Count</button>
                <button id="edit" data-id="' . $data->id . '" class="dropdown-item">Edit</button>
                <button id="delete" data-id="' . $data->id . '" class="dropdown-item">Delete</button>
                </div>
                </div>';
            })
            ->rawColumns(['count', 'aksi', 'no_partin'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'no_po' => ['required', 'string', 'max:255'],
                'cust_id' => ['required', 'string', 'max:255'],
                'date' => ['required', 'string', 'max:255'],

            ]);

            $post = new ModelsOrder();
            $post->no_po = $request->no_po;
            $post->cust_id = $request->cust_id;
            $post->total_price = str_replace(",", "", $request->grand_total);
            $post->date = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
            $post->save();

            $part_id = collect($request->part_id)->filter()->all();
            //$qty = collect($request->qty)->filter()->all();
            //$total_price = collect($request->total_price)->filter()->all();
            $qty = array_filter($request->qty, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $total_price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($part_id); $count++) {
                $data = array(
                    'order_id' => $post->id,
                    'part_id' => $part_id[$count],
                    'qty'  => str_replace(",", "", $qty[$count]),
                    'price'  => str_replace(",", "", $total_price[$count]),
                    'created_at' => date("Y-m-d H:i:s", strtotime('now'))
                );

                $insert[] = $data;
            }

            DetailOrder::insert($insert);

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsOrder::with('DetailOrder.Parts')->find($request->id);
        // ['order_id', "=", null],
        // $SJ = SJ::where([['cust_id', '=', $get->cust_id], ['status', "=", "INVOICE"]])->get();
        $SJ = SJ::with('customer')->where([['cust_id', '=', $get->cust_id], ['order_id', '=', $get->id]])
            ->orWhere([['order_id', "=", null]])->get();
        $noSJ = SJ::select('id')->where('order_id', '=', $get->id)->get();

        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json([$get, $SJ, $noSJ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'no_po' => ['required', 'string', 'max:255'],
            ]);

            $post = ModelsOrder::find($id);
            $post->no_po = $request->no_po;
            $post->status = $request->status;
            if (count(collect($request->detail_id)->filter()->all()) != 0) {
                $post->total_price = str_replace(",", "", $request->grand_total);

                $detail_id = collect($request->detail_id)->filter()->all();
                $part_id = collect($request->part_id)->filter()->all();
                $qty = array_filter($request->qty, function ($value) {
                    return ($value !== null && $value !== false && $value !== '');
                });
                $total_price = array_filter($request->total_price, function ($value) {
                    return ($value !== null && $value !== false && $value !== '');
                });
                for ($count = 0; $count < count($detail_id); $count++) {
                    DetailOrder::where(['id' => $detail_id[$count]])
                        ->update([
                            'part_id' => $part_id[$count],
                            'qty'  => str_replace(",", "", $qty[$count]),
                            'price'  => str_replace(",", "", $total_price[$count]),
                        ]);
                }
            }
            $post->save();
            return response()->json($post);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = ModelsOrder::find($id);
        $post->delete();

        $get = DetailOrder::where(['order_id' => $id])->get();

        foreach ($get as $data) {
            // $stock = StockWip::where(['part_id' => $data->part_id, 'type' => $data->type]);
            // $stockk = $stock->first();
            // $stock->update([
            //     'qty'  => $stockk->qty - $data->qty,
            //     'total_price'  => $stockk->total_price - $data->total_price,
            // ]);

            $del_detail = DetailOrder::find($data->id);
            $del_detail->delete();
        }

        return response()->json($post);
    }

    public function print_partin($id)
    {
        $data = ModelsOrder::with('customer', 'order', 'DetailOrder.Parts')->find($id);

        return view('/printOut/surat_partin', ['data' => $data]);
    }

    public function report_order(Request $request)
    {
        $dataa = DetailOrder::with('Order', 'Parts.customer');
        if ($request->cust_id != "#" && $request->part_id != "#") {
            $dataa->whereRelation('Parts', 'cust_id', '=', $request->cust_id);
            $dataa->where([
                ['part_id', '=', $request->part_id],
            ]);
            $dataa->whereHas('Order', function ($query) use ($request) {
                $query->whereDate('date', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->cust_id != "#") {
            $dataa->whereRelation('Parts', 'cust_id', '=', $request->cust_id);
            $dataa->whereHas('Order', function ($query) use ($request) {
                $query->whereDate('date', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->date_st) {
            $dataa->whereHas('Order', function ($query) use ($request) {
                $query->whereDate('date', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        }



        $data = $dataa->get();


        return DataTables::of($data)
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }
    public function count($id)
    {
        $order = SJ::select('id')->where([
            ['order_id', '=', $id],
        ])->get();

        $count = DetailSJ::select('qty')->whereIn("sj_id", $order->toArray())->sum('qty');

        $post = DetailOrder::find($id);
        $post->qty_progress = $count;
        $post->save();
        return response()->json($post);
    }
}
