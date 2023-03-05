<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryDetails extends Model
{

    public function Inventory(){
        return $this->belongsTo(Inventory::class);
    }
}
