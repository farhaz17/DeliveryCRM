<?php

namespace App\Http\Controllers\Api\Interview;

use App\Model\CreateInterviews\CreateInterviews;
use App\Model\Guest\Career;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\Passport;
use App\Model\RiderProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Career\RejoinCareer;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

         $rider = RiderProfile::where('user_id','=',$user_id)->first();

         $status = null;
         $date_time = null;

         if(!empty($rider)){
              $interview = CreateInterviews::where('passport_id','=',$rider->passport_id)->orderby('id','desc')->first();
              $career = Career::where('passport_no','=',$rider->passport->passport_no)->first();
              if(!empty($interview)){
                  if($interview->acknowledge_status=="0" && empty($career->action_rider)){
                      $status = "0";
                      $date_time = $interview->date_time;
                  }elseif($interview->acknowledge_status=="1" && empty($career->action_rider)){

                      if($interview->interview_status=="1" && empty($career->action_rider)){
                          $status = "3";
                      }elseif($interview->interview_status=="2" && empty($career->action_rider)){
                          $status = "4";
                      }else{
                          $status = "1";
                      }

                  }elseif($interview->acknowledge_status=="2" && empty($career->action_rider)){
                      $status = "2";
                  }elseif(!empty($career->action_rider)){
                      $status = "5";
                  }
              }
         }

         $array_to_send = array(
             'status' =>   $status,
             'date_time' => $date_time,
         );

            return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_interview_log(){

        $user_id = Auth::user()->id;
        $rider = RiderProfile::where('user_id','=',$user_id)->first();
        $interviews = CreateInterviews::where('passport_id','=',$rider->passport_id)->orderby('id','desc')->get();

        $array_to_send = array();

        foreach($interviews as $inter){
            $status = "";
            $date_time = "";

            if($inter->acknowledge_status=="2"){
                if($inter->interview_status="2"){
                    $status = "Rejected";
                    $date_time = $inter->updated_at;
                }elseif($inter->interview_status="1"){
                    $status = "Selected";
                    $date_time = $inter->updated_at;
                }else{
                    $status = "Not Interested";
                    $date_time = $inter->updated_at;
                }
            }elseif($inter->acknowledge_status=="0"){
                $status = "No Response";
                $date_time = $inter->updated_at;
            }elseif($inter->acknowledge_status=="1"){
                $status = "Acknowled gedAckn owled gedA cknowl edged Acknowle dge dAcknow edgedAck nowled ged Acknowled gedAck nowledged";
                $date_time = $inter->updated_at;
            }

            $gamer = array(
                'status_board' => $status,
                'date_time' => $date_time,
            );

            $array_to_send [] = $gamer;

        }

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
        $user_id = Auth::user()->id;

        $rider = RiderProfile::where('user_id','=',$user_id)->first();
        $status = null;
        $date_time = null;

        if($request->status=="3"){

            Career::where('passport_no','=',$rider->passport->passport_no)->update(['action_rider'=>'1']);
            $response['code'] = 1;
            $response['message'] = "Action Selected";
            return response()->json($response);

        }elseif($request->status=="4"){
            Career::where('passport_no','=',$rider->passport->passport_no)->update(['action_rider'=>'2']);
            $response['code'] = 1;
            $response['message'] = "Action Selected";
            return response()->json($response);

        }else{

            if(!empty($rider)) {
                $interview = CreateInterviews::where('passport_id', '=', $rider->passport_id)->orderby('id','desc')->first();
                $interview->acknowledge_status =  $request->status;
                $interview->update();

                $passport = Passport::find($rider->passport_id);
                Career::where('passport_no','=',$passport->passport_no)->update(['hire_status'=>$request->status]);

                $onboard = OnBoardStatus::where('passport_id','=',$rider->passport_id)->first();

                      $my_status = 0;
                    $on_board_status ="";
                if($request->status=="2"){
                    $my_status = 1;
                    $on_board_status = "1";
                }else{
                    $my_status = 0;
                    $on_board_status = "0";
                }

                if($onboard != null){
                    $onboard->applicant_status = $my_status;
                    // $onboard->on_board = $on_board_status;
                    // i done bcz of oboard issue this comment
                    $onboard->update();
                }else{
                    $onboard_status = new OnBoardStatus();
                    $onboard_status->passport_id = $rider->passport->id;
                    $onboard->applicant_status = $my_status;
                    // $onboard->on_board = $on_board_status;
                     // i done bcz of oboard issue this comment
                    $onboard_status->save();
                }

                $response['code'] = 1;
                $response['message'] = "Thanks For your response";
                return response()->json($response);
            }

        }

    }

    public function interview_process(){

        $user_id = Auth::user()->id;

        $rider = RiderProfile::where('user_id','=',$user_id)->first();

        $pasport_id =   $rider->passport_id;

       $rejoin = RejoinCareer::where('passport_id','=',$pasport_id)->where('hire_status','=','0')->first();

       $current_status = "0";

           if($rejoin != null){

                        if($rejoin->on_board=="1"){
                            $current_status = "1"; //onboard
                        }elseif($rejoin->applicant_status=="5"){
                            $current_status = "2"; //wait list
                        }elseif($rejoin->applicant_status=="4"){
                            $current_status = "3"; //selected
                        }elseif($rejoin->applicant_status=="10"){
                            $current_status = "4"; // interview
                        }elseif($rejoin->applicant_status=="1"){
                            $current_status = "5"; // rejected
                        }
          }else{

             $passport = Passport::where('id','=',$pasport_id)->first();
             $career_id = $passport->career_id;



             if($career_id != "0"){

               $career_detail = Career::where('id','=',$career_id)->first();

               if($career_detail->applicant_status=="1"){
                 $current_status = "5"; // rejected
                 }elseif($career_detail->applicant_status=="5"){
                    $current_status = "2"; //wait list
                }elseif($career_detail->applicant_status=="4"){

                     $check_on_board = $career_detail->check_on_board();
                     $check_interview = $career_detail->check_interview_or_not();

                    $assing_platform = "";
                    if(isset($career_detail->passport_ppuid)){
                        $assing_platform = $career_detail->passport_ppuid->assign_platforms_checkin();
                    }

                   if(isset($assing_platform->plateformdetail)){
                    $current_status = "0"; //checkin
                    }elseif(isset($check_on_board)){
                        $current_status = "1"; //onboard
                     }elseif(isset($check_interview)){
                        $current_status = "4"; // interview
                     }else{
                        $current_status = "3"; //selected
                    }

                }

             }

          }



          $gamer = array(
            'status' => $current_status,
        );

        $array_to_send [] = $gamer;

         return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);


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
