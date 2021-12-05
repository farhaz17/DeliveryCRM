<?php

namespace App\Http\Controllers\Api\Guest;

use App\Model\Career\CareerHeardAboutUs;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Cities;
use App\Model\exprience_month;
use App\Model\Guest\Career;
use App\Model\Guest\Experience;
use App\Model\Passport\Passport;
use App\Model\Passport\PassportAdditional;
use App\Model\Referal\Referal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Nationality;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CareerController extends Controller
{
    public function store_career(Request $request)
    {
        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
//        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
//                'passport_no' => 'required|unique:careers,passport_no|
//                                  unique:passports,passport_no|
//                                  unique:renew_passports,renew_passport_number|
//                                  unique:referals,passport_no',
//                'email' => 'required|email|unique:careers,email',
                'phone' => 'required|unique:careers,phone',
                'whatsapp' => 'required|unique:careers,whatsapp',
//                'licence_no' => 'unique:careers,licence_no',
//                'platform_id' => 'required',
            ]);

            if($validator->fails()) {
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

//        $nine_digit_phone = substr($request->phone, -9);
//        $check_phone = Career::where('phone','LIKE','%'.$nine_digit_phone.'%')->first();
//        if($check_phone != null) {
//
//            $response['code'] = 2;
//            $response['message'] = "phone number is already exist";
//            return response()->json($response);
//        }



           if(!empty($request->licence_no))
            {
             $career = Career::where('licence_no','=',$request->licence_no)->first();
                 if(!empty($career)){
                     $response['code'] = 2;
                     $response['message'] = "license Number already taken";
                     return response()->json($response);
                 }
            }

        if(!empty($request->traffic_file_no))
        {
            $career = Career::where('traffic_file_no','=',$request->traffic_file_no)->first();
            if(!empty($career)){
                $response['code'] = 2;
                $response['message'] = "Traffic code Number already taken";
                return response()->json($response);
            }
        }




//        $already_passport = Passport::where('passport_no','=',$request->passport_no)->first();
//
//            if($already_passport != null){
//
//                $response['code'] = 2;
//                $response['message'] = "Your passport is already register with us";
//                return response()->json($response);
//            }

            $file1=null;
            $file2=null;
            $file3=null;
            $licence_back_image = null;
            if (!empty($_FILES['cv']['name'])) {
                if (!file_exists('./assets/upload/guest/cv')) {
                    mkdir('./assets/upload/guest/cv', 0777, true);
                }
                $ext = pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["cv"]["tmp_name"], './assets/upload/guest/cv/' . $file1);
                $file1 = '/assets/upload/guest/cv/' . $file1;
            }

            if (!empty($_FILES['passport']['name'])) {
                if (!file_exists('./assets/upload/guest/passport')) {
                    mkdir('./assets/upload/guest/passport', 0777, true);
                }
                $ext = pathinfo($_FILES['passport']['name'], PATHINFO_EXTENSION);
                $file2 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["passport"]["tmp_name"], './assets/upload/guest/passport/' . $file2);
                $file2 = '/assets/upload/guest/passport/' . $file2;
            }
            if(!empty($_FILES['licence']['name'])) {
                if (!file_exists('./assets/upload/guest/licence')) {
                    mkdir('./assets/upload/guest/licence', 0777, true);
                }
                $ext = pathinfo($_FILES['licence']['name'], PATHINFO_EXTENSION);
                $file3 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["licence"]["tmp_name"], './assets/upload/guest/licence/' . $file3);
                $file3 = '/assets/upload/guest/licence/' . $file3;
            }

            if(!empty($_FILES['licence_back_image']['name'])) {
                if (!file_exists('./assets/upload/guest/licence_back')) {
                    mkdir('./assets/upload/guest/licence_back', 0777, true);
                }
                $ext = pathinfo($_FILES['licence_back_image']['name'], PATHINFO_EXTENSION);
                $licence_back_image = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["licence_back_image"]["tmp_name"], './assets/upload/guest/licence_back/' . $licence_back_image);
                $licence_back_image = '/assets/upload/guest/licence_back/' . $licence_back_image;
            }

            $license_issue = NULL;
            $exit_date = NULL;
            $license_expiry = NULL;
            $passport_expiry = NULL;
            $license_no = NULL;
            $license_status_vehicle = 0;

            if(!empty($request->input('licence_issue'))){
                $license_issue = Carbon::createFromFormat('Y-m-d', $request->input('licence_issue'));
            }

            if($request->input('exit_date') != null){
                $exit_date = Carbon::createFromFormat('Y-m-d', $request->input('exit_date'));
            }

            if(!empty($request->input('licence_expiry'))){
                $license_expiry = Carbon::createFromFormat('Y-m-d', $request->input('licence_expiry'));
            }
            if(!empty($request->input('passport_expiry'))){
                $passport_expiry = Carbon::createFromFormat('Y-m-d', $request->input('passport_expiry'));
            }

            $dob = null;
        if(!empty($request->input('dob'))){
            $dob = Carbon::createFromFormat('Y-m-d', $request->input('dob'));
        }

            if(!empty($request->input('licence_no'))){
                $license_no = $request->input('licence_no');
            }

        if(!empty($request->input('licence_status_vehicle'))){

           $license_status_vehicle = $request->input('licence_status_vehicle');
        }
