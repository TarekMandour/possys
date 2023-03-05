<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAttribute extends Model
{
    protected $fillable = [
        'itm_code', 'attribute_id', 'attribute_name', 'attname', 'attprice'
    ];
}
