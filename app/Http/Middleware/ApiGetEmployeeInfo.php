<?php

namespace App\Http\Middleware;

use Closure;

class ApiGetEmployeeInfo
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

        // dd($request);
        if ($request->header('authorization') != env('API_KEY')) {
            return response()->json('Unauthorized', 401);
        }

        return $next($request);
    }
}
