<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\Agreement\Agreement;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\ElectronicApproval\ElectronicPreApprovalPayment;
use App\Model\LabourCardType;
use App\Model\LabourCardTypeAssign;
use App\Model\Master_steps;
use App\Model\Nationality;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Offer_letter\Offer_letter_submission;
use App\Model\PaymentType;
use App\Model\Seeder\Company;
use App\Model\Seeder\Designation;
use App\Model\VisaProcess\AssigningAmount;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\EmiratesIdApply;
use App\Model\VisaProcess\EmiratesIdFingerPrint;
use App\Model\VisaProcess\EntryDate;
use App\Model\VisaProcess\EntryPrintInside;
use App\Model\VisaProcess\EntryPrintOutside;
use App\Model\VisaProcess\FitUnfit;
use App\Model\VisaProcess\InOutStatusChange;
use App\Model\VisaProcess\LabourCard;
use App\Model\VisaProcess\Medical24;
use App\Model\VisaProcess\Medical48;
use App\Model\VisaProcess\MedicalNormal;
use App\Model\VisaProcess\MedicalVIP;
use App\Model\VisaProcess\NewContractAppTyping;
use App\Model\VisaProcess\NewContractSubmission;
use App\Model\VisaProcess\StatusChange;
use App\Model\VisaProcess\TawjeehClass;
use App\Model\VisaProcess\UniqueEmailId;
use App\Model\VisaProcess\UniqueEmailIdHandover;
use App\Model\VisaProcess\VisaPasted;
use App\Model\VisaProcess\VisaStamping;
use App\Model\VisaProcess\WaitingForApproval;
use App\Model\VisaProcess\WaitingForZajeel;
use App\Model\Work_permit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Guest\Career;
use App\Model\Passport;
use App\Model\Passport\Passport as PassportPassport;
use Illuminate\Validation\Rules\Unique;
use App\Model\AgreedAmount;
use App\Model\Cities;
use App\Model\Emirates_id_cards;
use App\Model\Master\Vehicle\VehicleInsurance;
use App\Model\Vehicle\InsuranceNetworkType;
use App\Model\VisaApplication;
use App\Model\VisaProcess\BypassVisa;
use App\Model\VisaProcess\Insurance\Glwmc;
use App\Model\VisaProcess\Insurance\TakafulEmarat;
use App\Model\VisaProcess\RenewVisaSteps;
use App\Model\VisaProcess\VisaProcessResumeAndStop;
use App\Model\VisaProcess\VisaCencel\ReplacementVisaCancel;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Model\VisaProcess\VisaPaymentOptions;
use Illuminate\Support\Facades\Validator;
use App\Model\VisaProcess\VisaCancel\BetweenVisaCancel;
use App\Model\VisaProcess\VisaCancel\VisaCancelRequest;
use App\Model\UserCodes\UserCodes;
use App\Model\PlatformCode\PlatformCode;
use App\Model\VisaProcess\VisaProcessLabourInsurance;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\ArBalance\ArBalance;
use App\Model\ArBalance\BalanceType;
use App\Model\Platform;
use App\Model\VisaProcess\RenewAgreedAmount;
use Laravel\Passport\Passport as LaravelPassportPassport;
use App\Model\VisaProcess\VisaCencel\VisaCancellationStatus;
use App\Model\RiderProfile;
use App\Imports\LabourCardImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Passport\passport_addtional_info;

class VisaStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//*/
            // function __construct()
            // {

            //     $this->middleware('role_or_permission:Admin|master-ppuids', ['only' => ['ppuid']]);
            //     $this->middleware('role_or_permission:Admin|passport-passport-create', ['only' => ['store','index']]);

            // }

            function __construct()
            {
                $this->middleware('role_or_permission:Admin|VisaProcessEmiratesIdHandover|VisaProcessManager|VisaProcess');
            }

    public function index()
    {
        //
        $passport=Passport\Passport::all();
        $steps=Master_steps::all();
        $job=Designation::all();
        $labour_card_type=LabourCardType::all();
        return view('admin-panel.visa-master.visa_master',compact('passport','steps','job','labour_card_type'));
    }

    public function visa_process(){
        return view('admin-panel.visa-master.visa_process.index');
    }

    public function visa_process_names(Request $request){

        $passport=Passport\Passport::where('passport_no',$request->keyword)->first();


        $passport_id=$passport->id;
        $name=$passport->personal_info->full_name;
        $ppuid=$passport->pp_uid;
        $passport_no=$passport->passport_no;
        $image=isset($passport->profile->image)?$passport->profile->image:'';

        $expiry_date=$passport->date_expiry;

        $req=VisaCancelRequest::where('passport_id',$passport_id)->where('status','3')->first();


        if($expiry_date==null){
            $remain_days='Passport expiry date is not available';
        }
        else{
            $curr_date=date('Y-m-d');
            $date1 = strtotime($curr_date);
            $date2 = strtotime($expiry_date);
            $diff = abs($date2 - $date1);

            $years = floor($diff / (365*60*60*24));

            $months = floor(($diff - $years * 365*60*60*24)
                / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 -
                    $months*30*60*60*24)/ (60*60*24));

            $remain_days= $years." years ".$months." months ".$days." days";
        }

        //check for own visa
        $career_for_own=Career::where('passport_no',$request->keyword)->where('visa_status','3')->first();
        // dd($career_for_own);
        $pass_for_own=Passport\Passport::where('id',$passport_id)->where('visa_status','3')->first();

        if(isset($career_for_own)){
                $own_visa='12';
        }
        elseif(isset($pass_for_own)){
            $own_visa='1';
        }else{
            $own_visa='0';
        }
