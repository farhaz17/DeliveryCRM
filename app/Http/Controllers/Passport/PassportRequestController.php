<?php

namespace App\Http\Controllers\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Passport\LockerPassportRequest;
use App\Model\Passport\Passport;
use App\Model\Passport\PassportLocker;
use App\Model\Passport\PassportToLocker;
use App\Model\Passport\PassportWithRider;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PassportRequestController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Requested_passport_role', ['only' => ['list']]);
        $this->middleware('role_or_permission:Admin|Remove_from_locker', ['only' => ['locker_transfer']]);

    }

    public function request() {
        return view('admin-panel.passport_report.request');
    }

    public function store(Request $request) {

        //check already Requested or not
        $passport_request = LockerPassportRequest::where('passport_id', '=', $request->passport_id)
                            ->where('status', NULL)->first();
        if ($passport_request) {
            $message = [
                'message' => 'Passport Already Requested',
                'alert-type' => 'error'
            ];
            return redirect()->route('request_passport.request')->with($message);
         }

        $obj = new LockerPassportRequest();

        $obj->passport_id = $request->input('passport_id');
        $obj->remarks = $request->input('remark');
        $obj->reason = $request->input('reason');
        $obj->return_date = $request->input('return_date');
        $obj->request_from = $request->input('request_from');
        $obj->save();
        $message = [
            'message' => 'Passport request successful',
            'alert-type' => 'success'
        ];
        return redirect()->route('request_passport.request')->with($message);
    }


    public function list() {
        $passports =  LockerPassportRequest::with('passport', 'user')->whereNull('status')->latest()->get();
        $passports_status =  LockerPassportRequest::with('passport', 'user')->whereIn('status', [1,2])->latest()->get(); //status 1-accept 2-reject


        return view('admin-panel.passport_report.passport_request_list',compact('passports', 'passports_status'));
    }

    public function update(Request $request, $id) {
        $obj = LockerPassportRequest::find($id);
        if($request->accept)
        {
            $obj->status = 1; //accept
            $obj->save();
            $message = [
                'message' => 'Accepted Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('request_passport.list')->with($message);

        }
        else{
            $obj->status = 2; //reject
            $obj->save();
            $message = [
                'message' => 'Rejected Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('request_passport.list')->with($message);
        }

    }

    public function locker_transfer() {
        $passports =  LockerPassportRequest::with('passport', 'user')
                        ->join('passport_lockers', 'passport_lockers.passport_id', '=', 'locker_passport_requests.passport_id')
                        ->where('locker_passport_requests.status', '=', 1)
                        ->whereNull('passport_lockers.deleted_at')
                        ->select('passport_lockers.*')
                        ->select('locker_passport_requests.*')
                        ->groupBy('passport_id')
                        ->latest()->get();

        // $passport = PassportLocker::with('passport', 'user')
        //                 ->where('locker_passport_requests.status', '=', 1)
        //                 ->latest()->get();


        $passports_status =  PassportToLocker::with('passport', 'user')
                                ->where('received_from','=', Auth::user()->id)
                                ->where('from_locker', 1)
                                ->latest()->get();
        $users = User::where('user_group_id', 'not like', '%"4"%')->get();

        return view('admin-panel.passport_report.locker_transfer',compact('passports', 'passports_status', 'users'));
    }

    public function post_locker_transfer(Request $request) {

        DB::beginTransaction();

        try {

            // PassportToLocker::where('passport_id', '=', $request->input('passport_id'))
            //                     ->where('locker', '=', 1)->update(['locker' => NULL]);

            //after removing from locker update passport requested list
            LockerPassportRequest::where('passport_id', '=', $request->input('passport_id'))
                                ->where('status', '=', 1)->update(['status' => 3]);  //status-3 removed

            $obj = new PassportToLocker();

            if($request->input('request_from') == 2) {  //if passport requested by user
                $obj->user_request =  1;
            }
            $obj->passport_id = $request->input('passport_id');
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  1;
            $obj->holds_passport =  1;
            $obj->from_locker =  1;
            $obj->passport_flow =  2; //outgoing passport
            $obj->received_user = Auth::user()->id;
            $obj->save();
            $message = [
                'message' => 'Transferred Successfully',
                'alert-type' => 'success'
            ];

            $passport = PassportLocker::where('passport_id', '=', $request->input('passport_id'))->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $message = [
                'message' => 'Something went Wrong',
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('request_passport.locker_transfer')->with($message);

    }

    public function outgoing_transfer(Request $request) {

        $passports =  PassportToLocker::with('passport', 'user')
                        ->where('received_user','=', Auth::user()->id)
                        ->where('passport_flow', 2)
                        ->whereIn('status',[0,1,2])
                        ->whereNull('locker')
                        ->whereNull('with_rider')
                        ->latest()->get();

        $passports_transferred = PassportToLocker::with('passport', 'user')
                ->where('received_from','=', Auth::user()->id)
                ->where('passport_flow', 2)
                ->latest()->get();
        // $users = User::where('user_group_id', 'not like', '%"4"%')->get();

        $users = User::select('users.*')
                        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('roles.name', '=', 'Incoming_passport_transfer_role')->get();

        $passport_users = User::where('user_group_id', 'like', '%"20"%')->get();

        return view('admin-panel.passport_report.outgoing_transfer',compact('passports', 'passports_transferred','users', 'passport_users'));

    }

    public function cancel_transfer(Request $request, $id) {

        DB::beginTransaction();

        try {
            $obj_cancel = PassportToLocker::find($id);

            $obj_change = PassportToLocker::find($obj_cancel->transfer_id);
            $obj_change->status = 1;
            $obj_change->holds_passport = 1;
            $obj_change->send_to = NULL;
            $obj_change->save();

            $obj_cancel->delete();

            DB::commit();

            $message = [
                'message' => 'Passport Transfer Cancelled Successfully',
                'alert-type' => 'success'
            ];

        } catch (\Exception $e) {
            DB::rollback();
            $message = [
                'message' => 'Something went wrong',
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('request_passport.outgoing_transfer')->with($message);

    }

    public function transfer_update(Request $request, $id) {
        $obj = PassportToLocker::find($id);
        $obj_transfer = PassportToLocker::find($obj->transfer_id);
        if($request->accept)
        {
            if($obj_transfer) {
                $obj_transfer->holds_passport = 0; //update previous row
                $obj_transfer->save();
            }
            $obj->holds_passport = 1; //update latest row
            $obj->status = 1; //accept
            $obj->save();

        }
        else{
            $obj->status = 2; //reject
            $obj->save();

            if($obj_transfer) {
                $obj_transfer->holds_passport = 0; //update previous row
                $obj_transfer->save();

                $obj_rejected = new PassportToLocker();
                $obj_rejected->passport_id = $obj_transfer->passport_id;
                $obj_rejected->remarks = $obj_transfer->remarks;
                $obj_rejected->reason = $obj_transfer->reason;
                $obj_rejected->status =  1;
                $obj_rejected->received_user = $obj_transfer->received_user;
                $obj_rejected->received_from = $obj_transfer->received_from;
                $obj_rejected->holds_passport =  1;
                $obj_rejected->transfer_id = $obj->id;
                $obj_rejected->passport_flow =  2; //outgoing passport
                $obj_rejected->save();

            }
            else {

                $obj_rejected = new PassportToLocker();
                $obj_rejected->passport_id = $obj->passport_id;
                $obj_rejected->status =  1;
                $obj_rejected->received_user = $obj->received_from;
                $obj_rejected->from_locker = 1;
                $obj_rejected->holds_passport =  1;
                $obj_rejected->transfer_id = $obj->id;
                $obj->passport_flow =  2; //outgoing passport
                $obj_rejected->save();

            }




        }


        return redirect()->route('request_passport.outgoing_transfer');
    }

    public function locker(Request $request) {

        $obj_locker = PassportLocker::where('passport_id', $request->passport_id)->get();
        if(count($obj_locker) > 0) {
            $message = [
                'message' => 'Passport already in Locker',
                'alert-type' => 'error'
            ];

            return redirect()->route('passport_collect')->with($message);
        }

        $obj = PassportToLocker::find($request->collection_id);
        $obj->holds_passport = 0;
        $obj->locker = 1;
        $obj->save();

        $obj = new PassportLocker();

        $obj->passport_id = $request->input('passport_id');
        $obj->remarks = $request->input('remarks');
        $obj->received_from = Auth::user()->id;
        $obj->save();
        $message = [
            'message' => 'Send to Locker Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('request_passport.outgoing_transfer')->with($message);
    }

    public function passport_details(Request $request) {

        $searach = '%'.$request->passport_id.'%';
        $passport = Passport::where('passport_no', 'like', $searach)->first();

        return $passport;
    }


    public function post_transfer(Request $request) {

        if($request->bulk_transfer) {

            foreach($request->collection_id as $collection_id) {

                $obj = PassportToLocker::find($collection_id);
                $obj->status = 3;
                $obj->send_to = $request->input('user_id');
                $obj->save();

                $passport_id =  PassportToLocker::where('id','=', $collection_id)->value('passport_id');
                $obj = new PassportToLocker();

                $obj->passport_id = $passport_id;
                $obj->transfer_id = $collection_id;
                $obj->remarks = $request->input('remark');
                $obj->reason = $request->input('reason');
                $obj->status =  0;
                $obj->received_from = Auth::user()->id;
                $obj->received_user = $request->input('user_id');
                $obj->passport_flow =  2; //outgoing passport
                $obj->save();
            }
            $message = [
                'message' => 'Additinal Field Added Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('passport_collect')->with($message);

        }
        else {

            DB::beginTransaction();
            try {
                $obj = PassportToLocker::find($request->collection_id);
                $obj->status = 3;
                $obj->send_to = $request->input('user_id');
                $obj->save();

                $obj = new PassportToLocker();

                if($request->input('user_request') == 1) {  //if passport requested by user
                    $obj->user_request =  1;
                }
                $obj->passport_id = $request->input('passport_id');
                $obj->transfer_id = $request->collection_id;
                $obj->remarks = $request->input('remark');
                $obj->reason = $request->input('reason');
                $obj->status =  0;
                $obj->received_from = Auth::user()->id;
                $obj->received_user = $request->input('user_id');
                $obj->passport_flow =  2; //outgoing passport
                $obj->save();
                $message = [
                    'message' => 'Additinal Field Added Successfully',
                    'alert-type' => 'success'
                ];
                DB::commit();
            } catch(\Exception $e) {
                DB::rollback();
                $message = [
                    'message' => 'Something went wrong',
                    'alert-type' => 'error'
                ];
            }

            return redirect()->route('request_passport.outgoing_transfer')->with($message);
        }

    }


    public function transfer_to_manager(Request $request) {

            $obj = PassportToLocker::find($request->collection_id);
            $obj->status = 3;
            $obj->send_to = $request->input('user_id');
            $obj->save();

            $obj = new PassportToLocker();

            if($request->input('user_request') == 1) {  //if passport requested by user
                $obj->user_request =  1;
            }
            $obj->passport_id = $request->input('passport_id');
            $obj->transfer_id = $request->collection_id;
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  0;
            $obj->received_from = Auth::user()->id;
            $obj->received_user = $request->input('user_id');
            $obj->save();
            $message = [
                'message' => 'Additinal Field Added Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('request_passport.outgoing_transfer')->with($message);

    }



    public function rider(Request $request) {

        $passport = PassportWithRider::where('passport_id', $request->passport_id)->first();

        if($passport) {
            $message = [
                'message' => 'Passport already with rider',
                'alert-type' => 'error'
            ];
        }
        else{

            $obj = PassportToLocker::find($request->collection_id);
            $obj->holds_passport = 0;
            $obj->with_rider = 1;
            $obj->save();

            $obj = new PassportWithRider();

            $obj->passport_id = $request->input('passport_id');
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->reason;
            $obj->received_from = Auth::user()->id;
            $obj->save();

            $message = [
                'message' => 'Passport Sent to Rider',
                'alert-type' => 'success'
            ];

        }

        return redirect()->route('request_passport.outgoing_transfer')->with($message);
    }

    public function notify_return() {
        $passports =  LockerPassportRequest::with('passport', 'user')
                        ->select('locker_passport_requests.*')
                        ->whereDate('return_date', '<', Carbon::now())
                        ->join('passport_with_riders', 'passport_with_riders.passport_id', 'locker_passport_requests.passport_id')
                        ->whereNull('passport_with_riders.deleted_at')
                        ->groupBy('passport_id')
                        ->latest()->get();

        return view('admin-panel.passport_report.passport_return_notify',compact('passports'));
    }

    public function autocomplete_two(Request $request){

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
          ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
          ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
          ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
          ->orWhere("passports.pp_uid","LIKE","%{$request->input('query')}%")
          ->orWhere("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
          ->orWhere("user_codes.zds_code","LIKE","%{$request->input('query')}%")
          ->take(50)
          ->get();



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

    public function autocomplete(Request $request){

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->join('passport_to_lockers', 'passport_to_lockers.passport_id', '=', 'passports.id')
            ->groupBy('passport_to_lockers.passport_id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->get();

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->join('passport_to_lockers', 'passport_to_lockers.passport_id', '=', 'passports.id')
                ->groupBy('passport_to_lockers.passport_id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->join('passport_to_lockers', 'passport_to_lockers.passport_id', '=', 'passports.id')
                    ->groupBy('passport_to_lockers.passport_id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->join('passport_to_lockers', 'passport_to_lockers.passport_id', '=', 'passports.id')
                        ->groupBy('passport_to_lockers.passport_id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->get();

                    //zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => $pass->zds_code,
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

}
