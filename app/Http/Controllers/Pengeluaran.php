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
        foreach ($unique_dataaa as $keyyy => $attt) {
            $datdetail[$keyyy]["pengeluaran"] = $attt;
            foreach ($unique_data as $key => $at) {
                foreach ($unique_dataa as $keyy => $att) {
                    foreach ($data as $ke => $a) {
                        if ($at == $a->year && $att == $a->month && $attt == $a->jenisPengeluaran->id) {
                            $datdetail[$keyyy]["data"][$ke]["tahun"] = $at;
                            $datdetail[$keyyy]["data"][$ke]['bulan'] = $a->month;
                            $datdetail[$keyyy]["data"][$ke]['total'] = $a->total;
                            //                 $datdetail[$key]["pengeluaran"][$keyy]['jenis pengeluaran'] = $at->jenisPengeluaran->keterangan;
                        }
                    }
                }
            }
        }
        $jenisPengeluaran = JenisPengeluaran::get();
        //return $datdetail;
        return view('/kas/report/akunBiayaReport', ['judul' => "User", "datdetail" => $datdetail, 'jenisPengeluaran' => $jenisPengeluaran]);
    }
}
