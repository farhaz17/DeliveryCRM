<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendOtp;
use App\Model\ContactForm;
use App\Model\EmployeeMainMaster;
use App\Model\Passport\Passport;
use App\Model\Passport\RenewPassport;
use App\Model\RiderProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;
use Carbon\Carbon;

class RegisterController extends Controller
{


    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
        if ($validator->fails()) {

            $response['error'] = 1;
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

        $user = new User();
        $user->name= trim($request->input('name'));
        $user->email= trim($request->input('email'));
        $user->password=  trim(bcrypt($request->input('password')));
        $user->user_group_id=json_encode(["4"]);
        $user->save();

        $obj1=new RiderProfile();
        $obj1->user_id = $user->id;
        $obj1->save();
//        $accessToken = $user->createToken('authToken')->accessToken;
//
        $response['success'] = 1;
        $response['message'] = 'Registration Successful';

        return response()->json($response);

    }

    public function register_profile(Request $request)
    {


        $response = [];
        try {

            $master_data=Passport::where('passport_no', '=',trim($request->input('passport')))
                ->first();

            $renew_passport = RenewPassport::where('renew_passport_number','=',trim($request->input('passport')))->first();

                $validator = Validator::make($request->all(), [
//                    'name' => 'required',
//                    'passport' => 'required|unique:rider_profiles,passport_id',
//                    'zds_code' => 'required|unique:rider_profiles,zds_code',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                ]);
                if ($validator->fails()) {

                    $response['code'] = 2;
                    $response['message'] = $validator->errors()->first();
                    return response()->json($response);
                }

            if($renew_passport != null){

                $check_passport_data=RiderProfile::where('passport_id', '=',  $renew_passport->passport_id)->first();

//                dd($check_passport_data);
                if($check_passport_data == null){
                    $obj=new User();
//                $obj->name = $request->input('name');
                    $obj->email = $request->input('email');
                    $obj->user_group_id = json_encode(["4"]);
                    $obj->password = bcrypt(trim($request->input('password')));
                    $obj->save();


                    $obj1 = new RiderProfile();
//                $obj1->zds_code = $request->input('zds_code');
//                $obj1->passport = $request->input('passport');
                    $obj1->passport_id = $renew_passport->passport_id;
                    $obj1->user_id = $obj->id;
                    $obj1->save();

                    $response['code'] = 1;
                    $response['message'] = 'Registration Successful';

                    return response()->json($response);
                }
                else{
                    $response['code'] = 2;
                    $response['message'] = 'Passport no is already exist';

                    return response()->json($response);
                }

            }
            else if($master_data != null){

                $check_passport_data=RiderProfile::where('passport_id', '=',  $master_data->id)->first();

//                dd($check_passport_data);
                if($check_passport_data == null){
                    $obj=new User();
//                $obj->name = $request->input('name');
                    $obj->email = trim($request->input('email'));
                    $obj->user_group_id = json_encode(["4"]);
                    $obj->password = bcrypt(trim($request->input('password')));
                    $obj->save();


                    $obj1 = new RiderProfile();
//                $obj1->zds_code = $request->input('zds_code');
//                $obj1->passport = $request->input('passport');
                    $obj1->passport_id = $master_data->id;
                    $obj1->user_id = $obj->id;
                    $obj1->save();

                    $response['code'] = 1;
                    $response['message'] = 'Registration Successful';

                    return response()->json($response);
                }
                else{
                    $response['code'] = 2;
                    $response['message'] = 'Passport no is already exist';

                    return response()->json($response);
                }


            }
            else{
                $response['code'] = 3;
                $response['message'] = 'Passport no is wrong';

                return response()->json($response);
            }


        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 3;
            $response['message'] = 'Registration Failed';

            return response()->json($response);
        }
    }

    public function forget_password(Request $request)
    {
        $response = [];
        try {

            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);
            if ($validator->fails()) {

                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $user=User::where('email', '=', trim($request->input('email')))->first();

            if ($user === null) {
                $response['code'] = 2;
                $response['message'] = 'User Not Exist';

                return response()->json($response);
            }

            $otp = rand(1111,9999);

//            dd($otp);

            $obj=User::find($user->id);
            $obj->otp = $otp;
            $obj->save();

            Mail::to($request->input('email'))->send(new SendOtp($obj));

            $response['code'] = 1;
            $response['message'] = 'OTP Sent : Please check your email';

            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Something Went wrong';

            return response()->json($response);
        }
    }

    public function update_password(Request $request)
    {
        $response = [];
        try {

            $user=User::where('otp', '=', trim($request->input('otp')))
                ->where('email', '=', trim($request->input('email')))
                ->first();

            if ($user === null) {
                $response['code'] = 2;
                $response['message'] = 'Wrong OTP';

                return response()->json($response);
            }

            $response['code'] = 1;
            $response['message'] = 'Success';

            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Something Went wrong';

            return response()->json($response);
        }
    }

    public function update_password_final(Request $request)
    {
        $response = [];
        try {

            $user=User::where('otp', '=', trim($request->input('otp')))
                ->where('email', '=', trim($request->input('email')))
                ->first();

            if ($user === null) {
                $response['code'] = 2;
                $response['message'] = 'Something went wrong';

                return response()->json($response);
            }

            $obj=User::find($user->id);
            $obj->password = bcrypt($request->input('password'));
            $obj->save();


            $response['code'] = 1;
            $response['message'] = 'Password Updated Successfully';

            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Something Went wrong';

            return response()->json($response);
        }
    }

//    public function update_password_profile(Request $request)
//    {
//        $response = [];
//
//        $user = Auth::user();
//        $current_password = $request->input('current_password');
//        if (!Hash::check($current_password, $user->password)) {
//                $response['code'] = 2;
//                $response['message'] = 'Please enter the current password';
//                return response()->json($response);
//        }
//        else{
//            $user->fill([
//                'password' => Hash::make($request->password)
//            ])->save();
//
//            $response['code'] = 1;
//            $response['message'] = 'Password Updated Successfully';
//        }
//    }


    public function contact_admin(Request $request)
    {

        $response = [];
        try {

            $contact_exist = ContactForm::where('passport','=',trim($request->input('passport')))->where('email','=',trim($request->input('email')))->first();

            if($contact_exist == null){



                   $validator = Validator::make($request->all(), [
                       'name' => 'required',
                       'email' => 'required|email|unique:contact_forms,email',
                       'zds_code' => 'required',
                       'passport' => 'required',
                       'message' => 'required',
                   ]);
                   if ($validator->fails()) {

                       $response['code'] = 2;
                       $response['message'] = $validator->errors()->first();
                       return response()->json($response);
                   }

                   $obj=new ContactForm();
                   $obj->name = trim($request->input('name'));
                   $obj->email = trim($request->input('email'));
                   $obj->phone = trim($request->input('phone'));
                   $obj->zds_code = trim($request->input('zds_code'));
                   $obj->passport = trim($request->input('passport'));
                   $obj->message = trim($request->input('message'));
                   $obj->save();

                   $response['code'] = 1;
                   $response['message'] = 'Successfully Sent,We will update you soon';

                   return response()->json($response);


            }else{
                $response['code'] = 3;
                $response['message'] = "We already have your request, We will contact you soon";
                return response()->json($response);
            }



        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Sending failed,Try again later';

            return response()->json($response);
        }
    }

}
