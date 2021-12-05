<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class DcMemberLoginCheck
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
        if(isset($request->email) && isset($request->password)){

            $user = User::where('email','=',$request->email)->first();

            if(isset($user->member_user)){

                if($user->member_user->status=="0"){
                    $message = [
                        'message' => "Your account is temporary blocked please contact your manager.!",
                        'alert-type' => 'error',
                        'error' => 'df'
                    ];

                    return  redirect()->back()->with($message);
//                    return redirect('/locint')->with(with($message));
                    dd($message);
                }
            }

        }

        return $next($request);
    }
}
