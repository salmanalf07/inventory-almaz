<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class BensinTol extends Controller
{
    public function json(Request $request)
    {
        $dataa = Pengeluaran::with('customers', 'drivers', 'jenisPengeluaran');

        if ($request->month != "" && $request->month) {
            $dataa->where('month', $request->month);
            $dataa->where('typeInput', $request->query('query'));
        } else {
            $dataa->where('month', date("m"));
            $dataa->where('typeInput', 'BensinTol');
        }

        if ($request->year != "" && $request->year) {
            $dataa->whereYear('date', $request->year);
        } else {
            $dataa->whereYear('date', date("Y"));
        }

        $data = $dataa->get();

        //saldo Akhir
        $totalDebit = $data->sum('debit');
        $totalKredit = $data->sum('kredit');

        // Menghitung saldo akhir
        $saldoAkhir = $totalDebit - $totalKredit;
        //end
        return DataTables::of($data, $saldoAkhir)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
                <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->with('saldoAkhir', $saldoAkhir)
            ->toJson();
    }

    public function storeBensinTol(Request $request)
    {
        try {
            $request->validate([
                'date' => ['required', 'string', 'max:255'],
                'pengeluaran_id' => ['required', 'string', 'max:255'],
                'uraian' => ['required', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:255'],
            ]);

            $post = Pengeluaran::findOrNew($request->id);
            $post->typeInput = $request->typeInput;
            $post->date = date("Y-m-d H:i", strtotime(str_replace('/', '-',  $request->date)));
            $post->pengeluaran_id = $request->pengeluaran_id;
            $post->cust_id = $request->cust_id;
            $post->car_id = $request->car_id;
            $post->driver_id = $request->driver_id;
            $post->month = $request->month;
            $post->uraian = $request->uraian;
            $post->debit = $request->debit == null ? 0 : str_replace(".", "", $request->debit);
            $post->kredit = $request->kredit == null ? 0 : str_replace(".", "", $request->kredit);
            $post->keterangan = $request->keterangan;
            if ($request->status != "#") {
                $post->status = $request->status;
            } else {
                $post->status = "OPEN";
            }
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
        $get = Pengeluaran::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function destroy($id)
    {
        $post = Pengeluaran::find($id);
        $post->delete();

        return response()->json($post);
    }

    public function bensinTolReport(Request $request)
    {
        // Mendapatkan semua entri petty cash
        $data = Pengeluaran::with('jenisPengeluaran', 'cars', 'drivers', 'customers')->where('typeInput', 'BensinTol');
        if ($request->month_search != "#") {
            $data->where('month', $request->month_search);
        }
        if ($request->year_search != "#") {
            $data->whereYear('date', $request->year_search);
        }
        $pettyCashEntries = $data->get();

        // Menginisialisasi saldo awal
        $saldoAwal = 0;

        // Membuat array untuk menyimpan saldo pada setiap record
        $saldoPerRecord = [];

        // Menghitung saldo pada setiap record
        foreach ($pettyCashEntries as $entry) {
            // Menghitung saldo pada setiap record berdasarkan debit dan kredit
            if ($entry->debit) {
                $saldoAwal += $entry->debit;
            } elseif ($entry->kredit) {
                $saldoAwal -= $entry->kredit;
            }

            // Menyimpan saldo pada setiap record ke dalam array
            $saldoPerRecord[$entry->id] = $saldoAwal;
        }

        return view('/kas/report/bensinTol_report', compact('pettyCashEntries', 'saldoPerRecord'));
        //return $pettyCashEntries;
        //return view('petty_cash_report', compact('saldoPerTanggal'));
    }
}
