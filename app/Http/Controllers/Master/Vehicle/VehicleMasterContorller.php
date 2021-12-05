<?php

namespace App\Http\Controllers\Master\Vehicle;

use App\Model\BikeCencel;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\Assign\AssignBike;
use App\Model\BikeDetailHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\BikesTracking\BikesTracking;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\BikesTracking\BikesTrackingHistory;
use App\Model\Master\Vehicle\VehiclePlateReplace;
use App\Model\Master\Vehicle\VehicleStatusChangeHistory;

class VehicleMasterContorller extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage', ['only' => ['vehicle_life_cycle','status_wise_vehicle_report']]);
    }
    public function vehicle_life_cycle(){
        $all_bike_history = [];
        if(request('bike_id') !== null){
            $bike_id = request('bike_id');
            $count_history = count($all_bike_history);
            foreach(BikeDetail::whereId($bike_id)->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Registration';
                $all_bike_history[$count_history]['event_type'] = 'Master';
                $event_desctiption = '';
                $event_desctiption .= "The Vehicle <span class='badge badge-lg badge-danger text-white'> Registered </span> on"  . date(" F j, Y, g:i a " ,strtotime($history['created_at']));
                $all_bike_history[$count_history]['event_desctiption'] = $event_desctiption;
                $all_bike_history[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
            foreach(AssignBike::whereBike($bike_id)->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Assignment';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                if($history['checkin'] !== null){
                    $event_desctiption .= "<span class='badge badge-lg badge-success text-white'>Checked In</span> on  " . date("F j, Y, g:i a " ,strtotime($history['checkin']));
                }
                if($history['checkout'] !== null){
                    $event_desctiption .= "<span class='badge badge-lg badge-danger text-white'> Checked Out</span> on " . date("F j, Y, g:i a" ,strtotime($history['checkout']));
                }
                $all_bike_history[$count_history]['event_desctiption'] =  $event_desctiption;

                $all_bike_history[$count_history]['date_time'] = $history['checkin'];
                $count_history++;
            };
            foreach(BikeDetailHistory::whereBikeId($bike_id)->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Assignment';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                if($history['plate_no'] !== null){
                    $event_desctiption .= "Plate No: <span class='badge badge-success'> " . $history['plate_no'] . '</span> ';
                }
                if($history['created_at'] !== null){
                    $event_desctiption .= " changed on " . date(" F j, Y, g:i a" ,strtotime($history['created_at']));
                }
                $all_bike_history[$count_history]['event_desctiption'] =  $event_desctiption;
                $all_bike_history[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
            foreach(BikesTracking::whereBikeId($bike_id)->with(['tracker','previous_tracker'])->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Tracker Installation';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                $event_desctiption .= "Tracking No: <span class='badge bg-success text-white'>" . $history['tracker']['tracking_no'] . "</span> installed on " . date("F j, Y, g:i a" ,strtotime($history['checkin']));
                if($history['checkin']  && $history['checkout']){
                    $event_desctiption .= " and removed on " . date("F j, Y, g:i a" ,strtotime($history['checkout']));
                }
                $all_bike_history[$count_history]['date_time'] = $history['checkout'] ?? $history['checkin'];
                $all_bike_history[$count_history]['event_desctiption'] = $event_desctiption;
                $count_history++;
            };
            foreach(BikesTrackingHistory::whereBikeId($bike_id)->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Tracker Installation';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                if($history['tracking_number']){
                    $event_desctiption .= "Installed Tracking No: <span class='badge bg-success'>" .  $history['tracking_number'] . "</span>";
                }
                $all_bike_history[$count_history]['event_desctiption'] = $event_desctiption;
                $all_bike_history[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
            foreach(VehicleStatusChangeHistory::whereBikeId($bike_id)->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Status update';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                if($history['status_change_form'] !== null){
                    $event_desctiption .= "Status changed from " . get_vehicles_status_name($history['status_change_form']) . " to " . get_vehicles_status_name($history['status_change_to']);
                }
                $all_bike_history[$count_history]['event_desctiption'] = $event_desctiption;
                $all_bike_history[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
            foreach(VehiclePlateReplace::whereBikeId($bike_id)->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Plate Replace request';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                $event_desctiption .= "Requested to change plate no: <span class='badge bg-success text-white'>" . $history['plate_no'] . "</span> on " . $history['created_at'] ;
                $event_desctiption .= $history['reson_of_replacement'] !== null ? " as " . get_plate_replace_reason( $history['reson_of_replacement']) : '';
                if($history['status'] == 1){
                    $event_desctiption .= " and replaced with <span class='badge bg-success text-white'>" . $history['new_plate_no']  . "</span> on " . $history['updated_at'] ;
                }
                if($history['status'] == 2){
                    $event_desctiption .= " and Rejected on " . $history['updated_at'];
                }
                $all_bike_history[$count_history]['event_desctiption'] = $event_desctiption;
                $all_bike_history[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
            foreach(BikeReplacement::whereReplaceBikeId($bike_id)->with(['temporary_bike','permanent_bike','goto_assign_detail'])->oldest()->get()->toArray() as $history){
                $all_bike_history[$count_history]['event_name'] = 'Vehicle Tracker Installation';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                if($history['type'] == 2){
                    $event_desctiption ="Permanently replaced with plate no: " . $history['temporary_bike']['plate_no'] . " on" . date(" F j, Y, g:i a" ,strtotime($history['goto_assign_detail']['checkout']));
                }else{
                    if($history['type'] == 1 && $history['status'] == 0){
                        $event_desctiption .= "temporary bike plate no: " . $history['temporary_bike']['plate_no'] ." is returned on " . $history['updated_at'];
                    }
                    if($history['type'] == 1 && $history['status'] == 1){
                        $event_desctiption .= "Plate No: " . $history['temporary_bike']['plate_no'] . " is running as temporary";
                    }
                }
                $all_bike_history[$count_history]['event_desctiption'] = $event_desctiption;
                $all_bike_history[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
            foreach(BikeCencel::whereBikeId($bike_id)->oldest()->get()->toArray() as $history ){
                $all_bike_history[$count_history]['event_name'] = 'Bike Cancellation';
                $all_bike_history[$count_history]['event_type'] = 'Operation';
                $event_desctiption = '';
                if($history['date_and_time'] !== null){
                    $event_desctiption .= "Bike is <span class='badge badge-danger'>cancelled</span> on ". date(" F j, Y, g:i a " ,strtotime($history['date_and_time']));
                }
                $all_bike_history[$count_history]['event_desctiption'] = $event_desctiption;

                $all_bike_history[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
        }
        $all_bike_history = collect($all_bike_history)->sortBy('date_time')->values()->all();
        $all_bikes = BikeDetail::get(['id','plate_no','chassis_no']);
        return view('admin-panel.vehicle_master.vehicle_life_cycle', compact('all_bike_history','all_bikes'));
    }

    public function status_wise_vehicle_report(){
        $all_temporary_bikes = BikeReplacement::whereType(1)->whereStatus(1)->get();
        $temporary_replaced_bike_ids = $all_temporary_bikes->pluck('replace_bike_id')->toArray();
        $new_replaced_bike_ids = $all_temporary_bikes->pluck('new_bike_id')->toArray();

        $all_bikes = BikeDetail::with([
                'model_info',
                'year',
                'get_current_bike.passport.rider_platform',
                'get_current_bike.passport.platform_assign.plateformdetail',
                'get_current_bike.passport.personal_info',
                'get_temporaray_bike.passport.rider_platform',
                'get_temporaray_bike.passport.platform_assign.plateformdetail',
                'get_temporaray_bike.passport.personal_info',
                'traffic.passport_info.personal_info',
                'traffic.customer_supplier_info',
                'traffic.state',
                'traffic.company',
                'sub_category',
                'category'
            ])->get();
        $all_cencel_bikes = BikeCencel::pluck('bike_id');
        $total_bikes_running = $all_bikes->whereNotIn('id', $temporary_replaced_bike_ids)->where('status', 1);

        $repairing_at_garage_bikes = $all_bikes->whereIn('id',$temporary_replaced_bike_ids );

        $working_vehicles = $all_bikes->whereNotIn('id', $all_cencel_bikes)->where('status',2);
        $not_working_vehicles = $all_bikes->whereNotIn('id', $all_cencel_bikes)->where('status', 0);
        $holding_vehicles = $all_bikes->whereNotIn('id', $all_cencel_bikes)->where('status', 3);

        return view('admin-panel.vehicle_master.status_wise_vehicle_report', compact('total_bikes_running','repairing_at_garage_bikes','working_vehicles','not_working_vehicles','holding_vehicles'));
    }
}
