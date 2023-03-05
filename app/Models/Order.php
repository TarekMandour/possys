<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id','client_name', 'client_phone', 'client_email',
        'client_state','client_city', 'client_address', 'payment',
        'branch_id','branch_name', 'more_notes', 'type',
        'scheduled','status_pay','delivery_cost',
        'status','total_price'
    ];

    public function OrderProduct()
    {
        return $this->hasMany('App\Models\OrderProduct', 'order_id', 'id');
    }

    public function deligate()
    {
        return $this->hasOne(Deligate::class, 'id','deligate_id');
    }

    public function Branch(){
        return $this->belongsTo(Branch::class);
    }
}
