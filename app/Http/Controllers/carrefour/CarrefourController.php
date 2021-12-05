<?php

namespace App\Http\Controllers\carrefour;

use App\User;
use Calendar;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Model\Passport\Passport;
use Illuminate\Support\Facades\DB;
use App\Imports\CarrefourCodImport;
use App\Http\Controllers\Controller;
use App\Imports\CarrefourCashImport;
use App\Model\AssingToDc\AssignToDc;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Carrefour\CarrefourCod;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use App\Model\Carrefour\CarrefourUploads;
use Illuminate\Support\Facades\Validator;
use App\Model\Carrefour\CarrefourFilePath;
use App\Model\Carrefour\CarrefourFollowUp;
use App\Model\Carrefour\CarreforCloseMonth;
use App\Model\Passport\passport_addtional_info;

class CarrefourController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Cod Admin', ['only' => [
            'carrefour_update_cash_cod', 'carrefour_delete_cash_cod'
        ]]);
    }
    public function index()
    {
        return view('admin-panel.carrefour.carrefour_cod_upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rider_ids = PlatformCode::where('platform_id','38')->get();
        return view('admin-panel.carrefour.carrefour_add_cash',compact('rider_ids'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->upload_or_delete == "delete"){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $cod_exits = CarrefourUploads::where('start_date', $start_date)->where('end_date', $end_date)->delete();
            if($cod_exits){
                $file_exists = CarrefourFilePath::whereDate('upload_start_date', $request->start_date )->where('type', 0)->first();
                $file_exists->file_path ? Storage::disk('s3')->delete($file_exists->file_path) : "";
                $message = [
                    'message' => "Cod on between " . $start_date." and ".$end_date. " deleted successfully.",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }else{
                $message = [
                    'message' => "Cod not found on " . $start_date." to ".$end_date,
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
        }elseif($request->upload_or_delete == "Upload")
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
            $start_date = Carbon::parse($request->start_date)->startOfDay();
            $end_date = Carbon::parse($request->end_date)->endOfday();
            $already = CarrefourUploads::where(function($upload)use($start_date){
                $upload->whereDate('start_date', '<=', $start_date);
                $upload->whereDate('end_date', '>=', $start_date);
            })->orWhere(function($upload)use($end_date){
                $upload->whereDate('end_date', '>=', $end_date);
                $upload->whereDate('start_date', '<=', $end_date);
            })->first();
                if($already){
                    $message = [
                        'message' => 'For this Date Range is Already Uploaded',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }
        $rows_to_be_updated = head(Excel::toArray(new \App\Imports\CarrefourCodImport($request->start_date,$request->end_date), request()->file('select_file')));
        // dd($rows_to_be_updated);
        $missing_rider_ids = [];
        $missing_rider_names = [];
        foreach($rows_to_be_updated as $key => $row){
            if(!empty($row[1])){
                $riderid_exists  = PlatformCode::where('platform_id','38')->wherePlatformCode($row[0])->first();
                if(!$riderid_exists){
                    $missing_rider_ids[] = $row[0];
                    $missing_rider_names[] = $row[1];
                }
            }
        }
        if(count($missing_rider_ids) > 0){
            $message = [
                'message' => "Carrefour Excel Upload failed",
                'alert-type' => 'error',
                'missing_rider_ids' => implode(',' , $missing_rider_ids),
                'missing_rider_names' => implode(',' , $missing_rider_names)
            ];
            return redirect()->back()->with($message);
        }else {
            Excel::import(new CarrefourCodImport($request->start_date,$request->end_date), request()->file('select_file'));

            if (!file_exists('../public/assets/upload/excel_file/carrefour_cod')) {
                mkdir('../public/assets/upload/excel_file/carrefour_cod', 0777, true);
            }
            if(!empty($_FILES['select_file']['name'])) {
                $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                $file_name = time()."_" .$request->start_date.'.'.$ext;
                $file_path = 'assets/upload/excel_file/carrefour_cod/'.$file_name;
                // $file_path_image = 'assets/upload/excel_file/carrefour_cod/' . date("Y-m-d") . '/';
                // $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                Storage::disk('s3')->put($file_path, file_get_contents($request->select_file));
                $excel_path = new CarrefourFilePath();
                $excel_path->upload_start_date = $request->start_date;
                $excel_path->file_path = $file_path;
                $excel_path->type = 0;
                $excel_path->save();
            }
            $message = [
                'message' => 'Uploaded Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }
    }else {
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->ajax()){
            $carrefour_rider_passport_ids = AssignToDc::whereIn('platform_id',[38])->distinct('rider_passport_id')->pluck('rider_passport_id');
            $carrefour_riders = Passport::select('id','pp_uid','passport_no')->with(['personal_info:id,passport_id,full_name'])
            ->whereIn('id', $carrefour_rider_passport_ids)->get();
                $carrefour_cods = CarrefourCod::with(['passport.carrefour_plateform_code', 'passport.personal_info'])
                    ->where(function($carrefour_cod){
                        if(request('start_date') && request('end_date')){
                            $carrefour_cod->whereBetween('date', [request('start_date'), request('end_date')]);
                        }
                    })
                ->get();
            $view = view('admin-panel.carrefour.shared_blades.ajax_carrefour_cash_cod', compact('carrefour_cods', 'carrefour_riders'))->render();
            return response([
                'html' => $view,
                'total_amount' => number_format($carrefour_cods->sum('amount'), 2)
            ]);
        }

        return view('admin-panel.carrefour.carrefour_cash_cod');
    }
    public function carrefour_update_cash_cod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carrefour_cash_cod_id' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        carrefourCod::find($request->carrefour_cash_cod_id)->update([
            "date"=> $request->date,
            "amount" => $request->amount
        ]);
        return redirect()->route('carrefour_cash_cod', ['start_date'=> request('start_date'), 'end_date' => request('end_date')]);
    }
    public function carrefour_delete_cash_cod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carrefour_cash_cod_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        carrefourCod::find($request->carrefour_cash_cod_id)->delete();
        return redirect()->route('carrefour_cash_cod', ['start_date'=> request('start_date'), 'end_date' => request('end_date')]);

    }
    public function ajax_total_cod_cash(Request $request){

        $data = CarrefourCod::whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    public  function carrefour_render_calender(Request $request){

        if($request->ajax()){
            $events = [];
            $data  = CarrefourUploads::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);

            if($data->count()) {
                foreach ($data as $key => $value) {
                    $events[] = Calendar::event(
                        'Sheet Uploaded',
                        true,
                        new \DateTime($value->start_date),
                        new \DateTime($value->end_date.' +1 day'),
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
            $html = view('admin-panel.cod_uploads.render_calender_ajax',compact('calendar'))->render();
            return $html;
        }
    }

    public  function carrefour_cash_render_calender(Request $request){

        if($request->ajax()){
            $events = [];
            $data  = CarrefourCod::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);

            if($data->count()) {
                foreach ($data as $key => $value) {
                    if($value->start_date != null){
                        $events[] = Calendar::event(
                            'Sheet Uploaded',
                            true,
                            new \DateTime($value->start_date),
                            new \DateTime($value->end_date.' +1 day'),
                            null,
                            // Add color and link on event
                            [
                                'color' => '#f05050',
                                'contentHeight' => 100,
                            ]
                        );
                    }
                }
            }
            $calendar = Calendar::addEvents($events);
            $html = view('admin-panel.cod_uploads.render_calender_ajax',compact('calendar'))->render();
            return $html;
        }
    }

    public function carrefour_store_cash(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zds_code' => 'required',
            'date' => 'required|date',
            'amount' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        $array = explode(',',$request->zds_code);
        $cod = new CarrefourCod();
        $cod->passport_id = $array[0];
        $cod->rider_id = $array[1];
        $cod->date = $request->date;
        $cod->amount = $request->amount;
        $cod->save();
        $message = [
            'message' => 'Cod Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function close_month()
    {
        $uploads = CarrefourUploads::select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
        $cods = CarrefourCod::all();
        $close_month = CarreforCloseMonth::all();
        return view('admin-panel.carrefour.carrefour_close_month',compact('uploads','cods','close_month'));
    }

    public function save_close_month(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        foreach($request->details as $key => $value) {
            if(isset($request->details[$key]['rider_ids']) && isset($request->details[$key]['passport_id'])) {
                $close_month = new CarreforCloseMonth();
                $close_month->date = $request->date;
                $close_month->passport_id = $request->details[$key]['passport_id'];
                $close_month->platform_code = $request->details[$key]['rider_ids'];
                $close_month->close_month_amount = $request->details[$key]['amount'];
                $close_month->save();
            }
        }
        $message = [
            'message' => 'Month has been Closed Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function cash_cod_upload()
    {
        return view('admin-panel.carrefour.upload_cash_cod');
    }

    public function store_cash_cod_upload(Request $request)
    {
        if($request->upload_or_delete == "delete"){
            $start_date = $request->start_date;
            $cod_exits = CarrefourCod::where('start_date', $start_date)->delete();
            if($cod_exits){
                $file_exists = CarrefourFilePath::whereDate('upload_start_date', $request->start_date )->where('type', 1)->first();
                $file_exists->file_path ? Storage::disk('s3')->delete($file_exists->file_path) : "";
                $message = [
                    'message' => "Cod on " . $start_date." deleted successfully.",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }else{
                $message = [
                    'message' => "Cod not found on " . $start_date,
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
        }elseif($request->upload_or_delete == "Upload")
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
            $already = CarrefourCod::where('start_date',$request->start_date)->first();
                if($already){
                    $message = [
                        'message' => 'For this Date Range is Already Uploaded',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }
        $rows_to_be_updated = head(Excel::toArray(new \App\Imports\CarrefourCashImport($request->start_date,$request->end_date), request()->file('select_file')));
        // dd($rows_to_be_updated);
        $missing_rider_ids = [];
        foreach($rows_to_be_updated as $key => $row){
            if(!empty($row[0])){
                $riderid_exists  = PlatformCode::where('platform_id','38')->wherePlatformCode($row[0])->first();
                if(!$riderid_exists){
                    $missing_rider_ids[] = $row[0];
                }
            }
        }
        if(count($missing_rider_ids) > 0){
            $message = [
                'message' => "Carrefour Excel Upload failed",
                'alert-type' => 'error',
                'missing_rider_ids' => implode(',' , $missing_rider_ids),
            ];
            return redirect()->back()->with($message);
        }
        $rider_ids = [];
        $dates = [];
        $amounts = [];
        foreach($rows_to_be_updated as $key => $row){
            if(!empty($row[0])){
                $riderid_exists  = CarrefourCod::where('rider_id',$row[0])->where('date',$row[1])->where('amount',$row[2])->first();
                if($riderid_exists){
                    $rider_ids[] = $row[0];
                    $dates[] = $row[1];
                    $amounts[] = $row[3];
                }
            }
        }
        if(count($rider_ids) > 0){
            $message = [
                'message' => "Carrefour Excel Upload failed",
                'alert-type' => 'error',
                'rider_ids' => implode(',' , $rider_ids),
                'dates' => implode(',' , $dates),
                'amounts' => implode(',' , $amounts),
            ];
            return redirect()->back()->with($message);
        }else {
            Excel::import(new CarrefourCashImport($request->start_date,$request->start_date), request()->file('select_file'));

            if (!file_exists('../public/assets/upload/excel_file/carrefour_cash_cod')) {
                mkdir('../public/assets/upload/excel_file/carrefour_cash_cod', 0777, true);
            }
            if(!empty($_FILES['select_file']['name'])) {
                $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                $file_name = time()."_" .$request->start_date.'.'.$ext;
                $file_path = 'assets/upload/excel_file/carrefour_cash_cod/'.$file_name;
                // $file_path_image = 'assets/upload/excel_file/carrefour_cash_cod/' . date("Y-m-d") . '/';
                // $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                Storage::disk('s3')->put($file_path, file_get_contents($request->select_file));
                $excel_path = new CarrefourFilePath();
                $excel_path->upload_start_date = $request->start_date;
                $excel_path->file_path = $file_path;
                $excel_path->type = 1;
                $excel_path->save();
            }
            $message = [
                'message' => 'Uploaded Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }
    }else {
        $message = [
            'message' => 'Operation failed',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($message);
    }
    }

    public function rider_wise_cod()
    {
        return view('admin-panel.carrefour.carrefour_rider_cod');
    }

    public function ajax_rider_report(Request $request)
    {
        $searach = '%' . $request->keyword . '%';
        $passport_id = Passport::where('passport_no', 'like', $searach)->first()->id;

        $plateforms = PlatformCode::where('passport_id',$passport_id)->where('platform_id','38')->get();
        if(count($plateforms) != '0'){
        $upload = CarrefourUploads::where('passport_id',$passport_id)->get();
        $codss = CarrefourCod::where('passport_id',$passport_id)->get();
        $closemonth = CarreforCloseMonth::where('passport_id',$passport_id)->get();

        $now_cod = CarrefourCod::where('passport_id',$passport_id)->sum('amount');
        $close = CarreforCloseMonth::where('passport_id',$passport_id)->sum('close_month_amount');
        $riderProfile = CarrefourUploads::where('passport_id',$passport_id)->select( DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();

            $total_paid_amount = 0;
            if(count($riderProfile) != 0){
            $remain_cod = $riderProfile[0]['total'];}
            else{
            $remain_cod = 0;}
            $remain_amount = 0;

            if($now_cod != null){
                $total_paid_amount = $now_cod;
            }
            if($close != null){
                $total_paid_amount = $total_paid_amount+$close;
            }
            if($remain_cod != null){
                $remain_amount = number_format((float)$remain_cod-$total_paid_amount, 2, '.', '');
            }
            $plate = passport_addtional_info::where('passport_id',$passport_id)->first();
            $record = 'abc';
            $view = view('admin-panel.carrefour.ajax_rider_report', compact('plate','record','upload','codss','closemonth','remain_amount'))->render();
            return response()->json(['html' => $view]);
        }else{
            $record = 'no records';
            $view = view('admin-panel.carrefour.ajax_rider_report', compact('record'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function carrefour_balance_cod()
    {
        $dc_users = User::find(AssignToDc::where('platform_id', '38')->get('user_id')->unique('user_id'));
        return view('admin-panel.carrefour.carrefour_balance_cod',compact('dc_users'));
    }

    public function carrefour_buttons(Request $request)
    {
        $user_id = $request->dc;
        if($user_id == null || $user_id == 'all'){
            $riderProfile = CarrefourUploads::select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
        }else{
            $riderProfile = CarrefourUploads::whereHas('passport.rider_dc_detail', function($q) use($user_id) {
                $q->where('user_id','=', $user_id);
            })->select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
        }
        $cods = CarrefourCod::all();
        $close_month = CarreforCloseMonth::all();
        $bl_fivehundred = array();
        $ab_fivehundred = array();
        $ab_thousand = array();
        $ab_thousandfive = array();
        $ab_twothousand = array();
        $ab_twofivethousand = array();
        foreach($riderProfile as $rider){
            $total_paid_amount = 0;
            $remain_cod = $rider->total;
            $remain_amount = 0;
            $now_cod = $cods->where('passport_id',$rider->passport_id)->sum('amount');
            $close = $close_month->where('passport_id','=',$rider->passport_id)->sum('close_month_amount');

            if($now_cod != null){
                $total_paid_amount = $now_cod;
            }
            if($close != null){
                $total_paid_amount = $total_paid_amount+$close;
            }
            if($remain_cod != null){
                $remain_amount = number_format((float)$remain_cod-$total_paid_amount, 2, '.', '');
            }
            if($remain_amount<500){
                $bl_fivehundred [] = $rider->passport_id;
            }elseif($remain_amount >= 500 && $remain_amount < 1000){
                $ab_fivehundred [] = $rider->passport_id;
            }elseif($remain_amount >= 1000 && $remain_amount < 1500){
                $ab_thousand [] = $rider->passport_id;
            }elseif($remain_amount >= 1500 && $remain_amount < 2000){
                $ab_thousandfive [] = $rider->passport_id;
            }elseif($remain_amount >= 2000 && $remain_amount < 2500){
                $ab_twothousand [] = $rider->passport_id;
            }elseif($remain_amount >= 2500){
                $ab_twofivethousand [] = $rider->passport_id;
            }
        }
        $one = count($bl_fivehundred);
        $two = count($ab_fivehundred);
        $three = count($ab_thousand);
        $four = count($ab_thousandfive);
        $five = count($ab_twothousand);
        $six = count($ab_twofivethousand);
        return view('admin-panel.carrefour.carrefour_buttons',compact('one','two','three','four','five','six'));
    }

    public function ajax_balance_cod(Request $request)
    {
        $user_id = $request->dc;
        $cods = CarrefourCod::all();
        $close_month = CarreforCloseMonth::all();
        $amt = $request->btnValue;

        $all_dc_riders = AssignToDc::latest()->get();
        $active_rider_passport_ids = $all_dc_riders->whereIn('platform_id', [38])->where('status',1)->pluck('rider_passport_id')->toArray();
        $ex_rider_passport_ids = $all_dc_riders->whereIn('platform_id', [38])->where('status',0)->whereNotIn('rider_passport_id', $active_rider_passport_ids)
        ->unique('rider_passport_id')->pluck('rider_passport_id')->toArray();

        if($user_id == null || $user_id == 'all'){

            $riderProfile = CarrefourUploads::select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
            $active_rider_cods = $riderProfile->whereIn('passport_id', $active_rider_passport_ids);
            $ex_rider_cods = $riderProfile->whereIn('passport_id', $ex_rider_passport_ids);
            $no_rider_cods = $riderProfile->whereNotIn('passport_id',$ex_rider_passport_ids)->whereNotIn('passport_id',$active_rider_passport_ids)
            ->whereNotIn('platform_id', [38]);

        }else{
            $riderProfile = CarrefourUploads::whereHas('passport.rider_dc_detail', function($q) use($user_id) {
                $q->where('user_id','=', $user_id);
            })->select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
            $active_rider_cods = $riderProfile->whereIn('passport_id', $active_rider_passport_ids);
            $ex_rider_cods = $riderProfile->whereIn('passport_id', $ex_rider_passport_ids);
            $no_rider_cods = $riderProfile->whereNotIn('passport_id',$ex_rider_passport_ids)->whereNotIn('passport_id',$active_rider_passport_ids)
            ->whereNotIn('platform_id', [38]);
        }

        $view = view('admin-panel.carrefour.ajax_balance_cod',compact('amt','riderProfile','cods','close_month','active_rider_cods','ex_rider_cods','no_rider_cods'))->render();
        return $view;
    }

    public function save_followup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passport_id' => 'required',
            'carrefour_upload_id' => 'required',
            'feedback_id' => 'required',
        ],
            $messages = [
                'feedback_id.required' => "Please select a feedback"
            ]
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => $validate->first(),
                'status' =>'500'
            ]);
        }
        $carrefour_follow_up = CarrefourFollowUp::create([
            'user_id' => auth()->id(),
            'passport_id' => $request->passport_id,
            'carrefour_upload_id' => $request->carrefour_upload_id,
            'feedback_id' => $request->feedback_id,
            'remarks' => $request->remarks,
        ]);

        if($carrefour_follow_up){
            return response([
                'html' => null,
                'alert-type' => 'success',
                'message' => 'Follow Up Added!',
                'status' =>'200'
            ]);
        }else{
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => 'Follow Up Adding failed!',
                'status' =>'500'
            ]);
        }
    }

    public function follow_up_calls(Request $request)
    {
        $follow_up_calls = CarrefourUploads::whereId($request->carrefour_upload_id)->with('follow_ups')->first()->follow_ups;
        $view = view('admin-panel.carrefour.follow_up_calls',compact('follow_up_calls'))->render();
        return response()->json(['html' => $view]);
    }

    public function uploaded_data(Request $request)
    {
        if($request->ajax()) {

            $data = CarrefourUploads::where('start_date',$request->start_date)->get();

            return Datatables::of($data)
                ->addColumn('rider_name', function (CarrefourUploads $cod) {
                    return isset($cod->passport->personal_info->full_name) ? $cod->passport->personal_info->full_name : 'N/A';
                })
                ->make(true);
        }

        $batchs = CarrefourUploads::distinct()->get(['start_date','end_date']);
        return view('admin-panel.carrefour.uploaded_data',compact('batchs'));
    }

    public function get_details(Request $request)
    {
        if($request->ajax()) {

            $total_amount = CarrefourUploads::select(DB::raw('sum(amount) as total_amount'))->where('start_date', '=', $request->start_date)->first();
            $total_rider = CarrefourUploads::where('start_date', '=', $request->start_date)->count();
            $origina_file = CarrefourFilePath::where('upload_start_date', '=', $request->start_date)->where('type', 0)->first();

            $array_to_send = array(
                'total_amount' => isset($total_amount->total_amount) ? number_format($total_amount->total_amount, 2) : 0,
                'total_rider' => isset($total_rider) ? $total_rider : 0,
                'original_path' => isset($origina_file->file_path) ? Storage::temporaryUrl($origina_file->file_path, now()->addMinutes(5)) : '',
            );

            echo json_encode($array_to_send);
            exit;
        }
    }

    public function dashboard()
    {
        $first_date[] = CarrefourUploads::oldest()->first()->start_date ?? Carbon::today()->format('Y-m-d');
        $first_date[] = CarrefourCod::oldest()->first()->date ?? Carbon::today()->format('Y-m-d');
        $first_date[] = CarreforCloseMonth::oldest()->first()->date ?? Carbon::today()->format('Y-m-d');

        $start_dates[] = min($first_date);
        $end_dates = CarreforCloseMonth::distinct('start_date')->pluck('date')->toArray();
        $start_dates = array_merge($start_dates, $end_dates);
        $date_range = [
            'start_dates' => $start_dates,
            'end_dates' => $end_dates
        ];
        return view('admin-panel.carrefour.dashboard',compact('date_range'));
    }

    public function ajax_dashboard()
    {
        if(request('date_range') == 'latest'){
            $start_date = CarreforCloseMonth::latest('date')->first()->date ?? CarrefourUploads::oldest('start_date')->first()->start_date ?? Carbon::today();
            $end_date = Carbon::today()->format('Y-m-d');
        }else{
            $date_range = request('date_range') ? explode('_', request('date_range')) : [];
            $start_date = $date_range[0];
            $end_date = $date_range[1];
        }
        $uploaded_cods = CarrefourUploads::with(['passport.personal_info'])->whereBetween('start_date', [$start_date, $end_date])->get();
        $total_cod = $uploaded_cods->sum('amount');
        $cods = CarrefourCod::with(['passport.check_platform_code_exist', 'passport.personal_info'])->whereBetween('date', [$start_date, $end_date])->get();
        $total_received_cod = $cods->sum('amount');
        $close_month = CarreforCloseMonth::whereDate('date', request('date_range') == 'latest' ? $start_date : $end_date )->sum('close_month_amount');
        $total_remain = $total_cod - ($total_received_cod + (request('date_range') == 'latest' ? 0 : $close_month));
        $total_cash_received = $cods->sum('amount');//->where('type',0);
        $total_bank_received = 0; //$cods->where('type',1)->sum('amount');
        $view = view('admin-panel.carrefour.shared_blades.ajax_carrefour_cod_report',
            compact(
                'cods',
                'total_remain',
                'total_cash_received',
                'total_bank_received',
                'uploaded_cods',
                'total_cod',
                'close_month',
                'start_date',
                'end_date'
            ))->render();
            return response([
                'html' => $view
            ]);
    }
}