// dd($own_visa);
                    //---------------offer letter process 1------------
                    $offer_letter=Offer_letter::where('passport_id',$passport->id)->first();
                    $offer_letter_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','2')->first();
                    $stop_resume_offer_letter= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','2')->first();








                    //---------------offer letter ends------------

                    //---------------offer letter submission process 2------------
                    $offer_letter_sub=Offer_letter_submission::where('passport_id',$passport->id)->first();
                    $offer_letter_sub_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','3')->first();
                    $stop_resume_offer_letter_sub= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','3')->first();


                    //---------------offer letter submission ENDS------------

                     //---------------Electronic Pre Approval process 3------------
                     $electronic_pre_approval=ElectronicPreApproval::where('passport_id',$passport->id)->first();
                    $electronic_pre_approval_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','4')->first();

                    $stop_resume_electronic_pre_approval= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','4')->first();

                     //---------------Electronic Pre Approval process 3 ENDS------------

                     //---------------Electronic Pre Approval Payment process 4------------
                     $electronic_pre_approval_pay=ElectronicPreApprovalPayment::where('passport_id',$passport->id)->first();
                     $electronic_pre_approval_pay_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','5')->first();
                    $stop_resume_electronic_pre_approval_pay= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','5')->first();


                     //---------------Electronic Pre Approval process 4 ENDS------------

                     //---------------Print Visa Inside Outside process 5-----------
                     $print_inside_out_side=EntryPrintOutside::where('passport_id',$passport->id)->first();
                     $print_inside_out_side_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','6')->first();
                    $stop_resume_print_inside_out_side= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','6')->first();

                    $replacement_inside_out_side= DB::table('replacement_visa_cancels')->where('passport_id',$passport->id)->where('visa_process_id','5')->first();
                    $replacement_req= DB::table('replacement_requests')->where('passport_id',$passport->id)->where('status','1')->first();


                     //---------------Print Visa Inside Outside process 5 ENDS------------


                     //---------------Status Change/in out change process 6-----------

                     $status_change=StatusChange::where('passport_id',$passport->id)->first();
                     $status_change_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','8')->first();
                    $stop_resume_status_change= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','7')->first();
                    $replacement_status_change= DB::table('replacement_visa_cancels')->where('passport_id',$passport->id)->where('visa_process_id','7')->first();



                     $in_out_change=InOutStatusChange::where('passport_id',$passport->id)->first();
                     $in_out_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','9')->first();
                    $stop_resume_in_out_change= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','9')->first();
                    $replacement_in_out_change= DB::table('replacement_visa_cancels')->where('passport_id',$passport->id)->where('visa_process_id','8')->first();




                     //---------------Status Change/in out change process 6 ENDS-----------

                     //---------------Entry Date process 7-----------
                     $entry_date=EntryDate::where('passport_id',$passport->id)->first();
                     $entry_date_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','10')->first();

                    $stop_resume_entry_date= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','10')->first();


                     //---------------Entry Date process 7 ends-----------
                     //---------------Medical process 8 ends-----------
                     $med_normal=MedicalNormal::where('passport_id',$passport->id)->first();
                     $med_normal_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','11')->first();
                    $stop_resume_med_normal= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','11')->first();

                     $med_48=Medical48::where('passport_id',$passport->id)->first();
                     $med_48_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','12')->first();
                    $stop_resume_med_48= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','12')->first();

                     $med_24=Medical24::where('passport_id',$passport->id)->first();
                     $med_24_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','13')->first();
                    $stop_resume_med_24= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','13')->first();

                     $med_vip=MedicalVIP::where('passport_id',$passport->id)->first();
                     $med_vip_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','14')->first();
                     $stop_resume_med_vip= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','14')->first();

                     //---------------Medial process 8 ends-----------
                     //---------------Medial process 9-----------
                     $fit_unfit=FitUnfit::where('passport_id',$passport->id)->first();
                     $fit_unfit_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','15')->first();
                    $stop_resume_fit_unfit= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','15')->first();


                     //---------------Medial process 9 ends-----------
                        //---------------Medial process 10-----------
                        $emirates_id_apply=EmiratesIdApply::where('passport_id',$passport->id)->first();
                        $emirates_id_apply_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','16')->first();

                        //---------------Medial process 10 ends-----------
                        //---------------Medial process 11 ends-----------
                        $figer_print=EmiratesIdFingerPrint::where('passport_id',$passport->id)->first();
                        $figer_print_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','17')->first();
                    $stop_resume_figer_print= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','17')->first();
                    $payment_figer_print= DB::table('visa_payment_options')->where('passport_id',$passport->id)->where('visa_process_step_id','17')->first();

                        //---------------Medial process 11 ends-----------
                        //--------------- process 12-----------
                        $new_contract=NewContractAppTyping::where('passport_id',$passport->id)->first();
                        $new_contract_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','18')->first();
                    $stop_resume_new_contract= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','18')->first();

                        //--------------- process 12-----------
                           //--------------- process 13-----------
                           $tawjeeh=TawjeehClass::where('passport_id',$passport->id)->first();
                           $tawjeeh_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','19')->first();
                    $stop_resume_tawjeeh= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','19')->first();


                           //--------------- process 13-----------
                                //--------------- process 14-----------
                        $new_contract_sub=NewContractSubmission::where('passport_id',$passport->id)->first();
                        $new_contract_sub_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','20')->first();
                    $stop_resume_new_contract_sub= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','20')->first();
                    $payment_new_contract_sub= DB::table('visa_payment_options')->where('passport_id',$passport->id)->where('visa_process_step_id','20')->first();

                        //--------------- process 14-----------
                        //--------------- process 15-----------
                        $labour_card=LabourCard::where('passport_id',$passport->id)->first();
                        $labour_card_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','21')->first();
                    $stop_resume_labour_card= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','21')->first();

                        //--------------- process 15-----------
                         //--------------- process 16-----------
                         $visa_stamp=VisaStamping::where('passport_id',$passport->id)->first();
                         $visa_stamp_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','22')->first();
                    $stop_resume_visa_stamp= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','22')->first();

                         //--------------- process 16-----------
                         //--------------- process 17-----------
                         $waiting=WaitingForApproval::where('passport_id',$passport->id)->first();
                         $waiting_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','23')->first();
                    $stop_resume_waiting= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','23')->first();

                         //--------------- process 17ends-----------
                         //--------------- process 18-----------
                         $zajeel=WaitingForZajeel::where('passport_id',$passport->id)->first();
                         $zajeel_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','24')->first();
                    $stop_resume_zajeel= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','24')->first();


                             //--------------- process 18 ends-----------
                                      //--------------- process 18-----------
                         $visa_pasted=VisaPasted::where('passport_id',$passport->id)->first();
                         $visa_pasted_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','25')->first();
                    $stop_resume_visa_pasted= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','25')->first();



                         //--------------- process 18 ends-----------
                         $unique=UniqueEmailId::where('passport_id',$passport->id)->first();
                         $unique_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','26')->first();
                    $stop_resume_unique= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','26')->first();



                         $unique_id=UniqueEmailIdHandover::where('passport_id',$passport->id)->first();
                         $unique_id_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','27')->first();
                    $stop_resume_unique_id= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','27')->first();



                    $labour_insurance=VisaProcessLabourInsurance::where('passport_id',$passport->id)->first();
                    $labour_insurance_amount=AssigningAmount::where('passport_id',$passport->id)->where('master_step_id','28')->first();
                     $stop_resume_labour_insurance= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->where('visa_process_step_id','28')->first();



                         //-----------------------------------------------------
                         $currnet_status=CurrentStatus::where('passport_id',$passport->id)->first();
                         if ($currnet_status != null) {
                             $current_status_id = $currnet_status->passport_id;
                             $currnet_status_pass = $currnet_status->current_process_id;
                             $next_status_id = $currnet_status_pass + 1;
                         }
                         else{
                          $next_status_id='2';
                                 }
                        //----------------------------fine starts----------------------

                        $career= Career::where('passport_no',$request->keyword)->first();
                        if(!empty($career)){
                            $fine_starts=$career->exit_date;
                        }
                        else{
                            $fine_starts='null';
                        }
                        $stop_resume= DB::table('visa_process_resume_and_stops')->where('passport_id',$passport->id)->latest('created_at')->first();

                        // $=VisaProcessResumeAndStop::where('passport_id',$passport->id)->first();
                        // dd($stop_resume);


                        //----------------------------fine starts----------------------


                        //-----------assignmed amount details...

                        // $offer_letter_sub_amount=AssigningAmount::where('passport_id',$passport->id)->pluck('id')->toArray();




                    // dd($stop_resume_status_change);

                    $cancel_between= BetweenVisaCancel::where('passport_id',$passport->id)->where('status','1')->first();

                    $payroll_deductction=AgreedAmount::where('passport_id',$passport->id)->first();
                   if($payroll_deductction != null){
                    $payroll_amount=$payroll_deductction->payroll_deduct_amount;
                   }
                   else{
                    $payroll_amount='0';
                   }
                //    dd($offer_letter);
        // dd($payment_offer_letter);
        $cancel_between= BetweenVisaCancel::where('passport_id',$passport->id)->first();
        $bypass = BypassVisa::where('passport_id',$passport->id)->first();
        $CurrentStatus = CurrentStatus ::where('passport_id',$passport->id)->first();
        //check for visa process
        $rider_not_visas = Passport\Passport::where('id',$passport->id)->where('career_id','=','0')->whereNull('visa_status')->first();
        if($rider_not_visas==null){
            $rider_visa_status='1';
        }
        else{
            $rider_visa_status='0';
        }


        $passport_start = Passport\Passport::where('id',$passport->id)->first();



        if($passport_start->career_id!=0){
        $career_status = Career ::where('id',$passport_start->career_id)->whereNotNull('visa_process_start_status')->first();
        }

        if($CurrentStatus!=null){
            $visa_start_status='1';
            }
        elseif($passport_start->visa_process_start_status==null){
            $visa_start_status='0';
        }elseif(isset($career_status)){
            $visa_start_status='1';
        }

        else{
            $visa_start_status='1';
        }
      




        $view = view("admin-panel.visa-master.visa_process.ajax_files.get_names_detail", compact('passport_id','name','ppuid','passport_no','remain_days','image',
        'offer_letter','offer_letter_amount','offer_letter_sub','offer_letter_sub_amount','electronic_pre_approval','electronic_pre_approval_amount','electronic_pre_approval_pay',
        'electronic_pre_approval_pay_amount','print_inside_out_side','print_inside_out_side_amount','status_change','status_change_amount','in_out_change','in_out_amount',
        'entry_date','entry_date_amount','med_normal','med_normal_amount','med_48','med_48_amount','med_24','med_24_amount','med_vip','med_vip_amount','fit_unfit','fit_unfit_amount'
        ,'emirates_id_apply','emirates_id_apply_amount','figer_print','new_contract','new_contract_amount','tawjeeh','new_contract_sub','new_contract_sub_amount',
        'labour_card','labour_card_amount','visa_stamp','visa_stamp_amount','waiting','zajeel','visa_pasted','unique','unique_id','next_status_id','fine_starts','figer_print_amount','fit_unfit_amount','tawjeeh_amount','waiting_amount',
        'zajeel_amount','visa_pasted_amount','unique_amount','unique_id_amount','payroll_amount','stop_resume','stop_resume_offer_letter','stop_resume_offer_letter_sub','stop_resume_electronic_pre_approval','stop_resume_electronic_pre_approval_pay','stop_resume_print_inside_out_side','stop_resume_status_change',
        'stop_resume_in_out_change','stop_resume_entry_date','stop_resume_med_normal','stop_resume_med_48','stop_resume_med_24','stop_resume_med_vip','stop_resume_fit_unfit','stop_resume_figer_print','stop_resume_new_contract','stop_resume_tawjeeh','stop_resume_new_contract_sub','stop_resume_labour_card','stop_resume_visa_stamp',
        'stop_resume_waiting','stop_resume_zajeel','stop_resume_visa_pasted','stop_resume_unique','stop_resume_unique_id','replacement_inside_out_side','replacement_status_change','replacement_in_out_change',
        'cancel_between','req','own_visa','labour_insurance','labour_insurance_amount','stop_resume_labour_insurance','bypass','rider_not_visas','rider_visa_status','visa_start_status','replacement_req'))->render();

        return response()->json(['html' => $view]);


    }
     public function visa_process_offer_letter(Request $request){
         $id=$request->id;
         $offer_letter=Offer_letter::where('passport_id',$id)->first();
         $payment_offer_letter= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','2')->first();

         $by_pass=BypassVisa::where('passport_id',$id)->count();
         if($by_pass=='0'){
             $req='0';
         }
         else{
            $req='1';
         }

        //  dd($offer_letter);
         $company=Company::all();
         $job=Designation::all();
         $payment_type=PaymentType::all();




         $view = view("admin-panel.visa-master.visa_process.ajax_files.offer_letter_form", compact('offer_letter','company','job','payment_type','id','payment_offer_letter','req'))->render();
         return response()->json(['html' => $view]);
     }

     public function visa_process_offer_letter_sub(Request $request){
        $id=$request->id;
        $offer_sub_letter=Offer_letter_submission::where('passport_id',$id)->first();
        $payment_offer_sub_letter= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','3')->first();

        $company=Company::all();
        $job=Designation::all();
        $payment_type=PaymentType::all();

        $by_pass=BypassVisa::where('passport_id',$id)->count();
         if($by_pass=='0'){
             $req='0';
         }
         else{
            $req='1';
         }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.offer_letter_submission_form", compact('offer_sub_letter','req','company','job','payment_type','id','payment_offer_sub_letter'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_electronic_pre_app(Request $request){
        $id=$request->id;
        $elec_pre_app=ElectronicPreApproval::where('passport_id',$id)->first();
        $payment_elec_pre_app= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','4')->first();

        $payment_type=PaymentType::all();

        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.elec_pre_app_form", compact('req','elec_pre_app','payment_type','id','payment_elec_pre_app'))->render();
        return response()->json(['html' => $view]);
    }


    public function visa_process_electronic_pre_app_pay(Request $request){
        $id=$request->id;
        $elec_pre_app_pay=ElectronicPreApprovalPayment::where('passport_id',$id)->first();
        $payment_elec_pre_app_pay= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','5')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.elec_pre_app_pay", compact('req','elec_pre_app_pay','payment_type','id','payment_elec_pre_app_pay'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_print_inside_outside(Request $request){
        $id=$request->id;
        $print_inside=EntryPrintOutside::where('passport_id',$id)->first();
        $payment_print_inside= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','7')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.print_inside_outside", compact('req','print_inside','payment_type','id','payment_print_inside'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_status_change(Request $request){
        $id=$request->id;
        $status_change=StatusChange::where('passport_id',$id)->first();
        $in_out_status=InOutStatusChange::where('passport_id',$id)->first();
        $payment_status_change= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','8')->first();
        $payment_in_out_status= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','9')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.status_change_form", compact('req','status_change','in_out_status','payment_type','id','payment_status_change','payment_in_out_status'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_entry_date(Request $request){
        $id=$request->id;
        $entry_date=EntryDate::where('passport_id',$id)->first();
        $payment_type=PaymentType::all();
        $payment_entry_date= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','10')->first();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }


        $view = view("admin-panel.visa-master.visa_process.ajax_files.entry_date_form", compact('req','entry_date','payment_type','id','payment_entry_date'))->render();
        return response()->json(['html' => $view]);
    }
    public function visa_process_medical(Request $request){
        $id=$request->id;
        $med_normal=MedicalNormal::where('passport_id',$id)->first();
        $payment_med_normal=VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','11')->first();
        $med_48=Medical48::where('passport_id',$id)->first();
        $payments_med_48= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','12')->first();


        $med_24=Medical24::where('passport_id',$id)->first();
        $payments_med_24= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','13')->first();

        $med_vip=MedicalVIP::where('passport_id',$id)->first();
        $payment_med_vip= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','14')->first();

        $payment_type=PaymentType::all();

        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.medical_form", compact('req','med_normal','med_48','med_24','med_vip','payment_type','id' ,'payment_med_normal','payments_med_48',
        'payments_med_24','payment_med_vip'))->render();
        return response()->json(['html' => $view]);
    }
    public function visa_process_fit_unfit(Request $request){
        $id=$request->id;
        $fit_unfit=FitUnfit::where('passport_id',$id)->first();
        $payment_fit_unfit= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','15')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.fit_unfit_form", compact('req','fit_unfit','payment_type','id','payment_fit_unfit'))->render();
        return response()->json(['html' => $view]);
    }


    public function visa_process_emirates_id_apply(Request $request){
        $id=$request->id;
        $emirates_app=EmiratesIdApply::where('passport_id',$id)->first();
        $stop_resume_emirates_app= DB::table('visa_process_resume_and_stops')->where('passport_id',$id)->where('visa_process_step_id','16')->first();
        $payment_emirates_app= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','16')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.emirates_id_form", compact('req','emirates_app','payment_type','id','stop_resume_emirates_app','payment_emirates_app'))->render();
        return response()->json(['html' => $view]);
    }
    public function visa_process_finger_print(Request $request){
        $id=$request->id;
        $finger_print=EmiratesIdFingerPrint::where('passport_id',$id)->first();
        $payment_finger_print= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','17')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.finger_print_form", compact('req','finger_print','payment_type','id','payment_finger_print'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_new_contract(Request $request){
        $id=$request->id;
        $new_contract=NewContractAppTyping::where('passport_id',$id)->first();

        $payment_new_contract=VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','18')->first();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $payment_type=PaymentType::all();

        $offer_letter_sub=Offer_letter_submission::where('passport_id', $id)->first();
        $mb_no=isset($offer_letter_sub->mb_no)?$offer_letter_sub->mb_no:"N/A";
        $view = view("admin-panel.visa-master.visa_process.ajax_files.new_contract_form", compact('mb_no','req','new_contract','payment_type','id','payment_new_contract'))->render();
        return response()->json(['html' => $view]);
    }


    public function visa_process_tawjeeh(Request $request){
        $id=$request->id;
        $tawjeeh=TawjeehClass::where('passport_id',$id)->first();
        $payment_tawjeeh=VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','19')->first();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $payment_type=PaymentType::all();
        $view = view("admin-panel.visa-master.visa_process.ajax_files.tawjeeh_form", compact('req','tawjeeh','payment_type','id','payment_tawjeeh'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_new_contract_sub(Request $request){
        $id=$request->id;
        $new_contract_sub=NewContractSubmission::where('passport_id',$id)->first();
        $payment_new_contract_sub= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','20')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.new_contract_sub_form", compact('req','new_contract_sub','payment_type','id','payment_new_contract_sub'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_new_labout_card(Request $request){
        $id=$request->id;
        $labour_card=LabourCard::where('passport_id',$id)->first();
        $payment_labour_card= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','21')->first();


        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $elec_pre_app=ElectronicPreApproval::where('passport_id',$id)->first();
        $labour_card_no=isset($elec_pre_app->labour_card_no)?$elec_pre_app->labour_card_no:"N/A";
        $view = view("admin-panel.visa-master.visa_process.ajax_files.labour_card_form", compact('labour_card_no','req','labour_card','payment_type','id','payment_labour_card'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_visa_stamp(Request $request){
        $id=$request->id;
        $visa_stamp=VisaStamping::where('passport_id',$id)->first();
        $payment_visa_stamp= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','22')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.visa_stamp_form", compact('req','visa_stamp','payment_type','id','payment_visa_stamp'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_waiting(Request $request){
        $id=$request->id;
        $approval=WaitingForApproval::where('passport_id',$id)->first();
        $payment_approval= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','23')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.waiting_approval_form", compact('req','approval','payment_type','id','payment_approval'))->render();
        return response()->json(['html' => $view]);
    }
    public function visa_process_zajeel(Request $request){
        $id=$request->id;
        $zajeel=WaitingForZajeel::where('passport_id',$id)->first();
        $payment_zajeel= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','24','zajeel')->first();

        $payment_type=PaymentType::all();

        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.waiting_zajeel_form", compact('req','zajeel','payment_type','id'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_visa_pasted(Request $request){
        $id=$request->id;
        $visa_pasted=VisaPasted::where('passport_id',$id)->first();
        $payment_visa_pasted= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','25')->first();
        $visa_application_data=VisaApplication::where('passport_id',$id)->first();


        $states=Cities::all();


        $companies=Company::all();

        $professions = Designation::all();


        $payment_type=PaymentType::all();

        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

            $print_visa=EntryPrintOutside::where('passport_id',$id)->first();
        //eid
            $emirates_id=Emirates_id_cards::where('passport_id',$id)->first();
            $visa_pasted= VisaPasted::where('passport_id',$id)->first();
        //state from company and offer letter
            $offer_letter= Offer_letter::where('passport_id',$id)->first();

            // UID Number

            // EID Number
            // File Number
            // State
            // Visa Profession
            // Visa Company

            // Date of Issue

            // Expiry Date

        $view = view("admin-panel.visa-master.visa_process.ajax_files.visa_pasted_form", compact('companies','professions','states','req',
        'visa_pasted','payment_type','id','payment_visa_pasted','emirates_id','visa_pasted','offer_letter','print_visa','visa_application_data'))->render();
        return response()->json(['html' => $view]);
    }
       public function visa_process_unique(Request $request){
        $id=$request->id;
        $unique=UniqueEmailId::where('passport_id',$id)->first();
        $visa_pasted=VisaPasted::where('passport_id',$id)->first();
        $payment_unique= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','26')->first();
        $visa_application_data=VisaApplication::where('passport_id',$id)->first();

        $eid= Emirates_id_cards::where('passport_id',$id)->first();

        $payment_type=PaymentType::all();

        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.unique_form", compact('visa_application_data','visa_pasted','eid','req','unique','payment_type','id','unique'))->render();
        return response()->json(['html' => $view]);
    }
    public function visa_process_unique_id(Request $request){
        $id=$request->id;
        $handover=UniqueEmailIdHandover::where('passport_id',$id)->first();
        $payment_handover= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','27')->first();

        $payment_type=PaymentType::all();
        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }
        $view = view("admin-panel.visa-master.visa_process.ajax_files.unique__id_form", compact('req','handover','payment_type','id','payment_handover'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_labour_insurance(Request $request){
        $id=$request->id;
        $labour_insurance=VisaProcessLabourInsurance::where('passport_id',$id)->first();
        $payment_labour_insurance= VisaPaymentOptions::where('passport_id',$id)->where('visa_process_step_id','28')->first();

        $payment_type=PaymentType::all();

        $by_pass=BypassVisa::where('passport_id',$id)->count();
        if($by_pass=='0'){
            $req='0';
        }
        else{
           $req='1';
        }

        $view = view("admin-panel.visa-master.visa_process.ajax_files.labour_insurance", compact('req','labour_insurance','payment_type','id','payment_labour_insurance'))->render();
        return response()->json(['html' => $view]);
    }
//-------------Stop Resume functions-------------------------

    public function visa_process_stop_resume(Request $request){
        $id=$request->id;
        $user_id=auth()->user()->id;
        $step=$request->step;
        $stop_and_resume=VisaProcessResumeAndStop::where('passport_id',$id)->where('visa_process_step_id',$step)->first();

        $view = view("admin-panel.visa-master.visa_process.stop_resume_files.index", compact('stop_and_resume','id','user_id','step'))->render();
        return response()->json(['html' => $view]);
    }


        public function stop_resume_save(Request $request){




            if($request->input('row_id')==null){



            $obj = new VisaProcessResumeAndStop();
            $obj->passport_id = $request->input('passport_id');
            $obj->visa_process_step_id = $request->input('visa_process_step_id');
            $obj->remarks = $request->input('remarks');
            $obj->user_id = $request->input('user_id');
            $obj->time_and_date = $request->input('time_and_date');
            $obj->status = '1';
            $obj->save();

            $passport_id= $request->input('passport_id');
            $passport=PassportPassport::where('id',$passport_id)->first();
            $pass_no=$passport->passport_no;
        return response()->json([
            'code' => "100",
            'passport_no'=>$pass_no
        ]);
    }
    else{

        $obj = VisaProcessResumeAndStop::find($request->input('row_id'));
        $obj->resume_remarks=$request->input('resume_remarks');
        $obj->resume_time_and_date=$request->input('resume_time_and_date');
        $passport_id= $request->input('passport_id');
        $obj->status = '2';
        $obj->save();
        $passport=PassportPassport::where('id',$passport_id)->first();
         $pass_no=$passport->passport_no;
        return response()->json([
            'code' => "101",
            'passport_no'=>$pass_no
        ]);

    }


    }


    public function visa_process_replacement(Request $request){
        $passport_id=$request->id;


        $user_id=auth()->user()->id;
        $visa_process_step_id=$request->step;


        $replacement_req= DB::table('replacement_requests')->where('passport_id',$passport_id)->where('status','1')->first();
        $passport_id_rep=$replacement_req->replace_to_passport_id;
        if($passport_id_rep != null){
            $passport_rep=PassportPassport::where('id',$passport_id_rep)->first();
            $passport_no_to=$passport_rep->passport_no;
            $passport_id_to=$passport_rep->id;
        }
        else{
            $passport_no_to=null;
            $passport_id_to=null;
        }



        // $stop_and_resume=VisaProcessResumeAndStop::where('passport_id',$passport_id)->where('visa_process_step_id',$visa_process_step_id)->first();
        $repalancement=ReplacementVisaCancel::where('passport_id',$passport_id)->where('visa_process_id',$visa_process_step_id)->first();

        // $stop_and_resume_id=$stop_and_resume->id;
        $stop_and_resume_id=null;
        $view = view("admin-panel.visa-master.visa_process.stop_resume_files.replacement", compact('passport_id_to','passport_no_to','repalancement','passport_id','user_id','visa_process_step_id','stop_and_resume_id'))->render();
        return response()->json(['html' => $view]);
    }

    public function visa_process_replacement_save(Request $request){

        $passport=PassportPassport::where('passport_no',$request->input('replaced_passport_id'))->first();
        $passport_id=$passport->id;

        //offerletter
        //offerletterSub
        //electronic pre approcva
        //electrinic pre app pay
        //labour insurance

//         Offer_letter
// Offer_letter_submission
// ElectronicPreApproval
// ElectronicPreApprovalPayment
// VisaProcessLabourInsurance
     DB::table('offer_letters')->where('passport_id', $request->input('passport_id'))
        ->update(['passport_id' => $passport_id,
        'replace_status'=>'1']);
    DB::table('offer_letter_submission')->where('passport_id', $request->input('passport_id'))
    ->update(['passport_id' => $passport_id,
    'replace_status'=>'1',
        ]);
    DB::table('electronic_pre_approval')->where('passport_id', $request->input('passport_id'))
    ->update(['passport_id' => $passport_id,
    'replace_status'=>'1',
    ]);


    DB::table('electronic_pre_approval_payments')->where('passport_id', $request->input('passport_id'))
    ->update(['passport_id' =>  $passport_id,
    'replace_status'=>'1',
    ]);

    DB::table('visa_process_labour_insurances')->where('passport_id', $request->input('passport_id'))
    ->update(['passport_id' => $passport_id,
    'replace_status'=>'1',
    ]);
    DB::table('current_status')->where('passport_id', $request->input('passport_id'))
    ->update(['passport_id' => $passport_id]);

    DB::table('visa_payment_options')->where('passport_id', $request->input('passport_id'))->where('visa_process_step_id','28')
    ->update(['passport_id' => $passport_id]);

    DB::table('visa_payment_options')->where('passport_id', $request->input('passport_id'))->where('visa_process_step_id','5')
    ->update(['passport_id' => $passport_id]);


        $obj = new ReplacementVisaCancel();
        $obj->passport_id = $request->input('passport_id');
        $obj->replaced_passport_id = $passport_id;
        $obj->visa_process_id = $request->input('visa_process_id');
        $obj->remarks = $request->input('remarks');
        $obj->user_id = $request->input('user_id');
        $obj->stop_and_resume_id = null;
        $obj->status = '1';
        $obj->save();
        $passport_id= $request->input('passport_id');
        $passport=PassportPassport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;

    return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
    ]);
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
        $passport_no= $request->input('passport_no');

        $passport=Passport\Passport::where('passport_no',$passport_no)->get();
        $work_permit=Work_permit::where('passport_number',$passport_no)->get();
        $result=Work_permit::all();
        $result2=count($work_permit);
        $nationality=Nationality::first();

        return view('admin-panel.masters.view_permit',compact('passport','work_permit','nationality','result2','result'));
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
    public function ajax_get_passport(Request $request){



        $pass = Passport\Passport::find($request->passport_id);


        $expiry_date=$pass->date_expiry;
        $curr_date=date('Y-m-d');
        $date1 = strtotime($curr_date);
        $date2 = strtotime($expiry_date);
        $diff = abs($date2 - $date1);

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)
            / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 -
                $months*30*60*60*24)/ (60*60*24));

        $remain_days= $years." years ".$months." months ".$days." days";

        $response = $pass->sur_name."$".$pass->given_names."$".$pass->passport_pic."$".$remain_days;


        return $response;


    }


    public function amountstore(Request $request)
    {
        $obj = new AssigningAmount();
        $count_step=$request->input('master_step_id');
        $count_pass = $request->input('passport_id');
        $amount=AssigningAmount::where('passport_id',$count_pass)->where('master_step_id',$count_step)->count();
       if ($amount=='1'){
           $message = [
               'message' => 'Amount for this step already assinged',
               'alert-type' => 'error'
           ];
           return redirect()->back()->with($message);
       }

        $obj->amount = $request->input('amount');
        $obj->master_step_id = $request->input('master_step_id');
        $obj->passport_id = $request->input('passport_id');

        $obj->save();


        $message = [
            'message' => 'Added Successfully',
            'alert-type' => 'success'
        ];





    }


    public function labour_card_type(Request $request)
    {

        $obj = new LabourCardTypeAssign();
        $obj->passport_id = $request->input('passport_id');
        $obj->labour_card_type_id = $request->input('card_type');
        $obj->save();


        $message = [
            'message' => 'Labour Card Type Added Successfully',
            'alert-type' => 'success'
        ];
       return redirect()->back()->with($message);



    }

    public function visasteps(Request $request)
    {

        $pass_id=$request->input('passport_id');
        $passport_table=Passport\Passport::where('id',$pass_id)->first();
//get the passport no
        $passport_no=$passport_table->passport_no;

        $career= Career::where('passport_no',$passport_no)->first();

        $visa_status= $career->visa_status;
        $fine_start=$career->exit_date;

        // dd($fine_start);



        if($visa_status=='3'){
            $visa_status_own= $career->visa_status_own;


            if($visa_status_own=='2'){
             $message = [
                'message' => 'Own Visa Without NOC! Visa Not Required!',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($message);
            }
        }


        $passport=Passport\Passport::all();
        $company=Company::all();
        $job=Designation::all();
        $payment_type=PaymentType::all();
        $labour_card_type=LabourCardType::all();

        $pass=Passport\Passport::where('passport_no',$passport_no)->get();
        $pass2=Passport\Passport::where('passport_no',$passport_no)->first();
        $pass_id=$pass2->id;
        $steps=Master_steps::all();
        $amount=AssigningAmount::where('passport_id',$pass_id)->get();
        $agreeCount=Agreement::where('passport_id',$pass_id)->count();



        // if ($agreeCount==0){
        //     $message = [
        //         'message' => 'Agreement Not Singed Yet',
        //         'alert-type' => 'error'
        //     ];



            // dd($message);
            // return redirect()->route('star')->with($message);

//             return redirect()->back()->with($message);
// //

//         }
        // $agreement=Agreement::where('passport_id',$pass_id)->first();
        // $employee_type=$agreement->employee_type_id;
        // if ($employee_type=='1'){
        //     $message = [
        //         'message' => 'Visa Process Not Required',
        //         'alert-type' => 'error'
        //     ];
        //     return redirect()->back()->with($message);

        // }

//-------------passport info-------------------

        $passport_name=Passport\Passport::find($pass_id);
        $expiry_date=$passport_name->date_expiry;
        $curr_date=date('Y-m-d');
        $date1 = strtotime($curr_date);
        $date2 = strtotime($expiry_date);
        $diff = abs($date2 - $date1);
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)
            / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 -
                $months*30*60*60*24)/ (60*60*24));
        $remain_days= $years." years ".$months." months ".$days." days";
        //---------------------------

        $offer_key=Offer_letter::where('passport_id',$pass_id)->first();
        $offer_sub_key=Offer_letter_submission::where('passport_id',$pass_id)->first();
        $elec_pre_key=ElectronicPreApproval::where('passport_id',$pass_id)->first();
        $elec_pre_pay_key=ElectronicPreApprovalPayment::where('passport_id',$pass_id)->first();
        $print_inside_key=EntryPrintOutside::where('passport_id',$pass_id)->first();
        $print_outside_key=EntryPrintOutside::where('passport_id',$pass_id)->first();
        $status_change_key=StatusChange::where('passport_id',$pass_id)->first();
        $in_out_status_key=InOutStatusChange::where('passport_id',$pass_id)->first();
        $entry_date_key=EntryDate::where('passport_id',$pass_id)->first();
        $medical_normal_key=MedicalNormal::where('passport_id',$pass_id)->first();
        $medical_48_key=Medical48::where('passport_id',$pass_id)->first();
        $medical_24_key=Medical24::where('passport_id',$pass_id)->first();
        $medical_vip_key=MedicalVIP::where('passport_id',$pass_id)->first();
        $fit_unfit_key=FitUnfit::where('passport_id',$pass_id)->first();
        $eid_finger_key=EmiratesIdFingerPrint::where('passport_id',$pass_id)->first();
        $tawjeeh_key=TawjeehClass::where('passport_id',$pass_id)->first();
        $emirates_id_key=EmiratesIdApply::where('passport_id',$pass_id)->first();
        $new_contract_id_key=NewContractAppTyping::where('passport_id',$pass_id)->first();
        $new_contract_sub_key=NewContractSubmission::where('passport_id',$pass_id)->first();
        $labour_card_key=LabourCard::where('passport_id',$pass_id)->first();
        $visa_staming_key=VisaStamping::where('passport_id',$pass_id)->first();
        $visa_pasted_key=VisaPasted::where('passport_id',$pass_id)->first();
        $unique_key=UniqueEmailId::where('passport_id',$pass_id)->first();
        $approval_key=WaitingForApproval::where('passport_id',$pass_id)->first();
        $handover_key=UniqueEmailIdHandover::where('passport_id',$pass_id)->first();
        $zajeel_key=WaitingForZajeel::where('passport_id',$pass_id)->first();
        $labour_card_type_key= LabourCardTypeAssign::where('passport_id',$pass_id)->first();
        $inside_outside_status=EntryPrintOutside::where('passport_id',$pass_id)->first();




//--------------------offer letter-------------
            if ($inside_outside_status != null) {
                $status_inside_outside = $inside_outside_status->inside_out_status;

            }
            //--------------------offer letter-------------
            if ($labour_card_type_key != null) {
                $labour_card_type_id = $labour_card_type_key->id;
                $labour_card_type_assign=LabourCardType::find($labour_card_type_id);
            }

            //--------------------offer letter-------------
            if ($offer_key != null) {
                $offer_id = $offer_key->id;
                $offer_letter=Offer_letter::find($offer_id);
            }
        //--------------------offer letter Submission-------------
        if ($offer_sub_key != null) {
            $offer_sub_id = $offer_sub_key->id;
            $offer_sub_letter=Offer_letter_submission::find($offer_sub_id);
        }

        //--------------------Electronic Pre Approval-------------
        if ($elec_pre_key != null) {
            $elec_pre_id = $elec_pre_key->id;
            $elec_pre_app=ElectronicPreApproval::find($elec_pre_id);
        }
        if ($elec_pre_pay_key != null) {
            $elec_pre_pay_id = $elec_pre_pay_key->id;
            $elec_pre_app_pay=ElectronicPreApprovalPayment::find($elec_pre_pay_id);
        }
        //--------------------Inside-------------
        if ($print_inside_key != null) {
            $inside_id = $print_inside_key->id;
            $print_inside=EntryPrintOutside::find($inside_id);
        }

        //--------------------outisde-------------
        if ($print_outside_key != null) {
            $outside_id = $print_outside_key->id;
            $print_outside=EntryPrintOutside::find($outside_id);

        }
        //--------------------Status Chage-------------
        if ($status_change_key != null) {
            $status_id = $status_change_key->id;
            $status_change=StatusChange::find($status_id);

        }
        //--------------------In out Status Chage-------------
        if ($in_out_status_key != null) {
            $inout_id = $in_out_status_key->id;
            $in_out_status=InOutStatusChange::find($inout_id);

        }
        //--------------------entryd ate-------------
        if ($entry_date_key != null) {
            $entry_id = $entry_date_key->id;
            $entry_date=EntryDate::find($entry_id);

        }
        //--------------------Medical normal-------------
        if ($medical_normal_key != null) {
            $med_nor_id = $medical_normal_key->id;
            $med_normal=MedicalNormal::find($med_nor_id);

        }
        //--------------------Medical 48-------------
        if ($medical_48_key != null) {
            $med_48_id = $medical_48_key->id;
            $med_48=Medical48::find($med_48_id);

        }//--------------------Medical 24-------------
        if ($medical_24_key != null) {
            $med_24_id = $medical_24_key->id;
            $med_24=Medical24::find($med_24_id);

        }
        //--------------------Medical vip-------------
        if ($medical_vip_key != null) {
            $med_vip_id = $medical_vip_key->id;
            $med_vip=MedicalVIP::find($med_vip_id);

        }
        //--------------------Fit Unfit-------------
        if ($fit_unfit_key != null) {
            $fit_unfit_id = $fit_unfit_key->id;
            $fit_unfit=FitUnfit::find($fit_unfit_id);

        }
        if ($emirates_id_key != null) {
            $em_id= $emirates_id_key->id;
            $emirates_app=EmiratesIdApply::find($em_id);

        }
        //--------------------new contact-------------
        if ($new_contract_id_key != null) {
            $new_conrtact_id = $new_contract_id_key->id;
            $new_contract=NewContractAppTyping::find($new_conrtact_id);

        }
        //--------------------new contact submission-------------
        if ($new_contract_sub_key != null) {
            $new_conrtact_sub_id = $new_contract_sub_key->id;
            $new_contract_sub=NewContractSubmission::find($new_conrtact_sub_id);

        }
        //--------------------Labour Card-------------
        if ($labour_card_key != null) {
            $labour_id = $labour_card_key->id;
            $labour_card=LabourCard::find($labour_id);

        }
        //--------------------Visa Stamping-------------
        if ($visa_staming_key != null) {
            $visa_staming_id = $visa_staming_key->id;
            $visa_stamp=VisaStamping::find($visa_staming_id);

        }
        //--------------------Visa Stamping-------------
        if ($visa_pasted_key != null) {
            $visa_pasted_id = $visa_pasted_key->id;
            $visa_pasted=VisaPasted::find($visa_pasted_id);

        }
        //--------------------unique Email Id-------------
        if ($unique_key != null) {
            $unique_id = $unique_key->id;
            $unique=UniqueEmailId::find($unique_id);

        }
        if ($eid_finger_key != null) {
            $finger_id = $eid_finger_key->id;
            $finger_print=EmiratesIdFingerPrint::find($finger_id);

        }
        if ($tawjeeh_key != null) {
            $tawjeeh_id = $tawjeeh_key->id;
            $tawjeeh=TawjeehClass::find($tawjeeh_id);

        }
        if ($approval_key != null) {
            $approval_id = $approval_key->id;
            $approval=WaitingForApproval::find($approval_id);

        }
        if ($handover_key != null) {
            $handover_id = $handover_key->id;
            $handover=UniqueEmailIdHandover::find($handover_id);

        }
        if ($zajeel_key != null) {
            $zajeel_id = $zajeel_key->id;
            $zajeel=WaitingForZajeel::find($zajeel_id);

        }

//------------------current_status and next status we are getting here---------
        $currnet_status=CurrentStatus::where('passport_id',$pass_id)->first();
        if ($currnet_status != null) {
            $current_status_id = $currnet_status->passport_id;
            $currnet_status_pass = $currnet_status->current_process_id;
            $next_status_id = $currnet_status_pass + 1;
        }
        else{
         $next_status_id='2';
                }


        return view('admin-panel.visa-master.visa_master',compact('passport','company','steps','pass','amount','offer_letter'
            ,'offerLenght','offer_sub_letter','elec_pre_app','print_inside','print_outside','status_change','in_out_status',
            'entry_date','med_normal','med_48','med_24','med_vip','fit_unfit','emirates_app','new_contract','new_contract_sub',
            'labour_card','visa_stamp','visa_pasted','unique','finger_print','tawjeeh',
            'approval','handover','elec_pre_app_pay','emirates_app','zajeel','employee_type','job','next_status_id'
            ,'passport_name','remain_days','payment_type','labour_card_type','labour_card_type_assign','status_inside_outside','visa_status_own','fine_start'));


    }


    public function visa_process_dashboard(){

        //fine starts next week
        $nextWeek = date("Y-m-d", strtotime("+7 day"));
        $passedMonth = date("Y-m-d", strtotime("-30 day"));

        $today=date("Y-m-d");
        $fine_starts_next_week= Career::whereBetween('exit_date',[$today,$nextWeek])->get();
        $fine_already_passed= Career::whereBetween('exit_date',[$passedMonth,$today])->get();


        //--------fine starts next week ends----------------------

        $steps=Master_steps::all();
        // dd($steps);

        $steps->shift(0);
        $steps->shift(9);
        $company=Company::where('type', '=', '1')->get();
    //    dd()
        // $company->shift(1);

        $data_label = "";
        $data_label_values = "";

        foreach ($steps as $step){
            $data_label .= "'$step->step_name'".",";

            $value = CurrentStatus::select('current_process_id', DB::raw('count(id) as total'))->where('current_process_id','=',$step->id)->groupBy('current_process_id')->first();

            if(!empty( $value)){
                $data_label_values .= "{$value->total}".",";
            }else{
                $zero = "0";
                $data_label_values .= "$zero".",";
            }
        }

       if(isset($data_label)) {
           $data_label = trim($data_label, ",");
           $data_label_values = trim($data_label_values, ",");

       }

       //employees by visa companies

       $data_plateform = "";
       $data_plateform_values = "";
       $concat = "";
       foreach ($company as $com){
           $data_plateform = "name:"."'$com->name'"."}, ";
           $value2 = Offer_letter::select('company', DB::raw('count(id) as total_plate_form'))->where('company','=',$com->id)->groupBy('company')->first();
           if(!empty( $value2)){
               $data_plateform_values = "{ value:"."{$value2->total_plate_form}".",";
           }else{
               $zero2 = "0";
               $data_plateform_values = "{ value:"."$zero2".",";

           }
           $concat .= $data_plateform_values.''.$data_plateform;
           $ab = '.$zero2.'.',';
           $srting_append = '{value: 335,name: '.$ab.'}';
       }

       $data_plateform = trim($data_plateform,",");
       $data_plateform_values = trim($data_plateform_values,",");

    //    ---------------process to be starts---------------------------

    $current_steps=array();
    $current_status=CurrentStatus::all();
    $master_steps= Master_steps ::all();
    $master_steps->shift(0);
    $master_steps->shift(9);
    foreach($master_steps as $row){
        $gamer = array(
            'step_name' =>  $row->step_name,
            'no' =>  count($current_status->where('current_process_id',$row->id-1)),
        );
        $current_steps[] = $gamer;
    }



// ----------------------------------
// visa process to start
$data = array();
$career = Career::where('visa_process_start_status','=' ,null)->where('visa_status','1')->pluck('id')->toArray();
$pass_id = CurrentStatus::pluck('passport_id')->toArray();
$visa_not_started = PassportPassport::whereNotIn('id',$pass_id)->pluck('id')->toArray();
//check career id if it is not null, meanas that it has career,
//check the visa_status, if it is 1
// visa_process_start_status
$passport=PassportPassport::whereIn('career_id',$career)->pluck('id')->toArray();
$visa_process_to_start= PassportPassport::whereIn('id',$passport)->orWhere('visa_status','1')->where('visa_process_start_status', null)->limit('10')->get();
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
$pass=PassportPassport::where('id',$row->id)->first();
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

}
$data[] = $gamer;
}
}
//new visa Process ends here
// dd($data);
//visa prcess to be renewed
    $curr_date=date('Y-m-d');
    $renewed_visas= RenewAgreedAmount::pluck('passport_id');
    $visa_pasted= VisaPasted::whereNotIn('passport_id',$renewed_visas)->where('expiry_date' ,'<',$curr_date)->limit(10)->get();
    //visa process to be renewd ends here
