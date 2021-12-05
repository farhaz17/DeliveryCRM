<?php

namespace App\Http\Controllers\Api;

use App\Model\Bike_person_fuels;
use App\Model\FuelPlatform\FuelPlatform;
use App\Model\RiderFuel\RiderFuel;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Image;

class FuelRiderController extends Controller
{

    public function save_fuel(Request $request){

        $current_timestamp = Carbon::now()->timestamp;
        try{
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'picture' => 'required',
            ]);
            if ($validator->fails()){
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $riderProfile = User::find(Auth::user()->id);

            $user_passport_id = $riderProfile->profile->passport_id;
            $today_date  = date("Y-m-d");

            $check_in_platform = $riderProfile->profile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

            if($check_in_platform == null){

                $response['code'] = 2;
                $response['message'] = "platform is not assigned";
                return response()->json($response);
            }

            $allow_fuel_platforms = FuelPlatform::where('status','=','1')->pluck('platform_id')->toArray();

            $passport_id = $riderProfile->profile->passport_id;
            $bike_person_fuel = Bike_person_fuels::where('passport_id','=',$passport_id)->where('status','=','1')->first();

            $is_personal_fuel = 0;

            if($bike_person_fuel!=null){
                $is_personal_fuel = $bike_person_fuel->id;
            }


            if(!in_array($check_in_platform,$allow_fuel_platforms)){

                if($bike_person_fuel==null){

                    $response['code'] = 2;
                    $response['message'] = "you are not allowed to save fuel";
                    return response()->json($response);

                }
            }

            $now_time = Carbon::parse($today_date)->startOfDay();
            $end_time = Carbon::parse($today_date)->endOfDay();

           $is_already = RiderFuel::where('passport_id','=',$user_passport_id)->whereDate('created_at', '>=', $now_time)
                ->whereDate('created_at', '<=', $end_time)->first();

           if($is_already != null){

               $response['code'] = 2;
               $response['message'] = "Today fuel is already submitted";
               return response()->json($response);
           }

            if (!empty($_FILES['picture']['name'])) {
                $today_date = date("Y-m-d");
                // if (!file_exists('./assets/upload/rider_fuel/'.$today_date.'/')) {
                //     mkdir('./assets/upload/rider_fuel/'.$today_date, 0777, true);
                // }
                // $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                // $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                // move_uploaded_file($_FILES["picture"]["tmp_name"], './assets/upload/rider_fuel/'.$today_date.'/'. $file1);
                // $file1 = '/assets/upload/rider_fuel/'.$today_date.'/'.$file1;
                $img = $request->file('picture');
                $image_name = '/assets/upload/rider_fuel/'.$today_date."/" .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($image_name,  $imageS3->stream());


            }

            $rider_fuel = new RiderFuel();
            $rider_fuel->amount = $request->amount;
            $rider_fuel->image = isset($image_name) ? $image_name : '';
            $rider_fuel->passport_id = $user_passport_id;
            $rider_fuel->platform_id = $check_in_platform;
            if($is_personal_fuel!=0){
              $rider_fuel->bike_person_fuel_id  = $is_personal_fuel;
            }
            $rider_fuel->save();

            $response['code'] = 1;
            $response['message'] = 'Fuel  Submitted Successful';
            return response()->json($response);

        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed!';

            return response()->json($response);
        }
    }

    public function is_fuel_already_saved(){
        $riderProfile = Auth::user();
        $passport = $riderProfile->profile->passport;
        $start_time = Carbon::today()->startOfDay();
        $end_time = Carbon::today()->endOfDay();
        $is_already = RiderFuel::where('passport_id','=',$passport->id)->whereDate('created_at', '>=', $start_time)
            ->whereDate('created_at', '<=', $end_time)->first();
        $check_in_platform = $passport->platform_assign->where('status', 1 )->pluck(['plateform'])->first();
        $allow_fuel_platforms = FuelPlatform::where('status', 1 )->pluck('platform_id')->toArray();
        $before_now_now = $passport->platform_assign->where('status', 0 )->wherein('plateform', $allow_fuel_platforms)->pluck(['plateform'])->first();
         if($before_now_now != null){
             return response()->json(['status' => "4"], 200, [], JSON_NUMERIC_CHECK);
         }
        if($check_in_platform == null){
            return response()->json(['status' => "3"], 200, [], JSON_NUMERIC_CHECK);
        }
       if($check_in_platform != null){
           if($check_in_platform == "4"){
                return response()->json( ['status' => "4" ], 200, [], JSON_NUMERIC_CHECK); // 5 for delivero
           }elseif($check_in_platform == "15" || $check_in_platform == "34" ){
                return response()->json(['status' => "4"], 200, [], JSON_NUMERIC_CHECK); // 6 for talabat bike or car
           }
       }
        $bike_person_fuel = Bike_person_fuels::wherePassportId($passport->id)->whereStatus(1)->first();
        $is_personal_fuel = 0;
        if($bike_person_fuel != null){
            $is_personal_fuel = $bike_person_fuel->id;
        }
        if(!in_array($check_in_platform,$allow_fuel_platforms)){
            if($bike_person_fuel == null){
                return response()->json(['status' => "2"], 200, [], JSON_NUMERIC_CHECK);
            }
        }
        if($is_already != null){
            $gamer = ['status' => "1"];
        }else{
            $gamer = [ 'status' => "0"]; //zero means eligble
        }
        return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_rider_fuel_history(Request $request){

        $riderProfile = User::find(Auth::user()->id);
        $user_passport_id = $riderProfile->profile->passport_id;
        if(!empty($request->start_date) && !empty($request->end_date)){
            $data =  RiderFuel::where('passport_id','=',$user_passport_id)->whereDate('created_at', '>=',$request->start_date)
                ->whereDate('created_at', '<=', $request->end_date)->orderby('id','desc')->get();
            $array_to_send = array();
            $amount_to_send = array();
            $total_amount = 0;
            foreach ($data as $row) {
                $total_amount+= $row->amount;
                $remakrs=$row->remarks;
                if ($remakrs==null){
                    $remakrs_val='123';
                }
                else{
                    $remakrs_val=$remakrs;
                }
                $res = array(
                    "amount" => $row->amount,
                    "image" => $row->image,
                    "status" => $row->status,
                    "passport_id" => $row->passport_id,
                    "action_by" => $row->action_by,
                    "created_at" => $row->created_at->format('Y-m-d'),
                    "updated_at" => $row->updated_at->format('Y-m-d'),
                    "remarks" => $remakrs_val,
                );
                $array_to_send[]= $res;
            }
                $amount_res=array(
                    'total_amount'=>$total_amount,
                );
            $amount_to_send[]=$amount_res;

            return response()->json(['data' => $array_to_send,'total_amount' =>$total_amount], 200, [], JSON_NUMERIC_CHECK);

        }
        else{
            $data =  RiderFuel::where('passport_id','=',$user_passport_id)->orderby('id','desc')->get();
            $array_to_send = array();
            $total_amount = 0;
            foreach ($data as $row) {
                $remakrs=$row->remarks;
                if ($remakrs==null){
                    $remakrs_val='123';
                }
                else{
                    $remakrs_val=$remakrs;
                }
                $res = array(
                    "amount" => $row->amount,
                    "image" => $row->image,
                    "status" => $row->status,
                    "passport_id" => $row->passport_id,
                    "action_by" => $row->action_by,
                    "created_at" => $row->created_at->format('Y-m-d'),
                    "updated_at" => $row->updated_at->format('Y-m-d'),
                    "remarks" => $remakrs_val,
                );
                $array_to_send[]= $res;
            }
            return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
        }



//        return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_rider_fuel_search( Request $request){
        $riderProfile = User::find(Auth::user()->id);
        $user_passport_id = $riderProfile->profile->passport_id;
        $query=$request->status;

        if ($query=='1') {
            $data = RiderFuel::where('passport_id', '=', $user_passport_id)
                ->where('status','1')->get();


            foreach ($data as $row) {

                        $remakrs=$row->remarks;
                        if ($remakrs==null){
                            $remakrs_val='123';
                        }
                        else{
                            $remakrs_val=$remakrs;

                        }
                        $res = array(
                            "amount" => $row->amount,
                            "image" => $row->image,
                            "status" => $row->status,
                            "passport_id" => $row->passport_id,
                            "action_by" => $row->action_by,
                            "created_at" => $row->created_at->format('Y-m-d'),
                            "updated_at" => $row->updated_at->format('Y-m-d'),
                            "remarks" => $remakrs_val,

                        );
                        $array_to_send[]= $res;
                    }
                    return response()->json(['data' =>  $array_to_send], 200, [], JSON_NUMERIC_CHECK);
        }
        elseif($query=='2'){
                    $data = RiderFuel::where('passport_id', '=', $user_passport_id)
                        ->where('status','2')->get();
                    foreach ($data as $row) {
                        $remakrs=$row->remarks;
                        if ($remakrs==null){
                            $remakrs_val='123';
                        }
                        else{
                            $remakrs_val=$remakrs;

                        }
                        $res = array(
                            "amount" => $row->amount,
                            "image" => $row->image,
                            "status" => $row->status,
                            "passport_id" => $row->passport_id,
                            "action_by" => $row->action_by,
                            "created_at" => $row->created_at->format('Y-m-d'),
                            "updated_at" => $row->updated_at->format('Y-m-d'),
                            "remarks" => $remakrs_val,

                        );
                        $array_to_send[]= $res;
                    }
                    return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
        }
        elseif($query=='0'){
            $data = RiderFuel::where('passport_id', '=', $user_passport_id)
                ->where('status','0')->get();
                    foreach ($data as $row) {
                        $remakrs=$row->remarks;

                        if ($remakrs == null){
                            $remakrs_val='123';
                        }
                        else{
                            $remakrs_val=$remakrs;

                        }
                        $res = array(
                            "amount" => $row->amount,
                            "image" => $row->image,
                            "status" => $row->status,
                            "passport_id" => $row->passport_id,
                            "action_by" => $row->action_by,
                            "created_at" => $row->created_at->format('Y-m-d'),
                            "updated_at" => $row->updated_at->format('Y-m-d'),
                            "remarks" => $remakrs_val,

                        );
                        $array_to_send[]= $res;
                    }
                        return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
        }

        }


//    public function get_rider_fuel_date( Request $request){
//        $riderProfile = User::find(Auth::user()->id);
//        $user_passport_id = $riderProfile->profile->passport_id;
//
//        $data =  RiderFuel::where('passport_id','=',$user_passport_id)->whereDate('created_at', '>=',$request->start_date)
//            ->whereDate('created_at', '<=', $request->end_date)->orderby('id','desc')->get();
//        foreach ($data as $row) {
//            $remakrs=$row->remarks;
//
//            if ($remakrs == null){
//                $remakrs_val='123';
//            }
//            else{
//                $remakrs_val=$remakrs;
//
//            }
//            $res = array(
//                "amount" => $row->amount,
//                "image" => $row->image,
//                "status" => $row->status,
//                "passport_id" => $row->passport_id,
//                "action_by" => $row->action_by,
//                "created_at" => $row->created_at->format('Y-m-d'),
//                "updated_at" => $row->updated_at->format('Y-m-d'),
//                "remarks" => $remakrs_val,
//
//            );
//            $array_to_send[]= $res;
//        }
//        return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
//    }
//
}
