<?php

namespace App\Http\Controllers\UserCodes;

use DataTables;
use App\Model\Platform;
use Illuminate\Http\Request;
use App\Model\Passport\Passport;
use App\Model\Agreement\Agreement;
use App\Model\ArBalance\ArBalance;
use App\Model\UserCodes\UserCodes;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Model\Passport\PassportAdditional;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Passport\passport_addtional_info;
use App\Model\PlatformCode\PlatformCodeUpdateHistory;

class UserCodesController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|usercodes|assignment-platform-assignment', ['only' => ['index','store','destroy','edit','update']]);
    }
    public function index(Request $request)
    {
        $passport = Passport::where('is_cancel','=','0')->get(['id','passport_no','pp_uid']);
        $plateform = Platform::Orderby('id','asc')->get();
        return view('admin-panel.user_codes.user_codes',compact('passport','plateform'));
    }
    public  function make_table_userodes(Request $request){
        $passport=Passport::where('is_cancel','=','0')->get();
        $plateform=Platform::Orderby('id','asc')->get();
        $distnict_passports  = UserCodes::get();
        $row_column = [];
        if ($request->ajax()) {
            if(!empty($request->keyword)){
                if($request->filter_by=="1"){
                    //passpornumber
                    $searach = '%'.$request->keyword.'%';
                    $passport = Passport::where('passport_no','like',$searach)->pluck('id')->toArray();
                    $distnict_passports  = UserCodes::whereIn('passport_id',$passport)->get();

                }elseif($request->filter_by=="2"){
                    //name
                    $searach = '%'.$request->keyword.'%';
                    $passport  = passport_addtional_info::where('full_name','like',$searach)->pluck('passport_id')->toArray();
                    $distnict_passports  = UserCodes::whereIn('passport_id',$passport)->get();
                }elseif($request->filter_by=="3"){
                    //ppuid
                    $searach = '%'.$request->keyword.'%';
                    $passport = Passport::where('pp_uid','like',$searach)->pluck('id')->toArray();
                    $distnict_passports  = UserCodes::whereIn('passport_id',$passport)->get();

                }elseif($request->filter_by=="4"){
                    //zds code
                    $searach = '%'.$request->keyword.'%';
                     $passport = UserCodes::where('zds_code','like',$searach)->pluck('passport_id')->toArray();
                    $distnict_passports  = UserCodes::whereIn('passport_id',$passport)->get();

                }elseif($request->filter_by=="5"){
                    //platform code
                    $searach = '%'.$request->keyword.'%';
                    $passport = PlatformCode::where('platform_code','like',$searach)->pluck('passport_id')->toArray();
                    $distnict_passports  = UserCodes::whereIn('passport_id',$passport)->get();

                }elseif($request->filter_by=="6"){
                    //empty remove filter
                    $distnict_passports = [];
                }
            }
            $dt = Datatables::of($distnict_passports);
                $dt->editColumn('status','<h4 class="badge badge-primary">Approved</h4>');
                $dt->addColumn('action',function(UserCodes $cod){
                $action_html = '<a class="text-success mr-2 edit_cls" id="'.$cod->passport->id.'" href="javascript:void(0)">
                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                            </a';
                    return $action_html;
                });
                $dt->editColumn('id',function(UserCodes $cod){
                    return $cod->passport->id;
                });
                $dt->addColumn('passport_number',function(UserCodes $cod){
                    return $cod->passport->passport_no;
                });
                $dt->addColumn('name',function(UserCodes $cod){
                    return $cod->passport->personal_info->full_name;
                });
                $dt->addColumn('ppuid',function(UserCodes $cod){
                    return $cod->passport->pp_uid;
                });
                $dt->addColumn('zds_code',function(UserCodes $cod){
                    $html = '<span id="'.$cod->passport->id.'-zds_code">'.$cod->zds_code.'</span>';
                    return $html;
                });
                $dt->addColumn('current_platform',function(UserCodes $cod){
                    $check_in_platform = $cod->passport->platform_assign->where('status','=','1')->first();
                    $p_name = "";
                    if(!empty($check_in_platform)){
                        $p_name =   $check_in_platform->plateformdetail->name;
                    }else{
                        $p_name = "N/A";
                    }
                    return $p_name;
                });
                $dt->addColumn('id',function(UserCodes $cod){
                    return $cod->id;
                });
            foreach($plateform as $plt){
                if (isset($res->passport->platform_codes)) {
                    $zamaoto = $res->passport->platform_codes->where('platform_id', '=', $plt->id)->first();
                    echo isset($zamaoto->platform_code) ? $zamaoto->platform_code : '';
                }
                $gamer = $plt;
                $dt->addColumn($plt->name,function(UserCodes $cod) use ($plt){
                    $passport_id =  $cod->passport->id."-".$plt->name;
                    $platform_code = "";
                    if(isset($cod->passport->platform_codes)){
                        $zamaoto = $cod->passport->platform_codes->where('platform_id','=',$plt->id)->first();
                        $platform_code =  isset($zamaoto->platform_code) ?  $zamaoto->platform_code : '';
                    }
                    $html = '<span id="'.$passport_id.'">'.$platform_code.'</span>';
                    return $html;
                });
                $row_column [] = $plt->name;
            }
            $row_column [] = 'action';
            $row_column [] = 'zds_code';
           $dt->rawColumns($row_column);
         return $dt->make(true);
        }
    }

    public function store(Request $request)
    {
        try {
            if($request->zds_code!=null) {
                $validator = Validator::make($request->all(), [
                    'zds_code' => 'unique:user_codes,zds_code,',
                    'passport_number' => 'required|unique:user_codes,passport_id,',
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
                $user_code = new UserCodes();
                $user_code->zds_code = $request->zds_code;
                $user_code->passport_id = $request->passport_number;
                $user_code->save();
                $message = [
                    'message' => 'Zds code Submitted Successfully',
                    'alert-type' => 'success',
                    'error' => '',
                ];
                return redirect()->back()->with($message);
            }
            $plate_form_id = $request->input('plateform');
            $passport_id = $request->input('passport_number');
            $zds_code = $request->input('zds_code');
            $validator = Validator::make($request->all(), [
                // 'plateform_code' => 'unique:platform_codes,platform_code,'
            ]);
            if($validator->fails()){
                $validate = $validator->errors();
                $message = [
                    'message' => 'Platform code already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

             $is_already_code = PlatformCode::wherePlatformId($request->plateform)
                ->wherePlatformCode($request->plateform_code)
                ->first();
            if($is_already_code == null){
                $obj = new PlatformCode();
                $obj->passport_id = $request->passport_number;
                $obj->platform_id =  $request->plateform;
                $obj->platform_code =  $request->plateform_code;
                $obj->save();

                $plateformcodeHistory = new PlatformCodeUpdateHistory();
                $plateformcodeHistory->platform_code_id = $obj->id;
                $plateformcodeHistory->from = $obj->platform_code; // same platform code as newly created
                $plateformcodeHistory->to = $obj->platform_code; // same platform code as newly created
                $plateformcodeHistory->user_id = auth()->id();
                $plateformcodeHistory->remarks = "Platform Code history added from registation form";
                $plateformcodeHistory->save();
                $message = [
                    'message' => "Platform Code ". $plateformcodeHistory->from . " added and update history added",
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($message);
            }else{
                $message = [
                    'message' => 'RiderID '. $request->plateform_code . ' already exist for this platform',
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);
            }

        }catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured SDFSDF',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }
    public function edit($id)
    {
        $passport_id =  DB::table('user_codes')->where('id', $id)->first();
        $pass_id=$passport_id->passport_id;
        $pass_edit=Passport::find($pass_id);
        $plate_edit=Platform::find($id);
        $passport=Passport::all();
        $plateform=Platform::all();
        $result=UserCodes::all();
        return view('admin-panel.user_codes.user_codes',compact('pass_edit','plate_edit','passport','plateform','result'));
    }

    public function update(Request $request, $id)
    {
        try{
            if (isset($request->platform_id2)){
                $platform_id=$request->platform_id2;
            }
            else{
                $platform_id=$request->platform_id;
            }
            $platform_type_data=Platform::where('id',$platform_id)->first();
            if(isset($request->type_usercode)){
                if($id!="0"){
                    $validator = Validator::make($request->all(), [
                        'platform_code' => 'required|numeric|unique:platform_codes,platform_code,'.$id
                    ]);
                }else{
                    $validator = Validator::make($request->all(), [
                        'platform_code' => 'required|numeric|unique:platform_codes,platform_code'
                    ]);
                }
                if ($validator->fails()) {

                    $validate = $validator->errors();
                    $message = array(
                        'message' => $validate->first(),
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    );
                    echo json_encode($message);
                    exit;
                }
                $usercodes = PlatformCode::find($id);
                $usercodes->platform_code = $request->platform_code;
                $usercodes->update();
                $message = array(
                    'message' => 'PlatForm Code Updated Successfully',
                    'alert-type' => 'success',
                    'error' => 'df'
                );
                echo json_encode($message);
                exit;
            }
            if($platform_type_data == null){
                $message = [
                    'message' => 'Platform is not found',
                    'alert-type' => 'error'
                ];
                echo json_encode($message);
                exit;
            }
            $platform_type= $platform_type_data->platform_category;
            $new_on_board=$request->new_on_board_val;
            if ($new_on_board=='1'){
                $message = [
                    'message' => 'Platform Code Not Required for New on board',
                    'alert-type' => 'success'
                ];
                echo json_encode($message);
                exit;
            }
            if ($platform_type=='2'){
                $message = [
                    'message' => 'Platform Code Not Required for Restaurant',
                    'alert-type' => 'success'
                ];
                echo json_encode($message);
                exit;
            }
            if($id!="0"){
                $validator = Validator::make($request->all(), [
                    'platform_code' => 'required|numeric|unique:platform_codes,platform_code,'.$id
                ]);
            }else{
                $validator = Validator::make($request->all(), [
                    'platform_code' => 'required|numeric|unique:platform_codes,platform_code'
                ]);
            }
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = array(
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                );
                echo json_encode($message);
                exit;
            }else{
                if($id!="0"){
                    $usercodes = PlatformCode::find($id);
                    $usercodes->platform_code = $request->platform_code;
                    $usercodes->update();

                    $str = $usercodes->plateform;
                    $platform_name = str_replace(' ', '', $str);
                }else{
                    $usercodes = new  PlatformCode();
                    $usercodes->platform_code = $request->platform_code;
                    $usercodes->passport_id = $request->passport_id;
                    $usercodes->platform_id = $platform_id;
                    $usercodes->save();
                    $platform_name = "gamer";
                }
                $message = array(
                    'message' => 'PlatForm Code Updated Successfully',
                    'alert-type' => 'success',
                    'passport_id' => $usercodes->passport_id,
                    'platform_name' => $platform_name,
                    'error' => 'df'
                );
                echo json_encode($message);
                exit;
            }
        }catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            $message = array(
                'message' => 'Error Occurred',
                'alert-type' => 'error',
            );
            echo json_encode($message);
            exit;
        }
    }
    public function update_zds_code(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'zds_code' => 'required|unique:user_codes,zds_code,'.$id
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = array(
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            );
            echo json_encode($message);
            exit;
        }else{
            $usercodes = UserCodes::find($id);
            $old_zds_code = $usercodes->zds_code;
            $usercodes->zds_code = $request->zds_code;
            $usercodes->update();
            $str = $usercodes->plateform;
            $platform_name = str_replace(' ', '', $str);
            $message = array(
                'message' => 'ZDS Code Updated Successfully',
                'alert-type' => 'success',
                'passport_id' => $usercodes->passport_id,
                'platform_name' => $platform_name,
                'error' => 'df'
            );
            echo json_encode($message);
            exit;
        }
    }

    public  function ajax_usercode_edit(Request $request){
        $passport_id = $request->passport_id;
        $zds_code = UserCodes::where('passport_id','=',$passport_id)->first();
        $user_codes = PlatformCode::with('platform_name')->where('passport_id','=',$passport_id)->get();
        $childe['data']  = [];
        if(isset($user_codes[0])){
            $gamer = array(
                'id' => isset($user_codes[0]->zds_code->id) ? $user_codes[0]->zds_code->id : '',
                'name' => "Zds Code",
                'platform_code' => isset($user_codes[0]->zds_code->zds_code) ? $user_codes[0]->zds_code->zds_code : 'not empty',
            );
            $childe['data'] [] = $gamer;
            foreach($user_codes as $user_code){
                $gamer = array(
                    'id' => $user_code->id,
                    'name' => $user_code->platform_name->name,
                    'platform_code' => $user_code->platform_code,
                    'passport_id' => $user_code->passport_id ?? null,
                    'platform_id' => $user_code->platform_id ?? null,

                );
                $childe['data'] [] = $gamer;
            }
        }else{
            if(!empty($zds_code)){
                $gamer = array(
                    'id' => isset($zds_code->id) ? $zds_code->id : '',
                    'name' => "Zds Code",
                    'platform_code' => isset($zds_code->zds_code) ? $zds_code->zds_code : '0',
                );
                $childe['data'] [] = $gamer;
            }
        }
        echo json_encode($childe);
        exit;
    }

    public function get_specific_rider_plaform_code(Request $request){
        if($request->ajax()){
            $platform = $request->platform;
            $passport_id = $request->passport_id;
            $codes = PlatformCode::where('passport_id','=',$passport_id)->where('platform_id','=',$platform)->first();
            $agreement  = Agreement::where('passport_id','=',$passport_id)->first();
            $is_agreement = "";
            if($agreement !=null){
                 $is_agreement = "yes";
            }else{
                 $link = url('agreement/create?id='.$passport_id);
                 $is_agreement = $link;
             }
            $driving_licence  = DrivingLicense::where('passport_id','=',$passport_id)->first();
            $is_driving = "";
            if($driving_licence !=null){
                $is_driving = "yes";
            }else{
                $link = url('driving_license?id='.$passport_id);
                $is_driving = $link;
            }
            $plaform_code_now = "";
            $plaform_code_id = "";
            if($codes!=null){
                $plaform_code_now = $codes->platform_code;
                $plaform_code_id = $codes->id;
            }
            $array_to_send = array(
                'platform_code' => $plaform_code_now,
                'id' => $plaform_code_id,
                'is_driving' => $is_driving,
                'is_agreement' => $is_agreement,
            );
            echo  json_encode($array_to_send);
            exit;
        }
    }
    public function add_new_platform_code(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passport_id' => 'required',
            'platform_id' => 'required'
        ], $messages = [
            'passport_id.required' => 'Passport id not found',
            'platform_id.required' => 'Platform id not found'
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
        $already_exists = PlatformCode::with('platform_name')
            ->wherePassportId($request->passport_id)
            ->wherePlatformCode($request->platform_code)
            ->wherePlatformId($request->platform_id)
            ->first();
        if(!$already_exists){
            $new_platform_code = PlatformCode::create([
                'platform_id' => $request->platform_id,
                'passport_id' => $request->passport_id,
                'platform_code' => $request->platform_code,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Platform Code created',
                'alert-type' => 'success',
                'PlatformCode' => $new_platform_code,
                'platform_name' => Platform::find($new_platform_code->platform_id)->name
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Platform code already exists on the platform',
                'alert-type' => 'error',
            ]);
        }
    }
}
