<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockWip extends Model
{
    use HasFactory;

    protected $fillable = [
        'partin_id',
        'part_id',
        'qty',
        'qty_out',
        'type',
        'total_price',
    ];

    public function Parts()
    {
        return $this->belongsTo(Parts::class, 'part_id', 'id');
    }
}
