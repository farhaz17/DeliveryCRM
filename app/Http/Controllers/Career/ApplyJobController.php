<?php

namespace App\Http\Controllers\Career;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Guest\Career;
use App\Model\Passport\Passport;
use App\Model\Referal\Referal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApplyJobController extends Controller
{
    public function apply(Request $request) {

        // $message = [
        //     'message' => "You Cannot Apply",
        //     'alert-type' => 'error',
        //     'error' => ''
        // ];
        // return response()->json([
        //     'code' => "101",
        //     'message' => $message,
        // ]);
        if($request->token == "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq") {

            //dd($request->all());
            $response = [];
            $current_timestamp = Carbon::now()->timestamp;
    //        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'email',
                'phone' => 'required|unique:careers,phone',
                'whatsapp' => 'required|unique:careers,whatsapp',
                'promotion_type' => 'required',
                'nationality' => 'required',
            ]);

            if ($validator->fails()) {

                $response['message'] = $validator->errors()->first();
                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error',
                    'error' => ''
                ];

                return response()->json([
                    'code' => "101",
                    'message' => $message
                ]);
            }

            $full_number = preg_replace("/[\s-]/", "", $request->phone);
            $whatsapp_full_number = preg_replace("/[\s-]/", "", $request->whatsapp);

            $already_passport = Passport::where('passport_no','=',$request->passport_no)->first();

            if($already_passport != null){

                $message = [
                    'message' => "Passport number is already register with us",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return response()->json([
                    'code' => "101",
                    'message' => $message
                ]);
            }

            if($request->licence_no != null){
                $check_license = Career::where('licence_no','=',trim($request->licence_no))->first();
                if($check_license != null){

                    $message = [
                        'message' => "License number is already register with us",
                        'alert-type' => 'error',
                        'error' => ''
                    ];
                    return response()->json([
                        'code' => "101",
                        'message' => $message
                    ]);
                }
            }

            if($request->email != null){
                $check_email = Career::where('email','=',trim($request->email))->first();
                if($check_email != null){
                    $message = [
                        'message' => "Email is already register with us",
                        'alert-type' => 'error',
                        'error' => ''
                    ];
                    return response()->json([
                        'code' => "101",
                        'message' => $message
                    ]);
                }
            }


    //        dd($request);

            $file1=null;
            $file2=null;
            $file3=null;

            $license_issue = NULL;
            $exit_date = NULL;
            $license_expiry = NULL;
            $passport_expiry = NULL;
            $license_no = NULL;
            $license_status_vehicle = 0;


    //        echo "license Issued".$license_issue;
    //        dd();
    //        $obj1 = Career::find($id);
    //        $obj1->platform_id = null;
    //        $obj1->cities = null;
    //        $obj1->save();


            $obj= new Career();
            $obj->name = trim($request->input('name'));
            $obj->email = trim($request->input('email'));
            $obj->phone = trim($full_number);
            $obj->whatsapp = trim($whatsapp_full_number);
            $obj->promotion_type = trim($request->input('promotion_type'));
            // $obj->user_id = Auth::user()->id;
        if($request->promotion_type=="1" || $request->promotion_type=="2" || $request->promotion_type=="3" || $request->promotion_type=="5"){
            $obj->social_media_id_name =  trim($request->social_id_name);
        }elseif($obj->promotion_type=="7"){
                $obj->promotion_others = trim($request->other_source_name);
        }

            $phone_no = (string) $request->phone;
            if(strpos($phone_no, "+971") !== false) {
                $obj->source_type = 4; //From Website
            }
            else{
                $obj->source_type = 6; //International
            }


            if(!empty($request->input('apply_for'))){
                $obj->vehicle_type = trim($request->input('apply_for'));
            }

            $file1?$obj->cv = $file1:"";

            if(!empty($request->input('license_status'))){
                $obj->licence_status = trim($request->input('license_status'));
            }

            if($request->input('license_status')=="1"){
                if(!empty($request->license_type)){
                    $obj->licence_status_vehicle = trim($request->license_type);
                }
                if(!empty($request->licence_no)){
                    $obj->licence_no = trim($request->licence_no);
                }
                if(!empty($request->traffic_no)){
                    $obj->traffic_file_no = trim($request->traffic_no);
                }

                if(!empty($request->licence_issue_date)){
                    $obj->licence_issue = $request->licence_issue_date;
                }
                if(!empty($request->licence_expiry_date)){
                    $obj->licence_expiry = trim($request->licence_expiry_date);
                }

                $file3?$obj->licence_attach = $file3:"";
            }

            if(!empty($request->input('nationality'))){
                $obj->nationality = $request->input('nationality');
            }
            $obj->nationality = trim($request->input('nationality'));
            if(!empty($request->input('dob'))){
                $obj->dob = trim($request->input('dob'));
            }

            $file2?$obj->passport_attach = $file2:"";

            if(!empty($request->input('visa_status'))){
                $obj->visa_status = trim($request->input('visa_status'));
            }

            if($request->input('visit_exit_date') != null) {
                $obj->exit_date = trim($request->visit_exit_date);
            }
            if(!empty($request->input('platform_id'))){
                $obj->platform_id = json_encode($request->input('platform_id'));
            }
            if(!empty($request->cities)){
                $obj->cities = json_encode($request->cities);
            }

            $obj->save();
            // $last_id = $obj->id;
            // $career_history = new CareerStatusHistory();
            // $career_history->career_id = $last_id;
            // $career_history->status = "0";
            // $career_history->save();

            // $referal = Referal::where('career_id','=',$last_id)->first();
            // if(!empty($referal)){
            //     $referal->passport_no = trim($request->passport_no);
            //     $referal->update();
            // }


            return response()->json([
                'code' => "100"
            ]);

        }else {
            $message = [
                'message' => "You Cannot Apply",
                'alert-type' => 'error',
                'error' => ''
            ];
            return response()->json([
                'code' => "101",
                'message' => $message,
            ]);
        }

    }
}
