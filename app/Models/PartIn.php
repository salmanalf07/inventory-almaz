<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartIn extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'order_id',
        'cust_id',
        'user_id',
        'no_part_in',
        'date_in',
        'no_sj_cust',
        'check_result',
        'plan_delivery',
        'priority',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function part()
    {
        return $this->belongsTo(Parts::class, 'part_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function DetailPartIn()
    {
        return $this->hasMany(DetailPartIn::class, 'partin_id', 'id');
    }
}
