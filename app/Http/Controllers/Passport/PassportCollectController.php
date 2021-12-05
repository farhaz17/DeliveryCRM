<?php

namespace App\Http\Controllers\Passport;

use App\User;
use Carbon\Carbon;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use App\Model\VendorRiderOnboard;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use App\Model\Passport\PassportDelay;
use App\Model\Passport\PassportLocker;
use App\Model\Passport\PassportToLocker;
use App\Model\Passport\PassportWithRider;
use Illuminate\Support\Facades\Validator;
use App\Model\Passport\LockerPassportRequest;

class PassportCollectController extends Controller
{


    function __construct()
    {
//        dd("Not Available for now");

        // dd("we are here now")
        // $this->middleware('role_or_permission:Admin|passport_collect', ['only' => ['create','store']]);
        // $this->middleware('role_or_permission:Admin|driving-license', ['only' => ['index','edit','update']]);
    }

    public function index() {
//        dd("Not Available for now");
        $passports =  PassportToLocker::with('passport', 'user')
                        ->where('received_user','=', Auth::user()->id)
                        ->where(function ($query) {
                            $query->where('passport_flow', '!=', 2)
                                ->orWhereNull('passport_flow');
                        })
                        ->whereIn('status',[0,1,2])
                        ->whereNull('locker')
                        ->latest()->get();

        $passports_transferred = PassportToLocker::with('passport', 'user')
                        ->where('received_from','=', Auth::user()->id)
                        // ->whereIn('status',[3])
                        ->latest()->get();

        // $users = User::where('user_group_id', 'not like', '%"4"%')->get();
        $users = User::select('users.*')
                        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->where('roles.name', '=', 'Incoming_passport_transfer_role')->get();

        return view('admin-panel.passport_collect.index',compact('passports', 'passports_transferred','users'));
    }

    public function show() {
        // return "hello";
    }

    public function create() {
//        dd("Not Available for now");
        return view('admin-panel.passport_collect.create');
    }

    public function update(Request $request, $id) {
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

            $message = [
                'message' => 'Passport Accepted Successfully',
                'alert-type' => 'success'
            ];
        }
        else{
            $obj->status = 2; //reject
            $obj->save();

            if($obj_transfer) {
                $obj_transfer->holds_passport = 0; //update previous row
                $obj_transfer->save();
            }

            $obj_rejected = new PassportToLocker();
            $obj_rejected->passport_id = $obj_transfer->passport_id;
            $obj_rejected->remarks = $obj_transfer->remarks;
            $obj_rejected->reason = $obj_transfer->reason;
            $obj_rejected->status =  1;
            $obj_rejected->received_user = $obj_transfer->received_user;
            $obj_rejected->received_from = $obj_transfer->received_from;
            $obj_rejected->holds_passport =  1;
            $obj_rejected->transfer_id = $obj->id;
            $obj_rejected->save();

            $message = [
                'message' => 'Passport Rejected Successfully',
                'alert-type' => 'success'
            ];

        }


