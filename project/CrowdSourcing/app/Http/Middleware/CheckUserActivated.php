<?php

namespace App\Http\Middleware;
use App\Preferences;
use Closure;

class CheckUserActivated
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
       // if((Preferences::where('name','validation')->first()->enable)){
  /*      if(!$request->session()->has($request->user()->id))
{
        $request->user()->activated = true;
            $request->user()->save();
}*/
        if (!$request->user()->activated) {
            return redirect('/not-enabled');
        }
        return $next($request);
    }
}
