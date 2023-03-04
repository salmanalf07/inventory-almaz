<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductionStd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'work_hours',
        'normal_capacity',
        'target',
        'status',
    ];
}
