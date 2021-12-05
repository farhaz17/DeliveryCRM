<?php

namespace App\Http\Controllers\Master\Vehicle;

use Carbon\Carbon;
use App\Model\BikeDetail;
use App\Model\Lpo\LpoMaster;
use Illuminate\Http\Request;
use App\Imports\TrackerImport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\BikesTracking\BikesTracking;
use App\Model\BikesTracking\TrackerRequest;
use App\Model\Master\Vehicle\VehicleTrackingInventory;

class VehicleTrackingInventoryController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracking_inventories = VehicleTrackingInventory::all();
        return view('admin-panel.vehicle_master.tracking_inventory_list', compact('tracking_inventories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lpos = LpoMaster::where('inventory_type',3)->get();
        return view('admin-panel.vehicle_master.tracking_inventory_create', compact('lpos'));
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
            'tracking_no' => 'unique:vehicle_tracking_inventories|required'
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
            $vehicle_tracking_inventory = new VehicleTrackingInventory();
            $vehicle_tracking_inventory->tracking_no = $request->tracking_no;
            $vehicle_tracking_inventory->lpo_id = $request->lpo_id;
            $vehicle_tracking_inventory->save();
            $message = [
                'message' => 'Tracking Inventory Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleTrackingInventory  $vehicle_tracking_inventory
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleTrackingInventory $vehicle_tracking_inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleTrackingInventory  $vehicle_tracking_inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleTrackingInventory $vehicle_tracking_inventory)
    {
        return view('admin-panel.vehicle_master.tracking_inventory_edit', compact('vehicle_tracking_inventory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleTrackingInventory  $vehicle_tracking_inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleTrackingInventory $vehicle_tracking_inventory)
    {
        $validator = Validator::make($request->all(), [
            'tracking_no' => 'required|unique:vehicle_tracking_inventories,tracking_no,'.$vehicle_tracking_inventory->id
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
            $vehicle_tracking_inventory->tracking_no = $request->tracking_no;
            $vehicle_tracking_inventory->update();
            $message = [
                'message' => 'Tracking Inventory Updated Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleTrackingInventory  $vehicle_tracking_inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleTrackingInventory $vehicle_tracking_inventory)
    {
        //
    }

    public function dc_request_for_tracker()
    {
        $user = Auth::user();
        $tracker_installed_bike_ids = BikesTracking::whereStatus(1)->whereCheckout(null)->pluck('bike_id');
        $tracker_requested = TrackerRequest::where('type','!=','2')->pluck('bike_id');
        if($user->hasRole(['DC_roll'])){
            $tracker_free_bikes =BikeDetail::whereHas('get_current_bike.passport.dc_detail', function($q) use($user) {
                $q->where('user_id','=', $user->id);
            })->whereNotIn('id', $tracker_installed_bike_ids)->whereNotIn('id', $tracker_requested)->where('status',2)->get();
        }elseif($user->hasRole(['Admin'])){
            $tracker_free_bikes =BikeDetail::whereNotIn('id', $tracker_installed_bike_ids)->whereNotIn('id', $tracker_requested)->where('status',2)->get();
        }

        return view('admin-panel.bikes_tracking.dc_request_tracker',compact('tracker_free_bikes'));
    }

    public function save_dc_request_tracker(Request $request)
    {
        $arrays = explode(',',$request->id);
        foreach($arrays as $tracker){
            $obj = new TrackerRequest();
            $obj->bike_id = $tracker;
            $obj->user_id = Auth::user()->id;
            $obj->date = Carbon::now()->toDateString();
            $obj->status = 1;
            $obj->save();
        }
        $message = [
            'message' => 'Tracker Request Sent Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }

    public function rta_request_for_tracker()
    {
        $tracker_installed_bike_ids = BikesTracking::whereStatus(1)->whereCheckout(null)->pluck('bike_id');
        $tracker_requested = TrackerRequest::where('type','!=','2')->pluck('bike_id');
        $tracker_free_bikes = BikeDetail::whereNotIn('id', $tracker_installed_bike_ids)->whereNotIn('id', $tracker_requested)->where('status','!=','2')->get();
        return view('admin-panel.bikes_tracking.rta_request_tracker',compact('tracker_free_bikes'));
    }

    public function save_rta_request_tracker(Request $request)
    {
        $arrays = explode(',',$request->id);
        foreach($arrays as $tracker){
            $obj = new TrackerRequest();
            $obj->bike_id = $tracker;
            $obj->user_id = Auth::user()->id;
            $obj->date = Carbon::now()->toDateString();
            $obj->status = 2;
            $obj->save();
        }
        $message = [
            'message' => 'Tracker Request Sent Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }

    public function tracker_requests()
    {
        $tracker_installed = BikesTracking::whereStatus(1)->whereCheckout(null)->pluck('bike_id');
        $trackers = TrackerRequest::whereNotIn('bike_id', $tracker_installed)->where('type',0)->get();
        return view('admin-panel.bikes_tracking.all_requests_tracker',compact('trackers'));
    }

    public function tracker_upload()
    {
        $lpos = LpoMaster::where('inventory_type',3)->get();
        $lpos_keys = $lpos->filter(function($lpo){
            return $lpo->count = count(VehicleTrackingInventory::where('lpo_id', '=', $lpo->id)
                ->get());
        })->toArray();

        return view('admin-panel.bikes_tracking.tracker_upload',compact('lpos','lpos_keys'));
    }

    public function save_upload_tracker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        
        $rows_to_be_updated = head(Excel::toArray(new \App\Imports\TrackerImport('',$request->id), request()->file('select_file')));

        if (!file_exists('../public/assets/upload/excel_file/tracker_upload')) {
            mkdir('../public/assets/upload/excel_file/tracker_upload', 0777, true);
        }

        if(!empty($_FILES['select_file']['name'])) {
            $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
            $file_path_image = 'assets/upload/excel_file/tracker_upload/' . date("Y-m-d") . '/';
            $fileName = $file_path_image . time().'.'.$request->select_file->extension();
            Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
        }
        Excel::import(new \App\Imports\TrackerImport($fileName,$request->id), request()->file('select_file'));
        $message = [
            'message' => 'Uploaded Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }
}
