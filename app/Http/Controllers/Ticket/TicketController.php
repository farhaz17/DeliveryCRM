<?php

namespace App\Http\Controllers\Ticket;

use App\Events\Notify;
use App\Mail\TicketMail;
use App\Model\Departments;
use App\Model\Platform;
use App\Model\Ticket;
use App\Http\Controllers\Controller;
use App\Model\Ticket_assign_logs\Ticket_assign_logs;
use App\Model\TicketActivity;

use App\Model\TicketMessage;
use App\Model\TicketShare;
use App\Notifications\TicketReplies;
use App\User;
use Faker\Provider\File;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\FcmToken;
use App\Model\Notification;
use Intervention\Image\Facades\Image;
use Pusher\Pusher;
use Images;
use Illuminate\Support\Facades\Storage;


class TicketController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|operation-manage-ticket', ['only' => ['index','edit','destroy','update','store']]);
        $this->middleware('role_or_permission:Admin|operation-approve-ticket', ['only' => ['approve_tickets']]);
        $this->middleware('role_or_permission:Admin|operation-shared-ticket', ['only' => ['ticket_share']]);
        $this->middleware('role_or_permission:Admin|ticket-approve-tickets-teamlead', ['only' => ['approve_tickets_teamlead']]);
        $this->middleware('role_or_permission:Admin|ticket-approve-tickets-manager', ['only' => ['approve_tickets_manager']]);

    }

    public function index(){
        $admin_tickets = Ticket::with(
            [
                'user_ticket.profile_ticket.passport_ticket.personal_info_ticket',
                'platform_',
                'department',
                'closed_name'
            ])
        ->orderBy('id', 'desc')
        ->get();
        // $departments = Departments::all();
        $issue_ids = Departments::whereIn('major_dept_id',auth()->user()->major_department_ids)->get();
        $users_new_array = array();
        foreach ($issue_ids as $abs){ $users_new_array [] = $abs->id; }
        $tickets = Ticket::with(['user_ticket.profile_ticket.passport_ticket.personal_info_ticket', 'platform_', 'department', 'closed_name'])
        ->orderBy('id', 'desc')
        ->where(function ($query){
                $query->whereIn('platform', auth()->user()->user_platform_id);
            })
        ->where(function($query) use ($users_new_array){
                $query
                    ->whereIn('department_id',$users_new_array)
                    ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id ? auth()->user()->user_issue_dep_id : array() )
                    ->orwhereHas('ticket_activity', function($query) use($users_new_array){
                        $query->whereIn('assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array());
                    });
            })
        ->get();
        $ticketshare_array = TicketShare::where('sent_by','=',Auth::user()->id)->pluck('ticket_id')->toArray();
        $ticketshare = Ticket::whereIn('id',$ticketshare_array)->get();
        return view('admin-panel.ticket.queries',compact('ticketshare','tickets','admin_tickets'));
    }

    public  function approve_tickets(){

        $pending_tickets = Ticket::where('is_approved','=','7')
            ->orderBy('is_approved', 'desc')
            ->get();
        $pending_logs = Ticket_assign_logs::where('type','=','Assigned By Manager')->get();


        $aproved_tickets = Ticket::where('is_approved','=','8')
            ->orderBy('is_approved', 'desc')
            ->get();
        $approved_logs = Ticket_assign_logs::where('type','=','Approved By Management')->get();

        $rejected_tickets = Ticket::where('is_approved','=','9')
            ->orderBy('is_approved', 'desc')
            ->get();
        $rejected_logs  = Ticket_assign_logs::where('type','=','Rejected By Management')->get();

      $array_status = array('Pending','Closed','In Process','Rejected');


        return view('admin-panel.ticket.approve_ticket',compact('pending_tickets',
            'aproved_tickets','rejected_tickets','array_status','pending_logs','approved_logs','rejected_logs'));

    }

    public  function  approve_tickets_teamlead(){

        $admin_tickets = Ticket::select('*')
            ->where('is_approved','!=','0')
            ->where('is_approved','<=','3')
            ->orderBy('is_approved', 'desc')
            ->get();



        $pending_tickets = Ticket::where('is_approved','=','1')
                                    ->orderBy('is_approved', 'desc')
                                    ->get();
        $pending_logs = Ticket_assign_logs::where('type','=','Assigned By Employee')->get();


        $aproved_tickets = Ticket::where('is_approved','=','2')
                                ->orderBy('is_approved', 'desc')
                                ->get();
        $approved_logs = Ticket_assign_logs::where('type','=','Approved By TeamLeader')->get();


        $rejected_tickets = Ticket::where('is_approved','=','3')
                            ->orderBy('is_approved', 'desc')
                            ->get();

       $rejected_logs = Ticket_assign_logs::where('type','=','Rejected By TeamLeader')->get();



        $assign_manager = Ticket::where('is_approved','=','4')
                            ->orderBy('is_approved', 'desc')
                            ->get();
        $assign_manager_logs = Ticket_assign_logs::where('type','=','Assigned By TeamLeader')->get();


        $array_status = array('Pending','Closed','In Process','Rejected');

 return view('admin-panel.ticket.teamlead_approve_ticket',compact('admin_tickets','pending_tickets',
    'aproved_tickets','rejected_tickets','assign_manager','array_status','pending_logs','approved_logs','rejected_logs','assign_manager_logs'));


    }

    public function get_ticket_chat(Request $request){

        $ticke_info = Ticket::find($request->ticket_id);

        $array_status = array('Pending','Closed','In Process','Rejected');

        $id = $request->ticket_id;
        $ticket_messages_public = TicketMessage::where('ticket_id',$id)->where('category','=','2')->get();
        $ticket_messages_private = TicketMessage::where('ticket_id',$id)->where('category','=','1')->get();

        if($request->type=="team"){
            $view = view("admin-panel.ticket.get_ajax_chat_history",compact('ticket_messages_private','ticket_messages_public','ticke_info','array_status'))->render();
        }elseif($request->type=="manager"){
            $view = view("admin-panel.ticket.manager_get_ajax_chat_history",compact('ticket_messages_private','ticket_messages_public','ticke_info','array_status'))->render();
        }elseif($request->type=="management"){
            $view = view("admin-panel.ticket.management_get_ajax_chat_history",compact('ticket_messages_private','ticket_messages_public','ticke_info','array_status'))->render();
        }


        return response()->json(['html'=>$view]);

    }

    public  function  approve_tickets_manager(){
        $admin_tickets = Ticket::select('*')
            ->where('is_approved','!=','0')
            ->where('is_approved','>=','4')
            ->where('is_approved','<=','6')
            ->orderBy('is_approved', 'asc')
            ->get();


        $pending_tickets = Ticket::where('is_approved','=','4')
            ->orderBy('is_approved', 'desc')
            ->get();

        $pending_logs = Ticket_assign_logs::where('type','=','Assigned By TeamLeader')->get();


        $aproved_tickets = Ticket::where('is_approved','=','5')
            ->orderBy('is_approved', 'desc')
            ->get();
        $approved_logs = Ticket_assign_logs::where('type','=','Approved By Manager')->get();

        $rejected_tickets = Ticket::where('is_approved','=','6')
            ->orderBy('is_approved', 'desc')
            ->get();
        $rejected_logs = Ticket_assign_logs::where('type','=','Rejected By Manager')->get();

        $assign_manager = Ticket::where('is_approved','=','7')
            ->orderBy('is_approved', 'desc')
            ->get();
        $assign_manager_logs = Ticket_assign_logs::where('type','=','Assigned By Manager')->get();



        $array_status = array('Pending','Closed','In Process','Rejected');

        $departments=Departments::all();

        return view('admin-panel.ticket.manager_approve_ticket',compact('admin_tickets','pending_tickets',
            'aproved_tickets','rejected_tickets','assign_manager','array_status',
        'pending_logs','approved_logs','rejected_logs','assign_manager_logs'
        ));
    }



    public function approve_ticket_save(Request $request){

        Ticket::where('id','=',$request->primary_id)->update(['is_approved' =>$request->status]);

        $status_array = array(
            '0',
            'Assigned By Employee',
            'Approved By TeamLeader',
            'Rejected By TeamLeader',
            'Assigned By TeamLeader',
            'Approved By Manager',
            'Rejected By Manager',
            'Assigned By Manager',
            'Approved By Management',
            'Rejected By Management',
        );

          $ticket_log = new Ticket_assign_logs();
        $ticket_log->type = $status_array[$request->status];
        $ticket_log->ticket_id = $request->primary_id;
        $ticket_log->user_id = auth::user()->id;
        $ticket_log->save();

        $message = [
            'alert-type' => 'success',
            'message' => 'Status Has been Updated Successfully'
        ];
        return back()->with($message);

    }



    public function scopeIsActiveShop($query,$users_new_array) {
        return $query->whereIn('department_id', $users_new_array);
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


        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
//        $ticket_id = rand(5120,9999).time();

        $ticket_id = IdGenerator::generate(['table' => 'tickets', 'field' => 'ticket_id',  'length' => 10, 'prefix' => 'TC']);

        try {

            $image=null;
            $voice=null;
            if (!empty($_FILES['image']['name'])) {

                if (!file_exists('./public/assets/upload/tickets/images')) {
                    mkdir('./public/assets/upload/tickets/images', 0777, true);
                }
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], './public/assets/upload/tickets/images/' . $image);
                $image->save();
                $image = '/assets/upload/tickets/images/' . $image;

          }

            if (!empty($_FILES['voice']['name'])) {
                if (!file_exists('./public/assets/upload/tickets/voices')) {
                    mkdir('./public/assets/upload/tickets/voices', 0777, true);
                }
                $ext = pathinfo($_FILES['voice']['name'], PATHINFO_EXTENSION);
                $voice = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["voice"]["tmp_name"], './public/assets/upload/tickets/voices/' . $voice);
                $voice->save();
                $voice = '/assets/upload/tickets/voices/' . $voice;
            }


            $obj = new Ticket();
            $obj->ticket_id = $ticket_id;
            $obj->name = $request->input('name');
            $obj->zdscode = $request->input('zdscode');
            $obj->email = $request->input('email');
            $obj->whatsapp = $request->input('whatsapp');
            $obj->contact = $request->input('contact');
            $obj->platform = $request->input('platform');
            $obj->platform_id = $request->input('platform_id');
            $obj->message = $request->input('message');
            $obj->department_id = $request->input('department_id');
            $image?$obj->image_url = $image:"";
            $voice?$obj->voice_message = $voice:"";
            $obj->save();
            $response['success'] = 1;
            $response['message'] = 'Ticket successfully created.';

            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response['success'] = 2;
            $response['message'] = 'Ticket creation failed frgdgdf';
            return response()->json($response);
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


        try {

            $obj = Ticket::find($id);
            $obj->is_checked = 1;
            $obj->closed_by = Auth::user()->id;
            if(isset($request->is_hide)){
                $obj->is_hide = "1";
            }
            $obj->save();

            $message = [
                'message' => 'Query Checked Successfully',
                'alert-type' => 'success'

            ];

            Mail::to([$obj->user->email])->send(new TicketMail($obj));

            $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj->user_id)->first();

            if(!empty($token)){
                $token  = $token->fcm_token;
                $title = "Ticket Update";
                $body = "Ticket is closed";
                $activity = 'TICKETACTIVITY';
                $notification = new Notification;
                $notification->singleDevice($token,$title,$body,$activity);

            }


            return redirect()->route('ticket')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('ticket')->with($message);
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

