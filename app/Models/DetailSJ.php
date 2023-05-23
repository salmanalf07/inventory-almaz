<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailSJ extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "detail_sjs";
    protected $fillable = [
        'sj_id',
        'part_id',
        'qty',
        'qty_pack',
        'type_pack',
        'sadm',
        'total_price'
    ];

    public function DetailSJ()
    {
        return $this->belongsTo(SJ::class, 'sj_id', 'id');
    }

    public function part()
    {
        return $this->belongsTo(Parts::class, 'part_id', 'id');
    }
}
