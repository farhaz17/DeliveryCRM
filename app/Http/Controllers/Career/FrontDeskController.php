<?php

namespace App\Http\Controllers\Career;

use App\Model\AgreedAmount;
use App\Model\Career\CareerHeardAboutUs;
use App\Model\DrivingLicense\DrivingLicense;
use Illuminate\Database\Eloquent\Model;
use Mail;
use Carbon\Carbon;
use App\Model\Cities;
use App\Model\FcmToken;
use App\Model\Platform;
use App\Model\Nationality;
use App\Mail\FrontdeskMail;
use App\Model\Guest\Career;
use App\Model\Notification;
use App\Model\RiderProfile;
use App\Model\Master\FourPl;
use CreateFrontdeskFollowup;
use Illuminate\Http\Request;
use App\Model\Referal\Referal;
use GuzzleHttp\Promise\Create;
use App\Model\Passport\Passport;
use App\Model\Career\RejoinCareer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Career\onboard_followup;
use App\Model\Career\waitlistfollowup;
use App\Model\Career\selected_followup;
use App\Model\Seeder\Followup_statuses;
use App\Model\Career\frontdesk_followup;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\InterviewBatch\InterviewBatch;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Package\Package;
use App\Model\RejoinCareerHitory;
use Illuminate\Support\Facades\Storage;

class FrontDeskController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Hiring-front-desk|Hiring-pool|Hiring-front-desk', ['only' => ['store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|Hiring-wait-list|Hiring-pool|Hiring-front-desk', ['only' => ['wait_list','store']]);
        $this->middleware('role_or_permission:Admin|Hiring-selected-candidate|Hiring-pool|Hiring-front-desk', ['only' => ['create','store','career_send_interview']]);
        $this->middleware('role_or_permission:Admin|Need_Licence', ['only' => ['need_to_take_licence']]);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $date_range = "2021-05-12";
        $passports = Passport::pluck('passport_no')->toArray();

