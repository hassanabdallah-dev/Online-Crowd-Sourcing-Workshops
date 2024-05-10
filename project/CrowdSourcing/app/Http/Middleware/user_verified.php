<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Preferences;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
class user_verified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->user()->hasRole('admin'))
        {
            $conn = auth()->user()->hasRole('monitor')?'mysql2':'mysql3';
            $pref = new Preferences();
            $pref->setConnection($conn);
            if($pref->where('name', 'email-verification')->where('enable',true)->exists()){
                return app(EnsureEmailIsVerified::class)->handle($request, function ($request) use ($next) {
                    //Put your awesome stuff there. Like:
                    return $next($request);
            });
            }
        }
        return $next($request);
    }
}