// own_visa_process to start


$own_visa=array();
$career = Career::where('visa_process_start_status','=' ,null)
->where('visa_status','3')
->where('visa_status_own','1')
->pluck('id')->toArray();

$pass_id = CurrentStatus::pluck('passport_id')->toArray();
$visa_not_started = PassportPassport::whereNotIn('id',$pass_id)->pluck('id')->toArray();
$passport=PassportPassport::whereIn('career_id',$career)->pluck('id')->toArray();

$visa_process_to_start= PassportPassport::whereIn('id',$passport)
->orWhere('visa_status','3')
->where('visa_status_own','1')
->limit(10)
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

$current_status=CurrentStatus::where('passport_id',$row->id)->first();
$pass=PassportPassport::where('id',$row->id)->first();
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
$own_visa[] = $gamer;
}

}

//own visa process to end

//list of all cancelled visas
$visa_can=VisaCancellationStatus::where('current_status','4')->limit(10)->get();


//total visa process to start

$career = Career::where('visa_process_start_status','=' ,null)->where('visa_status','1')->pluck('id')->toArray();
$pass_id = CurrentStatus::pluck('passport_id')->toArray();
$visa_not_started = PassportPassport::whereNotIn('id',$pass_id)->pluck('id')->toArray();
$passport=PassportPassport::whereIn('career_id',$career)->pluck('id')->toArray();
$visa_process_to_start= PassportPassport::whereIn('id',$passport)->orWhere('visa_status','1')->where('visa_process_start_status', null)->count();

