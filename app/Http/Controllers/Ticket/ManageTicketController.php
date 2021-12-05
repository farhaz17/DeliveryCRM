<?php

namespace App\Http\Controllers\Ticket;

use App\Model\Departments;
use App\Model\FcmToken;
use App\Model\MajorDepartment;
use App\Model\Notification;
use App\Model\Ticket;
use App\Model\TicketActivity;
use App\Model\TicketMessage;
use App\Model\TicketShare;
use App\Notifications\Notifications\AssignTicket;
use App\Notifications\TicketReplies;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use DateTime;
use Illuminate\Support\Facades\Storage;


class ManageTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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

        try {

            $validator = Validator::make($request->all(), [
                'department_id' => 'required'
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];


                return redirect()->back()->with($message);
            }




            foreach($request->department_id as $ab){

                $ticket_id = $request->input('ticket_id');
                $obj1 = Ticket::find($ticket_id);
                $obj=new TicketActivity();
                $obj->assigned_from = $obj1->processing_by;
                $obj->assigned_user_by = Auth::user()->id;
                $obj->assigned_to = $ab;
//                $obj->message_note = $request->input('message');
                $obj->ticket_id = $ticket_id;
                $obj->save();

                $obj1->processing_by = $obj->assigned_to;
                $obj1->save();

            }



            $obj = Ticket::find($ticket_id);

            $array_to_send = array();
            $string_ab = "";
            if(isset($request->department_id)){
                foreach ($request->department_id as  $ab){
                    $users = User::where('major_department_ids','LIKE','%'.$ab.'%')->pluck('id')->toArray();
                    if(!empty($users)){
                        $string_ab.= "".implode(',',$users);
                    }
                }
                if($string_ab!=""){
                    $array_to_send = explode(',',$string_ab);
                    $array_to_send = array_unique($array_to_send);
                }

                $users= User::select('*')
                    ->whereIn('id',$array_to_send)
                    ->get();
            }

            foreach($users as $user){
                $user->notify(new AssignTicket($obj));
            }

//            $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj1->user_id)->first();
//
//
//            if(!empty($token)){
//                $token  = $token->fcm_token;
//                $title = "Ticket Update";
//                $body = "Assigned to ".$obj1->department->name." Department";
//                $notification = new Notification;
//                $notification->singleDevice($token,$title,$body);
//            }


            $message = [
                'message' => 'Department Changed',
                'alert-type' => 'success'

            ];
            return redirect()->back()->with($message);


        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => "Error occured",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
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

        $ticket_info=Ticket::find($id);


        $ticket_activities=TicketActivity::where('ticket_id', '=', $id)->get();
        $ticket_shared=TicketShare::where('ticket_id','=',$id)->get();

        $departments=Departments::all();
        $major_departments=MajorDepartment::all();


        $user_names_array = array();
        $shared_names_array=auth()->user()->major_department_ids;

        $internal=User::all();
        foreach ($internal as $ab) {
            $js = $ab->major_department_ids;

            if(!empty($js)){
                $mystring = implode(',',$shared_names_array);
                $word = implode(',',$js);
                if(strpos($mystring, $word) !== false){
                    $names= array(
                        'name' => $ab->name,
                        'id' => $ab->id,
                    );
                    $user_names_array [] = $names;
                }

            }


//            if (in_array($ab->major_department_ids, $shared_names_array)) {
//
//            }

        }
//        dd($user_names_array);

         $maj_string= implode(',',auth()->user()->major_department_ids);
        $internal_users=User::where('major_department_ids','LIKE','%'.$maj_string.'%')->get();



        $ticket_messages_private=TicketMessage::where('ticket_id', '=', $id)->where('category', '=', 1)->get();
        $ticket_messages_public=TicketMessage::where('ticket_id', '=', $id)
            ->where('category', '=', 2)
            ->with('user.profile.passport.personal_info')
            ->get();
        $ticket_history=Ticket::where('user_id',$ticket_info->user_id)->get();

        $dpts  =Departments::where('id','=',$ticket_info->processing_by)->first();

         $major_dtp = $dpts->major_dept_id;






       $is_user = User::where('major_department_ids','LIKE','%'.$major_dtp.'%')->where('designation_type','>',0)->first();

       $is_teamlead = false;
       $is_manager =  false;



       if(!empty($is_user)){

           if($is_user->designation_type=="2"){
               $is_teamlead  = true;
           }

           if($is_user->designation_type=="1"){
               $is_manager  = true;
           }

       }


        $m_departments = MajorDepartment::all();




        return view('admin-panel.ticket.ticket_info',compact('m_departments','is_manager','is_teamlead','ticket_info','departments','ticket_activities','ticket_messages_private','ticket_messages_public',
            'major_departments','ticket_history','internal_users','ticket_shared','user_names_array'));

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

    public function store_message(Request $request){

//        dd($request->all());
        $current_timestamp = Carbon::now()->timestamp;
        try {
            $validator = Validator::make($request->all(), [
                 'pdf' => 'mimes:pdf',
                'image' => 'mimes:jpeg,png,bmp,gif,svg,jpg',
                'voice' => 'mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            ]);
            if ($validator->fails()) {
                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }


//            {
//                city_id:"603655a0ba3e854b287486d2",
//	calendar_date:"2021-02-24T13:33:20.671Z",
//	weather_status_id:1,
//	min_temperature:22,
//	max_temperature:1,
//	avg_humidity_in_percentage:22,
//	sunset_time: "2021-02-24T13:33:20.671Z",
//	last_updated_at: "2021-02-24T13:33:20.671Z",
//	source_system: 2
//}




            $voice=null;
            $image = null;
            $pdf = null;

            if (!empty($_FILES['voice']['name'])) {
                // if (!file_exists('./assets/upload/tickets/voices')) {
                //     mkdir('./assets/upload/tickets/voices', 0777, true);
                // }
                // $ext = pathinfo($_FILES['voice']['name'], PATHINFO_EXTENSION);
                // $voice = $request->input('name').$current_timestamp . '.' . $ext;
                // move_uploaded_file($_FILES["voice"]["tmp_name"], './assets/upload/tickets/voices/' . $voice);
                // $voice = '/assets/upload/tickets/voices/' . $voice;
                $file = $request->file('voice');
                $voice = '/assets/upload/tickets/voices/' .time() . '.' . $file ->getClientOriginalExtension();
                Storage::disk("s3")->put($voice, file_get_contents($file));
            }
            if (!empty($_FILES['image']['name'])) {
                // if (!file_exists('./assets/upload/tickets/images_chat')) {
                //     mkdir('./assets/upload/tickets/images_chat', 0777, true);
                // }
                // $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                // $image = $request->input('name').$current_timestamp . '.' . $ext;
                // move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/tickets/images_chat/' . $image);


                // $img = Image::make('./assets/upload/tickets/images_chat/' . $image);
                // $img->save('./assets/upload/tickets/images_chat/' . $image,25);

                // $image = '/assets/upload/tickets/images_chat/' . $image;
                $img = $request->file('image');
                $image = '/assets/upload/tickets/images_chat/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                Storage::disk("s3")->put($image, $imageS3->stream());
            }

            if (!empty($_FILES['pdf']['name'])) {
                // if (!file_exists('./assets/upload/tickets/pdf')) {
                //     mkdir('./assets/upload/tickets/pdf', 0777, true);
                // }
                // $ext = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
                // $pdf = $request->input('name').$current_timestamp . '.' . $ext;
                // move_uploaded_file($_FILES["pdf"]["tmp_name"], './assets/upload/tickets/pdf/' . $pdf);
                // $pdf = '/assets/upload/tickets/pdf/' . $pdf;
                $pdfile = $request->file('pdf');
                $pdf = '/assets/upload/tickets/pdf/' .time() . '.' . $pdfile ->getClientOriginalExtension();
                Storage::disk("s3")->put($pdf, file_get_contents($pdfile));
            }

//            if($voice == null && $image==null && $pdf=null && $request->input('chat_message') == null){
//
//                $message = [
//                    'message' => 'No data entered',
//                    'alert-type' => 'error'
//
//                ];
//                return redirect()->back()->with($message);
//
//            }

            $ticket_id = $request->input('ticket_id2');
            $category = $request->input('category');




            $obj=new TicketMessage();
            $obj->ticket_id = $ticket_id;
            $obj->chat_message = $request->input('chat_message');
            $obj->user_id = Auth::user()->id;
            $obj->is_read = "1";
            $voice?$obj->voice_message = $voice:"";
            $image?$obj->image_file = $image:"";
            $pdf?$obj->pdf_file = $pdf:"";
            if(in_array(4,Auth::user()->user_group_id)) {
                $obj->user_type = 2;
            }else{
                $obj->user_type = 1;
            }


            if ($category == 1){
                $obj->category = 1;
            }
            else{
                $obj->category = 2;
                $ticketss = Ticket::find($ticket_id);
                $tick_id = $ticketss->ticket_id;
                $token=FcmToken::select('fcm_token')->where('user_id', '=', $ticketss->user_id)->first();
                if(in_array(4,Auth::user()->user_group_id)) {

                }else{

                    if(!empty($token)){
                        $token  = $token->fcm_token;
                        $title = "Ticket Update";
                        $body = "New Message Received";
                        $activity = 'TICKETACTIVITY';
                        $notification = new Notification;
                        $notification->singleDevice($token,$title,$body,$activity);
                    }
                }
            }
            $obj->save();
            $message = [
                'message' => 'Message Sent Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'error' => $e->getMessage()
            ];
            return redirect()->back()->with($message);
        }
    }

//    public function send_ticket_voice_note(Request $request){
//     // if (!empty($_FILES['image']['name'])) {
//     $size = $_FILES['audio_data']['size']; //the size in bytes
//     $input = $_FILES['audio_data']['tmp_name']; //temporary name that PHP gave to the uploaded file
//     $output = $_FILES['audio_data']['name'].".wav";

//         $voice = '/assets/upload/tickets/voices/' .time() . '.' .  $output;
//         Storage::disk("s3")->put($voice);

//         // dd($voice);


// //    }
// }

    public function store_message_app(Request $request){

        $response = [];
        $current_timestamp = Carbon::now()->timestamp;


//        dd($request->all());

        try {



            $voice=null;
            $image = null;
            $pdf = null;

            if (!empty($_FILES['voice']['name'])) {
                // if (!file_exists('./assets/upload/tickets/voices')) {
                //     mkdir('./assets/upload/tickets/voices', 0777, true);
                // }
                // $ext = pathinfo($_FILES['voice']['name'], PATHINFO_EXTENSION);
                // $voice = $request->input('name').$current_timestamp . '.' . $ext;
                // move_uploaded_file($_FILES["voice"]["tmp_name"], './assets/upload/tickets/voices/' . $voice);
                // $voice = '/assets/upload/tickets/voices/' . $voice;
                $file = $request->file('voice');
                $voice = '/assets/upload/tickets/voices/' .time() . '.' . $file ->getClientOriginalExtension();
                Storage::disk("s3")->put($voice, file_get_contents($file));
            }

            if (!empty($_FILES['image']['name'])) {
                // if (!file_exists('./assets/upload/tickets/images_chat')) {
                //     mkdir('./assets/upload/tickets/images_chat', 0777, true);
                // }
                // $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                // $image = $request->input('name').$current_timestamp . '.' . $ext;
                // move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/tickets/images_chat/' . $image);

                // $img = Image::make('./assets/upload/tickets/images_chat/'.$image);
                // $img->save('./assets/upload/tickets/images_chat/'.$image,25);

                // $image = '/assets/upload/tickets/images_chat/' . $image;
                $img = $request->file('image');
                $image = '/assets/upload/tickets/images_chat/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                Storage::disk("s3")->put($image, $imageS3->stream());
            }

            if (!empty($_FILES['pdf']['name'])) {
                // if (!file_exists('./assets/upload/tickets/pdf')) {
                //     mkdir('./assets/upload/tickets/pdf', 0777, true);
                // }
                // $ext = pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
                // $pdf = $request->input('name').$current_timestamp . '.' . $ext;
                // move_uploaded_file($_FILES["pdf"]["tmp_name"], './assets/upload/tickets/pdf/' . $pdf);
                // $pdf = '/assets/upload/tickets/pdf/' . $pdf;
                $pdfile = $request->file('pdf');
                $pdf = '/assets/upload/tickets/pdf/' .time() . '.' . $pdfile ->getClientOriginalExtension();
                Storage::disk("s3")->put($pdf, file_get_contents($pdfile));
            }

//            if($voice == null && $image==null && $pdf=null && $request->input('chat_message') == null){
//
//                $response['error'] = 2;
//                $response['message'] = "No record entered";
//                return response()->json($response);
//
//            }

            $obj=new TicketMessage();
            $obj->ticket_id = $request->input('ticket_id');
            $obj->chat_message = $request->input('chat_message');
            $obj->user_id = Auth::user()->id;
            $obj->is_read = "1";
            $voice?$obj->voice_message = $voice:"";
            $image?$obj->image_file = $image:"";
            $pdf?$obj->pdf_file = $pdf:"";
            $obj->category = 2;
            $obj->user_type = 2;
            $obj->save();

            $messages = TicketMessage::where('ticket_id','=',$request->input('ticket_id'))->get();


            $response['code'] = 1;
            $response['message'] = 'Message Sent.';
            $response['data'] = $messages;


            $ticket_id = $request->input('ticket_id');
            $obj1 = Ticket::find($ticket_id);
//            $obj2 = Ticket::find($ticket_id)::with("ticket_activity")->get();

//            dd($obj1->ticket_activity);
//
//
            $users = new User();
            if(!$obj1->ticket_activity->isEmpty()){
                foreach($obj1->ticket_activity as $ticket_activity){
//                    dd($ticket_activity->assigned_to);
                    $users =User::select('*')
                        ->where('id','=',1)
                        ->orwhere('user_platform_id', 'like', '%'.$obj1->platform_->id.'%')
                        ->where('user_issue_dep_id', 'like', '%'.$obj1->current_department->id.'%')
                        ->orWhere('user_issue_dep_id', 'like', '%'.$obj1->department->id.'%')
                        ->orWhere('user_issue_dep_id', 'like', '%'.$ticket_activity->assigned_to.'%')
                        ->get();

                }
            }


            else{
//                dd("sdfsdf");
                $users=User::select('*')
                    ->where('id','=',1)
                    ->orwhere('user_platform_id', 'like', '%'.$obj1->platform_->id.'%')
                    ->where('user_issue_dep_id', 'like', '%'.$obj1->current_department->id.'%')
                    ->orWhere('user_issue_dep_id', 'like', '%'.$obj1->department->id.'%')
                    ->get();

//                dd($users);
            }


//            $users  = array_unique($users);

//            dd($users);




//            $users=User::select('*')
//                ->where(function ($query) {
//                    $query->where('user_platform_id', 'like', '%'.$obj1->platform_->id.'%');
//                })->where(function($query) {
//                    $query->where('user_issue_dep_id', '=', $obj1->current_department->id)
//                        ->orWhere('user_issue_dep_id', '=', $obj1->department->id)
//                        ->orWhere('user_issue_dep_id', '=', $obj1->ticket_activity->to_department->id);
//                })
//                ->orWhere('id','=',1)
//                ->get();


            foreach($users as $user){
                $user->notify(new \App\Notifications\TicketMessage($obj1));
            }

//            $options = array(
//                'cluster' => 'ap2',
//                'encrypted' => true
//            );
//            $pusher = new Pusher(
//                '528cdceee8181ca31807',
//                'ccc70fe7e4c099aff497',
//                '985726',
//                $options
//            );
//
//            $pusher->trigger('manage_notification', '',"msg");

            return response()->json($response);
        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Sending Failed';
            return response()->json($response);
        }
    }






    public function ajax_ticket_info(Request $request){

            $id = $request->id;
            $all_ticket = Ticket::where('id',$id)->get();
            $ticket_chat = TicketMessage::where('ticket_id',$id)->get();

            $view = view("admin-panel.ticket.ajax_ticket_info",compact('all_ticket', 'ticket_chat'))->render();

           return response()->json(['html'=>$view]);

    }

    public  function internal_ticket_assign(Request $request){

        $validator = Validator::make($request->all(), [
            'user_department_id' => 'required',
            'internal_dep_assign' => 'required',
//            'message' => 'required',

        ]);
        if ($validator->fails()) {
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error'

            ];
            return redirect()->back()->with($message);
        }

        $ticket_id = $request->input('ticket_id');
        $obj1 = Ticket::find($ticket_id);

        foreach ($request->internal_dep_assign as $ab){
            $obj=new TicketShare();
            $obj->ticket_id=$request->input('ticket_id');
            $obj->assigned_from = $obj1->processing_by;
            $obj->internal_dep_assign=$ab;
//            $obj->message_note=$request->input('message');
            $obj->sent_by=$request->input('sent_by');
            $obj->save();
        }

        $message = [
            'message' => 'Ticket Assigned Internally',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);

    }

    //show the data from shared tickets
    public function show_shared($id)
    {

        $ticket_info=Ticket::find($id);
        $ticket_assigned='123';


        $ticket_activities=TicketActivity::where('ticket_id', '=', $id)->get();
        $ticket_shared=TicketShare::where('ticket_id','=',$id)->get();

        $departments=Departments::where('id', '!=', $ticket_info->processing_by)->get();
        $major_departments=MajorDepartment::where('id', '!=', $ticket_info->processing_by)->get();


        $user_names_array = array();
        $shared_names_array=auth()->user()->major_department_ids;

        $internal=User::all();
        foreach ($internal as $ab) {
            $js = $ab->major_department_ids;

            if(!empty($js)){
                $mystring = implode(',',$shared_names_array);
                $word = implode(',',$js);
                if(strpos($mystring, $word) !== false){
                    $names= array(
                        'name' => $ab->name,
                        'id' => $ab->id,
                    );
                    $user_names_array [] = $names;
                }

            }


//            if (in_array($ab->major_department_ids, $shared_names_array)) {
//
//            }

        }
//        dd($user_names_array);

        $maj_string= implode(',',auth()->user()->major_department_ids);
        $internal_users=User::where('major_department_ids','LIKE','%'.$maj_string.'%')->get();



        $ticket_messages_private=TicketMessage::where('ticket_id', '=', $id)->where('category', '=', 1)->get();
        $ticket_messages_public=TicketMessage::where('ticket_id', '=', $id)
            ->where('category', '=', 2)
            ->with('user.profile.passport.personal_info')
            ->get();
        $ticket_history=Ticket::where('user_id',$ticket_info->user_id)->get();

        $dpts  =Departments::where('id','=',$ticket_info->processing_by)->first();

        $major_dtp = $dpts->major_dept_id;






        $is_user = User::where('major_department_ids','LIKE','%'.$major_dtp.'%')->where('designation_type','>',0)->first();

        $is_teamlead = false;
        $is_manager =  false;



        if(!empty($is_user)){

            if($is_user->designation_type=="2"){
                $is_teamlead  = true;
            }
            if($is_user->designation_type=="1"){
                $is_manager  = true;
            }

        }



        return view('admin-panel.ticket.ticket_info',compact('is_manager','is_teamlead','ticket_info','departments','ticket_activities','ticket_messages_private','ticket_messages_public',
            'major_departments','ticket_history','internal_users','ticket_shared','user_names_array','ticket_assigned'));

    }

    public function ajax_ticket_log(Request $request){

        if($request->ajax()){

            $array_to_send = array();

          $ticket_activity = TicketActivity::where('ticket_id',$request->ticket_id)->orderby('id','asc')->first();
          $ticket_share = TicketShare::where('ticket_id',$request->ticket_id)->orderby('id','asc')->first();

          $ticket_activity_start_date = "";
          $ticket_share_start_date = "";


            if(!empty($ticket_activity->created_at)){
                $ticket_activity_start_date = $ticket_activity->created_at;
            }

            if(!empty($ticket_share->created_at)){
                $ticket_share_start_date = $ticket_share->created_at;
            }

            $ticket_start_date_act = strtotime($ticket_activity_start_date);
            $ticket_start_date_share = strtotime($ticket_share_start_date);

            if(!empty($ticket_activity) && !empty($ticket_share)){

                if($ticket_start_date_act > $ticket_start_date_share)
                {
                    $start_date_ab = explode(" ",$ticket_share->created_at);
                    $start_date = $start_date_ab[0];
                }
                if($ticket_start_date_share > $ticket_start_date_act)
                {
                    $start_date_ad = explode(" ",$ticket_activity->created_at);
                    $start_date = $start_date_ad[0];
                }

            }elseif($ticket_activity==null && $ticket_share==null){
                $start_date = date("Y-m-d");
            }elseif($ticket_share==null && !empty($ticket_activity)){
                $start_date_ad = explode(" ",$ticket_activity->created_at);
                $start_date = $start_date_ad[0];
            }elseif($ticket_activity==null && !empty($ticket_share)){
                $start_date_ab = explode(" ",$ticket_share->created_at);
                $start_date = $start_date_ab[0];
            }else{
                $start_date = date("Y-m-d");
            }


            $end_date = date("Y-m-d");
            $begin = new DateTime($start_date);
            $end   = new DateTime($end_date);


            for($i = $begin; $i <= $end; $i->modify('+1 day')){

                $ticket_activity_ab = TicketActivity::where('ticket_id',$request->ticket_id)->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();


                foreach($ticket_activity_ab as $ticket_activity){


                  $gamer = array(
                       'type' => "Department",
                       'from_department' => isset($ticket_activity->from_major_department->major_department)? $ticket_activity->from_major_department->major_department : '',
                       'date' => $ticket_activity->created_at,
                       'to_department' => isset($ticket_activity->to_major_department->major_department) ? $ticket_activity->to_major_department->major_department : '' ,
                       'assigned_by' => isset($ticket_activity->assigned_by->name) ? $ticket_activity->assigned_by->name : '',
                  );
                  $array_to_send [] = $gamer;

                }

                 $ticketshares = TicketShare::where('ticket_id',$request->ticket_id)->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();

                foreach($ticketshares as $ticket_share){

                    $gamer = array(
                        'type' => "Person",
                        'share_from' => isset($ticket_share->share_from->name)? $ticket_share->share_from->name : '',
                        'date' => $ticket_share->created_at,
                        'share_to' => isset($ticket_share->share->name) ? $ticket_share->share->name : '' ,
                        'message' => isset($ticket_share->message_note) ? $ticket_share->message_note : '' ,
                    );
                    $array_to_send [] = $gamer;
                }

             }

             $view = view('admin-panel.ticket.ticket_log_ajax',compact('array_to_send'))->render();

            return response()->json(['html'=>$view]);
        }

    }

}
