<?php

namespace App\Http\Controllers\Api\Referal;

use App\Model\Assign\AssignPlateform;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Guest\Career;
use App\Model\Passport\Passport;
use App\Model\Passport\RenewPassport;
use App\Model\Referal\Referal;
use App\Model\RiderProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;

class RefrealApiController extends Controller
{
    //
    public function get_referal(Request $request)
    {

        if($request->input('license_status')==1){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'passport_no' => 'required',
                'phone_no' => 'required',
                'whatsapp_no' => 'required',
                'driving_license' => 'required',
                'driving_attachment' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $response['code'] = 2;
                $response['message'] = $validate->first();
                return response()->json($response);
            }
        }
        else{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'passport_no' => 'required',
                'phone_no' => 'required',
                'whatsapp_no' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $response['code'] = 2;
                $response['message'] = $validate->first();
                return response()->json($response);
            }
        }

        $pass_no=$request->input('passport_no');
        $driving_no=$request->input('driving_license');
        $referal_details=Referal::where('passport_no',$pass_no)->count();
        $driving_license_ref=Referal::where('driving_license',$driving_no)->whereNotNull('driving_license')->count();
        $career_details=Career::where('passport_no',$pass_no)->count();
        $passport_details=Passport::where('passport_no',$pass_no)->count();
        $older_passport_details=RenewPassport::where('renew_passport_number',$pass_no)->count();
        $driving_lincense=DrivingLicense::where('license_number',$driving_no)->count();

        if ($referal_details>=1){
            $response['code'] = 2;
            $response['message'] = "This User Already Referred !";
            return response()->json($response);
        }
        if ($career_details>=1){
            $response['code'] = 2;
            $response['message'] = "This User Already Applied for Job!";
            return response()->json($response);
        }
        if ($passport_details>=1){
            $response['code'] = 2;
            $response['message'] = "This User Already Exist !";
            return response()->json($response);
        }
        if ($older_passport_details>=1){
            $response['code'] = 2;
            $response['message'] = "This User Already Exist !";
            return response()->json($response);
        }
        if ($driving_lincense>=1 ){
            $response['code'] = 2;
            $response['message'] = "This Driving License Already Exist !";
            return response()->json($response);
        }
        if ($driving_license_ref>=1){
            $response['code'] = 2;
            $response['message'] = "This Driving License Already Exist !";
            return response()->json($response);
        }




       $driving_attach= $request->input('driving_attachment');


          if (isset($_FILES['driving_attachment']))
        {

        $current_timestamp = Carbon::now()->timestamp;
        if (!file_exists('../public/assets/upload/referals/')) {
            mkdir('../public/assets/upload/referals/', 0777, true);
        }

        $ext = pathinfo($_FILES['driving_attachment']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $current_timestamp . '.' . $ext;

        move_uploaded_file($_FILES["driving_attachment"]["tmp_name"], '../public/assets/upload/referals/' . $file_name);
        $file_path = 'assets/upload/referals/' . $file_name;
        }


        $response = [];
        try {

            $riderProfile  = RiderProfile::where('user_id','=',Auth::user()->id)->first();
            $user_passport_id = $riderProfile->passport_id;
            $obj = new Referal();
            $obj->passport_id = $user_passport_id;
            $obj->name =  $request->input('name');
            $obj->passport_no = $request->input('passport_no');
            $obj->driving_license = $request->input('driving_license');
            $obj->driving_attachment = isset($file_path)?$file_path:null;
            $obj->phone_no = $request->input('phone_no');
            $obj->whatsapp_no = $request->input('whatsapp_no');
            //status by default pending '0'
            //creadit amount default null
            $obj->save();
            $response['code'] = 1;
            $response['message'] = 'Your Referral Added Successfully!';
            return response()->json($response);
        }
        catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Some thing went wrong';
            return response()->json($response);
        }
}


    public  function get_referal_history(){
        $riderProfile  = RiderProfile::where('user_id','=',Auth::user()->id)->first();
        $passport_id=$riderProfile->passport_id;

        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->where('interview_status','=','0')
//            ->where('careers.refer_by','=',$passport_id)
            ->pluck('career_id')
            ->toArray();


        $referals=  Career::where('refer_by','=',$passport_id)
            ->where(function ($query) {
                $query->where('hire_status', '=', 0)
                    ->orwhereNull('hire_status');
            })
            ->whereNotIn('id',$create_interviews)
            ->get();


        $referal_array = array();
        foreach ($referals as $row) {
            $status=$row->applicant_status;
            $credit_status_val= 0;

            if ($credit_status_val =='0'){
                $credit_status='No Reward Yet!';
            }
            else if ($credit_status_val=='1'){
                $credit_status='Reward Collectable!';
            }
            else {
                $credit_status='Reward Collected!';
            }
            $ref_params = array(
                'name' =>  $row->name,
                'passport_no' => $row->passport_no,
                'driving_license' => $row->driving_license,
                'driving_attachment' => isset($row->driving_attachment)?$row->driving_attachment:"N/A",
                'status' => $status,
                'credit_status' => $credit_status,
                'credit_status_val' => $credit_status_val,
                'phone_no' => $row->phone,
            );
            $referal_array [] = $ref_params;
        }

        $referal_interview = Career::whereNotNull('refer_by')
//            ->where(function ($query) {
//                $query->where('hire_status', '!=', 0)
////                    ->orwhereNull('hire_status');
//            })
            ->where('hire_status', '!=', 0)
            ->where('refer_by','=',$passport_id)
            ->whereIn('id',$create_interviews)->get();


        foreach ($referal_interview as $row) {
            $status= 1;
            $credit_status_val= 0;

            if ($credit_status_val =='0'){
                $credit_status='No Reward Yet!';
            }
            else if ($credit_status_val=='1'){
                $credit_status='Reward Collectable!';
            }
            else {
                $credit_status='Reward Collected!';
            }
            $ref_params = array(
                'name' =>  $row->name,
                'passport_no' => $row->passport_no,
                'driving_license' => $row->driving_license,
                'driving_attachment' => isset($row->driving_attachment)?$row->driving_attachment:"N/A",
                'status' => $status,
                'credit_status' => $credit_status,
                'credit_status_val' => $credit_status_val,
                'phone_no' => $row->phone,
            );
            $referal_array [] = $ref_params;
        }

        $hired = Career::whereNotNull('refer_by')
            ->where(function ($query) {
                $query->where('hire_status', '=', 0)
                    ->orwhereNull('hire_status');
            })
            ->whereIn('id',$create_interviews)->get();


        $passports = AssignPlateform::where('status','=','1')->pluck('passport_id')->toArray();

        $careers_id = Passport::whereIn('id',$passports)->pluck('career_id')->toArray();

        $referals_hired = Career::where('refer_by','=',$passport_id)->where('hire_status','=','1')->whereIn('id',$careers_id)->get();


        foreach ($referals_hired as $row) {
            $status= 3;
            $credit_status_val= 3;

            if ($credit_status_val =='0'){
                $credit_status='No Reward Yet!';
            }
            else if ($credit_status_val=='1'){
                $credit_status='Reward Collectable!';
            }
            else {
                $credit_status='Reward Collected!';
            }
            $ref_params = array(
                'name' =>  $row->name,
                'passport_no' => $row->passport_no,
                'driving_license' => $row->driving_license,
                'driving_attachment' => isset($row->driving_attachment)?$row->driving_attachment:"N/A",
                'status' => $status,
                'credit_status' => $credit_status,
                'credit_status_val' => $credit_status_val,
                'phone_no' => $row->phone,
            );
            $referal_array [] = $ref_params;
        }

        return response()->json(['data'=>$referal_array], 200, [], JSON_NUMERIC_CHECK);


    }
}
