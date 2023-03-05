<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function Branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function Product()
    {
        return $this->hasOne('App\Models\Post', 'itm_code', 'itm_code');
    }
}
