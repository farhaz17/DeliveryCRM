<?php

namespace App\Http\Controllers\Referal;

use App\Model\Assign\AssignPlateform;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\Guest\Career;
use App\Model\Nationality;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\Passport;
use App\Model\Referal\Referal;
use App\Model\Referal\ReferralSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefrealController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Hiring-referal-rewards|Hiring-pool', ['only' => ['store','destroy','edit','update','get_referal_user_ajax','view_referal','profile_reward_collect','referral_setting_update','referral_settings_store']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //


        $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
            ->where('interview_status','=','0')
            ->pluck('career_id')
            ->toArray();

            $passport_no = Career::whereNotNull('refer_by')->pluck('passport_no')->toArray();
            $passport_ids = Passport::whereIn('passport_no',$passport_no)->pluck('id')->toArray();

            $checkin_ids = AssignPlateform::whereIn('passport_id',$passport_ids)->pluck('passport_id')->toArray();
           $passport_no_checkins = Passport::whereIn('id',$checkin_ids)->pluck('passport_no')->toArray();

        $referals = Career::whereNotNull('refer_by')->where('applicant_status','=','0')
                            // ->whereNotIn('id',$create_interviews)
                            ->whereNotIn('passport_no',$passport_no_checkins)
                            ->get();


        $interview =   Career::whereNotNull('refer_by')->whereIn('id',$create_interviews)->get();

