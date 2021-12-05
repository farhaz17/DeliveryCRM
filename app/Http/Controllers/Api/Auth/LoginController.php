<?php

namespace App\Http\Controllers\Api\Auth;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignReport;
use App\Model\Assign\AssignSim;
use App\Model\FcmToken;
use App\Model\Notifications\UserNotificationInfos;
use App\Model\Passport\Passport;
use App\Model\Performance\DeliverooPerformance;
use App\Model\Performance\DeliverooSetting;
use App\Model\RiderProfile;
use App\Model\Ticket;
use App\Model\TicketMessage;
use App\Model\UserCodes\UserCodes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Description;


class LoginController extends Controller
{
    use IssueTokenTrait;

    private $client;

    public function __construct()
    {
        $this->client = Client::find(2);
    }

    public function login(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'username' => 'email|required',
            'password' => 'required'
        ]);


        if($validator->fails()) {
            $response['success'] = 2;
            $response['message'] = $validator->errors()->first();
            return response()->json($response,400);
        }

        // $this->validate($request, [
        //     'username' => 'email|required',
        //     'password' => 'required'
        // ]);




        $user = User::where('email','=',$request->username)->where('user_group_id','!=','["4"]')->first();

        if($user != null){
            $response['success'] = 2;
            $response['message'] = 'Incorrect Credentials';
            return response()->json($response,400);
        }else{
            return $this->issueToken($request, 'password');
        }


    }

    public function refresh(Request $request)
    {

        $this->validate($request, [
            'refresh_token' => 'required'
        ]);

        return $this->issueToken($request, 'refresh_token');
    }

    public function get_checkin_detail()
    {
        //calculating average rating
//        $deliveroo = DeliverooPerformance::get();
//        $del_setting = DeliverooSetting::first();
//        foreach ($deliveroo as $del) {
//
//            if (isset($del->get_the_rider_id_by_platform('4')->platform_codes->passport->profile->id) == Auth::user()->id) {
//                $passport_id=$del->get_the_rider_id_by_platform('4')->platform_codes->passport->id;
//
//                $user_platform = AssignPlateform::where('passport_id',$passport_id)->where('status','1')->first();
//                //checking if platform assinged, else null
//                if (isset($user_platform))
//                {
//                    //check if platfrom is deliveroo and if not than average rating =NULL
//                    if ($user_platform->plateform == '4'){
//                        $ratings = DeliverooPerformance::where('rider_id',$del->rider_id)->get();
//                        foreach ($ratings as $rate){
//
//                            if ($rate->attendance < $del_setting->attendance_critical_value) {
//                                $att_rating = 1;
//                            } elseif ($rate->attendance >= $del_setting->attendance_critical_value && $rate->attendance < $del_setting->attendance_bad_value) {
//                                $att_rating = 2;
//                            } elseif ($rate->attendance >= $del_setting->attendance_bad_value && $rate->attendance < $del_setting->attendance_good_value) {
//                                $att_rating = 3;
//                            } elseif ($rate->attendance >= $del_setting->attendance_good_value) {
//                                $att_rating = 4;
//                            }
//                            //unassigned
//                            if ($rate->unassigned >= $del_setting->unassigned_critical_value) {
//                                $un_ass_rating = 1;
//                            } elseif ($rate->unassigned <= $del_setting->unassigned_critical_value && $rate->unassigned > $del_setting->unassigned_bad_value) {
//                                $un_ass_rating = 2;
//                            } elseif ($rate->unassigned <= $del_setting->unassigned_bad_value && $rate->unassigned > $del_setting->unassigned_good_value) {
//                                $un_ass_rating = 3;
//                            } elseif ($rate->unassigned <= $del_setting->unassigned_good_value) {
//                                $un_ass_rating = 4;
//                            }
//                            //wait at customer
//                            if ($rate->wait_time_at_customer >= $del_setting->wait_critical_value) {
//                                $wait_rating = 1;
//                            } elseif ($rate->wait_time_at_customer <= $del_setting->wait_critical_value && $rate->wait_time_at_customer > $del_setting->wait_bad_value) {
//                                $wait_rating = 2;
//                            } elseif ($rate->wait_time_at_customer <= $del_setting->wait_bad_value && $rate->wait_time_at_customer > $del_setting->wait_good_value) {
//                                $wait_rating = 3;
//                            } elseif ($rate->wait_time_at_customer <= $del_setting->wait_good_value) {
//                                $wait_rating = 4;
//                            }
//
////-----------------rating calculation--------------
//                            $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
//                            $final_avg = $avg_rating / 3;
//                            $final_rating = ($final_avg / 4) * 5;
//                            if ($del->attendance == 0) {
//                                $rating = 0.00;
//                            } else {
//                                $rating = number_format($final_rating, 2);
//                            }
//                            $array_rating[]=$rating;
//                        }
//                        $total_ratings=count($array_rating);
//                        $average_rating=array_sum($array_rating)/$total_ratings;
//                    }
//                    else{
//                        $average_rating='6';
//                    }
//
//                }
//
//            }
//
//
//        }



        $user_id = Auth::user()->id;

        $rider = RiderProfile::where('user_id', '=', $user_id)->first();
        $array_to_send = array();

        if (!empty($rider)) {
//            $assign_bkes = AssignBike::where('passport_id', '=', $rider->passport_id)
//                ->where('status', '=', '1')
//                ->first();
//
//            $assign_sim = AssignSim::where('passport_id', '=', $rider->passport_id)
//                ->where('status', '=', '1')
//                ->first();
//            $assign_platform = AssignPlateform::where('passport_id', '=', $rider->passport_id)
//                ->where('status', '=', '1')
//                ->first();
//
//            $array_to_send ['bike_number'] = isset($assign_bkes->bike_plate_number->plate_no) ? $assign_bkes->bike_plate_number->plate_no : '';
//
//            $bike_checkin = null;
//            $sim_checkin = null;
//            $platform_checkin = null;
//
//            if (isset($assign_bkes->checkin)) {
//                $ab = explode(" ", $assign_bkes->checkin);
//                $bike_checkin = $ab[0];
//            }
//            if (isset($assign_sim->checkin)) {
//                $ab = explode(" ", $assign_sim->checkin);
//                $sim_checkin = $ab[0];
//            }
//            if (isset($assign_platform->checkin)) {
//                $ab = explode(" ", $assign_platform->checkin);
//                $platform_checkin = $ab[0];
//            }



            $unread_notify = UserNotificationInfos::where('status', '=', '0')->where('user_ids', '=', $user_id)->count();

//            $array_to_send ['bike_checkin_time'] = $bike_checkin;
//            $array_to_send ['sim_number'] = isset($assign_sim->telecome->account_number) ? $assign_sim->telecome->account_number : '';
            $array_to_send['unread_notification'] = $unread_notify;

//            $array_to_send ['sim_checkin_time'] = $sim_checkin;
//            $array_to_send ['platform'] = isset($assign_platform->plateformdetail->name) ? $assign_platform->plateformdetail->name : '';
//            $array_to_send ['platform_check_in_time'] = $platform_checkin;
            $array_to_send ['full_name'] = isset($rider->passport->personal_info->full_name) ? $rider->passport->personal_info->full_name : '';
            $array_to_send ['rider_image'] = isset($rider->image) ? $rider->image : '';


//            $array_to_send['passport_number'] =  isset($rider->passport->passport_no) ? $rider->passport->passport_no : '';
            $array_to_send['passport_id'] =  isset($rider->passport->id) ? $rider->passport->id : '';
            $agreement_status=$rider->agreement_status;
            if ($agreement_status=='1'){
                $agreement_status_check='1';
            }
            else{
                $agreement_status_check='0';
            }

            $array_to_send['agreement_status']= $agreement_status_check;


            $ppuid_cancel=Passport::where('id',$rider->passport->id)->first();
            $ppuid_status= $ppuid_cancel->cancel_status;
            if ($ppuid_status==null){
                $ppuid_status_check='0';
            }
            else{
                $ppuid_status_check='1';
            }
            $array_to_send['ppuid_status']= $ppuid_status_check;


//            $array_to_send['zds_code'] =  isset($rider->passport->rider_zds_code->zds_code) ? $rider->passport->rider_zds_code->zds_code : '';
//            $array_to_send['emirates_id'] =  isset($rider->passport->emirates_id->card_no) ? str_replace("-","",$rider->passport->emirates_id->card_no) : '';
//            $array_to_send['license_number'] =  isset($rider->passport->driving_license->license_number) ? $rider->passport->driving_license->license_number : '';



            $sim_status = "0";
            $bike_status = "0";
            $platform_status = "0";

            $assign_report = AssignReport::where('passport_id','=',$rider->passport_id)->where('status','=','1')->first();

            if(!empty($assign_report)){
                $array_to_send['average_rating'] =  isset($average_rating) ? number_format($average_rating,'2') : '6';
//                $array_to_send['sim_verify_status'] = "1";
                $array_to_send['bike_verify_status'] = "1";
//                $array_to_send['platform_verify_status'] = "1";
//                $array_to_send['passport_verify_status'] = "1";
//                $array_to_send['license_verify_status'] = "1";
//                $array_to_send['zds_verify_status'] = "1";
//                $array_to_send['emirates_id_verify_status'] = "1";

            }else{
//                $array_to_send['sim_verify_status'] = "0";
//                $array_to_send['bike_verify_status'] = "0";
//                $array_to_send['platform_verify_status'] = "0";
//                $array_to_send['passport_verify_status'] = "0";
//                $array_to_send['license_verify_status'] = "0";
//                $array_to_send['zds_verify_status'] = "0";
//                $array_to_send['emirates_id_verify_status'] = "0";


                $array_to_send['average_rating'] = isset($average_rating) ? number_format($average_rating,'2'): '6' ;
//                $array_to_send['sim_verify_status'] = "1";
                $array_to_send['bike_verify_status'] = "1";
//                $array_to_send['platform_verify_status'] = "1";
//                $array_to_send['passport_verify_status'] = "1";
//                $array_to_send['license_verify_status'] = "1";
//                $array_to_send['zds_verify_status'] = "1";
//                $array_to_send['emirates_id_verify_status'] = "1";

            }

            $ticket_id = Ticket::where('user_id',$user_id)->pluck('id')->toArray();
            $total_unread_message = TicketMessage::whereIn('ticket_id',$ticket_id)
                                                ->where('user_type','=','1')
                                                ->where('is_read','1')->count();
            $array_to_send['total_unread_messages'] = $total_unread_message;


        }

        return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
    }




    public function logout(Request $request)
    {

        $accessToken = Auth::user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();
//        $accessToken->delete();
        return response()->json([], 204);

    }


}
