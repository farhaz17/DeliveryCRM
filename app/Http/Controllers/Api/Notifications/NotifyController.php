<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Model\BikeDetail;
use App\Model\Notifications\NotificationsMsg;
use App\Model\Notifications\UserNotificationInfos;
use App\Model\Telecome;
use App\Model\VerificationForm;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    //
    public function get_user_notification()
{
//         $id = \Illuminate\Support\Facades\Auth::user()->id;
         $id = Auth::user()->id;
//       dd($id);

//    s =  UserNotificationInfos::where('user_ids','=',$id)

        $notifications =  UserNotificationInfos::where('user_ids','=',$id)
//             select('user_notification_infos.*','user_notification_infos.user_ids')
            ->join('notifications_msgs','user_notification_infos.notification_id','=','notifications_msgs.id')
           ->join('platforms','platforms.id','=','notifications_msgs.plateform_id')
             ->select('notifications_msgs.*','user_notification_infos.status as msg_status','platforms.name')
            ->orderby('notifications_msgs.id','DESC')
            ->get();

//         UserNotificationInfos::where('user_ids','=',$id)->update(['status' => 1]);


    return response()->json(['data'=>$notifications], 200, [], JSON_NUMERIC_CHECK);
}

    public function update($id)
    {


//        dd("pass");
        //$id = UserNotificationInfos::where('id', '=',$id)->first();
        $user_id = Auth::user()->id;
//          $msg = NotificationsMsg::find($id)->with('platforms');
//        $user_id='4';

        $notifications =  UserNotificationInfos::join('notifications_msgs','user_notification_infos.notification_id','=','notifications_msgs.id')
            ->join('platforms','platforms.id','=','notifications_msgs.plateform_id')
            ->select('notifications_msgs.*','platforms.name')
            ->where('notifications_msgs.id','=',$id)
            ->first();

        UserNotificationInfos::where('notification_id','=',$id)->where('user_ids','=',$user_id)->update(['status' => 1]);

//        $obj = UserNotificationInfos::where('notification_id','=',$id)->where('user_ids','=',$user_id)->update(['status' => "1"]);

          $response['code'] = 1;
//        $response['message'] = 'Form is Successfully Submitted';

        return response()->json($notifications);
    }


}

