<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'npwp',
        'address',
        'send_address',
        'phone',
        'name_pic',
        'phone_pic',
        'distance',
        'top',
        'type_invoice',
        'invoice_schedule',
        'information',
        'ppn',
        'pph',
    ];

    public function part_in()
    {
        return $this->hasMany(PartIn::class, 'cust_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'cust_id', 'id');
    }

    public function sj()
    {
        return $this->hasMany(SJ::class, 'cust_id', 'id');
    }

    public function parts()
    {
        return $this->hasMany(Parts::class, 'cust_id', 'id');
    }

    public function invoice()
    {
        return $this->hasMany(invoice::class, 'cust_id', 'id');
    }
}