//expired visa
$renewed_visas=RenewAgreedAmount::pluck('passport_id');
$expired_visa= VisaPasted::whereNotIn('passport_id',$renewed_visas)->where('expiry_date' ,'<',$curr_date)->count();


//own visa count
$career = Career::where('visa_process_start_status','=' ,null)
->where('visa_status','3')
->where('visa_status_own','1')
->pluck('id')->toArray();

$pass_id = CurrentStatus::pluck('passport_id')->toArray();
$visa_not_started = PassportPassport::whereNotIn('id',$pass_id)->pluck('id')->toArray();
$passport=PassportPassport::whereIn('career_id',$career)->pluck('id')->toArray();

$own_visa_count= PassportPassport::whereIn('id',$passport)
->orWhere('visa_status','3')
->where('visa_status_own','1')
->count();

// dd($own_visa_count);

// cancelled visa count

$status=VisaCancellationStatus::pluck('passport_id')->toArray();
$cancel_visa_count=VisaCancelRequest::whereNotIn('passport_id',$status)->where('status','3')->count();


//replacement
$replacement_history=ReplacementVisaCancel::count();

//

$total_visa_process_completed=CurrentStatus::where('current_process_id','27')->count();






        return view('admin-panel.visa-master.visa_process.dashboard.index',compact('own_visa_count','total_visa_process_completed','cancel_visa_count','replacement_history','expired_visa','visa_process_to_start','data','visa_pasted','own_visa','visa_can','fine_starts_next_week','data_label','data_label_values','company','data_plateform','data_plateform_values','fine_already_passed','current_steps'));

    }


    //list of rider need to pay money at each step
