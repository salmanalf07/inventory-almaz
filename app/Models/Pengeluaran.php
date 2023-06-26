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
        'month',
        'date',
        'uraian',
        'customer',
        'debit',
        'kredit',
        'saldo',
        'keterangan',
    ];

    public function jenisPengeluaran()
    {
        return $this->belongsTo(JenisPengeluaran::class, 'pengeluaran_id', 'id');
    }
}
