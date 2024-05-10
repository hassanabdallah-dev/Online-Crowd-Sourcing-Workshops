<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Workshop;
class active_workshop2
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
        $work = new Workshop();
        $work->setConnection('mysql2');
        if(!$work->where([
            'monitor_id'=>auth()->user()->id,
            'active' => true
        ])->exists())
            return redirect()->route('home');
        return $next($request);
    }
}
