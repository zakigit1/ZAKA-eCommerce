<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use App\Models\LogoSetting;
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

       
       $generalSettings = GeneralSetting::first();
       $logoSettings = LogoSetting::first();
       
       // ? Set time zone : 
        Config::set('app.timezone',$generalSettings->time_zone);
        
        
        // ? Share currency icons in all view project : 
        // the  "*" signs mean all view files if you want to do just for admin view file 'admin.*' . this is just example 
        view()->composer('*', function ($view) use($generalSettings ,$logoSettings) { 
            $view->with(['settings' => $generalSettings , 'logoSettings'=>$logoSettings ]);
        });
    }   
}
