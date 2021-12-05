<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\LabourCardTypeAssign;
use App\Model\Offer_letter\Offer_letter_submission;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\FitUnfit;
use App\Model\VisaProcess\NewContractAppTyping;
use App\Model\VisaProcess\NewContractSubmission;
use App\Model\VisaProcess\TawjeehClass;
use App\Model\VisaProcess\VisaAttachment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Passport\Passport;
use App\Model\VisaProcess\BypassVisa;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\VisaProcess\VisaPaymentOptions;

class NewContractAppTypingController extends Controller
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
            if(!isset($by_pass)){
                $validator = Validator::make($request->all(), [

                    'transaction_date_time' => 'nullable|date:new_contract_app_typings,transaction_date_time,'.$id,

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
                if($request->hasfile('visa_attachment'))
                {
                    foreach($request->file('visa_attachment') as $file)
                    {
                        $name =rand(100,100000).'.'.time().'.'.$file->extension();
                        $filePath = '/assets/upload/NewContractAppTyping/' . $name;
                        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                        $data[] = $name;

                    }
                }


                if($request->hasfile('file_name'))
                {
                    foreach($request->file('file_name') as $file2)
                    {
                        $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                        $filePath2 = '/assets/upload/NewContractAppTyping/other_attachments/' . $name2;
                        $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                        $data2[] = $name2;
                    }
                }
                        $obj =  NewContractAppTyping::find($id);
                        $obj->passport_id = $request->input('passport_id');
                        $obj->payment_amount = $request->input('payment_amount');
                        $obj->new_contract_date = $request->input('new_contract_date');
                        $obj->status = $request->input('status');
                        $obj->mb_no = $request->input('mb_no');

                        if(isset($data)){
                            $obj->visa_attachment = json_encode($data);
                        }
                        $obj->save();

                        if($request->input('payment_checkbox')!=null){
                            $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','18')->first();


                            if(!isset($pay_option)){
                                $obj_pay = new VisaPaymentOptions();
                            }
                            else{
                                $pay_id=$pay_option->id;
                                $obj_pay =  VisaPaymentOptions::find($pay_id);
                            }
                    $obj_pay->passport_id = $request->input('passport_id');
                    $obj_pay->visa_process_step_id ='18';
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



        if(!isset($by_pass)){

        $validator = Validator::make($request->all(), [

            'transaction_date_time' => 'nullable|date:new_contract_app_typings,transaction_date_time',

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
        if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath = '/assets/upload/NewContractAppTyping/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                $data[] = $name;

            }
        }


        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $filePath2 = '/assets/upload/NewContractAppTyping/other_attachments/' . $name2;
                $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                $data2[] = $name2;
            }
        }
                $obj = new NewContractAppTyping();
                $obj->passport_id = $request->input('passport_id');
                $obj->payment_amount = $request->input('payment_amount');
                $obj->new_contract_date = $request->input('new_contract_date');
                $obj->status = $request->input('status');
                $obj->mb_no = $request->input('mb_no');

                if(isset($data)){
                    $obj->visa_attachment = json_encode($data);
                }
                $obj->save();
                if($request->input('payment_checkbox')!=null){
                $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='18';
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
                    $obj3->current_process_id = '18';
                    $obj3->save();
                }
                else{
                    $current_id=$current_status->id;
                    DB::table('current_status')->where('id', $current_id)
                        ->update(['current_process_id' => '18']);
                }

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

    public function tawjeeh_class(Request $request)
    {
        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;

        if($request->edit_status=='1'){
            $id=$request->request_id;
            if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath = '/assets/upload/TawjeehClass/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                $data[] = $name;
            }
        }

        $obj = TawjeehClass::find($id);
        $obj->passport_id = $request->input('passport_id');
        $obj->status = $request->input('status');
        $obj->tawjeeh_date = $request->input('tawjeeh_date');

        $obj->is_complete = '1';
        if(isset($data)){
            $obj->visa_attachment = json_encode($data);
        }
        $obj->save();
        return response()->json([
            'code' => "104",
            'passport_no'=>$pass_no
        ]);
        }
        else{



        if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath = '/assets/upload/TawjeehClass/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                $data[] = $name;

            }
        }


        $obj = new TawjeehClass();
        $obj->passport_id = $request->input('passport_id');
        $obj->status = $request->input('status');
        $obj->tawjeeh_date = $request->input('tawjeeh_date');

        $obj->is_complete = '1';
        if(isset($data)){
            $obj->visa_attachment = json_encode($data);
        }
        $obj->save();
        $passport_id= $request->input('passport_id');
        $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
        $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


        if ($current_status_count=='0') {

            $obj3 = new CurrentStatus();
            $obj3->passport_id = $request->input('passport_id');
            $obj3->current_process_id = '19';
            $obj3->save();

        }
        else{
            $current_id=$current_status->id;
            DB::table('current_status')->where('id', $current_id)
                ->update(['current_process_id' => '19']);
        }

    return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
    ]);
    }
}
    public function new_contract_sub(Request $request)
    {


                $passport_id= $request->input('passport_id');
                $passport=Passport::where('id',$passport_id)->first();
                $pass_no=$passport->passport_no;
                $by_pass=BypassVisa::where('passport_id',$passport_id)->first();


        if($request->edit_status=='1'){
            $id=$request->request_id;
            if(!isset($by_pass)){
                $validator = Validator::make($request->all(), [
                    'transaction_no' => 'unique:new_contract_submissions,transaction_no,'.$id,

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



           if($request->hasfile('file_name'))
           {
               foreach($request->file('file_name') as $file)
               {
                   $name =rand(100,100000).'.'.time().'.'.$file->extension();
                   $filePath = '/assets/upload/NewContractSubmission/' . $name;
                   $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                   $data[] = $name;

               }
           }



            $obj = NewContractSubmission::find($id);
            $obj->passport_id = $request->input('passport_id');
            $obj->save();


                $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','20')->first();
                if(!isset($pay_option)){
                $obj_pay = new VisaPaymentOptions();
                }
                else{
                $pay_id=$pay_option->id;
                $obj_pay =  VisaPaymentOptions::find($pay_id);
                                }
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='20';
            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction');
            $obj_pay->vat = $request->input('vat');
            $obj_pay->fine_amount = $request->input('fine_amount');
            $obj_pay->service_charges = $request->input('service_charges');
            if(isset($data)){
                //other attachments
                $obj_pay->other_attachment = json_encode($data);
            }
            $obj_pay->save();

            return response()->json([
                'code' => "104",
                'passport_no'=>$pass_no
            ]);
        
        }
        else{


                if(!isset($by_pass)){
                $validator = Validator::make($request->all(), [
                    'transaction_no' => 'unique:new_contract_submissions,transaction_no',

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



           if($request->hasfile('file_name'))
           {
               foreach($request->file('file_name') as $file)
               {
                   $name =rand(100,100000).'.'.time().'.'.$file->extension();
                   $filePath = '/assets/upload/NewContractSubmission/' . $name;
                   $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                   $data[] = $name;

               }
           }



            $obj = new NewContractSubmission();
            $obj->passport_id = $request->input('passport_id');
            $obj->save();


            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='20';
            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction');
            $obj_pay->vat = $request->input('vat');
            $obj_pay->fine_amount = $request->input('fine_amount');
            $obj_pay->service_charges = $request->input('service_charges');
            if(isset($data)){
                //other attachments
                $obj_pay->other_attachment = json_encode($data);
            }
            $obj_pay->save();


            $passport_id= $request->input('passport_id');
            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


            if ($current_status_count=='0') {

                $obj3 = new CurrentStatus();

                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '20';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '20']);
            }


            //Assign Labour card "New Labour card" after Contract Submission.
            //if nationality emirati add "National And GCC Labour Card"
            // if nationality emirati and part time "Labour Card For Part Time"
            $nationality = DB::table('passports')->where('id',$passport_id)->first();
            $nation=$nationality->nation_id;
            $current_labour = DB::table('labour_card_type_assigns')->where('passport_id',$passport_id)->first();
            if(isset($current_labour)){
                $current_labour_id=$current_labour->id;
                if ($nation=='9'){
                    DB::table('labour_card_type_assigns')->where('id', $current_labour_id)
                        ->update(['labour_card_type_id' => '2']);
                }
                else{
                    DB::table('labour_card_type_assigns')->where('id', $current_labour_id)
                        ->update(['labour_card_type_id' => '3']);
                }
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
    }


