<?php

namespace App\Http\Controllers\VisaProcess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AgreedAmount;
use App\Model\DiscountName\DiscountName;
use App\Model\Guest\Career;
use App\Model\Master_steps;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Passport\Passport;
use App\Model\PaymentType;
use App\Model\Seeder\Company;
use App\Model\VisaProcess\AssigningAmount;
use App\Model\VisaProcess\OwnVisa\OwnVisaContractSubmission;
use App\Model\VisaProcess\OwnVisa\OwnVisaContractTyping;
use App\Model\VisaProcess\OwnVisa\OwnVisaCurrentStatus;
use App\Model\VisaProcess\OwnVisa\OwnVisaLabourCardApproval;
use App\Model\VisaProcess\RenewAgreedAmount;
use App\Model\VisaProcess\VisaPaymentOptions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OwnVisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //




        return view('admin-panel.visa-master.own_visa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

              $passport=Passport::where('passport_no',$request->keyword)->first();
            $own_visa=Career::where('passport_no',$passport->passport_no)->where('visa_status','3')->where('visa_status_own','1')->first();


             if($own_visa==null){
                $visa_remarks='1';

            }
            else{
                $visa_remarks='2';
            }


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

            $own_visa_typing=OwnVisaContractTyping::where('passport_id',$passport->id)->first();
            $own_visa_sub=OwnVisaContractSubmission::where('passport_id',$passport->id)->first();
            $own_visa_labour=OwnVisaLabourCardApproval::where('passport_id',$passport->id)->first();
            $current_status=OwnVisaCurrentStatus::where('passport_id',$passport->id)->latest()->first();

           if($current_status != null){
            $next_status_value=$current_status->current_process_id;
            $next_status=$next_status_value+1;
           }
           else{
               $next_status='0';
           }




            $view = view("admin-panel.visa-master.own_visa.own_visa_ajax_files.get_own_visa_names",
             compact('passport_id','name','ppuid','passport_no','remain_days','image','visa_remarks','own_visa_typing','own_visa_sub','own_visa_labour','next_status'))->render();
        return response()->json(['html' => $view]);
    }


    public function own_contract_typing(Request $request){
        $id=$request->id;
        $own_visa_typing=OwnVisaContractTyping::where('passport_id',$id)->first();
        $own_visa_typing_pay=VisaPaymentOptions::where('passport_id',$id)->where('own_visa','1')->where('own_visa_step','1')->first();
        $company=Company::all();
        $payment_type=PaymentType::all();

        $view = view("admin-panel.visa-master.own_visa.own_visa_ajax_files.own_visa_typing",
        compact('own_visa_typing','company','payment_type','id','own_visa_typing_pay'))->render();
        return response()->json(['html' => $view]);
    }

   public function own_contract_typing_save(Request $request ){
    $user_id=Auth::user()->id;
    if($request->hasfile('attachment'))
    {
        foreach($request->file('attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/own_visa/own_contract_typing/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }
    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/attachment/own_contract_typing/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $passport_id= $request->input('passport_id');
    $obj = new OwnVisaContractTyping();
    $obj->passport_id = $request->input('passport_id');
    $obj->mb_no = $request->input('mb_no');
    $obj->company = $request->input('company');
    $obj->user_id =  $user_id;




    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    $obj->save();
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');

            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction_date_time');
            $obj_pay->vat = $request->input('vat');
            $obj_pay->own_visa = '1';
            $obj_pay->own_visa_step = '1';
            if(isset($data2)){
                $obj_pay->other_attachment = json_encode($data2);
            }
            $obj_pay->save();


    if(isset($data2)){
        $obj->other_attachment = json_encode($data2);
    }




    //add current status , first time status will be added. after that status will bee updated

    $object = new OwnVisaCurrentStatus();
    $object->passport_id = $request->input('passport_id');

    $object->current_process_id = '1';
    $object->save();


    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
    return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);
   }

   public function own_contract_sub_save(Request $request ){
    $user_id=Auth::user()->id;
    if($request->hasfile('attachment'))
    {
        foreach($request->file('attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/own_visa/own_contract_sub/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }
    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/attachment/own_contract_sub/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $passport_id= $request->input('passport_id');
    $obj = new OwnVisaContractSubmission();
    $obj->passport_id = $request->input('passport_id');
    $obj->mb_no = $request->input('mb_no');
    $obj->user_id =  $user_id;
    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    $obj->save();
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction_date_time');
            $obj_pay->vat = $request->input('vat');
            $obj_pay->own_visa = '1';
            $obj_pay->own_visa_step = '2';
            if(isset($data2)){
                $obj_pay->other_attachment = json_encode($data2);
            }
            $obj_pay->save();


    if(isset($data2)){
        $obj->other_attachment = json_encode($data2);
    }




    //add current status , first time status will be added. after that status will bee updated


    $current_status = DB::table('own_visa_current_statuses')->where('passport_id',$passport_id)->first();
    DB::table('own_visa_current_statuses')->where('id', $current_status->id)
    ->update(['current_process_id' => '2']);


    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
    return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);
   }


   public function own_contract_sub(Request $request){
    $id=$request->id;
    $own_visa_sub=OwnVisaContractSubmission::where('passport_id',$id)->first();
    $own_visa_sub_pay=VisaPaymentOptions::where('passport_id',$id)->where('own_visa','1')->where('own_visa_step','2')->first();


    $payment_type=PaymentType::all();

    $view = view("admin-panel.visa-master.own_visa.own_visa_ajax_files.own_visa_sub",
    compact('own_visa_sub','payment_type','id','own_visa_sub_pay'))->render();
    return response()->json(['html' => $view]);
}

public function own_labour(Request $request){
    $id=$request->id;
    $own_visa_lab=OwnVisaLabourCardApproval::where('passport_id',$id)->first();
    $own_visa_lab_pay=VisaPaymentOptions::where('passport_id',$id)->where('own_visa','1')->where('own_visa_step','3')->first();

    $payment_type=PaymentType::all();

    $view = view("admin-panel.visa-master.own_visa.own_visa_ajax_files.own_labour_card",
    compact('own_visa_lab','payment_type','id','own_visa_lab_pay'))->render();
    return response()->json(['html' => $view]);
}



public function own_contract_lab_save(Request $request ){
    $user_id=Auth::user()->id;
    if($request->hasfile('attachment'))
    {
        foreach($request->file('attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/own_visa/own_contract_lab/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }
    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/attachment/own_contract_lab/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $passport_id= $request->input('passport_id');
    $obj = new OwnVisaLabourCardApproval();
    $obj->passport_id = $request->input('passport_id');
    $obj->labour_card_no = $request->input('labour_card_no');
    $obj->user_id =  $user_id;
    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    $obj->save();
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction_date_time');
            $obj_pay->vat = $request->input('vat');
            $obj_pay->own_visa = '1';
            $obj_pay->own_visa_step = '3';
            if(isset($data2)){
                $obj_pay->other_attachment = json_encode($data2);
            }
            $obj_pay->save();


    if(isset($data2)){
        $obj->other_attachment = json_encode($data2);
    }




    //add current status , first time status will be added. after that status will bee updated


    $current_status = DB::table('own_visa_current_statuses')->where('passport_id',$passport_id)->first();
    DB::table('own_visa_current_statuses')->where('id', $current_status->id)
    ->update(['current_process_id' => '3']);


    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
    return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
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

    public function change_own_visa_status(){
        $discount_names = DiscountName::orderby('id','desc')->get();
        $master_steps = Master_steps::where('id','!=','1')->get();
        $own_visa=Career::where('visa_status','3')->where('visa_status_own','1')->pluck('passport_no')->toArray();
        $passport=Passport::whereIn('passport_no',$own_visa)->orWhere('visa_status','3')->pluck('id')->toArray();
        $own= OwnVisaCurrentStatus ::whereIn('passport_id',$passport)->pluck('passport_id')->toArray();
        $own_visa_to_start= Passport::whereIn('id',$passport)->whereNotIn('id',$own)->get();

        return view('admin-panel.visa-master.own_visa.own_visa_status_change',compact('own_visa_to_start','discount_names','master_steps'));

    }

    public function own_visa_list(){
        $own_visa=Career::where('visa_status','3')->where('visa_status_own','1')->pluck('passport_no')->toArray();
        $passport=Passport::whereIn('passport_no',$own_visa)->orWhere('visa_status','3')->pluck('id')->toArray();
        $own= OwnVisaCurrentStatus ::whereIn('passport_id',$passport)->pluck('passport_id')->toArray();
        $own_visa_to_start= Passport::whereIn('id',$passport)->whereNotIn('id',$own)->get();

             return view('admin-panel.visa-master.own_visa.own_visa_to_start',compact('own_visa_to_start'));
    }

    public function own_visa_to_start(){
        $own_visa=Career::where('visa_status','3')->where('visa_process_start_status','1')->where('visa_status_own','1')->pluck('passport_no')->toArray();
        $passport=Passport::whereIn('passport_no',$own_visa)->where('visa_process_start_status','1')->orWhere('visa_status','3')->pluck('id')->toArray();
        $own= OwnVisaCurrentStatus ::whereIn('passport_id',$passport)->pluck('passport_id')->toArray();
        $own_visa_to_start= Passport::whereIn('id',$passport)->whereNotIn('id',$own)->get();

             return view('admin-panel.visa-master.own_visa.own_visa_process_steps_to_start',compact('own_visa_to_start'));
    }

    public function own_visa_sub(Request $request){
        $current_status=$request->master_id;


    // if($master_id=='3')
    // $own_visa=Career::where('visa_status','3')->where('visa_status_own','1')->pluck('passport_no')->toArray();
    // $passport=Passport::whereIn('passport_no',$own_visa)->pluck('id')->toArray();
    $own= OwnVisaCurrentStatus ::where('current_process_id',$current_status)->pluck('passport_id')->toArray();

    $own_visa_to_start= Passport::whereIn('id',$own)->get();

        $view = view("admin-panel.visa-master.own_visa.own_visa_ajax_files.ajax_own_visa_sub", compact('own_visa_to_start','current_status'))->render();

        return response()->json(['html' => $view]);


    }


    public function own_visa_change_save(Request $request){
            // dd($request->all());

            $passport_id=$request->career_primary_id;


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

        $agreed_amount  = new AgreedAmount();
        $agreed_amount->passport_id =$passport_id;
        $agreed_amount->agreed_amount = $request->agreed_amount;
        $agreed_amount->advance_amount  = $advance_amount;
        $agreed_amount->discount_details = $json_discount_detail;
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
                        'passport_id' => $passport_id,
                        'rn_visa_process_status' => '1',
                    );
                    AssigningAmount::create($array_insert);
                }
                $counter_amount_step =  $counter_amount_step+1;
            }

        }


//----------------------------------------------

            $validator = Validator::make($request->all(), [
                'visa_status' => 'required',
                'career_primary_id' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";

                foreach ($validate->all() as $error){
                    $message_error .= $error;
                }

                $message = [
                    'message' => $message_error,
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }


            $obj = Passport::find($request->career_primary_id);


            if(!empty($request->input('visa_status'))){
                $obj->visa_status = trim($request->input('visa_status'));
            }

            if($request->input('visa_status')=="1"){
                $validator = Validator::make($request->all(), [
                    'visit_visa_status' => 'required',
                    'visit_exit_date' => 'required',
                ]);
                if ($validator->fails()) {
                    $validator = $validator->errors();
                $message_error = "";

                foreach ($validator->all() as $error){
                    $message_error .= $error;
                }

                $message = [
                    'message' => $message_error,
                    'alert-type' => 'error',
                    'error' => $validator->first()
                ];
                return redirect()->back()->with($message);

                }
                $obj->visa_status_visit = trim($request->input('visit_visa_status'));
                $obj->exit_date = trim($request->visit_exit_date);

            }elseif($request->input('visa_status')=="2"){
                $validator = Validator::make($request->all(), [
                    'cancel_visa_status' => 'required',
                    'cancel_fine_date' => 'required'
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                    $validate = $validator->errors();
                    $message_error = "";

                    foreach ($validate->all() as $error){
                        $message_error .= $error;
                    }

                    $message = [
                        'message' => $message_error,
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->back()->with($message);
                }
                $obj->visa_status_cancel = trim($request->input('cancel_visa_status'));
                $obj->exit_date = trim($request->cancel_fine_date);

            }elseif($request->input('visa_status')=="3"){
                $validator = Validator::make($request->all(), [
                    'own_visa_status' => 'required'
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                    $validate = $validator->errors();
                    $message_error = "";

                    foreach ($validate->all() as $error){
                        $message_error .= $error;
                    }

                    $message = [
                        'message' => $message_error,
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->back()->with($message);
                }
                $obj->visa_status_own = trim($request->input('own_visa_status'));
            }

            $obj->update();



            Career::where('passport_no','=',$obj->passport_no)
                ->update(['visa_status'=> trim($request->input('visit_visa_status'))]);





            $message = [
                'message' => "Status changed successfully!",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->back()->with($message);

    }

}
