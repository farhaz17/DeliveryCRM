<?php

namespace App\Http\Controllers\Riders\DefaulterRiders;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Assign\AssignPlateform;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Validator;
use App\Model\Riders\DefaulterRiders\DefaulterRider;
use App\Model\Riders\DefaulterRiders\DefaulterRiderComments;
use App\Model\Riders\DefaulterRiders\DefaulterRiderDrcAssign;
use App\Model\Riders\DefaulterRiders\DefalterRiderReassignRequest;
use Illuminate\Support\Facades\Auth;

class DefaulterRiderManagerController extends Controller
{
    public function drcm_dashboard()
    {
        return view('admin-panel.riders.defaulter_riders.defaulter_rider_manager.drcm_dashboard');
    }
    public function drcm_rider_operations(Request $request)
    {
        $user = Auth::user();

        $hide_class = "";

        if($user->hasRole(['Admin'])){

            $defaulter_riders = DefaulterRider::with([
                'comments','creator','passport.personal_info','passport.platform_codes','passport.dc_detail.user_detail'
            ])
        ->get();
        $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::with(['defaulter_rider','drcm','drc'])->get();
        $users = User::with('roles')->get();
        $defaulter_ridrer_coordinators = $users->filter(function($user){
            return $user->hasRole(['Defaulter Rider Co-ordinator']);
        });


        }else{

            $defaulter_riders = DefaulterRider::with([
                'comments','creator','passport.personal_info','passport.platform_codes','passport.dc_detail.user_detail'
            ])
        ->whereDrcmId(auth()->id())->get();
        $defaulter_requests_sent_to_DRC = DefaulterRiderDrcAssign::with(['defaulter_rider','drcm','drc'])->get();
        $users = User::with('roles')->get();
        $defaulter_ridrer_coordinators = $users->filter(function($user){
            return $user->hasRole(['Defaulter Rider Co-ordinator']);
        });

        }





        return view('admin-panel.riders.defaulter_riders.defaulter_rider_manager.drcm_rider_operations', compact('defaulter_riders','defaulter_ridrer_coordinators', 'defaulter_requests_sent_to_DRC'));
    }

