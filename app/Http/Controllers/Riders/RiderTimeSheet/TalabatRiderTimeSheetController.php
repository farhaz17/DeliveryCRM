<?php

namespace App\Http\Controllers\Riders\RiderTimeSheet;

use App\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Imports\TalabatRiderTimeSheetImport;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use App\Model\Riders\RiderTimeSheet\TalabatRiderTimeSheet;

class TalabatRiderTimeSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $last_time_sheet = TalabatRiderTimeSheet::latest('start_date')->first();
        $dc_users = User::find(AssignToDc::whereIn('platform_id', [15,34,41])->get('user_id')->unique('user_id'))
        ->filter(function($user){
            if(auth()->user()->hasRole(['DC_roll'])){
                return auth()->id() == $user->id;
            }else{
                return true;
            }
        })
        ; // at least one time he was Talabat DC
        return view('admin-panel.riders.rider_time_sheets.index', compact('last_time_sheet','dc_users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = [];
        $data  = TalabatRiderTimeSheet::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);
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
        return view('admin-panel.riders.rider_time_sheets.talabat_rider_time_sheet_upload', compact('calendar'));
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
            $time_sheet_exists = TalabatRiderTimeSheet::whereDate('start_date', $request->start_date)->get();
            $time_sheet_exist = $time_sheet_exists->first();
            if($time_sheet_exist){
                // $file_exists = TalabatRiderTimeSheetFilePath::whereDate('start_date', $request->start_date )->whereDate('end_date', $request->end_date)->first();
                $time_sheet_exist->uploaded_file_path ? Storage::disk('s3')->delete($time_sheet_exist->uploaded_file_path) : "";
                foreach ($time_sheet_exists as  $time_sheet_exist) {
                    $time_sheet_exist->Delete(); // Permanently Deleting TalabatRiderTimeSheet Records
                }
                $message = [
                    'message' => "Time Sheet recoreds from " . $request->start_date . " to " . $request->end_date . " deleted successfully.",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }else{
                $message = [
                    'message' => "Time Sheet recoreds not found from " . $request->start_date . " to " . $request->end_date . " Please select correct date range.",
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
            $is_already = TalabatRiderTimeSheet::where(function($time_sheet)use($start_date){
                $time_sheet->whereDate('start_date', '<=', $start_date);
                $time_sheet->whereDate('end_date', '>=', $start_date);
            })->orWhere(function($time_sheet)use($end_date){
                $time_sheet->whereDate('end_date', '>=', $end_date);
                $time_sheet->whereDate('start_date', '<=', $end_date);
            })
            ->first();
            if($is_already != null){
                $message = [
                    'message' => 'For this Date Range is Already Uploaded',
                    'alert-type' => 'error'
                ];
                return redirect()->route('talabat_rider_time_sheets.create')->with($message);
            }
            $rows_to_be_updated = head(Excel::toArray(new \App\Imports\TalabatRiderTimeSheetImport($start_date, $end_date, ''), request()->file('select_file')));
            unset($rows_to_be_updated[0]);
            $missing_rider_ids = [];
            $missing_rider_names = [];
            $missing_city_names = [];
            foreach($rows_to_be_updated as $key => $row){
                $riderid_exists  = PlatformCode::whereIn('platform_id', [15,34,41])->wherePlatformCode($row[0])->first();
                if(!$riderid_exists){
                    $missing_rider_ids[] = $row[0];
                    $missing_rider_names[] = $row[1];
                    $missing_city_names[] = $row[3];
                }
            }
            // dd($missing_rider_ids);
            if(count($missing_rider_ids) > 0){
                $message = [
                    'message' => "Talabat Rider Time Sheet Excel sheet Upload failed",
                    'alert-type' => 'error',
                    'missing_rider_ids' => implode(',' , $missing_rider_ids),
                    'missing_rider_names' => implode(',' , $missing_rider_names),
                    'missing_city_names' => implode(',' , $missing_city_names)
                ];
                return redirect()->back()->with($message);
            }else{

                if (!file_exists('../public/assets/upload/excel_file/talabat_rider_time_sheet')) {
                    mkdir('../public/assets/upload/excel_file/talabat_rider_time_sheet', 0777, true);
                }

                if(!empty($_FILES['select_file']['name'])) {
                    $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                    $file_path_image = 'assets/upload/talabat_rider_time_sheet/' . date("Y-m-d") . '/';
                    $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                    Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
                }
                Excel::import(new TalabatRiderTimeSheetImport($start_date, $end_date, $fileName), request()->file('select_file'));
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
     * @param  \App\TalabatRiderTimeSheet  $talabatRiderTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function show(TalabatRiderTimeSheet $talabatRiderTimeSheet)
    {
        dd('Under maintenance');
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TalabatRiderTimeSheet  $talabatRiderTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function edit(TalabatRiderTimeSheet $talabatRiderTimeSheet)
    {
        dd('Under maintenance');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TalabatRiderTimeSheet  $talabatRiderTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TalabatRiderTimeSheet $talabatRiderTimeSheet)
    {
        dd('Under maintenance');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TalabatRiderTimeSheet  $talabatRiderTimeSheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(TalabatRiderTimeSheet $talabatRiderTimeSheet)
    {
        dd('Under maintenance');
    }

    public function talabat_rider_time_sheet_view(Request $request)
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

        $time_sheets = TalabatRiderTimeSheet::with(['passport.personal_info', 'passport.assign_to_dcs.user_detail'])
        ->whereBetween('start_date', [$request->start_date, $request->end_date])
        ->get();

        $with_dc_assign_to_dc_rider_time_sheets = $time_sheets->filter(function($time_sheet)use($with_dc_assign_to_dc_rider_passport_ids){
            return in_array( $time_sheet->passport_id, $with_dc_assign_to_dc_rider_passport_ids );
        })
        ->groupBy('passport_id');
        ;
        $without_dc_assign_to_dc_rider_time_sheets = $time_sheets->filter(function($time_sheet)use($without_dc_assign_to_dc_rider_passport_ids){
            return in_array( $time_sheet->passport_id, $without_dc_assign_to_dc_rider_passport_ids );
        })
        ->groupBy('passport_id');
        ;

        $rider_time_sheets_for_dc = $time_sheets->filter(function($time_sheet)use($with_dc_assign_to_dc_rider_passport_ids){
            return in_array( $time_sheet->passport_id, $with_dc_assign_to_dc_rider_passport_ids );
        })
        ->groupBy('passport_id');
        ;

        $file_paths = $time_sheets->unique('uploaded_file_path');

        if(request('dc_id')){
            $rider_count = count($with_dc_assign_to_dc_rider_time_sheets);
            $orders = $with_dc_assign_to_dc_rider_time_sheets->map(function($time_sheet){
                return  ['orders' => $time_sheet->sum('orders')];
            })->sum('orders');
            $deliveries = $with_dc_assign_to_dc_rider_time_sheets->map(function($time_sheet){
                return  ['deliveries' => $time_sheet->sum('deliveries')];
            })->sum('deliveries');
            $distance = $with_dc_assign_to_dc_rider_time_sheets->map(function($time_sheet){
                return  ['distance' => $time_sheet->sum('distance')];
            })->sum('distance');
            $total_delivery_pay = $with_dc_assign_to_dc_rider_time_sheets->map(function($time_sheet){
                return  ['total_delivery_pay' => $time_sheet->sum('total_delivery_pay')];
            })->sum('total_delivery_pay');
        }else{
            $rider_count = $time_sheets ?  $time_sheets->unique('passport_id')->count(): 0;
            $orders = $time_sheets ? $time_sheets->sum('orders'): 0;
            $deliveries = $time_sheets ? $time_sheets->sum('deliveries'): 0;
            $distance = $time_sheets ? $time_sheets->sum('distance'): 0;
            $total_delivery_pay = $time_sheets ? $time_sheets->sum('total_delivery_pay'): 0;
        }

        $file_path_dropdowns = view('admin-panel.riders.rider_time_sheets.shared_blades.talabat_rider_time_sheet_file_dropdown_view', compact('file_paths'))->render();
        $view = view('admin-panel.riders.rider_time_sheets.shared_blades.talabat_rider_time_sheet_view', compact('without_dc_assign_to_dc_rider_time_sheets', 'with_dc_assign_to_dc_rider_time_sheets'))->render();
        return response([
            'html' => $view,
            'rider_count' => number_format($rider_count, 0),
            'orders' => number_format($orders,0),
            'deliveries' => number_format($deliveries,0),
            'distance' => number_format($distance,0),
            'total_delivery_pay' => number_format($total_delivery_pay,0),
            'file_path_dropdowns' =>  $file_path_dropdowns
        ]);
    }
}
