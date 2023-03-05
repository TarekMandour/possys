<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deligate extends Model
{
    protected $fillable = ['name', 'phone'];

    public function Branch(){
        return $this->belongsTo(Branch::class);
    }
}
