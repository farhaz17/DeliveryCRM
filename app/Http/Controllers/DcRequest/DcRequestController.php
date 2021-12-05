<?php

namespace App\Http\Controllers\DcRequest;

use App\User;
use Carbon\Carbon;
use App\Model\Cities;
use App\Model\Platform;
use App\DcLimit\DcLimit;
use App\Model\Cods\Cods;
use App\Model\BikeDetail;
use App\Model\RiderHoldDC;
use App\Model\Guest\Career;
use App\Model\Master\FourPl;
use Illuminate\Http\Request;
use App\Model\Cods\CloseMonth;
use App\Model\Referal\Referal;
use App\Model\OwnSimBikeHistory;
use App\Model\Passport\Passport;
use App\Model\Master\SubCategory;
use App\Model\VendorRiderOnboard;
use App\Model\Agreement\Agreement;
use App\Model\Career\RejoinCareer;
use App\Model\CodUpload\CodUpload;
use App\Model\AccidentRiderRequest;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Master\CategoryAssign;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use App\Model\Referal\ReferralSetting;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\OnBoardStatus\OnBoardStatusType;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\Riders\DefaulterRiders\DefaulterRider;
use App\Model\DcRequestForCheckin\DcRequestForCheckin;
use App\Model\DcRequestForCheckout\DcRequestForCheckout;
use App\Model\Package\PackageAssignment;
use App\Model\Riders\DefaulterRiders\DefaulterRiderDrcAssign;
use App\Model\Riders\DefaulterRiders\DefalterRiderReassignRequest;

class DcRequestController extends Controller
{

    function __construct()
    {

        $this->middleware('role_or_permission:Admin|Hiring-Re-Entry|checkout_type_report', ['only' => ['checkout_type_report','get_checkout_report_type_ajax']]);
        $this->middleware('role_or_permission:Admin|DC_roll|Defaulter Rider Co-ordinator', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Admin|manager_dc', ['only' => ['checkin_request_for_teamleader','request_for_teamleader']]);
        $this->middleware('role_or_permission:Admin|Defaulter Rider Co-ordinator Manager', ['only' => ['checkin_request_for_defaulter_manager','request_for_checkout_defaulter_manager']]);
        $this->middleware('role_or_permission:Admin|Hiring-pool|Hiring-onboard-report', ['only' => ['dc_sent_request_checkin']]);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;

         $requests = DcRequestForCheckout::where('request_by_id','=',$user_id)->get();

         $checkout_type_array = get_checkout_type_names();

         $status_array =  array('Pending','Accepted','Rejected');

            return view('admin-panel.dc.index',compact('requests','checkout_type_array','status_array'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view("admin-panel.dc.make_request");
    }

    public function send_to_checkout_report()
    {
        return view("admin-panel.dc.send_to_checkout_report");

    }

    public function ajax_onboard_checkin(Request $request){

        if($request->ajax()){
            $primary_id = $request->id;
            $onboard = OnBoardStatus::find($primary_id);
            $plaforms = Platform::all();
            $cities = Cities::all();
            $four_pl_name = "";
            $visa_type = "";
            if($onboard->career_id != "0"){
                //  $career_detail = Career::find($onboard->career_id);
                    //  if($career_detail->employee_type=="2"){
                    //      if(isset($career_detail->vendor_fourpl_detail)){
                    //         $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                    //      }else{
                    //         $four_pl_name = "N/A";
                    //      }
                    //     $visa_type = "Four PL";
                //  }
                $career_detail = Career::find($onboard->career_id);
                if($career_detail != null){
                    if($career_detail->employee_type=="2"){
                        if(isset($career_detail->vendor_fourpl_detail)){
                        $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                        $is_working = $career_detail->vendor_fourpl_detail;
                        }else{
                        $four_pl_name = "N/A";
                        }
                        $visa_type =  $is_working->cancel_status=="1" ? "Company" : "Four PL";
                    }
                }else{
                    $visa_type = "Company";
                }
            }else{
                $passport_id = $onboard->passport_id;
                $passport_detail = Passport::find($passport_id);
                if($passport_detail->career_id!="0"){
                // $career_detail = Career::find($onboard->career_id);
                    // if($career_detail != null){

                    //     if($career_detail->employee_type=="2"){
                    //         if(isset($career_detail->vendor_fourpl_detail)){
                    //         $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                    //         }else{
                    //         $four_pl_name = "N/A";
                    //         }
                    //     $visa_type = "Four PL";
                    //     }

                    // }else{
                    //     $visa_type = "Company";
                // }
                $rider = VendorRiderOnboard::where('passport_no', $passport_detail->passport_no)->where('status', 1)->where('cancel_status', 0)->first();
                    if($rider) {
                        $visa_type = "Four PL";
                        $four_pl_name = FourPl::find($rider->four_pls_id);
                        if($four_pl_name) {
                            $four_pl_name = $four_pl_name->name;
                        }else{
                            $four_pl_name = "N/A";
                        }
                    }else{
                        $visa_type = "N/A";
                    }
                }else{
                    $visa_type = "Company";
                }
            }
            $view = view('admin-panel.dc.ajax_make_request_for_checkin',compact('onboard','cities','plaforms','four_pl_name','visa_type'))->render();
        return response()->json(['html'=>$view]);
        }
    }

    public function team_leader_request_sent_for_dc(Request  $request){

        $user = Auth::user();
        if($user->hasRole('Admin')){
            $riders = RiderHoldDC::where('request_status','=','0')->get();
        }else{
          $primay_ids = DcRequestForCheckin::where('approve_by_id','=',$user->id)->pluck('id')->toArray();

          $riders = RiderHoldDC::whereIn('dc_request_for_checkin_id',$primay_ids)->where('request_status','=','0')->get();
        }


        return view('admin-panel.dc.team_leader_request_sent_for_dc',compact('riders'));
    }

    public function get_rejected_request_ajax(Request $request){

        if($request->ajax()){
            $rider_hold_dc = RiderHoldDC::where('id','=',$request->primary_id)->first();

            $request_dc = DcRequestForCheckin::where('id',$rider_hold_dc->dc_request_for_checkin_id)->first();

            $status_array =  array('Pending','Accepted','Rejected');


            $platforms = Platform::all();
            $cities = Cities::all();
            $all_dc = User::where('designation_type','=','3')->where('user_platform_id','LIKE','%'.$request_dc->platform_id.'%')->get();



            $view = view("admin-panel.dc.reject_ajax_request",compact('all_dc','cities','platforms','request_dc','status_array'))->render();

            return response()->json(['html'=>$view]);
        }

    }

    public function resend_rejected_requested_save(Request $request){


        try {
            $validator = Validator::make($request->all(), [
                'primary_id_selected' => 'required',
                'to_dc_id' => 'required',
            ]);
            if($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            $riderhold = RiderHoldDC::find($request->primary_id_selected);

            $is_usercheckin = $riderhold->checkin_assign_platform();

            if(!isset($is_usercheckin)){
                $message = [
                    'message' => "User is Already checkout no need of DC",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

            $total_assigned = AssignToDc::where('status','=','1')->where('user_id','=',$request->to_dc_id)->where('platform_id','=',$request->plateform)->count();
            $total_dc_limit = DcLimit::where('user_id','=',$request->to_dc_id)->first();
            $limit = $total_dc_limit->limit ? $total_dc_limit->limit : 0;
            $total_remain_rider =  $limit-$total_assigned;
            if($total_remain_rider < 1){
                $message = [
                    'message' => "Limit is completed, please select another DC",
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);
            }

            $riderhold_new = new RiderHoldDC();
            $riderhold_new->assign_platform_id = $riderhold->assign_platform_id;
            $riderhold_new->dc_request_for_checkin_id = $riderhold->dc_request_for_checkin_id;
            $riderhold_new->dc_id = $request->to_dc_id;
            $riderhold_new->request_status = "0";
            $riderhold_new->rejected_primary_id = $riderhold->id;
            $riderhold_new->save();


            $message = [
                'message' => "Request Sent Successfully",
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);



        }catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

    }




    public function get_team_leader_request_sent_for_dc(Request  $request){

        if($request->ajax()){
            $status = $request->status;

            $user = Auth::user();
            if($user->hasRole('Admin')){
                if($status=="2"){
                    $riders = RiderHoldDC::where('request_status','=',$status)->whereNull('rejected_primary_id')->get();
                }else{
                    $riders = RiderHoldDC::where('request_status','=',$status)->get();
                }



            }else{

                $primay_ids = DcRequestForCheckin::where('approve_by_id','=',$user->id)->pluck('id')->toArray();

                if($status=="2"){
                    $riders =  RiderHoldDC::whereIn('dc_request_for_checkin_id',$primay_ids)->where('request_status','=',$status)->whereNull('rejected_primary_id')->get();
                }else{
                    $riders =  RiderHoldDC::whereIn('dc_request_for_checkin_id',$primay_ids)->where('request_status','=',$status)->get();
                }

            }

            $view = view('admin-panel.dc.get_team_leader_request_sent_for_dc',compact('status',"riders"))->render();
            return response(['html' => $view]);

        }


    }

    public function dc_to_accept_rider(Request  $request){

        $user = Auth::user();
        if($user->hasRole('Admin')){

            $users = User::where('designation_type','=','3')->get();
            $all_dc_drc_m = $users->filter(function($user){
                return $user->hasAnyRole(['Defaulter Rider Co-ordinator', 'Defaulter Rider Co-ordinator Manager']);
            })->pluck('id')->toArray();


         $riders = RiderHoldDC::where('request_status','=','0')->WhereNotIn('dc_id',$all_dc_drc_m)->get();
         $defaulder_rider = RiderHoldDC::where('request_status','=','0')->WhereIn('dc_id',$all_dc_drc_m)->get();
        //  $defaulter_riders_pending = DefalterRiderReassignRequest::where('approval_status','=','0')->get();

        }elseif($user->hasRole('Defaulter Rider Co-ordinator')){

            $users = User::where('designation_type','=','3')->get();
            $all_dc_drc_m = $users->filter(function($user){
                return $user->hasAnyRole(['Defaulter Rider Co-ordinator', 'Defaulter Rider Co-ordinator Manager']);
            })->pluck('id')->toArray();

            $defaulder_rider = RiderHoldDC::where('dc_id','=',$user->id)->where('request_status','=','0')->get();
            $riders = RiderHoldDC::where('request_status','=','0')->where('dc_id','=',$user->id)->WhereNotIn('dc_id',$all_dc_drc_m)->get();


        }else{
            $users = User::where('designation_type','=','3')->get();
            $all_dc_drc_m = $users->filter(function($user){
                return $user->hasAnyRole(['Defaulter Rider Co-ordinator', 'Defaulter Rider Co-ordinator Manager']);
            })->pluck('id')->toArray();

            $riders = RiderHoldDC::where('dc_id','=',$user->id)->where('request_status','=','0')->WhereNotIn('dc_id',$all_dc_drc_m)->get();
            $defaulder_rider = RiderHoldDC::where('dc_id','=',$user->id)->WhereIn('dc_id',$all_dc_drc_m)->where('request_status','=','0')->get();

            // $defaulter_riders_pending = DefalterRiderReassignRequest::where('requested_to_dc_id','=',$user->id)
                                                                // ->where('approval_status','=','0')->get();
        }


        return view('admin-panel.dc.dc_to_accept_rider',compact('riders','defaulder_rider'));
    }

    public function rider_to_accept_request_save(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'primary_id_selected' => 'required',
                'select_choice' => 'required',
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }
             $rider_hold = RiderHoldDC::find($request->primary_id_selected);
             $rider_hold->request_status =   $request->select_choice;
             $rider_hold->save();

             if($request->select_choice=="1"){
//                             assign to dc specific rider
                 $rider_hold = RiderHoldDC::find($request->primary_id_selected);
            $assign_to_dc = new AssignToDc();
            $assign_to_dc->rider_passport_id =  $rider_hold->check_in_request->rider_passport_id;
            $assign_to_dc->user_id =  $rider_hold->dc_id;
            $assign_to_dc->platform_id =   $rider_hold->check_in_request->platform_id;
            $assign_to_dc->checkin =   $rider_hold->assign_platform->checkin;
            $assign_to_dc->status =  "1";
            $assign_to_dc->save();
             }

            $message = [
                'message' => "Dc has been assigned successfully",
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);



        }catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


    }


    public function rider_to_accept_request_defaulter_save(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'defaulter_primary_id_selected' => 'required',
                'defaulter_select_choice' => 'required',
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }
            $primary_id = $request->defaulter_primary_id_selected;


             $drc_assgin = DefalterRiderReassignRequest::find($primary_id);




              $defaulter_rider_id = $drc_assgin->defaulter_rider_id;




             $defaulter_rider = DefalterRiderReassignRequest::where('defaulter_rider_id','=',$defaulter_rider_id)
                                                             ->where('approval_status','=','0')->first();
             $defaulter_rider->approval_status =   $request->defaulter_select_choice;
             $defaulter_rider->save();

             if($request->defaulter_select_choice=="1"){
//                             assign to dc defaulter specific rider

                 $drc_defaulter =  DefaulterRiderDrcAssign::where('defaulter_rider_id','=',$defaulter_rider_id)
                                            //  ->where('approval_status','=','0')
                                             ->where('is_defaulter_now','=','0')
                                             ->orderby('id','desc')->first();

                  $drc_defaulter->is_defaulter_now  = "1";
                  $drc_defaulter->approval_status  = "1";
                  $drc_defaulter->update();



                 $defaulter_rider = DefalterRiderReassignRequest::find($primary_id);

                 $assign_platform = $defaulter_rider->defaulter_rider->passport->assign_platforms_checkin();

                  $already_assign_dc = AssignToDc::where('rider_passport_id','=',$defaulter_rider->defaulter_rider->passport->id)
                            ->where('status','=','1')->first();
                  $already_assign_dc->status = "0";
                  $already_assign_dc->update();

                    $assign_to_dc = new AssignToDc();
                    $assign_to_dc->rider_passport_id =  $defaulter_rider->defaulter_rider->passport->id;
                    $assign_to_dc->user_id =  $defaulter_rider->requested_to_dc_id;
                    $assign_to_dc->platform_id =  $assign_platform->plateform;
                    $assign_to_dc->checkin =   $assign_platform->checkin;
                    $assign_to_dc->status =  "1";
                    $assign_to_dc->save();
             }

            $message = [
                'message' => "Dc has been assigned successfully",
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);

        }catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            // dd($e);
            return redirect()->back()->with($message);
        }


    }


    public function get_dc_to_accept_rider_table(Request $request){

            if($request->ajax()){
                $status = $request->status;

                $user = Auth::user();
                if($user->hasRole('Admin')){
                    $riders = RiderHoldDC::where('request_status','=',$status)->get();

                }else{
                    $riders =  RiderHoldDC::where('dc_id','=',$user->id)->where('request_status','=',$status)->get();
                }

                $view = view('admin-panel.dc.get_dc_to_accept_rider_table',compact('status',"riders"))->render();
                return response(['html' => $view]);

            }

    }


    public function get_dc_to_accept_rider_for_defautler_table(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->status;

            $now_pass_status = "";
            if($status=="4"){
                $now_pass_status = "0";
            }elseif($status=="5"){
                $now_pass_status = "1";
            }elseif($status=="6"){
                $now_pass_status = "2";
            }



            $user = Auth::user();
            if($user->hasRole('Admin')){

                $users = User::where('designation_type','=','3')->get();
                $all_dc_drc_m = $users->filter(function($user){
                    return $user->hasAnyRole(['Defaulter Rider Co-ordinator', 'Defaulter Rider Co-ordinator Manager']);
                })->pluck('id')->toArray();


            $riders = RiderHoldDC::where('request_status','=',$now_pass_status)->WhereNotIn('dc_id',$all_dc_drc_m)->get();
            $defaulder_rider = RiderHoldDC::where('request_status','=',$now_pass_status)->WhereIn('dc_id',$all_dc_drc_m)->get();
            $defaulter_riders_pending = DefalterRiderReassignRequest::where('approval_status','=','0')->get();

            }elseif($user->hasRole('Defaulter Rider Co-ordinator')){

                $users = User::where('designation_type','=','3')->get();
                $all_dc_drc_m = $users->filter(function($user){
                    return $user->hasAnyRole(['Defaulter Rider Co-ordinator', 'Defaulter Rider Co-ordinator Manager']);
                })->pluck('id')->toArray();

                $defaulder_rider = RiderHoldDC::where('dc_id','=',$user->id)->where('request_status','=',$now_pass_status)->get();
                $riders = RiderHoldDC::where('request_status','=',$now_pass_status)->where('dc_id','=',$user->id)->WhereNotIn('dc_id',$all_dc_drc_m)->get();


            }else{

                $users = User::where('designation_type','=','3')->get();
                $all_dc_drc_m = $users->filter(function($user){
                    return $user->hasAnyRole(['Defaulter Rider Co-ordinator', 'Defaulter Rider Co-ordinator Manager']);
                })->pluck('id')->toArray();

                $riders = RiderHoldDC::where('dc_id','=',$user->id)->where('request_status','=',$now_pass_status)->WhereNotIn('dc_id',$all_dc_drc_m)->get();
                $defaulder_rider = RiderHoldDC::where('dc_id','=',$user->id)->WhereIn('dc_id',$all_dc_drc_m)->where('request_status','=',$now_pass_status)->get();

                $defaulter_riders_pending = DefalterRiderReassignRequest::where('requested_to_dc_id','=',$user->id)
                                                                    ->where('approval_status','=','0')->get();
            }





            // if($user->hasRole('Admin')){

            //  $defaulter_riders_pending = DefalterRiderReassignRequest::where('approval_status','=',$now_pass_status)->get();
            //     }else{

            //     $defaulter_riders_pending = DefalterRiderReassignRequest::where('requested_to_dc_id','=',$user->id)
            //                                                         ->where('approval_status','=',$now_pass_status)->get();
            //   }

              $view = view('admin-panel.dc.get_dc_defaulter_rider_table',compact('now_pass_status',"defaulder_rider"))->render();
              return response(['html' => $view]);



    }
}



