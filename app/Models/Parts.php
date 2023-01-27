<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parts extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cust_id',
        'name_local',
        'part_no',
        'part_name',
        'price',
        'sa_dm',
        'qty_pack',
        'type_pack',
        'information',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'cust_id', 'id');
    }

    public function part_in()
    {
        return $this->hasMany(DetailPartIn::class, 'part_id', 'id');
    }
    public function part_out()
    {
        return $this->hasMany(DetailSJ::class, 'part_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'part_id', 'id');
    }

    public function stock()
    {
        return $this->hasMany(Stock::class, 'part_id', 'id');
    }

    public function out()
    {
        return $this->hasMany(DetailSJ::class, 'part_id', 'id');
    }
}
