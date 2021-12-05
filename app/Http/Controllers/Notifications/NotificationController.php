<?php

namespace App\Http\Controllers\Notifications;

use App\Model\Agreement\AgreementCategoryTree;
use App\Model\Assign\AssignPlateform;
use App\Model\FcmToken;
use App\Model\Notification;
use App\Model\Notifications\NotificationsMsg;
use App\Model\Notifications\UserNotificationInfos;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Platform;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|notification-platform-notification', ['only' => ['index','store','destroy','edit','update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $plateform=Platform::all();
        $notifications=NotificationsMsg::all();

        return view('admin-panel.Notification.plateform_notification',compact('plateform','notifications'));
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

        $validator = Validator::make($request->all(), [
            'file_notif'  => 'mimes:pdf'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'File Must of PDF',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $validator2 = Validator::make($request->all(), [
            'user_ids'  => 'required'
        ]);
        if ($validator2->fails()) {

            $validate = $validator2->errors();
            $message = [
                'message' => 'Please Select Atleast One Rider',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        if (empty($_FILES['voice_notif']['name'])) {
            $file_path=null;
        }

        else {
            if (!file_exists('../public/assets/upload/notifications/voice_notification/')) {
                mkdir('../public/assets/upload/notifications/voice_notification/', 0777, true);
            }

            $ext = pathinfo($_FILES['voice_notif']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["voice_notif"]["tmp_name"], '../public/assets/upload/notifications/voice_notification/' . $file_name);
            $file_path = 'assets/upload/notifications/voice_notification/' . $file_name;

        }
        if (empty($_FILES['img_notif']['name'])) {
            $file_path1=null;
        }
        else {
            if (!file_exists('../public/assets/upload/notifications/img_notification/')) {
                mkdir('../public/assets/upload/notifications/img_notification/', 0777, true);
            }

            $ext1 = pathinfo($_FILES['img_notif']['name'], PATHINFO_EXTENSION);
            $file_name1 = time() . "_" . $request->date . '.' . $ext1;

            move_uploaded_file($_FILES["img_notif"]["tmp_name"], '../public/assets/upload/notifications/img_notification/' . $file_name1);
            $file_path1 = 'assets/upload/notifications/img_notification/' . $file_name1;

        }
        if (empty($_FILES['file_notif']['name'])) {
            $file_path3=null;
        }
        else {
            if (!file_exists('../public/assets/upload/notifications/file_notification/')) {
                mkdir('../public/assets/upload/notifications/file_notification/', 0777, true);
            }

            $ext3 = pathinfo($_FILES['file_notif']['name'], PATHINFO_EXTENSION);
            $file_name3 = time() . "_" . $request->date . '.' . $ext3;

            move_uploaded_file($_FILES["file_notif"]["tmp_name"], '../public/assets/upload/notifications/file_notification/'.$file_name3);
            $file_path3 = 'assets/upload/notifications/file_notification/' . $file_name3;

        }




        $obj = new NotificationsMsg();

        $json_passport_ids = "";
            $data = array(
                'user_ids' => $request->user_ids,
            );
        $json_passport_ids = json_encode($data);




//          $obj->user_ids = $json_passport_ids;
          $obj->plateform_id = $request->input('plateform');
          $obj->text_notif = $request->input('text_notif');
          $obj->voice_notif = $file_path;
          $obj->img_notif = $file_path1;
          $obj->file_notif = $file_path3;

          $obj->save();

          $notification_id=$obj->id;

          foreach($request->user_ids as $user_id)
             {
                 if($user_id == '') {
                     continue;
                 }
            $obj2 = new UserNotificationInfos();
            $obj2->notification_id = $notification_id;
            $obj2->user_ids = $user_id;
            $obj2->save();
                    }

        $token=FcmToken::select('fcm_token')->where('user_id', '=', $obj2->user_ids)->first();
        if(!empty($token)){
            $token  = $token->fcm_token;
            $title = "You have a new notification";
            $body = $request->input('text_notif');
            $activity = 'NOTIFICATIONACTIVITY';
            $notification = new Notification;
            $notification->singleDevice($token,$title,$body,$activity);

        }

        $message = [
            'message' => 'Notification Sent Successfully',
            'alert-type' => 'success',

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

    public function get_plateform_detail(Request $request){


        $select_id = $request->plateform_id;



        $childe['data'] = [];

        if(!empty($select_id)){
            $platform = AssignPlateform::where('plateform',$select_id)->where('status','=','1')->get();

            if($platform != null){
           foreach($platform as $plt){

               if(isset($plt->passport->profile)){

                   $gamer = array(
                       'given_name' => $plt->passport ?$plt->passport->given_names:'',
                       'sur_name' => $plt->passport ?$plt->passport->sur_name:'',
                       'full_name' => isset($plt->passport->personal_info->full_name) ? $plt->passport->personal_info->full_name : '',
                       'id' => $plt->id,
                       'user_id' =>  $plt->passport->profile ? $plt->passport->profile->user_id : '' ,

                   );
                   $childe['data'] [] = $gamer;

               }


                }


            }

              echo json_encode($childe);
                exit;

        }else{

            $childe['data'] = [];
            echo json_encode($childe);
            exit;
        }






    }


}
