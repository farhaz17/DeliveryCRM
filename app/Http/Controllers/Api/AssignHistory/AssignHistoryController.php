<?php

namespace App\Http\Controllers\Api\AssignHistory;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Emirates_id_cards;
use App\Model\RiderProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssignHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $rider = RiderProfile::where('user_id', '=', $user_id)->first();

        $array_to_send = array();

          $bikes = AssignBike::where('passport_id','=',$rider->passport_id)->orderby('status','desc')->get();

          if(!empty($bikes)){
              foreach($bikes as $bike){
                  $time = explode(" ",$bike->checkin);
                  $checkout_dt = null;
                  if(!empty($bike->checkout)){
                      $checkout_dt = explode(" ",$bike->checkout);
                  }

                  $duration = null;

                  if(!empty($bike->checkin) && !empty($bike->checkout)){

                      $diff = abs(strtotime($bike->checkout) - strtotime($bike->checkin));
                      $years   = floor($diff / (365*60*60*24));
                      $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

                      $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                      $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                      $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

                      $duration = $days." days"." ".$hours." hrs"." ".$minuts." min";

                  }

                  $gamer = array(
                      'bike' =>  $bike->bike_plate_number->plate_no,
                      'checkin_date' => $time[0],
                      'checkin_time' =>  $time[1],
                      'checkout_date' =>  !empty($checkout_dt) ? $checkout_dt[0] : "Active",
                      'checkout_time' =>   !empty($checkout_dt) ? $checkout_dt[1] : "Active",
                      'duration' => !empty($duration) ?  $duration : "You are using this Bike",
                      'status' => $bike->status,
                  );
                  $array_to_send [] = $gamer;
              }
          }

        return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
    }

    public function sim_history(){

        $user_id = Auth::user()->id;
        $rider = RiderProfile::where('user_id', '=', $user_id)->first();

        $array_to_send = array();

        $sims = AssignSim::where('passport_id','=',$rider->passport_id)->orderby('status','desc')->get();

        if(!empty($sims)){
            foreach($sims as $sim){

                $time = explode(" ",$sim->checkin);
                $checkout_dt = null;
                if(!empty($sim->checkout)){
                    $checkout_dt =    explode(" ",$sim->checkout);
                }

                $duration = null;

                if(!empty($sim->checkin) && !empty($sim->checkout)){

                    $diff = abs(strtotime($sim->checkout) - strtotime($sim->checkin));
                    $years   = floor($diff / (365*60*60*24));
                    $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

                    $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                    $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

                    $duration = $days." days"." ".$hours." hrs"." ".$minuts." min";

                }

                $gamer = array(
                    'sim' =>  $sim->telecome->account_number,
                    'checkin_date' => $time[0],
                    'checkin_time' =>  $time[1],
                    'checkout_date' =>  !empty($checkout_dt) ? $checkout_dt[0] : "Active",
                    'checkout_time' =>   !empty($checkout_dt) ? $checkout_dt[1] : "Active",
                    'duration' => !empty($duration) ?  $duration : "You are using this Sim",
                    'status' => $sim->status,
                );
                $array_to_send [] = $gamer;
            }
        }

        return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);

    }

    public function platform_history(){

        $user_id = Auth::user()->id;
        $rider = RiderProfile::where('user_id', '=', $user_id)->first();

        $array_to_send = array();

        $platforms = AssignPlateform::where('passport_id','=',$rider->passport_id)->orderby('status','desc')->get();

        if(!empty($platforms)){
            foreach($platforms as $plt){

                $time = explode(" ",$plt->checkin);
                $checkout_dt = null;
                if(!empty($plt->checkout)){
                    $checkout_dt =    explode(" ",$plt->checkout);
                }

                $duration = null;

                if(!empty($plt->checkin) && !empty($plt->checkout)){

                    $diff = abs(strtotime($plt->checkout) - strtotime($plt->checkin));
                    $years   = floor($diff / (365*60*60*24));
                    $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

                    $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                    $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

                    $duration = $days." days"." ".$hours." hrs"." ".$minuts." min";

                }

                $gamer = array(
                    'platform' =>  $plt->plateformdetail->name,
                    'checkin_date' => $time[0],
                    'checkin_time' =>  $time[1],
                    'checkout_date' =>  !empty($checkout_dt) ? $checkout_dt[0] : "Active",
                    'checkout_time' =>   !empty($checkout_dt) ? $checkout_dt[1] : "Active",
                    'duration' => !empty($duration) ?  $duration : "You are in this Platform",
                    'status' => $plt->status,
                );
                $array_to_send [] = $gamer;
            }
        }

        return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);

    }

    public function get_passport_detail(){

        $user_id = Auth::user()->id;
        $rider = RiderProfile::where('user_id', '=', $user_id)->first();

        $gamer = array(
            'passport_number' =>  $rider->passport->passport_no,
            'issue_date' => $rider->passport->date_issue,
            'expire_date' =>  $rider->passport->date_expiry,
            'scan_pic' =>  !empty($rider->passport->passport_pic) ? $rider->passport->passport_pic : null,
            'national' =>   !empty($rider->passport->nation->name) ? $rider->passport->nation->name : null,
            'personal_mobile' =>   !empty($rider->passport->personal_info->personal_mob) ? $rider->passport->personal_info->personal_mob : null,
            'personal_email' =>   !empty($rider->passport->personal_info->personal_email) ? $rider->passport->personal_info->personal_email : null,
            'personal_image' =>   !empty($rider->passport->personal_info->personal_image) ? $rider->passport->personal_info->personal_image : null,

        );
        return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_emirates_id_detail(){
        $user_id = Auth::user()->id;
        $rider = RiderProfile::where('user_id', '=', $user_id)->first();

       $emirates = Emirates_id_cards::where('passport_id','=',$rider->passport_id)->first();

       $gamer= array();
       if(!empty($emirates)){
           $gamer = array(
               'card_no' =>  $emirates->card_no,
               'expire_date' => $emirates->expire_date,
               'card_front_pic' =>  !empty($emirates->card_front_pic) ? $emirates->card_front_pic : null,
               'card_back_pic' =>  !empty($emirates->card_back_pic) ? $emirates->card_back_pic : null,

           );
       }
      return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_driving_license_detail(){
        $user_id = Auth::user()->id;
        $rider = RiderProfile::where('user_id', '=', $user_id)->first();

        $driving_license = DrivingLicense::where('passport_id','=',$rider->passport_id)->first();

        $gamer= array();
        if(!empty($driving_license)){

            $liceense_type =  null;
            $car_type = null;
            if($driving_license->license_type=="1"){
                $liceense_type = "Bike";
            }elseif($driving_license->license_type=="2"){
                $liceense_type = "Car";
            }else{
                $liceense_type = "Both";
            }

            if(!empty($driving_license->car_type) && $driving_license->car_type=="1"){
                $car_type = "Automatic Car";
            }elseif(!empty($driving_license->car_type) && $driving_license->car_type=="2"){
                $car_type = "Manual Car";
            }

            $issue_date = null;
            if(isset($driving_license->issue_date)){
                $issue_date =  explode(" ",$driving_license->issue_date);
            }
            $expire_date = null;
            if(isset($driving_license->expire_date)){
                $expire_date =  explode(" ",$driving_license->expire_date);
            }

            $gamer = array(
                'license_number' =>  $driving_license->license_number,
                'issue_date' =>  isset($issue_date) ? $issue_date[0] : '',
                'expire_date' =>   isset($expire_date) ? $expire_date[0] : '',
                'place_issue' =>  $driving_license->place_issue,
                'traffic_code' =>  $driving_license->traffic_code,
                'license_type' =>  $liceense_type,
                'car_type' =>  $car_type,
                'front_image' =>   !empty($driving_license->image) ? $driving_license->image : null,
                'back_image' =>   !empty($driving_license->back_image) ? $driving_license->back_image : null,
            );
        }
        return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_user_codes(){

        $user_id = Auth::user()->id;

        $rider = RiderProfile::where('user_id', '=', $user_id)->first();
        $array_to_send = array();

        $array_to_send['zds_code'] =  isset($rider->passport->rider_zds_code->zds_code) ? $rider->passport->rider_zds_code->zds_code : '';
        $array_to_send['ppuid'] =  isset($rider->passport->pp_uid) ? $rider->passport->pp_uid : '';

        return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);

    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
