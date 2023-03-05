<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public function getPhoto()
    {
        return url('public/uploads/' . $this->photo);
    }

    public function getPhoto2()
    {
        return url('public/uploads/' . $this->photo2);
    }

    public function getPhoto3()
    {
        return url('public/uploads/' . $this->photo3);
    }

    public function getPhoto4()
    {
        return url('public/uploads/' . $this->photo4);
    }
}
