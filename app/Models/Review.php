<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable =['rate','name','email','phone','comment','post_id'];

    public function Post()
    {
        return $this->hasOne('App\Models\Post', 'id', 'post_id');
    }
}
