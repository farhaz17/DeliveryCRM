<?php

namespace App\Http\Controllers\Career;

use App\Model\Assign\AssignPlateform;
use App\Model\Career\CareerHeardAboutUs;
use App\Model\Cities;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\Guest\Career;
use App\Model\Master\FourPl;
use App\Model\Nationality;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\Passport;
use App\Model\Platform;
use App\Model\Seeder\Followup_statuses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function foo\func;

class CareerDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  view('admin-panel.career.career_dashboard.index');
    }

    public function new_career_report(){

        $nations = Nationality::all();

        $referals = Career::whereNull('refer_by')->where('applicant_status','!=','4')->where('applicant_status','!=','1')
            ->where('applicant_status','!=','5')->orderby('refer_by','desc')->get();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $platforms = Platform::all();
        $cities = Cities::all();

        $fourpls = FourPl::all();

        $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
        $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
        $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5'])->get();


        return view('admin-panel.career.new_career.career_new_report',compact('from_sources','platforms','follow_up_status','referals','interview','nations'));
    }

    public function get_new_report_user_ajax(Request $request){

        $nations = Nationality::all();


        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $platforms = Platform::all();
        $cities = Cities::all();

        $fourpls = FourPl::all();

        $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
        $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
        $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5'])->get();


        if($request->ajax()){

            $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                ->where('interview_status','=','0')
                ->pluck('career_id')
                ->toArray();

            if($request->tab_name=="pending"){
                $referals = Career::whereNull('refer_by')
                    ->where('applicant_status','!=','4')
                    ->where(function ($query) {
                        $query->where('hire_status', '=', 0)
                            ->orwhereNull('hire_status');
                    })
                    ->where('applicant_status','!=','1')
                    ->where('applicant_status','!=','5')->orderby('refer_by','desc')->get();
            }elseif($request->tab_name=="waitlist"){

                $referals = Career::where('applicant_status','=','5')
                    ->where(function ($query) {
                        $query->where('hire_status', '=', 0)
                            ->orwhereNull('hire_status');
                    })
                    ->whereNull('refer_by')->orderby('id','desc')->get();

            }elseif($request->tab_name=="selected"){
                $referals = Career::whereNull('refer_by')->where('applicant_status','=','4')
                    ->where(function ($query) {
                        $query->where('hire_status', '=', 0)
                            ->orwhereNull('hire_status');
                    })
                    ->whereNotIn('id',$create_interviews)->get();

            }elseif($request->tab_name=="interview"){
                $referals = Career::whereNull('refer_by')
                    ->where(function ($query) {
                        $query->where('hire_status', '=', 0)
                            ->orwhereNull('hire_status');
                    })
                    ->whereIn('id',$create_interviews)->get();
            }elseif($request->tab_name=="onboard"){

                $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
                    ->where('on_board','=','1')->pluck('career_id')->toArray();

                $referals = Career::join('passports','passports.career_id','=','careers.id')
                    ->select('careers.*')
                    ->whereNull('careers.refer_by')->whereIn('careers.id',$onboards)->get();

            }elseif($request->tab_name=="only_pass"){


                $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
                    ->where('on_board','=','1')->pluck('career_id')->toArray();

                $referals = Career::select('careers.*')
                    ->whereNull('careers.refer_by')->whereIn('careers.id',$onboards)->get();

//                dd($referals->pluck('name'));

            }elseif($request->tab_name=="absent"){

                $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                    ->where('interview_status','=','3')
                    ->pluck('career_id')
                    ->toArray();

                $referals = Career::whereNull('refer_by')->where('hire_status','=','0')->whereIn('id',$create_interviews)->get();
            }elseif($request->tab_name=="hired"){

                $create_interviews =  CreateInterviews::join('interview_batches','interview_batches.id','=','create_interviews.interviewbatch_id')
                    ->where('interview_status','=','3')
                    ->pluck('career_id')
                    ->toArray();

                $passports = AssignPlateform::where('status','=','1')->pluck('passport_id')->toArray();
                $careers_id = Passport::whereIn('id',$passports)->pluck('career_id')->toArray();


                $referals = Career::whereNull('refer_by')->where('hire_status','=','0')->whereIn('id',$careers_id)->get();
            }



        }

        $tab = $request->tab_name;

        $view = view('admin-panel.career.new_career.career_new_report_ajax_render', compact('source_type_array','from_sources','tab','referals'))->render();
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

    public function hiring_pool_dashboard()
    {
        $careers = Career::with('interviews')->whereNotNull('promotion_type')->get();


        $selected_applications = $careers->filter(function($career) {
             return $career->applicant_status == 4;
        });
        $waiting_applications = $careers->filter(function($career) {
         return $career->applicant_status == 5;
        });
        $interviews = CreateInterviews::all(); //->filter(fn($career) => $career->whereHas('interviews') && $career->applicant_status == 5);
        $all_applications = [
            'Tiktok'    =>  $careers->filter(
                function($career){ return $career->promotion_type == 1; })->count()
            ,
            'Facebook'  =>  $careers->filter(function($career){ return $career->promotion_type == 2; })->count(),
            'Youtube'   =>  $careers->filter(function($career){ return $career->promotion_type == 3; })->count(),
            'Website'   =>  $careers->filter(function($career){ return $career->promotion_type == 4; })->count(),
            'Instagram' =>  $careers->filter(function($career){ return $career->promotion_type == 5; })->count(),
            'Friend'    =>  $careers->filter(function($career){ return $career->promotion_type == 6; })->count(),
            'Other'     =>  $careers->filter(function($career){ return $career->promotion_type == 7; })->count(),
            'Radio'     =>  $careers->filter(function($career){ return $career->promotion_type == 8; })->count(),
            'Restaurant'=>  $careers->filter(function($career){ return $career->promotion_type == 9; })->count(),
        ];
// dd($all_applications);
        return view('admin-panel.career.career_dashboard.test', compact('all_applications','careers'));
    }
}