        return redirect()->route('passport_collect')->with($message);
    }


    public function store(Request $request) {

        $validator =   Validator::make($request->all(),[
            'passport_id'=>'required'
        ]);

        if ($validator->fails()) {

            $message = [
                'message' =>  $validator->errors()->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


        if( $request->status == 1) {   //received passport

            $with_rider = PassportWithRider::where('passport_id', '=', $request->passport_id)->first();

            if($with_rider === NULL) {
                $passports =  PassportToLocker::where('passport_id', $request->passport_id)
                        ->where(function ($query) {
                            $query->where('holds_passport', 1)
                                    ->orWhere('locker', 1);
                        })
                        ->get();

                if(count($passports) > 0) {
                    $message = [
                        'message' => 'Passport already entered',
                        'alert-type' => 'error'
                    ];

                    return redirect()->route('passport_collect.create')->with($message);
                }
            }


            $passport_rider = PassportWithRider::where('passport_id', '=', $request->passport_id)->delete();

            //Update passport received in Delay passport table
            $delay_passport = PassportDelay::where('passport_id', $request->passport_id)->where('status', 0)->first();
            if($delay_passport) {
                $delay_passport->update(['status' => 1]);
            }

            // if($passport_rider) {
            //     PassportToLocker::where('passport_id', '=', $request->passport_id)
            //                     ->where('with_rider', '=', 1)->update(['with_rider' => NULL]);
            // }

            $obj = new PassportToLocker();

            $obj->passport_id = $request->input('passport_id');
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  $request->input('status');
            $obj->received_user = Auth::user()->id;
            $obj->holds_passport =  1;
            $obj->save();
            $message = [
                'message' => 'Passport collection successful',
                'alert-type' => 'success'
            ];
            return redirect()->route('passport_collect.create')->with($message);
        }
        else {  //not received passport

            $delay_passport = PassportDelay::where('passport_id', $request->passport_id)->where('status', 0)->first();

            if($delay_passport) {
                $message = [
                    'message' =>  "passport already entered for later receive",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

            $obj = new PassportDelay();

            $obj->passport_id = $request->input('passport_id');
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  $request->input('status');
            $obj->received_user = Auth::user()->id;
            $obj->submitting_date = $request->input('submit_date');
            $obj->save();
            $message = [
                'message' => 'Passport collection successful',
                'alert-type' => 'success'
            ];
            return redirect()->route('passport_collect.create')->with($message);
        }


    }

    public function save_passport_handle_with_ajax(Request $request){


        $validator = Validator::make($request->all(),[
            'ppuid_primary_id'=>'required',
        ]);

        if($validator->fails()){
            return  $validator->errors()->first();
        }

        $passport_id = $request->ppuid_primary_id;

        //condition validation start

        $with_rider = PassportWithRider::where('passport_id', '=', $passport_id)->first();
            if($with_rider === NULL) {
                $passports =  PassportToLocker::where('passport_id', $passport_id)
                        ->where(function ($query) {
                            $query->where('holds_passport', 1)
                                    ->orWhere('locker', 1);
                        })
                        ->get();
                if(count($passports) > 0) {
                    return 'Passport already entered';
                }
           }

        //condition validation end







        if( $request->status == 1) {   //received passport

            $with_rider = PassportWithRider::where('passport_id', '=', $passport_id)->first();

            if($with_rider === NULL) {
                $passports =  PassportToLocker::where('passport_id', $passport_id)
                    ->where(function ($query) {
                        $query->where('holds_passport', 1)
                            ->orWhere('locker', 1);
                    })
                    ->get();

                if(count($passports) > 0) {
                    return  "Passport already entered";
                }
            }



            $obj = new PassportToLocker();

            $obj->passport_id = $passport_id;
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  $request->input('status');
            $obj->received_user = Auth::user()->id;
            $obj->holds_passport =  1;
            $obj->save();

             return  "success";

        }elseif($request->status == 2){

            $obj = new PassportDelay();

            $obj->passport_id = $passport_id;
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  $request->input('status');
            $obj->received_user = Auth::user()->id;
            $obj->security_deposit_amount = $request->input('security_deposit');
            $obj->submitting_date = $request->input('submit_date');
            $obj->later_now_option = $request->later_now;
            $obj->save();
            return  "success";
        }else {  //not received passport
            $obj = new PassportDelay();

            $obj->passport_id = $passport_id;
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  $request->input('status');
            $obj->received_user = Auth::user()->id;
            $obj->submitting_date = $request->input('submit_date');
            $obj->save();

            return  "success";

        }

    }

    public function transfer(Request $request) {

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
                $obj->save();
            }
            $message = [
                'message' => 'Passport Transferred Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('passport_collect')->with($message);

        }
        else {
            $obj = PassportToLocker::find($request->collection_id);
            $obj->status = 3;
            $obj->send_to = $request->input('user_id');
            $obj->save();

            $obj = new PassportToLocker();

            $obj->passport_id = $request->input('passport_id');
            $obj->transfer_id = $request->collection_id;
            $obj->remarks = $request->input('remark');
            $obj->reason = $request->input('reason');
            $obj->status =  0;
            $obj->received_from = Auth::user()->id;
            $obj->received_user = $request->input('user_id');
            $obj->save();
            $message = [
                'message' => 'Passport Transferred Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('passport_collect')->with($message);
        }

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

        return redirect()->route('passport_collect')->with($message);

    }

    public function report(Request $request) {

        $passports =  PassportLocker::with('passport.zds_code', 'user', 'personal_info')->get();
        // $passports = collect($data)->last();
        $passports_transferred = PassportToLocker::with('passport', 'user')
                                    ->where(function ($query) {
                                        $query->where('locker', '!=', 1)
                                            ->orWhereNull('locker');
                                    })
                                    ->whereHas('receiving_user', function($query) {
                                        $query->where('user_group_id', 'not like', '%"20"%');
                                    })
                                    ->where('holds_passport', 1)
                                    ->get();

        $passports_with_riders =  PassportWithRider::with('passport.zds_code', 'user', 'personal_info')->get();

        $passports_with_users = PassportToLocker::select('received_user', 'passport_id', DB::raw('count(*) as total'))
                                ->with('passport', 'receiving_user')
                                ->where('holds_passport',1)
                                ->groupBy('received_user')
                                ->get();

        $not_returned =  LockerPassportRequest::with('passport', 'user')
                                ->whereDate('return_date', '<', Carbon::now())
                                ->latest()->count();

        $passports_with_controller =  PassportToLocker::with('passport.zds_code', 'receiving_user', 'personal_info')
                                        ->where(function ($query) {
                                            $query->where('locker', '!=', 1)
                                                ->orWhereNull('locker');
                                        })
                                        ->whereHas('receiving_user', function($query) {
                                            $query->where('user_group_id', 'like', '%"20"%');
                                        })
                                        ->where('holds_passport', 1)
                                        ->get();

        $passports_not_returned =  LockerPassportRequest::with('passport.zds_code', 'user', 'personal_info')
                                        ->select('locker_passport_requests.*', 'passport_with_riders.remarks as rider_remarks')
                                        ->whereDate('locker_passport_requests.return_date', '<', Carbon::now())
                                        // ->join('passport_with_riders', 'passport_with_riders.passport_id', 'locker_passport_requests.passport_id')
                                        ->join('passport_with_riders', function($query)
                                        {
                                           $query->on('passport_with_riders.passport_id','=','locker_passport_requests.passport_id')
                                           ->whereRaw('locker_passport_requests.id IN (select MAX(l2.id) from locker_passport_requests as l2 join passport_with_riders as p2 on p2.passport_id = l2.passport_id group by l2.passport_id)');
                                        })
                                        ->whereNull('passport_with_riders.deleted_at')
                                        // ->groupBy('passport_id')
                                        ->latest()->get();

        $passports_delayed = PassportDelay::with('passport.zds_code', 'user', 'personal_info')->whereIn('status', [0, 2])->get();

        $requested_passports =  LockerPassportRequest::with('passport', 'user')->whereNull('status')->latest()->get();
        $accepted_passports =  LockerPassportRequest::with('passport.zds_code', 'user', 'personal_info')->where('status', 1)->latest()->get();
        $rejected_passports =  LockerPassportRequest::with('passport.zds_code', 'user', 'personal_info')->where('status', 2)->latest()->get();

        $passports_with_riders_reason =  PassportWithRider::select('*', DB::raw('count(*) as total'))->groupBy('reason')->orderBy('reason', 'desc')->get();

        $inlocker_today =  PassportLocker::whereDate('created_at', '=', Carbon::today())->count();
        $with_rider_today =  PassportWithRider::whereDate('created_at', '=', Carbon::today())->count();

        $remaining_passports = Passport::leftJoin('passport_delays', function($join)
                                            {
                                                $join->on('passport_delays.passport_id', '=', 'passports.id')->whereIn('passport_delays.status', [0,2]);
                                            })
                                        ->leftJoin('passport_lockers', function($join)
                                        {
                                            $join->on('passport_lockers.passport_id', '=', 'passports.id')->whereNull('passport_lockers.deleted_at');
                                        })
                                        ->leftJoin('passport_with_riders', function($join)
                                        {
                                            $join->on('passport_with_riders.passport_id', '=', 'passports.id')->whereNull('passport_with_riders.deleted_at');
                                        })
                                        ->leftJoin('passport_to_lockers', function($join)
                                        {
                                            $join->on('passport_to_lockers.passport_id', '=', 'passports.id')
                                            ->whereNull('passport_with_riders.deleted_at')
                                            ->where(function ($query) {
                                                $query->where('locker', '!=', 1)
                                                    ->orWhereNull('locker');
                                            })
                                            ->where('holds_passport', 1);
                                        })
                                        ->whereNull('passport_to_lockers.passport_id')
                                        ->whereNull('passport_with_riders.passport_id')
                                        ->whereNull('passport_lockers.passport_id')
                                        ->whereNull('passport_delays.passport_id')
                                        ->count();

        $fourpl_in_locker = PassportLocker::leftJoin('passports', 'passports.id', 'passport_lockers.passport_id')
                                    ->with('passport.zds_code', 'user', 'personal_info')
                                    ->join('careers', 'passports.career_id', 'careers.id')
                                    ->join('vendor_rider_onboards', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                                    ->where('vendor_rider_onboards.cancel_status', 0)
                                    ->get();

        $fourpl_delayed = VendorRiderOnboard::select('passport_delays.*')->leftJoin('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                                ->with('passport.zds_code', 'user', 'personal_info')
                                ->join('passports', 'passports.career_id', 'careers.id')
                                ->join('passport_delays', 'passport_delays.passport_id', 'passports.id')->whereIn('passport_delays.status', [0,2])->get();

        $fourpl_with_rider = PassportWithRider::leftJoin('passports', 'passports.id', 'passport_with_riders.passport_id')
                                    ->with('passport.zds_code', 'user', 'personal_info')
                                    ->join('careers', 'passports.career_id', 'careers.id')
                                    ->join('vendor_rider_onboards', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                                    ->where('vendor_rider_onboards.cancel_status', 0)
                                    ->get();
        // $passport_stats = [
        //     'not_returned' => $not_returned,
        // ];

        // return $passport_stats;

        return view('admin-panel.passport_collect.report', compact('passports', 'passports_transferred', 'passports_with_riders', 'passports_with_users', 'passports_with_controller', 'passports_not_returned', 'requested_passports', 'accepted_passports', 'rejected_passports', 'passports_with_riders_reason', 'inlocker_today', 'with_rider_today', 'passports_delayed', 'remaining_passports', 'fourpl_in_locker', 'fourpl_delayed', 'fourpl_with_rider'));

    }

    public function userwise_report(Request $request) {

        $passports_holding = PassportToLocker::where('received_user','=', Auth::user()->id)
                                ->where('holds_passport',1)
                                ->count();

        $passports_transferred = PassportToLocker::where('received_from','=', Auth::user()->id)
                                ->whereIn('status',[1,3])
                                ->count();

        $passports_received = PassportToLocker::where('received_user','=', Auth::user()->id)
                                ->whereIn('status',[1,3])
                                ->count();

        return view('admin-panel.passport_collect.userwise_report',compact('passports_holding', 'passports_transferred', 'passports_received'));

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
        $obj->received_from = Auth::user()->id;
        $obj->remarks = $request->input('remarks');
        $obj->save();
        $message = [
            'message' => 'Send to Locker Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('passport_collect')->with($message);
    }

    public function passport_details(Request $request) {

        $searach = '%'.$request->passport_id.'%';
        $passport = Passport::where('passport_no', 'like', $searach)->first();

        return $passport;
    }

    public function autocomplete(Request $request){

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
        ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
        ->get();

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
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

    public function get_full_passport_detail(Request $request){

        $searach = '%'.$request->passport_id.'%';
        $passport = Passport::with('zds_code')->where('passport_no', 'like', $searach)->first();



            $gamer = array(
                'name' => $passport->personal_info->full_name,
                'id' => $passport->id,
                'pp_uid' => $passport->pp_uid,
                'passport_no' => $passport->passport_no,
                'zds_code' => $passport->zds_code->zds_code,
            );


        echo json_encode($gamer);

    }

}
