<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\NewContractAppTyping;
use App\Model\VisaProcess\TawjeehClass;
use App\Model\VisaProcess\UniqueEmailId;
use App\Model\VisaProcess\UniqueEmailIdHandover;
use App\Model\VisaProcess\VisaAttachment;
use App\Model\VisaProcess\VisaPasted;
use App\Model\VisaProcess\VisaStamping;
use App\Model\VisaProcess\WaitingForApproval;
use App\Model\VisaProcess\WaitingForZajeel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Emirates_id_cards;
use App\Model\Passport\Passport;
use App\Model\VisaApplication;
use App\Model\VisaProcess\BypassVisa;
use DB;
use App\Quotation;
use Illuminate\Support\Facades\Validator;
use App\Model\VisaProcess\VisaPaymentOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use Laravel\Passport\Passport as PassportPassport;

class VisaStampingController extends Controller
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

        $passport_id= $request->input('passport_id');
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();

        if($request->edit_status=='1'){
            $id=$request->request_id;
            if(!isset($by_pass)){
                $validator = Validator::make($request->all(), [
                    'transaction_date_time' => 'nullable|date:visa_stampings,transaction_date_time,'.$id,
                ]);
                if ($validator->fails()) {
        //                $validate->first()
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
                        $filePath = '/assets/upload/VisaStamping/' . $name;
                        $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                        $data[] = $name;

                    }
                }
                if($request->hasfile('file_name'))
                {
                    foreach($request->file('file_name') as $file2)
                    {
                        $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                        $filePath2 = '/assets/upload/VisaStamping/other_attachments/' . $name2;
                        Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                        $data2[] = $name2;
                    }
                }
                        $obj =  VisaStamping::find($id);

                        $obj->passport_id = $request->input('passport_id');
                        $obj->payment_amount = $request->input('payment_amount');
                        $obj->types = $request->input('type');
                        if(isset($data)){
                            $obj->visa_attachment = json_encode($data);
                        }
                        $obj->save();
                        if($request->input('payment_checkbox')!=null){
                            $pay_option=VisaPaymentOptions::where('passport_id',$request->input('passport_id'))
                            ->where('visa_process_step_id','22')->first();
                            if(isset($pay_option)){
                        $pay_id=$pay_option->id;
                        $obj_pay = VisaPaymentOptions::find($pay_id);

                        $obj_pay->passport_id = $request->input('passport_id');
                        $obj_pay->visa_process_step_id ='22';
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
                    return response()->json([
                        'code' => "104",
                        'passport_no'=>$pass_no
                    ]);
        }
        else{
        if(!isset($by_pass)){
            $validator = Validator::make($request->all(), [
            'transaction_date_time' => 'nullable|date:visa_stampings,transaction_date_time',
        ]);
        if ($validator->fails()) {
//                $validate->first()
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
                $filePath = '/assets/upload/VisaStamping/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;

            }
        }
        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file2)
            {
                $name2 =rand(100,100000).'.'.time().'.'.$file2->extension();
                $filePath2 = '/assets/upload/VisaStamping/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file2));
                $data2[] = $name2;
            }
        }
                $obj = new VisaStamping();

                $obj->passport_id = $request->input('passport_id');
                $obj->payment_amount = $request->input('payment_amount');
                $obj->types = $request->input('type');
                if(isset($data)){
                    $obj->visa_attachment = json_encode($data);
                }
                $obj->save();
                if($request->input('payment_checkbox')!=null){
                $obj_pay = new VisaPaymentOptions();
                $obj_pay->passport_id = $request->input('passport_id');
                $obj_pay->visa_process_step_id ='22';
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
                    $obj3->current_process_id = '22';
                    $obj3->save();

                }
                else{
                    $current_id=$current_status->id;
                    DB::table('current_status')->where('id', $current_id)
                        ->update(['current_process_id' => '22']);
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
    public function approval(Request $request)
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
                   $filePath = '/assets/upload/approval/' . $name;
                   $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                   $data[] = $name;
               }
           }

           $obj =  WaitingForApproval::find($id);
           $obj->passport_id = $request->input('passport_id');
           $obj->status = $request->input('status');
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


         $visa_stamp= VisaStamping::where('passport_id', $request->input('passport_id'))->first();
         $visa_stamp_type=$visa_stamp->types;

        if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();

                // $file->move(public_path().'/assets/upload/approval/', $name);
                $filePath = '/assets/upload/approval/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                $data[] = $name;

            }
        }

        $obj = new WaitingForApproval();
        $obj->passport_id = $request->input('passport_id');
        $obj->status = $request->input('status');
        $obj->is_complete = '1';
        if(isset($data)){
            $obj->visa_attachment = json_encode($data);
        }
        $obj->save();
        $passport_id= $request->input('passport_id');



        $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();
            if($visa_stamp_type=='0' || $visa_stamp_type==null){
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '23']);
            }
            else{
                $current_id=$current_status->id;
            DB::table('current_status')->where('id', $current_id)
                ->update(['current_process_id' => '24']);
            }



    return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
    ]);


    }
}

    public function zajeel(Request $request)
    {
        if($request->edit_status=='1'){
            $id=$request->request_id;
            $passport_id= $request->input('passport_id');
            $passport=Passport::where('id',$passport_id)->first();
            $pass_no=$passport->passport_no;


            $zajeel=WaitingForZajeel::where('passport_id',$passport_id)->first();
            if($request->edit_receive==null ){
            if($request->hasfile('visa_attachment'))
            {
                foreach($request->file('visa_attachment') as $file)
                {
                    $name =rand(100,100000).'.'.time().'.'.$file->extension();
                    $filePath = '/assets/upload/zajeel/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }
            $obj =  WaitingForZajeel::find($id);
            $obj->passport_id = $request->input('passport_id');
            $obj->send = $request->input('send');
            $obj->handover_date = $request->input('handover_date');
            $obj->status = '1';
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
        DB::table('waiting_for_zajeels')->where('id', $zajeel->id)
        ->update(['receive_date' => $request->receive_date,'status'=>'2','receive' => $request->receive]);
        return response()->json([
            'code' => "104",
            'passport_no'=>$pass_no
        ]);
    }
}
        else{

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;

        $zajeel_count=WaitingForZajeel::where('passport_id',$passport_id)->count();
        $zajeel=WaitingForZajeel::where('passport_id',$passport_id)->first();

        if($request->receive==null  && $zajeel_count=='0'){
            if($request->hasfile('visa_attachment'))
            {
                foreach($request->file('visa_attachment') as $file)
                {
                    $name =rand(100,100000).'.'.time().'.'.$file->extension();
                    $filePath = '/assets/upload/zajeel/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }
            $obj = new WaitingForZajeel();
            $obj->passport_id = $request->input('passport_id');
            $obj->send = $request->input('send');
            $obj->handover_date = $request->input('handover_date');
            $obj->status = '1';
            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }

            $obj->save();
            return response()->json([
                'code' => "100",
                'passport_no'=>$pass_no
            ]);
        }
        else{
            DB::table('waiting_for_zajeels')->where('id', $zajeel->id)
                ->update(['receive_date' => $request->receive_date,'status'=>'2','receive' => $request->receive]);

                $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();

                DB::table('current_status')->where('id', $current_status->id)
                ->update(['current_process_id' => '24']);

                return response()->json([
                    'code' => "100",
                    'passport_no'=>$pass_no
                ]);
        }
    }


}


    public function visa_pasted(Request $request)
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
                $filePath = '/assets/upload/VisaPasted/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }

        $obj = new VisaPasted();
        $obj->passport_id = $request->input('passport_id');
        $obj->status = $request->input('status');
        $obj->issue_date = $request->input('date_issue');
        $obj->expiry_date = $request->input('date_expiry');
        $obj->is_complete = '1';

        if(isset($data)){
            $obj->visa_attachment = json_encode($data);
        }
        $obj->save();

        //if data exist in visa application then update
        //else add new data
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();
        $visa_app=VisaApplication::where('passport_id',$passport_id)->count();
        $visa_app2=VisaApplication::where('passport_id',$passport_id)->first();

        // if(!isset($by_pass)){
        if($visa_app=='0'){
            $obj2=new VisaApplication();
            $obj2->uid_number = $request->input('uid_num');
            $obj2->file_number = $request->input('file_number');
            $obj2->eid_number=$request->input('eid_num');
            $obj2->issue_date = $request->input('date_issue');
            $obj2->expiry_date = $request->input('date_expiry');
            $obj2->state_id = $request->input('state_id');
            $obj2->passport_id = $request->input('passport_id');
            $obj2->visa_profession_id = $request->input('visa_profession_id');
            $obj2->visa_company_id = $request->input('visa_company');
            $obj2->data_status = '1';

            $obj2->user_id = Auth::user()->id;
            if(isset($data)){
                $obj2->attachment = json_encode($data);
            }

            $obj2->save();
        }
        else{
            $obj3=VisaApplication::find($visa_app2->id);
            $obj3->uid_number=$request->input('uid_num');
            $obj3->eid_number=$request->input('eid_num');
            $obj3->file_number = $request->input('file_number');
            $obj3->issue_date = $request->input('date_issue');
            $obj3->expiry_date = $request->input('date_expiry');
            $obj3->state_id = $request->input('state_id');
            $obj3->passport_id = $request->input('passport_id');
            $obj3->visa_profession_id = $request->input('visa_profession_id');
            $obj3->visa_company_id = $request->input('visa_company');
            $obj3->data_status = '1';
            if(isset($data)){
                $obj3->attachment = json_encode($data);
            }
            $obj3->user_id = Auth::user()->id;
            $obj3->save();
        }

            //if data exist in visa application then update
            //else add new data

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
                $filePath = '/assets/upload/VisaPasted/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }

            $obj = new VisaPasted();
            $obj->passport_id = $request->input('passport_id');
            $obj->status = $request->input('status');
            $obj->issue_date = $request->input('date_issue');
            $obj->expiry_date = $request->input('date_expiry');
            $obj->is_complete = '1';

            if(isset($data)){
                $obj->visa_attachment = json_encode($data);
            }
            $obj->save();

            //if data exist in visa application then update
            //else add new data
            $by_pass=BypassVisa::where('passport_id',$passport_id)->first();
            $visa_app=VisaApplication::where('passport_id',$passport_id)->count();
            $visa_app2=VisaApplication::where('passport_id',$passport_id)->first();

            // if(!isset($by_pass)){
            if($visa_app=='0'){
                $obj2= new VisaApplication();
                $obj2->uid_number = $request->input('uid_num');
                $obj2->file_number = $request->input('file_number');
                $obj2->eid_number=$request->input('eid_num');
                $obj2->issue_date = $request->input('date_issue');
                $obj2->expiry_date = $request->input('date_expiry');
                $obj2->state_id = $request->input('state_id');
                $obj2->passport_id = $request->input('passport_id');
                $obj2->visa_profession_id = $request->input('visa_profession_id');
                $obj2->visa_company_id = $request->input('visa_company');
                $obj2->data_status = '1';
                $obj2->user_id = Auth::user()->id;
                if(isset($data)){
                    $obj2->attachment = json_encode($data);
                }
                $obj2->save();
            }
            else{
                $obj3=VisaApplication::find($visa_app2->id);
                $obj3->uid_number=$request->input('uid_num');
                $obj3->eid_number=$request->input('eid_num');
                $obj3->file_number = $request->input('file_number');
                $obj3->issue_date = $request->input('date_issue');
                $obj3->expiry_date = $request->input('date_expiry');
                $obj3->state_id = $request->input('state_id');
                $obj3->passport_id = $request->input('passport_id');
                $obj3->visa_profession_id = $request->input('visa_profession_id');
                $obj3->visa_company_id = $request->input('visa_company');
                $obj3->data_status = '1';
                if(isset($data)){
                    $obj3->attachment = json_encode($data);
                }
                $obj3->user_id = Auth::user()->id;
                $obj3->save();
            }

            $passport_id= $request->input('passport_id');
            $current_status_count = DB::table('current_status')->where('passport_id',$passport_id)->count();
            $current_status = DB::table('current_status')->where('passport_id',$passport_id)->first();


            if ($current_status_count=='0') {

                $obj3 = new CurrentStatus();

                $obj3->passport_id = $request->input('passport_id');
                $obj3->current_process_id = '25';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '25']);
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




    public function unique(Request $request)
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
                    $filePath = '/assets/upload/UniqueEmailId/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }
            $obj = UniqueEmailId::find($id);
            $obj->passport_id = $request->input('passport_id');
            $obj->status = $request->input('status');
            $obj->issue_date = $request->input('issue_date');
            $obj->expiry_date = $request->input('expiry_date');
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
                    $filePath = '/assets/upload/UniqueEmailId/' . $name;
                    $t = Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }
            $obj = new UniqueEmailId();
            $obj->passport_id = $request->input('passport_id');
            $obj->status = $request->input('status');
            $obj->issue_date = $request->input('issue_date');
            $obj->expiry_date = $request->input('expiry_date');
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
                $obj3->current_process_id = '26';
                $obj3->save();

            }
            else{
                $current_id=$current_status->id;
                DB::table('current_status')->where('id', $current_id)
                    ->update(['current_process_id' => '26']);
            }



