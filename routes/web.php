<?php

use Illuminate\Support\Facades\Route;

//Auth::routes();

Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::get('/invoice/{id}', 'Admin\OrderController@invoice')->name('admin.login');


