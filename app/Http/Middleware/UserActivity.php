<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $expire = now()->addMinutes(2); /* keep online for 2 min */
            Cache::put('user-is-online-' .auth()->user()->NidUser,true,$expire);
            /* last seen */
            // User::all()->where('NidUser','=',auth()->user()->NidUser)->update(['last_seen' => now()]);
            User::where('NidUser',auth()->user()->NidUser)->update(['last_seen' => now()]);
        }
        // User::where('UserName',auth()->user()->UserName)->update(['last_seen' => now()]);
        return $next($request);
    }
}
