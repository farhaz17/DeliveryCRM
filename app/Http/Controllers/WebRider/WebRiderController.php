<?php

namespace App\Http\Controllers\WebRider;

use App\Model\Departments;
use App\Model\MajorDepartment;
use App\Model\Passport\Passport;
use App\Model\Passport\RenewPassport;
use App\Model\Platform;
use App\Model\RiderProfile;
use App\Model\Ticket;
use App\Model\TicketActivity;
use App\Model\TicketMessage;
use App\Notifications\TicketReplies;
use App\User;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Pusher\Pusher;
use Illuminate\Support\Facades\Storage;

class WebRiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id = Auth::user()->id;

        $ticket_rejected = Ticket::where('user_id',$id)
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message.user')
            ->where('is_checked', '=', "3")
            ->orderBy('id','DESC')
            ->get();

        $tickets_process = Ticket::where('user_id',$id)
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message.user')
            ->where('is_checked', '=', "2")
            ->orderBy('id','DESC')
            ->get();


        $tickets_closed = Ticket::where('user_id',$id)
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message.user')
            ->where('is_checked', '=', "1")
            ->orderBy('id','DESC')
            ->get();

        $tickets_pending = Ticket::where('user_id',$id)
            ->with('user')
            ->with('department')
            ->with('current_department')
            ->with('ticket_activity.from_department')
            ->with('ticket_activity.to_department')
            ->with('ticket_message.user')
            ->where('is_checked', '=', "0")
            ->orderBy('id','DESC')
            ->get();


