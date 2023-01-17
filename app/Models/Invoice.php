<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cust_id',
        'date_inv',
        'no_invoce',
        'no_faktur',
        'harga_jual',
        'detail_order',
        'tax_id',
        'ppn',
        'pph',
        'total_harga',
        'tukar_faktur',
        'jatuh_tempo',
        'tanggal_bayar',
        'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function DetailInvoice()
    {
        return $this->hasMany(DetailInvoice::class, 'invoice_id', 'id');
    }
    public function application()
    {
        return $this->hasMany(Application::class, 'id', 'tax_id');
    }
}
