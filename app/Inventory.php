<?php

namespace App;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{


    public function Branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function InventoryDetails()
    {
        return $this->hasMany(InventoryDetails::class);
    }
}
