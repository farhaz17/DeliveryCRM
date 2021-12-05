<?php

namespace App\Http\Controllers\Assign;

use App\Model\Agreement\Agreement;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Assign\OfficeSimAssign;
use App\Model\Assign\SimAssignType;
use App\Model\AssingToDc\AssignToDc;
use App\Model\BikeDetail;
use App\Model\Cities;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\Cods\CloseMonth;
use App\Model\Cods\Cods;
use App\Model\CodUpload\CodUpload;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Master\CategoryAssign;
use App\Model\Master\SubCategory;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\OnBoardStatus\OnBoardStatusType;
use App\Model\OwnSimBikeHistory;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Platform;
use App\Model\PlatformCode\PlatformCode;
use App\Model\Telecome;
use App\Model\UserCodes\UserCodes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DataTables;

class AssginPlateformController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|assignment-platform-assignment|assignment-platform-assignment-view', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|assignment-platform-assignment', ['only' => ['store','destroy','edit','update']]);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $assign_plateform = [];
        if($request->ajax()){
//             $assign_plateform=AssignPlateform::all();
            if($request->filter_by=="1"){
                //passport number
                $searach = '%'.$request->keyword.'%';
                $passport = Passport::where('passport_no','like',$searach)->pluck('id')->toArray();
                $assign_plateform= AssignPlateform::whereIn('passport_id',$passport)->get();

            }elseif($request->filter_by=="2"){
                //name
                $searach = '%'.$request->keyword.'%';
                $passport  = passport_addtional_info::where('full_name','like',$searach)->pluck('passport_id')->toArray();
                $assign_plateform= AssignPlateform::whereIn('passport_id',$passport)->get();

            }elseif($request->filter_by=="3"){
                //zds code
                $searach = '%'.$request->keyword.'%';
                $passport = UserCodes::where('zds_code','like',$searach)->pluck('passport_id')->toArray();
                $assign_plateform= AssignPlateform::whereIn('passport_id',$passport)->get();

            }elseif($request->filter_by=="4"){
                //platform

                $searach = '%'.$request->keyword.'%';
                $platform_ids = Platform::where('name','like',$searach)->pluck('id')->toArray();
                $passsport = AssignPlateform::whereIn('plateform',$platform_ids)->pluck('passport_id')->toArray();
                $assign_plateform= AssignPlateform::whereIn('passport_id',$passsport)->get();
            }else{
                // empty the table remove filter
                $assign_plateform = [];
            }


            $dt = Datatables::of($assign_plateform);


            $dt->addColumn('passport_number', function (AssignPlateform $plt) {
                return $plt->passport->passport_no;
            });
            $dt->addColumn('passport_number', function (AssignPlateform $plt) {
                return $plt->passport->passport_no;
            });
            $dt->addColumn('zds_code', function (AssignPlateform $plt) {
                return isset($plt->passport->zds_code->zds_code) ? $plt->passport->zds_code->zds_code : "";
            });
            $dt->addColumn('city', function (AssignPlateform $plt) {
                return isset($plt->city->name) ? $plt->city->name : "";
            });

            $dt->addColumn('name', function (AssignPlateform $plt) {
                return $plt->passport->personal_info->full_name;
            });

            $dt->addColumn('platform', function (AssignPlateform $plt) {
                return isset($plt->plateformdetail->name) ?  $plt->plateformdetail->name : '';
            });



                $dt->addColumn('action', function (AssignPlateform $plt) {

                    if($plt->status==0){
                        $ab = '<span class="badge badge-success">Checked Out</span>';
                    }else{
                        $ab = '<a class="text-success mr-2 plateform_btn_cls"  id="'.$plt->id.' " href="javascript:void(0)">
                                                                <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>
                                                            </a>';
                    }


                    return $ab;
                });


            $dt->rawColumns(['action']);
            return $dt->make(true);
        }


        $plateform=Platform::all();
        $passport=Passport::all();
        $cities=Cities::all();

        $sub_cat_work = SubCategory::where('sub_category','=',1)->get();



        return view('admin-panel.assigning.platform_assign',compact('passport','plateform','assign_plateform','sub_cat_work','cities'));
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
        //
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

        $passport_id = $request->passport_id_selected_checkout;

