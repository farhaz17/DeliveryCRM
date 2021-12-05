<?php

namespace App\Http\Controllers\Reports\VisaProcessReport;

use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Offer_letter\Offer_letter;
use App\Model\AgreedAmount;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\VisaProcess\AssigningAmount;

use App\Model\Guest\Career;
use App\Model\Seeder\Company;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\OwnVisa\OwnVisaLabourCardApproval;
use App\Model\VisaProcess\RenewAgreedAmount;
use App\Model\VisaProcess\UniqueEmailIdHandover;
use App\Model\VisaProcess\VisaCancellStatus;
use App\Model\VisaProcess\VisaCencel\VisaCancellationStatus;
use App\Model\VisaProcess\VisaProcessResumeAndStop;
use Illuminate\Support\Facades\DB;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Model\VisaProcess\RenewalContractTyping;
use App\Model\VisaProcess\VisaCencel\VisaCancellationTyping;
use App\Model\ElectronicApproval\ElectronicPreApprovalPayment;
;

class VisaProcessReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = array();
        $career = Career::where('visa_process_start_status','=' ,null)->where('visa_status','1')->pluck('id')->toArray();
        $pass_id = CurrentStatus::pluck('passport_id')->toArray();
        $visa_not_started = Passport::whereNotIn('id',$pass_id)->pluck('id')->toArray();
        //check career id if it is not null, meanas that it has career,
        //check the visa_status, if it is 1
        // visa_process_start_status
        $passport=Passport::whereIn('career_id',$career)->pluck('id')->toArray();
        $visa_process_to_start= Passport::whereIn('id',$passport)->orWhere('visa_status','1')->where('visa_process_start_status', null)->get();
        foreach($visa_process_to_start as $row){
            $pay_status= AssigningAmount::where('master_step_id','2')->where('passport_id',$row->id)->first();
            if($pay_status !=null){
                if($pay_status->pay_status=='1'){
                    $payment_status="Paid";
                }
                elseif($pay_status->pay_status=='2'){
                    if($pay_status->unpaid_status=='1'){
                       $payment_status='Will be paid at'.$pay_status->pay_later->step_name;
                    }
                    else{
                        $payment_status='Payroll Deduction';
                    }
                }
                else{
                    $payment_status='N/A';
                }
            }
            else{
                $payment_status='N/A';
            }
            // || $row->visa_status=='1'

if(isset($row->career->visa_status) && $row->career->visa_status=='1' || $row->visa_status=='1' ){
    $current_status=CurrentStatus::where('passport_id',$row->id)->first();
    $pass=Passport::where('id',$row->id)->first();
    $career=Career::where('passport_no',$row->passport_no)->first();
   if(!isset($current_status)){
    //    if(!isset($career) && $pass->visa_process_start_status==null ){

        $gamer = array(
            'passport_id' =>$row->id,
            'name' =>  isset($row->personal_info->full_name)?$row->personal_info->full_name:'N/A',
            'pass_no' => isset( $row->passport_no)?  $row->passport_no:"N/A",
            'pp_uid' => isset( $row->pp_uid)? $row->pp_uid:'N/A',
            'payment_status' =>$payment_status,
            'fine_start' =>isset( $row->career->exit_date)? $row->career->exit_date:'N/A',
            'agreed_amount'=>isset($row->agreed->agreed_amount)?$row->agreed->agreed_amount:'N/A',
            'advance_amount'=>isset($row->agreed->advance_amount)?$row->agreed->advance_amount:'N/A',
            'discount_details'=>isset($row->agreed->discount_details)?$row->agreed->discount_details:'N/A',
            'final_amount'=>isset($row->agreed->final_amount)?$row->agreed->final_amount:'N/A',
            'payroll_deduct_amount'=>isset($row->agreed->payroll_deduct_amount)?$row->agreed->payroll_deduct_amount:'N/A',
            'visa_status'=>isset($row->career->visa_status)?$row->career->visa_status:'N/A',
            'career_id'=>isset($row->career->id)?$row->career->id:'N/A',
        );
        $data[] = $gamer;
    }
// }
 }
    }
