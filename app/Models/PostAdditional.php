<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAdditional extends Model
{
    protected $fillable = [
        'itm_code', 'addname', 'addprice'
    ];
}
