<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Production extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'prodstd_id',
        'shift',
        'date_production',
        'hour_actual_st',
        'hour_actual_en',
        'output_act',
        'hanger_rusak',
        'tidak_racking',
        'keteter',
        'tidak_ada_barang',
        'trouble_mesin',
        'trouble_chemical',
        'trouble_utility',
        'trouble_ng',
        'mati_lampu',
    ];
}