//        $agreement  = Agreement::where('passport_id','=',$passport_id)->first();
//
//        if($agreement==null){
//            $message = [
//                'message' => "Agreement is not created, please create agreement",
//                'alert-type' => 'error',
//                'error' => 'df'
//            ];
//            return redirect()->back()->with($message);
//        }

        $driving_licence  = DrivingLicense::where('passport_id','=',$passport_id)->first();

        if($driving_licence==null) {

            $message = [
                'message' => "Driving license is not created, please create driving license",
                'alert-type' => 'error',
                'error' => 'df'
            ];
            return redirect()->back()->with($message);

        }


        $assign_obj_ab = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        if($assign_obj_ab==null){

            $message = [
                'message' => 'Platform is not checkin, you can not checkout',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);

        }

        $is_platform_code = PlatformCode::where('passport_id','=',$passport_id)->where('platform_id','=',$assign_obj_ab->plateform)->first();

        if($is_platform_code==null){

            $message = [
                'message' => "platform code is not exist please enter the platform code",
                'alert-type' => 'error',
                'error' => 'df'
            ];
            return redirect()->back()->with($message);

        }


        $id= $assign_obj_ab->id;

        $obj = AssignPlateform::find($id);

        $total_pending_amount = 0;
        $total_paid_amount= 0;

        $check_in_platform = $obj->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();
        $rider_id = $obj->passport->platform_codes->where('platform_id','=',$check_in_platform)->pluck(['platform_code'])->first();

        $user_passport_id = $obj->passport->id;


        $amount =  CodUpload::where('rider_id','=',$rider_id)->where('platform_id','=',$check_in_platform)->selectRaw('sum(amount) as total')->first();
        $paid_amount =  Cods::where('passport_id',$user_passport_id)->where('platform_id','=',$check_in_platform)->where('status','1')->selectRaw('sum(amount) as total')->first();
        $adj_req_t =CodAdjustRequest::where('passport_id','=',$user_passport_id)->where('status','=','2')->selectRaw('sum(amount) as total')->first();

        $salary_array = CloseMonth::where('passport_id','=',$obj->passport->id)->selectRaw('sum(close_month_amount) as total')->first();

        if($adj_req_t != null){
            $total_paid_amount = $total_paid_amount+$adj_req_t->total;
        }

            if(!empty($amount)){
                $total_pending_amount = $amount->total;
            }
            if(!empty($paid_amount)){
                $total_paid_amount = $paid_amount->total;
            }

        if(!empty($salary_array)){
            $total_paid_amount = $total_paid_amount+$salary_array->total;
        }


        $previous_balance =  isset($obj->passport->previous_balance->amount) ? $obj->passport->previous_balance->amount : '0';

        $now_amount = $total_pending_amount+$previous_balance;

        $remain_amount =  $now_amount-$total_paid_amount;

