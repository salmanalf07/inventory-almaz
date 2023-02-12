<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\DetailSJ;
use App\Models\Order;
use App\Models\Parts;
use App\Models\SJ as ModelsSJ;
use App\Models\TrackSj;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SJ extends Controller
{
    public function json(Request $request)
    {
        $dataa = ModelsSJ::with('customer');

        if ($request->datein && $request->dateen) {
            $dataa->whereDate('sjs.date_sj', '>=', $request->datein)
                ->whereDate('sjs.date_sj', '<=', $request->dateen);
        } else {
            $dateS = Carbon::now()->startOfMonth()->subMonth(3);
            $dateE = Carbon::now();
            // $dataa->whereDate('sjs.date_sj', '=', date("Y-m-d"));
            $dataa->whereBetween('sjs.date_sj', [$dateS, $dateE]);
        }

        $data = $dataa->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                    </button>
                    <div class="dropdown-menu">
                    <button id="print" data-id="' . $data->id . '" class="dropdown-item">Print</button>
                    <button id="tracking" data-id="' . $data->id . '" class="dropdown-item">Tracking</button>
                    <button id="edit" data-id="' . $data->id . '" class="dropdown-item">Update</button>
                    <button id="delete" data-id="' . $data->id . '" class="dropdown-item">Delete</button>
                    </div>
                    </div>';
            })
            ->rawColumns(['aksi', 'information'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cust_id' => ['required', 'string', 'max:255'],
                'user_id' => ['required', 'string', 'max:255'],
                'car_id' => ['required', 'string', 'max:255'],
                //'type' => ['required', 'string', 'max:255'],
                'booking_month' => ['required', 'string', 'max:255'],
                'booking_year' => ['required', 'string', 'max:255'],
                'grand_total' => ['required', 'string', 'max:255'],

            ]);

            $record = ModelsSJ::latest()->first();
            if ($record === null) {
                $nosj = 1;
            } else {
                $nosj = $record->nosj + 1;
            }


            $get_user = User::where("name", $request->user_id)->first();

            $post = new ModelsSJ();
            $post->nosj = $nosj;
            $post->cust_id = $request->cust_id;
            if ($request->invoice_id != "-") {
                $post->invoice_id = $request->invoice_id;
            }
            if ($request->order_id != "-") {
                $post->order_id = $request->order_id;
            }
            $post->driver_id = $request->driver_id;
            $post->car_id = $request->car_id;
            $post->user_id = $get_user->id;
            $post->booking_month = $request->booking_month;
            $post->booking_year = $request->booking_year;
            $post->grand_total = str_replace(",", "", $request->grand_total);
            $post->date_sj = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_sj)));
            if ($request->kembali_sj != "") {
                $post->kembali_sj = date("Y-m-d", strtotime(str_replace('/', '-', $request->kembali_sj)));
            }
            if ($request->kembali_rev != "") {
                $post->kembali_rev = date("Y-m-d", strtotime(str_replace('/', '-', $request->kembali_rev)));
            }
            $post->revisi = $request->revisi;
            $post->status = $request->status;
            $post->save();

            $part_id = collect($request->part_id)->filter()->all();
            $type = collect($request->type)->filter()->all();
            $qty = collect($request->qty)->filter()->all();
            $qty_pack = collect($request->qty_pack)->filter()->all();
            $type_pack = collect($request->type_pack)->filter()->all();
            $total_price = array_filter($request->total_price, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });
            $keterangan = array_filter($request->keterangan, function ($value) {
                return ($value !== null && $value !== false && $value !== '');
            });

            for ($count = 0; $count < count($part_id); $count++) {
                if ($keterangan[$count] === "-") {
                    $keterangann = null;
                } else {
                    $keterangann = $keterangan[$count];
                }
                $data = array(
                    'sj_id' => $post->id,
                    'part_id' => $part_id[$count],
                    'type' => $type[$count],
                    'qty'  => str_replace(",", "", $qty[$count]),
                    'qty_pack'  => $qty_pack[$count],
                    'type_pack'  => $type_pack[$count],
                    'total_price'  => str_replace(",", "", $total_price[$count]),
                    'keterangan'  => $keterangann,
                    'created_at' => date("Y-m-d H:i:s", strtotime('now'))
                );

                $insert[] = $data;
            }

            DetailSJ::insert($insert);
            $track = new TrackSj();
            $track->sj_id = $post->id;
            $track->user_id = $get_user->id;
            $track->tracking = "Created";
            $track->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsSJ::with('DetailSJ', 'user')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {


            $post = ModelsSJ::find($id);
            $post->date_sj = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_sj)));
            $post->grand_total = str_replace(",", "", $request->grand_total);
            //$post->cust_id = $request->cust_id;
            if ($request->order_id && $request->order_id != "-") {
                $post->order_id = $request->order_id;

                $track = new TrackSj();
                $track->sj_id = $id;
                $track->user_id = Auth::user()->id;
                $track->tracking = "Update No Po";
                $track->save();
            }
            if ($post->kembali_sj != "") {
                $post->kembali_sj = date("Y-m-d", strtotime(str_replace('/', '-', $request->kembali_sj)));
                $track = new TrackSj();
                $track->sj_id = $id;
                $track->user_id = Auth::user()->id;
                $track->tracking = "Return SJ";
                $track->save();
            }
            if ($request->kembali_rev != "") {
                $post->kembali_rev = date("Y-m-d", strtotime(str_replace('/', '-', $request->kembali_rev)));
                $track = new TrackSj();
                $track->sj_id = $id;
                $track->user_id = Auth::user()->id;
                $track->tracking = "Return Rev";
                $track->save();
            }
            $post->revisi = $request->revisi;
            if ($request->status == "INVOICE") {
                $post->status = $request->status;
                $track = new TrackSj();
                $track->sj_id = $id;
                $track->user_id = Auth::user()->id;
                $track->tracking = "Invoice";
                $track->save();
            }
            if ($request->status == "CLOSE") {
                $post->status = $request->status;
                $track = new TrackSj();
                $track->sj_id = $id;
                $track->user_id = Auth::user()->id;
                $track->tracking = "Closed";
                $track->save();
            }
            $post->save();

            if (count(collect($request->part_id)->filter()->all()) != 0) {
                $detail_id = collect($request->detail_id)->filter()->all();
                $part_id = collect($request->part_id)->filter()->all();
                //x$qty = collect($request->qty)->filter()->all();
                $qty = array_filter($request->qty, function ($value) {
                    return ($value !== null && $value !== false && $value !== '');
                });
                $qty_pack = collect($request->qty_pack)->filter()->all();
                $type_pack = collect($request->type_pack)->filter()->all();
                $total_price = array_filter($request->total_price, function ($value) {
                    return ($value !== null && $value !== false && $value !== '');
                });
                $keterangan = array_filter($request->keterangan, function ($value) {
                    return ($value !== null && $value !== false && $value !== '');
                });

                for ($count = 0; $count < count($detail_id); $count++) {
                    if ($keterangan[$count] === "-") {
                        $keterangann = null;
                    } else {
                        $keterangann = $keterangan[$count];
                    }
                    DetailSJ::where(['id' => $detail_id[$count]])
                        ->update([
                            'part_id' => $part_id[$count],
                            'qty'  => str_replace(",", "", $qty[$count]),
                            'qty_pack'  => str_replace(",", "", $qty_pack[$count]),
                            'type_pack'  => str_replace(",", "", $type_pack[$count]),
                            'total_price'  => str_replace(",", "", $total_price[$count]),
                            'keterangan'  => $keterangann,
                        ]);
                }

                $track = new TrackSj();
                $track->sj_id = $id;
                $track->user_id = Auth::user()->id;
                $track->tracking = "Update";
                $track->save();
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
        $post = ModelsSJ::find($id);
        $post->delete();

        $get = DetailSJ::where(['sj_id' => $id])->get();


        foreach ($get as $data) {

            $del_detail = DetailSJ::find($data->id);
            $del_detail->delete();
        }

        return response()->json($post);
    }

    public function destroy_part($id)
    {
        $post = DetailSJ::with('Part')->find($id);

        $track = new TrackSj();
        $track->sj_id = $post->sj_id;
        $track->user_id = Auth::user()->id;
        $track->tracking = "Deleted Part " . $post->part->name_local . ", Qty: " . $post->qty;
        $track->save();

        $post->delete();

        return response()->json($post);
    }

    public function print(Request $request)
    {
        $data = ModelsSJ::with('customer', 'car', 'driver', 'order', 'DetailSJ.Part')->find($request->id_print);

        $trackk = new TrackSj();
        $trackk->sj_id = $data->id;
        $trackk->user_id = Auth::user()->id;
        $trackk->tracking = "Add Date SJ -" . $request->datee;
        $trackk->save();

        $track = new TrackSj();
        $track->sj_id = $data->id;
        $track->user_id = Auth::user()->id;
        $track->tracking = "Printed";
        $track->save();

        $pdf = PDF::loadView('/PrintOut/surat_sj', ['data' => $data, 'datee' => $request->datee])
            ->setPaper('A4', "portrait");
        return $pdf->stream();

        // $output = $pdf->output();
        // return new Response($output, 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' =>  'inline; filename="invoice.pdf"',
        // ]);
        //return view('/PrintOut/surat_sj', ['data' => $data, 'datee' => $request->datee]);
    }

    public function report_partoutt(Request $request)
    {
        $dataa = DetailSJ::with('DetailSJ', 'part.customer');
        if ($request->cust_id != "#" && $request->type != "#") {
            $dataa->whereRelation('part', 'cust_id', '=', $request->cust_id);
            $dataa->where('type', '=', $request->type);
            $dataa->whereHas('DetailSJ', function ($query) use ($request) {
                $query->whereDate('date_sj', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_sj', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->part_id != "#" && $request->type != "#") {
            $dataa->where([
                ['part_id', '=', $request->part_id],
                ['type', '=', $request->type],
            ]);
            $dataa->whereHas('DetailSJ', function ($query) use ($request) {
                $query->whereDate('date_sj', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_sj', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->type != "#") {
            $dataa->where([
                ['type', '=', $request->type],
            ]);
            $dataa->whereHas('DetailSJ', function ($query) use ($request) {
                $query->whereDate('date_sj', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_sj', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->part_id != "#") {
            $dataa->where([
                ['part_id', '=', $request->part_id],
            ]);
            $dataa->whereHas('DetailSJ', function ($query) use ($request) {
                $query->whereDate('date_sj', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_sj', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } elseif ($request->cust_id != "#") {
            $dataa->whereRelation('part', 'cust_id', '=', $request->cust_id);
            $dataa->whereHas('DetailSJ', function ($query) use ($request) {
                $query->whereDate('date_sj', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_sj', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        } else {
            $dataa->whereHas('DetailSJ', function ($query) use ($request) {
                $query->whereDate('date_sj', '>=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_st))))
                    ->whereDate('date_sj', '<=', date('Y-m-d', strtotime(str_replace('/', '-', $request->date_ot))));
            });
        }


        $data = $dataa->get();


        return DataTables::of($data)
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function report_partout(Request $request)
    {
        $date = explode(" - ", $request->date);
        $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
        $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));

        $dauu = ModelsSJ::with('customer')->select(
            "cust_id",
            DB::raw("(sum(grand_total)) as total"),
            DB::raw("(DATE_FORMAT(date_sj, '%d-%m-%Y')) as my_date")
        );
        if ($request->date != null) {
            $dauu->whereDate('date_sj', '>=', $datein)
                ->whereDate('date_sj', '<=', $dateen);
        }
        if ($request->cust_id != "#") {
            $dauu->where('cust_id', $request->cust_id);
        }
        if ($request->user_id != "#") {
            $dauu->where('user_id', $request->user_id);
        }

        $dauu->groupBy("cust_id")
            ->groupBy(DB::raw("DATE_FORMAT(date_sj, '%d-%m-%Y')"));
        $dau = $dauu->get();

        $ur = array();
        $urr = array();
        foreach ($dau as $att) {
            $ur[] = $att->my_date;
            $urr[] = $att->customer['code'];
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
                        if ($uniqe . $attt == $dauu->my_date . $dauu->customer['code']) {
                            $datdetaill[$key]["uniqe"][$ke]["real"][0]["total"] = $dauu->total;
                        }
                    }
                }
            }
        }


        return view('/report/r_partout_by_cust', ['judul' => "User", "datdetail" => $datdetaill, "date" => $request->date]);
        //return ['dat' => $dat, 'data' => $data, 'datdetail' => $datdetail];
        //return $datdetaill;
        //return view('/report/r_partout_tab', ['judul' => "User", "datdetail" => $dau, "date" => $request->date]);
        //return $dau;
    }

    public function report_sumpart(Request $request)
    {
        $date = explode(" - ", $request->date);
        $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
        $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));

        $data = DB::table('detail_sjs')
            ->join(
                'sjs',
                'sjs.id',
                '=',
                'detail_sjs.sj_id'
            )
            ->join(
                'parts',
                'parts.id',
                '=',
                'detail_sjs.part_id'
            )
            ->join(
                'customers',
                'customers.id',
                '=',
                'sjs.cust_id'
            )
            ->selectRaw('detail_sjs.part_id,parts.name_local,customers.code,sjs.date_sj, sum(detail_sjs.total_price) as total')
            ->where('detail_sjs.deleted_at', '=', null);
        if ($request->cust_id != "#") {
            $data->where('sjs.cust_id', $request->cust_id);
        };
        if ($request->date != null) {
            $data->whereDate('sjs.date_sj', '>=', $datein)
                ->whereDate('sjs.date_sj', '<=', $dateen);
        };
        if ($request->user_id != "#") {
            $data->where('sjs.user_id', $request->user_id);
        }
        $data->groupBy('detail_sjs.part_id')
            ->groupBy('parts.name_local')
            ->groupBy('customers.code')
            ->groupBy('sjs.date_sj');
        $dataa = $data->get();

        $ar = array();
        $arr = array();
        $arrr = array();
        foreach ($dataa as $att) {
            $ar[] = $att->name_local;
            $arr[] = $att->date_sj;
            $arrr[] = $att->code;
            $unique_data = array_unique($ar);
            $unique_dataa = array_unique($arr);
            $unique_dataaa = array_unique($arrr);
        }


        $datdetail = array();
        if (count($dataa) > 0) {
            foreach ($unique_data as $ke => $uniqe) {
                foreach ($unique_dataa as $key => $datu) {
                    foreach ($dataa as $kee => $datan) {
                        $datdetail[$ke]["name_local"] = $uniqe;
                        $datdetail[$ke]["uniqe"][$key]["date"] = $datu;
                        if ($datu . $uniqe == $datan->date_sj . $datan->name_local) {
                            $datdetail[$ke]["code"] = $datan->code;
                            $datdetail[$ke]["uniqe"][$key]["real"][0]["total"] = $datan->total;
                        }
                    }
                }
            }
        }


        return view('/report/r_partout_by_part', ['judul' => "User", "datdetail" => $datdetail, "date" => $request->date]);
        //return ['dat' => $dat, 'data' => $data, 'datdetail' => $datdetail];
        //return $datdetail;
        //return $dataa;
    }
    public function report_sumpo(Request $request)
    {

        $data = DB::table('detail_sjs')
            ->join(
                'sjs',
                'sjs.id',
                '=',
                'detail_sjs.sj_id'
            )
            ->leftJoin(
                'orders',
                'orders.id',
                '=',
                'sjs.order_id'
            )
            ->join(
                'customers',
                'customers.id',
                '=',
                'sjs.cust_id'
            )
            ->selectRaw('customers.code,sjs.order_id,sjs.date_sj,orders.no_po, sum(detail_sjs.total_price) as total')
            ->where('detail_sjs.deleted_at', '=', null);
        if ($request->cust_id != "#") {
            $data->where('sjs.cust_id', $request->cust_id);
        };
        if ($request->date != null) {
            $date = explode(" - ", $request->date);
            $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
            $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));

            $data->whereDate('sjs.date_sj', '>=', $datein)
                ->whereDate('sjs.date_sj', '<=', $dateen);
        };
        if ($request->order_id == "blank") {
            $data->where('sjs.order_id', '=', null);
        };
        if ($request->order_id != "#" && $request->order_id != "blank") {
            $data->where('sjs.order_id', $request->order_id);
        }
        $data->groupBy('sjs.order_id')
            ->groupBy('customers.code')
            ->groupBy('orders.no_po')
            ->groupBy('sjs.date_sj');
        $dataa = $data->get();

        $ar = array();
        $arr = array();
        $arrr = array();
        foreach ($dataa as $att) {
            $ar[] = $att->code . " - " . $att->order_id;
            $arr[] = $att->date_sj;
            $arrr[] = $att->order_id;
            $unique_data = array_unique($ar);
            $unique_dataa = array_unique($arr);
            $unique_dataaa = array_unique($arrr);
        }


        $datdetail = array();
        if (count($dataa) > 0) {
            foreach ($unique_data as $ke => $uniqe) {
                foreach ($unique_dataa as $key => $datu) {
                    foreach ($dataa as $kee => $datan) {
                        $datdetail[$ke]["uniqe"][$key]["date"] = $datu;
                        if ($datu . $uniqe == $datan->date_sj . $datan->code . " - " . $datan->order_id) {
                            $datdetail[$ke]["code"] = $datan->code;
                            $datdetail[$ke]["no_po"] = $datan->no_po;
                            //     $datdetail[$ke]["code"] = $datan->order_id;
                            $datdetail[$ke]["uniqe"][$key]["real"][0]["total"] = $datan->total;
                        }
                    }
                }
            }
        }


        return view('/report/r_partout_by_po', ['judul' => "User", "datdetail" => $datdetail, "date" => $request->date]);
        //return ['dat' => $dat, 'data' => $data, 'datdetail' => $datdetail];
        //return $datdetail;
        //return $dataa;
    }

    public function update_price_sj()
    {
        $dateStart = date("Y-m-d", strtotime(str_replace('/', '-', "01/06/2022")));
        $dateEnd = date("Y-m-d", strtotime(str_replace('/', '-', "04/06/2022")));

        $sj = ModelsSJ::select('id', 'nosj')
            ->whereDate('date_sj', '>=', $dateStart)
            ->whereDate('date_sj', '<=', $dateEnd)
            ->get();

        foreach ($sj as $sjj) {
            $detail_sj = DetailSJ::select('id', 'sj_id', 'part_id', 'qty')->with('DetailSJ')
                ->where('sj_id', '=', $sjj->id)
                ->whereHas('DetailSJ', function ($query) use ($dateStart, $dateEnd) {
                    $query->whereDate('date_sj', '>=', $dateStart)
                        ->whereDate('date_sj', '<=', $dateEnd);
                })
                ->get();
            for ($countt = 0; $countt < count($detail_sj); $countt++) {
                $part = Parts::find($detail_sj[$countt]->part_id);
                $post = DetailSJ::where('id', '=', $detail_sj[$countt]->id);
                $post->update([
                    'total_price' => $part->price * $detail_sj[$countt]->qty,
                ]);
            };

            $detailsj = DetailSJ::where('sj_id', $sjj->id)->sum('total_price');

            $update = ModelsSJ::find($sjj->id);
            $update->grand_total = (int)$detailsj;
            $update->save();
        }

        // $sjj = ModelsSJ::select('id', 'nosj', 'grand_total')
        //     ->whereIn('id', $sj->toArray())
        //     ->get();

        return $sj;
    }
}
