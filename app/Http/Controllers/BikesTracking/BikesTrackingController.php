<?php

namespace App\Http\Controllers\BikesTracking;

use Carbon\Carbon;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\BikesTracking\BikesTracking;
use App\Model\BikesTracking\TrackerRequest;
use App\Model\BikesTracking\BikesTrackingHistory;
use App\Model\Master\Vehicle\VehicleTrackingInventory;

class BikesTrackingController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|master-bike-tracking', ['only' => ['index','edit','destroy','update','store']]);
        $this->middleware('role_or_permission:Admin|master-bike-tracking-history', ['only' => ['bike_tracking_history']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracker_installed_bike_ids = BikesTracking::whereStatus(1)->whereCheckout(null)->pluck('bike_id'); // All bikes on which tracker already installed and Working
        $tracker_free_bikes = BikeDetail::whereNotIn('id', $tracker_installed_bike_ids)->get();

        $occupied_trackers_ids = BikesTracking::whereStatus(1)->whereCheckout(null)->pluck('tracking_number'); // All Occupied tracker ids
        $unoccupied_trackers = VehicleTrackingInventory::whereNotIn('id',$occupied_trackers_ids)->get(); // Unoccupied trackers

        $all_installed_trackers = BikesTracking::with('tracker','bike')->whereStatus(1)->whereCheckout(null)->get();
        return view('admin-panel.bikes_tracking.bikes_tracking',compact('tracker_free_bikes','all_installed_trackers','unoccupied_trackers'));
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
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'bike_id' => 'required',
            'tracking_number' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        $selectedTracker = VehicleTrackingInventory::find($request->tracking_number); // Selected Tracker

            $obj= new BikesTracking();
            $obj->bike_id = $request->bike_id;
            $obj->tracking_number = $selectedTracker->id;
            $obj->checkin =  $request->checkin;
            $obj->type = 1;
            $obj->status = 1;
            $obj->remarks = "New Tracker Installed";
            $obj->save();

        $selectedTracker->status = 1;
        $selectedTracker->update();

        $tracker_request = TrackerRequest::where('bike_id',$request->bike_id)->where('type','!=','2')->get();
        if(count($tracker_request) != 0)
        {
            $tracker_requests = TrackerRequest::where('bike_id',$request->bike_id)->where('type','!=','2')->update(['type' => '1']);
        }
        $message = [
            'message' => 'Tracker no '. $selectedTracker->tracking_no . ' Installed on Plate No '. BikeDetail::find($obj->bike_id)->plate_no . ' Successfully ',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
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
        $bikes=BikeDetail::all();
        $tracking=BikesTracking::all();
        $tracking_edit=BikesTracking::find($id);

        return view('admin-panel.bikes_tracking.bikes_tracking',compact('bikes','tracking','tracking_edit'));
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
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'removeOrShuffle' => 'required',
            'current_tracker_id' => 'required',
            'new_tracker_id' => 'required_if:removeOrShuffle,shuffle',
            // 'removeOrShuffle' => 'unique:bikes_trackings,tracking_number,'.$id,
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        $currentInstalledTracker = BikesTracking::find($id);
        $current_vehicle_tracking_inventory = VehicleTrackingInventory::find($currentInstalledTracker->tracking_number);
        $message = '';
            $currentInstalledTracker->checkout = Carbon::now();
            $currentInstalledTracker->type =  $request->removeOrShuffle == "shuffle" ? 3 : 2 ; // removed 2 shuffle 3
            $currentInstalledTracker->status = 0;
            $currentInstalledTracker->remarks = $request->remarks;
                if($request->removeOrShuffle == "shuffle"){
                    $newinstallTracker = new BikesTracking();
                    $newinstallTracker->checkin = Carbon::now();
                    $newinstallTracker->tracking_number =  $request->new_tracker_id;;
                    $newinstallTracker->bike_id = $currentInstalledTracker->bike_id;
                    $newinstallTracker->status = 1;
                    $newinstallTracker->type = 1;
                    $newinstallTracker->save();
                    $message = 'Tracker No: '. $newinstallTracker->tracker->tracking_no . ' installed, ';
                    $currentInstalledTracker->new_shuffled_tracker_id =  $request->new_tracker_id;
                }
            $currentInstalledTracker->update();
            $message .= 'Tracker No: ' . $currentInstalledTracker->tracker->tracking_no .' removed successfully!';
        $current_vehicle_tracking_inventory->update(['status' => 0]);

        if($request->removeOrShuffle == "remove"){
            $tracker_request = TrackerRequest::where('bike_id',$currentInstalledTracker->bike_id)->where('type','!=','2')->get();
            if(count($tracker_request) != 0)
            {
                $tracker_requests = TrackerRequest::where('bike_id',$currentInstalledTracker->bike_id)->where('type','!=','2')->update(['type' => '2']);
            }
        }
        $message = [
            'message' =>  $message,
            'alert-type' => 'success'
        ];
        return redirect()->route('bike_tracking')->with($message);
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


    public function bike_tracking_history(){
        $bike_tracker_histroy = BikesTracking::with(['bike','tracker', 'previous_tracker'])->get();
        return view('admin-panel.bikes_tracking.bike_tracking_history',compact('bike_tracker_histroy'));
    }

    public function ajax_get_bike_tracker_history(Request $request)
    {
        $bike_tracker_history = BikesTracking::whereBikeId($request->bike_id)->get();
        $view = view("admin-panel.bikes_tracking.shared_blades.bike_tracker_history",compact('bike_tracker_history'))->render();
        return response()->json(['html'=>$view]);
    }
}
