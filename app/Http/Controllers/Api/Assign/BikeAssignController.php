<?php

namespace App\Http\Controllers\Api\Assign;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Assign\OfficeSimAssign;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use App\Model\BikeImports;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Guest\Career;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Platform;
use App\Model\RiderProfile;
use App\Model\Telecome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BikeAssignController extends Controller
{
    //





    public function get_name()
    {

        $name=passport_addtional_info::all();
        return response()->json(['data'=>$name], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_passport()
    {
        $passport=Passport::all();
        return response()->json(['data'=>$passport], 200, [], JSON_NUMERIC_CHECK);
    }
    public function get_bike()
    {
        $bike=BikeDetail::all();
        return response()->json(['data'=>$bike], 200, [], JSON_NUMERIC_CHECK);
    }



    public function  assign_bike(Request $request)
    {


        $response = [];
        $current_timestamp = Carbon::now()->timestamp;

        try {

            $validator = Validator::make($request->all(), [
                'passport_id' => 'required',
                'plate_id' => 'required',
                'checkin' => 'required',

            ]);
            if ($validator->fails()) {

                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $file1=null;
            if (!empty($_FILES['bike_image']['name'])) {
                if (!file_exists('./assets/upload/assignment/assign_bike')) {
                    mkdir('./assets/upload/assignment/assign_bike', 0777, true);
                }
                $ext = pathinfo($_FILES['bike_image']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('passport_id').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["bike_image"]["tmp_name"], './assets/upload/assignment/assign_bike/' . $file1);
                $file1 = '/assets/upload/assignment/assign_bike/' . $file1;
            }

              $bike_id=$request->input('plate_id');
              $pass_id=  $request->input('passport_id');



               $passport_number=AssignBike::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
               $plate_number=AssignBike::where('bike',$bike_id)->latest('created_at')->first();



            if($plate_number != null && $passport_number != null ){

                if($passport_number->status!= "1" && $plate_number->status != "1" ){
                    $obj = new AssignBike();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->bike = $request->input('plate_id');
                    $obj->checkin = $request->input('checkin');
                    $obj->remarks = $request->input('remarks');
                    $obj->bike_images = $file1;
                    $obj->status = '1';
                    $obj->save();
                    $response['code'] = 1;
                    $response['message'] = 'Bike Assinged';
                    return response()->json($response);
                }else{

                    $response['code'] = 2;
                    $response['message'] = "Bike Already Assigned  Not checkout first else";
                    return response()->json($response);
                }

             }elseif($passport_number != null){

                if($passport_number->status!="1"){
                    $obj = new AssignBike();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->bike = $request->input('plate_id');
                    $obj->checkin = $request->input('checkin');
                    $obj->remarks = $request->input('remarks');
                    $obj->bike_images = $file1;
                    $obj->status = '1';
                    $obj->save();
                    $response['code'] = 1;
                    $response['message'] = 'Bike Assinged';
                    return response()->json($response);
                }else{
                    $response['code'] = 2;
                    $response['message'] = "Bike Already Assigned  Not checkout seconde else";
                    return response()->json($response);
                }

            }elseif($plate_number != null){

                if($plate_number->status!="1"){

                    $obj = new AssignBike();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->bike = $request->input('plate_id');
                    $obj->checkin = $request->input('checkin');
                    $obj->remarks = $request->input('remarks');
                    $obj->bike_images = $file1;
                    $obj->status = '1';
                    $obj->save();
                    $response['code'] = 1;
                    $response['message'] = 'Bike Assinged';
                    return response()->json($response);

                }else{

                    $response['code'] = 2;
                    $response['message'] = "Bike Already Assigned  Not checkout third eelse";
                    return response()->json($response);

                }

            }else{

                $obj = new AssignBike();
                $obj->passport_id = $request->input('passport_id');
                $obj->bike = $request->input('plate_id');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');
                $obj->bike_images = $file1;
                $obj->status = '1';
                $obj->save();
                $response['code'] = 1;
                $response['message'] = 'Bike Assinged';
                return response()->json($response);

            }




        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }



    //get bike checkout names
    public function get_bike_checkout()
    {
//        $bike_checkin = AssignBike::select('assign_bikes.passport_id','assign_bikes.bike','assign_bikes.checkin',
//            'assign_bikes.checkout','assign_bikes.remarks','assign_bikes.status')->where('')latest('created_at')
      //  $bike_checkin = AssignBike::where('id',$id)->latest('created_at')->first();latest('created_at')->first();

        $bike_checkin = AssignBike::where("checkout", null)->get();
        $checkedin_bikes_exist = array();
        foreach ($bike_checkin as $ab) {


            $gamer = array(

                'id' => $ab->id,
                'passport_id' => $ab->passport_id,
                'bike_id' => $ab->bike,
                'plate_no' => $ab->bike_plate_number->plate_no,
                'full_name' => $ab->passport->personal_info->full_name,
                'checkin' => $ab->checkin,
                'checkout' => $ab->checkout,
                'passport_no' => $ab->passport->passport_no,
                'remarks' => $ab->remarks,
                'status' => $ab->status,
                'created_at' => $ab->created_at,

            );

            $checkedin_bikes_exist [] = $gamer;
        }


//dd($checkedin_bikes_exist);
        return response()->json(['data'=>$checkedin_bikes_exist], 200, [], JSON_NUMERIC_CHECK);
    }

    public function bike_checkout(Request $request,$id){
        $response = [];

        $validator = Validator::make($request->all(), [
            'checkout' => 'required',

        ]);
        if ($validator->fails()) {

            $response['code'] = 2;
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

//        $id=$request->input('id');
        $obj = AssignBike::find($id);

        $obj->checkout=$request->input('checkout');
        $obj->remarks=$request->input('remarks');
        $obj->status='0';
        $obj->save();

        $response['code'] = 1;
        $response['message'] = 'Bike Checked-Out';
        return response()->json($response);
    }


    public function assign_dashboard_count(){


        //checkin detail counting start


        $today_date  = date("Y-m-d");

        $now_time = Carbon::parse($today_date)->startOfDay();
        $end_time = Carbon::parse($today_date)->endOfDay();

        $today_sim_checkin = AssignSim::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();

        $today_office_checkin = OfficeSimAssign::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();

        $total_today_sim = $today_sim_checkin+$today_office_checkin;

        $total_today_bike =  AssignBike::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();

        $total_today_platform = AssignPlateform::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();
        //checkout work start

        $today_sim_checkout = AssignSim::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();

        $today_office_checkout = OfficeSimAssign::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();

        $total_today_sim_checkout = $today_sim_checkout+$today_office_checkout;

        $total_today_bike_checkout =  AssignBike::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();

        $total_today_platform_checkout = AssignPlateform::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();


            $gamer = array(
                'bike_checkin_today' => $total_today_bike,
                'bike_checkout_today' => $total_today_bike_checkout,
                'sim_checkin_today' => $total_today_sim,
                'sim_checkout_today' => $total_today_sim_checkout,
                'platform_checkin_today' => $total_today_platform,
                'platform_checkout_today' => $total_today_platform_checkout,
            );


        return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);

    }


    public function today_details_checkin($id){
        $today_date  = date("Y-m-d");

        $now_time = Carbon::parse($today_date)->startOfDay();
        $end_time = Carbon::parse($today_date)->endOfDay();

        if($id=="1"){
            //bike checkin
            $total_today_bike_detail =  AssignBike::whereDate('created_at', '>=', $now_time)
                ->whereDate('created_at', '<=', $end_time)
                ->where('status','=','1')

                ->get();

            $array_to_send = array();

            foreach($total_today_bike_detail as $row){

//                        isset($row->passport->passport_no)?$row->passport->passport_no:"N/A";
                $gamer = array(
                             'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A",
                             'platform_name' =>   $row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A",
                             'zds_code' =>   isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A",
                             'bike_number' =>   isset($row->bike_plate_number->plate_no)?$row->bike_plate_number->plate_no:"N/A",
                             'checkin_time_date' =>   isset($row->checkin)?$row->checkin:"N/A",
                             'checkout_time_date' =>   isset($row->checkout)?$row->checkout:"N/A",
                             'checkout_remarks' => isset($row->remarks)?$row->remarks:"N/A",
                             'id' => "1",
                   );
                $array_to_send [] = $gamer;
             }


                  return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);


        }elseif($id=="2"){
            //bike checkout
            $total_today_bike_checkout_detail =  AssignBike::whereDate('updated_at', '>=', $now_time)
                ->whereDate('updated_at', '<=', $end_time)
                ->where('status','=','0')
                ->get();

            $array_to_send = array();

            foreach($total_today_bike_checkout_detail as $row){

//                        isset($row->passport->passport_no)?$row->passport->passport_no:"N/A";
                $gamer = array(
                    'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A",
                    'platform_name' =>   isset($row->plateformdetail->name)?$row->plateformdetail->name:"N/A",
                    'zds_code' =>   isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A",
                    'bike_number' =>   isset($row->bike_plate_number->plate_no)?$row->bike_plate_number->plate_no:"N/A",
                    'checkin_time_date' =>   isset($row->checkin)?$row->checkin:"N/A",
                    'checkout_time_date' =>   isset($row->checkout)?$row->checkout:"N/A",
                    'checkout_remarks' => isset($row->remarks)?$row->remarks:"N/A",
                    'id' => "2",
                );
                $array_to_send [] = $gamer;
            }


            return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

        }elseif($id=="3"){
            //sim checkin
            $today_sim_checkin_detail = AssignSim::whereDate('created_at', '>=', $now_time)
                ->whereDate('created_at', '<=', $end_time)
                ->where('status','=','1')
                ->get();

            $array_to_send = array();

                            foreach($today_sim_checkin_detail as $row){
                                $gamer = array(
                                    'name' => isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A",
                                    'zds_code' => isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A",
                                    'sim_number' =>   isset($row->telecome->account_number)?$row->telecome->account_number:"N/A",
                                    'platform_name' => isset($row->passport->rider_platform->plateformdetail->name)?$row->passport->rider_platform->plateformdetail->name:"N/A",
                                    'assign_to' =>    isset($row->assign_to->name)?$row->assign_to->name:"N/A",
                                    'checkin_time_date' => isset($row->checkin)?$row->checkin:"N/A",
                                    'checkout_time_date' => isset($row->checkout)?$row->checkout:"N/A",
                                    'checkout_remarks' => isset($row->remarks)?$row->remarks:"N/A",
                                    'id' => "3",
                                );
                                $array_to_send [] = $gamer;
                            }


            return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

        }elseif($id=="4"){
            //sim checkout

            $today_sim_checkout_get = AssignSim::whereDate('updated_at', '>=', $now_time)
                ->whereDate('updated_at', '<=', $end_time)
                ->where('status','=','0')
                ->get();



            $array_to_send = array();

            foreach($today_sim_checkout_get as $row){
                $gamer = array(
                    'name' => isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A",
                    'zds_code' => isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A",
                    'sim_number' =>   isset($row->telecome->account_number)?$row->telecome->account_number:"N/A",
                    'platform_name' => isset($row->passport->rider_platform->plateformdetail->name)?$row->passport->rider_platform->plateformdetail->name:"N/A",
                    'assign_to' =>    isset($row->assign_to->name)?$row->assign_to->name:"N/A",
                    'checkin_time_date' => isset($row->checkin)?$row->checkin:"N/A",
                    'checkout_time_date' => isset($row->checkout)?$row->checkout:"N/A",
                    'checkout_remarks' => isset($row->remarks)?$row->remarks:"N/A",
                    'id' => "4",
                );
                $array_to_send [] = $gamer;
            }


            return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);


        }elseif($id=="5"){
            //platform checkin

            $total_today_platform_checkin_detail = AssignPlateform::whereDate('created_at', '>=', $now_time)
                ->whereDate('created_at', '<=', $end_time)
                ->where('status','=','1')
                ->get();
            $array_to_send = array();

            foreach($total_today_platform_checkin_detail as $row) {
                $gamer = array(
                    'name' =>  isset($row->passport->personal_info->full_name) ? $row->passport->personal_info->full_name : "N/A",
                    'platform_name' => isset($row->plateformdetail->name) ? $row->plateformdetail->name : "N/A",
                    'zds_code' => isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code : "N/A",
                    'checkin_time_date' => isset($row->checkin) ? $row->checkin : "N/A",
                    'checkout_time_date' => isset($row->checkout) ? $row->checkout : "N/A",
                     'checkout_remarks' => isset($row->remakrs) ? $row->remakrs : "N/A",
                    'id' => "5",
                     );
                $array_to_send [] = $gamer;
                }

            return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

        }elseif($id=="6"){
            //platform checkout

            $total_today_platform_checkout_detail = AssignPlateform::whereDate('updated_at', '>=', $now_time)
                ->whereDate('updated_at', '<=', $end_time)
                ->where('status','=','0')
                ->get();

            $array_to_send = array();

            foreach($total_today_platform_checkout_detail as $row) {
                $gamer = array(
                    'name' =>  isset($row->passport->personal_info->full_name) ? $row->passport->personal_info->full_name : "N/A",
                    'platform_name' => isset($row->plateformdetail->name) ? $row->plateformdetail->name : "N/A",
                    'zds_code' => isset($row->passport->zds_code->zds_code) ? $row->passport->zds_code->zds_code : "N/A",
                    'checkin_time_date' => isset($row->checkin) ? $row->checkin : "N/A",
                    'checkout_time_date' => isset($row->checkout) ? $row->checkout : "N/A",
                    'checkout_remarks' => isset($row->remakrs) ? $row->remakrs : "N/A",
                    'id' => "6",
                );
                $array_to_send [] = $gamer;
            }

            return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);


        }

    }


    public function checkin_by_platform($id){

        if($id=="1"){

            $today_date  = date("Y-m-d");

            $now_time = Carbon::parse($today_date)->startOfDay();
            $end_time = Carbon::parse($today_date)->endOfDay();

            $total_today_bike_array =  AssignBike::whereDate('created_at', '>=', $now_time)
                ->whereDate('created_at', '<=', $end_time)
                ->where('status','=','1')
                ->pluck('passport_id')
                ->toArray();

             $platforms = Platform::all();
             $array_to_send = array();

             foreach($platforms as $plt) {
                 $assign_count = AssignPlateform::whereIn('passport_id', $total_today_bike_array)
                     ->where('plateform', '=', $plt->id)
                     ->where('status', '=', '1')
                     ->count();
                if($assign_count > 0 ){
                    $gamer = array(
                        'name' => $plt->name,
                        'total' => $assign_count,
                        'id' => $plt->id,
                    );
                    $array_to_send [] = $gamer;
                }
             }

            return response()->json(['data' =>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

        }elseif($id=="2"){



            $today_date  = date("Y-m-d");

            $now_time = Carbon::parse($today_date)->startOfDay();
            $end_time = Carbon::parse($today_date)->endOfDay();

            $total_today_bike_checkout =  AssignBike::whereDate('updated_at', '>=', $now_time)
                ->whereDate('updated_at', '<=', $end_time)
                ->where('status','=','0')
                ->pluck('passport_id')
                ->toArray();


//            dd($total_today_bike_checkout);

            $platforms = Platform::all();

            $array_to_send = array();

            foreach($platforms as $plt) {
                $assign_count = AssignPlateform::whereIn('passport_id', $total_today_bike_checkout)
                    ->where('plateform', '=', $plt->id)
                    ->where('status', '=', '1')
                    ->count();
                if($assign_count > 0 ){
                    $gamer = array(
                        'name' => $plt->name,
                        'total' => $assign_count,
                        'id' => $plt->id,
                    );
                    $array_to_send [] = $gamer;
                }
            }

            return response()->json(['data' =>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

        }elseif($id=="3"){


            $today_date  = date("Y-m-d");

            $now_time = Carbon::parse($today_date)->startOfDay();
            $end_time = Carbon::parse($today_date)->endOfDay();

            $today_sim_checkout = AssignSim::whereDate('updated_at', '>=', $now_time)
                ->whereDate('updated_at', '<=', $end_time)
                ->where('status','=','1')
                ->pluck('passport_id')
                ->toArray();

            $platforms = Platform::all();

            $array_to_send = array();

            foreach($platforms as $plt) {
                $assign_count = AssignPlateform::whereIn('passport_id', $today_sim_checkout)
                    ->where('plateform', '=', $plt->id)
                    ->where('status', '=', '1')
                    ->count();
                if($assign_count > 0 ){
                    $gamer = array(
                        'name' => $plt->name,
                        'total' => $assign_count,
                        'id' => $plt->id,
                    );
                    $array_to_send [] = $gamer;
                }
            }

            return response()->json(['data' =>$array_to_send], 200, [], JSON_NUMERIC_CHECK);



        }elseif($id=="4"){


            $today_date  = date("Y-m-d");

            $now_time = Carbon::parse($today_date)->startOfDay();
            $end_time = Carbon::parse($today_date)->endOfDay();

            $today_sim_checkout = AssignSim::whereDate('updated_at', '>=', $now_time)
                ->whereDate('updated_at', '<=', $end_time)
                ->where('status','=','0')
                ->pluck('passport_id')
                ->toArray();

            $platforms = Platform::all();

            $array_to_send = array();

            foreach($platforms as $plt){
                $assign_count = AssignPlateform::whereIn('passport_id', $today_sim_checkout)
                    ->where('plateform', '=', $plt->id)
                    ->where('status', '=', '1')
                    ->count();
                if($assign_count > 0 ){
                    $gamer = array(
                        'name' => $plt->name,
                        'total' => $assign_count,
                        'id' => $plt->id,
                    );
                    $array_to_send [] = $gamer;
                }
            }

            return response()->json(['data' =>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

        }elseif($id=="5"){

            $today_date  = date("Y-m-d");

            $now_time = Carbon::parse($today_date)->startOfDay();
            $end_time = Carbon::parse($today_date)->endOfDay();
            $platforms = Platform::all();

            $array_to_send = array();

            foreach($platforms as $plt) {

                $assign_count = AssignPlateform::whereDate('updated_at', '>=', $now_time)
                    ->whereDate('updated_at', '<=', $end_time)
                    ->where('status', '=', '1')
                    ->where('plateform', '=', $plt->id)
                    ->count();

                if($assign_count > 0 ){
                    $gamer = array(
                        'name' => $plt->name,
                        'total' => $assign_count,
                        'id' => $plt->id,
                    );
                    $array_to_send [] = $gamer;
                }
            }

            return response()->json(['data' =>$array_to_send], 200, [], JSON_NUMERIC_CHECK);


        }elseif($id=="6"){

            $today_date  = date("Y-m-d");

            $now_time = Carbon::parse($today_date)->startOfDay();
            $end_time = Carbon::parse($today_date)->endOfDay();
            $platforms = Platform::all();

            $array_to_send = array();

            foreach($platforms as $plt) {

                $assign_count = AssignPlateform::whereDate('updated_at', '>=', $now_time)
                    ->whereDate('updated_at', '<=', $end_time)
                    ->where('status', '=', '0')
                    ->where('plateform', '=', $plt->id)
                    ->count();

                if($assign_count > 0 ){
                    $gamer = array(
                        'name' => $plt->name,
                        'total' => $assign_count,
                        'id' => $plt->id,
                    );
                    $array_to_send [] = $gamer;
                }
            }

            return response()->json(['data' =>$array_to_send], 200, [], JSON_NUMERIC_CHECK);


        }

    }
}
