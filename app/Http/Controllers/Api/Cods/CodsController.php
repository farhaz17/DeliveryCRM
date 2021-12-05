<?php

namespace App\Http\Controllers\Api\Cods;

use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\CodPrevious\CodPrevious;
use App\Model\Cods\CloseMonth;
use App\Model\Cods\Cods;
use App\Model\CodUpload\CodUpload;
use App\Model\Guest\Career;
use App\Model\RiderProfile;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Model\PlatformCode\PlatformCode;


class CodsController extends Controller
{
    //
    public function store_cods(Request $request){

        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
        try {

            if($request->slip_number=="Bank_issue"){
                $validator = Validator::make($request->all(), [
                    'slip_number' => 'required',
                    'date' => 'required',
                    'amount' => 'required',
                ]);
            }else{
                $validator = Validator::make($request->all(), [
                    'slip_number' => 'required',
                    'date' => 'required',
                    'amount' => 'required',
                    'picture' => 'required',
                ]);
            }



            if ($validator->fails()) {

                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            if (!empty($_FILES['picture']['name'])) {
                if (!file_exists('./assets/upload/cods')) {
                    mkdir('./assets/upload/cods', 0777, true);
                }
                $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["picture"]["tmp_name"], './assets/upload/cods/' . $file1);
                $file1 = '/assets/upload/cods/' . $file1;
            }

            $date_time = explode(" ",$request->date);

            $riderProfile = User::find(Auth::user()->id);

            $user_passport_id = $riderProfile->profile->passport_id;

            $check_in_platform = $riderProfile->profile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

            if(!empty($check_in_platform)) {

                $obj= new Cods();
                if(($request->slip_number=="Bank_issue")){
                    $obj->slip_number = "N/A";
                }else{
                    $obj->slip_number = trim($request->input('slip_number'));
                }

                $obj->machine_number = trim($request->input('machine_number'));
                $obj->location_at_machine = trim($request->input('location_at_machine'));
                $obj->date = trim($date_time[0]);
                $obj->time = trim($date_time[1]);
                $obj->amount = trim($request->input('amount'));
                $obj->platform_id = $check_in_platform;
                $obj->message = $request->message;
                $obj->passport_id = $user_passport_id;

                if($request->slip_number=="Bank_issue"){
                    $obj->type = '3';
                }else{
                    $obj->type = '1';
                }


                if(!empty($file1)){
                    $obj->picture =$file1;
                }
                $obj->save();

                $response['code'] = 1;
                $response['message'] = 'Cod Submitted Successful';
                return response()->json($response);

            }else{

                $response['code'] = 2;
                $response['message'] = "You don't have platform";

                return response()->json($response);

            }



        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed fgf';

            return response()->json($response);
        }

    }

