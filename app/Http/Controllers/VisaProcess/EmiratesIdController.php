<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\EmiratesIdApply;
use App\Model\VisaProcess\EmiratesIdFingerPrint;
use App\Model\VisaProcess\FitUnfit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Passport\Passport;
use DB;
use App\Quotation;
use App\Model\VisaProcess\VisaAttachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\VisaProcess\VisaPaymentOptions;


class EmiratesIdController extends Controller
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
        //
        if($request->edit_status=='1'){
            $id=$request->request_id;
            if($request->hasfile('visa_attachment'))
            {
                foreach($request->file('visa_attachment') as $file)
                {
                    $name =rand(100,100000).'.'.time().'.'.$file->extension();
                    $filePath = '/assets/upload/emirates_id_app/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }

                if($request->hasfile('file_name'))
                {
                    foreach($request->file('file_name') as $file2)
                    {
                        $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                        $filePath2 = '/assets/upload/emirates_id_app/other_attachments/' . $name2;
                        $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                        $data2[] = $name2;

                    }
                }

                $obj =  EmiratesIdApply::find($id);
                $obj->passport_id = $request->input('passport_id');
                $obj->e_id_app_expiry = $request->input('e_id_app_expiry');
                if(isset($data)){
                    $obj->visa_attachment = json_encode($data);
                }
                $obj->save();
                if($request->input('payment_checkbox')!=null){
                    $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','16')->first();


                        if(!isset($pay_option)){
                            $obj_pay = new VisaPaymentOptions();
                        }
                        else{
                            $pay_id=$pay_option->id;
                            $obj_pay =  VisaPaymentOptions::find($pay_id);
                        }

                $obj_pay->passport_id = $request->input('passport_id');
                $obj_pay->visa_process_step_id ='16';
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
                return response()->json([
                    'code' => "104",
                    'passport_no'=>$pass_no
                ]);
            }
        }
        else{



        if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath = '/assets/upload/emirates_id_app/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;

            }
        }

            if($request->hasfile('file_name'))
            {
                foreach($request->file('file_name') as $file2)
                {
                    $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                    $filePath2 = '/assets/upload/emirates_id_app/other_attachments/' . $name2;
                    $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                    $data2[] = $name2;

                }
            }

            $obj = new EmiratesIdApply();
            $obj->passport_id = $request->input('passport_id');
            // $obj->payment_amount = $request->input('payment_amount_main');
            $obj->e_id_app_expiry = $request->input('e_id_app_expiry');
            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
            $obj->save();
            if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='16';
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
                $obj3->current_process_id = '16';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '16']);
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
    public function finger_print(Request $request)
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
                    $filePath = '/assets/upload/finger_print/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }
                $obj =  EmiratesIdFingerPrint::find($id);
                $obj->passport_id = $request->input('passport_id');
                $obj->status = $request->input('status');
                $obj->finger_print_date = $request->input('finger_print_date');
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
                $filePath = '/assets/upload/finger_print/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }
            $obj = new EmiratesIdFingerPrint();
            $obj->passport_id = $request->input('passport_id');
            $obj->status = $request->input('status');
            $obj->finger_print_date = $request->input('finger_print_date');
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
            $obj3->current_process_id = '17';
            $obj3->save();
        }
        else{
            $current_id=$current_status->id;
            DB::table('current_status')->where('id', $current_id)
                ->update(['current_process_id' => '17']);
        }

    return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
    ]);
        }

}
}
