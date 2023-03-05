<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title1','product_id'
    ];


        public function Product()
        {
            return $this->hasOne('App\Models\Post', 'id', 'product_id');
        }

}
