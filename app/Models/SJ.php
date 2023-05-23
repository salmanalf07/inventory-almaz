<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SJ extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sjs";
    protected $fillable = [
        'nosj',
        'invoice_id',
        'cust_id',
        'car_id',
        'driver_id',
        'sadm',
        'grand_total',
        'user_id',
        'date_sj',
        'kembali_sj',
        'revisi',
        'status'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function DetailSJ()
    {
        return $this->hasMany(DetailSJ::class, 'sj_id', 'id');
    }
    public function tracking()
    {
        return $this->hasMany(TrackSj::class, 'sj_id', 'id');
    }
}
