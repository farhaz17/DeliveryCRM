<?php

namespace App\Http\Controllers\VisaProcess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Passport\Passport;
use App\Model\VisaProcess\VisaPasted;
use App\Model\DiscountName\DiscountName;
use App\Model\VisaProcess\RenewVisaSteps;
use App\Model\Master_steps;
use App\Model\AgreedAmount;
use App\Model\Emirates_id_cards;
use App\Model\VisaProcess\AssigningAmount;
use App\Model\VisaProcess\RenewAgreedAmount;
use App\Model\VisaProcess\RenewalContractTyping;
use App\Model\VisaProcess\RenewalContractSubmission;
use App\Model\VisaProcess\RenewalVisaMedical;
use App\Model\VisaProcess\RenewalEmirates_id_apply;
use App\Model\VisaProcess\RenewalVisaStamping;
use App\Model\VisaProcess\RenewalEmiratesIdTyping;
use App\Model\VisaProcess\RenewalEmiratesIdHandover;
use App\Model\VisaProcess\RenewalEmiratesIdReceive;

use App\Model\PaymentType;
use App\Model\RenewVisaPaymentOption;
use App\Model\VisaProcess\BypassVisa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Auth;
use Image;







// app\Model\VisaProcess\RenewalContractTyping.php



class RenewVisaProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin-panel.visa-master.renew_visa.index');
    }

   public function visa_renew_names(Request $request){

    $passport=Passport ::where('passport_no',$request->keyword)->first();
// dd($passport);
    $passport_id=$passport->id;

    $name=isset($passport->personal_info->full_name)?$passport->personal_info->full_name:"N/A";

    $ppuid=$passport->pp_uid;
    $passport_no=$passport->passport_no;
    $image=isset($passport->profile->image)?$passport->profile->image:'';
    $expiry_date=$passport->date_expiry;
    $discount_names = DiscountName::orderby('id','desc')->get();
    $master_steps = RenewVisaSteps::get();

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

    $visa_pasted=VisaPasted::where('passport_id',$passport_id)->first();

    $curr_date=date('Y-m-d');

    if($visa_pasted!=null){
        $visa_expiry_date=$visa_pasted->expiry_date;
        $expiry_date_v=date("Y-m-d", strtotime($visa_expiry_date));


        if(isset($expiry_date_v) && $expiry_date_v > $curr_date){
            $visa_renew_com="2";
            //visa has not expired
            //show expiry date on view
            //start visa
        }
        else{
            //visa has been expired!!!
            //show expiry date on view with alert
            //start visa
            $visa_renew_com="1";
        }
    }
    else{
        //record not found
        // do not start visa
        $visa_expiry_date="Visa Expiry Date is not availale";
        $visa_renew_com="3";
        $expiry_date_v='1';

    }

    $by_pass=BypassVisa::where('passport_id',$passport_id)->count();


    $renew_visa_started=RenewAgreedAmount::where('passport_id',$passport_id)->count();
    // dd($renew_visa_started);

    if($renew_visa_started >= '1'){

        $current_date=date('Y-m-d');
        $renew_expired= RenewalEmiratesIdTyping::where('passport_id',$passport_id)->where('expiry_date' ,'<',$current_date)->where('renew_expire_status',null)->first();
// dd($renew_expired);
    }
    else{
        $renew_expired=null;
    }








// dd($visa_renew_com);


// renew_expired
        $view = view("admin-panel.visa-master.renew_visa.ajax_files.get_renew_visa_prcess", compact('renew_expired','renew_visa_started','passport_id','name','ppuid','passport_no','image','expiry_date','visa_expiry_date','remain_days','visa_renew_com','expiry_date_v',
        'discount_names','master_steps','by_pass'))->render();
    return response()->json(['html' => $view]);





    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



        $visa_process_to_start=RenewAgreedAmount::where('current_status',null)->get();
        // dd($visa_process_to_start);

        $data=array();

            foreach($visa_process_to_start as $row){


                $gamer = array(
                    'id' =>$row->id,
                    'passport_id' =>$row->passport_id,
                    'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:'N/A',
                    'pass_no' => isset( $row->passport->passport_no)?  $row->passport->passport_no:"N/A",
                    'pp_uid' => isset( $row->passport->pp_uid)? $row->passport->pp_uid:'N/A',
                    'agreed_amount'=>isset($row->agreed_amount)?$row->agreed_amount:'N/A',
                    'advance_amount'=>isset($row->advance_amount)?$row->advance_amount:'N/A',
                    'discount_amount'=>isset($row->discount_amount)?$row->discount_amount:'N/A',
                    'final_amount'=>isset($row->final_amount)?$row->final_amount:'N/A',
                    'payroll_deduct_amount'=>isset($row->payroll_deduction)?$row->payroll_deduction:'N/A',
                );
                $data[] = $gamer;

            }




    return view('admin-panel.visa-master.renew_visa.renew_process_data',compact('data'));
    }
    public function renew_nested(Request $request){
    $amounts=AssigningAmount::where('passport_id',$request->id)->where('rn_visa_process_status','!=',null)->get();

    // resources\views\admin-panel\visa-master\renew_visa\ajax_files\renew_nested.blade.php

    $view = view("admin-panel.visa-master.renew_visa.ajax_files.renew_nested", compact('amounts'))->render();
    return response()->json(['html' => $view]);
}
public function start_renew_visa($id){
    $obj = RenewAgreedAmount::find($id);
    $obj->current_status='1';
    $obj->save();
    $message = [
        'message' => 'Visa Process Ready To Start Now!!',
        'alert-type' => 'success'

    ];

    return redirect()->back()->with($message);

}