//offer letter

public function visa_process_payments(){
    $current_steps=array();
    $current_status=CurrentStatus::all();
    $master_steps= Master_steps ::all();
    $assignin= AssigningAmount::all();
    $master_steps->shift(0);
    $total_amount_pending=$assignin->where('pay_status',null)->sum('amount');

    foreach($master_steps as $row){
        $gamer = array(
            'step_name' =>  $row->step_name,
            'no' =>  count($assignin->where('master_step_id',$row->id)->where('pay_status',null)),
            'sum_amount' =>  $assignin->where('master_step_id',$row->id)->where('pay_status',null)->sum('amount'),
            'step_id' => $row->id,
        );
        $current_steps[] = $gamer;
    }


    return view('admin-panel.visa-master.visa_process.visa_process_payments',compact('current_steps','total_amount_pending'));

}

public function get_visa_payment_detail(Request $request){


    $step_id=$request->step_id;
    $step_ids=$step_id;

    $master_step=Master_steps::where('id',$step_ids)->first();


    $master_step_name=$master_step->step_name;
    // dd($master_step_name);

       $data=array();
       $data_partial=array();
    //    $current_status=CurrentStatus::where('current_process_id',$step_ids)->get();partial_amount_status
       $current_status= AssigningAmount::where('master_step_id',$step_ids)->where('pay_status',null)->get();

       $current_status_partial= AssigningAmount::where('master_step_id',$step_ids)->where('partial_amount_status','1')->get();



    foreach($current_status as $row){
       $amount= AssigningAmount::where('master_step_id',$step_ids)->where('passport_id',$row->passport_id)->where('pay_status',null)->first();
        $amount_val=isset($amount)?$amount->amount:'N/A';
        $pay_status=isset($amount)?$amount->pay_status:'N/A';
        $remarks=isset($amount)?$amount->remarks:'N/A';
        $pay_at=isset($amount->pay_at)?$amount->pay_later->step_name:'N/A';
        $partial_amount=isset($amount->partial_amount)?$amount->partial_amount:'N/A';
        $partial_amount_step=isset($amount->partial_amount_step)?$amount->partial_amount_to_be->step_name:'N/A';

        $gamer = array(
            'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:'',
            'pass_no' => isset( $row->passport->passport_no)?  $row->passport->passport_no:"",
            'pp_uid' => isset( $row->passport->pp_uid)? $row->passport->pp_uid:'',
            'amount' =>$amount_val,
            'pay_status' =>$pay_status,
            'remarks' =>$remarks,
            'pay_at' =>$pay_at,

        );
        $data[] = $gamer;
    }


    foreach($current_status_partial as $row){
        $amount= AssigningAmount::where('master_step_id',$step_ids)->where('passport_id',$row->passport_id)->where('pay_status',null)->first();
         $amount_val=isset($amount)?$amount->amount:'N/A';
         $pay_status=isset($amount)?$amount->pay_status:'N/A';
         $remarks=isset($amount)?$amount->remarks:'N/A';
         $pay_at=isset($amount->pay_at)?$amount->pay_later->step_name:'N/A';
         $partial_amount=isset($amount->partial_amount)?$amount->partial_amount:'N/A';
         $partial_amount_step=isset($amount->partial_amount_step)?$amount->partial_amount_to_be->step_name:'N/A';

         $gamer = array(
             'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:'',
             'pass_no' => isset( $row->passport->passport_no)?  $row->passport->passport_no:"",
             'pp_uid' => isset( $row->passport->pp_uid)? $row->passport->pp_uid:'',
             'amount' =>$amount_val,
             'pay_status' =>$pay_status,
             'remarks' =>$remarks,
             'pay_at' =>$pay_at,
             'partial_amount' =>isset($row->partial_amount)?$row->partial_amount:'N/A',
             'partial_amount_step' =>isset($row->partial_amount_step)?$row->partial_amount_to_be->step_name:'N/A',
         );
         $data_partial[] = $gamer;
     }
    // dd($data);

    $view = view("admin-panel.visa-master.visa_process.ajax_files.get_unpaid_detail", compact('data','data_partial'))->render();
    return response()->json(['html' => $view, 'step_name'=>$master_step_name]);
}

