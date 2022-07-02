<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_id',
        'qty',
    ];

    public function Parts()
    {
        return $this->belongsTo(Parts::class, 'part_id', 'id');
    }
}
