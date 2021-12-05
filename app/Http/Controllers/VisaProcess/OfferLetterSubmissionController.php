<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\Offer_letter\Offer_letter_submission;
use App\Model\VisaProcess\CurrentStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Passport\Passport;
use App\Model\VisaProcess\BypassVisa;
use App\Model\VisaProcess\VisaAttachment;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Storage;
use App\Model\VisaProcess\VisaPaymentOptions;

use Illuminate\Support\Facades\Validator;

class OfferLetterSubmissionController extends Controller
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

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();

        if($request->edit_status=='1'){
            $id=$request->request_id;

            if(!isset($by_pass)){


                $validator = Validator::make($request->all(), [
                    'mb_no' => 'unique:offer_letter_submission,mb_no,'.$id,

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
                        $name =rand(100,100000).'.'.time().'.'.$file->extension();
                        $filePath = '/assets/upload/OfferLetterSubmission/' . $name;
                        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                        $data[] = $name;
                    }
                }

                if($request->hasfile('file_name'))
                {
                    foreach($request->file('file_name') as $file2)
                    {
                        $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                        $filePath2 = '/assets/upload/OfferLetterSubmission/other_attachments/' . $name2;
                        $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                        $data2[] = $name2;
                    }
                }
                    $passport_id= $request->input('passport_id');

                    $obj = Offer_letter_submission::find($id);
                    $obj->passport_id = $request->input('passport_id');
                    $obj->mb_no = $request->input('mb_no');
                    $obj->date_and_time = $request->input('date_and_time');
                    if(isset($data)){
                        $obj->visa_attachment = json_encode($data);
                    }
                    if($obj->replace_status=='1'){
                        $obj->replace_status = '2';
                    }
                    $obj->save();
                    if($request->input('payment_checkbox')!=null){
                        $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','2')->first();


                            if(!isset($pay_option)){
                                $obj_pay = new VisaPaymentOptions();
                            }
                            else{
                                $pay_id=$pay_option->id;
                                $obj_pay =  VisaPaymentOptions::find($pay_id);
                            }
                    $obj_pay->passport_id = $request->input('passport_id');
                    $obj_pay->visa_process_step_id ='3';
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
            'mb_no' => 'unique:offer_letter_submission,mb_no',

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
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath = '/assets/upload/OfferLetterSubmission/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }

        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $filePath2 = '/assets/upload/OfferLetterSubmission/other_attachments/' . $name2;
                $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                $data2[] = $name2;
            }
        }
            $passport_id= $request->input('passport_id');
            $obj = new Offer_letter_submission();
            $obj->passport_id = $request->input('passport_id');
            $obj->mb_no = $request->input('mb_no');
            $obj->date_and_time = $request->input('date_and_time');
            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
            $obj->save();
            if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='3';
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

            $table_id = DB::table('offer_letter_submission')->latest('id')->first();
            $id=$table_id->id;

            $obj2 = new VisaAttachment();

            $obj2->attachment_name = isset($fileName)?$fileName:'';
            $obj2->table_id = $id;
            $obj2->save();
            $attachment_id = DB::table('visa_attachments')->latest('id')->first();
            $attach_id=$attachment_id->id;




            DB::table('offer_letter_submission')->where('id', $id)
                ->update(['attachment_id' =>$attach_id]);

            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


            if ($current_status_count=='0') {

                $obj3 = new CurrentStatus();

                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '3';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '3']);
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
}
