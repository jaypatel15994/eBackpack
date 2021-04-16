<?php

namespace App\Http\Middleware;

use Auth,Closure;
use Illuminate\Http\Request;

class CheckUserType
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
        if(Auth::check()){
            if(Auth::user()->user_type == '1'){
                return redirect('/');
            }
        }
        return $next($request);
    }
}