//        echo $passport_id;
//        dd("we are out if =".$remain_amount);
            if($remain_amount <= 0){

//                dd("we are in if =".$remain_amount);

                $obj->checkout=$request->input('checkout');
                $obj->remarks=$request->input('remarks');
                $obj->status='0';
                $obj->save();

                OwnSimBikeHistory::where('passport_id','=',$passport_id)
                    ->where('status','=','1')
                    ->update(array('status' => "0", 'checkout'=>$request->input('checkout') ));

                AssignToDc::where('rider_passport_id','=',$passport_id)
                            ->where('status','=','1')
                            ->update(array('status' => "0"));


//                 $onboard_type = new OnBoardStatusType();
//                 $onboard_type->passport_id = $obj->passport->id;
//                 $onboard_type->checkout_type = $request->checkout_type;
//                 $onboard_type->expected_date = $request->expected_date;
//                 if(!empty($request->platform)){
//                     $onboard_type->platform_id = json_encode($request->platform);
//                 }
//                 $onboard_type->save();

//                 if($request->checkout_type=="1" || $request->checkout_type=="3" || $request->checkout_type=="4"){
//
//                     $on_board = OnBoardStatus::where('passport_id','=',$obj->passport->id)->first();
//                     if($on_board != null){
//                         $on_board->on_board = '1';
//                         $on_board->exist_user = '1';
//                         $on_board->assign_platform = '1';
//                         $on_board->interview_status = '1';
//                         $on_board->update();
//                     }else{
//                         $on_board = new OnBoardStatus();
//                         $on_board->passport_id = $obj->passport->id;
//                         $on_board->assign_platform = '1';
//                         $on_board->exist_user = '1';
//                         $on_board->on_board = '1';
//                         $on_board->interview_status = '1';
//                         $on_board->save();
//                     }
//                 }



          CategoryAssign::where('passport_id','=',$passport_id)
            ->where('status','=','1')
            ->orderby('id','desc')
            ->update(array('status' => "0"));





                $message = [
                    'message' => 'Platform Checkout Added Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);

            }else{

                $message = [
                    'message' => 'COD is still remain',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

            }


    }

    public function autocomplete_from_checkin_platform(Request $request)
    {

//        $checkin_passsports = AssignPlateform::where('status','=','0')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->where('cancel_status','=','0')
            ->get();

        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->where('cancel_status','=','0')
                ->get();

        }

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->where('passports.cancel_status','=','0')
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->where('passports.cancel_status','=','0')
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->where('passports.cancel_status','=','0')
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->where('passports.cancel_status','=','0')
                            ->get();

                        if (count($mobile_data)=='0')
                        {
//                            $drive_lin_data =Passport::select('driving_licenses.license_number','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
//                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
//                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
//                                ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                                ->where("driving_licenses.license_number","LIKE","%{$request->input('query')}%")
//                                ->get();
//                            $platform=$request->input('query');
//                            $plaform_code_id=PlatformCode::where('platform_code',$platform)->first();

                            $platform_code =Passport::select('platform_codes.platform_code','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('platform_codes', 'platform_codes.passport_id', '=', 'passports.id')
                                ->where("platform_codes.platform_code","LIKE","%{$request->input('query')}%")
                                ->where('passports.cancel_status','=','0')
                                ->get();
                            if (count($platform_code)=='0') {
                                $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->where('passports.cancel_status','=','0')
                                    ->get();
                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->where('passports.cancel_status','=','0')
                                        ->get();
                                    if (count($drive_lin_data) == '0') {
                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->where('passports.cancel_status','=','0')
                                            ->get();
                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->where('passports.cancel_status','=','0')
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
                                                        ->where('passports.cancel_status','=','0')
                                                        ->get();
                                                }else{
                                                    $plat_data = array();
                                                }

                                                //platnumber response
                                                $pass_array = array();
                                                foreach ($plat_data as $pass) {
                                                    $gamer = array(
                                                        'name' => $bike_id->plate_no,
                                                        'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
                                                        'passport' => $pass->passport_no,
                                                        'ppuid' => $pass->pp_uid,
                                                        'full_name' => $pass->full_name,
                                                        'type' => '5',
                                                    );
                                                    $pass_array[] = $gamer;
                                                    return response()->json($pass_array);
                                                }
                                            }

                                            //visa number search
                                            $pass_array = array();
                                            foreach ($visa_number as $pass) {
                                                $gamer = array(
                                                    'name' => $pass->visa_number,
                                                    'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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
                                                'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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
                                            'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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
                                        'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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
                                    'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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
                                'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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
                        'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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
                    'zds_code' => isset($pass->zds_code) ? $pass->zds_code : 'N/A' ,
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


    public function autocomplete_from_checkout_platform(Request $request)
    {



       $passports_gamer = Passport::select('passport_id')->groupBy('passport_id')->get()->toArray();

        $checkout_passsports = AssignPlateform::where('status','=','0')->whereNotIn('passport_id',$passports_gamer)->select('passport_id')->groupBy('passport_id')->get()->toArray();

        $checkin_passsports = array_merge($passports_gamer,$checkout_passsports);


        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn("passports.id",$checkin_passsports)
            ->get();

        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->whereIn("passports.id",$checkin_passsports)
                ->get();

        }


        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereIn("passports.id",$checkin_passsports)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->whereIn("passports.id",$checkin_passsports)
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->whereIn("passports.id",$checkin_passsports)
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->whereIn("passports.id",$checkin_passsports)
                            ->get();

                        if (count($mobile_data)=='0')
                        {
//                            $drive_lin_data =Passport::select('driving_licenses.license_number','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
//                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
//                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
//                                ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                                ->where("driving_licenses.license_number","LIKE","%{$request->input('query')}%")
//                                ->get();
//                            $platform=$request->input('query');
//                            $plaform_code_id=PlatformCode::where('platform_code',$platform)->first();

                            $platform_code =Passport::select('platform_codes.platform_code','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('platform_codes', 'platform_codes.passport_id', '=', 'passports.id')
                                ->where("platform_codes.platform_code","LIKE","%{$request->input('query')}%")
                                ->whereIn("passports.id",$checkin_passsports)
                                ->get();
                            if (count($platform_code)=='0') {
                                $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->whereIn("passports.id",$checkin_passsports)
                                    ->get();
                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->whereIn("passports.id",$checkin_passsports)
                                        ->get();
                                    if (count($drive_lin_data) == '0') {
                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->whereIn("passports.id",$checkin_passsports)
                                            ->get();
                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->whereIn("passports.id",$checkin_passsports)
                                                ->get();
                                            if (count($visa_number) == '0') {
                                                $platno = $request->input('query');
                                                $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->whereIn("passports.id",$checkin_passsports)
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
}
