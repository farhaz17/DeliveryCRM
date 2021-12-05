<?php

namespace App\Http\Controllers\careem;

use App\User;
use Calendar;
use DataTables;
use App\Model\Careem;
use App\CareemFilePath;
use App\Model\CareemCod;
use Illuminate\Http\Request;
use App\Model\CareemFollowUp;
use Illuminate\Support\Carbon;
use App\Model\CareemCloseMonth;
use App\Imports\CareemCodImport;
use App\Model\Passport\Passport;
use App\Model\CodUpload\CodUpload;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Model\Passport\passport_addtional_info;

class CareemController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Cod Admin', ['only' => [
            'careem_update_bank_cod', 'careem_update_cash_cod',
            'careem_delete_cash_cod', 'careem_delete_bank_cod'
            ]]);
    }
    public function index()
    {
        return view('admin-panel.careem.careem_cod_upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rider_ids = PlatformCode::whereIn('platform_id',[1,32])->get();
        return view('admin-panel.careem.careem_cash_cod',compact('rider_ids'));
    }
    public function careem_update_bank_cod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'careem_cash_cod_id' => 'required',
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

        CareemCod::find($request->careem_cash_cod_id)->update([
            "date"=> $request->date,
            "amount" => $request->amount
        ]);
        return redirect()->route('careem_bank_cod', ['start_date'=> request('start_date'), 'end_date' => request('end_date')]);
    }
    public function careem_update_cash_cod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'careem_cash_cod_id' => 'required',
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

        CareemCod::find($request->careem_cash_cod_id)->update([
            "date"=> $request->date,
            "amount" => $request->amount
        ]);
        return redirect()->route('careem_cash_cod', ['start_date'=> request('start_date'), 'end_date' => request('end_date')]);
    }

    public function careem_delete_cash_cod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'careem_cash_cod_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        CareemCod::find($request->careem_cash_cod_id)->delete();
        return redirect()->route('careem_cash_cod', ['start_date'=> request('start_date'), 'end_date' => request('end_date')]);
    }
    public function careem_delete_bank_cod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'careem_bank_cod_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        CareemCod::find($request->careem_bank_cod_id)->delete();
        return redirect()->route('careem_bank_cod', ['start_date'=> request('start_date'), 'end_date' => request('end_date')]);

    }
    public function store(Request $request)
    {
        if($request->upload_or_delete == "delete"){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $cod_exits = Careem::where('start_date', $start_date)->where('end_date', $end_date)->delete();
            if($cod_exits){
                $file_exists = CareemFilePath::whereDate('upload_start_date', $request->start_date )->first();
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
            $already = Careem::where(function($upload)use($start_date){
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
        $rows_to_be_updated = head(Excel::toArray(new \App\Imports\CareemCodImport($request->start_date,$request->end_date), request()->file('select_file')));
        // dd($rows_to_be_updated);
        $missing_rider_ids = [];
        $missing_rider_names = [];
        foreach($rows_to_be_updated as $key => $row){
            if(!empty($row[2])){
                $riderid_exists  = PlatformCode::whereIn('platform_id',[1,32])->wherePlatformCode($row[2])->first();
                if(!$riderid_exists){
                    $missing_rider_ids[] = $row[2];
                    $missing_rider_names[] = $row[3];
                }
            }
        }
        if(count($missing_rider_ids) > 0){
            $message = [
                'message' => "Careem Excel Upload failed",
                'alert-type' => 'error',
                'missing_rider_ids' => implode(',' , $missing_rider_ids),
                'missing_rider_names' => implode(',' , $missing_rider_names)
            ];
            return redirect()->back()->with($message);
        }else {
            Excel::import(new CareemCodImport($request->start_date,$request->end_date), request()->file('select_file'));

            if (!file_exists('../public/assets/upload/excel_file/careem_cod')) {
                mkdir('../public/assets/upload/excel_file/careem_cod', 0777, true);
            }
            if(!empty($_FILES['select_file']['name'])) {
                $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                // $file_path_image = 'assets/upload/excel_file/careem_cod/' . date("Y-m-d") . '/';
                // $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                $file_name = time()."_" .$request->start_date.'.'.$ext;
                $file_path = 'assets/upload/excel_file/careem_cod/'.$file_name;
                Storage::disk('s3')->put($file_path, file_get_contents($request->select_file));
                $excel_path = new CareemFilePath();
                $excel_path->upload_start_date = $request->start_date;
                $excel_path->file_path = $file_path;
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
    public function show()
    {
        $rider_ids = PlatformCode::whereIn('platform_id',[1,32])->get();
        return view('admin-panel.careem.careem_bank_cod',compact('rider_ids'));
    }

    public  function careem_render_calender(Request $request){

        if($request->ajax()){
            $events = [];
            $data  = Careem::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);

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

    public function store_cash_cod(Request $request)
    {
        $cod = new CareemCod();
        $cod->passport_id = $request->zds_code;
        $cod->date = $request->date;
        $cod->time = $request->time;
        $cod->amount = $request->amount;
        $cod->type = 1;
        $cod->save();
        $message = [
            'message' => 'Cod Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function store_bank_cod(Request $request)
    {
        if($request->picture != null){
            if (!file_exists('../public/assets/upload/careem_cods/')) {
                mkdir('../public/assets/upload/careem_cods/', 0777, true);
            }
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;
            $file_path = 'assets/upload/careem_cods/' . $file_name;
            Storage::disk('s3')->put($file_path, file_get_contents($request->picture));
        }
        $cod = new CareemCod();
        $cod->passport_id = $request->zds_code;
        $cod->date = $request->date;
        $cod->time = $request->time;
        $cod->amount = $request->amount;
        $cod->message = $request->message;
        if($request->picture){
        $cod->image = $file_path;}
        $cod->type = 0;
        $cod->save();
        $message = [
            'message' => 'Cod Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function cash_cod(Request $request)
    {
        if($request->ajax()){
            $careem_rider_passport_ids = AssignToDc::whereIn('platform_id',[1,32])->distinct('rider_passport_id')->pluck('rider_passport_id');
            $carrem_riders = Passport::select('id','pp_uid','passport_no')->with(['personal_info:id,passport_id,full_name'])
            ->whereIn('id', $careem_rider_passport_ids)->get();
                $careem_cods = CareemCod::with(['passport.careem_plateform_code', 'passport.personal_info'])
                    ->where(function($careem_cod){
                        if(request('start_date') && request('end_date')){
                            $careem_cod->whereBetween('date', [request('start_date'), request('end_date')]);
                        }
                    })
                    ->where('type','1') ->orderby('id','desc') ->get();
                $view = view('admin-panel.careem.shared_blades.ajax_cash_cod', compact('careem_cods', 'carrem_riders'))->render();
                return response([
                    'html' => $view,
                    'total_amount' => number_format($careem_cods->sum('amount'), 2)
                ]);
        }
        return view('admin-panel.careem.cash_cod');
    }

    public function ajax_total_cod_cash(Request $request){

        $data = CareemCod::where('type','1')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }

    public function bank_cod(Request $request)
    {
        if($request->ajax()){
            $careem_rider_passport_ids = AssignToDc::whereIn('platform_id',[1,32])->distinct('rider_passport_id')->pluck('rider_passport_id');
            $carrem_riders = Passport::select('id','pp_uid','passport_no')->with(['personal_info:id,passport_id,full_name'])
            ->whereIn('id', $careem_rider_passport_ids)->get();
                $careem_cods = CareemCod::with(['passport.careem_plateform_code', 'passport.personal_info'])
                    ->where(function($careem_cod){
                        if(request('start_date') && request('end_date')){
                            $careem_cod->whereBetween('date', [request('start_date'), request('end_date')]);
                        }
                    })->where('type','0') ->orderby('id','desc') ->get();
                $view = view('admin-panel.careem.shared_blades.ajax_bank_cod', compact('careem_cods', 'carrem_riders'))->render();
                return response([
                    'html' => $view,
                    'total_amount' => number_format($careem_cods->sum('amount'), 2)
                ]);
        }
        return view('admin-panel.careem.bank_cod');

    }

    public function ajax_total_cod_bank(Request $request){

        $data = CareemCod::where('type','0')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }

    public function close_month()
    {
        $cods = CareemCod::all();
        $close_month = CareemCloseMonth::all();
        $uploads = Careem::select('*', DB::raw('sum(total_driver_other_cost) as total'))->groupBy('passport_id')->get();
        return view('admin-panel.careem.close_month',compact('cods','uploads','close_month'));
    }

    public function save_close_month(Request $request)
    {
        foreach($request->details as $key => $value) {
            if(isset($request->details[$key]['rider_ids']) && isset($request->details[$key]['passport_id'])) {
                $close_month = new CareemCloseMonth();
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

    public function rider_wise_cod()
    {
        return view('admin-panel.careem.careem_rider_cod');
    }

    public function ajax_rider_report(Request $request)
    {
        $searach = '%' . $request->keyword . '%';
        $passport_id = Passport::where('passport_no', 'like', $searach)->first()->id;

        $plateforms = PlatformCode::where('passport_id',$passport_id)->whereIn('platform_id',[1,32])->get();
        if(count($plateforms) != '0'){
        $upload = Careem::where('passport_id',$passport_id)->get();
        $codss = CareemCod::where('passport_id',$passport_id)->get();
        $closemonth = CareemCloseMonth::where('passport_id',$passport_id)->get();

        $now_cod = CareemCod::where('passport_id',$passport_id)->sum('amount');
        $close = CareemCloseMonth::where('passport_id',$passport_id)->sum('close_month_amount');
        $riderProfile = Careem::where('passport_id',$passport_id)->select( DB::raw('sum(total_driver_other_cost) as total'))->groupBy('passport_id')->get();

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
            $view = view('admin-panel.careem.ajax_rider_report', compact('plate','record','upload','codss','closemonth','remain_amount'))->render();
            return response()->json(['html' => $view]);
        }else{
            $record = 'no records';
            $view = view('admin-panel.careem.ajax_rider_report', compact('record'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function careem_balance_cod()
    {
        $dc_users = User::find(AssignToDc::whereIn('platform_id', [1,32])->get('user_id')->unique('user_id'));
        return view('admin-panel.careem.careem_balance_cod',compact('dc_users'));
    }

    public function careem_buttons(Request $request)
    {
        $user_id = $request->dc;
        if($user_id == null || $user_id == 'all'){
            $riderProfile = Careem::select('*', DB::raw('sum(total_driver_other_cost) as total'))->groupBy('passport_id')->get();
        }else{
            $riderProfile = Careem::with('follow_ups')->whereHas('passport.rider_dc_detail', function($q) use($user_id) {
                $q->where('user_id','=', $user_id);
            })->select('*', DB::raw('sum(total_driver_other_cost) as total'))->groupBy('passport_id')->get();
        }
        $cods = CareemCod::all();
        $close_month = CareemCloseMonth::all();
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
        return view('admin-panel.careem.careem_buttons',compact('one','two','three','four','five','six'));
    }

    public function ajax_balance_cod(Request $request)
    {
        $user_id = $request->dc;
        $cods = CareemCod::all();
        $close_month = CareemCloseMonth::all();
        $amt = $request->btnValue;

        $all_dc_riders = AssignToDc::latest()->get();
        $active_rider_passport_ids = $all_dc_riders->whereIn('platform_id', [1,32])->where('status',1)->pluck('rider_passport_id')->toArray();
        $ex_rider_passport_ids = $all_dc_riders->whereIn('platform_id', [1,32])->where('status',0)->whereNotIn('rider_passport_id', $active_rider_passport_ids)
        ->unique('rider_passport_id')->pluck('rider_passport_id')->toArray();

        if($user_id == null || $user_id == 'all'){

            $riderProfile = Careem::with('follow_ups')->select('*', DB::raw('sum(total_driver_other_cost) as total'))->groupBy('passport_id')->get();
            $active_rider_cods = $riderProfile->whereIn('passport_id', $active_rider_passport_ids);
            $ex_rider_cods = $riderProfile->whereIn('passport_id', $ex_rider_passport_ids);
            $no_rider_cods = $riderProfile->whereNotIn('passport_id',$ex_rider_passport_ids)->whereNotIn('passport_id',$active_rider_passport_ids)
            ->whereNotIn('platform_id', [1,32]);

        }else{
            $riderProfile = Careem::with('follow_ups')->whereHas('passport.rider_dc_detail', function($q) use($user_id) {
                $q->where('user_id','=', $user_id);
            })->select('*', DB::raw('sum(total_driver_other_cost) as total'))->groupBy('passport_id')->get();
            $active_rider_cods = $riderProfile->whereIn('passport_id', $active_rider_passport_ids);
            $ex_rider_cods = $riderProfile->whereIn('passport_id', $ex_rider_passport_ids);
            $no_rider_cods = $riderProfile->whereNotIn('passport_id',$ex_rider_passport_ids)->whereNotIn('passport_id',$active_rider_passport_ids)
            ->whereNotIn('platform_id', [1,32]);
        }

        $view = view('admin-panel.careem.ajax_balance_cod',compact('amt','riderProfile','cods','close_month','active_rider_cods','ex_rider_cods','no_rider_cods'))->render();
        return $view;
    }

    public function save_followup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passport_id' => 'required',
            'careem_upload_id' => 'required',
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
        $careem_follow_up = CareemFollowUp::create([
            'user_id' => auth()->id(),
            'passport_id' => $request->passport_id,
            'careem_upload_id' => $request->careem_upload_id,
            'feedback_id' => $request->feedback_id,
            'remarks' => $request->remarks,
        ]);

        if($careem_follow_up){
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
        $follow_up_calls = Careem::whereId($request->careem_upload_id)->with('follow_ups')->first()->follow_ups;
        $view = view('admin-panel.careem.follow_up_calls',compact('follow_up_calls'))->render();
        return response()->json(['html' => $view]);
    }

    public function uploaded_data(Request $request)
    {
        if($request->ajax()) {

            $data = Careem::where('start_date',$request->start_date)->get();

            return Datatables::of($data)
                ->addColumn('rider_name', function (Careem $cod) {
                    return isset($cod->passport->personal_info->full_name) ? $cod->passport->personal_info->full_name : 'N/A';
                })
                ->make(true);
        }

        $batchs = Careem::distinct()->get(['start_date','end_date']);
        return view('admin-panel.careem.uploaded_data',compact('batchs'));
    }

    public function get_details(Request $request)
    {
        if($request->ajax()) {

            $total_amount = Careem::select(DB::raw('sum(total_driver_other_cost) as total_amount'))->where('start_date', '=', $request->start_date)->first();
            $total_rider = Careem::where('start_date', '=', $request->start_date)->count();
            $origina_file = CareemFilePath::where('upload_start_date', '=', $request->start_date)->first();

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
        $first_date[] = Careem::oldest()->first()->start_date ?? Carbon::today()->format('Y-m-d');
        $first_date[] = CareemCod::oldest()->first()->date ?? Carbon::today()->format('Y-m-d');
        $first_date[] = CareemCloseMonth::oldest()->first()->date ?? Carbon::today()->format('Y-m-d');

        $start_dates[] = min($first_date);
        $end_dates = CareemCloseMonth::distinct('start_date')->pluck('date')->toArray();
        $start_dates = array_merge($start_dates, $end_dates);
        $date_range = [
            'start_dates' => $start_dates,
            'end_dates' => $end_dates
        ];
        return view('admin-panel.careem.dashboard',compact('date_range'));
    }
    public function ajax_careem_dashboard(Request $request)
    {
        if(request('date_range') == 'latest'){
            $start_date = CareemCloseMonth::latest('date')->first()->date ?? CodUpload::oldest('start_date')->first()->start_date ?? Carbon::today();
            $end_date = Carbon::today()->format('Y-m-d');
        }else{
            $date_range = request('date_range') ? explode('_', request('date_range')) : [];
            $start_date = $date_range[0];
            $end_date = $date_range[1];
        }
        $uploaded_cods = Careem::with(['passport.personal_info'])->whereBetween('start_date', [$start_date, $end_date])->get();
        $total_cod = $uploaded_cods->sum('total_driver_other_cost');
        $cods = CareemCod::with(['passport.check_platform_code_exist', 'passport.personal_info'])->whereBetween('date', [$start_date, $end_date])->get();
        $total_received_cod = $cods->sum('amount');
        $close_month = CareemCloseMonth::whereDate('date', request('date_range') == 'latest' ? $start_date : $end_date )->sum('close_month_amount');
        $total_remain = $total_cod - ($total_received_cod + (request('date_range') == 'latest' ? 0 : $close_month));
        $total_cash_received = $cods->where('type',0)->sum('amount');
        $total_bank_received = $cods->where('type',1)->sum('amount');
        $view = view('admin-panel.careem.shared_blades.ajax_careem_cod_report',
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
    public function careem_cash_cod_upload(Request $request)
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
            $message = [
                'message' => "Under construction delete operation",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
            // need to check the date range!!!
            // return $request->start_date;
            $careem_cod_exists = CareemCod::where('date', $request->start_date)->whereDataStoredFrom(2)->get();
            $performance_exist = $careem_cod_exists->first();
            if($performance_exist){
                // $file_exists = TalabatRiderPerformanceFilePath::whereDate('start_date', $request->start_date )->whereDate('end_date', $request->end_date)->first();
                $performance_exist->uploaded_file_path ? Storage::disk('s3')->delete($performance_exist->uploaded_file_path) : "";
                foreach ($careem_cod_exists as  $performance_exist) {
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
            $rows_to_be_updated = head(Excel::toArray(new \App\Imports\CareemCashCodImport(''), request()->file('select_file')));
            unset($rows_to_be_updated[0]);
            $missing_rider_ids = [];
            $date_exists = [];
            $amount_exists = [];
            $messages = [];
            // dd($rows_to_be_updated);
            foreach($rows_to_be_updated as $key => $row){
                $riderid_exists  = PlatformCode::whereIn('platform_id', [1, 32])->wherePlatformCode($row[0])->first();
                if($riderid_exists){
                    $careem_cash_cod_exists = CareemCod::whereType(1)
                        ->where('date', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d'))
                        ->wherePassportId($riderid_exists->passport_id)
                        ->whereAmount($row[2])
                        ->first();
                }
                if(!$riderid_exists OR $careem_cash_cod_exists !== null){
                    $missing_rider_ids[] = $row[0];
                    $date_exists[] =  \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d');
                    $amount_exists[] = $row[2];
                    $messages[] = !$riderid_exists ? "Rider Code Missing" :  ($careem_cash_cod_exists ? "Cash Already Exists" : "Have some problems in sheet");
                }
            }
            // dd($missing_rider_ids, $date_exists, $amount_exists, $messages);
            if(count($missing_rider_ids) > 0){
                // dd($date_exists);
                $message = [
                    'message' => "Careem Cash Cod Bulk Upload failed",
                    'alert-type' => 'error',
                    'missing_rider_ids' => implode(',' , $missing_rider_ids),
                    'date_exists' => implode(',' , $date_exists),
                    'amount_exists' => implode(',' , $amount_exists),
                    'messages' => implode(',' , $messages)
                ];
                return redirect()->back()->with($message);
            }else{

                if (!file_exists('../public/assets/upload/excel_file/careem_cash_cod')) {
                    mkdir('../public/assets/upload/excel_file/careem_cash_cod', 0777, true);
                }

                if(!empty($_FILES['select_file']['name'])) {
                    $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                    $file_path_image = 'assets/upload/careem_cash_cod/' . date("Y-m-d") . '/';
                    $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                    Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
                }
                Excel::import(new \App\Imports\CareemCashCodImport($fileName), request()->file('select_file'));
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
}
