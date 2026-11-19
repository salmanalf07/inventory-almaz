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
        $data = ModelsUser::with('roles')->get();

        return DataTables::of($data)
            ->addColumn('role', function ($data) {
                return $data->roles->pluck('name')->implode(', ');
            })
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
                'password' => ['required', 'string', new Password],
                'role_id' => ['required', 'exists:roles,id'],
            ]);

            $post = new ModelsUser();
            $post->name = $request->name;
            $post->username = $request->username;
            $post->password = bcrypt($request->password);
            $post->phone = $request->phone;
            $post->save();
            
            $post->roles()->sync([$request->role_id]);

            $data = [$post];
            return response()->json($data);
        } catch (ValidationException $error) {
            $data = [$error->errors(), "error"];
            return response($data);
        }
    }

    public function edit(Request $request)
    {
        $user = ModelsUser::with('roles')->find($request->id);
        $data = $user->toArray();
        $data['role_id'] = $user->roles->first() ? $user->roles->first()->id : null;
        return response()->json($data);
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
            $post->save();
            
            if ($request->role_id) {
                $post->roles()->sync([$request->role_id]);
            }

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