//        echo "license Issued".$license_issue;
//        dd();


                $obj=new Career();
                $obj->name = trim($request->input('name'));
//                $obj->email = trim($request->input('email'));
                $obj->phone = trim($request->input('phone'));
                $obj->whatsapp = trim($request->input('whatsapp'));
//                $obj->facebook = trim($request->input('facebook'));
                $obj->vehicle_type = trim($request->input('vehicle_type'));
                $obj->experience = trim($request->input('experience'));
//                $file1?$obj->cv = $file1:"";
                $obj->licence_status = trim($request->input('licence_status'));

                if($request->input('licence_status')=="1"){
                    $obj->licence_status_vehicle = trim($license_status_vehicle);
                    $obj->licence_no = trim($license_no);
//                    $obj->licence_issue = $license_issue;
//                    $obj->licence_expiry = trim($license_expiry);
                    $file3?$obj->licence_attach = $file3:"";
                    $file3?$obj->licence_attach_back = $licence_back_image: "";
                    $obj->traffic_file_no = $request->traffic_file_no;
                }

                $request->experience_month  ? $obj->experience_month = $request->experience_month : null;
                $obj->nationality = trim($request->input('nationality'));
//                $obj->dob = trim($request->input('dob'));
//                $obj->passport_no = trim($request->input('passport_no'));
//                $obj->passport_expiry = trim($passport_expiry);
//                $file2?$obj->passport_attach = $file2:"";
                $obj->visa_status = trim($request->input('visa_status'));
//                $obj->visa_status_visit = trim($request->input('visa_status_visit'));
//                $obj->visa_status_cancel = trim($request->input('visa_status_cancel'));
//                $obj->visa_status_own = trim($request->input('visa_status_own'));
//                if($request->input('exit_date') != null) {
//                    $obj->exit_date = trim($exit_date);
//                }
                $obj->company_visa = trim($request->input('company_visa'));
                $obj->promotion_type = trim($request->input('promotion_type'));
                $obj->promotion_others = trim($request->input('promotion_others'));
//                $obj->inout_transfer = trim($request->input('inout_transfer'));


        if(!empty($request->input('platform_id'))){

            $my_array = json_decode($request->input('platform_id'));
            $s = array();
            foreach ($my_array as $b){
                $s[]  =  (String)$b;
            }
            $obj->platform_id = json_encode($s);

        }

        if(!empty($request->input('cities'))){

            $my_array = json_decode($request->input('cities'));
            $s = array();
            foreach ($my_array as $b){
                $s[]  =  (String)$b;
            }
            $obj->cities = json_encode($s);

        }

        $career_id = 0;
                if(isset($request->passport_id) && !empty($request->passport_id)){
                    $obj->refer_by = $request->passport_id;
                    $career_id = 1;
                }
                 // Application submitted form App

        $country_code = substr($request->phone, 0, 4);

        if($country_code=="+971"){
            $source_type = "1";
        }else{
            $source_type = "6";
        }
        $obj->source_type = $source_type;
        $obj->save();

                $last_id = $obj->id;


                $career_history = new CareerStatusHistory();
                $career_history->career_id = $last_id;
                $career_history->status = "0";
                $career_history->save();


                $response['code'] = 1;
                $response['message'] = 'Job Submission Successful';

                return response()->json($response);


