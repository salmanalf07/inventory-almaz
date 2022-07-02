<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nopol',
        'brand',
        'type',
        'status',
    ];

    public function car()
    {
        return $this->hasMany(SJ::class, 'car   _id', 'id');
    }
}
