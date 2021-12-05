<?php

namespace App\Http\Controllers\RiderOrderDetail;

use App\Model\AssingToDc\AssignToDc;
use App\Model\Passport\Passport;
use App\Model\Platform;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\RiderOrderDetail\RiderOrderRates;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;

class RiderOrderDetailControler extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|rider-order-all-order', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|rider-order-add-rider-order', ['only' => ['add_order_rates']]);
        $this->middleware('role_or_permission:Admin|add-rider-order', ['only' => ['add_order','save_rider_order']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        if($request->ajax()) {



            if(in_array(1, Auth::user()->user_group_id)){
                $platforms_ids = Platform::pluck('id')->toArray();
            }else{
                $platforms_ids = Platform::whereIn('id',Auth::user()->user_platform_id)->pluck('id')->toArray();
            }

            if(!empty($request->from_date))
            {
                $now_time = Carbon::parse($request->from_date)->startOfDay();
                $end_time = Carbon::parse($request->end_date)->endOfDay();

                 $designation_type = Auth::user()->designation_type;

                 if($designation_type=="3"){
                     $user_id = Auth::user()->id;



                   $dc_riders = AssignToDc::where('user_id','=',$user_id)->whereStatus(1)->pluck('rider_passport_id')->toArray();


                     $query = RiderOrderDetail::whereDate('start_date_time', '>=', $now_time)
                         ->whereDate('start_date_time', '<=', $end_time)
                         ->whereIn('passport_id', $dc_riders);
                    if($request->platform) {
                        $query = $query->where('platform_id','=',$request->platform);
                    }
                    if($request->passport_id) {
                        $query = $query->where('passport_id','=',$request->passport_id);
                    }

                    $data = $query->get();
                 }else{


                     $query = RiderOrderDetail::whereDate('start_date_time', '>=', $now_time)
                         ->whereDate('start_date_time', '<=', $end_time);

                    if($request->platform) {
                        $query = $query->where('platform_id','=',$request->platform);
                    }
                    if($request->passport_id) {
                        $query = $query->where('passport_id','=',$request->passport_id);
                    }

                    $data = $query->get();



                 }


            }else{
                $designation_type = Auth::user()->designation_type;

                if($designation_type=="3") {
                    $user_id = Auth::user()->id;

                    $dc_riders = AssignToDc::where('user_id', '=', $user_id)->whereStatus(1)->pluck('rider_passport_id')->toArray();


                    $data = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->whereIn('passport_id',$dc_riders)->get();
                }else{

                    $data = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->get();

                }
            }

                $view = view("admin-panel.rider_order_detail.rider_order_detail_search_render", compact('data'))->render();
                return response()->json(['html' => $view]);
        }


        if(in_array(1, Auth::user()->user_group_id)){
            $plaforms = Platform::all();
        }else{
            $plaforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms_ids = Platform::pluck('id')->toArray();
        }else{
            $platforms_ids = Platform::whereIn('id',Auth::user()->user_platform_id)->pluck('id')->toArray();
        }

        $designation_type = Auth::user()->designation_type;

        if($designation_type=="3"){

            $user_id = Auth::user()->id;

            $total_rider_array = AssignToDc::where('user_id','=',$user_id)->where('status','=','1')->get()->pluck('rider_passport_id')->toArray();

            $total_orders = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->whereIn('passport_id',$total_rider_array)->sum('total_order');
            $rirder_total = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->whereIn('passport_id',$total_rider_array)->distinct('passport_id')->count();

        }else{

            $total_orders = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->sum('total_order');
            $rirder_total = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->distinct('passport_id')->count();

        }




//         $plaforms = Platform::all();



        return  view('admin-panel.rider_order_detail.index',compact('plaforms','total_orders','rirder_total'));
    }

    public function add_order_rates(){

         $platforms = Platform::all();
         $rates = RiderOrderRates::orderby('id','desc')->get();

        return view('admin-panel.rider_order_detail.rider_order_rates',compact('platforms','rates'));
    }

    public function add_order(){


        return view('admin-panel.rider_order_detail.add_rider_order');

    }

    public function save_rider_order(Request $request){



        $response = [];
        $current_timestamp = Carbon::now()->timestamp;


        $validator = Validator::make($request->all(), [
            'start_date_time' => 'required',
            'end_date_time' => 'required',
//            'image' => 'required',
            'total_order' => 'required',
        ]);
        if ($validator->fails()) {
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];

            return redirect()->back()->with($message);
        }

        $final_start_date_time = "";
        $final_end_date_time  = "";

        $date1 = $request->start_date_time;
        $date2 = $request->end_date_time;

        $final_start_date_time = $request->start_date_time;

        $start_time = explode("T",$date1);
//           $end_time  =  explode(" ",$date2);

//        dd($date2);

        $st_time = strtotime($start_time[1]);
        $ed_time = strtotime($date2);

        if($ed_time > $st_time){

            $date2  = $start_time[0]." ".$request->end_date_time;

            $final_end_date_time = $date2;



        }elseif($ed_time < $st_time){
                $en_d_now_date = date("Y-m-d", strtotime($start_time[0]."+1 day"));

            $date2  = $en_d_now_date." ".$request->end_date_time;
            $final_end_date_time =  $date2;

        }else{
            $final_end_date_time =  $start_time[0]." ".$request->end_date_time;
        }



        $timestamp1 = strtotime($final_start_date_time);
        $timestamp2 = strtotime($final_end_date_time);
        $hour = abs($timestamp2 - $timestamp1)/(60*60);



        if($hour > 24){


            $message = [
                'message' => "Shift time should not be Exceed from 24 hours",
                'alert-type' => 'error',
                'error' => ''
            ];

            return redirect()->back()->with($message);

        }

        $opening_date = new DateTime($final_start_date_time);
        $closing_date = new DateTime($final_end_date_time);
        $current_date = new DateTime();

        if ($opening_date > $current_date || $closing_date > $current_date)
        {


            $message = [
                'message' => "You have selected future date / time",
                'alert-type' => 'error',
                'error' => ''
            ];

            return redirect()->back()->with($message);

        }

        $start_date = new DateTime($final_start_date_time);
        $end_date = new DateTime($final_end_date_time);

        if ($start_date == $end_date)
        {


            $message = [
                'message' => "Invalid shift time",
                'alert-type' => 'error',
                'error' => ''
            ];

            return redirect()->back()->with($message);

        }


//        $riderProfile = User::find(Auth::user()->id);
//
//        $user_passport_id = $riderProfile->profile->passport_id;

        $user_passport = Passport::where('id','=',$request->user_passport_id)->first();

        $user_passport_id =  $request->user_passport_id;

        $check_in_platform = $user_passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

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
                    // if (!file_exists('./assets/upload/riderorder/'.$date_folder."/")) {
                    //     mkdir('./assets/upload/riderorder/'.$date_folder."/", 0777, true);
                    // }
                    // $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    // $file1 = rand(0,1000000).$current_timestamp.'.'.$ext;
                    // move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/riderorder/'.$date_folder."/".$file1);
                    // $image_name = '/assets/upload/riderorder/'.$date_folder."/" . $file1;
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
                $obj->image =  $image_name;
                if(!empty($rate->amount)){
                    $obj->amount = isset($rate->amount) ? $rate->amount : '';
                }

                $obj->save();

                $message = [
                    'message' => "Order Submitted Successful",
                    'alert-type' => 'success',
                    'error' => ''
                ];

                return redirect()->back()->with($message);

            }else{



                $message = [
                    'message' => "You don't have platform",
                    'alert-type' => 'error',
                    'error' => ''
                ];

                return redirect()->back()->with($message);
            }

        }else{


            $message = [
                'message' => "Time frame already exist",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);

        }

    }


    public function save_order_rates(Request $request){


        try {

        $validator = Validator::make($request->all(), [
            'platform_id' => 'required|unique:rider_order_rates,platform_id',
            'amount' => 'required'
        ]);

        if ($validator->fails()) {

            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

          $rates = new RiderOrderRates();
          $rates->platform_id = $request->platform_id;
          $rates->amount = $request->amount;
          $rates->save();

            $message = [
                'message' => "Amount has been added successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->back()->with($message);


        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }

    public function order_rate_edit($id){

        $rate = RiderOrderRates::find($id);
        $platforms = Platform::all();

        return  view('admin-panel.rider_order_detail.rider_order_rate_edit',compact('rate','platforms'));
    }

    public function order_rate_update(Request $request,$id){

        try {

            $validator = Validator::make($request->all(), [
                'platform_id' => 'required|unique:rider_order_rates,platform_id,'.$id,
                'amount' => 'required'
            ]);

            if ($validator->fails()) {

                $response['message'] = $validator->errors()->first();
                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return redirect()->back()->with($message);
            }

            $rates = RiderOrderRates::find($id);
            $rates->platform_id = $request->platform_id;
            $rates->amount = $request->amount;
            $rates->update();

            $message = [
                'message' => "Amount has been Updated successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->back()->with($message);


        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return response()->json($response);
        }

    }

    public function missing_order_rider(Request $request){



        if($request->ajax()) {

            if(in_array(1, Auth::user()->user_group_id)){
                $platforms_ids = Platform::pluck('id')->toArray();
            }else{
                $platforms_ids = Platform::whereIn('id',Auth::user()->user_platform_id)->pluck('id')->toArray();
            }

            if(!empty($request->from_date))
            {
                $now_time = Carbon::parse($request->from_date)->startOfDay();
                $end_time = Carbon::parse($request->end_date)->endOfDay();

                $data = RiderOrderDetail::where('platform_id','=',$request->platform)
                    ->whereDate('start_date_time', '>=', $now_time)
                    ->whereDate('start_date_time', '<=', $end_time)
                    ->get();
            }else{
                $data = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->get();
            }
            return Datatables::of($data)
                ->editColumn('image', function (RiderOrderDetail $rider_detail) {
                    $image_url =  url($rider_detail->image);
                    $mg = '<a href="'.$image_url.'" target="_blank"  class="badge badge-primary ">see image</a>';
                    return $mg;
                })->addColumn('name', function (RiderOrderDetail $rider_detail) {
                    $name = isset($rider_detail->passport->personal_info->full_name) ? $rider_detail->passport->personal_info->full_name : 'N/A';
                    return $name;
                })->addColumn('zds_code', function (RiderOrderDetail $rider_detail) {
                    $zds_code=isset($rider_detail->passport->zds_code->zds_code)?$rider_detail->passport->zds_code->zds_code:"N/A";
                    return $zds_code;
//
                })->addColumn('rider_id', function(RiderOrderDetail $rider_detail) {

                    $rider_id=isset($rider_detail->passport->rider_id->platform_code)?$rider_detail->passport->rider_id->platform_code:"N/A";

//                    $platform_ids = $rider_detail->passport->assign_platforms_check() ? $rider_detail->passport->assign_platforms_check()->plateformdetail->id : "N/A";
//                    $rider_platform_code=isset($rider_detail->passport->get_the_rider_id_by_platform($platform_ids)->platform_code)?$rider_detail->passport->get_the_rider_id_by_platform($platform_ids)->platform_code:"N/A";
//                    return $rider_platform_code;
                    return $rider_id;
                })->editColumn('platform_id', function(RiderOrderDetail $rider_detail) {
                    $platform_name = isset($rider_detail->platform->name) ? $rider_detail->platform->name : 'N/A';
                    return $platform_name;
                })
                ->addColumn('total_earning', function(RiderOrderDetail $rider_detail) {

                    $total_earning = isset($rider_detail->platform->name) ? ($rider_detail->amount*$rider_detail->total_order) : '0';
                    return $total_earning;
                })
                ->rawColumns(['image'])
                ->make(true);
        }


        if(in_array(1, Auth::user()->user_group_id)){
            $plaforms = Platform::all();
        }else{
            $plaforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms_ids = Platform::pluck('id')->toArray();
        }else{
            $platforms_ids = Platform::whereIn('id',Auth::user()->user_platform_id)->pluck('id')->toArray();
        }


        $total_orders = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->sum('total_order');
        $rirder_total = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->distinct('passport_id')->count();


//         $plaforms = Platform::all();



        return  view('admin-panel.rider_order_detail.missing_orders_rider',compact('plaforms','total_orders','rirder_total'));

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

    public function rider_data_count_ajax(Request $request){

        if($request->ajax()){

            if(in_array(1, Auth::user()->user_group_id)){
                $platforms_ids = Platform::pluck('id')->toArray();
            }else{
                $platforms_ids = Platform::whereIn('id',Auth::user()->user_platform_id)->pluck('id')->toArray();
            }

            if($request->start_date!="ab"){

//                $now_time = $request->start_date." 00:00:00";
//                $end_time = $request->end_date." 23:59:00";

                $designation_type = Auth::user()->designation_type;

                if($designation_type=="3"){

                    $user_id = Auth::user()->id;


                    $dc_riders = AssignToDc::where('user_id','=',$user_id)->whereStatus(1)->pluck('rider_passport_id')->toArray();


                    $now_time = Carbon::parse($request->start_date)->startOfDay();
                    $end_time = Carbon::parse($request->end_date)->endOfDay();

                    $query = RiderOrderDetail::whereDate('start_date_time', '>=', $now_time)
                        ->whereDate('start_date_time', '<=', $end_time)
                        ->whereIn('passport_id' , $dc_riders);

                        if($request->platform) {
                            $query = $query->where('platform_id','=',$request->platform);
                        }
                        if($request->passport_id) {
                            $query = $query->where('passport_id','=',$request->passport_id);
                        }

                        $total_orders = $query->sum('total_order');

                    $query = RiderOrderDetail::whereDate('start_date_time', '>=', $now_time)
                        ->whereDate('start_date_time', '<=', $end_time)
                        ->whereIn('passport_id' , $dc_riders);

                        if($request->platform) {
                            $query = $query->where('platform_id','=',$request->platform);
                        }
                        if($request->passport_id) {
                            $query = $query->where('passport_id','=',$request->passport_id);
                        }

                        $rirder_total = $query->distinct('passport_id')->count();

                }else{

                    $now_time = Carbon::parse($request->start_date)->startOfDay();
                    $end_time = Carbon::parse($request->end_date)->endOfDay();

                    $query = RiderOrderDetail::whereDate('start_date_time', '>=', $now_time)
                        ->whereDate('start_date_time', '<=', $end_time);

                    if($request->platform) {
                        $query = $query->where('platform_id','=',$request->platform);
                    }
                    if($request->passport_id) {
                        $query = $query->where('passport_id','=',$request->passport_id);
                    }

                    $total_orders = $query->sum('total_order');

                    $rirder_total = RiderOrderDetail::whereDate('start_date_time', '>=', $now_time)
                        ->whereDate('start_date_time', '<=', $end_time);
                    if($request->platform) {
                        $query = $query->where('platform_id','=',$request->platform);
                    }
                    if($request->passport_id) {
                        $query = $query->where('passport_id','=',$request->passport_id);
                    }

                    $rirder_total = $query->distinct('passport_id')->count();


                }



                $array_to_send = array(
                    'total_amount' => isset($total_orders) ? $total_orders : 0,
                    'total_rider' => isset($rirder_total) ? $rirder_total : 0,
                );

                echo json_encode($array_to_send);
                exit;

            }else{

                $designation_type = Auth::user()->designation_type;

                if($designation_type=="3") {

                    $user_id = Auth::user()->id;

                    $dc_riders = AssignToDc::where('user_id', '=', $user_id)->whereStatus(1)->pluck('rider_passport_id')->toArray();

                    $total_orders = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->whereIn('passport_id',$dc_riders)->sum('total_order');
                    $rirder_total = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->whereIn('passport_id',$dc_riders)->distinct('passport_id')->count();

                }else{

                    $total_orders = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->sum('total_order');
                    $rirder_total = RiderOrderDetail::whereIn('platform_id',$platforms_ids)->distinct('passport_id')->count();

                }



                $array_to_send = array(
                    'total_amount' => isset($total_orders) ? $total_orders : 0,
                    'total_rider' => isset($rirder_total) ? $rirder_total : 0,
                );

                echo json_encode($array_to_send);
                exit;

            }


        }

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
