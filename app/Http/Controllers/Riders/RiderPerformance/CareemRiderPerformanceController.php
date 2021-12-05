<?php

namespace App\Http\Controllers\Riders\RiderPerformance;

use App\User;
use Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Imports\CareemRiderPerformanceImport;
use App\Model\Riders\RiderPerformance\CareemRiderPerformance;

class CareemRiderPerformanceController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|DC_roll', [
            'only' => [
                'index',
                'careem_rider_performances_view',
                'create',
                'store'
            ]]);
    }
    public function index()
    {
        $last_performance = CareemRiderPerformance::latest('start_date')->first();
        $dc_users = User::find(AssignToDc::whereIn('platform_id', [1,32])->get('user_id')->unique('user_id')); // at least one time he was Careem DC
        return view('admin-panel.riders.rider_performances.careem_rider_performances_index', compact('last_performance','dc_users'));
    }
    public function careem_rider_performances_view(Request $request)
    {
        // Get all cod under selected date
        $all_dc_riders = AssignToDc::latest()->get();
        $dc_id = $request->dc_id ?? "all";
        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', auth()->id())
            ->whereIn('platform_id', [1,32])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }elseif(auth()->user()->hasRole(['Admin']) && $dc_id != 'all'){
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', $dc_id)
            ->whereIn('platform_id', [1,32])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }
        $performances = CareemRiderPerformance::with(['passport.personal_info', 'passport.assign_to_dcs.user_detail'])
        ->whereBetween('start_date', [$request->start_date, $request->end_date])
        ->get()
        ->filter(function($performance)use($dc_id, $dc_rider_passport_ids){
            if($dc_id != "all"){
                return in_array($performance->passport_id, $dc_rider_passport_ids);
            }else{
                return true;
            }
        })
        ;
        // Get all active careem dc riders' passport_ids
        $active_careem_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [1,32])->where('status',1)
        ->pluck('rider_passport_id')->toArray();

        $active_careem_rider_performances = $performances->whereIn('passport_id', $active_careem_rider_passport_ids)
        ->groupBy('passport_id');

        // Get all ex careem dc riders's passport_ids
        $ex_careem_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [1,32])->where('status',0)
        ->whereNotIn('rider_passport_id', $active_careem_rider_passport_ids)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();
        $ex_careem_rider_performances = $performances->whereIn('passport_id', $ex_careem_rider_passport_ids)
        ->groupBy('passport_id');

        // Get all no careem dc riders' passport_ids
        $no_careem_rider_passport_ids = $all_dc_riders
        ->where('status', 0)
        ->filter(function($all_dc_rider){
            return $all_dc_rider->platform_id != 1 || $all_dc_rider->platform_id != 32;
        })
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();

        $no_careem_rider_performances = $performances
        ->whereNotIn('passport_id',$ex_careem_rider_passport_ids)
        ->whereNotIn('passport_id',$active_careem_rider_passport_ids)
        ->whereNotIn('platform_id', [1,32])
        ->groupBy('passport_id');

        $all_performances = $performances
        ->groupBy('passport_id');
        $file_paths = $performances->unique('uploaded_file_path');
        $file_path_dropdowns = view('admin-panel.riders.rider_performances.shared_blades.careem_rider_performance_file_dropdown_view', compact('file_paths'))->render();
        $view = view('admin-panel.riders.rider_performances.shared_blades.careem_rider_performances_view', compact('all_performances', 'active_careem_rider_performances', 'ex_careem_rider_performances', 'no_careem_rider_performances'))->render();
        return response([
            'html' => $view,
            'rider_count' => $performances ? number_format( $performances->unique('passport_id')->count(), 0) : 0,
            'trips' => $performances ? number_format($performances->sum('trips'), 0) : 0,
            'earnings' => $performances ? number_format($performances->sum('earnings'), 0) : 0,
            'completed_trips' => $performances ? number_format($performances->sum('completed_trips'), 0) : 0,
            'cash_collected' => $performances ? number_format($performances->sum('cash_collected'), 0) : 0,
            'file_path_dropdowns' =>  $file_path_dropdowns
        ]);
    }
    public function create()
    {
        $events = [];
        $data  = CareemRiderPerformance::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);
        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    'Sheet Uploaded',
                    true,
                    new \DateTime($value['start_date']),
                    new \DateTime($value['end_date'] . ' + 1 days' ),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        'contentHeight' => 100,
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);
        return view('admin-panel.riders.rider_performances.careem_rider_performances_upload', compact('calendar'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            // 'end_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        if($request->upload_or_delete === "delete"){
            // need to check the date range!!!
            $performance_exists = CareemRiderPerformance::whereDate('start_date', $request->start_date )->whereDate('end_date', $request->end_date)->get();
            $performance_exist = $performance_exists->first();
            if($performance_exist){
                // $file_exists = CareemRiderPerformanceFilePath::whereDate('start_date', $request->start_date )->whereDate('end_date', $request->end_date)->first();
                $performance_exist->uploaded_file_path ? Storage::disk('s3')->delete($performance_exist->uploaded_file_path) : "";
                foreach ($performance_exists as  $performance_exist) {
                    $performance_exist->forceDelete(); // Permanently Deleting CareemRiderPerformance Records
                }
                $message = [
                    'message' => "Performance recoreds from " . $request->start_date . " to " . $request->end_date . " deleted successfully.",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }else{
                $message = [
                    'message' => "Performance recoreds not found from " . $request->start_date . " to " . $request->end_date . " Please select correct date range.",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
        }elseif($request->upload_or_delete === "upload"){
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
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date = Carbon::parse($request->start_date)->endOfday();
            $is_already = CareemRiderPerformance::where(function($performance)use($start_date){
                $performance->whereDate('start_date', '<=', $start_date);
                $performance->whereDate('end_date', '>=', $start_date);
            })->orWhere(function($performance)use($end_date){
                $performance->whereDate('end_date', '>=', $end_date);
                $performance->whereDate('start_date', '<=', $end_date);
            })
            ->first();
            if($is_already != null){
                $message = [
                    'message' => 'For this Date Range is Already Uploaded',
                    'alert-type' => 'error'
                ];
                return redirect()->route('careem_rider_performances.create')->with($message);
            }
            $rows_to_be_updated = head(Excel::toArray(new \App\Imports\CareemRiderPerformanceImport($start_date, $end_date, ''), request()->file('select_file')));
            unset($rows_to_be_updated[0]);
            $missing_rider_ids = [];
            // $missing_rider_names = [];
            $missing_zone_names = [];
            foreach($rows_to_be_updated as $key => $row){
                $riderid_exists  = PlatformCode::whereIn('platform_id',[1, 32])->wherePlatformCode($row[2])->first();
                if(!$riderid_exists){
                    $missing_rider_ids[] = $row[2];
                    // $missing_rider_names[] = $row[1];
                    $missing_zone_names[] = $row[1];
                }
            }
            if(count($missing_rider_ids) > 0){
                $message = [
                    'message' => "Careem Rider Performance Excel sheet Upload failed",
                    'alert-type' => 'error',
                    'missing_rider_ids' => implode(',' , $missing_rider_ids),
                    // 'missing_rider_names' => implode(',' , $missing_rider_names),
                    'missing_zone_names' => implode(',' , $missing_zone_names)
                ];
                return redirect()->back()->with($message);
            }else{

                if (!file_exists('../public/assets/upload/excel_file/careem_rider_performance')) {
                    mkdir('../public/assets/upload/excel_file/careem_rider_performance', 0777, true);
                }

                if(!empty($_FILES['select_file']['name'])) {
                    $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                    $file_path_image = 'assets/upload/careem_rider_performance/' . date("Y-m-d") . '/';
                    $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                    Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
                }
                Excel::import(new CareemRiderPerformanceImport($start_date, $end_date, $fileName), request()->file('select_file'));
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
        }else{
            $message = [
                'message' => 'Operation failed',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Riders\RiderPerformance\CareemRiderPerformance  $careemRiderPerformance
     * @return \Illuminate\Http\Response
     */
    public function show(CareemRiderPerformance $careemRiderPerformance)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Riders\RiderPerformance\CareemRiderPerformance  $careemRiderPerformance
     * @return \Illuminate\Http\Response
     */
    public function edit(CareemRiderPerformance $careemRiderPerformance)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Riders\RiderPerformance\CareemRiderPerformance  $careemRiderPerformance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CareemRiderPerformance $careemRiderPerformance)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Riders\RiderPerformance\CareemRiderPerformance  $careemRiderPerformance
     * @return \Illuminate\Http\Response
     */
    public function destroy(CareemRiderPerformance $careemRiderPerformance)
    {
        //
    }
}
