<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtp;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function forget_password_msp(Request $request)
    {

//        $response = [];
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";

                foreach ($validate->all() as $error){
                    $message_error .= $error;
                }
                $validate = $validator->errors();
                $message="Email is required";
                return view('auth.passwords.reset')->with(compact('message'));
            }
            $user=User::where('email', '=', trim($request->input('email')))->first();

            if ($user === null) {
                $message='User Not Exist';
                return view('auth.passwords.reset')->with(compact('message'));
            }
            $otp = rand(1111,9999);

            $obj=User::find($user->id);
            $obj->otp = $otp;
            $obj->save();
            Mail::to($request->input('email'))->send(new SendOtp($obj));
            $email=$request->input('email');
            return view('auth.passwords.msp_otp')->with(compact('email'));
        } catch (\Illuminate\Database\QueryException $e) {
            $message="Something Went wrong";
            return view('auth.passwords.reset')->with(compact('message'));
        }
    }


    public function update_password_msp(Request $request)
    {
        $email=$request->input('email');
        $otp=$request->input('otp');

            $user=User::where('otp', '=', trim($request->input('otp')))
                ->where('email', '=', trim($request->input('email')))
                ->first();

            if ( $user === null) {
                $message='Wrong OTP';
                return view('auth.passwords.msp_otp')->with(compact('message','email'));
            }

        return view('auth.passwords.reset_password')->with(compact('email','otp'));
    }


    public function update_password_final(Request $request)
    {
        $otp=$request->input('otp');
        $email=$request->input('email');
        $password=$request->input('password');
        $confirm_password =$request->input('confirm_password');

        if ($password != $confirm_password) {
            $message='Password and Confirm Password Does Not Matach';
            return view('auth.passwords.reset_password')->with(compact('message','email','otp'));
        }

        try {

            $user=User::where('otp', '=', trim($request->input('otp')))
                ->where('email', '=', trim($request->input('email')))
                ->first();
            if ($user === null) {
                $message='Something went wrong';
                return view('auth.passwords.reset_password')->with(compact('message','email','otp'));
            }
            $obj=User::find($user->id);
            $obj->password = bcrypt($request->input('password'));
            $obj->save();

            $message='Password Updated Successfully';
            return view('auth.login')->with(compact('message'));

            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Something Went wrong';

            return response()->json($response);
        }
    }




}
