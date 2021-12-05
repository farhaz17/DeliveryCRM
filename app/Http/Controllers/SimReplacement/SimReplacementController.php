<?php

namespace App\Http\Controllers\SimReplacement;

use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\BikeDetail;
use App\Model\Passport\Passport;
use App\Model\SimReplacement\SimReplacement;
use App\Model\Telecome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SimCancel;
use Illuminate\Support\Facades\Validator;

class SimReplacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $sim_cancels_id = SimCancel::where('status','=','1')->pluck('sim_id')->toArray();

        $sims = Telecome::where(function ($query)  {
            $query->where('telecomes.status','!=','1')
            ->orwhere('telecomes.reserve_status','!=',1);
            })
            ->whereNotIn('telecomes.id',$sim_cancels_id)->get();
        // where('status','=','0')->whereNotIn('id',$sim_cancels)->get();

        return view('admin-panel.sim_replacement.create',compact('sims'));
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
            'passport_id_selected' => 'required',
            'replacement_type' => 'required',
            'checkin' => 'required',
            'new_sim_id' => 'required'
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


        $sim_detail_already = Telecome::where('id','=',$request->input('new_sim_id'))->first();

        if($sim_detail_already != null){
            $exist_sim_detail = Telecome::where('account_number','=',$sim_detail_already->account_number)->where('status','=','1')->first();

            if($exist_sim_detail != null){
                $message = [
                    'message' => 'This Sim is already assigned to someone',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

        }

        $reserve_sim_detail = Telecome::where('id','=',$request->input('new_sim_id'))->where('reserve_status','=','1')->first();

        if($reserve_sim_detail != null){
            $message = [
                'message' => 'This Sim is already reserved to someone',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }




        $sim_detail_already_two = Telecome::where('id','=',$request->input('new_sim_id'))->where('status','=','1')->first();

        if($sim_detail_already_two != null){

            if($exist_sim_detail != null){
                $message = [
                    'message' => 'This Sim is already assigned',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

            }
        }


        $pass_id =  $request->passport_id_selected;

        $sim_replacement = SimReplacement::where('passport_id','=',$pass_id)->where('status','=','1')->first();

        if($sim_replacement != null){

            $message = [
                'message' => 'This Rider have Replace Sim, So checkout that Replace Sim before Assign new Sim',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $assign_platform = AssignPlateform::where('passport_id','=',$pass_id)->where('status','=','1')->first();

        if($assign_platform == null){

            $message = [
                'message' => 'Platform is not assigned, please assign platform',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        if($request->replacement_type=="2"){

            $sim_replacement = new SimReplacement();

            $pass_id =  $request->passport_id_selected;
            $passport = Passport::find($pass_id);
            $checkin_sim_id = ($passport->sim_checkin()->telecome->id) ? ($passport->sim_checkin()->telecome->id) : '';

            $sim_replacement->passport_id = $pass_id;
            $sim_replacement->assign_sim_id = ($passport->sim_checkin()->id) ? ($passport->sim_checkin()->id) : '';;
            $sim_replacement->replace_sim_id = $checkin_sim_id;
            $sim_replacement->new_sim_id = $request->new_sim_id;
            $sim_replacement->type = $request->replacement_type;
            $sim_replacement->replace_remarks = $request->remarks;
            $sim_replacement->replace_checkin = $request->checkin;
            $sim_replacement->status = "0";
            $sim_replacement->save();

            $bike_detail = Telecome::find($checkin_sim_id);
            $bike_detail->status = "0";
            $bike_detail->update();

            $already_assign = AssignSim::where('sim','=',$checkin_sim_id)->where('status','=','1')->first();
            $already_assign->status = "0";
            $already_assign->checkout = $request->checkin;
            // $already_assign->remarks = "replaced sim";
            $already_assign->update();

            $obj = new AssignSim();
            $obj->passport_id = $pass_id;
            $obj->assigned_to = "1";
            $obj->sim = $request->new_sim_id;
            $obj->checkin = $request->checkin;
            $obj->remarks = $request->remarks;
            $obj->status = '1';
            $obj->save();

            $bike_detail = Telecome::find($request->new_sim_id);
            $bike_detail->status = "1";
            $bike_detail->update();



        }else{

            $validator = Validator::make($request->all(), [
                'repalce_reason' => 'required',
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

            $sim_replacement = new SimReplacement();

            $pass_id =  $request->passport_id_selected;
            $passport = Passport::find($pass_id);
            $checkin_sim_id = ($passport->sim_checkin()->telecome->id) ? ($passport->sim_checkin()->telecome->id) : '';

            $sim_replacement->passport_id = $pass_id;
            $sim_replacement->assign_sim_id = ($passport->sim_checkin()->id) ? ($passport->sim_checkin()->id) : '';;
            $sim_replacement->replace_sim_id = $checkin_sim_id;
            $sim_replacement->new_sim_id = $request->new_sim_id;
            $sim_replacement->type = $request->replacement_type;
            $sim_replacement->replace_reason = $request->repalce_reason;
            $sim_replacement->replace_remarks = $request->remarks;
            $sim_replacement->replace_checkin = $request->checkin;
            $sim_replacement->status = "1";
            $sim_replacement->save();

            $bike_detail = Telecome::find($request->new_sim_id);
            $bike_detail->status = "1";
            $bike_detail->update();

        }



        $message = [
            'message' => "Sim Replaced Successfully",
            'alert-type' => 'success',
            'error' => 'df'
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


        $validator = Validator::make($request->all(), [
            'passport_id_selected_checkout' => 'required',
            'checkout' => 'required',
            'sim_replace_primary_id' => 'required',
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

        if(isset($request->make_permanent)){
            $id = $request->sim_replace_primary_id;

            $sim_id_checkout = "";

            $sim_replacement = SimReplacement::find($id);
            $sim_replacement->status = "0";
            $sim_replacement->replace_taken_remarks = $request->remarks_checkout;
            $sim_replacement->replace_checkout =   $request->chekcout_date;
            $sim_id_checkout = $sim_replacement->new_sim_id;
            $sim_replacement->update();


            $sim_detail = Telecome::find($sim_replacement->replace_sim_id);
            $sim_detail->status = "0";
            $sim_detail->update();

            $bike_detail = Telecome::find($sim_id_checkout);
            $bike_detail->status = "1";
            $bike_detail->update();


            $old_sim_bike = AssignSim::where('passport_id','=',$request->passport_id_selected_checkout)->where('status','=','1')->first();
            $old_sim_bike->checkout = $request->checkout;
            $old_sim_bike->remarks = $request->remarks_checkout;
            $old_sim_bike->status = '0';
            $old_sim_bike->update();


            $obj = new AssignSim();
            $obj->passport_id = $request->passport_id_selected_checkout;
            $obj->sim = $sim_id_checkout;
            $obj->checkin = $sim_replacement->replace_checkin;
            $obj->remarks = $request->remarks_checkout;
            $obj->status = '1';
            $obj->save();

            $message = [
                'message' => "Sim Replaced as Permanent  Taken Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->back()->with($message);

        }else{

            $id = $request->sim_replace_primary_id;

            $sim_id_checkout = "";

            $sim_replacement = SimReplacement::find($id);
            $sim_replacement->status = "0";
            $sim_replacement->replace_taken_remarks = $request->remarks_checkout;
            $sim_replacement->replace_checkout =   $request->chekcout_date;
            $sim_id_checkout = $sim_replacement->new_sim_id;
            $sim_replacement->update();

            $sime_detail = Telecome::find($sim_id_checkout);
            $sime_detail->status = "0";
            $sime_detail->update();

            $message = [
                'message' => "Sim Replace Taken Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }




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

    public function autocomplete_checkin_sim_for_replace(Request $request){

        $gamer_passsports = AssignSim::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


        $checkin_passsports = AssignPlateform::where('status','=','1')->whereIn('passport_id',$gamer_passsports)->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn("passports.id",$checkin_passsports)
            ->get();

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

                                                $bike_ids_no = isset($bike_id->id) ? $bike_id->id : '0';
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_ids_no}%")
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
        $pass_array=array();
        foreach ($passport_data as $pass){
            $gamer = array(
                'name' => $pass->passport_no,
                'ppuid' => $pass->pp_uid,
                'full_name' => $pass->full_name,
                'zds_code' => $pass->zds_code,
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }

    public function autocomplete_sim_need_replace_checkout(Request $request){

        $checkin_passsports = SimReplacement::where('type','=','1')->where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray();

        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn("passports.id",$checkin_passsports)
            ->get();

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

                                                $bike_ids_no = isset($bike_id->id) ? $bike_id->id : '0';
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_ids_no}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->whereIn("passports.id",$checkin_passsports)
                                                    ->get();
                                                //platnumber response
                                                $pass_array = array();
                                                if($plat_data!=null){

                                                    foreach ($plat_data as $pass) {
                                                        $gamer = array(
                                                            'name' => isset($bike_id->plate_no) ? $bike_id->plate_no : '',
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
                'zds_code' => $pass->zds_code,
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }



}
