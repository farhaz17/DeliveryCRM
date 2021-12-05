<?php

namespace App\Http\Controllers\Career;


use Carbon\Carbon;
use App\Mail\SendOtp;
use App\Model\Cities;
use App\CareerRequest;
use App\Model\Platform;
use App\Mail\CareerMail;
use App\Mail\HiringEmail;
use App\Mail\RemarksMail;
use App\Model\Nationality;
use App\Model\AgreedAmount;
use App\Model\Guest\Career;
use App\Model\Master\FourPl;
use Illuminate\Http\Request;
use App\Model\exprience_month;
use App\Model\Referal\Referal;
use App\Model\Passport\Passport;
use App\Model\RejoinCareerHitory;
use App\Model\Career\RejoinCareer;
use App\Model\shortlisted_statuses;
use App\Http\Controllers\Controller;
use App\Model\Master\CategoryAssign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Model\Passport\RenewPassport;
use Intervention\Image\Facades\Image;
use App\Model\Seeder\Followup_statuses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Model\Career\CareerHeardAboutUs;
use Illuminate\Support\Facades\Validator;
use App\Model\LogAfterPpuid\LogAfterPpuid;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\VisaProcess\AssigningAmount;
use App\Model\DrivingLicense\DrivingLicense;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Model\Passport\passport_addtional_info;
use App\Model\CareerStatusHistory\CareerStatusHistory;


