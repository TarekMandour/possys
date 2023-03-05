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

    }
}
