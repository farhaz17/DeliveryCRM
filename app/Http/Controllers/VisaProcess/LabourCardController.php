<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\LabourCard;
use App\Model\VisaProcess\NewContractSubmission;
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

class LabourCardController extends Controller
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

        if($request->edit_status=='1'){


            $id=$request->request_id;

            if($request->hasfile('visa_attachment'))
            {

                foreach($request->file('visa_attachment') as $file)
                {
                    $name =rand(100,100000).'.'.time().'.'.$file->extension();
                    // $file->move(public_path().'/assets/upload/LabourCardPrint/', $name);
                    $filePath = '/assets/upload/LabourCardPrint/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }


            if($request->hasfile('file_name'))
            {
                foreach($request->file('file_name') as $file2)
                {
                    $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                    // $file->move(public_path().'/assets/upload/LabourCardPrint/', $name);
                    $filePath2 = '/assets/upload/LabourCardPrint/other_attachments/' . $name2;
                    Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                    $data2[] = $name2;
                }

            }

                $obj = LabourCard::find($id);
                $obj->passport_id = $request->input('passport_id');
                $obj->labour_card_expiry_date = $request->input('labour_card_expiry_date');
                $obj->person_code = $request->input('person_code');
                $obj->labour_card_no = $request->input('labour_card_no');
                $obj->issue_date = $request->input('issue_date');



                if(isset($data)){
                    $obj->visa_attachment = json_encode($data);
                         }
                    $obj->save();


                    if($request->input('payment_checkbox')!=null){
                        $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','21')->first();


                        if(!isset($pay_option)){
                            $obj_pay = new VisaPaymentOptions();
                        }
                        else{
                            $pay_id=$pay_option->id;
                            $obj_pay =  VisaPaymentOptions::find($pay_id);
                        }
                $obj_pay->passport_id = $request->input('passport_id');
                $obj_pay->visa_process_step_id ='21';
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
        else
        {


        if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                // $file->move(public_path().'/assets/upload/LabourCardPrint/', $name);
                $filePath = '/assets/upload/LabourCardPrint/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }


        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                // $file->move(public_path().'/assets/upload/LabourCardPrint/', $name);
                $filePath2 = '/assets/upload/LabourCardPrint/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                $data2[] = $name2;
            }

        }

            $obj = new LabourCard();
            $obj->passport_id = $request->input('passport_id');
            $obj->labour_card_expiry_date = $request->input('labour_card_expiry_date');
            $obj->person_code = $request->input('person_code');
            $obj->labour_card_no = $request->input('labour_card_no');
            $obj->issue_date = $request->input('issue_date');



            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
                     }
                $obj->save();
                if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='21';
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
                $obj3->current_process_id = '21';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '21']);
            }
            $attachment_id = DB::table('visa_attachments')->latest('id')->first();
            $attach_id=$attachment_id->id;




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
}
