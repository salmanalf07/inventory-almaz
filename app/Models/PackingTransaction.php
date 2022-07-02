<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackingTransaction extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'detransaction_id',
        'label_pack',
        'qty_out',
        'total_fg',
        'tota_ng',
        'type_ng',
        'tota_pack',
        'operator',
    ];

    public function detail_transaction()
    {
        return $this->belongsTo(DetailTransaction::class, 'detransaction_id', 'id');
    }
}
