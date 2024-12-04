<?php

namespace App\Providers;

use App\Models\EmailConfiguration;
use App\Models\GeneralSetting;
use App\Models\LogoSetting;
use App\Models\PusherConfiguration;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\QueryException;

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
        $pusherConfig = $this->pusherConfiguration();

    
        // dd($pusherConfig);
        // dd(Config::get('broadcasting'));

        ########################################################################################################

        // $generalSettings = GeneralSetting::first();
        // $logoSettings = LogoSetting::first();

        $generalSettings = $this->getGeneralSettings();
        $logoSettings = $this->getLogoSettings();


        // ? Set time zone : search how the time zone ? 
        Config::set('app.timezone',$generalSettings->time_zone);


        // ? Share currency icons in all view project : 
        // the  "*" signs mean all view files if you want to do just for admin view file 'admin.*' . this is just example 
        view()->composer('*', function ($view) use($generalSettings ,$logoSettings ,$pusherConfig) { 
            $view->with(['settings' => $generalSettings , 'logoSettings'=>$logoSettings ,'pusherConfig'=>$pusherConfig]);
        });
        
    }   



    private function emailConfiguration(){

        try {
            $EmailConfig = EmailConfiguration::first();

            Config::set('mail.mailers.smtp.host',$EmailConfig->host);
            Config::set('mail.mailers.smtp.port',$EmailConfig->port);
            Config::set('mail.mailers.smtp.encryption',$EmailConfig->encryption);
            Config::set('mail.mailers.smtp.username',$EmailConfig->username);
            Config::set('mail.mailers.smtp.password',$EmailConfig->password);
            Config::set('mail.from.address',$EmailConfig->email);
            Config::set('mail.from.name',$EmailConfig->name);
        } catch (QueryException $e) {
            // Handle the exception, for example, by setting default mail configuration
            Config::set('mail.mailers.smtp.host', env('MAIL_HOST', 'smtp.mailgun.org'));
            Config::set('mail.mailers.smtp.port', env('MAIL_PORT', 587));
            Config::set('mail.mailers.smtp.encryption', env('MAIL_ENCRYPTION', 'tls'));
            Config::set('mail.mailers.smtp.username', env('MAIL_USERNAME'));
            Config::set('mail.mailers.smtp.password', env('MAIL_PASSWORD'));
            Config::set('mail.from.address', env('MAIL_FROM_ADDRESS', 'hello@example.com'));
            Config::set('mail.from.name', env('MAIL_FROM_NAME', 'Example'));
        }
    }


    private function pusherConfiguration()
    {
        try {
            $pusherConfig = PusherConfiguration::first();

            Config::set('broadcasting.connections.pusher.key', $pusherConfig->pusher_key);
            Config::set('broadcasting.connections.pusher.secret', $pusherConfig->pusher_secret);
            Config::set('broadcasting.connections.pusher.app_id', $pusherConfig->pusher_app_id);
            Config::set('broadcasting.connections.pusher.options.host', "api-" . $pusherConfig->pusher_cluster . ".pusher.com");

            return $pusherConfig;

        } catch (QueryException $e) {
            // Handle the exception, for example, by setting default pusher configuration
            Config::set('broadcasting.connections.pusher.key', env('PUSHER_APP_KEY'));
            Config::set('broadcasting.connections.pusher.secret', env('PUSHER_APP_SECRET'));
            Config::set('broadcasting.connections.pusher.app_id', env('PUSHER_APP_ID'));
            Config::set('broadcasting.connections.pusher.options.host', env('PUSHER_APP_CLUSTER'));

            return new PusherConfiguration();
        }
    }

    private function getGeneralSettings()
    {
        try {
            return GeneralSetting::first();
        } catch (QueryException $e) {
            // Handle the exception, for example, by setting default general settings
            return new GeneralSetting();
        }
    }

    private function getLogoSettings()
    {
        try {
            return LogoSetting::first();
        } catch (QueryException $e) {
            // Handle the exception, for example, by setting default logo settings
            return new LogoSetting();
        }
    }

}
