<?php

namespace App\Http\Controllers\CreateInterviews;

use App\Model\Assign\AssignPlateform;
use App\Model\BikeDetail;
use App\Model\Career\RejoinCareer;
use App\Model\Cities;
use App\Model\LogAfterPpuid\LogAfterPpuid;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\OnBoardStatus\OnBoardStatusType;
use App\Model\Passport\Passport;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\FcmToken;
use App\Model\Guest\Career;
use App\Model\InterviewBatch\InterviewBatch;
use App\Model\Notification;
use App\Model\Platform;
use App\Model\Referal\Referal;
use App\Model\ReserveBike\ReserveBike;
use App\Model\RiderProfile;
use App\Model\Telecome;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Model\OwnSimBikeHistory;
use App\Model\AssingToDc\AssignToDc;
use App\Model\DcRequestForCheckin\DcRequestForCheckin;
use App\Model\DcRequestForCheckout\DcRequestForCheckout;
use App\Model\Master\CategoryAssign;

class CreateInterviewController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|interview-create-interview|Hiring-pool|Onboard|Hiring-create-new-interview-batch|Hiring-interview-btach-report', ['only' => ['index','store','edit','destroy','update']]);
        $this->middleware('role_or_permission:Admin|interview-sent-invitation|Hiring-pool|Onboard|Hiring-create-new-interview-batch|Hiring-interview-btach-report', ['only' => ['sent_interview']]);
        $this->middleware('role_or_permission:Admin|interview-acknowledge-invitation|Hiring-pool|Onboard|Hiring-create-new-interview-batch|Hiring-interview-btach-report', ['only' => ['acknowledge_interview']]);
        $this->middleware('role_or_permission:Admin|interview-rejected-invitation|Hiring-pool|Onboard|Hiring-interview-btach-report|Hiring-create-new-interview-batch', ['only' => ['invitation_rejected']]);
        $this->middleware('role_or_permission:Admin|interview-pass-candidate|Hiring-pool|Onboard|Hiring-create-new-interview-batch|Hiring-interview-btach-report', ['only' => ['pass_candidate']]);
        $this->middleware('role_or_permission:Admin|interview-fail-candidate|Hiring-pool|Onboard|Hiring-create-new-interview-batch|Hiring-interview-btach-report', ['only' => ['fail_candidate']]);
        $this->middleware('role_or_permission:Admin|interview-recent-interview|Hiring-pool|Onboard|Hiring-create-new-interview-batch|Hiring-interview-btach-report', ['only' => ['recent_interview']]);
        $this->middleware('role_or_permission:Admin|interview-batch-interview|Hiring-pool|Onboard|Hiring-create-new-interview-batch|Hiring-interview-btach-report', ['only' => ['batch_report']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $platforms = Platform::all();

         $batches = InterviewBatch::orderby('id','desc')->get();

         $batch_status_array = ["Not Completed","Completed"];

//         dd($batches);

        $cities = Cities::all();

         return  view('admin-panel.createinterview.create_interview_new_module',compact('cities','batch_status_array','platforms','batches'));

    }

    public function display_interview_list(Request $request){

        if($request->ajax()){
            $platform = $request->platform_id;
            $limit = $request->quantity;

          $assign_platforms_passport = AssignPlateform::
                                join('passports','assign_plateforms.passport_id','=','passports.id')
                               ->select('passports.id')
                                ->where('assign_plateforms.status','=','1')
                                ->pluck('passports.id')->toArray();

          $passport_nos =  AssignPlateform::where('plateform','=',$platform)
                                        ->select('passport_id')
                                        ->where('status','=','0')
                                        ->distinct('passport_id')
                                        ->pluck('passport_id')->toArray();

           $passport_career = Career::join('passports','passports.passport_no','careers.passport_no')
                                         ->where('careers.platform_id','like','%'.$platform.'%')
                                         ->select('passports.id')
                                         ->pluck('passports.id')->toArray();

           $on_board_status =OnBoardStatusType::where('platform_id','LIKE','%'.$platform.'%')
                                                ->where('applicant_status','=','1')
                                                ->select('passport_id')
                                                ->pluck('passport_id')->toArray();




            $passport_array = array_merge($passport_nos,$passport_career);

            $passport_array = array_merge($passport_array,$on_board_status);

            $passport_final_array = array_unique($passport_array);

            if($request->select_wise=="0"){

                $careers = OnBoardStatus::where('driving_license_status','=','1')
                    ->where('agreement_status','=','1')
                    ->where(function ($query) {
                        $query->orwhereNull('applicant_status')
                            ->orwhere('applicant_status','=','1');
                    })
                    ->where(function ($query) {
                        $query->orwhereNull('interview_status')
                            ->orwhere('interview_status','=','1');
                    })
                    ->where(function ($query) {
                        $query->orwhereNull('assign_platform')
                            ->orwhere('assign_platform','=','1');
                    })
//                    ->whereIn('passport_id',$passport_final_array)
//                    ->whereNotIn('passport_id',$assign_platforms_passport)
//                    ->orwhere(function ($query) use($passport_final_array) {
//                        $query->where('exist_user','=','1')
//                            ->whereIn('passport_id',$passport_final_array);
//                    })
                    ->orderby('updated_at','asc')

                    ->get();

            }



            echo json_encode($careers);

            exit;



//            $view = view("admin-panel.createinterview.display_list_table",compact('careers'))->render();
//            return response()->json(['html'=>$view]);
        }

    }

    public function save_batch(Request $request){

        $validator = Validator::make($request->all(), [
            'platform_id' => 'required',
            'date_time' => 'required',
            'reference_number' => 'required|unique:interview_batches,reference_number',
            'start_time' => 'required',
            'end_time' => 'required',
            'cities' => 'required',
            'quantity' => 'required',
        ]);
        if ($validator->fails()) {

            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $interview = new InterviewBatch();
        $interview->platform_id = $request->platform_id;
        $interview->reference_number = $request->reference_number;
        $interview->interview_date = $request->date_time;
        $interview->start_time = $request->start_time;
        $interview->end_time = $request->end_time;
        $interview->cities = json_encode($request->cities,true);
        $interview->candidate_quantity = $request->quantity;
        $interview->save();


        $message = [
            'message' => "Batch has been created successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);

    }

    public  function ajax_generate_reference_number(Request $request){


        if($request->ajax()){
             $platform = $request->platform_id;

             $batches = InterviewBatch::where('platform_id','=',$platform)->count();


                  $now_platform = Platform::find($platform);
                  $upper_case = strtoupper($now_platform->short_code);
                  $final_referenc_number = $upper_case."-"."INT"."-".($batches+1);
                  return $final_referenc_number;



        }
    }



    public function save_interview_list(Request $request){

        $validator = Validator::make($request->all(), [
            'user_ids' => 'required',
            'select_platform' => 'required',
            'select_date_time' => 'required',
        ]);
        if ($validator->fails()) {

            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $batch = new InterviewBatch();
        $batch->platform_id = $request->select_platform;
        $batch->save();

        $batch_id = $batch->id;

        foreach($request->user_ids as $gamer){

             $obj2 = RiderProfile::where('passport_id','=',$gamer)->first();
             if(!empty($obj2)){
                 Career::where('passport_no','=',$obj2->passport->passport_no)->update(['action_rider'=>null]);
                 $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj2->user_id)->first();
                 if(!empty($token)){
                     $token  = $token->fcm_token;
                     $title = "You Are Invited For Interview";
                     $body = "";
                     $activity = 'TICKETACTIVITY';
                     $notification = new Notification;
                     $notification->singleDevice($token,$title,$body,$activity);
                 }
             }
              $interview = new CreateInterviews();
              $interview->passport_id = $gamer;
              $interview->interviewbatch_id = $batch_id;
              $interview->date_time = $request->select_date_time;
              $interview->save();


             $passport = Passport::find($gamer);

               Career::where('passport_no','=',$passport->passport_no)->update(['hire_status'=>'0']);

                $onboard = OnBoardStatus::where('passport_id','=',$passport->id)->first();

                if($onboard != null){
                    $onboard->applicant_status = '0';
                    // $onboard->on_board = '0';
                    //by me this cooment added
                    $onboard->update();
                }else{

                    // $onboard_status = new OnBoardStatus();
                    // $onboard_status->passport_id = $passport->id;
                    // $onboard_status->applicant_status = "0";
                    // $onboard_status->save();
                }


//            Referal::where('passport_no','=',$passport->passport_no)
//                ->update(['status'=>'1']);
        }

        $message = [
            'message' => "Interview Invitation Sent Successfully ",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);

    }

    public function sent_interview(Request $request){

        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->select('create_interviews.*')
            ->get();

        if($request->ajax()){

            return Datatables::of($create_interviews)
                ->addColumn('user_name',function(CreateInterviews $interview){

                    $name =  isset($interview->passport->personal_info->full_name) ? $interview->passport->personal_info->full_name : '' ;
                    if(empty($name)){
                        $name =  isset($interview->career_detail) ? $interview->career_detail->name : '' ;
                    }
                    return $name;
                })
                ->addColumn('platform',function(CreateInterviews $interview){
                    return isset($interview->batch_info->platform->name) ? $interview->batch_info->platform->name : '';
                })
                ->addColumn('passport_number',function(CreateInterviews $interview){
                    return  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;

                })
                ->addColumn('phone',function(CreateInterviews $interview){
                    return isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";
                })
                ->addColumn('nationality',function(CreateInterviews $interview){
                    return isset($interview->passport->nation->name) ? $interview->passport->nation->name : '';
                })
                ->addColumn('status',function(CreateInterviews $interview){

//                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';
                    $status = "";
                    $class = "";
                    if($interview->interview_status=="0"){
                        $status = "Pending";
                        $class = "primary";
                    }elseif($interview->interview_status=="1"){
                        $status = "Pass";
                        $class = "success";
                    }elseif($interview->interview_status=="2"){
                        $status = "Fail";
                        $class = "danger";
                    }elseif($interview->interview_status=="3"){
                        $status = "Absent";
                        $class = "info";
                    }

                    return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

      return view('admin-panel.createinterview.all_sent',compact('create_interviews'));
    }

    public function acknowledge_interview(Request $request){

        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->select('create_interviews.*')
            ->where('create_interviews.acknowledge_status','=','1')
            ->where('create_interviews.interview_status','=','0')
            ->get();

        if($request->ajax()){

            return Datatables::of($create_interviews)
                ->addColumn('user_name',function(CreateInterviews $interview){

                    return  isset($interview->passport->personal_info->full_name) ? $interview->passport->personal_info->full_name : '' ;
                })
                ->addColumn('platform',function(CreateInterviews $interview){
                    return isset($interview->batch_info->platform->name) ? $interview->batch_info->platform->name : '';
                })
                ->addColumn('passport_number',function(CreateInterviews $interview){
                    return  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;

                })
                ->addColumn('phone',function(CreateInterviews $interview){
                    return isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";
                })
                ->addColumn('nationality',function(CreateInterviews $interview){
                    return isset($interview->passport->nation->name) ? $interview->passport->nation->name : '';
                })
                ->addColumn('status',function(CreateInterviews $interview){

//                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';
                    $status = "";
                    $class = "";
                    if($interview->acknowledge_status=="0"){
                        $status = "Pending";
                        $class = "info";
                    }elseif($interview->acknowledge_status=="1"){
                        $status = "Acknowledged";
                        $class = "primary";
                    }elseif($interview->acknowledge_status=="2"){
                        $status = "Not interested";
                        $class = "secondary";
                    }
                    return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                })
                ->addColumn('action',function(CreateInterviews $interview){

                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';

                    return $html_ab;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin-panel.createinterview.acknowledge_interview',compact('create_interviews'));
    }

    public function invitation_rejected(Request $request){


        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->select('create_interviews.*')
            ->where('create_interviews.acknowledge_status','=','2')
            ->where('create_interviews.interview_status','=','0')
            ->get();

        if($request->ajax()){

            return Datatables::of($create_interviews)
                ->addColumn('user_name',function(CreateInterviews $interview){

                    return  isset($interview->passport->personal_info->full_name) ? $interview->passport->personal_info->full_name : '' ;
                })
                ->addColumn('platform',function(CreateInterviews $interview){
                    return isset($interview->batch_info->platform->name) ? $interview->batch_info->platform->name : '';
                })
                ->addColumn('passport_number',function(CreateInterviews $interview){
                    return  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;

                })
                ->addColumn('phone',function(CreateInterviews $interview){
                    return isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";
                })
                ->addColumn('nationality',function(CreateInterviews $interview){
                    return isset($interview->passport->nation->name) ? $interview->passport->nation->name : '';
                })
                ->addColumn('status',function(CreateInterviews $interview){

//                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';
                    $status = "";
                    $class = "";
                    if($interview->acknowledge_status=="0"){
                        $status = "Pending";
                        $class = "info";
                    }elseif($interview->acknowledge_status=="1"){
                        $status = "Acknowledged";
                        $class = "primary";
                    }elseif($interview->acknowledge_status=="2"){
                        $status = "Not interested";
                        $class = "secondary";
                    }
                    return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                })
                ->addColumn('action',function(CreateInterviews $interview){

                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';

                    return $html_ab;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin-panel.createinterview.rejected_invitation',compact('create_interviews'));
    }


    public function pass_candidate(Request $request){


        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->select('create_interviews.*')
            ->where('create_interviews.acknowledge_status','=','1')
            ->where('create_interviews.interview_status','=','1')
            ->get();

        if($request->ajax()){

            return Datatables::of($create_interviews)
                ->addColumn('user_name',function(CreateInterviews $interview){

                    return  isset($interview->passport->personal_info->full_name) ? $interview->passport->personal_info->full_name : '' ;
                })
                ->addColumn('platform',function(CreateInterviews $interview){
                    return isset($interview->batch_info->platform->name) ? $interview->batch_info->platform->name : '';
                })
                ->addColumn('passport_number',function(CreateInterviews $interview){
                    return  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;

                })
                ->addColumn('phone',function(CreateInterviews $interview){
                    return isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";
                })
                ->addColumn('nationality',function(CreateInterviews $interview){
                    return isset($interview->passport->nation->name) ? $interview->passport->nation->name : '';
                })
                ->addColumn('status',function(CreateInterviews $interview){

                    $status = "Pass";
                    $class = "success";

                    return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                })
                ->addColumn('action',function(CreateInterviews $interview){

                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';

                    return $html_ab;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin-panel.createinterview.pass_candidate',compact('create_interviews'));
    }


    public function fail_candidate(Request $request){


        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->select('create_interviews.*')
            ->where('create_interviews.acknowledge_status','=','1')
            ->where('create_interviews.interview_status','=','2')
            ->get();

        if($request->ajax()){

            return Datatables::of($create_interviews)
                ->addColumn('user_name',function(CreateInterviews $interview){

                    return  isset($interview->passport->personal_info->full_name) ? $interview->passport->personal_info->full_name : '' ;
                })
                ->addColumn('platform',function(CreateInterviews $interview){
                    return isset($interview->batch_info->platform->name) ? $interview->batch_info->platform->name : '';
                })
                ->addColumn('passport_number',function(CreateInterviews $interview){
                    return  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;

                })
                ->addColumn('phone',function(CreateInterviews $interview){
                    return isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";
                })
                ->addColumn('nationality',function(CreateInterviews $interview){
                    return isset($interview->passport->nation->name) ? $interview->passport->nation->name : '';
                })
                ->addColumn('status',function(CreateInterviews $interview){

                    $status = "Fail";
                    $class = "danger";

                    return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                })
                ->addColumn('action',function(CreateInterviews $interview){

                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';

                    return $html_ab;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
        return view('admin-panel.createinterview.fail_candiadate',compact('create_interviews'));
    }

    public function recent_interview(Request $request){

         $laste_id = InterviewBatch::orderby('id','desc')->first();

         if(!empty($laste_id)){

             $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                 ->select('create_interviews.*')
                 ->where('create_interviews.interviewbatch_id','=',$laste_id->id)
                 ->get();

         }



            if($request->ajax()){

                return Datatables::of($create_interviews)
                    ->addColumn('user_name',function(CreateInterviews $interview){

                        return  isset($interview->passport->personal_info->full_name) ? $interview->passport->personal_info->full_name : '' ;
                    })
                    ->addColumn('platform',function(CreateInterviews $interview){
                        return isset($interview->batch_info->platform->name) ? $interview->batch_info->platform->name : '';
                    })
                    ->addColumn('passport_number',function(CreateInterviews $interview){
                        return  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;

                    })
                    ->addColumn('phone',function(CreateInterviews $interview){
                        return isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";
                    })
                    ->addColumn('nationality',function(CreateInterviews $interview){
                        return isset($interview->passport->nation->name) ? $interview->passport->nation->name : '';
                    })
                    ->addColumn('status',function(CreateInterviews $interview){
                        $status = "";
                        $class = "";
                        if($interview->acknowledge_status=="0"){
                            $status = "Pending";
                            $class = "info";
                        }elseif($interview->acknowledge_status=="1"){
                            $status = "Acknowledged";
                            $class = "primary";
                        }elseif($interview->acknowledge_status=="2"){
                            $status = "Not interested";
                            $class = "secondary";
                        }
                        return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                    })
                    ->addColumn('interview_status',function(CreateInterviews $interview){
                        $status = "";
                        $class = "";
                        if($interview->interview_status=="0"){
                            $status = "Pending";
                            $class = "primary";
                        }elseif($interview->interview_status=="1"){
                            $status = "Pass";
                            $class = "success";
                        }elseif($interview->interview_status=="2"){
                            $status = "Fail";
                            $class = "danger";
                        }
                        return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                    })
                    ->addColumn('action',function(CreateInterviews $interview){

                        if($interview->interview_status=="1"){
                            $status = "Pass";
                            $class = "success";
                            $html_ab = '<h4 class="badge badge-primary">Not Required</h4>';
                        }elseif($interview->interview_status=="2"){
                            $status = "Fail";
                            $class = "success";
                            $html_ab = '<h4 class="badge badge-danger">Not Required</h4>';
                        }
                        else{
                            $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$interview->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';
                        }


                        return $html_ab;
                    })
                    ->rawColumns(['status','action','interview_status'])
                    ->make(true);
            }


        return view('admin-panel.createinterview.recent_interview',compact('create_interviews'));
    }


    public function batch_report(Request $request){

      if($request->ajax()){


          $batch_id = $request->batch_id;

          $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
              ->select('create_interviews.*')
              ->where('create_interviews.interviewbatch_id','=',$batch_id)
              ->get();

                return Datatables::of($create_interviews)
                    ->addColumn('user_name',function(CreateInterviews $interview){

                        $name =  isset($interview->passport) ? $interview->passport->personal_info->full_name : '' ;
                        if(empty($name)){
                            $name =  isset($interview->career_detail) ? $interview->career_detail->name : '' ;
                        }
                        return $name;


                    })
                    ->addColumn('platform',function(CreateInterviews $interview){
                        return isset($interview->batch_info) ? $interview->batch_info->platform->name : '';
                    })
                    ->addColumn('passport_number',function(CreateInterviews $interview){
                        $passport_no =  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;

                        if(empty($passport_no)){
                            $passport_no =  isset($interview->career_detail) ? $interview->career_detail->passport_no : '' ;
                        }

                        return $passport_no;
                    })
                    ->addColumn('phone',function(CreateInterviews $interview){
                        $phone =  isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";

                        if(empty($phone)){
                            $phone =  isset($interview->career_detail) ? $interview->career_detail->phone : '' ;
                        }

                        return $phone;

                    })
                    ->addColumn('nationality',function(CreateInterviews $interview){
                      $nation = isset($interview->passport) ? $interview->passport->nation->name : '';

                        if(empty($nation)){
                            $nation =  isset($interview->career_detail->country_name) ? $interview->career_detail->country_name->name : '' ;
                        }

                        return $nation;

                    })
                    ->addColumn('status',function(CreateInterviews $interview){
                        $status = "";
                        $class = "";
                        if($interview->acknowledge_status=="0"){
                            $status = "Pending";
                            $class = "info";
                        }elseif($interview->acknowledge_status=="1"){
                            $status = "Acknowledged";
                            $class = "primary";
                        }elseif($interview->acknowledge_status=="2"){
                            $status = "Not interested";
                            $class = "secondary";
                        }
                        return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                    })
                    ->addColumn('interview_status',function(CreateInterviews $interview){
                        $status = "";
                        $class = "";
                        if($interview->interview_status=="0"){
                            $status = "Pending";
                            $class = "primary";
                        }elseif($interview->interview_status=="1"){
                            $status = "Pass";
                            $class = "success";
                        }elseif($interview->interview_status=="2"){
                            $status = "Fail";
                            $class = "danger";
                         }elseif($interview->interview_status=="3"){
                            $status = "Absent";
                            $class = "info";
                        }

                        return '<h4 class="badge badge-'.$class.'">'.$status.'</h4>';
                    })
                    ->addColumn('checkbox_operation',function (CreateInterviews $interviews){

                        if($interviews->interview_status=="0"){
                            $html = ' <label class="checkbox checkbox-outline-primary text-10">
                                                        <input type="checkbox" class="company_checkbox" name="checkbox_array[]" value="'.$interviews->id.'"><span></span><span class="checkmark"></span>
                                                    </label>';
                        }else{
                            $html = "";
                        }

                        return $html;

                    })
                    ->setRowAttr([
                        'style' => function(CreateInterviews $interviews) {
                            $check_defaulter  = isset($interviews->defaulter_rider_details) ? $interviews->defaulter_rider_details : null;
                            $is_defaulte_now = null;

                            if(isset($check_defaulter)){
                                    if(count($check_defaulter)>0){
                                        $is_defaulte_now  =  $check_defaulter[0]->check_defaulter_rider() ? $check_defaulter[0]->check_defaulter_rider() : null;
                                        if(isset($is_defaulte_now)){
                                            return  "background-color : #ff18004a";
                                        }else{
                                            return  "background-color :";
                                        }



                                   }
                            }else{
                                return  "background-color : ";
                            }

                        },
                    ])
                    ->rawColumns(['status','interview_status','checkbox_operation'])
                    ->make(true);
            }

      $batches = InterviewBatch::orderby('id','desc')->get();
        return view('admin-panel.createinterview.batch_report',compact('batches'));



    }


    public function autocomplete_batch_report(Request  $request){


        if($request->ajax()){

            $create_interview_passports =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
              ->select('create_interviews.*')
            //   ->where('create_interviews.interview_status','=','0')
              ->pluck('passport_id')
              ->toArray();


            $create_interview_career =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->select('create_interviews.*')
            // ->where('create_interviews.interview_status','=','0')
            ->pluck('career_id')
            ->toArray();





        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code','passports.id')
        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
        ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
        ->whereIn('passports.id',$create_interview_passports)
        ->get();

    if (count($passport_data)=='0')
    {
        // return "pp";
        $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passports.id','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
            ->whereIn('passports.id',$create_interview_passports)
            ->get();
                if (count($puid_data)=='0')
                {
                    $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code','passports.id')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->whereIn('passports.id',$create_interview_passports)
                        ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                        ->get();
                    if (count($full_data)=='0')
                    {
                        $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid','passports.id')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->whereIn('passports.id',$create_interview_passports)
                            ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                            ->get();

                            if(count($zds_data)=='0'){

                                $career_name = Career::where("name","like","%{$request->input('query')}%")
                                ->whereIn('id',$create_interview_career)
                                    ->get();


                                        if(count($career_name)=='0'){

                                            $career_email = Career::where("email","like","%{$request->input('query')}%")
                                            ->whereIn('id',$create_interview_career)
                                            ->get();

                                                        if(count($career_email)=='0'){

                                                            $career_phone = Career::where("phone","like","%{$request->input('query')}%")
                                                                                    ->whereIn('id',$create_interview_career)
                                                                                    ->get();

                                                                    if(count($career_phone)=='0'){

                                                                    }
                                                                        //career phone
                                                                        $pass_array=array();
                                                                        foreach ($career_phone as $pass){
                                                                            $gamer = array(
                                                                                'name' => isset($pass->phone) ? $pass->phone : '',
                                                                                'passport' => $pass->name,
                                                                                'ppuid' => $pass->email,
                                                                                'id' => $pass->id,
                                                                                'full_name' => $pass->whatsapp,
                                                                                'type'=>'5',
                                                                            );
                                                                            $pass_array[]= $gamer;
                                                                        }
                                                                        return response()->json($pass_array);


                                                        }

                                                        //career email
                                                        $pass_array=array();
                                                        foreach ($career_name as $pass){
                                                            $gamer = array(
                                                                'name' => isset($pass->email) ? $pass->email : '',
                                                                'passport' => $pass->phone,
                                                                'ppuid' => $pass->name,
                                                                'id' => $pass->id,
                                                                'full_name' => $pass->whatsapp,
                                                                'type'=>'6',
                                                            );
                                                            $pass_array[]= $gamer;
                                                        }
                                                        return response()->json($pass_array);

                                        }
                                                 //career name
                                                $pass_array=array();
                                                foreach ($career_name as $pass){

                                                    $gamer = array(
                                                        'name' => isset($pass->name) ? $pass->name : '',
                                                        'passport' => $pass->phone,
                                                        'ppuid' => $pass->email,
                                                        'id' => $pass->id,
                                                        'full_name' => $pass->whatsapp,
                                                        'type'=>'4',
                                                    );
                                                    $pass_array[]= $gamer;
                                                }
                                                return response()->json($pass_array);


                            }

                            //zds code response
                            $pass_array=array();
                            foreach ($zds_data as $pass){
                                $gamer = array(
                                    'name' => isset($pass->zds_code) ? $pass->zds_code : '',
                                    'passport' => $pass->passport_no,
                                    'id' => $pass->id,
                                    'ppuid' => $pass->pp_uid,
                                    'full_name' => $pass->full_name,
                                    'type'=>'3',
                                );
                                $pass_array[]= $gamer;
                            }
                            return response()->json($pass_array);







                    }

                    //full name response
                    $pass_array=array();
                    foreach ($full_data as $pass){
                        $gamer = array(
                            'name' => $pass->full_name,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'id' => $pass->id,
                            'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
                            'type'=>'2',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);

                }
                //ppuid response
                    $pass_array=array();
                    foreach ($puid_data as $pass){
                        $gamer = array(
                            'name' => $pass->pp_uid,
                            'passport' => $pass->passport_no,
                            'full_name' => $pass->full_name,
                            'id' => $pass->id,
                            'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
                            'type'=>'1',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);
                }


                //passport number response
                $pass_array=array();
                foreach ($passport_data as $pass){
                    $gamer = array(
                        'name' => $pass->passport_no,
                        'ppuid' => $pass->pp_uid,
                        'full_name' => $pass->full_name,
                        'id' => $pass->id,
                        'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
                        'type'=>'0',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);


        }


    }



    public function get_autocomplete_batch_report(Request $request){

        if($request->ajax()){

            $type = $request->type_now;
            $primary_id = $request->primary_id;

            if($type=="career"){

                $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                ->select('create_interviews.*')
                ->where('create_interviews.career_id','=',$primary_id)
                ->get();

            }else{

                $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                ->select('create_interviews.*')
                ->where('create_interviews.passport_id','=',$primary_id)
                ->get();

            }


            $view = view("admin-panel.createinterview.batch_report_search_result",compact('create_interviews'))->render();

            return response()->json(['html'=>$view]);


        }

    }



    public function ajax_batch_log(Request $request){

          $batch_id= $request->batch;

        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->select('create_interviews.*')
            ->where('create_interviews.interviewbatch_id','=',$batch_id)
            ->get();

        $total_acknowledge = $create_interviews->where('acknowledge_status','=','1')->where('interview_status','=','0')->count();
        $total_no_response = $create_interviews->where('acknowledge_status','=','2')->where('interview_status','=','0')->count();
        $total_pass = $create_interviews->where('interview_status','=','1')->count();
        $total_fail = $create_interviews->where('interview_status','=','2')->count();
        $total_absent = $create_interviews->where('interview_status','=','3')->count();
        $total_interview_pending = $create_interviews->where('interview_status','=','0')->count();

        $array_to_send = array(
            'total_acknowledge' => $total_acknowledge,
            'total_no_response' => $total_no_response,
            'total_pending' => $total_absent,
            'total_interview_pending' => $total_interview_pending,
            'total_pass' => $total_pass,
            'total_fail' => $total_fail,
        );

        echo json_encode($array_to_send);
        exit;
    }

    public function ajax_interview_user(Request $request){

        $batch_id = $request->batch_id;
        $create_interviews = CreateInterviews::where('interviewbatch_id','=',$batch_id)
            ->where('create_interviews.acknowledge_status','=','1')
            ->where('create_interviews.interview_status','=','1')
            ->get();

        $bikes = BikeDetail::all();
        $passport = Passport::all();
        $bikes_detail = BikeDetail::select('bike_details.*')
            ->leftjoin('assign_bikes', 'assign_bikes.bike', '=', 'bike_details.id')
            ->where('assign_bikes.status', '=', 1)
            ->orwhere('bike_details.reserve_status', '=', 1)
            ->distinct()
            ->get();
        $checkedin = array();
        foreach ($bikes_detail as $x) {
            $checkedin [] = $x->id;
        }

        $checked_out = array();
        foreach ($bikes as $ab) {
            if (!in_array($ab->id, $checkedin)) {
                $gamer = array(
                    'id' => $ab->id,
                    'bike' => $ab->plate_no,
                    'cencel' => isset($ab->bike_cancel->plate_no) ? $ab->bike_cancel->plate_no : "",
                );
                $checked_out [] = $gamer;
            }
        }

        $sims=Telecome::all();

        $sim = Telecome::select('telecomes.*')
            ->leftjoin('assign_sims', 'assign_sims.sim', '=', 'telecomes.id')
            ->where('assign_sims.status','=',1)
            ->orwhere('telecomes.reserve_status','=',1)
            ->get();

        //getting assinged sim details
        $checkedin = array();
        foreach ($sim as $x) {
            $checkedin [] = $x->id;
        }

        $checked_out_sim = array();
        foreach ($sims as $ab) {

            if (!in_array($ab->id, $checkedin)) {
                $gamer = array(
                    'sim_number' => $ab->account_number,
                    'id' => $ab->id,
                );
                $checked_out_sim [] = $gamer;
            }
        }

        $reserved_variable = "";
        $reserve_bikes = array();
        if(isset($request->type)){
            $reserved_variable = $request->type;
            $reserve_bikes = ReserveBike::where('batch_id','=',$batch_id)->get();
        }


        $view = view("admin-panel.reserve_bike.ajax_batch_user",compact('create_interviews', 'reserve_bikes', 'reserved_variable','checked_out','checked_out_sim'))->render();

        return response()->json(['html'=>$view]);
    }

    public function get_city_wise_batch_interview(Request $request){

        if($request->ajax()){

            $city_id = $request->city_id;
            $platform_id = $request->platform_id;


            if($city_id != null && $platform_id != null){
                $batches = InterviewBatch::where('cities','LIKE','%'.$city_id.'%')
                                         ->where('platform_id','=',$platform_id)
                                           ->get();

            }elseif(!empty($city_id) && empty($platform_id)){
                $batches = InterviewBatch::where('cities','LIKE','%'.$city_id.'%')->get();
            }elseif(empty($city_id) && !empty($platform_id)){
                $batches = InterviewBatch::where('platform_id','=',$platform_id)->get();
            }




            echo json_encode($batches);

            exit;

        }
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


        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'remarks' => 'required',
        ]);
        if ($validator->fails()) {

            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $batch = CreateInterviews::find($id);
        $batch->interview_status = $request->status;
        $batch->update();

        $pass_status = "";
        if($request->status==1){
            $pass_status = "3";
        }else{
            $pass_status = "4";
        }

        if($pass_status=="4"){
            $on_board = OnBoardStatus::where('passport_id','=',$batch->passport_id)->first();
            if($on_board != null){
                OnBoardStatus::where('passport_id','=',$batch->passport_id)
                    ->update(['interview_status'=>'1']);
            }else{
                $on_board = new OnBoardStatus();
                $on_board->passport_id = $batch->passport_id;
                $on_board->interview_status = '1';
                $on_board->save();
            }
        }else{
            $on_board = OnBoardStatus::where('passport_id','=',$batch->passport_id)->first();
            if($on_board != null){
                OnBoardStatus::where('passport_id','=',$batch->passport_id)
                    ->update(['interview_status'=>'0']);
            }else{
                $on_board = new OnBoardStatus();
                $on_board->passport_id = $batch->passport_id;
                $on_board->interview_status = '0';
                $on_board->save();
            }
        }

        $passport = Passport::find($batch->passport_id);
        Career::where('passport_no','=',$passport->passport_no)->update(['hire_status'=>$pass_status]);
        $onboard = OnBoardStatus::where('passport_id','=',$batch->passport_id)->first();
        $passport_id = $batch->passport_id;

      $notification_msg = "";

       if($request->status=="1"){
           $notification_msg = "Congratulations you are selected for this job.";

           if($onboard != null){
               $onboard->applicant_status = "0";
            //    $onboard->on_board = "0";
            // comment added by me
               $onboard->exist_user = "0";
               $onboard->update();
           }else{
               $onboard_status = new OnBoardStatus();
               $onboard_status->passport_id = $batch->passport->id;
               $onboard->applicant_status = "0";
            //    $onboard->on_board = "0";
               $onboard->exist_user = "0";
               $onboard_status->save();
           }
//dd("fsg");
       }else{
           $notification_msg = "Unfortunately you are not selected.";

           if($onboard != null){
               $onboard->applicant_status = "1";
            //    $onboard->on_board = "1";
                 // comment added by me
               $onboard->exist_user = "1";
               $onboard->update();
           }else{
               $onboard_status = new OnBoardStatus();
               $onboard_status->passport_id = $batch->passport->id;
               $onboard->applicant_status = "1";
            //    $onboard->on_board = "1";
                 // comment added by me
               $onboard->exist_user = "1";
               $onboard_status->save();
           }
       }


            $obj2 = RiderProfile::where('passport_id','=',$passport_id)->first();
            if(!empty($obj2)){
                $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj2->user_id)->first();
                if(!empty($token)){
                    $token  = $token->fcm_token;
                    $title = $notification_msg;
                    $body = "";
                    $activity = 'TICKETACTIVITY';
                    $notification = new Notification;
                    $notification->singleDevice($token,$title,$body,$activity);
                }
            }

        $message = [
            'message' => "Interview Invitation Sent Successfully ",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);


    }

    public function update_interview_status(Request $request){


        try{



        $validator = Validator::make($request->all(), [
            'interview_status' => 'required',
            'checkbox_array' => 'required',
        ]);
        if ($validator->fails()) {

            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $selected_ids = explode(',',$request->checkbox_array);

        $already_passed  =CreateInterviews::whereIn('id',$selected_ids)->where('interview_status','=','1')->get();

        if($already_passed->count()>0){
            $message = [
                'message' => "Pass Candidate Status can't be change again",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $time_stamp = Carbon::now()->toDateTimeString();

        foreach($selected_ids as $ids){

            $interview = CreateInterviews::find($ids);
            if($interview!=null){
                $career_id = $interview->career_id;
                $interview->interview_status = $request->interview_status;
                $interview->update();
            }


            if($career_id!="0"){

                if($request->interview_status=="1"){

                    $career_orignal = Career::find($career_id);
                    $career_orignal->hire_status = 1;
                    $career_orignal->update();
                    $onboard = new OnBoardStatus();
                    $onboard->career_id = $career_id;
                    $onboard->interview_status = $request->interview_status;
                    $onboard->assign_platform = 1;
                    $onboard->create_interview_id = $ids;
                    $onboard->on_board = 1;
                    $onboard->save();

                }else{
                    $career_orignal = Career::find($career_id);
                    $career_orignal->applicant_status = 4;
                    $career_orignal->hire_status = 0;
                    $career_orignal->update();
                }

            }else{


                        if($request->interview_status=="1"){

                            $inter = CreateInterviews::find($ids);
                            $passport_id = $inter->passport_id;



                            $rejoin = RejoinCareer::where('passport_id',$passport_id)->where('hire_status','=',0)->orderby('id','desc')->first();
                    // $passport_id = $rejoin->passport_id;
                    $rejoin->applicant_status = "10";
                    $rejoin->on_board = "1";
                    $data =  json_decode($rejoin->history_status,true);
                     array_push($data, ['7' => $time_stamp]);
                     array_push($data, ['10' => $time_stamp]);
                    $rejoin->history_status = json_encode($data);
                    $rejoin->update();

                    $dc_request_old = DcRequestForCheckout::where('rider_passport_id','=',$passport_id)->orderby('id','desc')->first();

                    if($dc_request_old != null){
                        if($dc_request_old->request_status=="1"){

                            if($dc_request_old->shuffle_type=="2"){

                                // $current_timestamp = Carbon::now()->timestamp;
                                $current_timestamp = Carbon::now()->toDateTimeString();

                                // $checkout_date =  $dc_request_old->checkout_date_time;
                                $remark =  $dc_request_old->remarks;
                                $result = $this->checkout_method_for_interview_pass($current_timestamp,$remark,$passport_id);

                          }

                       }

                    }
                    $onboard = new OnBoardStatus();
                    $onboard->passport_id = $passport_id;
                    $onboard->interview_status = $request->interview_status;
                    $onboard->assign_platform = 1;
                    $onboard->create_interview_id = $ids;
                    $onboard->on_board = 1;
                    $onboard->save();





                        }else{
                            $now_status = "";
                                if($request->interview_status=="2"){
                                    $now_status = 8;
                                }elseif($request->interview_status=="3"){
                                    $now_status = 9;
                                }
                            $inter = CreateInterviews::find($ids);
                            $passport_id = $inter->passport_id;

                            $rejoin = RejoinCareer::where('passport_id',$passport_id)->where('hire_status','=',0)->first();
                            $rejoin->applicant_status = "4";
                            $data =  json_decode($rejoin->history_status,true);
                            array_push($data, [$now_status => $time_stamp]);
                            $rejoin->history_status = json_encode($data);
                            $rejoin->update();

                        }




            }
            // main else end here




        }
        //for each end here

        $message = [
            'message' => "status has been changes successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);

    }catch (\Illuminate\Database\QueryException $e){
        $message = [
            'message' => 'Error Occured',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($message);
    }



    }


    public function checkout_method_for_interview_pass($checkout_date,$remarks,$passport_id){

        try{

        $passport_id = $passport_id;
        $assign_obj_ab = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

        if($assign_obj_ab==null){

            return "Platform is not checkin, you can not checkout";
        }


        $obj = AssignPlateform::where('passport_id','=',$passport_id)->where('status','=','1')->first();

            $obj->checkout=$checkout_date;
            $obj->remarks=$remarks;
            $obj->status='0';
            $obj->save();

            OwnSimBikeHistory::where('passport_id','=',$passport_id)
                ->where('status','=','1')
                ->update(array('status' => "0", 'checkout'=>$checkout_date));

            AssignToDc::where('rider_passport_id','=',$passport_id)
                ->where('status','=','1')
                ->update(array('status' => "0",'checkout'=>$checkout_date));


                CategoryAssign::where('passport_id','=',$passport_id)
                ->where('status','=','1')
                ->orderby('id','desc')
                ->update(array('status' => "0",'assign_ended_at' => Carbon::now()));

            return 'success';
        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return "Error Occured";
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
}
