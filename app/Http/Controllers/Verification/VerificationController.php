<?php

namespace App\Http\Controllers\Verification;

use App\Http\Controllers\Assign\AssignController;
use App\Mail\CareerMail;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\BikeDetail;
use App\Model\FcmToken;
use App\Model\Guest\Career;
use App\Model\Notification;
use App\Model\Platform;
use App\Model\Seeder\UserCurrentStatus;
use App\Model\Telecome;
use App\Model\UserLiveStatus\UserLiveStatus;
use App\Model\VerificationForm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(auth()->user()->id==1){
            $verifications = VerificationForm::all();

            $not_verified =  VerificationForm::where('status','=','0')->get();
            $verified =  VerificationForm::where('status','=','1')->get();
            $rejected =  VerificationForm::where('status','=','2')->get();

            $user_current_statuses = UserCurrentStatus::all();

            $platforms = Platform::all();

        }else{
            $plateform_id = auth()->user()->user_platform_id;



            $verifications = VerificationForm::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform_id', auth()->user()->user_platform_id);
                })->get();



            $not_verified =  VerificationForm::where('status','=','0')->whereIn('platform_id', auth()->user()->user_platform_id)->get();
            $verified =  VerificationForm::where('status','=','1')->whereIn('platform_id', auth()->user()->user_platform_id)->get();
            $rejected =  VerificationForm::where('status','=','2')->whereIn('platform_id', auth()->user()->user_platform_id)->get();

            $platforms = Platform::all();
            $user_current_statuses = UserCurrentStatus::all();

        }



       return  view('admin-panel.verification.index',compact('verifications', 'platforms','not_verified','verified','rejected','user_current_statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        try{

            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'remarks' => 'required'
            ]);
            if($validator->fails()) {
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
                return redirect()->route('verification')->with($message);
            }

            $id = $request->id;
            $remarks = $request->remarks;
            $status = $request->status;

            $verify = VerificationForm::find($id);

            $verify->status = $status;
            $verify->remark = $remarks;
            $verify->verify_by = Auth::user()->id;
            $verify->update();

            $application_status = "";
            if($request->status=="0"){
                $application_status  = "Not Verified";
            }elseif($request->status=="1"){
                $application_status  = "Verified";

                $verify = VerificationForm::find($id);

                $passport_id = $verify->user->profile->passport_id;

//                echo $verify->updated_at;
//                dd($verify->updated_at);

                $bike = BikeDetail::where('plate_no','=',$verify->plate_no)->first();
                $sim =  Telecome::where('account_number','=',$verify->simcard_no)->first();


                $assign_bike = new  AssignBike();
                $assign_bike->passport_id = $passport_id;
                $assign_bike->bike = $bike->id;
                $assign_bike->checkin = $verify->updated_at;
                $assign_bike->save();

                $assign_sim = new  AssignSim();
                $assign_sim->passport_id = $passport_id;
                $assign_sim->sim = $sim->id;
                $assign_sim->checkin = $verify->updated_at;
                $assign_sim->save();

                $assign_platform = new  AssignPlateform();
                $assign_platform->passport_id = $passport_id;
                $assign_platform->plateform = $verify->platform_id;
                $assign_platform->checkin = $verify->updated_at;
                $assign_platform->save();

                $user_id = $verify->user->profile->user_id;


                 $user_already = UserLiveStatus::where('user_id','=',$user_id)->first();
                 if(!empty($user_already)){
                     $user_already->user_current_status_id = $request->user_current_status;
                     $user_already->update();
                 }else{

                     $live_status = new UserLiveStatus();
                     $live_status->user_id = $user_id;
                     $live_status->user_current_status_id = $request->user_current_status;
                     $live_status->save();

                 }










            }elseif($request->status=="2"){
                $application_status  = "Rejected";
            }

            $career_array = array(
                'status' => $application_status,
                'remarks' => $remarks,
            );


        $verify = VerificationForm::find($id);

                $token=FcmToken::select('fcm_token')->where('user_id', '=', $verify->user_id)->first();
                if(!empty($token)){

                    $token  = $token->fcm_token;
                    $title = "New form update";
                    $body = "status: {$application_status}";
                    $activity="VERIFICATIONACTIVTY";
                    $notification = new Notification;
                    $notification->singleDevice($token,$title,$body,$activity);

                }




