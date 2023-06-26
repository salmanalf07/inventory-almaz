<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran as ModelsPengeluaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Pengeluaran extends Controller
{
    public function json(Request $request)
    {
        $data = ModelsPengeluaran::get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '<button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
                <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }
}
