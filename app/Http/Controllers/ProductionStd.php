<?php

namespace App\Http\Controllers;

use App\Models\ProductionStd as ModelsProductionStd;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class ProductionStd extends Controller
{
    public function json()
    {
        $data = ModelsProductionStd::get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Edit</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'work_hours' => ['required', 'string', 'max:255'],
                'normal_capacity' => ['required', 'string', 'max:255'],
                'target' => ['required', 'string', 'max:255'],
                'status' => ['required', 'string', 'max:255'],
            ]);

            $post = new ModelsProductionStd();
            $post->work_hours = $request->work_hours;
            $post->normal_capacity = $request->normal_capacity;
            $post->target = $request->target;
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
        $get = ModelsProductionStd::find($request->id);
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

            $post = ModelsProductionStd::find($id);
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
}
