<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Cookie::get('NPMS_Permissions') != null)
        {
            $CurrentUserPermissions = Crypt::decrypt(Cookie::get('NPMS_Permissions'),false);
            view()->share('CurrentUserPermissions',str_replace('|','',substr($CurrentUserPermissions,strpos($CurrentUserPermissions,'|'),strlen($CurrentUserPermissions)-strpos($CurrentUserPermissions,'|'))));
        }
    }
}
