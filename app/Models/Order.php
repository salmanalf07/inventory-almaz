<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cust_id',
        'no_po',
        'date',
        'status',
    ];

    public function part_in()
    {
        return $this->hasMany(PartIn::class, 'order_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function DetailOrder()
    {
        return $this->hasMany(DetailOrder::class, 'order_id', 'id');
    }
}
