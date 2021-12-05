<?php

namespace App\Http\Controllers\Api\Attendance;

use App\Http\Middleware\Rider;
use App\Model\Attendance\RiderAttendance;
use App\Model\Passport\Passport;
use App\Model\RiderProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Carbon\Carbon;

class AttendanceApiController extends Controller
{
    //

    public  function get_attendance(Request $request)
    {

         $response = [];
         $riderProfile  = RiderProfile::where('user_id','=',Auth::user()->id)->first();
         $user_passport_id = $riderProfile->passport_id;
        $status=$request->input('status');

        $check_in_platform = $riderProfile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

        if($check_in_platform == null){

            $response['code'] = 2;
            $response['message'] = "platform is not assigned";
            return response()->json($response);
        }


        $user_today_att=RiderAttendance::where('passport_id',$user_passport_id)->whereDate('created_at', '=', Carbon::today()->toDateString())->first();
            if (empty($user_today_att)){
              $obj = new RiderAttendance();
              $obj->passport_id = $user_passport_id;
              $obj->status = $status;
              $obj->save();
              $response['code'] = 0;
              $response['message'] = 'Your Attendance Have Been Marked Successfully!';
              return response()->json($response);
          }
          else{
              $response['code'] = 1;
              $response['message'] = 'You have already marked your attendance!';
              return response()->json($response);
        }
        dd('asdf');
    }


    public  function get_attendance_status()
    {
        $response = [];
        $riderProfile  = RiderProfile::where('user_id','=',Auth::user()->id)->first();
        $user_passport_id = $riderProfile->passport_id;
        $user_today_att=RiderAttendance::where('passport_id',$user_passport_id)->whereDate('created_at', '=', Carbon::today()->toDateString())->first();




        if (empty($user_today_att)){
            $response['code'] = 0;
            return response()->json($response);
        }
        else{
            $response['code'] = 1;
            return response()->json($response);
        }

    }
}
