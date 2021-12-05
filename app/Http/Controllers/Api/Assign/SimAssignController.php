<?php

namespace App\Http\Controllers\Api\Assign;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignSim;
use App\Model\Telecome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SimAssignController extends Controller
{
    //
    public function get_sim_no(){

//      $assign_sim=AssignSim::where("status","!=", 1)->get();
//      dd($assign_sim);
//      foreach ($assign_sim as $sim){
//
//
//        $sim_no=Telecome::where("id","!=",$sim->sim)->get();
//      }
             $sim_no=Telecome::get();


        return response()->json(['data'=>$sim_no], 200, [], JSON_NUMERIC_CHECK);

    }


    public function  assign_sim(Request $request)
    {
        $response = [];
        $current_timestamp = Carbon::now()->timestamp;

        try {

            $validator = Validator::make($request->all(), [
                'passport_id' => 'required',
                'sim_id' => 'required',
                'checkin' => 'required',

            ]);
            if ($validator->fails()) {

                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }


            $sim_id=$request->input('sim_id');
            $pass_id=  $request->input('passport_id');



            $passport_number=AssignSim::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
            $sim_number=AssignSim::where('sim',$sim_id)->latest('created_at')->first();



            if($sim_number != null && $passport_number != null ){

                if($passport_number->status!= "1" && $sim_number->status != "1" ){
                    $obj = new AssignSim();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->sim = $request->input('sim_id');
                    $obj->checkin = $request->input('checkin');
                    $obj->remarks = $request->input('remarks');
                    $obj->status = '1';
                    $obj->save();
                    $response['code'] = 1;
                    $response['message'] = 'SIM Assinged Successfully';
                    return response()->json($response);
                }else{

                    $response['code'] = 2;
                    $response['message'] = "SIM Already Assigned  and  Not checkout first else";
                    return response()->json($response);
                }

            }elseif($passport_number != null){

                if($passport_number->status!="1"){
                    $obj = new AssignSim();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->sim = $request->input('plate_id');
                    $obj->checkin = $request->input('sim_id');
                    $obj->remarks = $request->input('remarks');
                    $obj->status = '1';
                    $obj->save();
                    $response['code'] = 1;
                    $response['message'] = 'SIM Assinged Successfully';
                    return response()->json($response);
                }else{
                    $response['code'] = 2;
                    $response['message'] = "SIM Already Assigned and  Not checkout seconde else";
                    return response()->json($response);
                }

            }elseif($sim_number != null){

                if($sim_number->status!="1"){

                    $obj = new AssignSim();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->sim = $request->input('sim_id');
                    $obj->checkin = $request->input('checkin');
                    $obj->remarks = $request->input('remarks');
                    $obj->status = '1';
                    $obj->save();
                    $response['code'] = 1;
                    $response['message'] = 'SIM Assinged Successfully';
                    return response()->json($response);

                }else{

                    $response['code'] = 2;
                    $response['message'] = "SIM Already Assigned and Not checkout third eelse";
                    return response()->json($response);

                }

            }else{

                $obj = new AssignSim();
                $obj->passport_id = $request->input('passport_id');
                $obj->sim = $request->input('sim_id');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');
                $obj->status = '1';
                $obj->save();
                $response['code'] = 1;
                $response['message'] = 'SIM Assinged Successfully';
                return response()->json($response);

            }




        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }


    //get sim checked in name
    public function get_sim_checkout()
    {


        $sim_checkin = AssignSim::where("checkout", null)->get();
        $checkedin_sim_exist = array();
        foreach ($sim_checkin as $ab) {


            $gamer = array(
                'id' => $ab->id,
                'passport_id' => $ab->passport_id,
                'passport_no' => $ab->passport->passport_no,
                'sim_id' => $ab->sim,
                'sim_no' => $ab->telecome->account_number,
                'full_name' => $ab->passport->personal_info->full_name,
                'checkin' => $ab->checkin,
                'checkout' => $ab->checkout,
                'remarks' => $ab->remarks,
                'status' => $ab->status,
            );

            $checkedin_sim_exist [] = $gamer;
        }



        return response()->json(['data'=>$checkedin_sim_exist], 200, [], JSON_NUMERIC_CHECK);
    }

    public function sim_checkout(Request $request, $id)
    {
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
        $obj = AssignSim::find($id);

        $obj->checkout=$request->input('checkout');
        $obj->remarks=$request->input('remarks');
        $obj->status='0';
        $obj->save();

        $response['code'] = 1;
        $response['message'] = 'SIM checked-out Successfully!';
        return response()->json($response);
    }

}
