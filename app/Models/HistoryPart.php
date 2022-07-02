<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'cust_id',
        'part_id',
        'name_local',
        'part_no',
        'part_name',
        'price',
        'periode',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
}