//    public function fileDownload($filename){
//        //Suppose profile.docx file is stored under project/public/download/profile.docx
////        $download = 'http://localhost/zone_repair/ticket_app/voices/'. $filename;
////        return response()->download($download);
//
//        return response()->download(url("{$filename}"));
//    }

//    public function fileDownload($filename)
//    {
//        //PDF file is stored under project/public/download/info.pdf
//        $file= public_path(). $filename;
//
//        $headers = array(
//            'Content-Type: audio/mpeg',
//        );
//
//        return Response::download($file, 'voice_note.mp3', $headers);
//    }

    public function getDepartments()
    {

        $response['departments'] = Departments::where('status', '=', 0)->get();
        // $customers = Customer::find($id);
        return response()->json($response);
    }

    public function getPlatforms()
    {

        $response['platforms'] = Platform::all();
        // $customers = Customer::find($id);
        return response()->json($response);
    }

    public function storeTicket(Request $request)
    {


        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
//        $ticket_id = rand(1520,9999).time();

        // $ticket_id_gen = IdGenerator::generate(['table' => 'tickets', 'field' => 'ticket_id',  'length' => 6, 'prefix' => 'TC']);

        $ticket_id_gen = DB::table('tickets')->orderBy('id', 'DESC')->first();

         $split_val=  explode('TC',$ticket_id_gen->ticket_id);
         $ticket_digit=$split_val[1]+1;
         $ticket_id='TC'.$ticket_digit;



//        try {


            $riderProfile = User::find(Auth::user()->id);

//            $user_passport_id = $riderProfile->profile->passport_id;

            $check_in_platform = $riderProfile->profile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();

            if($request->input('platform')=="0"){
                $response['code'] = 2;
                $response['message'] = 'Department is required';
                return response()->json($response);
            }

            if($request->input('department_id')=="0"){
                $response['code'] = 2;
                $response['message'] = 'please select your issue';
                return response()->json($response);
            }

            if($check_in_platform == null){
                $check_in_platform = "13";
//                $response['code'] = 2;
//                $response['message'] = 'Platform is not Assigned yet';
//                return response()->json($response);
            }else{
                $check_in_platform  = $check_in_platform;
            }


            $checkexist= Ticket::select('*')
                ->where('user_id', '=', Auth::user()->id )
                ->where('is_checked', '=', 0 )
                ->where('department_id', '=', $request->input('department_id'))
                ->orderBy('id', 'DESC')
                ->first();

//            dd($checkexist);
            if($checkexist == null){
                $file1=null;
                $file2=null;
                if (!empty($_FILES['image']['name'])) {
                //     if (!file_exists('./assets/upload/tickets/images')) {
                //         mkdir('./assets/upload/tickets/images', 0777, true);
                //     }
                //     $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                //     $file1 = $request->input('name').$current_timestamp.'.'.$ext;

                //  move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/tickets/images/'.$file1);

                //     $img = Image::make('./assets/upload/tickets/images/' . $file1);
                //     $img->save('./assets/upload/tickets/images/' . $file1,25);
                //     $file1 = '/assets/upload/tickets/images/' . $file1;
                    $img = $request->file('image');
                    $file1 = '/assets/upload/tickets/images/' .time() . '.' . $img ->getClientOriginalExtension();

                    $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                    $constraint->aspectRatio();
                                });

                    Storage::disk("s3")->put($file1, $imageS3->stream());

                }

                if (!empty($_FILES['voice']['name'])) {
                    // if (!file_exists('./assets/upload/tickets/voices')) {
                    //     mkdir('./assets/upload/tickets/voices', 0777, true);
                    // }
                    // $ext = pathinfo($_FILES['voice']['name'], PATHINFO_EXTENSION);
                    // $file2 = $request->input('name').$current_timestamp . '.' . $ext;
                    // move_uploaded_file($_FILES["voice"]["tmp_name"], './assets/upload/tickets/voices/' . $file2);
                    // $file2 = '/assets/upload/tickets/voices/' . $file2;
                    $voice = $request->file('voice');
                    $file2 = '/assets/upload/tickets/voices/' .time() . '.' . $voice ->getClientOriginalExtension();
                    Storage::disk("s3")->put($file2, file_get_contents($voice));
                }



                $obj = new Ticket();
                $obj->ticket_id = $ticket_id;
                $obj->user_id = Auth::user()->id;
                $obj->platform = $check_in_platform;
