<?php

namespace App\Http\Controllers\Api\RiderOrderDetail;

use App\Model\Cods\Cods;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\RiderOrderDetail\RiderOrderRates;
use App\Model\RiderProfile;
use App\Model\UnassignedOrders;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Image;

class RiderOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user_id = Auth::user()->id;

        $rider_profile = RiderProfile::where('user_id','=',$user_id)->first();

        $user_passport_id = $rider_profile->passport_id;

        $grand_total_order = 0;

        if(!empty($request->start_date) &&  !empty($request->end_date) ){
            $end_date = $request->end_date." 23:59:00";
            $start_date = $request->start_date." 00:01:00";
            $data = RiderOrderDetail::where('passport_id','=',$user_passport_id)->whereBetween('start_date_time', [$start_date, $end_date])->orderby('start_date_time')->get();
            $grand_total_order = RiderOrderDetail::where('passport_id','=',$user_passport_id)->whereBetween('start_date_time', [$start_date, $end_date])->sum('total_order');
        }else{
            $data = RiderOrderDetail::where('passport_id','=',$user_passport_id)->orderby('start_date_time')->get();
            $grand_total_order = RiderOrderDetail::where('passport_id','=',$user_passport_id)->sum('total_order');
        }

        return response()->json(['data' => $data,'grand_total_order' =>$grand_total_order], 200, [], JSON_NUMERIC_CHECK);

    }

    public function rider_order_seven_days(){


        $user_id = Auth::user()->id;

        $rider_profile = RiderProfile::where('user_id','=',$user_id)->first();

        $user_passport_id = $rider_profile->passport_id;

        $last_seven = \Carbon\Carbon::today()->subDays(7);

        $grand_total_order = 0;

            $data = RiderOrderDetail::where('passport_id','=',$user_passport_id)->where('start_date_time', '>=', $last_seven)->orderby('start_date_time')->get();
            $grand_total_order = RiderOrderDetail::where('passport_id','=',$user_passport_id)->where('start_date_time', '>=', $last_seven)->sum('total_order');

        return response()->json(['data' => $data,'grand_total_order' =>$grand_total_order], 200, [], JSON_NUMERIC_CHECK);

    }

    public function save_unassigned_order(Request $request){

        $current_timestamp = Carbon::now()->timestamp;
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'no_of_orders' => 'required',
            'image' => 'required',
            'reason' => 'required',
        ]);
        if ($validator->fails()) {
            $response['code'] = 2;
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }

        $riderProfile = User::find(Auth::user()->id);

        $user_passport_id = $riderProfile->profile->passport_id;

        $check_in_platform = $riderProfile->profile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();




        if(!empty($check_in_platform)) {



            $image_name = "";
            if(!empty($_FILES['image']['name'])) {
                $date_folder = date("Y-m-d");
                // if (!file_exists('./assets/upload/unassignedorder/'.$date_folder."/")) {
                //     mkdir('./assets/upload/unassignedorder/'.$date_folder."/", 0777, true);
                // }
                // $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                // $file1 = rand(0,1000000).$current_timestamp.'.'.$ext;
                // move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/unassignedorder/'.$date_folder."/".$file1);
                // $image_name = '/assets/upload/unassignedorder/'.$date_folder."/" . $file1;
                $img = $request->file('image');
                $image_name = '/assets/upload/riderorder/'.$date_folder."/" .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($image_name, $imageS3->stream());
            }

            $rider_order_date = RiderOrderDetail::where('platform_id','=',$check_in_platform)
                ->where('passport_id','=',$user_passport_id)
                ->where('start_date_time','LIKE','%'.$request->date.'%')->first();

            if($rider_order_date==null){

                $response['code'] = 1;
                $response['message'] = "Please send your daily order first";
                return response()->json($response);

            }



            $obj = new UnassignedOrders();
            $obj->passport_id = $user_passport_id;
            $obj->platform_id = $check_in_platform;
            $obj->no_of_orders = $request->no_of_orders;
            $obj->order_date = $request->date;
            $obj->reason = $request->reason;
            $obj->image = $image_name;
            if($request->reason=="Other"){
             $obj->other_reason =  $request->other_reason;
            }
            $obj->save();

            $response['code'] = 1;
            $response['message'] = "Unassigned order saved successfully";
            return response()->json($response);

        }else{

            $response['code'] = 2;
            $response['message'] = "Platform is not assigned";
            return response()->json($response);

        }


    }



    public function tick_under_days(){


        $current_date = date("Y-m-d");

//        $begin_date = strtotime(date("Y-m-d", strtotime("-3 day")));
        $begin_date = date("Y-m-d", strtotime("-3 day"));
//        dd($begin_date);
        $end_date = date("Y-m-d", strtotime("+3 day"));

        $begin = new DateTime($begin_date);
        $end   = new DateTime($end_date);


        $user_id = Auth::user()->id;

        $rider_profile = RiderProfile::where('user_id','=',$user_id)->first();

        $user_passport_id = $rider_profile->passport_id;

        $array_to_send = array();

        for($i = $begin; $i <= $end; $i->modify('+1 day')){
            $data = RiderOrderDetail::where('passport_id','=',$user_passport_id)->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->count();
            $gamer = array(
                'ticks' => $data,
                'date' => $i->format("Y-m-d"),
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
        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
//        try {

            $validator = Validator::make($request->all(), [
                'start_date_time' => 'required',
                'end_date_time' => 'required',
                'image' => 'required',
                'total_order' => 'required',
            ]);
            if ($validator->fails()) {
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

             $final_start_date_time = "";
            $final_end_date_time  = "";

            $date1 = $request->start_date_time;
            $date2 = $request->end_date_time;

        $final_start_date_time = $request->start_date_time;

           $start_time = explode(" ",$date1);
//           $end_time  =  explode(" ",$date2);

            $st_time = strtotime($start_time[1]);
            $ed_time = strtotime($date2);

            if($ed_time > $st_time){

             $date2  = $start_time[0]." ".$request->end_date_time;

                $final_end_date_time = $date2;

//                echo "we are in greater end time"."<br>";

            }elseif($ed_time < $st_time){
                $en_d_now_date = date("Y-m-d", strtotime($start_time[0]."+1 day"));

                $date2  = $en_d_now_date." ".$request->end_date_time;

                $final_end_date_time =  $date2;

//                echo "we are in less end time"."<br>";
            }else{
                $final_end_date_time =  $start_time[0]." ".$request->end_date_time;
            }




//            echo "start date".$final_start_date_time."<br>";
//        echo "end date".$final_end_date_time."<br>";

//            die();




            $timestamp1 = strtotime($final_start_date_time);
            $timestamp2 = strtotime($final_end_date_time);
            $hour = abs($timestamp2 - $timestamp1)/(60*60);

//            dd($hour);

            if($hour > 24){
                $response['code'] = 2;
                $response['message'] = "Shift time should not be Exceed from 24 hours";
                return response()->json($response);
            }

            $opening_date = new DateTime($final_start_date_time);
            $closing_date = new DateTime($final_end_date_time);
            $current_date = new DateTime();

            if ($opening_date > $current_date || $closing_date > $current_date)
            {
                $response['code'] = 2;
                $response['message'] = "You have selected future date / time";
                return response()->json($response);

            }

            $start_date = new DateTime($final_start_date_time);
            $end_date = new DateTime($final_end_date_time);

            if ($start_date == $end_date)
            {
                $response['code'] = 2;
                $response['message'] = "Invalid shift time";
                return response()->json($response);

            }


            $riderProfile = User::find(Auth::user()->id);

            $user_passport_id = $riderProfile->profile->passport_id;

            $check_in_platform = $riderProfile->profile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

            $is_already = RiderOrderDetail::where('passport_id','=',$user_passport_id)->orderby('end_date_time','desc')->first();


        $fromTime = $final_start_date_time;
        $toTime = $final_end_date_time;

        $existRequest = RiderOrderDetail::where(function ($query) use ($fromTime,$toTime){
            $query->where(function ($query) use ($fromTime,$toTime) {
                $query->where('start_date_time', '>=', $fromTime)
                    ->where('start_date_time', '<=', $toTime);
            })->orWhere(function ($query) use ($fromTime,$toTime) {
                $query->where('end_date_time', '>=', $fromTime)
                    ->where('end_date_time', '<=', $toTime);
            })->orWhere(function ($query) use ($toTime) {
                $query->where('start_date_time', '<=', $toTime)
                    ->where('end_date_time', '>=', $toTime);
            });
        })
        ->where('passport_id', $user_passport_id)
        ->first();

//       print_r($existRequest);


       if($existRequest == null){

           if(!empty($check_in_platform)) {
               $image_name = "";
               if(!empty($_FILES['image']['name'])) {
                   $date_folder = date("Y-m-d");
                //    if (!file_exists('./assets/upload/riderorder/'.$date_folder."/")) {
                //        mkdir('./assets/upload/riderorder/'.$date_folder."/", 0777, true);
                //    }
                //    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                //    $file1 = rand(0,1000000).$current_timestamp.'.'.$ext;
                //    move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/riderorder/'.$date_folder."/".$file1);
                //    $image_name = '/assets/upload/riderorder/'.$date_folder."/" . $file1;
                $img = $request->file('image');
                $image_name = '/assets/upload/riderorder/'.$date_folder."/" .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($image_name, $imageS3->stream());
               }

               $rate = RiderOrderRates::where('platform_id','=',$check_in_platform)->first();

               $obj= new RiderOrderDetail();
               $obj->passport_id = $user_passport_id;
               $obj->start_date_time = trim($final_start_date_time);
               $obj->end_date_time = trim($final_end_date_time);
               $obj->image = $image_name;
               $obj->platform_id = $check_in_platform;
               $obj->total_order = $request->total_order;
               if(!empty($rate->amount)){
                   $obj->amount = isset($rate->amount) ? $rate->amount : '';
               }

               $obj->save();

               $response['code'] = 1;
               $response['message'] = 'Order Submitted Successful';
               return response()->json($response);

           }else{

               $response['code'] = 2;
               $response['message'] = "You don't have platform";
               return response()->json($response);
           }

       }else{

           $response['code'] = 2;
           $response['message'] = "Time frame already exist";
           return response()->json($response);

       }








//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = "error contact admin";
//
//            return response()->json($response);
//        }
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
