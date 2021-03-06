<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailOrder;
use App\Models\DetailPartIn;
use App\Models\DetailSJ;
use App\Models\HistoryPart;
use App\Models\Order;
use App\Models\Parts as ModelsParts;
use App\Models\SJ;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Parts extends Controller
{
    public function json()
    {
        $data = ModelsParts::with('customer')->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Action
                </button>
                <div class="dropdown-menu">
                <button id="mass-price" data-id="' . $data->id . '" class="dropdown-item">Upd. Price Mass</button>
                <button id="edit" data-id="' . $data->id . '" class="dropdown-item">Update</button>
                <button id="delete" data-id="' . $data->id . '" class="dropdown-item">Delete</button>
                </div>
                </div>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cust_id' => ['required', 'string', 'max:255'],
                'part_no' => ['required', 'string', 'max:255'],
                'part_name' => ['required', 'string', 'max:255'],
            ]);
            if ($request->price) {
                $price = str_replace(",", "", $request->price);
            } else {
                $price = 0;
            }
            $get = Customer::find($request->cust_id);

            $post = new ModelsParts();
            $post->cust_id = $request->cust_id;
            $post->name_local = $request->part_name . '-' . $get->code . '-' . substr($request->part_no, -5);
            $post->part_no = $request->part_no;
            $post->part_name = $request->part_name;
            $post->price = $price;
            $post->sa_dm = $request->sa_dm;
            $post->qty_pack = $request->qty_pack;
            $post->type_pack = $request->type_pack;
            $post->information = $request->information;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsParts::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'cust_id' => ['required', 'string', 'max:255'],
                'name_local' => ['required', 'string', 'max:255'],
                'part_no' => ['required', 'string', 'max:255'],
                'part_name' => ['required', 'string', 'max:255'],
            ]);

            $get = Customer::find($request->cust_id);

            $post = ModelsParts::find($id);
            if ($post->price != str_replace(",", "", $request->price)) {

                $postt = new HistoryPart();
                $postt->cust_id = $post->cust_id;
                $postt->part_id = $post->id;
                $postt->name_local = $post->name_local;
                $postt->part_no = $post->part_no;
                $postt->part_name = $post->part_name;
                $postt->price = $post->price;
                $postt->periode = date("d-m-Y", strtotime($post->updated_at)) . " - " . date("d-m-Y", strtotime('now'));
                $postt->save();

                $post->price = str_replace(",", "", $request->price);
            }
            $post->cust_id = $request->cust_id;
            $post->name_local = $request->part_name . '-' . $get->code . '-' . substr($request->part_no, -5);
            $post->part_no = $request->part_no;
            $post->part_name = $request->part_name;
            $post->sa_dm = $request->sa_dm;
            $post->qty_pack = $request->qty_pack;
            $post->type_pack = $request->type_pack;
            $post->information = $request->information;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = ModelsParts::find($id);
        $post->delete();

        return response()->json($post);
    }

    public function update_price(Request $request)
    {
        $dateStart = date("Y-m-d", strtotime(str_replace('/', '-', $request->dateStart)));
        $dateEnd = date("Y-m-d", strtotime(str_replace('/', '-', $request->dateEnd)));
        $part = ModelsParts::find($request->id);
        $part_in = DetailPartIn::select('id', 'qty')->with('PartIn')
            ->where('part_id', '=', $request->id)
            ->whereHas('PartIn', function ($query) use ($request, $dateStart, $dateEnd) {
                $query->whereDate('date_in', '>=', $dateStart)
                    ->whereDate('date_in', '<=', $dateEnd);
            })
            ->get();
        if (count($part_in) != 0) {
            for ($count = 0; $count < count($part_in); $count++) {
                $post = DetailPartIn::where('id', '=', $part_in[$count]->id);
                $post->update([
                    'total_price' => $part->price * $part_in[$count]->qty,
                ]);
                $partin_ar[] = $part_in[$count]->partin_id;
            };

            $unique_partin = array_unique($partin_ar);

            foreach ($unique_partin as $value) {
                $detailsj = DetailPartIn::where('partin_id', $value)->sum('total_price');

                // $up_partin = PartIn::find($value);
                // $up_partin->grand_total = (int)$detailsj;
                // $up_partin->save();
            }
        }

        $detail_sj = DetailSJ::select('id', 'sj_id', 'qty')->with('DetailSJ')
            ->where('part_id', '=', $request->id)
            ->whereHas('DetailSJ', function ($query) use ($request, $dateStart, $dateEnd) {
                $query->whereDate('date_sj', '>=', $dateStart)
                    ->whereDate('date_sj', '<=', $dateEnd);
            })
            ->get();
        if (count($detail_sj) != 0) {
            for ($countt = 0; $countt < count($detail_sj); $countt++) {
                $post = DetailSJ::where('id', '=', $detail_sj[$countt]->id);
                $post->update([
                    'total_price' => $part->price * $detail_sj[$countt]->qty,
                ]);
                $ur[] = $detail_sj[$countt]->sj_id;
            };
            $unique_dataa = array_unique($ur);

            foreach ($unique_dataa as $value) {
                $detailsj = DetailSJ::where('sj_id', $value)->sum('total_price');

                $update = SJ::find($value);
                $update->grand_total = (int)$detailsj;
                $update->save();
            }
        }

        $detail_order = DetailOrder::select('id', 'qty')
            ->where('part_id', '=', $request->id)
            ->whereDate('created_at', '>=', $dateStart)
            ->whereDate('created_at', '<=', $dateEnd)
            ->get();
        if (count($detail_order) != 0) {
            for ($count = 0; $count < count($detail_order); $count++) {
                $post = DetailOrder::where('id', '=', $detail_order[$count]->id);
                $post->update([
                    'price' => $part->price * $detail_order[$count]->qty,
                ]);
                $order_ar[] = $detail_order[$count]->order_id;
            };
            // $unique_order = array_unique($order_ar);

            // foreach ($unique_order as $value) {
            //     $order = DetailOrder::where('order_id', $value)->sum('price');

            //     $up_order = Order::find($value);
            //     $up_order->total_price = (int)$order;
            //     $up_order->save();
            // }
        }

        return response()->json($part);
    }
}
