<?php

namespace App\Http\Controllers\Career;

use App\Model\BikeDetail;
use App\Model\Career\CareerDocumentName;
use App\Model\Career\CareerHeardAboutUs;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Cities;
use App\Model\DiscountName\DiscountName;
use App\Model\exprience_month;
use App\Model\Guest\Career;
use App\Model\Master\FourPl;
use App\Model\Master_steps;
use App\Model\Nationality;
use App\Model\Passport\Passport;
use App\Model\Platform;
use App\Model\Referal\Referal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\VendorRiderOnboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class CareerByOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_id = Auth::user()->id;


        $careers = Career::all();
        $not_verified = Career::where('applicant_status','=','0')->get();
        $rejected = Career::where('applicant_status','=','1')->get();
        $document_pending = Career::where('applicant_status','=','2')->get();
        $short_listed = Career::where('applicant_status','=','3')->get();

        $driving_license_yes = Career::where('licence_status','=','1')->get();
        $driving_license_no = Career::where('licence_status','=','0')->get();


        $first_priority =  Career::select('careers.*')
            ->where('licence_status','=','1')   // driving license = yes
            ->where('company_visa','=','1')  // taking visa company =yes
            ->where(function ($q) {       // visa status  = cancel / visit visa
                $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
            })
            ->where('applicant_status','=','0')
            ->where('user_id','=',$user_id)
            ->whereNull('careers.refer_by')
            ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
            ->orderBy('careers.id','desc')
            ->get();

        $second_priority = Career::select('careers.*')
            ->where('licence_status','=','1') // driving license = yes
            ->where('company_visa','=','1')  // taking visa company =yes
            ->where('visa_status','=','3') // own
            ->where('applicant_status','=','0')
            ->where('user_id','=',$user_id)
            ->whereNull('refer_by')
            ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')

            ->orderBy('careers.id','desc')
            ->get();

