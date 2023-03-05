<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth

Route::post('/admin-login', 'Api\AdminController@login');
Route::get('/admin-profile', 'Api\AdminController@profile');
Route::post('/change-password', 'Api\AdminController@change_pasword');
Route::post('/update-profile', 'Api\AdminController@UpdateProfile');
Route::post('/update-password', 'Api\AdminController@Updatepassword');
Route::post('/check-code', 'Api\AdminController@checkCode');

//Content

Route::get('/home/{id}', 'Api\AdminController@home');
Route::get('/settings', 'Api\AdminController@settings');
Route::get('/categories', 'Api\AdminController@Categories');
Route::get('/units', 'Api\AdminController@Units');
Route::get('/branches', 'Api\AdminController@Branches');
Route::get('/products-cat-id/{branch_id}/{cat_id}', 'Api\AdminController@ProductsByCatID');
Route::get('/product-details/{branch_id}/{product_id}', 'Api\AdminController@ProductDetail');
Route::post('/search', 'Api\AdminController@Search');
Route::get('/search-itemcode/{branch_id}/{item_code}', 'Api\AdminController@SearchItemCode');
Route::get('/printers', 'Api\AdminController@printers');
Route::post('/printer-update', 'Api\AdminController@printerUpdate');
Route::get('/printer-details/{id}', 'Api\AdminController@printerDetail');
Route::get('/printer-remove/{id}', 'Api\AdminController@printerremove');
Route::get('/tables-category', 'Api\AdminController@tablesCategory');
Route::get('/tables', 'Api\AdminController@tables');
Route::get('/tables-by-category/{cat_id}', 'Api\AdminController@tableByCategory');
Route::get('/table-details/{id}', 'Api\AdminController@tableDetail');
Route::post('/table-update', 'Api\AdminController@tableUpdate');
Route::post('/client-add', 'Api\AdminController@clientAdd');
Route::get('/client-profile/{phone}', 'Api\AdminController@clientProfile');
Route::get('/discounts', 'Api\AdminController@Discounts');


Route::post('/client-login', 'Api\ClientController@login'); 
// Route::get('/client-profile', 'Api\ClientController@profile');
Route::get('/all-clients', 'Api\ClientController@AllClients');
Route::get('/page/{id}', 'Api\ClientController@Page');
Route::get('/sliders', 'Api\AdminController@sliders');
Route::get('/supplies', 'Api\AdminController@supplies');
Route::post('/store-supplier', 'Api\AdminController@StoreSupplier');
Route::get('/active-products/{id}', 'Api\AdminController@ActiveProducts');
Route::get('/featured-products/{id}', 'Api\AdminController@FeaturedProducts');


//cart
Route::post('/add-cart', 'Api\CartController@AddCart');
Route::get('/get-cart', 'Api\CartController@ShowCart');
Route::get('/delete-cart/{id}', 'Api\CartController@DeleteCart');
Route::get('/delete-all-cart', 'Api\CartController@DeleteAllCart');
Route::post('/edit-cart', 'Api\CartController@EditCart');
Route::post('/add-discount', 'Api\CartController@AddDiscount');
Route::post('/add-order', 'Api\CartController@AddOrder');
Route::post('/get-orders', 'Api\CartController@getOrders');
Route::get('/get-order/{id}', 'Api\CartController@getOrder');