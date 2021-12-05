<?php

namespace App\Http\Controllers\Performance;

use App\Model\BikeDetail;
use App\Model\Performance\DeliverooPerformance;
use App\Model\Performance\DeliverooSetting;
use App\Model\Platform;
use App\Model\PlatformCode\PlatformCode;
use App\Model\UserCodes\UserCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Quotation;
use PhpParser\Node\Stmt\DeclareDeclare;
use Calendar;

class PerformanceController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|performance-upload-performance', ['only' => ['index','store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|performance-upload-performance', ['only' => ['view_performance']]);
        $this->middleware('role_or_permission:Admin|performance-two-weeks-rating', ['only' => ['two_weeks']]);
        $this->middleware('role_or_permission:Admin|performance-over-all-rating', ['only' => ['all_rating']]);
        $this->middleware('role_or_permission:Admin|performance-performance-setting', ['only' => ['performance_setting']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $platforms=Platform::where('platform_category',1)->get();
        $platform_values=$platforms->whereIn('id',auth()->user()->user_platform_id)->first();
        $platform_name= $platform_values->name;
        $platform_id= $platform_values->id;
        $events = [];
        $data  = DeliverooPerformance::distinct()->Orderby('date_from','desc')->get(['date_from','date_to']);
        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    'Sheet Uploaded',
                    true,
                    new \DateTime($value->date_from),
                    new \DateTime($value->date_to.' +1 day'),
                    null,
                    [
                        'color' => '#f05050',
                        'contentHeight' => 100,
                    ]);}}
        $calendar = Calendar::addEvents($events);
        $msp_rider_ids=PlatformCode::pluck('platform_code')->toArray();
        $deliveroo = DB::table('deliveroo_performances')
            ->select('rider_id')
            ->whereNotIn('rider_id',$msp_rider_ids)
            ->groupBy('rider_id')
            ->get();
        return view('admin-panel.performance.upload_performance',compact('platforms','calendar','platform_name','platform_id','deliveroo'));
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

        $date_from= $id;
        $deliveroo = DeliverooPerformance::where('date_from',$date_from)->get();
        $range = DeliverooPerformance::where('date_from',$date_from)->first();

//        -----------------rating calculation--------
        $del_setting = DeliverooSetting::first();

        $final_rating_riders = array(
        );



//        $recent_dates = DeliverooPerformance::where('date_from','<', date('Y-m-d'))->orderBy('date_from', 'DESC')
//            ->get();
//        dd($recent_dates);
        $date_ranges = DB::table('deliveroo_performances')
            ->select('date_to','date_from')
            ->distinct('date_to')
            ->orderBy('date_to', 'desc')
            ->limit('2')
            ->get();

        $last_two_weeks=array();
        foreach ($date_ranges as $dates) {
            $res = array(
                "date_from" => $dates->date_from,
            );
            $last_two_weeks[]= $res;
        }


        $from=$last_two_weeks;


//        $averrage_rating = DeliverooPerformance::whereIn('date_from',$from)
//            ->groupBy('rider_id')
//            ->get();

        $averrage_rating = DeliverooPerformance::selectRaw('rider_id,AVG(attendance) as attendance,AVG(unassigned) as unassigned,AVG(wait_time_at_customer) as wait_time_at_customer')
           ->whereIn('date_from',$from)
            ->groupBy('rider_id')
            ->get();

//        dd($averrage_rating);


//dd($averrage_rating);

        //now calclute average rating
        $sum_avg=array();



foreach ($averrage_rating as $avg) {

    if ($avg->attendance < $del_setting->attendance_critical_value) {
        $att_rating = 1;
    } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
        $att_rating = 2;
    } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
        $att_rating = 3;
    } elseif ($avg->attendance >= $del_setting->attendance_good_value) {
        $att_rating = 4;
    }
//    echo $avg->rider_id.'<br>';
//    echo 'Attendance'.$avg->attendance.'<br>';
//    echo 'att_rating'.$att_rating.'<br>';
    //unassigned
    if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
        $un_ass_rating = 1;
    } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
        $un_ass_rating = 2;
    } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
        $un_ass_rating = 3;
    } elseif ($avg->unassigned <= $del_setting->unassigned_good_value) {
        $un_ass_rating = 4;
    }
    //wait at customer
