<?php

namespace App\Http\Controllers\VehicleReport;

use App\Model\BikeCencel;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use App\Model\AccidentRiderRequest;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\VehicleAccident\VehicleAccident;

class VehicleAccidentController extends Controller
{
    public function accident_request()
    {
        return view('admin-panel.vehicle_accident.accident_request');
    }

    function location_autocomplete(Request $request)
    {
        $data = $request->all();
        $query = $data['query'];
        $filter_data = VehicleAccident::select('location')->where('location', 'LIKE', '%'.$query.'%')->distinct()->get();
        $data = array();
        foreach ($filter_data as $hsl)
        {
            $data[] = $hsl->location;
        }
        return response()->json($data);
    }

    public function get_rider_details(Request $request)
    {
        $searach = '%'.$request->keyword.'%';
        $passport = Passport::where('passport_no', 'like', $searach)->first();

        $name = "";
        if(!empty($passport)){
            $name = $passport->personal_info->full_name;
        }

        $plate = "";
        if(!empty($passport->id)){
            $assign_bike = AssignBike::where('passport_id', $passport->id)->where('status', '=', '1')->first();
            if(isset($assign_bike)){
                $plate = BikeDetail::with('get_current_bike.plateforms.plateformdetail')->where('id',$assign_bike->bike)->first();
            }
        }

        $array = array(
            'name' =>  $name,
            'id' =>  $passport->id,
            'plate' =>  isset($plate->plate_no) ? $plate->plate_no: '',
        );
        return $array;
    }

