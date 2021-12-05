<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\CompanyCode;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\ElectronicApproval\ElectronicPreApprovalPayment;
use App\Model\LabourCardTypeAssign;
use App\Model\Offer_letter\Offer_letter;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\VisaAttachment;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Passport\Passport;
use App\Model\VisaProcess\BypassVisa;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\VisaProcess\VisaPaymentOptions;
use App\Model\VisaProcess\VisaProcessLabourInsurance;

class ElectronicPreApprovalController extends Controller
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
        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();

        if($request->edit_status=='1'){

             $id=$request->request_id;
                if($request->hasfile('visa_attachment'))
                {
                    foreach($request->file('visa_attachment') as $file)
                    {
                        $name =rand(100,100000).'-'.time().'.'.$file->extension();
                        $filePath = '/assets/upload/electronic_pre_approval/' . $name;
                        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                        $data[] = $name;
                    }
                }
                    $passport_id= $request->input('passport_id');
                    $obj = ElectronicPreApproval::find($id);
                    $obj->passport_id = $request->input('passport_id');
                    $obj->labour_approval = $request->input('labour_approval');
                    $obj->labour_card_no = $request->input('labour_card_no');
                    $obj->is_complete = '1';
                if(isset($data)){
                    $obj->visa_attachment = json_encode($data);
                }
                if($obj->replace_status=='1'){
                    $obj->replace_status = '2';
                }
                    $obj->save();

                    return response()->json([
                        'code' => "104",
                        'passport_no'=>$pass_no
                    ]);
        }else{




        if(!isset($by_pass)){
        $validator = Validator::make($request->all(), [
            'person_code' => 'unique:electronic_pre_approval,person_code',

       ]);
       if ($validator->fails()) {
           $validate = $validator->errors();
           $message_error = "";

           foreach ($validate->all() as $error){
               $message_error .= $error;
           }

           $validate = $validator->errors();
           return response()->json([
            'code' => "102",
            'passport_no'=>$pass_no
        ]);
       }
    }

        if($request->hasfile('visa_attachment'))
        {

            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = '/assets/upload/electronic_pre_approval/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;

            }
        }



            $passport_id= $request->input('passport_id');
            $obj = new ElectronicPreApproval();
            $obj->passport_id = $request->input('passport_id');
            $obj->labour_approval = $request->input('labour_approval');
            $obj->labour_card_no = $request->input('labour_card_no');
            $obj->is_complete = '1';
        if(isset($data)){
            $obj->visa_attachment = json_encode($data);
        }
            $obj->save();

            $table_id = DB::table('electronic_pre_approval')->latest('id')->first();
            $id=$table_id->id;


            $current_labour_card_count = DB::table('labour_card_type_assigns')->where('passport_id',$passport_id)->count();
            $current_labour = DB::table('labour_card_type_assigns')->where('passport_id',$passport_id)->first();

            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();
            if ($current_status_count=='0') {
                $obj4 = new CurrentStatus();
                $obj4->passport_id = $request->input('passport_id');
                $obj4->current_process_id = '28';
                $obj4->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '28']);
            }

            $passport_id= $request->input('passport_id');
            $passport=Passport::where('id',$passport_id)->first();
            $pass_no=$passport->passport_no;
        return response()->json([
            'code' => "100",
            'passport_no'=>$pass_no
        ]);

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

    public function elec_pre_app_payment(Request $request)
    {
        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();
        //
        if($request->edit_status=='1'){

            $id=$request->request_id;

            if(!isset($by_pass)){
                $validator = Validator::make($request->all(), [
                    'mb_no' => 'unique:electronic_pre_approval_payments,mb_no,'.$id,

               ]);
               if ($validator->fails()) {
                   $validate = $validator->errors();
                   $message_error = "";

                   foreach ($validate->all() as $error){
                       $message_error .= $error;
                   }

                   $validate = $validator->errors();
                   return response()->json([
                    'code' => "103",
                    'passport_no'=>$pass_no
                ]);
               }
            }
                if($request->hasfile('visa_attachment'))
                {

                    foreach($request->file('visa_attachment') as $file)
                    {
                        $name =rand(100,100000).'-'.time().'.'.$file->extension();
                        $filePath = '/assets/upload/ElectronicPreAppPay/' . $name;

                        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                        $data[] = $name;

                    }
                }



                if($request->hasfile('file_name'))
                {
                    foreach($request->file('file_name') as $file2)
                    {
                        $name2 =rand(100,100000).'-'.time().'.'.$file2->extension();
                        $filePath2 = '/assets/upload/ElectronicPreAppPay/other_attachments/' . $name2;
                        $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                        $data2[] = $name2;
                    }

                }





                $passport_id= $request->input('passport_id');
                $obj =  ElectronicPreApprovalPayment::find($id);
                $obj->passport_id = $request->input('passport_id');
                $obj->mb_no = $request->input('mb_no');
                $obj->labour_card_no = $request->input('labour_card_no');
                $obj->issue_date = $request->input('issue_date');
                $obj->expiry_date = $request->input('expiry_date');
                if(isset($data)){
                    $obj->visa_attachment = json_encode($data);
                }
                if($obj->replace_status=='1'){
                    $obj->replace_status = '2';
                }
                $obj->save();
                if($request->input('payment_checkbox')!=null){
                    $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','5')->first();


                        if(!isset($pay_option)){
                            $obj_pay = new VisaPaymentOptions();
                        }
                        else{
                            $pay_id=$pay_option->id;
                            $obj_pay =  VisaPaymentOptions::find($pay_id);
                        }
                    $obj_pay->passport_id = $request->input('passport_id');
                    $obj_pay->visa_process_step_id ='5';
                    $obj_pay->payment_amount = $request->input('payment_amount');
                    $obj_pay->payment_type = $request->input('payment_type');
                    $obj_pay->transaction_no = $request->input('transaction_no');
                    $obj_pay->transaction_date_time = $request->input('transaction_date_time');
                    $obj_pay->vat = $request->input('vat');
                    $obj_pay->fine_amount = $request->input('fine_amount');
                    $obj_pay->service_charges = $request->input('service_charges');
                if(isset($data2)){
                    //other attachment
                    $obj_pay->other_attachment = json_encode($data2);
                }

                $obj_pay->save();

            }
            return response()->json([
                'code' => "104",
                'passport_no'=>$pass_no
            ]);
        }
        else{


        if(!isset($by_pass)){

        $validator = Validator::make($request->all(), [
            'mb_no' => 'unique:electronic_pre_approval_payments,mb_no',

       ]);
       if ($validator->fails()) {
           $validate = $validator->errors();
           $message_error = "";

           foreach ($validate->all() as $error){
               $message_error .= $error;
           }

           $validate = $validator->errors();
           return response()->json([
            'code' => "102",
            'passport_no'=>$pass_no
        ]);
       }
    }
        if($request->hasfile('visa_attachment'))
        {

            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'-'.time().'.'.$file->extension();
                $filePath = '/assets/upload/ElectronicPreAppPay/' . $name;

                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;

            }
        }



        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'-'.time().'.'.$file2->extension();
                $filePath2 = '/assets/upload/ElectronicPreAppPay/other_attachments/' . $name2;
                $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                $data2[] = $name2;
            }

        }





        $passport_id= $request->input('passport_id');
        $obj = new ElectronicPreApprovalPayment();
        $obj->passport_id = $request->input('passport_id');
        $obj->mb_no = $request->input('mb_no');
        $obj->labour_card_no = $request->input('labour_card_no');
        $obj->issue_date = $request->input('issue_date');
        $obj->expiry_date = $request->input('expiry_date');
        if(isset($data)){
            $obj->visa_attachment = json_encode($data);
        }
        $obj->save();
        if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='5';
            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction_date_time');
            $obj_pay->vat = $request->input('vat');
            $obj_pay->fine_amount = $request->input('fine_amount');
            $obj_pay->service_charges = $request->input('service_charges');
        if(isset($data2)){
            //other attachment
            $obj_pay->other_attachment = json_encode($data2);
        }

        $obj_pay->save();
    }








           $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
           $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


           if ($current_status_count=='0') {

               $obj4 = new CurrentStatus();

               $obj4->passport_id = $request->input('passport_id');
               $obj4->current_process_id = '5';
               $obj4->save();

           }
           else{
               $current_id=$current_status->id;
               DB::table('current_status')->where('id', $current_id)
                   ->update(['current_process_id' => '5']);
           }


            return response()->json([
                'code' => "100",
                'passport_no'=>$pass_no
            ]);



    }
    }
    public function labour_insurance_save(Request $request){

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        if($request->edit_status=='1'){

            $id=$request->request_id;
            if($request->hasfile('file_name'))
            {
                foreach($request->file('file_name') as $file2)
                {
                    $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                    // $file->move(public_path().'/assets/upload/LabourCardPrint/', $name);
                    $filePath2 = '/assets/upload/LabourInsurance/other_attachments/' . $name2;
                    Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                    $data2[] = $name2;
                }
            }

                $obj =  VisaProcessLabourInsurance::find($id);
                $obj->passport_id = $request->input('passport_id');
                $obj->date_entered = $request->input('date_entered');
                if($obj->replace_status=='1'){
                    $obj->replace_status = '2';
                }
                $obj->save();

                if($request->input('payment_checkbox')!=null){
                    $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','28')->first();


                        if(!isset($pay_option)){
                            $obj_pay = new VisaPaymentOptions();
                        }
                        else{
                            $pay_id=$pay_option->id;
                            $obj_pay =  VisaPaymentOptions::find($pay_id);
                        }

                $obj_pay->passport_id = $request->input('passport_id');
                $obj_pay->visa_process_step_id ='28';
                $obj_pay->payment_amount = $request->input('payment_amount');
                $obj_pay->payment_type = $request->input('payment_type');
                $obj_pay->transaction_no = $request->input('transaction_no');
                $obj_pay->transaction_date_time = $request->input('transaction_date_time');
                $obj_pay->vat = $request->input('vat');
                $obj_pay->fine_amount = $request->input('fine_amount');
                $obj_pay->service_charges = $request->input('service_charges');
                if(isset($data2)){
                    //other attachments
                    $obj_pay->other_attachment = json_encode($data2);
                }
                $obj_pay->save();
            }
            return response()->json([
                'code' => "104",
                'passport_no'=>$pass_no
            ]);

        }
        else{
        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                // $file->move(public_path().'/assets/upload/LabourCardPrint/', $name);
                $filePath2 = '/assets/upload/LabourInsurance/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                $data2[] = $name2;
            }

        }

            $obj = new VisaProcessLabourInsurance();
            $obj->passport_id = $request->input('passport_id');
            $obj->date_entered = $request->input('date_entered');

                $obj->save();
                if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='28';
            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction_date_time');
            $obj_pay->vat = $request->input('vat');
            $obj_pay->fine_amount = $request->input('fine_amount');
            $obj_pay->service_charges = $request->input('service_charges');
            if(isset($data2)){
                //other attachments
                $obj_pay->other_attachment = json_encode($data2);
            }
            $obj_pay->save();

        }





            $passport_id= $request->input('passport_id');
            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


            if ($current_status_count=='0') {

                $obj3 = new CurrentStatus();

                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '4';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '4']);
            }
            $attachment_id = DB::table('visa_attachments')->latest('id')->first();
            $attach_id=$attachment_id->id;





            return response()->json([
                'code' => "100",
                'passport_no'=>$pass_no
            ]);

}
    }
}
