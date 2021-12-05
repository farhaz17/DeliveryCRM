<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\Offer_letter\Offer_letter;
use App\Model\Passport\PassportAdditional;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\EntryPrintInside;
use App\Model\VisaProcess\EntryPrintOutside;
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

class EntryPrintVisaController extends Controller
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
    public function create(Request $request)
    {

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;

        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();


        if($request->edit_status=='1'){

            $id=$request->request_id;
            if(!isset($by_pass)){


                $validator = Validator::make($request->all(), [
                    'visa_number' => 'unique:entry_print_inside_outside,visa_number,'.$id,

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

               $validator2 = Validator::make($request->all(), [
                'uid_no' => 'unique:entry_print_inside_outside,uid_no,'.$id,

           ]);
           if ($validator2->fails()) {
               $validate2 = $validator2->errors();
               $message_error = "";

               foreach ($validate2->all() as $error){
                   $message_error .= $error;
               }

               $validate2 = $validator2->errors();
               return response()->json([
                'code' => "104",
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
                        $filePath = '/assets/upload/EntryPrintOutSide/' . $name;
                        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    }
                }




                if($request->hasfile('file_name'))
                {
                    foreach($request->file('file_name') as $file2)
                    {
                        $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                        $data2[] = $name2;
                        $filePath2 = '/assets/upload/EntryPrintOutSide/other_attachments/' . $name2;
                        Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                    }
                }




                    $passport_id= $request->input('passport_id');
                    $obj = EntryPrintOutside::find($id);

                    $obj->passport_id = $request->input('passport_id');
                    $obj->visa_number = $request->input('visa_number');
                    $obj->type = $request->input('type');
                    $obj->uid_no = $request->input('uid_no');
                    $obj->visa_issue_date = $request->input('visa_issue_date');
                    $obj->visa_expiry_date = $request->input('visa_expiry_date');
                    $obj->is_complete = '1';
                    if(isset($data)){
                        $obj->visa_attachment = json_encode($data);
                    }
                        $obj->save();
                        if($request->input('payment_checkbox')!=null){
                            $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))->where('visa_process_step_id','7')->first();


                                if(!isset($pay_option)){
                                    $obj_pay = new VisaPaymentOptions();
                                }
                                else{
                                    $pay_id=$pay_option->id;
                                    $obj_pay =  VisaPaymentOptions::find($pay_id);
                                }



                        $obj_pay->passport_id = $request->input('passport_id');
                        $obj_pay->visa_process_step_id ='7';
                        $obj_pay->payment_amount = $request->input('payment_amount');
                        $obj_pay->payment_type = $request->input('payment_type');
                        $obj_pay->transaction_no = $request->input('transaction_no');
                        $obj_pay->transaction_date_time = $request->input('transaction_date_time');
                        $obj_pay->fine_amount = $request->input('fine_amount');
                            $obj_pay->vat = $request->input('vat');
                            $obj_pay->service_charges = $request->input('service_charges');
                            if(isset($data2)){
                                //other attachment
                                $obj_pay->other_attachment = json_encode($data2);
                            }
                       $obj_pay->save();

        }
          return response()->json([
                        'code' => "105",
                        'passport_no'=>$pass_no
                    ]);
    }
        else{


        if(!isset($by_pass)){


        $validator = Validator::make($request->all(), [
            'visa_number' => 'unique:entry_print_inside_outside,visa_number',

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



       $validator2 = Validator::make($request->all(), [
        'uid_no' => 'unique:entry_print_inside_outside,uid_no',

   ]);
   if ($validator2->fails()) {
       $validate2 = $validator2->errors();
       $message_error = "";

       foreach ($validate2->all() as $error){
           $message_error .= $error;
       }

       $validate2 = $validator2->errors();
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
                $filePath = '/assets/upload/EntryPrintOutSide/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
            }
        }




        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $data2[] = $name2;
                $filePath2 = '/assets/upload/EntryPrintOutSide/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file2));
            }
        }




            $passport_id= $request->input('passport_id');
            $obj = new EntryPrintOutside();

            $obj->passport_id = $request->input('passport_id');
            $obj->visa_number = $request->input('visa_number');
            $obj->type = $request->input('type');
            $obj->uid_no = $request->input('uid_no');
            $obj->visa_issue_date = $request->input('visa_issue_date');
            $obj->visa_expiry_date = $request->input('visa_expiry_date');
            $obj->is_complete = '1';
            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
                $obj->save();
                if($request->input('payment_checkbox')!=null){
                $obj_pay = new VisaPaymentOptions();
                $obj_pay->passport_id = $request->input('passport_id');
                $obj_pay->visa_process_step_id ='7';
                $obj_pay->payment_amount = $request->input('payment_amount');
                $obj_pay->payment_type = $request->input('payment_type');
                $obj_pay->transaction_no = $request->input('transaction_no');
                $obj_pay->transaction_date_time = $request->input('transaction_date_time');
                $obj_pay->fine_amount = $request->input('fine_amount');
                    $obj_pay->vat = $request->input('vat');
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
                $obj3 = new CurrentStatus();
                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '7';
                $obj3->save();
            }
            $passport_id= $request->input('passport_id');
            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();
            if ($current_status_count=='0') {
                $obj3 = new CurrentStatus();

                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '7';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '7']);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        if (!empty($_FILES['file_name']['name'])) {

            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;
            $filePath = '/assets/upload/EntryPrintInside/' . $file_name;
            $t = Storage::disk('s3')->put($filePath, file_get_contents($_FILES['file_name']['name']));
            $obj = new EntryPrintInside();

            $obj->passport_id = $request->input('passport_id');
            $obj->visa_number = $request->input('visa_number');
            $obj->uid_no = $request->input('uid_no');
            $obj->visa_issue_date = $request->input('visa_issue_date');
            $obj->visa_expiry_date = $request->input('visa_expiry_date');

            if($request->input('payment_checkbox')!=null){


            $obj_pay = new VisaPaymentOptions();
            $obj_pay->passport_id = $request->input('passport_id');
            $obj_pay->visa_process_step_id ='6';
            $obj_pay->payment_amount = $request->input('payment_amount');
            $obj_pay->payment_type = $request->input('payment_type');
            $obj_pay->transaction_no = $request->input('transaction_no');
            $obj_pay->transaction_date_time = $request->input('transaction_date_time');
            $obj_pay->fine_amount = $request->input('fine_amount');
            $obj_pay->service_charges = $request->input('service_charges');
                $obj_pay->vat = $request->input('vat');
                if(isset($data2)){
                    //other attachment
                    $obj->other_attachment = json_encode($data2);
                }
           $obj_pay->save();
            }


            $table_id = DB::table('entry_print_insides')->latest('id')->first();
            $id=$table_id->id;

            $obj2 = new VisaAttachment();

            $obj2->attachment_name = $file_name;
            $obj2->table_id = $id;
            $obj2->save();

            $attachment_id = DB::table('visa_attachments')->latest('id')->first();
            $attach_id=$attachment_id->id;

            DB::table('entry_print_insides')->where('id', $id)
                ->update(['attachment_id' =>$attach_id]);

            $passport_id= $request->input('passport_id');
            $passport=Passport::where('id',$passport_id)->first();
            $pass_no=$passport->passport_no;
        return response()->json([
            'code' => "100",
            'passport_no'=>$pass_no
        ]);

        // }
    }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {



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
