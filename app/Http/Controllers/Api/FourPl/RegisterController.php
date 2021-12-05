<?php

namespace App\Http\Controllers\Api\FourPL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\FourPlRegisterEmail;
use App\Model\FourPl\FourPlUser;
use App\User;
use App\Model\Master\FourPl;
use Mail;
use Hash;
use Auth;
use DB;

class RegisterController extends Controller
{
    public function register(Request $request) {

        $vendor = User::where('email', $request->email)->first();
        if($vendor) {
            $account = FourPlUser::where('user_id', $vendor->id)->first();
            if($account->activated == 1) {
                $data = [
                    'response' => 'account activated',
                    'code' => 202,
                ];
            }else{
                $otp = mt_rand(1000,9999);
                FourPlUser::where('user_id', $vendor->id)->update(['otp' => $otp]);
                \Mail::to($request->email)->send(new FourPlRegisterEmail($otp));
                $data = [
                    'response' => 'account not activated',
                    'code' => 201,
                    'otp' => $otp,
                    'id' => $account->id,
                ];
            }
            return response()->json($data, 200);
        }

        DB::beginTransaction();
        try {

            $otp = mt_rand(1000,9999);

            $data = new User();
            $data->email = $request->email;
            $data->password = trim(bcrypt($request->password));
            $data->user_group_id = json_encode(["21"]);
            $data->save();

            $obj = new FourPlUser();
            $obj->user_id = $data->id;
            $obj->company_name = $request->company_name;
            $obj->phone = $request->phone;
            $obj->otp = $otp;
            $obj->save();

            \Mail::to($request->email)->send(new FourPlRegisterEmail($otp));
            $data = [
                'response' => 'success',
                'code' => 200,
                'otp' => $otp,
                'id' => $obj->id,
            ];

            DB::commit();
        }
        catch(\Exception $e) {
            DB::rollback();
            \Log::channel('fourpl')->info($e);
            $data = [
                'response' => $e->getMessage(),
                'code' => 203,
            ];
        }

        // $details['email'] = $request->email;
        // dispatch(new \App\Jobs\SendFourPlEmailJob($details));

        // $details['email'] = 'farhaz171717@gmail.com';

        // // dispatch(new \App\Jobs\SendFourPlEmailJob($details));


        // $data = [
        //     'response' => 'success',
        //     'code' => 200,
        //     'mail' => '$mail',
        // ];

        return response()->json($data, 200);
    }

    public function verify(Request $request) {
        $otp = FourPlUser::where('id', $request->id)->update(['activated' => 1]);
        $data = [
            'response' => 'success',
            'code' => 200,
        ];
        return response()->json($data, 200);
    }

    public function login(Request $request) {

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $four_pl = FourPlUser::where('user_id', $user->id)->where('activated', 1)->first();
            if ($four_pl) {
                if (Hash::check($request->password, $user->password)) {
                // if ($request->password == $user->password) {
                    $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                    $response = ['token' => $token, 'email' => $user->email, 'id' => $user->id, 'username' => $user->company_name];
                    return response($response, 200);
                } else {
                    $response = ['message' => 'Password mismatch'];
                    return response($response, 200);
                }
            } else {
                $response = ['message' =>'Account Not activated'];
                return response($response, 200);
            }
        }
        else {
            $response = ['message' =>'User does not exist'];
            return response($response, 200);
        }


    }

    public function four_pl_details(Request $request) {
        $data = FourPl::where('user_id', $request->id)->first();
        $data = [
            'data' => $data,
            'response' => 'success',
            'code' => 200,
        ];
        return response()->json($data, 200);
    }

    public function four_pl_resubmit(Request $request) {
        $update_data = FourPl::where('user_id', $request->id)->update(['status' => '', 'submit_status' => '']);
        $data = FourPl::where('user_id', $request->id)->first();
        $data = [
            'data' => $data,
            'response' => 'success',
            'code' => 200,
        ];
        return response()->json($data, 200);
    }

    public function forgot_password(Request $request) {

        $otp = mt_rand(1000,9999);
        $email = User::where('email', $request->email)->first();

        $update_otp = FourPlUser::where('user_id', $email->id)->update(['otp' => $otp]);

        if($email) {

            try {
                \Mail::to($request->email)->send(new FourPlRegisterEmail($otp));
                $data = [
                    'response' => 'success',
                    'code' => 200,
                    'otp' => $otp,
                    'id' => $email->id,
                ];
            }
            catch(\Exception $e) {
                $data = [
                    'response' => $e,
                    'code' => 201,
                ];
            }

            return response()->json($data, 200);
        }
        else{
            $data = [
                'data' => 2,
                'response' => 'No Email Found',
                'code' => 203,
            ];
            return response()->json($data, 200);
        }
    }

    public function password_reset(Request $request) {
        $data = User::where('id', $request->id)->update(['password' => trim(bcrypt($request->password))]);
        $data = [
            'response' => 'Successfully Updated',
            'code' => 200,
        ];
        return response()->json($data, 200);
    }

    public function test() {
        return "api";
    }

    public function logout(Request $request) {

        \DB::table('oauth_access_tokens')
        ->where('user_id', $request->id)
        ->update([
            'revoked' => true
        ]);

        $data = [
            'data' => 1,
            'response' => 'success',
            'code' => 200,
        ];
        return response()->json($data, 200);
    }

    public function auth(Request $request) {

        $four_pl = FourPl::where('user_id', $request->user_id)->where('status', 1)->first();
        if($four_pl) {
            $data = [
                'data' => 1,
                'approved' => 1,
                'response' => 'success',
                'code' => 200,
            ];
            return response()->json($data, 200);
        }

        $data = [
            'data' => 1,
            'approved' => 0,
            'response' => 'success',
            'code' => 200,
        ];
        return response()->json($data, 200);
    }

    public function approved_vendor(Request $request) {
        $four_pl = FourPl::where('user_id', $request->user_id)->where('status', 1)->first();
        if($four_pl) {
            $data = [
                'data' => 1,
                'response' => 'success',
                'code' => 200,
            ];
            return response()->json($data, 200);
        }

        $data = [
            'data' => 0,
            'response' => 'success',
            'code' => 200,
        ];
        return response()->json($data, 200);
    }
}
