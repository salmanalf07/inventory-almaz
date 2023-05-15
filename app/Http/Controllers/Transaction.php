<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaction;
use App\Models\PackingTransaction;
use App\Models\Stock;
use App\Models\Transaction as ModelsTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Transaction extends Controller
{
    public function json(Request $request)
    {
        $dataa = DetailTransaction::with('Transaction', 'Part.customer')
            ->whereHas('Transaction', function ($query) use ($request) {
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
                    '
                    <button id="edit" data-id="' . $data->Transaction->id . '" class="btn btn-warning">Update</button>
                    <button id="delete" data-id="' . $data->Transaction->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi', 'no_partin'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'date_transaction' => ['required', 'string', 'max:255'],
                'shift' => ['required', 'string', 'max:255'],
                'no_rak' => ['required', 'string', 'max:255'],
                'time_start' => ['required', 'string', 'max:255'],
                'operator' => ['required', 'string', 'max:255'],
            ]);


            $record = ModelsTransaction::latest()->first();
            if ($record === null) {
                $no_transaction = 1;
            } else {
                if (date("Y-m-d", strtotime($record->date_transaction)) != date("Y-m-d", strtotime(str_replace('/', '-', $request->date_transaction)))) {
                    $no_transaction = 1;
                } else {
                    $no_transaction = $record->no_transaction + 1;
                }
            }

            $get_user = User::where("name", $request->user_id)->first();

            $post = new ModelsTransaction();
            $post->user_id = $get_user->id;
            $post->no_transaction = $no_transaction;

            $post->date_transaction = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_transaction)));
            $post->no_rak = $request->no_rak;
            $post->shift = $request->shift;
            $post->time_start = date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_start)));
            $post->operator = $request->operator;
            $post->grand_total = str_replace(",", "", $request->grand_total);
            $post->total_sa = $request->total_sa;
            $post->save();


            $part_id = collect($request->part_id)->filter()->all();
            $cust_id = collect($request->cust_id)->filter()->all();
            $type = collect($request->type)->filter()->all();
            $qty_in = collect($request->qty_in)->filter()->all();
            $sa = array_filter($request->sa, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($part_id); $count++) {
                $angka = str_replace(",", "", $price[$count]);

                if ($angka % 1 == 0) {
                    $angka = rtrim($angka, '0');
                    $angka = rtrim($angka, '.');
                }
                $postt = new DetailTransaction();
                $postt->transaction_id = $post->id;
                $postt->cust_id = $cust_id[$count];
                $postt->part_id = $part_id[$count];
                $postt->type = $type[$count];
                $postt->qty_in  = str_replace(",", "", $qty_in[$count]);
                $postt->sa  = str_replace(",", "", $sa[$count]);
                $postt->price  = $angka;
                $postt->save();

                // $posttt = new PackingTransaction();
                // $posttt->detransaction_id = $postt->id;
                // $posttt->save();
            }

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsTransaction::with('user', 'detail_transaction.Part')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'date_transaction' => ['required', 'string', 'max:255'],
                'no_rak' => ['required', 'string', 'max:255'],
                'time_start' => ['required', 'string', 'max:255'],
                'operator' => ['required', 'string', 'max:255'],

            ]);
            $get_user = User::where("name", $request->user_id)->first();

            $post = ModelsTransaction::find($id);
            $post->user_id = $get_user->id;
            $post->no_transaction = $request->no_transaction;
            $post->date_transaction = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_transaction)));
            $post->no_rak = $request->no_rak;
            $post->shift = $request->shift;
            if ($post->time_start != date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_start)))) {
                $post->time_start = date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_start)));
            }
            $post->operator = $request->operator;
            $post->grand_total = str_replace(",", "", $request->grand_total);
            $post->total_sa = $request->total_sa;
            $post->save();

            $detail_id = collect($request->detail_id)->filter()->all();
            $part_id = collect($request->part_id)->filter()->all();
            $cust_id = collect($request->cust_id)->filter()->all();
            $qty_in = collect($request->qty_in)->filter()->all();
            $sa = array_filter($request->sa, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($detail_id); $count++) {
                $recent = DetailTransaction::where(['id' => $detail_id[$count]]);
                $recentt = $recent->first();
                $qty_up = str_replace(",", "", $qty_in[$count]);
                $price_up = str_replace(",", "", $price[$count]);
                if ($recentt->qty_in != str_replace(",", "", $qty_in[$count])) {
                    $qty_up = str_replace(",", "", $qty_in[$count]) - $recentt->qty_in;
                    $price_up = str_replace(",", "", $price[$count]) - $recentt->total_price;
                }
                $angka = str_replace(",", "", $price_up[$count]);

                if ($angka % 1 == 0) {
                    $angka = rtrim($angka, '0');
                    $angka = rtrim($angka, '.');
                }
                $recent->update([
                    'cust_id' => $cust_id[$count],
                    'part_id' => $part_id[$count],
                    'qty_in'  => str_replace(",", "", $qty_up),
                    'sa'  => str_replace(",", "", $sa[$count]),
                    'price'  => $angka,
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now'))
                ]);
            }

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = ModelsTransaction::find($id);
        $post->delete();

        $get = DetailTransaction::where(['transaction_id' => $id])->get();

        foreach ($get as $data) {
            $del_detail = DetailTransaction::find($data->id);
            $del_detail->delete();

            $del_packing = PackingTransaction::where('detransaction_id', $data->id);
            $del_packing->delete();
        }

        return response()->json($post);
    }

    public function rekap_production(Request $request)
    {
        $dataa = DetailTransaction::with('customer', 'Transaction', 'Part');
        if ($request->cust_id != "#") {
            $dataa->whereHas('Transaction', function ($query) use ($request) {
                $query->where('cust_id', $request->cust_id);
            });
        }
        if ($request->dateinn && $request->dateenn) {
            $dataa->whereHas('Transaction', function ($query) use ($request) {
                $query->whereDate('date_transaction', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->dateinn))))
                    ->whereDate('date_transaction', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->dateenn))));
            });
        }
        if ($request->status != "#") {
            $dataa->whereHas('Transaction', function ($query) use ($request) {
                $query->where('status', $request->status);
            });
        }

        $data = $dataa->get();

        return DataTables::of($data)
            ->toJson();
    }

    public function grafik_packing(Request $request)
    {
        $dataa = DB::table('packing_transactions')
            ->join(
                'ng_transactions',
                'ng_transactions.packing_id',
                '=',
                'packing_transactions.id'
            )
            ->selectRaw('packing_transactions.date_packing, sum(packing_transactions.total_fg) as total_fg,sum(packing_transactions.total_ng) as total_ng,
            sum(ng_transactions.over_paint) as over_paint,
            sum(ng_transactions.bintik_or_pin_hole) as bintik_or_pin_hole,
            sum(ng_transactions.minyak_or_map) as minyak_or_map,
            sum(ng_transactions.cotton) as cotton,
            sum(ng_transactions.no_paint_or_tipis) as no_paint_or_tipis,
            sum(ng_transactions.scratch) as scratch,
            sum(ng_transactions.air_pocket) as air_pocket,
            sum(ng_transactions.kulit_jeruk) as kulit_jeruk,
            sum(ng_transactions.kasar) as kasar,
            sum(ng_transactions.karat) as karat,
            sum(ng_transactions.water_over) as water_over,
            sum(ng_transactions.minyak_kering) as minyak_kering,
            sum(ng_transactions.dented) as dented,
            sum(ng_transactions.keropos) as keropos,
            sum(ng_transactions.nempel_jig) as nempel_jig,
            sum(ng_transactions.lainnya) as lainnya
            ');
        $dataa->where('packing_transactions.deleted_at', '=', null);

        if ($request->date != null) {
            $date = explode(" - ", $request->date);
            $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
            $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));

            $dataa->whereDate('packing_transactions.date_packing', '>=', $datein)
                ->whereDate('packing_transactions.date_packing', '<=', $dateen);
        };
        if ($request->cust_id != "#") {
            $dataa->where('packing_transactions.cust_id', $request->cust_id);
        };
        if ($request->part_id != "#") {
            $dataa->where('packing_transactions.part_id', $request->part_id);
        };
        if ($request->shift != "#") {
            $dataa->where('packing_transactions.shift', $request->shift);
        } else {
            $dataa->where('packing_transactions.shift', 1);
        };

        $dataa->groupBy('packing_transactions.date_packing');

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
        $allDates = array_column($dataArray, "date_packing");

        // Buat objek kosong untuk menyimpan data
        $dataObj = collect();

        // Loop untuk setiap tanggal yang ingin ditambahkan
        foreach ($datesToAdd as $date) {
            // Cek apakah tanggal sudah ada pada array $allDates
            if (!in_array($date, $allDates)) {
                // Jika belum, tambahkan data baru ke dalam objek $dataObj
                $dataObj->push([
                    "date_packing" => $date,
                    "total_fg" => 0,
                    "total_ng" => 0,
                    "over_paint" => null,
                    "bintik_or_pin_hole" => null,
                    "minyak_or_map" => null,
                    "cotton" => null,
                    "no_paint_or_tipis" => null,
                    "scratch" => null,
                    "air_pocket" => null,
                    "kulit_jeruk" => null,
                    "kasar" => null,
                    "karat" => null,
                    "water_over" => null,
                    "minyak_kering" => null,
                    "dented" => null,
                    "keropos" => null,
                    "nempel_jig" => null,
                    "lainnya" => null
                ]);
            }
        }

        // Gabungkan objek $dataObj dengan data asli
        $dataObj = $dataObj->merge($data);

        // Gunakan $dataObj sebagai data yang akan digunakan selanjutnya
        $data = json_decode(json_encode($dataObj), true);
        usort($data, function ($a, $b) {
            return strcmp($a['date_packing'], $b['date_packing']);
        });
        //return $data;
        return view('/report/r_summary_ng', ['record' => count($dataa->get()), "data" => $data]);
    }
}
