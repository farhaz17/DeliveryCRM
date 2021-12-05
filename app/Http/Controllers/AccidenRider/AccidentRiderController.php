<?php

namespace App\Http\Controllers\AccidenRider;

use DB;
use Carbon\Carbon;
use App\Model\Telecome;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\Lpo\BikeMissing;
use App\Model\Assign\AssignSim;
use PhpParser\Node\Expr\Assign;
use App\Model\Assign\AssignBike;
use App\Model\OwnSimBikeHistory;
use App\Model\AccidentRiderRequest;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Master\CategoryAssign;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use App\Model\ReserveBike\ReserveBike;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\SimReplacement\SimReplacement;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\VehicleAccident\VehicleAccident;
use App\Model\DcRequestForCheckout\DcRequestForCheckout;

class AccidentRiderController extends Controller
{
    //

    public function create(){

        return view('admin-panel.accident_request.create');
    }

    public function save_accident_request(Request $request){


        try {
            $validator = Validator::make($request->all(), [
                'rider_passport_id' => 'required',
                'checkout_date' => 'required',
                'checkout_type' => 'required',
            ]);
            if($validator->fails()){
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);
            }



             $already_request = AccidentRiderRequest::where('rider_passport_id','=',$request->rider_passport_id)
                                  ->where('status','=','0')->first();

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

            $user_id = Auth::user()->id;

             $accident_rider = new AccidentRiderRequest();
             $accident_rider->rider_passport_id = $request->rider_passport_id;
             $accident_rider->checkout_date = $request->checkout_date;
             $accident_rider->request_type =  $request->checkout_type;
             $accident_rider->checkout_type =  "5";
             $accident_rider->remarks = $request->remarks;
             $accident_rider->bike_id = $bike_id;
             $accident_rider->sim_id = $sim_id;
             $accident_rider->dc_id =   $user_id;
             $accident_rider->save();


             $message = [
                'message' => "request has been sent successfully",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);


        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return response()->json($message, 500);
        }


    }

    public function get_teamleader_request(Request  $request){

        if($request->ajax()){
         $user = Auth::user();

          if($user->hasRole('Admin')){
          $status = $request->request_type;

          $requests = AccidentRiderRequest::where('status','=',$status)->get();

          }else{

             $status = $request->request_type;

             $requests = AccidentRiderRequest::where('status','=',$status)->get();

          }

          $array_type  = ['','Complete Checkout','Only Bike Replacement'];

         $view = view('admin-panel.accident_request.ajax_render_temlader_request',compact('array_type','requests','status'))->render();
         return response()->json(['html'=>$view]);
         }


     }

    public function accident_request_for_teamleader(){

        if(in_array(1, Auth::user()->user_group_id)){
            $pending_request = AccidentRiderRequest::with('bike')->where('status','=','0')->get();
        }else{
            $pending_request = AccidentRiderRequest::where('accident_rider_requests.status','=','0')
                                ->select('accident_rider_requests.*', 'assign_plateforms.plateform')
                                ->join('assign_plateforms', 'assign_plateforms.passport_id', 'accident_rider_requests.rider_passport_id')
                                ->where('assign_plateforms.status','=','1')
                                ->get();
        }


        $accepted_request = AccidentRiderRequest::where('status','=','1')->get();
        $rejected_request = AccidentRiderRequest::where('status','=','2')->get();

        $array_type  = ['','Complete Checkout','Only Bike Replacement'];
            return view('admin-panel.accident_request.accident_request_for_teamleader',compact('array_type','pending_request','accepted_request','rejected_request'));
    }

    public function after_approved_requests(){

        $complete_accepted_request = AccidentRiderRequest::where('status','=','1')
                                                         ->where('request_type','=','1')
                                                         ->where('bike_sim_approve_status','=','0')
                                                            ->get();

       $only_bike_accpet_request = AccidentRiderRequest::where('status','=','1')
                                                        ->where('request_type','=','2')
                                                        ->where('bike_sim_approve_status','=','0')
                                                        ->get();

        $array_type  = ['','Complete Checkout','Only Bike Replacement'];
            return view('admin-panel.accident_request.after_approved_request_list',compact('array_type','only_bike_accpet_request','complete_accepted_request'));

    }

    public function save_after_accepte_request(Request $request){



        try {
            $validator = Validator::make($request->all(), [
                'rider_passport_id' => 'required',
                'checkout_date' => 'required',
                'bike_number' => 'required',
                'primary_id' => 'required',
            ]);
            if($validator->fails()){
                $validate = $validator->errors();

                return $validate->first();
            }

            $id = $request->primary_id;

            $request_detail = AccidentRiderRequest::where('id','=',$id)->first();


             $assign_platform = AssignPlateform::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

             if($request_detail->request_type==="1"){

                    if($assign_platform != null){
                            return  "User is checkin.!!";
                    }

             }


             $id = $request->primary_id;



             $bike_id = null;

             if (!$request_detail->rider_name->bike_assign->isEmpty()) {
                $abs =  $request_detail->rider_name->bike_assign->where('status','1')->first();
                $bike_id  =  isset($abs->bike_plate_number->id) ? $abs->bike_plate_number->id : 'N/A';
             }

             if(!isset($bike_id)){
                 return "bike is not assigned";
             }

             $temp_bike_id = null;
             if(!$request_detail->rider_name->temporary_bike_replacement->isEmpty()) {
                $abs =  $request_detail->rider_name->temporary_bike_replacement->where('status','1')->first();
                $temp_bike_id  =  isset($abs->temporary_plate_number->id) ? $abs->temporary_plate_number->id : null;
            }


            $sim_id = null;
            if (!$request_detail->rider_name->sim_assign->isEmpty()) {
                $abs_sim = $request_detail->rider_name->sim_assign->where('status','1')->first();
                $sim_id = isset($abs_sim->telecome->id) ? $abs_sim->telecome->id : null;
            }


            if(!isset($sim_id)){
                return  "Sim is not Assigned.!";
            }

            $result_sim  = $this->sim_checkout($request->rider_passport_id,$request->checkout_date,$request->remarks,$sim_id);

            if($result_sim=="success"){
                    $result_bike = $this->bike_checkout($request->rider_passport_id,$request->checkout_date,$request->remarks);

                    if($result_bike=="success"){
                        if(isset($temp_bike_id)){
                            $bike_replacement = BikeReplacement::where('passport_id','=',$request->rider_passport_id)
                                                                ->where('status','=','1')->first();
                            $bike_replacement->status = "0";
                            $bike_replacement->replace_taken_remarks = $request->remarks;
                            $bike_replacement->replace_checkout =  $request->checkout_date;
                            $bike_replacement->update();

                            $bike_detail = BikeDetail::find($temp_bike_id);
                            $bike_detail->status = 0;
                            $bike_detail->update();
                        }


                       $bike_missing = new BikeMissing();
                       $bike_missing->bike_id = $request->bike_number;
                       $bike_missing->created_user_id = Auth::user()->id;
                       $bike_missing->remarks = $request->remarks;
                       $bike_missing->process = 1;
                       $bike_missing->save();

                       if($request_detail->data_from == "1"){

                            $obj = VehicleAccident::where('rider_passport_id','=',$request->rider_passport_id)->where('status',1)->first();
                            $obj->status = 2;
                            $obj->update();
                        }

                       $request_detail->bike_sim_approve_status = "1";
                       $request_detail->bike_sim_approve_by =   Auth::user()->id;
                       $request_detail->update();


                        return  "success";
                    }else{
                        return  $result_bike;
                    }


            }else{
                return  $result_sim;
            }







        }catch(\Illuminate\Database\QueryException $e){

            return "Error Occured";
        }


    }


    public function save_after_accepte_request_for_bike_only(Request $request){

           try{
                    $validator = Validator::make($request->all(), [
                        'repalce_bike_type' => 'required',
                        'primary_id' => 'required',
                        'checkout_date' => 'required',
                         'rider_passport_id' => 'required'
                    ]);
                    if($validator->fails()){
                        $validate = $validator->errors();

                        return $validate->first();
                    }

                    if($request->repalce_bike_type!="1"){
                        $validator = Validator::make($request->all(), [
                            'new_bike_id' => 'required',
                        ]);
                        if($validator->fails()){
                            $validate = $validator->errors();
                            return $validate->first();
                        }
                    }

                    $id = $request->primary_id;
                    $request_detail = AccidentRiderRequest::where('id','=',$id)->first();

                        if($request->repalce_bike_type=="1"){ //remove only temporary bike

                            $bike_replacement = BikeReplacement::where('passport_id','=',$request->rider_passport_id)
                            ->where('status','=','1')->first();
                            $bike_replacement->status = "0";
                            $bike_id_now=  $bike_replacement->new_bike_id;
                            $bike_replacement->replace_taken_remarks = $request->remarks;
                            $bike_replacement->replace_checkout =  $request->checkout_date;
                            $bike_replacement->update();

                            if($request_detail->data_from == "1"){
                                return 'asfd';
                                $obj = VehicleAccident::where('rider_passport_id','=',$request->rider_passport_id)->where('status',1)->first();
                                $obj->status = 2;
                                $obj->update();
                            }

                            $request_detail->bike_sim_approve_status = "1";
                            $request_detail->bike_sim_approve_by =   Auth::user()->id;
                            $request_detail->update();

                            $bike_missing = new BikeMissing();
                            $bike_missing->bike_id = $bike_id_now;
                            $bike_missing->created_user_id = Auth::user()->id;
                            $bike_missing->process = 1;
                            $bike_missing->remarks = $request->remarks;
                            $bike_missing->save();


                            return "success";

                        }elseif($request->repalce_bike_type=="2"){ //give him new bike and checkout the temporary bike and permananet bike




                            $bike_replacement = BikeReplacement::where('passport_id','=',$request->rider_passport_id)
                            ->where('status','=','1')->first();

                            if($bike_replacement != null){

                                $bike_id_now=  $bike_replacement->new_bike_id;

                                $bike_replacement->status = "0";
                                $bike_replacement->replace_taken_remarks = $request->remarks;
                                $bike_replacement->replace_checkout =  $request->checkout_date;
                                $bike_replacement->update();

                                $bike_missing = new BikeMissing();
                                $bike_missing->bike_id = $bike_id_now;
                                $bike_missing->created_user_id = Auth::user()->id;
                                $bike_missing->process = 1;
                                $bike_missing->remarks = $request->remarks;
                                $bike_missing->save();

                            }

                            $assign_bike = AssignBike::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

                            $assigned_bike_id = null;

                            if($assign_bike != null){
                                $assigned_bike_id = $assign_bike->bike;
                            }


                             $this->bike_checkout($request->rider_passport_id,$request->checkout_date,$request->remarks);

                             $result_assign = $this->make_bike_assign($request->rider_passport_id,$request->new_bike_id,$request->checkout_date,$request->remarks);

                             if($result_assign=="success"){

                                $bike_missing = new BikeMissing();
                                $bike_missing->bike_id = $assigned_bike_id;
                                $bike_missing->created_user_id = Auth::user()->id;
                                $bike_missing->process = 1;
                                $bike_missing->remarks = $request->remarks;
                                $bike_missing->save();

                                if($request_detail->data_from == "1"){

                                    $obj = VehicleAccident::where('rider_passport_id','=',$request->rider_passport_id)->where('status',1)->first();
                                    $obj->status = 2;
                                    $obj->update();
                                }

                                $request_detail->bike_sim_approve_status = "1";
                                $request_detail->bike_sim_approve_by =   Auth::user()->id;
                                $request_detail->update();

                                return "success";

                             }else{
                                    return  $result_assign;
                             }





                        }elseif($request->repalce_bike_type=="3"){ // give him new temporary bike

                            $assign_bike = AssignBike::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

                            if($assign_bike != null){

                                $assigned_bike_id = $assign_bike->bike;

                                $bike_detail_already = BikeDetail::where('id','=',$request->bike_id)->first();

                                if($bike_detail_already != null){
                                    $exist_bike_detail = BikeDetail::where('plate_no','=',$bike_detail_already->plate_no)->where('status','=','1')->first();

                                    if($exist_bike_detail != null){
                                        return 'This Bike is already assigned to someone';
                                    }
                                }

                                $bike_detail_already_two = BikeDetail::where('id','=',$request->bike_id)->where('status','=','1')->first();

                                if($bike_detail_already_two != null){

                                    if($exist_bike_detail != null){
                                        return 'This Bike is already assigned';
                                    }
                                }


                            $bike_replacement = BikeReplacement::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

                            if($bike_replacement != null){
                                return 'This Rider have Replace Bike, So checkout that Replace Bike before Assign new Bike';
                            }

                            $bike_missing = new BikeMissing();
                            $bike_missing->bike_id = $assigned_bike_id;
                            $bike_missing->created_user_id = Auth::user()->id;
                            $bike_missing->process = 1;
                            $bike_missing->remarks = $request->remarks;
                            $bike_missing->save();


                                $bike_replacement = new BikeReplacement();
                                $bike_replacement->passport_id =  $request->rider_passport_id;
                                $bike_replacement->new_bike_id = $request->new_bike_id;
                                $bike_replacement->replace_bike_id =  $assign_bike->bike;
                                $bike_replacement->assign_bike_id =  $assign_bike->id;
                                $bike_replacement->status = "1";
                                $bike_replacement->replace_remarks = $request->remarks;
                                $bike_replacement->type = "1";
                                $bike_replacement->replace_checkin =  $request->checkout_date;
                                $bike_replacement->replace_reason = "0";
                                $bike_replacement->save();

                                if($request_detail->data_from == "1"){

                                    $obj = VehicleAccident::where('rider_passport_id','=',$request->rider_passport_id)->where('status',1)->first();
                                    $obj->status = 2;
                                    $obj->update();
                                }

                                $request_detail->bike_sim_approve_status = "1";
                                $request_detail->bike_sim_approve_by =   Auth::user()->id;
                                $request_detail->update();

                                return "success";

                            }else{
                                return "User don't have permanent Bike";
                            }



                        }elseif($request->repalce_bike_type=="4"){ //replace current bike with new bike

                            $assign_bike = AssignBike::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

                            $assigned_bike_id = null;

                            if($assign_bike != null){
                                $assigned_bike_id = $assign_bike->bike;
                            }

                            $this->bike_checkout($request->rider_passport_id,$request->checkout_date,$request->remarks);

                             $result_assign = $this->make_bike_assign($request->rider_passport_id,$request->new_bike_id,$request->checkout_date,$request->remarks);

                            if($result_assign=="success"){


                                $bike_missing = new BikeMissing();
                                $bike_missing->bike_id = $assigned_bike_id;
                                $bike_missing->created_user_id = Auth::user()->id;
                                $bike_missing->remarks = $request->remarks;
                                $bike_missing->process = 1;
                                $bike_missing->save();

                                if($request_detail->data_from == "1"){

                                    $obj = VehicleAccident::where('rider_passport_id','=',$request->rider_passport_id)->where('status',1)->first();
                                    $obj->status = 2;
                                    $obj->update();
                                }

                                $request_detail->bike_sim_approve_status = "1";
                                $request_detail->bike_sim_approve_by =   Auth::user()->id;
                                $request_detail->update();

                                return "success";

                             }else{
                                    return  $result_assign;
                             }



                        }






            }catch(\Illuminate\Database\QueryException $e){

                return "Error Occured gamer";
            }
    }



    public function  sim_checkout($passport_id,$chekcout_date,$remarks,$sim_id){

        $assign_replace_sim = SimReplacement::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        if($assign_replace_sim!=null){

            $assign_replace_sim->status = "0";
            $assign_replace_sim->replace_taken_remarks = $remarks;
            $assign_replace_sim->replace_checkout = $chekcout_date;
            $sim_id_checkout = $assign_replace_sim->new_sim_id;
            $assign_replace_sim->update();

            $sime_detail = Telecome::find($sim_id_checkout);
            $sime_detail->status = "0";
            $sime_detail->update();

        }





        $passport_assign = AssignSim::where('passport_id','=',$passport_id)
            ->where('status','=','1')
            ->orderBy('id','desc')
            ->first();

        if($passport_assign == null){
          return  'Sim is not assigned to this rider';
        }else{
            $passport_assign->checkout= $chekcout_date;
            $passport_assign->remarks= $remarks;
            $passport_assign->status='0';
            $passport_assign->checkout_reason = "1";
            $passport_assign->save();
        }

        DB::table('telecomes')->where('id', $sim_id)
            ->update(['status' => '0']);

       return "success";
    }


    public function bike_checkout($passport_id,$checkout,$remarks){



        $obj = AssignBike::where('passport_id','=',$passport_id)->where('status','=','1')->orderby('id','desc')->first();
        if($obj != null){

            $obj->checkout = $checkout;
            $obj->remarks = $remarks;
            $obj->checkout_reason = "0";
            $obj->status = '0';
            $obj->save();

            $assign_id  = $obj->id;
            $bike_id = AssignBike::where('id', $assign_id)->latest('created_at')->first();

            DB::table('bike_details')->where('id', $bike_id->bike)
                ->update([
                    'status' =>  0
                    ]);

            return "success";

        }else{
            return "success";
        }




    }


    public function make_bike_assign($passport_id,$bike_id,$checkin,$remarks)
    {

        $pass_id = $passport_id;


        $bike_own_history = OwnSimBikeHistory::where('passport_id','=',$passport_id)->where('own_type','=','2')->where('status','=','1')->first();

        if($bike_own_history != null){

            $bike_own_history->status = "0";
            $bike_own_history->update();

        }




        $assigned_id=AssignBike::where('passport_id',$pass_id)->count();
        $checkout_detail=AssignBike::where('passport_id',$pass_id)->latest('created_at')->first();

        $plate_number_detail =BikeDetail::where('id','=',$bike_id)->where('status','=','1')->first();

        if($plate_number_detail != null){
              return 'This bike is already taken';
        }


        $passport_number=AssignBike::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
        $plate_number=AssignBike::where('bike',$bike_id)->latest('created_at')->first();



        $passport_number=AssignBike::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
        $plate_number=AssignBike::where('bike',$bike_id)->latest('created_at')->first();

        if($plate_number != null && $passport_number != null ){

            if($passport_number->status!= "1" && $plate_number->status != "1" ){


                $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

                $user_id = Auth::user()->id;
                $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

                if($reserve_bike != null){
                    if($reserve_bike->bike_id==$bike_id){
                        $reserve_bike->assign_status  = "1";
                        $reserve_bike->assigned_by  = $user_id;
                        $reserve_bike->update();
                    }else{

                        return  'Please assign same bike that reserved For this rider';
                    }
                }elseif($reserve_bike_check != null){
                    return 'This bike is already reserved for rider';
                }


                $obj = new AssignBike();
                $obj->passport_id = $pass_id;
                $obj->bike = $bike_id;
                $obj->checkin = $checkin;
                $obj->remarks = $remarks;
                $obj->status = '1';
                $obj->save();


                DB::table('bike_details')->where('id',$bike_id)
                ->update(['status' => '1']);
                return 'success';


            }else{
                return 'Bike Already Assigned  Not checkout';
            }

        }elseif($passport_number != null){

            if($passport_number->status!="1"){


                $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

                $user_id = Auth::user()->id;
                $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

                if($reserve_bike != null){
                    if($reserve_bike->bike_id==$bike_id){
                        $reserve_bike->assign_status  = "1";
                        $reserve_bike->assigned_by  = $user_id;
                        $reserve_bike->update();
                    }else{
                         return 'Please assign same bike that reserved For this rider';
                     }
                }elseif($reserve_bike_check != null){
                    return 'This bike is already reserved for rider';
                }

                $obj = new AssignBike();
                $obj->passport_id = $pass_id;
                $obj->bike = $bike_id;
                $obj->checkin = $checkin;
                $obj->remarks = $remarks;
                $obj->status = '1';
                $obj->save();
                DB::table('bike_details')->where('id',$bike_id)
                    ->update(['status' => '1']);

                return 'success';

            }else{
                return 'Bike Already Assigned  Not checkout';
            }

        }elseif($plate_number != null){

            if($plate_number->status!="1"){

                $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

                $user_id = Auth::user()->id;
                $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

                if($reserve_bike != null){
                    if($reserve_bike->bike_id==$bike_id){
                        $reserve_bike->assign_status  = "1";
                        $reserve_bike->assigned_by  = $user_id;
                        $reserve_bike->update();
                    }else{
                        return 'Please assign same bike that reserved For this rider';
                    }
                }elseif($reserve_bike_check != null){
                        return 'This bike is already reserved for rider';
                }


                $obj = new AssignBike();
                $obj->passport_id = $pass_id;
                $obj->bike = $bike_id;
                $obj->checkin = $checkin;
                $obj->remarks = $remarks;
                $obj->status = '1';
                $obj->save();

                DB::table('bike_details')->where('id',$bike_id)
                    ->update(['status' => '1']);
                return  "success";

            }else{

                return  "Bike Already Assigned  Not checkout";

            }

        }else{

            $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

            $user_id = Auth::user()->id;
            $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

            if($reserve_bike != null){
                if($reserve_bike->bike_id==$bike_id){
                    $reserve_bike->assign_status  = "1";
                    $reserve_bike->assigned_by  = $user_id;
                    $reserve_bike->update();
                }else{

                    return "Please assign same bike that reserved For this rider";
                }
            }elseif($reserve_bike_check != null){

                return "This bike is already reserved for rider";
            }



            $obj = new AssignBike();
            $obj->passport_id =$pass_id;
            $obj->bike = $bike_id;
            $obj->checkin = $checkin;
            $obj->remarks = $remarks;
            $obj->status = '1';
            $obj->save();

            DB::table('bike_details')->where('id',$bike_id)
                ->update(['status' => '1']);

            return "success";


        }
    }







    public function save_request_teamlader_action(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'primary_id' => 'required',
                'request_type' => 'required',
            ]);
            if($validator->fails()){
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                ];
                return $validate->first();
            }

            if(isset($request->request_rta)) {
                AccidentRiderRequest::where('id', $request->primary_id)->update(['request_type' => $request->checkout_type]);
            }

            if($request->request_type=="1"){ //accepted

                $accident_rider = AccidentRiderRequest::find($request->primary_id);
                $passport_id = $accident_rider->rider_passport_id;

             $assign_platform = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

             $bike_id = null;
             $sim_id = null;

             if($assign_platform != null){
                 $bike = AssignBike::where('passport_id','=',$passport_id)->where('status','=','1')->first();
                $sim = AssignSim::where('passport_id','=',$passport_id)->where('status','=','1')->first();

                if($bike == null || $bike == null ){
                    $message = [
                        'message' => "Sim or Bike is not Assigned",
                        'alert-type' => 'error',
                    ];
                    return "Sim or Bike is not Assigned";
                }

                $bike_id = $bike->bike;
                $sim_id = $sim->sim;

             }else{
                $message = [
                    'message' => "User not Checkin.!",
                    'alert-type' => 'error',
                ];
                return "User not Checkin.!";
             }

            $user_id = Auth::user()->id;


           if($accident_rider->request_type=="1"){



            $obj_assign = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();
                 $result = $this->checkout_method($request,$passport_id);

                 if($result=="success"){


                    $dcrequest = new DcRequestForCheckout();
                    $dcrequest->request_by_id = Auth::user()->id;
                    $dcrequest->rider_passport_id = $passport_id;
                    $dcrequest->checkout_type = "5";
                    $dcrequest->checkout_date_time = $accident_rider->checkout_date;
                    $dcrequest->remarks = $accident_rider->remarks;
                    $dcrequest->assigned_platform_id = $obj_assign->id;
                    $dcrequest->request_status = 1;
                    $dcrequest->approve_by_id = Auth::user()->id;
                    $dcrequest->save();


                    $accident_rider->status = "1";
                    $accident_rider->remarks = $request->remarks;
                    $accident_rider->team_leader_id = $user_id;
                    $accident_rider->update();

                    // $message = [
                    //     'message' => "Success",
                    //     'alert-type' => 'success',
                    // ];
                    return "success";

                 }else{
                    $message = [
                        'message' => "Error",
                        'alert-type' => 'error',
                    ];
                    return  'Error Occured';
                 }

            }


            $accident_rider->status = "1";
            $accident_rider->remarks = $request->remarks;
            $accident_rider->team_leader_id = $user_id;
            $accident_rider->update();


            }else{ //rejected

                $accident_rider = AccidentRiderRequest::find($request->primary_id);
                $accident_rider->status = "2";
                $accident_rider->remarks = $request->remarks;
                $accident_rider->update();

                if($accident_rider->data_from == "1"){

                    $obj = VehicleAccident::where('rider_passport_id','=',$accident_rider->rider_passport_id)->where('status',1)->first();
                    $obj->status = 3;
                    $obj->update();
                }

            }

            $message = [
                'message' => "Rejected",
                'alert-type' => 'error',
            ];

            return  'success';


        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return  $e->getMessage();
        }

    }


    public function get_accident_request_ajax(Request $request){
        if($request->ajax()){

            $id = $request->id_primary;
            $request_detail = AccidentRiderRequest::where('id','=',$id)->first();

            $array_type  = ['','Complete Checkout','Only Bike Replacement'];

            $view = view("admin-panel.accident_request.ajax_request_detail",compact('array_type','request_detail'))->render();
            return response()->json(['html'=>$view]);
        }
    }

    public function after_accept_get_accident_request_ajax(Request $request){
        if($request->ajax()){

            $id = $request->id_primary;
            $request_detail = AccidentRiderRequest::where('id','=',$id)->first();

            $array_type  = ['','Complete Checkout','Only Bike Replacement'];

            if($request_detail->request_type=="1"){
                $view = view("admin-panel.accident_request.after_accept_ajax_request_detail",compact('array_type','request_detail'))->render();
                return response()->json(['html'=>$view]);
            }else{
                $working_bikes = BikeDetail::whereStatus(2)->get();
                $view = view("admin-panel.accident_request.after_approve_request_bike_replace",compact('array_type','request_detail','working_bikes'))->render();
                return response()->json(['html'=>$view]);
            }

        }
    }


    public function checkout_method($request,$passport_id){

        try{

        $passport_id = $passport_id;

        $driving_licence  = DrivingLicense::where('passport_id','=',$passport_id)->first();

        if($driving_licence==null) {
            return "Driving license is not created, please create driving license";
        }

        $assign_obj_ab = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        if($assign_obj_ab==null){

            return "Platform is not checkin, you can not checkout";
        }

        $is_platform_code = PlatformCode::where('passport_id','=',$passport_id)->where('platform_id','=',$assign_obj_ab->plateform)->first();


        $id= $assign_obj_ab->id;

        $obj = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        $total_pending_amount = 0;
        $total_paid_amount= 0;

        $check_in_platform = $obj->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();
        $rider_id = $obj->passport->platform_codes->where('platform_id','=',$check_in_platform)->pluck(['platform_code'])->first();

        $user_passport_id = $obj->passport->id;






            $obj->checkout=$request->input('checkout_date');
            $obj->remarks=$request->input('remarks');
            $obj->status='0';
            $obj->save();

            OwnSimBikeHistory::where('passport_id','=',$passport_id)
                ->where('status','=','1')
                ->update(array('status' => "0", 'checkout'=>$request->input('checkout') ));

            AssignToDc::where('rider_passport_id','=',$passport_id)
                ->where('status','=','1')
                ->update(array('status' => "0",'checkout'=>$request->checkout_date));

                CategoryAssign::where('passport_id','=',$passport_id)
                ->where('status','=','1')
                ->orderby('id','desc')
                ->update(array('status' => "0",'assign_ended_at' => Carbon::now()));




            return 'success';
        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return "gamere".$e;
        }



    }







}