    public function checkin_request_for_teamleader(){


        $user = Auth::user();

        $user_platforms =  $user->user_platform_id;

        if($user->hasRole('Admin')){

            $request_pending = DcRequestForCheckin::where('request_status','=','0')->get();
            $request_rejected = DcRequestForCheckin::where('request_status','=','2')->get();
            $request_accepted = DcRequestForCheckin::where('request_status','=','1')->get();

        }else{

            if($user->hasRole('Defaulter Rider Co-ordinator Manager')){

                $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::where('drcm_id','=',$user->id)
            ->where('is_defaulter_now','=','0')
            ->pluck('defaulter_rider_id')->toArray();

            }else{

                $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::
              where('is_defaulter_now','=','0')
            ->pluck('defaulter_rider_id')->toArray();

            }



            $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                ->pluck('passport_id')->toArray();


            $request_pending = DcRequestForCheckin::where('request_status','=','0')->whereIn('platform_id',$user_platforms)->whereNotIn('rider_passport_id',$passport_ids)->get();
            $request_rejected = DcRequestForCheckin::where('request_status','=','2')->whereIn('platform_id',$user_platforms)->whereNotIn('rider_passport_id',$passport_ids)->get();
            $request_accepted = DcRequestForCheckin::where('request_status','=','1')->whereIn('platform_id',$user_platforms)->whereNotIn('rider_passport_id',$passport_ids)->get();

        }


        $visa_type_array = ['N/A','Visit Visa','Cancel Visa','Own Visa'];
        $checkout_type_array = get_checkout_type_names();
        $status_array =  array('Pending','Accepted','Rejected');

        return view('admin-panel.dc.checkin_request_for_teamleader',compact('visa_type_array','request_accepted','request_rejected','request_pending','checkout_type_array','status_array'));
    }