//                $obj->platform_id = $request->input('platform_id');
                $obj->message = $request->input('message');
                $obj->department_id = $request->input('department_id');
                $obj->processing_by = $request->input('department_id');
                $file1?$obj->image_url = $file1:"";
                $file2?$obj->voice_message = $file2:"";
                $obj->save();
                $response['code'] = 1;
                $response['message'] = 'Ticket successfully created.';

//                $user = User::find(1);

//                $wheredept = array('user_issue_dep_id','=',$request->input('department_id'));
//                $whereplat = array('user_platform_id','=',$checkplatform->id);

//                $users= User::select('*')
//                    ->where(function ($query) {
//                        $query->where('user_issue_dep_id', 'like', '%'.$request->input('department_id').'%')
//                            ->where('user_platform_id', 'like', '%'.$checkplatform->id.'%');
//                    })->orWhere(function($query) {
//                        $query->where('id','=',1);
//                    })
//                    ->get();

//                $admin= User::select('*')
//                    ->where('id','=',1)
//                    ->get();
////                dd($users);
//                $admin->notify(new TicketReplies($obj));

                $issue_ids = Departments::where('id','=',$request->input('department_id'))->first();


                $users= User::select('*')
                    ->where('major_department_ids', 'LIKE', '%'.$issue_ids->major_dept_id.'%')
                    ->where('user_platform_id', 'like', '%'.$check_in_platform.'%')
                    ->orWhere('id','=',1)
                    ->get();

                foreach($users as $user){
//                    dd($user);
                    $user->notify(new TicketReplies($obj));
//                    return redirect()->back();
                }
