<?php

namespace App\Http\Controllers\Attendance;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Attendance\RiderAttendance;
use App\Model\BikeDetail;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Platform;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\RiderProfile;
use App\Model\UserCodes\UserCodes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;

class AttendanceController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|DC_roll|attandance-rider-attandance', ['only' => ['index','ajax_get_attendance_date','ajax_get_attendance_user','ajax_refresh_show','update_to_present']]);
    }

    public function index(){
        $user_platforms=Auth::user()->user_platform_id;
        $platforms=Platform::whereIn('id',$user_platforms)->get();
        $platform_att2 = array();
        foreach ($platforms as $platform_res) {
            $array_pasport1 = $platform_res->assign_platforms2->pluck('passport_id')->toArray();
            $array_pasport = array_unique($array_pasport1);
            $rider_attendance = RiderAttendance::whereIn('passport_id', $array_pasport)->whereDate('created_at', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $rider_profile = RiderProfile::whereIn('passport_id', $array_pasport)->pluck('passport_id')->toArray();
            $at = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',1)->get();
            $total_leave = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',2)->count();
            $ab = RiderProfile::whereNotIn('passport_id', $rider_profile)->get();
            $total_platform= AssignPlateform::where('plateform',$platform_res->id)->where('status','1')->count();
            $total_absent=$total_platform- count($at);
            $yesteday_date=date('Y-m-d',strtotime("-1 days"));
            $total_orders=RiderOrderDetail::where('platform_id',$platform_res->id)->whereDate('start_date_time', '=',
            $yesteday_date)->count();
            $gamer = array(
                'platform_id' => $platform_res->id,
                'platform' => $platform_res->name,
                'present' => count($at),
                'absent' => $total_absent,
                'orders' => $total_orders,
                'total_rider' => $total_platform,
                'leave' => $total_leave,
            );
            $platform_att2[] = $gamer;
            $platform_att = collect($platform_att2)->sortBy('total_rider')->reverse()->toArray();
        }
        return view('admin-panel.attendance.rider_attendance',compact('platform_att','platforms'));
    }
    public function ajax_get_attendance_date(Request $request){
        $date_search=$request->keyword;
        $platform_id=$request->platform;
        $designaiton_type = Auth::user()->designation_type;
        if($designaiton_type=="3"){
            $user_id = Auth::user()->id;
            $total_rider_array = AssignToDc::where('user_id','=',$user_id)->where('status','=',"1")->get()->pluck('rider_passport_id')->toArray();
            $platform_ids = Platform::whereIn('id', $platform_id)->pluck('id')->toArray();
            $passsport = AssignPlateform::whereIn('plateform', $platform_ids)->whereIn('passport_id',$total_rider_array)->where('status','=','1')->pluck('passport_id')->toArray();
            $attendance=RiderAttendance::
            whereDate('created_at', '=', $request->keyword)
                ->where('status','=','1')
                ->whereIn('passport_id', $passsport)
                ->get();
            $leave=RiderAttendance::whereDate('created_at', '=', $request->keyword)
                ->where('status','=','2')
                ->whereIn('passport_id', $passsport)
                ->get();
            $absent = RiderAttendance::
            whereDate('created_at', '=', $request->keyword)
                ->whereIn('status', [1,2])
                ->whereIn('passport_id', $passsport)
                ->get();
            $attendance_array=array();
            $i=0;
            foreach($absent as $x){
                $attendance_array[]=$absent[$i]->passport_id;
                $i++;
            }
            $rider_profiles=AssignPlateform::whereIn('plateform',$platform_ids)->where('status','1')->get();
            $rider_profile=$rider_profiles->whereNotIn('passport_id',$attendance_array)->whereIn('passport_id',$total_rider_array);
           }else{
               $platform_ids = Platform::whereIn('id', $platform_id)->pluck('id')->toArray();
               $passsport = AssignPlateform::whereIn('plateform', $platform_ids)->where('status','=','1')->pluck('passport_id')->toArray();
               $attendance=RiderAttendance::
               whereDate('created_at', '=', $request->keyword)
                   ->where('status','=','1')
                   ->whereIn('passport_id', $passsport)
                   ->get();
               $leave=RiderAttendance::whereDate('created_at', '=', $request->keyword)
                   ->where('status','=','2')
                   ->whereIn('passport_id', $passsport)
                   ->get();
               $absent = RiderAttendance::
               whereDate('created_at', '=', $request->keyword)
                   ->whereIn('status', [1,2])
                   ->whereIn('passport_id', $passsport)
                   ->get();
               $attendance_array=array();
               $i=0;
               foreach($absent as $x){
                   $attendance_array[]=$absent[$i]->passport_id;
                   $i++;
               }
               $rider_profiles=AssignPlateform::whereIn('plateform',$platform_ids)->where('status','1')->get();
               $rider_profile=$rider_profiles->whereNotIn('passport_id',$attendance_array);
           }
        $view = view("admin-panel.attendance.ajax_get_attendance", compact('attendance','rider_profile','date_search','leave'))->render();
        return response()->json(['html' => $view]);
    }
    public function ajax_get_attendance_user(Request $request){
        if($request->filter_by == "1"){
            //passport number
            $searach = $request->keyword;
            $passport = Passport::where('passport_no', $searach)->first();
            $attendance = RiderAttendance::where('passport_id', $passport->id)->get();
            $view = view("admin-panel.attendance.ajax_get_attendance_user", compact('attendance'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->filter_by == "2"){
            //passport number
            $searach = '%' . $request->keyword . '%';
            $passport = passport_addtional_info::where('full_name', 'like', $searach)->pluck('passport_id')->toArray();
            $attendance = RiderAttendance::whereIn('passport_id', $passport)->get();
            $view = view("admin-panel.attendance.ajax_get_attendance_user", compact('attendance'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->filter_by == "3"){
            //ppuid
            $searach = '%' . $request->keyword . '%';
            $passport = Passport::where('pp_uid', 'like', $searach)->pluck('id')->toArray();
            $attendance = RiderAttendance::whereIn('passport_id', $passport)->get();
            $view = view("admin-panel.attendance.ajax_get_attendance_user", compact('attendance'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->filter_by == "4") {
                //zds code
            $searach = '%' . $request->keyword . '%';
            $passport = UserCodes::where('zds_code', 'like', $searach)->pluck('passport_id')->toArray();
            $attendance = RiderAttendance::whereIn('passport_id', $passport)->get();
            $view = view("admin-panel.attendance.ajax_get_attendance_user", compact('attendance'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->filter_by == "5"){
            //plate number
            $searach = '%' . $request->keyword . '%';
            $bike_ids = BikeDetail::where('plate_no', 'like', $searach)->pluck('id')->toArray();
            $assign_bike = AssignBike::with(['plateform' => function ($query) {
                $query->where('status', '=', '1');
            }])->whereIn('bike', $bike_ids)
                ->orderby('updated_at', 'desc')
                ->first();
            $attendance = RiderAttendance::where('passport_id', $assign_bike->passport_id)->get();
            $view = view("admin-panel.attendance.ajax_get_attendance_user", compact('attendance'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->filter_by == "6"){
            //platform
            $searach = '%' . $request->keyword . '%';
            $platform_ids = Platform::where('name', 'like', $searach)->pluck('id')->toArray();
            $passsport = AssignPlateform::whereIn('plateform', $platform_ids)->where('status','=','1')->pluck('passport_id')->toArray();
            $attendance = RiderAttendance::whereIn('passport_id', $passsport)->get();
            $view = view("admin-panel.attendance.ajax_get_attendance_user", compact('attendance'))->render();
            return response()->json(['html' => $view]);
        }
    }
    public function ajax_refresh_show(){
        $platforms=Platform::all();
        $platform_att2 = array();
        foreach ($platforms as $platform_res) {
            $array_pasport1 = $platform_res->assign_platforms2->pluck('passport_id')->toArray();
            $array_pasport = array_unique($array_pasport1);
            $rider_attendance = RiderAttendance::whereIn('passport_id', $array_pasport)->whereDate('created_at', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $rider_profile = RiderProfile::whereIn('passport_id', $array_pasport)->pluck('passport_id')->toArray();
            $at = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',1)->get();
            $total_leave = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',2)->count();
            $ab = RiderProfile::whereNotIn('passport_id', $rider_profile)->get();
            $total_platform= AssignPlateform::where('plateform',$platform_res->id)->where('status','1')->count();
            $total_absent=$total_platform- count($at);
            $yesteday_date=date('Y-m-d',strtotime("-1 days"));
            $total_orders=RiderOrderDetail::where('platform_id',$platform_res->id)->whereDate('start_date_time', '=',
            $yesteday_date)->count();
            $gamer = array(
                'platform_id' => $platform_res->id,
                'platform' => $platform_res->name,
                'present' => count($at),
                'absent' => $total_absent,
                'orders' => $total_orders,
                'total_rider' => $total_platform,
                'leave' => $total_leave,
            );
            $platform_att2[] = $gamer;
            $platform_att = collect($platform_att2)->sortBy('total_rider')->reverse()->toArray();
        }
        $view = view("admin-panel.attendance.ajax_refresh_show", compact('platform_att'))->render();
        return response()->json(['html' => $view]);
    }
    public function update_to_present(Request $request) {
        if($request->present_or_leave == 1) {
            foreach($request->passport_id as $passport_id) {
                $obj = new RiderAttendance();
                $obj->passport_id = $passport_id;
                $obj->status = 1;
                $obj->created_at = $request->created_at;
                $obj->save();
            }
            return response()->json([
                'code' => 1,
                'message' => "success"
            ]);
        }
        if($request->present_or_leave == 2) {
            foreach($request->passport_id as $passport_id) {
                $obj = new RiderAttendance();
                $obj->passport_id = $passport_id;
                $obj->status = 2;
                $obj->created_at = $request->created_at;
                $obj->save();
            }
            return response()->json([
                'code' => 1,
                'message' => "success"
            ]);
        }
        $item = RiderAttendance::where('passport_id', $request->passport_id)->where('created_at', 'LIKE', "%$request->created_at%")->first();
        if($item){
            if($request->present) {
                $item->status = 1;
            }
            if($request->leave) {
                $item->status = 2;
            }
            $item->save();
        }else {
            $obj = new RiderAttendance();
            $obj->passport_id = $request->passport_id;
            if($request->present) {
                $obj->status = 1;
            }
            if($request->leave) {
                $obj->status = 2;
            }
            $obj->created_at = $request->created_at;
            $obj->save();
        }
        return response()->json([
            'code' => 1,
            'message' => "success"
        ]);
    }
}
