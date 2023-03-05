<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'client_id', 'pro_id', 'qty'
    ];

    public function Post()
    {
        return $this->hasOne('App\Models\Post', 'id', 'pro_id');
    }

}
