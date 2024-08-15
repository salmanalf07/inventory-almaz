<?php

namespace App\Http\Controllers;

use App\Models\DetailOrder;
use App\Models\DetailSJ;
use App\Models\Order as ModelsOrder;
use App\Models\Parts;
use App\Models\SJ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Order extends Controller
{
    public function json()
    {
        $data = ModelsOrder::with('customer');

        return DataTables::of($data)
            ->addColumn('count', function ($data) {
                $order = SJ::select('id')->where([
                    ['order_id', '=', $data->id],
                ])->get();

                $count = SJ::select('grand_total')->whereIn("id", $order->toArray())->sum('grand_total');

                if ($data->total_price != 0) {
                    $countt = round((($count / $data->total_price) * 100), 2);
                } else {
                    $countt = 0;
                }
                return $countt . " %";
            })
            ->addColumn('aksi', function ($data) {
                return
                    '<div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
                </button>
                <div class="dropdown-menu">
                <button id="edit" data-id="' . $data->id . '" class="dropdown-item">Edit</button>
                <button id="delete" data-id="' . $data->id . '" class="dropdown-item">Delete</button>
                <form method="post" role="form" action="reportProgress" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                <input type="hidden" name="_token" id="csrf-token" value="' . Session::token() . '" />
                <input class="form-control" type="text" name="id" id="id" value="' . $data->id . '" hidden>
                <button type="submit" id="reportProgress" data-id="' . $data->id . '" class="dropdown-item">Report Progress</button>
                </form>
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
            $post->date = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
            $post->save();


            $part_id = collect($request->part_id)->filter()->all();
            //$qty = collect($request->qty)->filter()->all();
            //$total_price = collect($request->total_price)->filter()->all();
            $qty = array_filter($request->qty, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($part_id); $count++) {
                $parts = Parts::find($part_id[$count]);
                $qtyBase = str_replace(".", "", $qty[$count]);
                $data = array(
                    'order_id' => $post->id,
                    'part_id' => $part_id[$count],
                    'qty'  => $qtyBase,
                    'price'  => $qtyBase * $parts->price,
                    'created_at' => date("Y-m-d H:i:s", strtotime('now'))
                );

                $insert[] = $data;
            }

            DetailOrder::insert($insert);
            $detailOrder = DetailOrder::where('order_id', $post->id)->get();
            ModelsOrder::where('id', $post->id)->update(['total_price' => $detailOrder->sum('price')]);

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

                $detail_id = collect($request->detail_id)->filter()->all();
                $part_id = collect($request->part_id)->filter()->all();
                $qty = array_filter($request->qty, function ($value) {
                    return ($value !== null && $value !== false && $value !== '');
                });
                for ($count = 0; $count < count($part_id); $count++) {
                    $parts = Parts::find($part_id[$count]);
                    $qtyBase = str_replace(".", "", $qty[$count]);
                    $saveDetail = DetailOrder::findOrNew($detail_id[$count] ?? "#");
                    $saveDetail->order_id = $id;
                    $saveDetail->part_id = $part_id[$count];
                    $saveDetail->qty = $qtyBase;
                    $saveDetail->price = $qtyBase * $parts->price;
                    $saveDetail->save();
                }
            }
            $detailOrder = DetailOrder::where('order_id', $post->id)->get();
            $post->total_price = $detailOrder->sum('price');
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
        }
        if ($request->cust_id != "#") {
            $dataa->whereRelation('Parts', 'cust_id', '=', $request->cust_id);
        }
        if ($request->date_st) {
            $dataa->whereHas('Order', function ($query) use ($request) {
                $query->whereDate('date', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        }

        $data = $dataa->get();

        foreach ($data as $order) {
            $sj = DetailSJ::with('DetailSJ')->where('part_id', $order->part_id)
                ->whereRelation('DetailSJ', 'order_id', '=', $order->order_id)
                ->sum('qty');
            if ($sj == null) {
                $order->qty_progress = 0;
            } else {
                $order->qty_progress = $sj;
            }
        }


        return DataTables::of($data)
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function count($id)
    {
        $data = DetailOrder::find($id)->get();

        foreach ($data as $dataa) {
            $order = SJ::select('id')->where([
                ['order_id', '=', $id],
            ])->get();

            $count = DetailSJ::select('qty')
                ->where('part_id', '=', $dataa->part_id)
                ->whereIn("sj_id", $order->toArray())
                ->sum('qty');

            $post = DetailOrder::find($dataa->id);
            $post->qty_progress = $count;
            $post->save();
        }
        return response()->json(200);
    }

    public function progress_po(Request $request)
    {
        try {
            $order = SJ::select('id')->where([
                ['order_id', '=', $request->po_id],
            ])->get();

            $count = DetailSJ::select('qty')
                ->where('part_id', '=', $request->part_id)
                ->whereIn("sj_id", $order->toArray())
                ->sum('qty');
            $part = Parts::find($request->part_id);
            $detOrder = DetailOrder::select('qty')->where([
                ['order_id', '=', $request->po_id],
                ['part_id', '=', $request->part_id]
            ])->first();
            // ->get();

            return response()->json(['part' => $part->name_local, 'qty' => $count, 'total' => $detOrder->qty]);
        } catch (\Throwable $th) {
            return response()->json(false);
        }
    }
}
