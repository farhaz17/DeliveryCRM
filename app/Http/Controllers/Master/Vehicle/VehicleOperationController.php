<?php

namespace App\Http\Controllers\Master\Vehicle;

use Carbon\Carbon;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Company\Traffic;
use App\Model\Master\Vehicle\VehicleMake;
use App\Model\Master\Vehicle\VehicleYear;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleModel;
use App\Model\Master\Vehicle\VehicleCategory;
use App\Model\Master\Vehicle\VehiclePlateCode;
use App\Model\Master\Vehicle\VehicleSubCategory;
use App\Model\Master\Vehicle\VehicleStatusChangeHistory;

class VehicleOperationController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage', ['only' => ['vehicle_cancel_form','vehicle_cancel_store','vehicle_working_status_form','ajax_get_vehicle_sub_categories','ajax_get_filtered_bikes','vehicle_working_status_store','vehicle_working_status_bulk_update']]);
    }

    public function vehicle_cancel_form()
    {
        $all_bike_details  = BikeDetail::whereNotIn('id', BikeCencel::pluck('bike_id'))->get();
        return view('admin-panel.vehicle_master.vehicle_cancel_form', compact('all_bike_details'));
    }

    public function vehicle_cancel_store(Request $request){
        $validator = Validator::make($request->all(), [
            'bike_id' => 'required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
            $bike_exist = BikeDetail::find($request->bike_id);
            if($bike_exist->status != 1){
                $new_bike_cancel = new BikeCencel();
                $new_bike_cancel->bike_id = $bike_exist->id;
                $new_bike_cancel->date_and_time = $request->date_and_time;
                $new_bike_cancel->remarks = $request->remarks;
                $new_bike_cancel->save();
                $message = [
                    'message' => 'Vehicle Cancelled Successfully',
                    'alert-type' => 'success'
                ];
            }else if($bike_exist->status == 1){
                $message = [
                    'message' => 'Selected bike is active. Please inactive the bike first',
                    'alert-type' => 'error'
                ];
            }
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    // Vehicle Cancellation ends here

    // Vehicle Woking Status update starts here

    public function vehicle_working_status_form()
    {
        $all_bike_details  = BikeDetail::whereNotIn('id', BikeCencel::pluck('bike_id'))->whereNotIn('status', [1])->get();
        $vehicle_categories = VehicleCategory::whereHas('bikes')->get();
        $vehicle_models = VehicleModel::whereHas('bikes')->get();
        $vehicle_years = VehicleYear::whereHas('bikes')->get();
        $vehicle_makes = VehicleMake::whereHas('bikes')->get();
        $vehicle_plate_codes = VehiclePlateCode::whereHas('bikes')->get();
        $traffics = Traffic::whereHas('bikes')->whereNotIn('traffic_for',[2])->get();
        return view('admin-panel.vehicle_master.vehicle_working_status_form', compact('all_bike_details','vehicle_categories','vehicle_models','vehicle_years','vehicle_makes','vehicle_plate_codes','traffics'));
    }
    public function ajax_get_vehicle_sub_categories(Request $request)
    {
        return VehicleSubCategory::whereVehicleCategoryId($request->category_id)->whereHas('bikes')->get();
    }
    public function ajax_get_filtered_bikes(Request $request)
    {
         $filtered_bikes = BikeDetail::where(function($bikes){
            if(request('traffic_id') !== null){
                $bikes->where('traffic_file', request('traffic_id'));
            }
            if(request('vehicle_category_id') !== null){
                $bikes->where('category_type', request('vehicle_category_id'));
            }
            if(request('vehicle_sub_category_id') !== null){
                $bikes->where('vehicle_sub_category_id', request('vehicle_sub_category_id'));
            }
            if(request('vehicle_model_id') !== null){
                $bikes->where('model', request('vehicle_model_id'));
            }
            if(request('vehicle_year_id') !== null){
                $bikes->where('make_year', request('vehicle_year_id'));
            }
            if(request('vehicle_make_id') !== null){
                $bikes->where('make_id', request('vehicle_make_id'));
            }
            if(request('vehicle_plate_code_id') !== null){
                $bikes->where('plate_code', request('vehicle_plate_code_id'));
            }
            if(request('vehicle_status') !== null){
                $bikes->where('status', request('vehicle_status'));
            }
        })
        ->whereNotIn('traffic_file',Traffic::whereTrafficFor(2)->pluck('id')) // remove personal vehicles
        ->whereNotIn('status', [1]) // status 1 bike can't be updated and showed
        ->whereNotIn('id', BikeCencel::pluck('bike_id')) // cancelled bikes excluded
        ->get();
        $view = view('admin-panel.vehicle_master.shared_blades.filtered_vehicle_list_with_status', compact('filtered_bikes'))->render();
        return response()->json(['html' => $view]);
    }
    public function vehicle_working_status_store(Request $request){
        $validator = Validator::make($request->all(), [
            'bike_id' => 'required',
            // 'date_and_time' => 'required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {
          $bike_exist = BikeDetail::whereId($request->bike_id)->whereNotIn('id', BikeCencel::pluck('bike_id'))->whereIn('status',[0,2,3])->first();
            if($bike_exist){
                $new_bike_history = new VehicleStatusChangeHistory();
                $new_bike_history->bike_id = $bike_exist->id;
                $new_bike_history->change_date = Carbon::now();  // $request->date_and_time;
                $new_bike_history->status_change_form = $bike_exist->status;
                $new_bike_history->status_change_to = $request->status_change_to;
                $new_bike_history->changed_by = auth()->id();
                $new_bike_history->remarks = $request->remarks;
                $new_bike_history->save();

                if($new_bike_history->id){
                    $bike_exist->status = $request->status_change_to;
                    $bike_exist->update();
                }

                $message = [
                    'message' => 'Vehicle status update Successfully',
                    'alert-type' => 'success'
                ];
            }else{
                $message = [
                    'message' => 'Vehicle not found',
                    'alert-type' => 'error'
                ];
            }
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    public function vehicle_working_status_bulk_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'update_all_status' => 'required_if:update_all_to_same_status,1'
        ],
        $messages = [
            'update_all_status.required_if' => "Please Select any status form top bar"
            ]
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return $message;
        }
        try{
            foreach($request->status as $bike_id => $status){
                $bike_exist = BikeDetail::whereId($bike_id)->whereNotIn('id', [1])->first();
                if(isset($request->update_all_to_same_status)){ // checking all status checked or not
                    if($bike_exist->status !== (int)$request->update_all_status){
                        $new_bike_history = new VehicleStatusChangeHistory();
                        $new_bike_history->bike_id = $bike_id;
                        $new_bike_history->change_date = Carbon::now();
                        $new_bike_history->status_change_form = $bike_exist->status;
                        $new_bike_history->status_change_to = $request->update_all_status;
                        $new_bike_history->changed_by = auth()->id();
                        $new_bike_history->remarks = "Bulk Update Operation";
                        $new_bike_history->save();
                    $bike_exist->status = $request->update_all_status;
                    $bike_exist->update();
                    }
                }elseif($bike_exist->status !== (Int)$status){
                        $new_bike_history = new VehicleStatusChangeHistory();
                        $new_bike_history->bike_id = $bike_id;
                        $new_bike_history->change_date = Carbon::now();
                        $new_bike_history->status_change_form = $bike_exist->status;
                        $new_bike_history->status_change_to = $status;
                        $new_bike_history->changed_by = auth()->id();
                        $new_bike_history->remarks = "Individual Update Operation";
                        $new_bike_history->save();
                    $bike_exist->status = $status;
                    $bike_exist->update();
                }
            }
            $message = [
                'message' => isset($request->update_all_to_same_status) ?  "Bulk Status update successful!" : "Individual Status update successful",
                'alert-type' => 'success',
            ];
        return $message;
    }catch (\Illuminate\Database\QueryException $e) {
        $message = [
            'message' => $e->getMessage(),
            'alert-type' => 'error'
        ];
        return $message;
        }
    }
    // Vehicle Woking Status ends here
}