//            Mail::to([$verify->email])->send(new CareerMail($career_array));

            $message = [
                'message' => 'Status has been updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('verification')->with($message);

//        }
//        catch (\Illuminate\Database\QueryException $e){
//            $message = [
//                'message' => 'Error Occured',
//                'alert-type' => 'error'
//            ];
//            return redirect()->route('verification')->with($message);
//        }


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


        $sim_number =Telecome::where('account_number', '=',trim($request->input('user_sim_number')))->first();
        $plate_number = BikeDetail::where('plate_no','=',trim($request->input('user_plate_number')))->first();



        if($sim_number != null && $plate_number != null){

            $validator = Validator::make($request->all(), [
                'user_platform_id' => 'required',
                'user_plate_from_code' => 'required|unique:verification_forms,platform_code,'. $id,
                'user_plate_number' => 'required|unique:verification_forms,plate_no,'. $id,
                'user_sim_number' => 'required|unique:verification_forms,simcard_no,'. $id,
            ]);
            if ($validator->fails()) {

                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error',
                    'error' => '',
                ];
                return redirect()->route('verification')->with($message);

            }



            $current_timestamp = Carbon::now()->timestamp;

            $ver_ob = VerificationForm::find($id);

            $ver_ob->platform_id = trim($request->user_platform_id);
            $ver_ob->platform_code = trim($request->user_plate_from_code);
            $ver_ob->plate_no = trim($request->user_plate_number);
            $ver_ob->simcard_no  = trim($request->user_sim_number);
            $ver_ob->remark =  trim($request->user_remarks);
            $ver_ob->status = $request->user_status;
            $ver_ob->verify_by = Auth::user()->id;
            $ver_ob->update();


            $application_status = "";
            if($request->user_status=="0"){
                $application_status  = "Not Verified";
            }elseif($request->user_status=="1"){
                $application_status  = "Verified";

                $verify = VerificationForm::find($id);

                $passport_id = $verify->user->profile->passport_id;

//                echo $verify->updated_at;
//                dd($verify->updated_at);

                $bike = BikeDetail::where('plate_no','=',$verify->plate_no)->first();
                $sim =  Telecome::where('account_number','=',$verify->simcard_no)->first();


                $assign_bike = new  AssignBike();
                $assign_bike->passport_id = $passport_id;
                $assign_bike->bike = $bike->id;
                $assign_bike->checkin = $verify->updated_at;
                $assign_bike->save();

                $assign_sim = new  AssignSim();
                $assign_sim->passport_id = $passport_id;
                $assign_sim->sim = $sim->id;
                $assign_sim->checkin = $verify->updated_at;
                $assign_sim->save();

                $assign_platform = new  AssignPlateform();
                $assign_platform->passport_id = $passport_id;
                $assign_platform->plateform = $verify->platform_id;
                $assign_platform->checkin = $verify->updated_at;
                $assign_platform->save();

                $user_id = $verify->user->profile->user_id;


                $user_already = UserLiveStatus::where('user_id','=',$user_id)->first();
                if(!empty($user_already)){
                    $user_already->user_current_status_id = $request->user_c_status;
                    $user_already->update();
                }else{

                    $live_status = new UserLiveStatus();
                    $live_status->user_id = $user_id;
                    $live_status->user_current_status_id = $request->user_c_status;
                    $live_status->save();

                }





            }elseif($request->status=="2"){
                $application_status  = "Rejected";
            }

            $career_array = array(
                'status' => $application_status,
                'remarks' => $request->user_remarks,
            );

            $verify = VerificationForm::find($id);
            $token=FcmToken::select('fcm_token')->where('user_id', '=', $verify->user_id)->first();
            if(!empty($token)){

                $token  = $token->fcm_token;
                $title = "New form update";
                $body = "status: {$application_status}";
                $activity="VERIFICATIONACTIViTY";
                $notification = new Notification;
                $notification->singleDevice($token,$title,$body,$activity);

            }


            $message = [
                'message' => 'Status has been updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('verification')->with($message);




        }else{

            $message = [
                'message' => "Provided Information is Wrong",
                'alert-type' => 'error',
                'error' => '',
            ];
            return redirect()->route('verification')->with($message);


        }



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

    public  function ajax_verification_detail(Request $request){

        $id = $request->primary_id;

        $verification = VerificationForm::find($id);

         $status =  "";
         if($verification->status=="0"){
            $status = "Not Verified";
         }elseif($verification->status=="1"){
             $status = "Verified";
         }elseif($verification->status=="2"){
             $status = "Rejected";
         }


         $gamer = array(
            'id' => $verification->id,
            'name' => isset($verification->user->profile->passport) ? $verification->user->profile->passport->personal_info->full_name : '',
            'email' => $verification->user->email ? $verification->user->email : '' ,
            'platform_name' =>  (isset($request->edit_form)) ? $verification->platform_id : $verification->platform->name,
            'platform_code' => $verification->platform_code,
            'plate_no' => $verification->plate_no,
            'bike_pic' => url($verification->bike_pic),
            'mulkiya_pic' => url($verification->mulkiya_pic),
            'mulkiya_back' => url($verification->mulkiya_back),
            'emirates_pic' => url($verification->emirates_pic),
            'emirates_id_back' => url($verification->emirates_id_back),
            'selfie_pic' => url($verification->selfie_pic),
            'simcard_no' =>  $verification->simcard_no,
            'remark' =>  $verification->remark,
            'status' =>   (isset($request->edit_form)) ? $verification->status : $status,
        );

        $childe['data'] [] = $gamer;



        echo json_encode($childe);
        exit;


    }


}
