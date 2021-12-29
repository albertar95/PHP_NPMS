<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class logoutUsers
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
        $user = Auth::user();
        if (! empty(auth()->user()->Force_logout))
        {
            if(auth()->user()->Force_logout)
            {
                User::where('NidUser',auth()->user()->NidUser)->update(['Force_logout' => false]);
                Auth::logout();
                return redirect()->route('login');
            }
        }
        return $next($request);
    }
}
