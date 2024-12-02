<?php

namespace App\Providers;

use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherConfiguration;
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

        /* For pagination design  */
        Paginator::useBootstrap();

        ########################################################################################################

        /** Set SMTP Mail Configuration :  */
        $this->emailConfiguration();
        // dd(Config::get('mail'));
        
        ########################################################################################################
        
        /** Set Pusher Configuration :  */
        // $this->pusherConfiguration();

        $pusherConfig = PusherConfiguration::first();

        Config::set('broadcasting.connections.pusher.key',$pusherConfig->pusher_key);
        Config::set('broadcasting.connections.pusher.secret',$pusherConfig->pusher_secret);
        Config::set('broadcasting.connections.pusher.app_id',$pusherConfig->pusher_app_id);
        Config::set('broadcasting.connections.pusher.options.host',"api-".$pusherConfig->pusher_cluster.".pusher.com");
        // dd(Config::get('broadcasting'));

        ########################################################################################################

        $generalSettings = GeneralSetting::first();
        $logoSettings = LogoSetting::first();


        // ? Set time zone : search how the time zone ? 
        Config::set('app.timezone',$generalSettings->time_zone);


        // ? Share currency icons in all view project : 
        // the  "*" signs mean all view files if you want to do just for admin view file 'admin.*' . this is just example 
        view()->composer('*', function ($view) use($generalSettings ,$logoSettings,$pusherConfig) { 
            $view->with(['settings' => $generalSettings , 'logoSettings'=>$logoSettings ,'pusherConfig'=>$pusherConfig]);
        });
        
    }   



    public function emailConfiguration(){

        $EmailConfig = EmailConfiguration::first();

        Config::set('mail.mailers.smtp.host',$EmailConfig->host);
        Config::set('mail.mailers.smtp.port',$EmailConfig->port);
        Config::set('mail.mailers.smtp.encryption',$EmailConfig->encryption);
        Config::set('mail.mailers.smtp.username',$EmailConfig->username);
        Config::set('mail.mailers.smtp.password',$EmailConfig->password);
        Config::set('mail.from.address',$EmailConfig->email);
        Config::set('mail.from.name',$EmailConfig->name);
    }


    // public function pusherConfiguration(){

    //     $pusherConfig = PusherConfiguration::first();

    //     Config::set('broadcasting.connections.pusher.key',$pusherConfig->pusher_key);
    //     Config::set('broadcasting.connections.pusher.secret',$pusherConfig->pusher_secret);
    //     Config::set('broadcasting.connections.pusher.app_id',$pusherConfig->pusher_app_id);
    //     Config::set('broadcasting.connections.pusher.options.host',"api-".$pusherConfig->pusher_cluster.".pusher.com");
    // }

}
