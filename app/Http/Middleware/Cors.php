<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            // ->header('Access-Control-Allow-Origin', 'https://zonedeliveryservices.com/career/career-form.html')
            // ->header('Access-Control-Allow-Origin', 'https://zonedeliveryservices.com')
            // ->header('Access-Control-Allow-Origin', 'http://192.168.2.174:8080/career-form/career-form.html')
            // ->header('Access-Control-Allow-Origin', 'http://localhost/zone_repair/public/vendor_registration')

            // ->header('Access-Control-Allow-Origin', 'http://localhost/zone_repair/public/get_full_job_detail2')
            // ->header('Access-Control-Allow-Origin', 'http://localhost/zone_repair/public/apply_store_2')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}
