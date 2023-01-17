<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cust_id',
        'user_id',
        'date_transaction',
        'no_transaction',
        'no_rak',
        'total_sa',
        'total_price',
        'time_start',
        'time_end',
        'status',
    ];

    public function detail_transaction()
    {
        return $this->hasMany(DetailTransaction::class, 'transaction_id', 'id');
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
