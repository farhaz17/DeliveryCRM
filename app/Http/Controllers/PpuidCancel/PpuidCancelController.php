<?php

namespace App\Http\Controllers\PpuidCancel;

use App\Model\Agreement\Agreement;
use App\Model\Assign\AssignPlateform;
use App\Model\OnBoardStatus\OnBoardStatusType;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\PpuidCancel\PpuidCancel;
use App\Model\RiderProfile;
use App\Model\UserCodes\UserCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Career\RejoinCareer;
use App\Model\Passport\Ppuid;
use App\Model\PpuidCancel\CancelCateogryPpuid;
use App\Model\VendorRegistration\VendorRiderOnboard;
use Illuminate\Support\Facades\DB;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Illuminate\Support\Facades\Validator;
use App\Model\Master_steps;
use App\Model\DiscountName\DiscountName;
use App\Model\Career\CareerDocumentName;
use Carbon\Carbon;
use App\Model\AgreedAmount;
use Illuminate\Support\Facades\Storage;
use App\Model\LogAfterPpuid\LogAfterPpuid;
use App\Model\VisaProcess\AssigningAmount;

class PpuidCancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        dd("we are here");

$discount_names = DiscountName::orderby('id','desc')->get();
$master_steps = Master_steps::where('id','!=','1')->get();

