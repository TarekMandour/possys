<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    public function category()
    {
        return $this->hasOne('App\Models\TableCat', 'id', 'cat_id');
    }
}
