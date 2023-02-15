<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackingTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'cust_id',
        'part_id',
        'date_packing',
        'total_fg',
        'total_ng',
        'operator',
        'status'
    ];

    public function ng()
    {
        return $this->hasOne(NgTransaction::class, 'packing_id', 'id');
    }
    public function Part()
    {
        return $this->belongsTo(Parts::class, 'part_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
