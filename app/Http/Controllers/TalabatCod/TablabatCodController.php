<?php

namespace App\Http\Controllers\TalabatCod;

use App\User;
use Calendar;
use Carbon\Carbon;
use App\Model\Cities;
use App\Model\Platform;
use App\Imports\CodUploads;
use App\Model\Manager_users;
use Illuminate\Http\Request;
use App\Model\Passport\Passport;
use App\Imports\TalabatCodImport;
use App\Model\CodUpload\CodUpload;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\TalabatCod\TalabatCod;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\CodUpload\ExcelFilePath;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use App\Imports\TalabatCodInternalImport;
use Illuminate\Support\Facades\Validator;
use App\Model\TalabatCod\TalabatCodFollowUp;
use App\Model\TalabatCod\TalabatCodInternal;
use App\Model\TalabatCod\TalabatCodDeduction;
use App\Model\TalabatFilePath\TalabatFilePath;
use App\Model\PlatformCode\PlatformCodeUpdateHistory;

class TablabatCodController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|DC_roll|Cod|talabat_cod', [
            'only' => [
                'rider_wise_cod_statement',
                'talabat_user_wise_riders_cod_analysis',
                'ajax_talabat_user_wise_riders_cod_analysis',
                'ajax_talabat_user_wise_riders_cod_buttons',
                'index',
                'store',
                'talabat_cod_internal',
                'talabat_cod_internal_store'
            ]]);

        $this->middleware('role_or_permission:Admin|rider_code_manager|DC_roll|manager_dc', [
            'only' => [
                    'manage_rider_codes',
                    'add_rider_id_to_talabat_dc',
                    'rider_code_update',
                    'get_dc_rider_with_codes',
                    'talabat_user_wise_riders_cod_follow_up',
                    'ajax_talabat_user_wise_riders_cod_follow_up',
                    'ajax_talabat_user_wise_riders_cod_follow_up_buttons'
                ]
        ]);
    }
    public function index()
    {
        return  view('admin-panel.talabat_cod.create');
    }
    public function rider_wise_cod_statement()
    {
       return view('admin-panel.talabat_cod.rider_wise_cod_statement');
    }
    public function get_rider_list_for_cod_statement(Request $request)
    {
        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->where('employee_category', 0)
            ->get();
        if(count($passport_data)=='0'){
            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->where('employee_category', 0)
                ->get();
        }
        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->where('employee_category', 0)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->where('employee_category', 0)
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->where('employee_category', 0)
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->where('employee_category', 0)
                            ->get();

                        if (count($mobile_data)=='0')
                        {
                            $platform_code =Passport::select('platform_codes.platform_code','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('platform_codes', 'platform_codes.passport_id', '=', 'passports.id')
                                ->where("platform_codes.platform_code","LIKE","%{$request->input('query')}%")
                                ->where('employee_category', 0)
                                ->get();
                        if (count($platform_code)=='0') {
                            $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                ->where('employee_category', 0)
                                ->get();
                            if (count($emirates_code) == '0') {
                                $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                    ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                    ->where('employee_category', 0)
                                    ->get();
                                if (count($drive_lin_data) == '0') {
                                    $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                        ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                        ->where('employee_category', 0)
                                        ->get();
                                    if( count($labour_card_data)=='0') {
                                        $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                            ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                            ->where('employee_category', 0)
                                            ->get();
                                        if (count($visa_number) == '0') {
                                            $platno = $request->input('query');
                                            $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                            if($bike_id != null){
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->where('employee_category', 0)
                                                    ->get();
                                                //platnumber response
                                                $pass_array = array();
                                                foreach ($plat_data as $pass) {
                                                    $gamer = array(
                                                        'name' => $bike_id->plate_no,
                                                        'zds_code' => $pass->zds_code,
                                                        'passport' => $pass->passport_no,
                                                        'ppuid' => $pass->pp_uid,
                                                        'full_name' => $pass->full_name,
                                                        'type' => '5',
                                                    );
                                                    $pass_array[] = $gamer;
                                                    return response()->json($pass_array);
                                                }
                                            }
                                        }
                                        //visa number search
                                        $pass_array = array();
                                        foreach ($visa_number as $pass) {
                                            $gamer = array(
                                                'name' => $pass->visa_number,
                                                'zds_code' => $pass->zds_code,
                                                'passport' => $pass->passport_no,
                                                'ppuid' => $pass->pp_uid,
                                                'full_name' => $pass->full_name,
                                                'type' => '10',
                                            );
                                            $pass_array[] = $gamer;
                                            return response()->json($pass_array);
                                        }
                                    }
                                    $pass_array = array();
                                    foreach ($labour_card_data as $pass) {
                                        $gamer = array(
                                            'name' => $pass->labour_card_no,
                                            'zds_code' => $pass->zds_code,
                                            'passport' => $pass->passport_no,
                                            'ppuid' => $pass->pp_uid,
                                            'full_name' => $pass->full_name,
                                            'type' => '9',
                                        );
                                        $pass_array[] = $gamer;
                                        return response()->json($pass_array);
                                    }
                                }
                                //platnumber response
                                $pass_array = array();
                                foreach ($drive_lin_data as $pass) {
                                    $gamer = array(
                                        'name' => (string)$pass->license_number,
                                        'zds_code' => $pass->zds_code,
                                        'passport' => $pass->passport_no,
                                        'ppuid' => $pass->pp_uid,
                                        'full_name' => $pass->full_name,
                                        'type' => '8',
                                    );
                                    $pass_array[] = $gamer;

                                    return response()->json($pass_array);
                                }
                            }
                                //emirates ID response
                                $pass_array = array();
                                foreach ($emirates_code as $pass) {
                                    $gamer = array(

                                        'name' => $pass->card_no,
                                        'zds_code' => $pass->zds_code,
                                        'passport' => $pass->passport_no,
                                        'ppuid' => $pass->pp_uid,
                                        'full_name' => $pass->full_name,
                                        'type' => '7',
                                    );
                                    $pass_array[] = $gamer;

                                }
                                return response()->json($pass_array);
                            }
                        //platform code  response
                            $pass_array=array();
                            foreach ($platform_code as $pass){
                                $gamer = array(
                                    'name' => $pass->platform_code,
                                    'zds_code' => $pass->zds_code,
                                    'passport' => $pass->passport_no,
                                    'ppuid' => $pass->pp_uid,
                                    'full_name' => $pass->full_name,
                                    'type'=>'6',
                                );
                                $pass_array[]= $gamer;
                            }

                            return response()->json($pass_array);
                        }
                        //mobile number response
                        $pass_array=array();
                        foreach ($mobile_data as $pass){
                            $gamer = array(
                                'name' => $pass->personal_mob,
                                'zds_code' => $pass->zds_code,
                                'passport' => $pass->passport_no,
                                'ppuid' => $pass->pp_uid,
                                'full_name' => $pass->full_name,
                                'type'=>'5',
                            );
                            $pass_array[]= $gamer;
                        }
                        return response()->json($pass_array);
                    }
                    //zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => $pass->zds_code,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'full_name' => $pass->full_name,
                            'type'=>'3',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);
                }
                //full name response
                $pass_array=array();
                foreach ($full_data as $pass){
                    $gamer = array(
                        'name' => $pass->full_name,
                        'passport' => $pass->passport_no,
                        'ppuid' => $pass->pp_uid,
                        'zds_code' => $pass->zds_code,
                        'type'=>'2',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);
            }
            //ppuid response
            $pass_array=array();
            foreach ($puid_data as $pass){
                $gamer = array(
                    'name' => $pass->pp_uid,
                    'passport' => $pass->passport_no,
                    'full_name' => $pass->full_name,
                    'zds_code' => $pass->zds_code,
                    'type'=>'1',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);
        }
        //passport number response
        $pass_array=array();

        foreach ($passport_data as $pass){
            $gamer = array(
                'name' => $pass->passport_no,
                'ppuid' => $pass->pp_uid,
                'full_name' => $pass->full_name,
                'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);
    }
    public function ajax_talabat_rider_statement_report(Request $request)
    {
        $searach = '%' . $request->keyword . '%';
        $passport_id = Passport::where('passport_no', 'like', $searach)->first()->id;
        $talabat_rider_cods = TalabatCod::with(['city_detail', 'zone_detail','passport'])->wherePassportId($passport_id)
        ->whereBetween('start_date', [$request->start_date, $request->end_date])
        ->latest()->get();
        $talabat_rider_cod_deductions = TalabatCodDeduction::wherePassportId($passport_id)
        ->whereBetween('start_date', [$request->start_date, $request->end_date])
        ->latest()->get();
        $rider_details = $talabat_rider_cods ? $talabat_rider_cods->first() : null;

        $view = view('admin-panel.talabat_cod.shared_blades.ajax_talabat_rider_statement_report', compact('talabat_rider_cods','talabat_rider_cod_deductions'))->render();
        $rider_details = view('admin-panel.talabat_cod.shared_blades.rider_details', compact('rider_details'))->render();

        return response()->json(['html' => $view,'rider_details' => $rider_details]);
    }
    public  function render_calender_talabat_cod(Request $request)
    {
        if($request->ajax()){
            $events = array();
            $data  = TalabatCod::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);
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

            $talabat_cod_deduction =  TalabatCodDeduction::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);
            if($talabat_cod_deduction->count()){
                foreach ($talabat_cod_deduction as $value) {
                    $events[] = Calendar::event(
                        'Deduction Sheet Uploaded',
                        true,
                        new \DateTime($value->start_date),
                        new \DateTime($value->end_date.' +1 day'),
                        null,
                        // Add color and link on event
                        [
                            'color' => '#003473',
                            'contentHeight' => 100,
                        ]
                    );
                }
            }

            $calendar = Calendar::addEvents($events);

            $html = view('admin-panel.talabat_cod.render_calender_ajax',compact('calendar'))->render();
            return $html;
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        if($request->upload_or_delete == "delete"){
            $start_date = $request->start_date;

            $cod_exits = TalabatCod::where('start_date', $start_date)->delete();

            if($cod_exits){
                $file_exists = TalabatFilePath::whereDate('upload_start_date', $request->start_date )->first();
                $file_exists->file_path ? Storage::disk('s3')->delete($file_exists->file_path) : "";
                $message = [
                    'message' => "Cod on " . $start_date . " deleted successfully.",
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
        }elseif($request->upload_or_delete == "upload"){
            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx',
                // 'start_date' => 'unique:cod_uploads,start_date',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
            $is_already = TalabatCod::whereDate('start_date', $request->start_date )->first();
            if($is_already){
                $message = [
                    'message' => 'For this Date Range is Already Uploaded',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
            $rows_to_be_updated = head(Excel::toArray(new \App\Imports\TalabatCodImport($request->start_date,$request->end_date), request()->file('select_file')));
            unset($rows_to_be_updated[0]);
            $missing_rider_names = [];
            $missing_rider_ids = [];
            $missing_cities = [];
            // dd($rows_to_be_updated );
            foreach($rows_to_be_updated as $key => $row){
                if(!empty($row[4])){
                    $riderid_exists  = PlatformCode::whereIn('platform_id',[15,34,41])->wherePlatformCode($row[4])->first();
                    if(!$riderid_exists){
                        $missing_rider_names[] = $row[3];
                        $missing_rider_ids[] = $row[4];
                        $missing_cities[] = $row[1];
                    }
                }
            }
            if(count($missing_rider_ids) > 0){
                $message = [
                    'message' => "Talabat Excel Upload failed",
                    'alert-type' => 'error',
                    'missing_rider_ids' => implode(',' , $missing_rider_ids),
                    'missing_cities' => implode(',' , $missing_cities),
                    'missing_rider_names' => implode(',' , $missing_rider_names)
                ];
                return redirect()->back()->with($message);
            }else{
                Excel::import(new TalabatCodImport($request->start_date,$request->start_date), request()->file('select_file'));
                if (!file_exists('../public/assets/upload/excel_file/talabat_cod')) {
                    mkdir('../public/assets/upload/excel_file/talabat_cod', 0777, true);
                }
                if(!empty($_FILES['select_file']['name'])) {
                    $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                    $file_path_image = 'assets/upload/talabat_cod/' . date("Y-m-d") . '/';
                    $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                    Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
                    $excel_path = new TalabatFilePath();
                    $excel_path->upload_start_date = $request->start_date;
                    $excel_path->file_path = $fileName;
                    $excel_path->save();
                }
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
    public function manage_rider_codes()
    {
        $manager_members = Manager_users::whereManagerUserId(auth()->id())
        ->whereStatus(1)
        ->pluck('member_user_id')
        ->toArray();
        $dcs = User::whereDesignationType(3)->get(['id', 'name'])
        ->filter(function($dc) use($manager_members){
            if(auth()->user()->hasRole(['manager_dc'])){
                return in_array($dc->id, $manager_members);
            }else{
                return true;
            }
            // return $dc->missing_id_count = 15; // testing count
        })
        ->filter(function($dc){
            return $dc->riders_count = $dc->dc_riders_count();
        });
        return view('admin-panel.talabat_cod.manage_rider_codes', compact('dcs','manager_members'));
    }
    public function get_dc_rider_with_codes(Request $request)
    {
        if($request->ajax()){
            $selected_dc = User::whereDesignationType(3)->whereId(request('dc_id'))->first();
            $all_dc_riders = AssignToDc::with('passport.personal_info','platform')
            ->where(function($assign_to_dc)use($selected_dc){
                $assign_to_dc->whereUserId($selected_dc !== null ? $selected_dc->id : auth()->id());
            })
            ->whereStatus(1)->get();
            $rider_id_available_passports = PlatformCode::whereIn('passport_id', $all_dc_riders
            ->pluck('rider_passport_id'))
            ->where(function($platform_code)use($selected_dc){
                $platform_code->whereIn('platform_id', $selected_dc !== null ? $selected_dc->user_platform_id : auth()->user()->user_platform_id);
            })
            ->pluck('passport_id');
            $id_missing_riders = $all_dc_riders->whereNotIn('rider_passport_id', $rider_id_available_passports);

            $view = view('admin-panel.talabat_cod.shared_blades.get_dc_rider_with_codes', compact('all_dc_riders','id_missing_riders'))->render();
            return response()->json(['html' => $view]);
        }else{
            return redirect()->route('manage_rider_codes');
        }
    }
    public function rider_code_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'platform_code' => 'required',
            'platform_code_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return response($message);
        }
        $plateformcode_exists = PlatformCode::wherePlatformCode($request->platform_code)->whereplatformId($request->platform_id)->first();
        if ($plateformcode_exists) {
            $message = [
                'message' =>'Rider Id can\'t be duplicate on same platform',
                'alert-type' => 'error'
            ];
            return response($message);
        }
        $plateformcode_to_be_updated = PlatformCode::find($request->platform_code_id);
        if($plateformcode_to_be_updated){
                try {
                    $plateformcodeHistory = new PlatformCodeUpdateHistory();
                    $plateformcodeHistory->platform_code_id = $plateformcode_to_be_updated->id;
                    $plateformcodeHistory->from = $plateformcode_to_be_updated->platform_code;
                    $plateformcodeHistory->to = $request->platform_code;
                    $plateformcodeHistory->user_id = auth()->id();
                    $plateformcodeHistory->remarks = "Platform Code history added";
                    $plateformcodeHistory->save();

                    $plateformcode_to_be_updated->platform_code = $request->platform_code;
                    $plateformcode_to_be_updated->update();
                        $message = [
                            'message' => "Platform Code updated form ". $plateformcodeHistory->from ." to ". $plateformcodeHistory->to . " and update history added",
                            'alert-type' => 'success',
                            'updated_row' => $plateformcode_to_be_updated
                        ];
                    return response($message);
                } catch (\Illuminate\Database\QueryException $e) {
                    $message = [
                        'message' => $e->getMessage(),
                        'alert-type' => 'error'
                    ];
                    return response($message);
                }
            }else{
                $message = [
                    'message' => "Platform Code Not Found",
                    'alert-type' => 'error'
                ];
                return response($message);
            }
    }
    public function add_rider_id_to_talabat_dc(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'passport_id.*' => 'required',
            'platform_code.*' => 'nullable',
            'platform_id.*' => 'required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => 'df'
            ];
            return redirect()->back()->with($message);
        }
        $rider_ids = [];
        $duplicate_riders_codes = [];
        foreach($request->passport_id as $key => $value){
            if(!empty($request->platform_code[$key])){
                $plateformcode_exists = PlatformCode::wherePlatformCode($request->platform_code[$key])
                ->wherePlatformId($request->platform_id[$key])
                ->first();
                if(!$plateformcode_exists){
                    $rider_ids[] = PlatformCode::create([
                        'passport_id' => $request->passport_id[$key],
                        'platform_id' => $request->platform_id[$key],
                        'platform_code' => $request->platform_code[$key]
                    ])-> platform_code;
                }else{
                    $duplicate_riders_codes[] = $plateformcode_exists->platform_code;
                }
            }
        }
        $m = count($rider_ids) > 0 ?  "Rider Id " . implode(', ', $rider_ids) . "  assinged Successfully " : "No Rider Id Assigned ";
        $m .= count($duplicate_riders_codes) > 0 ?  " Rider Id " . implode(', ', $duplicate_riders_codes) . " couldn't be added as the ids already exists in the same platform." : "";
        $message = [
            'message' => $m,
            'alert-type' => count($rider_ids) > 0 ?  'success' : 'error',
        ];
        return redirect()->back()->with($message);
    }
    public function ajax_talabat_user_wise_riders_cod_buttons(Request $request)
    {
        $cities = Cities::get(['id','city_code']);
        $dc_id = $request->dc_id ?? "all"; // dc id for dc wise filter by admin
        $adjustment_type =  $request->adjustment_type ?? 1;
        $internal_cod_adjustment_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['Admin']) && $dc_id !== 'all' && $dc_id !== 'no_dc') {
            $dc_rider_passport_ids = AssignToDc::whereUserId($dc_id)
            ->whereIn('platform_id', [15,34,41])
            ->pluck('rider_passport_id')->toArray();
        }elseif((auth()->user()->hasRole(['Admin']) && $dc_id == 'no_dc')) {
            $dc_rider_passport_ids = AssignToDc::whereIn('platform_id', [15,34,41])
            ->pluck('rider_passport_id')->toArray();
        }elseif(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = AssignToDc::whereUserId(auth()->id())
            ->whereIn('platform_id', [15,34,41])
            ->pluck('rider_passport_id')->toArray();
        }
        if($adjustment_type == 1){
            $internal_cod_adjustments = TalabatCodInternal::whereStartDate($internal_cod_adjustment_date)->get(['passport_id', 'cash', 'bank', 'uploaded_file_path'])
            ->filter(function($cod) use($dc_rider_passport_ids, $dc_id){
                if(auth()->user()->hasRole(['Admin'])) {
                    if($dc_id == "all") return  true;
                    elseif($dc_id == "no_dc") return !in_array($cod->passport_id, $dc_rider_passport_ids);
                    else return in_array($cod->passport_id, $dc_rider_passport_ids);
                }
                if(auth()->user()->hasRole(['DC_roll'])){
                    return in_array($cod->passport_id, $dc_rider_passport_ids);
                }else{
                    return true;
                }
            })
            ;
        }else{
            $internal_cod_adjustments = collect();
        }
        $cods = TalabatCod::whereStartDate($request->start_date)->latest()->get()
        ->filter(function($cod) use($dc_rider_passport_ids, $dc_id){
            if(auth()->user()->hasRole(['Admin'])) {
                if($dc_id == "all") return  true;
                elseif($dc_id == "no_dc") return !in_array($cod->passport_id, $dc_rider_passport_ids);
                else return in_array($cod->passport_id, $dc_rider_passport_ids);
            }
            if(auth()->user()->hasRole(['DC_roll'])){
                return in_array($cod->passport_id, $dc_rider_passport_ids);
            }else{
                return true;
            }
        })
        ->filter(function($cod)use($internal_cod_adjustments){
            $internal_cod_adjustments = $internal_cod_adjustments->where('passport_id', $cod->passport_id)->first();
            if($internal_cod_adjustments){
                return $cod->internal_cod_adjustments = $internal_cod_adjustments;
            }else{
                return true;
            }
        })
        ;
        if($request->type == "cod_collection_buttons"){
            $view = view('admin-panel.talabat_cod.shared_blades.talabat_cod_collection_buttons', compact('cities','cods','dc_id', 'internal_cod_adjustments','adjustment_type'))->render();
        }elseif($request->type == "cod_balance_buttons"){
            $view = view('admin-panel.talabat_cod.shared_blades.talabat_cod_balance_buttons', compact('cities','cods','dc_id', 'internal_cod_adjustments','adjustment_type'))->render();
        }
        $total_cod_collection = $cods->sum('current_day_cod');
        $total_cod_balance = $cods->sum('current_day_balance');
        $total_internal_cash_cod = $internal_cod_adjustments->sum('cash');
        $total_internal_bank_cod = $internal_cod_adjustments->sum('bank');
        $net_cod_balane = $total_cod_balance - ($total_internal_cash_cod + $total_internal_bank_cod);
        $net_cod_collection = $total_cod_collection - ($total_internal_cash_cod + $total_internal_bank_cod);
        $uploaded_file_path = Storage::temporaryUrl(TalabatFilePath::where('upload_start_date',  $cods->first()->start_date)->first()->file_path, now()->addMinutes(5)) ?? '#';
        return response()->json([
            'html' => $view,
            'cod_count' => $cods->count(),
            'selected_date_cods_sum' => number_format($net_cod_collection, 2),
            'selected_date_balance_sum' => number_format($net_cod_balane, 2),
            'uploaded_file_path' => $uploaded_file_path
        ]);
    }
    public function talabat_user_wise_riders_cod_analysis(Request $request)
    {
        $cities = Cities::get(['id','city_code']);
        $last_cod = TalabatCod::latest('start_date')->first();
        $last_cod->file_path = Storage::temporaryUrl(TalabatFilePath::where('upload_start_date', $last_cod->start_date)->first()->file_path, now()->addMinutes(5)) ?? '#';
        $starting_time = Carbon::parse($last_cod->start_date)->startOfDay();
        $ending_time = Carbon::parse($last_cod->start_date)->endOfDay();
        $dc_users = User::find(AssignToDc::whereIn('platform_id', [15,34,41])->get('user_id')->unique('user_id')); // at least one time he was Talabat DC

        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = AssignToDc::whereUserId(auth()->id())
            ->whereIn('platform_id', [15,34,41])
            ->latest()
            ->get()
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')
            ->toArray();
        }
        // dd($dc_rider_passport_ids);
        $filtered_cods = $last_cod ?
        TalabatCod::whereDate('start_date',$last_cod->start_date)->latest()->get()
        ->filter(function($cod) use($dc_rider_passport_ids){
            if(auth()->user()->hasRole(['Admin'])) return true;
            if(auth()->user()->hasRole(['DC_roll'])){
                return in_array($cod->passport_id, $dc_rider_passport_ids);
            }else{
                return true;
            }
        }) : [];
        $selected_date_cods_count = $filtered_cods->count();
        $selected_date_cods_sum = $filtered_cods->sum('current_day_cod');
        $selected_date_balance_sum = $filtered_cods->sum('current_day_balance');
        return view('admin-panel.talabat_cod.talabat_user_wise_riders_cod_analysis', compact('cities','last_cod','selected_date_cods_count','selected_date_cods_sum','selected_date_balance_sum','dc_users'));
    }
    public function ajax_talabat_user_wise_riders_cod_analysis(Request $request)
    {

        // Get all cod under selected date
        $all_dc_riders = AssignToDc::latest()->get();
        $dc_id = $request->dc_id ?? "all";
        $adjustment_type =  $request->adjustment_type ?? 1;
        $internal_cod_adjustment_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', auth()->id())
            ->whereIn('platform_id', [15,34,41])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }elseif(auth()->user()->hasRole(['Admin']) && $dc_id != 'all'){
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', $dc_id)
            ->whereIn('platform_id', [15,34,41])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }
        if($adjustment_type == 1){
            $internal_cod_adjustments = TalabatCodInternal::whereStartDate($internal_cod_adjustment_date)->get(['passport_id', 'cash', 'bank', 'uploaded_file_path'])
            ->filter(function($cod) use($dc_rider_passport_ids, $dc_id){
                if(auth()->user()->hasRole(['Admin'])) {
                    if($dc_id == "all") return  true;
                    elseif($dc_id == "no_dc") return !in_array($cod->passport_id, $dc_rider_passport_ids);
                    else return in_array($cod->passport_id, $dc_rider_passport_ids);
                }
                if(auth()->user()->hasRole(['DC_roll'])){
                    return in_array($cod->passport_id, $dc_rider_passport_ids);
                }else{
                    return true;
                }
            })
            ;
        }else{
            $internal_cod_adjustments = collect();
        }
        $last_cod_date = request('start_date') ?? TalabatCod::latest('start_date')->first()->start_date;
        $city = $request->city_id;
        $column = $request->searchBy;
        $starting_amount = (int)$request->starting_amount;
        $ending_amount = (int)$request->ending_amount;
        $cods = TalabatCod::with(['passport.personal_info', 'passport.sim.telecome', 'passport.zds_code', 'passport.assign_to_dcs.user_detail'])
        ->whereDate('start_date', $last_cod_date)
        ->where(function($talabat_cod)use($dc_rider_passport_ids){
            if(auth()->user()->hasRole(['DC_roll'])) $talabat_cod->whereIn('passport_id', $dc_rider_passport_ids);
        })
        ->where(function($talabat_cod)use($dc_id, $dc_rider_passport_ids){
            if(auth()->user()->hasRole(['Admin']) && $dc_id != "all"){
                $talabat_cod->whereIn('passport_id', $dc_rider_passport_ids);
            }
        })
        ->where(function($cod)use($starting_amount, $ending_amount, $column){
            if($starting_amount == 0){
                $cod->where($column, '<', $ending_amount);
            }elseif($starting_amount == 2500 OR $starting_amount == 300){
                $cod->where($column, '>=', $starting_amount);
            }else{
                $cod->whereBetween($column, [$starting_amount, $ending_amount]);
            }
        })
        ->whereCityId($city)
        ->get();
        foreach($cods as $cod){
            $cod->internal_cod_adjustment = $internal_cod_adjustments->where('passport_id', $cod->passport_id)->first();
        }
        // Get all active talabat dc riders' passport_ids
        $active_talabat_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [15,34,41])->where('status',1)
        ->pluck('rider_passport_id')->toArray();

        $active_talabat_rider_cods = $cods->whereIn('passport_id', $active_talabat_rider_passport_ids);

        // Get all ex talabat dc riders's passport_ids
        $ex_talabat_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [15,34,41])->where('status',0)
        ->whereNotIn('rider_passport_id', $active_talabat_rider_passport_ids)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();
        $ex_talabat_rider_cods = $cods->whereIn('passport_id', $ex_talabat_rider_passport_ids);

        // Get all no talabat dc riders' passport_ids
        $no_talabat_rider_passport_ids = $all_dc_riders
        ->where('status', 0)
        ->filter(function($all_dc_rider){
            return $all_dc_rider->platform_id != 15 || $all_dc_rider->platform_id != 34;
        })
        // ->where('platform_id','!=', 15)
        // ->where('platform_id','!=', 34)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();

        $no_talabat_rider_cods = $cods
        ->whereNotIn('passport_id',$ex_talabat_rider_passport_ids)
        ->whereNotIn('passport_id',$active_talabat_rider_passport_ids)
        ->whereNotIn('platform_id', [15,34,41]);

        $view = view('admin-panel.talabat_cod.shared_blades.ajax_talabat_cod_report',
        compact('cods','active_talabat_rider_cods','ex_talabat_rider_cods','no_talabat_rider_cods', 'adjustment_type'))->render();
        return response()->json(['html' => $view]);
    }
    public function ajax_talabat_user_wise_riders_cod_follow_up_buttons(Request $request)
    {
        $cities = Cities::get(['id','city_code']);
        $dc_id = $request->dc_id ?? "all"; // dc id for dc wise filter by admin
        $adjustment_type =  $request->adjustment_type ?? 1;
        $internal_cod_adjustment_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['Admin']) && $dc_id !== 'all' && $dc_id !== 'no_dc') {
            $dc_rider_passport_ids = AssignToDc::whereUserId($dc_id)
            ->whereIn('platform_id', [15,34,41])
            ->pluck('rider_passport_id')->toArray();
        }elseif((auth()->user()->hasRole(['Admin']) && $dc_id == 'no_dc')) {
            $dc_rider_passport_ids = AssignToDc::whereIn('platform_id', [15,34,41])
            ->pluck('rider_passport_id')->toArray();
        }elseif(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = AssignToDc::whereUserId(auth()->id())
            ->whereIn('platform_id', [15,34,41])
            ->pluck('rider_passport_id')->toArray();
        }
        if($adjustment_type == 1){
            $internal_cod_adjustments = TalabatCodInternal::whereStartDate($internal_cod_adjustment_date)->get(['passport_id', 'cash', 'bank', 'uploaded_file_path'])
            ->filter(function($cod) use($dc_rider_passport_ids, $dc_id){
                if(auth()->user()->hasRole(['Admin'])) {
                    if($dc_id == "all") return  true;
                    elseif($dc_id == "no_dc") return !in_array($cod->passport_id, $dc_rider_passport_ids);
                    else return in_array($cod->passport_id, $dc_rider_passport_ids);
                }
                if(auth()->user()->hasRole(['DC_roll'])){
                    return in_array($cod->passport_id, $dc_rider_passport_ids);
                }else{
                    return true;
                }
            })
            ;
        }else{
            $internal_cod_adjustments = collect();
        }
        $cods = TalabatCod::whereStartDate($request->start_date)->latest()->get()
        ->filter(function($cod) use($dc_rider_passport_ids, $dc_id){
            if(auth()->user()->hasRole(['Admin'])) {
                if($dc_id == "all") return  true;
                elseif($dc_id == "no_dc") return !in_array($cod->passport_id, $dc_rider_passport_ids);
                else return in_array($cod->passport_id, $dc_rider_passport_ids);
            }
            if(auth()->user()->hasRole(['DC_roll'])){
                return in_array($cod->passport_id, $dc_rider_passport_ids);
            }else{
                return true;
            }
        })
        ->filter(function($cod)use($internal_cod_adjustments){
            $internal_cod_adjustments = $internal_cod_adjustments->where('passport_id', $cod->passport_id)->first();
            if($internal_cod_adjustments){
                return $cod->internal_cod_adjustments = $internal_cod_adjustments;
            }else{
                return true;
            }
        })
        ;
        if($request->type == "cod_collection_buttons"){
            $view = view('admin-panel.talabat_cod.shared_blades.talabat_cod_collection_follow_up_buttons', compact('cities','cods','dc_id', 'internal_cod_adjustments','adjustment_type'))->render();
        }elseif($request->type == "cod_balance_buttons"){
            $view = view('admin-panel.talabat_cod.shared_blades.talabat_cod_balance_follow_up_buttons', compact('cities','cods','dc_id', 'internal_cod_adjustments','adjustment_type'))->render();
        }
        $total_cod_collection = $cods->sum('current_day_cod');
        $total_cod_balance = $cods->sum('current_day_balance');
        $total_internal_cash_cod = $internal_cod_adjustments->sum('cash');
        $total_internal_bank_cod = $internal_cod_adjustments->sum('bank');
        $net_cod_balane = $total_cod_balance - ($total_internal_cash_cod + $total_internal_bank_cod);
        $net_cod_collection = $total_cod_collection - ($total_internal_cash_cod + $total_internal_bank_cod);
        return response()->json([
            'html' => $view,
            'cod_count' => $cods->count(),
            'selected_date_cods_sum' => number_format($net_cod_collection, 2),
            'selected_date_balance_sum' => number_format($net_cod_balane, 2)
        ]);
    }
    public function talabat_user_wise_riders_cod_follow_up(Request $request)
    {
        $cities = Cities::get(['id','city_code']);
        $last_cod = TalabatCod::latest('start_date')->first();
        $starting_time = Carbon::parse($last_cod->start_date)->startOfDay();
        $ending_time = Carbon::parse($last_cod->start_date)->endOfDay();
        $dc_users = User::find(AssignToDc::whereIn('platform_id', [15,34,41])->get('user_id')->unique('user_id')); // at least one time he was Talabat DC

        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = AssignToDc::whereUserId(auth()->id())
            ->whereIn('platform_id', [15,34,41])
            ->latest()
            ->get()
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')
            ->toArray();
        }
        // dd($dc_rider_passport_ids);
        $filtered_cods = $last_cod ?
        TalabatCod::whereDate('start_date',$last_cod->start_date)->latest()->get()
        ->filter(function($cod) use($dc_rider_passport_ids){
            if(auth()->user()->hasRole(['Admin'])) return true;
            if(auth()->user()->hasRole(['DC_roll'])){
                return in_array($cod->passport_id, $dc_rider_passport_ids);
            }else{
                return true;
            }
        }) : [];
        $selected_date_cods_count = $filtered_cods->count();
        $selected_date_cods_sum = $filtered_cods->sum('current_day_cod');
        $selected_date_balance_sum = $filtered_cods->sum('current_day_balance');
        return view('admin-panel.talabat_cod.talabat_user_wise_riders_cod_follow_up', compact('cities','last_cod','selected_date_cods_count','selected_date_cods_sum','selected_date_balance_sum','dc_users'));
    }
    public function ajax_talabat_user_wise_riders_cod_follow_up(Request $request)
    {
        // Get all cod under selected date
        $all_dc_riders = AssignToDc::latest()->get();
        $dc_id = $request->dc_id ?? "all";
        $adjustment_type =  $request->adjustment_type ?? 1;
        $internal_cod_adjustment_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', auth()->id())
            ->whereIn('platform_id', [15,34,41])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }elseif(auth()->user()->hasRole(['Admin']) && $dc_id != 'all'){
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', $dc_id)
            ->whereIn('platform_id', [15,34,41])
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }
        if($adjustment_type == 1){
            $internal_cod_adjustments = TalabatCodInternal::whereStartDate($internal_cod_adjustment_date)->get(['passport_id', 'cash', 'bank', 'uploaded_file_path'])
            ->filter(function($cod) use($dc_rider_passport_ids, $dc_id){
                if(auth()->user()->hasRole(['Admin'])) {
                    if($dc_id == "all") return  true;
                    elseif($dc_id == "no_dc") return !in_array($cod->passport_id, $dc_rider_passport_ids);
                    else return in_array($cod->passport_id, $dc_rider_passport_ids);
                }
                if(auth()->user()->hasRole(['DC_roll'])){
                    return in_array($cod->passport_id, $dc_rider_passport_ids);
                }else{
                    return true;
                }
            })
            ;
        }else{
            $internal_cod_adjustments = collect();
        }
        $last_cod = TalabatCod::latest('start_date')->first();
        $city = $request->city_id;
        $column = $request->searchBy;
        $starting_amount = (int)$request->starting_amount;
        $ending_amount = (int)$request->ending_amount;
        $cods = TalabatCod::with(['passport', 'passport.personal_info', 'passport.sim.telecome', 'passport.zds_code', 'passport.assign_to_dcs.user_detail'])
        ->withCount('follow_ups')
        ->whereDate('start_date', $last_cod->start_date)
        ->where(function($talabat_cod)use($dc_rider_passport_ids){
            if(auth()->user()->hasRole(['DC_roll'])) $talabat_cod->whereIn('passport_id', $dc_rider_passport_ids);
        })
        ->where(function($talabat_cod)use($dc_id, $dc_rider_passport_ids){
            if(auth()->user()->hasRole(['Admin']) && $dc_id != "all"){
                $talabat_cod->whereIn('passport_id', $dc_rider_passport_ids);
            }
        })
        ->where(function($cod)use($starting_amount, $ending_amount, $column){
            if($starting_amount == 0){
                $cod->where($column, '<', $ending_amount);
            }elseif($starting_amount == 2500 OR $starting_amount == 300){
                $cod->where($column, '>=', $starting_amount);
            }else{
                $cod->whereBetween($column, [$starting_amount, $ending_amount]);
            }
        })
        ->whereCityId($city)
        ->get();
        foreach($cods as $cod){
            $cod->internal_cod_adjustment = $internal_cod_adjustments->where('passport_id', $cod->passport_id)->first();
        }
        // Get all active talabat dc riders' passport_ids
        $active_talabat_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [15,34,41])->where('status',1)
        ->pluck('rider_passport_id')->toArray();

        $active_talabat_rider_cods = $cods->whereIn('passport_id', $active_talabat_rider_passport_ids);

        // Get all ex talabat dc riders's passport_ids
        $ex_talabat_rider_passport_ids = $all_dc_riders
        ->whereIn('platform_id', [15,34,41])->where('status',0)
        ->whereNotIn('rider_passport_id', $active_talabat_rider_passport_ids)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();
        $ex_talabat_rider_cods = $cods->whereIn('passport_id', $ex_talabat_rider_passport_ids);

        // Get all no talabat dc riders' passport_ids
        $no_talabat_rider_passport_ids = $all_dc_riders
        ->where('status', 0)
        ->filter(function($all_dc_rider){
            return $all_dc_rider->platform_id != 15 || $all_dc_rider->platform_id != 34;
        })
        // ->where('platform_id','!=', 15)
        // ->where('platform_id','!=', 34)
        ->unique('rider_passport_id')
        ->pluck('rider_passport_id')->toArray();

        $no_talabat_rider_cods = $cods
        ->whereNotIn('passport_id',$ex_talabat_rider_passport_ids)
        ->whereNotIn('passport_id',$active_talabat_rider_passport_ids)
        ->whereNotIn('platform_id', [15,34,41]);

        $city_wise_button_id = $request->city_wise_button_id;
        $view = view('admin-panel.talabat_cod.shared_blades.ajax_talabat_cod_follow_up_report', compact('cods','active_talabat_rider_cods','ex_talabat_rider_cods','no_talabat_rider_cods', 'city_wise_button_id','adjustment_type'))->render();
        return response()->json(['html' => $view]);
    }

    public function talabat_cod_internal()
    {
        $talabat_cod_dates = TalabatCod::distinct('start_date')->latest()->groupBy('start_date')->get()->take(15);
        return  view('admin-panel.talabat_cod.create_internal', compact('talabat_cod_dates'));
    }
    public  function render_calender_talabat_internal_cod(Request $request)
    {
        if($request->ajax()){
            $events = array();
            $data  = TalabatCodInternal::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);
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

            $talabat_cod_deduction = collect(); // TalabatCodDeduction::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);
            if($talabat_cod_deduction->count()){
                foreach ($talabat_cod_deduction as $value) {
                    $events[] = Calendar::event(
                        'Deduction Sheet Uploaded',
                        true,
                        new \DateTime($value->start_date),
                        new \DateTime($value->end_date.' +1 day'),
                        null,
                        // Add color and link on event
                        [
                            'color' => '#003473',
                            'contentHeight' => 100,
                        ]
                    );
                }
            }

            $calendar = Calendar::addEvents($events);

            $html = view('admin-panel.talabat_cod.render_calender_ajax',compact('calendar'))->render();
            return $html;
        }
    }
    public function talabat_cod_internal_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        if($request->upload_or_delete == "delete"){
            $start_date = $request->start_date;
            $cod_exits = TalabatCodInternal::where('start_date', $start_date)->first();
            if($cod_exits){
                $uploaded_file_path = $cod_exits->uploaded_file_path;
                $uploaded_file_path ? Storage::disk('s3')->delete($uploaded_file_path) : "";
                $cod_exits = TalabatCodInternal::where('start_date', $start_date)->delete();
                $message = [
                    'message' => "Cod on " . $start_date . " deleted successfully.",
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
        }elseif($request->upload_or_delete == "upload"){
            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx',
                // 'start_date' => 'unique:cod_uploads,start_date',
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
            // dd($start_date, $end_date);
            $is_already = TalabatCodInternal::whereDate('start_date', $start_date )->first();

            if($is_already){
                $message = [
                    'message' => 'For this Date Range is Already Uploaded',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
            $rows_to_be_updated = head(Excel::toArray(new \App\Imports\TalabatCodInternalImport($start_date, $end_date, ''), request()->file('select_file')));
            unset($rows_to_be_updated[0]);
            $missing_courier_names = [];
            $missing_rider_ids = [];
            $missing_cities = [];
            // dd($rows_to_be_updated );
            foreach($rows_to_be_updated as $key => $row){
                if(!empty($row[2])){
                    $riderid_exists  = PlatformCode::whereIn('platform_id',[15,34,41])->wherePlatformCode($row[2])->first();
                    if(!$riderid_exists){
                        $missing_courier_names[] = $row[1];
                        $missing_rider_ids[] = $row[2];
                        $missing_cities[] = $row[0];
                    }
                }
            }
            if(count($missing_rider_ids) > 0){
                $message = [
                    'message' => "Talabat Internal COD Upload failed",
                    'alert-type' => 'error',
                    'missing_rider_ids' => implode(',' , $missing_rider_ids),
                    'missing_cities' => implode(',' , $missing_cities),
                    'missing_courier_names' => implode(',' , $missing_courier_names)
                ];
                return redirect()->back()->with($message);
            }else{
                if (!file_exists('../public/assets/upload/excel_file/talabat_cod_internal')) {
                    mkdir('../public/assets/upload/excel_file/talabat_cod_internal', 0777, true);
                }
                if(!empty($_FILES['select_file']['name'])) {
                    $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                    $file_path_image = 'assets/upload/talabat_cod_internal/' . date("Y-m-d") . '/';
                    $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                    Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
                }
                Excel::import(new TalabatCodInternalImport($start_date, $end_date, $fileName), request()->file('select_file'));
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