//        $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')
//            ->where('applicant_status','!=','5')->orderby('refer_by','desc')->where('created_at','>',$date_range)->get();

        $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')
            ->where('applicant_status','!=','5')
            ->where('follow_up_status','=','0')
            ->where('source_type','=','3')
              ->whereNUll('career_bypass')
            ->whereDate('created_at',Carbon::today())->orderby('refer_by','desc')->get();


        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $platforms = Platform::all();
        $cities = Cities::all();

        $fourpls = FourPl::all();

        $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
        $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
        $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
        $followup_front = frontdesk_followup::where('status','0')->get();

        return view('admin-panel.career.new_career.front_desk',compact("followup_front","follow_up_status","waist_size",'shirt_size','fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'));

    }

    public function get_front_desk_table(Request $request){

        if($request->ajax()){
             $query = $request->tab_name;
             $query = $request->tab_name;
            if($query=="referal"){

                $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')
                    ->where('applicant_status','!=','5')
                    ->where('follow_up_status','=','0')
                    ->whereNotNull('refer_by')
                      ->whereNUll('career_bypass')
                    ->whereDate('created_at',Carbon::today())->orderby('refer_by','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();
                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

            }elseif($query=="walkin"){

                $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')
                    ->where('applicant_status','!=','5')
                    ->where('source_type','=','3')
                    ->whereDate('created_at',Carbon::today())
                      ->whereNUll('career_bypass')
                    ->orderby('refer_by','desc')
                    ->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

            }

        }

        $view = view('admin-panel.career.new_career.render_front_end_desk_tables',compact('query',"follow_up_status",'fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
        return response(['html' => $view]);
    }

    public function search_result_career(Request $request){

        if($request->ajax()){



            if(empty($request->search_name) && empty($request->start_created_date) && empty($request->end_created_date)){
                return "error";
            }

            if(!empty($request->start_created_date) && empty($request->end_created_date)){
                return "error_two";
            }

                    if(!empty($request->search_name) && !empty($request->start_created_date) && !empty($request->end_created_date))
                    {
                        $now_time = Carbon::parse($request->start_created_date)->startOfDay();
                        $end_time = Carbon::parse($request->end_created_date)->endOfDay();


                        $name = $request->search_name;
                        $created_at = $request->search_created_date;

                        $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')
                            ->where('applicant_status','!=','5')
                            ->where(function ($query) use ($name,$created_at) {
                                $query->where('name','LIKE','%'.$name.'%')
                                     ->orwhere('phone','LIKE','%'.$name.'%')
                                     ->orwhere('whatsapp','LIKE','%'.$name.'%')
                                     ->orwhere('email','LIKE','%'.$name.'%');

                            })
                            ->whereDate('created_at', '>=', $now_time)
                            ->whereDate('created_at', '<=', $end_time)
                              ->whereNUll('career_bypass')
                            ->orderby('refer_by','desc')
                            ->get();
                    }elseif(!empty($request->search_name) && empty($request->start_created_date) && empty($request->end_created_date)){
                        $name = $request->search_name;

                        $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')
                            ->where('applicant_status','!=','5')
                            ->where(function ($query) use ($name) {
                                $query->where('name','LIKE','%'.$name.'%')
                                    ->orwhere('phone','LIKE','%'.$name.'%')
                                    ->orwhere('whatsapp','LIKE','%'.$name.'%')
                                    ->orwhere('email','LIKE','%'.$name.'%');
                            })
                              ->whereNUll('career_bypass')
                            ->orderby('refer_by','desc')
                            ->get();


                    }elseif(empty($request->search_name) && !empty($request->start_created_date) && !empty($request->end_created_date)){



                        $now_time = Carbon::parse($request->start_created_date)->startOfDay();
                        $end_time = Carbon::parse($request->end_created_date)->endOfDay();



                        $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')
                            ->where('applicant_status','!=','5')
                            ->whereDate('created_at', '>=', $now_time)
                            ->whereDate('created_at', '<=', $end_time)
                              ->whereNUll('career_bypass')
                            ->orderby('refer_by','desc')
                            ->get();

                    }



                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

            $view = view('admin-panel.career.new_career.search_candidate_render',compact("follow_up_status",'fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
            return response(['html' => $view]);

        }

    }


    public function search_result_career_wait_list(Request $request){

        if($request->ajax()){



            if(empty($request->search_name) && empty($request->start_created_date) && empty($request->end_created_date)){
                return "error";
            }

            if(!empty($request->start_created_date) && empty($request->end_created_date)){
                return "error_two";
            }

            if(!empty($request->search_name) && !empty($request->start_created_date) && !empty($request->end_created_date))
            {
                $now_time = Carbon::parse($request->start_created_date)->startOfDay();
                $end_time = Carbon::parse($request->end_created_date)->endOfDay();


                $name = $request->search_name;
                $created_at = $request->search_created_date;

                $careers = Career::where('applicant_status','=','5')
                    ->where(function ($query) use ($name,$created_at) {
                        $query->where('name','LIKE','%'.$name.'%')
                            ->orwhere('phone','LIKE','%'.$name.'%')
                            ->orwhere('whatsapp','LIKE','%'.$name.'%')
                            ->orwhere('email','LIKE','%'.$name.'%');

                    })
                    ->whereDate('updated_at', '>=', $now_time)
                    ->whereDate('updated_at', '<=', $end_time)
                      ->whereNUll('career_bypass')
                    ->orderby('refer_by','desc')
                    ->get();
            }elseif(!empty($request->search_name) && empty($request->start_created_date) && empty($request->end_created_date)){
                $name = $request->search_name;

                $careers = Career::where('applicant_status','=','5')
                    ->where(function ($query) use ($name) {
                        $query->where('name','LIKE','%'.$name.'%')
                            ->orwhere('phone','LIKE','%'.$name.'%')
                            ->orwhere('whatsapp','LIKE','%'.$name.'%')
                            ->orwhere('email','LIKE','%'.$name.'%');
                    })
                      ->whereNUll('career_bypass')
                    ->orderby('refer_by','desc')
                    ->get();


            }elseif(empty($request->search_name) && !empty($request->start_created_date) && !empty($request->end_created_date)){



                $now_time = Carbon::parse($request->start_created_date)->startOfDay();
                $end_time = Carbon::parse($request->end_created_date)->endOfDay();



                $careers = Career::where('applicant_status','=','5')
                    ->whereDate('updated_at', '>=', $now_time)
                    ->whereDate('updated_at', '<=', $end_time)
                      ->whereNUll('career_bypass')
                    ->orderby('refer_by','desc')
                    ->get();

            }



            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

            $from_sources = CareerHeardAboutUs::all();

            $platforms = Platform::all();
            $cities = Cities::all();

            $fourpls = FourPl::all();

            $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

            $view = view('admin-panel.career.new_career.search_candidate_render',compact("follow_up_status",'fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
            return response(['html' => $view]);

        }

    }

    public function filter_data_career(Request $request){

        if($request->ajax()){

            if($request->tab=="1" &&  $request->type=="wait_list"){

                if(isset($request->visa_month)){
                    if($request->visa_status=="1"){

                        $careers = Career::where('applicant_status','=','5')
                            ->where('employee_type','=','1')
                            ->where('new_taken_licence','=','0')
                            ->where('vehicle_type','=',$request->apply_for)
                            ->where('visa_status','=',$request->visa_status)
                            ->where('visa_status_visit','=',$request->visa_month)
                              ->whereNUll('career_bypass')
                            ->orderby('id','desc')->get();
                    }

               }elseif(isset($request->cancel_type)){

                    $careers = Career::where('applicant_status','=','5')
                        ->where('employee_type','=','1')
                        ->where('new_taken_licence','=','0')
                        ->where('vehicle_type','=',$request->apply_for)
                        ->where('visa_status','=',$request->visa_status)
                        ->where('visa_status_cancel','=',$request->cancel_type)
                        ->orderby('id','desc')->get();

               }elseif(isset($request->own_visa_type)){
                    $careers = Career::where('applicant_status','=','5')
                        ->where('employee_type','=','1')
                        ->where('new_taken_licence','=','0')
                        ->where('vehicle_type','=',$request->apply_for)
                        ->where('visa_status','=',$request->visa_status)
                        ->where('visa_status_own','=',$request->own_visa_type)
                          ->whereNUll('career_bypass')
                        ->orderby('id','desc')->get();

                }elseif(isset($request->only_apply_type)){
                    $careers = Career::where('applicant_status','=','5')
                        ->where('employee_type','=','1')
                        ->where('new_taken_licence','=','0')
                        ->where('vehicle_type','=',$request->apply_for)
                          ->whereNUll('career_bypass')
                        ->orderby('id','desc')->get();
                }else{
                    $careers = Career::where('applicant_status','=','5')
                        ->where('employee_type','=','1')
                        ->where('new_taken_licence','=','0')
                        ->where('vehicle_type','=',$request->apply_for)
                        ->where('visa_status','=',$request->visa_status)
                          ->whereNUll('career_bypass')
                        ->orderby('id','desc')->get();
                }


                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif($request->tab=="2"  &&  $request->type=="wait_list"){

                $careers = Career::where('applicant_status','=','5')
                    ->where('new_taken_licence','=','0')
                    ->where('employee_type','=',2)
                    ->where('vehicle_type','=',$request->apply_for)
                    ->orderby('id','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }  elseif(isset($request->only_apply_for_take)  &&  $request->type=="new_taken_wait_list"){

                $new_taken_careers = Career::where('applicant_status','=','5')
                    ->where('employee_type','=',1)
                    ->where('new_taken_licence','=',1)
                    ->where('vehicle_type','=',$request->apply_for)
                    ->orderby('id','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','new_taken_careers','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif($request->tab=="3"  &&  $request->type=="new_taken_wait_list"){

                $new_taken_careers = Career::where('applicant_status','=','5')
                    ->where('employee_type','=',1)
                    ->where('new_taken_licence','=',1)
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->visa_status)
                      ->whereNUll('career_bypass')
                    ->orderby('id','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','new_taken_careers','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif($request->tab=="2"  &&  $request->type=="new_taken_wait_list" && isset($request->visa_month)){

                $new_taken_careers = Career::where('applicant_status','=','5')
                    ->where('employee_type','=',1)
                    ->where('new_taken_licence','=',1)
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->visa_status)
                    ->where('visa_status_visit','=',$request->visa_month)
                      ->whereNUll('career_bypass')
                    ->orderby('id','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','new_taken_careers','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif($request->tab=="2"  &&  $request->type=="new_taken_wait_list" && isset($request->cancel_visa_status)){

                $new_taken_careers = Career::where('applicant_status','=','5')
                    ->where('employee_type','=',1)
                    ->where('new_taken_licence','=',1)
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->visa_status)
                    ->where('visa_status_cancel','=',$request->cancel_visa_status)
                      ->whereNUll('career_bypass')
                    ->orderby('id','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','new_taken_careers','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif($request->tab=="2"  &&  $request->type=="new_taken_wait_list" && isset($request->own_visa_status)){

                $new_taken_careers = Career::where('applicant_status','=','5')
                    ->where('employee_type','=',1)
                    ->where('new_taken_licence','=',1)
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->visa_status)
                    ->where('visa_status_own','=',$request->own_visa_status)
                      ->whereNUll('career_bypass')
                    ->orderby('id','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','new_taken_careers','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif(isset($request->selected_company_only_apply)  &&  $request->type=="selected_company"){


                $passports = Passport::pluck('passport_no')->toArray();

                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

                $company_rider = Career::orderby('id','desc')
                    ->where('applicant_status','=','4')
                    ->where('employee_type','=','1')
                    ->where('vehicle_type','=',$request->apply_for)
                      ->whereNUll('career_bypass')
                    ->whereNotIn('id',$interviews)->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('company_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif(isset($request->only_visa_status)  &&  $request->type=="selected_company"){


                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

                $company_rider = Career::orderby('id','desc')
                    ->where('applicant_status','=','4')
                    ->where('employee_type','=','1')
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->only_visa_status)
                      ->whereNUll('career_bypass')
                    ->whereNotIn('id',$interviews)->get();


                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('company_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);
            }elseif(isset($request->visa_month) &&  $request->type=="selected_company"){


                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

                $company_rider = Career::orderby('id','desc')
                    ->where('applicant_status','=','4')
                    ->where('employee_type','=','1')
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->visa_status)
                    ->where('visa_status_visit','=',$request->visa_month)
                      ->whereNUll('career_bypass')
                    ->whereNotIn('id',$interviews)->get();


                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('company_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif(isset($request->cancel_type) &&  $request->type=="selected_company"){

                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

                $company_rider = Career::orderby('id','desc')
                    ->where('applicant_status','=','4')
                    ->where('employee_type','=','1')
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->visa_status)
                    ->where('visa_status_cancel','=',$request->cancel_type)
                      ->whereNUll('career_bypass')
                    ->whereNotIn('id',$interviews)->get();


                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('company_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }elseif(isset($request->own_visa_type) &&  $request->type=="selected_company"){

                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

                $company_rider = Career::orderby('id','desc')
                    ->where('applicant_status','=','4')
                    ->where('employee_type','=','1')
                    ->where('vehicle_type','=',$request->apply_for)
                    ->where('visa_status','=',$request->visa_status)
                    ->where('visa_status_own','=',$request->own_visa_type)
                      ->whereNUll('career_bypass')
                    ->whereNotIn('id',$interviews)->get();


                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('company_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);
            }elseif(isset($request->fourpl_only_apply)  &&  $request->type=="selected_fourpl"){


                $passports = Passport::pluck('passport_no')->toArray();


                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();


                $four_pl_rider = Career::orderby('id','desc')
                                        ->where('applicant_status','=','4')
                                        ->where('employee_type','=','2')
                                        ->where('vehicle_type','=',$request->apply_for)
                                        ->whereNotIn('passport_no',$passports)
                                          ->whereNUll('career_bypass')
                                        ->whereNotIn('id',$interviews)->get();


                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();
                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_data_career_render',compact('four_pl_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }




        }

    }

//package filter
    public function filter_data_by_package(Request $request){

        if($request->ajax()){


            $pkg_id = $request->pkg_id;

            if($request->type=="selected_company"){ //for selected type

                $passports = Passport::pluck('passport_no')->toArray();

                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

                $company_rider = Career::orderby('id','desc')
                    ->where('applicant_status','=','4')
                    ->where('employee_type','=','1')
                      ->whereNUll('career_bypass')
                      ->where('pkg_id',$pkg_id)
                    ->whereNotIn('id',$interviews)->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_date_package',compact('company_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);


            }elseif($request->type=="fourpl_rider"){

                $passports = Passport::pluck('passport_no')->toArray();

                $interviews = CreateInterviews::where(function ($query)  {
                    $query->where('interview_status', '=', '0')
                        ->orwhere('interview_status', '=', '1');
                })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();


                $four_pl_rider = Career::orderby('id','desc')
                ->where('applicant_status','=','4')
                ->where('employee_type','=','2')
                ->whereNotIn('passport_no',$passports)
                  ->whereNUll('career_bypass')
                  ->where('pkg_id',$pkg_id)
                ->whereNotIn('id',$interviews)->get();


                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

                $tab = $request->tab;
                $type = $request->type;

                $view = view('admin-panel.career.new_career.filter_date_package',compact('four_pl_rider','type','tab',"follow_up_status",'fourpls','platforms','cities','platforms','from_sources','source_type_array'))->render();
                return response(['html' => $view]);

            }



        }

    }



    public function filter_data_counts(Request $request){

        if($request->ajax()){


           if(isset($request->only_apply_for) && $request->type=="wait_list"){

               $careers = Career::where('applicant_status','=','5')
                   ->where('employee_type','=','1')
                   ->where('new_taken_licence','=','0')
                   ->where('vehicle_type','=',$request->apply_for)
                     ->whereNUll('career_bypass')
                   ->get();

               $array_to_send = array(
                   'visit_visa_count' =>  $careers->where('visa_status','=','1')->count(),
                   'cancel_visa_count' => $careers->where('visa_status','=','2')->count(),
                   'own_visa_count' => $careers->where('visa_status','=','3')->count(),
               );

               echo json_encode($array_to_send);
               exit;

           }elseif(isset($request->visa_status) && $request->type=="wait_list"){


               $careers = Career::where('applicant_status','=','5')
                   ->where('employee_type','=','1')
                   ->where('new_taken_licence','=','0')
                   ->where('vehicle_type','=',$request->apply_for)
                   ->where('visa_status','=',$request->visa_status)
                     ->whereNUll('career_bypass')
                   ->get();

               if($request->visa_status=="1"){

                   $array_to_send = array(
                       'one_month_count' =>  $careers->where('visa_status_visit','=','1')->count(),
                       'three_month_count' => $careers->where('visa_status_visit','=','2')->count(),
                   );

                   echo json_encode($array_to_send);
                   exit;

               }elseif($request->visa_status=="2"){

                   $array_to_send = array(
                       'free_zone_count' =>  $careers->where('visa_status_cancel','=','1')->count(),
                       'company_visa_count' => $careers->where('visa_status_cancel','=','2')->count(),
                       'waiting_cancellation_count' => $careers->where('visa_status_cancel','=','3')->count(),
                   );

                   echo json_encode($array_to_send);
                   exit;

               }elseif($request->visa_status=="3"){

                   $array_to_send = array(
                       'noc_count' =>  $careers->where('visa_status_own','=','1')->count(),
                       'without_noc_count' => $careers->where('visa_status_own','=','2')->count(),
                   );

                   echo json_encode($array_to_send);
                   exit;

               }

           }elseif($request->type=="new_taken"){

               if(isset($request->new_taken)){

                   $new_taken_careers = Career::where('applicant_status','=','5')
                       ->where('employee_type','=','1')
                       ->where('new_taken_licence','=','1')
                       ->where('vehicle_type','=',$request->apply_for)
                       ->orderby('id','desc')->get();

                         $array_to_send = array(
                             'visit_visa_count' =>  $new_taken_careers->where('visa_status','=','1')->count(),
                             'cancel_visa_count' => $new_taken_careers->where('visa_status','=','2')->count(),
                             'own_visa_count' => $new_taken_careers->where('visa_status','=','3')->count(),
                         );

               echo json_encode($array_to_send);
               exit;
               }elseif(isset($request->visa_status)){


                   if($request->visa_status=="1"){

                       $new_taken_careers = Career::where('applicant_status','=','5')
                           ->where('employee_type','=','1')->where('new_taken_licence','=','1')
                           ->where('vehicle_type','=',$request->apply_for)
                           ->where('visa_status','=',"1")
                             ->whereNUll('career_bypass')
                           ->orderby('id','desc')->get();

                       $array_to_send = array(
                           'one_month_count' =>  $new_taken_careers->where('visa_status_visit','=','1')->count(),
                           'three_month_count' => $new_taken_careers->where('visa_status_visit','=','2')->count(),
                       );

                       echo json_encode($array_to_send);
                       exit;

                   }elseif($request->visa_status=="2"){

                       $new_taken_careers = Career::where('applicant_status','=','5')
                           ->where('employee_type','=','1')->where('new_taken_licence','=','1')
                           ->where('vehicle_type','=',$request->apply_for)
                           ->where('visa_status','=',"2")
                             ->whereNUll('career_bypass')
                           ->orderby('id','desc')->get();

                       $array_to_send = array(
                           'free_zone_count' =>  $new_taken_careers->where('visa_status_cancel','=','1')->count(),
                           'company_visa_count' => $new_taken_careers->where('visa_status_cancel','=','2')->count(),
                           'waiting_cancellation_count' => $new_taken_careers->where('visa_status_cancel','=','3')->count(),
                       );

                       echo json_encode($array_to_send);
                       exit;

                   }elseif($request->visa_status=="3"){

                       $new_taken_careers = Career::where('applicant_status','=','5')
                           ->where('employee_type','=','1')->where('new_taken_licence','=','1')
                           ->where('vehicle_type','=',$request->apply_for)
                           ->where('visa_status','=',"3")
                             ->whereNUll('career_bypass')
                           ->orderby('id','desc')->get();

                       $array_to_send = array(
                           'noc_count' =>  $new_taken_careers->where('visa_status_own','=','1')->count(),
                           'without_noc_count' => $new_taken_careers->where('visa_status_own','=','2')->count(),
                       );

                       echo json_encode($array_to_send);
                       exit;

                   }


               }

           }elseif($request->type=="selected_company" && isset($request->only_apply_for)){


               $interviews = CreateInterviews::where(function ($query) {
                   $query->where('interview_status', '=', '0')
                       ->orwhere('interview_status', '=', '1');
               })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

               $company_rider = Career::orderby('id','desc')
                   ->where('applicant_status','=','4')
                   ->where('employee_type','=','1')
                   ->where('vehicle_type','=',$request->apply_for)
                     ->whereNUll('career_bypass')
                   ->whereNotIn('id',$interviews)->get();


               $array_to_send = array(
                   'visit_visa_count' =>  $company_rider->where('visa_status','=','1')->count(),
                   'cancel_visa_count' => $company_rider->where('visa_status','=','2')->count(),
                   'own_visa_count' => $company_rider->where('visa_status','=','3')->count(),
               );

               echo json_encode($array_to_send);
               exit;
           }elseif($request->type=="selected_company" && isset($request->only_visa_status)){


               $interviews = CreateInterviews::where(function ($query) {
                   $query->where('interview_status', '=', '0')
                       ->orwhere('interview_status', '=', '1');
               })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

               $company_rider = Career::orderby('id','desc')
                   ->where('applicant_status','=','4')
                   ->where('employee_type','=','1')
                   ->where('vehicle_type','=',$request->apply_for)
                   ->where('visa_status','=',$request->only_visa_status)
                     ->whereNUll('career_bypass')
                   ->whereNotIn('id',$interviews)->get();

               if($request->only_visa_status=="1"){

                   $array_to_send = array(
                       'one_month_count' =>  $company_rider->where('visa_status_visit','=','1')->count(),
                       'three_month_count' => $company_rider->where('visa_status_visit','=','2')->count(),
                   );

                   echo json_encode($array_to_send);
                   exit;

               }elseif($request->only_visa_status=="2"){

                   $array_to_send = array(
                       'free_zone_count' =>  $company_rider->where('visa_status_cancel','=','1')->count(),
                       'company_visa_count' => $company_rider->where('visa_status_cancel','=','2')->count(),
                       'waiting_cancellation_count' => $company_rider->where('visa_status_cancel','=','3')->count(),
                   );

                   echo json_encode($array_to_send);
                   exit;

               }elseif($request->only_visa_status=="3"){

                   $array_to_send = array(
                       'noc_count' =>  $company_rider->where('visa_status_own','=','1')->count(),
                       'without_noc_count' => $company_rider->where('visa_status_own','=','2')->count(),
                   );

                   echo json_encode($array_to_send);
                   exit;

               }

           }



        }

    }



    public function search_result_career_selected(Request $request){



        if($request->ajax()){

            $passports = Passport::pluck('passport_no')->toArray();


            $interviews = CreateInterviews::where(function ($query)  {
                $query->where('interview_status', '=', '0')
                    ->orwhere('interview_status', '=', '1');
            })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();

            $company_rider = Career::orderby('id','desc')
                            ->where('applicant_status','=','4')
                            ->where('employee_type','=','1')
                              ->whereNUll('career_bypass')
                            ->whereNotIn('id',$interviews)->get();
            $four_pl_rider = Career::orderby('id','desc')
                                    ->where('applicant_status','=','4')
                                    ->where('employee_type','=','2')
                                    ->whereNotIn('passport_no',$passports)
                                      ->whereNUll('career_bypass')
                                    ->whereNotIn('id',$interviews)->get();

            if(empty($request->search_name) && empty($request->start_created_date) && empty($request->end_created_date)){
                return "error";
            }

            if(!empty($request->start_created_date) && empty($request->end_created_date)){
                return "error_two";
            }

            if(!empty($request->search_name) && !empty($request->start_created_date) && !empty($request->end_created_date))
            {
                $now_time = Carbon::parse($request->start_created_date)->startOfDay();
                $end_time = Carbon::parse($request->end_created_date)->endOfDay();


                $name = $request->search_name;
                $created_at = $request->search_created_date;

                $careers = Career::where('applicant_status','=','4')
                    ->where(function ($query) use ($name    ) {
                        $query->where('name','LIKE','%'.$name.'%')
                            ->orwhere('phone','LIKE','%'.$name.'%')
                            ->orwhere('whatsapp','LIKE','%'.$name.'%')
                            ->orwhere('email','LIKE','%'.$name.'%');

                    })
                    ->whereNotIn('passport_no',$passports)
                    ->whereNotIn('id',$interviews)
                    ->whereDate('updated_at', '>=', $now_time)
                    ->whereDate('updated_at', '<=', $end_time)
                      ->whereNUll('career_bypass')
                    ->orderby('refer_by','desc')
                    ->get();
            }elseif(!empty($request->search_name) && empty($request->start_created_date) && empty($request->end_created_date)){
                $name = $request->search_name;

                $careers = Career::where('applicant_status','=','4')
                    ->where(function ($query) use ($name) {
                        $query->where('name','LIKE','%'.$name.'%')
                            ->orwhere('phone','LIKE','%'.$name.'%')
                            ->orwhere('whatsapp','LIKE','%'.$name.'%')
                            ->orwhere('email','LIKE','%'.$name.'%');
                    })
                    ->whereNotIn('passport_no',$passports)
                    ->whereNotIn('id',$interviews)
                      ->whereNUll('career_bypass')
                    ->orderby('refer_by','desc')
                    ->get();


            }elseif(empty($request->search_name) && !empty($request->start_created_date) && !empty($request->end_created_date)){



                $now_time = Carbon::parse($request->start_created_date)->startOfDay();
                $end_time = Carbon::parse($request->end_created_date)->endOfDay();



                $careers = Career::where('applicant_status','=','4')
                    ->whereDate('updated_at', '>=', $now_time)
                    ->whereDate('updated_at', '<=', $end_time)
                    ->whereNotIn('passport_no',$passports)
                    ->whereNotIn('id',$interviews)
                      ->whereNUll('career_bypass')
                    ->orderby('refer_by','desc')
                    ->get();

            }



            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

            $from_sources = CareerHeardAboutUs::all();

            $platforms = Platform::all();
            $cities = Cities::all();

            $fourpls = FourPl::all();

            $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5','10','11','12'])->get();

            $view = view('admin-panel.career.new_career.search_candidate_render',compact("follow_up_status",'fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
            return response(['html' => $view]);

        }

    }





    public function wait_list()
    {




        $passports = Passport::pluck('passport_no')->toArray();

        $careers = Career::where('applicant_status','=','5')
            ->where(function ($query) {
                $query->where('employee_type','=','1')
                    ->orwhere('employee_type','=','0');
            })
            ->where('new_taken_licence','=','0')
              ->whereNUll('career_bypass')
            ->orderby('id','desc')->get();

        $new_taken_careers = Career::where('applicant_status','=','5')->where('employee_type','=','1')->where('new_taken_licence','=','1')->orderby('id','desc')  ->whereNUll('career_bypass')->get();
        $four_pl = Career::where('applicant_status','=','5')->where('employee_type','=',2)->where('new_taken_licence','=','0')  ->whereNUll('career_bypass')->get();

        $cancel_passport_array = Passport::where('cancel_status','=','1')->pluck('id')->toArray();

        $rejoin_candidate = RejoinCareer::where('applicant_status','=','5')
                                         ->where('on_board','=','0')
                                         ->where('hire_status','=',0)
                                         ->whereNotIn('passport_id',$cancel_passport_array)
                                         ->get();

        $followup_waitlist = waitlistfollowup::where('status','0')->get();




        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $platforms = Platform::all();
        $cities = Cities::all();

        $fourpls = FourPl::all();

        $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
        $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
        $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5'])->get();

        return view('admin-panel.career.new_career.wait_list',compact("new_taken_careers","followup_waitlist",'rejoin_candidate',"four_pl","follow_up_status","waist_size",'shirt_size','fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'));

    }


    public function rejoin_reject_save(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'primary_id_rejected' => 'required',
                'reject_rejoin_reason' => 'required'

            ]);

                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }

                $status = "1";
                $primary_id = $request->primary_id_rejected;

                $rejoin_table = RejoinCareer::find($primary_id);
                $past_status = $rejoin_table->applicant_status;
                $rejoin_table->past_status = $past_status;
                $rejoin_table->applicant_status = $status;
                $passport_id = $rejoin_table->passport_id;
                $rejoin_table->update();

                $rejoin_history = new RejoinCareerHitory();
                $rejoin_history->passport_id  = $passport_id;
                $rejoin_history->status = $status;
                $rejoin_history->past_status = $past_status;
                $rejoin_history->user_id = Auth::user()->id;
                $rejoin_history->remarks = $request->reject_rejoin_reason;
                $rejoin_history->save();


                $message = [
                    'message' => "Rider has been rejected successfully",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
        }
        catch (\Illuminate\Database\QueryException $e){

            dd($e);
            $message = [
                'message' => "Error Occured",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


    }


    public function need_to_take_licence()
    {



        $passports = Passport::pluck('passport_no')->toArray();

        $careers = Career::
        // where('applicant_status','!=','4')
             where('applicant_status','!=','1')
            ->where('applicant_status','!=','5')
            ->where('employee_type','=','1')
            ->where('licence_status','=','2')
              ->whereNUll('career_bypass')
            ->orderby('refer_by','desc')
        ->orderby('id','desc')->get();

//        $four_pl = Career::where('employee_type','=',2)
//             ->where('applicant_status','!=','4')->where('applicant_status','!=','1')
//                 ->where('applicant_status','!=','5')
//                 ->where('employee_type','=','1')
//                 ->where('licence_status','=','2')
//                 ->orderby('id','desc')->get();


        $rejoin_candidate = RejoinCareer::where('applicant_status','=','5')->where('on_board','=','0')->where('hire_status','=',0)->get();



        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $platforms = Platform::all();
        $cities = Cities::all();

        $fourpls = FourPl::all();

        $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
        $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
        $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5'])->get();

        return view('admin-panel.career.new_career.need_to_take_licence',compact('rejoin_candidate',"follow_up_status","waist_size",'shirt_size','fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'));

    }

    public function career_report(){


        $careers = Career::orderby('id','desc')  ->whereNUll('career_bypass')->limit(400)->get();

        $licence_status_array = array('','YES',"NO");
        $applying_for_array = array('','Bike',"Car","Both");
        $visa_status_type = array('','Visit Visa',"Cancel Visa","Own Visa");


        $rejoins = RejoinCareer::where('hire_status','=','0')->get();

        return view('admin-panel.career.new_career.career_reports_candidate_wise',compact('rejoins','visa_status_type','applying_for_array','careers','licence_status_array'));
    }

    public function career_report_ajax(Request $request){

        if($request->ajax()){

            $request_type = $request->request_type;

            if($request_type=="1"){

                $careers = Career::orderby('id','desc')  ->whereNUll('career_bypass')->limit(400)->get();

        $licence_status_array = array('','YES',"NO");
        $applying_for_array = array('','Bike',"Car","Both");
        $visa_status_type = array('','Visit Visa',"Cancel Visa","Own Visa");




        $view = view('admin-panel.career.new_career.career_reports_candidate_wise_ajax',compact('request_type','visa_status_type','applying_for_array','careers','licence_status_array'))->render();

            }else{

                $rejoins = RejoinCareer::where('hire_status','=','0')->get();

                $view = view('admin-panel.career.new_career.career_reports_candidate_wise_ajax',compact('request_type','rejoins'))->render();

            }



        return response(['html' => $view]);


        }



    }

    public function get_creeer_wise_report_agreed_amount_detail(Request  $request){

        if($request->ajax()){

            $primary_id = $request->primary_id;
            $agreed_amoount = AgreedAmount::find($primary_id);

            $view = view('admin-panel.career.new_career.get_career_report_candidate_wise_table',compact('agreed_amoount'))->render();
            return response(['html' => $view]);

        }


    }

    public function career_report_rnder_slider(Request  $request){

        if($request->ajax()){

            $primray_id = $request->primary_id;
            if($request->type=="1"){



            $career = Career::find($primray_id);

            $documents = json_decode($career->physical_document);

            $passport = Passport::where('career_id','=',$primray_id)->first();
            $agreed_amounts = "";
            if($passport != null){
                 $agreed_amounts = AgreedAmount::where('passport_id','=',$passport->id)->first();
            }


            }else{

                $passport = Passport::where('career_id','=',$primray_id)->first();
                           $agreed_amounts = AgreedAmount::where('passport_id','=',$primray_id)->first();

                           $documents = array();

                           if(isset($passport->career_id)){

                            $career_id = $passport->career_id;
                               $career = Career::find($primray_id);

                                   $documents = json_decode($career->physical_document);

                           }



            }



            $view = view('admin-panel.career.new_career.render_career_report_slider',compact('agreed_amounts','documents'))->render();
            return response(['html' => $view]);

        }

    }

    public function send_to_wait_list_only(Request $request){

        try {

            $validator = Validator::make($request->all(), [
                'status_type' => 'required',
                'career_primary_id' => 'required'

            ]);

                if ($validator->fails()) {
                    $validate = $validator->errors();
                    return $validate->first();
                }

                $career_data = Career::find($request->career_primary_id);
                $career_data->applicant_status = 5;
                $career_data->update();

                return "success";


        }
        catch (\Illuminate\Database\QueryException $e){

            return "Error Occured";
        }

    }



    public function save_driving_license(Request $request){

        try {
        // $validator = Validator::make($request->all(), [
        //     'edit_license_number' => 'required|unique:driving_licenses,license_number',
        //     'edit_traffic_cod' => 'required|unique:driving_licenses,traffic_code',
        //     'edit_issue_date' => 'required',
        //     'edit_expire_date' => 'required',
        //     'image_update' => 'mimes:jpeg,jpg,png,gif|max:10000',
        //     'image_back_update' => 'mimes:jpeg,jpg,png,gif|max:10000',
        //     'licence_city' => 'required',
        //     'career_primary_id' => 'required'

        // ]);

        //     if ($validator->fails()) {
        //         $validate = $validator->errors();

        //         return $validate->first();
        //     }

         $passport_detail = Passport::where('career_id','=',$request->career_primary_id)->first();

         $passport_id = "";

         if($passport_detail==null){
             return "No PPUID Found.!";
         }else{
             $passport_id  = $passport_detail->id;
         }

             $is_driving_license= DrivingLicense::where('passport_id','=',$passport_id)->first();

         if($is_driving_license != null){
             return "passport id already taken";
         }





        if (!file_exists('../public/assets/upload/driving_licence_img/front')) {
            mkdir('../public/assets/upload/driving_licence_img/front', 0777, true);
        }

        if(!empty($_FILES['image_update']['name'])) {

            $ext = pathinfo($_FILES['image_update']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["image_update"]["tmp_name"], '../public/assets/upload/driving_licence_img/front/' . $file_name);
            $file_path_image = 'assets/upload/driving_licence_img/front/' . $file_name;
        }

        if (!file_exists('../public/assets/upload/driving_licence_img/back')) {
            mkdir('../public/assets/upload/driving_licence_img/back', 0777, true);
        }

        if(!empty($_FILES['image_back_update']['name'])) {

            $ext = pathinfo($_FILES['image_back_update']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["image_back_update"]["tmp_name"], '../public/assets/upload/driving_licence_img/back/' . $file_name);
            $file_path_image_back = 'assets/upload/driving_licence_img/back/' . $file_name;
        }


        $randnum = rand(1111111111,9999999999);


        $driving_license  = new DrivingLicense();
        $driving_license->passport_id = $passport_id;
        $driving_license->license_number = isset($request->edit_license_number) ? $request->edit_license_number:  $randnum;
        $driving_license->issue_date = isset($request->edit_issue_date) ? date('Y-m-d', strtotime($request->edit_issue_date)) : '2022-01-01 00:00:00';
        $driving_license->expire_date =  isset($request->edit_expire_date) ? date('Y-m-d', strtotime($request->edit_expire_date)) : '2022-01-01 00:00:00';
        $driving_license->place_issue = $request->edit_place_issue;
        $driving_license->traffic_code = $request->edit_traffic_cod;

        $driving_license->license_type =  $request->edit_license_type;
        if($request->edit_license_type=="1"){
            $driving_license->car_type =  null;
        }else{
            $driving_license->car_type =  $request->edit_car_type;
        }

        if(!empty($file_path_image)){
            $driving_license->image =  $file_path_image;
        }
        if(!empty($file_path_image_back)){
            $driving_license->back_image =  $file_path_image_back;
        }
        if(isset($request->expo) && $request->expo == 1) {
            $driving_license->expo_bypass = 1;
        }
        $driving_license->save();


         $career_data = Career::find($request->career_primary_id);
         $career_data->new_taken_licence = "1";
         $career_data->applicant_status = 5;
         $career_data->licence_status = 1;
         $career_data->update();

            $career_history = new CareerStatusHistory();
            $career_history->career_id = $request->career_primary_id;
            $career_history->status = 5;
            $career_history->save();




        return "success";


        }
        catch (\Illuminate\Database\QueryException $e){

            return "Error Occured";
        }

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $passports = Passport::pluck('passport_no')->toArray();


        $interviews = CreateInterviews::where(function ($query)  {
                                        $query->where('interview_status', '=', '0')
                                       ->orwhere('interview_status', '=', '1');
                                       })->where('return_from_onboard','=','0')->pluck('career_id')->toArray();


        $return_to_onboard =  CreateInterviews::where('return_from_onboard','=','1')->pluck('career_id')->toArray();




        $company_rider = Career::orderby('id','desc')->where('applicant_status','=','4')
            ->where(function ($query) {
                $query->where('employee_type','=','1')
                    ->orwhere('employee_type','=','0');
            })
              ->whereNUll('career_bypass')
            ->whereNotIn('id',$interviews)->orwhereIn('id',$return_to_onboard)->get();


        $pkg_id_company_rider = Career::orderby('id','desc')->where('applicant_status','=','4')
        ->where(function ($query) {
            $query->where('employee_type','=','1')
                ->orwhere('employee_type','=','0');

        })
        ->whereNUll('career_bypass')
        ->whereNotIn('id',$interviews)->orwhereIn('id',$return_to_onboard)
        ->pluck('pkg_id')->toArray();


        $company_pkg = Package::whereIn('id',$pkg_id_company_rider)->get();



        $four_pl_rider = Career::orderby('id','desc')
                            ->where('applicant_status','=','4')
            ->where('employee_type','=','2')
            ->whereNotIn('passport_no',$passports)
              ->whereNUll('career_bypass')
            ->whereNotIn('id',$interviews)->orwhereIn('id',$return_to_onboard)->get();



        $pkg_id_fourpl_rider = Career::orderby('id','desc')
        ->where('applicant_status','=','4')
        ->where('employee_type','=','2')
        ->whereNotIn('passport_no',$passports)
        ->whereNUll('career_bypass')
        ->whereNotIn('id',$interviews)->orwhereIn('id',$return_to_onboard)->pluck('pkg_id')->toArray();


        $fourpl_pkg = Package::whereIn('id',$pkg_id_fourpl_rider)->get();




            $cancel_passport_array = Passport::where('cancel_status','=','1')->pluck('id')->toArray();

        $rejoin_candidate = RejoinCareer::where('applicant_status','=','4')
                                        ->where('on_board','=','0')
                                          ->where('hire_status','=',0)
                                          ->whereNotIn('passport_id',$cancel_passport_array)
                                          ->get();


        $company_rider = Career::orderby('id','desc')
                                ->where('applicant_status','=','4')
                                ->where('employee_type','=','1')
                                ->whereNUll('career_bypass')
                                ->whereNotIn('id',$interviews)->get();
        $four_pl_rider = Career::orderby('id','desc')
                                    ->where('applicant_status','=','4')
                                    ->where('employee_type','=','2')
                                      ->whereNUll('career_bypass')
                                    ->whereNotIn('id',$interviews)->get();
        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $platforms = Platform::all();
        $cities = Cities::all();

        $nations = Nationality::all();

        $platforms = Platform::all();

        $batches = InterviewBatch::where('is_complete','=','0')->get();
        $followup_selected = selected_followup::where('status','0')->get();

        return view('admin-panel.career.new_career.selected_candidate',compact("fourpl_pkg","company_pkg","followup_selected",'rejoin_candidate','batches','nations','platforms','cities','platforms','four_pl_rider','company_rider','from_sources','source_type_array'));

    }

    public function update_career_status_from_rejected_for_rejoin(Request  $request){

        $validator = Validator::make($request->all(), [
            'change_status_id' => 'required',
            'from_rejected' => 'required',
            'follow_up_status' => 'required',
        ]);
        if ($validator->fails()) {
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

         $rejoin_career = RejoinCareer::where('id',$request->change_status_id)->first();
         $rejoin_career->applicant_status =  $request->follow_up_status;
         $rejoin_career->update();

         $message = [
            'message' => "Status has been changed successfully",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);


    }


    public function update_career_status_from_rejected(Request $request){

     if($request->from_rejected=="1"){

         $validator = Validator::make($request->all(), [
             'change_status_id' => 'required',
             'from_rejected' => 'required',
             'follow_up_status' => 'required',
         ]);
         if ($validator->fails()) {
             $message = [
                 'message' => $validator->errors()->first(),
                 'alert-type' => 'error',
                 'error' => ''
             ];
             return redirect()->back()->with($message);
         }

         $primary_id = $request->change_status_id;

         $career= Career::find($primary_id);
         $career->applicant_status = $request->follow_up_status;
         if($career->employee_type=="0"){
             $career->employee_type = "1";
         }
         $career->update();

         $caption_now = "";

         if($request->follow_up_status=="4"){
             $caption_now = "Selected";
         }elseif($request->follow_up_status=="5"){
             $caption_now = "wait List";
         }else{
             $caption_now = "Rejected";
         }

         $careers = new CareerStatusHistory();
        //  $careers->remarks= "sent to  from onboard";
        //  $careers->company_remarks="sent to  from onboard";
         $careers->career_id = $primary_id;
         $careers->status = $request->follow_up_status;
         $careers->user_id = Auth::user()->id;
         $careers->save();

         CreateInterviews::where('career_id',$primary_id)->update(array('return_from_onboard' => '1'));
     }elseif($request->from_rejected=="2"){

         $validator = Validator::make($request->all(), [
             'from_rejected' => 'required',
             'select_ids_career' => 'required',
         ]);
         if ($validator->fails()) {
             $message = [
                 'message' => $validator->errors()->first(),
                 'alert-type' => 'error',
                 'error' => ''
             ];
             return redirect()->back()->with($message);
         }

         $array_ids = explode(",",$request->select_ids_career);

         foreach($array_ids as $ids){

             $primary_id = $ids;

             $career= Career::find($primary_id);
             $career->applicant_status = $request->follow_up_status;
             if($career->employee_type=="0"){
                 $career->employee_type = "1";
             }
             $career->update();

             $caption_now = "";

             if($request->follow_up_status=="4"){
                 $caption_now = "Selected";
             }elseif($request->follow_up_status=="5"){
                 $caption_now = "wait List";
             }else{
                 $caption_now = "Rejected";
             }

             $careers = new CareerStatusHistory();
            //  $careers->remarks= "sent to  from onboard";
            //  $careers->company_remarks="sent to  from onboard";
             $careers->career_id = $primary_id;
             $careers->status = $request->follow_up_status;
             $careers->user_id = Auth::user()->id;
             $careers->save();

         }

     }

        $message = [
            'message' => "Rider status has changes successfully",
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);


    }



    public function save_status_send_to_selected(Request $request){

        $validator = Validator::make($request->all(), [
            'package_id' => 'required',
            'pkg_agreed_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $array_no =  explode(",",$request->pkg_agreed_id);


         $already_guy = Career::where('pkg_id',$request->package_id)->count();

         $pkg_detail = Package::where('id',$request->package_id)->first();

         $limit =  $pkg_detail->qty;

         $now_total = $already_guy+count($array_no);

         if($now_total > $limit){

            $message = [
                'message' => "Package limit hab been exceeded.!",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);

         }






        $status = 4;
        foreach($array_no as $career){


             $career_table = Career::find($career);
             $career_table->applicant_status = $status;
             $career_table->pkg_id =  $request->package_id;
             $career_table->follow_up_status = "0";
             $career_table->update();

            $careers = new CareerStatusHistory();
          //   $careers->remarks= "sent to selected from frontdesk";
          //   $careers->company_remarks="sent to selected from frontdesk";
            $careers->career_id = $career;
            $careers->status = $status;
            $careers->user_id = Auth::user()->id;
            $careers->save();
        }

        $message = [
            'message' => 'Candidate Status has been changed successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);




    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'checkbox_array' => 'required',
        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

//        if($request->type!="3"){
//
//            $careers_d = Career::whereIn('id',$request->checkbox_array)->where('employee_type','=',0)->orWhereNull('employee_type')->get();
//
//            if($careers_d->count() > 0){
//
//                $message = [
//                    'message' => "please update the Employee type before update the Status",
//                    'alert-type' => 'error',
//                    'error' => ''
//                ];
//                return redirect()->back()->with($message);
//            }
//        }else{
//            $array_now = explode(',',$request->checkbox_array);
//            $careers = Career::whereIn('id',$array_now)->where('employee_type','=',0)->orwhere('employee_type')->get();
//
//            if($careers->count() > 0){
//                $message = [
//                    'message' => "please update the Employee type before update the Status",
//                    'alert-type' => 'error',
//                    'error' => ''
//                ];
//                return redirect()->back()->with($message);
//            }
//
//        }

          if($request->type=="1"){
              $status = 4;



              foreach($request->checkbox_array as $career){


                   $career_table = Career::find($career);
                   $career_table->applicant_status = $status;
                   $career_table->follow_up_status = "0";
                   $career_table->update();

                  $careers = new CareerStatusHistory();
                //   $careers->remarks= "sent to selected from frontdesk";
                //   $careers->company_remarks="sent to selected from frontdesk";
                  $careers->career_id = $career;
                  $careers->status = $status;
                  $careers->user_id = Auth::user()->id;
                  $careers->save();
              }

              $message = [
                  'message' => 'Candidate Status has been changed successfully',
                  'alert-type' => 'success'
              ];
              return redirect()->back()->with($message);



          }elseif($request->type=="2"){  //rejected block
            //  dd($request);
              $status = 1;
              foreach($request->checkbox_array as $career){

                  $career_table = Career::find($career);

                  $past_status  = $career_table->applicant_status;

                  $career_table->applicant_status = $status;
                  $career_table->past_status = $past_status;
                  $career_table->follow_up_status = "0";
                  $career_table->update();

                  $mytime = Carbon::now();
                  $note_date = $mytime->toDateString();

                  $careers = new CareerStatusHistory();
                  $careers->remarks= $request->reject_reason;
                  $careers->company_remarks= $request->reject_reason;
                  $careers->note_added_date = $note_date;
                  $careers->career_id = $career;
                  $careers->status = $status;
                  $careers->user_id = Auth::user()->id;
                  $careers->save();
              }

              $message = [
                  'message' => 'Candidate Status has been changed successfully',
                  'alert-type' => 'success'
              ];
              return redirect()->back()->with($message);



          }elseif($request->type=="3"){

              $validator = Validator::make($request->all(), [
                  'follow_up_status' => 'required',
                  'note' => 'required',
              ]);
              if ($validator->fails()) {
                  $response['message'] = $validator->errors()->first();
                  $message = [
                      'message' => $validator->errors()->first(),
                      'alert-type' => 'error',
                      'error' => ''
                  ];
                  return redirect()->back()->with($message);
              }

              $array_now = explode(',',$request->checkbox_array);

              foreach($array_now as $career){

                  $career_table = Career::find($career);

                  $career_table->follow_up_status = $request->follow_up_status;
                  $career_table->followup_date = $request->date;
                //   if($request->follow_up_status == "4"){
                //   $career_table->applicant_status = 1;}
                  $career_table->update();

                  $mytime = Carbon::now();
                  $note_date = $mytime->toDateString();

                  $careers = new CareerStatusHistory();
                  $careers->remarks= $request->note;
                  $careers->company_remarks= $request->note;
                  $careers->career_id = $career;
                  $careers->follow_up_status = $request->follow_up_status;
                  $careers->note_added_date = $note_date;
                  if($request->category == "1"){
                      $careers->career_category = 1;
                  }elseif($request->category == "2"){
                    $careers->career_category = 2;
                  }elseif($request->category == "3"){
                    $careers->career_category = 3;
                  }elseif($request->category == "4"){
                    $careers->career_category = 4;
                  }
                  if($request->date != null){
                  $careers->follow_up_date = $request->date;}
                  $careers->user_id = Auth::user()->id;
                  $careers->save();
              }

              $message = [
                  'message' => 'Note has been Added successfully',
                  'alert-type' => 'success'
              ];
              return redirect()->back()->with($message);


          }elseif($request->type=="4"){

              $validator = Validator::make($request->all(), [
                  'email_note' => 'required',
                  'checkbox_array' => 'required'
              ]);
              if ($validator->fails()) {
                  $response['message'] = $validator->errors()->first();
                  $message = [
                      'message' => $validator->errors()->first(),
                      'alert-type' => 'error',
                      'error' => ''
                  ];
                  return redirect()->back()->with($message);
              }

            $array_now = explode(',',$request->checkbox_array);

            $careers = Career::find($array_now);
            $emails = $careers->map(function($career){
                return $career->email;
            });

            Mail::to($emails)->queue(new FrontdeskMail);

            $message = [
                'message' => 'Email has been sent successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
          }elseif($request->type=="5"){  //rejoin selected candidate

              $status = 4;



              $time_stamp = Carbon::now()->toDateTimeString();

                foreach($request->checkbox_array as $career){


                    $rejoin_table = RejoinCareer::find($career);
                    $rejoin_table->applicant_status = $status;
                    $rejoin_table->follow_up_status = "0";
                    $data =  json_decode($rejoin_table->history_status,true);
                    $arry_ab_1 = array('2'=>$time_stamp);
                    $arry_ab_2 = array('2'=>$time_stamp);
                    array_push($data,$arry_ab_1);
                    array_push($data,$arry_ab_2);



                    $rejoin_table->history_status = json_encode($data);
                    $rejoin_table->save();




                }
                $message = [
                    'message' => 'Candidate Status has been changed successfully',
                    'alert-type' => 'success'
                ];
                  return redirect()->back()->with($message);

           }elseif($request->type=="6"){  //rejoin rejected candidate

              $status = 1;
              $time_stamp = Carbon::now()->toDateTimeString();

              foreach($request->checkbox_array as $career){

                  $rejoin_table = RejoinCareer::find($career);

                  $past_status = $rejoin_table->applicant_status;
                  $rejoin_table->past_status = $past_status;
                  $rejoin_table->follow_up_status = "0";
                  $rejoin_table->applicant_status = $status;
                  $passport_id = $rejoin_table->passport_id;
                  $rejoin_table->update();


                  $is_rejoin = RejoinCareer::where('passport_id','=',$passport_id)->where('hire_status','=','0')->first();

                  if($is_rejoin!=null){

                      $is_ready_array =  json_decode($is_rejoin->history_status,true);


                      $gamer =  ['4' => $time_stamp];
                      array_push($is_ready_array, $gamer);

                      $is_rejoin->history_status = json_encode($is_ready_array);
                      $is_rejoin->update();
                  }else{

                      $array_new =['4' => $time_stamp];
                      $rejoin = new RejoinCareer();
                      $rejoin->passport_id = $passport_id;
                      $rejoin->history_status = json_encode($array_new);
                      $rejoin->applicant_status = $status;
                      $rejoin->save();
                  }



              }
              $message = [
                  'message' => 'Candidate Status has been changed successfully',
                  'alert-type' => 'success'
              ];
              return redirect()->back()->with($message);

          }



    }

    public function save_rejected_from_selected(Request  $request){

        $validator = Validator::make($request->all(), [
            'checkbox_array' => 'required',
        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

    if(isset($request->which_tab_button_pressed)){


        if($request->which_tab_button_pressed=="3"){


            $array_checkbox = explode(",",$request->checkbox_array);

            $status = 1;
            foreach($array_checkbox as $career){

                $career_table = RejoinCareer::find($career);

                $past_status  = $career_table->applicant_status;
                $career_table->follow_up_status = "0";
                $career_table->applicant_status = $status;
                $career_table->past_status = $past_status;
                $career_table->update();

//                $careers = new CareerStatusHistory();
//                $careers->remarks= $request->reject_reason;
//                $careers->company_remarks= $request->reject_reason;
//                $careers->career_id = $career;
//                $careers->status = $status;
//                $careers->user_id = Auth::user()->id;
//                $careers->save();
            }

            $message = [
                'message' => 'Candidate Status has been changed successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);


        }
    }



        $array_checkbox = explode(",",$request->checkbox_array);

        $status = 1;
        foreach($array_checkbox as $career){

            $career_table = Career::find($career);

            $past_status  = $career_table->applicant_status;

            $career_table->applicant_status = $status;
            $career_table->past_status = $past_status;
            $career_table->follow_up_status = "0";
            $career_table->update();

            $mytime = Carbon::now();
            $note_date = $mytime->toDateString();

            $careers = new CareerStatusHistory();
            $careers->remarks= $request->reject_reason;
            $careers->company_remarks= $request->reject_reason;
            $careers->note_added_date = $note_date;
            $careers->career_id = $career;
            $careers->status = $status;
            $careers->user_id = Auth::user()->id;
            $careers->save();
        }

        $message = [
            'message' => 'Candidate Status has been changed successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);

    }

    public function batch_detail(Request $request){

         $batch_id = $request->batch_id;

         $batch = InterviewBatch::where('id',$batch_id)->first();

        $gamer = array(
            'platform_name' =>  $batch->platform->name,
            'total_candidate' => isset($batch->interviews) ? $batch->interviews->count() : 0 ,
            'interview_date' =>  $batch->interview_date,
            'start_time' =>  $batch->start_time,
            'end_time' =>  $batch->end_time,
            'quantity' =>  $batch->candidate_quantity,

        );
        return $gamer;

//        return response()->json(['data' => $gamer], 200, [], JSON_NUMERIC_CHECK);
    }

    public function career_send_interview(Request  $request){

        $validator = Validator::make($request->all(), [
            'checkbox_array' => 'required',
            'batch_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            return  $validator->errors()->first();
        }



        if($request->type_for_rejoin=="0"){


            $select_array = explode(",",$request->checkbox_array);

             $count_interview_batch = InterviewBatch::find($request->batch_id);

            if(isset($count_interview_batch->candidate_quantity)){
                 $range_batch = $count_interview_batch->candidate_quantity;
              $total_interview =  CreateInterviews::where('interviewbatch_id','=',$request->batch_id)->count();

               $range_already = $total_interview+count($select_array);
                     if($range_already > $range_batch){
                          return  "Exceed";
                      }

            }


            $is_error = false;
            $array_error_name = [];
            foreach ($select_array as $id){
                $is_exist = CreateInterviews::where('career_id','=',$id)->where('interviewbatch_id','=',$request->batch_id)->where('interview_status','=','0')->first();
                if($is_exist != null){
                    $is_error = true;
                    $array_error_name [] =  $is_exist->career_detail->name;
                }
            }
            if($is_error){

                return implode(", ",$array_error_name);
            }

            foreach($select_array as $gamer){
                $interview = new CreateInterviews();
                $interview->career_id = $gamer;
                $interview->interviewbatch_id = $request->batch_id;
                $interview->save();
                Career::where('id','=',$gamer)->update(['hire_status'=>'0']);
                Career::where('id','=',$gamer)->update(['follow_up_remove'=>'1','follow_up_status'=>'0']);
            }

        }elseif($request->type_for_rejoin=="1"){ //for rejoin users



            $select_array = explode(",",$request->checkbox_array);



            $count_interview_batch = InterviewBatch::find($request->batch_id);

            if(isset($count_interview_batch->candidate_quantity)){
                $range_batch = $count_interview_batch->candidate_quantity;
                $total_interview =  CreateInterviews::where('interviewbatch_id','=',$request->batch_id)->count();

                $range_already = $total_interview+count($select_array);
                if($range_already > $range_batch){
                    return  "Exceed";
                }

            }

            $is_error = false;
            $array_error_name = [];
            foreach ($select_array as $id){

                $rejoin_user = RejoinCareer::find($id);

                $is_exist = CreateInterviews::where('passport_id','=',$rejoin_user->passport_id)->where('interviewbatch_id','=',$request->batch_id)->where('interview_status','=','0')->first();
                if($is_exist != null){
                    $is_error = true;
                    $array_error_name [] =  $is_exist->passport->personal_info->full_name;
                }
            }
            if($is_error){
                return implode(", ",$array_error_name);
            }

            foreach($select_array as $gamer){

                $time_stamp = Carbon::now()->toDateTimeString();

                $rejoin_user = RejoinCareer::find($gamer);

                $interview = new CreateInterviews();
                $interview->passport_id = $rejoin_user->passport_id;
                $interview->interviewbatch_id = $request->batch_id;
                $interview->save();

                $data =  json_decode($rejoin_user->history_status,true);
                  array_push($data, ['5' => $time_stamp]);
                  array_push($data, ['6' => $request->batch_id]);
                $rejoin_user->history_status = json_encode($data);
                $rejoin_user->applicant_status = 10;
                $rejoin_user->follow_up_status = "0";
                $rejoin_user->update();


            }
        }


        return "success";



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

        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
//        try {

        $validator = Validator::make($request->all(), [
            'edit_name' => 'required',
            'employee_type' => 'required',
            'edit_phone' => 'required|unique:careers,phone,'.$id,
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            return $validate->first();
        }

        if(!empty($request->edit_passport)){

            $validator = Validator::make($request->all(), [
                'edit_passport' => 'unique:careers,passport_no,'.$id,
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                return $validate->first();
            }

        }

        if($request->employee_type=="2"){

            $validator = Validator::make($request->all(), [
                'four_pl_name_id' => 'required',
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                return $validate->first();
            }
        }else{
            $validator = Validator::make($request->all(), [
                'visa_status' => 'required',
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                return $validate->first();
            }


        }

        if(!empty($request->edit_email)){

            $validator = Validator::make($request->all(), [
                'edit_email' => 'unique:careers,passport_no,'.$id,
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                return $validate->first();
            }
        }


//        dd($request);

        $file1=null;
        $file2=null;
        $file3=null;

        $license_issue = NULL;
        $exit_date = NULL;
        $license_expiry = NULL;
        $passport_expiry = NULL;
        $license_no = NULL;
        $license_status_vehicle = 0;


//        echo "license Issued".$license_issue;
//        dd();
        $obj1 = Career::find($id);
        $obj1->platform_id = null;
        $obj1->cities = null;
        $obj1->save();


        $obj= Career::find($id);
        $obj->name = trim($request->input('edit_name'));
        $obj->email = trim($request->input('edit_email'));
        $obj->phone = trim($request->input('edit_phone'));
        $obj->whatsapp = trim($request->input('edit_whatsapp'));
        $obj->facebook = trim($request->input('edit_social_media_id'));
        if(!empty($request->input('apply_for'))){
            $obj->vehicle_type = trim($request->input('apply_for'));
        }
        if(!empty($request->shirt_size)){
            $obj->shirt_size = $request->shirt_size;
        }

        if(!empty($request->waist_size)){
            $obj->waist_size = $request->waist_size;
        }


        if (!empty($request->input('experience'))){
            $obj->experience = trim($request->input('experience'));
        }


        if(!empty($request->input('exp_month'))){
            $obj->experience_month = trim($request->input('exp_month'));
        }

        $file1?$obj->cv = $file1:"";

        if(!empty($request->input('license_status'))){
            $obj->licence_status = trim($request->input('license_status'));
        }
        if(!empty($request->input('license_type'))){
            $obj->licence_status_vehicle = trim($request->input('license_type'));
        }

        if($request->employee_type=="1"){
            $obj->employee_type = $request->employee_type;
            $obj->four_pl_name_id = null;
            if(isset($request->visa_status)){
                $obj->visa_status = trim($request->input('visa_status'));
                if($request->input('visa_status')=="1"){
                    if(isset($request->visit_visa_status)){
                        $obj->visa_status_visit = $request->visit_visa_status;
                    }
                }elseif($request->input('visa_status')=="2"){
                    if(isset($request->edit_cancel_visa_status)){
                        $obj->visa_status_cancel = $request->edit_cancel_visa_status;
                    }
                }elseif($request->input('visa_status')=="3"){
                    if(isset($request->own_visa_status)){
                        $obj->visa_status_own = $request->own_visa_status;
                    }

                }
            }
        }else{
            $obj->employee_type = $request->employee_type;
            $obj->four_pl_name_id = $request->four_pl_name_id;
            $obj->visa_status = null;
            $obj->visa_status_cancel  = null;

        }






        if(!empty($request->input('edit_nation'))){
            $obj->nationality = $request->input('edit_nation');
        }

        if(!empty($request->input('edit_dob'))){
            $obj->dob = trim($request->input('edit_dob'));
        }
        if(!empty($request->edit_passport)) {
            $obj->passport_no = trim($request->edit_passport);
        }
        if(!empty($request->edit_passport_expiry)){
            $obj->passport_expiry = trim($request->edit_passport_expiry);
        }


        if(!empty($request->input('platform_id'))){
            $obj->platform_id = json_encode($request->input('platform_id'));
        }
        if(!empty($request->cities)){
            $obj->cities = json_encode($request->cities);
        }

        $obj->save();
        $last_id = $obj->id;
        $career_history = new CareerStatusHistory();
        $career_history->career_id = $last_id;
        $career_history->status = "0";
        $career_history->save();

        $referal = Referal::where('career_id','=',$last_id)->first();
        if(!empty($referal)){
            $referal->passport_no = trim($request->passport_no);
            $referal->update();
        }



        return "success";




//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = 'Submission Failed';
//
//            return response()->json($response);
//        }

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

    public function rejoin_ajax_passport_detail(Request $request){

        if($request->ajax()){

             $rejoin = RejoinCareer::where('id',$request->primary_id)->first();

            $passport = $rejoin->passport_detail;

            $view = view("admin-panel.career.new_career.passport_detail_ajax", compact('passport'))->render();

            return response()->json(['html' => $view]);

        }

    }




    public function ajax_view_edit_detail(Request $request){

        $id = $request->primary_id;

        $career = Career::find($id);

        $vehicle_type = "";
        $visa_status = "";

        if($career->vehicle_type=="1"){
            $vehicle_type = "Bike";
        }elseif($career->vehicle_type=="2"){
            $vehicle_type = "Car";
        }elseif($career->vehicle_type=="3"){
            $vehicle_type = "Both";
        }

        $visa_status = $career->visa_status;


//        $visa_status_cancel = "";
//
//        if($career->visa_status_cancel=="1"){
//            $visa_status_cancel = "Free Zone";
//        }elseif($career->visa_status_cancel=="2"){
//            $visa_status_cancel = "Local Land";
//        }else{
//            $visa_status_cancel = "";
//        }
//        $visa_status_own = "";
//        if($career->visa_status_own=="1"){
//            $visa_status_own = "NOC";
//        }elseif($career->visa_status_own=="2"){
//            $visa_status_own = "Without NOC";
//        }else{
//            $visa_status_own = "";
//        }

        $experiece = "";

        if(!empty($career->experience)){
            $experiece_year = isset($career->get_experience->name) ? $career->get_experience->name : '';
            $experiece_month  = isset($career->get_month_experience->name) ? $career->get_month_experience->name  :'';

            $experiece =  $experiece_year." ".$experiece_month;

        }else{
            $experiece = "0";
        }

        $app_status = "";
        if($career->applicant_status=="0"){
            $app_status = "Not Verified";
        }elseif($career->applicant_status=="1"){
            $app_status = "Rejected";
        }elseif($career->applicant_status=="2"){
            $app_status = "Document Pending";
        }elseif($career->applicant_status=="3"){
            $app_status = "Short Listed";
        }elseif($career->applicant_status=="4"){
            $app_status = "Selected";
        }elseif($career->applicant_status=="5"){
            $app_status = "Wait list";
        }

        $drving_license_status_vehice = "";


            $drving_license_status_vehice = $career->licence_status_vehicle;




        $visa_status_visit = $career->visa_status_visit;


        $inout_transfer =$career->inout_transfer;





        $career_history = array();
        if(!empty($career->career_history))
        {

            foreach($career->career_history as $history){

                $gamer = array(
                    'id' => $history->id,
                    'remark' => $history->remarks,
                    'company_remark' => $history->company_remarks,
                    'status' => $history->status,
                    'created_at' => $history->created_at,
                    'user_name' => (!empty($history->user_id)) ?  $history->user->name : 'By Default' ,
                );
                $career_history [] = $gamer;
            }
        }


        $array_platform = array();

        if(is_array($career->platform_id)){
            $array_platform =  $career->platform_id;
        }else{
            $array_platform [] =$career->platform_id;
        }
        $platforms_name = "";

        $cities_name = $career->cities;

//        if(!empty($career->cities)){
//
//
//            foreach($career->cities as $ab){
//                $city = Cities::find($ab);
//                $cities_name .=   isset($city->name)?$city->name.", ":"";
//            }
//
//        }

        $array_platform =  $array_platform;


        $phone_country_code = $this->get_country_name_from_code($career->phone);
        $whatsapp_country_code = $this->get_country_name_from_code($career->whatsapp);

        $remain_phone_number = "";
        $remain_whatsapp_number = "";


      if($phone_country_code=="ae" || $phone_country_code=="sd"  || $phone_country_code=="ne"   || $phone_country_code=="np" || $phone_country_code=="bd" ){
          $country_code = substr($career->phone,  4);
          $remain_phone_number = $country_code;
       }else{
          $country_code = substr($career->phone,  3);
          $remain_phone_number = $country_code;
      }

        if($whatsapp_country_code=="ae" || $whatsapp_country_code=="sd"  || $whatsapp_country_code=="ne"   || $whatsapp_country_code=="np" || $whatsapp_country_code=="bd" ){
            $country_code = substr($career->whatsapp,  4);
            $remain_whatsapp_number = $country_code;
        }else{
            $country_code = substr($career->whatsapp,  3);
            $remain_whatsapp_number = $country_code;
        }

        $refer_passport_id = "";
        $refered_passport_name = "";


        if(!empty($career->refer_by)){
            $refered_passport_name =  $career->refer_by_user->personal_info->full_name;
            $refer_passport_id =  $career->refer_by;

            $refer_passport_id = url('profile')."?passport_id=".$refer_passport_id;

        }

            $socials = CareerHeardAboutUs::find($career->source_type);

//        $promotion_type_array = array('','Tiktok','Facebook','Youtube','Website','Instagram','Friend','Other','Radio','Restaurant');

        $array_source_type =  array('','App','On Call','Walkin Candidate','Website','Social Media');

        $passport_id = Passport::where('career_id','=',$career->id)->first();

        $gamer = array(
            'id' => $career->id,
            'name' => $career->name,
            'email' => $career->email,
            'phone' => $remain_phone_number,
            'phone_country_code' => $phone_country_code,
            'whatsapp_country_code' => $whatsapp_country_code,
            'whatsapp' =>  $remain_whatsapp_number,
            'facebook' =>  $career->facebook,
            'experience'  =>  $career->experience,
            'exp_month' =>  $career->experience_month,
            'vehicle_type' => $vehicle_type,
            'cv' =>  (isset($career->cv)) ? url($career->cv) : 'Not Found' ,
            'licence_status' =>  $career->licence_status,
            'licence_status_vehicle' =>  $drving_license_status_vehice,
            'licence_no'  =>  $career->licence_no,
            'licence_issue'  =>  $career->licence_issue,
            'licence_expiry'  =>  $career->licence_expiry,
            'licence_city_id' => isset($career->licence_city_id) ? $career->licence_city_id : null,
            'licence_city_name' => isset($career->licence_city_id) ? $career->city->name : null,
            'licence_attach'   =>  $career->licence_attach ? Storage::temporaryUrl($career->licence_attach,now()->addMinutes(30)) : '',
            'licence_attach_back'   =>  $career->licence_attach_back ? Storage::temporaryUrl($career->licence_attach_back,now()->addMinutes(30)) : '',
            'traffic_code_no'   =>  $career->traffic_file_no ? $career->traffic_file_no : '',
            'nationality'  =>  $career->nationality,
            'dob'  =>  $career->dob,
            'passport_no' =>  $career->passport_no,
            'passport_expiry' =>  $career->passport_expiry,
            'passport_attach' =>  $career->passport_attach ? url($career->passport_attach) : 'Not Found' ,
            'visa_status' =>  $visa_status,
            'visa_status_visit' =>  $visa_status_visit,
            'visa_status_cancel' =>  isset($career->visa_status_cancel) ? $career->visa_status_cancel : null,
            'visa_status_own' =>  isset($career->visa_status_own) ? $career->visa_status_own : null,
            'exit_date' =>  $career->exit_date,
            'company_visa'  =>  isset($career->company_visa) ? $career->company_visa : null,
            'inout_transfer'   =>  $inout_transfer,
            'platform_id'  =>  $array_platform,
            'cities'  =>  $cities_name,
            'applicant_status'  =>  $app_status,
            'remarks'   =>  $career->remarks,
            'employee_type' => isset($career->employee_type) ? $career->employee_type : '0',
            'four_pl_name_id' => $career->four_pl_name_id,
            'shirt_size' => $career->shirt_size,
            'waist_size' => $career->waist_size,
            'company_remark' => $career->company_remarks,
            'promotion_type' => isset($career->promotion_type) ? $career->promotion_type : '',
            'social_id_name' => isset($career->social_media_id_name) ? $career->social_media_id_name : '',
            'promotion_others' => isset($career->promotion_others)?$career->promotion_others:"",
            'source_type' => isset($socials) ? $socials->name: "N/A",
            'social_media_id_name' => isset($career->social_media_id_name) ? $career->social_media_id_name: "N/A",
            'career_history' =>  json_encode($career_history),
            'refer_passport_id' => $refer_passport_id,
            'refered_passport_name' => $refered_passport_name,
            'medical_type' => isset($career->medical_type) ? $career->medical_type : null,
            'nation_id' => isset($career->nationality) ? $career->nationality : null,
            'nic_expiry' => isset($career->nic_expiry) ? $career->nic_expiry : null,
            'care_of' => isset($career->care_of) ? $career->care_of : null,
            'care_of_name' => isset($career->care_of) ? $career->care_of_name->personal_info->full_name : null,
            'passport_id' => isset($passport_id) ? $passport_id->id : null,
            'physical_documents' => isset($career->physical_document) ? json_decode($career->physical_document) : null

        );

        $childe['data'] [] = $gamer;

//            dd($childe);



        echo json_encode($childe);
        exit;

    }

    function get_country_name_from_code($number){


        $country_code = substr($number, 0, 4);

        $result = "";

        if($country_code=="+971"){
            $result = "ae";
        }elseif($country_code=="+249"){
            $result = "sd";
        }elseif($country_code=="+227"){
            $result = "ne";
        }elseif($country_code=="+977"){
            $result = "np";
        }elseif($country_code=="+880"){
            $result = "bd";
        }

        $country_code = substr($number, 0, 3);

        if($country_code=="+92"){
            $result = "pk";
        }elseif($country_code=="+91"){
            $result = "in";
        }

        return $result;

    }

    public function view_frontdesk_follow_up(){

        $mytime = Carbon::now();
        $date = $mytime->toDateString();

        $license = Career::where('applicant_status','!=','1')->where('applicant_status','!=','5')->where('employee_type','=','1')
            ->where('licence_status','=','2')->whereNUll('career_bypass')->pluck('id')->toArray();

        //front desk
        $careers = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')->whereNotIn('source_type', [3])
            ->where('applicant_status','!=','5')->where('follow_up_status','=','0')
              ->whereNUll('career_bypass')
            ->orderby('refer_by','desc')->get();

        $careers1 = Career::where('applicant_status','!=','4')->where('applicant_status','!=','1')->whereIn('source_type', [3])
        ->where('applicant_status','!=','5')->where('follow_up_status','=','0')->where('created_at','<',$date)
          ->whereNUll('career_bypass')->whereNotIn('id', $license)
        ->orderby('refer_by','desc')->get();

        $career_count = $careers->count();
        $career_count1 = $careers1->count();
        $career_counts = $career_count + $career_count1;

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $today = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->whereHas('career', function($q) use ($date){
            $q->where('applicant_status', '!=', '1')->where('applicant_status','!=','5')->where('applicant_status','!=','4')->where('followup_date','<=',$date);
        })->where('career_category','=',"1")->groupBy('career_id')->get();

        $history = CareerStatusHistory::all();

        $followup_front = frontdesk_followup::where('status','0')->get();
        $followup_fronts = frontdesk_followup::all();
        $followup_front_keys = $followup_fronts->filter(function($followup_front){
            return $followup_front->count = count(CareerStatusHistory::whereHas('career', function($q)use($followup_front){
                $q->whereNotIn('applicant_status', [1,5,4])
                    ->where('follow_up_status', '=', $followup_front->id);
                })
                ->where('follow_up_status', '=', $followup_front->id)
                ->where('career_category','=',"1")
                ->groupBy('career_id')
                ->get());
        })->toArray();

        return view('admin-panel.career.new_career.view_frontdesk_followup',compact("career_counts","followup_fronts","followup_front","careers","careers1","source_type_array","today","history",'followup_front_keys'));

    }

    public function ajax_frontdesk_follow_up(Request $request){

            $id = $request->id;
            $data = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->whereHas('career', function($q) use ($id){
                $q->where('applicant_status', '!=', '1')->where('applicant_status','!=','5')->where('applicant_status','!=','4')->where('follow_up_status', '=', $id);
            })->where('follow_up_status','=',$id)->where('career_category','=',"1")->groupBy('career_id')->orderby('id','desc')->get();

            $table = Datatables::of($data)
                        ->editColumn('career_name', function($data){
                            return ($data->career->name);
                        })
                        ->editColumn('career_email', function($data){
                            return ($data->career->email);
                        })
                        ->editColumn('career_phone', function($data){
                            return ($data->career->phone);
                        })
                        ->editColumn('career_whatsapp', function($data){
                            return ($data->career->whatsapp);
                        })
                        ->editColumn('action', function($data){

                            $action = '<a class="text-primary mr-2 follow_up" data-category="1" id = "'.$data->career->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                            <a class="text-primary mr-2 view_cls" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                            <a class="text-danger mr-2 rejection" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                            ';
                            return ($action);
                        })
                        ->editColumn('source_type', function($data){
                            if($data->career->source_type == "1"){
                                $type = 'App';
                                return ($type);
                            }elseif($data->career->source_type == "2"){
                                $type = 'On Call';
                                return ($type);
                            }elseif($data->career->source_type == "3"){
                                $type = 'Walkin Candidate';
                                return ($type);
                            }elseif($data->career->source_type == "4"){
                                $type = 'Website';
                                return ($type);
                            }elseif($data->career->source_type == "5"){
                                $type = 'Social Media';
                                return ($type);
                            }elseif($data->career->source_type == "6"){
                                $type = 'International';
                                return ($type);
                            }
                        });
            return $table->make(true);

    }

    public function view_waitlist_follow_up(){

        $mytime = Carbon::now();
        $date = $mytime->toDateString();

        //wait_list
        $wait_today = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->whereHas('career', function($q) use ($date){
            $q->where('applicant_status', '!=', '1')->where('applicant_status','!=','4')->where('followup_date','<=',$date);
        })->where('career_category','=',"2")->groupBy('career_id')->get();

        $rejoin_today = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('rejoin_careers', 'rejoin_careers.passport_id', 'career_status_histories.passport_id')
        ->where('career_category','=',"2")->where('rejoin_careers.applicant_status', '=', '5')->where('rejoin_careers.followup_date', '<=',$date)->groupBy('career_status_histories.passport_id')->get();

        $career_count = $wait_today->count();
        $career_count1 = $rejoin_today->count();
        $career_counts = $career_count + $career_count1;

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $followup_wait = waitlistfollowup::where('status','0')->get();
        $followup_waits = waitlistfollowup::all();
        $followup_wait_keys = $followup_waits->filter(function($followup_wait){
            return $followup_wait->count = count(CareerStatusHistory::whereHas('career', function($q) use ($followup_wait){
                $q->where('applicant_status', '!=', '1')->where('applicant_status','!=','4')->where('follow_up_status', '=', $followup_wait->id);
            })->where('follow_up_status','=',$followup_wait->id)->where('career_category','=',"2")->groupBy('career_id')->get());
        })->toArray();

        return view('admin-panel.career.new_career.view_waitlist_followup',compact("followup_wait_keys","career_counts","followup_waits","rejoin_today","source_type_array","followup_wait","wait_today"));

    }

    public function ajax_waitlist_follow_up(Request $request){

        $id = $request->id;
        $career_data = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->whereHas('career', function($q) use ($id){
            $q->where('applicant_status', '!=', '1')->where('applicant_status','!=','4')->where('follow_up_status', '=', $id);
        })->where('follow_up_status','=',$id)->where('career_category','=',"2")->groupBy('career_id')->orderby('id','desc')->get();

        $rejoin = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('rejoin_careers', 'rejoin_careers.passport_id', 'career_status_histories.passport_id')
        ->where('career_category','=',"2")->where('rejoin_careers.applicant_status', '=', '5')->where('rejoin_careers.follow_up_status', '=', $id)->groupBy('career_status_histories.passport_id')->get();

        $merged = $rejoin->merge($career_data);

        $data = $merged->all();

        $table = Datatables::of($data)
                    ->editColumn('career_name', function($data){
                        if(isset($data->career->name))
                            return $data->career->name;
                        elseif(isset($data->passport_detail->personal_info->full_name))
                            return $data->passport_detail->personal_info->full_name;
                        else
                            return '';
                    })
                    ->editColumn('career_email', function($data){
                        if(isset($data->career->email))
                            return $data->career->email;
                        elseif(isset($data->passport_detail->personal_info->personal_email))
                            return $data->passport_detail->personal_info->personal_email;
                        else
                            return '';
                    })
                    ->editColumn('career_phone', function($data){
                        if(isset($data->career->phone))
                            return $data->career->phone;
                        elseif(isset($data->passport_detail->personal_info->personal_mob))
                            return $data->passport_detail->personal_info->personal_mob;
                        else
                            return '';
                    })
                    ->editColumn('career_whatsapp', function($data){
                        if(isset($data->career->whatsapp))
                            return $data->career->whatsapp;
                        elseif(isset($data->passport_detail->personal_info->nat_whatsapp_no))
                            return $data->passport_detail->personal_info->nat_whatsapp_no;
                        else
                            return '';
                    })
                    ->editColumn('action', function($data){

                        if(isset($data->career->id))
                            return $action = '<a class="text-primary mr-2 follow_up" data-category="2" id = "'.$data->career->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                <a class="text-primary mr-2 view_cls" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                                <a class="text-danger mr-2 rejection" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                                 ';
                        else
                            return '<a class="text-primary mr-2 rejoin_follow_up" data-category="2" id="' .$data->passport_id . '" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                            <a class="text-primary mr-2 view_passport_detail_btn" data-passport_id="'. $data->passport_id . '" id="'. $data->id .' " href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                            <a class="text-danger mr-2 rejection_rejoin" id="'. $data->id .' " href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                            ';
                    })
                    ->editColumn('employee_type', function($data){
                        if(isset($data->career->employee_type)){
                        if($data->career->employee_type == "1"){
                            $type = 'Company';
                            return ($type);
                        }else{
                            $type = 'Four PL';
                            return ($type);
                        }}else{
                            $type = 'Rejoin';
                            return ($type);
                        }
                    })
                    ->editColumn('visa_status', function($data){
                        if(isset($data->career->visa_status)){
                            if($data->career->visa_status == "1"){
                                        $type = 'Visit Visa';
                                        return ($type);
                                    }elseif($data->career->visa_status == "2"){
                                        $type = 'Cancel Visa';
                                        return ($type);
                                    }elseif($data->career->visa_status == "3"){
                                        $type = 'Own Visa';
                                        return ($type);
                                    }}else{
                            $type = 'N/A';
                            return ($type);
                        }
                    })
                    ->editColumn('source_type', function($data){
                        if(isset($data->career->source_type)){
                            if($data->career->source_type == "1"){
                                $type = 'App';
                                return ($type);
                            }elseif($data->career->source_type == "2"){
                                $type = 'On Call';
                                return ($type);
                            }elseif($data->career->source_type == "3"){
                                $type = 'Walkin Candidate';
                                return ($type);
                            }elseif($data->career->source_type == "4"){
                                $type = 'Website';
                                return ($type);
                            }elseif($data->career->source_type == "5"){
                                $type = 'Social Media';
                                return ($type);
                            }elseif($data->career->source_type == "6"){
                                $type = 'International';
                                return ($type);
                            }}else{
                            $type = 'N/A';
                            return ($type);
                        }
                    });

        return $table->make(true);

}

    public function view_selected_follow_up(){

        $mytime = Carbon::now();
        $date = $mytime->toDateString();

        //selected
        $selected_today = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->whereHas('career', function($q) use($date){
            $q->where('applicant_status', '!=', '1')->where('follow_up_remove', '!=', '1')->where('followup_date','<=',$date);
        })->where('career_category','=',"3")->groupBy('career_id')->get();

        $rejoin_today = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('rejoin_careers', 'rejoin_careers.passport_id', 'career_status_histories.passport_id')
        ->where('career_category','=',"3")->where('rejoin_careers.applicant_status', '=', '4')->where('rejoin_careers.followup_date', '<=',$date)->groupBy('career_status_histories.passport_id')->get();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $followup_selected = selected_followup::where('status','0')->get();
        $followup_selecteds = selected_followup::all();

        return view('admin-panel.career.new_career.view_selected_followup',compact("followup_selecteds","rejoin_today","source_type_array","followup_selected","selected_today"));

    }

    public function ajax_selected_follow_up(Request $request){

        $id = $request->id;
        $career_data = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->whereHas('career', function($q) use($id){
            $q->where('applicant_status', '!=', '1')->where('follow_up_remove', '!=', '1')->where('follow_up_status', '=', $id);
        })->where('follow_up_status','=',$id)->where('career_category','=',"3")->groupBy('career_id')->orderby('id','desc')->get();

        $rejoin = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('rejoin_careers', 'rejoin_careers.passport_id', 'career_status_histories.passport_id')
        ->where('career_category','=',"3")->where('rejoin_careers.applicant_status', '=', '4')->where('rejoin_careers.follow_up_status', '=', $id)->groupBy('career_status_histories.passport_id')->get();

        $merged = $rejoin->merge($career_data);

        $data = $merged->all();

        $table = Datatables::of($data)
                    ->editColumn('career_name', function($data){
                        if(isset($data->career->name))
                            return $data->career->name;
                        elseif(isset($data->passport_detail->personal_info->full_name))
                            return $data->passport_detail->personal_info->full_name;
                        else
                            return '';
                    })
                    ->editColumn('career_email', function($data){
                        if(isset($data->career->email))
                            return $data->career->email;
                        elseif(isset($data->passport_detail->personal_info->personal_email))
                            return $data->passport_detail->personal_info->personal_email;
                        else
                            return '';
                    })
                    ->editColumn('career_phone', function($data){
                        if(isset($data->career->phone))
                            return $data->career->phone;
                        elseif(isset($data->passport_detail->personal_info->personal_mob))
                            return $data->passport_detail->personal_info->personal_mob;
                        else
                            return '';
                    })
                    ->editColumn('career_whatsapp', function($data){
                        if(isset($data->career->whatsapp))
                            return $data->career->whatsapp;
                        elseif(isset($data->passport_detail->personal_info->nat_whatsapp_no))
                            return $data->passport_detail->personal_info->nat_whatsapp_no;
                        else
                            return '';
                    })
                    ->editColumn('action', function($data){

                        if(isset($data->career->id))
                        return $action = '<a class="text-primary mr-2 follow_up" data-category="3" id = "'.$data->career->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                        <a class="text-primary mr-2 view_cls" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                        <a class="text-danger mr-2 rejection" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                        ';
                        else
                            return '<a class="text-primary mr-2 rejoin_follow_up" data-category="3" id="' .$data->passport_id . '" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                            <a class="text-primary mr-2 view_passport_detail_btn" data-passport_id="'. $data->passport_id . '" id="'. $data->id .' " href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                            <a class="text-danger mr-2 rejection_rejoin" id="'. $data->id .' " href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                            ';
                    })
                    ->editColumn('employee_type', function($data){
                        if(isset($data->career->employee_type)){
                        if($data->career->employee_type == "1"){
                            $type = 'Company';
                            return ($type);
                        }else{
                            $type = 'Four PL';
                            return ($type);
                        }}else{
                            $type = 'Rejoin';
                            return ($type);
                        }
                    })
                    ->editColumn('visa_status', function($data){
                        if(isset($data->career->visa_status)){
                            if($data->career->visa_status == "1"){
                                        $type = 'Visit Visa';
                                        return ($type);
                                    }elseif($data->career->visa_status == "2"){
                                        $type = 'Cancel Visa';
                                        return ($type);
                                    }elseif($data->career->visa_status == "3"){
                                        $type = 'Own Visa';
                                        return ($type);
                                    }}else{
                            $type = 'N/A';
                            return ($type);
                        }
                    })
                    ->editColumn('source_type', function($data){
                        if(isset($data->career->source_type)){
                            if($data->career->source_type == "1"){
                                $type = 'App';
                                return ($type);
                            }elseif($data->career->source_type == "2"){
                                $type = 'On Call';
                                return ($type);
                            }elseif($data->career->source_type == "3"){
                                $type = 'Walkin Candidate';
                                return ($type);
                            }elseif($data->career->source_type == "4"){
                                $type = 'Website';
                                return ($type);
                            }elseif($data->career->source_type == "5"){
                                $type = 'Social Media';
                                return ($type);
                            }elseif($data->career->source_type == "6"){
                                $type = 'International';
                                return ($type);
                            }}else{
                            $type = 'N/A';
                            return ($type);
                        }
                    });
        return $table->make(true);

}

    public function view_onboard_follow_up(){

        $mytime = Carbon::now();
        $date = $mytime->toDateString();

        //onboard
        $onboard_today = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('on_boarding_statuses', 'on_boarding_statuses.career_id', 'career_status_histories.career_id')->whereHas('career', function($q) use($date){
            $q->where('applicant_status', '!=', '1')->where('applicant_status', '!=', '5')->where('followup_date','<=',$date);
        })->where('career_category','=',"4")->where('on_boarding_statuses.assign_platform', '!=','0')->groupBy('career_status_histories.career_id')->get();

        $rejoin_today = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('rejoin_careers', 'rejoin_careers.passport_id', 'career_status_histories.passport_id')
        ->where('career_category','=',"4")->whereIn('rejoin_careers.applicant_status', [0, 10])->where('rejoin_careers.followup_date', '<=',$date)->groupBy('career_status_histories.passport_id')->get();

        $followup_onboard = onboard_followup::where('status','0')->get();
        $followup_onboards = onboard_followup::all();

        return view('admin-panel.career.new_career.view_onboard_followup',compact("followup_onboards","rejoin_today","followup_onboard","onboard_today"));

    }

    public function ajax_onboard_follow_up(Request $request){

        $id = $request->id;
        $career_data = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('on_boarding_statuses', 'on_boarding_statuses.career_id', 'career_status_histories.career_id')->whereHas('career', function($q) use($id){
            $q->where('applicant_status', '!=', '1')->where('applicant_status', '!=', '5')->where('follow_up_status', '=', $id);
        })->where('follow_up_status','=',$id)->where('on_boarding_statuses.assign_platform', '!=','0')->where('career_category','=',"4")->groupBy('career_status_histories.career_id')->orderby('career_status_histories.id','desc')->get();

        $rejoin = CareerStatusHistory::select('*', \DB::raw('MAX(remarks) AS remarks,MAX(follow_up_date) AS follow_up_date'))->join('rejoin_careers', 'rejoin_careers.passport_id', 'career_status_histories.passport_id')
        ->where('career_category','=',"4")->whereIn('rejoin_careers.applicant_status', [0, 10])->where('rejoin_careers.follow_up_status', '=', $id)->groupBy('career_status_histories.passport_id')->get();

        $merged = $rejoin->merge($career_data);

        $data = $merged->all();

        $table = Datatables::of($data)
                    ->editColumn('career_name', function($data){
                        if(isset($data->career->name))
                            return $data->career->name;
                        elseif(isset($data->passport_detail->personal_info->full_name))
                            return $data->passport_detail->personal_info->full_name;
                        else
                            return '';
                    })
                    ->editColumn('career_email', function($data){
                        if(isset($data->career->email))
                            return $data->career->email;
                        elseif(isset($data->passport_detail->personal_info->personal_email))
                            return $data->passport_detail->personal_info->personal_email;
                        else
                            return '';
                    })
                    ->editColumn('career_phone', function($data){
                        if(isset($data->career->phone))
                            return $data->career->phone;
                        elseif($data->passport_detail->personal_info->personal_mob)
                            return $data->passport_detail->personal_info->personal_mob;
                        else
                            return '';
                    })
                    ->editColumn('career_whatsapp', function($data){
                        if(isset($data->career->whatsapp))
                            return $data->career->whatsapp;
                        elseif(isset($data->passport_detail->personal_info->nat_whatsapp_no))
                            return $data->passport_detail->personal_info->nat_whatsapp_no;
                        else
                            return '';
                    })
                    ->editColumn('action', function($data){

                        if(isset($data->career->id))
                        return $action = '<a class="text-primary mr-2 follow_up" data-category="4" id = "'.$data->career->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                        <a class="text-primary mr-2 view_cls" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                        <a class="text-danger mr-2 rejection" id = "'.$data->career->id.'" href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>
                        ';
                        else
                            return '<a class="text-primary mr-2 rejoin_follow_up" data-category="4" id="' .$data->passport_id . '" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                            <a class="text-primary mr-2 view_passport_detail_btn" data-passport_id="'. $data->passport_id . '" id="'. $data->id .' " href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                            <a class="text-danger mr-2 rejection_rejoin" id="'. $data->passport_id .' " href="javascript:void(0)"><i class="nav-icon i-Close font-weight-bold"></i></a>';
                    })
                    ->editColumn('employee_type', function($data){
                        if(isset($data->career->employee_type)){
                        if($data->career->employee_type == "1"){
                            $type = 'Company';
                            return ($type);
                        }else{
                            $type = 'Four PL';
                            return ($type);
                        }}else{
                            $type = 'Rejoin';
                            return ($type);
                        }
                    })
                    ->editColumn('visa_status', function($data){
                        if(isset($data->career->visa_status)){
                            if($data->career->visa_status == "1"){
                                        $type = 'Visit Visa';
                                        return ($type);
                                    }elseif($data->career->visa_status == "2"){
                                        $type = 'Cancel Visa';
                                        return ($type);
                                    }elseif($data->career->visa_status == "3"){
                                        $type = 'Own Visa';
                                        return ($type);
                                    }}else{
                            $type = 'N/A';
                            return ($type);
                        }
                    });
        return $table->make(true);

}

    public function follow_up_save(Request $request){

            $career_table = Career::find($request->id);
            $career_table->follow_up_status = $request->follow_up_status;
            $career_table->followup_date = $request->date;
            // if($request->remove_today == "1"){
            // $career_table->remove_today = 1;}
            // else {
            //     $career_table->remove_today = 0;}
            $career_table->update();

            $mytime = Carbon::now();
            $note_date = $mytime->toDateString();

            $careers = new CareerStatusHistory();
            $careers->remarks= $request->note;
            $careers->company_remarks= $request->note;
            $careers->career_id = $request->id;
            $careers->follow_up_status = $request->follow_up_status;
            $careers->note_added_date = $note_date;
            if($request->category == "1"){
                $careers->career_category = 1;
            }elseif($request->category == "2"){
              $careers->career_category = 2;
            }elseif($request->category == "3"){
                $careers->career_category = 3;
            }elseif($request->category == "4"){
                $careers->career_category = 4;
            }
            if($request->date != null){
            $careers->follow_up_date = $request->date;}
            $careers->user_id = Auth::user()->id;
            $careers->save();

        $message = [
            'message' => 'Note has been Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function rejoin_follow_up(Request $request){
        $array_now = explode(',',$request->checkbox_array);

        foreach($array_now as $career){

            $career_table = RejoinCareer::where('passport_id','=',$career)->update(['follow_up_status' => $request->follow_up_status,'followup_date' => $request->date,]);

            $mytime = Carbon::now();
            $note_date = $mytime->toDateString();

            $careers = new CareerStatusHistory();
            $careers->remarks= $request->note;
            $careers->company_remarks= $request->note;
            $careers->passport_id = $career;
            $careers->follow_up_status = $request->follow_up_status;
            $careers->note_added_date = $note_date;
            if($request->category == "1"){
                $careers->career_category = 1;
            }elseif($request->category == "2"){
              $careers->career_category = 2;
            }elseif($request->category == "3"){
                $careers->career_category = 3;
            }elseif($request->category == "4"){
                $careers->career_category = 4;
            }
            if($request->date != null){
            $careers->follow_up_date = $request->date;}
            $careers->user_id = Auth::user()->id;
            $careers->save();
            }
        $message = [
            'message' => 'Note has been Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function rejoin_follow_up_save(Request $request){

            // if($request->remove_today == null){
            // $career_table = RejoinCareer::where('passport_id','=',$request->id)->update(['follow_up_status' => $request->follow_up_status,'followup_date' => $request->date,]);
            // }elseif($request->remove_today == "1"){
            $career_table = RejoinCareer::where('passport_id','=',$request->id)->update(['follow_up_status' => $request->follow_up_status,'followup_date' => $request->date,]);
            // }

            $mytime = Carbon::now();
            $note_date = $mytime->toDateString();

            $careers = new CareerStatusHistory();
            $careers->remarks= $request->note;
            $careers->company_remarks= $request->note;
            $careers->passport_id = $request->id;
            $careers->follow_up_status = $request->follow_up_status;
            $careers->note_added_date = $note_date;
            if($request->category == "1"){
                $careers->career_category = 1;
            }elseif($request->category == "2"){
              $careers->career_category = 2;
            }elseif($request->category == "3"){
                $careers->career_category = 3;
            }elseif($request->category == "4"){
                $careers->career_category = 4;
            }
            if($request->date != null){
            $careers->follow_up_date = $request->date;}
            $careers->user_id = Auth::user()->id;
            $careers->save();

        $message = [
            'message' => 'Note has been Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function waitlist_reject_save(Request $request){

        $career = $request->id;
        $status = 1;

        $career_table = Career::find($career);
        $past_status  = $career_table->applicant_status;
        $career_table->applicant_status = $status;
        $career_table->past_status = $past_status;
        $career_table->follow_up_status = "0";
        $career_table->update();

        $mytime = Carbon::now();
        $note_date = $mytime->toDateString();

        $careers = new CareerStatusHistory();
        $careers->remarks= $request->reject_reason;
        $careers->company_remarks= $request->reject_reason;
        $careers->note_added_date = $note_date;
        $careers->career_id = $career;
        $careers->status = $status;
        $careers->user_id = Auth::user()->id;
        $careers->save();

        $message = [
            'message' => 'Candidate Status has been changed successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function waitlist_rejoin_reject_save(Request $request){

        $status = 1;
        $time_stamp = Carbon::now()->toDateTimeString();
        $career = $request->id;

        $rejoin_table = RejoinCareer::find($career);
        $past_status = $rejoin_table->applicant_status;
        $rejoin_table->past_status = $past_status;

        $rejoin_table->applicant_status = $status;
        $passport_id = $rejoin_table->passport_id;
        $rejoin_table->update();

        $is_rejoin = RejoinCareer::where('passport_id','=',$passport_id)->where('hire_status','=','0')->first();

        if($is_rejoin!=null){

            $is_ready_array =  json_decode($is_rejoin->history_status,true);
            $gamer =  ['4' => $time_stamp];
            array_push($is_ready_array, $gamer);
            $is_rejoin->history_status = json_encode($is_ready_array);
            $is_rejoin->update();
        }else{

            $array_new =['4' => $time_stamp];
            $rejoin = new RejoinCareer();
            $rejoin->passport_id = $passport_id;
            $rejoin->history_status = json_encode($array_new);
            $rejoin->applicant_status = $status;
            $rejoin->save();
        }

        $message = [
            'message' => 'Candidate Status has been changed successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function selected_rejoin_reject_save(Request $request){

        $status = 1;
        $career = $request->id;

        $career_table = RejoinCareer::find($career);
        $past_status  = $career_table->applicant_status;
        $career_table->applicant_status = $status;
        $career_table->past_status = $past_status;
        $career_table->update();

        $message = [
            'message' => 'Candidate Status has been changed successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function onboard_reject_save(Request $request){

        $primary_id = $request->change_status_id;
        $onboard = OnBoardStatus::where('career_id',$primary_id)->update(['on_board' => '0','assign_platform' => '0','interview_status' => '0',]);

        $career= Career::find($primary_id);
        $career->applicant_status = $request->follow_up_status;
        $career->follow_up_remove = "0";
        $career->update();

        $caption_now = "";
        if($request->follow_up_status=="4"){
            $caption_now = "Selected";
        }elseif($request->follow_up_status=="5"){
            $caption_now = "wait List";
        }else{
            $caption_now = "Rejected";
        }

        $careers = new CareerStatusHistory();
        // $careers->remarks= "sent to  from onboard";
        // $careers->company_remarks="sent to  from onboard";
        $careers->career_id = $primary_id;
        $careers->status = $request->follow_up_status;
        $careers->user_id = Auth::user()->id;
        $careers->save();

        CreateInterviews::where('career_id',$primary_id)->update(array('return_from_onboard' => '1'));

        $message = [
            'message' => "Rider status has changes successfully",
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }

    public function onboard_rejoin_reject_save(Request $request){

            $primary_id = $request->change_status_id;
            $time_stamp = Carbon::now()->toDateTimeString();
            $onboard = OnBoardStatus::where('passport_id',$primary_id)->update(['on_board' => '0','assign_platform' => '0','interview_status' => '0',]);

            $rejoin_career = RejoinCareer::where('passport_id',$primary_id)
                                            ->where('on_board','=','1')
                                            ->where('hire_status','=','0')->orderby('id','desc')->first();

            $status_to_update = "";
            if($request->follow_up_status=="4"){
                $status_to_update = "2";
            }elseif($request->follow_up_status=="5"){
                $status_to_update = "1";
            }else{
                $status_to_update = "4";
            }

            $rejoin_career->applicant_status =  $request->follow_up_status;
            $rejoin_career->on_board =  "0";
            $rejoin_career->follow_up_status =  "0";

            $data =  json_decode($rejoin_career->history_status,true);
            array_push($data, [$status_to_update => $time_stamp]);
            $rejoin_career->history_status = json_encode($data);
            $rejoin_career->save();

            $message = [
                'message' => "Rider status has changes successfully",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);
    }

    public function get_pacakges_ajax_list(Request $request){

        if($request->ajax()){

            $packages_lists = Package::all();

            echo json_encode($packages_lists);
            exit;
        }

    }

    public function get_pacakges_ajax_detail(Request $request){

        if($request->ajax()){

            $primary_id = $request->primary_id;

            $package_detail = Package::where('id','=',$primary_id)->first();

            $array = array(
                'package_name' => $package_detail->package_name,
                'platform' => $package_detail->platform_detail->name,
                'state' =>  $package_detail->state_detail->name,
                'qty' =>   $package_detail->qty,
                'salary_package' => $package_detail->salary_package,
            );

            echo json_encode($array);
            exit;
        }

    }

    public function get_single_interview_by_package(Request $request){

                if($request->ajax()){

                    // $primary_id  = $request->primary_id;

                    // $career_detail = Career::where('id','=',$primary_id)->first();

                     $pkg_id = $request->pkg_id;

                      $pkg_detail = Package::where('id','=',$pkg_id)->first();

                      $city_id = $pkg_detail->state;
                      $platform = $pkg_detail->platform;

                      $interview_batches = InterviewBatch::where('cities','LIKE','%'.$city_id.'%')
                      ->where('platform_id','=',$platform)
                        ->get();

                        $city_name =   $pkg_detail->state_detail->name;
                        $platform_name =   $pkg_detail->platform_detail->name;


                    $view = view('admin-panel.career.new_career.package_interview_single_ajax',compact('city_name',"platform_name",'interview_batches'))->render();
                    return response(['html' => $view]);
                }

     }




    //pkg selection end here





}
