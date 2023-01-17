<?php

namespace App\Http\Controllers;

use App\Models\Stock as ModelsStock;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class Stock extends Controller
{
    public function json(Request $request)
    {
        $dataa = ModelsStock::with('Parts', 'Parts.customer');
        $data = $dataa->get();


        return DataTables::of($data)
            // ->addColumn('aksi', function ($data) {
            //     return
            //         '
            //         <button id="edit" data-id="' . $data->id . '" class="btn btn-warning">Update</button>
            //         <button id="delete" data-id="' . $data->id . '" class="btn btn-danger">Delete</button>';
            // })
            // ->rawColumns(['aksi'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }
}
