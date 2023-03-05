<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'photo', 'is_active'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function Branch(){
        return $this->belongsTo(Branch::class);
    }
    public  function getPhoto(){
        return url('public/uploads/'.$this->photo);
    }
}
