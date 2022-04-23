<?php

namespace App\Providers;

use App\Models\Roles;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\ServiceProvider;
use PhpParser\ErrorHandler\Collecting;

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
            $rawVal = str_replace('|','',substr($CurrentUserPermissions,strpos($CurrentUserPermissions,'|'),strlen($CurrentUserPermissions)-strpos($CurrentUserPermissions,'|')));
            $row = explode('#',$rawVal);
            $AccessedEntities = new Collection();
            foreach ($row as $r)
            {
                $AccessedEntities->push(explode(',',$r)[0]);
            }
            $AccessedSub = new Collection();
            foreach ($row as $r)
            {
                $AccessedSub->push(["entity" => explode(',',$r)[0],"rowValue" => substr($r,2,strlen($r)-2)]);
            }
            // $AdminStatus = User::with('role')->where('NidUser','=',Auth::user()->NidUser)->get()->role->IsAdmin;
            $sharedData = array('UserAccessedEntities' => $AccessedEntities->toArray(),'UserAccessedSub' => $AccessedSub);
            view()->share('sharedData',$sharedData);
        }
        // try {
        //     if ($this->app->environment() !== 'test') {
        //         if(Settings::all()->where('SettingTitle','=','SessionSetting')->where('SettingKey','=','SessionTimeout')->count() > 0)
        //         config([
        //             'session.lifetime' => Settings::all()->where('SettingTitle','=','SessionSetting')->where('SettingKey','=','SessionTimeout')->firstOrFail()->SettingValue
        //         ]);
        //         if(Settings::all()->where('SettingTitle','=','BackupSetting')->where('SettingKey','=','BackupPath')->count() > 0)
        //         config([
        //             'filesystems.disks.alter.root' => Settings::all()->where('SettingTitle','=','BackupSetting')->where('SettingKey','=','BackupPath')->firstOrFail()->SettingValue
        //         ]);
        //       }
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }
}
