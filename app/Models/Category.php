<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // public function Post()
    // {
    //     return $this->belongsTo('App\Models\Post', 'cat_id');
    // }


    public function getPhoto()
    {
        return url('public/uploads/' . $this->photo);
    }
}