    public function drcm_rider_approval(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'drc_id' => 'required',
                'accept_reject' => 'required',
                'defaulter_rider_id' => 'required'
            ],
            $messages = []
        );
        if ($validator->fails()) {
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' =>  $validate->first(),
                'status' =>'500'
            ]);
        }
        $defaulter_request_exists = DefaulterRider::whereId($request->defaulter_rider_id)->whereStatus(1)->first();
        if(!$defaulter_request_exists){
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => 'Defalter Rider request not found!',
                'status' =>'500'
            ]);
        }
        $drc_assign_exists = DefaulterRiderDrcAssign::whereDefaulterRiderId($defaulter_request_exists->id)
        ->whereDrcId($request->drc_id)
        ->first();
        if($drc_assign_exists && $request->accept_reject == 1){
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => 'Assignment request already sent !',
                'status' =>'500'
            ]);
        }
        if($request->accept_reject == 1){ // Accepted

             $defaulter_drc_already = DefaulterRiderDrcAssign::where('is_defaulter_now','=','0')->where('defaulter_rider_id','=',$request->defaulter_rider_id)->first();

             if($defaulter_drc_already != null){
                return response([
                    'html' => null,
                    'alert-type' => 'error',
                    'message' => 'This Rider is Already Defaulter',
                    'status' =>'500'
                ]);
             }

            // checkout rider form dc
            $current_dc = AssignToDc::whereRiderPassportId($defaulter_request_exists->passport_id)->whereStatus(1)->first();
            if($current_dc){
                // dd($defaulter_rider);
                AssignToDc::create([
                    'rider_passport_id'=> $current_dc->rider_passport_id,
                    'user_id'=> auth()->id(),
                    'platform_id'=>$current_dc->platform_id,
                    'checkin'=>Carbon::now(),
                    'status'=>1,
                ]);
                $current_dc->update([
                    'status' => 0,
                    'checkout' => Carbon::now()
                ]);
            }

            $DefaulterRiderDrcAssign = DefaulterRiderDrcAssign::create([
                'defaulter_rider_id' => $request->defaulter_rider_id,
                'drcm_id' => $defaulter_request_exists->drcm_id,
                'drc_id' => $request->drc_id,
            ]);
            if($request->comment){
                $DefaulterRiderComments = DefaulterRiderComments::create([
                    'comment' => $request->comment,
                    'defaulter_rider_id' => $request->defaulter_rider_id,
                    'commenter_id' => auth()->id(),
                ]);
            }
            $defaulter_request_exists->accepted = 1;
            $defaulter_request_exists->drc_id = $request->drc_id;
            $defaulter_request_exists->accepted_by = auth()->id();
            $defaulter_request_exists->save();
            // dd($defaulter_request_exists, $drc_assign_exists, $DefaulterRiderDrcAssign, $DefaulterRiderComments);
            return response([
                'html' => null,
                'alert-type' => 'success',
                'message' => 'Defaulter Request accepted and sent to Co-ordinator',
                'status' =>'200'
            ]);

        }elseif($request->accept_reject == 2){ // Rejected
            if($request->comment){
                DefaulterRiderComments::create([
                    'comment' => $request->comment,
                    'defaulter_rider_id' => $request->defaulter_rider_id,
                    'commenter_id' => auth()->id(),
                ]);
            }
            $defaulter_request_exists->accepted = 2;
            $defaulter_request_exists->status = 0;
            $defaulter_request_exists->accepted_by = auth()->id();
            $defaulter_request_exists->save();
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => 'Defaulter Request rejected',
                'status' =>'200'
            ]);
        }
    }

    public function save_remove_defaulter(Request $request){


            try{
                $validator = Validator::make($request->all(), [
                    'dc_id' => 'required',
                    'primary_key_id' => 'required'
                ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
            }
            $defaulter_id  = $request->primary_key_id;

          $d_rider_drc  =  DefaulterRiderDrcAssign::find($defaulter_id);

             $already_defaulter_assign = DefalterRiderReassignRequest::where('defaulter_rider_id','=',$d_rider_drc->defaulter_rider_id)->where('approval_status','=','0')->first();

              if($already_defaulter_assign != null){
                        $message = [
                            'message' => "Already request is pending",
                            'alert-type' => 'error'
                        ];
                        return redirect()->back()->with($message);
                }



                $user_id = Auth::user()->id;

                 $defaulterider_assign = new DefalterRiderReassignRequest();
                 $defaulterider_assign->defaulter_rider_id =  $d_rider_drc->defaulter_rider_id;
                 $defaulterider_assign->requested_to_dc_id =  $request->dc_id;
                 $defaulterider_assign->requested_by = $user_id;
                 $defaulterider_assign->save();

                 $message = [
                    'message' => "Request Has been sent successfully",
                    'alert-type' => 'success'
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


    public function get_platforms_dcs(Request $request){


        if($request->ajax()){

             $defaultriderdc = DefaulterRiderDrcAssign::find($request->id);

             $defaulter_rider  = DefaulterRider::find($defaultriderdc->defaulter_rider_id);

             $assign_platform = AssignPlateform::where('passport_id','=',$defaulter_rider->passport_id)
                                                ->where('status','=','1')
                                                ->first();

                  $userData = array();
                if($assign_platform != null){

                    $user_id = Auth::user()->id;

                    $userData = User::where('user_platform_id','LIKE','%'.$assign_platform->plateform.'%')
                                      ->where('designation_type','=','3')
                                      ->where('id','!=',$user_id)
                                       ->get();


                }

                $view = view("admin-panel.riders.defaulter_riders.defaulter_rider_manager.ajax_rider_dc_assign", compact('userData'))->render();

                return response()->json(['html' => $view]);





        }


    }

}