//visit visa counter

// $visit_visa_count=array();
// $career = Career::where('visa_process_start_status','=' ,null)
// ->where('visa_status','2')
// ->pluck('id')
// ->toArray();

// $pass_id = CurrentStatus::pluck('passport_id')->toArray();

// $visa_not_started = Passport::whereNotIn('id',$pass_id)->pluck('id')->toArray();

// //check career id if it is not null, meanas that it has  career,
// //check the visa_status, if it is 1
// // visa_process_start_status
// $passport=Passport::whereIn('career_id',$career)->pluck('id')->toArray();


// $visa_process_to_start= Passport::whereIn('id',$passport)
// ->orWhere('visa_status','2')
// ->get();




// foreach($visa_process_to_start as $row){
//     $pay_status= AssigningAmount::where('master_step_id','2')->where('passport_id',$row->id)->first();
//     if($pay_status !=null){
//         if($pay_status->pay_status=='1'){
//             $payment_status="Paid";
//         }
//         elseif($pay_status->pay_status=='2'){
//             if($pay_status->unpaid_status=='1'){
//                $payment_status='Will be paid at'.$pay_status->pay_later->step_name;
//             }
//             else{
//                 $payment_status='Payroll Deduction';
//             }
//         }
//         else{
//             $payment_status='N/A';
//         }
//     }
//     else{
//         $payment_status='N/A';
//     }
//     // || $row->visa_status=='1'

// if(isset($row->career->visa_status) && $row->career->visa_status=='2' || $row->visa_status=='2' ){
// $current_status=CurrentStatus::where('passport_id',$row->id)->first();
// $pass=Passport::where('id',$row->id)->first();
// $career=Career::where('passport_no',$row->passport_no)->first();
// if(!isset($current_status)){


// $gamer = array(
//     'passport_id' =>$row->id,
// );
// $visit_visa_count[] = $gamer;
// }

// }