//                Notification::send($user, new TicketReplies($obj));


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



//                $notification=DB::table('notifications')
//                    ->orderBy('idd', 'DESC')
//                    ->first();

                $pusher->trigger('manage_notification', '',"msg");

                return response()->json($response);
            }
            else{

                $response['code'] = 2;
                $response['message'] = 'One Ticket is already in active';
                return response()->json($response);
            }


//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = 'Ticket creation failed';
//            return response()->json($response);
//        }

    }

    public function getTicketDetails()
    {

        $id = Auth::user()->id;

        $tickets = Ticket::where('user_id',$id)
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message_public.user')
            ->withCount([
                'unread_message',
                'unread_message as unread_message_g'])
            ->where('is_checked', '=', "0")
//            ->orWhere('is_checked', '=', "2")
            ->orderBy('id','DESC')
            ->get();

        return response()->json(['data'=>$tickets], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getTicketDetails_competed()
    {

        $id = Auth::user()->id;

        $tickets = Ticket::where('user_id',$id)
            ->where('is_hide','=','0')
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message_public.user')
            ->withCount([
                'unread_message',
                'unread_message as unread_message_g'])
            ->where('is_checked', '=', "1")
            ->orderBy('id','DESC')
            ->get();

        return response()->json(['data'=>$tickets], 200, [], JSON_NUMERIC_CHECK);
    }


    public function getTicketInProcess()
    {

        $id = Auth::user()->id;

        $tickets = Ticket::where('user_id',$id)
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message_public.user')
            ->withCount([
                'unread_message',
                'unread_message as unread_message_g'])
            ->where('is_checked', '=', "2")
            ->orderBy('id','DESC')
            ->get();

        return response()->json(['data'=>$tickets], 200, [], JSON_NUMERIC_CHECK);
    }

    public function update_message_read_app($id){

      $ticket_message = TicketMessage::where('ticket_id','=',$id)->where('user_type','=','1')->update(['is_read'=>'0']);


        $response['code'] = 1;
        $response['message'] = 'Message read status updated successfully';
        return response()->json($response);

    }


    public function getTicketInRejected()
    {

        $id = Auth::user()->id;

        $tickets = Ticket::where('user_id',$id)
            ->where('is_hide','=','0')
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message_public.user')
            ->withCount([
                'unread_message',
                'unread_message as unread_message_g'])
            ->where('is_checked', '=', "3")
            ->orderBy('id','DESC')
            ->get();

        return response()->json(['data'=>$tickets], 200, [], JSON_NUMERIC_CHECK);
    }




    public function ticket_start(Request $request, $id)
    {
        try {

            $obj = Ticket::find($id);
            $obj->is_checked = 2;
            $obj->closed_by = Auth::user()->id;
            $obj->save();

            $message = [
                'message' => 'Ticket Started Successfully',
                'alert-type' => 'success'

            ];

            Mail::to([$obj->user->email])->send(new TicketMail($obj));

            $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj->user_id)->first();

            if(!empty($token)){
                $token  = $token->fcm_token;
                $title = "Ticket Update";
                $body = "Ticket start processing";
                $activity = 'TICKETACTIVITY';
                $notification = new Notification;
                $notification->singleDevice($token,$title,$body,$activity);

            }

            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }

    }

    public  function  assign_to_management(Request $request, $id){

        try {


            $obj = Ticket::find($id);
            $obj->is_approved = $request->status;
            $obj->save();

            $array_status = array('0',
                'Ticket Assign To Team Leader Successfully',
                'Ticket Approved Successfully',
                'Ticket Rejected Successfully',
                'Ticket Assign To Manager Successfully',
                'Ticket Approved Successfully',
                'Ticket Rejected Successfully',
                'Ticket Assign To Management Successfully',
                'Ticket Approved Successfully',
                'Ticket Rejected Successfully',
                );

            $message = [
                'message' => $array_status[$request->status],
                'alert-type' => 'success'
            ];

            $status_array = array(
                '0',
                'Assigned By Employee',
                'Approved By TeamLeader',
                'Rejected By TeamLeader',
                'Assigned By TeamLeader',
                'Approved By Manager',
                'Rejected By Manager',
                'Assigned By Manager',
                'Approved By Management',
                'Rejected By Management',
            );

            $ticket_log = new Ticket_assign_logs();
            $ticket_log->type = $status_array[$request->status];
            $ticket_log->ticket_id = $id;
            $ticket_log->user_id = auth::user()->id;
            $ticket_log->save();



            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }


    }

    public function ticket_reject(Request $request, $id)
    {
        try {

            $obj = Ticket::find($id);
            $obj->is_checked = 3;

            if(isset($request->is_hide)){
                $obj->is_hide = "1";
            }
            $obj->closed_by = Auth::user()->id;
            $obj->save();

            $message = [
                'message' => 'Ticket Rejected Successfully',
                'alert-type' => 'success'

            ];

            Mail::to([$obj->user->email])->send(new TicketMail($obj));

            $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj->user_id)->first();

            if(!empty($token)){
                $token  = $token->fcm_token;
                $title = "Ticket Update";
                $body = "Ticket Rejected";
                $activity = 'TICKETACTIVITY';
                $notification = new Notification;
                $notification->singleDevice($token,$title,$body,$activity);

            }


            return redirect()->route('ticket')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('ticket')->with($message);
        }

    }

    public function ajax_ticket_filter(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;


        if(!empty($end_date) && !empty($start_date) && empty($request->name_id)){

            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";

            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('id', 'desc')
                ->get();
        }elseif(!empty($end_date) && !empty($start_date) && !empty($request->name_id)){
            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";


            $admin_tickets = Ticket::select('*')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();

        }elseif(!empty($request->name_id)){
            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();
        }else{
            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->get();
        }



        $issue_ids = Departments::whereIn('major_dept_id',auth()->user()->major_department_ids)->get();

        $users_new_array = array();

        foreach ($issue_ids as $abs){
            $users_new_array [] = $abs->id;
        }

        if(!empty($end_date) && !empty($start_date) && empty($request->name_id)){

            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";

            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('id', 'desc')
                ->get();



        }elseif(!empty($end_date) && !empty($start_date) && !empty($request->name_id)){


            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();

        }elseif(!empty($request->name_id)){

            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();
        }else{

            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->orderBy('id', 'desc')
                ->get();

        }
        $is_checked = $request->table_checked;
        $view = view("admin-panel.ticket.ajax_view_ticket_filter",compact('tickets', 'is_checked','admin_tickets'))->render();
        return response()->json(['html'=>$view]);


    }


    public function ajax_ticket_filter_count_colors(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;


        if(!empty($end_date) && !empty($start_date) && empty($request->name_id)){

            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";

            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('id', 'desc')
                ->get();
        }elseif(!empty($end_date) && !empty($start_date) && !empty($request->name_id)){
            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";


            $admin_tickets = Ticket::select('*')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();

        }elseif(!empty($request->name_id)){
            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();
        }else{
            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->get();
        }



        $issue_ids = Departments::whereIn('major_dept_id',auth()->user()->major_department_ids)->get();

        $users_new_array = array();

        foreach ($issue_ids as $abs){
            $users_new_array [] = $abs->id;
        }

        if(!empty($end_date) && !empty($start_date) && empty($request->name_id)){

            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";

            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->whereBetween('created_at', [$start_date, $end_date])
                ->orderBy('id', 'desc')
                ->get();



        }elseif(!empty($end_date) && !empty($start_date) && !empty($request->name_id)){


            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();

        }elseif(!empty($request->name_id)){

            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->where('user_id','=',$request->name_id)
                ->orderBy('id', 'desc')
                ->get();
        }else{

            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->orderBy('id', 'desc')
                ->get();

        }
        $is_checked = $request->table_checked;


         $response = $this->count_tickets_hours($is_checked,$tickets,$admin_tickets);

        echo json_encode($response);
        exit;


    }






    public function count_tickets_hours($is_checked, $tickets, $admin_tickets){

         $total_pending_24_ticket = 0;
         $total_pending_48_ticket = 0;
         $total_pending_72_ticket = 0;
         $total_pending_less_24_ticket = 0;

  if(auth()->user()->id == 1){
    foreach($admin_tickets as $ticket){

        if($ticket->is_checked==$is_checked){

            $from = \Carbon\Carbon::parse($ticket->created_at);
            $to = \Carbon\Carbon::now();
            $hours_spend = $to->diffInHours($from);

            if($hours_spend < 24) {
                $total_pending_less_24_ticket = $total_pending_less_24_ticket+1;
            }elseif($hours_spend >= 24 && $hours_spend < 48){

                $total_pending_24_ticket = $total_pending_24_ticket+1;
            }elseif($hours_spend >= 48 && $hours_spend <= 72){

                $total_pending_48_ticket = $total_pending_48_ticket+1;
            }else if($hours_spend > 72){

                $total_pending_72_ticket = $total_pending_72_ticket+1;
            }

        }
    }

    }else{

    foreach($tickets as $ticket){

        if($ticket->is_checked==$is_checked){


                        $from = \Carbon\Carbon::parse($ticket->created_at);
                        $to = \Carbon\Carbon::now();
                        $hours_spend = $to->diffInHours($from);
                        $color_code = "";
                        $font_color = "";
                        if($hours_spend < 24) {
                            $total_pending_less_24_ticket = $total_pending_less_24_ticket+1;
                        }elseif($hours_spend >= 24 && $hours_spend < 48){
                            $color_code = "#ffc107";
                            $font_color = "black";
                            $total_pending_24_ticket = $total_pending_24_ticket+1;
                        }elseif($hours_spend >= 48 && $hours_spend <= 72){
                            $color_code = "#3f51b5a6";
                            $font_color = "black";
                            $total_pending_48_ticket = $total_pending_48_ticket+1;
                        }else if($hours_spend > 72){
                            $color_code = "#8b0000";
                            $font_color = "white";
                            $total_pending_72_ticket = $total_pending_72_ticket+1;
                        }

        }
   }

}

  $array_to_send = array(
        'total_24_tickets' =>  $total_pending_24_ticket,
        'total_48_tickets' =>  $total_pending_48_ticket,
        'total_72_tickets' =>  $total_pending_72_ticket,
        'total_less_24_ticket' =>  $total_pending_less_24_ticket,
  );

  return $array_to_send;

    }



    public function ajax_ticket_share_filter(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $sent_id =  Auth::user()->id;


             $ticket_array = TicketShare::where('sent_by','=',$sent_id)->pluck('ticket_id')->toArray();




        if(!empty($end_date) && !empty($start_date) && empty($request->name_id)){

            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";

            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->whereIn('id', $ticket_array)
                ->orderBy('id', 'desc')
                ->get();
        }elseif(!empty($end_date) && !empty($start_date) && !empty($request->name_id)){
            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";


            $admin_tickets = Ticket::select('*')
                ->whereBetween('created_at', [$start_date, $end_date])
                ->where('user_id','=',$request->name_id)
                ->whereIn('id', $ticket_array)
                ->orderBy('id', 'desc')
                ->get();



        }elseif(!empty($request->name_id)){
            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->where('user_id','=',$request->name_id)
                ->whereIn('id', $ticket_array)
                ->orderBy('id', 'desc')
                ->get();
        }else{
            $admin_tickets = Ticket::select('*')
                ->orderBy('id', 'desc')
                ->whereIn('id', $ticket_array)
                ->get();


        }


        $is_checked = $request->table_checked;
        $view = view("admin-panel.ticket.ajax_view_ticket_share_filter",compact(  'departments','admin_tickets'))->render();
        return response()->json(['html'=>$view]);

    }





    public  function approve_ajax_ticket_filter(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if(!empty($end_date) && !empty($start_date) && empty($request->name_id)){

            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";

            if($request->type=="management"){
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','>=','7')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            }elseif($request->type=="manager"){
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','>=','4')
                    ->where('is_approved','<=','6')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            }elseif($request->type=="teamlead"){
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','<=','3')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->orderBy('id', 'desc')
                    ->get();
            }



        }elseif(!empty($end_date) && !empty($start_date) && !empty($request->name_id)){
            $start_date = $request->start_date." 00:00:01";
            $end_date = $request->end_date." 23:59:00";

            if($request->type=="management") {
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved', '!=', '0')
                    ->where('is_approved', '>=', '7')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->where('user_id', '=', $request->name_id)
                    ->orderBy('id', 'desc')
                    ->get();
            }elseif($request->type=="manager"){
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','>=','4')
                    ->where('is_approved','<=','6')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->where('user_id','=',$request->name_id)
                    ->orderBy('id', 'desc')
                    ->get();
           }elseif($request->type=="teamlaed"){
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','<=','3')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->where('user_id','=',$request->name_id)
                    ->orderBy('id', 'desc')
                    ->get();
             }


        }elseif(!empty($request->name_id)){

            if($request->type=="management") {
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved', '!=', '0')
                    ->where('is_approved', '>=', '7')
                    ->where('user_id', '=', $request->name_id)
                    ->orderBy('id', 'desc')
                    ->get();
            }elseif($request->type=="manager"){

                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','>=','4')
                    ->where('is_approved','<=','6')
                    ->where('user_id', '=', $request->name_id)
                    ->orderBy('id', 'desc')
                    ->get();

            }elseif($request->type=="teamlaed"){
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','<=','3')
                    ->where('user_id', '=', $request->name_id)
                    ->orderBy('id', 'desc')
                    ->get();
            }


        }else{

            if($request->type=="management") {
                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','>=','7')
                    ->orderBy('id', 'desc')
                    ->get();
            }elseif($request->type=="manager"){

                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','>=','4')
                    ->where('is_approved','<=','6')
                    ->orderBy('id', 'desc')
                    ->get();

            }elseif($request->type=="teamlaed"){

                $admin_tickets = Ticket::select('*')
                    ->where('is_approved','!=','0')
                    ->where('is_approved','<=','3')
                    ->orderBy('id', 'desc')
                    ->get();
            }

        }

        $is_checked = $request->table_checked;
        $view = view("admin-panel.ticket.approve_ajax_filter_view",compact('tickets', 'is_checked', 'departments','admin_tickets'))->render();
        return response()->json(['html'=>$view]);


    }

    public function ticket_share(){

        $ticket_share=TicketShare::where('internal_dep_assign','=',auth()->user()->id)->get();
        $users_new_array = array();
        $users_name_array = array();
        foreach ($ticket_share as $abs){
            $users_new_array [] = $abs->ticket_id;
            $users_name_array [] = $abs->sent_by;
        }

        $admin_tickets = Ticket::select('*')
            ->whereIn('id',$users_new_array)
            ->orderBy('id', 'desc')
            ->get();
        $users = User::select('*')
            ->whereIn('id',$users_name_array)
            ->first();
        if (isset($users)) {
            $sent_by = $users->name;
        }else{
            $sent_by = "N/A";
        }


        return view('admin-panel.ticket.ticket_share',compact('admin_tickets','admin_tickets','sent_by'));

        }