public function visa_process_pendings()
{

    $data=array();

    $career=Career::where('visa_process_start_status','=' ,'1')->pluck('id')->toArray();

    $passport=PassportPassport::whereIn('career_id',$career)->pluck('id')->toArray();


    $offer_letter= Offer_letter ::whereIn('passport_id',$passport)->pluck('passport_id')->toArray();


    // $own= CurrentStatus ::whereIn('passport_id',$passport)->pluck('passport_id')->toArray();
    //take al the ppuids who are in offer letter
    $visa_process_to_start= PassportPassport::whereIn('id',$passport)->whereNotIn('id',$offer_letter)->orWhere('visa_process_start_status','=' ,'1')->get();

    $current_status_count= CurrentStatus::all();

    foreach($visa_process_to_start as $row){
        $count=0;

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
            elseif($pay_status->pay_status==null){
                $payment_status='Unpaid';
            }
            else{
                $payment_status='N/A';
            }
        }
        else{
            $payment_status='N/A';
        }
        $current_status=CurrentStatus::where('passport_id',$row->id)->first();

        if(!isset($current_status)){

    $gamer = array(
        'name' =>  isset($row->personal_info->full_name)?$row->personal_info->full_name:'N/A',
        'pass_no' => isset( $row->passport_no)?$row->passport_no:"N/A",
        'pp_uid' => isset( $row->pp_uid)? $row->pp_uid:'N/A',
        'payment_status' =>$payment_status,
        'passport_id' =>$row->passport_no,
    );
    $data[] = $gamer;
    $count++;

}
}
    return view('admin-panel.visa-master.visa_process.dashboard.visa_process_to_start',compact('data','current_status_count','visa_process_to_start'));


}

public function visa_process_get_remaining(Request $request){
    $master_id=$request->master_id;

    $current_status=$master_id-1;


    $data=array();

    if($master_id=='28'){
        $step_data= CurrentStatus ::where('current_process_id','28')->pluck('passport_id')->toArray();
    }
    else if($master_id=='29'){
        $step_data= CurrentStatus ::where('current_process_id','27')->pluck('passport_id')->toArray();
    }
    else{
    $step_data= CurrentStatus ::where('current_process_id',$current_status)->pluck('passport_id')->toArray();
    }
    //take al the ppuids who are in offer letter
    $visa_process_to_start= Passport\Passport::whereIn('id',$step_data)->get();

    foreach($visa_process_to_start as $row){
        $pay_status= AssigningAmount::where('master_step_id',$master_id)->where('passport_id',$row->id)->first();
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
            elseif($pay_status->pay_status==null){
                $payment_status='Unpaid';
            }
            else{
                $payment_status='N/A';
            }
        }
        else{
            $payment_status='N/A';
        }
    $gamer = array(
        'name' =>  isset($row->personal_info->full_name)?$row->personal_info->full_name:'N/A',
        'pass_no' => isset( $row->passport_no)?  $row->passport_no:"N/A",
        'pp_uid' => isset( $row->pp_uid)? $row->pp_uid:'N/A',
        'payment_status' =>$payment_status,
        'passport_id' =>$row->passport_no,
        'current_status' =>$current_status,
    );
    $data[] = $gamer;
    }

    $view = view("admin-panel.visa-master.visa_process.remain_visa_ajax.offer_letter_sub", compact('data','master_id'))->render();

    return response()->json(['html' => $view]);




}

