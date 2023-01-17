<?php

namespace App\Http\Controllers;

use App\Models\StockWip;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EarlyStock extends Controller
{
    public function json(Request $request)
    {
        $dataa = StockWip::with('Parts.customer');
        $data = $dataa->get();

        return DataTables::of($data)
            ->addColumn('aksi', function ($data) {
                return
                    '';
            })
            ->rawColumns(['aksi', 'no_partin'])
            ->toJson();
        // <a href="print_partin/' . $data->id . '" class="btn btn-primary">Print</a>
    }
}
