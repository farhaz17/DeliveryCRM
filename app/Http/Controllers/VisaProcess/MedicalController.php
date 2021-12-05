<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\EntryPrintOutside;
use App\Model\VisaProcess\FitUnfit;
use App\Model\VisaProcess\Medical24;
use App\Model\VisaProcess\Medical48;
use App\Model\VisaProcess\MedicalNormal;
use App\Model\VisaProcess\MedicalVIP;
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

class MedicalController extends Controller
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

        if($request->edit_status1=='1'){

            $id=$request->request_id1;
            if(!isset($by_pass)){

                $validator = Validator::make($request->all(), [
                    'medical_tans_no' => 'unique:medical_normals,medical_tans_no,'.$id,

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
                        $data[] = $name;
                        $filePath = '/assets/upload/MedicalNormal/' . $name;
                        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    }
                }

                if($request->hasfile('file_name'))
                {
                    foreach($request->file('file_name') as $file2)
                    {
                        $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                        $data2[] = $name2;
                        $filePath2 = '/assets/upload/MedicalNormal/other_attachments/' . $name2;
                        $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                    }
                }


                    $obj =  MedicalNormal::find($id);

                    $obj->passport_id = $request->input('passport_id');
                    $obj->medical_type = $request->input('medical_type');
                    $obj->medical_tans_no = $request->input('medical_tans_no');
                    $obj->medical_date_time = $request->input('medical_date_time');
                    if(isset($data)){
                        $obj->visa_attachment = json_encode($data);
                    }
                    $obj->save();
                    if($request->input('payment_checkbox')!=null){

                    $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))
                    ->where('visa_process_step_id','11')->first();
                    if(isset($pay_option)){
                        $pay_id=$pay_option->id;
                        $obj_pay = VisaPaymentOptions::find($pay_id);

                        $obj_pay->passport_id = $request->input('passport_id');
                        $obj_pay->visa_process_step_id ='11';
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
                    else{
                        if($request->input('payment_checkbox')!=null){
                            $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','11')->first();


                            if(!isset($pay_option)){
                                $obj_pay = new VisaPaymentOptions();
                            }
                            else{
                                $pay_id=$pay_option->id;
                                $obj_pay =  VisaPaymentOptions::find($pay_id);
                            }
                            $obj_pay->passport_id = $request->input('passport_id');
                            $obj_pay->visa_process_step_id ='11';
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

                    }

                }
                return response()->json([
                    'code' => "104",
                    'passport_no'=>$pass_no
                ]);
        }
        else{




        if(!isset($by_pass)){

        $validator = Validator::make($request->all(), [
            'medical_tans_no' => 'unique:medical_normals,medical_tans_no',

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
                $data[] = $name;
                $filePath = '/assets/upload/MedicalNormal/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
            }
        }

        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $data2[] = $name2;
                $filePath2 = '/assets/upload/MedicalNormal/other_attachments/' . $name2;
                $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
            }
        }


            $obj = new MedicalNormal();

            $obj->passport_id = $request->input('passport_id');
            $obj->medical_type = $request->input('medical_type');
            $obj->medical_tans_no = $request->input('medical_tans_no');
            $obj->medical_date_time = $request->input('medical_date_time');
            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
            $obj->save();
            if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='11';
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
                $obj3->current_process_id = '14';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '14']);
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

    public function medical48(Request $request)
    {


        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();



        if($request->edit_status2=='1'){

            $id=$request->request_id2;

        if(!isset($by_pass)){
            $validator = Validator::make($request->all(), [
                'medical_tans_no' => 'unique:medical48s,medical_tans_no,'.$id,

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
                    $filePath = '/assets/upload/Medical48/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }

            if($request->hasfile('file_name'))
            {
                foreach($request->file('file_name') as $file2)
                {
                    $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                    $data2[] = $name2;
                    $filePath2 = '/assets/upload/Medical48/other_attachments/' . $name2;
                    $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                }
            }



                $obj = Medical48::find($id);

                $obj->passport_id = $request->input('passport_id');
                $obj->medical_tans_no = $request->input('medical_tans_no');
                $obj->medical_date_time = $request->input('medical_date_time');
                if(isset($data)){
                    $obj->visa_attachment = json_encode($data);
                }
                $obj->save();
                if($request->input('payment_checkbox')!=null){

                $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))
                ->where('visa_process_step_id','12')->first();
                $pay_id=$pay_option->id;
                $obj_pay = VisaPaymentOptions::find($pay_id);
                $obj_pay->passport_id = $request->input('passport_id');
                $obj_pay->visa_process_step_id ='12';
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



        }else{



        if(!isset($by_pass)){
        $validator = Validator::make($request->all(), [
            'medical_tans_no' => 'unique:medical48s,medical_tans_no',

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
                $filePath = '/assets/upload/Medical48/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }

        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $data2[] = $name2;
                $filePath2 = '/assets/upload/Medical48/other_attachments/' . $name2;
                $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
            }
        }



            $obj = new Medical48();

            $obj->passport_id = $request->input('passport_id');
            $obj->medical_tans_no = $request->input('medical_tans_no');
            $obj->medical_date_time = $request->input('medical_date_time');
            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
            $obj->save();
            if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='12';
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
                $obj3->current_process_id = '14';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '14']);
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


    //--------
    public function medical24(Request $request)
    {


        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();
        if(!isset($by_pass)){
        $validator = Validator::make($request->all(), [
            'medical_tans_no' => 'unique:medical24s,medical_tans_no',

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
                $filePath = '/assets/upload/Medical24/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;

            }
        }
        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $data2[] = $name2;
                $filePath2 = '/assets/upload/Medical24/other_attachments/' . $name2;
                $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
            }
        }


            $obj = new Medical24();

            $obj->passport_id = $request->input('passport_id');
            $obj->medical_tans_no = $request->input('medical_tans_no');
            $obj->medical_date_time = $request->input('medical_date_time');
            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
            $obj->save();
            if($request->input('payment_checkbox')!=null){
            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='13';
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



            $attachment_id = DB::table('visa_attachments')->latest('id')->first();
            $attach_id=$attachment_id->id;
            $passport_id= $request->input('passport_id');
            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


            if ($current_status_count=='0') {

                $obj3 = new CurrentStatus();

                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '14';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '14']);
            }


                $passport_id= $request->input('passport_id');
                $passport=Passport::where('id',$passport_id)->first();
                $pass_no=$passport->passport_no;
            return response()->json([
                'code' => "100",
                'passport_no'=>$pass_no
            ]);

        }



    //
    public function medicalvip(Request $request)
    {
        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();
        if(!isset($by_pass)){
        $validator = Validator::make($request->all(), [
            'medical_tans_no' => 'unique:medical_v_i_p_s,medical_tans_no',

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
                $filePath = '/assets/upload/MedicalVIP/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }

        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $data2[] = $name2;
                $filePath2 = '/assets/upload/MedicalVIP/other_attachments/' . $name2;
                $t = Storage::disk('s3')->put($filePath2, file_get_contents($file2));
            }
        }



        $obj = new MedicalVIP();
        $obj->passport_id = $request->input('passport_id');
        $obj->medical_tans_no = $request->input('medical_tans_no');
        $obj->medical_date_time = $request->input('medical_date_time');
        if(isset($data)){
            $obj->visa_attachment = json_encode($data);
        }
        $obj->save();
        if($request->input('payment_checkbox')!=null){
        $obj_pay = new VisaPaymentOptions();
        $obj_pay->passport_id = $request->input('passport_id');
        $obj_pay->visa_process_step_id ='14';
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
                $obj3->current_process_id = '14';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '14']);
            }
            $passport_id= $request->input('passport_id');
            $passport=Passport::where('id',$passport_id)->first();
            $pass_no=$passport->passport_no;
        return response()->json([
            'code' => "100",
            'passport_no'=>$pass_no
        ]);

        }




    public function fit_unfit(Request $request)
    {
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
                    $data2[] = $name2;
                    $filePath2 = '/assets/upload/fit_unfit/other_attachments/' . $name2;
                    Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                }
            }


                $obj =  FitUnfit::find($id);

                $obj->passport_id = $request->input('passport_id');
                $obj->status = $request->input('status');
                $obj->fit_unfit_date = $request->input('fit_unfit_date');

                $obj->is_complete = '1';

                if(isset($data2)){
                    $obj->other_attachment = json_encode($data2);
                        }
                $obj->save();
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
                $data2[] = $name2;
                $filePath2 = '/assets/upload/fit_unfit/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file2));
            }
        }


            $obj = new FitUnfit();
            $obj->passport_id = $request->input('passport_id');
            $obj->status = $request->input('status');
            $obj->fit_unfit_date = $request->input('fit_unfit_date');

            $obj->is_complete = '1';

            if(isset($data2)){
                $obj->other_attachment = json_encode($data2);
                    }
            $obj->save();




            $passport_id= $request->input('passport_id');
            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


            if ($current_status_count=='0') {

                $obj3 = new CurrentStatus();

                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '15';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '15']);
            }

        return response()->json([
            'code' => "100",
            'passport_no'=>$pass_no
        ]);


    }
}



}