//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = 'Submission Failed';
//
//            return response()->json($response);
//        }
    }

    public function getExperiences()
    {
        $gamer = array(
            'name' => '0 Year',
            'id' => '6',
        );

        $array_to_send = array();
         $exprience = Experience::where('name','!=','0 Year')->get();


        $array_to_send [] = $gamer;

         foreach($exprience as $ab){

             $gamer = array(
                 'name' => $ab->name,
                 'id' => $ab->id,
             );

             $array_to_send [] = $gamer;
         }




        $response['categories'] = $array_to_send;

        // $customers = Customer::find($id);
        return response()->json($response);
    }

    public function get_experience_month(){
          $exprience_months = exprience_month::all();

        $response['categories'] = $exprience_months;

        return response()->json($response);

    }

    public function  get_cities(){

        $cities = Cities::all();

        $response['platforms'] = $cities;

        return response()->json($response);

    }




    public function getPromotionType()
    {



//
//        $collection = collect(['name' => 'Tiktok', 'id' => '1',
//            'name' => 'Facebook', 'id' => '2',
//            'name' => 'Youtube', 'id' => '3',
//    'name' => 'Website', 'id' => '4',
//    'name' => 'Friend', 'id' => '5',
//    'name' => 'Other', 'id' => '6']);
//
//
//        $collection->toArray();
        $collection = CareerHeardAboutUs::all();



        $response['categories'] = $collection;

        // $customers = Customer::find($id);
        return response()->json($response);
    }

    public function career_request_form_outside_uae(Request $request)
    {
         // return $request->all();
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required|unique:careers',
            'whatsapp' => 'required|unique:careers',
            'email' => 'email|nullable|unique:careers',
            'passport_no' => 'unique:careers|nullable',
            'license_no' => 'nullable|unique:careers',
        ],
        $messages = [
            'name.required' => "Please Enter your name",
            'mobile_no.required' => "Please Enter your mobile No",
            'whatsapp_no.required' => "Please Enter your whatsapp No"
            ]
        );
        if($request->passport_status == 1){
            $validator = Validator::make($request->all(),
                ["passport_no" => "required"], $messages =
                ["passport_no.required" => "Please Enter Passport No"]
            );
        }else if($request->uae_license_status == 1){
            $validator = Validator::make($request->all(),
                ["license_no" => "required"], $messages =
                ["license_no.required" => "Please Enter License No"]
            );
        }
        if($validator->fails()){
            $response['code'] = 2;
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }
        try {
            $obj = new Career();
            $obj->nationality = $request->nationality;
            $obj->belong_city_name = $request->belong_city_name;
            $obj->name = $request->name;
            $obj->phone = $request->phone;
            $obj->whatsapp = $request->whatsapp;
            $obj->email = $request->email;
            $obj->passport_status = $request->passport_status;
            $obj->passport_no =  $request->passport_no;
            $obj->pak_licence_status = $request->pak_licence_status;
            $obj->licence_status = $request->licence_status;
            $obj->licence_no = $request->licence_no;
            $obj->promotion_others = $request->promotion_others;
            if($request->promotion_type=="1" || $request->promotion_type=="2" || $request->promotion_type=="3" || $request->promotion_type=="5"){
                $obj->social_media_id_name =  trim($request->promotion_others);
              }elseif($obj->promotion_type=="7"){
                   $obj->promotion_others = trim($request->promotion_others);
              }
            $obj->promotion_type = $request->promotion_type;
            $obj->source_type = 1; // Application submitted form App
            $obj->save();

            $response['code'] = 1;
            $response['message'] = "Submission Successful~";
            return response()->json($response);

        }catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 3;
            $response['message'] = $e->getMessage();

            return response()->json($response);
        }
    }

    public function get_nationalities(){
        $nationalities = Nationality::whereNotIn('id', [17, 18, 19, 20])->get();
        $response['platforms'] = $nationalities;
        return response()->json($response);
    }

    public function get_current_version(){


        $response['version'] = "1.5.6";

        return response()->json($response);
    }

}

