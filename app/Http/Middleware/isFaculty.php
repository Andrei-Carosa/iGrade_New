<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isFaculty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() ){

            //check user if active
            if(Auth::user()->admin_account){

                redirect()->back();

            }

            //check user if faculty
            if(Auth::user()->type == 1 || Auth::user()->type == 3 ){

                return $next($request);

            }

        }else{

            abort(401, 'Access Denied, Please Login First.');

        }
    }
}
