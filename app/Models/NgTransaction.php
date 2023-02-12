<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NgTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'detransaction_id',
        'over_paint',
        'bintik_or_pin_hole',
        'minyak_or_map',
        'cotton',
        'no_paint_or_tipis',
        'scratch',
        'air_pocket',
        'kulit_jeruk',
        'kasar',
        'karat',
        'water_over',
        'minyak_kering',
        'dented',
        'keropos',
        'nempel_jig',
        'lainnya',
    ];
}