    public function get_checkin_request_render(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->request_type;
            $user_platforms =  $user->user_platform_id;

            if($user->hasRole('Admin')){
                $requests = DcRequestForCheckin::where('request_status','=',$request->request_type)->get();
            }else{


                if($user->hasRole('Defaulter Rider Co-ordinator Manager')){

                    $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::where('drcm_id','=',$user->id)
                ->where('is_defaulter_now','=','0')
                ->pluck('defaulter_rider_id')->toArray();

                }else{

                    $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::
                  where('is_defaulter_now','=','0')
                ->pluck('defaulter_rider_id')->toArray();

                }

            $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                ->pluck('passport_id')->toArray();

                $requests = DcRequestForCheckin::where('request_status','=',$request->request_type)->whereIn('platform_id',$user_platforms)->whereNotIn('rider_passport_id',$passport_ids)->get();
            }

            $checkout_type_array = get_checkout_type_names();
            $status_array =  array('Pending','Accepted','Rejected');

            $status = $request->request_type;

            $visa_type_array = ['N/A','Visit Visa','Cancel Visa','Own Visa'];

           $view = view('admin-panel.dc.checkin_requests_render',compact('visa_type_array','status','requests','checkout_type_array','status_array'))->render();

            return response()->json(['html'=>$view]);
        }

    }


    public function checkin_request_for_defaulter_manager(){

        $user = Auth::user();

        $user_platforms =  $user->user_platform_id;

        if($user->hasRole('Admin')){

            $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::pluck('defaulter_rider_id')->toArray();

            $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                                            ->pluck('passport_id')->toArray();

            $request_pending = DcRequestForCheckin::where('request_status','=','0')->whereIn('rider_passport_id',$passport_ids)->get();
            $request_rejected = DcRequestForCheckin::where('request_status','=','2')->whereIn('rider_passport_id',$passport_ids)->get();
            $request_accepted = DcRequestForCheckin::where('request_status','=','1')->whereIn('rider_passport_id',$passport_ids)->get();

        }else{

            $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::where('drcm_id','=',$user->id)
                                            ->pluck('defaulter_rider_id')->toArray();

            $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                                            ->pluck('passport_id')->toArray();

            $request_pending = DcRequestForCheckin::where('request_status','=','0')->whereIn('rider_passport_id',$passport_ids)->get();
            $request_rejected = DcRequestForCheckin::where('request_status','=','2')->whereIn('rider_passport_id',$passport_ids)->get();
            $request_accepted = DcRequestForCheckin::where('request_status','=','1')->whereIn('rider_passport_id',$passport_ids)->get();

        }


        $visa_type_array = ['N/A','Visit Visa','Cancel Visa','Own Visa'];
        $checkout_type_array = get_checkout_type_names();
        $status_array =  array('Pending','Accepted','Rejected');

        return view('admin-panel.dc.defaulter_checkin_request_manger',compact('visa_type_array','request_accepted','request_rejected','request_pending','checkout_type_array','status_array'));


    }

    public function get_checkin_request_render_defaulter_manager(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->request_type;
            $user_platforms =  $user->user_platform_id;

            if($user->hasRole('Admin')){

                $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::pluck('defaulter_rider_id')->toArray();

                $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                                                ->pluck('passport_id')->toArray();

                $requests = DcRequestForCheckin::where('request_status','=',$request->request_type)->whereIn('rider_passport_id',$passport_ids)->get();
            }else{

                $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::where('drcm_id','=',$user->id)
                                            ->pluck('defaulter_rider_id')->toArray();

            $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                                            ->pluck('passport_id')->toArray();

                $requests = DcRequestForCheckin::where('request_status','=',$request->request_type)->whereIn('rider_passport_id',$passport_ids)->get();
            }

            $checkout_type_array = get_checkout_type_names();
            $status_array =  array('Pending','Accepted','Rejected');

            $status = $request->request_type;

            $visa_type_array = ['N/A','Visit Visa','Cancel Visa','Own Visa'];

           $view = view('admin-panel.dc.checkin_requests_render',compact('visa_type_array','status','requests','checkout_type_array','status_array'))->render();

            return response()->json(['html'=>$view]);
        }

    }





    public function get_checkin_request_render_for_dc(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->request_type;
            $user_platforms =  $user->user_platform_id;

            if($user->hasRole('Admin')){
                $requests = DcRequestForCheckin::where('request_status','=',$request->request_type)->get();
            }else{
                $requests = DcRequestForCheckin::where('request_status','=',$request->request_type)->where('request_by_id','=',$user->id)->get();
            }

            $checkout_type_array = get_checkout_type_names();
            $status_array =  array('Pending','Accepted','Rejected');

            $status = $request->request_type;

           $view = view('admin-panel.dc.checkin_requests_render_for_dc',compact('status','requests','checkout_type_array','status_array'))->render();

            return response()->json(['html'=>$view]);
        }

    }

    public function dc_request_for_checkin_save(Request $request){
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                'checkin_primary_id' => 'required',
//                'platform_id' => 'required',
                'city_id' => 'required',
                'checking_date' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }
            $passport_id =0 ;
            $onboard = OnBoardStatus::find($request->checkin_primary_id);
            if($onboard->career_id=="0"){
                $passport_id = $onboard->passport_id;
            }else{
                $passport_id = $onboard->career_detail->passport_ppuid->id;
            }
             $is_driving_licence = DrivingLicense::where('passport_id','=',$passport_id)->first();
            //for expo 2020 we are hiring rider without licence
                // if($is_driving_licence == null){
                //     $message = [
                //         'message' => "Driving Licence is not exist.!",
                //         'alert-type' => 'error',
                //     ];
                //     return redirect()->back()->with($message);
            // }


            $already_exist = DcRequestForCheckin::where('rider_passport_id','=',$passport_id)->where('request_status','=',0)->first();

            if($already_exist != null){
                $message = [
                    'message' => "Request is already in pending for this rider",
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);
            }




            $obj_assign = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

            if($obj_assign!=null){
                $message = [
                    'message' => "Rider is already Checkin",
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);
            }

            $rider_have_own_sim_and_bike = 0;

            if(isset($request->rider_bike) && isset($request->rider_sim)){
                $rider_have_own_sim_and_bike = 3;
            }elseif(isset($request->rider_bike)){
                $rider_have_own_sim_and_bike = 1;
            }elseif(isset($request->rider_sim)){
                $rider_have_own_sim_and_bike = 2;
            }

            $platformcode_allow_check = Platform::where('id','=',$request->platform_id)->first();

            if($platformcode_allow_check->need_platform_code=="1"){

                if(isset($request->platform_code)){

                    // $validator = Validator::make($request->all(), [//
                        //     'platform_code' => 'unique:platform_codes,platform_code,'
                        // ]);

                        // if($validator->fails()){
                        //     $validate = $validator->errors();
                        //     $message = [
                        //         'message' => 'Platform code already exist',
                        //         'alert-type' => 'error',
                        //         'error' => $validate->first()
                        //     ];
                        //     return redirect()->back()->with($message);
                    // }

                    $is_already_code = PlatformCode::wherePlatformCode($request->platform_code)
                        // ->where('passport_id','=',$passport_id)
                        ->where('platform_id','=',$request->platform_id)
                        ->first();
                    if($is_already_code != null){
                        $message = [
                            'message' => 'Platform code already exist for this platform',
                            'alert-type' => 'error',
                        ];
                        return redirect()->back()->with($message);
                    }
                    $obj = new PlatformCode();
                    $obj->passport_id = $passport_id;
                    $obj->platform_id = $request->platform_id;
                    $obj->platform_code =  $request->platform_code;
                    $obj->save();
                }
            }




            $dcrequest = new DcRequestForCheckin();
            $dcrequest->request_by_id = Auth::user()->id;
            $dcrequest->rider_passport_id = $passport_id;
            $dcrequest->checkin_date_time = $request->checking_date;
            $dcrequest->rider_have_own_sim_and_bike = $rider_have_own_sim_and_bike;
            $dcrequest->remarks = $request->remarks;
            $dcrequest->platform_id = isset($onboard->career_batch_detail->batch_info->platform_id) ? $onboard->career_batch_detail->batch_info->platform_id : $request->platform_id;
            $dcrequest->city_id = $request->city_id;
            $dcrequest->save();

            $message = [
                'message' => "Request is submitted successfully",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


    }

    public function after_accept_reject_send_onboard(Request $request){



            try {
                $validator = Validator::make($request->all(), [
                    'primary_id' => 'required',
                    'request_type' => 'required',
                ]);

                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message_error = "";
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->back()->with($message);
                }
                $time_stamp = Carbon::now()->toDateTimeString();
                $primary_id = $request->primary_id;
                $status  = 0;
                if($request->request_type=="1"){  //onboard

                    $status = 1;
                    $dc_request = DcRequestForCheckout::find($primary_id);
                    $dc_request->is_action_approve_status_id = $status;

                    // dd($dc_request->rider_passport_id);

                         $onboard = new OnBoardStatus();
                         $onboard->passport_id = $dc_request->rider_passport_id;
                         $onboard->interview_status = "1";
                         $onboard->assign_platform = 1;
                         $onboard->on_board = 1;
                         $onboard->save();


                    $dc_request->update();


                    $is_rejoin = RejoinCareer::where('passport_id','=',$dc_request->rider_passport_id)
                                               ->where('hire_status','=','0')->orderby('id','desc')->first();

                    if($is_rejoin!=null){
                        $is_rejoin->on_board = "1";
                        $data =  json_decode($is_rejoin->history_status,true);
                        array_push($data, ['10' => $time_stamp]);
                        $is_rejoin->history_status = json_encode($data);
                        $is_rejoin->update();
                    }else{
                        $array_new = array(['10' => $time_stamp]);
                        $rejoin = new RejoinCareer();
                        $rejoin->passport_id = $dc_request->rider_passport_id;
                        $rejoin->history_status = json_encode($array_new);
                        $rejoin->on_board = 1;
                        $rejoin->save();
                    }





                }elseif($request->request_type=="2"){ //wait list
                    $status  = 5;


                    $dc_request = DcRequestForCheckout::where('id','=',$primary_id)->first();
                    $dc_request->is_action_approve_status_id = $status;
                    $dc_request->update();




                    $is_rejoin = RejoinCareer::where('passport_id','=',$dc_request->rider_passport_id)->where('hire_status','=','0')->first();

                    if($is_rejoin!=null){

                        $is_rejoin->applicant_status = "5";
                        $data =  json_decode($is_rejoin->history_status,true);
                         array_push($data, ['1' => $time_stamp]);
                        $is_rejoin->history_status = json_encode($data);
                        $is_rejoin->update();
                    }else{

                        $rejoin = new RejoinCareer();
                        $rejoin->passport_id = $dc_request->rider_passport_id;
                        $is_ready_array  = array(['1' => $time_stamp]);
                        $rejoin->history_status = json_encode($is_ready_array);
                        $rejoin->applicant_status = 5;
                        $rejoin->save();
                    }

                }


                return "success";


        }catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'rider_passport_id' => 'required',
                'checkout_date' => 'required',
                'checkout_type' => 'required',
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            $accident_request = AccidentRiderRequest::where('rider_passport_id','=',$request->rider_passport_id)
                                 ->where('request_type','=','1')
                                 ->where('status','=','0')
                                ->first();

                 if($accident_request != null){

                    $message = [
                        'message' => "Accident Request already sent for thie rider.!",
                        'alert-type' => 'error',

                    ];
                    return redirect()->back()->with($message);

                 }

            //  $rejoin_array = RejoinCareer::where('passport_id','=',$request->rider_passport_id)->orderby('id','desc')->first();

            //         if($rejoin_array!=null){


            //                         if($rejoin_array->applicant_status=="5" && $rejoin_array->hire_status=="0"){
            //                             $message = [
            //                                 'message' => "This rirder in wait list.!",
            //                                 'alert-type' => 'error'
            //                             ];
            //                             return redirect()->back()->with($message);
            //                         }elseif($rejoin_array->applicant_status=="4" && $rejoin_array->hire_status=="0"){

            //                             $message = [
            //                                 'message' => "This rirder in selected.!",
            //                                 'alert-type' => 'error'
            //                             ];
            //                             return redirect()->back()->with($message);

            //                         }elseif($rejoin_array->applicant_status=="10" && $rejoin_array->hire_status=="0" ){

            //                             $message = [
            //                                 'message' => "Interview sent to this rider.!",
            //                                 'alert-type' => 'error'
            //                             ];
            //                             return redirect()->back()->with($message);

            //                         }elseif($rejoin_array->on_board=="1" && $rejoin_array->hire_status=="0" ){

            //                                 $message = [
            //                                     'message' => "This rirder in on board.!",
            //                                     'alert-type' => 'error'
            //                                 ];
            //                                 return redirect()->back()->with($message);

            //                         }
            //                   }

            //date 10-oct-2021
            //comment for rider inter issue end

            $already_exist = DcRequestForCheckout::where('rider_passport_id','=',$request->rider_passport_id)->where('request_status','=',0)->orderby('id','desc')->first();

            if($already_exist != null){

                $message = [
                    'message' => "Request is already in pending for this rider",
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);

            }
            if($request->checkout_type=="2" || $request->checkout_type=="1" || $request->checkout_type=="10" || $request->checkout_type=="11" )
            {

                $validator = Validator::make($request->all(), [
                    'expected_date' => 'required',
                ]);

                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->back()->with($message);
                }

            }



            $obj_assign = AssignPlateform::where('passport_id','=',$request->rider_passport_id)->where('status','=','1')->first();

            if($obj_assign==null){

                $message = [
                    'message' => "Rider is not checkin currently",
                    'alert-type' => 'error'

                ];
                return redirect()->back()->with($message);

            }

            $dcrequest = new DcRequestForCheckout();
            $dcrequest->request_by_id = Auth::user()->id;
            $dcrequest->rider_passport_id = $request->rider_passport_id;
            $dcrequest->checkout_type = $request->checkout_type;
            $dcrequest->checkout_date_time = $request->checkout_date;
            if($request->checkout_type=="2" || $request->checkout_type=="1" || $request->checkout_type=="10" || $request->checkout_type=="11" || $request->checkout_type=="6" || $request->checkout_type=="5")
            {
                $dcrequest->return_date = $request->expected_date;
            }

            if($request->checkout_type=="1")
            {
                $dcrequest->shuffle_type = $request->shuffle_type;
            }

            $dcrequest->remarks = $request->remarks;
            $dcrequest->assigned_platform_id = $obj_assign->id;
            $dcrequest->save();

            $message = [
                'message' => "Request is submitted successfully",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


    }

    public function send_to_direct_checkout_save(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'rider_passport_id' => 'required',
                'checkout_date' => 'required',
                'checkout_type' => 'required',
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            $already_exist = DcRequestForCheckout::where('rider_passport_id','=',$request->rider_passport_id)->where('request_status','=',0)->first();

            if($already_exist != null){

                $message = [
                    'message' => "Request is already in pending for this rider",
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);

            }
            if($request->checkout_type=="2" || $request->checkout_type=="1" || $request->checkout_type=="10" || $request->checkout_type=="11" || $request->checkout_type=="6" || $request->checkout_type=="5")
            {

                $validator = Validator::make($request->all(), [
                    'expected_date' => 'required',
                ]);

                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->back()->with($message);
                }

            }



            $obj_assign = AssignPlateform::where('passport_id','=',$request->rider_passport_id)->where('status','=','0')->orderby('id','desc')->first();

            $dcrequest = new DcRequestForCheckout();
            $dcrequest->request_by_id = Auth::user()->id;
            $dcrequest->rider_passport_id = $request->rider_passport_id;
            $dcrequest->checkout_type = $request->checkout_type;
            $dcrequest->checkout_date_time = $request->checkout_date;
            if($request->checkout_type=="2" || $request->checkout_type=="1" || $request->checkout_type=="10" || $request->checkout_type=="11" || $request->checkout_type=="6" || $request->checkout_type=="5")
            {
                $dcrequest->return_date = $request->expected_date;
            }

            if($request->checkout_type=="1")
            {
                $dcrequest->shuffle_type = $request->shuffle_type;
            }

            $dcrequest->remarks = $request->remarks;
            $dcrequest->assigned_platform_id = $obj_assign->id;
            $dcrequest->send_direct_checkout = 1;
            $dcrequest->request_status = 1;
            $dcrequest->approve_by_id = Auth::user()->id;
            $dcrequest->save();

            $message = [
                'message' => "Request is submitted successfully",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


    }



    public function request_for_teamleader(){

        $user_id = Auth::user()->id;
        $user = Auth::user();


        if($user->hasRole('Admin')){
        $requests = DcRequestForCheckout::where('request_status','=','0')->get();
        $accepted = DcRequestForCheckout::where('request_status','=','1')->get();
        $rejected = DcRequestForCheckout::where('request_status','=','2')->get();

        $checkout_type_array = get_checkout_type_names();

        $status_array =  array('Pending','Accepted','Rejected');
        }else{

            $user_platforms =  $user->user_platform_id;
            $assign_platform_ids = AssignPlateform::whereIn('plateform',$user_platforms)->pluck('id')->toArray();



                if($user->hasRole('Defaulter Rider Co-ordinator Manager')){

                    $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::where('drcm_id','=',$user->id)
                ->where('is_defaulter_now','=','0')
                ->pluck('defaulter_rider_id')->toArray();

                }else{

                    $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::
                  where('is_defaulter_now','=','0')
                ->pluck('defaulter_rider_id')->toArray();

                }






            $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
            ->pluck('passport_id')->toArray();

            $requests = DcRequestForCheckout::where('request_status','=','0')->whereIn('assigned_platform_id',$assign_platform_ids)->whereNotIn('rider_passport_id',$passport_ids)->get();
            $accepted = DcRequestForCheckout::where('request_status','=','1')->whereIn('assigned_platform_id',$assign_platform_ids)->whereNotIn('rider_passport_id',$passport_ids)->get();
            $rejected = DcRequestForCheckout::where('request_status','=','2')->whereIn('assigned_platform_id',$assign_platform_ids)->whereNotIn('rider_passport_id',$passport_ids)->get();

            $checkout_type_array = get_checkout_type_names();

            $status_array =  array('Pending','Accepted','Rejected');

        }

        return view('admin-panel.dc.request_for_teamleader',compact('rejected','accepted','requests','checkout_type_array','status_array'));
    }

    public function request_for_checkout_defaulter_manager(){

        $user_id = Auth::user()->id;
        $user = Auth::user();


        if($user->hasRole('Admin')){

            $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::
            where('is_defaulter_now','=','0')
            ->pluck('defaulter_rider_id')->toArray();

            $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                ->pluck('passport_id')->toArray();



        $requests = DcRequestForCheckout::where('request_status','=','0')->whereIn('rider_passport_id',$passport_ids)->get();
        $accepted = DcRequestForCheckout::where('request_status','=','1')->whereIn('rider_passport_id',$passport_ids)->get();
        $rejected = DcRequestForCheckout::where('request_status','=','2')->whereIn('rider_passport_id',$passport_ids)->get();

        $checkout_type_array = get_checkout_type_names();

        $status_array =  array('Pending','Accepted','Rejected');
        }else{

            $user_platforms =  $user->user_platform_id;
            $assign_platform_ids = AssignPlateform::whereIn('plateform',$user_platforms)->pluck('id')->toArray();




                $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::where('drcm_id','=',$user->id)
                ->where('is_defaulter_now','=','0')
                ->pluck('defaulter_rider_id')->toArray();

                $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                    ->pluck('passport_id')->toArray();


            $requests = DcRequestForCheckout::where('request_status','=','0')->whereIn('assigned_platform_id',$assign_platform_ids)->whereIn('rider_passport_id',$passport_ids)->get();
            $accepted = DcRequestForCheckout::where('request_status','=','1')->whereIn('assigned_platform_id',$assign_platform_ids)->whereIn('rider_passport_id',$passport_ids)->get();
            $rejected = DcRequestForCheckout::where('request_status','=','2')->whereIn('assigned_platform_id',$assign_platform_ids)->whereIn('rider_passport_id',$passport_ids)->get();

            $checkout_type_array = get_checkout_type_names();

            $status_array =  array('Pending','Accepted','Rejected');

        }

        return view('admin-panel.dc.request_for_checkout_defaulter_manager',compact('rejected','accepted','requests','checkout_type_array','status_array'));
    }


    public function dc_sent_request_checkin(){

        $user = Auth::user();
        if($user->hasRole('Admin')){

            $requests = DcRequestForCheckin::where('request_status','=','0')->get();
            $accepted = DcRequestForCheckin::where('request_status','=','1')->get();
            $rejected = DcRequestForCheckin::where('request_status','=','2')->get();

        }else{
            $user_id = Auth::user()->id;
            $requests = DcRequestForCheckin::where('request_status','=','0')->where('request_by_id','=',$user_id)->get();
            $accepted = DcRequestForCheckin::where('request_status','=','1')->where('request_by_id','=',$user_id)->get();
            $rejected = DcRequestForCheckin::where('request_status','=','2')->where('request_by_id','=',$user_id)->get();
        }

        $checkout_type_array = get_checkout_type_names();

        $status_array =  array('Pending','Accepted','Rejected');

        return view('admin-panel.dc.dc_send_request_checkin',compact('rejected','accepted','requests','checkout_type_array','status_array'));


    }

    public function dc_sent_request_checkout(){
         $user = Auth::user();
        if($user->hasRole('Admin')){

            $requests = DcRequestForCheckout::where('request_status','=','0')->get();
            $accepted = DcRequestForCheckout::where('request_status','=','1')->get();
            $rejected = DcRequestForCheckout::where('request_status','=','2')->get();

        }else{
           $user_id = Auth::user()->id;
            $requests = DcRequestForCheckout::where('request_status','=','0')->where('request_by_id','=',$user_id)->get();
            $accepted = DcRequestForCheckout::where('request_status','=','1')->where('request_by_id','=',$user_id)->get();
            $rejected = DcRequestForCheckout::where('request_status','=','2')->where('request_by_id','=',$user_id)->get();
        }

        $checkout_type_array = get_checkout_type_names();

        $status_array =  array('Pending','Accepted','Rejected');

        return view('admin-panel.dc.dc_send_request_checkout',compact('rejected','accepted','requests','checkout_type_array','status_array'));
    }



    public function  get_checkout_request_render(Request  $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->request_type;

            $defauter_array = DefaulterRiderDrcAssign::where('is_defaulter_now','=','0')
            ->where('status','=','1')
            ->pluck('defaulter_rider_id')->toArray();

            $passport_ids = DefaulterRider::whereIn('id',$defauter_array)
                ->pluck('passport_id')->toArray();

            if($user->hasRole('Admin')) {
                $requests = DcRequestForCheckout::where('request_status','=',$status)->get();
            }else{
                $user_platforms =  $user->user_platform_id;
                $assign_platform_ids = AssignPlateform::whereIn('plateform',$user_platforms)->pluck('id')->toArray();





                $requests = DcRequestForCheckout::where('request_status','=',$status)->whereIn('assigned_platform_id',$assign_platform_ids)->whereNotIn('rider_passport_id',$passport_ids)->get();

            }

            $checkout_type_array = get_checkout_type_names();

            $status_array =  array('Pending','Accepted','Rejected');

            $view =  view('admin-panel.dc.get_checkout_request_render',compact('status','requests','checkout_type_array','status_array'))->render();
            return response()->json(['html'=>$view]);
        }

    }

    public function get_checkout_request_render_defaulter_manager(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->request_type;



            if($user->hasRole('Admin')) {

                $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::
                where('is_defaulter_now','=','0')
                ->pluck('defaulter_rider_id')->toArray();

                $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                    ->pluck('passport_id')->toArray();

                $requests = DcRequestForCheckout::where('request_status','=',$status)->whereIn('rider_passport_id',$passport_ids)->get();
            }else{

                $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::where('drcm_id','=',$user->id)
                ->where('is_defaulter_now','=','0')
                ->pluck('defaulter_rider_id')->toArray();

                $passport_ids = DefaulterRider::whereIn('id',$defaulter_requests_sent_to_DRC)
                    ->pluck('passport_id')->toArray();


                $user_platforms =  $user->user_platform_id;
                $assign_platform_ids = AssignPlateform::whereIn('plateform',$user_platforms)->pluck('id')->toArray();
                $requests = DcRequestForCheckout::where('request_status','=',$status)->whereIn('assigned_platform_id',$assign_platform_ids)->whereIn('rider_passport_id',$passport_ids)->get();

            }

            $checkout_type_array = get_checkout_type_names();

            $status_array =  array('Pending','Accepted','Rejected');

            $view =  view('admin-panel.dc.get_checkout_request_render',compact('status','requests','checkout_type_array','status_array'))->render();
            return response()->json(['html'=>$view]);
        }

    }

    public function get_defaulter_checkout_request_render(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->request_type;



            if($user->hasRole('Admin')) {
                $defauter_array = DefaulterRiderDrcAssign::where('is_defaulter_now','=','0')
                ->where('status','=','1')
                ->pluck('defaulter_rider_id')->toArray();

                $passport_ids = DefaulterRider::whereIn('id',$defauter_array)
                    ->pluck('passport_id')->toArray();
                $requests = DcRequestForCheckout::where('request_status','=',$status)->whereIn('rider_passport_id',$passport_ids)->get();
            }else{

                $defauter_array = DefaulterRiderDrcAssign::where('is_defaulter_now','=','0')
                ->where('status','=','1')
                ->where('drcm_id','=',$user->id)
                ->pluck('defaulter_rider_id')->toArray();

                $passport_ids = DefaulterRider::whereIn('id',$defauter_array)
                    ->pluck('passport_id')->toArray();


                $user_platforms =  $user->user_platform_id;
                $assign_platform_ids = AssignPlateform::whereIn('plateform',$user_platforms)->pluck('id')->toArray();


                $requests = DcRequestForCheckout::where('request_status','=',$status)
                ->whereIn('assigned_platform_id',$assign_platform_ids)
                ->whereIn('rider_passport_id',$passport_ids)
                ->get();

            }

            $checkout_type_array = get_checkout_type_names();

            $status_array =  array('Pending','Accepted','Rejected');

            $view =  view('admin-panel.dc.get_checkout_request_render',compact('status','requests','checkout_type_array','status_array'))->render();
            return response()->json(['html'=>$view]);
        }


    }


    public function get_checkout_request_render_for_dc(Request $request){

        if($request->ajax()){
            $user = Auth::user();
            $status = $request->request_type;
            if($user->hasRole('Admin')) {

                $requests = DcRequestForCheckout::where('request_status','=',$status)->get();
            }else{

                $requests = DcRequestForCheckout::where('request_status','=',$status)->where('request_by_id','=',$user->id)->get();

            }


            $checkout_type_array = get_checkout_type_names();
            $status_array =  array('Pending','Accepted','Rejected');

            $view =  view('admin-panel.dc.get_checkout_request_render_dc',compact('status','requests','checkout_type_array','status_array'))->render();
            return response()->json(['html'=>$view]);
        }


    }

    public function checkout_type_report(){

        $platforms = Platform::all();

        return view('admin-panel.dc.checkout_type_report',compact('platforms'));

    }

    public function autocomplete_checkout_type_report(Request $request){


        // $checkout_requests = DcRequestForCheckout::where('checkout_type','=','1')->where('request_status','!=','0')->get();

        $all_dc_request_checkout_passports = DcRequestForCheckout::where('request_status','!=','0')
        ->where('is_action_approve_status_id','=','0')->pluck('rider_passport_id')->toArray();



        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn('passports.id',$all_dc_request_checkout_passports)
            ->get();

        if (count($passport_data)=='0')
        {
            // return "pp";
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereIn('passports.id',$all_dc_request_checkout_passports)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->whereIn('passports.id',$all_dc_request_checkout_passports)
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->whereIn('passports.id',$all_dc_request_checkout_passports)
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->get();

                    //zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => isset($pass->zds_code) ? $pass->zds_code : '',
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
                        'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
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
                    'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
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
                'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }

    public function get_autocomplete_detail_checkout_report(Request $request){

        if($request->ajax()){

            $searach = '%'.$request->passport_id.'%';
            $passport = Passport::where('passport_no', 'like', $searach)->first();

            $checkout_type_array = get_checkout_type_names();

            $passport_id = $passport->id;

            $dc_request_result =  DcRequestForCheckout::where('request_status','!=','0')
            ->where('rider_passport_id','=',$passport_id)
            ->where('is_action_approve_status_id','=','0')->first();

            $status_array = array('','Accepted','Rejected');

            $view = view("admin-panel.dc.checkout_report_type_search_result",compact('dc_request_result','checkout_type_array','status_array'))->render();

            return response()->json(['html'=>$view]);


        }




    }



    public function get_checkout_report_by_platform(Request $request){

        if($request->ajax()){
            $id = $request->id_primary;

             $assigng_platform_ids = AssignPlateform::where('plateform',$id)->pluck('id')->toArray();

            $checkout_type_array = get_checkout_type_names();

            $status_array = array('','Accepted','Rejected');

            if($id=="all"){

                $checkout_requests = DcRequestForCheckout::where('checkout_type','=','1')->where('request_status','!=','0')->where('is_action_approve_status_id','=',0)->get();

                $all_dc_request_checkouts = DcRequestForCheckout::where('request_status','!=','0')->where('is_action_approve_status_id','=',0)->get();

            }else{

                $checkout_requests = DcRequestForCheckout::where('checkout_type','=','1')->where('request_status','!=','0')->where('is_action_approve_status_id','=',0)->whereIn('assigned_platform_id',$assigng_platform_ids)->get();

                $all_dc_request_checkouts = DcRequestForCheckout::where('request_status','!=','0')->where('is_action_approve_status_id','=',0)->whereIn('assigned_platform_id',$assigng_platform_ids)->get();

            }



                $view = view("admin-panel.dc.checkout_report_type_render",compact('status_array','checkout_type_array','checkout_requests','all_dc_request_checkouts'))->render();

            return response()->json(['html'=>$view]);
        }
    }

    public function get_checkout_report_type_ajax(Request $request){


        if($request->ajax()){

            $tab_name = $request->tab_name;
            $platform_id = $request->platform_id;

            $assigng_platform_ids = AssignPlateform::where('plateform',$platform_id)->pluck('id')->toArray();

            $checkout_type_array = get_checkout_type_names();

             $tab_index =  $tab_name;

             if($platform_id=="all"){
                 $checkout_requests = DcRequestForCheckout::where('checkout_type','=',$tab_index)->where('request_status','!=','0')->where('is_action_approve_status_id','=',0)->get();
             }else{
                 $checkout_requests = DcRequestForCheckout::where('checkout_type','=',$tab_index)->where('request_status','!=','0')->where('is_action_approve_status_id','=',0)->whereIn('assigned_platform_id',$assigng_platform_ids)->get();
             }


        }

        $status_array = array('','Accepted','Rejected');

        $view = view('admin-panel.dc.report_ajax_checkout', compact('status_array','checkout_requests','checkout_type_array'))->render();
        return response(['html' => $view]);

    }

    public function get_request_ajax(Request $request){

        if($request->ajax()){
            $id = $request->id_primary;

            $request_dc = DcRequestForCheckout::where('id',$id)->first();

            $checkout_type_array = get_checkout_type_names();

            $status_array =  array('Pending','Accepted','Rejected');

            $passport = Passport::where('id', '=', $request_dc->rider_passport_id)->first();

            if(isset($request->form_request)){
                $view = view("admin-panel.dc.ajax_checkout_type_request",compact('passport','request_dc','status_array','checkout_type_array'))->render();
            }else{
                $view = view("admin-panel.dc.ajax_request",compact('passport','request_dc','status_array','checkout_type_array'))->render();
            }
            return response()->json(['html'=>$view]);
        }

    }

    public function get_checkin_request_ajax(Request $request){
        if($request->ajax()){

            $id = $request->id_primary;
            $request_dc = DcRequestForCheckin::where('id',$id)->first();
            $four_pl_name = "";
            $visa_type = "";
            $passport_id = $request_dc->rider_passport_id;
            $passport_detail = Passport::find($passport_id);
            if($passport_detail->career_id!="0"){
                $career_detail = Career::find($passport_detail->career_id);
                if($career_detail != null){
                    if($career_detail->employee_type=="2"){
                        if(isset($career_detail->vendor_fourpl_detail)){
                        $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                            $is_working = $career_detail->vendor_fourpl_detail;

                        }else{
                        $four_pl_name = "N/A";
                        }


                         $visa_type =  $is_working->cancel_status=="1" ? "Company" : "Four PL";


                    }
                }else{
                    $visa_type = "Company";
                }
            }else{
                $visa_type = "Company";
            }
            $status_array =  array('Pending','Accepted','Rejected');
            $platforms = Platform::all();
            $cities = Cities::all();
            $defaulter_ids = DefaulterRider::where('passport_id','=',$request_dc->rider_passport_id)->pluck('id')->toArray();
            $defaulter_now =  null;
            if(count($defaulter_ids)>0){
                 $defaulter_now = DefaulterRiderDrcAssign::whereIn('defaulter_rider_id',$defaulter_ids)->where('is_defaulter_now','=','0')->first();
            }
            if($defaulter_now != null){
                $users = User::where('designation_type','=','3')
                ->where('user_platform_id','LIKE','%'.$request_dc->platform_id.'%')
                ->with('roles')->get();

                $all_dc = $users->filter(function($user){
                    return $user->hasRole(['Defaulter Rider Co-ordinator']);
                });
            }else{

                $users = User::where('designation_type','=','3')->get();
                $all_dc_drc_m = $users->filter(function($user){
                    return $user->hasAnyRole(['Defaulter Rider Co-ordinator', 'Defaulter Rider Co-ordinator Manager']);
                })->pluck('id')->toArray();


                $all_dc = User::where('designation_type','=','3')->whereNotIn('id',$all_dc_drc_m)->where('user_platform_id','LIKE','%'.$request_dc->platform_id.'%')->get();

            }
            $view = view("admin-panel.dc.ajax_checkin_request_detail",compact('all_dc','cities','platforms','request_dc','status_array','four_pl_name','visa_type'))->render();
            return response()->json(['html'=>$view]);
        }
    }

    public function get_checkin_request_ajax_defaulter_manager(Request $request){

        if($request->ajax()){
            $id = $request->id_primary;

            $request_dc = DcRequestForCheckin::where('id',$id)->first();

            $status_array =  array('Pending','Accepted','Rejected');


            $platforms = Platform::all();
            $cities = Cities::all();

            $users = User::where('designation_type','=','3')
            ->where('user_platform_id','LIKE','%'.$request_dc->platform_id.'%')
            ->with('roles')->get();

            $all_dc = $users->filter(function($user){
                return $user->hasRole(['Defaulter Rider Co-ordinator']);
            });
            // $all_dc = User::where('designation_type','=','3')->where('user_platform_id','LIKE','%'.$request_dc->platform_id.'%')->get();



                $view = view("admin-panel.dc.ajax_checkout_request_defaulter_manger",compact('all_dc','cities','platforms','request_dc','status_array'))->render();

            return response()->json(['html'=>$view]);
        }

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

        try{
             $validator = Validator::make($request->all(), [
                 'checkout_date' => 'required',
                 'checkout_type' => 'required',
                 'request_type' => 'required',
                 'primary_id' => 'required',
             ]);

            if ($validator->fails()) {
                $validate = $validator->errors();

                return $validate->first();
            }

            if($request->checkout_type=="2" || $request->checkout_type=="1" || $request->checkout_type=="10" || $request->checkout_type=="11" || $request->checkout_type=="6" || $request->checkout_type=="5")
            {


                $validator = Validator::make($request->all(), [
                    'expected_date' => 'required',
                ]);

                if ($validator->fails()) {
                    $validate = $validator->errors();

                    return $validate->first();
                }
            }



            if($request->request_type=="2"){

                $dc_request = DcRequestForCheckout::where('id',$id)->first();
                $dc_request->checkout_type = $request->checkout_type;
                $dc_request->checkout_date_time = $request->checkout_date;
                $dc_request->remarks = $request->remarks;
                $dc_request->request_status = 2;

                if($request->checkout_type=="2" || $request->checkout_type=="1" || $request->checkout_type=="10" || $request->checkout_type=="11" || $request->checkout_type=="6" || $request->checkout_type=="5")
                {
                    $dc_request->return_date = $request->expected_date;
                }else{
                    $dc_request->return_date  = "";
                }

                if($request->checkout_type=="1")
                {
                    $dc_request->shuffle_type = $request->shuffle_type;
                }else{
                    $dc_request->shuffle_type  = "";
                }

                $dc_request->approve_by_id = Auth::user()->id;
                $dc_request->reject_reason = $request->reject_reason;
                $dc_request->update();

                return  "success";

            }else if($request->request_type=="1"){



                $dc_request = DcRequestForCheckout::where('id',$id)->first();
                $dc_request->checkout_type = $request->checkout_type;
                $dc_request->checkout_date_time = $request->checkout_date;
                $dc_request->remarks = $request->remarks;

                if($request->checkout_type=="2" || $request->checkout_type=="1" || $request->checkout_type=="10" || $request->checkout_type=="11" || $request->checkout_type=="6" || $request->checkout_type=="5")
                {
                    $dc_request->return_date = $request->expected_date;
                }else{
                    $dc_request->return_date  = "";
                }


                if($request->checkout_type=="1")
                {
                    $dc_request->shuffle_type = $request->shuffle_type;
                }else{
                    $dc_request->shuffle_type  = "";
                }

                $dc_request->request_status = 1;
                $dc_request->approve_by_id = Auth::user()->id;


                $result = "";
                if($request->checkout_type=="1")
                {
                     if($request->shuffle_type=="1"){
                         $result = $this->checkout_method($request,$dc_request->rider_passport_id);
                     }else{
                         $result = "success";
                     }

                }else{
                    $result = $this->checkout_method($request,$dc_request->rider_passport_id);
                }




                //start to send direct on wait list
                if($result=="success"){

                    $dc_request->update();

                    $result = "";
                    if($request->checkout_type=="1" || $request->checkout_type=="3")
                    {

                        $time_stamp = Carbon::now()->toDateTimeString(); // send to wait list

                        $status  = 5;
                        $dc_request = DcRequestForCheckout::where('id','=',$id)->first();
                        $dc_request->is_action_approve_status_id = $status;
                        $dc_request->update();

                        $is_rejoin = RejoinCareer::where('passport_id','=',$dc_request->rider_passport_id)->where('hire_status','=','0')->first();

                        if($is_rejoin!=null){

                            $is_rejoin->applicant_status = "5";
                            $data =  json_decode($is_rejoin->history_status,true);
                            array_push($data, ['1' => $time_stamp]);
                            $is_rejoin->history_status = json_encode($data);
                            $is_rejoin->update();
                        }else{

                            $rejoin = new RejoinCareer();
                            $rejoin->passport_id = $dc_request->rider_passport_id;
                            $is_ready_array  = array(['1' => $time_stamp]);
                            $rejoin->history_status = json_encode($is_ready_array);
                            $rejoin->applicant_status = 5;
                            $rejoin->save();
                        }

                        return "success";
                    }




                    return "success";
                }else{
                    return $result;
                }
                //End to send direct on wait list




            }


        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return 'Error Occured';
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

    public function save_checkin_request(Request $request){

        $validator = Validator::make($request->all(), [
            'primary_id' => 'required',
            'request_type' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();

            return $validate->first();
        }
         $primary_id = $request->primary_id;
        $checkin_request = DcRequestForCheckin::find($primary_id);




        $passport_id = $checkin_request->rider_passport_id;

        if($request->request_type=="2"){

            $rider_have_own_sim_and_bike = 0;
            if(isset($request->rider_bike) && isset($request->rider_sim)){
                $rider_have_own_sim_and_bike = 3;
            }elseif(isset($request->rider_bike)){
                $rider_have_own_sim_and_bike = 1;
            }elseif(isset($request->rider_sim)){
                $rider_have_own_sim_and_bike = 2;
            }

            $checkin_request->request_status = $request->request_type;
            $checkin_request->remarks = $request->remarks;
            $checkin_request->reject_reason = $request->reject_reason;
            $checkin_request->approve_by_id = Auth::user()->id;
            $checkin_request->platform_id = $request->platform_id;
            $checkin_request->city_id = $request->city_id;
//            $checkin_request->dc_id = $request->to_dc_id;
            $checkin_request->checkin_date_time = $request->checkin_date;
            $checkin_request->rider_have_own_sim_and_bike = $rider_have_own_sim_and_bike;
            $checkin_request->update();

            return "success";

        }else{




         $result = $this->checkin_method($request,$passport_id);
         $assing_plataform_q = AssignPlateform::where('passport_id','=',$passport_id)
                             ->where('status','=','1')->orderby('id','desc')->first();
         $assing_primary_id = "";
         if($assing_plataform_q!=null){
             $assing_primary_id = $assing_plataform_q->id;
         }

         if($result=="success"){

             $rider_have_own_sim_and_bike = 0;
             if(isset($request->rider_bike) && isset($request->rider_sim)){
                 $rider_have_own_sim_and_bike = 3;
             }elseif(isset($request->rider_bike)){
                 $rider_have_own_sim_and_bike = 1;
             }elseif(isset($request->rider_sim)){
                 $rider_have_own_sim_and_bike = 2;
             }

             if(isset($request->pkg_id)){
                $package_assignment = new PackageAssignment();
                $package_assignment->user_id =  Auth::user()->id;
                $package_assignment->passport_id = $passport_id;
                $package_assignment->package_id = $request->pkg_id;
                $package_assignment->salary_package = 34300;
                $package_assignment->signed_file = "Pakistan Zindabad";
                $package_assignment->save();
             }

             $primar_id_checkin = $checkin_request->id;
             $checkin_request->request_status = $request->request_type;
             $checkin_request->remarks = $request->remarks;
             $checkin_request->approve_by_id = Auth::user()->id;
             $checkin_request->platform_id = $request->platform_id;
             $checkin_request->city_id = $request->city_id;
 //            $checkin_request->dc_id = $request->to_dc_id;
             $checkin_request->checkin_date_time = $request->checkin_date;
             $checkin_request->rider_have_own_sim_and_bike = $rider_have_own_sim_and_bike;
             $checkin_request->update();

             $riderhold_dc = new  RiderHoldDC();
             $riderhold_dc->dc_request_for_checkin_id =  $primar_id_checkin;
             $riderhold_dc->assign_platform_id =  $assing_primary_id;
             $riderhold_dc->dc_id =  $request->to_dc_id;
             $riderhold_dc->save();

             return "success";
         }else{

             return $result;
         }



        }


    }



    public function checkin_method($request, $passport_id){


        $agreement=Agreement::where('passport_id',$passport_id)->where('status','1')->first();
        $ppuid_cancel=Passport::where('id',$passport_id)->first();
        if($ppuid_cancel!=null){
            $ppuid_cancel_status=$ppuid_cancel->cancel_status;
            if ($ppuid_cancel_status=='1'){
                return "PPUID Cancelled, Platform Cannot Assinged";
            }
        }

        $platform_id=$request->platform_id;
        $new_on_board=$request->new_on_board;
        $platform_type_data=Platform::where('id',$platform_id)->first();
        $platform_type= $platform_type_data->platform_category;
        $validator = Validator::make($request->all(), [
            'platform_id' => 'required',
            'checkin_date' => 'required',
            'to_dc_id' => 'required',
            'city_id' => 'required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();

            return $validate->first();
        }
        $pass_id= $passport_id;



        $total_assigned = AssignToDc::where('status','=','1')->where('user_id','=',$request->to_dc_id)->where('platform_id','=',$request->platform_id)->count();
        $total_dc_limit = DcLimit::where('user_id','=',$request->to_dc_id)->first();
        $limit = $total_dc_limit->limit ? $total_dc_limit->limit : 0;
        $total_remain_rider =  $limit-$total_assigned;
        if($total_remain_rider < 1){

            return "Limit is completed, please select another DC";
        }
        $assigned_id=AssignPlateform::where('passport_id',$pass_id)->count();
        $checkout_detail=AssignPlateform::where('passport_id',$pass_id)->latest('created_at')->first();
        if ($assigned_id >= 1 &&  $checkout_detail->status =='1'){

            return 'Not Checked Out';
        }elseif($assigned_id >=1 &&  $checkout_detail->status =='0'){
            $obj = new AssignPlateform();
            $obj->passport_id = $pass_id;
            $obj->plateform = $request->input('platform_id');
            $obj->checkin = $request->input('checkin_date');
            $obj->city_id = $request->input('city_id');
            $obj->status ='1';
            $obj->save();
            if(isset($request->rider_bike)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "2";
                $own_bike_sim_obj->platform_id = $request->platform_id;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin_date;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            if(isset($request->rider_sim)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "1";
                $own_bike_sim_obj->platform_id = $request->platform_id;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin_date;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            // $career_id = Passport::where('id','=',$pass_id)->first();
            // if($career_id != null){
            //     $onboard = OnBoardStatus::where('career_id','=',$career_id->career_id)
            //     ->where('on_board','=',"1")
            //     ->where('interview_status','=',"1")
            //     ->where('assign_platform','=',"1")
            //     ->orderby('id','desc')->first();
            //     if($onboard != null){
            //         $onboard->on_board = '0';
            //         $onboard->interview_status = '0';
            //         $onboard->assign_platform = '0';
            //         $onboard->update();
            //     }
            // }else{

            //     $onboard_pass = OnBoardStatus::where('passport_id','=',$pass_id)
            //     ->where('on_board','=',"1")
            //     ->where('interview_status','=',"1")
            //     ->where('assign_platform','=',"1")
            //     ->orderby('id','desc')->first();
            //     if($onboard_pass != null){
            //         $onboard_pass->on_board = '0';
            //         $onboard_pass->interview_status = '0';
            //         $onboard_pass->assign_platform = '0';
            //         $onboard_pass->update();
            //     }

            // }

            $passport_detail=Passport::where('id',$pass_id)->first();
            $passport_no=$passport_detail->passport_no;
            $ref= Referal::where('passport_no','=',$passport_no)->first();
            $ref_set= ReferralSetting::first();
            if ($ref!=null){
                Referal::where('passport_no','=',$passport_no)->update(['status'=>'3','credit_amount'=>$ref_set->amount]);
            }
            $is_already = CategoryAssign::where('passport_id','=',$pass_id)->where('status','=','1')->first();
            if($is_already == null) {
                $obj = new CategoryAssign();
                $obj->passport_id = $pass_id;
                $obj->main_category = 2;
                $obj->sub_category1 = 1;
                $obj->sub_category2 = $request->work_type;
                $obj->assign_started_at = Carbon::now();
                $obj->status = 1;
                $obj->save();
            }
//            assign to dc specific rider
//            $assign_to_dc = new AssignToDc();
//            $assign_to_dc->rider_passport_id =  $pass_id;
//            $assign_to_dc->user_id =  $request->to_dc_id;
//            $assign_to_dc->platform_id =   $request->platform_id;
//            $assign_to_dc->checkin =   $request->checkin_date;
//            $assign_to_dc->status =  "1";
//            $assign_to_dc->save();

                        $career_id = Passport::where('id','=',$pass_id)->first();
                        if($career_id != null){
                            $onboard = OnBoardStatus::where('career_id','=',$career_id->career_id)
                            ->where('passport_id','=','0')
                            ->where('on_board','=',"1")
                            ->where('interview_status','=',"1")
                            ->where('assign_platform','=',"1")
                            ->orderby('id','desc')->first();
                            if($onboard != null){
                                $onboard->on_board = '0';
                                $onboard->interview_status = '0';
                                $onboard->assign_platform = '0';
                                $onboard->update();
                            }
                        }else{

                            $onboard_pass = OnBoardStatus::where('passport_id','=',$pass_id)
                            ->where('career_id','=','0')
                            ->where('on_board','=',"1")
                            ->where('interview_status','=',"1")
                            ->where('assign_platform','=',"1")
                            ->orderby('id','desc')->first();
                            if($onboard_pass != null){
                                $onboard_pass->on_board = '0';
                                $onboard_pass->interview_status = '0';
                                $onboard_pass->assign_platform = '0';
                                $onboard_pass->update();
                            }

                            $rejoin_career = RejoinCareer::where('passport_id','=',$pass_id)->where('on_board','=','1')->where('hire_status','=','0')->first();
                            $rejoin_career->hire_status = "1";
                            $rejoin_career->update();
                        }
            return 'success';
            exit;
        }else{
            $obj = new AssignPlateform();
            $obj->passport_id = $pass_id;
            $obj->plateform = $request->input('platform_id');
            $obj->checkin = $request->input('checkin_date');
            $obj->city_id = $request->input('city_id');
            $obj->status ='1';
            $obj->save();
            if(isset($request->rider_bike)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "2";
                $own_bike_sim_obj->platform_id = $request->platform_id;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin_date;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            if(isset($request->rider_sim)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "1";
                $own_bike_sim_obj->platform_id = $request->platform_id;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin_date;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            $passport_detail=Passport::where('id',$pass_id)->first();
            $passport_no=$passport_detail->passport_no;
            $ref= Referal::where('passport_no',$passport_no)->first();
            $ref_set= ReferralSetting::first();
            if ($ref!=null){
                Referal::where('passport_no','=',$passport_no)
                    ->update(['status'=>'3','credit_status'=>'1','credit_amount'=>$ref_set->amount]);
            }
            $is_already = CategoryAssign::where('passport_id','=',$pass_id)
                ->where('status','=','1')
                ->first();
            if($is_already == null) {
                $obj = new CategoryAssign();
                $obj->passport_id = $pass_id;
                $obj->main_category = 2;
                $obj->sub_category1 = 1;
                $obj->sub_category2 = $request->work_type;
                $obj->status = 1;
                $obj->save();
            }
//              assign to dc specific rider
//            $assign_to_dc = new AssignToDc();
//            $assign_to_dc->rider_passport_id =  $pass_id;
//            $assign_to_dc->user_id =  $request->to_dc_id;
//            $assign_to_dc->platform_id =   $request->platform_id;
//            $assign_to_dc->checkin =   $request->checkin_date;
//            $assign_to_dc->status =  "1";
//            $assign_to_dc->save();


                $career_id = Passport::where('id','=',$pass_id)->first();

                if($career_id != null){
                    $onboard = OnBoardStatus::where('career_id','=',$career_id->career_id)
                    ->where('on_board','=',"1")
                    ->where('interview_status','=',"1")
                    ->where('assign_platform','=',"1")
                    ->orderby('id','desc')->first();
                    if($onboard != null){
                        $onboard->on_board = '0';
                        $onboard->interview_status = '0';
                        $onboard->assign_platform = '0';
                        $onboard->update();
                    }
                }else{

                    $onboard_pass = OnBoardStatus::where('passport_id','=',$pass_id)
                    ->where('on_board','=',"1")
                    ->where('interview_status','=',"1")
                    ->where('assign_platform','=',"1")
                    ->orderby('id','desc')->first();
                    if($onboard_pass != null){
                        $onboard_pass->on_board = '0';
                        $onboard_pass->interview_status = '0';
                        $onboard_pass->assign_platform = '0';
                        $onboard_pass->update();
                    }
                    $rejoin_career = RejoinCareer::where('passport_id','=',$pass_id)->where('on_board','=','1')->where('hire_status','=','0')->first();
                    $rejoin_career->hire_status = "1";
                    $rejoin_career->update();


                }

            return "success";
            exit;
        }

    }

    public function checkout_method($request,$passport_id){

        try{

        $passport_id = $passport_id;

        // $driving_licence  = DrivingLicense::where('passport_id','=',$passport_id)->first();

        // if($driving_licence==null) {
        //     return "Driving license is not created, please create driving license";
        // }

        $assign_obj_ab = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        if($assign_obj_ab==null){

            return "Platform is not checkin, you can not checkout";
        }

        $is_platform_code = PlatformCode::where('passport_id','=',$passport_id)->where('platform_id','=',$assign_obj_ab->plateform)->first();

        // if($is_platform_code==null){
        //     return "platform code is not exist please enter the platform code";
        // }



        $id= $assign_obj_ab->id;

        $obj = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        $total_pending_amount = 0;
        $total_paid_amount= 0;

        $check_in_platform = $obj->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();
        $rider_id = $obj->passport->platform_codes->where('platform_id','=',$check_in_platform)->pluck(['platform_code'])->first();

        $user_passport_id = $obj->passport->id;


//        $amount =  CodUpload::where('rider_id','=',$rider_id)->where('platform_id','=',$check_in_platform)->selectRaw('sum(amount) as total')->first();
//        $paid_amount =  Cods::where('passport_id',$user_passport_id)->where('platform_id','=',$check_in_platform)->where('status','1')->selectRaw('sum(amount) as total')->first();
//        $adj_req_t =CodAdjustRequest::where('passport_id','=',$user_passport_id)->where('status','=','2')->selectRaw('sum(amount) as total')->first();
//
//        $salary_array = CloseMonth::where('passport_id','=',$obj->passport->id)->selectRaw('sum(close_month_amount) as total')->first();
//
//        if($adj_req_t != null){
//            $total_paid_amount = $total_paid_amount+$adj_req_t->total;
//        }
//
//        if(!empty($amount)){
//            $total_pending_amount = $amount->total;
//        }
//        if(!empty($paid_amount)){
//            $total_paid_amount = $paid_amount->total;
//        }
//
//        if(!empty($salary_array)){
//            $total_paid_amount = $total_paid_amount+$salary_array->total;
//        }


//        $previous_balance =  isset($obj->passport->previous_balance->amount) ? $obj->passport->previous_balance->amount : '0';
//
//        $now_amount = $total_pending_amount+$previous_balance;
//
//        $remain_amount =  $now_amount-$total_paid_amount;



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

    public function checkout_method_for_interview_pass($checkout_date,$remarks,$passport_id){

        try{

        $passport_id = $passport_id;
        $assign_obj_ab = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        if($assign_obj_ab==null){

            return "Platform is not checkin, you can not checkout";
        }


        $obj = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

            $obj->checkout=$checkout_date;
            $obj->remarks=$remarks;
            $obj->status='0';
            $obj->save();

            OwnSimBikeHistory::where('passport_id','=',$passport_id)
                ->where('status','=','1')
                ->update(array('status' => "0", 'checkout'=>$checkout_date));

            AssignToDc::where('rider_passport_id','=',$passport_id)
                ->where('status','=','1')
                ->update(array('status' => "0",'checkout'=>$checkout_date));

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
            return "Error Occured";
        }



    }



    public function autocomplete_checkin_platform(Request $request)
    {

        $user = Auth::user();

        if($user->hasRole('Admin')) {
            $checkin_passsports = AssignPlateform::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;
        }else{

             $dc_riders_array = AssignToDc::where('status','=','1')->where('user_id','=',$user->id)->pluck('rider_passport_id')->toArray();


            $checkin_passsports = AssignPlateform::where('status','=','1')->whereIn('passport_id',$dc_riders_array)->select('passport_id')->groupBy('passport_id')->get()->toArray() ;
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



    public function autocomplete_send_checkout_report(Request $request)
    {

        $checkin_passsports = AssignPlateform::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;

        $dc_request_checkout = DcRequestForCheckout::select('rider_passport_id')->groupBy('rider_passport_id')->pluck('rider_passport_id')->toArray();
        $old_platform_checkouts = AssignPlateform::where('status','=','0')->WhereNotIn('passport_id',$checkin_passsports)->select('passport_id')->groupBy('passport_id')->pluck('passport_id')->toArray();



        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn("passports.id",$old_platform_checkouts)
            ->whereNotIn("passports.id",$dc_request_checkout)
            ->where("passports.cancel_status",'=','0')
            ->get();

        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                 ->whereIn("passports.id",$old_platform_checkouts)
                ->whereNotIn("passports.id",$dc_request_checkout)
                ->where("passports.cancel_status",'=','0')
                ->get();

        }

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereIn("passports.id",$old_platform_checkouts)
                ->whereNotIn("passports.id",$dc_request_checkout)
                ->where("passports.cancel_status",'=','0')
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->whereIn("passports.id",$old_platform_checkouts)
                    ->whereNotIn("passports.id",$dc_request_checkout)
                    ->where("passports.cancel_status",'=','0')
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->whereIn("passports.id",$old_platform_checkouts)
                        ->whereNotIn("passports.id",$dc_request_checkout)
                        ->where("passports.cancel_status",'=','0')
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->whereIn("passports.id",$old_platform_checkouts)
                            ->whereNotIn("passports.id",$dc_request_checkout)
                            ->where("passports.cancel_status",'=','0')
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
                                ->whereIn("passports.id",$old_platform_checkouts)
                                ->whereNotIn("passports.id",$dc_request_checkout)
                                ->where("passports.cancel_status",'=','0')
                                ->get();
                            if (count($platform_code)=='0') {
                                $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->whereIn("passports.id",$old_platform_checkouts)
                                    ->whereNotIn("passports.id",$dc_request_checkout)
                                    ->where("passports.cancel_status",'=','0')
                                    ->get();
                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->whereIn("passports.id",$old_platform_checkouts)
                                        ->whereNotIn("passports.id",$dc_request_checkout)
                                        ->where("passports.cancel_status",'=','0')
                                        ->get();
                                    if (count($drive_lin_data) == '0') {
                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->whereIn("passports.id",$old_platform_checkouts)
                                            ->whereNotIn("passports.id",$dc_request_checkout)
                                            ->where("passports.cancel_status",'=','0')
                                            ->get();
                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->whereIn("passports.id",$old_platform_checkouts)
                                                ->whereNotIn("passports.id",$dc_request_checkout)
                                                ->where("passports.cancel_status",'=','0')
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
                                                        ->whereIn("passports.id",$old_platform_checkouts)
                                                        ->whereNotIn("passports.id",$dc_request_checkout)
                                                        ->where("assign_bikes.status", "1")
                                                        ->where("passports.cancel_status",'=','0')
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






    public function autocomplete_checkout_platform(Request $request)
    {

        $checkin_passsports = AssignPlateform::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereNotIn("passports.id",$checkin_passsports)
            ->get();

        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->whereNotIn("passports.id",$checkin_passsports)
                ->get();

        }

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereNotIn("passports.id",$checkin_passsports)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->whereNotIn("passports.id",$checkin_passsports)
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->whereNotIn("passports.id",$checkin_passsports)
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->whereNotIn("passports.id",$checkin_passsports)
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
                                ->whereNotIn("passports.id",$checkin_passsports)
                                ->get();
                            if (count($platform_code)=='0') {
                                $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->whereNotIn("passports.id",$checkin_passsports)
                                    ->get();
                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->whereNotIn("passports.id",$checkin_passsports)
                                        ->get();
                                    if (count($drive_lin_data) == '0') {
                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->whereNotIn("passports.id",$checkin_passsports)
                                            ->get();
                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->whereNotIn("passports.id",$checkin_passsports)
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


}
