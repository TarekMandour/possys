<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->type == 0) {
            return $next($request);
        } elseif (Auth::check() && Auth::user()->type == 1) {
            return redirect(url('admin/cashier'));
        } elseif (Auth::check() && Auth::user()->type == 2) {
            return redirect(url('admin/kitchen'));
        } else {
            return redirect(url('/'));
        }

    }
}
