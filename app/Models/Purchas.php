<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchas extends Model
{
    public function Supplier()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
}
