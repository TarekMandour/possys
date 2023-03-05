<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $guard = 'client';

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'photo', 'is_active','city','address','location'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Address()
    {
        return $this->hasMany('App\Models\Address', 'client_id', 'id');
    }

    public  function getPhoto(){
        return url('public/uploads/'.$this->photo);
    }


    public function wallets()
    {
        return $this->morphMany('App\Models\Wallet', 'walletable');
    }
}
