<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pengeluaran_id',
        'driver_id',
        'cust_id',
        'car_id',
        'month',
        'typeInput',
        'date',
        'uraian',
        'debit',
        'kredit',
        'saldo',
        'keterangan',
        'status'
    ];

    public function jenisPengeluaran()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'pengeluaran_id', 'id');
    }
    public function drivers()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }
    public function customers()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function cars()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
}
