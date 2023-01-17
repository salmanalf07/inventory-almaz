<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPartIn extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'partin_id',
        'part_id',
        'qty',
        'type',
        'total_price'
    ];

    public function PartIn()
    {
        return $this->belongsTo(PartIn::class, 'partin_id', 'id');
    }
    public function Parts()
    {
        return $this->belongsTo(Parts::class, 'part_id', 'id');
    }
}
