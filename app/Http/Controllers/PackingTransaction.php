<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\NgTransaction;
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
        $dataa = ModelsPackingTransaction::with('customer', 'Part');
        if ($request->datein && $request->dateen) {
            $dataa->whereDate('date_packing', '>=', $request->datein)
                ->whereDate('date_packing', '<=', $request->dateen);
        } else {
            $dataa->whereDate('date_packing', '=', date("Y-m-d"));
        };
        $data = $dataa->orderBy('created_at', 'DESC');


        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
                    <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date_packing' => ['required', 'string', 'max:255'],
                'part_id' => ['required', 'string', 'max:255'],
                'cust_id' => ['required', 'string', 'max:255'],
                'operator' => ['required', 'string', 'max:255'],
            ]);

            $get_user = User::where("name", $request->user_id)->first();

            $post = new ModelsPackingTransaction();

            $post->shift = $request->shift;
            $post->date_packing = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_packing)));
            $post->user_id = $get_user->id;
            $post->cust_id = $request->cust_id;
            $post->part_id = $request->part_id;
            $post->operator = $request->operator;
            $post->total_fg = str_replace(",", "", $request->total_fg);
            $post->total_ng = str_replace(",", "", $request->total_ng);
            $post->status = $request->status;
            $post->save();

            $postt = new NgTransaction();

            $postt->packing_id = $post->id;
            $postt->over_paint = $request->over_paint;
            $postt->bintik_or_pin_hole = $request->bintik_or_pin_hole;
            $postt->minyak_or_map = $request->minyak_or_map;
            $postt->cotton = $request->cotton;
            $postt->no_paint_or_tipis = $request->no_paint_or_tipis;
            $postt->scratch = $request->scratch;
            $postt->air_pocket = $request->air_pocket;
            $postt->kulit_jeruk = $request->kulit_jeruk;
            $postt->kasar = $request->kasar;
            $postt->karat = $request->karat;
            $postt->water_over = $request->water_over;
            $postt->minyak_kering = $request->minyak_kering;
            $postt->dented = $request->dented;
            $postt->keropos = $request->keropos;
            $postt->nempel_jig = $request->nempel_jig;
            $postt->lainnya = $request->lainnya;

            $postt->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function edit(Request $request)
    {
        $get = ModelsPackingTransaction::with('Part', 'customer', 'ng', 'user')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'string', 'max:255'],

            ]);

            if ($request->status == "CLOSE" && $request->detail_id) {
                $packing = ModelsPackingTransaction::find($request->id);
                // $packing->shift = $request->shift;
                $packing->total_ng = str_replace(",", "", $request->total_ng);
                $packing->total_fg = str_replace(",", "", $request->total_fg);
                $packing->status = $request->status;
                $packing->save();

                $ng = NgTransaction::firstOrNew(['packing_id' => $request->id]);
                $ng->packing_id = $request->id;
                $ng->over_paint = $request->over_paint;
                $ng->bintik_or_pin_hole = $request->bintik_or_pin_hole;
                $ng->minyak_or_map = $request->minyak_or_map;
                $ng->cotton = $request->cotton;
                $ng->no_paint_or_tipis = $request->no_paint_or_tipis;
                $ng->scratch = $request->scratch;
                $ng->air_pocket = $request->air_pocket;
                $ng->kulit_jeruk = $request->kulit_jeruk;
                $ng->kasar = $request->kasar;
                $ng->karat = $request->karat;
                $ng->water_over = $request->water_over;
                $ng->minyak_kering = $request->minyak_kering;
                $ng->dented = $request->dented;
                $ng->keropos = $request->keropos;
                $ng->nempel_jig = $request->nempel_jig;
                $ng->lainnya = $request->lainnya;

                $ng->save();
            } else {
                $packing = ModelsPackingTransaction::find($request->id);
                $packing->status = $request->status;
                $packing->save();
            }

            $data = [$packing];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function destroy($id)
    {
        $post = ModelsPackingTransaction::find($id);
        $post->delete();

        $postt = NgTransaction::where('packing_id', $id);
        $postt->delete();

        return response()->json($post);
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
