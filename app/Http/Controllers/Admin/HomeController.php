<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        // $user = Auth::User();
        // Session::put('user', $user);
    
        return view('admin.blank'); 
    }

    public function disable_bdg () {
        $notification = Notification::where('title', '!=' , null)->update([
            'bdg' => 0
        ]);
    }
    
}
