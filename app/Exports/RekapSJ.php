<?php

namespace App\Exports;

use App\Models\DetailOrder;
use App\Models\DetailSJ;
use App\Models\Invoice as ModelsInvoice;
use App\Models\Order;
use App\Models\SJ;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapSJ implements FromView
{
    protected $id_print;

    function __construct($id_print)
    {
        $this->id_print = $id_print;
    }

    public function view(): View
    {
        $datau = DetailSJ::with('DetailSJ', 'part');
        $datau->whereRelation('DetailSJ', 'cust_id', '=', 9);

        $order = ModelsInvoice::with('customer', 'order')->find($this->id_print);
        $datau->whereHas('DetailSJ', function ($query) use ($order) {
            $query->where('order_id', $order->order_id);
        });
        $data = $datau->get();
        $dataa = SJ::with('DetailSJ.part');
        $dataa->where('cust_id', '=', 9);
        $datau->whereHas('DetailSJ', function ($query) use ($order) {
            $query->where('order_id', $order->order_id);
        });

        $dat = $dataa->get();

        return view('/rekap/rekap_sj', ['judul' => "User", 'data' => $data, 'dat' => $dat, 'invoice' => $order]);
    }
}