// --------------------------------------------------------------
// edit_id_number" => "XXX-XXXX-XXXXXXX-X"
if(isset($request->card_no) || $request->eid_already=='2'){

    if(isset($request->edit_id_number) && $request->edit_id_number!='XXX-XXXX-XXXXXXX-X'){

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
        if(!empty($file_path_front)){
            $card->card_front_pic = $file_path_front;
        }
        if(!empty($file_path_back)){
            $card->card_back_pic = $file_path_back;
        }
        $card->enter_by = Auth::user()->id;
        $card->save();
//-----------------------------------------------------------------
            return response()->json([
                'code' => "100",
                'passport_no'=>$pass_no
            ]);

            }
            elseif($request->eid_already=='1'){
                return response()->json([
                    'code' => "100",
                    'passport_no'=>$pass_no
                ]);
            }
            else{
                return response()->json([
                    'code' => "100",
                    'passport_no'=>$pass_no
                ]);

                }
            }
        }
    }



    public function handover(Request $request)
    {
        //

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        $passport_id= $request->input('passport_id');
        $by_pass=BypassVisa::where('passport_id',$passport_id)->first();

        if($request->edit_status=='1'){
            $id=$request->request_id;
            if($request->hasfile('visa_attachment'))
        {
            foreach($request->file('visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();

                // $file->move(public_path().'/assets/upload/handover/', $name);



                $filePath = '/assets/upload/handover/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                $data[] = $name;

            }
        }

        $passport= Passport::where('passport_no',$request->input('passport_number'))->first();
        $passport_id=$passport->id;


        $obj =  UniqueEmailIdHandover::find($id);
        $obj->passport_id = $request->input('passport_id');
        $obj->status = $request->input('status');
        $obj->handover_person_name =$passport_id;
        $obj->handover_date = $request->input('handover_date');

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

                // $file->move(public_path().'/assets/upload/handover/', $name);



                $filePath = '/assets/upload/handover/' . $name;
                $t = Storage::disk('s3')->put($filePath, file_get_contents($file));

                $data[] = $name;

            }
        }
        if(!isset($by_pass)){
        $passport= Passport::where('passport_no',$request->input('passport_number'))->first();
        $passport_id=$passport->id;
        }
        else{
            $passport_id=null;
        }


        $obj = new UniqueEmailIdHandover();
        $obj->passport_id = $request->input('passport_id');
        $obj->status = $request->input('status');
        $obj->handover_person_name =$passport_id;
        $obj->handover_date = $request->input('handover_date');

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
            $obj3->current_process_id = '27';
            $obj3->save();

        }
        else{
            $current_id=$current_status->id;
            DB::table('current_status')->where('id', $current_id)
                ->update(['current_process_id' => '27']);
        }

    return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
    ]);

        }
    }


}
