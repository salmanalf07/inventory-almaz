<?php

namespace App\Http\Controllers;

use App\Imports\CustomersImport;
use App\Models\Customer as ModelsCustomer;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class Customer extends Controller
{
    public function json()
    {
        $data = ModelsCustomer::orderBy('created_at', 'DESC');

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-primary">Edit</button>
                    <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'code' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'send_address'  => ['required', 'string', 'max:255'],
                'phone'  => ['nullable', 'string'],
                'name_pic' => ['required', 'string', 'max:255'],
                'phone_pic'  => ['required', 'string'],
                'distance' => ['nullable', 'string'],
                'type_invoice' => ['nullable', 'string', 'max:255'],
                'invoice_schedule' => ['nullable', 'string', 'max:255'],
                'information'  => ['nullable', 'string', 'max:255'],
            ]);

            $post = new ModelsCustomer();
            $post->code = $request->code;
            $post->name = $request->name;
            $post->npwp = $request->npwp;
            $post->address = $request->address;
            $post->send_address  = $request->send_address;
            $post->phone  = $request->phone;
            $post->name_pic = $request->name_pic;
            $post->phone_pic = $request->phone_pic;
            $post->distance = $request->distance;
            $post->type_invoice = $request->type_invoice;
            $post->invoice_schedule = $request->invoice_schedule;
            $post->ppn = $request->ppn;
            $post->pph = $request->pph;
            $post->information  = $request->information;
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
        $get = ModelsCustomer::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'code' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
                'send_address'  => ['required', 'string', 'max:255'],
                'phone'  => ['nullable', 'string', 'max:255'],
                'name_pic' => ['required', 'string', 'max:255'],
                'phone_pic'  => ['required', 'string', 'max:255'],
                'distance' => ['nullable', 'string', 'max:255'],
                'type_invoice' => ['nullable', 'string', 'max:255'],
                'invoice_schedule' => ['nullable', 'string', 'max:255'],
                'information'  => ['nullable', 'string', 'max:255'],
            ]);

            $post = ModelsCustomer::find($id);
            $post->code = $request->code;
            $post->name = $request->name;
            $post->npwp = $request->npwp;
            $post->address = $request->address;
            $post->send_address  = $request->send_address;
            $post->phone  = $request->phone;
            $post->name_pic = $request->name_pic;
            $post->phone_pic = $request->phone_pic;
            $post->distance = $request->distance;
            $post->type_invoice = $request->type_invoice;
            $post->invoice_schedule = $request->invoice_schedule;
            $post->information  = $request->information;
            $post->ppn = $request->ppn;
            $post->pph = $request->pph;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = ModelsCustomer::find($id);
        $post->delete();

        return response()->json($post);
    }
}