//renew visa_process reports
public function visa_renew_process_payments(){
    $current_steps=array();
    $current_status=CurrentStatus::all();
    $master_steps= RenewVisaSteps ::all();
    $assignin= AssigningAmount::all();
    // $master_steps->shift(0);

    foreach($master_steps as $row){
        $gamer = array(
            'step_name' =>  $row->step_name,
            'no' =>  count($assignin->where('rn_step_id',$row->id)->where('rn_visa_process_status','1')),
            'step_id' => $row->id,
        );
        $current_steps[] = $gamer;
    }

    // dd($current_steps);


    return view('admin-panel.visa-master.visa_process.renew_visa_process_payments',compact('current_steps'));

}

public function get_renew_visa_payment_detail(Request $request){

    $step_id=$request->step_id;
    $step_ids=$step_id-1;

    $master_step=RenewVisaSteps::where('id',$step_id)->first();
    $master_step_name=$master_step->step_name;
       $data=array();
       $data_partial=array();
    //    $current_status=CurrentStatus::where('current_process_id',$step_ids)->get();partial_amount_status
       $current_status= AssigningAmount::where('rn_step_id',$step_id)->where('rn_visa_process_status','1')->get();

    foreach($current_status as $row){
       $amount= AssigningAmount::where('rn_step_id',$step_id)->where('passport_id',$row->passport_id)->where('rn_pay_status',null)->first();
        $amount_val=isset($amount)?$amount->amount:'N/A';
        $pay_status=isset($amount)?$amount->rn_pay_status:'N/A';
        $remarks=isset($amount)?$amount->remarks:'N/A';
        $pay_at=isset($amount->pay_at)?$amount->pay_later->step_name:'N/A';
        $partial_amount=isset($amount->partial_amount)?$amount->partial_amount:'N/A';
        $partial_amount_step=isset($amount->partial_amount_step)?$amount->partial_amount_to_be->step_name:'N/A';

        $gamer = array(
            'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:'',
            'pass_no' => isset( $row->passport->passport_no)?  $row->passport->passport_no:"",
            'pp_uid' => isset( $row->passport->pp_uid)? $row->passport->pp_uid:'',
            'amount' =>$amount_val,
            'pay_status' =>$pay_status,
            'remarks' =>$remarks,
            'pay_at' =>$pay_at,
        );
        $data[] = $gamer;
    }
// dd($data);
    $view = view("admin-panel.visa-master.visa_process.ajax_files.get_renew_unpaid_detail", compact('data'))->render();
    return response()->json(['html' => $view, 'step_name'=>$master_step_name]);
}



public function takaful_emarat(){

    $company = Company::where('type','1')->get();
    $insurance= VehicleInsurance::all();
    return view('admin-panel.visa-master.visa_process.insurance.takaful_emarat',compact('company','insurance'));
}

public function takaful_save(Request $request )
{



    $pass_no=$request->passport_number;
    $passpoprt=PassportPassport::where('passport_no',$pass_no)->first();
    $pass_id=$passpoprt->id;

            $obj = new TakafulEmarat();
            $obj->member_id = $request->member_id;
            $obj->insurance_company = $request->insurance_company;
            $obj->passport_id = $pass_id;
            $obj->company_id = $request->company;
            $obj->card_no = $request->card_no;
            $obj->emirates_id = $request->emirates_id;
            $obj->network_type = $request->network_type;
            $obj->pid =$request->pid;
            $obj->effective_date =$request->effective_date;
            $obj->expiry_date =$request->expiry_date;
            $obj->save();


return response()->json([
    'code' => "100",
]);
}

public function load_takaful(){

    $takaful=TakafulEmarat::all();
    // resources\views\admin-panel\visa-master\visa_process\insurance\ajax_takaful_view.blade.php
    $view = view("admin-panel.visa-master.visa_process.insurance.ajax_takaful_view", compact('takaful'))->render();

    return response()->json(['html' => $view]);

}

public function takaful_edit($id){
    $company = Company::where('type','1')->get();

    $edit_takaful = TakafulEmarat::find($id);

    $passport=PassportPassport::where('id',$edit_takaful->passport_id)->first();
    $passport_no= $passport->passport_no;
    $insurance= VehicleInsurance::all();

    return view('admin-panel.visa-master.visa_process.insurance.takaful_emarat',compact('insurance','company','edit_takaful','passport_no'));



}

public function takaful_update(Request $request)
{
    $pass_no=$request->passport_number;
    $passpoprt=PassportPassport::where('passport_no',$pass_no)->first();
    $pass_id=$passpoprt->id;
    $obj = TakafulEmarat::find($request->id);
    $obj->insurance_company = $request->insurance_company;
    $obj->member_id = $request->member_id;
    $obj->passport_id = $pass_id;
    $obj->company_id = $request->company;
    $obj->card_no = $request->card_no;
    $obj->emirates_id = $request->emirates_id;
    $obj->network_type = $request->network_type;
    $obj->pid =$request->pid;
    $obj->effective_date =$request->effective_date;
    $obj->expiry_date =$request->expiry_date;
    $obj->user_id =auth()->user()->id;

    $obj->save();


return response()->json([
    'code' => "100",
]);



}

public function visa_bypass($id){

    $passport=PassportPassport::where('id',$id)->first();
    $pass_no=$passport->passport_no;
    $obj= new BypassVisa();
    $obj->passport_id =$id;
    $obj->status ='1';
    $obj->user_id =auth()->user()->id;
    $obj->save();

    $message = [
        'message' => 'Visa Process Has Been By Passed Successfully!!',
        'alert-type' => 'success'

    ];

    return redirect('visa_process?passport_id='.$pass_no);

    // return redirect()->back()->with($message);




}
public function takaful_check(Request $request){

    $pass_no=$request->passport_no;
    $passport=PassportPassport::where('passport_no',$pass_no)->first();
    $pass_id= $passport->id;

    $current_status= CurrentStatus::where('passport_id',$pass_id)->where('current_process_id','27')->count();



    if($current_status == 0){
        return response()->json([
            'code' => "100",
        ]);
    }
    else{
        return response()->json([
            'code' => "101",
        ]);
    }
}
public function visa_pybass_list(){

    $bypass= BypassVisa::all();
    return view('admin-panel.visa-master.visa_process.by_pass_list',compact('bypass'));
}
public function gl_wmc(){
    return view('admin-panel.visa-master.visa_process.insurance.gl_wmc');
}

public function load_gl_wmc(){

    $glwmc = Glwmc::all();
    $view = view("admin-panel.visa-master.visa_process.insurance.ajax_gl_wmc_view", compact('glwmc'))->render();

    return response()->json(['html' => $view]);

}

public function gl_save(Request $request){
    $pass_no=$request->passport_number;
    $passpoprt=PassportPassport::where('passport_no',$pass_no)->first();
    $pass_id=$passpoprt->id;

            $obj = new Glwmc();

            $obj->passport_id = $pass_id;
            $obj->amount = $request->amount;
            $obj->issue_date = $request->issue_date;
            $obj->expiry_date = $request->expiry_date;
            $obj->user_id =auth()->user()->id;
            $obj->save();


return response()->json([
    'code' => "100",
]);

}

public function gl_update(Request $request)
{
    $pass_no=$request->passport_number;
    $passpoprt=PassportPassport::where('passport_no',$pass_no)->first();
    $pass_id=$passpoprt->id;
    $obj = Glwmc::find($request->id);
    $obj->passport_id = $pass_id;
    $obj->amount = $request->amount;
    $obj->issue_date = $request->issue_date;
    $obj->expiry_date = $request->expiry_date;
    $obj->user_id =auth()->user()->id;

    $obj->save();


return response()->json([
    'code' => "100",
]);
}

public function gl_edit($id){


    $edit_gl = Glwmc::find($id);
    $passport=PassportPassport::where('id',$edit_gl->passport_id)->first();
    $passport_no= $passport->passport_no;
    return view('admin-panel.visa-master.visa_process.insurance.gl_wmc',compact('edit_gl','passport_no'));



}

public function load_company_network(Request $request){

    $edit_takaful = TakafulEmarat::find($request->edit_takaful);
    $id=$request->company;

    $network_type= InsuranceNetworkType::where('insurance_company',$id)->get();

    $view = view("admin-panel.visa-master.visa_process.insurance.ajax_network_type", compact('network_type','edit_takaful'))->render();

    return response()->json(['html' => $view]);
}

