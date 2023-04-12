<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        App::setLocale('ar');

        $Setting = Setting::find(1);
        view()->share('Settings', $Setting);

        $about = Page::find(1); //about us
        view()->share('Pages', $about);

        view()->composer('*', function($view)
        {

            if (isset(Auth::user()->type)) {
                if(Auth::user()->type == 1) {
                    $notification = Notification::where('bdg',1)->where('branch_id ', Auth::user()->branch_id)->get();
                    $view->with('notifications', $notification); 
                } else {
                    $notification = Notification::where('bdg',1)->get();
                    $view->with('notifications', $notification); 
                }
            }
               
        });

    }
}
