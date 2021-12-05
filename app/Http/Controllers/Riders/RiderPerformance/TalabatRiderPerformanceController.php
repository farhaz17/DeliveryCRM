<?php

namespace App\Http\Controllers\Riders\RiderPerformance;
use App\User;
use Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\TalabatCod\TalabatCod;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use App\TalabatRiderPerformanceFilePath;
use Illuminate\Support\Facades\Validator;
use App\Imports\TalabatRiderPerformanceImport;
use App\Model\Riders\RiderPerformance\TalabatRiderPerformance;

class TalabatRiderPerformanceController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|DC_roll|manager_dc', [
            'only' => [
                'index',
                // 'talabat_rider_performances_view',
                'create',
                'store',
                'talabat_rider_performances_view_new',
            ]]);
    }
    public function index()
    {
        // $this->authorize(function(){
        //     return false;
        // });
        $last_performance = TalabatRiderPerformance::latest('start_date')->first();
        $dc_users = User::find(AssignToDc::whereIn('platform_id', [15,34,41])->get('user_id')->unique('user_id'))
        ->filter(function($user){
            if(auth()->user()->hasRole(['DC_roll'])){
                return auth()->id() == $user->id;
            }else{
                return true;
            }
        })
        ; // at least one time he was Talabat DC
        return view('admin-panel.riders.rider_performances.talabat_rider_performances_index', compact('last_performance','dc_users'));
    }

    public function create()
    {
        $events = [];
        $data  = TalabatRiderPerformance::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);
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
        return view('admin-panel.riders.rider_performances.talabat_rider_performances_upload', compact('calendar'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'start_date' => 'required|date',
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
            // return $request->start_date;
            $performance_exists = TalabatRiderPerformance::whereDate('start_date', $request->start_date)->get();
            $performance_exist = $performance_exists->first();
            if($performance_exist){
                // $file_exists = TalabatRiderPerformanceFilePath::whereDate('start_date', $request->start_date )->whereDate('end_date', $request->end_date)->first();
                $performance_exist->uploaded_file_path ? Storage::disk('s3')->delete($performance_exist->uploaded_file_path) : "";
                foreach ($performance_exists as  $performance_exist) {
                    $performance_exist->forceDelete(); // Permanently Deleting TalabatRiderPerformance Records
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
            $is_already = TalabatRiderPerformance::where(function($performance)use($start_date){
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
                return redirect()->route('talabat_rider_performances.create')->with($message);
            }
            $rows_to_be_updated = head(Excel::toArray(new \App\Imports\TalabatRiderPerformanceImport($start_date, $end_date, ''), request()->file('select_file')));
            unset($rows_to_be_updated[0]);
            $missing_rider_ids = [];
            $missing_rider_names = [];
            $missing_zone_names = [];
            foreach($rows_to_be_updated as $key => $row){
                $riderid_exists  = PlatformCode::whereIn('platform_id', [15,34,41])->wherePlatformCode($row[0])->first();
                if(!$riderid_exists){
                    $missing_rider_ids[] = $row[0];
                    $missing_rider_names[] = $row[1];
                    $missing_zone_names[] = $row[7];
                }
            }
            // dd($missing_rider_ids);
            if(count($missing_rider_ids) > 0){
                $message = [
                    'message' => "Talabat Rider Performance Excel sheet Upload failed",
                    'alert-type' => 'error',
                    'missing_rider_ids' => implode(',' , $missing_rider_ids),
                    'missing_rider_names' => implode(',' , $missing_rider_names),
                    'missing_zone_names' => implode(',' , $missing_zone_names)
                ];
                return redirect()->back()->with($message);
            }else{

                if (!file_exists('../public/assets/upload/excel_file/talabat_rider_performance')) {
                    mkdir('../public/assets/upload/excel_file/talabat_rider_performance', 0777, true);
                }

                if(!empty($_FILES['select_file']['name'])) {
                    $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                    $file_path_image = 'assets/upload/talabat_rider_performance/' . date("Y-m-d") . '/';
                    $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                    Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
                }
                Excel::import(new TalabatRiderPerformanceImport($start_date, $end_date, $fileName), request()->file('select_file'));
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

    public function talabat_rider_performances_view_old_backup(Request $request)
    {
        // Get all cod under selected date
        $all_dc_riders = AssignToDc::latest()->get()
        ->filter(function($assign_to_dc){
            if(auth()->user()->hasRole(['DC_roll'])){
                return $assign_to_dc->user_id == auth()->Id();
            }elseif(request('dc_id') != null){
                return $assign_to_dc->user_id  == request('dc_id');
            }else{
                return true;
            }
        })
        ;
        $dc_id = $request->dc_id ?? "all";
        $dc_rider_passport_ids = [];
        if(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', auth()->id())
            ->whereIn('platform_id', [15,34,41])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }elseif(auth()->user()->hasRole(['Admin','manager_dc']) && $dc_id != 'all'){
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', $dc_id)
            ->whereIn('platform_id', [15,34,41])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }
        $performances = TalabatRiderPerformance::with(['passport.personal_info', 'passport.assign_to_dcs.user_detail'])
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
        // Get all active talabat dc riders' passport_ids
        $active_talabat_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [15,34,41])->where('status',1)
        ->pluck('rider_passport_id')->toArray();

        $active_talabat_rider_performances = $performances->whereIn('passport_id', $active_talabat_rider_passport_ids)
        ->groupBy('passport_id');

        // Get all ex talabat dc riders's passport_ids
        $ex_talabat_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [15,34,41])->where('status',0)
        ->whereNotIn('rider_passport_id', $active_talabat_rider_passport_ids)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();
        $ex_talabat_rider_performances = $performances->whereIn('passport_id', $ex_talabat_rider_passport_ids)
        ->groupBy('passport_id');

        // Get all no talabat dc riders' passport_ids
        $no_talabat_rider_passport_ids = $all_dc_riders
        ->where('status', 0)
        ->filter(function($all_dc_rider){
            return $all_dc_rider->platform_id != 15 || $all_dc_rider->platform_id != 34 || $all_dc_rider->platform_id != 41;
        })
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();

        $no_talabat_rider_performances = $performances
        ->whereNotIn('passport_id',$ex_talabat_rider_passport_ids)
        ->whereNotIn('passport_id',$active_talabat_rider_passport_ids)
        ->whereNotIn('platform_id', [15,34,41])
        ->groupBy('passport_id');

        $all_performances = $performances
        ->groupBy('passport_id');
        $file_paths = $performances->unique('uploaded_file_path');
        $file_path_dropdowns = view('admin-panel.riders.rider_performances.shared_blades.talabat_rider_performance_file_dropdown_view', compact('file_paths'))->render();
        $view = view('admin-panel.riders.rider_performances.shared_blades.talabat_rider_performances_view', compact('all_performances', 'active_talabat_rider_performances', 'ex_talabat_rider_performances', 'no_talabat_rider_performances'))->render();
        return response([
            'html' => $view,
            'rider_count' => $performances ? number_format( $performances->unique('passport_id')->count(), 0) : 0,
            'completed_orders' => $performances ? number_format($performances->sum('completed_orders'), 0) : 0,
            'cancelled_orders' => $performances ? number_format($performances->sum('cancelled_orders'), 0) : 0,
            'completed_deliveries' => $performances ? number_format($performances->sum('completed_deliveries'), 0) : 0,
            'total_working_hours' => $performances ? number_format($performances->sum('total_working_hours'), 0) : 0,
            'file_path_dropdowns' =>  $file_path_dropdowns
        ]);
    }
    public function talabat_rider_performances_view_new(Request $request)
    {
        // Get all cod under selected date
        $all_dc_riders = AssignToDc::whereIn('platform_id', [15,34,41])
        ->where(function($assign_to_dc){
            if(request('dc_id')){
                $assign_to_dc->where('user_id', request('dc_id'));
            }
        })
        ->latest()->get();
        $with_dc_assign_to_dc_rider_passport_ids = $all_dc_riders
        ->where('status', 1)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();

        $without_dc_assign_to_dc_rider_passport_ids = $all_dc_riders
        ->where('status', 0)
        ->whereNotIn('rider_passport_id', $with_dc_assign_to_dc_rider_passport_ids)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();

        $performances = TalabatRiderPerformance::with(['passport.personal_info', 'passport.assign_to_dcs.user_detail', 'passport.zds_code'])
        ->whereBetween('start_date', [$request->start_date, $request->end_date])
        ->get();

        $with_dc_assign_to_dc_rider_performances = $performances->filter(function($performance)use($with_dc_assign_to_dc_rider_passport_ids){
            return in_array( $performance->passport_id, $with_dc_assign_to_dc_rider_passport_ids );
        })
        ->groupBy('passport_id');
        ;
        $without_dc_assign_to_dc_rider_performances = $performances->filter(function($performance)use($without_dc_assign_to_dc_rider_passport_ids){
            return in_array( $performance->passport_id, $without_dc_assign_to_dc_rider_passport_ids );
        })
        ->groupBy('passport_id');
        ;

        $rider_performances_for_dc = $performances->filter(function($performance)use($with_dc_assign_to_dc_rider_passport_ids){
            return in_array( $performance->passport_id, $with_dc_assign_to_dc_rider_passport_ids );
        })
        ->groupBy('passport_id');
        ;

        $file_paths = $performances->unique('uploaded_file_path');

        if(request('dc_id')){
            $rider_count = count($with_dc_assign_to_dc_rider_performances);
            $completed_orders = $with_dc_assign_to_dc_rider_performances->map(function($performance){
                return  ['completed_orders' => $performance->sum('completed_orders')];
            })->sum('completed_orders');
            $cancelled_orders = $with_dc_assign_to_dc_rider_performances->map(function($performance){
                return  ['cancelled_orders' => $performance->sum('cancelled_orders')];
            })->sum('cancelled_orders');
            $completed_deliveries = $with_dc_assign_to_dc_rider_performances->map(function($performance){
                return  ['completed_deliveries' => $performance->sum('completed_deliveries')];
            })->sum('completed_deliveries');
            $total_working_hours = $with_dc_assign_to_dc_rider_performances->map(function($performance){
                return  ['total_working_hours' => $performance->sum('total_working_hours')];
            })->sum('total_working_hours');
        }else{
            $rider_count = $performances ?  $performances->unique('passport_id')->count(): 0;
            $completed_orders = $performances ? $performances->sum('completed_orders'): 0;
            $cancelled_orders = $performances ? $performances->sum('cancelled_orders'): 0;
            $completed_deliveries = $performances ? $performances->sum('completed_deliveries'): 0;
            $total_working_hours = $performances ? $performances->sum('total_working_hours'): 0;
        }

        $file_path_dropdowns = view('admin-panel.riders.rider_performances.shared_blades.talabat_rider_performance_file_dropdown_view', compact('file_paths'))->render();
        $view = view('admin-panel.riders.rider_performances.shared_blades.talabat_rider_performances_view_new', compact('without_dc_assign_to_dc_rider_performances', 'with_dc_assign_to_dc_rider_performances'))->render();
        return response([
            'html' => $view,
            'rider_count' => number_format($rider_count, 0),
            'completed_orders' => number_format($completed_orders,0),
            'cancelled_orders' => number_format($cancelled_orders,0),
            'completed_deliveries' => number_format($completed_deliveries,0),
            'total_working_hours' => number_format($total_working_hours,0),
            'file_path_dropdowns' =>  $file_path_dropdowns
        ]);
    }
}