//echo 'unassinged'.$avg->unassigned.'<br>';
//echo 'unassinged_rating'.$un_ass_rating.'<br>';

    if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
        $wait_rating = 1;
    } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
        $wait_rating = 2;
    } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
        $wait_rating = 3;
    } elseif ($avg->wait_time_at_customer <= $del_setting->wait_good_value) {
        $wait_rating = 4;
    }
//    echo 'Wait'.$avg->wait_time_at_customer.'<br>';
//    echo 'Wait rating'.$wait_rating.'<br>';

//-----------------rating calculation--------------

    $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
    $final_avg = $avg_rating / 3;
    $final_rating = ($final_avg / 4) * 5;
    if ($avg->attendance == 0) {
        $rating = 0.00;
    } else {
        $rating = number_format($final_rating, 2);
    }


//    echo $rating.'<br>';
//    echo $avg->rider_id.'<br>';

//    $gamer = array(
//        'rider_id' => $avg->rider_id,
//        'rating' => floatval($rating)
//    );
//
//    $final_rating_riders [] = $gamer;


}
//dd();




//






        return view('admin-panel.performance.deliveroo_show',compact('deliveroo','range','del_setting','averrage_rating'));

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
    public  function performance_setting(){

        $delivroo_settings = DeliverooSetting::first();
        return view('admin-panel.performance.performance_setting',compact('delivroo_settings'));
    }

    public function performance_setting_edit(Request $request){
        $delivroo_settings = DeliverooSetting::first();
        $view = view("admin-panel.performance.ajax_deliveroo_settings",compact('delivroo_settings'))->render();
        return response()->json(['html'=>$view]);
    }
    public  function deliveroo_settings_store(Request $request){
            //add try catch


        $obj = new DeliverooSetting();

        $obj->attendance_critical_value = $request->input('attendance_critical_value');
        $obj->attendance_bad_value = $request->input('attendance_bad_value');
        $obj->attendance_good_value = $request->input('attendance_good_value');
        $obj->unassigned_critical_value = $request->input('unassigned_critical_value');
        $obj->unassigned_bad_value = $request->input('unassigned_bad_value');
        $obj->unassigned_good_value = $request->input('unassigned_good_value');
        $obj->wait_critical_value = $request->input('wait_critical_value');
        $obj->wait_bad_value = $request->input('wait_bad_value');
        $obj->wait_good_value = $request->input('wait_good_value');

        $obj->save();

        $message = [
            'message' => 'Deliveroo Crtical Settings Saved Successfully!',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
    }

    public function deliveroo_setting_update(Request $request, $id){

        $obj = DeliverooSetting::find($id);
        $obj->attendance_critical_value = $request->input('attendance_critical_value');
        $obj->attendance_bad_value = $request->input('attendance_bad_value');
        $obj->attendance_good_value = $request->input('attendance_good_value');
        $obj->unassigned_critical_value = $request->input('unassigned_critical_value');
        $obj->unassigned_bad_value = $request->input('unassigned_bad_value');
        $obj->unassigned_good_value = $request->input('unassigned_good_value');
        $obj->wait_critical_value = $request->input('wait_critical_value');
        $obj->wait_bad_value = $request->input('wait_bad_value');
        $obj->wait_good_value = $request->input('wait_good_value');
        $obj->save();
        $message = [
            'message' => 'Deliveroo Crtical Settings Updated  Successfully!',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
    }

    public  function view_performance(){

        $date_ranges = DB::table('deliveroo_performances')
            ->select('date_to','date_from')
            ->distinct('date_to')
            ->orderBy('date_to', 'desc')
            ->limit('5')
            ->get();
        $total_number=DeliverooPerformance::all();



        return view('admin-panel.performance.performance_view',compact('date_ranges','total_number'));

    }
    public function show_deliveroo_performance(Request $request,$id){
//    dd("adfsdfasdf");
        $date_from= $id;
        $deliveroo = DeliverooPerformance::where('date_from',$date_from)->get();
        $range = DeliverooPerformance::where('date_from',$date_from)->first();

        return view('admin-panel.performance.deliveroo_show',compact('deliveroo','range'));


//        $view = view("admin-panel.performance.ajax_deliveroo_show",compact('deliveroo'))->render();
//
//        return response()->json(['html'=>$view]);
    }



    public  function two_weeks(){



        $date_ranges = DB::table('deliveroo_performances')
            ->select('date_to','date_from')
            ->distinct('date_to')
            ->orderBy('date_to', 'desc')
            ->limit('2')
            ->get();

        $last_two_weeks=array();
        foreach ($date_ranges as $dates) {
            $res = array(
                "date_from" => $dates->date_from,
            );
            $last_two_weeks[]= $res;
        }


        $from=$last_two_weeks;
        $del_setting = DeliverooSetting::first();

        $averrage_rating = DeliverooPerformance::selectRaw('rider_id,MAX(rider_name) as rider_name,SUM(hours_scheduled) as hours_scheduled,SUM(hours_worked) as hours_worked, SUM(no_of_orders_delivered) as no_of_orders_delivered, AVG(attendance) as attendance,AVG(unassigned) as unassigned,AVG(wait_time_at_customer) as wait_time_at_customer')
            ->whereIn('date_from',$from)
            ->groupBy('rider_id')->get();

//
//        foreach ($averrage_rating as $avg) {
//
//            if ($avg->attendance < $del_setting->attendance_critical_value) {
//                $att_rating = 1;
//            } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
//                $att_rating = 2;
//            } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
//                $att_rating = 3;
//            } elseif ($avg->attendance >= $del_setting->unassigned_good_value) {
//                $att_rating = 4;
//            }
//            //unassigned
//            if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
//                $un_ass_rating = 1;
//            } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
//                $un_ass_rating = 2;
//            } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
//                $un_ass_rating = 3;
//            } elseif ($avg->unassigned <= $del_setting->unassigned_good_value) {
//                $un_ass_rating = 4;
//            }
//            //wait at customer
//
//
//            if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
//                $wait_rating = 1;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
//                $wait_rating = 2;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
//                $wait_rating = 3;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->unassigned_good_value) {
//                $wait_rating = 4;
//            }
//
////-----------------rating calculation--------------
//
//            $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
//            $final_avg = $avg_rating / 3;
//            $final_rating = ($final_avg / 4) * 5;
//            if ($avg->attendance == 0) {
//                $rating = 0.00;
//            } else {
//                $rating = number_format($final_rating, 2);
//            }
//
//
//
//        }



        return view('admin-panel.performance.two_weeks',compact('del_setting','averrage_rating'));

    }





    public  function all_rating(){


        $del_setting = DeliverooSetting::first();

        $averrage_rating = DeliverooPerformance::selectRaw('rider_id,MAX(rider_name) as rider_name,SUM(hours_scheduled) as hours_scheduled,SUM(hours_worked) as hours_worked, SUM(no_of_orders_delivered) as no_of_orders_delivered,AVG(attendance) as attendance,AVG(unassigned) as unassigned,AVG(wait_time_at_customer) as wait_time_at_customer')
            ->groupBy('rider_id')->get();


//        foreach ($averrage_rating as $avg) {
//
//            if ($avg->attendance < $del_setting->attendance_critical_value) {
//                $att_rating = 1;
//            } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
//                $att_rating = 2;
//            } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
//                $att_rating = 3;
//            } elseif ($avg->attendance >= $del_setting->unassigned_good_value) {
//                $att_rating = 4;
//            }
//            //unassigned
//            if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
//                $un_ass_rating = 1;
//            } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
//                $un_ass_rating = 2;
//            } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
//                $un_ass_rating = 3;
//            } elseif ($avg->unassigned <= $del_setting->unassigned_good_value) {
//                $un_ass_rating = 4;
//            }
//            //wait at customer
//
//
//            if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
//                $wait_rating = 1;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
//                $wait_rating = 2;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
//                $wait_rating = 3;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->unassigned_good_value) {
//                $wait_rating = 4;
//            }
//
////-----------------rating calculation--------------
//
//            $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
//            $final_avg = $avg_rating / 3;
//            $final_rating = ($final_avg / 4) * 5;
//            if ($avg->attendance == 0) {
//                $rating = 0.00;
//            } else {
//                $rating = number_format($final_rating, 2);
//            }
//
//
//        }


        return view('admin-panel.performance.all_rating',compact('del_setting','averrage_rating'));

    }


}
