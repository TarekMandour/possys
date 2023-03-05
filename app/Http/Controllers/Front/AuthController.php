<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Register(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|min:6',
            'phone' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',

        ]);

        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $auth = Auth::attempt(['phone' => $request->phone, 'password' => $request->password]);

        return redirect('home');

    }

    public function Login(Request $request)
    {
        $data = $this->validate($request, [
            'phone' => 'required',
            'password' => 'required',

        ]);

        $auth = Auth::attempt(['phone' => $request->phone, 'password' => $request->password]);

        return redirect('home');

    }
}
