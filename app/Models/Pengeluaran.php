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
}
