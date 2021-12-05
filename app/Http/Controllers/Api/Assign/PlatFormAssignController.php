<?php

namespace App\Http\Controllers\Api\Assign;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Platform;
use App\Model\Telecome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlatFormAssignController extends Controller
{
    //


    public function get_platform_name(){
        $platform=Platform::all();
       return response()->json(['data'=>$platform], 200, [], JSON_NUMERIC_CHECK);
    }



    public function  assign_platform(Request $request)
    {
        $response = [];
        $current_timestamp = Carbon::now()->timestamp;

        try {

            $validator = Validator::make($request->all(), [
                'passport_id' => 'required',
                'platform_id' => 'required',
                'checkin' => 'required',

            ]);
            if ($validator->fails()) {

                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }



            $pass_id=  $request->input('passport_id');
            $passport_number=AssignPlateform::where('passport_id','=',$pass_id)->orderby('id','desc')->first();




            if($passport_number != null){

                if($passport_number->status!= "1"){
                    $obj = new AssignPlateform();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->plateform = $request->input('platform_id');
                    $obj->checkin = $request->input('checkin');
                    $obj->remarks = $request->input('remarks');
                    $obj->status = '1';
                    $obj->save();
                    $response['code'] = 1;
                    $response['message'] = 'Platform Assinged Successfully';
                    return response()->json($response);
                }else{

                    $response['code'] = 2;
                    $response['message'] = "Platform Already Assigned  and  Not checkout first else";
                    return response()->json($response);
                }

            }
          else{

                $obj = new AssignPlateform();
                $obj->passport_id = $request->input('passport_id');
                $obj->plateform = $request->input('platform_id');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');
                $obj->status = '1';
                $obj->save();
                $response['code'] = 1;
                $response['message'] = 'Platform Assinged Successfully';
                return response()->json($response);

            }




        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }


    public function get_platform_checkout()
    {


        $platform_checkin = AssignPlateform::where("checkout", null)->get();
        $checkedin_plateform_exist = array();
        foreach ($platform_checkin as $ab) {


            $gamer = array(

                'id' => $ab->id,
                'passport_id' => $ab->passport_id,
                'platform_name' => $ab->plateformdetail->name,
                'platform_id' => $ab->plateform,
                'full_name' => $ab->passport->personal_info->full_name,
                'checkin' => $ab->checkin,
                'checkout' => $ab->checkout,
                'passport_no' => $ab->passport->passport_no,
                'remarks' => $ab->remarks,
                'status' => $ab->status,
            );

            $checkedin_plateform_exist [] = $gamer;
        }


//dd($checkedin_plateform_exist);
        return response()->json(['data'=>$checkedin_plateform_exist], 200, [], JSON_NUMERIC_CHECK);
    }

    public function platform_checkout(Request $request,$id){
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
        $obj = AssignPlateform::find($id);

        $obj->checkout=$request->input('checkout');
        $obj->remarks=$request->input('remarks');
        $obj->status='0';
        $obj->save();

        $response['code'] = 1;
        $response['message'] = 'Bike Checked-Out';
        return response()->json($response);
    }



}
