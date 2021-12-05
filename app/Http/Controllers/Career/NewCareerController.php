<?php

namespace App\Http\Controllers\Career;

use App\Model\Career\CareerHeardAboutUs;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Cities;
use App\Model\exprience_month;
use App\Model\Guest\Career;
use App\Model\Nationality;
use App\Model\Passport\Passport;
use App\Model\Platform;
use App\Model\Referal\Referal;
use App\Model\shortlisted_statuses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NewCareerController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Hiring-add-career-social-media|Hiring-pool|Hiring-front-desk', ['only' => ['save_career_from_social_media','career_from_social_media']]);
        $this->middleware('role_or_permission:Admin|Hiring-pool', ['only' => ['store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|Hiring-add-candidate-on-call|Hiring-pool', ['only' => ['career_from_on_call','save_career_from_on_call']]);
        $this->middleware('role_or_permission:Admin|Hiring-add-international-candidate|Hiring-pool', ['only' => ['career_from_international','save_career_from_international']]);
        $this->middleware('role_or_permission:Admin|Hiring-add-walkin-candidate|Hiring-pool|Hiring-add-career-social-media|Hiring-front-desk', ['only' => ['career_from_walk','save_career_from_social_media']]);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passport = Passport::pluck('passport_no')->toArray();
        $new_visa = Career::whereNotIn('passport_no',$passport)
            ->where('applicant_status','=','2')
            ->whereNull('refer_by')
            ->where('status_after_shortlist','!=','0')
            ->where('visa_status_after_shortlist','=','4')
            ->where('visa_status_one_after_shortlist','=','7')
            ->orderBy('updated_at','desc')->get();

        $freelance_visa = Career::whereNotIn('passport_no',$passport)
            ->where('applicant_status','=','2')
            ->whereNull('refer_by')
            ->where('status_after_shortlist','!=','0')
            ->where('visa_status_after_shortlist','=','5')
            ->where('visa_status_one_after_shortlist','=','11')
            ->orderBy('updated_at','desc')->get();

         $designation_status  = shortlisted_statuses::take(3)->pluck('name','id')->toArray();
         $legal_status  = shortlisted_statuses::skip(3)->take(3)->pluck('name','id')->toArray();

        $nations=Nationality::all();

      return view('admin-panel.career.only_new_visa_noc',compact('nations','legal_status','new_visa','freelance_visa','designation_status'));
    }

    public function not_new_visa_noc(){

        $passport = Passport::pluck('passport_no')->toArray();
        $new_visa = Career::whereNotIn('passport_no',$passport)
            ->where('applicant_status','=','2')
            ->whereNull('refer_by')
            ->where('status_after_shortlist','!=','0')
            ->where('visa_status_after_shortlist','=','4')
            ->where('visa_status_one_after_shortlist','=','8')
            ->orderBy('updated_at','desc')->get();

        $freelance_visa = Career::whereNotIn('passport_no',$passport)
            ->where('applicant_status','=','2')
            ->whereNull('refer_by')
            ->where('status_after_shortlist','!=','0')
            ->where('visa_status_after_shortlist','=','5')
            ->where('visa_status_one_after_shortlist','=','12')
            ->orderBy('updated_at','desc')->get();

        $four_pl = Career::whereNotIn('passport_no',$passport)
            ->where('applicant_status','=','2')
            ->whereNull('refer_by')
            ->where('status_after_shortlist','!=','0')
            ->where('visa_status_after_shortlist','=','6')
            ->orderBy('updated_at','desc')->get();

        $designation_status  = shortlisted_statuses::take(3)->pluck('name','id')->toArray();
        $legal_status  = shortlisted_statuses::skip(3)->take(3)->pluck('name','id')->toArray();
        $more_status  = shortlisted_statuses::pluck('name','id')->toArray();

        $nations=Nationality::all();
//        dd("asgur");

        return view('admin-panel.career.not_new_visa_noc',compact('more_status','four_pl','nations','legal_status','new_visa','freelance_visa','designation_status'));


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

    public function career_from_social_media(){

        //
        $career = Career::where('source_type','=', '5')->orderBy('id', 'desc')->limit(10)->get();
        $platform = Platform::all();
        $exp_months = exprience_month::all();
        $cities = Cities::all();
        $socials = CareerHeardAboutUs::all();

        $countries = Nationality::whereNotIn('id',[17,18,19,20,26])->get();

        return view('admin-panel.career.new_career.create_from_social_media',compact('countries','socials','exp_months','platform','cities','career'));


    }

    public function save_career_from_social_media(Request $request)
    {

        try {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email',
            'license_status' => 'required',
            'visa_status' => 'required',
            'phone' => 'required',
            'full_number' => 'required',
            'whatsapp' => 'required|unique:careers,whatsapp',
            'whats_app_full_number' => 'required',
            'promotion_type' => 'required',
            'source_type' => 'required',
        ]);
        if ($validator->fails()) {


//            return redirect()->back()->with($message);
            return $validator->errors()->first();
        }

        if($request->license_status=="1"){

            $validator = Validator::make($request->all(), [
                'license_type' => 'required',
            ]);
            if ($validator->fails()) {
                $response['message'] = $validator->errors()->first();
                return $validator->errors()->first();
            }

        }

            $full_number = preg_replace("/[\s-]/", "", $request->full_number);
            $whats_app_full_number = preg_replace("/[\s-]/", "", $request->whats_app_full_number);



          $country_code = substr($full_number, 0, 4);

          if($country_code=="+971"){
          $source_type = $request->source_type;
          }else{
              $source_type = "6";
          }




            $check_phone = Career::where('phone','=',$full_number)->first();
            if($check_phone != null) {
                $message = [
                    'message' => "phone number already register with us",
                    'alert-type' => 'error',
                    'error' => ''
                ];
//                return redirect()->back()->with($message);
                return "phone number already register with us";
            }



        if($request->email != null){
            $check_email = Career::where('email','=',trim($request->email))->first();
            if($check_email != null){
                $message = [
                    'message' => "Email is already register with us",
                    'alert-type' => 'error',
                    'error' => ''
                ];
//                return redirect()->back()->with($message);

                return "Email is already register with us";
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





        $obj= new Career();
        $obj->name = trim($request->input('name'));
        $obj->email = trim($request->input('email'));
        $obj->phone = $full_number;
        $obj->whatsapp = $whats_app_full_number;
        $obj->promotion_type = trim($request->input('promotion_type'));
        $obj->user_id = Auth::user()->id;
        if($request->promotion_type=="1" || $request->promotion_type=="2" || $request->promotion_type=="3" || $request->promotion_type=="5"){
            $obj->social_media_id_name =  trim($request->social_id_name);
        }elseif($obj->promotion_type=="7"){
            $obj->promotion_others = trim($request->other_source_name);
        }
        $obj->source_type = $source_type;
        $obj->nationality = $request->country_id;



        if(!empty($request->input('license_status'))){
            $obj->licence_status = trim($request->input('license_status'));
            if(!empty($request->license_type)){
             $obj->licence_status_vehicle = trim($request->license_type);
            }
        }


        if(!empty($request->input('visa_status'))){
            $obj->visa_status = trim($request->input('visa_status'));
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


        $message = [
            'message' => "Career Added Successfully",
            'alert-type' => 'success',
            'error' => ''
        ];

            return "success";
//        return redirect()->back()->with($message);

        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return "Submission Failed";

//            return response()->json($response);
        }


    }

    public function career_from_international(){

        //
        $career = Career::where('source_type','=', '6')->orderBy('id', 'desc')->limit(10)->get();
        $platform = Platform::all();
        $exp_months = exprience_month::all();
        $cities = Cities::all();
        $socials = CareerHeardAboutUs::all();

        $nationalities = Nationality::whereNotIn('id',[17,18,19,20,26])->get();

        return view('admin-panel.career.new_career.create_from_international',compact('nationalities','socials','exp_months','platform','cities','career'));

    }


    public function save_career_from_international(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'nullable|email',
                'phone' => 'required',
                'full_number' => 'required',
                'whatsapp' => 'required|unique:careers,whatsapp',
                'whats_app_full_number' => 'required',
                'promotion_type' => 'required',
                'source_type' => 'required',
                'national_id' => 'required',
                'license_status' => 'required',
                'is_passport' => 'required',
            ]);
            if ($validator->fails()) {

                $response['message'] = $validator->errors()->first();

                return   $validator->errors()->first();

            }




            $full_number = preg_replace("/[\s-]/", "", $request->full_number);
            $whats_app_full_number = preg_replace("/[\s-]/", "", $request->whats_app_full_number);

            $check_phone = Career::where('phone','=',$full_number)->first();

            if($check_phone != null) {
                    $message = [
                        'message' => "phone number already register with us",
                        'alert-type' => 'error',
                        'error' => ''
                    ];

                return "phone number already register with us";
//                    return redirect()->back()->with($message);
            }


            if($request->email != null){
                $check_email = Career::where('email','=',trim($request->email))->first();
                if($check_email != null){
                    $message = [
                        'message' => "Email is already register with us",
                        'alert-type' => 'error',
                        'error' => ''
                    ];
                    return "Email is already register with us";

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



            $obj= new Career();
            $obj->name = trim($request->input('name'));
            $obj->email = trim($request->input('email'));
            $obj->phone = trim($full_number);
            $obj->whatsapp = $whats_app_full_number;
            $obj->promotion_type = trim($request->input('promotion_type'));
            $obj->user_id = Auth::user()->id;
            if($request->promotion_type=="1" || $request->promotion_type=="2" || $request->promotion_type=="3" || $request->promotion_type=="5"){
                $obj->social_media_id_name =  trim($request->social_id_name);
            }elseif($obj->promotion_type=="7"){
                $obj->promotion_others = trim($request->other_source_name);
            }
            $obj->source_type = trim($request->input('source_type'));



            if(!empty($request->input('license_status'))){
                $obj->licence_status = trim($request->input('license_status'));
                if(!empty($request->license_type)){
                    $obj->licence_status_vehicle = trim($request->license_type);
                }
            }


            if(!empty($request->input('is_passport'))){
                $obj->have_passport = trim($request->input('is_passport'));
            }

            if(!empty($request->national_id)){
                $obj->nationality = $request->national_id;
            }

            $obj->save();
            $last_id = $obj->id;
            $career_history = new CareerStatusHistory();
            $career_history->career_id = $last_id;
            $career_history->status = "0";
            $career_history->save();


            $message = [
                'message' => "Career Added Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];

            return  "success";
//            return redirect()->back()->with($message);

        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return  "Submission Failed";


        }


    }


    public function career_from_on_call(){

        //
        $career = Career::where('source_type','=', '2')->orderBy('id', 'desc')->limit(10)->get();
        $platform = Platform::all();
        $exp_months = exprience_month::all();
        $cities = Cities::all();
        $socials = collect([
            (object) [
                'name' => 'Tiktok',
                'id' => '1'
            ],
            (object) [
                'name' => 'Facebook',
                'id' => '2'
            ],
            (object) [
                'name' => 'Youtube',
                'id' => '3'
            ],
            (object) [
                'name' => 'Website',
                'id' => '4'
            ],
            (object) [
                'name' => 'Instagram',
                'id' => '5'
            ],
            (object) [
                'name' => 'Friend',
                'id' => '6'
            ],
            (object) [
                'name' => 'Other',
                'id' => '7'
            ],
            (object) [
                'name' => 'Radio',
                'id' => '8'
            ],
            (object) [
                'name' => 'Restaurant',
                'id' => '9'
            ]
        ]);

        $nationalities = Nationality::whereNotIn('id',[17,18,19,20,26])->get();

        return view('admin-panel.career.new_career.create_from_on_call',compact('nationalities','socials','exp_months','platform','cities','career'));

    }

    public function save_career_from_on_call(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'nullable|email',
                'phone' => 'required',
                'license_status' => 'required',
                'full_number' => 'required',
                'whatsapp' => 'required|unique:careers,whatsapp',
                'whats_app_full_number' => 'required',

                'promotion_type' => 'required',
                'source_type' => 'required',
                'visa_status' => 'required',
            ]);
            if ($validator->fails()) {

                $response['message'] = $validator->errors()->first();
                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return  $validator->errors()->first()."ashir";
//                return redirect()->back()->with($message);
            }



            $full_number = preg_replace("/[\s-]/", "", $request->full_number);
            $whats_app_full_number = preg_replace("/[\s-]/", "", $request->whats_app_full_number);


            $check_phone = Career::where('phone','=',$full_number)->first();
            if($check_phone != null) {
                $message = [
                    'message' => "phone number already register with us",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return "phone number already register with us";
//                return redirect()->back()->with($message);
            }


            if($request->email != null){
                $check_email = Career::where('email','=',trim($request->email))->first();
                if($check_email != null){
                    $message = [
                        'message' => "Email is already register with us",
                        'alert-type' => 'error',
                        'error' => ''
                    ];
                    return "Email is already register with us";
                }
            }

            if($request->license_status=="1"){

                $validator = Validator::make($request->all(), [
                    'license_type' => 'required',
                ]);
                if ($validator->fails()) {
                    $response['message'] = $validator->errors()->first();
                    return $validator->errors()->first();
                }

            }


            $full_number = $request->full_number;

            $country_code = substr($full_number, 0, 4);

            if($country_code=="+971"){
                $source_type = "2";
            }else{
                $source_type = "6";
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



            $obj= new Career();
            $obj->name = trim($request->input('name'));
            $obj->email = trim($request->input('email'));
            $obj->phone = trim($full_number);
            $obj->whatsapp = trim($whats_app_full_number);
            $obj->promotion_type = trim($request->input('promotion_type'));
            $obj->user_id = Auth::user()->id;
            if($request->promotion_type=="1" || $request->promotion_type=="2" || $request->promotion_type=="3" || $request->promotion_type=="5"){
                $obj->social_media_id_name =  trim($request->social_id_name);
            }elseif($obj->promotion_type=="7"){
                $obj->promotion_others = trim($request->other_source_name);
            }
            $obj->source_type = $source_type;



            if(!empty($request->input('license_status'))){
                $obj->licence_status = trim($request->input('license_status'));
                if(!empty($request->license_type)){
                    $obj->licence_status_vehicle = trim($request->license_type);
                }
            }


            if(!empty($request->input('visa_status'))){
                $obj->visa_status = trim($request->input('visa_status'));
            }


            if(!empty($request->input('platform_id'))){
                $obj->platform_id = json_encode($request->input('platform_id'));
            }
            if(!empty($request->cities)){
                $obj->cities = json_encode($request->cities);
            }
            $obj->nationality = $request->country_id;
            $obj->save();
            $last_id = $obj->id;
            $career_history = new CareerStatusHistory();
            $career_history->career_id = $last_id;
            $career_history->status = "0";
            $career_history->save();


            $message = [
                'message' => "Career Added Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];

            return  "success";
//            return redirect()->back()->with($message);

        } catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Submission Failed';

            return  'Submission Failed';

            return response()->json($response);
        }


    }


    public function career_from_walk(){

        //
        $career = Career::where('source_type','=', '3')->orderBy('id', 'desc')->limit(10)->get();
        $platform = Platform::all();
        $exp_months = exprience_month::all();
        $cities = Cities::all();
        $socials = CareerHeardAboutUs::all();

        $countries = Nationality::whereNotIn('id',[17,18,19,20,26])->get();
        return view('admin-panel.career.new_career.career_from_walkin',compact('countries','socials','exp_months','platform','cities','career'));


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

    public function ajax_filter_color_after_short_list(Request $request)
    {

        if($request->priority == "new_visa") {

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','4')
                ->where('visa_status_one_after_shortlist','=','7')
                ->orderBy('updated_at','desc')->get();


            $color = $request->color;
            $request_priority = $request->priority;

            $designation_status  = shortlisted_statuses::take(3)->pluck('name')->toArray();
            $legal_status  = shortlisted_statuses::skip(3)->take(3)->pluck('name','id')->toArray();

            $view = view('admin-panel.career.career_after_short_list', compact('legal_status','designation_status','request_priority', 'first_priority', 'color'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->priority == "freelance"){

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority =  Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','5')
                ->where('visa_status_one_after_shortlist','=','11')
                ->orderBy('updated_at','desc')->get();


            $color = $request->color;
            $request_priority = $request->priority;

            $designation_status  = shortlisted_statuses::take(3)->pluck('name','id')->toArray();
            $legal_status  = shortlisted_statuses::skip(3)->take(3)->pluck('name','id')->toArray();


            $view = view('admin-panel.career.career_after_short_list', compact('legal_status','designation_status','request_priority', 'first_priority', 'color'))->render();
            return response()->json(['html' => $view]);

        }elseif($request->priority == "not_new_visa") {

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority =  Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','4')
                ->where('visa_status_one_after_shortlist','=','8')
                ->orderBy('updated_at','desc')->get();


            $color = $request->color;
            $request_priority = $request->priority;

            $designation_status  = shortlisted_statuses::take(3)->pluck('name')->toArray();
            $legal_status  = shortlisted_statuses::skip(3)->take(3)->pluck('name','id')->toArray();

            $view = view('admin-panel.career.career_after_short_list', compact('legal_status','designation_status','request_priority', 'first_priority', 'color'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->priority == "without_noc") {

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority =  Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','5')
                ->where('visa_status_one_after_shortlist','=','12')
                ->orderBy('updated_at','desc')->get();


            $color = $request->color;
            $request_priority = $request->priority;

            $designation_status  = shortlisted_statuses::take(3)->pluck('name')->toArray();
            $legal_status  = shortlisted_statuses::skip(3)->take(3)->pluck('name','id')->toArray();

            $view = view('admin-panel.career.career_after_short_list', compact('legal_status','designation_status','request_priority', 'first_priority', 'color'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->priority == "four_pl") {

            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority =  Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','6')
                ->orderBy('updated_at','desc')->get();


            $color = $request->color;
            $request_priority = $request->priority;

            $designation_status  = shortlisted_statuses::take(3)->pluck('name')->toArray();
            $legal_status  = shortlisted_statuses::skip(3)->take(3)->pluck('name','id')->toArray();

            $view = view('admin-panel.career.career_after_short_list', compact('legal_status','designation_status','request_priority', 'first_priority', 'color'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function  get_ajax_filter_color_block_count_after_shortlist(Request $request)
    {
        $total_first_priority_24 = 0;
        $total_first_priority_48 = 0;
        $total_first_priority_72 = 0;
        $total_first_priority_less_24 = 0;

        if($request->priority=="new_visa"){
//            $passport = Passport::join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                ->get()
//                ->pluck('passport_no')
//                ->toArray();
            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','4')
                ->where('visa_status_one_after_shortlist','=','7')
                ->orderBy('updated_at','desc')->get();

        }elseif($request->priority=="freelance"){

//            $passport = Passport::join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                ->get()
//                ->pluck('passport_no')
//                ->toArray();
            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority =  Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','5')
                ->where('visa_status_one_after_shortlist','=','11')
                ->orderBy('updated_at','desc')->get();
        }elseif($request->priority=="not_new_visa"){

//            $passport = Passport::join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                ->get()
//                ->pluck('passport_no')
//                ->toArray();
            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority =   Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','4')
                ->where('visa_status_one_after_shortlist','=','8')
                ->orderBy('updated_at','desc')->get();
        }
        elseif($request->priority=="without_noc"){

//            $passport = Passport::join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                ->get()
//                ->pluck('passport_no')
//                ->toArray();
            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','5')
                ->where('visa_status_one_after_shortlist','=','12')
                ->orderBy('updated_at','desc')->get();

        }elseif($request->priority=="four_pl"){

//            $passport = Passport::join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                ->get()
//                ->pluck('passport_no')
//                ->toArray();
            $passport = Passport::pluck('passport_no')->toArray();

            $first_priority = Career::whereNotIn('passport_no',$passport)
                ->where('applicant_status','=','2')
                ->whereNull('refer_by')
                ->where('status_after_shortlist','!=','0')
                ->where('visa_status_after_shortlist','=','6')
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





}
