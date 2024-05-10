<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Workshop;
class firststage
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
        if(session('stage') != 0)
            return redirect()->route('participant.chooseGroup');
        return $next($request);
    }
}
