<?php

namespace App\Http\Controllers;

use App\Models\JenisPengeluaran;
use App\Models\Pengeluaran as ModelsPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class Pengeluaran extends Controller
{
    public function json(Request $request)
    {
        $data = ModelsPengeluaran::get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
                <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    function r_akunBiaya(Request $request)
    {
        $dataa = ModelsPengeluaran::with('jenisPengeluaran')->select('pengeluaran_id', 'month', DB::raw('YEAR(date) as year'), DB::raw('SUM(kredit) as total'))
            ->groupBy('pengeluaran_id', 'month', DB::raw('YEAR(date)'));
        if ($request->month_start != "#" && $request->month_end != "#") {
            $dataa->where('month', '>=', $request->month_start)
                ->where('month', '<=', $request->month_end);
        } else {
            $dataa->where('month', date("m"));
        }
        if ($request->year_search != "#") {
            $dataa->whereYear('date', $request->year_search);
        } else {
            $dataa->whereYear('date', date("Y"));
        }
        $data = $dataa->get();

        $ar = array();
        $arr = array();
        $arrr = array();
        foreach ($data as $att) {
            $ar[] = $att->year;
            $arr[] = $att->month;
            $arrr[] = $att->jenisPengeluaran->id;
            $unique_data = array_unique($ar);
            $unique_dataa = array_unique($arr);
            $unique_dataaa = array_unique($arrr);
        }
        $datdetail = array();
        sort($unique_dataa);
        foreach ($unique_dataaa as $keyyy => $attt) {
            $datdetail[$keyyy]["pengeluaran"] = $attt;

            foreach ($unique_data as $key => $at) {
                foreach ($unique_dataa as $keyy => $att) {
                    $found = false; // Menandakan apakah data ditemukan untuk bulan yang sesuai
                    foreach ($data as $ke => $a) {
                        if ($at == $a->year && $att == $a->month && $attt == $a->jenisPengeluaran->id) {
                            $datdetail[$keyyy]["data"][$ke + 1]["tahun"] = $at;
                            $datdetail[$keyyy]["data"][$ke + 1]['bulan'] = $a->month;
                            $datdetail[$keyyy]["data"][$ke + 1]['total'] = $a->total;
                            $found = true;
                        }
                    }

                    // Jika data tidak ditemukan untuk bulan yang sesuai, tambahkan entri dengan total 0
                    if (!$found) {
                        $datdetail[$keyyy]["data"][] = [
                            "tahun" => $at,
                            "bulan" => $att,
                            "total" => "0"
                        ];
                    }
                }
            }
        }

        $biayaUmum = JenisPengeluaran::where([
            ['noUrut', '!=', null],
            ['group', '=', 'biayaUmum']
        ])->get();
        $biayaOpr = JenisPengeluaran::where([
            ['noUrut', '!=', null],
            ['group', '=', 'biayaOpr']
        ])->get();
        //return $datdetail;
        return view('/kas/report/akunBiayaReport', ['judul' => "User", "datdetail" => $datdetail, 'biayaUmum' => $biayaUmum, 'biayaOpr' => $biayaOpr]);
    }
}
