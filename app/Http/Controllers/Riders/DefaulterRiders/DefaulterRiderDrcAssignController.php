<?php

namespace App\Http\Controllers\Riders\DefaulterRiders;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Validator;
use App\Model\Riders\DefaulterRiders\DefaulterRider;
use App\Model\Riders\DefaulterRiders\DefaulterRiderComments;
use App\Model\Riders\DefaulterRiders\DefaulterRiderDrcAssign;

class DefaulterRiderDrcAssignController extends Controller
{
    public function drc_dashboard()
    {
        return view('admin-panel.riders.defaulter_riders.defaulter_rider_drc.drc_dashboard');
    }
    public function drc_rider_operations(Request $request)
    {
        $defaulter_requests_to_drc = DefaulterRiderDrcAssign::with(['defaulter_rider','drcm','drc'])->get();
        return view('admin-panel.riders.defaulter_riders.defaulter_rider_drc.drc_rider_operations', compact('defaulter_requests_to_drc'));

    }

    public function drc_rider_approval(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'accept_reject' => 'required',
                'drc_assign_request_id' => 'required'
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

        // get the assign drc record
        $drc_assign_request_exists = DefaulterRiderDrcAssign::whereId($request->drc_assign_request_id)->whereStatus(1)->first();
        if(!$drc_assign_request_exists){
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' =>  "DRC Assign Request not found !",
                'status' =>'500'
            ]);
        }
        if($request->accept_reject == 1){

            $defaulter_request_exists = DefaulterRider::whereId($drc_assign_request_exists->defaulter_rider_id)->whereStatus(1)->first();
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

            // update drc record
            $drc_assign_request_exists->approval_status = 1;
            $drc_assign_request_exists->save();

            // add comment if there is any
            if($request->comment){
                $DefaulterRiderComments = DefaulterRiderComments::create([
                    'comment' => $request->comment,
                    'defaulter_rider_id' => $drc_assign_request_exists->defaulter_rider_id,
                    'commenter_id' => auth()->id(),
                ]);
            }
            return response([
                'html' => null,
                'alert-type' => 'success',
                'message' =>  "DRC request accepted !",
                'status' =>'200'
            ]);
        }elseif($request->accept_reject == 2){
            // update drc record
            $drc_assign_request_exists->approval_status = 2;
            $drc_assign_request_exists->save();

            // Rollback the defaulter rider request

            $defaulter_rider = DefaulterRider::whereId($drc_assign_request_exists->defaulter_rider_id)->first()
                ->update([
                    'accepted' => 0
                ]);

            // add comment if there is any
            if($request->comment){
                $DefaulterRiderComments = DefaulterRiderComments::create([
                    'comment' => $request->comment,
                    'defaulter_rider_id' => $drc_assign_request_exists->defaulter_rider_id,
                    'commenter_id' => auth()->id(),
                ]);
            }
            return response([
                'html' => null,
                'alert-type' => 'success',
                'message' =>  "DRC request accepted !",
                'status' =>'200'
            ]);
        }

    }
}
