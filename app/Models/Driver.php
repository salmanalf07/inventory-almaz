<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'sim',
        'status',
    ];

    public function driver()
    {
        return $this->hasMany(SJ::class, 'cust_id', 'id');
    }
}
