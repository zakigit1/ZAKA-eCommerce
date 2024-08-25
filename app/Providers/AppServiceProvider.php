<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View ;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Paginator::useBootstrap();

        // ? Set time zone : 
        
        $generalSettings = GeneralSetting::first();

        Config::set('app.timezone',$generalSettings->time_zone);
        
        
        // ? Share currency icons in all view project : 
        // the  "*" signs mean all view files if you want to do just for admin view file 'admin.*' . this is just example 
        view()->composer('*', function ($view) use($generalSettings) { 
            return $view->with('settings', $generalSettings);
        });
    }   
}
