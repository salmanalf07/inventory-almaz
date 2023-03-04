<?php

namespace App\Http\Controllers;

use App\Models\Production as ModelsProduction;
use App\Models\ProductionStd;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Production extends Controller
{
    public function json(Request $request)
    {
        if ($request->datein && $request->dateen) {
            $dataa = ModelsProduction::whereDate('date_production', '>=', $request->datein)
                ->whereDate('date_production', '<=', $request->dateen);
        } else {
            $dataa = ModelsProduction::whereDate('date_production', '=', date("Y-m-d"));
        }
        $data = $dataa->get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
                <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'shift' => ['required', 'string', 'max:255'],
                'date_production' => ['required', 'string', 'max:255'],
                'output_act' => ['required', 'string', 'max:255'],
                'hour_actual_st' => ['required', 'string', 'max:255'],
                'hour_actual_en' => ['required', 'string', 'max:255'],
            ]);
            $prodstd = ProductionStd::where('status', 'Active')->first();

            $post = new ModelsProduction();
            $post->prodstd_id = $prodstd->id;
            $post->shift = $request->shift;
            $post->date_production = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_production)));
            $post->hour_actual_st = $request->hour_actual_st;
            $post->hour_actual_en = $request->hour_actual_en;
            $post->output_act = $request->output_act;
            $post->hanger_rusak = $request->hanger_rusak;
            $post->tidak_racking = $request->tidak_racking;
            $post->keteter = $request->keteter;
            $post->tidak_ada_barang = $request->tidak_ada_barang;
            $post->trouble_mesin = $request->trouble_mesin;
            $post->trouble_chemical = $request->trouble_chemical;
            $post->trouble_utility = $request->trouble_utility;
            $post->trouble_ng = $request->trouble_ng;
            $post->mati_lampu = $request->mati_lampu;
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
        $get = ModelsProduction::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'shift' => ['required', 'string', 'max:255'],
                'date_production' => ['required', 'string', 'max:255'],
                'output_act' => ['required', 'string', 'max:255'],
                'hour_actual_st' => ['required', 'string', 'max:255'],
                'hour_actual_en' => ['required', 'string', 'max:255'],
            ]);

            $post = ModelsProduction::find($id);
            $post->shift = $request->shift;
            $post->date_production = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_production)));
            $post->hour_actual_st = $request->hour_actual_st;
            $post->hour_actual_en = $request->hour_actual_en;
            $post->output_act = $request->output_act;
            $post->hanger_rusak = $request->hanger_rusak;
            $post->tidak_racking = $request->tidak_racking;
            $post->keteter = $request->keteter;
            $post->tidak_ada_barang = $request->tidak_ada_barang;
            $post->trouble_mesin = $request->trouble_mesin;
            $post->trouble_chemical = $request->trouble_chemical;
            $post->trouble_utility = $request->trouble_utility;
            $post->trouble_ng = $request->trouble_ng;
            $post->mati_lampu = $request->mati_lampu;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
}