//  }


        return view('admin-panel.reports.visa_process_report.index',compact('data','visit_visa_count'));
    }
    public function check_current_stats($visa_status){

    }

    public function visa_process_report_visa_status(){
        $data=array();
        $career = Career::where('visa_process_start_status','=' ,null)
        ->where('visa_status','2')
        ->pluck('id')
        ->toArray();

        $pass_id = CurrentStatus::pluck('passport_id')->toArray();

        $visa_not_started = Passport::whereNotIn('id',$pass_id)->pluck('id')->toArray();

        //check career id if it is not null, meanas that it has  career,
        //check the visa_status, if it is 1
        // visa_process_start_status
        $passport=Passport::whereIn('career_id',$career)->pluck('id')->toArray();


        $visa_process_to_start= Passport::whereIn('id',$passport)
        ->orWhere('visa_status','2')
        ->get();




        foreach($visa_process_to_start as $row){
            $pay_status= AssigningAmount::where('master_step_id','2')->where('passport_id',$row->id)->first();
            if($pay_status !=null){
                if($pay_status->pay_status=='1'){
                    $payment_status="Paid";
                }
                elseif($pay_status->pay_status=='2'){
                    if($pay_status->unpaid_status=='1'){
                       $payment_status='Will be paid at'.$pay_status->pay_later->step_name;
                    }
                    else{
                        $payment_status='Payroll Deduction';
                    }
                }
                else{
                    $payment_status='N/A';
                }
            }
            else{
                $payment_status='N/A';
            }
            // || $row->visa_status=='1'

if(isset($row->career->visa_status) && $row->career->visa_status=='2' || $row->visa_status=='2' ){
    $current_status=CurrentStatus::where('passport_id',$row->id)->first();
    $pass=Passport::where('id',$row->id)->first();
    $career=Career::where('passport_no',$row->passport_no)->first();
   if(!isset($current_status)){


        $gamer = array(
            'passport_id' =>$row->id,
            'name' =>  isset($row->personal_info->full_name)?$row->personal_info->full_name:'N/A',
            'pass_no' => isset( $row->passport_no)?  $row->passport_no:"N/A",
            'pp_uid' => isset( $row->pp_uid)? $row->pp_uid:'N/A',
            'payment_status' =>$payment_status,
            'fine_start' =>isset( $row->career->exit_date)? $row->career->exit_date:'N/A',
            'agreed_amount'=>isset($row->agreed->agreed_amount)?$row->agreed->agreed_amount:'N/A',
            'advance_amount'=>isset($row->agreed->advance_amount)?$row->agreed->advance_amount:'N/A',
            'discount_details'=>isset($row->agreed->discount_details)?$row->agreed->discount_details:'N/A',
            'final_amount'=>isset($row->agreed->final_amount)?$row->agreed->final_amount:'N/A',
            'payroll_deduct_amount'=>isset($row->agreed->payroll_deduct_amount)?$row->agreed->payroll_deduct_amount:'N/A',
            'visa_status'=>isset($row->career->visa_status)?$row->career->visa_status:'N/A',
            'career_id'=>isset($row->career->id)?$row->career->id:'N/A',
        );
        $data[] = $gamer;
    }

 }

         }

    $view = view("admin-panel.reports.visa_process_report.visa_process_cancel_visa", compact('data'))->render();
    return response()->json(['html' => $view]);
    }



    public function visa_process_report_own_visa_status(){
        $data=array();
        $career = Career::where('visa_process_start_status','=' ,null)
        ->where('visa_status','3')
        ->where('visa_status_own','1')
        ->pluck('id')->toArray();

        $pass_id = CurrentStatus::pluck('passport_id')->toArray();

        $visa_not_started = Passport::whereNotIn('id',$pass_id)->pluck('id')->toArray();


        $passport=Passport::whereIn('career_id',$career)->pluck('id')->toArray();



        // $passport_own= Passport::whereIn('id',$passport)
        // ->orWhere('visa_status','2')
        // ->pluck('id')
        // ->toArray();
        // dd($visa_process_to_start);


        $visa_process_to_start= Passport::whereIn('id',$passport)
        ->orWhere('visa_status','3')
        ->where('visa_status_own','1')
        ->get();




        foreach($visa_process_to_start as $row){
            $pay_status= AssigningAmount::where('master_step_id','2')->where('passport_id',$row->id)->first();
            if($pay_status !=null){
                if($pay_status->pay_status=='1'){
                    $payment_status="Paid";
                }
                elseif($pay_status->pay_status=='2'){
                    if($pay_status->unpaid_status=='1'){
                       $payment_status='Will be paid at'.$pay_status->pay_later->step_name;
                    }
                    else{
                        $payment_status='Payroll Deduction';
                    }
                }
                else{
                    $payment_status='N/A';
                }
            }
            else{
                $payment_status='N/A';
            }
            // || $row->visa_status=='1'

// if(isset($row->visa_process_to_start) ||isset($row) || isset()$row->career->visa_status=='3' || $row->visa_status=='3' ){
    $current_status=CurrentStatus::where('passport_id',$row->id)->first();
    $pass=Passport::where('id',$row->id)->first();
    $career=Career::where('passport_no',$row->passport_no)->first();
   if(!isset($current_status)){
    //    if(!isset($career) && $pass->visa_process_start_status==null ){

        $gamer = array(
            'passport_id' =>$row->id,
            'name' =>  isset($row->personal_info->full_name)?$row->personal_info->full_name:'N/A',
            'pass_no' => isset( $row->passport_no)?  $row->passport_no:"N/A",
            'pp_uid' => isset( $row->pp_uid)? $row->pp_uid:'N/A',
            'payment_status' =>$payment_status,
            'fine_start' =>isset( $row->career->exit_date)? $row->career->exit_date:'N/A',
            'agreed_amount'=>isset($row->agreed->agreed_amount)?$row->agreed->agreed_amount:'N/A',
            'advance_amount'=>isset($row->agreed->advance_amount)?$row->agreed->advance_amount:'N/A',
            'discount_details'=>isset($row->agreed->discount_details)?$row->agreed->discount_details:'N/A',
            'final_amount'=>isset($row->agreed->final_amount)?$row->agreed->final_amount:'N/A',
            'payroll_deduct_amount'=>isset($row->agreed->payroll_deduct_amount)?$row->agreed->payroll_deduct_amount:'N/A',
            'visa_status'=>isset($row->career->visa_status)?$row->career->visa_status:'N/A',
            'career_id'=>isset($row->career->id)?$row->career->id:'N/A',
        );
        $data[] = $gamer;
    }
// }
 }

        //  }

    $view = view("admin-panel.reports.visa_process_report.visa_process_own_visa", compact('data'))->render();
    return response()->json(['html' => $view]);
    }



    public function visa_process_report_own_without_status(){
        $data=array();
        $career = Career::where('visa_process_start_status','=' ,null)
        ->where('visa_status','3')
        ->where('visa_status_own','2')
        ->pluck('passport_no')->toArray();

        $pass_id = CurrentStatus::pluck('passport_id')->toArray();

        $visa_not_started = Passport::whereNotIn('id',$pass_id)->pluck('id')->toArray();

        //check career id if it is not null, meanas that it has  career,
        //check the visa_status, if it is 1
        // visa_process_start_status
        $passport=Passport::whereIn('passport_no',$career)->pluck('id')->toArray();



        $visa_process_to_start= Passport::whereIn('id',$passport)->orWhere('visa_status','2')->get();




        foreach($visa_process_to_start as $row){
            $pay_status= AssigningAmount::where('master_step_id','2')->where('passport_id',$row->id)->first();
            if($pay_status !=null){
                if($pay_status->pay_status=='1'){
                    $payment_status="Paid";
                }
                elseif($pay_status->pay_status=='2'){
                    if($pay_status->unpaid_status=='1'){
                       $payment_status='Will be paid at'.$pay_status->pay_later->step_name;
                    }
                    else{
                        $payment_status='Payroll Deduction';
                    }
                }
                else{
                    $payment_status='N/A';
                }
            }
            else{
                $payment_status='N/A';
            }
            // || $row->visa_status=='1'

if(isset($row->career->visa_status) && $row->career->visa_status=='3' && $row->career->visa_status_own=='2' || $row->visa_status=='3' ){
    $current_status=CurrentStatus::where('passport_id',$row->id)->first();
    $pass=Passport::where('id',$row->id)->first();
    $career=Career::where('passport_no',$row->passport_no)->first();
   if(!isset($current_status)){
    //    if(!isset($career) && $pass->visa_process_start_status==null ){

        $gamer = array(
            'passport_id' =>$row->id,
            'name' =>  isset($row->personal_info->full_name)?$row->personal_info->full_name:'N/A',
            'pass_no' => isset( $row->passport_no)?  $row->passport_no:"N/A",
            'pp_uid' => isset( $row->pp_uid)? $row->pp_uid:'N/A',
            'payment_status' =>$payment_status,
            'fine_start' =>isset( $row->career->exit_date)? $row->career->exit_date:'N/A',
            'agreed_amount'=>isset($row->agreed->agreed_amount)?$row->agreed->agreed_amount:'N/A',
            'advance_amount'=>isset($row->agreed->advance_amount)?$row->agreed->advance_amount:'N/A',
            'discount_details'=>isset($row->agreed->discount_details)?$row->agreed->discount_details:'N/A',
            'final_amount'=>isset($row->agreed->final_amount)?$row->agreed->final_amount:'N/A',
            'payroll_deduct_amount'=>isset($row->agreed->payroll_deduct_amount)?$row->agreed->payroll_deduct_amount:'N/A',
            'visa_status'=>isset($row->career->visa_status)?$row->career->visa_status:'N/A',
            'career_id'=>isset($row->career->id)?$row->career->id:'N/A',
        );
        $data[] = $gamer;
    }
// }
 }

         }
    // dd($data);
    $view = view("admin-panel.reports.visa_process_report.visa_process_without", compact('data'))->render();
    return response()->json(['html' => $view]);
    }

    public function get_nested_info_visa_process_report(Request $request){
        // dd($request->all());
        $amounts=AssigningAmount::where('passport_id',$request->id)->get();
        $view = view("admin-panel.reports.visa_process_report.ajax_nested_table", compact('amounts'))->render();
        return response()->json(['html' => $view]);
    }
    public function start_visa($id){

            $obj = Career::find($id);
            $obj->visa_process_start_status='1';
            $obj->save();

            $passport=Passport::where('career_id',$id)->first();

           if( isset($passport)){
            DB::table('passports')->where('career_id', $id)->update(['visa_process_start_status' =>'1']);
            }


        $message = [
            'message' => 'Visa Process Ready To Start Now!!',
            'alert-type' => 'success'

        ];

        return redirect()->back()->with($message);

    }

    public function start_visa2($id){

            $obj = Passport::find($id);
            $obj->visa_process_start_status='1';
            $obj->save();

                $career_id=$obj->career_id;
                if ($career_id !=null){
            $career = Career::where('career_id',$career_id)->first();
            if(isset($career)){
            $obj1 = Career::find($career->id);
            $obj1->visa_process_start_status='1';
            $obj1->save();
            }
        }
                    $message = [
                        'message' => 'Visa Process Ready To Start Now!!',
                        'alert-type' => 'success'
                    ];

        return redirect()->back()->with($message);

    }



    public function start_visa3($id){

        $obj = Career::find($id);

            $obj->visa_process_start_status='1';
            $obj->save();

            $passport_no=$obj->passport_no;
            $passport = Passport::where('passport_no',$passport_no)->first();

            $obj1= Passport::find($passport->id);
            $obj1->visa_process_start_status='1';

            $obj1->save();

        $message = [
            'message' => 'Visa Process Ready To Start Now!!',
            'alert-type' => 'success'

        ];

        return redirect()->back()->with($message);

    }

    public function start_visa4($id){

            $obj = Passport::find($id);
            $obj->visa_process_start_status='1';
            $obj->save();
            $passport_no=$obj->passport_no;
            $career = Career::where('passport_no',$passport_no)->first();
            if(isset($career)){
            $obj1= Career::find($career->id);
            $obj1->visa_process_start_status='1';
            $obj1->save();
            }
                    $message = [
                        'message' => 'Visa Process Ready To Start Now!!',
                        'alert-type' => 'success'
                    ];
        return redirect()->back()->with($message);

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

    public function visa_process_report_show(){

        $passport = Passport::with(['offer.companies:id,name', 'personal_info:passport_id,full_name','zds_code:passport_id,zds_code',
            'emirates_id:passport_id,card_no,expire_date','platform_assign','bike_assign','sim_assign','offer_letter_submission:passport_id,mb_no',
            'elect_pre_approval:passport_id,person_code,labour_card_no,issue_date,mb_no,issue_date,expiry_date',
            'print_visa_inside_outside:passport_id,visa_number,uid_no,visa_issue_date','agreement:passport_id,agreement_no'])->get();

        return view('admin-panel.reports.visa_process_report.visa_process_reports',compact('passport'));
    }

    public function visa_process_companies(){
        $companies=Company::where('type','1')->get();

        $company_id='1';
        // $started= Offer_letter::where('company',$company_id)->get();
        $offer= Offer_letter::where('company',$company_id)->get();
        $started_passport_ids= Offer_letter ::where('company',$company_id)->pluck('passport_id')->toArray();
        // $in_process= ElectronicPreApproval::whereIn('passport_id',$started_passport_ids)->get();
        $started=CurrentStatus::where('current_process_id','2')->whereIn('passport_id',$started_passport_ids)->get();
        $in_process=CurrentStatus::where('current_process_id','4')->whereIn('passport_id',$started_passport_ids)->get();
        $complete= CurrentStatus::where('current_process_id','27')->whereIn('passport_id',$started_passport_ids)->get();
        return view('admin-panel.reports.visa_process_report.company_report',compact('companies','started','in_process','complete','company_id'));

    }

    public function visa_company_detail(Request $request){
        $company_id=$request->company_id;
        // $started= Offer_letter::where('company',$company_id)->get();
        $offer= Offer_letter::where('company',$company_id)->get();
        $started_passport_ids= Offer_letter ::where('company',$company_id)->pluck('passport_id')->toArray();
        // $in_process= ElectronicPreApproval::whereIn('passport_id',$started_passport_ids)->get();
        $started=CurrentStatus::where('current_process_id','2')->whereIn('passport_id',$started_passport_ids)->get();
        $in_process=CurrentStatus::where('current_process_id','4')->whereIn('passport_id',$started_passport_ids)->get();
        $complete= CurrentStatus::where('current_process_id','27')->whereIn('passport_id',$started_passport_ids)->get();
        // $complete= UniqueEmailIdHandover::whereIn('passport_id',$started_passport_ids)->get();
        $view = view("admin-panel.reports.visa_process_report.ajax_company_rep", compact('started','in_process','complete','company_id'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_category_details(){

        $company_id='1';
        $companies=Company::where('type','1')->get();

        $offer= Offer_letter::where('company',$company_id)->get();
        $offer_letter= Offer_letter::all();

        $started_passport_ids= Offer_letter ::where('company',$company_id)->pluck('passport_id')->toArray();

        $emirates_nationals=Passport::where('nation_id','9')->pluck('id')->toArray();

        // PRE APPROVAL FOR WORK PERMIT
        $pre_app_for_work_per=CurrentStatus::where('current_process_id','28')->orWhere('current_process_id','4')->whereIn('passport_id',$started_passport_ids)->get();
        //working as new requirment

           // NEW ELECTRONIC WORK PERMIT
        // $new_contract_work_per=CurrentStatus::where('current_process_id','5')->whereIn('passport_id',$started_passport_ids)->get();
        $new_elec_work_permit_under_cancel_data=VisaCancellationTyping::where('passport_id',$started_passport_ids)->pluck('passport_id')->toArray();
        $renew_elec_work_after_data= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->pluck('passport_id')->toArray();
        $new_contract_work_per=ElectronicPreApprovalPayment::whereIn('passport_id',$started_passport_ids)
        ->whereNotIn('passport_id',$new_elec_work_permit_under_cancel_data)
        ->whereNotIn('passport_id',$renew_elec_work_after_data)
        ->get();


         // NEW ELECTRONIC WORK PERMIT UNDER CANCELLATION
         //beforem his renewal
         $before_rwnewal= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->pluck('passport_id')->toArray();
         $new_elec_work_permit_under_cancel=VisaCancellationTyping::whereNotIn('passport_id',$before_rwnewal)->get();
         //- ELECTRONIC WORK PERMIT FOR PART TIME
         $elec_work_per_for_part_time=OwnVisaLabourCardApproval::whereIn('passport_id',$started_passport_ids)->get();

         //IF EMIRATI New Contract Submission - NATIONAL AND GCC ELECTRONIC WORK PERMIT
         $national_gcc=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals)->get();
        //  AFTER SUBMISSION OF CONTRACT - RENEWAL ELECTRONIC WORK PERMIT
        $renew_elec_work_after= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->get();
        //IF EMIRATI -  RENEWAL NATIONAL AND GCC ELECTRONIC WORK PERMIT
        $renew_elec_work_per_if_emr=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals)->get();

        //IF EMIRATI -  RENEWAL NATIONAL AND GCC ELECTRONIC WORK PERMIT
        // $renew_elec_work_per=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals)->get();
        //RENEWAL TYPING Cancellation submission - RENEWAL  WORK PERMIT UNDER CANCELLATION
        //if is in visa in visa cancel
        $renewal_work_permit_under_cancel=array();
        $RenewalContractTyping= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->get();

        foreach($RenewalContractTyping as $res2){
            $RenewalContractTypingCount= VisaCancellationTyping ::where('passport_id',$res2->passport_id)->count();
            if($RenewalContractTypingCount>='1'){
                $gamer2=array(

                    'name' => $res2->passport->personal_info->full_name,
                    'passport_no' => $res2->passport->passport_no,
                    'ppuid' => $res2->passport->pp_uid,

                );
                $renewal_work_permit_under_cancel[] = $gamer2;
            }


        }



        $data=array();

        foreach($companies as $res){
            $started_passport_ids2= Offer_letter ::where('company',$res->id)->pluck('passport_id')->toArray();
            $emirates_nationals2=Passport::where('nation_id','9')->pluck('id')->toArray();
            $pre_app_for_work_per2=CurrentStatus::where('current_process_id','28')->orWhere('current_process_id','4')->whereIn('passport_id',$started_passport_ids2)->count();
            $new_contract_work_per2=CurrentStatus::where('current_process_id','5')->whereIn('passport_id',$started_passport_ids2)->count();
             $before_rwnewal2= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids2)->pluck('passport_id')->toArray();
             $new_elec_work_permit_under_cancel2=VisaCancellationTyping::whereNotIn('passport_id',$before_rwnewal2)->count();
             $elec_work_per_for_part_time2=OwnVisaLabourCardApproval::whereIn('passport_id',$started_passport_ids2)->count();
             $national_gcc2=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals2)->count();
            $renew_elec_work_after2= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids2)->count();
            $renew_elec_work_per_if_emr2=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals2)->count();
            $renewal_work_permit_under_cancel2=0;

            // $renewal_work_permit_under_cancel2=array();
            // $RenewalContractTyping2= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids2)->get();
            // $RenewalContractTypingCount2= VisaCancellationTyping ::where('passport_id',$res3->passport_id)->count();
            // if($RenewalContractTypingCount>='1'){

            // }

            // foreach($RenewalContractTyping2 as $res3){

            //     if($RenewalContractTypingCount>='1'){
            //         $gamer3=array(
            //             'name' => $res3->passport->personal_info->full_name,
            //             'passport_no' => $res3->passport->passport_no,
            //             'ppuid' => $res3->passport->pp_uid,
            //         );
            //         $renewal_work_permit_under_cancel2[] = $gamer3;
            //     }


            // }
            // dd(count($renewal_work_permit_under_cancel2));

        //    $last=array_count_values($renewal_work_permit_under_cancel2);




        $counter= $pre_app_for_work_per2+$new_contract_work_per2+$new_elec_work_permit_under_cancel2+$elec_work_per_for_part_time2+$national_gcc2+$renew_elec_work_after2+$renew_elec_work_per_if_emr2+$renewal_work_permit_under_cancel2;

        $gamer=array(
                'id' => $res->id,
                'name' => $res->name,
                // 'counter'=>$counter,
            );
            $data[] = $gamer;


    }

        return view('admin-panel.reports.visa_process_report.visa_report_categorywise',compact('company_id','companies','pre_app_for_work_per','new_contract_work_per',
        'new_elec_work_permit_under_cancel','elec_work_per_for_part_time',
        'national_gcc','renew_elec_work_after','renew_elec_work_per_if_emr','renewal_work_permit_under_cancel','data'));

    }

    public function get_visa_category_details(Request $request){

        $company_id=$request->company_id;
        $companies=Company::where('type','1')->get();

        $offer= Offer_letter::where('company',$company_id)->get();
        $started_passport_ids= Offer_letter ::where('company',$company_id)->pluck('passport_id')->toArray();


        $emirates_nationals=Passport::where('nation_id','9')->pluck('id')->toArray();

        // PRE APPROVAL FOR WORK PERMIT
        $pre_app_for_work_per=CurrentStatus::where('current_process_id','28')->orWhere('current_process_id','4')->whereIn('passport_id',$started_passport_ids)->get();
        //working as new requirment

           // NEW ELECTRONIC WORK PERMIT
        // $new_contract_work_per=CurrentStatus::where('current_process_id','5')->whereIn('passport_id',$started_passport_ids)->get();
        // $new_contract_work_per=ElectronicPreApprovalPayment::whereIn('passport_id',$started_passport_ids)->get();

        // $new_elec_work_permit_under_cancel_data=VisaCancellationTyping::where('passport_id',$started_passport_ids)->pluck('passport_id')->toArray();
        // $new_contract_work_per=ElectronicPreApprovalPayment::whereIn('passport_id',$started_passport_ids)->whereNotIn('passport_id',$new_elec_work_permit_under_cancel_data)->get();


        $new_elec_work_permit_under_cancel_data=VisaCancellationTyping::where('passport_id',$started_passport_ids)->pluck('passport_id')->toArray();
        $renew_elec_work_after_data= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->pluck('passport_id')->toArray();
        $new_contract_work_per=ElectronicPreApprovalPayment::whereIn('passport_id',$started_passport_ids)
        ->whereNotIn('passport_id',$new_elec_work_permit_under_cancel_data)
        ->whereNotIn('passport_id',$renew_elec_work_after_data)
        ->get();


         // NEW ELECTRONIC WORK PERMIT UNDER CANCELLATION
         //beforem his renewal
         $before_rwnewal= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->get();
         $new_elec_work_permit_under_cancel=VisaCancellationTyping::whereNotIn('passport_id',$before_rwnewal)->get();
         //- ELECTRONIC WORK PERMIT FOR PART TIME
         $elec_work_per_for_part_time=OwnVisaLabourCardApproval::whereIn('passport_id',$started_passport_ids)->get();

         //IF EMIRATI New Contract Submission - NATIONAL AND GCC ELECTRONIC WORK PERMIT
         $national_gcc=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals)->get();
        //  AFTER SUBMISSION OF CONTRACT - RENEWAL ELECTRONIC WORK PERMIT
        $renew_elec_work_after= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->get();
        //IF EMIRATI -  RENEWAL NATIONAL AND GCC ELECTRONIC WORK PERMIT
        $renew_elec_work_per_if_emr=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals)->get();

        //IF EMIRATI -  RENEWAL NATIONAL AND GCC ELECTRONIC WORK PERMIT
        // $renew_elec_work_per=CurrentStatus::where('current_process_id','20')->whereIn('passport_id',$emirates_nationals)->get();
        //RENEWAL TYPING Cancellation submission - RENEWAL  WORK PERMIT UNDER CANCELLATION
        //if is in visa in visa cancel
        $renewal_work_permit_under_cancel=array();
        $RenewalContractTyping= RenewalContractTyping ::whereIn('passport_id',$started_passport_ids)->get();

        foreach($RenewalContractTyping as $res2){
            $RenewalContractTypingCount= VisaCancellationTyping ::where('passport_id',$res2->passport_id)->count();
            if($RenewalContractTypingCount>='1'){
                $gamer2=array(

                    'name' => $res2->passport->personal_info->full_name,
                    'passport_no' => $res2->passport->passport_no,
                    'ppuid' => $res2->passport->pp_uid,

                );
                $renewal_work_permit_under_cancel[] = $gamer2;
            }


        }

        $view=view('admin-panel.reports.visa_process_report.ajax_category',compact('company_id','companies','pre_app_for_work_per','pre_app_for_work_per','new_contract_work_per','new_elec_work_permit_under_cancel','elec_work_per_for_part_time',
        'national_gcc','renew_elec_work_after','renew_elec_work_per_if_emr','renewal_work_permit_under_cancel'))->render();

        return response()->json(['html' => $view]);
    }

    public function stop_and_resume_report(){
        $stop_resume=VisaProcessResumeAndStop::all();

        return view('admin-panel.reports.visa_process_report.stop_and_resume_report',compact('stop_resume'));
    }
}
