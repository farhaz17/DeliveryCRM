<?php

namespace App\Http\Controllers\Riders\RiderAttendance;

use App\User;
use Carbon\Carbon;
use App\Model\Platform;
use App\Model\RiderProfile;
use App\Model\Manager_users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use App\Model\Attendance\RiderAttendance;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\Riders\RiderPerformance\TalabatRiderPerformance;

class RiderAttendanceController extends Controller
{
    public function rider_attendance_report(Request $request)
    {
        $current_user = auth()->user();
        $performance_date = TalabatRiderPerformance::latest()->first()->start_date;
        $talabat_rider_performances = TalabatRiderPerformance::select('id','start_date','passport_id','completed_orders')->where('start_date', $performance_date)->latest()->get();
        $all_talabat_active_riders = AssignToDc::select('user_id','rider_passport_id')->whereIn('platform_id', [15,34,41])->whereStatus(1)->get();
        $last_performance_date = $talabat_rider_performances->first()->start_date;

        $manager_dc_ids =  Manager_users::whereManagerUserId(auth()->id())->whereStatus(1)->pluck('member_user_id')->toArray();
        $dc_list = User::whereDesignationType(3)->get()->filter(function($dc)use($manager_dc_ids, $current_user){
            if($current_user->hasRole(['Admin'])){
                return true;
            }elseif($current_user->hasRole(['manager_dc'])){
                return in_array($dc->id, $manager_dc_ids);
            }elseif($current_user->hasRole(['DC_roll'])){
                return $dc->id == auth()->id();
            }
        });
        $selected_date_performances = $talabat_rider_performances->where('start_date', $last_performance_date)
        ->filter(function($rider_performance)use($manager_dc_ids, $all_talabat_active_riders, $current_user){
            if($current_user->hasRole(['Admin'])){
                return true;
            }elseif($current_user->hasRole(['manager_dc'])){
                $assign_to_dc_rider_passports = $all_talabat_active_riders->whereIn('user_id', $manager_dc_ids)->pluck('rider_passport_id')->toArray();
                return in_array($rider_performance->passport_id, $assign_to_dc_rider_passports);
            }elseif($current_user->hasRole(['DC_roll'])){
                $assign_to_dc_rider_passports = $all_talabat_active_riders->whereIn('user_id', [auth()->id()])->pluck('rider_passport_id')->toArray();
                return in_array($rider_performance->passport_id, $assign_to_dc_rider_passports);
            }
        })
        ;

        $as_per_system_total_rider = $all_talabat_active_riders->filter(function($active_riders)use($manager_dc_ids, $current_user){
            if($current_user->hasRole(['Admin'])){
                return true;
            }elseif($current_user->hasRole(['manager_dc'])){
                return in_array($active_riders->user_id, $manager_dc_ids);
            }elseif($current_user->hasRole(['DC_roll'])){
                return auth()->id() == $active_riders->user_id;
            }
        })->count();

        $talabat_platform = collect([
            'platform_id' => 15,
            'platform' => "Talabat",
            'present' => count($selected_date_performances->where('completed_orders')),
            'absent' => count($selected_date_performances) - count($selected_date_performances->where('completed_orders')),
            'orders' => $selected_date_performances->sum('completed_orders'),
            'total_rider' => count($selected_date_performances),
            'as_per_system_total_rider' => $as_per_system_total_rider,
        ]);
        $platform_att = collect([$talabat_platform])->sortBy('total_rider')->reverse()->toArray();
        return view('admin-panel.riders.rider_attendances.rider_attendance_report',compact('platform_att','dc_list', 'last_performance_date'));
    }
    public function ajax_rider_attendance_report(Request $request)
    {
        $current_user = auth()->user();
        $performance_date = carbon::parse($request->performance_date);
        $talabat_rider_performances = TalabatRiderPerformance::select('id','start_date','passport_id','completed_orders')->where('start_date', $performance_date)->latest()->get();
        $all_talabat_active_riders = AssignToDc::select('user_id','rider_passport_id')->whereIn('platform_id', [15,34,41])->whereStatus(1)->get();
        $manager_dc_ids =  Manager_users::whereManagerUserId(auth()->id())->whereStatus(1)->pluck('member_user_id')->toArray();
        $dc_list = User::whereDesignationType(3)->get()->filter(function($dc)use($manager_dc_ids, $current_user){
            if($current_user->hasRole(['Admin'])){
                return true;
            }elseif($current_user->hasRole(['manager_dc'])){
                return in_array($dc->id, $manager_dc_ids);
            }elseif($current_user->hasRole(['DC_roll'])){
                return $dc->id == auth()->id();
            }
        });

        $selected_date_performances = $talabat_rider_performances->where('start_date', $performance_date)
        ->filter(function($rider_performance)use($manager_dc_ids, $all_talabat_active_riders, $request, $current_user){
            if($current_user->hasRole(['Admin'])){
                if($request->dc_id){
                    $assign_to_dc_rider_passports = $all_talabat_active_riders->whereIn('user_id', [$request->dc_id])->pluck('rider_passport_id')->toArray();
                    return in_array($rider_performance->passport_id, $assign_to_dc_rider_passports);
                }else{
                    return true;
                }
            }elseif($current_user->hasRole(['manager_dc'])){
                if($request->dc_id){
                    $assign_to_dc_rider_passports = $all_talabat_active_riders->whereIn('user_id', [$request->dc_id])->pluck('rider_passport_id')->toArray();
                    return in_array($rider_performance->passport_id, $assign_to_dc_rider_passports);
                }else{
                    $assign_to_dc_rider_passports = $all_talabat_active_riders->whereIn('user_id', $manager_dc_ids)->pluck('rider_passport_id')->toArray();
                    return in_array($rider_performance->passport_id, $assign_to_dc_rider_passports);
                }
            }elseif($current_user->hasRole(['DC_roll'])){
                $assign_to_dc_rider_passports = $all_talabat_active_riders->whereIn('user_id', [auth()->id()])->pluck('rider_passport_id')->toArray();
                return in_array($rider_performance->passport_id, $assign_to_dc_rider_passports);
            }
        })
        ;

        $as_per_system_total_rider = $all_talabat_active_riders->filter(function($active_riders)use($manager_dc_ids, $request, $current_user){
            if($current_user->hasRole(['Admin'])){
                if($request->dc_id){
                    return $request->dc_id == $active_riders->user_id;
                }else{
                    return true;
                }
            }elseif($current_user->hasRole(['manager_dc'])){
                if($request->dc_id){
                    return $request->dc_id == $active_riders->user_id;
                }else{
                    return in_array($active_riders->user_id, $manager_dc_ids);
                }
            }elseif($current_user->hasRole(['DC_roll'])){
                return auth()->id() == $active_riders->user_id;
            }
        })->count();

        $talabat_platform = collect([
            'platform_id' => 15,
            'platform' => "Talabat",
            'present' => count($selected_date_performances->where('completed_orders')),
            'absent' => count($selected_date_performances) - count($selected_date_performances->where('completed_orders')),
            'orders' => $selected_date_performances->sum('completed_orders'),
            'total_rider' => count($selected_date_performances),
            'as_per_system_total_rider' => $as_per_system_total_rider,
        ]);
        $platform_att = collect([$talabat_platform])->sortBy('total_rider')->reverse()->toArray();
        $view = view('admin-panel.riders.rider_attendances.shared_blades.ajax_rider_attendance_report',compact('platform_att'))->render();
        return response(
            [
                'html' => $view,
            ]
        );
    }
}
