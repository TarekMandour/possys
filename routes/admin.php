<?php

use Illuminate\Support\Facades\Route;

Route::get('admin', 'HomeController@index')->name('admin.blank');

//Auth::routes();

Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::get('login', 'Auth\AdminLoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::post('admin/logout', 'Auth\AdminLoginController@logout')->name('logout');

// Admin routes
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {
    Route::group(['middleware' => ['admin']], function () {

        Route::get('/', 'HomeController@index')->name('admin.blank');

        Route::get('/admins', 'AdminController@index');
        Route::get('/show_admin/{id}', 'AdminController@show');
        Route::get('/create_admin', 'AdminController@create');
        Route::post('/create_admin', 'AdminController@store')->name('admin.create_admin.submit');
        Route::get('/edit_admin/{id}', 'AdminController@edit');
        Route::post('/edit_admin', 'AdminController@update')->name('admin.edit_admin.submit');
        Route::post('/delete_admin', 'AdminController@delete')->name('admin.delete_admin');

        Route::get('/bonus/{id}', 'BonusController@index');
        Route::get('/create_bonus', 'BonusController@store')->name('admin.create_bonus.submit');
        Route::post('/delete_bonus', 'BonusController@delete')->name('admin.delete_bonus');

        Route::get('/clients', 'ClientController@index');
        Route::get('/show_client/{id}', 'ClientController@show');
        Route::get('/create_client', 'ClientController@create');
        Route::post('/create_client', 'ClientController@store')->name('admin.create_client.submit');
        Route::get('/edit_client/{id}', 'ClientController@edit');
        Route::post('/edit_client', 'ClientController@update')->name('admin.edit_client.submit');
        Route::post('/delete_client', 'ClientController@delete')->name('admin.delete_client');
        Route::get('/sales_client/{id}', 'ClientController@sales');

        Route::get('/sliders', 'SliderController@index');
        Route::get('/show_slider/{id}', 'SliderController@show');
        Route::get('/create_slider', 'SliderController@create');
        Route::post('/create_slider', 'SliderController@store')->name('admin.create_slider.submit');
        Route::get('/edit_slider/{id}', 'SliderController@edit');
        Route::post('/edit_slider', 'SliderController@update')->name('admin.edit_slider.submit');
        Route::post('/delete_slider', 'SliderController@delete')->name('admin.delete_slider');

        Route::get('/contacts', 'ContactController@index');
        Route::get('/show_contact/{id}', 'ContactController@show');
        Route::get('/create_contact', 'ContactController@create');
        Route::post('/create_contact', 'ContactController@store')->name('admin.create_contact.submit');
        Route::get('/edit_contact/{id}', 'ContactController@edit');
        Route::post('/edit_contact', 'ContactController@update')->name('admin.edit_contact.submit');
        Route::post('/delete_contact', 'ContactController@delete')->name('admin.delete_contact');

        Route::get('/pages', 'PageController@index');
        Route::get('/show_page/{id}', 'PageController@show');
        Route::get('/create_page', 'PageController@create');
        Route::post('/create_page', 'PageController@store')->name('admin.create_page.submit');
        Route::get('/edit_page/{id}', 'PageController@edit');
        Route::post('/edit_page', 'PageController@update')->name('admin.edit_page.submit');
        Route::post('/delete_page', 'PageController@delete')->name('admin.delete_page');

        Route::get('/services', 'ServiceController@index');
        Route::get('/show_service/{id}', 'ServiceController@show');
        Route::get('/create_service', 'ServiceController@create');
        Route::post('/create_service', 'ServiceController@store')->name('admin.create_service.submit');
        Route::get('/edit_service/{id}', 'ServiceController@edit');
        Route::post('/edit_service', 'ServiceController@update')->name('admin.edit_service.submit');
        Route::post('/delete_service', 'ServiceController@delete')->name('admin.delete_service');

        Route::get('/products', 'PostController@index');
        Route::get('/show_post/{id}', 'PostController@show');
        Route::get('/create_post', 'PostController@create')->middleware('permission:اضافة منتج');
        Route::post('/create_post', 'PostController@store')->name('admin.create_post.submit')->middleware('permission:اضافة منتج');
        Route::get('/import_products', 'PostController@import_products');
        Route::post('/import_products', 'PostController@import_products_store')->name('admin.import_products.submit');
        Route::get('/edit_post/{id}', 'PostController@edit');
        Route::post('/edit_post', 'PostController@update')->name('admin.edit_post.submit');
        Route::post('/delete_post', 'PostController@delete')->name('admin.delete_post');
        Route::get('/reviews/{id}', 'PostController@reviews');
        Route::post('/filter_post', 'PostController@filter')->name('admin.filter_post.submit');
        Route::get('/filter_post', 'PostController@filter');
        Route::get('/export-product', 'PostController@export');


        Route::get('/edit_setting/{id}', 'SettingController@edit');
        Route::post('/edit_setting', 'SettingController@update')->name('admin.edit_setting.submit');

        Route::get('/menu', 'MenuController@index');
        Route::post('/create_menu', 'MenuController@store')->name('admin.create_menu.submit');
        Route::get('/edit_menu', 'MenuController@edit');
        Route::post('/update_menu', 'MenuController@update')->name('admin.update_menu.submit');
        Route::post('/delete_menu', 'MenuController@delete')->name('admin.delete_menu');

        Route::get('/category', 'CategoryController@index');
        Route::post('/create_category', 'CategoryController@store')->name('admin.create_category.submit');
        Route::get('/edit_category', 'CategoryController@edit');
        Route::post('/update_category', 'CategoryController@update')->name('admin.update_category.submit');
        Route::post('/delete_category', 'CategoryController@delete')->name('admin.delete_category');

        Route::get('/supplier', 'SupplierController@index');
        Route::get('/sales_supplier/{id}', 'SupplierController@sales');
        Route::post('/create_supplier', 'SupplierController@store')->name('admin.create_supplier.submit');
        Route::get('/edit_supplier', 'SupplierController@edit');
        Route::post('/update_supplier', 'SupplierController@update')->name('admin.update_supplier.submit');
        Route::post('/delete_supplier', 'SupplierController@delete')->name('admin.delete_supplier');

        Route::get('/damageditem', 'DamagedItemController@index');
        Route::get('/sales_damageditem/{id}', 'DamagedItemController@sales');
        Route::post('/create_damageditem', 'DamagedItemController@store')->name('admin.create_damageditem.submit');
        Route::get('/edit_damageditem', 'DamagedItemController@edit');
        Route::post('/update_damageditem', 'DamagedItemController@update')->name('admin.update_damageditem.submit');
        Route::post('/delete_damageditem', 'DamagedItemController@delete')->name('admin.delete_damageditem');
        Route::get('/filter_damageditem', 'DamagedItemController@filter')->name('admin.filter_damageditem.submit');

        Route::get('/deficiencies', 'DeficienciesController@index');
        Route::get('/sales_deficiencie/{id}', 'DeficienciesController@sales');
        Route::post('/create_deficiencie', 'DeficienciesController@store')->name('admin.create_deficiencie.submit');
        Route::get('/edit_deficiencie', 'DeficienciesController@edit');
        Route::post('/update_deficiencie', 'DeficienciesController@update')->name('admin.update_deficiencie.submit');
        Route::post('/delete_deficiencie', 'DeficienciesController@delete')->name('admin.delete_deficiencie');
        Route::get('/filter_deficiencie', 'DeficienciesController@filter')->name('admin.filter_deficiencie.submit');

        Route::get('/unit', 'UnitController@index');
        Route::post('/create_unit', 'UnitController@store')->name('admin.create_unit.submit');
        Route::get('/edit_unit', 'UnitController@edit');
        Route::post('/update_unit', 'UnitController@update')->name('admin.update_unit.submit');
        Route::post('/delete_unit', 'UnitController@delete')->name('admin.delete_unit');

        Route::get('/attribute', 'AttributeController@index');
        Route::post('/create_attribute', 'AttributeController@store')->name('admin.create_attribute.submit');
        Route::get('/edit_attribute', 'AttributeController@edit');
        Route::post('/update_attribute', 'AttributeController@update')->name('admin.update_attribute.submit');
        Route::post('/delete_attribute', 'AttributeController@delete')->name('admin.delete_attribute');

        Route::get('/printer', 'PrinterController@index');
        Route::post('/create_printer', 'PrinterController@store')->name('admin.create_printer.submit');
        Route::get('/edit_printer', 'PrinterController@edit');
        Route::post('/update_printer', 'PrinterController@update')->name('admin.update_printer.submit');
        Route::post('/delete_printer', 'PrinterController@delete')->name('admin.delete_printer');

        Route::get('/tablecat', 'TableCatController@index');
        Route::post('/create_tablecat', 'TableCatController@store')->name('admin.create_tablecat.submit');
        Route::get('/edit_tablecat', 'TableCatController@edit');
        Route::post('/update_tablecat', 'TableCatController@update')->name('admin.update_tablecat.submit');
        Route::post('/delete_tablecat', 'TableCatController@delete')->name('admin.delete_tablecat');

        Route::get('/table', 'TableController@index');
        Route::post('/create_table', 'TableController@store')->name('admin.create_table.submit');
        Route::get('/edit_table', 'TableController@edit');
        Route::post('/update_table', 'TableController@update')->name('admin.update_table.submit');
        Route::post('/delete_table', 'TableController@delete')->name('admin.delete_table');

        Route::get('/discount', 'DiscountsController@index');
        Route::post('/create_discount', 'DiscountsController@store')->name('admin.create_discount.submit');
        Route::get('/edit_discount', 'DiscountsController@edit');
        Route::post('/update_discount', 'DiscountsController@update')->name('admin.update_discount.submit');
        Route::post('/delete_discount', 'DiscountsController@delete')->name('admin.delete_discount');

        Route::get('/publisher', 'PublisherController@index');
        Route::post('/create_publisher', 'PublisherController@store')->name('admin.create_publisher.submit');
        Route::get('/edit_publisher', 'PublisherController@edit');
        Route::post('/update_publisher', 'PublisherController@update')->name('admin.update_publisher.submit');
        Route::post('/delete_publisher', 'PublisherController@delete')->name('admin.delete_publisher');

        Route::get('/level', 'LevelController@index');
        Route::post('/create_level', 'LevelController@store')->name('admin.create_level.submit');
        Route::get('/edit_level', 'LevelController@edit');
        Route::post('/update_level', 'LevelController@update')->name('admin.update_level.submit');
        Route::post('/delete_level', 'LevelController@delete')->name('admin.delete_level');

        Route::get('/subject', 'SubjectController@index');
        Route::post('/create_subject', 'SubjectController@store')->name('admin.create_subject.submit');
        Route::get('/edit_subject', 'SubjectController@edit');
        Route::post('/update_subject', 'SubjectController@update')->name('admin.update_subject.submit');
        Route::post('/delete_subject', 'SubjectController@delete')->name('admin.delete_subject');

        Route::get('/partners', 'PartnerController@index');
        Route::post('/create_partner', 'PartnerController@store')->name('admin.create_partner.submit');
        Route::get('/edit_partner', 'PartnerController@edit');
        Route::post('/update_partner', 'PartnerController@update')->name('admin.update_partner.submit');
        Route::post('/delete_partner', 'PartnerController@delete')->name('admin.delete_partner');

        Route::get('/languages', 'LangController@index');
        Route::post('/create_language', 'LangController@store')->name('admin.create_language.submit');
        Route::get('/edit_language', 'LangController@edit');
        Route::post('/update_language', 'LangController@update')->name('admin.update_language.submit');
        Route::post('/delete_language', 'LangController@delete')->name('admin.delete_language');


        Route::get('/branch', 'BranchController@index');
        Route::post('/create_branch', 'BranchController@store')->name('admin.create_branch.submit');
        Route::get('/edit_branch', 'BranchController@edit');
        Route::post('/update_branch', 'BranchController@update')->name('admin.update_branch.submit');
        Route::post('/delete_branch', 'BranchController@delete')->name('admin.delete_branch');

//Vouchers - السندات
        Route::get('/voucher', 'VouchersController@index');
        Route::post('/create_voucher', 'VouchersController@store')->name('admin.create_voucher.submit');
        Route::post('/delete_voucher', 'VouchersController@delete')->name('admin.delete_voucher');

        
        Route::get('/roles', 'RoleController@index');
        Route::get('/show_role/{id}', 'RoleController@show');
        Route::get('/create_role', 'RoleController@create');
        Route::post('/create_role', 'RoleController@store')->name('admin.create_role.submit');
        Route::get('/edit_role/{id}', 'RoleController@edit');
        Route::post('/edit_role', 'RoleController@update')->name('admin.edit_role.submit');
        Route::post('/delete_role', 'RoleController@delete')->name('admin.delete_role');

    });

//    BranchUser
    Route::group(['middleware' => ['BranchUser']], function () {


        Route::get('/stocks', 'StockController@index');
        Route::get('/show_stock/{id}', 'StockController@show');
        Route::get('/barcode_stock/{id}', 'StockController@barcode');
        Route::get('/barcode_purchas/{id}', 'StockController@purchasbarcode');
        Route::get('/create_stock', 'StockController@create');
        Route::post('/create_stock', 'StockController@store')->name('admin.create_stock.submit');
        Route::get('/edit_stock', 'StockController@edit');
        Route::post('/edit_stock', 'StockController@update')->name('admin.edit_stock.submit');
        Route::post('/delete_stock', 'StockController@delete')->name('admin.delete_stock');
        Route::get('/reviews/{id}', 'StockController@reviews');
        Route::get('/filter_stock', 'StockController@filter')->name('admin.filter_stock.submit');
        // Route::get('/filter_stock', 'StockController@index');

        Route::get('/purchass', 'PurchasController@index');
        Route::get('purchas_datatable', 'PurchasController@datatable')->name('purchas.datatable.data');
        Route::post('/purchass', 'PurchasController@filter')->name('admin.filter_purchas.submit');
        Route::get('/show_purchas/{id}', 'PurchasController@show');
        Route::get('/create_purchas', 'PurchasController@create');
        Route::post('/create_purchas', 'PurchasController@store')->name('admin.create_purchas.submit');
        Route::get('/edit_purchas/{id}', 'PurchasController@edit');
        Route::post('/edit_purchas', 'PurchasController@update')->name('admin.edit_purchas.submit');
        Route::post('/delete_purchas', 'PurchasController@delete')->name('admin.delete_purchas');
        Route::get('/return_purchas/{id}', 'PurchasController@return_purchas');
        Route::get('/get_supplier', 'PurchasController@get_supplier');
        Route::get('/get_p_product', 'PurchasController@get_p_product');
        Route::post('/add-cart-purchas', 'PurchasController@addCartPurchas');
        Route::get('/deletpurchasecart', 'PurchasController@deletpurchasecart');
        Route::get('/copyprice', 'PurchasController@copyprice');
        Route::get('/alldeletpurchasecart', 'PurchasController@alldeletpurchasecart');
        Route::post('/purchase-cashier', 'PurchasController@store')->name('admin.purchase.submit');
        Route::get('/print_purchas/{id}', 'PurchasController@print_purchas');

        Route::post('liveitemSearch', 'PurchasController@liveitemSearch')->name('liveitemSearch');

        Route::get('/cashier/{id?}', 'OrderController@create');
        Route::get('/client_data', 'OrderController@client_data');
        Route::post('/addclientorder', 'OrderController@addClientOrder');
        Route::get('/addcartorder', 'OrderController@addCartOrder');
        Route::post('/editcartorder', 'OrderController@editcartorder');
        Route::get('/get_order_product', 'OrderController@get_order_product');
        Route::get('/add_discount', 'OrderController@add_discount');
        Route::get('/DeleteCart', 'OrderController@DeleteCart');
        Route::get('/alldeletordercart', 'OrderController@alldeletordercart');
        Route::post('/cashier', 'OrderController@store')->name('admin.cashier.submit');
        Route::get('/print_order/{id}', 'OrderController@print_order');
        Route::get('/orders/{id?}', 'OrderController@index');
        Route::get('orders_datatable', 'OrderController@datatable')->name('orders.datatable.data');
        Route::post('/orders', 'OrderController@filter')->name('admin.filter_orders.submit');
        Route::get('/show_order/{id}', 'OrderController@show');
        Route::get('/return_order/{id}', 'OrderController@return_order');

        Route::get('/category_product/{id}/{branch_id}', 'OrderController@category_data');
        Route::get('/product-admin-modal', 'OrderController@Product');


        Route::get('/cashier_today/{id?}', 'OrderController@BranchOrderToday');
        Route::get('/edit_order/{id}', 'OrderController@edit');
        Route::post('/edit_order', 'OrderController@update')->name('admin.edit_order.submit');
        Route::post('/delete_order', 'OrderController@delete')->name('admin.delete_order');
        Route::post('/delete_orderStatus', 'OrderController@delete_Status')->name('admin.delete_orderStatus');

        Route::get('/kitchen/{id?}', 'kitchenController@kitchen');
        Route::get('/kitchen_data/{id?}', 'kitchenController@kitchen_data');
        Route::get('/order_confirmed/{id}', 'kitchenController@orderConfirmed');


        Route::get('/deligate/{id?}', 'DeligateController@index');
        Route::post('/create_deligate', 'DeligateController@store')->name('admin.create_deligate.submit');
        Route::get('/edit_deligate', 'DeligateController@edit');
        Route::post('/update_deligate', 'DeligateController@update')->name('admin.update_deligate.submit');
        Route::post('/delete_deligate', 'DeligateController@delete')->name('admin.delete_deligate');


        Route::get('/inventory', 'InventoryController@index');
        Route::post('/create_inventory', 'InventoryController@store');
        Route::post('/delete_inventory', 'InventoryController@delete')->name('admin.delete_inventory');
//details
        Route::get('/inventory/{id}', 'InventoryController@show');
        Route::get('/add_inventory', 'InventoryController@add_inventory');
        Route::get('/editQty', 'InventoryController@editQty');


//        transfer
        Route::get('/transfer', 'TransferPermissionController@index');
        Route::post('/transfer', 'TransferPermissionController@filter')->name('admin.filter_transfer.submit');
        Route::get('/add-transfer', 'TransferPermissionController@create');
        Route::post('/add-transfer', 'TransferPermissionController@store')->name('admin.transfer.submit');
        Route::get('/addcarttransfer', 'TransferPermissionController@addCartOrder');
        Route::get('/DeleteTransfer', 'TransferPermissionController@DeleteCart');
        Route::get('/get_transfer_product', 'TransferPermissionController@get_order_product');
        Route::post('/edittransfer', 'TransferPermissionController@editcartorder');

        Route::get('/damageditem', 'DamagedItemController@index');
        Route::get('/sales_damageditem/{id}', 'DamagedItemController@sales');
        Route::post('/create_damageditem', 'DamagedItemController@store')->name('admin.create_damageditem.submit');
        Route::get('/edit_damageditem', 'DamagedItemController@edit');
        Route::post('/update_damageditem', 'DamagedItemController@update')->name('admin.update_damageditem.submit');
        Route::post('/delete_damageditem', 'DamagedItemController@delete')->name('admin.delete_damageditem');
        Route::get('/filter_damageditem', 'DamagedItemController@filter')->name('admin.filter_damageditem.submit');

        Route::get('/deficiencies', 'DeficienciesController@index');
        Route::get('/sales_deficiencies/{id}', 'DeficienciesController@sales');
        Route::post('/create_deficiencies', 'DeficienciesController@store')->name('admin.create_deficiencies.submit');
        Route::get('/edit_deficiencies', 'DeficienciesController@edit');
        Route::post('/update_deficiencies', 'DeficienciesController@update')->name('admin.update_deficiencies.submit');
        Route::post('/delete_deficiencies', 'DeficienciesController@delete')->name('admin.delete_deficiencies');
        Route::get('/filter_deficiencies', 'DeficienciesController@filter')->name('admin.filter_deficiencies.submit');


        Route::get('/tax-report', 'ReportController@TaxReport');
        Route::get('/sales-inv-report', 'ReportController@saleinvReport');
        Route::get('/print-tax', 'ReportController@PrintTaxReport');
        Route::get('/sales-report', 'ReportController@SellReport');
        Route::get('/item-report/{id}', 'ReportController@ItemReport');
        Route::get('/bonus-report', 'ReportController@BonusReport');



    });
});