public function visa_process_amount()
{
    $zds_code=UserCodes::all();
    $rider_id=PlatformCode::all();
    $ar_balance_sheet=ArBalanceSheet::orderBy('id', 'desc')->take(50)->get();
    foreach ($ar_balance_sheet as $res){
        $passport_detail=PassportPassport::where('id',$res->passport_id)->first();
        $rider_id= isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code)?$passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code:'N/A';
        $gamer1 = array(
            'ppuid' => $res->passport->pp_uid,
            'platform_code' => $rider_id,
            'platform'=>$res->platform_id,
            'name' => $res->passport->personal_info->full_name,
            'date'=>$res->date_saved,
            'description'=>$res->balance_name,
            'amount'=>$res->balance,
            'status'=>$res->status,
        );
        $statement [] = $gamer1;
    }

    $ar_zds=ArBalance::all();
    $balance_types_sub=BalanceType::where('category','1')->get();
    $balance_types_add=BalanceType::where('category','2')->get();
    $platforms=Platform::all();

    //---------assging amounts

    // $visa_steps_amount=  AssigningAmount::all();

    $visa_steps=  Master_steps::all();
    $visa_steps->shift(0);

    return view('admin-panel.visa-master.visa_process.visa_process_amount.visa_process_amount',compact('zds_code','rider_id','platforms','ar_zds','balance_types_add','balance_types_sub','ar_balance_sheet','statement','visa_steps'));

}
public function replacement_history(){
    $history=ReplacementVisaCancel::all();
    return view('admin-panel.visa-master.visa_replacement.history',compact('history'));

}
public function get_visa_profile_detail(Request $request){

                $passport_id=$request->passport_id;

                $user = RiderProfile::where('passport_id', $passport_id)->first();
        if ($user == null || empty($user)) {
            $user = 'null';
        }


                 //---------------offer letter process 1------------
                 $offer_letter=Offer_letter::where('passport_id',$passport_id)->first();
                 $payment_offer_letter= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','2')->first();
                 //---------------offer letter ends------------
                 //---------------offer letter submission process 2------------
                 $offer_letter_sub=Offer_letter_submission::where('passport_id',$passport_id)->first();
                 $payment_offer_letter_sub= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','3')->first();
                 //---------------offer letter submission ENDS------------

                  //---------------Electronic Pre Approval process 3------------
                  $electronic_pre_approval=ElectronicPreApproval::where('passport_id',$passport_id)->first();
                  $payment_electronic_pre_approval= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','4')->first();
                  //---------------Electronic Pre Approval process 3 ENDS------------
                  //---------------Electronic Pre Approval Payment process 4------------
                  $electronic_pre_approval_pay=ElectronicPreApprovalPayment::where('passport_id',$passport_id)->first();
                  $payment_electronic_pre_approval= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','4')->first();
                  //---------------Electronic Pre Approval process 4 ENDS------------
                  //---------------Print Visa Inside Outside process 5-----------
                  $print_inside_out_side=EntryPrintOutside::where('passport_id',$passport_id)->first();
                  $payment_print_inside_out_side= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','5')->first();
                  //---------------Print Visa Inside Outside process 5 ENDS------------
                  //---------------Status Change/in out change process 6-----------
                  $status_change=StatusChange::where('passport_id',$passport_id)->first();
                  $in_out_change=InOutStatusChange::where('passport_id',$passport_id)->first();
                  $payment_status_change= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','6')->first();
                  //---------------Status Change/in out change process 6 ENDS-----------
                  //---------------Entry Date process 7 ends-----------
                  //---------------Medical process 8 ends-----------
                  $med_normal=MedicalNormal::where('passport_id',$passport_id)->first();
                  $payment_status_change= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','14')->first();
                  //---------------Medial process 8 ends-----------
                  //---------------Medial process 9-----------
                  $fit_unfit=FitUnfit::where('passport_id',$passport_id)->first();
                  $payment_fit_unfit = VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','15')->first();
                  //---------------Medial process 9 ends-----------
                     //---------------Medial process 10-----------
                     $emirates_id_apply=EmiratesIdApply::where('passport_id',$passport_id)->first();
                     $payment_emirates_id_apply = VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','16')->first();
                     //---------------Medial process 10 ends-----------
                     //---------------Medial process 11 ends-----------
                     $figer_print=EmiratesIdFingerPrint::where('passport_id',$passport_id)->first();
                     $payment_figer_print = VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','17')->first();
                     //---------------Medial process 11 ends-----------
                     //--------------- process 12-----------
                     $new_contract=NewContractAppTyping::where('passport_id',$passport_id)->first();
                     $payment_new_contract = VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','18')->first();
                     //--------------- process 12-----------
                        //--------------- process 13-----------
                        $tawjeeh=TawjeehClass::where('passport_id',$passport_id)->first();
                        $payment_tawjeeh = VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','19')->first();
                        //--------------- process 13-----------
                             //--------------- process 14-----------
                     $new_contract_sub=NewContractSubmission::where('passport_id',$passport_id)->first();
                     $payment_new_contract_sub = VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','21')->first();
                     //--------------- process 14-----------
                     //--------------- process 15-----------
                     $labour_card=LabourCard::where('passport_id',$passport_id)->first();
                     $payment_labour_card= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','22')->first();
                     //--------------- process 15-----------
                      //--------------- process 16-----------
                      $visa_stamp=VisaStamping::where('passport_id',$passport_id)->first();
                      $payment_visa_stamp= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','23')->first();
                      //--------------- process 16-----------
                      //--------------- process 17-----------
                      $waiting=WaitingForApproval::where('passport_id',$passport_id)->first();
                      $payment_waiting= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','24')->first();
                      //--------------- process 17ends-----------
                      //--------------- process 18-----------
                      $zajeel=WaitingForZajeel::where('passport_id',$passport_id)->first();
                      $payment_zajeel= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','25')->first();
                          //--------------- process 18 ends-----------
                                   //--------------- process 18-----------
                      $visa_pasted=VisaPasted::where('passport_id',$passport_id)->first();
                      $payment_visa_pasted= VisaPaymentOptions::where('passport_id',$passport_id)->where('visa_process_step_id','26')->first();
                      //--------------- process 18 ends-----------
                      $unique=UniqueEmailId::where('passport_id',$passport_id)->first();

                      $unique_id=UniqueEmailIdHandover::where('passport_id',$passport_id)->first();
                 $labour_insurance=VisaProcessLabourInsurance::where('passport_id',$passport_id)->first();


                 //company
                 //st_no
                 //job
                 $company= isset($offer_letter->companies->name)?$offer_letter->companies->name:"N/A";
                 $st_no=isset($offer_letter->st_no)?$offer_letter->st_no:'N/A';
                 $job=isset($offer_letter->designation->name)?$offer_letter->designation->name:"N/A";
                 //mb_no
                 $mb_no=isset($offer_letter_sub->mb_no)?$offer_letter_sub->mb_no:"N/A";
                 //labour_card_no
                  $labour_card_no=isset($electronic_pre_approval->labour_card_no)?$electronic_pre_approval->labour_card_no:'N/A';
                 //visa_no
                 $visa_no=isset($print_inside_out_side->visa_no)?$print_inside_out_side->visa_no:'N/A';
                 //uid_no
                 $uid_no=isset($print_inside_out_side->uid_no)?$print_inside_out_side->uid_no:'N/A';
                 //medical type
                 if(isset($med_normal)&&$med_normal->type=='1'){
                    $medical_type= "Normal";}
                     elseif(isset($med_normal)&&$med_normal->type=='2'){
                        $medical_type='48 Hours';}
                         elseif(isset($med_normal)&&$med_normal->type=='3'){
                            $medical_type="24 Hours";
                         }
                         elseif(isset($med_normal)&&$med_normal->type=='4'){
                            $medical_type= "Medical VIP";
                         }else{
                            $medical_type= "N/A";
                         }
                  //medical_app id
                 $medical_app_id=isset($med_normal->medical_tans_no)?$med_normal->medical_tans_no:"N/A";
                 //fit unnfit
                if(isset($fit_unfit) && $fit_unfit->status=='1'){
                $fit_unfit_status="Fit";
                        }
                        elseif(isset($fit_unfit) && $fit_unfit=='2'){
                        $fit_unfit_status="Fit";
                        }
                        else{
                            $fit_unfit_status="N/A";
                        }
                 //visa_no
                 //tawjeeh
                    if(isset($tawjeeh)&&$tawjeeh->status=='1'){
                        $tawjeeh_status='Taken';
                    }
                    elseif(isset($tawjeeh)&&$tawjeeh->status=='1'){
                        $tawjeeh_status='Not Taken';
                    }else{
                        $tawjeeh_status='N/A';
                    }
                 //visa stamping

                 //waiting for approval
                 //person code
                 $person_code=isset($labour_card->person_code)?$labour_card->person_code:'N/A';



                 // labour card
                 $gamer2 = array(
                    'company' => $company,
                    'st_no' => $st_no,
                    'job'=>$job,
                    'mb_no' => $mb_no,
                    'visa_no'=>$visa_no,
                    'uid_no'=>$uid_no,
                    'medical_type'=>$medical_type,
                    'medical_app_id'=>$medical_app_id,
                    'fit_unfit_status'=>$fit_unfit_status,
                    'tawjeeh_status'=>$tawjeeh_status,
                    'labour_card_no'=>$labour_card_no,
                    'person_code'=>$person_code,
                    'expiry_date'=>$visa_pasted->expiry_date,


                );

                // dd();
                // resources\views\admin-panel\profile\ajax_files\visa_detail.blade.php

                $view = view("admin-panel.profile.ajax_files.visa_detail", compact('gamer2','user','visa_pasted'))->render();

                return response()->json(['html' => $view]);




}

public function labour_card_upload(){


    return view('admin-panel.visa-master.visa_process.labouur_card_upload');
}


// public function labour_card_upload_store(Request $request)
// {


// }



public function labour_card_upload_store(Request $request)
    {

        // $platform_id=  $request->platform_id;

        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);


        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
            ];
            return redirect()->back()->with($message);
        } else {

            $last_id = Excel::toArray(new \App\Imports\LabourCardImport(), request()->file('select_file'));
            $data = collect(head($last_id));

            $gamer_array = array();
            $count = 0;

            foreach ($data as $res){

                $passport = PassportPassport::where('pp_uid','=',$res['pp_uid'])->first();

                $pass_id=$passport['id'];
                $status_check = $this->check_the_status($pass_id);
                if($status_check['passport_id']==""){
                    $count = $count+1;


                }
                $gamer_array [] = $status_check;

            }

            if ($count==count($data)){
                Excel::import(new LabourCardImport,request()->file('select_file'));
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
            else{

                $message_code='1';
                return view('admin-panel.visa-master.visa_process.labouur_card_upload',
                compact('message_code','gamer_array'));
            }


            }

        }

        public function check_the_status($gamer){


                $pass = CurrentStatus::where('passport_id','=',$gamer)->first();
                $passport = PassportPassport::where('id','=',$gamer)->first();
                $passport_add = passport_addtional_info::where('passport_id','=',$gamer)->first();

                if($pass['current_process_id'] < '21' ){
                    $gamer =array(
                        'passport_id' => $pass['passport_id'],
                        'passport_no' => $passport['passport_no'],
                        'ppuid' => $passport['pp_uid'],
                        'name' => $passport_add['full_name'],
                    );
                }
                // dd($gamer);
                return $gamer;

       }





//this is main class ending here
}