//        dd($tickets_pending);

        return view('admin-panel.ticket.rider_tickets',compact('ticket_rejected','tickets_process','tickets_closed','tickets_pending'));

    }

    public function ticket_chat($id){

        $ticket_info=Ticket::find($id);
        $ticket_activities=TicketActivity::where('ticket_id', '=', $id)->get();
        $departments=Departments::where('id', '!=', $ticket_info->processing_by)->get();
        $major_departments=MajorDepartment::where('id', '!=', $ticket_info->processing_by)->get();

//        $ticket_messages_private=TicketMessage::where('ticket_id', '=', $id)->where('category', '=', 1)->get();

        $ticket_messages_public=TicketMessage::where('ticket_id', '=', $id)
            ->where('category', '=', 2)
            ->with('user.profile.passport.personal_info')
            ->get();

//        dd($ticket_messages_public);



        return view('admin-panel.ticket.ticket_chat',compact('ticket_messages_public',
                                                            'ticket_info','ticket_activities','departments','major_departments'));
    }


    public function rider_login(){

        return view('auth.rider_login');
    }

    public function rider_register(){

        return view('auth.rider_register');

    }

    public function create_ticket(){
          $platforms = Platform::all();
         $departments = Departments::all();

       return view('admin-panel.ticket.rider_ticket_create',compact('platforms','departments'));
    }

    public function save_ticket(Request $request){




        $current_timestamp = Carbon::now()->timestamp;
//        $ticket_id = rand(1520,9999).time();

        $ticket_id = IdGenerator::generate(['table' => 'tickets', 'field' => 'ticket_id',  'length' => 6, 'prefix' => 'TC']);

        try {
            $validator = Validator::make($request->all(), [
                'platform' => 'required',
                'platform_id' => 'required',
                'message' => 'required',
                'department_id' => 'required',
                'image' => 'mimes:jpeg,png,bmp,gif,svg',
                'voice' => 'mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
            ]);
            if ($validator->fails()) {
                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('create_ticket')->with($message);
            }

            $checkexist= Ticket::select('*')
                ->where('user_id', '=', Auth::user()->id )
                ->where('is_checked', '=', 0 )
                ->where('department_id', '=', $request->input('department_id'))
                ->orderBy('id', 'DESC')
                ->first();

            if($checkexist == null){
                $file1=null;
                $file2=null;
                if (!empty($_FILES['image']['name'])) {
                    // if (!file_exists('./assets/upload/tickets/images')) {
                    //     mkdir('./assets/upload/tickets/images', 0777, true);
                    // }
                    // $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    // $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                    // move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/tickets/images/' . $file1);

                    // $img = Image::make('./assets/upload/tickets/images/' . $file1);
                    // $img->save('./assets/upload/tickets/images/' . $file1,25);
                    // $file1 = '/assets/upload/tickets/images/' . $file1;
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

                    // $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                    //                 $constraint->aspectRatio();
                    //             });

                    Storage::disk("s3")->put($file2, file_get_contents($voice));
                }

                $obj = new Ticket();
                $obj->ticket_id = $ticket_id;
                $obj->user_id = Auth::user()->id;
                $obj->platform = $request->platform;
                $obj->platform_id = $request->input('platform_id');
                $obj->message = $request->input('message');
                $obj->department_id = $request->input('department_id');
                $obj->processing_by = $request->input('department_id');
                $file1?$obj->image_url = $file1:"";
                $file2?$obj->voice_message = $file2:"";
                $obj->save();


                $issue_ids = Departments::where('id','=',$request->input('department_id'))->first();


                $users= User::select('*')
                    ->where('major_department_ids', 'LIKE', '%'.$issue_ids->major_dept_id.'%')
                    ->where('user_platform_id', 'like', '%'.$request->platform.'%')
                    ->orWhere('id','=',1)
                    ->get();

//                $users= User::select('*')
//                    ->where('user_issue_dep_id', 'like', '%'.$request->input('department_id').'%')
//                    ->where('user_platform_id', 'like', '%'.$request->platform.'%')
//                    ->orWhere('id','=',1)
//                    ->get();

                foreach($users as $user){
                    $user->notify(new TicketReplies($obj));
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
                    'message' => 'Ticket successfully created.',
                    'alert-type' => 'success'
                ];
                return redirect()->route('create_ticket')->with($message);


            }
            else{
                $message = [
                    'message' => 'One Ticket is already in active',
                    'alert-type' => 'error'
                ];
                return redirect()->route('create_ticket')->with($message);
            }

        }catch(\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Ticket creation failed',
                'alert-type' => 'error'
            ];
            return redirect()->route('create_ticket')->with($message);
        }

    }


    public function sign_up(Request $request){

        try {
            $master_data=Passport::where('passport_no', '=',trim($request->input('passport_no')))
                ->first();

            $renew_passport = RenewPassport::where('renew_passport_number','=',trim($request->input('passport')))->first();

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'passport_no' => 'required',
                'password' => 'required|confirmed',
            ]);
            if ($validator->fails()) {

                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error'

                ];
                return redirect()->route('rider_register')->with($message);
            }

            if($renew_passport != null){

                $check_passport_data=RiderProfile::where('passport_id', '=',  $renew_passport->passport_id)->first();


                if($check_passport_data == null){
                    $obj=new User();
                    $obj->email = $request->input('email');
                    $obj->user_group_id = json_encode(["4"]);
                    $obj->password = bcrypt(trim($request->input('password')));
                    $obj->save();


                    $obj1 = new RiderProfile();
                    $obj1->passport_id = $renew_passport->passport_id;
                    $obj1->user_id = $obj->id;
                    $obj1->save();

                    $message = [
                        'message' => 'Registration Successful',
                        'alert-type' => 'success'

                    ];
                    return redirect()->route('rider_register')->with($message);
                }
                else{

                    $message = [
                        'message' => 'Passport no is already exist',
                        'alert-type' => 'success'

                    ];
                    return redirect()->route('rider_register')->with($message);

                }

            }
            else if($master_data != null){

                $check_passport_data=RiderProfile::where('passport_id', '=',  $master_data->id)->first();


                if($check_passport_data == null){
                    $obj=new User();
                    $obj->email = trim($request->input('email'));
                    $obj->user_group_id = json_encode(["4"]);
                    $obj->password = bcrypt(trim($request->input('password')));
                    $obj->save();


                    $obj1 = new RiderProfile();
                    $obj1->passport_id = $master_data->id;
                    $obj1->user_id = $obj->id;
                    $obj1->save();

                    $message = [
                        'message' => 'Registration Successful',
                        'alert-type' => 'success'

                    ];
                    return redirect()->route('rider_register')->with($message);


                }
                else{

                    $message = [
                        'message' => 'Passport no is already exist',
                        'alert-type' => 'error'

                    ];
                    return redirect()->route('rider_register')->with($message);


                }


            }
            else{
                $message = [
                    'message' => 'Passport no is Wrong',
                    'alert-type' => 'error'

                ];
                return redirect()->route('rider_register')->with($message);
            }


        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Registration Failed',
                'alert-type' => 'error'
            ];
            return redirect()->route('rider_register')->with($message);
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
