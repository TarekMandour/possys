<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{


    public function wallets()
    {
        return $this->morphMany('App\Models\Wallet', 'walletable');
    }
}
