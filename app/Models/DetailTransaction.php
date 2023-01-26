<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'cust_id',
        'part_id',
        'qty_in',
        'sa',
        'price',
    ];

    public function Transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
    public function Part()
    {
        return $this->belongsTo(Parts::class, 'part_id', 'id');
    }

    public function Packing()
    {
        return $this->hasOne(PackingTransaction::class, 'detransaction_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }
}
