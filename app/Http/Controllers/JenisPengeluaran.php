<?php

namespace App\Http\Controllers;

use App\Models\JenisPengeluaran as ModelsJenisPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class JenisPengeluaran extends Controller
{
    public function json(Request $request)
    {
        $data = ModelsJenisPengeluaran::get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
                <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'type' => ['required', 'string', 'max:255'],
                'keterangan' => ['required', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:255'],
            ]);

            $post = new ModelsJenisPengeluaran();
            $post->type = $request->type;
            $post->keterangan = $request->keterangan;
            if ($request->status != "#") {
                $post->status = $request->status;
            } else {
                $post->status = "ACTIV";
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
        $get = ModelsJenisPengeluaran::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'type' => ['required', 'string', 'max:255'],
                'keterangan' => ['required', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:255'],
            ]);

            $post = ModelsJenisPengeluaran::find($id);
            $post->type = $request->type;
            $post->keterangan = $request->keterangan;
            if ($request->status != "#") {
                $post->status = $request->status;
            } else {
                $post->status = "ACTIV";
            }
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
        $post = ModelsJenisPengeluaran::find($id);
        $post->delete();

        return response()->json($post);
    }
}