    public function  store_bank_issue(Request $request){

        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
        try {

            $validator = Validator::make($request->all(), [
                'slip_number' => 'required',
                'machine_number' => 'required',
                'location_at_machine' => 'required',
                'date' => 'required',
                'amount' => 'required',

            ]);
            if ($validator->fails()) {

                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }



            $date_time = explode(" ",$request->date);

            $riderProfile = User::find(Auth::user()->id);

            $user_passport_id = $riderProfile->profile->passport_id;

            $check_in_platform = $riderProfile->profile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

            if(!empty($check_in_platform)) {

                $obj= new Cods();
                $obj->slip_number = trim($request->input('slip_number'));
                $obj->machine_number = trim($request->input('machine_number'));
                $obj->location_at_machine = trim($request->input('location_at_machine'));
                $obj->date = trim($date_time[0]);
                $obj->time = trim($date_time[1]);
                $obj->amount = trim($request->input('amount'));
                $obj->platform_id = $check_in_platform;
                $obj->message = $request->message;
                $obj->passport_id = $user_passport_id;
                $obj->type = '1';
                $obj->save();

                $response['code'] = 1;
                $response['message'] = 'Cod Submitted Successful';
                return response()->json($response);

            }else{

                $response['code'] = 2;
                $response['message'] = "You don't have platform";

                return response()->json($response);

            }



        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }



    public function store_cash(Request $request){

        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
        try {

            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'amount' => 'required',
            ]);

            if($validator->fails()){
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $date_time = explode(" ",$request->date);

            $riderProfile = User::find(Auth::user()->id);

            $user_passport_id = $riderProfile->profile->passport_id;

            $check_in_platform = $riderProfile->profile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

            if(!empty($check_in_platform)){

                $obj= new Cods();
                $obj->date = trim($date_time[0]);
                $obj->time = trim($date_time[1]);
                $obj->amount = trim($request->input('amount'));
                $obj->passport_id = $user_passport_id;
                $obj->platform_id = $check_in_platform;
                $obj->type = '0';
                $obj->save();

                $response['code'] = 1;
                $response['message'] = 'Cod Submitted Successful';
                return response()->json($response);

            }else{

                $response['code'] = 2;
                $response['message'] = "You don\'t have platform ";

                return response()->json($response);

            }



        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }

    public function cod_history(Request $request){

        $user_id = Auth::user()->id;

         $rider_profile = RiderProfile::where('user_id','=',$user_id)->first();

        $user_passport_id = $rider_profile->passport_id;

        if(!empty($request->start_date) &&  !empty($request->end_date) ){
            $data = Cods::where('passport_id','=',$user_passport_id)->whereBetween('date', [$request->start_date, $request->end_date])->latest()->get();
        }else{
            $data = Cods::where('passport_id','=',$user_passport_id)->latest()->get();
        }

        return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }



    public function cod_rider_order_history(Request $request){

        $user_id = Auth::user()->id;

        $riderProfile  = RiderProfile::where('user_id','=',$user_id)->first();
        $data  = [];


        if(isset($riderProfile->passport->platform_codes)){
            $ab = $riderProfile->passport->platform_codes->pluck(['platform_code']);
            $array_ab = $ab->toArray();

            if(!empty($request->start_date) && !empty($request->end_date)){
                $data =  CodUpload::whereIn('rider_id',$array_ab)->whereBetween('start_date', [$request->start_date, $request->end_date])->with('platform')->get();
            }else{
                $data =  CodUpload::whereIn('rider_id',$array_ab)->with('platform')->get();
            }
        }

        return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public  function cod_adjust_request_store(Request $request){

        $response = [];
        try {

            $validator = Validator::make($request->all(), [
                'message' => 'required',
//                'amount' => 'required',
                'first_image' => 'required',
                'images.*' => 'image|mimes:jpeg,bmp,png,jpg'
            ]);

            if($validator->fails()){
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $current_timestamp = Carbon::now()->timestamp;

            $data_images = [];



                if(!empty($_FILES['first_image']['name'])) {
                    if (!file_exists('./assets/upload/cods/adjustment/')) {
                        mkdir('./assets/upload/cods/adjustment', 0777, true);
                    }
                    $ext = pathinfo($_FILES['first_image']['name'], PATHINFO_EXTENSION);
                    $file1 = rand(0,1000000).$current_timestamp.'.'.$ext;
                    move_uploaded_file($_FILES["first_image"]["tmp_name"], './assets/upload/cods/adjustment/' . $file1);
                    $data_images[] = '/assets/upload/cods/adjustment/' . $file1;
                }

                if(!empty($_FILES['second_image']['name'])) {
                    if (!file_exists('./assets/upload/cods/adjustment/')) {
                        mkdir('./assets/upload/cods/adjustment', 0777, true);
                    }
                    $ext = pathinfo($_FILES['second_image']['name'], PATHINFO_EXTENSION);
                    $file1 = rand(0,1000000).$current_timestamp.'.'.$ext;
                    move_uploaded_file($_FILES["second_image"]["tmp_name"], './assets/upload/cods/adjustment/' . $file1);
                    $data_images[] = '/assets/upload/cods/adjustment/' . $file1;
                }

                if(!empty($_FILES['third_image']['name'])) {
                    if (!file_exists('./assets/upload/cods/adjustment/')) {
                        mkdir('./assets/upload/cods/adjustment', 0777, true);
                    }
                    $ext = pathinfo($_FILES['third_image']['name'], PATHINFO_EXTENSION);
                    $file1 = $current_timestamp.'.'.$ext;
                    move_uploaded_file($_FILES["third_image"]["tmp_name"], './assets/upload/cods/adjustment/' . $file1);
                    $data_images[] = '/assets/upload/cods/adjustment/' . $file1;
                }



            $riderProfile  = RiderProfile::where('user_id','=',Auth::user()->id)->first();

            $check_in_platform = $riderProfile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

            $user_passport_id = $riderProfile->passport_id;

            if(!empty($check_in_platform)){

                $obj= new CodAdjustRequest();
                $obj->message = trim($request->message);
                $obj->passport_id = $user_passport_id;
                $obj->images =  json_encode($data_images,JSON_UNESCAPED_SLASHES);
                $obj->amount =  $request->amount;
                $obj->order_id =  $request->order_id;
                $obj->order_date =  $request->order_date;
                $obj->platform_id =  isset($check_in_platform) ? $check_in_platform : '';
                $obj->status =  "1";
                $obj->save();

            }else{

                $response['code'] = 2;
                $response['message'] = 'platform not assign yet';

                return response()->json($response);

            }


//            $cod_upload  = CodUpload::where('order_id','=',trim($request->order_id))->first();
//            $cod_upload->status = 1;
//            $cod_upload->update();

            $response['code'] = 1;
            $response['message'] = 'Cod Adjustment Request Submitted';
            return response()->json($response);

        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }



    public function adjustment_history(Request $request){


        $riderProfile  = RiderProfile::where('user_id','=',Auth::user()->id)->first();
        $user_passport_id = $riderProfile->passport_id;

        $data  = [];

        if(!empty($request->start_date) && !empty($request->end_date)){
            $data =  CodAdjustRequest::where('passport_id','=',$user_passport_id)->whereBetween('order_date', [$request->start_date, $request->end_date])->get();
        }else{
            $data =  CodAdjustRequest::where('passport_id','=',$user_passport_id)->get();
        }

        return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function adjustment_history_detail($id){

        $data =  CodAdjustRequest::find($id);

        $array_image = json_decode($data->images);

        $first_image = "";
        $second_image = null;
        $third_image = null;

        if(isset($array_image[0])){
            $first_image = $array_image[0] ;
        }

        if(isset($array_image[1])){
            $second_image = $array_image[1];
        }

        if(isset($array_image[2])){
            $third_image = $array_image[2];
        }

        $gamer = array(
            'message' => $data->message,
            'amount' => $data->message,
            'order_id' => $data->order_id,
            'status' => $data->status,
            'first_image' => $first_image,
            'second_image' => $second_image,
            'third_image' => $third_image,
        );

        return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);
    }





    public function get_cod_balance(){

        $user_id = Auth::user()->id;
        $riderProfile  = RiderProfile::where('user_id','=',$user_id)->first();
        $remain_amount = 0;
        $total_pending_amount = 0;
        $total_paid_amount = 0;
        $total_salary_amount = 0;

        $user_passport_id = $riderProfile->passport_id;

        if(isset($riderProfile->passport->platform_codes)){
            $check_in_platform = null;
            $check_in_platform = $riderProfile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();
            $rider_id = $riderProfile->passport->platform_codes->where('platform_id','=',$check_in_platform)->pluck(['platform_code'])->first();

            $amount =  CodUpload::where('rider_id','=',$rider_id)
                ->where('platform_id','=',$check_in_platform)
                ->selectRaw('sum(amount) as total')->first();

            $paid_amount =  Cods::where('passport_id',$user_passport_id)->where('platform_id','=',$check_in_platform)->where('status','1')->selectRaw('sum(amount) as total')->first();
            $salary_array = CloseMonth::where('passport_id','=',$riderProfile->passport->id)->selectRaw('sum(close_month_amount) as total')->first();

            if(!empty($amount)){
                $total_pending_amount = $amount->total;
            }
            if(!empty($paid_amount)){
                $total_paid_amount = $paid_amount->total;
            }
            if(!empty($salary_array)){
               $total_paid_amount = $total_paid_amount+$salary_array->total;
            }


        }
        $pre_amount = 0;
         $prev_array = CodPrevious::where('passport_id','=',$riderProfile->passport_id)->first();
         if($prev_array != null){
             $pre_amount = $prev_array->amount;

             $total_pending_amount = $total_pending_amount+$pre_amount;
         }

          $adj_req_t =CodAdjustRequest::where('passport_id','=',$user_passport_id)->where('status','=','2')->selectRaw('sum(amount) as total')->first();

        if($adj_req_t != null){
            $total_paid_amount = $total_paid_amount+$adj_req_t->total;
        }

        $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');

        return response()->json(['amount'=>$remain_amount], 200, [], JSON_NUMERIC_CHECK);

    }

    public function salary_close_month(){

        $user_id = Auth::user()->id;
        $riderProfile  = RiderProfile::where('user_id','=',$user_id)->first();

         $gamer = CloseMonth::select('created_at as date','close_month_amount as amount')->where('passport_id','=',$riderProfile->passport->id)->get();

        return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);

    }

    public function cod_detail(Request $request){

        // $riderProfile = PlatformCode::where('passport_id','=',$id)->first();
        // if(!empty($riderProfile))
        // {
        //     $rider_id = $riderProfile->platform_code;
        //     $upload = CodUpload::where('rider_id',$rider_id)->first();
        // }
        // if(!empty($upload))
        // {
            $passport_id = Auth::user()->profile->passport_id;
            $data = collect();
            $data['Cods'] = Cods::where('passport_id',$passport_id)->where('platform_id','4')->get();
            $data['CodAdjustRequest'] = CodAdjustRequest::where('passport_id',$passport_id)->where('platform_id','4')->get();
        // }
        // else {
        //     $data['code'] = 2;
        //     $data['message'] = 'NO Rider Information';
        // }

        return response()->json(['data'=>$data], 200, [], JSON_NUMERIC_CHECK);
    }

}
