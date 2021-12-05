<?php

namespace App\Http\Controllers\Header;

use App\Model\Notification;
use App\Model\Ticket;
use App\Model\VisaProcess\VisaCancallation;
use App\Model\VisaProcess\VisaCancellStatus;
use App\Model\VisaProcess\VisaClearance;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends Controller
{
    public function read_done($id){

        DB::table('notifications')
            ->where('idd','=',$id)
            ->limit(1)
            ->update(['read_at' => Carbon::now()]);
         $notify = Notification::where('idd','=',$id)->where('data','LIKE','%New Ticket Assigned%')->first();
         $notify_created_date = Notification::where('idd','=',$id)->where('data','LIKE','%New Ticket Created%')->first();
         $parts_notification = Notification::where('idd','=',$id)->where('data','LIKE','%repair_parts_request%')->first();


         if(!empty($notify)){
             $ticket = json_decode($notify->data);
             return redirect()->route('manage_ticket.show',$ticket->ticket->id);
         }elseif(!empty($notify_created_date)){
             $ticket = json_decode($notify_created_date);
             $player = json_decode($ticket->data);
                 $gamer = Ticket::where('ticket_id','=',$player->ticket->ticket_id)->first();
             return redirect()->route('manage_ticket.show',$gamer->id);
         }
         elseif(!empty($parts_notification)){
            // return redirect()->back();
            // $parts_json = json_decode($parts_notification->data);
            // $repair_id=$parts_json->repair_parts_request->id;
            return redirect()->back();
            // // return back()->withInput(['postvar1' => 'postval1']);  // L5.5
            // $token = csrf_token();

            // // return redirect()->route('get_inv_parts',['repair_id'=>$repair_id, '_token'=>$token]);

            // return Redirect::route('get_inv_parts2',['repair_id' => $repair_id,'_token'=>$token]);
            // // return Redirect::route('get_inv_parts',$repair_id);
         }
    }


    public function read_done2($id){

        DB::table('notifications')
            ->where('idd','=',$id)
            ->limit(1)
            ->update(['read_at' => Carbon::now()]);

        $notify = Notification::where('idd','=',$id)->where('data','LIKE','%New Visa Cancellation%')->first();
        $visa_cancel=json_decode($notify->data);
        if(!empty($notify)){
            $dep_id= auth()->user()->id;
            $department=User::where('id',$dep_id)->first();
            $user_dep_ids=$department->major_department_ids;
            if (in_array('5', $department->major_department_ids)) {
            $major_dep_id='5';
            }
            else{
                $major_dep_id='100';
            }
            $result=VisaCancallation::where('id',$visa_cancel->visa_cancel->id)->first();
            $res=VisaClearance::where('cancallation_id',$visa_cancel->visa_cancel->id)->first();

            $can_status=VisaCancellStatus::all();

            return view('admin-panel.visa-master.visa_cancel_detail',compact('result','major_dep_id','res','can_status'));
        }else{
            return redirect()->back();

        }
    }


    public function get_notification(){

        $notifications= auth()->user()->unreadNotifications;
        $count = count(auth()->user()->unreadNotifications);

        $notify =view('admin-panel.base.notification',compact('notifications'))->render();
//        dd($count);
        if ($notifications) {
            $result['data'] = $notify;
            $result['count'] = $count;
            $result['response'] = true;
        } else {
            $result['response'] = false;
        }
        return response()->json($result, 200);

    }
    public function get_notification2(){

        $notifications2= auth()->user()->unreadNotifications_visa;
        $count = count(auth()->user()->unreadNotifications_visa);

        $notify =view('admin-panel.base.visa_notification',compact('notifications2'))->render();
//        dd($count);
        if ($notifications2) {
            $result['data'] = $notify;
            $result['count'] = $count;
            $result['response'] = true;
        } else {
            $result['response'] = false;
        }
        return response()->json($result, 200);

    }


    public function get_notification3(){

        $notifications3= auth()->user()->unreadNotifications_parts;
        $count = count(auth()->user()->unreadNotifications_parts);
        // resources\views\admin-panel\base\parts_notification.blade.php
        $notify =view('admin-panel.base.parts_notification',compact('notifications3'))->render();
//        dd($count);
        if ($notifications3) {
            $result['data'] = $notify;
            $result['count'] = $count;
            $result['response'] = true;
        } else {
            $result['response'] = false;
        }
        return response()->json($result, 200);

    }
}
