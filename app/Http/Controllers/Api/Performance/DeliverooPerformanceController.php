<?php

namespace App\Http\Controllers\Api\Performance;

use App\Model\Performance\DeliverooPerformance;
use App\Model\Performance\DeliverooSetting;
use App\Model\PlatformCode\PlatformCode;
use App\Model\UserCodes\UserCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Auth;

class DeliverooPerformanceController extends Controller
{
    //

    public function get_performance()
    {

        $date_ranges = DB::table('deliveroo_performances')
            ->select('date_to', 'date_from')
            ->distinct('date_to')
            ->get();
        return response()->json(['data' => $date_ranges], 200, [], JSON_NUMERIC_CHECK);
    }


    public function get_performance_detail(Request $request)
    {


//        $date_from= $request->date_from;
//        $result = DeliverooPerformance::where('date_from',$date_from)->where('rider_id',80880)->get();
//        return response()->json(['data'=>$result], 200, [], JSON_NUMERIC_CHECK);


//        if (isset($request->date_from)){
        $date_from = $request->date_from;

        $rider_id = DeliverooPerformance::get();
//dd($rider_id);
//        $gamer=array();


        $gamer = array();
        foreach ($rider_id as $rider) {
//
            if (isset($rider->get_the_rider_id_by_platform('4')->passport->profile->id) == Auth::user()->id) {


                $user_id = Auth::user()->id;
                $plate_code = $rider->rider_id;


                $result = DeliverooPerformance::where('date_from', $date_from)->where('rider_id', $plate_code)->get();



                $del_setting = DeliverooSetting::first();

                foreach ($result as $del) {


                    //attendance value
                    if (isset($del->get_the_rider_id_by_platform('4')->passport->profile->id) == Auth::user()->id) {
                        if ($del->attendance < $del_setting->attendance_critical_value) {
                            $att_rating = 1;
                        } elseif ($del->attendance >= $del_setting->attendance_critical_value && $del->attendance < $del_setting->attendance_bad_value) {
                            $att_rating = 2;
                        } elseif ($del->attendance >= $del_setting->attendance_bad_value && $del->attendance < $del_setting->attendance_good_value) {
                            $att_rating = 3;
                        } elseif ($del->attendance >= $del_setting->attendance_bad_value) {
                            $att_rating = 4;
                        }
                        //unassigned
                        if ($del->unassigned >= $del_setting->unassigned_critical_value) {
                            $un_ass_rating = 1;
                        } elseif ($del->unassigned <= $del_setting->unassigned_critical_value && $del->unassigned > $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 2;
                        } elseif ($del->unassigned <= $del_setting->unassigned_bad_value && $del->unassigned > $del_setting->unassigned_good_value) {
                            $un_ass_rating = 3;
                        } elseif ($del->unassigned <= $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 4;
                        }
                        //wait at customer


                        if ($del->wait_time_at_customer >= $del_setting->wait_critical_value) {
                            $wait_rating = 1;
                        } elseif ($del->wait_time_at_customer <= $del_setting->wait_critical_value && $del->wait_time_at_customer > $del_setting->wait_bad_value) {
                            $wait_rating = 2;
                        } elseif ($del->wait_time_at_customer <= $del_setting->wait_bad_value && $del->wait_time_at_customer > $del_setting->wait_good_value) {
                            $wait_rating = 3;
                        } elseif ($del->wait_time_at_customer <= $del_setting->wait_bad_value) {
                            $wait_rating = 4;
                        }

//-----------------rating calculation--------------

                        $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
                        $final_avg = $avg_rating / 3;
                        $final_rating = ($final_avg / 4) * 5;
                        if ($del->attendance == 0) {
                            $rating = 0.00;
                        } else {
                            $rating = number_format($final_rating, 2);
                        }


                        $gamer = array(

                            'user_id' => Auth::user()->id,
//                                'rider_id' => isset($del->get_the_rider_id_by_platform('4')->passport) ? $del->get_the_rider_id_by_platform('4')->platform_code->platform_code : "N/A",
//                                'full_name' => isset($del->get_the_rider_id_by_platform('4')->passport->personal_info->full_name) ? $del->get_the_rider_id_by_platform('4')->passport->personal_info->full_name : "N/A",
                            'hours_scheduled' => $del->hours_scheduled,
                            'hours_worked' => $del->hours_worked,
                            'attendance' => $del->attendance,
                            'no_of_orders_delivered' => $del->no_of_orders_delivered,
                            'no_of_orders_unassignedr' => $del->no_of_orders_unassignedr,
                            'unassigned' => $del->unassigned,
                            'wait_time_at_customer' => $del->wait_time_at_customer,
                            'rating' => $rating,
//                                'attendance_critcle_val'=>$del_setting->attendance_critical_value,
//                                'attendance_bad_value'=>$del_setting->attendance_bad_value,
//                                'attendance_good_value'=>$del_setting->attendance_good_value,
//                                'unassigned_critical_value'=>$del_setting->unassigned_critical_value,
//                                'unassigned_good_value'=>$del_setting->unassigned_good_value,
//                                'unassigned_bad_value'=>$del_setting->unassigned_bad_value,
//                                'wait_critical_value'=>$del_setting->wait_critical_value,
//                                'wait_bad_value'=>$del_setting->wait_bad_value,
//                                'wait_good_value'=>$del_setting->wait_good_value,

                        );
//                    $x []=$gamer;

                    }
                }


//                    $result = DeliverooPerformance::where('rider_id','=',$r_id)->where('date_from','=',$request->date_from)->get();
            }
            return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);
        }




    }


