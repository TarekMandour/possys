<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    protected $fillable = [
        'user_id', 'user_type', 'external_name', 'trans_date', 'pay_type', 'type', 'amount', 'notes'
    ];


    public function User()
    {
        if ($this->user_type == 'client') {
            return $this->belongsTo(Client::class, 'user_id');
        } else if ($this->user_type == 'supplier') {
            return $this->belongsTo(Supplier::class, 'user_id');
        }
    }
}