    public function save_vehicle_accident_request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rider_passport_id' => 'required',
            'police_report' => 'required',
            'accident_date' => 'required',
            'location' => 'required',
            'rider_condition' => 'required',
            'checkout_type' => 'required_if:rider_condition,1',
        ]);
        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }

        $already = VehicleAccident::where('rider_passport_id','=',$request->rider_passport_id)->whereNotIn('status',[3,9])->first();

        if($already != null){
            $message = [
                'message' => "Request already in pending",
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }

        $already_request = AccidentRiderRequest::where('rider_passport_id','=',$request->rider_passport_id)->where('status','=','0')->first();

        if($already_request != null){
            $message = [
                'message' => "Request already in pending",
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }

        $assign_platform = AssignPlateform::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

        $bike_id = null;
        $sim_id = null;

        if($assign_platform != null){
            $bike = AssignBike::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();
            $sim = AssignSim::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

           if($bike == null || $bike == null ){
               $message = [
                   'message' => "Sim or Bike is not Assigned",
                   'alert-type' => 'error',
               ];
               return redirect()->back()->with($message);
           }

           $bike_id = $bike->bike;
           $sim_id = $sim->sim;

        }else{
           $message = [
               'message' => "User not Checkin.!",
               'alert-type' => 'error',
           ];
           return redirect()->back()->with($message);
        }

        $accident_rider = new AccidentRiderRequest();
        $accident_rider->rider_passport_id = $request->rider_passport_id;
        $accident_rider->checkout_date = $request->accident_date;
        if($request->rider_condition == 2 || $request->rider_condition == 3){
            $type = 1;
        }elseif($request->rider_condition == 1){
            $type = $request->checkout_type;
        }
        $accident_rider->request_type = $type;
        $accident_rider->checkout_type = "5";
        $accident_rider->data_from = 1;
        $accident_rider->remarks = $request->remark;
        $accident_rider->bike_id = $bike_id;
        $accident_rider->sim_id = $sim_id;
        $accident_rider->dc_id = Auth::user()->id;
        $accident_rider->save();

        if($request->hasfile('attachment'))
        {
            foreach($request->file('attachment') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/acciden_police_report/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }

        $obj = new VehicleAccident();
        $obj->rider_passport_id = $request->rider_passport_id;
        $obj->bike_id = $bike_id;
        $obj->accident_date = $request->accident_date;
        $obj->location = $request->location;
        $obj->rider_condition = $request->rider_condition;
        if($request->rider_condition == 2 || $request->rider_condition == 3){
            $type = 1;
        }elseif($request->rider_condition == 1){
            $type = $request->checkout_type;
        }
        $obj->checkout_type = $type;
        $obj->police_report = $request->police_report;
        $obj->remark = $request->remark;
        $obj->user_id = Auth::user()->id;
        $obj->status = 1;
        if(isset($data)){
            $obj->police_report_attachment = json_encode($data);
        }
        $obj->save();

        $message = [
            'message' => "request has been sent successfully",
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }

    public function accident_autocomplete(Request $request)
    {
        $user = Auth::user();
        if($user->hasRole('DC_roll')) {

            $dc_riders_array = AssignToDc::where('status','=','1')->where('user_id','=',$user->id)->pluck('rider_passport_id')->toArray();
            $checkin_passsports = AssignPlateform::where('status','=','1')->whereIn('passport_id',$dc_riders_array)->select('passport_id')->groupBy('passport_id')->get()->toArray();
        }else{
            $checkin_passsports = AssignPlateform::select('passport_id')->groupBy('passport_id')->get()->toArray();
        }

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
                                                 if($bike_id != null){
                                                     $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                         ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                         ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                         ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                         ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                         ->whereIn("passports.id",$checkin_passsports)
                                                         ->where("assign_bikes.status", "1")
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

    public function accident_pending_request()
    {
        $requests = VehicleAccident::with('passport','bikes','user')->where('status',1)->get();
        $rejected = VehicleAccident::with('passport','bikes','user')->where('status',3)->get();
        return view('admin-panel.vehicle_accident.pending_request',compact('requests','rejected'));
    }

    public function accident_pending_process()
    {
        $requests = VehicleAccident::with('passport','bikes','user')->where('status',2)->get();
        $uploaded = VehicleAccident::with('passport','bikes')->where('status',4)->get();
        $claims = VehicleAccident::with('passport','bikes')->where('status',5)->get();
        $delivery = VehicleAccident::with('passport','bikes')->where('status',6)->get();
        $loss_claim = VehicleAccident::with('passport','bikes')->where('status',7)->where('loss_or_repair',1)->get();
        $loss_cancel = VehicleAccident::with('passport','bikes')->where('status',8)->where('loss_or_repair',1)->get();
        return view('admin-panel.vehicle_accident.pending_process',compact('requests','uploaded','claims','delivery','loss_claim','loss_cancel'));
    }

    public function get_upload_modal_accident(Request $request)
    {
        $documents = VehicleAccident::find($request->id);
        $view = view("admin-panel.vehicle_accident.upload_modal", compact('documents'))->render();
        return response()->json(['html' => $view]);
    }

    public function save_accident_documents(Request $request)
    {
        if($request->hasfile('police'))
        {
            foreach($request->file('police') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/acciden_police_report/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $obj = VehicleAccident::find($request->ids);
        $obj->police_report_received = $request->polices;
        $obj->emiratesid = $request->eid;
        $obj->driving_license = $request->license;
        $obj->passport_received = $request->passport;
        $obj->salary = $request->salary;
        $obj->status = 4;
        if(isset($data)){
            $obj->police_report_attachment = json_encode($data);
        }
        $obj->save();

        return response()->json(['code' => "100",'id'=>$obj->bike_id]);
    }

    public function save_claim_process(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'claim_date' => 'required',
        ]);
        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return response()->json(['code' => "101",'message'=>$message]);
        }
        if($request->hasfile('claim_file'))
        {
            foreach($request->file('claim_file') as $file)
            {
                $name = rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/claim_file/' . $name;
                $ab = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $obj = VehicleAccident::find($request->claim_id);
        $obj->claim_date = $request->claim_date;
        $obj->claim_remark = $request->claim_remark;
        if(isset($data)){
            $obj->claim_file = json_encode($data);
        }
        $obj->status = 5;
        $obj->save();

        return response()->json(['code' => "100",'id'=>$obj->bike_id]);
    }

    public function bike_delivery_to_garage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'claim_no' => 'required',
            'date' => 'required',
            'del_id' => 'required',
        ]);
        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return response()->json(['code' => "101",'message'=>$message]);
        }

        $obj = VehicleAccident::find($request->del_id);
        $obj->claim_number = $request->claim_no;
        $obj->delivery_date = $request->date;
        $obj->garage = $request->garage;
        $obj->concerned_person = $request->person;
        $obj->contact = $request->contact;
        $obj->status = 6;
        $obj->save();

        return response()->json(['code' => "100",'id'=>$obj->bike_id]);
    }

    public function save_loss_repair(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'loss_or_repair' => 'required',
            'date' => 'required_if:loss_or_repair,2',
        ]);
        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return response()->json(['code' => "101",'message'=>$message]);
        }

        if($request->loss_or_repair == 1)
        {
            if($request->hasfile('offer_letter'))
            {
                foreach($request->file('offer_letter') as $file)
                {
                    $name = rand(100,100000).'-'.time().'.'.$file->extension();
                    $filePath = 'assets/upload/total_loss_offer_letter/' . $name;
                    $ab = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $filePath;
                }
            }
            if($request->hasfile('transfer_letter'))
            {
                foreach($request->file('transfer_letter') as $file)
                {
                    $name = rand(100,100000).'-'.time().'.'.$file->extension();
                    $filePath = 'assets/upload/total_loss_transfer_letter/' . $name;
                    $ab = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $dataone[] = $filePath;
                }
            }
            $obj = VehicleAccident::find($request->loss_id);
            if(isset($data)){
                $obj->offer_letter = json_encode($data);
            }
            if(isset($dataone)){
                $obj->transfer_letter = json_encode($dataone);
            }
            $obj->loss_or_repair = $request->loss_or_repair;
            $obj->status = 7;
            $obj->save();
        }elseif($request->loss_or_repair == 2){
            $obj = VehicleAccident::find($request->loss_id);
            $obj->receive_date = $request->date;
            $obj->person = $request->person;
            $obj->condition = $request->condition;
            $obj->loss_or_repair = $request->loss_or_repair;
            $obj->status = 9;
            $obj->save();
        }
        return response()->json(['code' => "100",'id'=>$obj->bike_id]);
    }

    public function loss_repair_bikes()
    {
        $loss = VehicleAccident::with('passport','bikes')->where('status',9)->where('loss_or_repair',1)->get();
        $repair = VehicleAccident::with('passport','bikes')->where('status',9)->where('loss_or_repair',2)->get();
        return view('admin-panel.vehicle_accident.completed_process',compact('loss','repair'));
    }

    public function save_lossclaim_process(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'lossclaim_date' => 'required',
        ]);

        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return response()->json(['code' => "101",'message'=>$message]);
        }
        if($request->hasfile('lossclaim_file'))
        {
            foreach($request->file('lossclaim_file') as $file)
            {
                $name = rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = 'assets/upload/total_loss_claim_file/' . $name;
                $ab = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $filePath;
            }
        }
        $obj = VehicleAccident::find($request->lossclaim_id);
        $obj->loss_claim_date = $request->lossclaim_date;
        $obj->loss_claim_remark = $request->lossclaim_remark;
        $obj->status = 8;
        if(isset($data)){
            $obj->loss_claim_file = json_encode($data);
        }
        $obj->save();

        return response()->json(['code' => "100",'id'=>$obj->bike_id]);
    }

    public function save_cancel_bike_process(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cancel_date' => 'required',
        ]);

        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return response()->json(['code' => "101",'message'=>$message]);
        }

        $bike_exist = BikeDetail::find($request->cancel_bike_id);
        if($bike_exist->status != 1){
            $new_bike_cancel = new BikeCencel();
            $new_bike_cancel->bike_id = $bike_exist->id;
            $new_bike_cancel->date_and_time = $request->cancel_date;
            $new_bike_cancel->remarks = $request->cancel_remark;
            $new_bike_cancel->save();

            $obj = VehicleAccident::find($request->cancel_id);
            $obj->cancelled_date = $request->cancel_date;
            $obj->cancelled_remark = $request->cancel_remark;
            $obj->status = 9;
            $obj->save();

            $message = [
                'message' => 'Vehicle Cancelled Successfully',
                'alert-type' => 'success'
            ];
            return response()->json(['code' => "100",'id'=>$obj->bike_id]);
        }else if($bike_exist->status == 1){
            $message = [
                'message' => 'Selected bike is active. Please inactive the bike first',
                'alert-type' => 'error'
            ];
            return response()->json(['code' => "102",'message'=>$message]);
        }
    }

    public function accident_process()
    {
        $bikes = BikeDetail::get(['id','plate_no','chassis_no','engine_no']);
        return view('admin-panel.vehicle_accident.accident_process',compact('bikes'));
    }

    public function accident_process_details(Request $request)
    {
        $bike = $request->bike;
        $bikes = VehicleAccident::where('bike_id',$bike)->latest()->first();

        $view = view('admin-panel.vehicle_accident.accident_process_details',compact('bikes'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_documents_details(Request $request)
    {
        $accident = VehicleAccident::find($request->id);
        $type = $request->type;
        $view = view('admin-panel.vehicle_accident.accident_document_details',compact('accident','type'))->render();
        return response()->json(['html' => $view]);
    }
}
