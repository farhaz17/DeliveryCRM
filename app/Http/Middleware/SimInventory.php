<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SimInventory
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

       if(in_array(16, Auth::user()->user_group_id) || in_array(1, Auth::user()->user_group_id)){
           return $next($request);
       }

        $message = [
            'message' => 'Access Denied',
            'alert-type' => 'error',
            'error' => '',
        ];

        return  redirect()->back()->with($message);

    }
}
