<?php

namespace App\Http\Controllers;

use App\Models\DetailPartIn;
use App\Models\DetailSJ;
use App\Models\PartIn as ModelsPartIn;
use App\Models\Parts;
use App\Models\StockWip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class PartIn extends Controller
{
    public function json(Request $request)
    {
        $dataa = ModelsPartIn::with('DetailPartIn', 'customer');
        // if ($request->datein && $request->dateen) {
        //     $dataa->whereDate('date_in', '>=', $request->datein)
        //         ->whereDate('date_in', '<=', $request->dateen);
        // } else {
        //     $dataa->whereDate('date_in', '=', date("Y-m-d"));
        // };
        $data = $dataa->orderBy('created_at', 'DESC');


        return DataTables::of($data)
            ->addColumn('count', function ($data) {
                $partin = ModelsPartIn::select('id')->where([
                    ['id', '=', $data->id],
                ])->get();

                $count = DetailPartIn::select('total_price')->whereIn("partin_id", $partin->toArray())->sum('total_price');
                return $count;
            })
            ->addColumn('aksi', function ($data) {
                return
                    '
                    <button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
                    <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi', 'count', 'no_partin'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'order_id' => ['required', 'string', 'max:255'],
                'cust_id' => ['required', 'string', 'max:255'],
                'user_id' => ['required', 'string', 'max:255'],
                'date_in' => ['required', 'string', 'max:255'],
                'check_result' => ['required', 'string', 'max:255'],

            ]);


            $record = ModelsPartIn::latest()->first();
            if ($record === null) {
                $no_part_in = 1;
            } else {
                if (date("Y-m-d", strtotime($record->created_at)) != date("Y-m-d")) {
                    $no_part_in = 1;
                } else {
                    $no_part_in = $record->no_part_in + 1;
                }
            }

            $get_user = User::where("name", $request->user_id)->first();

            $post = new ModelsPartIn();
            if ($request->order_id != "-") {
                $post->order_id = $request->order_id;
            }
            $post->cust_id = $request->cust_id;
            $post->user_id = $get_user->id;
            $post->no_part_in = $no_part_in;
            $post->date_in = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_in)));
            $post->no_sj_cust = $request->no_sj_cust;
            $post->check_result = $request->check_result;
            $post->plan_delivery = $request->plan_delivery;
            $post->notes = $request->notes;
            $post->save();


            $part_id = collect($request->part_id)->filter()->all();
            $type = collect($request->type)->filter()->all();
            $qty = collect($request->qty)->filter()->all();
            $total_price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($part_id); $count++) {
                if ($type[$count] === "Choose...") {
                    $typee = "WIP";
                } else {
                    $typee = $type[$count];
                }
                $angka = str_replace(",", "", $total_price[$count]);

                if ($angka % 1 == 0) {
                    $angka = rtrim($angka, '0');
                    $angka = rtrim($angka, '.');
                }
                $data = array(
                    'partin_id' => $post->id,
                    'part_id' => $part_id[$count],
                    'qty'  => str_replace(",", "", $qty[$count]),
                    'type'  => $typee,
                    'total_price'  => $angka,
                    'created_at' => date("Y-m-d H:i:s", strtotime('now'))
                );
                $insert[] = $data;
                // }
                // DetailPartIn::insert($insert);

                // for ($countt = 0; $countt < count($part_id); $countt++) {
                if ($stock = StockWip::where([['part_id', '=', $part_id[$count]], ['type', '=', $typee]])->first()) {
                    $stock = StockWip::where([['part_id', '=', $part_id[$count]], ['type', '=', $typee]])->first();
                    StockWip::where([['part_id', '=', $part_id[$count]], ['type', '=', $typee]])
                        ->update([
                            'partin_id' => $post->id,
                            'part_id' => $part_id[$count],
                            'qty'  => $stock['qty'] + str_replace(",", "", $qty[$count]),
                            'type'  => $typee,
                            'total_price'  => $stock['total_price'] + str_replace(",", "", $total_price[$count]),
                        ]);
                } else {
                    $datawip = array(
                        'partin_id' => $post->id,
                        'part_id' => $part_id[$count],
                        'qty'  => str_replace(",", "", $qty[$count]),
                        'type'  => $typee,
                        'total_price'  => str_replace(",", "", $total_price[$count]),
                        'created_at' => date("Y-m-d H:i:s", strtotime('now'))
                    );
                    StockWip::insert($datawip);
                };
            }
            DetailPartIn::insert($insert);

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsPartIn::with('user', 'DetailPartIn.Parts')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'order_id' => ['required', 'string', 'max:255'],
                'cust_id' => ['required', 'string', 'max:255'],
                'user_id' => ['required', 'string', 'max:255'],
                'date_in' => ['required', 'string', 'max:255'],
                'check_result' => ['required', 'string', 'max:255'],

            ]);
            $get_user = User::where("name", $request->user_id)->first();

            $post = ModelsPartIn::find($id);
            if ($request->order_id != "-") {
                $post->order_id = $request->order_id;
            }
            $post->cust_id = $request->cust_id;
            $post->user_id = $get_user->id;
            $post->date_in = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_in)));
            $post->no_sj_cust = $request->no_sj_cust;
            $post->check_result = $request->check_result;
            $post->plan_delivery = $request->plan_delivery;
            $post->notes = $request->notes;
            $post->save();

            $detail_id = collect($request->detail_id)->filter()->all();
            $part_id = collect($request->part_id)->filter()->all();
            $type = collect($request->type)->filter()->all();
            $qty = collect($request->qty)->filter()->all();
            $total_price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            for ($count = 0; $count < count($detail_id); $count++) {
                $recent = DetailPartIn::where(['id' => $detail_id[$count]]);
                $recentt = $recent->first();
                $qty_up = str_replace(",", "", $qty[$count]) - $recentt->qty;
                $price_up = str_replace(",", "", $total_price[$count]) - $recentt->total_price;
                $angka = str_replace(",", "", $total_price[$count]);

                if ($angka % 1 == 0) {
                    $angka = rtrim($angka, '0');
                    $angka = rtrim($angka, '.');
                }
                $recent->update([
                    'qty'  => str_replace(",", "", $qty[$count]),
                    'total_price'  => $angka,
                ]);

                $stock = StockWip::where(['part_id' => $part_id[$count], 'type' => $type[$count]]);
                $stockk = $stock->first();
                $stock->update([
                    'qty'  => $stockk->qty + $qty_up,
                    'total_price'  => $stockk->total_price + $price_up,
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
        $post = ModelsPartIn::find($id);
        $post->delete();

        $get = DetailPartIn::where(['partin_id' => $id])->get();


        foreach ($get as $data) {
            $stock = StockWip::where(['part_id' => $data->part_id, 'type' => $data->type]);
            $stockk = $stock->first();
            $stock->update([
                'qty'  => $stockk->qty - $data->qty,
                'total_price'  => $stockk->total_price - $data->total_price,
            ]);

            $del_detail = DetailPartIn::find($data->id);
            $del_detail->delete();
        }

        return response()->json($post);
    }

    public function print_partin($id)
    {
        $data = ModelsPartIn::with('customer', 'order', 'DetailPartIn.Parts')->find($id);

        return view('/PrintOut/surat_partin', ['data' => $data]);
    }
    public function report_partin(Request $request)
    {
        $dataa = DetailPartIn::with('PartIn', 'Parts.customer');
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

        if ($request->segment(1) == "report_partin") {
            return DataTables::of($data)
                ->toJson();
        }
        if ($request->segment(1) == "ExportPlanning") {
            return view('/report/r_planningPartIn', ['judul' => "Export Planning", 'data' => $data]);
        }
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function report_invsout(Request $request)
    {
        $date_st = "04/01/2023";
        $date_out = "10/01/2023";
        //partin
        $dataa = DetailPartIn::with('PartIn.customer', 'Parts');
        //partout
        $dataua = DetailSJ::with('DetailSJ.customer', 'part');

        $dataa->whereHas('PartIn', function ($query) use ($request) {
            $query->whereDate('date_in', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('date_in', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        });
        $dataua->whereHas('DetailSJ', function ($query) use ($request) {
            $query->whereDate('date_sj', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                ->whereDate('date_sj', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
        });

        if ($request->cust_id != "#") {
            $dataa->whereRelation('PartIn', 'cust_id', '=', $request->cust_id);
            $dataua->whereRelation('DetailSJ', 'cust_id', '=', $request->cust_id);
        }
        if ($request->part_id != "#") {
            $dataa->where([
                ['part_id', '=', $request->part_id],
                // ['type', '=', $request->type],
            ]);
            $dataua->where([
                ['part_id', '=', $request->part_id],
                // ['type', '=', $request->type],
            ]);
        }

        $data = $dataa->get();
        $dataa = $dataua->get();

        $datdetail = array();
        $datdetaill = array();

        foreach ($data as $key => $attt) {
            $datdetail[$key]["status"] = "in";
            $datdetail[$key]["date"] = $attt->PartIn['date_in'];
            $datdetail[$key]["nosj"] = $attt->PartIn['no_sj_cust'];
            $datdetail[$key]["customer"] = $attt->PartIn->customer['code'];
            $datdetail[$key]["part_name"] = $attt->parts['part_name'];
            $datdetail[$key]["part_no"] = $attt->parts['part_no'];
            $datdetail[$key]["type_part"] = $attt->type != null ? $attt->type : "";
            $datdetail[$key]["send"]["in"] = $attt->qty;
            $datdetail[$key]["send"]["out"] = 0;
            $datdetail[$key]["keterangan"] = "";
        }
        foreach ($dataa as $ky => $att) {
            $datdetaill[$ky]["status"] = "out";
            $datdetaill[$ky]["date"] = $att->DetailSJ['date_sj'];
            $datdetaill[$ky]["nosj"] = $att->DetailSJ['nosj'];
            $datdetaill[$ky]["customer"] = $att->DetailSJ->customer['code'];
            $datdetaill[$ky]["part_name"] = $att->part['part_name'];
            $datdetaill[$ky]["part_no"] = $att->part['part_no'];
            $datdetaill[$ky]["type_part"] = $att->type != null ? $att->type : "";
            $datdetaill[$ky]["send"]["in"] = 0;
            $datdetaill[$ky]["send"]["out"] = $att->qty;
            $datdetaill[$ky]["keterangan"] = $att->keterangan;
        }
        $result = array_merge($datdetail, $datdetaill);
        usort($result, fn ($a, $b) => $a['date'] <=> $b['date']);
        // return $result;
        return DataTables::of($result)
            ->toJson();
    }

    public function summary_partin(Request $request)
    {
        $date = explode(" - ", $request->date);
        $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
        $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));
        $dauu = DB::table('detail_part_ins')
            ->join(
                'part_ins',
                'part_ins.id',
                '=',
                'detail_part_ins.partin_id'
            )
            ->join(
                'customers',
                'customers.id',
                '=',
                'part_ins.cust_id'
            )->selectRaw('(DATE_FORMAT(part_ins.date_in, "%d-%m-%Y")) as my_date,customers.code, sum(total_price) as total');
        if ($request->date != null) {
            $dauu->whereDate('part_ins.date_in', '>=', $datein)
                ->whereDate('part_ins.date_in', '<=', $dateen);
        }
        if ($request->cust_id != "#") {
            $dauu->where('part_ins.cust_id', $request->cust_id);
        }

        $dauu->groupBy("customers.code")
            ->groupBy('my_date');
        $dauu->where('detail_part_ins.deleted_at', '=', null);
        $dau = $dauu->get();

        $ur = array();
        $urr = array();
        foreach ($dau as $att) {
            $ur[] = $att->my_date;
            $urr[] = $att->code;
            $unique_dataa = array_unique($ur);
            $unique_dataaa = array_unique($urr);
        }

        $datdetaill = array();
        if (count($dau) > 0) {
            foreach ($unique_dataaa as $key => $attt) {
                foreach ($unique_dataa as $ke => $uniqe) {
                    foreach ($dau as $kee => $dauu) {
                        //$datdetail[$key][$attt->part_name][$uniqe->nosj][$datan->DetailSJ['nosj']] = [$datan->qty];
                        $datdetaill[$key]["cust_id"] = $attt;
                        $datdetaill[$key]["uniqe"][$ke]["date"] = $uniqe;
                        if ($uniqe . $attt == $dauu->my_date . $dauu->code) {
                            $datdetaill[$key]["uniqe"][$ke]["real"][0]["total"] = $dauu->total;
                        }
                    }
                }
            }
        }


        return view('/report/r_partin_by_cust', ['judul' => "User", "datdetail" => $datdetaill, "date" => $request->date]);
        //return ['dat' => $dat, 'data' => $data, 'datdetail' => $datdetail];
        //return $datdetaill;
        //return view('/report/r_partout_tab', ['judul' => "User", "datdetail" => $dau, "date" => $request->date]);
        //return $dau;
    }
}
