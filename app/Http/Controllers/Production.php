<?php

namespace App\Http\Controllers;

use App\Models\Production as ModelsProduction;
use App\Models\ProductionStd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function grafik_production(Request $request)
    {
        $dataa = DB::table('productions')
            ->join(
                'production_stds',
                'production_stds.id',
                '=',
                'productions.prodstd_id'
            )
            ->join(
                'transactions',
                'transactions.date_transaction',
                '=',
                'productions.date_production'
            )
            ->join(
                'detail_transactions',
                'detail_transactions.transaction_id',
                '=',
                'transactions.id'
            )

            ->selectRaw('
            productions.shift,
            productions.date_production,
            productions.hour_actual_st,
            productions.hour_actual_en,
            productions.output_act,
            productions.hanger_rusak,
            productions.tidak_racking,
            productions.keteter,
            productions.tidak_ada_barang,
            productions.trouble_mesin,
            productions.trouble_chemical,
            productions.trouble_utility,
            productions.trouble_ng,
            productions.mati_lampu,
            production_stds.work_hours,
            production_stds.normal_capacity,
            production_stds.target,
            production_stds.status,
            sum(detail_transactions.qty_in) as qty_in
        ');

        $dataa->where('productions.deleted_at', '=', null);
        $dataa->where('transactions.deleted_at', '=', null);

        if ($request->date != null) {
            $date = explode(" - ", $request->date);
            $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
            $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));

            $dataa->whereDate('productions.date_production', '>=', $datein)
                ->whereDate('productions.date_production', '<=', $dateen);
        };

        if ($request->cust_id != "#") {
            $dataa->where('transactions.cust_id', $request->cust_id);
        };

        if ($request->shift != "#") {
            $dataa->where('productions.shift', $request->shift);
        } else {
            $dataa->where('productions.shift', 1);
        };

        $dataa->groupBy(
            'productions.shift',
            'productions.date_production',
            'productions.hour_actual_st',
            'productions.hour_actual_en',
            'productions.output_act',
            'productions.hanger_rusak',
            'productions.tidak_racking',
            'productions.keteter',
            'productions.tidak_ada_barang',
            'productions.trouble_mesin',
            'productions.trouble_chemical',
            'productions.trouble_utility',
            'productions.trouble_ng',
            'productions.mati_lampu',
            'production_stds.work_hours',
            'production_stds.normal_capacity',
            'production_stds.target',
            'production_stds.status',
        );

        $data = $dataa->get();

        //add tanggal semua
        $datesToAdd = [];

        $currentDate = $datein;
        while ($currentDate <= $dateen) {
            $datesToAdd[] = $currentDate;
            $currentDate = date("Y-m-d", strtotime("+1 day", strtotime($currentDate)));
        }

        //combine data
        $dataArray = $data->toArray();
        // Ambil semua tanggal pada array $data dan simpan ke dalam array $allDates
        $allDates = array_column($dataArray, "date_production");

        // Buat objek kosong untuk menyimpan data
        $dataObj = collect();

        // Loop untuk setiap tanggal yang ingin ditambahkan
        foreach ($datesToAdd as $date) {
            // Cek apakah tanggal sudah ada pada array $allDates
            if (!in_array($date, $allDates)) {
                // Jika belum, tambahkan data baru ke dalam objek $dataObj
                $std = ProductionStd::where('status', 'Active')->first();
                $dataObj->push([
                    "shift" => $request->shift,
                    "date_production" => $date,
                    "hour_actual_st" => null,
                    "hour_actual_en" => null,
                    "output_act" => 0,
                    "hanger_rusak" => null,
                    "tidak_racking" => null,
                    "keteter" => null,
                    "tidak_ada_barang" => null,
                    "trouble_mesin" => null,
                    "trouble_chemical" => null,
                    "trouble_utility" => null,
                    "trouble_ng" => null,
                    "mati_lampu" => null,
                    "work_hours" => 0,
                    "normal_capacity" => $std->normal_capacity,
                    "target" => $std->target,
                    "status" => $std->status,
                    "qty_in" => 0
                ]);
            }
        }

        // Gabungkan objek $dataObj dengan data asli
        $dataObj = $dataObj->merge($data);

        // Gunakan $dataObj sebagai data yang akan digunakan selanjutnya
        $data = json_decode(json_encode($dataObj), true);
        usort($data, function ($a, $b) {
            return strcmp($a['date_production'], $b['date_production']);
        });

        //return $data;
        return view('/report/r_summary_prod', ['record' => count($dataa->get()), "data" => $data]);
    }
}