$career_doc_name = CareerDocumentName::all();

        return view('admin-panel.ppuid_cancel.index',compact('career_doc_name','master_steps','discount_names'));
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
    public function ppuid_show(Request $request){


        $searach = '%' . $request->keyword . '%';

        $passport = Passport::where('passport_no', 'like', $searach)->first();
        $passport_info=passport_addtional_info::where('passport_id',$passport->id)->first();
//        $agreement_check=Agreement::where('passport_id',$passport->id)->first();


        $ppuid_status=PpuidCancel::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

        if ($ppuid_status==null){
            $ppuid_visa='100';
            $ppuid_working='100';
            $ppuid_id_status='100';

            $ppuid_visa_remakrs='100';
            $ppuid_working_remarks='100';
            $ppuid_id_status_remarks='100';
        }
        else{
            $ppuid_working=$ppuid_status->working_status;
            $ppuid_visa=$ppuid_status->visa_status;
            $ppuid_id_status=$ppuid_status->id_status;


            $ppuid_working_remarks=$ppuid_status->working_status_remarks;
            $ppuid_visa_remakrs=$ppuid_status->visa_status_remarks;
            $ppuid_id_status_remarks=$ppuid_status->id_status_remarks;
        }


        //------------------------------------------------------------
        $zds_code=UserCodes::where('passport_id',$passport->id)->first();

        $already_cancel=$passport->cancel_status;
        if ($already_cancel=='1'){
            $current_status='1';

        }else{
            $current_status='2';
        }

        $platform_checkout_type_detail=OnBoardStatusType::where('passport_id',$passport->id)->first();
        if ($platform_checkout_type_detail==null) {
            $platform_checkout_type="100";
        }
        else{
            $platform_checkout_type=$platform_checkout_type_detail->checkout_type;
        }


        $platform_checkout_remarks_detail=AssignPlateform::where('passport_id',$passport->id)->first();
        if ($platform_checkout_remarks_detail==null) {
            $platform_checkout_remarks="none";

        }
        else{
            $platform_checkout_remarks=$platform_checkout_remarks_detail->remarks;
        }

        $main_categories = CancelCateogryPpuid::where('parent_id','=','0')->get();


        $view = view("admin-panel.ppuid_cancel.new_ajax_get_ppuid",compact('passport','main_categories','passport_info','zds_code',
            'ppuid_working','ppuid_visa','current_status','platform_checkout_type','platform_checkout_remarks',
            'ppuid_id_status','ppuid_visa_remakrs','ppuid_working_remarks','ppuid_id_status_remarks'))->render();
        return response()->json(['html' => $view]);
    }

    public function ajax_append_subcategory_cancel(Request $request){

        if($request->ajax()){
            $sub_categories = CancelCateogryPpuid::where('parent_id','=',$request->id)->get();

            $view = view("admin-panel.ppuid_cancel.ajax_canacel_subcategory",compact('sub_categories'))->render();
        return response()->json(['html' => $view]);

        }
    }

    public function cancel_activate_agreed_amount(Request $request){

        if($request->ajax()){


            $discount_names = DiscountName::orderby('id','desc')->get();
            $master_steps = Master_steps::where('id','!=','1')->get();

            $career_doc_name = CareerDocumentName::all();
            $view = view("admin-panel.ppuid_cancel.fourpl_select_ajax",compact('discount_names','master_steps','career_doc_name'))->render();
        return response()->json(['html' => $view]);

        }
    }





    public function ppuid_cancel_status(Request $request){

        try{


            $validator = Validator::make($request->all(), [
                'keyword' => 'required',
                'cancel_remarks' => 'required',
                'main_category' => 'required',
                'sub_category' => 'required',
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                    return $validate->first();
            }


            $searach = '%' . $request->keyword . '%';

            $passport = Passport::where('passport_no', 'like', $searach)->first();

            $passport_number = "";

            if($passport != null){

                    $passport_number =  $passport->passport_no;
                $assign_platform = $passport->assign_platforms_checkin();

                if(isset($assign_platform)){
                    return "Platform is assigned, so ppuid cancelled is not allow";
                }

                $assign_bike = $passport->assign_bike_check();

                if(isset($assign_bike)){
                    return "Bike is assigned, so ppuid cancelled is not allow";
                }

                $assign_sim = $passport->assign_sim_check();

                if(isset($assign_sim)){
                    return "Sim is assigned, so ppuid cancelled is not allow";
                }


                $passport->cancel_status = "1";
                $passport->update();

                $current_timestamp = Carbon::now();

                $ppuid_obj = new PpuidCancel();
                $ppuid_obj->passport_id = $passport->id;
                $ppuid_obj->status = "1";
                $ppuid_obj->cancel_date_time = $current_timestamp;
                $ppuid_obj->cancel_remarks = $request->cancel_remarks;
                $ppuid_obj->cancel_cateogry_ppuid_id =  $request->sub_category;
                $ppuid_obj->save();

             $rejoin_gamer = RejoinCareer::where('hire_status','!=','1')
                                    ->where('passport_id','=',$passport->id)->first();

                        if($rejoin_gamer != null){
                            $rejoin_gamer->applicant_status = "10";
                            $rejoin_gamer->onboard = "02";
                            $rejoin_gamer->hire_status = "1";
                            $rejoin_gamer->update();
                        }

        $vendor_rider_onboard = VendorRiderOnboard::where('passport_no','=',$passport_number)->orderby('id','desc')->first();

        if($vendor_rider_onboard != null){

                    $vendor_rider_onboard->cancel_status = "1";
        $vendor_rider_onboard->update();

        }

                return "success";
            }else{
                return "passport number not matched with our record";
            }


            }catch(\Illuminate\Database\QueryException $e){
               return  $e;
            }


    }


    public function ppuid_cancel_report(){


        $active_ppuid=Passport::where('cancel_status','=',null)
            ->orWhere('cancel_status','=','0')
            ->count();

        $inactive_ppuid=Passport::where('cancel_status', '=', '1')->count();
        $total_ppuid=Passport::count();


        $all_active=Passport::where('cancel_status',null)
            ->orWhere('cancel_status','=','0')
            ->get();

        $all_inactive=Passport::where('cancel_status', '1')->get();

        $active_agreements=Agreement::where('status','=',null)->orWhere('status','=','0')->count();
        $inactive_agreements=Agreement::where('status','=','1')->count();
        $total_agreements=Agreement::count();

        $working_status=PpuidCancel::where('working_status','!=',null)->get();
        $visa_status=PpuidCancel::where('visa_status','!=',null)->get();
        $id_status=PpuidCancel::where('id_status','!=',null)->get();


        return view('admin-panel.ppuid_cancel.ppuid_cancel_report',compact('inactive_ppuid','active_ppuid','all_active','all_inactive','total_ppuid',
            'total_agreements','active_agreements','inactive_agreements','visa_status','working_status','id_status'));
    }

    public function ppuid_cancel_history(){

        $history=PpuidCancel::all();

        return view('admin-panel.ppuid_cancel.ppuid_cancel_history',compact('history'));
    }







    //activat again


    public function ppuid_activate(Request $request){


        $passport_id=$request->passport_id_activate;
        $passport_number_activate=$request->passport_number_activate;
        try{


            $validator = Validator::make($request->all(), [
                'passport_id_activate' => 'required',
                'passport_number_activate' => 'required',
                'active_remarks' => 'required',

            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                    return $validate->first();
            }


            if(isset($request->company_now)){
                $step_amount_now  = $this->check_the_step_amount($request);

                if($step_amount_now!=$request->final_amount){
                    return "Step amount is not Equal to Final Amount";
                }
          }



            $searach = '%' . $request->passport_number_activate . '%';

            $passport = Passport::where('passport_no', 'like', $searach)->first();

            if($passport != null){


             $ppuid_cancel = PpuidCancel::where('passport_id','=',$passport->id)->where('status','=','1')->first();


                        if($ppuid_cancel != null){

                            $passport->cancel_status = "0";
                            $passport->update();

                            $current_timestamp = Carbon::now();

                            $ppuid_cancel->reactivate_remarks = $request->active_remarks;
                            $ppuid_cancel->reactivate_date_time = $current_timestamp;
                            $ppuid_cancel->status = "0";
                            $ppuid_cancel->reactive_type = $request->work_as;
                            $ppuid_cancel->update();
                            // return "success";

                            $passport_id =  $passport->id;
                            if(isset($request->company_now)){  //agreed amount work start


                                $is_agreed_amount = AgreedAmount::where('passport_id','=',$passport_id)->first();

                                if($is_agreed_amount != null){
                                    $is_agreed_amount->agreed_amount_status = "0";
                                    $is_agreed_amount->update();
                                }


                                $advance_amount = 0;
                                $json_discount_detail = "";
                                if(!empty($request->discount_name) && !empty($request->discount_amount)){

                                    $array_to_send = [];

                    //                foreach ($request->discount_amount as $d_amount){
                                        $data = array(
                                            'name' => $request->discount_name,
                                            'amount' =>$request->discount_amount,
                                        );
                                        $array_to_send [] = $data;
                    //                }
                                    $json_discount_detail = json_encode($array_to_send);
                                }

                                if(!empty($request->advance_amount)){
                                    $advance_amount =  $request->advance_amount;
                                }

                                $date_folder = date("Y-m-d");

                                if (!file_exists('../public/assets/upload/agreed_amount/'.$date_folder."/")) {
                                    mkdir('../public/assets/upload/agreed_amount/'.$date_folder."/", 0777, true);
                                }

                                if($request->hasfile('attchemnt')) {
                                    if (!empty($_FILES['attchemnt']['name'])) {

                                        $img = $request->file('attchemnt');
                                        $file_path_front = 'assets/upload/agreed_amount/' .time() . '.' . $img ->getClientOriginalExtension();

                                        $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                            $constraint->aspectRatio();
                                        });

                                        Storage::disk("s3")->put($file_path_front, $imageS3->stream());

                                    }
                                }


                                $agreed_amount  = new AgreedAmount();
                                $agreed_amount->passport_id =  $passport_id;
                                $agreed_amount->agreed_amount = $request->agreed_amount;
                                $agreed_amount->advance_amount  = $advance_amount;
                                if(isset($json_discount_detail)){
                                    $agreed_amount->discount_details = $json_discount_detail;
                                }

                                $agreed_amount->final_amount = $request->final_amount;
                                if(!empty($file_path_front)){
                                    $agreed_amount->attachment = $file_path_front;
                                }
                                if(isset($request->payroll_deduct)){
                                    $agreed_amount->payroll_deduct_amount = $request->payroll_deduct_amount;
                                }

                                $agreed_amount->save();
                                $last_id = $agreed_amount->id;

                                $logAfter = new  LogAfterPpuid();
                                $logAfter->log_status_id = 2;
                                $logAfter->passport_id = $passport_id;
                                $logAfter->save();



                                if(!empty($request->select_amount_step)){

                                    $counter_amount_step = 0;
                                    foreach($request->select_amount_step as  $step_amount){
                                        if(!empty($step_amount) && !empty($request->step_amount[$counter_amount_step])){
                                            $array_insert = array(
                                                'amount' => $request->step_amount[$counter_amount_step],
                                                'master_step_id' => $step_amount,
                                                'passport_id' => $passport_id,
                                                'agreed_amount_id' => $last_id,
                                            );
                                            AssigningAmount::create($array_insert);
                                        }
                                        $counter_amount_step =  $counter_amount_step+1;
                                    }

                                }



                            } //agreed amount work end


                            return "success";



                        }else{
                            return "Cancel Status not found, please contact admin";
                        }


            }else{
                return "passport number not matched with our record";
            }


            }catch(\Illuminate\Database\QueryException $e){
               return  $e;
            }

        }


        function check_the_step_amount($request){

            $totaly_amount = 0;

            foreach ($request->step_amount as $amount){
                $totaly_amount = $totaly_amount+$amount;
            }

            if(isset($request->payroll_deduct)){
                $totaly_amount = $totaly_amount+$request->payroll_deduct_amount;
            }

            return $totaly_amount;
        }



}