public function renew_visa_process(){
    return view('admin-panel.visa-master.renew_visa.renew_visa_process');
}



public function renew_visa_process_names(Request $request){


    $passport=Passport::where('passport_no',$request->keyword)->first();
    $passport_id=$passport->id;
    $name=$passport->personal_info->full_name;
    $ppuid=$passport->pp_uid;
    $passport_no=$passport->passport_no;
    $image=isset($passport->profile->image)?$passport->profile->image:'';

    $expiry_date=$passport->date_expiry;

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

                        if(isset($request->agreed_id)){

    //---------------Renewal typing process 1------------
    $renewal_contract_typing_x=RenewalContractTyping::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();

    if(isset($renewal_contract_typing_x) && $renewal_contract_typing_x->renew_expire_status==null){
        $renewal_contract_typing=RenewalContractTyping::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
    }
    else{
        $renewal_contract_typing=null;
    }
    $renewal_contract_typing_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','1')->first();
    //---------------offer letter ends------------

    //---------------Renewal  submission process 2------------
    $renewal_contract_sub_x=RenewalContractSubmission::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();

    if(isset($renewal_contract_sub_x) && $renewal_contract_sub_x->renew_expire_status==null){
        $renewal_contract_sub=RenewalContractSubmission::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
    }
    else{
        $renewal_contract_sub=null;
    }


    $renewal_contract_sub_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','2')->first();
    //---------------offer letter submission ENDS------------

     //---------------Renewal Medical  process 3------------
     $medical_x=RenewalVisaMedical::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();


     if(isset($medical_x) && $medical_x->renew_expire_status==null){
        $medical=RenewalVisaMedical::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
     }
     else{
         $medical=null;
     }



     $medical_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','3')->first();
     //---------------Renewal Medical process 3 ENDS------------

     //---------------Renewal Emirates id Payment process 4------------
     $emirates_id_apply_x=RenewalEmirates_id_apply::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();

    //  dd($emirates_id_apply_x);

     if(isset($emirates_id_apply_x)&&$emirates_id_apply_x->renew_expire_status==null){
        $emirates_id_apply=RenewalEmirates_id_apply::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
     }
     else{
         $emirates_id_apply=null;
     }

    //  dd($emirates_id_apply);

     $emirates_id_apply_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','4')->first();

     //---------------Renewal Emirates id process 4 ENDS------------
     //---------------Rewnewal Visa Stamping change process 6-----------

     $visa_stamping_x=RenewalVisaStamping::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();

     if(isset($visa_stamping_x) && $visa_stamping_x->renew_expire_status==null){
        $visa_stamping=RenewalVisaStamping::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
     }
     else{
         $visa_stamping=null;
     }


     $visa_stamping_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','5')->first();
//---------------Rewnewal Visa Stamping change process 6-----------


     $emirates_id_typing_x=RenewalEmiratesIdTyping::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();

     if(isset($emirates_id_typing_x) && $emirates_id_typing_x->renew_expire_status==null){
        $emirates_id_typing=RenewalEmiratesIdTyping::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
     }
     else{
         $emirates_id_typing=null;
     }


     $emirates_id_typing_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','6')->first();
     //---------------Status Change/in out change process 6 ENDS-----------
     //---------------Entry Date process 7-----------

     $emirates_id_rec_x=RenewalEmiratesIdReceive::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();

     if(isset($emirates_id_rec_x) && $emirates_id_rec_x->renew_expire_status==null){
        $emirates_id_rec=RenewalEmiratesIdReceive::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
     }
     else{
         $emirates_id_rec=null;
     }



     $emirates_id_rec_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','7')->first();

     $emirates_id_handover_x=RenewalEmiratesIdHandover::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
     if(isset($emirates_id_handover_x) && $emirates_id_handover_x->renew_expire_status==null){
        $emirates_id_handover=RenewalEmiratesIdHandover::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
     }
     else{
         $emirates_id_handover=null;
     }

     $emirates_id_handover_amount=AssigningAmount::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->where('rn_step_id','7')->first();
     //---------------Entry Date process 7 ends-----------
         //-----------------------------------------------------
         $currnet_status=RenewAgreedAmount::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();

         if ($currnet_status != null)
         {
             $current_status=$currnet_status->current_status;
             $next_status_id = $current_status + 1;
         }
         else
         {
              $next_status_id='1';

        }
        //----------------------------fine starts----------------------



    $payroll_deductction=RenewAgreedAmount::where('passport_id',$passport->id)->where('renew_agreement_id',$request->agreed_id)->first();
   if($payroll_deductction != null){
    $payroll_amount=$payroll_deductction->payroll_deduct_amount;
   }
   else{
    $payroll_amount='0';
   }
















                        }
                        else{

                //---------------Renewal typing process 1------------
                $renewal_contract_typing_x=RenewalContractTyping::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

                if(isset($renewal_contract_typing_x) && $renewal_contract_typing_x->renew_expire_status==null){
                    $renewal_contract_typing=RenewalContractTyping::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                }
                else{
                    $renewal_contract_typing=null;
                }
                $renewal_contract_typing_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','1')->first();
                //---------------offer letter ends------------

                //---------------Renewal  submission process 2------------
                $renewal_contract_sub_x=RenewalContractSubmission::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

                if(isset($renewal_contract_sub_x) && $renewal_contract_sub_x->renew_expire_status==null){
                    $renewal_contract_sub=RenewalContractSubmission::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                }
                else{
                    $renewal_contract_sub=null;
                }


                $renewal_contract_sub_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','2')->first();
                //---------------offer letter submission ENDS------------

                 //---------------Renewal Medical  process 3------------
                 $medical_x=RenewalVisaMedical::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();


                 if(isset($medical_x) && $medical_x->renew_expire_status==null){
                    $medical=RenewalVisaMedical::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                 }
                 else{
                     $medical=null;
                 }



                 $medical_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','3')->first();
                 //---------------Renewal Medical process 3 ENDS------------

                 //---------------Renewal Emirates id Payment process 4------------
                 $emirates_id_apply_x=RenewalEmirates_id_apply::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

                //  dd($emirates_id_apply_x);

                 if(isset($emirates_id_apply_x)&&$emirates_id_apply_x->renew_expire_status==null){
                    $emirates_id_apply=RenewalEmirates_id_apply::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                 }
                 else{
                     $emirates_id_apply=null;
                 }

                //  dd($emirates_id_apply);

                 $emirates_id_apply_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','4')->first();

                 //---------------Renewal Emirates id process 4 ENDS------------
                 //---------------Rewnewal Visa Stamping change process 6-----------

                 $visa_stamping_x=RenewalVisaStamping::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

                 if(isset($visa_stamping_x) && $visa_stamping_x->renew_expire_status==null){
                    $visa_stamping=RenewalVisaStamping::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                 }
                 else{
                     $visa_stamping=null;
                 }


                 $visa_stamping_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','5')->first();
   //---------------Rewnewal Visa Stamping change process 6-----------


                 $emirates_id_typing_x=RenewalEmiratesIdTyping::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

                 if(isset($emirates_id_typing_x) && $emirates_id_typing_x->renew_expire_status==null){
                    $emirates_id_typing=RenewalEmiratesIdTyping::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                 }
                 else{
                     $emirates_id_typing=null;
                 }


                 $emirates_id_typing_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','6')->first();
                 //---------------Status Change/in out change process 6 ENDS-----------
                 //---------------Entry Date process 7-----------

                 $emirates_id_rec_x=RenewalEmiratesIdReceive::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

                 if(isset($emirates_id_rec_x) && $emirates_id_rec_x->renew_expire_status==null){
                    $emirates_id_rec=RenewalEmiratesIdReceive::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                 }
                 else{
                     $emirates_id_rec=null;
                 }



                 $emirates_id_rec_amount=AssigningAmount::where('passport_id',$passport->id)->where('rn_step_id','7')->first();

                 $emirates_id_handover_x=RenewalEmiratesIdHandover::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                 if(isset($emirates_id_handover_x) && $emirates_id_handover_x->renew_expire_status==null){
                    $emirates_id_handover=RenewalEmiratesIdHandover::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();
                 }
                 else{
                     $emirates_id_handover=null;
                 }

                 $emirates_id_handover_amount=AssigningAmount::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->where('rn_step_id','7')->first();
                 //---------------Entry Date process 7 ends-----------
                     //-----------------------------------------------------
                     $currnet_status=RenewAgreedAmount::where('passport_id',$passport->id)->orderBy('created_at', 'desc')->first();

                     if ($currnet_status != null)
                     {
                         $current_status=$currnet_status->current_status;
                         $next_status_id = $current_status + 1;
                     }
                     else
                     {
                          $next_status_id='1';

                    }
                    //----------------------------fine starts----------------------



                $payroll_deductction=RenewAgreedAmount::where('passport_id',$passport->id)->first();
               if($payroll_deductction != null){
                $payroll_amount=$payroll_deductction->payroll_deduct_amount;
               }
               else{
                $payroll_amount='0';
               }
            //else ends here
            }



    $view = view("admin-panel.visa-master.renew_visa.ajax_files.get_renew_visa_detail", compact('passport_id','name','ppuid','passport_no','remain_days',
    'next_status_id','image','renewal_contract_typing','renewal_contract_typing_amount','renewal_contract_sub','renewal_contract_sub_amount','medical',
    'medical_amount','emirates_id_apply','emirates_id_apply_amount','visa_stamping','visa_stamping_amount','emirates_id_typing','emirates_id_typing_amount',
    'emirates_id_handover','emirates_id_handover_amount','currnet_status','emirates_id_rec','emirates_id_rec_amount'))->render();
return response()->json(['html' => $view]);
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

                $ext = pathinfo($_FILES['attchemnt']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["attchemnt"]["tmp_name"], '../public/assets/upload/agreed_amount/' . $date_folder . "/" . $file_name);
                $file_path_front = 'assets/upload/agreed_amount/' . $date_folder . "/" . $file_name;
            }
        }
        $renew_already= RenewAgreedAmount::
        where('passport_id',$request->passport_id)
        ->orderBy('created_at', 'desc')->first();

        if(isset($renew_already)){
            $return_times=$renew_already->renew_turn_status+1;
            $renew_expire_status='';

        }
        else{
            $return_times='1';
            $renew_expire_status=null;
        }



        $agreed_amount  = new RenewAgreedAmount();
        $agreed_amount->passport_id = $request->passport_id;
        $agreed_amount->renew_turn_status = $return_times;
        $agreed_amount->agreed_amount = $request->agreed_amount;
        $agreed_amount->advance_amount  = $advance_amount;
        $agreed_amount->discount_amount = $json_discount_detail;
        $agreed_amount->final_amount = $request->final_amount;
        if(!empty($file_path_front)){
            $agreed_amount->attachment = $file_path_front;
        }
        if(isset($request->payroll_deduct)){
            $agreed_amount->payroll_deduction = $request->payroll_deduct_amount;
        }

        $agreed_amount->save();


        if(!empty($request->select_amount_step)){

            $counter_amount_step = 0;
            foreach($request->select_amount_step as  $step_amount){
                if(!empty($step_amount) && !empty($request->step_amount[$counter_amount_step])){
                    $array_insert = array(
                        'amount' => $request->step_amount[$counter_amount_step],
                        'rn_step_id' => $step_amount,
                        'passport_id' => $request->passport_id,
                        'rn_visa_process_status' => '1',
                    );
                    AssigningAmount::create($array_insert);
                }
                $counter_amount_step =  $counter_amount_step+1;
            }

        }
        DB::table('renewal_contract_typings')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);

        DB::table('renewal_contract_submissions')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);


        DB::table('renewal_emirates_id_applies')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);

        DB::table('renewal_visa_stampings')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);


        DB::table('renewal_emirates_id_typings')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);


        DB::table('renewal_emirates_id_receives')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);


        DB::table('renewal_emirates_id_handovers')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);


        DB::table('renewal_visa_medicals')->where('passport_id', $request->passport_id)->where('renew_expire_status',null)
        ->update(['renew_expire_status' =>'1']);


         return response()->json([
            'code' => "100",

        ]);

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


    public function renew_visa_process_contract_typing(Request $request){

        $id=$request->id;
        $contract_typing_status=RenewalContractTyping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
            // dd($contract_typing_status->renew_expire_status);
        if(isset($contract_typing_status) && $contract_typing_status->renew_expire_status==null){
            $contract_typing=RenewalContractTyping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
            // dd($contract_typing);
            $contract_typing_payment=RenewVisaPaymentOption::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
        }
        else{
            $contract_typing=null;
            $contract_typing_payment=null;

        }


        // $contract_typing=RenewalContractTyping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

        $payment_type=PaymentType::all();
        $view = view("admin-panel.visa-master.renew_visa.ajax_files.form_renewal_contract_typing",
         compact('contract_typing','payment_type','id','contract_typing_payment'))->render();

         return response()->json(['html' => $view]);
    }

    public function renewcontract_typing_save(Request $request){
        if($request->hasfile('renew_visa_attachment'))
        {
            foreach($request->file('renew_visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath ='/assets/upload/renew_visa_process/contract_typing/'.$name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }
        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file3)
            {
                $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
                $filePath2 = '/assets/upload/renew_visa_process/contract_typing/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file3));
                $data2[] = $name2;
            }
        }
        $renew_already= RenewAgreedAmount::
        where('passport_id',$request->passport_id)
        ->orderBy('created_at', 'desc')->first();

        if(isset($renew_already)){
            $return_expire=null;
            $return_times=$renew_already->renew_turn_status+1;
            $agree_id=$renew_already->id;

        }
        else{
            $return_times='1';
            $return_expire='1';
        }


        $passport_id= $request->input('passport_id');
        $obj = new RenewalContractTyping();
        $obj->passport_id = $request->input('passport_id');
        $obj->renew_expire_status = $return_expire;
        $obj->renew_turn_status = $return_times;
        $obj->renew_agreement_id = $agree_id;



        $obj->mb_no = $request->input('st_no');
        if(isset($data)){
            $obj->attachments = json_encode($data);
        }
        if(isset($data2)){
            $obj->other_attachment = json_encode($data2);
        }
        $obj->save();

        if($request->input('payment_amount')!=null){
        $obj_save=new RenewVisaPaymentOption();
        $obj_save->passport_id = $request->input('passport_id');
        $obj_save->renew_step = '1';
        $obj_save->payment_amount = $request->input('payment_amount');
        $obj_save->fine_amount = $request->input('fine_amount');
        $obj_save->payment_type = $request->input('payment_type');
        $obj_save->transaction_no = $request->input('transaction_no');
        $obj_save->transaction_date_time = $request->input('transaction_date');
        $obj_save->vat = $request->input('vat');
        $obj_save->renew_turn_status = $return_times;
        $obj_save->renew_agreement_id = $agree_id;
        $obj_save->save();
        }

        $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();
        if ($current_status->current_status==null) {
              DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
               ->update(['current_status' => '1']);
        }
        else{
            DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
            ->update(['current_status' => '1']);
        }

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
    return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
    ]);

    }


   public function renew_visa_process_contract_sub(Request $request){
        $id=$request->id;
        $contract_sub_status=RenewalContractSubmission::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

        if(isset($contract_sub_status) && $contract_sub_status->renew_expire_status==null){
            $contract_sub=RenewalContractSubmission::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
            $contract_sub_payment=RenewVisaPaymentOption::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
        }
        else{
            $contract_sub=null;
            $contract_sub_payment=null;


        }
        $payment_type=PaymentType::all();

        $view = view("admin-panel.visa-master.renew_visa\ajax_files.form_renewal_contract_sub",
         compact('contract_sub','payment_type','id','contract_sub_payment'))->render();
        return response()->json(['html' => $view]);


   }


   public function renewcontract_sub_save(Request $request){
    if($request->hasfile('renew_visa_attachment'))
    {
        foreach($request->file('renew_visa_attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/renew_visa_process/contract_sub/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }
    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/renew_visa_process/contract_sub/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $renew_already= RenewAgreedAmount::
    where('passport_id',$request->passport_id)
    ->orderBy('created_at', 'desc')->first();

    if(isset($renew_already)){
        $return_times=$renew_already->renew_turn_status+1;
        $return_expire=null;
        $agree_id=$renew_already->id;

    }
    else{
        $return_times='1';
        $return_expire='1';
    }
    $passport_id= $request->input('passport_id');
    $obj = new RenewalContractSubmission();
    $obj->passport_id = $request->input('passport_id');
    $obj->renew_expire_status = $return_times;
    $obj->mb_no = $request->input('st_no');
    $obj->renew_expire_status = $return_expire;
    $obj->renew_agreement_id = $agree_id;

    $obj->renew_turn_status = $return_times;
        if(isset($data)){
            $obj->attachments = json_encode($data);
        }
        if(isset($data2)){
            $obj->other_attachment = json_encode($data2);
        }
         $obj->save();

        if($request->input('payment_amount')!=null){
        $obj_save=new RenewVisaPaymentOption();
        $obj_save->passport_id = $request->input('passport_id');
        $obj_save->renew_step = '2';
        $obj_save->payment_amount = $request->input('payment_amount');
        $obj_save->fine_amount = $request->input('fine_amount');
        $obj_save->payment_type = $request->input('payment_type');
        $obj_save->transaction_no = $request->input('transaction_no');
        $obj_save->transaction_date_time = $request->input('transaction_date');
        $obj_save->vat = $request->input('vat');
        $obj_save->renew_turn_status = $return_times;
        $obj_save->renew_agreement_id = $agree_id;
        $obj_save->save();
        }





    $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();



    if ($current_status->current_status==null) {

          DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
           ->update(['current_status' => '2']);
    }
    else{
        DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
        ->update(['current_status' => '2']);
    }

    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);

}


public function renew_visa_process_medical(Request $request){
    $id=$request->id;
    $medical_status=RenewalVisaMedical::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

    if(isset($medical_status) && $medical_status->renew_expire_status==null){
        $medical=RenewalVisaMedical::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
    }
    else{
        $medical=null;


    }



    $payment_type=PaymentType::all();

    $view = view("admin-panel.visa-master.renew_visa.ajax_files.form_renewal_contract_medical",
     compact('medical','payment_type','id'))->render();
    return response()->json(['html' => $view]);


}


public function renewmedical_save(Request $request){


    if($request->hasfile('renew_visa_attachment'))
    {
        foreach($request->file('renew_visa_attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/renew_visa_process/medical/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }
    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/renew_visa_process/medical/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $renew_already= RenewAgreedAmount::
    where('passport_id',$request->passport_id)
    ->orderBy('created_at', 'desc')->first();

    if(isset($renew_already)){
        $return_times=$renew_already->renew_turn_status+1;
        $return_expire=null;
        $agree_id=$renew_already->id;

    }
    else{
        $return_times='1';
        $return_expire='1';
    }

    $passport_id= $request->input('passport_id');
    $obj = new RenewalVisaMedical();

    $obj->medical_type = $request->input('med_type');
    $obj->passport_id = $request->input('passport_id');
    $obj->renew_expire_status = $return_expire;
    $obj->medical_tans_no = $request->input('medical_tans_no');
    $obj->medical_date_time = $request->input('medical_date_time');
    $obj->payment_amount = $request->input('payment_amount');
    $obj->payment_type = $request->input('payment_type');
    $obj->transaction_no = $request->input('transaction_no');
    $obj->transaction_date_time = $request->input('transaction_date_time');
    $obj->vat = $request->input('vat');
    $obj->renew_turn_status = $return_times;
    $obj->renew_agreement_id = $agree_id;

    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    if(isset($data2)){
        $obj->other_attachments = json_encode($data2);
    }
    $obj->save();



    $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();



    if ($current_status->current_status==null) {

          DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
           ->update(['current_status' => '3']);
    }
    else{
        DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
        ->update(['current_status' => '3']);
    }

    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);

}

public function renew_emirates_id_apply(Request $request){
    $id=$request->id;
    $eid_apply_x=RenewalEmirates_id_apply::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
    if(isset($eid_apply_x) && $eid_apply_x->renew_expire_status==null){
        $eid_apply=RenewalEmirates_id_apply::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
    }
    else{
        $eid_apply=null;

    }
    $payment_type=PaymentType::all();
    $view = view("admin-panel.visa-master.renew_visa.ajax_files.form_renewal_eid",compact('eid_apply','payment_type','id'))->render();
    return response()->json(['html' => $view]);


}

public function reneweid_apply_save(Request $request){

    if($request->hasfile('renew_visa_attachment'))
    {
        foreach($request->file('renew_visa_attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/renew_visa_process/emirates_id_apply/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }

    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/renew_visa_process/emirates_id_apply/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $renew_already= RenewAgreedAmount::
    where('passport_id',$request->passport_id)
    ->orderBy('created_at', 'desc')->first();

    if(isset($renew_already)){
        $return_times=$renew_already->renew_turn_status+1;
        $return_expire=null;
        $agree_id=$renew_already->id;

    }
    else{
        $return_times='1';
        $return_expire='1';
    }

    $passport_id= $request->input('passport_id');
    $obj = new RenewalEmirates_id_apply();
    $obj->passport_id = $request->input('passport_id');
    $obj->renew_expire_status = $return_expire;
    $obj->e_id_app_expiry = $request->input('eid_exp');
    $obj->renew_turn_status = $return_times;

        if(isset($data)){
            $obj->attachment = json_encode($data);
        }
        if(isset($data2)){
            $obj->other_attachment = json_encode($data2);
        }

        $obj->save();

        if($request->input('payment_amount')!=null){
        $obj_save=new RenewVisaPaymentOption();
        $obj_save->passport_id = $request->input('passport_id');
        $obj_save->renew_step = '1';
        $obj_save->payment_amount = $request->input('payment_amount');
        $obj_save->fine_amount = $request->input('fine_amount');
        $obj_save->payment_type = $request->input('payment_type');
        $obj_save->transaction_no = $request->input('transaction_no');
        $obj_save->transaction_date_time = $request->input('transaction_date');
        $obj_save->vat = $request->input('vat');
        $obj_save->renew_turn_status = $return_times;
        $obj_save->renew_expire_status = $return_expire;
        $obj->renew_agreement_id = $agree_id;
        $obj_save->save();
        }






    $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();



    if ($current_status->current_status==null) {

          DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
           ->update(['current_status' => '4']);
    }
    else{
        DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
        ->update(['current_status' => '4']);
    }

    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);
}


public function renew_visa_stamping(Request $request){
    $id=$request->id;

    $visa_stamp_x=RenewalVisaStamping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

    if(isset($visa_stamp_x) && $visa_stamp_x->renew_expire_status==null){
        $visa_stamp=RenewalVisaStamping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
    }
    else{
        $visa_stamp=null;
    }
    $payment_type=PaymentType::all();
    $view = view("admin-panel.visa-master.renew_visa.ajax_files.form_renewal_visa_stamping",compact('visa_stamp','payment_type','id'))->render();
    return response()->json(['html' => $view]);


}

public function renew_visa_stamp_save(Request $request){


    if($request->hasfile('visa_attachment'))
    {
        foreach($request->file('visa_attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/renew_visa_process/renew_visa_stamping/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }

    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/renew_visa_process/renew_visa_stamping/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $renew_already= RenewAgreedAmount::
    where('passport_id',$request->passport_id)
    ->orderBy('created_at', 'desc')->first();

    if(isset($renew_already)){
        $return_times=$renew_already->renew_turn_status+1;
        $return_expire=null;
        $agree_id=$renew_already->id;

    }
    else{
        $return_times='1';
        $return_expire='1';
    }

    $passport_id= $request->input('passport_id');
    $obj = new RenewalVisaStamping();
    $obj->passport_id = $request->input('passport_id');

    $obj->visa_stamping_payment_option = $request->input('visa_stamping_payment_option');
    $obj->renew_turn_status = $return_times;
    $obj->renew_expire_status = $return_expire;
    $obj->renew_agreement_id = $agree_id;


    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    if(isset($data2)){
        $obj->other_attachment = json_encode($data2);
    }
    $obj->save();
    if($request->input('payment_amount')!=null){
        $obj_save=new RenewVisaPaymentOption();
        $obj_save->passport_id = $request->input('passport_id');
        $obj_save->renew_step = '1';
        $obj_save->payment_amount = $request->input('payment_amount');
        $obj_save->fine_amount = $request->input('fine_amount');
        $obj_save->payment_type = $request->input('payment_type');
        $obj_save->transaction_no = $request->input('transaction_no');
        $obj_save->transaction_date_time = $request->input('transaction_date');
        $obj_save->vat = $request->input('vat');
        $obj_save->renew_turn_status = $return_times;
        $obj_save->renew_expire_status = $return_expire;
        $obj_save->renew_agreement_id = $agree_id;
        $obj_save->save();
        }






    $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();



    if ($current_status->current_status==null) {

          DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
           ->update(['current_status' => '5']);
    }
    else{
        DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
        ->update(['current_status' => '5']);
    }

    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);

}
public function renew_visa_pasting(Request $request){
    $id=$request->id;
//table name is emieartes id typing but actually it is visa pasting
$visa_pasted_x=RenewalEmiratesIdTyping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

if(isset($visa_pasted_x) && $visa_pasted_x->renew_expire_status==null){
    $visa_pasted=RenewalEmiratesIdTyping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
}
else{
    $visa_pasted=null;
}

$visa_pasted_amount=RenewalEmiratesIdTyping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

    $payment_type=PaymentType::all();
    $view = view("admin-panel.visa-master.renew_visa.ajax_files.form_renew_visa_pasting",compact('visa_pasted','payment_type','id'))->render();
    return response()->json(['html' => $view]);


}


public function renew_visa_pasted_save(Request $request){

    if($request->hasfile('visa_attachment'))
    {
        foreach($request->file('visa_attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/renew_visa_process/visa_pasting/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }

    $renew_already= RenewAgreedAmount::
    where('passport_id',$request->passport_id)
    ->orderBy('created_at', 'desc')->first();

    if(isset($renew_already)){
        $return_times=$renew_already->renew_turn_status+1;
        $return_expire=null;
        $agree_id=$renew_already->id;

    }
    else{
        $return_times='1';
        $return_expire='1';
    }

            $passport_id= $request->input('passport_id');
            $obj = new RenewalEmiratesIdTyping();
            $obj->passport_id = $request->input('passport_id');
            $obj->renew_expire_status = $return_times;
            $obj->status = $request->input('status');
            $obj->issue_date = $request->input('issue_date');
            $obj->expiry_date = $request->input('expiry_date');
            $obj->renew_turn_status = $return_times;
            $obj->renew_expire_status = $return_expire;
            $obj->renew_agreement_id = $agree_id;



            if(isset($data)){
                $obj->attachment = json_encode($data);
            }
            $obj->save();;


    $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();



    if ($current_status->current_status==null) {

          DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
           ->update(['current_status' => '6']);
    }
    else{
        DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
        ->update(['current_status' => '6']);
    }

    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;

    return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);


}



public function renew_visa_eid_rec(Request $request){
    $id=$request->id;
//table name is emieartes id typing but actually it is visa pasting
    $unique_x=RenewalEmiratesIdReceive::where('passport_id',$id)->orderBy('created_at', 'desc')->first();
    if(isset($unique_x) && $unique_x->renew_expire_status==null){
        $unique=RenewalEmiratesIdReceive::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

    }
    else{
        $unique=null;
    }
    $payment_type=PaymentType::all();

    $eid=Emirates_id_cards::where('passport_id',$id)->where('status','2')->first();


    $view = view("admin-panel.visa-master.renew_visa.ajax_files.form_emirates_id_receive",compact('unique','payment_type','id','eid'))->render();
    return response()->json(['html' => $view]);


}


public function renew_visa_eid_rec_save(Request $request){

if($request->hasfile('visa_attachment'))
{
    foreach($request->file('visa_attachment') as $file)
    {
        $name =rand(100,100000).'.'.time().'.'.$file->extension();
        $filePath = '/assets/upload/renew_visa_process/emirates_id_recive/' . $name;
        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
        $data[] = $name;
    }
}
        $renew_already= RenewAgreedAmount::
        where('passport_id',$request->passport_id)
        ->orderBy('created_at', 'desc')->first();

        if(isset($renew_already)){
            $return_times=$renew_already->renew_turn_status+1;
            $return_expire=null;
            $agree_id=$renew_already->id;
        }
        else{
            $return_times='1';
            $return_expire='1';
        }

            $passport_id= $request->input('passport_id');
            $obj = new RenewalEmiratesIdReceive();
            $passport_id= $request->input('passport_id');
            $obj->renew_expire_status = $return_times;
            $obj->passport_id = $request->input('passport_id');
            $obj->status = $request->input('status');
            $obj->issue_date = $request->input('issue_date');
            $obj->expiry_date = $request->input('expiry_date');
            $obj->renew_turn_status = $return_times;
            $obj->renew_expire_status = $return_expire;
            $obj->renew_agreement_id = $agree_id;

            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
            $obj->save();




            if(isset($request->card_no) || $request->eid_already=='2'){
                if(!empty($_FILES['front_pic']['name'])){
                    $img = $request->file('front_pic');
                    $file_path_front = 'assets/upload/emirates_id_card/front/' .time() . '.' . $img ->getClientOriginalExtension();
                    $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                    Storage::disk("s3")->put($file_path_front, $imageS3->stream());

                }

                    if(!empty($_FILES['back_pic']['name'])){
                        $img = $request->file('back_pic');
                        $file_path_back = 'assets/upload/emirates_id_card/back/' .time() . '.' . $img ->getClientOriginalExtension();
                        $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                        $constraint->aspectRatio();
                                    });
                        Storage::disk("s3")->put($file_path_back, $imageS3->stream());

                    }

                    $card = new Emirates_id_cards();
                    $card->passport_id = $request->input('passport_id');
                    $card->card_no = $request->edit_id_number;
                    $card->expire_date = $request->edit_expire_date;
                    $card->status = '2';

                    if(!empty($file_path_front)){
                        $card->card_front_pic = $file_path_front;
                    }
                    if(!empty($file_path_back)){
                        $card->card_back_pic = $file_path_back;
                    }
                    $card->enter_by = Auth::user()->id;
                    $card->save();
                }

            $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();



if ($current_status->current_status==null) {

      DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
       ->update(['current_status' => '7']);
}
else{
    DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
    ->update(['current_status' => '7']);
}

$passport_id= $request->input('passport_id');
$passport=Passport::where('id',$passport_id)->first();
$pass_no=$passport->passport_no;

return response()->json([
'code' => "100",
'passport_no'=>$pass_no
]);


}





public function renew_visa_eid_handover(Request $request){
    $id=$request->id;
    $handover_x=RenewalEmiratesIdHandover::where('passport_id',$id)->orderBy('created_at', 'desc')->first();


    if(isset($handover_x) && $handover_x->renew_expire_status==null){
        $handover=RenewalEmiratesIdHandover::where('passport_id',$id)->orderBy('created_at', 'desc')->first();

    }
    else{
        $handover=null;
    }
    $payment_type=PaymentType::all();

    $view = view("admin-panel.visa-master.renew_visa.ajax_files.form_renewal_eid_handover",compact('handover','payment_type','id'))->render();
    return response()->json(['html' => $view]);


}
 public function renew_eid_handover(Request $request){
        if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath = '/assets/upload/renew_visa_process/emirates_id_handover/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }
        $renew_already= RenewAgreedAmount::
        where('passport_id',$request->passport_id)
        ->orderBy('created_at', 'desc')->first();

        if(isset($renew_already)){
            $return_times=$renew_already->renew_turn_status+1;
            $return_expire=null;
            $agree_id=$renew_already->id;

        }
        else{
            $return_times='1';
            $return_expire='1';
        }
        $passport_id= $request->input('passport_id');
        $obj = new RenewalEmiratesIdHandover();
        $obj->passport_id = $request->input('passport_id');
        $obj->renew_expire_status = $return_times;
        $obj->status = $request->input('status');
        $obj->renew_turn_status = $return_times;
        $obj->renew_expire_status = $return_expire;
        $obj->renew_agreement_id = $agree_id;

        if(isset($data)){
            $obj->attachment = json_encode($data);
        }
        $obj->save();

        $current_status = DB::table('renew_agreed_amounts')->where('passport_id',$passport_id)->orderBy('created_at', 'desc')->first();

        if ($current_status->current_status==null) {

            DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
            ->update(['current_status' => '8']);
        }
        else{
            DB::table('renew_agreed_amounts')->where('id', $current_status->id)->orderBy('created_at', 'desc')
            ->update(['current_status' => '8']);
        }

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;

        return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
        ]);


 }

   public function expired_visa(){
    $curr_date=date('Y-m-d');

    $renewed_visas=RenewAgreedAmount::pluck('passport_id');

    // $x=round($renewed_visas);

    $visa_pasted= VisaPasted::whereNotIn('passport_id',$renewed_visas)->where('expiry_date' ,'<',$curr_date)->get();
    // dd($visa_pasted);
    return view('admin-panel.visa-master.renew_visa.expired_list',compact('visa_pasted'));
    // $date2 = strtotime($expiry_date);


 }


 public function renew_visa_pendings(Request $request){

    $step_id=$request->id;
    // dd($step_id);
    $step_id_to_get=$step_id-1;

// dd($step_id_to_get);

if($step_id=='9'){
    $visa_process_to_start=RenewAgreedAmount::where('current_status','8')->get();
}else{
    $visa_process_to_start=RenewAgreedAmount::where('current_status',$step_id_to_get)->get();
}

        // dd($visa_process_to_start);

        $data=array();

            foreach($visa_process_to_start as $row){

                $gamer = array(
                    'id' =>$row->id,
                    'passport_id' =>$row->passport_id,
                    'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:'N/A',
                    'pass_no' => isset( $row->passport->passport_no)?  $row->passport->passport_no:"N/A",
                    'pp_uid' => isset( $row->passport->pp_uid)? $row->passport->pp_uid:'N/A',
                    'agreed_amount'=>isset($row->agreed_amount)?$row->agreed_amount:'N/A',
                    'advance_amount'=>isset($row->advance_amount)?$row->advance_amount:'N/A',
                    'discount_amount'=>isset($row->discount_amount)?$row->discount_amount:'N/A',
                    'final_amount'=>isset($row->final_amount)?$row->final_amount:'N/A',
                    'payroll_deduct_amount'=>isset($row->payroll_deduction)?$row->payroll_deduction:'N/A',
                );
                $data[] = $gamer;
            }
    $view = view("admin-panel.visa-master.renew_visa.ajax_files.pending_renewals",compact('data','step_id'))->render();
    return response()->json(['html' => $view]);
 }


 //renew visa expires

  public function  renew_expired_visa(){
    $curr_date=date('Y-m-d');
    //table name is emieartes id typing but actually it is visa pasting
    $renew_expired= RenewalEmiratesIdTyping::where('expiry_date' ,'<',$curr_date)->where('renew_expire_status','1')->orderBy('created_at', 'desc')->get();

    return view('admin-panel.visa-master.renew_visa.renew_expired_list',compact('renew_expired'));

  }

  public function renew_visa_history(){

        $renew_history= RenewAgreedAmount::orderBy('passport_id')->get();
        $renew_eid_typing= RenewalEmiratesIdTyping::all();
        // $contract_typing_status=RenewalContractTyping::where('passport_id',$id)->orderBy('created_at', 'desc')->first();




        $data=array();

        foreach($renew_history as $row){

          $renewed_at=  $renew_eid_typing->where('renew_agreement_id',$row->id)->pluck('issue_date')->first();
          $expires_at=  $renew_eid_typing->where('renew_agreement_id',$row->id)->pluck('expiry_date')->first();



          $gamer = array(
                'id' =>$row->id,
                'renewal_times' =>$row->renew_turn_status,
                'passport_id' =>$row->passport_id,
                'name' =>  isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:'N/A',
                'pass_no' => isset( $row->passport->passport_no)?  $row->passport->passport_no:"N/A",
                'pp_uid' => isset( $row->passport->pp_uid)? $row->passport->pp_uid:'N/A',
                'renewed_at' => isset($renewed_at)?date('d-m-Y', strtotime($renewed_at)):"N/A",
                'expires_at' => isset($expires_at)?date('d-m-Y', strtotime($expires_at)):"N/A",
            );
            $data[] = $gamer;

        }
        // dd($data);

        return view('admin-panel.visa-master.renew_visa.renewal_history',compact('data'));
  }






}