class CareerContrller extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|hiring-pool-pending|Hiring-pool', ['only' => ['index','store','destroy','edit']]);        $this->middleware('role_or_permission:Admin|hiring-pool-rejected|Hiring-pool|Rejection-report', ['only' => ['career_rejected']]);
        $this->middleware('role_or_permission:Admin|hiring-pool-document-pending|Hiring-pool|', ['only' => ['career_document_pending']]);
        $this->middleware('role_or_permission:Admin|hiring-pool-document-pending|Hiring-front-desk|Hiring-pool', ['only' => ['update']]);
    }


    public function index(){




        $passport_no = Passport::pluck('passport_no')
            ->toArray();

        $today = Carbon::today();
//        dd($today->subDays(7));


        $careers = Career::where('created_at', '>', $today->subDays(7))->get();
        $not_verified = Career::where('applicant_status','=','0')->where('created_at', '>=', $today->subDays(7))->get();

        $rejected = Career::where('applicant_status','=','1')->where('created_at', '>=', $today->subDays(7))->get();
        $document_pending = Career::where('applicant_status','=','2')->where('created_at', '>=', $today->subDays(7))->get();
        $short_listed = Career::where('applicant_status','=','3')->where('created_at', '>=', $today->subDays(7))->get();

        $driving_license_yes = Career::where('licence_status','=','1')->where('created_at', '>=', $today->subDays(7))->get();
        $driving_license_no = Career::where('licence_status','=','0')->where('created_at', '>=', $today->subDays(7))->get();


        $first_priority =  Career::select('careers.*')
                                    ->where('licence_status','=','1')   // driving license = yes
                                    ->where('company_visa','=','1')  // taking visa company =yes
                                    ->where(function ($q) {       // visa status  = cancel / visit visa
                                    $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
                                    })
                                    ->where('applicant_status','=','0')
                                    ->whereNull('careers.refer_by')
                                    ->where('careers.created_at', '>=', $today->subDays(7))
                                    ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                                    ->orderBy('careers.id','desc')
                                    ->get();

//        dd($first_priority);

        $second_priority = Career::select('careers.*')
                                    ->where('licence_status','=','1') // driving license = yes
                                  ->where('company_visa','=','1')  // taking visa company =yes
                                  ->where('visa_status','=','3') // own
                                    ->where('careers.created_at', '>=', $today->subDays(7))
                                  ->where('applicant_status','=','0')
                                    ->whereNull('refer_by')
                                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')

                                    ->orderBy('careers.id','desc')
                                   ->get();


        $third_priority = Career::select('careers.*')
                                    ->where(function ($q) {
                                    $q->where('licence_status', '!=', '1')->orWhere('company_visa', '!=', '1')->orWhere('visa_status', '=', '0')->orWhereNUll('visa_status')
                                        ;
                                })
                                ->where('applicant_status','=','0')
                                ->where('careers.created_at', '>=', $today->subDays(7))
                                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                                    ->whereNull('refer_by')
                                ->orderBy('careers.id','desc')
                                ->get();

        $referal_users = Career::select('careers.*')->whereNotNull('refer_by')->where('applicant_status','=','0')->get();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();


        return view('admin-panel.career.index',compact('from_sources','source_type_array','referal_users','careers', 'first_priority', 'second_priority', 'third_priority','driving_license_no','driving_license_yes','not_verified','rejected','document_pending','short_listed'));

    }

    public function ajax_filter_color(Request $request){

        $today = Carbon::today();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        if($request->priority=="first_priority"){

            $today = Carbon::today();
//            dd($today->subDays(7));

            $first_priority =  Career::select('careers.*')
                ->where('licence_status','=','1')   // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where(function ($q) {       // visa status  = cancel / visit visa
                    $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
                })
                ->where('applicant_status','=','0')
                ->whereNull('careers.refer_by')
                ->where('careers.created_at','>=',$today->subDays(7))
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                ->orderBy('careers.id','desc')
                ->get();



            $color = $request->color;

            $request_priority = $request->priority;

            $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="second_priority"){

            $first_priority = Career::select('careers.*')
                ->where('licence_status','=','1') // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where('visa_status','=','3') // own
                ->where('applicant_status','=','0')
                ->where('careers.created_at', '>=', $today->subDays(7))
                ->whereNull('refer_by')
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')

                ->orderBy('careers.id','desc')
                ->get();

            $color = $request->color;
            $request_priority = $request->priority;

            $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="third_priority"){
            $first_priority = Career::select('careers.*')
                ->where(function ($q) {
                    $q->where('licence_status', '!=', '1')->orWhere('company_visa', '!=', '1')->orWhere('visa_status', '=', '0')->orWhereNUll('visa_status')
                    ;
                })
                ->where('applicant_status','=','0')
                ->where('careers.created_at', '>=', $today->subDays(7))
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                ->whereNull('refer_by')
                ->orderBy('careers.id','desc')
                ->get();

            $color = $request->color;

            $request_priority = $request->priority;

             $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();

            return response()->json(['html'=>$view]);

        }elseif($request->priority=="rejected"){
            $first_priority = Career::where('applicant_status','=','1')->whereNull('refer_by')->orderby('id','desc')->get();

            $color = $request->color;

            $request_priority = $request->priority;

            $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="rejected_referal"){
//            $first_priority = Career::where('applicant_status','=','1')->whereNull('refer_by')->orderby('id','desc')->get();

            $first_priority = Career::where('applicant_status','=','1')->whereNotNull('refer_by')->orderby('id','desc')->get();

            $color = $request->color;
            $request_priority = "referal";

            $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="document_pending"){

            $passport = Passport::pluck('passport_no')->toArray();
            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','=','0')
                ->orderBy('updated_at','desc')->get();

            $color = $request->color;
            $request_priority = $request->priority;

            $view = view('admin-panel.career.ajax_career_color_filter_document_pending',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="document_pending_referals"){

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNotNull('refer_by')
                ->where('status_after_shortlist','=','0')
                ->orderBy('updated_at','desc')->get();

            $color = $request->color;
            $request_priority = "referal";


            $view = view('admin-panel.career.ajax_career_color_filter_document_pending',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="referal"){

            $first_priority = Career::select('careers.*')->whereNotNull('refer_by')->where('applicant_status','=','0')->get();

            $color = $request->color;

            $request_priority = $request->priority;

            $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();

            return response()->json(['html'=>$view]);
        }elseif($request->priority=="withlicense"){

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::select('careers.*')
                            ->where('licence_status','=','1')
                            ->where('applicant_status','=','2')
                            ->where('status_after_shortlist','=','0')
                        ->whereNotIn('passport_no',$passport)->get();

            $color = $request->color;

            $request_priority = $request->priority;

            $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();

            return response()->json(['html'=>$view]);
        }elseif($request->priority=="wihoutlicense"){

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::select('careers.*')
                ->where(function ($query) {
                    $query->whereNull('licence_status')
                        ->orwhere('licence_status','=','2');
                })
                ->whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->where('status_after_shortlist','=','0')
                ->get();



            $color = $request->color;

            $request_priority = $request->priority;

            $view = view('admin-panel.career.ajax_career_color_filter',compact('source_type_array','from_sources','request_priority','first_priority','color'))->render();

            return response()->json(['html'=>$view]);
        }


    }

    public function get_ajax_filter_color_block_count(Request $request)
    {
        $today = Carbon::today();

        $total_first_priority_24 = 0;
        $total_first_priority_48 = 0;
        $total_first_priority_72 = 0;
        $total_first_priority_less_24 = 0;

        if($request->priority=="first_priority"){

            $first_priority =  Career::select('careers.*')
                ->where('licence_status','=','1')   // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where(function ($q) {       // visa status  = cancel / visit visa
                    $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
                })
                ->where('applicant_status','=','0')
                ->where('careers.created_at', '>=', $today->subDays(7))
                ->whereNull('careers.refer_by')
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                ->orderBy('careers.id','desc')
                ->get();

        }elseif($request->priority=="second_priority"){

            $first_priority = Career::select('careers.*')
                ->where('licence_status','=','1') // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where('visa_status','=','3') // own
                ->where('applicant_status','=','0')
                ->where('careers.created_at', '>=', $today->subDays(7))
                ->whereNull('refer_by')
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')

                ->orderBy('careers.id','desc')
                ->get();


        }elseif($request->priority=="third_priority"){
            $first_priority = Career::select('careers.*')
                ->where(function ($q) {
                    $q->where('licence_status', '!=', '1')->orWhere('company_visa', '!=', '1')->orWhere('visa_status', '=', '0')
                    ;
                })
                ->where('applicant_status','=','0')
                ->where('careers.created_at', '>=', $today->subDays(7))
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                ->whereNull('refer_by')
                ->orderBy('careers.id','desc')
                ->get();

        }elseif($request->priority=="referal"){

            $first_priority = Career::select('careers.*')->whereNotNull('refer_by')->where('applicant_status','=','0')->get();

        }elseif($request->priority=="rejected_referal"){


            $first_priority = Career::where('applicant_status','=','1')->whereNotNull('refer_by')->orderby('id','desc')->get();

        }elseif($request->priority=="rejected"){

            $first_priority = Career::where('applicant_status','=','1')->whereNull('refer_by')->orderby('id','desc')->get();

        }elseif($request->priority=="document_pending"){

            $passport = Passport::join('driving_licenses','driving_licenses.passport_id','=','passports.id')
                ->get()
                ->pluck('passport_no')
                ->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','=','0')
                ->orderBy('updated_at','desc')->get();

        }elseif($request->priority=="document_pending_referals"){

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNotNull('refer_by')
                ->where('status_after_shortlist','=','0')
                ->orderBy('updated_at','desc')->get();

        }elseif($request->priority=="withlicense"){

            $passport = Passport::pluck('passport_no')->toArray();


            $first_priority = Career::select('careers.*')->where('licence_status','=','1')
                ->where('applicant_status','=','2')
                ->where('status_after_shortlist','=','0')
                    ->whereNotIn('passport_no',$passport)->get();


        }elseif($request->priority=="wihoutlicense"){

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::select('careers.*')
                ->where(function ($query) {
                    $query->whereNull('licence_status')
                        ->orwhere('licence_status','=','2');
                })
                ->where('applicant_status','=','2')
                ->where('status_after_shortlist','=','0')
                ->whereNotIn('passport_no',$passport)
                ->get();



        }

        foreach ($first_priority as $career) {

            $from = \Carbon\Carbon::parse($career->updated_at);
            $to = \Carbon\Carbon::now();
            $hours_spend = $to->diffInHours($from);
            if ($hours_spend < 24) {
                $total_first_priority_less_24 = $total_first_priority_less_24 + 1;
            }elseif($hours_spend >= 24 && $hours_spend < 48) {
                $total_first_priority_24 = $total_first_priority_24 + 1;
            }elseif($hours_spend >= 48 && $hours_spend <= 72) {
                $total_first_priority_48 = $total_first_priority_48 + 1;
            }elseif($hours_spend > 72) {
                $total_first_priority_72 = $total_first_priority_72 + 1;
            }
        }

        $gamer = array(
            'orange' => $total_first_priority_24,
            'pink' => $total_first_priority_48,
            'red' => $total_first_priority_72,
            'white' => $total_first_priority_less_24,
        );

        return $gamer;


    }


    function save_passport_id_ajax(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'nation_id' => 'required',
                'career_primary_id' => 'required|unique:passports,career_id',
                'passport_number' => 'required|unique:passports,passport_no',
//                'sur_name' => 'required',
                'given_names' => 'required',
                'father_name' => 'required',
                'agreed_amount' => 'required',
                'final_amount' => 'required',
//                'attchemnt' => 'required',
            ]);
            if ($validator->fails()) {
                return $validator->errors()->first().",";
            }

            $first_five_digit_passport =  substr($request->passport_number, 0, 7);


            $check_five_passport = Passport::where('passport_no','LIKE',$first_five_digit_passport."%")->first();


            if($check_five_passport != null){

                return "First Five digit of passport no is already exist.!";
            }

            $renew_passport = RenewPassport::where('renew_passport_number','=',$request->passport_number)->first();

            if($renew_passport != null){
                return "Passport number is already exist in Renew passport";
            }


            if($request->nation_id=="1"){
                $validator = Validator::make($request->all(), [
                    'nic_number' => 'required|unique:passports,citizenship_no'
                ]);

                if ($validator->fails()) {
                    return $validator->errors()->first().",";
                }
            }

             $step_amount_now  = $this->check_the_step_amount($request);

            if($step_amount_now!=$request->final_amount){
                return "Step amount is not Equal to Final Amount";
            }

            $obj = new Passport();
            $ppuid = IdGenerator::generate(['table' => 'passports', 'field' => 'pp_uid', 'length' => 7, 'prefix' => 'PP5']);

            $obj->nation_id = $request->input('nation_id');
            $obj->pp_uid = $ppuid;
            $obj->passport_no = $request->input('passport_number');
            $obj->sur_name = $request->input('sur_name');
            $obj->given_names = $request->input('given_names');
            $obj->father_name = $request->input('father_name');
            $obj->career_id = $request->input('career_primary_id');
            if($request->nation_id=="1"){
                $obj->citizenship_no = $request->input('nic_number');
            }
            $obj->save();

            $passport_id = $obj->id;

            $is_already = CategoryAssign::where('passport_id','=',$passport_id)->first();
            if($is_already == null) {

                $category_assign = new CategoryAssign();
                $category_assign->passport_id = $passport_id;
                $category_assign->assign_started_at = Carbon::now();
                $category_assign->main_category = 2 ; // main category Workers = 2
                $category_assign->sub_category1 = 1 ; // Sub Category 1 Riders = 1
                $category_assign->sub_category2 = 10; // Sub Category 2 Rider = 10
                $category_assign->save();

            }


            $career = Career::find($request->career_primary_id);
            $email_to_send = $career->email;
            $applicant_status =  $career->applicant_status;
            $career->update();
            $career_history = new CareerStatusHistory();
            $career_history->career_id = $request->career_primary_id;
            $career_history->status = $applicant_status;
            $career_history->save();



            $career = Career::find($request->input('career_primary_id'));
            $career->passport_no = $request->input('passport_number');
            $career->update();


            $sir_name=$request->input('sur_name');
            $given_name=$request->input('given_names');
            $father_name=$request->input('father_name');
            if ($sir_name==null){
                $full_name=$given_name." ".$father_name;
            }
            else{
                $full_name=$given_name." ".$sir_name." ".$father_name;
            }

            $obj2 = new passport_addtional_info();
            $obj2->passport_id = $passport_id;
            $obj2->full_name = $full_name;
            $obj2->save();

            $logafter = new LogAfterPpuid();
            $logafter->passport_id =  $passport_id;
            $logafter->log_status_id =  1;
            $logafter->save();


            $is_agreed_amount = AgreedAmount::where('passport_id','=',$passport_id)->first();

            if($is_agreed_amount != null){
                return "Agreed Amount Already Entered,";
            }


            $advance_amount = 0;
            $json_discount_detail = "";
            if(!empty($request->discount_name) && !empty($request->discount_amount)){

                $array_to_send = [];

//                foreach ($request->discount_amount as $d_amount){
                    $data = array(
                        'name' => $request->discount_name,
                        'amount' =>$request->discount_amount,
                    );
                    $array_to_send [] = $data;
//                }
                $json_discount_detail = json_encode($array_to_send);
            }

            if(!empty($request->advance_amount)){
                $advance_amount =  $request->advance_amount;
            }

            $date_folder = date("Y-m-d");

            if (!file_exists('../public/assets/upload/agreed_amount/'.$date_folder."/")) {
                mkdir('../public/assets/upload/agreed_amount/'.$date_folder."/", 0777, true);
            }

            if($request->hasfile('attchemnt')) {
                if (!empty($_FILES['attchemnt']['name'])) {

//                    $ext = pathinfo($_FILES['attchemnt']['name'], PATHINFO_EXTENSION);
//                    $file_name = time() . "_" . $request->date . '.' . $ext;
//
//                    move_uploaded_file($_FILES["attchemnt"]["tmp_name"], '../public/assets/upload/agreed_amount/' . $date_folder . "/" . $file_name);
//                    $file_path_front = 'assets/upload/agreed_amount/' . $date_folder . "/" . $file_name;

                    $img = $request->file('attchemnt');
                    $file_path_front = 'assets/upload/agreed_amount/' .time() . '.' . $img ->getClientOriginalExtension();

                    $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    Storage::disk("s3")->put($file_path_front, $imageS3->stream());

                }
            }


            $agreed_amount  = new AgreedAmount();
            $agreed_amount->passport_id =  $passport_id;
            $agreed_amount->agreed_amount = $request->agreed_amount;
            $agreed_amount->advance_amount  = $advance_amount;
            if(isset($json_discount_detail)){
                $agreed_amount->discount_details = $json_discount_detail;
            }

            $agreed_amount->final_amount = $request->final_amount;
            if(!empty($file_path_front)){
                $agreed_amount->attachment = $file_path_front;
            }
            if(isset($request->payroll_deduct)){
                $agreed_amount->payroll_deduct_amount = $request->payroll_deduct_amount;
            }

            $agreed_amount->save();
            $last_id = $agreed_amount->id;

            $logAfter = new  LogAfterPpuid();
            $logAfter->log_status_id = 2;
            $logAfter->passport_id = $passport_id;
            $logAfter->save();



            if(!empty($request->select_amount_step)){

                $counter_amount_step = 0;
                foreach($request->select_amount_step as  $step_amount){
                    if(!empty($step_amount) && !empty($request->step_amount[$counter_amount_step])){
                        $array_insert = array(
                            'amount' => $request->step_amount[$counter_amount_step],
                            'master_step_id' => $step_amount,
                            'passport_id' => $passport_id,
                            'agreed_amount_id' => $last_id,
                        );
                        AssigningAmount::create($array_insert);
                    }
                    $counter_amount_step =  $counter_amount_step+1;
                }

            }

            $career_check_licence = Career::find($request->career_primary_id);

            if($career_check_licence->licence_status=="1" && !empty($career_check_licence->licence_no)){

                $career_driving = DrivingLicense::where('passport_id',$passport_id)->first();

                if($career_driving==null){

                    $now_driving  = new DrivingLicense();
                    $now_driving->passport_id = $passport_id;
                    $now_driving->license_type =  $career_check_licence->licence_status_vehicle;
                    $now_driving->license_number =  $career_check_licence->licence_no;
                    $now_driving->issue_date =  $career_check_licence->licence_issue;
                    $now_driving->expire_date =  $career_check_licence->licence_expiry;
                    $now_driving->traffic_code =  $career_check_licence->traffic_file_no;
                    $now_driving->place_issue =  $career_check_licence->licence_city_id;
                    $now_driving->image =  $career_check_licence->licence_attach;
                    $now_driving->back_image =   $career_check_licence->licence_attach_back;
                    $now_driving->save();


                }

            }



            //send emial to candiate
           $data = array(
               'passport_no' => $request->input('passport_number'),
               'name' => $full_name,
           );
            Mail::to($email_to_send)
                ->send(new HiringEmail($data));


            return "success,".$passport_id;

        }catch(\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }



    function save_passport_id_four_pl_ajax(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'nation_id' => 'required',
                'career_primary_id' => 'required|unique:passports,career_id',
                'passport_number' => 'required|unique:passports,passport_no',
//                'sur_name' => 'required',
                'given_names' => 'required',
                'father_name' => 'required',


            ]);
            if ($validator->fails()) {
                return $validator->errors()->first().",";
            }

            if($request->nation_id=="1"){
                $validator = Validator::make($request->all(), [
                    'cnic' => 'required|unique:passports,citizenship_no'
                ]);

                if ($validator->fails()) {
                    return $validator->errors()->first().",";
                }
            }


            $obj = new Passport();
            $ppuid = IdGenerator::generate(['table' => 'passports', 'field' => 'pp_uid', 'length' => 7, 'prefix' => 'PP5']);

            $obj->nation_id = $request->input('nation_id');
            $obj->pp_uid = $ppuid;
            $obj->passport_no = $request->input('passport_number');
            $obj->sur_name = $request->input('sur_name');
            $obj->given_names = $request->input('given_names');
            $obj->father_name = $request->input('father_name');
            $obj->career_id = $request->input('career_primary_id');
            if($request->nation_id=="1"){
                $obj->citizenship_no = $request->input('cnic');
            }
            $obj->save();

            $passport_id = $obj->id;

            $category_assign = new CategoryAssign();
            $category_assign->passport_id = $passport_id;
            $category_assign->assign_started_at = Carbon::now();
            $category_assign->main_category = 2 ; // main category Workers = 2
            $category_assign->sub_category1 = 1 ; // Sub Category 1 Riders = 1
            $category_assign->sub_category2 = 10; // Sub Category 2 Rider = 10
            $category_assign->save();

            $career = Career::find($request->input('career_primary_id'));
            $career->passport_no = $request->input('passport_number');
            $career->update();


            $sir_name=$request->input('sur_name');
            $given_name=$request->input('given_names');
            $father_name=$request->input('father_name');
            if ($sir_name==null){
                $full_name=$given_name." ".$father_name;
            }
            else{
                $full_name=$given_name." ".$sir_name." ".$father_name;
            }

            $obj2 = new passport_addtional_info();
            $obj2->passport_id = $passport_id;
            $obj2->full_name = $full_name;
            $obj2->save();

            $logafter = new LogAfterPpuid();
            $logafter->passport_id =  $passport_id;
            $logafter->log_status_id =  1;
            $logafter->save();

            return "success,".$passport_id;

        }catch(\Illuminate\Database\QueryException $e) {
            return $e;
        }
    }


    function check_the_step_amount($request){

        $totaly_amount = 0;

        foreach ($request->step_amount as $amount){
            $totaly_amount = $totaly_amount+$amount;
        }

        if(isset($request->payroll_deduct)){
            $totaly_amount = $totaly_amount+$request->payroll_deduct_amount;
        }

        return $totaly_amount;
    }




    public function edit($id){

         $platform = Platform::all();

          $career = Career::find($id);
          $exp_months = exprience_month::all();
          $cities = Cities::all();

//          dd($career);

        return view('admin-panel.career.edit',compact('exp_months','platform','career','cities'));
    }

    public function update(Request $request,$id){


//dd($request->all());
        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
//        try {




        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'passport_no' => "required|unique:careers,passport_no,".$id,
            'email' => 'required|email|unique:careers,email,'.$id,
            'phone' => 'required',
            'full_number' => 'required|unique:careers,phone,'.$id,
            'whats_app_full_number' => 'required|unique:careers,whatsapp,'.$id,
            'cities' => 'required',
            'employee_type' => 'required',
            'apply_for' => 'required',
            'medical_type' => 'required',
            'license_status' => 'required',

        ]);
        if ($validator->fails()) {
            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
//            return redirect()->back()->with($message);
            return $validator->errors()->first();
        }

        if($request->license_status=="1"){

            $obj_checking = Career::find($id);

            if($obj_checking->licence_attach != null){ // check if image already in pics

                $validator = Validator::make($request->all(), [
                    'license_type' => 'required',
                    'licence_no' => "required|unique:careers,licence_no,".$id,
                    'licence_issue_date' => 'required',
                    'licence_expiry_date' => 'required',
                    'traffic_no' => 'required',
                    'licence_city' => 'required',
               ]);

                if ($validator->fails()) {
                    return $validator->errors()->first();
                }

            }else{

                $validator = Validator::make($request->all(), [
                    'license_type' => 'required',
                    'licence_no' => "required|unique:careers,licence_no,".$id,
                    'licence_issue_date' => 'required',
                    'licence_expiry_date' => 'required',
                    'traffic_no' => 'required',
                    'licence_city' => 'required',
                    'licence_front_pic' => 'required',
                    'licence_back_pic' => 'required',

               ]);

                if ($validator->fails()) {
                    return $validator->errors()->first();
                }

            }



             $is_alread_driving = DrivingLicense::where('license_number',$request->licence_no)->first();

            if($is_alread_driving != null){

                $passport_id_in_driving = $is_alread_driving->passport_id;

                 $driving_passport = Passport::where('id',$passport_id_in_driving)->first();

                 if($driving_passport->career_id==$id){

                   $now_exist_with_other_driving = DrivingLicense::where('license_number',$request->licence_no)->where('passport_id','!=',$passport_id_in_driving)->first();
                   if($now_exist_with_other_driving != null){
                    return "Licence Number already be taken";
                   }

                 }else{
                    return "Licence Number already be taken";
                 }


            }

        }


        $exist_passport_id = Passport::where('career_id','=',$id)->first();

        if($exist_passport_id==null){
                $validator = Validator::make($request->all(), [
                    'visa_status' => 'required',
                ]);
                if($validator->fails()){

                    return $validator->errors()->first();
                   }
        }


        $already_passport = Passport::where('passport_no','=',$request->passport_no)->where('career_id','!=',$id)->first();

        if($already_passport != null){
            return "Passport number is already register with us";
        }

        $passport_check = RenewPassport::where('renew_passport_number','=',$request->passport_no)->first();
        if($passport_check != null){

            return "Passport number is already register with us";
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


        $full_number = preg_replace("/[\s-]/", "", $request->full_number);
        $whats_app_full_number = preg_replace("/[\s-]/", "", $request->whats_app_full_number);

        $obj= Career::find($id);
        $obj->name = trim($request->input('name'));
        $obj->email = trim($request->input('email'));
        $obj->phone = $full_number;
        $obj->whatsapp = $whats_app_full_number;
        $obj->employee_type = $request->employee_type;
        $obj->promotion_type = $request->promotion_type;
        $obj->social_media_id_name = $request->social_id_name;
        if(!empty($request->input('apply_for'))){
            $obj->vehicle_type = trim($request->input('apply_for'));
        }


        if(!empty($request->medical_type)){
            $obj->medical_type = $request->medical_type;
        }

        if(!empty($request->care_of)){
            $obj->care_of = $request->care_of;
        }

        if(!empty($request->remarks)){
            $obj->remarks = $request->remarks;
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

        if($request->input('license_status')=="1"){
            if(!empty($request->license_type)){
                $obj->licence_status_vehicle = trim($request->license_type);
            }
            if(!empty($request->licence_no)){
                $obj->licence_no = trim($request->licence_no);
            }
            if(!empty($request->traffic_no)){
                $obj->traffic_file_no = trim($request->traffic_no);
            }

            if(!empty($request->licence_issue_date)){
                $obj->licence_issue = $request->licence_issue_date;
            }
            if(!empty($request->licence_expiry_date)){
                $obj->licence_expiry = trim($request->licence_expiry_date);
            }

            if(!empty($request->licence_city)){
                $obj->licence_city_id = $request->licence_city;
            }

            if (!file_exists('../public/assets/upload/driving_licence_img/front')) {
                mkdir('../public/assets/upload/driving_licence_img/front', 0777, true);
            }
            if(!empty($_FILES['licence_front_pic']['name'])) {
                $img = $request->file('licence_front_pic');
                $file_path_image = 'assets/upload/driving_licence_img/front/' .time() . '.' . $img ->getClientOriginalExtension();
                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                Storage::disk("s3")->put($file_path_image, $imageS3->stream());
                $obj->licence_attach = $file_path_image;
            }
            if(!file_exists('../public/assets/upload/driving_licence_img/back')) {
                mkdir('../public/assets/upload/driving_licence_img/back', 0777, true);
            }
            if(!empty($_FILES['licence_back_pic']['name'])) {
                $img = $request->file('licence_back_pic');
                $file_path_image_back = 'assets/upload/driving_licence_img/back/' .time() . '.' . $img ->getClientOriginalExtension();
                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                Storage::disk("s3")->put($file_path_image_back, $imageS3->stream());
                $obj->licence_attach_back = $file_path_image_back;
            }
        }

        if(!empty($request->input('national_id'))){
             $obj->nationality = $request->input('national_id');
             if($request->national_id=="1"){
                $obj->nic_expiry = $request->nic_expiry;
             }
        }

        if(!empty($request->input('dob'))){
            $obj->dob = trim($request->input('dob'));
        }
        if(!empty($request->passport_no)) {
            $obj->passport_no = trim($request->passport_no);
            }
        if(!empty($request->passport_expiry)){
            $obj->passport_expiry = trim($request->passport_expiry);
        }

        $file2?$obj->passport_attach = $file2:"";

        if(!empty($request->input('visa_status'))){
            $obj->visa_status = trim($request->input('visa_status'));
        }

        $passport_id = Passport::where('career_id','=',$obj->id)->first();
        if($passport_id==null){
            if($request->input('visa_status')=="1"){
                $validator = Validator::make($request->all(), [
                    'visit_visa_status' => 'required',
                    'visit_exit_date' => 'required',
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                }
                $obj->visa_status_visit = trim($request->input('visit_visa_status'));
                $obj->exit_date = trim($request->visit_exit_date);

            }elseif($request->input('visa_status')=="2"){
                $validator = Validator::make($request->all(), [
                    'cancel_visa_status' => 'required',
                    'cancel_fine_date' => 'required'
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                }
                $obj->visa_status_cancel = trim($request->input('cancel_visa_status'));
                $obj->exit_date = trim($request->cancel_fine_date);

            }elseif($request->input('visa_status')=="3"){
                $validator = Validator::make($request->all(), [
                    'own_visa_status' => 'required'
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                }
                $obj->visa_status_own = trim($request->input('own_visa_status'));
            }

        }

        if(!empty($request->input('platform_id'))){
            $obj->platform_id = json_encode($request->input('platform_id'));
        }
        if(!empty($request->cities)){
            $obj->cities = json_encode($request->cities);
        }
        if($request->button_type_click!="2"){

            if(!isset($request->search_all_over) && $request->license_status!="2"){
                $obj->applicant_status = 5;
            }

        }
            $image_ids = $request->image_array;
            $now_array_image = explode(",",$image_ids);
            $date_folder = date("Y-m-d");

            if (!file_exists('../public/assets/upload/career/physical_doc/'.$date_folder."/")) {
                mkdir('../public/assets/upload/career/physical_doc/'.$date_folder."/", 0777, true);
            }

            $counter = 0;
            $array_to_save_physical_doc = array();
            foreach($now_array_image as $id_image){

                 $paramter_name = "physical_doc_image_".$id_image;
                 $paramter_doc_name = "physical_doc_name_".$id_image;

                 if(!empty($request->$paramter_name)){
                     $counter = $counter+1;
                     $array_to_send = array();
                     $images = $request->file($paramter_name);
                     foreach($images as $key => $file)
                     {
                        $name =rand(100,100000).'.'.time().'.'.$file->extension();
                        $filePath ='assets/upload/career/physical_doc/'. date("Y-m-d"). "/" . $name;
                        $imageS3 = Image::make($file)->resize(null, 500, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        Storage::disk("s3")->put($filePath, $imageS3->stream());
                        $array_to_send [] = $name;
                    }
                     $data = array(
                         'name' => $request->$paramter_doc_name,
                         'image' => $array_to_send,
                     );
                     $array_to_save_physical_doc [] = $data;
                }

            }

            if(count($array_to_save_physical_doc)>0){
                $json_detail = json_encode($array_to_save_physical_doc,JSON_UNESCAPED_SLASHES);
                $obj->physical_document = $json_detail;
            }






        $obj->follow_up_status = "0";
        $obj->employee_status_id = 1;
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



//        $response['code'] = 1;
//        $response['message'] = 'Job Submission Successful';

        $message = [
            'message' => "Career Updated Successfully",
            'alert-type' => 'success',
            'error' => ''
        ];

        return "success";







//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = 'Submission Failed';
//
//            return response()->json($response);
//        }




    }

    public function update_after_short_list(Request $request){

        $user_id = Auth::user()->id;
        $id = $request->id;
        $obj = Career::find($id);
        $obj->remarks=$request->input('remarks');
        $obj->status_after_shortlist=$request->status;
        $obj->visa_status_after_shortlist=  $request->legal_status;
        if($request->legal_status=="4"){
             $obj->visa_status_one_after_shortlist =  $request->new_visa_status_one;
             $obj->visa_status_two_after_shortlist = $request->new_visa_status_two;

            $careers = new CareerStatusHistory();
            $careers->remarks=$request->input('remarks');
            $careers->career_id = $id;
            $careers->status =  $request->new_visa_status_one;
            $careers->status_after_shortlist = "1";
            $careers->company_remarks = $request->company_remarks;
            $careers->user_id = $user_id;
            $careers->save();

            $careers = new CareerStatusHistory();
            $careers->remarks=$request->input('remarks');
            $careers->career_id = $id;
            $careers->status = $request->new_visa_status_two;
            $careers->status_after_shortlist = "1";
            $careers->company_remarks = $request->company_remarks;
            $careers->user_id = $user_id;
            $careers->save();

        }elseif($request->legal_status=="5"){
                $obj->visa_status_one_after_shortlist = $request->freelance_visa;

            $careers = new CareerStatusHistory();
            $careers->remarks=$request->input('remarks');
            $careers->career_id = $id;
            $careers->status = $request->freelance_visa;
            $careers->status_after_shortlist = "1";
            $careers->company_remarks = $request->company_remarks;
            $careers->user_id = $user_id;
            $careers->save();
        }

        $obj->save();

        $careers = new CareerStatusHistory();
        $careers->remarks=$request->input('remarks');
        $careers->career_id = $id;
        $careers->status = $request->status;
        $careers->status_after_shortlist = "1";
        $careers->company_remarks = $request->company_remarks;
        $careers->user_id = $user_id;
        $careers->save();
        // Mail::to([$obj->email])->send(new RemarksMail($obj));
        $message = [
            'message' => 'Remarks Saved Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);

    }


    public function store(Request $request){
        $sending_status = $request->sending_status;
        $id = $request->id;
        $obj = Career::find($id);

        if(empty($obj->email)){

            $message = [
                'message' => "please enter email before change the status",
                'alert-type' => 'error',
                'error' => ""
            ];
            return redirect()->route('career')->with($message);
        }

        if ($sending_status=='2'){
            $id = $request->id;
            $obj = Career::find($id);
            $obj->remarks=$request->input('remarks');
            $obj->save();

            $careers = new CareerStatusHistory();
            $careers->remarks=$request->input('remarks');
            $careers->career_id = $id;
            $careers->status = '0';
            $careers->save();
            // Mail::to([$obj->email])->send(new RemarksMail($obj));
            $message = [
                'message' => 'Remarks Saved Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }else{
            try {
                $validator = Validator::make($request->all(), [
                    'status' => 'required',
                    'remarks' => 'required',
                    'company_remarks' => 'required',
                ]);
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message_error = "";
                    foreach ($validate->all() as $error) {
                        $message_error .= $error;
                    }
                    $message = [
                        'message' => $message_error,
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->route('career')->with($message);
                }
                $id = $request->id;
                $remarks = $request->remarks;
                $status = $request->status;
                $career = Career::find($id);
                if(empty($career->passport_no)){
                    $message = [
                        'message' => 'please enter passport number before change the status',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }
                if(empty($career->email)){
                    $message = [
                        'message' => 'please enter email before change the status',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }
                $career->applicant_status = $status;
                $career->remarks = $remarks;
                $career->company_remarks = $request->company_remarks;
                $career->update();

                $career_history = new CareerStatusHistory();
                $career_history->career_id = $id;
                $career_history->status = $status;
                $career_history->remarks = $remarks;
                $career_history->company_remarks = $request->company_remarks;
                $career_history->user_id = auth()->user()->id;
                $career_history->save();
                $application_status = "";
                if ($request->status == "0") {
                    $application_status = "Not Verified";
                } elseif ($request->status == "1") {
                    $application_status = "Rejected";
                } elseif ($request->status == "2") {
                    $application_status = "Document Pending";
//                              $passport_number=trim($request->input('passport_no'));
                Referal::where('career_id','=',$id)
                    ->update(['status'=>'1']);
                }elseif ($request->status == "3") {
                    $application_status = "Short Listed";
                }elseif ($request->status == "4") {
                    $application_status = "Selected";
                }elseif ($request->status == "5") {
                    $application_status = "Wait List";
                }
                $career_array = array(
                    'status' => $application_status,
                    'remarks' => $remarks,
                );
                Mail::to([$career->email])->send(new CareerMail($career_array));
                $message = [
                    'message' => 'Status has been updated Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->route('career')->with($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return redirect()->route('career')->with($message);
            }
        }
    }

    public  function career_shortlisted(){

        $short_list = Career::where('applicant_status','=','3')->get();

        return view('admin-panel.career.short_listed',compact('short_list'));
    }

    public function career_rejected(){

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $careers = Career::where('applicant_status','=','1')->where('past_status','=','0')->orderby('id','desc')->get();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

        $platforms = Platform::all();
        $cities = Cities::all();

        $fourpls = FourPl::all();

        $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
        $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
        $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5'])->get();


     return view('admin-panel.career.new_career.rejected_candidate',compact("follow_up_status","waist_size",'shirt_size','fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'));

//        return view('admin-panel.career.rejected_listed',compact('from_sources','source_type_array','referals','short_list'));

    }

    public function get_reject_career_table(Request $request){

        if($request->ajax()){

            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

            $from_sources = CareerHeardAboutUs::all();

            if($request->status=="other"){
                $careers = Career::where('applicant_status','=','1')->whereNull('past_status')->orderby('id','desc')->get();
            }else{
                $careers = Career::where('applicant_status','=','1')->where('past_status','=',$request->status)->orderby('id','desc')->get();
            }


            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

            $from_sources = CareerHeardAboutUs::all();

            $platforms = Platform::all();
            $cities = Cities::all();

            $fourpls = FourPl::all();

            $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
            $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
            $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5'])->get();

            $view = view('admin-panel.career.new_career.get_reject_career_table',compact("follow_up_status","waist_size",'shirt_size','fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
            return response(['html' => $view]);
        }

    }

    public function get_reject_rejoin_career_table(Request $request){

        if($request->ajax()){



            if($request->status=="8"){ //wait list
                $wait_list = RejoinCareer::where('applicant_status','=','1')
                ->where('past_status','=','5')
                ->where('on_board','=','0')
                ->where('hire_status','=','0')->get();
            }elseif($request->status=="9"){ //selected

                $wait_list = RejoinCareer::where('applicant_status','=','1')
                ->where('past_status','=','4')
                ->where('on_board','=','0')
                ->where('hire_status','=','0')->get();

            }elseif($request->status=="10"){ //onboard

                 $history_passports = RejoinCareerHitory::where('past_status','=','33')->pluck('passport_id')->toArray();

                $wait_list = RejoinCareer::where('applicant_status','=','1')
                ->whereNull('past_status')
                ->whereIn('passport_id',$history_passports)
                ->where('hire_status','=','0')->get();

            }

            $view = view('admin-panel.career.new_career.get_rejoin_reject_table',compact("wait_list"))->render();
            return response(['html' => $view]);
        }

    }



    public function get_rejoin_candidate_rejected(Request $request){

        if($request->ajax()){


            $request_type = $request->request_type;

            if($request_type=="1"){  //for normal candiate's

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $careers = Career::where('applicant_status','=','1')->where('past_status','=','0')->orderby('id','desc')->get();

                $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

                $from_sources = CareerHeardAboutUs::all();

                $platforms = Platform::all();
                $cities = Cities::all();

                $fourpls = FourPl::all();

                $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
                $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");
                $follow_up_status = Followup_statuses::whereNotIn('id',['1','2','3','4','5'])->get();


                $view = view('admin-panel.career.new_career.rejected_candidate_ajax',compact("request_type","follow_up_status","waist_size",'shirt_size','fourpls','platforms','cities','platforms','careers','from_sources','source_type_array'))->render();
            return response(['html' => $view]);

            }else{ //for rejoin candidate

                $wait_list = RejoinCareer::where('applicant_status','=','1')
                                            ->where('past_status','=','5')
                                            ->where('on_board','=','0')
                                            ->where('hire_status','=','0')->get();

                $view = view('admin-panel.career.new_career.rejected_candidate_ajax',compact("request_type","wait_list"))->render();
                return response(['html' => $view]);


            }


        }


    }


    public function career_document_pending(){

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $from_sources = CareerHeardAboutUs::all();

           $passport = Passport::pluck('passport_no')
                                ->toArray();
        $short_list = Career::whereNotIn('passport_no',$passport)
                            ->where('applicant_status','=','2')
                            ->whereNull('refer_by')
                            ->where('status_after_shortlist','=','0')
                            ->orderBy('updated_at','desc')->get();

        $referals = Career::whereNotIn('passport_no',$passport)
            ->where('applicant_status','=','2')
            ->whereNotNull('refer_by')
            ->where('status_after_shortlist','=','0')
            ->orderBy('updated_at','desc')->get();


        $not_license = Career::select('careers.*')
            ->where(function ($query) {
                $query->whereNull('licence_status')
                    ->orwhere('licence_status','=','2');
            })
            ->whereNull('refer_by')
            ->where('applicant_status','=','2')
            ->where('status_after_shortlist','=','0')
            ->whereNotIn('passport_no',$passport)
            ->get();



        $license = Career::select('careers.*')
            ->where('licence_status','=','1')
            ->where('applicant_status','=','2')
            ->whereNull('refer_by')
            ->where('status_after_shortlist','=','0')
            ->whereNotIn('passport_no',$passport)
            ->get();



        $short_list_statuses = shortlisted_statuses::orderby('id','asc')->limit(3)->get();
        $short_list_legal_statuses = shortlisted_statuses::orderby('id','asc')->skip(3)->take(3)->get();
        $short_list_visa = shortlisted_statuses::orderby('id','asc')->skip(6)->take(2)->get();
        $short_list_visa_two = shortlisted_statuses::orderby('id','asc')->skip(8)->take(2)->get();
        $short_list_freelance_short = shortlisted_statuses::orderby('id','asc')->skip(10)->take(2)->get();


        $nations=Nationality::all();
        return view('admin-panel.career.document_pending_listed',compact('from_sources','source_type_array','short_list_freelance_short','short_list_visa_two','short_list_visa','short_list_legal_statuses','license','not_license','referals','short_list','nations','short_list_statuses'));
    }

    public function save_passport_passport(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'nation_id' => 'required',
                'passport_number' => 'required|unique:passports,passport_no',
                'sur_name' => 'required',
                'given_names' => 'required',
                'father_name' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                foreach ($validate->all() as $error) {
                    $message_error .= $error;
                }
                $message = [
                    'message' => $message_error,
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            $obj = new Passport();
            $ppuid = IdGenerator::generate(['table' => 'passports', 'field' => 'pp_uid', 'length' => 7, 'prefix' => 'PP5']);

            $obj->nation_id = $request->input('nation_id');
            $obj->pp_uid = $ppuid;
            $obj->passport_no = $request->input('passport_number');
            $obj->sur_name = $request->input('sur_name');
            $obj->given_names = $request->input('given_names');
            $obj->father_name = $request->input('father_name');
            $obj->career_id = $request->input('career_primary_id');
            $obj->save();

            $career = Career::find($request->input('career_primary_id'));
            $career->passport_no = $request->input('passport_number');
            $career->update();



             $passport_id = $obj->id;
            $sir_name=$request->input('sur_name');
            $given_name=$request->input('given_names');
            $father_name=$request->input('father_name');
            if ($sir_name==null){
                $full_name=$given_name." ".$father_name;
            }
            else{
                $full_name=$given_name." ".$sir_name." ".$father_name;
            }

            $obj2 = new passport_addtional_info();
            $obj2->passport_id = $passport_id;
            $obj2->full_name = $full_name;
            $obj2->save();

            $logafter = new LogAfterPpuid();
            $logafter->passport_id =  $passport_id;
            $logafter->log_status_id =  1;
            $logafter->save();

            $message = [
                'message' => "Passport Detail has been saved",
                'alert-type' => 'success',
                'error' => ""
            ];
            return redirect()->back()->with($message);


        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

    }

    public function render_shortlist_tabs_table(Request $request){

        if($request->ajax()){

            if($request->tab=="referal"){

                $passport = Passport::pluck('passport_no')->toArray();
                $referals = Career::whereNotIn('passport_no',$passport)
                    ->where('applicant_status','=','2')
                    ->whereNotNull('refer_by')
                    ->orderBy('updated_at','desc')->get();

                $color = $request->color;

                $request_priority = $request->priority;

                $view = view('admin-panel.career.ajax_career_color_filter',compact('request_priority','first_priority','color'))->render();
                return response()->json(['html'=>$view]);

            }

            $first_priority =  Career::select('careers.*')
                ->where('licence_status','=','1')   // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where(function ($q) {       // visa status  = cancel / visit visa
                    $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
                })
                ->where('applicant_status','=','0')
                ->whereNull('careers.refer_by')
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                ->orderBy('careers.id','desc')
                ->get();




        }
    }


    public function career_hired(){
        $short_list = Career::where('applicant_status','=','4')->get();

        $passport_status_array = array();

        foreach($short_list as $list){
            $curent_passport = Passport::where('passport_no','=',$list->passport_no)->first();
            if($curent_passport==null){
                $passport_status_array [] = "Not Uploaded";
            }else{
                $passport_status_array [] = "Uploaded";
            }


        }


        return view('admin-panel.career.hired',compact('short_list','passport_status_array'));
    }

    public function  career_wait_list(){



        $short_list = Career::where('applicant_status','=','5')->get();
        return view('admin-panel.career.wait_list',compact('short_list'));
    }

    public function change_status(){



        $passport = Passport::pluck('passport_no')->toArray();


        $first_priority =  Career::select('careers.*')
            ->whereNotIn('passport_no',$passport)
            ->where('status_after_shortlist','!=','1')
            ->orderBy('careers.id','asc')
            ->get();

        $source_types = CareerHeardAboutUs::all();

        $from_sources = CareerHeardAboutUs::all();

        $follow_up_statuses = Followup_statuses::all();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $nations = Nationality::all();

        $short_list_statuses = shortlisted_statuses::orderby('id','asc')->limit(3)->get();
        $short_list_legal_statuses = shortlisted_statuses::orderby('id','asc')->skip(3)->take(3)->get();
        $short_list_visa = shortlisted_statuses::orderby('id','asc')->skip(6)->take(2)->get();
        $short_list_visa_two = shortlisted_statuses::orderby('id','asc')->skip(8)->take(2)->get();
        $short_list_freelance_short = shortlisted_statuses::orderby('id','asc')->skip(10)->take(2)->get();
        return view('admin-panel.career.career_dashboard.change_status',compact('short_list_freelance_short','short_list_visa_two','short_list_visa','short_list_legal_statuses','short_list_statuses','nations','from_sources','follow_up_statuses','source_types','source_type_array','first_priority'));
    }

    public function career_add_ppuid(){


        $passport = Passport::pluck('passport_no')->toArray();


        $first_priority =  Career::select('careers.*')
            ->whereNotIn('passport_no',$passport)
            ->where('status_after_shortlist','!=','0')
            ->orderBy('careers.id','asc')
            ->get();

        $source_types = CareerHeardAboutUs::all();

        $from_sources = CareerHeardAboutUs::all();

        $follow_up_statuses = Followup_statuses::where('id','=','2')->get();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        $nations = Nationality::all();

        $short_list_statuses = shortlisted_statuses::orderby('id','asc')->limit(3)->get();
        $short_list_legal_statuses = shortlisted_statuses::orderby('id','asc')->skip(3)->take(3)->get();
        $short_list_visa = shortlisted_statuses::orderby('id','asc')->skip(6)->take(2)->get();
        $short_list_visa_two = shortlisted_statuses::orderby('id','asc')->skip(8)->take(2)->get();
        $short_list_freelance_short = shortlisted_statuses::orderby('id','asc')->skip(10)->take(2)->get();
        return view('admin-panel.career.career_dashboard.add_ppuid',compact('short_list_freelance_short','short_list_visa_two','short_list_visa','short_list_legal_statuses','short_list_statuses','nations','from_sources','follow_up_statuses','source_types','source_type_array','first_priority'));

    }

    public function ajax_filter_report_add_ppuid(Request  $request){

        $today_date = date("Y-m-d");


        $from_sources = CareerHeardAboutUs::all();

        $passport = Passport::pluck('passport_no')->toArray();
        if($request->ajax()){

            $promotion_type = $request->option;
            $user_status = $request->user_status;
            $source_type_drop = $request->source_type;


            if($promotion_type=="" && $user_status=="" && $source_type_drop==""){

                $first_priority =  Career::select('careers.*')
                    ->whereNotIn('passport_no',$passport)
                    ->where('status_after_shortlist','!=','0')
                    ->orderBy('careers.id','asc')
                    ->get();

            }elseif(!empty($promotion_type) && $user_status=="" && empty($source_type_drop)){
                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->whereNotIn('passport_no',$passport)
                        ->where('status_after_shortlist','!=','0')
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif(!empty($promotion_type) && $user_status!="" && empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('status_after_shortlist','!=','0')
                        ->where('applicant_status','=',$user_status)
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('applicant_status','=',$user_status)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif(!empty($promotion_type) &&  $user_status!="" && !empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('applicant_status','=',$user_status)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }
            elseif(!empty($promotion_type) &&  $user_status=="" && !empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }
            elseif( $user_status!="" && empty($promotion_type) && empty($source_type_drop)){


                $first_priority =  Career::select('careers.*')
                    ->where('applicant_status','=',$user_status)
                    ->where('status_after_shortlist','!=','0')
                    ->whereNotIn('passport_no',$passport)
                    ->orderBy('careers.id','asc')
                    ->get();

            }elseif( $user_status!="" && !empty($promotion_type) && empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('applicant_status','=',$user_status)
                        ->where('promotion_type','=',$promotion_type)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif($user_status!="" && !empty($promotion_type) && !empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('applicant_status','=',$user_status)
                        ->where('promotion_type','=',$promotion_type)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif(!empty($source_type_drop) &&  $user_status=="" && empty($promotion_type)){

                $first_priority =  Career::select('careers.*')
                    ->where('source_type','=',$source_type_drop)
                    ->where('status_after_shortlist','!=','0')
                    ->whereNotIn('passport_no',$passport)
                    ->orderBy('careers.id','asc')
                    ->get();
            }elseif(!empty($source_type_drop) &&  $user_status!="" && empty($promotion_type)){

                $first_priority =  Career::select('careers.*')
                    ->where('source_type','=',$source_type_drop)
                    ->where('applicant_status','=',$user_status)
                    ->where('status_after_shortlist','!=','0')
                    ->whereNotIn('passport_no',$passport)
                    ->orderBy('careers.id','asc')
                    ->get();
            }elseif(!empty($source_type_drop) &&  $user_status!="" && !empty($promotion_type)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('applicant_status','=',$user_status)
                        ->where('promotion_type','=',$promotion_type)
                        ->where('status_after_shortlist','!=','0')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }

            $source_types = CareerHeardAboutUs::all();
            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');


            if(!empty($request->color)){
                $color = $request->color;
                $view = view('admin-panel.career.career_dashboard.ajax_color_block_change_status',compact('user_status','from_sources','first_priority','source_types','color','source_type_array'))->render();
            }else{
                $view = view('admin-panel.career.career_dashboard.change_status_report_render',compact('user_status','from_sources','first_priority','source_types','source_type_array'))->render();
            }

            return response()->json(['html'=>$view]);

        }

    }

    public function ajax_filter_report_change_status(Request  $request){

        $today_date = date("Y-m-d");


        $from_sources = CareerHeardAboutUs::all();

        $passport = Passport::pluck('passport_no')->toArray();
        if($request->ajax()){

            $promotion_type = $request->option;
            $user_status = $request->user_status;
            $source_type_drop = $request->source_type;


        if($promotion_type=="" && $user_status=="" && $source_type_drop==""){

                    $first_priority =  Career::select('careers.*')
                        ->whereNotIn('passport_no',$passport)
                        ->where('status_after_shortlist','!=','1')
                        ->orderBy('careers.id','asc')
                        ->get();

            }elseif(!empty($promotion_type) && $user_status=="" && empty($source_type_drop)){
                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->whereNotIn('passport_no',$passport)
                        ->where('status_after_shortlist','!=','1')
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif(!empty($promotion_type) && $user_status!="" && empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('status_after_shortlist','!=','1')
                        ->where('applicant_status','=',$user_status)
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('applicant_status','=',$user_status)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif(!empty($promotion_type) &&  $user_status!="" && !empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('applicant_status','=',$user_status)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }
            elseif(!empty($promotion_type) &&  $user_status=="" && !empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }
            elseif( $user_status!="" && empty($promotion_type) && empty($source_type_drop)){


                    $first_priority =  Career::select('careers.*')
                        ->where('applicant_status','=',$user_status)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();

            }elseif( $user_status!="" && !empty($promotion_type) && empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('applicant_status','=',$user_status)
                        ->where('promotion_type','=',$promotion_type)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif($user_status!="" && !empty($promotion_type) && !empty($source_type_drop)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('applicant_status','=',$user_status)
                        ->where('promotion_type','=',$promotion_type)
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }elseif(!empty($source_type_drop) &&  $user_status=="" && empty($promotion_type)){

                    $first_priority =  Career::select('careers.*')
                        ->where('source_type','=',$source_type_drop)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
            }elseif(!empty($source_type_drop) &&  $user_status!="" && empty($promotion_type)){

                $first_priority =  Career::select('careers.*')
                    ->where('source_type','=',$source_type_drop)
                    ->where('applicant_status','=',$user_status)
                    ->where('status_after_shortlist','!=','1')
                    ->whereNotIn('passport_no',$passport)
                    ->orderBy('careers.id','asc')
                    ->get();
            }elseif(!empty($source_type_drop) &&  $user_status!="" && !empty($promotion_type)){

                if($promotion_type=="7"){
                    $first_priority =  Career::select('careers.*')
                        ->where('promotion_type','=',$promotion_type)
                        ->where('promotion_type','is',null)
                        ->where('applicant_status','=',$user_status)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }else{
                    $first_priority =  Career::select('careers.*')
                        ->where('applicant_status','=',$user_status)
                        ->where('promotion_type','=',$promotion_type)
                        ->where('status_after_shortlist','!=','1')
                        ->whereNotIn('passport_no',$passport)
                        ->orderBy('careers.id','asc')
                        ->get();
                }
            }

            $source_types = CareerHeardAboutUs::all();
            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');


            if(!empty($request->color)){
                $color = $request->color;
                $view = view('admin-panel.career.career_dashboard.ajax_color_block_change_status',compact('user_status','from_sources','first_priority','source_types','color','source_type_array'))->render();
            }else{
                $view = view('admin-panel.career.career_dashboard.change_status_report_render',compact('user_status','from_sources','first_priority','source_types','source_type_array'))->render();
            }

            return response()->json(['html'=>$view]);

        }

    }


    public function get_color_block_count_ajax_change_status(Request $request){

        $promotion_type = $request->option;

        $passport = Passport::pluck('passport_no')->toArray();

        if($promotion_type=="7"){

            $first_priority =  Career::select('careers.*')
                ->where('promotion_type','=',$promotion_type)
                ->whereNotIn('passport_no',$passport)
                ->orderBy('careers.id','asc')
                ->get();

        }elseif($promotion_type=="0"){
            $first_priority =  Career::select('careers.*')
                ->whereNotIn('passport_no',$passport)
                ->orderBy('careers.id','asc')
                ->get();
        }else{
            $first_priority =  Career::select('careers.*')
                ->where('promotion_type','=',$promotion_type)
                ->whereNotIn('passport_no',$passport)
                ->orderBy('careers.id','asc')
                ->get();
        }

        $total_first_priority_24 = 0;
        $total_first_priority_48 = 0;
        $total_first_priority_72 = 0;
        $total_first_priority_less_24 = 0;

        foreach ($first_priority as $career) {

            $from = \Carbon\Carbon::parse($career->updated_at);
            $to = \Carbon\Carbon::now();
            $hours_spend = $to->diffInHours($from);

            if ($hours_spend < 24) {
                $total_first_priority_less_24 = $total_first_priority_less_24 + 1;
            }elseif($hours_spend >= 24 && $hours_spend < 48) {
                $total_first_priority_24 = $total_first_priority_24 + 1;
            }elseif($hours_spend >= 48 && $hours_spend <= 72) {
                $total_first_priority_48 = $total_first_priority_48 + 1;
            }elseif($hours_spend > 72) {
                $total_first_priority_72 = $total_first_priority_72 + 1;
            }
        }

        $gamer = array(
            'orange' => $total_first_priority_24,
            'pink' => $total_first_priority_48,
            'red' => $total_first_priority_72,
            'white' => $total_first_priority_less_24,
        );

        return $gamer;
    }





    public  function  ajax_search_career_table(Request $request){

        $driving_license = $request->driving_license;
        $visa_status = $request->visa_status;



        if($request->value_s=="all" && $driving_license=="" && $visa_status==""){
                   $careers = Career::all();
//            dd("we are here");

        }elseif($driving_license!="" && $visa_status!="" && $request->value_s=="all"){


            $careers = Career::where('licence_status','=',$driving_license)->where('visa_status','=',$visa_status)->get();

        }elseif($driving_license!="" && $visa_status!="" && $request->value_s != "all"){


            $careers = Career::where('licence_status','=',$driving_license)->where('visa_status','=',$visa_status)->where('applicant_status','=',$request->value_s)->get();
//            print_r($careers);
//            dd("second if");
        }elseif($driving_license!="" && $visa_status!=""){

//            dd("third if");
            $careers = Career::where('licence_status','=',$driving_license)->where('visa_status','=',$visa_status)->get();

        }elseif($driving_license!="" && $request->value_s!="all"){

            $careers = Career::where('licence_status','=',$driving_license)->where('applicant_status','=',$request->value_s)->get();
//            echo  "forth";
//            dd($careers);
        }elseif($request->value_s!="all" && $visa_status!=""){
//            dd("fifth if");
            $careers = Career::where('visa_status','=',$visa_status)->where('applicant_status','=',$request->value_s)->get();

        }elseif($driving_license!=""){
//            dd("sixth if");
            $careers = Career::where('licence_status','=',$driving_license)->get();

        }elseif($visa_status!=""){
//            dd("seventh if");
            $careers = Career::where('visa_status','=',$visa_status)->get();

        }elseif($request->value_s=="all"){
//            dd("eight if");
            $careers = Career::all();

        }elseif($request->value_s!="all"){
//            dd("Nine if");
            $careers = Career::where('applicant_status','=',$request->value_s)->get();

        }


        $childe['data'] = array();

        if(!empty($careers)){
            foreach ($careers as $career){

                $application_status = "";
                if($career->applicant_status=="0"){
                    $application_status  = "Not Verified";
                }elseif($career->applicant_status=="1"){
                    $application_status  = "Rejected";
                }elseif($career->applicant_status=="2"){
                    $application_status  = "Document Pending";
                }elseif($career->applicant_status=="3"){
                    $application_status  = "Short Listed";
                }


                $gamer = array(
                    'id' => $career->id,
                    'name' => $career->name,
                    'email' => $career->email,
                    'phone' => $career->phone,
                    'whatsapp' => $career->whatsapp,
                    'status' => $application_status,

                );

                $childe['data'] [] = $gamer;

            }


        }

        echo json_encode($childe);
        exit;



    }

    public function ajax_search_license_count(Request $request){

        $status = $request->value_s;

        $driving_yes = "0";
        $driving_no = "0";

        if($status=="all"){
            $driving_yes = Career::where('licence_status','=','1')->count();
            $driving_no = Career::where('licence_status','=','0')->count();
        }else{
              $driving_yes = Career::where('applicant_status','=',$status)->where('licence_status','=','1')->count();
              $driving_no = Career::where('applicant_status','=',$status)->where('licence_status','=','0')->count();
         }

        return  $driving_yes.'$'.$driving_no;
    }

    public  function  ajax_search_visa_count(Request $request){

        $driving_license = $request->driving_license;
        $status = $request->value_s;

        $visit_count  = "0";
        $cancel_count  = "0";
        $own_count  = "0";
        $all_count = "0";

        if($status=="all" && $driving_license==""){

            $visit_count = Career::where('visa_status','=','1')->count();
            $cancel_count = Career::where('visa_status','=','2')->count();
            $own_count = Career::where('visa_status','=','3')->count();
            $all_count = Career::count();

        }elseif($status=="all" && $driving_license!=""){

            $visit_count = Career::where('visa_status','=','1')->where('licence_status','=',$driving_license)->count();
            $cancel_count = Career::where('visa_status','=','2')->where('licence_status','=',$driving_license)->count();
            $own_count = Career::where('visa_status','=','3')->where('licence_status','=',$driving_license)->count();
            $all_count = Career::where('licence_status','=',$driving_license)->count();

        }elseif($status!="all" && $driving_license!=""){

            $visit_count = Career::where('visa_status','=','1')->where('licence_status','=',$driving_license)->where('applicant_status','=',$status)->count();
            $cancel_count = Career::where('visa_status','=','2')->where('licence_status','=',$driving_license)->where('applicant_status','=',$status)->count();;
            $own_count = Career::where('visa_status','=','3')->where('licence_status','=',$driving_license)->where('applicant_status','=',$status)->count();;
            $all_count = Career::where('licence_status','=',$driving_license)->where('applicant_status','=',$status)->count();

        }elseif($status!="all" && $driving_license==""){

            $visit_count = Career::where('visa_status','=','1')->where('applicant_status','=',$status)->count();
            $cancel_count = Career::where('visa_status','=','2')->where('applicant_status','=',$status)->count();;
            $own_count = Career::where('visa_status','=','3')->where('applicant_status','=',$status)->count();;
            $all_count = Career::where('applicant_status','=',$status)->count();

        }

        return  $all_count.'$'.$visit_count.'$'.$cancel_count.'$'.$own_count;

    }





    public function ajax_view_remarks(Request $request){

         $id = $request->primary_id;

             if(!empty($id)){
                 $career = Career::find($id);

                 return $career->remarks;

             }

    }

    public function ajax_read_more_remark(Request $request){

        $id = $request->primary_id;

        if(!empty($id)){
            $career = CareerStatusHistory::find($id);

            return $career->remarks;

        }

    }

    public function ajax_read_more_company_remark(Request $request){

        $id = $request->primary_id;

        if(!empty($id)){
            $career = CareerStatusHistory::find($id);

            return $career->company_remarks;

        }
    }

    public function ajax_career_remark(Request $request){

        $id = $request->primary_id;

        $career_remark1 = CareerStatusHistory::select('career_status_histories.*', 'users.name', 'frontdesk_followups.name as followup_name')->where('career_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->join('frontdesk_followups','frontdesk_followups.id','career_status_histories.follow_up_status')
                                              ->where('career_status_histories.career_category', 1)
                                              ->get();

        $career_remark2 = CareerStatusHistory::select('career_status_histories.*', 'users.name', 'waitlistfollowups.name as followup_name')->where('career_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->join('waitlistfollowups','waitlistfollowups.id','career_status_histories.follow_up_status')
                                              ->where('career_status_histories.career_category', 2)
                                              ->get();

        $career_remark3 = CareerStatusHistory::select('career_status_histories.*', 'users.name', 'selected_followups.name as followup_name')->where('career_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->join('selected_followups','selected_followups.id','career_status_histories.follow_up_status')
                                              ->where('career_status_histories.career_category', 3)
                                              ->get();

        $career_remark4 = CareerStatusHistory::select('career_status_histories.*', 'users.name', 'onboard_followups.name as followup_name')->where('career_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->join('onboard_followups','onboard_followups.id','career_status_histories.follow_up_status')
                                              ->where('career_status_histories.career_category', 4)
                                              ->get();

        $career_remark5 = CareerStatusHistory::select('career_status_histories.*', 'users.name')->where('career_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->where('career_status_histories.career_category', 0)
                                              ->get();

        $merged = $career_remark1->merge($career_remark2)->merge($career_remark3)->merge($career_remark4)->merge($career_remark5);
        $career_remark = $merged->all();
        $keys = array_column($career_remark, 'id');
        array_multisort($keys, SORT_ASC, $career_remark);
        return $career_remark;


    }


    public function ajax_career_remark_rejon_remarks(Request $request){

        $id = $request->primary_id;

        $rejoin_career = RejoinCareer::where('id','=',$id)->first();

        $passport_id = $rejoin_career->passport_id;



        $career_remark1 = RejoinCareerHitory::select('rejoin_career_histories.*', 'users.name', 'rejoin_career_histories.remarks as remakrs','rejoin_career_histories.status as status','rejoin_career_histories.created_at')
                                              ->join('users', 'users.id', 'rejoin_career_histories.user_id')
                                              ->where('rejoin_career_histories.passport_id', $passport_id)
                                              ->get();



        // RejoinCareerHitory::where('career_id',)


        // $career_remark = $merged->all();
        // $keys = array_column($career_remark, 'id');
        // array_multisort($keys, SORT_ASC, $career_remark);
        return $career_remark1;


    }


    public function ajax_career_remark_rejoin(Request $request){

        $id = $request->primary_id;

        $career_remark2 = CareerStatusHistory::select('career_status_histories.*', 'users.name', 'waitlistfollowups.name as followup_name')->where('passport_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->join('waitlistfollowups','waitlistfollowups.id','career_status_histories.follow_up_status')
                                              ->where('career_status_histories.career_category', 2)
                                              ->get();

        $career_remark3 = CareerStatusHistory::select('career_status_histories.*', 'users.name', 'selected_followups.name as followup_name')->where('passport_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->join('selected_followups','selected_followups.id','career_status_histories.follow_up_status')
                                              ->where('career_status_histories.career_category', 3)
                                              ->get();

        $career_remark4 = CareerStatusHistory::select('career_status_histories.*', 'users.name', 'onboard_followups.name as followup_name')->where('passport_id','=',$id)
                                              ->join('users', 'users.id', 'career_status_histories.user_id')
                                              ->join('onboard_followups','onboard_followups.id','career_status_histories.follow_up_status')
                                              ->where('career_status_histories.career_category', 4)
                                              ->get();

        $merged = $career_remark2->merge($career_remark3)->merge($career_remark4);
        $career_remark = $merged->all();
        $keys = array_column($career_remark, 'id');
        array_multisort($keys, SORT_ASC, $career_remark);
        return $career_remark;


    }




    public function ajax_view_detail(Request $request){

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

        if($career->visa_status=="1"){
            $visa_status = "Visit Visa";
        }elseif($career->visa_status=="2"){
            $visa_status = "Cancel Visa";
        }elseif($career->visa_status=="3"){
            $visa_status = "Own Visa";
        }

        $visa_status_cancel = "";

            if($career->visa_status_cancel=="1"){
                $visa_status_cancel = "Free Zone";
            }elseif($career->visa_status_cancel=="2"){
                $visa_status_cancel = "Local Land";
            }else{
                $visa_status_cancel = "";
            }
        $visa_status_own = "";
        if($career->visa_status_own=="1"){
            $visa_status_own = "NOC";
        }elseif($career->visa_status_own=="2"){
            $visa_status_own = "Without NOC";
        }else{
            $visa_status_own = "";
        }

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

        if($career->licence_status_vehicle=="1"){
            $drving_license_status_vehice = "Bike";
        }elseif($career->licence_status_vehicle=="2"){
            $drving_license_status_vehice = "Car";
        }elseif($career->licence_status_vehicle=="3"){
            $drving_license_status_vehice = "Both";
        }else{
            $drving_license_status_vehice = "";
        }

        $visa_status_visit = "";

        if($career->visa_status_visit=="1"){
            $visa_status_visit = "One Month";
        }elseif($career->visa_status_visit=="2"){
            $visa_status_visit = "Three Month";
        }else{
            $visa_status_visit = "";
        }

        $inout_transfer = "";
        if($career->inout_transfer=="1"){
            $inout_transfer ="Here";
        }elseif($career->inout_transfer=="2"){
            $inout_transfer ="Home Country";
        }else{
            $inout_transfer = "";
        }




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

        $cities_name = "";

        if(!empty($career->cities)){


            foreach($career->cities as $ab){
                $city = Cities::find($ab);
                $cities_name .=   isset($city->name)?$city->name.", ":"";
            }

        }



        foreach($array_platform as $ab){
             $platf = Platform::find($ab);
            $platforms_name .=   isset($platf->name)?$platf->name.", ":"";
        }


$promotion_type_array = array('','Tiktok','Facebook','Youtube','Website','Instagram','Friend','Other','Radio','Restaurant');

$array_source_type =  array('','App','On Call','Walkin Candidate','Website','Social Media');

$employee_type_array = [
                0=>'N/A',
                1 => 'Company',
                2 =>'Four Pl Rider'];

$four_pl_name = $career->fourpl_company_name ? $career->fourpl_company_name->name : '0';


            $gamer = array(
                'id' => $career->id,
                'name' => $career->name,
                'email' => $career->email,
                'phone' => $career->phone,
                'whatsapp' =>  $career->whatsapp,
                'facebook' =>  $career->facebook,
                'created_at' =>  $career->created_at->todatestring(),
                'experience'  =>  $experiece,
                'vehicle_type' => $vehicle_type,
                'cv' =>  (isset($career->cv)) ? url($career->cv) : 'Not Found' ,
                'licence_status' =>  ($career->licence_status=="1") ? "Yes" : "No",
                'licence_status_vehicle' =>  $drving_license_status_vehice,
                'licence_no'  =>  $career->licence_no,
                'licence_issue'  =>  $career->licence_issue,
                'licence_expiry'  =>  $career->licence_expiry,
                'licence_city_name' => isset($career->licence_city_id) ? $career->city->name : null,
                'licence_attach'   =>  $career->licence_attach ? url($career->licence_attach) : 'Not Found',
                'licence_attach_back'   =>  $career->licence_attach_back ? url($career->licence_attach_back) : 'Not Found',
                'traffic_code_no'   =>  $career->traffic_file_no ? $career->traffic_file_no : 'Not Found',
                'nationality'  =>  isset($career->country_name) ? $career->country_name->name: $career->nationality,
                'dob'  =>  $career->dob,
                'passport_no' =>  $career->passport_no,
                'passport_expiry' =>  $career->passport_expiry,
                'passport_attach' =>  $career->passport_attach ? url($career->passport_attach) : 'Not Found' ,
                'visa_status' =>  $visa_status,
                'visa_status_visit' =>  $visa_status_visit,
                'visa_status_cancel' =>  $visa_status_cancel,
                'visa_status_own' =>  $visa_status_own,
                'exit_date' =>  $career->exit_date,
                'company_visa'  =>  ($career->company_visa=="1") ? 'Yes': "No",
                'inout_transfer'   =>  $inout_transfer,
                'platform_id'  =>  $platforms_name,
                'cities'  =>  $cities_name,
                'applicant_status'  =>  $app_status,
                'remarks'   =>  $career->remarks,
                'company_remark' => $career->company_remarks,
                'promotion_type' => isset($promotion_type_array[$career->promotion_type]) ? $promotion_type_array[$career->promotion_type] : 'N/A',
                'promotion_others' => isset($career->promotion_others)?$career->promotion_others:"",
                'source_type' => isset($array_source_type[$career->source_type]) ? $array_source_type[$career->source_type]: "N/A",
                'social_media_id_name' => isset($career->social_media_id_name) ? $career->social_media_id_name: "N/A",
                'career_history' =>  json_encode($career_history),
                'employee_type' => $employee_type_array[$career->employee_type],
                'four_pl_name' => $four_pl_name,
                'refer_by' => isset($career->refer_by) ? $career->refer_by_user->personal_info->full_name : '0',
            );

            $childe['data'] [] = $gamer;

//            dd($childe);



        echo json_encode($childe);
        exit;

    }


}