//        dd($interview);

        $nations = Nationality::all();

        return view('admin-panel.referal.index',compact('referals','interview','nations'));
    }

    public function get_referal_user_ajax(Request $request){


        if($request->ajax()){

            $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                ->where('interview_status','=','0')
                ->pluck('career_id')
                ->toArray();

                $passport_no = Career::whereNotNull('refer_by')->pluck('passport_no')->toArray();
                $passport_ids = Passport::whereIn('passport_no',$passport_no)->pluck('id')->toArray();

                $checkin_ids = AssignPlateform::whereIn('passport_id',$passport_ids)->pluck('passport_id')->toArray();
               $passport_no_checkins = Passport::whereIn('id',$checkin_ids)->pluck('passport_no')->toArray();
            //    dd( $checkin_ids);

            if($request->tab_name=="pending"){

                $referals = Career::whereNotNull('refer_by')->where('applicant_status','=','0')
                    // ->where(function ($query) {
                    //     $query->where('hire_status', '=', 0)
                    //         ->orwhereNull('hire_status');
                    // })
                    // ->whereNotIn('id',$create_interviews)
                    ->whereNotIn('passport_no',$passport_no_checkins)
                    ->get();
            }elseif($request->tab_name=="waitlist"){
                $referals = Career::whereNotNull('refer_by')->where('applicant_status','=','5')
                    ->where(function ($query) {
                        $query->where('hire_status', '=', 0)
                            ->orwhereNull('hire_status');
                    })
                    // ->whereNotIn('id',$create_interviews)
                    ->whereNotIn('passport_no',$passport_no_checkins)
                    ->get();
            }elseif($request->tab_name=="selected"){
                $referals = Career::whereNotNull('refer_by')->where('applicant_status','=','4')
                    ->where(function ($query) {
                        $query->where('hire_status', '=', 0)
                            ->orwhereNull('hire_status');
                    })
                    // ->whereNotIn('id',$create_interviews)
                    ->whereNotIn('passport_no',$passport_no_checkins)
                    ->get();

            }elseif($request->tab_name=="interview"){
                $referals = Career::whereNotNull('refer_by')
                    // ->where(function ($query) {
                    //     $query->where('hire_status', '=', 0)
                    //         ->orwhereNull('hire_status');
                    // })
                    ->whereIn('id',$create_interviews)
                    ->whereNotIn('passport_no',$passport_no_checkins)
                    ->get();
            }elseif($request->tab_name=="onboard"){

                $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
                    ->where('on_board','=','1')->pluck('career_id')->toArray();

                $referals = Career::join('passports','passports.career_id','=','careers.id')
                                    ->select('careers.*')
                                    ->whereNotNull('careers.refer_by')
                                    ->whereNotIn('passports.passport_no',$passport_no_checkins)
                                    ->whereIn('careers.id',$onboards)->get();

            }elseif($request->tab_name=="only_pass"){


                $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
                    ->where('on_board','=','1')->pluck('career_id')->toArray();

                $referals = Career::select('careers.*')
                    ->whereNotNull('careers.refer_by')
                    ->whereNotIn('passport_no',$passport_no_checkins)
                    ->whereIn('careers.id',$onboards)->get();

            }elseif($request->tab_name=="absent"){

                $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                    ->where('interview_status','=','3')
                    ->pluck('career_id')
                    ->toArray();

                $referals = Career::whereNotNull('refer_by')->where('hire_status','=','0')
                ->whereNotIn('passport_no',$passport_no_checkins)
                ->whereIn('id',$create_interviews)->get();
            }elseif($request->tab_name=="hired"){

                $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                    ->where('interview_status','=','3')
                    ->pluck('career_id')
                    ->toArray();

                $passports = AssignPlateform::pluck('passport_id')->toArray();
                $careers_id = Passport::whereIn('id',$passports)->pluck('career_id')->toArray();


                $referals = Career::whereNotNull('refer_by')->whereIn('passport_no',$passport_no_checkins)->get();
                // dd($referals);
            }



        }

        $tab = $request->tab_name;

        $view = view('admin-panel.referal.get_referal_status_ajax', compact('tab','referals'))->render();
        return response(['html' => $view]);
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

        $ref_set= ReferralSetting::first();

        $id=$request->id;
        $obj = Career::find($id);
        $pass_no=$obj->passport_no;

        $passport=Passport::where('passport_no',$pass_no)->first();
        if ($passport ==null){
            $message = [
                'message' => 'Passport Detail Not Colleceted Yet',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }else {


            $passport_id = $passport->id;
            $assing_platform = AssignPlateform::where('passport_id', $passport_id)->count();
            if ($assing_platform == '0') {
                $message = [
                    'message' => 'Platform Not Assigned Yet',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
        }



        $obj->referal_status_reward = '1';
        $obj->referal_reward_amount = $ref_set->amount;
        $obj->save();
        $message = [
            'message' => 'Credit Amount Status Changed to Paid',
            'alert-type' => 'success'
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
    public function edit(Request $request)
    {
        //

$id=$request->id;


        $obj = Referal::find($id);
        $obj->credit_status = '1';

        $obj->save();
        $message = [
            'message' => 'Credit Amount Status Changed to Paid',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);

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

        public function referral_settings( Request $request){


        $ref_settings = ReferralSetting::first();
        $view = view("admin-panel.referal.ajax_credit_setting",compact('ref_settings'))->render();
        return response()->json(['html'=>$view]);

        }

    public  function referral_settings_store(Request $request){
        //add try catch

        $obj = new ReferralSetting();
        $obj->amount = $request->input('amount');
        $obj->save();

        $message = [
            'message' => 'Refferal Credit Amount Settings Saved Successfully!',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
    }
    public function referral_setting_update(Request $request, $id){

        $obj = ReferralSetting::find($id);
        $obj->amount = $request->input('amount');
        $obj->save();
        $message = [
            'message' => 'Refferal Credit Amount Settings Updated  Successfully!',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
    }


    public function view_referal(Request $request){
         $passport_id=$request->passport_id;

         $referal= Career::where('refer_by',$passport_id)->get();

            $view = view("admin-panel.referal.ajax_get_referal_detail", compact('referal'))->render();
            return response()->json(['html' => $view]);
    }




    public function profile_reward_collect(Request $request)
    {

        $ref_set= ReferralSetting::first();
        $id=$request->id;
        $obj = Referal::find($id);
        $pass_no=$obj->passport_no;

        $passport=Passport::where('passport_no',$pass_no)->first();
        if ($passport ==null){
            $message = [
                'message' => 'Passport Detail Not Colleceted Yet',
                'alert-type' => 'error'
            ];
            return  "Passport Detail Not Colleceted Yet";
        }else {


            $passport_id = $passport->id;
            $assing_platform = AssignPlateform::where('passport_id', $passport_id)->count();
            if ($assing_platform == '0') {
                $message = [
                    'message' => 'Platform Not Assigned Yet',
                    'alert-type' => 'error'
                ];
                return  "Platform Not Assigned Yet";
            }
        }



        $obj->credit_status = '2';
        $obj->credit_amount = $ref_set->amount;
        $obj->save();
        $message = [
            'message' => 'Credit Amount Status Changed to Paid',
            'alert-type' => 'success'
        ];
        return  "success";
    }

}
