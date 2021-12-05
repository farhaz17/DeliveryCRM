<?php

namespace App\Http\Controllers\Riders;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\Passport\Passport;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Model\Riders\DefaulterRiders\DefaulterRider;
use App\Model\Riders\DefaulterRiders\DefaulterRiderComments;
use App\Model\Riders\DefaulterRiders\DefalterRiderReassignRequest;

class DefaulterRiderController extends Controller
{
    function __construct()
    {
        // $this->middleware('role_or_permission:Admin', ['only' => ['index','store','get_ajax_defaulter_rider_details','reassign_rider_accept_reject','get_ajax_defaulter_rider_comments','defaulter_rider_comments','rider_platform_wise_dc_list','defaulter_rider_accept_reject','defaulter_rider_reassign_request_to_dc']]);

        $this->middleware('role_or_permission:Admin|DC_roll', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|DC_roll', ['only' => ['store']]);
        $this->middleware('role_or_permission:Admin|DC_roll', ['only' => ['reassign_rider_accept_reject']]);

        // $this->middleware('role_or_permission:Admin|DC_roll|defaulter_rider_manager|Defaulter Rider Co-ordinator Manager', ['only' => ['get_ajax_defaulter_rider_details']]);
        // $this->middleware('role_or_permission:Admin|DC_roll|defaulter_rider_manager|Defaulter Rider Co-ordinator Manager', ['only' => ['get_ajax_defaulter_rider_comments']]);
        // $this->middleware('role_or_permission:Admin|DC_roll|defaulter_rider_manager|Defaulter Rider Co-ordinator Manager', ['only' => ['defaulter_rider_comments']]);
        // $this->middleware('role_or_permission:Admin|DC_roll|defaulter_rider_manager', ['only' => ['rider_platform_wise_dc_list']]);

        $this->middleware('role_or_permission:Admin|defaulter_rider_manager', ['only' => ['defaulter_rider_accept_reject']]);
        $this->middleware('role_or_permission:Admin|defaulter_rider_manager', ['only' => ['defaulter_rider_reassign_request_to_dc']]);
    }

    public function index(){



        $all_dc_riders = AssignToDc::with(['passport.personal_info','passport.platform_codes','platform','user_detail'])
        ->where(function($all_dc_riders){
            $current_user = auth()->user();
            if($current_user->hasRole(['Admin','defaulter_rider_manager'])) return true;
            if($current_user->designation_type == 3) return $all_dc_riders->whereUserId($current_user->id);
            else return false;
        })
        ->whereStatus(1)
        ->get();
        $defaulter_riders = DefaulterRider::with(['comments','creator','passport.personal_info','passport.platform_codes','passport.dc_detail.user_detail'])->withCount(['comments'])
        ->where(function($defaulter_rider){
            $current_user = auth()->user();
            if($current_user->hasRole(['Admin','defaulter_rider_manager'])) return true;
            if($current_user->designation_type == 3) return $defaulter_rider->where('user_id',$current_user->id);
            else return false;
        })
        ->get();
        $users = User::with('roles')->get();
        $defaulter_ridrer_coordinator_managers = $users->filter(function($user){
            return $user->hasRole(['Defaulter Rider Co-ordinator Manager']);
        });

        $reassign_requests = DefalterRiderReassignRequest::with('defaulter_rider')->get();

        return view('admin-panel.riders.defaulter_riders.defaulter_riders_list', compact('all_dc_riders','defaulter_riders','users','defaulter_ridrer_coordinator_managers','reassign_requests'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'drcm_id' => 'required',
            'defaulter_level' => 'required',
            'defaulter_details' => 'required',
            'attachments.*' => 'nullable|mimes:jpeg,png,pdf,xls,xlsx'
            ],
            $messages = [
                'attachments.*' => 'Attachments should be in jpeg, png, pdf, xls, xlsx format',
            ]
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $fileNames = [];
        if($request->hasFile('attachments')){
            $today_date = date("Y-m-d");
            $passport = Passport::find($request->passport_id);
            foreach($request->attachments as $attachment){
                $fileName = 'assets/upload/defaulter_riders/' . $today_date . '/' . $passport->pp_uid . '_' . time() . '.' . $attachment->extension();
                Storage::disk('s3')->put($fileName, file_get_contents($attachment));
                $fileNames[] = $fileName;
            }
        }
        $current_dc = AssignToDc::whereRiderPassportId($request->passport_id)->whereStatus(1)->first();
        if(!$current_dc){
            $message = [
                'message' => "Rider is not assign to any DC" ,
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }
        $defaulter_rider = DefaulterRider::create([
            'user_id' => auth()->id(), // creator id
            'drcm_id' => $request->drcm_id, // send request to Defaulter Rider Co odinator Manager
            'passport_id' => $request->passport_id,
            'subject' => $request->subject,
            'attachments' => json_encode($fileNames),
            'defaulter_level' => $request->defaulter_level,
            'defaulter_details' => $request->defaulter_details,
            'previous_assign_to_dc_id' => $current_dc->id,
        ]);
        $message = [
            'message' => "Rider defaulter has beed sent!" ,
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }

    public function get_ajax_defaulter_rider_details(Request $request){
        $defaulter_rider_details = DefaulterRider::find($request->defaulter_rider_id);
        $view = view('admin-panel.riders.defaulter_riders.shared_blades.defaulter_rider_details', compact('defaulter_rider_details'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_ajax_defaulter_rider_comments(Request $request){
        $defaulter_rider_comments = DefaulterRider::with(['comments','passport'])->whereId($request->defaulter_rider_id)->first();
        $view = view('admin-panel.riders.defaulter_riders.shared_blades.defaulter_rider_comments', compact('defaulter_rider_comments'))->render();
        return response()->json(['html' => $view]);
    }

    public function defaulter_rider_comments(Request $request){
        $defaulter_rider_comments = DefaulterRider::with(['comments','passport'])->whereId($request->defaulter_rider_id)->first();
        if(!$defaulter_rider_comments){
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => 'Defaulter Rider record not found!',
                'status' =>'500'
            ]);
        }
        $comment = DefaulterRiderComments::create([
            'commenter_id' => auth()->id(),
            'comment' => $request->comment,
            'defaulter_rider_id' => $defaulter_rider_comments->id,
        ]);
        if($comment->wasRecentlyCreated){
            $defaulter_rider_comments = DefaulterRider::with(['comments','passport'])->whereId($request->defaulter_rider_id)->first();
            $view = view('admin-panel.riders.defaulter_riders.shared_blades.defaulter_rider_comments', compact('defaulter_rider_comments'))->render();
            return response([
                'html'  => $view,
                'alert-type' => 'success',
                'message' => 'Comment Added successfully',
                'status' =>'200'
            ]);
        }else{
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => 'Comment could not be added',
                'status' =>'500'
            ]);
        }
    }

    public function defaulter_rider_accept_reject(Request $request){
        $validator = Validator::make($request->all(), [
            'defaulter_rider_id' => 'required',
            'accept_reject' => 'required',
            ],
            $messages = []
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $defaulter_rider = DefaulterRider::whereId($request->defaulter_rider_id)->whereStatus(1)->first();
        if(!$defaulter_rider){
            $message = [
                'message' => "Defaulter Rider Request not found",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);
        }
        $current_dc = AssignToDc::whereRiderPassportId($defaulter_rider->passport_id)->whereStatus(1)->first();
        if(!$current_dc){
            $message = [
                'message' => "Rider is not assign to any DC" ,
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }
        if($request->accept_reject == 2){ // 2 = rejected
            $defaulter_rider->update([
                'accepted' => $request->accept_reject,
                'accepted_by' => auth()->id(),
                'previous_assign_to_dc_id' => $current_dc->id,
                'status' => 0, // 0 = inactive
            ]);
            if(isset($request->comment)){
                DefaulterRiderComments::create([
                    'defaulter_rider_id' => $defaulter_rider->id,
                    'commenter_id' => auth()->id(),
                    'comment' => $request->comment,
                ]);
            }
            $message = [
                'message' => "Rider defaulter request rejected" ,
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }elseif($request->accept_reject == 1){ // 1 = accepted
            $defaulter_rider->update([
                'accepted' => $request->accept_reject,
                'accepted_by' => auth()->id(),
            ]);
            // checkout rider form dc
            if($current_dc){
                // dd($defaulter_rider);
                AssignToDc::create([
                    'rider_passport_id'=> $current_dc->rider_passport_id,
                    'user_id'=> $defaulter_rider->drc_id,
                    'platform_id'=>$current_dc->platform_id,
                    'checkin'=>Carbon::now(),
                    'status'=>1,
                ]);
                $current_dc->update([
                    'status' => 0,
                    'checkout' => Carbon::now()
                ]);
            }
            if(isset($request->comment)){
                DefaulterRiderComments::create([
                    'defaulter_rider_id' => $defaulter_rider->id,
                    'commenter_id' => auth()->id(),
                    'comment' => $request->comment,
                ]);
            }
            $message = [
                'message' => "Rider moved to defaulter list" ,
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);
        }else{
            $message = [
                'message' => "Error" ,
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }
    }

    public function reassign_rider_accept_reject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reassign_defaulter_rider_id' => 'required',
            'approval_status' => 'required',
            ],
            $messages = []
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $reassign_defaulter_rider = DefalterRiderReassignRequest::find($request->reassign_defaulter_rider_id);
        if(!$reassign_defaulter_rider){
            $message = [
                'message' => "Reassign request not found" ,
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);
        }
        if($request->approval_status == 2){ // 2 = rejected
            $reassign_defaulter_rider->approval_status = 2;
            $reassign_defaulter_rider->approved_by = auth()->id();
            $reassign_defaulter_rider->save();

            $message = [
                'message' => "Reassign request rejected!",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }elseif($request->approval_status == 1){ // 1 = accepted
            $current_dc = AssignToDc::whereRiderPassportId($reassign_defaulter_rider->defaulter_rider->passport_id)->whereStatus(1)->first();

            $new_dc = AssignToDc::create([
                'rider_passport_id'=> $reassign_defaulter_rider->defaulter_rider->previous_dc->rider_passport_id,
                'user_id'=> $reassign_defaulter_rider->requested_to_dc_id,
                'platform_id'=>$reassign_defaulter_rider->defaulter_rider->previous_dc->platform_id,
                'checkin'=>Carbon::now(),
                'status' => 1,
            ]);
            $current_dc->update([
                'status' => 0,
                'checkout' => Carbon::now()
            ]);
            if(isset($request->comment)){
                DefaulterRiderComments::create([
                    'defaulter_rider_id' => $reassign_defaulter_rider->defaulter_rider->id,
                    'commenter_id' => auth()->id(),
                    'comment' => $request->comment,
                ]);
            }
            DefaulterRider::find($reassign_defaulter_rider->defaulter_rider->id)
            ->update([
                'status'=> 0,
            ]);
            $reassign_defaulter_rider->approved_by = auth()->id();
            $reassign_defaulter_rider->approval_status = 1;
            $reassign_defaulter_rider->save();

            $message = [
                'message' => "Reassign request Accepted and Rider Reassigned to DC successfully!",
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }
    }

    public function defaulter_rider_reassign_request_to_dc(Request $request){
        $validator = Validator::make($request->all(), [
                'reassign_rider_id' => 'required',
                'dc_user_id' => 'required',
            ],
            $messages = [
                'dc_user_id.required' => "Please select any DC List",
            ]
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        $reassign_rider = DefaulterRider::whereId($request->reassign_rider_id)->first();
        DefalterRiderReassignRequest::create([
            'defaulter_rider_id' => $reassign_rider->id,
            'requested_to_dc_id' => $request->dc_user_id,
            'requested_by' => auth()->id()
        ]);
        if(isset($request->comment)){
            DefaulterRiderComments::create([
                'defaulter_rider_id' => $reassign_rider->id,
                'commenter_id' => auth()->id(),
                'comment' => $request->comment,
            ]);
        }
        $message = [
            'message' => "Reassign request sent successfully!",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function rider_platform_wise_dc_list(Request $request)
    {
        if($request->ajax()){
            $users = User::whereDesignationType(3)->get();
            $platform_users = $users->filter(function($user){
                return in_array(request('platform_id'), $user->user_platform_id);
            });
            $view = view('admin-panel.riders.defaulter_riders.shared_blades.rider_platform_wise_dc_list', compact('platform_users'))->render();
            return response()->json(['html' => $view]);
        }else{
            return redirect('/defaulter_riders');
        }
    }
}
