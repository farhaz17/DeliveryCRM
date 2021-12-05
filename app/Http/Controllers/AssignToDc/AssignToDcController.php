<?php

namespace App\Http\Controllers\AssignToDc;

use DB;
use App\User;
use Carbon\Carbon;
use App\Model\Platform;
use App\DcLimit\DcLimit;
use App\Model\Cods\Cods;
use App\Model\RiderProfile;
use App\Model\Manager_users;
use Illuminate\Http\Request;
use App\Exports\DcAssignRiders;
use App\Model\Passport\Passport;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Assign\AssignPlateform;
use App\Exports\AssignDashboardExport;
use App\Model\Attendance\RiderAttendance;
use Illuminate\Support\Facades\Validator;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\RiderOrderDetail\RiderOrderDetail;

class AssignToDcController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|assign_to_dc', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|add-to-assign-dc', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Admin|assign-to-dc-transfer', ['only' => ['dc_transfer_rider']]);

        $this->middleware('role_or_permission:Admin|dc_riders', ['only' => ['dc_riders']]);
        $this->middleware('role_or_permission:Admin|dc_dashboard', ['only' => ['dc_dashboard','rider_not_implement_attendance','rider_not_implement_orders']]);

        $this->middleware('role_or_permission:Admin', ['only' => ['dc_master_dashboard']]);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('designation_type','=','3')->get();

        $platforms = Platform::get();



        return  view("admin-panel.assign_rider_to_dc.dc_list",compact('users','platforms'));

    }

    public function dc_riders(){

        $user_id = Auth::user()->id;

        $users = User::where('designation_type','=','3')->where('id',$user_id)->get();

        $platforms = Platform::get();



        return  view("admin-panel.assign_rider_to_dc.dc_list",compact('users','platforms'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('designation_type','=','3')->get();

        return  view("admin-panel.assign_rider_to_dc.create",compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'user_ids' => 'required',
            'select_platform' => 'required',
            'select_quantity' => 'required',
            'select_dc_id' => 'required',
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

        $dc_id = $request->select_dc_id;

        $total_assigned = AssignToDc::where('status','=','1')->where('platform_id','=',$request->select_platform)->where('user_id','=',$dc_id)->count();
        $total_dc_limit = DcLimit::where('user_id','=',$dc_id)->first();
        $limit = $total_dc_limit->limit ? $total_dc_limit->limit : 0;

        $remain_limit = $limit-$total_assigned;
        $total_user_selected = count($request->user_ids);

        if($total_user_selected > $remain_limit){

            $message = [
                'message' => "you are exceeded from the DC limit.!",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }


        $total_remain_rider =  $limit;

        foreach($request->user_ids as $gamer){
             $assign_to_dc  = new  AssignToDc();
             $assign_to_dc->rider_passport_id = $gamer;
             $assign_to_dc->platform_id = $request->select_platform;
             $assign_to_dc->user_id = $request->select_dc_id;
             $assign_to_dc->status = "1";
            $assign_to_dc->save();

        }

        $message = [
            'message' => "Rider Assigned Successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);

    }

    public function dc_rirder_by_platform($id,$platform){


         $assign_to_dc = AssignToDc::where('user_id','=',$id)->where('platform_id','=',$platform)->where('status','=','1')->get();



        return  view("admin-panel.assign_rider_to_dc.platform_wise_list_rider",compact('assign_to_dc'));

    }

    public function dc_transfer_rider(){

        $users = User::where('designation_type','=','3')->get();

        return  view("admin-panel.assign_rider_to_dc.transfer_riders",compact('users'));

    }

    public function dc_transfer_save(Request $request){




        $validator = Validator::make($request->all(), [
            'user_ids' => 'required',
            'select_platform' => 'required',
            'select_quantity' => 'required',
            'select_dc_id' => 'required',
            'select_to_dc_id' => 'required',
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

        $dc_to_id = $request->select_to_dc_id;

        $total_assigned = AssignToDc::where('status','=','1')->where('user_id','=',$dc_to_id)->where('platform_id','=',$request->select_platform)->count();
        $total_dc_limit = DcLimit::where('user_id','=',$dc_to_id)->first();
        $limit = $total_dc_limit->limit ? $total_dc_limit->limit : 0;

        $remain_limit = $limit-$total_assigned;
        $total_user_selected = count($request->user_ids);

        if($total_user_selected > $remain_limit){

            $message = [
                'message' => "you are exceeded from the DC limit.!",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }


        $total_remain_rider =  $limit;

        foreach($request->user_ids as $gamer){
            $checkout = date('Y-m-d H:i:s');
            $assign_to_dc  = AssignToDc::where('rider_passport_id','=',$gamer)->where('status','=','1')->first();
            $assign_to_dc->status = "0";
            $assign_to_dc->checkout=$checkout;
            $assign_to_dc->update();

            $new_assign_to_dc = new AssignToDc();
            $new_assign_to_dc->rider_passport_id = $gamer;
            $new_assign_to_dc->platform_id = $request->select_platform;
            $new_assign_to_dc->user_id = $dc_to_id;
            $new_assign_to_dc->checkin=$checkout;
            $new_assign_to_dc->status = "1";
            $new_assign_to_dc->save();

        }

        $message = [
            'message' => "Rider Assigned Successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);


    }

    public function dc_dashboard($id=null){
        $dcs = User::whereDesignationType(3)->get(['id','name']);
        $user_id = $id !== null ? $id : Auth::user()->id; // Set user id
        $assign_to_dc_riders = AssignToDc::whereUserId($user_id)->get();
        $last_day_of_previous_month = Carbon::create('last day of last month');
        $last_day_of_current_month = Carbon::create('last day of this month');

        $attendance_of_riders = RiderAttendance::whereIn('passport_id',$assign_to_dc_riders->pluck('rider_passport_id'))
        ->whereBetween('created_at', [$last_day_of_previous_month, $last_day_of_current_month])
        ->get();

        $date_range = [];
        $total_dates_of_current_month = range(1, date('d'));
        foreach($total_dates_of_current_month as $date){
            $date_range[] = $last_day_of_previous_month->addDays(1)->format('Y-m-d');
        }
        $rider_attendance_chart_data = collect();
        $rider_attendance_chart_data['datasets'] = collect();
        $date_wise_toatal_riders = []; // Rider Totals
        $date_wise_joined_riders = [];
        $date_wise_left_riders = [];
        $date_wise_rider_passport_ids = []; // Get Date wise Rider passport ids
        foreach($date_range as $date){
            $starting_time =  $starting_time = Carbon::parse($date)->startOfDay();
            $ending_time = Carbon::parse($date)->endOfDay();
            $date_wise_toatal_riders[$date] = $assign_to_dc_riders->filter(function($rider)use($date){
                return(
                        ($date > $rider->checkout) && ($rider->getOriginal('checkin') == $rider->getOriginal('checkout'))
                        ||
                        ($rider->checkin < $date) && ($date < $rider->checkout)
                    );
            })
            ->count(); // Total Riders count
            $date_wise_joined_riders[$date] = $assign_to_dc_riders->filter(function($rider)use($date,$starting_time,$ending_time){
                return
                (($starting_time < $rider->getOriginal('checkin'))
                    &&
                ($ending_time > $rider->getOriginal('checkin') )
                    &&
                ($rider->checkin == $rider->checkout));
            })
            ->count(); // Date wise all joined DC riders count

            $date_wise_left_riders[$date] = $assign_to_dc_riders->filter(function($rider)use($date,$starting_time,$ending_time){
                // return $date == $rider->updated_at && ($rider->getOriginal('created_at') != $rider->getOriginal('updated_at'));
                return
                (($starting_time < $rider->getOriginal('checkout'))
                    &&
                ($ending_time > $rider->getOriginal('checkout') )
                    &&
                ($rider->checkin != $rider->checkout));
            })
            ->count(); // Date wise all left DC riders count

            $date_wise_rider_passport_ids[$date] = $assign_to_dc_riders->filter(function($rider)use($date){
                return $rider->status == 1 || $date < $rider->checkout;
            })->map(function($rider){
                return $rider->rider_passport_id; // Take only passport ids
            })->toArray(); // Date wise all dc riders passport ids

        }
        $rider_attendance_chart_data['datasets'][] = ['label' => 'Total Riders','backgroundColor' => '#003473','borderColor' => '#003474','data' => $date_wise_toatal_riders];
        $rider_attendance_chart_data['datasets'][] = ['label' => 'Riders Joined','backgroundColor' => '#663399','borderColor' => '#663399','data' => $date_wise_joined_riders];
        $rider_attendance_chart_data['datasets'][] = ['label' => 'Riders Left','backgroundColor' => '#10163a','borderColor' => '#10163a','data' => $date_wise_left_riders];

        // Rider Presents
        $present_count = [];
            foreach($date_range as $date){
                $present_count[$date] = $attendance_of_riders
                ->where('status',1)->where('created_at' , $date)
                ->filter(function($present)use($date_wise_rider_passport_ids, $date){
                    return in_array($present->passport_id ,$date_wise_rider_passport_ids[$date]);
                })
                ->count(); // return count of present
            }
        $rider_attendance_chart_data['datasets'][] = ['label' => 'Presents','backgroundColor' =>  '#4caf50','borderColor' => '#4caf60','data' =>  $present_count];

        // Rider in leave
        $in_leave_count = [];
            foreach($date_range as $date){
                $in_leave_count[$date] = $attendance_of_riders
                ->where('status',2)->where('created_at', $date)
                ->filter(function($present)use($date_wise_rider_passport_ids, $date){
                    return in_array($present->passport_id ,$date_wise_rider_passport_ids[$date]);
                })
                ->count();
            }
        $rider_attendance_chart_data['datasets'][] = ['label' => "Leaves",'backgroundColor' => '#ffc107','borderColor' => '#ffc110','data' => $in_leave_count];

        // Rider absent
        $in_absent_count = [];
            foreach($date_range as $date){
                $in_absent_count[$date] =  $date_wise_toatal_riders[$date] - ($present_count[$date] + $in_leave_count[$date]);
            }
        $rider_attendance_chart_data['datasets'][] = [ 'label' => 'Absents', 'backgroundColor' => '#f44336d6', 'borderColor' => '#f44336d6', 'data' => $in_absent_count];

        // Making labels for chartjs
        $rider_attendance_chart_data['labels'] = collect($date_range);

        // Data For Rider Order Chart.
        $last_day_of_previous_month = Carbon::create('last day of last month');
        $last_day_of_current_month = Carbon::create('last day of this month');
        $orders_of_riders = RiderOrderDetail::whereIn('passport_id',$assign_to_dc_riders->pluck('rider_passport_id'))
        ->whereBetween('created_at', [$last_day_of_previous_month, $last_day_of_current_month])
        ->get();

        $rider_order_chart_data = collect();
        $rider_order_chart_data['datasets'] = collect();
        $date_wise_toatal_toders = []; // Rider Orders
        foreach($date_range as $date){
            // $starting_time =  $starting_time = Carbon::parse($date)->addSeconds('01')->format('Y-m-d H:i:s');
            $starting_time = Carbon::parse($date)->startOfDay();
            $ending_time = Carbon::parse($date)->endOfDay();
            $date_wise_toatal_toders[$date] = $orders_of_riders
            ->where('start_date_time', '>=', $starting_time)
            ->where('start_date_time', '<=', $ending_time)
            ->sum('total_order'); // Total Riders count
        }
        $rider_order_chart_data['datasets'][] = ['label' => 'Total Orders','backgroundColor' => '#003473','borderColor' => '#003474','data' => $date_wise_toatal_toders];
        $rider_order_chart_data['datasets'][] = ['label' => 'Total Riders','backgroundColor' => '#003473','borderColor' => '#003474','data' => $date_wise_toatal_riders];
        $rider_order_chart_data['labels'] = collect($date_range);
        return view('admin-panel.assign_rider_to_dc.dashboard',compact('rider_attendance_chart_data','dcs','rider_order_chart_data'));
    }

    public function dc_leaderboard()
    {
        // Total DCs
        $dcs = User::whereDesignationType(3)
        ->with('get_dc_rirders')
        ->get(['id','name','user_profile_picture']);
        // Total Riders

        // Dates Calculation
        $starting_time =  Carbon::now()->startOfDay();
        $ending_time = Carbon::now()->endOfDay();
        $total_days = 1;
        if(request('date_range') !== null){
            if(request('date_range') == 'today'){
                $starting_time = Carbon::now()->startOfDay();
            }elseif(request('date_range') == 'last_week'){
                $starting_time = Carbon::now()->subdays( 7 )->startOfDay();
                $total_days = $starting_time->diffInDays($ending_time);
            }elseif(request('date_range') == 'last_two_weeks'){
                $starting_time = Carbon::now()->subdays( 7*2 )->startOfDay();
                $total_days = $starting_time->diffInDays($ending_time);
            }elseif(request('date_range') == 'last_month'){
                $starting_time = Carbon::now()->subMonth()->startOfDay();
                $total_days = $starting_time->diffInDays($ending_time);
            }else{
                $starting_time =  Carbon::now()->startOfDay();
            }
        }
        // Attendance collection
        $all_rider_attendances = RiderAttendance::whereBetween('created_at', [ $starting_time, $ending_time ])->get();

        // Order collection
        $all_rider_orders = RiderOrderDetail::whereBetween('created_at', [ $starting_time, $ending_time ])->get();
        $dcs->filter(function($user) use( $all_rider_attendances, $all_rider_orders, $total_days, $starting_time, $ending_time){
            // get passport id under each dc
            $all_riders_passport_ids = $user->get_dc_rirders
            ->filter(function($assign_to_dc)use($starting_time, $ending_time){
                return(
                        ($ending_time > $assign_to_dc->checkout) && ($assign_to_dc->getOriginal('checkin') == $assign_to_dc->getOriginal('checkout'))
                        ||
                        ($assign_to_dc->checkin < $starting_time) && ($ending_time < $assign_to_dc->checkout)
                    );
            })
            ->map(function($assign_to_dc){
                return $assign_to_dc->rider_passport_id;
            });
            // Total riders
            $total_riders = $all_riders_passport_ids->count();

            // get attendance filtered by passport ids
            $all_attendance_between_date_range = $all_rider_attendances->whereIn('passport_id', $all_riders_passport_ids)->whereIn('status', [1, 2])->count();
            $attendance_score = ($all_attendance_between_date_range / $total_days) / $total_riders;

            $all_orders_between_date_range = $all_rider_orders->whereIn('passport_id', $all_riders_passport_ids)->count();
            $order_score = ($all_orders_between_date_range / $total_days) / $total_riders;
            // dd($all_attendance_between_date_range, $total_days,  $total_riders);

            // get score
            return $user->score = round((($attendance_score + $order_score) / 2) * 100);
        });
        $dcs = $dcs->sortByDesc('score');
        // dd('Today: '.$today, "Last Week: " . $last_week, "Last Two weeks: " . $last_two_weeks, "Last Month: " . $last_month );
        return view('admin-panel.assign_rider_to_dc.dc_leaderboard', compact('dcs'));
    }

    public function dc_master_dashboard(){
        $total_dc = User::where('designation_type','=','3')->count();
        $total_rider_array = AssignToDc::where('status','=',"1")->get()->pluck('rider_passport_id')->toArray();
        $today_date = date("Y-m-d");

        $last_date = date("Y-m-d", strtotime($today_date."-1 day"));

        $total_orders_today = RiderOrderDetail::whereIn('passport_id',$total_rider_array)->where('start_date_time','LIKE','%'.$last_date.'%')->sum('total_order');
        $total_rider_assigned = count($total_rider_array);

        $total_rider_without_dc = AssignPlateform::where('status','=','1')->whereNotIn('passport_id',$total_rider_array)->get();

        $total_rider_without_dc = count($total_rider_without_dc);
        $today_attendence = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','1')->where('created_at','LIKE','%'.$today_date.'%')->count();
        $today_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$today_date.'%')->count();

        $today_absent = $total_rider_assigned-($today_attendence+$today_leaves);


        return view('admin-panel.assign_rider_to_dc.master_dashboard',compact('total_dc','total_orders_today','total_rider_assigned','total_rider_without_dc','today_absent'));
    }

    public function dc_manager_dashboard(){

        $user_id = Auth::user()->id;

        $manager_users =  Manager_users::where('manager_user_id','=',$user_id)->pluck('member_user_id')->toArray();

        $total_dc = User::where('designation_type','=','3')->whereIn('id',$manager_users)->count();

        $total_rider_array = AssignToDc::where('status','=',"1")->whereIn('user_id',$manager_users)->get()->pluck('rider_passport_id')->toArray();
        $today_date = date("Y-m-d");


        $last_date = date("Y-m-d", strtotime($today_date."-1 day"));

        $total_orders_today = RiderOrderDetail::whereIn('passport_id',$total_rider_array)->where('start_date_time','LIKE','%'.$last_date.'%')->sum('total_order');
        $total_rider_assigned = count($total_rider_array);

        $platforms_in_array = AssignPlateform::select('plateform')->where('status','=','1')->whereIn('passport_id',$total_rider_array)->distinct()->get()->pluck('plateform')->toArray();

        $total_rider_without_dc = AssignPlateform::where('status','=','1')->whereNotIn('passport_id',$total_rider_array)->whereIn('plateform',$platforms_in_array)->get();
        $total_rider_without_dc = count($total_rider_without_dc);
//        dd($total_rider_without_dc);




        $today_attendence = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','1')->where('created_at','LIKE','%'.$today_date.'%')->count();
        $today_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$today_date.'%')->count();

        $today_absent = $total_rider_assigned-($today_attendence+$today_leaves);


        $yesterday_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$last_date.'%')->get();

        $total_order_implement = RiderOrderDetail::whereIn('passport_id',$total_rider_array)
                                                    ->where('start_date_time','LIKE','%'.$last_date.'%')
                                                        ->groupby('passport_id')->get();
//        dd($total_rider_array);

        $implement_order = $total_order_implement->count() ? $total_order_implement->count() : 0;
        $yesterday_l = $yesterday_leaves->count() ? $yesterday_leaves->count() : 0;

        $total_order_not_implement  =  count($total_rider_array)-$implement_order;
//        dd($yesterday_leaves);

        $total_order_not_implement = $total_order_not_implement-$yesterday_l;



        return view('admin-panel.assign_rider_to_dc.dc_manager_dashboard',compact('total_dc','total_orders_today','total_rider_assigned','total_rider_without_dc','today_absent','total_order_not_implement'));

    }

    public function get_dc_item_menu(Request $request){

        if($request->ajax()){
            $menu_type = $request->id_menu;

            if($menu_type=="renewal-menu"){
                $total_rider_array = AssignToDc::where('status','=',"1")->get()->pluck('rider_passport_id')->toArray();

                $platforms = AssignPlateform::select('plateform')->whereNotIn('passport_id',$total_rider_array)->distinct()->get()->pluck('plateform')->toArray();

                 $platforms = Platform::whereIn('id',$platforms)->get();

                $view = view("admin-panel.assign_rider_to_dc.menu_item_display_ajax",compact('menu_type','platforms','total_rider_array'))->render();
                return response()->json(['html'=>$view]);
            }else{
                $total_dc = User::where('designation_type','=','3')->get();

                $view = view("admin-panel.assign_rider_to_dc.menu_item_display_ajax",compact('menu_type','total_dc','total_rider_array'))->render();

                return response()->json(['html'=>$view]);
            }



        }
    }

    public function get_dc_item_menu_of_manager(Request $request){

        if($request->ajax()){

            $manager_id =  Auth::user()->id;

            $manager_users =  Manager_users::where('manager_user_id','=',$manager_id)->pluck('member_user_id')->toArray();

//            $users_plat = User::whereIn('id',$manager_users)->get();

            $menu_type = $request->id_menu;

            if($menu_type=="renewal-menu"){
                $total_rider_array = AssignToDc::where('status','=',"1")->whereIn('user_id',$manager_users)->get()->pluck('rider_passport_id')->toArray();

                $platforms = AssignPlateform::select('plateform')->whereNotIn('passport_id',$total_rider_array)->distinct()->get()->pluck('plateform')->toArray();

                $platforms_in_array = AssignPlateform::select('plateform')->where('status','=','1')->whereIn('passport_id',$total_rider_array)->distinct()->get()->pluck('plateform')->toArray();

                $platforms = Platform::whereIn('id',$platforms_in_array)->get();

                $view = view("admin-panel.assign_rider_to_dc.menu_item_display_ajax",compact('menu_type','platforms','total_rider_array'))->render();
                return response()->json(['html'=>$view]);
            }elseif($menu_type=="documents-menu"){


                $order_not_implement_array = array();


                foreach($manager_users as $dc){

                    $today_date = date("Y-m-d");
                    $last_date = date("Y-m-d", strtotime($today_date."-1 day"));

                    $total_rider_array = AssignToDc::where('status','=',"1")->where('user_id','=',$dc)->get()->pluck('rider_passport_id')->toArray();
                    $yesterday_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$last_date.'%')->count();

                    $total_order_implement = RiderOrderDetail::whereIn('passport_id',$total_rider_array)
                        ->where('start_date_time','LIKE','%'.$last_date.'%')
                        ->groupBy('passport_id')
                        ->get();

                    $total_orders_imple =  $total_order_implement->count() ? $total_order_implement->count() : 0;



                    $total_order_not_implement  =  count($total_rider_array)-$total_orders_imple-$yesterday_leaves;

                     $dc_detail = User::find($dc);

                    $gamer = array(
                        'name' =>  $dc_detail->name,
                        'user_id' =>  $dc_detail->id,
                        'total_order_not_implement' => $total_order_not_implement,
                        'order_iplements' => $total_order_implement,
                        'absent' => $yesterday_leaves,
                        'riders' => count($total_rider_array)
                    );
                    $order_not_implement_array [] =   $gamer;
                }
//                dd($order_not_implement_array);

                 $manager_ab = isset($request->type) ? $request->type : '' ;

                $view = view("admin-panel.assign_rider_to_dc.menu_item_display_ajax",compact('menu_type','platforms','total_rider_array','order_not_implement_array','manager_ab'))->render();

                return response()->json(['html'=>$view]);
            }else{

                $total_dc = User::where('designation_type','=','3')->whereIn('id',$manager_users)->get();

                $view = view("admin-panel.assign_rider_to_dc.menu_item_display_ajax",compact('menu_type','total_dc'))->render();

                return response()->json(['html'=>$view]);
            }



        }
    }




    public  function rider_master_list($type,$id,$platform=null){

        if($type=="dc_rider"){

            $assign_to_dc = AssignToDc::where('user_id','=',$id)->where('status','=','1')->get();

            $total_rider_array = AssignToDc::where('user_id','=',$id)->where('status','=','1')->groupby('rider_passport_id')->pluck('rider_passport_id')->toArray();
            $total_rider_assigned = count($total_rider_array);


            $today_date = date("Y-m-d");
            $last_date = date("Y-m-d", strtotime($today_date."-1 day"));

            $today_attendence = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','1')->where('created_at','LIKE','%'.$today_date.'%')->groupby('passport_id')->get();
            $today_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$today_date.'%')->groupby('passport_id')->get();
//            dd($today_leaves);

            $leaves =  $today_leaves ? count($today_leaves) : 0;

             $today_attendence_now = $today_attendence ? count($today_attendence) : 0;
//             dd($today_attendence_now);


            $ab  = $today_attendence_now+$leaves;


//            dd($total_rider_assigned);

            $today_absent = $total_rider_assigned-$ab;











            $yesterday_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$last_date.'%')->get();

            $total_order_implement = RiderOrderDetail::whereIn('passport_id',$total_rider_array)
                ->where('start_date_time','LIKE','%'.$last_date.'%')
                ->groupby('passport_id')->get();



            $implement_order = $total_order_implement ? count($total_order_implement) : 0;
            $yesterday_l = $yesterday_leaves->count() ? $yesterday_leaves->count() : 0;

            $total_order_not_implement  =  count($total_rider_array)-$implement_order;
//            $total_order_not_implement = $total_order_not_implement-$yesterday_l;

            $today_leaves =  $today_leaves ? count($today_leaves) : 0;



            return  view("admin-panel.assign_rider_to_dc.rider_master_list",compact('today_leaves','total_order_not_implement','today_absent','assign_to_dc','type'));

        }elseif($type=="without_dc_rider"){

            $array_dc = AssignToDc::where('status','=','1')->get()->pluck('rider_passport_id')->toArray();
            $assign_platform = AssignPlateform::whereNotIn('passport_id',$array_dc)->where('plateform','=',$id)->where('status','=','1')->get();
            return  view("admin-panel.assign_rider_to_dc.rider_master_list_platform",compact('assign_platform'));

        }elseif($type=="rider_order_by_dc"){

            $array_dc = AssignToDc::where('status','=','1')->where('user_id','=',$id)->get()->pluck('rider_passport_id')->toArray();
            $today_date = date("Y-m-d");
            $last_day = date("Y-m-d", strtotime($today_date."-1 day"));


           $orders = RiderOrderDetail::whereIn('passport_id',$array_dc)->where('start_date_time','LIKE','%'.$last_day.'%')
                        ->orderby('total_order','desc')->get();

            return  view("admin-panel.assign_rider_to_dc.rider_order_by_dc",compact('orders'));


//            $users = User::where('designation_type','=','3')->where('id',$id)->get();
//            $platforms = Platform::get();
//            return  view("admin-panel.assign_rider_to_dc.dc_list",compact('users','platforms'));


        }elseif($type=="absent_dc_rider"){

            $total_rider_array = AssignToDc::where('status','=','1')->where('user_id','=',$id)->get()->pluck('rider_passport_id')->toArray();


            $today_date = date("Y-m-d");

            $today_attendence = RiderAttendance::whereIn('passport_id',$total_rider_array)
                ->where(function ($query) {
                    $query->where('status','=','1')
                    ->orwhere('status','=','2');
                })
                ->where('created_at','LIKE','%'.$today_date.'%')->get()->pluck('passport_id')->toArray();;



            $assign_to_dc = AssignToDc::where('status','=','1')->where('user_id','=',$id)
                                        ->whereNotIn('rider_passport_id',$today_attendence)->get();

            return  view("admin-panel.assign_rider_to_dc.absenet_dc_rider",compact('assign_to_dc','type'));

        }elseif($type=="dc_report"){

            $dcs = AssignToDc::select('rider_passport_id')->where('status','=','1')->where('user_id','=',$id)->pluck('rider_passport_id');

            for ($i=0 ; $i<=14; $i++){
                $d2 = date('y-m-d', strtotime('-'.$i.' days'));
                $date_name [] = "'$d2'";

                $order = RiderOrderDetail::whereIn('passport_id', $dcs)->where('start_date_time','LIKE','%'.$d2.'%')->sum('total_order');
                $total_order [] = $order;
            }

            for ($i=0 ; $i<=14; $i++){
                $d2 = date('y-m-d', strtotime('-'.$i.' days'));

                $attendance = RiderAttendance::whereIn('passport_id', $dcs)->where('created_at','LIKE','%'.$d2.'%')->where('status', 1)->count();
                $total_attendance [] = $attendance;
            }

            $total_orders = implode(', ', $total_order);
            $total_attendances = implode(', ', $total_attendance);
            $date_names = implode(', ', $date_name);

            return  view("admin-panel.assign_rider_to_dc.dc_report",compact('total_orders', 'date_names', 'total_attendances'));

        }



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

    public function dc_rider_filter_ajax(Request $request){

        if($request->ajax()){
            if($request->type=="absent_order"){

                $today_date = date("Y-m-d");
                $last_date = date("Y-m-d", strtotime($today_date."-1 day"));

                $dc_rider = $request->dc_id;

                $total_rider_array = AssignToDc::where('user_id','=',$dc_rider)->where('status','=','1')->groupby('rider_passport_id')->pluck('rider_passport_id')->toArray();
                $total_rider_assigned = count($total_rider_array);



                $today_attendence = RiderAttendance::whereIn('passport_id',$total_rider_array)
                                                    ->where(function ($query) {
                                                            $query->where('status','=','1')
                                                                ->orwhere('status','=','2');
                                                        })
                                                    ->where('created_at','LIKE','%'.$today_date.'%')
                                                    ->groupby('passport_id')
                                                    ->pluck('passport_id')
                                                    ->toArray();


//            dd($today_attendence);

                $assign_to_dc = AssignToDc::where('user_id','=',$dc_rider)
                                            ->where('status','=','1')
                                            ->whereNotIn('rider_passport_id',$today_attendence)
                                            ->whereIn('rider_passport_id',$total_rider_array)
                                            ->groupby('rider_passport_id')
                                            ->get();



                $type = $request->type;

                $view = view("admin-panel.assign_rider_to_dc.dc_filter_ajax_table", compact('assign_to_dc','type'))->render();
                return response()->json(['html' => $view]);


            }elseif($request->type=="not_implement_order"){

                $dc_rider = $request->dc_id;

                $total_rider_array = AssignToDc::where('user_id','=',$dc_rider)->where('status','=','1')->pluck('rider_passport_id')->toArray();

                $today_date = date("Y-m-d");
                $last_date = date("Y-m-d", strtotime($today_date."-1 day"));

                $total_order_implement = RiderOrderDetail::whereIn('passport_id',$total_rider_array)
                    ->where('start_date_time','LIKE','%'.$last_date.'%')
                    ->pluck('passport_id')->toArray();

                $assign_to_dc = AssignToDc::where('user_id','=',$dc_rider)->where('status','=','1')->whereNotIn('rider_passport_id',$total_order_implement)->get();

//                dd($total_order_implement);

                $type = $request->type;

                $view = view("admin-panel.assign_rider_to_dc.dc_filter_ajax_table", compact('assign_to_dc','type'))->render();
                return response()->json(['html' => $view]);


            }elseif($request->type=="rider_on_leave"){

                $today_date = date("Y-m-d");
                $dc_rider = $request->dc_id;

                $total_rider_array = AssignToDc::where('user_id','=',$dc_rider)->where('status','=','1')->pluck('rider_passport_id')->toArray();

                $today_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$today_date.'%')->pluck('passport_id')->toArray();

                $assign_to_dc = AssignToDc::where('user_id','=',$dc_rider)->where('status','=','1')->whereIn('rider_passport_id',$today_leaves)->get();

                $type = $request->type;

                $view = view("admin-panel.assign_rider_to_dc.dc_filter_ajax_table", compact('assign_to_dc','type'))->render();
                return response()->json(['html' => $view]);

            }

        }

    }

    public function rider_not_implement_attendance(){

        $user_id = Auth::user()->id;

        $total_rider_array = AssignToDc::where('user_id','=',$user_id)->where('status','=','1')->get()->pluck('rider_passport_id')->toArray();
        $today_date = date("Y-m-d");


        $last_day = date("Y-m-d", strtotime($today_date."-1 day"));

//        dd($last_day);

        $total_order_rider = RiderAttendance::whereIn('passport_id',$total_rider_array)
            ->where('created_at','LIKE','%'.$today_date.'%')
            ->distinct('passport_id')->pluck('passport_id')->toArray();

        $assign_to_dc = AssignToDc::where('user_id','=',$user_id)
                                ->whereNotIn('rider_passport_id',$total_order_rider)
                                ->where('status','=','1')->get();

        return  view("admin-panel.assign_rider_to_dc.platform_wise_list_rider",compact('assign_to_dc'));

    }

    public function rider_not_implement_orders($id=null){

        if($id!=null){
            $user_id = $id;
        }else{
            $user_id = Auth::user()->id;
        }


        $total_rider_array = AssignToDc::where('user_id','=',$user_id)->where('status','=','1')->get()->pluck('rider_passport_id')->toArray();
        $today_date = date("Y-m-d");
        $last_date = date("Y-m-d", strtotime($today_date."-1 day"));



        $total_order_rider = RiderOrderDetail::whereIn('passport_id',$total_rider_array)
            ->where('start_date_time','LIKE','%'.$last_date.'%')
            ->distinct('passport_id')->pluck('passport_id')->toArray();



        $assign_to_dc = AssignToDc::where('user_id','=',$user_id)
            ->whereNotIn('rider_passport_id',$total_order_rider)
            ->where('status','=','1')->get();

        return  view("admin-panel.assign_rider_to_dc.platform_wise_list_rider",compact('assign_to_dc'));

    }

    public function display_rider_list(Request $request){

        if($request->ajax()){
            $platform_id = $request->platform_id;
            $quantity = $request->quantity;


              $passport_not_in = AssignToDc::where('status','=','1')->where('platform_id','=',$platform_id)->groupby('rider_passport_id')->get()->pluck('rider_passport_id')->toArray();

            $user_platform_id = AssignPlateform::where('status','=','1')->where('plateform','=',$platform_id)
                ->whereNotIn('passport_id',$passport_not_in)
                ->groupby('passport_id')
                ->get()
                ->pluck('passport_id')
                ->toArray();
//            dd($user_platform_id);



             $passports = Passport::whereIn('id',$user_platform_id)->whereNotIn('id',$passport_not_in)->limit($quantity)->get();

//            dd(count($passports));

        }


        $view = view("admin-panel.assign_rider_to_dc.display_rider_list",compact('passports'))->render();
            return response()->json(['html'=>$view]);

    }

    public function display_rider_list_by_user_platform(Request $request){

        if($request->ajax()){
            $platform_id = $request->platform_id;
            $quantity = $request->quantity;
            $user_id = $request->user_id;

            $user_platform_id = AssignPlateform::where('status','=','1')->where('plateform','=',$platform_id)
                ->get()
                ->pluck('passport_id')
                ->toArray();
            $passport_not_in = AssignToDc::where('status','=','1')->where('platform_id','=',$platform_id)->where('user_id','=',$user_id)->get()->pluck('rider_passport_id')->toArray();

            $passports = Passport::whereIn('id',$passport_not_in)->limit($quantity)->get();

        }


        $view = view("admin-panel.assign_rider_to_dc.specific_rider_display_list",compact('passports'))->render();
        return response()->json(['html'=>$view]);

    }

    public function get_passport_checkin_platform(Request $request){

        if($request->ajax()){

            $userData = User::where('id','=',$request->user_id)->first();

            $platforms  = $userData->user_platform_id;

             $array_to_send = Platform::whereIn('id',$platforms)->get();



            echo json_encode($array_to_send);

            exit;

        }
    }

    public function get_dc_by_platforms(Request $request){

        if($request->ajax()){

            $userData = User::where('user_platform_id','LIKE','%'.$request->platform_id.'%')
                ->where('designation_type','=','3')
                ->where('id','!=',$request->user_id)->get();

            echo json_encode($userData);
            exit;
        }
    }

    public function get_remain_platform_counts(Request $request){

        if($request->ajax()){
            $platform_id = $request->platform_id;

            $total_platform_id = AssignPlateform::where('status','=','1')->where('plateform','=',$platform_id)
                                 ->count();
            $total_assigned = AssignToDc::where('status','=','1')->where('platform_id','=',$platform_id)->count();



            $total_remain_rider =  $total_platform_id-$total_assigned;

            $array_to_send = array(
              'total_rider_platform' =>   $total_platform_id,
              'total_rider_assigned' =>   $total_assigned,
              'total_rider_remain' =>   $total_remain_rider,
            );

            echo json_encode($array_to_send);
            exit;
        }
    }

    public function get_remain_dc_counts(Request $request){

        if($request->ajax()){
            $user_id = $request->user_id;


            if(isset($request->platform_id)){
                $total_assigned = AssignToDc::where('status','=','1')->where('user_id','=',$user_id)->where('platform_id','=',$request->platform_id)->count();
            }else{
                $total_assigned = AssignToDc::where('status','=','1')->where('user_id','=',$user_id)->count();
            }



            $total_dc_limit = DcLimit::where('user_id','=',$user_id)->first();
             $limit = $total_dc_limit->limit ? $total_dc_limit->limit : 0;


            $total_remain_rider =  $limit-$total_assigned;

            $array_to_send = array(
                'total_dc_limit' =>   $limit,
                'total_rider_assigned' =>   $total_assigned,
                'total_rider_remain' =>   $total_remain_rider,
            );

            echo json_encode($array_to_send);
            exit;
        }

    }

    public function check_dc_riders_attendance_rider(Request $request){

        if($request->ajax()){
            $user_id = Auth::user()->id;

            $total_rider_array = AssignToDc::where('user_id','=',$user_id)->where('status','=',"1")->get()->pluck('rider_passport_id')->toArray();
            $total_rider_assigned = count($total_rider_array);
            $today_date = date("Y-m-d");

            $last_date = date("Y-m-d", strtotime($today_date."-1 day"));

            $total_orders = RiderOrderDetail::whereIn('passport_id',$total_rider_array)
                                                ->where('start_date_time','LIKE','%'.$last_date.'%')
                                                ->distinct('passport_id')->count();



            $today_attendence = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','1')->where('created_at','LIKE','%'.$today_date.'%')->distinct('passport_id')->count();
            $today_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$today_date.'%')->distinct('passport_id')->count();

            $today_absent = $total_rider_assigned-($today_attendence+$today_leaves);

//            dd($today_attendence);

            $total_absent_leave_rider = $today_attendence+$today_leaves;

            $now_complete_rider = $total_orders-$today_leaves;



            $over_all_status = 0;

            $rider_order_status = 0;
            if($total_absent_leave_rider!=$total_orders){
                $rider_order_status = 1;
                $over_all_status =1;
            }

            $rider_attendance = 0;
            if($today_absent>0){
                $rider_attendance = 1;
                $over_all_status = 1;
            }


            $array_to_send = array(
                'rider_attendance_status' =>   $rider_attendance,
                'rider_order_status' =>   $rider_order_status,
                'over_all_status' =>   $over_all_status,
            );

            echo json_encode($array_to_send);
            exit;
        }

    }

    public function assign_dc_rider_download($id){



        if($id==0){

            $user = Auth::user()->designation_type;

            if($user=="1"){
                $user_id = Auth::user()->id;
                $manager_users_array = Manager_users::where('manager_user_id','=',$user_id)->pluck('member_user_id')->toArray();
                $assign_to_dc = AssignToDc::whereIn('user_id',$manager_users_array)->where('status','=','1')->get();

                $num_r = rand(0,1000);
                return Excel::download(new DcAssignRiders('admin-panel.assign_rider_to_dc.download_assign_rider_report',$assign_to_dc), "dc_rider_report{$num_r}.xlsx");


            }else{

                $manager_users_array = Manager_users::pluck('member_user_id')->toArray();
                $assign_to_dc = AssignToDc::whereIn('user_id',$manager_users_array)->where('status','=','1')->get();

                $num_r = rand(0,1000);
                return Excel::download(new DcAssignRiders('admin-panel.assign_rider_to_dc.download_assign_rider_report',$assign_to_dc), "dc_rider_report{$num_r}.xlsx");
            }



        }else{

            $assign_to_dc = AssignToDc::where('user_id','=',$id)->where('status','=','1')->get();
//            dd($assign_to_dc);

            $num_r = rand(0,1000);
            return Excel::download(new DcAssignRiders('admin-panel.assign_rider_to_dc.download_assign_rider_report',$assign_to_dc), "dc_rider_report{$num_r}.xlsx");

        }





    }



    public function get_manger_dc_user_button(Request $request){

        if($request->ajax()){

            $user = Auth::user()->designation_type;

            if($user=="1"){
                $user_id = Auth::user()->id;
                $manager_users = Manager_users::where('manager_user_id','=',$user_id)->get();

                $view = view("admin-panel.assign_rider_to_dc.download_btn_ajax",compact('manager_users'))->render();
                return response()->json(['html'=>$view]);

            }else{
                $manager_users = Manager_users::all();

                $view = view("admin-panel.assign_rider_to_dc.download_btn_ajax",compact('manager_users'))->render();
                return response()->json(['html'=>$view]);



            }
        }
    }

}
