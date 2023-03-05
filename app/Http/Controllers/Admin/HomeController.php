<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    
}
