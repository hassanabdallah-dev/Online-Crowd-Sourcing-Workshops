<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Workshop;
class participate_workshop
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
      /*  if(Gate::denies('active_workshop', $request->key))
            return redirect()->route('usermakekey');*/
            $work = new Workshop();
            $work->setConnection('mysql3');
        if(session('workshop_id') && $work->where([
            'id'=>session('workshop_id'),
            'active' => true
        ])->exists())
            return redirect()->route('home');
        return $next($request);
    }
}
