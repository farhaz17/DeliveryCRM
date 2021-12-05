<?php

namespace App\Http\Controllers\BikeReplacement;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\BikeDetail;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BikeReplacementController extends Controller
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

        $bikes = BikeDetail::whereStatus(2)->get();

        return view('admin-panel.bike_replacement.create',compact('bikes'));
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
            'repalce_reason' => 'required',
            'new_bike_id' => 'required'

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




        //for checking the same bike number, if exist will not allow to allocate other rider

        // $bike_detail_already = BikeDetail::where('id','=',$request->input('new_bike_id'))->first();
        // $bike_detail_already = BikeDetail::where('id','=',$request->input('new_bike_id'))
        //                                     ->where('status','=','1')
        //                                     ->first();



        // if($bike_detail_already != null){
            // $exist_bike_detail = BikeDetail::where('plate_no','=',$bike_detail_already->plate_no)->where('status','=','1')->first();

            // if($exist_bike_detail != null){
            //     $message = [
            //         'message' => 'This Bike is already assigned to someone',
            //         'alert-type' => 'error'
            //     ];
            //     return redirect()->back()->with($message);
            // }

            // $message = [
            //     'message' => 'This Bike is already assigned to someone',
            //     'alert-type' => 'error'
            // ];
            // return redirect()->back()->with($message);
        // }

        $bike_detail_already_two = BikeDetail::where('id','=',$request->input('new_bike_id'))->where('status','=','1')->first();

        if($bike_detail_already_two != null){

                $message = [
                    'message' => 'This Bike is already assigned',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
        }


        $pass_id =  $request->passport_id_selected;

        $bike_replacement = BikeReplacement::where('passport_id','=',$pass_id)->where('status','=','1')->first();

        if($bike_replacement != null){

            $message = [
                'message' => 'This Rider have Replace Bike, So checkout that Replace Bike before Assign new Bike',
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
        // replacement_type=="2" means permanent Replacement
        if($request->replacement_type=="2"){



            $bike_replacement = new BikeReplacement();

            $pass_id =  $request->passport_id_selected;
            $passport = Passport::find($pass_id);
            $checkin_bike_id = ($passport->bike_checkin()->bike_plate_number->id) ? ($passport->bike_checkin()->bike_plate_number->id) : '';

            $bike_replacement->passport_id = $pass_id;
            $bike_replacement->assign_bike_id = ($passport->bike_checkin()->id) ? ($passport->bike_checkin()->id) : '';
            $bike_replacement->replace_bike_id = $checkin_bike_id;
            $bike_replacement->new_bike_id = $request->new_bike_id;
            $bike_replacement->type = $request->replacement_type;
            $bike_replacement->replace_reason = $request->repalce_reason;
            $bike_replacement->replace_remarks = $request->remarks;
            $bike_replacement->replace_checkin = $request->checkin;
            $bike_replacement->status = "0";
            $bike_replacement->save();

            $bike_detail = BikeDetail::find($checkin_bike_id);
            $bike_detail->status = $request->repalce_reason == 4 ? 2 : 0; // this is where I need to change
            $bike_detail->update();

            $already_assign = AssignBike::where('bike','=',$checkin_bike_id)->where('status','=','1')->first();
            $already_assign->status = $request->repalce_reason = 0;
            $already_assign->checkout = $request->checkin;
            // $already_assign->remarks = "replaced bike";
            $already_assign->update();

            $obj = new AssignBike();
            $obj->passport_id = $pass_id;
            $obj->bike = $request->new_bike_id;
            $obj->checkin = $request->checkin;
            $obj->remarks = $request->remarks;
            $obj->status = '1';
            $obj->save();

            $bike_detail = BikeDetail::find($request->new_bike_id);
            $bike_detail->status = "1";
            $bike_detail->update();
            $message = [
                'message' => "Permanent Bike Replacement Successfully",
                'alert-type' => 'success',
                'error' => 'df'
            ];
        }else{
            // replacement_type=="1" means Temporary Replacement
            $bike_replacement = new BikeReplacement();
            $pass_id =  $request->passport_id_selected;
            $passport = Passport::find($pass_id);
            $checkin_bike_id = ($passport->bike_checkin()->bike_plate_number->id) ? ($passport->bike_checkin()->bike_plate_number->id) : '';

            $bike_replacement->passport_id = $pass_id;
            $bike_replacement->assign_bike_id = ($passport->bike_checkin()->id) ? ($passport->bike_checkin()->id) : '';
            $bike_replacement->replace_bike_id = $checkin_bike_id;
            $bike_replacement->new_bike_id = $request->new_bike_id;
            $bike_replacement->type = $request->replacement_type;
            $bike_replacement->replace_reason = $request->repalce_reason;
            $bike_replacement->replace_remarks = $request->remarks;
            $bike_replacement->replace_checkin = $request->checkin;
            $bike_replacement->status = "1";
            $bike_replacement->no_of_days = $request->no_of_days;
            $bike_replacement->save();

            $bike_detail = BikeDetail::find($request->new_bike_id);
            $bike_detail->status = "1";
            $bike_detail->update();
            $message = [
                'message' => "Temporary Bike Replacement Successfully",
                'alert-type' => 'success',
                'error' => 'df'
            ];
        }
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
            'bike_replace_primary_id' => 'required',
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
            // make temporary bike to permanent
            $id = $request->bike_replace_primary_id;

            $bike_id_checkout = "";

            $bike_replacement = BikeReplacement::find($id);
            $bike_replacement->status = "0";
            $bike_replacement->replace_checkout = $request->checkout;
            $bike_replacement->replace_taken_remarks = $request->remarks_checkout;
            $bike_id_checkout = $bike_replacement->new_bike_id;
            $bike_replacement->update();

            $bike_detail_old = BikeDetail::find($bike_replacement->replace_bike_id);
            $bike_detail_old->status = "0";
            $bike_detail_old->update();

            $bike_detail = BikeDetail::find($bike_id_checkout);
            $bike_detail->status = "1";
            $bike_detail->update();



            $old_assign_bike = AssignBike::where('passport_id','=',$request->passport_id_selected_checkout)->where('status','=','1')->first();
            $old_assign_bike->checkout = $request->checkout;
            $old_assign_bike->remarks = $request->remarks_checkout;
            $old_assign_bike->status = '0';
            $old_assign_bike->update();

            $obj = new AssignBike();
            $obj->passport_id = $request->passport_id_selected_checkout;
            $obj->bike = $bike_id_checkout;
            $obj->checkin = $bike_replacement->replace_checkin;
            $obj->remarks = $request->remarks_checkout;
            $obj->status = '1';
            $obj->save();

            $message = [
                'message' => "Temporary Bike  taken and Previous bike has been given to rider ",
                'alert-type' => 'success',
                'error' => ''
            ];


        }else{
            $id = $request->bike_replace_primary_id;

            $bike_id_checkout = "";

            $bike_replacement = BikeReplacement::find($id);
            $bike_replacement->status = "0";
            $bike_replacement->replace_taken_remarks = $request->remarks_checkout;
            $bike_id_checkout = $bike_replacement->new_bike_id;
            $bike_replacement->replace_checkout =  $request->checkout;
            $bike_replacement->update();

            $bike_detail = BikeDetail::find($bike_id_checkout);
            $bike_detail->status = 2;
            $bike_detail->update();

            $message = [
                'message' => "Bike Replace Taken Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];


        }

            return redirect()->back()->with($message);


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


    public function autocomplete_checkin_bikes_for_replace(Request $request){

        $gamer_passsports = AssignBike::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


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

    public function  autocomplete_bikes_need_replace_checkout(Request $request){

        $checkin_passsports = BikeReplacement::where('type','=','1')->where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray();


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


}
