<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Customer;
use App\Models\DetailInvoice;
use App\Models\DetailSJ;
use App\Models\Invoice as ModelsInvoice;
use App\Models\Order;
use App\Models\Parts;
use App\Models\SJ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Invoice extends Controller
{
    public function json()
    {
        $data = ModelsInvoice::with('customer')->orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                    </button>
                    <div class="dropdown-menu">
                    <button id="print" data-id="' . $data->id . '" class="dropdown-item">Print</button>
                    <button id="updSJ" data-sj="updSJ" data-id="' . $data->id . '" class="dropdown-item">Upd. SJ</button>
                    <button id="edit" data-id="' . $data->id . '" class="dropdown-item">Update</button>
                    <button id="delete" data-id="' . $data->id . '" class="dropdown-item">Delete</button>
                    </div>
                    </div>';
            })
            ->rawColumns(['aksi', 'no_partin'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cust_id' => ['required', 'string', 'max:255'],
                'date_inv' => ['required', 'string', 'max:255'],
                'no_invoice' => ['required', 'string', 'max:255'],
                'no_faktur' => ['required', 'string', 'max:255'],
                'book_month' => ['required', 'string', 'max:255'],
                'book_year' => ['required', 'string', 'max:255'],
                // 'grand_total' => ['required', 'string', 'max:255'],
                // 'ppn' => ['required', 'string', 'max:255'],
                // 'pph' => ['required', 'string', 'max:255'],
                // 'total_harga' => ['required', 'string', 'max:255'],
            ]);
            $pajak = Application::where('status', 'Active')->first();
            $post = new ModelsInvoice();
            $post->cust_id = $request->cust_id;
            $post->order_id = $request->order_id;
            $post->book_year = $request->book_year;
            $post->book_month = $request->book_month;
            $post->date_inv = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_inv)));
            $post->no_invoice = $request->no_invoice;
            $post->no_faktur = $request->no_faktur;
            $post->detail_order = implode(",", $request->part_id);
            $post->tax_id = $pajak->id;
            // $post->harga_jual = str_replace(",", "", $request->grand_total);
            // $post->ppn = str_replace(",", "", $request->ppn);
            // $post->pph = str_replace(",", "", $request->pph);
            //$post->total_harga = str_replace(",", "", $request->total_harga);
            if ($request->tukar_faktur != "") {
                $post->tukar_faktur = date("Y-m-d", strtotime(str_replace('/', '-', $request->tukar_faktur)));
            }
            if ($request->top != "") {
                $post->top = $request->top;
            }
            if ($request->jatuh_tempo != "") {
                $post->jatuh_tempo = date("Y-m-d", strtotime(str_replace('/', '-', $request->jatuh_tempo)));
            }
            if ($request->tanggal_bayar) {
                $post->tanggal_bayar = date("Y-m-d", strtotime(str_replace('/', '-', $request->tanggal_bayar)));
            }
            $post->status = $request->status;
            $post->save();

            // $part_id = collect($request->part_id)->filter()->all();
            // $qty = collect($request->qty)->filter()->all();
            // $total_price = array_filter($request->total_price, function ($value) {
            //     return ($value !== null && $value !== false && $value !== '');
            // });

            // for ($count = 0; $count < count($part_id); $count++) {
            //     $data = array(
            //         'invoice_id' => $post->id,
            //         'part_id' => $part_id[$count],
            //         'qty' => str_replace(",", "", $qty[$count]),
            //         'total_price' => str_replace(",", "", $total_price[$count]),
            //         'created_at' => date("Y-m-d H:i:s", strtotime('now')),
            //     );
            //     $insert[] = $data;
            // }
            // DetailInvoice::insert($insert);

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function edit(Request $request)
    {
        $get = ModelsInvoice::with('customer', 'DetailInvoice.Parts', 'application')->find($request->id);

        //$SJ = SJ::where([['cust_id', '=', $get->cust_id], ['status', "=", "INVOICE"]])->get();
        $SJ = SJ::with('customer')->where([['cust_id', '=', $get->cust_id], ['invoice_id', "=", $request->id]])
            ->orWhere([['invoice_id', "=", null]])->get();
        $noSJ = SJ::select('id')->where('invoice_id', '=', $get->id)->get();
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json([$get, $SJ, $noSJ]);
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->updSJ) {
                $updsj = collect($request->updSJ)->filter()->all();

                $invoice = DetailInvoice::where("invoice_id", "=", $id)->get();
                $SJ = SJ::where("invoice_id", "=", $id)->get();

                if (count($invoice)) {
                    foreach ($invoice as $dataa) {
                        $del_detail = DetailInvoice::find($dataa->id);
                        $del_detail->forceDelete();
                    }
                    foreach ($SJ as $dataa) {
                        $del_sj = SJ::find($dataa->id);
                        $del_sj->invoice_id = null;
                        $del_sj->save();
                    }
                    for ($count = 0; $count < count($updsj); $count++) {
                        SJ::where('id', '=', $updsj[$count])
                            ->update([
                                //'order_id' => $id,
                                'invoice_id' => $id,
                            ]);
                    }
                    //add detail invoice
                    $det_inv = DB::table('detail_sjs')
                        ->join('sjs', 'detail_sjs.sj_id', '=', 'sjs.id')
                        ->where('sjs.invoice_id', '=', $id)
                        ->where('detail_sjs.deleted_at', '=', null);
                    $det_inv->select("part_id", DB::raw("SUM(qty) as qty"), DB::raw("SUM(total_price) as total_price"))
                        ->groupBy(DB::raw("part_id"));
                    $data = $det_inv->get();

                    foreach ($data as $in_detail) {
                        $post = new DetailInvoice();
                        $post->invoice_id = $id;
                        $post->part_id = $in_detail->part_id;
                        $post->qty = str_replace(",", "", $in_detail->qty);
                        $post->total_price = str_replace(",", "", $in_detail->total_price);
                        $post->save();
                    }
                } else {
                    for ($count = 0; $count < count($updsj); $count++) {
                        SJ::where('id', '=', $updsj[$count])
                            ->update([
                                //'order_id' => $id,
                                'invoice_id' => $id,
                            ]);
                    }

                    //add detail invoice
                    $det_inv = DB::table('detail_sjs')
                        ->join('sjs', 'detail_sjs.sj_id', '=', 'sjs.id')
                        ->where('sjs.invoice_id', '=', $id)
                        ->where('detail_sjs.deleted_at', '=', null);
                    $det_inv->select("part_id", DB::raw("SUM(qty) as qty"), DB::raw("SUM(total_price) as total_price"))
                        ->groupBy(DB::raw("part_id"));
                    $data = $det_inv->get();

                    foreach ($data as $in_detail) {
                        $post = new DetailInvoice();
                        $post->invoice_id = $id;
                        $post->part_id = $in_detail->part_id;
                        $post->qty = str_replace(",", "", $in_detail->qty);
                        $post->total_price = str_replace(",", "", $in_detail->total_price);
                        $post->save();
                    }
                }

                $harga_jual = 0;
                foreach ($data as $in_detail) {
                    $harga_jual += str_replace(",", "", $in_detail->total_price);
                }
                $invoiceCust = ModelsInvoice::find($id);
                $pajak = Application::find($invoiceCust->tax_id);
                $customer = Customer::find($invoiceCust->cust_id);
                if ($customer->ppn == "Y") {
                    $ppn = round($harga_jual * ($pajak->ppn / 100));
                } else {
                    $ppn = 0;
                }
                if ($customer->pph == "Y") {
                    $pph = round($harga_jual * ($pajak->pph / 100));
                } else {
                    $pph = 0;
                }

                $update = ModelsInvoice::find($id);
                $update->harga_jual = $harga_jual;
                $update->ppn = $ppn;
                $update->pph = $pph;
                $update->total_harga = $harga_jual + $ppn - $pph;
                $update->save();

                return response()->json($update);
            } else {
                $post = ModelsInvoice::find($id);
                if ($request->order_id != 0) {
                    $post->order_id = $request->order_id;
                }
                if ($request->tukar_faktur != "") {
                    $post->tukar_faktur = date("Y-m-d", strtotime(str_replace('/', '-', $request->tukar_faktur)));
                }
                if ($request->top != "") {
                    $post->top = $request->top;
                }
                if ($request->jatuh_tempo != "") {
                    $post->jatuh_tempo = date("Y-m-d", strtotime(str_replace('/', '-', $request->jatuh_tempo)));
                }
                if ($request->tanggal_bayar) {
                    $post->tanggal_bayar = date("Y-m-d", strtotime(str_replace('/', '-', $request->tanggal_bayar)));
                }
                if ($request->status == "CLOSE") {
                    $post->status = $request->status;
                }
                $post->save();

                $data = [$post];
                return response()->json($data);
            }
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }


    public function destroy($id)
    {
        $post = ModelsInvoice::find($id);
        $post->delete();

        $get = DetailInvoice::where(['invoice_id' => $id])->get();

        foreach ($get as $data) {
            $del_detail = DetailInvoice::find($data->id);
            $del_detail->delete();
        }

        return response()->json($post);
    }

    public function tt_invoice(Request $request)
    {
        $data = ModelsInvoice::with('customer')->find($request->id_print);
        $date_cetak = date("Y-m-d", strtotime(str_replace('/', '-', $request->cetak_date)));
        return view('/PrintOut/tt_invoice', ['data' => $data, 'date_cetak' => $date_cetak]);
    }

    public function tax_invoice(Request $request)
    {
        $data = ModelsInvoice::with('customer', 'order', 'DetailInvoice.Parts')->find($request->id_print);
        $date_cetak = date("Y-m-d", strtotime(str_replace('/', '-', $request->cetak_date)));
        $pajak = Application::find($data->tax_id);
        //$DetOrder = DetailOrder::with('Parts')->whereIn('id', explode(",", $data->detail_order))->get();
        return view('/PrintOut/tax_invoice', ['data' => $data, 'date_cetak' => $date_cetak, 'pajak' => $pajak]);
        //return response()->json($data);
    }

    public function rekap_sj(Request $request)
    {
        $order = ModelsInvoice::with('customer', 'order.DetailOrder')->find($request->id_print);

        //if ($order->order_id != 0 || $order->order_id != null) {
        $po = Order::select('no_po')->find($order->order_id);
        //} else {
        // $po = "#";
        //}

        $pajak = Application::find($order->tax_id);
        $datau = DetailSJ::with('DetailSJ', 'part');
        //$datau->wherein('part_id', explode(",", $order->detail_order));
        $datau->whereRelation('DetailSJ', 'invoice_id', '=', $request->id_print);

        // $datau->whereHas('DetailSJ', function ($query) use ($order) {
        //     $query->where('order_id', $order->id);
        // });
        $data = $datau->get();

        $dataa = Parts::with('out.DetailSJ', 'customer');
        // $dataa->whereHas('out.DetailSJ', function ($query) use ($request) {
        //     $query->where('invoice_id', '=', $request->id_print);
        // });
        $dataa->whereRelation('out.DetailSJ', 'invoice_id', '=', $request->id_print);

        $ar = array();
        $arr = array();
        $arrr = array();
        foreach ($data as $att) {
            $ar[] = $att->DetailSJ;
            $arr[] = $att->part;
            $arrr[] = $att;
            $unique_data = array_unique($ar);
            $unique_dataa = array_unique($arr);
            $unique_dataaa = array_unique($arrr);
        }

        $dat = $dataa->get();
        $datdetail = array();
        if (count($dat) > 0) {
            foreach ($dat as $key => $attt) {
                foreach ($unique_data as $ke => $uniqe) {
                    foreach ($dat[$key]->out as $kee => $datan) {
                        $datdetail[$key]["part_name"] = $attt->part_name;
                        $datdetail[$key]["part_no"] = $attt->part_no;
                        $datdetail[$key]["uniqe"][$ke]["nosj"] = $uniqe->nosj;
                        $datdetail[$key]["uniqe"][$ke]["nosj_link"] = date('d', strtotime($uniqe->date_sj)) . $uniqe->nosj;
                        $datdetail[$key]["uniqe"][$ke]["date_sj"] = $uniqe->date_sj;
                        if ($uniqe->nosj . $request->id_print == $datan->DetailSJ['nosj'] . $datan->DetailSJ['invoice_id']) {
                            $datdetail[$key]["price"] = $datan->total_price / $datan->qty;
                            $datdetail[$key]["uniqe"][$ke]["sj_real"][0]["nosj"] = $datan->DetailSJ['nosj'];
                            $datdetail[$key]["uniqe"][$ke]["sj_real"][0]["qty"] = $datan->qty;
                        }
                    }
                }
            }
        }
        //return view('/rekap/rekap_sj1', ['judul' => "User", 'data' => $data, 'dat' => $dat, "datdetail" => $datdetail, 'invoice' => $order]);
        return view('/rekap/rekap_sj1', ['judul' => "User", 'dat' => $dat, "datdetail" => $datdetail, "po" => $po, 'pajak' => $pajak]);
        //return $po;
    }

    public function rekap_invoice(Request $request)
    {
        if ($request->order_id != "#") {
            $po = Order::select('no_po')->find($request->order_id);
        } else {
            $po = "#";
        }
        $pajak = Application::where('status', 'Active')->first();
        $datau = DetailSJ::with('DetailSJ', 'part');
        $datau->whereHas('DetailSJ', function ($query) use ($request) {
            if ($request->date != null) {
                $date = explode(" - ", $request->date);
                $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
                $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));
                $query->whereDate('date_sj', '>=', $datein)
                    ->whereDate('date_sj', '<=', $dateen);
            }
            if ($request->order_id != "#") {
                $query->where('order_id', $request->order_id);
            }
            if ($request->cust_id != "#") {
                $query->where('cust_id', $request->cust_id);
            }
            if ($request->status != "#") {
                $query->where('status', $request->status);
            }
        });
        $data = $datau->get();
        $dataa = Parts::with('out.DetailSJ', 'customer');

        $dataa->whereHas('out.DetailSJ', function ($query) use ($request) {
            if ($request->date != null) {
                $date = explode(" - ", $request->date);
                $datein = date("Y-m-d", strtotime(str_replace('/', '-', $date[0])));
                $dateen = date("Y-m-d", strtotime(str_replace('/', '-', $date[1])));

                $query->whereDate('date_sj', '>=', $datein)
                    ->whereDate('date_sj', '<=', $dateen);
            }
            if ($request->order_id != "#") {
                $query->where('order_id', $request->order_id);
            }
            if ($request->cust_id != "#") {
                $query->where('cust_id', $request->cust_id);
            }
            if ($request->status != "#") {
                $query->where('status', $request->status);
            }
        });

        $ar = array();
        $arr = array();
        $arrr = array();
        foreach ($data as $att) {
            $ar[] = $att->DetailSJ;
            $arr[] = $att->part;
            $arrr[] = $att;
            $unique_data = array_unique($ar);
            $unique_dataa = array_unique($arr);
            $unique_dataaa = array_unique($arrr);
        }

        $dat = $dataa->get();
        $datdetail = array();
        if (count($dat) > 0) {
            foreach ($dat as $key => $attt) {
                foreach ($unique_data as $ke => $uniqe) {
                    foreach ($dat[$key]->out as $kee => $datan) {
                        //$datdetail[$key][$attt->part_name][$uniqe->nosj][$datan->DetailSJ['nosj']] = [$datan->qty];
                        $datdetail[$key]["name_local"] = $attt->name_local;
                        $datdetail[$key]["part_no"] = $attt->part_no;
                        $datdetail[$key]["price"] = $attt->price;
                        $datdetail[$key]["uniqe"][$ke]["nosj"] = $uniqe->nosj;
                        $datdetail[$key]["uniqe"][$ke]["date_sj"] = $uniqe->date_sj;
                        if ($uniqe->nosj == $datan->DetailSJ['nosj']) {
                            $datdetail[$key]["uniqe"][$ke]["sj_real"][0]["nosj"] = $datan->DetailSJ['nosj'];
                            $datdetail[$key]["uniqe"][$ke]["sj_real"][0]["qty"] = $datan->qty;
                        }
                    }
                }
            }
        }
        return view('/rekap/rekap_invoice', ['judul' => "User", 'dat' => $dat, "datdetail" => $datdetail, "po" => $po, 'pajak' => $pajak]);
        //return ['dat' => $dat, 'data' => $data, 'datdetail' => $datdetail];
        //return $datdetail;
    }

    public function report_invoice(Request $request)
    {
        $dataa = ModelsInvoice::with('customer');
        if ($request->cust_id != "#") {
            $dataa->where('cust_id', $request->cust_id);
            if ($request->month != "#") {
                $dataa->whereMonth('date_inv', $request->month);
            } elseif ($request->year != "#") {
                $dataa->whereYear('date_inv', $request->year);
            }
        } elseif ($request->year == "#" && $request->month != "#") {
            $dataa->whereMonth('date_inv', $request->month);
            $dataa->whereYear('date_inv', date("Y"));
        } elseif ($request->year != "#" && $request->month == "#") {
            $dataa->whereYear('date_inv', $request->year);
        } elseif ($request->year != "#" && $request->month != "#") {
            $dataa->whereMonth('date_inv', $request->month);
            $dataa->whereYear('date_inv', $request->year);
        }

        $data = $dataa->get();

        return DataTables::of($data)
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }
}