//        $third_priority = Career::where('licence_status','!=','1') // other rest of option
//                                   ->where('company_visa','!=','1')
//                                   ->where('visa_status','!=','3')
//                                   ->where('visa_status','!=','1')
//                                   ->where('applicant_status','=','0')
//                                   ->get();
        $third_priority = Career::select('careers.*')
            ->where(function ($q) {
                $q->where('licence_status', '!=', '1')->orWhere('company_visa', '!=', '1')->orWhere('visa_status', '=', '0')->orWhereNUll('visa_status')
                ;
            })
            ->where('applicant_status','=','0')
            ->where('user_id','=',$user_id)
            ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
            ->whereNull('refer_by')
            ->orderBy('careers.id','desc')
            ->get();

        $referal_users = Career::select('careers.*')->whereNotNull('refer_by')->where('applicant_status','=','0')->get();



        return view('admin-panel.career_by_office.index',compact('referal_users','careers', 'first_priority', 'second_priority', 'third_priority','driving_license_no','driving_license_yes','not_verified','rejected','document_pending','short_listed'));

    }

    public function ajax_filter_color(Request $request){
        $user_id = Auth::user()->id;


        if($request->priority=="first_priority"){

            $first_priority =  Career::select('careers.*')
                ->where('licence_status','=','1')   // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where(function ($q) {       // visa status  = cancel / visit visa
                    $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
                })
                ->where('applicant_status','=','0')
                ->where('user_id','=',$user_id)
                ->whereNull('careers.refer_by')
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                ->orderBy('careers.id','desc')
                ->get();

            $color = $request->color;

            $request_priority = $request->priority;

            $view = view('admin-panel.career_by_office.ajax_career_color_filter',compact('request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="second_priority"){

            $first_priority = Career::select('careers.*')
                ->where('licence_status','=','1') // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where('visa_status','=','3') // own
                ->where('applicant_status','=','0')
                ->where('user_id','=',$user_id)
                ->whereNull('refer_by')
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')

                ->orderBy('careers.id','desc')
                ->get();

            $color = $request->color;
            $request_priority = $request->priority;

            $view = view('admin-panel.career_by_office.ajax_career_color_filter',compact('request_priority','first_priority','color'))->render();
            return response()->json(['html'=>$view]);

        }elseif($request->priority=="third_priority"){
            $first_priority = Career::select('careers.*')
                ->where(function ($q) {
                    $q->where('licence_status', '!=', '1')->orWhere('company_visa', '!=', '1')->orWhere('visa_status', '=', '0')->orWhereNUll('visa_status')
                    ;
                })
                ->where('applicant_status','=','0')
                ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
                ->whereNull('refer_by')
                ->where('user_id','=',$user_id)
                ->orderBy('careers.id','desc')
                ->get();

            $color = $request->color;

            $request_priority = $request->priority;

            $view = view('admin-panel.career_by_office.ajax_career_color_filter',compact('request_priority','first_priority','color'))->render();

            return response()->json(['html'=>$view]);

        }


    }

    public function get_ajax_filter_color_block_count(Request $request)
    {
        $total_first_priority_24 = 0;
        $total_first_priority_48 = 0;
        $total_first_priority_72 = 0;
        $total_first_priority_less_24 = 0;

        $user_id = Auth::user()->id;

        if($request->priority=="first_priority"){

            $first_priority =  Career::select('careers.*')
                ->where('licence_status','=','1')   // driving license = yes
                ->where('company_visa','=','1')  // taking visa company =yes
                ->where(function ($q) {       // visa status  = cancel / visit visa
                    $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
                })
                ->where('applicant_status','=','0')
                ->where('user_id','=',$user_id)
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
                ->where('user_id','=',$user_id)
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
                ->where('user_id','=',$user_id)
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
                ->orderBy('updated_at','desc')->get();

        }elseif($request->priority=="document_pending_referals"){

            $passport = Passport::join('driving_licenses','driving_licenses.passport_id','=','passports.id')
                ->get()
                ->pluck('passport_no')
                ->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNotNull('refer_by')
                ->orderBy('updated_at','desc')->get();

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $platform = Platform::all();
        $exp_months = exprience_month::all();
        $cities = Cities::all();
        $socials = CareerHeardAboutUs::all();

        $four_pls = FourPl::all();

        $shirt_size = array('Small','Medium','Large',"Extra Large","XXL","XXXL");
        $waist_size = array('28','30','32',"34","36","38","40","42","44","46","48");

        $nationalities = Nationality::whereNotIn('id',[17,18,19,20,26])->get();

        $riders = Passport::orderby('id','desc')->get();

        $discount_names = DiscountName::orderby('id','desc')->get();
        $master_steps = Master_steps::where('id','!=','1')->get();

        $career_doc_name = CareerDocumentName::all();



        return view('admin-panel.career_by_office.create',compact('career_doc_name','master_steps','discount_names','riders','nationalities','waist_size','shirt_size','four_pls','socials','exp_months','platform','cities'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request);

        //dd($request->all());
        $response = [];
        $current_timestamp = Carbon::now()->timestamp;
//        try {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
//            'passport_no' => 'required|unique:careers,passport_no',
            'email' => 'nullable|email',
            'phone' => 'required|unique:careers,phone',
            'whatsapp' => 'required|unique:careers,whatsapp',
            'promotion_type' => 'required',
            'source_type' => 'required',
            'nationality' => 'required',
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

        $already_passport = Passport::where('passport_no','=',$request->passport_no)->first();

        if($already_passport != null){

            $message = [
                'message' => "Passport number is already register with us",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        if($request->licence_no != null){
            $check_license = Career::where('licence_no','=',trim($request->licence_no))->first();
            if($check_license != null){

                $message = [
                    'message' => "License number is already register with us",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return redirect()->back()->with($message);
            }
        }

        if($request->email != null){
            $check_email = Career::where('email','=',trim($request->email))->first();
            if($check_email != null){
                $message = [
                    'message' => "Email is already register with us",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return redirect()->back()->with($message);
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
//        $obj1 = Career::find($id);
//        $obj1->platform_id = null;
//        $obj1->cities = null;
//        $obj1->save();


        $obj= new Career();
        $obj->name = trim($request->input('name'));
        $obj->email = trim($request->input('email'));
        $obj->phone = trim($request->input('phone'));
        $obj->whatsapp = trim($request->input('whatsapp'));
        $obj->promotion_type = trim($request->input('promotion_type'));
        $obj->user_id = Auth::user()->id;
        if($request->promotion_type=="1" || $request->promotion_type=="2" || $request->promotion_type=="3" || $request->promotion_type=="5"){
            $obj->social_media_id_name =  trim($request->social_id_name);
        }elseif($obj->promotion_type=="7"){
            $obj->promotion_others = trim($request->other_source_name);
        }
        $obj->source_type = trim($request->input('source_type'));


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

            $file3?$obj->licence_attach = $file3:"";
        }

        if(!empty($request->input('nationality'))){
            $obj->nationality = $request->input('nationality');
        }
        $obj->nationality = trim($request->input('nationality'));
        if(!empty($request->input('dob'))){
            $obj->dob = trim($request->input('dob'));
        }
        if(!empty($request->passport_no)) {
//            $obj->passport_no = trim($request->passport_no);
        }
        if(!empty($request->passport_expiry)){
            $obj->passport_expiry = trim($request->passport_expiry);
        }

        $file2?$obj->passport_attach = $file2:"";

        if(!empty($request->input('visa_status'))){
            $obj->visa_status = trim($request->input('visa_status'));
        }

        if($request->employee_type){
            $obj->employee_type = $request->employee_type;
            if($request->employee_type=="2"){
                $obj->four_pl_name_id = $request->four_pl_name;
            }
        }


        if(!empty($request->input('visit_visa_status'))){
            $obj->visa_status_visit = trim($request->input('visit_visa_status'));
        }
        if(!empty($request->cancel_visa_status)){
            $obj->visa_status_cancel = trim($request->input('cancel_visa_status'));
        }
        if(!empty($request->own_visa_status)){
            $obj->visa_status_own = trim($request->input('own_visa_status'));
        }
        if($request->input('visit_exit_date') != null) {
            $obj->exit_date = trim($request->visit_exit_date);
        }
        if(!empty($request->company_visa)){
            $obj->company_visa = trim($request->company_visa);
        }
        if(!empty($request->input('inout_transfer'))){
            $obj->inout_transfer = trim($request->input('inout_transfer'));
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



//        $response['code'] = 1;
//        $response['message'] = 'Job Submission Successful';

        $message = [
            'message' => "Career Added Successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);




//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = 'Submission Failed';
//
//            return response()->json($response);
//        }


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



    public function autocomplete_career(Request $request)
    {

        if($request->checked_or_not=="0"){

            $search_text = $request->get('query');
            $career_phone =Career::select('careers.name','careers.phone','careers.email','careers.whatsapp','careers.id')
                ->where('applicant_status','!=','5')
                ->where('applicant_status','!=','4')
                ->where('employee_type','!=','2')
                ->where("careers.phone","LIKE","%{$request->input('query')}%")
                ->get();


            if(count($career_phone)=='0') {

                $career_name = Career::select('careers.name', 'careers.phone', 'careers.email', 'careers.whatsapp','careers.id')
                    ->where("careers.name", "LIKE", "%{$request->input('query')}%")
                    ->where('applicant_status','!=','5')
                    ->where('applicant_status','!=','4')
                    ->where('employee_type','!=','2')
                    ->get();

                if (count($career_name)=='0') {

                    $career_email = Career::select('careers.name', 'careers.phone', 'careers.email', 'careers.whatsapp','careers.id')
                        ->where("careers.email", "LIKE", "%{$request->input('query')}%")
                        ->where('applicant_status','!=','5')
                        ->where('applicant_status','!=','4')
                        ->where('employee_type','!=','2')
                        ->get();

                    if (count($career_email) == '0') {
                        $career_whatspp = Career::select('careers.name', 'careers.phone', 'careers.email', 'careers.whatsapp','careers.id')
                            ->where("careers.whatsapp", "LIKE", "%{$request->input('query')}%")
                            ->where('applicant_status','!=','5')
                            ->where('applicant_status','!=','4')
                            ->where('employee_type','!=','2')
                            ->get();
                        //whats app  response
                        $pass_array = array();
                        foreach ($career_whatspp as $pass) {
                            $gamer = array(
                                'name' => $pass->whatsapp,
                                'id' => $pass->id,
                                'full_name' => $pass->name,
                                'email' => $pass->email,
                                'phone' => $pass->phone,
                                'type' => '2',
                            );
                            $pass_array[] = $gamer;
                        }
                        return response()->json($pass_array);

                    }
                    //email response
                    $pass_array = array();
                    foreach ($career_email as $pass) {
                        $gamer = array(
                            'name' => $pass->email,
                            'id' => $pass->id,
                            'full_name' => $pass->name,
                            'whatsapp' => $pass->whatsapp,
                            'phone' => $pass->phone,
                            'type' => '1',
                        );
                        $pass_array[] = $gamer;
                    }
                    return response()->json($pass_array);



                }

                $pass_array = array();
                foreach ($career_name as $pass) {
                    $gamer = array(
                        'name' => $pass->name,
                        'id' => $pass->id,
                        'whatsapp' => $pass->whatsapp,
                        'email' => $pass->email,
                        'phone' => $pass->phone,
                        'type' => '3',
                    );
                    $pass_array[] = $gamer;
                }
                return response()->json($pass_array);

            }

            //passport number response
            $pass_array=array();

            foreach ($career_phone as $pass){
                $gamer = array(
                    'name' => $pass->phone,
                    'id' => $pass->id,
                    'full_name' => $pass->name,
                    'email' => $pass->email,
                    'whatsapp' => $pass->whatsapp,
                    'type'=>'0',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);



        }elseif($request->checked_or_not=="1"){

            $search_text = $request->get('query');
            $career_phone =Career::select('careers.name','careers.phone','careers.email','careers.whatsapp','careers.id')
                ->where("careers.phone","LIKE","%{$request->input('query')}%")
                ->where('employee_type','!=','2')
                ->get();


            if(count($career_phone)=='0') {

                $career_name = Career::select('careers.name', 'careers.phone', 'careers.email', 'careers.whatsapp','careers.id')
                    ->where("careers.name", "LIKE", "%{$request->input('query')}%")
                    ->where('employee_type','!=','2')
                    ->get();

                if (count($career_name)=='0') {

                    $career_email = Career::select('careers.name', 'careers.phone', 'careers.email', 'careers.whatsapp','careers.id')
                        ->where("careers.email", "LIKE", "%{$request->input('query')}%")
                        ->where('employee_type','!=','2')
                        ->get();

                    if (count($career_email) == '0') {
                        $career_whatspp = Career::select('careers.name', 'careers.phone', 'careers.email', 'careers.whatsapp','careers.id')
                            ->where("careers.whatsapp", "LIKE", "%{$request->input('query')}%")
                            ->where('employee_type','!=','2')
                            ->get();
                        //whats app  response
                        $pass_array = array();
                        foreach ($career_whatspp as $pass) {
                            $gamer = array(
                                'name' => $pass->whatsapp,
                                'id' => $pass->id,
                                'full_name' => $pass->name,
                                'email' => $pass->email,
                                'phone' => $pass->phone,
                                'type' => '2',
                            );
                            $pass_array[] = $gamer;
                        }
                        return response()->json($pass_array);

                    }
                    //email response
                    $pass_array = array();
                    foreach ($career_email as $pass) {
                        $gamer = array(
                            'name' => $pass->email,
                            'id' => $pass->id,
                            'full_name' => $pass->name,
                            'whatsapp' => $pass->whatsapp,
                            'phone' => $pass->phone,
                            'type' => '1',
                        );
                        $pass_array[] = $gamer;
                    }
                    return response()->json($pass_array);



                }

                $pass_array = array();
                foreach ($career_name as $pass) {
                    $gamer = array(
                        'name' => $pass->name,
                        'id' => $pass->id,
                        'whatsapp' => $pass->whatsapp,
                        'email' => $pass->email,
                        'phone' => $pass->phone,
                        'type' => '3',
                    );
                    $pass_array[] = $gamer;
                }
                return response()->json($pass_array);

            }

            //passport number response
            $pass_array=array();

            foreach ($career_phone as $pass){
                $gamer = array(
                    'name' => $pass->phone,
                    'id' => $pass->id,
                    'full_name' => $pass->name,
                    'email' => $pass->email,
                    'whatsapp' => $pass->whatsapp,
                    'type'=>'0',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);


        }




    }


    public function only_passport_suggest(Request $request)
    {



            $search_text = $request->get('query');
            $career_passport_no =Career::select('careers.name','careers.passport_no','careers.id')
                ->where("careers.passport_no","LIKE","%{$request->input('query')}%")
                ->get();


            if(count($career_passport_no)=='0') {

                $vendor_onboard = VendorRiderOnboard::where("passport_no", "LIKE", "%{$request->input('query')}%")
                    ->get();

                    // dd($vendor_onboard);

                if (count($vendor_onboard)=='0') {


                    $passport_data =Passport::select('passports.id','passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                    ->get();

                    if (count($passport_data) == '0') {

                    }
                    //passport_resposnse
                    $pass_array = array();
                    foreach ($passport_data as $pass) {
                        $gamer = array(
                            'name' => $pass->passport_no,
                            'id' => $pass->id,
                            'full_name' => $pass->full_name,
                            'type' => '1',
                        );
                        $pass_array[] = $gamer;
                    }
                    return response()->json($pass_array);

                }

                $pass_array = array();
                foreach ($vendor_onboard as $pass) {
                    $gamer = array(
                        'name' => $pass->passport_no,
                        'id' => $pass->id,
                        'full_name' => $pass->rider_first_name.' '.$pass->rider_last_name,
                        'type' => '3',
                    );
                    $pass_array[] = $gamer;
                }
                return response()->json($pass_array);

            }

            //passport number response
            $pass_array=array();

            foreach ($career_passport_no as $pass){
                $gamer = array(
                    'name' => $pass->passport_no,
                    'id' => $pass->id,
                    'full_name' => $pass->name,
                    'type'=>'0',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);

    }



    public function search_passport_json(Request $request){

        $search = $request->q;

        $passports = Passport::Select('passport_no','id', DB::raw('CONCAT(given_names, " ", sur_name," ",father_name) AS full_name'))
            ->orwhere('passport_no','Like','%'.$search.'%')
            ->orwhere('given_names','Like','%'.$search.'%')
            ->orwhere('sur_name','Like','%'.$search.'%')
            ->orwhere('father_name','Like','%'.$search.'%')->limit(10)->get();

        $array_page = array(
            'more' => true,
        );

        return response()->json(['items' => $passports,'pagination' => $array_page]);
        exit;
    }

    public function ajax_check_the_passport_info(Request $request){

        if($request->ajax()){

            $search_text = $request->get('keyword');
            $career_passport_no =Career::where("careers.passport_no","LIKE","%{$search_text}%")->first();
            $vendor_onboard_passport = VendorRiderOnboard::where("passport_no", "LIKE", "%{$search_text}%")->first();
            $only_passport = Passport::where("passport_no", "LIKE", "%{$search_text}%")->first();

            $msg_to_send = "you can procees with this rider";

              if($career_passport_no != null)  {

                if($career_passport_no->applicant_status=="4"){

                        $passport_data =Passport::where('careeer_id','=',$career_passport_no->id)->first();

                        if($passport_data != null){
                           $check_interview = CreateInterviews::where('interview_status','0')
                                                ->where(function ($q) use($career_passport_no,$passport_data) {
                                                    $q->where('career_id', '=', $career_passport_no->id)->orWhere('passport_id', '=',$passport_data->id);
                                                })
                                              ->first();
                        }else{
                            $check_interview =   CreateInterviews::where('career_id',$career_passport_no->id)->where('interview_status','0')->first();
                        }

                        if($check_interview != null){
                            $msg_to_send = 'This rider is already in Interview,process it from there';
                        }

                          $onboard_status = OnBoardStatus::where('career_id','=',$career_passport_no->id)
                                                          ->where('interview_status','=','1')
                                                          ->where('assign_platform','=','1')
                                                          ->where('on_board','=','1')
                                                          ->first();

                            if($onboard_status != null){
                                $msg_to_send = 'This rider is already in Onboard,process it from there';
                            }

                                if($passport_data != null){
                                    $onboard_status = OnBoardStatus::where('passport_id','=',$passport_data->id)
                                                          ->where('interview_status','=','1')
                                                          ->where('assign_platform','=','1')
                                                          ->where('on_board','=','1')
                                                          ->first();

                                            if($onboard_status != null){
                                                $msg_to_send = 'This rider is already in Onboard,process it from there';
                                            }
                                }

                     }else{
                        $msg_to_send = 'This rider already in career';
                     }
              }elseif($vendor_onboard_passport != null){

                    if($vendor_onboard_passport->status=="0"){
                        $msg_to_send = 'This rider is already in Vendor Onboard in pending,or if this rider wants work as our rider contact Admin';
                    }else{
                            if($only_passport != null){
                                $msg_to_send = 'This rider is already in Vendor Onboard, PPuid is created we need cancel his ppuid and have to reactive agin';
                            }else{
                                $msg_to_send = 'This rider is already in Vendor Onboard ';
                            }


                    }

              }elseif($only_passport != null){
                    $msg_to_send = 'Already PPUID created';
              }



              return $msg_to_send;


        }


    }


    public function search_city_json(Request $request){

        $search = $request->q;

        $passports = Passport::Select('passport_no','id', DB::raw('CONCAT(given_names, " ", sur_name," ",father_name) AS full_name'))
            ->orwhere('passport_no','Like','%'.$search.'%')
            ->orwhere('given_names','Like','%'.$search.'%')
            ->orwhere('sur_name','Like','%'.$search.'%')
            ->orwhere('father_name','Like','%'.$search.'%')->limit(10)->get();

        $cities = Cities::select('name','id')->where('name','LIKE','%'.$search.'%')->get();

        $array_page = array(
            'more' => true,
        );

        return response()->json(['items' => $cities,'pagination' => $array_page]);
        exit;

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
}
