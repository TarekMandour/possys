<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class Post extends Model
{
    protected $fillable = [
        'title', 'title_en', 'content', 'cat_id', 'is_show', 'is_tax',
        'itm_code ', 'itm_unit1', 'itm_unit2', 'itm_unit3', 'mid', 'sm',
        'status', 'photo', 'branch_id'
    ];

    public function Category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'cat_id');
    }

    public function Branch()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }

    public function Unit1()
    {
        return $this->hasOne('App\Models\Unit', 'num', 'itm_unit1');
    }

    public function Unit2()
    {
        return $this->hasOne('App\Models\Unit', 'num', 'itm_unit2');
    }

    public function Unit3()
    {
        return $this->hasOne('App\Models\Unit', 'num', 'itm_unit3');
    }

    public function Stock(){
        return $this->hasMany(Stock::class,'itm_code','itm_code');
    }

    public function StockLast(){
        return $this->hasOne(Stock::class,'itm_code','itm_code')->select('price_selling','itm_code')->latest();
    }

    public function Reviews()
    {
        return $this->hasMany(Review::class , 'post_id');
    }

    public function additional(){
        return $this->hasMany(PostAdditional::class,'itm_code','itm_code');
    }

    public function addi(){
        return $this->hasMany(PostAdditional::class,'itm_code','itm_code');
    }
    public function attribute(){
        return $this->hasMany(PostAttribute::class,'itm_code','itm_code');
    }

//
//    public function Levels()
//    {
//        return $this->hasOne('App\Models\Level', 'id', 'level_id');
//    }

}