//        }
//        else{
//
//
//        $deliveroo = DeliverooPerformance::get();
//        $del_setting = DeliverooSetting::first();
//        $gamer = [];
////        $performance_data = array();
//        foreach ($deliveroo as $del) {
//
//            //attendance value
//            if (isset($del->get_the_rider_id_by_platform('4')->platform_codes->passport->profile->id) == Auth::user()->id) {
////            if (isset($del->platform_code->passport->profile->user_id) == Auth::user()->id){
////            $user_id=isset($del->platform_code)?$del->platform_code->passport->profile->id
//
//                if ($del->attendance < $del_setting->attendance_critical_value) {
//                    $att_rating = 1;
//                } elseif ($del->attendance >= $del_setting->attendance_critical_value && $del->attendance < $del_setting->attendance_bad_value) {
//                    $att_rating = 2;
//                } elseif ($del->attendance >= $del_setting->attendance_bad_value && $del->attendance < $del_setting->attendance_good_value) {
//                    $att_rating = 3;
//                } elseif ($del->attendance >= $del_setting->attendance_bad_value) {
//                    $att_rating = 4;
//                }
//                //unassigned
//                if ($del->unassigned >= $del_setting->unassigned_critical_value) {
//                    $un_ass_rating = 1;
//                } elseif ($del->unassigned <= $del_setting->unassigned_critical_value && $del->unassigned > $del_setting->unassigned_bad_value) {
//                    $un_ass_rating = 2;
//                } elseif ($del->unassigned <= $del_setting->unassigned_bad_value && $del->unassigned > $del_setting->unassigned_good_value) {
//                    $un_ass_rating = 3;
//                } elseif ($del->unassigned <= $del_setting->unassigned_bad_value) {
//                    $un_ass_rating = 4;
//                }
//                //wait at customer
//
//
//                if ($del->wait_time_at_customer >= $del_setting->wait_critical_value) {
//                    $wait_rating = 1;
//                } elseif ($del->wait_time_at_customer <= $del_setting->wait_critical_value && $del->wait_time_at_customer > $del_setting->wait_bad_value) {
//                    $wait_rating = 2;
//                } elseif ($del->wait_time_at_customer <= $del_setting->wait_bad_value && $del->wait_time_at_customer > $del_setting->wait_good_value) {
//                    $wait_rating = 3;
//                } elseif ($del->wait_time_at_customer <= $del_setting->wait_bad_value) {
//                    $wait_rating = 4;
//                }
//
////-----------------rating calculation--------------
//
//                $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
//                $final_avg = $avg_rating / 3;
//                $final_rating = ($final_avg / 4) * 5;
//                if ($del->attendance == 0) {
//                    $rating = 0.00;
//                } else {
//                    $rating = number_format($final_rating, 2);
//                }
//
//
//                $gamer = array(
//                    'user_id' => isset($del->get_the_rider_id_by_platform('4')->platform_code->passport->profile->id) ? $del->get_the_rider_id_by_platform('4')->platform_code->passport->profile->id : "N/A",
//                    'rider_id' => isset($del->get_the_rider_id_by_platform('4')->platform_code) ? $del->get_the_rider_id_by_platform('4')->platform_code->platform_code : "N/A",
//                    'full_name' => isset($del->get_the_rider_id_by_platform('4')->platform_code) ? $del->get_the_rider_id_by_platform('4')->platform_code->passport->personal_info->full_name : "N/A",
//                    'hours_scheduled' => isset($del->hours_scheduled) ? $del->hours_scheduled : "N/A",
//                    'hours_worked' => isset($del->hours_worked) ? $del->hours_worked : "",
//                    'attendance' => isset($del->attendance) ? $del->attendance : "",
//                    'no_of_orders_delivered' => isset($del->no_of_orders_delivered) ? $del->no_of_orders_delivered : "N/A",
//                    'no_of_orders_unassignedr' => isset($del->no_of_orders_unassignedr) ? $del->no_of_orders_unassignedr : "N/A",
//                    'unassigned' => isset($del->unassigned) ? $del->unassigned : "N/A",
//                    'wait_time_at_customer' => isset($del->wait_time_at_customer) ? $del->wait_time_at_customer : "N/A",
//                    'rating' => $rating,
//                    'attendance_critcle_val'=>$del_setting->attendance_critical_value,
//                    'attendance_bad_value'=>$del_setting->attendance_bad_value,
//                    'attendance_good_value'=>$del_setting->attendance_good_value,
//                    'unassigned_critical_value'=>$del_setting->unassigned_critical_value,
//                    'unassigned_good_value'=>$del_setting->unassigned_good_value,
//                    'unassigned_bad_value'=>$del_setting->unassigned_bad_value,
//                    'wait_critical_value'=>$del_setting->wait_critical_value,
//                    'wait_bad_value'=>$del_setting->wait_bad_value,
//                    'wait_good_value'=>$del_setting->wait_good_value,
//
//                );
//
//
//            }
//        }
//        }
//
//
//        return response()->json(['data'=>$gamer], 200, [], JSON_NUMERIC_CHECK);







    public  function get_dates(){
        $dates = DB::table('deliveroo_performances')
            ->select('date_to','date_from')
            ->distinct('date_to')
            ->orderBy('date_to', 'desc')
            ->limit('5')
            ->get();

        $data=array();
        foreach ($dates as $date) {
            $res = array(
                "date_val" => $date->date_from.' - '.$date->date_to,
                "date_from" => $date->date_from,
            );
            $data[]= $res;
        }
        return response()->json(['data'=>$data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_week_rating( Request $request){


        $date_from=$request->date_from;

        $rider_id = DeliverooPerformance::get();
//dd($rider_id);



        foreach ($rider_id as $rider) {

            if (isset($rider->get_the_rider_id_by_platform('4')->platform_code->passport->profile->id) == Auth::user()->id)
            {
//                dd("2020-08-22");
                $user_id=Auth::user()->id;
                $plate_code=$rider->rider_id;



//
//
                $result = DeliverooPerformance::where('date_from',$date_from)->where('rider_id',$plate_code)->get();


//                    $result = DeliverooPerformance::where('rider_id','=',$r_id)->where('date_from','=',$request->date_from)->get();
            }
        }
    }


}
