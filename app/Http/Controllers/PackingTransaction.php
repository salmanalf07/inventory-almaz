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
        $dataa = ModelsPackingTransaction::with('detail_transaction', 'detail_transaction.Transaction', 'detail_transaction.Part', 'detail_transaction.Part.customer')
            ->whereHas('detail_transaction.Transaction', function ($query) use ($request) {
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
                    '<button id="edit" data-id="' . $data->detail_transaction->id . '" class="btn btn-warning">Update</button>';
            })
            ->rawColumns(['aksi', 'no_partin'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }

    public function edit(Request $request)
    {
        $get = DetailTransaction::with('Part', 'Transaction.user', 'Packing', 'NG')->find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }
    public function update(Request $request, $id)
    {
        try {
            if ($request->time_end && $request->operator) {
                $request->validate([
                    'time_end' => ['required', 'string', 'max:255'],
                    'operator' => ['required', 'string', 'max:255'],

                ]);
            }

            $post = Transaction::find($id);
            if ($request->time_end) {
                $post->time_end = date("Y-m-d H:i", strtotime(str_replace('/', '-', $request->time_end)));
            }
            $post->status = $request->status;
            $post->save();
            if ($request->detail_id) {

                $packing = ModelsPackingTransaction::firstWhere(['detransaction_id' => $request->detail_id]);
                $packing->update([
                    'qty_out'  => str_replace(",", "", $request->qty_out),
                    'total_ng'  => str_replace(",", "", $request->total_ng),
                    'operator' => $request->operator,
                    'updated_at' => date("Y-m-d H:i:s", strtotime('now'))
                ]);

                $ng = NgTransaction::firstOrNew(['detransaction_id' => $request->detail_id]);
                $ng->detransaction_id = $request->detail_id;
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
            }

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
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