//        filter in shared

    public function ajax_tickets_color_wise(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;

            $admin_tickets = Ticket::select('*')
                ->where('is_checked', '=',$request->table_checked)
                ->orderBy('id', 'desc')
                ->get();


        $issue_ids = Departments::whereIn('major_dept_id',auth()->user()->major_department_ids)->get();

        $users_new_array = array();

        foreach ($issue_ids as $abs){
            $users_new_array [] = $abs->id;
        }

            $tickets=Ticket::select('*')
                ->where(function ($query) {
                    $query->whereIn('platform', auth()->user()->user_platform_id);
                })->where(function($query) use ($users_new_array) {
                    $query->whereIn('department_id',$users_new_array)
                        ->orWhereIn('processing_by', auth()->user()->user_issue_dep_id? auth()->user()->user_issue_dep_id : array() )
                        ->orwhereHas('ticket_activity', function($query) use($users_new_array)
                        {
                            $query->whereIn(
                                'assigned_to', auth()->user()->major_department_ids ? auth()->user()->major_department_ids : array()
                            );
                        });
                })
                ->where('is_checked', '=',$request->table_checked)
                ->orderBy('id', 'desc')
                ->get();




        $is_checked = $request->table_checked;
        $color = $request->time;
        $view = view("admin-panel.ticket.ajax_view_ticket_filter_only_color",compact('color','tickets', 'is_checked', 'departments','admin_tickets'))->render();
        return response()->json(['html'=>$view]);


    }



}
