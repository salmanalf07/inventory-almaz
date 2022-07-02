<?php

namespace App\Http\Controllers;

use App\Models\Application as ModelsApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Application extends Controller
{
    public function json()
    {
        $data = ModelsApplication::get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Action
                    </button>
                    <div class="dropdown-menu">
                    <button id="edit" data-id="' . $data->id . '" class="dropdown-item">Update</button>
                    <button id="delete" data-id="' . $data->id . '" class="dropdown-item">Delete</button>
                    </div>
                    </div>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'ppn' => ['required', 'string', 'max:255'],
                'pph' => ['required', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:255'],
            ]);

            $post = new ModelsApplication();
            $post->ppn = $request->ppn;
            $post->pph = $request->pph;
            if ($request->status != "#") {
                $post->status = $request->status;
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
        $get = ModelsApplication::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => ['required', 'string', 'max:255'],
            ]);

            $post = ModelsApplication::find($id);
            if ($request->status != "#") {
                $post->status = $request->status;
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
        $post = ModelsApplication::find($id);
        $post->delete();

        return response()->json($post);
    }
}
