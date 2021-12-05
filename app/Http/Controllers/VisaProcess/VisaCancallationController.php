<?php

namespace App\Http\Controllers\VisaProcess;

use App\Model\Departments;
use App\Model\Passport\Passport;
use App\Model\UserCodes\UserCodes;
use App\Model\VisaProcess\CancelledVisa;
use App\Model\VisaProcess\LabourCardCancel;
use App\Model\VisaProcess\VisaCancallation;
use App\Model\VisaProcess\VisaCancelChat;
use App\Model\VisaProcess\VisaCancellStatus;
use App\Model\VisaProcess\VisaClearance;
use App\Notifications\Notifications\AssignTicket;
use App\Notifications\Notifications\VisaCencelNotification;
use App\Notifications\TicketReplies;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Manager_users;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use App\Model\VisaProcess\UniqueEmailIdHandover;
use App\Model\VisaProcess\VisaCencel\VisaCancellation;
use App\Model\VisaProcess\VisaCencel\VisaCancellationApproval;
use App\Model\VisaProcess\VisaCencel\VisaCancellationDecline;
use App\Model\VisaProcess\VisaCencel\VisaCancellationSubmission;
use App\Model\VisaProcess\VisaCencel\VisaCancellationTyping;
use App\Model\VisaProcess\VisaCencel\VisaCancellationStatus;
use App\Model\PaymentType;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\VisaCancel\BetweenVisaCancel;
use App\Model\VisaProcess\VisaCancel\VisaCancelRequest;
use App\Model\VisaProcess\VisaCencel\ReplacementVisaCancel;
use App\VisaCancel\VisaCancelPayment;
use App\VisaProcess\ReplacementRequest;
use Illuminate\Container\RewindableGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class VisaCancallationController extends Controller
{



    function __construct()
    {
        $this->middleware('role_or_permission:Admin|visa_cancel_visa_cancel|', ['only' => ['index','store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin| visa_cancel_view_visa_clearance_report', ['only' => [' visa_cancel_view_visa_clearance_report']]);
        $this->middleware('role_or_permission:Admin|visa_cancel_visa_clearance_requests', ['only' => ['visa_cancel_visa_clearance_requests']]);
        $this->middleware('role_or_permission:Admin|visa_cancel_all_cancelled_visa', ['only' => ['visa_cancel_all_cancelled_visa']]);
        $this->middleware('role_or_permission:Admin|visa_cancel_approve_cancel_visa_request_pro', ['only' => ['visa_cancel_approve_cancel_visa_request_pro']]);
        $this->middleware('role_or_permission:Admin|Hiring-pool|visa_cancel_request_hr', ['only' => ['visa_cancel_request_hr']]);





//        visa_cancel_visa_cancel,
//        visa_cancel_view_visa_clearance_report,
//        visa_cancel_visa_clearance_requests,
//        visa_cancel_all_cancelled_visa,
//        visa_cancel_approve_cancel_visa_request_pro,

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
//        $canclled=VisaCancallation::all();
//
//        foreach ($canclled as $can){
//            $gamer = array(
//            "passport_id"=>$can->passport_id,
//        );
//
//        }
//        $passport=Passport::whereNotIn('id',$gamer)->get();
        return view('admin-panel.visa-master.visa_cancallation',compact('passport'));
//        return view('admin-panel.visa-master.visa_master',compact('passport','steps','job','labour_card_type'));
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

        $result=UserCodes::where('passport_id', $request->input('passport_id'))->first();
        if (isset($result)) {
            $zds_code = $result->zds_code;
        }
        else{
            $zds_code=null;
        }

        $obj = new VisaCancallation();
        $obj->passport_id = $request->input('passport_id');
        $obj->zds_code = $zds_code;
        $obj->cancallation_type = $request->input('cancallation_type');
        $obj->resignation_type = $request->input('resignation_type');
        $obj->remarks = $request->input('remarks');
        $obj->date_until_works = $request->input('date_until_works');
        $obj->start_cancel_date = $request->input('start_cancel_date');
        $obj->added_by = auth()->user()->id;

        $obj->save();


//        foreach($users as $user){
////                    dd($user);
//            $user->notify(new AssignTicket($obj));
////                    return redirect()->back();
//        }

        $message = [
            'message' => 'Cancellation Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
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


        $result=VisaCancallation::where('id',$id)->first();
        $clear_res=VisaClearance::where('cancallation_id',$result->id)->get();
        $can_status=VisaCancellStatus::all();
        $dep_id= auth()->user()->id;
        $department=User::where('id',$dep_id)->first();

        if (in_array(1, $department->user_group_id)) {
            $major_dep_id='6';
        }
        else if (in_array('1', $department->major_department_ids)) {
            $major_dep_id='1';
        }
        else if (in_array('3', $department->major_department_ids))
        {
            $major_dep_id='3';
        }
        else if (in_array('4', $department->major_department_ids))
        {
            $major_dep_id='4';
        }
        else if (in_array('5', $department->major_department_ids))
        {
            $major_dep_id='5';
        }
        else{
            $major_dep_id="100";
        }


        return view('admin-panel.visa-master.visa_cancel_chat',compact('result','clear_res','major_dep_id','can_status'));


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
    public  function cancal_approve(){
        $result=VisaCancallation::all();
        return view('admin-panel.visa-master.visa_cancel_approval',compact('result'));

    }



    public function cancal_approve_update(Request $request, $id)
    {

            $obj = VisaCancallation::find($id);
            $obj->approval_status = 1;
            $obj->save();
            $users= User::select('*')
                ->where('major_department_ids', 'LIKE', '%1%')
                ->orWhere('major_department_ids', 'LIKE', '%3%')
                ->orWhere('major_department_ids', 'LIKE', '%4%')
                ->orWhere('major_department_ids', 'LIKE', '%5%')
                ->get();
            foreach($users as $user){
                $user->notify(new VisaCencelNotification($obj));
            }
            $options = array(
                'cluster' => 'ap2',
                'encrypted' => true
            );
            $pusher = new Pusher(
                '528cdceee8181ca31807',
                'ccc70fe7e4c099aff497',
                '985726',
                $options
            );
            $pusher->trigger('manage_notification', 'notify-event',"msg");
            $message = [
                'message' => 'Approved Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);

    }


    public  function cancal_show(){
//        $result=VisaCancallation::where('approval_status','=','1')->get();
        $result=CancelledVisa::all();

        return view('admin-panel.visa-master.all_cencelled',compact('result'));

    }
    public function view_clear(){
        $result=VisaClearance::all();
        $department=User::where('id',auth()->user()->id)->first();
        $dep_id=$department->major_department_ids;

        return view('admin-panel.visa-master.view_clear',compact('result','dep_id'));
    }

    public function view_clearance_report(){
        $result=VisaClearance::all();
        return view('admin-panel.visa-master.view_clearance_report',compact('result','dep_id'));
    }
    public function view_clear_requests(){


        $result=VisaCancallation::where('approval_status','1')->get();
        $clear_res=VisaClearance::all();
        $can_status=VisaCancellStatus::all();
        $dep_id= auth()->user()->id;
        $department=User::where('id',$dep_id)->first();

        if (in_array(1, $department->user_group_id)) {
            $major_dep_id='6';
        }
       else if (in_array('1', $department->major_department_ids)) {
            $major_dep_id='1';
        }
        else if (in_array('3', $department->major_department_ids))
        {
            $major_dep_id='3';
        }
        else if (in_array('4', $department->major_department_ids))
        {
            $major_dep_id='4';
        }
        else if (in_array('5', $department->major_department_ids))
        {
            $major_dep_id='5';
        }
        else{
            $major_dep_id="100";
        }



        return view('admin-panel.visa-master.visa_cancel_requests',compact('result','clear_res','major_dep_id','can_status'));

    }


    public function clear_dep_visa(Request $request)
    {
        $pass_id=$request->input('passport_id');
        $clear_id=$request->input('clear_id');
        $dep_id=$request->input('department_id');
        $remarks=$request->input('remarks');
        $department=User::where('id',$dep_id)->first();
        $clear_val=VisaClearance::where('passport_id',$pass_id)->first();


      if(empty($clear_val)) {
          if (in_array('1', $department->major_department_ids)) {
              $obj = new VisaClearance();
              $obj->passport_id = $pass_id;
              $obj->cancallation_id = $clear_id;
              $obj->payroll_status = "1";
              $obj->payroll_remarks = $remarks;
              $obj->save();
              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect('view_clear_requests');

          } else if (in_array('3', $department->major_department_ids)) {
              $obj = new VisaClearance();
              $obj->passport_id = $pass_id;
              $obj->cancallation_id = $clear_id;
              $obj->operation_status = "1";
              $obj->operation_remarks = $remarks;
              $obj->save();
              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect('view_clear_requests');
          } else if (in_array('4', $department->major_department_ids)) {
              $obj = new VisaClearance();
              $obj->passport_id = $pass_id;
              $obj->cancallation_id = $clear_id;
              $obj->maintenance_status = "1";
              $obj->maintenance_remarks = $remarks;
              $obj->save();
              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect('view_clear_requests');
          } else if (in_array('5', $department->major_department_ids))
          {
              $obj = new VisaClearance();
              $obj->passport_id = $pass_id;
              $obj->cancallation_id = $clear_id;
              $obj->pro_status = "1";
              $obj->pro_remarks = $remarks;
              $obj->save();

              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect()->back()->with($message);
          }
      }
      else{

          if (in_array('1', $department->major_department_ids)) {
              DB::table('visa_clearances')->where('passport_id', $pass_id)
                  ->update(['payroll_status' =>'1','payroll_remarks'=>$remarks]);
              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect('view_clear_requests');
          }
          else if (in_array('3', $department->major_department_ids)) {

              DB::table('visa_clearances')->where('passport_id', $pass_id)
                  ->update(['operation_status' =>'1','operation_remarks'=>$remarks]);
              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect('view_clear_requests');
          } else if (in_array('4', $department->major_department_ids)) {
              DB::table('visa_clearances')->where('passport_id', $pass_id)
                  ->update(['maintenance_status' =>'1','maintenance_remarks'=>$remarks]);
              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect('view_clear_requests');
          } else if (in_array('5', $department->major_department_ids))
          {
              DB::table('visa_clearances')->where('passport_id', $pass_id)
                  ->update(['pro_status' =>'1','pro_remarks'=>$remarks]);
              $message = [
                  'message' => 'Cleared Successfully',
                  'alert-type' => 'success'
              ];
              return redirect('view_clear_requests');
          }
      }
    }


    public function clear_pro_visa(Request $request)
    {
        $pass_id=$request->input('passport_id');
        $clear_id=$request->input('clear_id');
        $can_status=$request->input('cancel_status');

        $obj = new CancelledVisa();
        $obj->passport_id = $pass_id;
        $obj->can_status = $can_status;
        $obj->cancallation_id = $clear_id;
        $obj->status = "1";

        $obj->save();
        DB::table('visa_clearances')->where('passport_id', $pass_id)
            ->update(['pro_status' =>'1']);
        $message = [
            'message' => 'Visa Cancelled Successfully!!!',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);

    }




    public function clear_dep_visa_req(Request $request)
    {
        $pass_id=$request->input('passport_id');
        $clear_id=$request->input('clear_id');
        $dep_id=$request->input('department_id');
        $remarks=$request->input('remarks');
        $department=User::where('id',$dep_id)->first();
        $clear_val=VisaClearance::where('passport_id',$pass_id)->first();
        if(empty($clear_val)) {
            if (in_array('1', $department->user_group_id)) {
                $obj = new VisaClearance();
                $obj->passport_id = $pass_id;
                $obj->cancallation_id = $clear_id;
                $obj->admin_status = "1";
                $obj->admin_remarks = $remarks;
                $obj->save();
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);

            }
            else if (in_array('1', $department->major_department_ids)) {
                $obj = new VisaClearance();
                $obj->passport_id = $pass_id;
                $obj->cancallation_id = $clear_id;
                $obj->payroll_status = "1";
                $obj->payroll_remarks = $remarks;
                $obj->save();
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);

            } else if (in_array('3', $department->major_department_ids)) {
                $obj = new VisaClearance();
                $obj->passport_id = $pass_id;
                $obj->cancallation_id = $clear_id;
                $obj->operation_status = "1";
                $obj->operation_remarks =$remarks;
                $obj->save();
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            } else if (in_array('4', $department->major_department_ids)) {
                $obj = new VisaClearance();
                $obj->passport_id = $pass_id;
                $obj->cancallation_id = $clear_id;
                $obj->maintenance_status = "1";
                $obj->maintenance_remarks = $remarks;
                $obj->save();
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            } else if (in_array('5', $department->major_department_ids))
            {
                $obj = new VisaClearance();
                $obj->passport_id = $pass_id;
                $obj->cancallation_id = $clear_id;
                $obj->pro_status = "1";
                $obj->pro_remarks = $remarks;
                $obj->save();
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
        }
        else{

            if (in_array('1', $department->user_group_id)) {
                DB::table('visa_clearances')->where('passport_id', $pass_id)
                    ->update(['admin_status' =>'1','admin_remarks'=>$remarks]);
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
            else if (in_array('1', $department->major_department_ids)) {
                DB::table('visa_clearances')->where('passport_id', $pass_id)
                    ->update(['payroll_status' =>'1','payroll_remarks'=>$remarks]);
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
            else if (in_array('3', $department->major_department_ids)) {
                DB::table('visa_clearances')->where('passport_id', $pass_id)
                    ->update(['operation_status' =>'1','operation_remarks'=>$remarks]);

                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            } else if (in_array('4', $department->major_department_ids)) {
                DB::table('visa_clearances')->where('passport_id', $pass_id)
                    ->update(['maintenance_status' =>'1','maintenance_remarks'=>$remarks]);
                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            } else if (in_array('5', $department->major_department_ids))
            {
                DB::table('visa_clearances')->where('passport_id', $pass_id)
                    ->update(['pro_status' =>'1','pro_remarks'=>$remarks]);

                $object= new LabourCardCancel();
                $object->passport_id = $pass_id;
                $object->cancallation_id = $clear_id;
                $object->status = '0';



                $message = [
                    'message' => 'Cleared Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
        }
    }


    public function autocomplete_cancel(Request $request)
    {
        $search_text = $request->get('query');
        $puid_data=null;
        $passport_data=null;
        $full_data=null;
        $gamer=array();

        $canclled=VisaCancallation::all();

        foreach ($canclled as $can){
            $gamer = array(
            "passport_id"=>$can->passport_id,
        );

        }
//        $passport=Passport::whereNotIn('id',$gamer)->get();
        $passport_data =Passport::select('passports.passport_no','passports.id','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereNotIn('passports.id',$gamer)
            ->get();


        if (count($passport_data)=='0')
        {
            $gamer=array();
            $canclled=VisaCancallation::all();

            foreach ($canclled as $can){
                $gamer = array(
                    "passport_id"=>$can->passport_id,
                );

            }
            $puid_data =Passport::select('passports.pp_uid','passports.id','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereNotIn('passports.id',$gamer)
                ->get();



            if (count($puid_data)=='0'){
                $gamer=array();
                $canclled=VisaCancallation::all();

                foreach ($canclled as $can){
                    $gamer = array(
                        "passport_id"=>$can->passport_id,
                    );

                }
                $full_data =Passport::select('passport_additional_info.full_name','passport_additional_info.passport_id','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                     ->whereNotIn('passport_additional_info.passport_id',$gamer)
                    ->get();

                if (count($full_data)=='0'){
                    $canclled=VisaCancallation::all();
                    $gamer=array();
                    foreach ($canclled as $can){
                        $gamer = array(
                            "passport_id"=>$can->passport_id,
                        );

                    }
                    $zds_data =Passport::select('user_codes.zds_code','user_codes.passport_id','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->whereNotIn('user_codes.passport_id',$gamer)
                        ->get();
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(

                            'name' => $pass->zds_code,
                            'passport_id' => $pass->passport_id,
                            'passport' => $pass->passport_no,
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
                        'passport_id' => $pass->passport_id,
                        'passport' => $pass->passport_no,
                        'ppuid' => $pass->pp_uid,
                        'zds_code' => $pass->zds_code,
                        'type'=>'2',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);

            }
            //first response

            $pass_array=array();
            foreach ($puid_data as $pass){
                $gamer = array(
                    'passport_id' => $pass->id,
                    'name' => $pass->pp_uid,
                    'passport' => $pass->passport_no,
                    'full_name' => $pass->full_name,
                    'zds_code' => $pass->zds_code,
                    'type'=>'1',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);
        }


//first response
        $pass_array=array();
        foreach ($passport_data as $pass){
            $gamer = array(
                'passport_id' => $pass->id,
                'name' => $pass->passport_no,
                'ppuid' => $pass->pp_uid,
                'full_name' => $pass->full_name,
                'zds_code' => $pass->zds_code,
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }



            public function visa_cancel_sheet(Request $request){
                if (!file_exists('../public/assets/upload/visa_cancel/')) {
                    mkdir('../public/assets/upload/visa_cancel/', 0777, true);
                }
                $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;
                move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/visa_cancel/' . $file_name);
                $file_path = '/assets/upload/visa_cancel/' . $file_name;
//                DB::table('visa_cancallations')->where('id', $request->id)
//                    ->update(['upload_path' =>$file_path,'approval_status'=>'1']);
//
//                $message = [
//                    'message' => 'Uploaded Successfully',
//                    'alert-type' => 'success'
//                ];

                $obj = VisaCancallation::find($request->id);
                $obj->approval_status = 1;
                $obj->upload_path = $file_path;
                $obj->save();
                $users= User::select('*')
                    ->where('major_department_ids', 'LIKE', '%1%')
                    ->orWhere('major_department_ids', 'LIKE', '%3%')
                    ->orWhere('major_department_ids', 'LIKE', '%4%')
                    ->orWhere('major_department_ids', 'LIKE', '%5%')
                    ->get();
                foreach($users as $user){
                    $user->notify(new VisaCencelNotification($obj));
                }
                $options = array(
                    'cluster' => 'ap2',
                    'encrypted' => true
                );
                $pusher = new Pusher(
                    '528cdceee8181ca31807',
                    'ccc70fe7e4c099aff497',
                    '985726',
                    $options
                );
                $pusher->trigger('manage_notification', 'notify-event',"msg");
                $message = [
                    'message' => 'Approved Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }





    public function visa_chat(Request $request)
    {
            $obj= new VisaCancelChat();
            $obj->chat_message=$request->input('chat_message');
            $obj->user_id=$request->input('user_id');
            $obj->cancellation_id=$request->input('cancel_id');
            $obj->save();
            return "success";
    }
    public function getMessageData( Request  $request){
        $chatData = VisaCancelChat::where('cancellation_id',$request->cancel_id)->get()->sortByDesc("created_at");;
        $view = view("admin-panel.visa-master.ajax_visa_chat",compact( 'chatData'))->render();
        return response()->json(['html'=>$view]);

//        return json_encode(array('data'=>$chatData));
    }


    //all the visa process completed
    public function completed_visa_process(){
//name is email id handover but actually it is emirates id handover
// $accepted=VisaCancelRequest::where('status','3')->pluck('id')->get();
// anas

        $status=VisaCancellationStatus::pluck('passport_id')->toArray();
        $passports=VisaCancelRequest::whereNotIn('passport_id',$status)->where('status','3')->get();



        // $pass_ids=UniqueEmailIdHandover::pluck('passport_id')->toArray();
        // $passports=Passport::whereIn('id',$pass_ids)->get();

        $pass_array=array();
        foreach ($passports as $pass){
            $req=VisaCancelRequest::where('passport_id',$pass->id)->where('status','3')->first();
            // if($req==null){
            //     $visa_req='1';
            // }
            // else{
            //     $visa_req='2';
            // }
            // $status=VisaCancellationStatus::where('passport_id',$pass->id)->first();


            // if(!isset($status)){
            $gamer = array(
                'passport_id' => $pass->id,
                'name' => $pass->passport->personal_info->full_name,
                'passport_no' => $pass->passport->passport_no,
                'ppuid' => $pass->passport->pp_uid,
                // 'req' => $visa_req,
            );
            $pass_array[]= $gamer;
        // }
    }
// dd($pass_array);
        return view('admin-panel.visa-master.cancel_visa.all_compete_visa_list',compact('pass_array'));
    }


    public function cancel_visa(){

        return view('admin-panel.visa-master.cancel_visa.index');

    }

    public function cancel_between(Request $request){

        $passport_id=$request->id;
        $user_id=auth()->user()->id;
        $visa_process_step_id=$request->step;
        $remarks=VisaCancelRequest::where('passport_id',$passport_id)->where('status','1')->first();

        $between=BetweenVisaCancel::where('passport_id',$passport_id)->where('visa_process_id',$visa_process_step_id)->first();
        $payment_type=PaymentType::all();

        $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.between_cancel_form", compact('remarks','payment_type','between','passport_id','user_id','visa_process_step_id'))->render();
        return response()->json(['html' => $view]);
    }

    public function between_cancel_save(Request $request){

            foreach($request->file('visa_cancel_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath ='/assets/upload/visa_cencel/between_cancel/'.$name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }

        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file3)
            {
                $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
                $filePath2 = '/assets/upload/visa_cencel/between_cancel/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file3));
                $data2[] = $name2;
            }
        }
        $passport_id= $request->input('passport_id');
        $obj = new BetweenVisaCancel();
        $obj->passport_id = $request->input('passport_id');
        $obj->visa_process_id = $request->input('visa_process_id');
        $obj->payment_amount = $request->input('payment_amount');
        $obj->payment_type = $request->input('payment_type');
        $obj->transaction_number = $request->input('transaction_no');
        $obj->transaction_date = $request->input('transaction_date');
        $obj->vat = $request->input('vat');

        if(isset($data)){
            $obj->attachment = json_encode($data);
        }
        if(isset($data2)){
            $obj->other_attachment = json_encode($data2);
        }
        $obj->save();

        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
        ]);

        }



    public function cancel_visa_process_names(Request $request){


        $passport=Passport::where('passport_no',$request->keyword)->first();
        $com_visa=UniqueEmailIdHandover::where('passport_id',$passport->id)->first();
        $req=VisaCancelRequest::where('passport_id',$passport->id)->where('status','3')->first();
        if($req==null){
            $request_can='1';
        }else{
            $request_can='0';
        }

        // // if($com_visa==null){
        // //     $visa_remarks='1';

        // // }
        // else{
        //     $visa_remarks='2';
        // }


        $passport_id=$passport->id;
        $name=$passport->personal_info->full_name;
        $ppuid=$passport->pp_uid;
        $passport_no=$passport->passport_no;
        $image=isset($passport->profile->image)?$passport->profile->image:'';

        $expiry_date=$passport->date_expiry;

        if($expiry_date==null){
            $remain_days='Passport expiry date is not available';
        }
        else{
            $curr_date=date('Y-m-d');
            $date1 = strtotime($curr_date);
            $date2 = strtotime($expiry_date);
            $diff = abs($date2 - $date1);

            $years = floor($diff / (365*60*60*24));

            $months = floor(($diff - $years * 365*60*60*24)
                / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 -
                    $months*30*60*60*24)/ (60*60*24));

            $remain_days= $years." years ".$months." months ".$days." days";
        }

        $visa_cancel_typing=VisaCancellationTyping::where('passport_id',$passport->id)->first();
        $visa_cancel_sub=VisaCancellationSubmission::where('passport_id',$passport->id)->first();
        $visa_cancel=VisaCancellation::where('passport_id',$passport->id)->first();
        $visa_cancel_approval=VisaCancellationApproval::where('passport_id',$passport->id)->first();
        $visa_cancel_decline=VisaCancellationDecline::where('passport_id',$passport->id)->first();

        $current_status=VisaCancellationStatus::where('passport_id',$passport->id)->latest()->first();
       if($current_status != null){
        $next_status_value=$current_status->current_status;
        $next_status=$next_status_value+1;
       }
       else{
           $next_status='0';
       }





        $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.get_cancel_visa_names",
         compact('passport_id','name','ppuid','passport_no','remain_days','image','visa_cancel_typing','visa_cancel_sub','visa_cancel'
         ,'visa_cancel_approval','visa_cancel_decline','next_status','request_can'))->render();
    return response()->json(['html' => $view]);


    }

    public function cancel_visa_contract_typing(Request $request){
        $id=$request->id;
        $cancel_typing=VisaCancellationTyping::where('passport_id',$id)->first();
        $cancel_typing_pay=VisaCancelPayment::where('passport_id',$id)->where('step_id','1')->first();
        $payment_type=PaymentType::all();


        $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.cancel_visa_cancel_type",
        compact('cancel_typing','payment_type','id','cancel_typing_pay'))->render();
        return response()->json(['html' => $view]);
    }
    //
public function renewcancel_typing_save(Request $request){


    if($request->hasfile('renew_visa_attachment'))
    {
        foreach($request->file('renew_visa_attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/visa_cencel/contract_typing/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }
    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/visa_cencel/contract_typing/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $passport_id= $request->input('passport_id');
    $obj = new VisaCancellationTyping();
    $obj->passport_id = $request->input('passport_id');
    $obj->cancel_date = $request->input('cancel_date');
    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    $obj->save();
    if($request->input('payment_option')!=null){
        $obj2= new VisaCancelPayment();
        $obj2->passport_id = $request->input('passport_id');
        $obj2->payment_amount = $request->input('payment_amount');
        $obj2->payment_type = $request->input('payment_type');
        $obj2->transaction_no = $request->input('transaction_no');
        $obj2->transaction_date = $request->input('transaction_date');
        $obj2->vat = $request->input('vat');
        $obj2->step_id = "1";

        if(isset($data2)){
            $obj2->other_attachment = json_encode($data2);
        }
        $obj2->save();
    }







    //add current status , first time status will be added. after that status will bee updated

    $object = new VisaCancellationStatus();
    $object->passport_id = $request->input('passport_id');
    $object->current_status = '1';
    $object->save();


    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
    return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
]);
}


public function cancel_visa_contract_sub(Request $request){
    $id=$request->id;
    $cancel_sub=VisaCancellationSubmission::where('passport_id',$id)->first();
    $cancel_sub_pay=VisaCancelPayment::where('passport_id',$id)->where('step_id','2')->first();
    $payment_type=PaymentType::all();

    $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.cencel_visa_cancel_sub",
    compact('cancel_sub','payment_type','id','cancel_sub_pay'))->render();
    return response()->json(['html' => $view]);
}
public function renewcancel_sub_save(Request $request){
if($request->hasfile('renew_visa_attachment'))
{
    foreach($request->file('renew_visa_attachment') as $file)
    {
        $name =rand(100,100000).'.'.time().'.'.$file->extension();
        $filePath ='/assets/upload/visa_cencel/contract_sub/'.$name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));
        $data[] = $name;
    }
}
if($request->hasfile('file_name'))
{
    foreach($request->file('file_name') as $file3)
    {
        $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
        $filePath2 = '/assets/upload/visa_cencel/contract_sub/other_attachments/' . $name2;
        Storage::disk('s3')->put($filePath2, file_get_contents($file3));
        $data2[] = $name2;
    }
}
    $passport_id= $request->input('passport_id');
    $obj = new VisaCancellationSubmission();
    $obj->passport_id = $request->input('passport_id');
    $obj->cancel_date = $request->input('cancel_date');
    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    $obj->save();
    if($request->input('payment_option')!=null){
    $obj2= new VisaCancelPayment();
    $obj2->passport_id = $request->input('passport_id');
    $obj2->payment_amount = $request->input('payment_amount');
    $obj2->payment_type = $request->input('payment_type');
    $obj2->transaction_no = $request->input('transaction_no');
    $obj2->transaction_date = $request->input('transaction_date');
    $obj2->vat = $request->input('vat');
    $obj2->step_id = "2";

    if(isset($data2)){
        $obj2->other_attachment = json_encode($data2);
    }
    $obj2->save();
}


    $current_status = DB::table('visa_cancellation_statuses')->where('passport_id',$passport_id)->latest()->first();
    DB::table('visa_cancellation_statuses')->where('id', $current_status->id)
        ->update(['current_status' => '2']);


        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
        ]);

}
public function cancel_visa_contract(Request $request){
    $id=$request->id;
    $cancel_cancel =VisaCancellation::where('passport_id',$id)->first();
    $cancel_cancel_pay=VisaCancelPayment::where('passport_id',$id)->where('step_id','3')->first();


    $payment_type=PaymentType::all();


    $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.cancel_visa_cancallation",
    compact('cancel_cancel','payment_type','id','cancel_cancel_pay'))->render();
    return response()->json(['html' => $view]);
}
public function renewcancel_cancel_save(Request $request){
    if($request->hasfile('renew_visa_attachment'))
    {
        foreach($request->file('renew_visa_attachment') as $file)
        {
            $name =rand(100,100000).'.'.time().'.'.$file->extension();
            $filePath ='/assets/upload/visa_cencel/contract_cancel/'.$name;
            Storage::disk('s3')->put($filePath, file_get_contents($file));
            $data[] = $name;
        }
    }
    if($request->hasfile('file_name'))
    {
        foreach($request->file('file_name') as $file3)
        {
            $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
            $filePath2 = '/assets/upload/visa_cencel/contract_cancel/other_attachments/' . $name2;
            Storage::disk('s3')->put($filePath2, file_get_contents($file3));
            $data2[] = $name2;
        }
    }
    $passport_id= $request->input('passport_id');
    $obj = new VisaCancellation();
    $obj->passport_id = $request->input('passport_id');
    $obj->cancel_date = $request->input('cancel_date');
    if(isset($data)){
        $obj->attachment = json_encode($data);
    }
    $obj->save();
    if($request->input('payment_option')!=null){
    $obj2= new VisaCancelPayment();
    $obj2->passport_id = $request->input('passport_id');
    $obj2->payment_amount = $request->input('payment_amount');
    $obj2->payment_type = $request->input('payment_type');
    $obj2->transaction_no = $request->input('transaction_no');
    $obj2->transaction_date = $request->input('transaction_date');
    $obj2->vat = $request->input('vat');
    $obj2->step_id = "3";

    if(isset($data2)){
        $obj2->other_attachment = json_encode($data2);
    }
    $obj2->save();
}



    $current_status = DB::table('visa_cancellation_statuses')->where('passport_id',$passport_id)->latest()->first();
    DB::table('visa_cancellation_statuses')
    ->where('id', $current_status->id)
        ->update(['current_status' => '3']);
    $passport_id= $request->input('passport_id');
    $passport=Passport::where('id',$passport_id)->first();
    $pass_no=$passport->passport_no;
    return response()->json([
    'code' => "100",
    'passport_no'=>$pass_no
    ]);

    }

    public function cancel_visa_approval(Request $request){

        $id=$request->id;
        $cancel_approval=VisaCancellationApproval::where('passport_id',$id)->first();
        $cancel_approval_pay=VisaCancelPayment::where('passport_id',$id)->where('step_id','4')->first();

        $payment_type=PaymentType::all();

        $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.cancel_visa_approval",
        compact('cancel_approval','payment_type','id','cancel_approval_pay'))->render();
        return response()->json(['html' => $view]);
    }

    public function cancel_visa_approcal_save(Request $request){

        if($request->hasfile('renew_visa_attachment'))
        {
            foreach($request->file('renew_visa_attachment') as $file)
            {
                $name =rand(100,100000).'.'.time().'.'.$file->extension();
                $filePath ='/assets/upload/visa_cencel/visa_cancel_approval/'.$name;
                Storage::disk('s3')->put($filePath, file_get_contents($file));
                $data[] = $name;
            }
        }
        if($request->hasfile('file_name'))
        {
            foreach($request->file('file_name') as $file3)
            {
                $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
                $filePath2 = '/assets/upload/visa_cencel/visa_cancel_approval/other_attachments/' . $name2;
                Storage::disk('s3')->put($filePath2, file_get_contents($file3));
                $data2[] = $name2;
            }
        }
        $passport_id= $request->input('passport_id');
        $obj = new VisaCancellationApproval();

        $obj->passport_id = $request->input('passport_id');
        $obj->decline_status = $request->input('decline_status');
        $obj->remarks = $request->input('remarks');
        $obj->cancel_date = $request->input('cancel_date');
        if(isset($data)){
            $obj->attachment = json_encode($data);
        }
        $obj->save();
        if($request->input('payment_option')!=null){
        $obj2= new VisaCancelPayment();
        $obj2->passport_id = $request->input('passport_id');
        $obj2->payment_amount = $request->input('payment_amount');
        $obj2->payment_type = $request->input('payment_type');
        $obj2->transaction_no = $request->input('transaction_no');
        $obj2->transaction_date = $request->input('transaction_date');
        $obj2->vat = $request->input('vat');
        $obj2->step_id ="4";

        if(isset($data2)){
            $obj2->other_attachment = json_encode($data2);
        }
        $obj2->save();
    }



        $current_status = DB::table('visa_cancellation_statuses')->where('passport_id',$passport_id)->latest()->first();
         DB::table('visa_cancellation_statuses')->where('id', $current_status->id)
        ->update(['current_status' => '4']);
        $passport_id= $request->input('passport_id');
        $passport=Passport::where('id',$passport_id)->first();
        $pass_no=$passport->passport_no;
        return response()->json([
        'code' => "100",
        'passport_no'=>$pass_no
        ]);

        }

        public function cancel_visa_decline(Request $request){
            $id=$request->id;
            $cancel_decline=VisaCancellationDecline::where('passport_id',$id)->first();
            $cancel_approval=VisaCancellationApproval::where('passport_id',$id)->first();
            $payment_type=PaymentType::all();
            $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.cancel_visa_decline",
            compact('cancel_decline','cancel_approval','payment_type','id'))->render();
            return response()->json(['html' => $view]);
        }



        public function cancel_visa_decline_save(Request $request){
            if($request->hasfile('renew_visa_attachment'))
            {
                foreach($request->file('renew_visa_attachment') as $file)
                {
                    $name =rand(100,100000).'.'.time().'.'.$file->extension();
                    $filePath ='/assets/upload/visa_cencel/visa_cancel_decline/'.$name;
                    Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }
            if($request->hasfile('file_name'))
            {
                foreach($request->file('file_name') as $file3)
                {
                    $name2 =rand(100,200000).'.'.time().'.'.$file3->extension();
                    $filePath2 = '/assets/upload/visa_cencel/visa_cancel_decline/other_attachments/' . $name2;
                    Storage::disk('s3')->put($filePath2, file_get_contents($file3));
                    $data2[] = $name2;
                }
            }
            $passport_id= $request->input('passport_id');
            $obj = new VisaCancellationDecline();
            $obj->passport_id = $request->input('passport_id');
            $obj->decline_status = $request->input('decline_status');
            $obj->payment_amount = $request->input('payment_amount');
            $obj->payment_type = $request->input('payment_type');
            $obj->transaction_no = $request->input('transaction_no');
            $obj->transaction_date = $request->input('transaction_date');
            $obj->vat = $request->input('vat');
            if(isset($data)){
                $obj->attachment = json_encode($data);
            }
            if(isset($data2)){
                $obj->other_attachment = json_encode($data2);
            }
            $obj->save();

            $current_status = DB::table('visa_cancellation_statuses')
            ->where('passport_id',$passport_id)->latest()->first();
            DB::table('visa_cancellation_statuses')->where('id', $current_status->id)
                    ->update(['current_status' => '5']);
            $passport_id= $request->input('passport_id');
            $passport=Passport::where('id',$passport_id)->first();
            $pass_no=$passport->passport_no;
            return response()->json([
            'code' => "100",
            'passport_no'=>$pass_no
            ]);

            }

            public function all_cancelled_visa(){

                $between=BetweenVisaCancel::where('status','1')->get();
                $compelete=VisaCancellationStatus::all();
                // dd($between);
                return view('admin-panel.visa-master.cancel_visa.reports.all_cancelled',compact('between','compelete'));


            }

            public function visa_cancel_complete(){



                $visa_can=VisaCancellationStatus::where('current_status','1')->pluck('passport_id')->toArray();


                $visa_cancel_typing=VisaCancellationTyping::whereIn('passport_id',$visa_can)->get();

                $payment_type=PaymentType::all();
                $view = view("admin-panel.visa-master.cancel_visa.reports.ajax_complete_cancel",compact('visa_cancel_typing','payment_type'))->render();
                return response()->json(['html' => $view]);


            }
           public function visa_cancel_submission(){
            $visa_can=VisaCancellationStatus::where('current_status','2')->pluck('passport_id')->toArray();
            $visa_cancel_sub=VisaCancellationSubmission::whereIn('passport_id',$visa_can)->get();
            $payment_type=PaymentType::all();
            $view = view("admin-panel.visa-master.cancel_visa.reports.ajax_visa_cancel_sub",compact('visa_cancel_sub','payment_type'))->render();
            return response()->json(['html' => $view]);
           }

            public function visa_cancel_cancellation_report(){
                $visa_can=VisaCancellationStatus::where('current_status','3')->pluck('passport_id')->toArray();
            $visa_cancel_cancellation=VisaCancellation::whereIn('passport_id',$visa_can)->get();
            $payment_type=PaymentType::all();
            $view = view("admin-panel.visa-master.cancel_visa.reports.ajax_visa_cancel_cancellation",compact('visa_cancel_cancellation','payment_type'))->render();
            return response()->json(['html' => $view]);
        }
        public function visa_cancel_approval(){
            $visa_can=VisaCancellationStatus::where('current_status','4')->pluck('passport_id')->toArray();
            $visa_cancel_app=VisaCancellationApproval::whereIn('passport_id',$visa_can)->get();
            $payment_type=PaymentType::all();
            $view = view("admin-panel.visa-master.cancel_visa.reports.ajax_visa_cancel_approval",compact('visa_cancel_app','payment_type'))->render();
            return response()->json(['html' => $view]);
        }
        public function visa_cancel_decline(){
            $visa_cancel_decline=VisaCancellationDecline::all();
            $payment_type=PaymentType::all();
            $view = view("admin-panel.visa-master.cancel_visa.reports.ajax_visa_cancel_decline",compact('visa_cancel_decline','payment_type'))->render();
            return response()->json(['html' => $view]);
        }



        public function visa_cancel_request(){

            // dd('asdf');
            // dd($between);

            return view('admin-panel.visa-master.cancel_visa.cancel_request');


        }

        public function visa_replacement_request(){
        //this is dc request for replacement
            return view('admin-panel.visa-master.visa_replacement.visa_replacement');
        }
        public function visa_replacement_request_hr(){
            //this is dc request for replacement
                return view('admin-panel.visa-master.visa_replacement.visa_replacement_hr');
            }

            public function visa_replacement_request_pro(){
                //this is dc request for replacement
                    return view('admin-panel.visa-master.visa_replacement.visa_replacement_pro');
                }

        public function cancel_visa_request_get_info(Request $request){


            $passport=Passport::where('passport_no',$request->keyword)->first();
            $passport_id=$passport->id;

            $between=BetweenVisaCancel::where('passport_id',$passport_id)->first();
           $visa_cancel_status = VisaCancellationStatus::where('passport_id',$passport_id)->first();
           $visa_cancel_req = VisaCancelRequest::where('passport_id',$passport_id)->first();
           $visa_status = CurrentStatus::where('passport_id',$passport_id)->first();

            if($between==null){
                $visa_remarks='1';

            }
            else{
                $visa_remarks='2';
            }

            if($visa_cancel_status==null){
                $visa_remarks='3';

            }
            else{
                $visa_remarks='4';
            }
            if($visa_cancel_req==null){
                $visa_remarks='5';
            }
            else{
                $visa_remarks='6';
            }

            if($visa_status==null){
                $visa_remarks='7';
            }



            $passport_id=$passport->id;
            $name=$passport->personal_info->full_name;
            $ppuid=$passport->pp_uid;
            $passport_no=$passport->passport_no;
            $image=isset($passport->profile->image)?$passport->profile->image:'';

            $expiry_date=$passport->date_expiry;

            if($expiry_date==null){
                $remain_days='Passport expiry date is not available';
            }
            else{
                $curr_date=date('Y-m-d');
                $date1 = strtotime($curr_date);
                $date2 = strtotime($expiry_date);
                $diff = abs($date2 - $date1);

                $years = floor($diff / (365*60*60*24));

                $months = floor(($diff - $years * 365*60*60*24)
                    / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 -
                        $months*30*60*60*24)/ (60*60*24));

                $remain_days= $years." years ".$months." months ".$days." days";
            }



            $current_status=VisaCancellationStatus::where('passport_id',$passport_id)->latest()->first();
           if($current_status != null){
            $next_status_value=$current_status->current_status;
            $next_status=$next_status_value+1;
           }
           else{
               $next_status='0';
           }
           $sent_from=$request->sent_from;





            $view = view("admin-panel.visa-master.cancel_visa.cancel_visa_ajax_files.visa_cancel_req",compact('sent_from','name','ppuid','passport_no','remain_days','image','visa_remarks','between','visa_cancel_status','passport_id'))->render();
        return response()->json(['html' => $view]);


        }




        public function visa_cancel_request_hr(){

            // dd('asdf');
            // dd($between);


            return view('admin-panel.visa-master.cancel_visa.visa_cancel_request_hr');


        }
        public function replacement_visa_request_get_info(Request $request){
//check visa between
//visa cancel VisaCancelRequest
//ReplacementRequest
//current status


// $current_status=CurrentStatus::where('passport_id',$passport_id)->first();

// if($current_status!=null){
//     $validation = $current_status->current_process_id;


//     if($validation > 5 && $validation <5){
//         $validation_msg='1';
//     }
//      elseif($validation<5 ){
//         $validation_msg='2';
//     }
//     elseif($validation==28){
//         $validation_msg='5';
//     }
//     else{
//         $validation_msg='4';
//     }
// }
// else{
//     $validation_msg='3';

// }
// $visa_cancel_status = ReplacementRequest::where('passport_id',$passport_id)->first();

// if($visa_cancel_status==null){
//     $visa_remarks='1';

// }
// else{
//     $visa_remarks='2';
// }


            if(isset($request->hr_req)){
                $hr_reqs='1';
            }
            else{
                $hr_reqs=null;
            }

            if(isset($request->pro_req)){
                $pro_req='1';
            }
            else{
                $pro_req=null;
            }


            $validation_remarks=null;

            $passport=Passport::where('passport_no',$request->keyword)->first();
            $passport_id=$passport->id;
            //1
            $between=BetweenVisaCancel::where('passport_id',$passport_id)->first();
            //2
            $visa_cancel_req = VisaCancelRequest::where('passport_id',$passport_id)->first();
            //3
            $replacement_req = ReplacementRequest::where('passport_id',$passport_id)->first();
            //4
            $CurrentStatus = CurrentStatus::where('passport_id',$passport_id)->first();


            //if any of these have data then cencallation/replacement already sent

            if(isset($visa_cancel_req) || isset($replacement_req)){
                    $validation_remarks='1';
                    //cencellation request already sent

            }elseif($CurrentStatus==null){
                $validation_remarks='3';
                //cancellation request already sent
            }
            else{
                $validation_remarks=='2';
                //visa process has not been started yet
            }
            // dd($validation_remarks);






            $passport_id=$passport->id;
            $name=$passport->personal_info->full_name;
            $ppuid=$passport->pp_uid;
            $passport_no=$passport->passport_no;
            $image=isset($passport->profile->image)?$passport->profile->image:'';

            $expiry_date=$passport->date_expiry;

            if($expiry_date==null){
                $remain_days='Passport expiry date is not available';
            }
            else{
                $curr_date=date('Y-m-d');
                $date1 = strtotime($curr_date);
                $date2 = strtotime($expiry_date);
                $diff = abs($date2 - $date1);

                $years = floor($diff / (365*60*60*24));

                $months = floor(($diff - $years * 365*60*60*24)
                    / (30*60*60*24));
                $days = floor(($diff - $years * 365*60*60*24 -
                        $months*30*60*60*24)/ (60*60*24));

                $remain_days= $years." years ".$months." months ".$days." days";
            }



            $current_status=VisaCancellationStatus::where('passport_id',$passport_id)->latest()->first();
           if($current_status != null){
            $next_status_value=$current_status->current_status;
            $next_status=$next_status_value+1;
           }
           else{
               $next_status='0';
           }
           $sent_from=$request->sent_from;

        // dd($validation_msg);



            $view = view("admin-panel.visa-master.visa_replacement.ajax_replacement",compact('pro_req','validation_remarks','sent_from','name','ppuid','passport_no'
            ,'remain_days','image','between','passport_id','hr_reqs'))->render();
        return response()->json(['html' => $view]);


        }

        public function repacement_request_save(Request $request){

            $user_id=Auth::user()->id;
            $passport_id= $request->input('passport_id');
            $passport=Passport::where('id',$passport_id)->first();
            $pass_no=$passport->passport_no;
            if($request->hr_req==null){
                $hr_req='0';
            }
            else{
                $hr_req=$request->input('hr_req');
            }

            if($request->pro_req==null){
                $pro_req='0';
            }
            else{
                $pro_req=$request->input('pro_req');
            }



            //if current status<= 5 or cs ==28
                //----------save the data in replacemen
            //else save the data in cance;
        $current_status_table= CurrentStatus::where('passport_id',$passport_id)->first();
        $current_status=$current_status_table->current_process_id;

            if($current_status<=5 || $current_status==28){
                $obj = new ReplacementRequest();
                $obj->passport_id = $request->input('passport_id');
                $obj->requested_by = $user_id;
                $obj->remarks = $request->input('remarks');
                $obj->hr_reqest = $hr_req;
                $obj->pro_req = $pro_req;


                $obj->save();

                    return response()->json([
                        'code' => "100",
                        'passport_no'=>$pass_no
                        ]);
            }
            else{

                $obj = new VisaCancelRequest();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->requsted_by = $user_id;
                    $obj->remarks = $request->input('remarks');
                    $obj->status = '1';
                    $obj->hr_reqest =$hr_req;
                    $obj->pro_req =$pro_req;
                    $obj->save();

                        return response()->json([
                            'code' => "100",
                            'passport_no'=>$pass_no
                            ]);

            }


                return response()->json([
                    'code' => "102",
                    'passport_no'=>$pass_no
                    ]);


    }

        public function cancel_request_save(Request $request){

                $user_id=Auth::user()->id;
                $passport_id= $request->input('passport_id');
                $passport=Passport::where('id',$passport_id)->first();
                $pass_no=$passport->passport_no;


                $visa_cancel = VisaCancelRequest::where('passport_id',$request->passport_id)->count();
                if($visa_cancel != 0){
                    return response()->json([
                        'code' => "102",
                        'passport_no'=>$pass_no
                        ]);
                }
                $obj = new VisaCancelRequest();
                    $obj->passport_id = $request->input('passport_id');
                    $obj->requsted_by = $user_id;
                    $obj->remarks = $request->input('remarks');
                    $obj->status = '1';
                    $obj->hr_reqest = $request->hr_reqest;
                    $obj->save();

                        return response()->json([
                            'code' => "100",
                            'passport_no'=>$pass_no
                            ]);
        }

        public function all_cancel_requests(){
            $req=VisaCancelRequest::where('status','1')->get();
            $remove=VisaCancelRequest::where('status','2')->get();
            return view('admin-panel.visa-master.cancel_visa.all_cancel_req',compact('req','remove'));
        }

        public function all_cancel_requests_to_dc(){
            //take the ids of all dcs under this managers
            //if dcs falls under this manager. show him the cancels requests
            $user_id=Auth::user()->id;
            $managers_dc= Manager_users::where('manager_user_id',$user_id)->pluck('member_user_id')->toArray();
            $req=VisaCancelRequest::where('status','1')->whereIn('requsted_by',$managers_dc)->get();
            $acc=VisaCancelRequest::where('status','3')->whereIn('requsted_by',$managers_dc)->get();

            return view('admin-panel.visa-master.cancel_visa.dc_manager_req',compact('req','acc'));
        }
        public function all_cancel_requests_to_pro(){
            //take the ids of all dcs under this managers
            //if dcs falls under this manager. show him the cancels requests

            $acc=VisaCancelRequest::where('status','3')->get();



            return view('admin-panel.visa-master.cancel_visa.visa_cancel_req_pro',compact('acc'));
        }
        public function hr_to_pro(){
            $acc=VisaCancelRequest::where('hr_reqest','1')->where('status','1')->get();
            $view = view("admin-panel.visa-master.cancel_visa.reports.ajax_hr_to_pro",compact('acc'))->render();
            return response()->json(['html' => $view]);


        }
        public function hr_to_pro_replacement(){
            $acc=ReplacementRequest ::where('hr_reqest','1')->where('status','0')->get();

            $view = view("admin-panel.visa-master.visa_replacement.replace_hr_to_pro",compact('acc'))->render();
            return response()->json(['html' => $view]);

        }






        public function cancel_request_accept($id){
            $user_id=Auth::user()->id;

            DB::table('visa_cancel_requests')->where('id', $id)
            ->update(['status' => '3','accepted_by'=> $user_id]);

            $message = [
                'message' => 'Cancel Visa Request Accepted Successfully',
                'alert-type' => 'success',

            ];
            return redirect()->back()->with($message);

        }

        public function replacement_request_accept($id){
            $user_id=Auth::user()->id;

            DB::table('replacement_requests')->where('id', $id)
            ->update(['status' => '1']);

            $message = [
                'message' => 'Visa Replacemenent Accepted Successfully',
                'alert-type' => 'success',

            ];
            return redirect()->back()->with($message);

        }




        public function cancel_request_revoke($id){


            DB::table('visa_cancel_requests')->where('id', $id)
            ->update(['status' => '2']);

            $message = [
                'message' => 'Cancel Visa Request Removed Successfully',
                'alert-type' => 'success',

            ];
            return redirect()->back()->with($message);

        }

        public function autocomplete_cancels(Request $request){
            //if rider has a dc then dc will send the request
            //if dc checked out then last checked out dc
            //if dc was never assigned or a fresh rider then hr team will do the visa cancel request

            $user_id=Auth::user()->id;


            $rider_assigned_to_dc=AssignToDc::where('user_id',$user_id)->latest('updated_at')->pluck('rider_passport_id')->toArray();
            // dd($rider_assigned_to_dc);

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->whereIn('passports.id',$rider_assigned_to_dc)
                ->get();

            if (count($passport_data)=='0')
            {
                $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                    ->whereIn('passports.id',$rider_assigned_to_dc)
                    ->get();
                if (count($puid_data)=='0')
                {
                    $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                        ->whereIn('passports.id',$rider_assigned_to_dc)
                        ->get();


                    //full name response
                    $pass_array=array();
                    foreach ($full_data as $pass){
                        $gamer = array(
                            'name' => $pass->full_name,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'zds_code' => $pass->zds_code,
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
                        'zds_code' => $pass->zds_code,
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
                'zds_code' => $pass->zds_code,
                'type'=>'0',
            );
            $pass_array[]= $gamer;
            }
            return response()->json($pass_array);
        }
        public function autocomplete_cancels_hr(Request $request){
            //if rider has a dc then dc will send the request
            //if dc checked out then last checked out dc
            //if dc was never assigned or a fresh rider then hr team will do the visa cancel request

            // $user_id=Auth::user()->id;


            // $rider_assigned_to_dc=AssignToDc::pluck('rider_passport_id')->toArray();
            // $fresh_pass=Passport::whereNotIn('id',$rider_assigned_to_dc)->pluck('id')->toArray();



            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->get();

            if (count($passport_data)=='0')
            {
                $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($puid_data)=='0')
                {
                    $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                        ->get();

                    //full name response
                    $pass_array=array();
                    foreach ($full_data as $pass){
                        $gamer = array(
                            'name' => $pass->full_name,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'zds_code' => $pass->zds_code,
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
                        'zds_code' => $pass->zds_code,
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
                'zds_code' => $pass->zds_code,
                'type'=>'0',
            );
            $pass_array[]= $gamer;
            }
            return response()->json($pass_array);

        }

        public function replacement_visa_requests(){
            //take the ids of all dcs under this managers
            //if dcs falls under this manager. show him the cancels requests

            $acc=ReplacementRequest ::where('status','0')->where('hr_reqest','0')->get();

            return view('admin-panel.visa-master.visa_replacement.replacement_requests',compact('acc'));
        }

        public function accpeted_replacement_requests(){
            $acc=ReplacementRequest ::where('status','1')->get();

            $view = view("admin-panel.visa-master.visa_replacement.replacement_accepted",compact('acc'))->render();
            return response()->json(['html' => $view]);
        }

        public function pro_replacement_requests(){
            $acc=ReplacementRequest ::where('status','0')->where('pro_req','1')->get();

            $view = view("admin-panel.visa-master.visa_replacement.replacement_pro",compact('acc'))->render();
            return response()->json(['html' => $view]);
        }

}
