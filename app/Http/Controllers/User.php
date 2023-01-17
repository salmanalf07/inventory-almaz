<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Rules\Password;
use Yajra\DataTables\Facades\DataTables;

class User extends Controller
{
    public function json()
    {
        $data = ModelsUser::all();

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
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'phone' => ['nullable', 'string', 'max:255'],
                'password' => ['required', 'string', new Password],
            ]);

            $post = new ModelsUser();
            $post->name = $request->name;
            $post->username = $request->username;
            $post->password = bcrypt($request->password);
            $post->role = $request->role;
            $post->phone = $request->phone;
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
        $get = ModelsUser::find($request->id);
        //->first() = hanya menampilkan satu saja dari hasil query
        //->get() = returnnya berbentuk array atau harus banyak data
        return response()->json($get);
    }

    public function update(Request $request, $id)
    {
        try {

            $post = ModelsUser::find($id);
            $post->name = $request->name;
            $post->username = $request->username;
            if ($request->password) {
                $request->validate([
                    'password' => ['required', 'string', new Password],
                ]);
                $post->password = bcrypt($request->password);
            }
            $post->phone = $request->phone;
            $post->role = $request->role;
            $post->save();

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function updatee(Request $request, $id)
    {
        try {

            $post = ModelsUser::find($id);
            $post->name = $request->name;
            $post->username = $request->username;
            if ($request->password) {
                $request->validate([
                    'password' => ['required', 'string', new Password],
                ]);
                $post->password = bcrypt($request->password);
            }
            $post->phone = $request->phone;
            $post->save();

            $data = [$post];
            return back();
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }
    public function destroy($id)
    {
        $post = ModelsUser::find($id);
        $post->delete();

        return response()->json($post);
    }
}
