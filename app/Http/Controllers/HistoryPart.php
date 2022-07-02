<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailOrder;
use App\Models\DetailPartIn;
use App\Models\DetailSJ;
use App\Models\HistoryPart as ModelsHistoryPart;
use App\Models\Parts;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class HistoryPart extends Controller
{
    public function json()
    {
        $data = ModelsHistoryPart::with('customer');
        return DataTables::of($data)
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'cust_id' => ['required', 'string', 'max:255'],
                'part_no' => ['required', 'string', 'max:255'],
                'part_name' => ['required', 'string', 'max:255'],
            ]);
            if ($request->price) {
                $price = str_replace(",", "", $request->price);
            } else {
                $price = 0;
            }
            $get = Customer::find($request->cust_id);

            $post = new Parts();
            $post->cust_id = $request->cust_id;
            $post->name_local = $request->part_name . '-' . $get->code . '-' . substr($request->part_no, -5);
            $post->part_no = $request->part_no;
            $post->part_name = $request->part_name;
            $post->price = $price;
            $post->sa_dm = $request->sa_dm;
            $post->qty_pack = $request->qty_pack;
            $post->type_pack = $request->type_pack;
            $post->information = $request->information;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
}
