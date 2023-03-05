<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id', 'pro_id', 'name', 'photo', 'category',
        'price', 'qty'
    ];

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function product()
    {
        return $this->hasOne(Post::class, 'id', 'pro_id');
    }

    public function getAttributesAttribute()
    {
        $res = null;
        if ($this->attributes['attributes'] != null) {

            $res = json_decode($this->attributes['attributes']);

        }

        return $res;
    }

    public function getAdditionsAttribute()
    {
        $res = null;
        if ($this->attributes['additions'] != null) {

            $res = json_decode($this->attributes['additions']);
        }

        return $res;
    }
}
