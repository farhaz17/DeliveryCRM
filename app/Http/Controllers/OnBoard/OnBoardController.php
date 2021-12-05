<?php

namespace App\Http\Controllers\OnBoard;

use App\Model\Agreement\Agreement;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\InterviewBatch\InterviewBatch;
use App\Model\OwnSimBikeHistory;
use App\Model\ReserveBike\ReserveBike;
use App\Model\Telecome;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use DateTime;
use DataTables;
use Carbon\Carbon;
use App\Model\Platform;
use App\Model\Nationality;
use App\Model\Career\CareerDocumentName;
use App\Model\Guest\Career;
use App\Model\Master_steps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Model\Passport\Passport;
use App\Model\Career\RejoinCareer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use App\Model\Career\onboard_followup;
use App\Model\DiscountName\DiscountName;
use Illuminate\Support\Facades\Validator;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\OnBoardStatus\OnBoardStatusForm;
use App\Model\OnBoardStatus\OnBoardStatusType;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Master\FourPl;
use App\Model\VendorRiderOnboard;
use App\Model\RejoinCareerHitory;
use App\Model\SimCancel;
use DB;

class OnBoardController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|onboard-view|Hiring-pool|Hiring-onboard-report|DC_roll', ['only' => ['index','store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|onboard-accident-vacation|Hiring-pool|Hiring-onboard-report', ['only' => ['vacation_accident_rider']]);

        $this->middleware('role_or_permission:Admin|Hiring-pool|waiting_for_training', ['only' => ['waiting_for_training']]);
        $this->middleware('role_or_permission:Admin|Hiring-pool|waiting_for_reservation', ['only' => ['waiting_for_reservation']]);

        $this->middleware('role_or_permission:Admin|Hiring-pool|reserved_report|RTAManage', ['only' => ['reserved_report']]);


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cancel_passports = Passport::where('cancel_status','=','1')->pluck('id')->toArray();
        $assign_platforms_passport_for_careers = AssignPlateform::join('passports','assign_plateforms.passport_id','=','passports.id')
            ->select('passports.id','passports.career_id')
            ->where('assign_plateforms.status','=','1')
            ->where('passports.career_id','!=','0')
            ->where('passports.cancel_status','=','0')
            ->pluck('passports.career_id')->toArray();
        $assign_platforms_passport = AssignPlateform::join('passports','assign_plateforms.passport_id','=','passports.id')
            ->select('passports.id')
            ->where('assign_plateforms.status','=','1')
            ->pluck('passports.id')->toArray();
            $cancel_passport_array = Passport::where('cancel_status','=','1')->pluck('id')->toArray();
        $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
            ->where('assign_platform','=','1')->where('passport_id','0')
            ->whereNotIn('career_id',$assign_platforms_passport_for_careers)
            ->get();
        $rejoins = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
            ->where('on_board','=','1')->where('passport_id','!=','0')
            ->whereNotIn('passport_id',$assign_platforms_passport)
            ->whereNotIn('passport_id',$cancel_passports)
            ->whereNotIn('passport_id',$cancel_passport_array)
            ->get();
        //    dd($rejoins[0]->passport_detail);
        $employee_type_array = ['','Company','FourPl'];
        $discount_names = DiscountName::orderby('id','desc')->get();
        $master_steps = Master_steps::where('id','!=','1')->get();
        $nationalities = Nationality::all();
        $followup_onboard = onboard_followup::where('status','0')->get();
        $dcouments_name = CareerDocumentName::all();

        $vendor_onboard = VendorRiderOnboard::all();
        $fourpl = FourPl::all();
        return view('admin-panel.on_board.index',compact('fourpl','vendor_onboard','dcouments_name','followup_onboard','rejoins','nationalities','master_steps','discount_names','employee_type_array','onboards'));
    }

    public function waiting_for_training(){


        $assign_platforms_passport_for_careers = AssignPlateform::
        join('passports','assign_plateforms.passport_id','=','passports.id')
            ->select('passports.id','passports.career_id')
            ->where('assign_plateforms.status','=','1')
            ->where('passports.career_id','!=','0')
            ->pluck('passports.career_id')->toArray();



        $assign_platforms_passport = AssignPlateform::
        join('passports','assign_plateforms.passport_id','=','passports.id')
            ->select('passports.id')
            ->where('assign_plateforms.status','=','1')
            ->pluck('passports.id')->toArray();




        $need_training_array_platform = Platform::where('need_training','1')->pluck('id')->toArray();
        $interview_batches_array = InterviewBatch::whereIn('platform_id',$need_training_array_platform)->pluck('id')->toArray();
        $create_interview_array = CreateInterviews::whereIn('interviewbatch_id',$interview_batches_array)->pluck('id')->toArray();



        $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
            ->where('on_board','=','1')->where('passport_id','0')
            ->whereNotIn('career_id',$assign_platforms_passport_for_careers)
            ->whereIn('create_interview_id',$create_interview_array)
            ->where('is_training','0')
            ->get();

        $rejoins = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
            ->where('on_board','=','1')->where('passport_id','!=','0')
            ->whereNotIn('passport_id',$assign_platforms_passport)
            ->whereIn('create_interview_id',$create_interview_array)
            ->where('is_training','0')->get();
//    dd($rejoins[0]->passport_detail);

        $employee_type_array = ['','Company','FourPl'];

        $discount_names = DiscountName::orderby('id','desc')->get();
        $master_steps = Master_steps::where('id','!=','1')->get();
        $nationalities = Nationality::all();
        $followup_onboard = onboard_followup::where('status','0')->get();


        $dcouments_name = CareerDocumentName::all();

        return view('admin-panel.on_board.waiting_for_training',compact('dcouments_name','followup_onboard','rejoins','nationalities','master_steps','discount_names','employee_type_array','onboards'));

    }

    public function waiting_for_reservation(){


        $assign_platforms_passport_for_careers = AssignPlateform::
        join('passports','assign_plateforms.passport_id','=','passports.id')
            ->select('passports.id','passports.career_id')
            ->where('assign_plateforms.status','=','1')
            ->where('passports.career_id','!=','0')
            ->pluck('passports.career_id')->toArray();



        $assign_platforms_passport = AssignPlateform::
        join('passports','assign_plateforms.passport_id','=','passports.id')
            ->select('passports.id')
            ->where('assign_plateforms.status','=','1')
            ->pluck('passports.id')->toArray();


        $need_reservation_array_platform = Platform::where('need_reservation','1')->pluck('id')->toArray();
        $interview_batches_array = InterviewBatch::whereIn('platform_id',$need_reservation_array_platform)->pluck('id')->toArray();
        $create_interview_array = CreateInterviews::whereIn('interviewbatch_id',$interview_batches_array)->pluck('id')->toArray();



        $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
            ->where('on_board','=','1')->where('passport_id','0')
            ->whereNotIn('career_id',$assign_platforms_passport_for_careers)
            ->whereIn('create_interview_id',$create_interview_array)
            ->where('is_reservation','0')
            ->get();

        $rejoins = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')
            ->where('on_board','=','1')->where('passport_id','!=','0')
            ->whereNotIn('passport_id',$assign_platforms_passport)
            ->whereIn('create_interview_id',$create_interview_array)
            ->where('is_reservation','0')->get();
//    dd($rejoins[0]->passport_detail);

        $employee_type_array = ['','Company','FourPl'];

        $discount_names = DiscountName::orderby('id','desc')->get();
        $master_steps = Master_steps::where('id','!=','1')->get();
        $nationalities = Nationality::all();
        $followup_onboard = onboard_followup::where('status','0')->get();


        $dcouments_name = CareerDocumentName::all();

        return view('admin-panel.on_board.waiting_for_reservation',compact('dcouments_name','followup_onboard','rejoins','nationalities','master_steps','discount_names','employee_type_array','onboards'));

    }

    public function reserved_report(){

        $reserves = ReserveBike::orderby('id','desc')->get();

        return view('admin-panel.on_board.reserved_report',compact('reserves'));
    }

    public function assigned_reserved_bikes(Request  $request){
        $validator = Validator::make($request->all(), [
            'primary_id_selected' => 'required',
            'checkin' => 'required',
        ]);
        if ($validator->fails()) {

            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $reserve_bike = ReserveBike::find($request->primary_id_selected);


        if($reserve_bike->sim_assign_status=="0"){
            $sim_detail_already = Telecome::where('id','=',$reserve_bike->sim_id)->first();
                        if($sim_detail_already != null){
                            $exist_sim_detail = Telecome::where('account_number','=',$sim_detail_already->account_number)->where('status','=','1')->first();
                            if($exist_sim_detail != null){
                                $message = [
                                    'message' => 'This Sim is already assigned to someone',
                                    'alert-type' => 'error'
                                ];
                                return redirect()->back()->with($message);
                            }
                        }

                        $sim_detail_already_two = Telecome::where('id','=',$reserve_bike->sim_id)->where('status','=','1')->first();
                        if($sim_detail_already_two != null){
                                $message = [
                                    'message' => 'This Sim is already assigned',
                                    'alert-type' => 'error'
                                ];
                                return redirect()->back()->with($message);
                        }

                        $sim_own_history = OwnSimBikeHistory::where('passport_id','=',$reserve_bike->passport_id)->where('own_type','=','1')->where('status','=','1')->first();
                        if($sim_own_history != null){
                            $message = [
                                'message' => 'This rider have own Sim.',
                                'alert-type' => 'error'
                            ];
                            return redirect()->back()->with($message);
                        }


                            $agreement=Agreement::where('passport_id',$reserve_bike->passport_id)->where('status','1')->first();
                            if ($agreement!=null) {
                                $agreement_status = $agreement->status;
                                if ($agreement_status == '1') {
                                    $message = [
                                        'message' => "Agreement Cancelled, SIM Cannot Assinged",
                                        'alert-type' => 'error',
                                        'error' => 'df'
                                    ];
                                    return redirect()->back()->with($message);
                                }
                            }

            $assign_plat = AssignPlateform::where('passport_id','=',$reserve_bike->passport_id)->where('status','=','1')->first();
            if($assign_plat==null){
                $message = [
                    'message' => 'Platform is not Assigned, please assign platform',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }


            $obj = new AssignSim();

            $obj->passport_id = $reserve_bike->passport_id;
            $obj->sim = $reserve_bike->sim_id;
            $obj->assigned_to = "1";
            $obj->checkin = $request->checkin;
            $obj->status = '1';
            $obj->save();

            $reserve_bike->sim_assign_status  = "1";
            $reserve_bike->assigned_by  = Auth::user()->id;
            $reserve_bike->update();

            DB::table('telecomes')->where('id',$reserve_bike->sim_id)
                ->update(['status' => '1','reserve_status'=>'0']);

        }



        if($reserve_bike->assign_status=="0"){

            $reserve_bike = ReserveBike::find($request->primary_id_selected);
            $bike_replacement = BikeReplacement::where('passport_id','=',$reserve_bike->passport_id)->where('type','=','1')->where('status','=','1')->first();

            if($bike_replacement != null){
                $message = [
                    'message' => 'This Rider have Replace Bike, So checkout that Replace Bike before Assign new Bike',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

            $bike_own_history = OwnSimBikeHistory::where('passport_id','=',$reserve_bike->passport_id)->where('own_type','=','2')->where('status','=','1')->first();

            if($bike_own_history != null){
                $message = [
                    'message' => 'This rider have own Bike.',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

            $assign_plat = AssignPlateform::where('passport_id','=',$reserve_bike->passport_id)->where('status','=','1')->first();
            if($assign_plat==null){
                $message = [
                    'message' => 'Platform is not Assigned, please assign platform',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

            $plate_number_detail =BikeDetail::where('id','=',$reserve_bike->bike_id)->where('status','=','1')->first();

            if($plate_number_detail != null){
                $message = [
                    'message' => 'This bike is already taken',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }


            $obj = new AssignBike();
            $obj->passport_id = $reserve_bike->passport_id;
            $obj->bike = $reserve_bike->bike_id;
            $obj->checkin = $request->input('checkin');
            $obj->remarks = $request->input('remarks');
            $obj->status = '1';
            $obj->save();

            $reserve_bike->assign_status  = "1";
            $reserve_bike->assigned_by  = Auth::user()->id;
            $reserve_bike->update();

            DB::table('bike_details')->where('id',$reserve_bike->bike_id)
                ->update(['status' => '1','reserve_status'=>'0']);
        }


        $message = [
            'message' => "assigned successfully",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);


    }



    public function render_vehicle_free_for_reservation(){


        $cancel_sim_id = SimCancel::where('status','=','1')->pluck('sim_id')->toArray();


        $sims = Telecome::select('telecomes.*')
            ->where(function ($query)  {
            $query->where('telecomes.status','!=','1')
            ->orwhere('telecomes.reserve_status','!=',1);
            })
            ->whereNotIn('telecomes.id',$cancel_sim_id)
            ->get();



        $cancel_bikes_ids = BikeCencel::pluck('bike_id')->toArray();

        $bikes = BikeDetail::whereNotIn('id',$cancel_bikes_ids)->get();
        $bikes_detail = BikeDetail::select('bike_details.*')
            ->where('status', '=', 2)
            ->orwhere('bike_details.reserve_status', '=', 1)
            ->distinct()
            ->get();
        // $checkedin = array();
        // foreach ($bikes_detail as $x) {
        //     $checkedin [] = $x->id;
        // }
        // $checked_out_bike = array();
        // foreach ($bikes as $ab) {
        //     if (!in_array($ab->id, $checkedin)) {
        //         $gamer = array(
        //             'id' => $ab->id,
        //             'bike' => $ab->plate_no,
        //             'cencel' => isset($ab->bike_cancel->plate_no) ? $ab->bike_cancel->plate_no : "",
        //             'plate_code' => $ab->plate_code,
        //         );
        //         $checked_out_bike [] = $gamer;
        //     }
        // }








        $view = view("admin-panel.on_board.render_vehicle_free_for_reservation",compact('sims','bikes_detail'))->render();
        return response()->json(['html'=>$view]);
    }

    public function save_reservation(Request  $request){

        $validator = Validator::make($request->all(), [
            'reserve_sim_id' => 'required',
            'reserve_bike_id' => 'required',
            'reservation_primary_id' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $primary_id = $request->reservation_primary_id;

        $on_board = OnBoardStatus::find($primary_id);

        $passport_id = "";

        if($on_board->passport_id != "0"){
            $passport_id = $on_board->passport_id;
        }else{
            $passport = Passport::where('career_id','=',$on_board->career_id)->first();

            if($passport != null){
                $passport_id = $passport->id;
            }else{

                $message = [
                    'message' => "PPUID is not created, please create ppuid",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
        }

         $is_telecome = Telecome::where('id','=',$request->reserve_sim_id)->where('status','=','1')->first();

        if($is_telecome != null){

            $message = [
                'message' => "This Sim already Assigned to someone.!",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);

        }

        $is_bike = BikeDetail::where('id','=',$request->reserve_bike_id)->where('status','=','1')->first();

        if($is_bike != null){

            $message = [
                'message' => "This Bike already Assigned to someone.!",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);

        }




        $already_reserve_bike = ReserveBike::where('passport_id',$passport_id)->where('assign_status','0')->first();

        if($already_reserve_bike != null){

            $message = [
                'message' => "Reservation is already done for this rider.!",
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


          $bike_reserve = new ReserveBike();
          $bike_reserve->passport_id = $passport_id;
          $bike_reserve->bike_id = $request->reserve_bike_id;
          $bike_reserve->sim_id = $request->reserve_sim_id;
          $bike_reserve->reserved_by = Auth::user()->id;
          $bike_reserve->save();

          Telecome::where('id','=',$request->reserve_sim_id)->update(['reserve_status'=>'1']);
          BikeDetail::where('id','=',$request->reserve_bike_id)->update(['reserve_status'=>'1']);

        $on_board = OnBoardStatus::find($primary_id);
        $on_board->is_reservation = "1";
        $on_board->update();



        $message = [
            'message' => "Sim and Bike reserved successfully",
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);



    }



    public function on_board_without_ppuid(){

//         $onboards = CreateInterviews::where('interview_status','=','1')->whereNotIn('career_id',$career_id)->get();

        $career_id = Passport::where('career_id','!=','0')->pluck('career_id')->toArray();



        $onboards = OnBoardStatus::where('interview_status','=','1')
                                   ->where('assign_platform','=','1')
                                   ->where('on_board','=','1')
                                    ->whereNotIn('career_id',$career_id)
                                    ->whereNull('passport_id')
                                    ->get();

        $employee_type_array = ['','Company','FourPl'];

        $nationalities = Nationality::all();

        return view('admin-panel.on_board.index',compact('nationalities','employee_type_array','onboards'));

    }

    public function vacation_accident_rider(Request $request){

        $assign_platforms =  AssignPlateform::select('passport_id')->where('status','=','1')
                                            ->groupby('passport_id')
                                            ->pluck('passport_id')
                                            ->toArray();


        if ($request->ajax()) {

            if(isset($request->platform)){
                if($request->platform==0 && $request->type==0){

                    $on_board_types = OnBoardStatusType::where(function ($query) use ($assign_platforms) {
                        $query->where('checkout_type','=','2')
                            ->where('applicant_status','=','0')
                        ->whereNotIn('passport_id',$assign_platforms);
                    })->orwhere(function ($query) use ($assign_platforms) {
                        $query->where('checkout_type','=','5')
                            ->where('applicant_status','=','0')
                            ->whereNotIn('passport_id',$assign_platforms);
                    })->get();

                }elseif($request->platform==0 && $request->type!=0){

                                if($request->type=="1"){
                                    $on_board_types = OnBoardStatusType::where(function ($query) use ($assign_platforms) {
                                        $query->where('checkout_type','=','2')
                                            ->where('applicant_status','=','0')
                                            ->whereNotIn('passport_id',$assign_platforms);
                                    })->where(function ($query) use ($assign_platforms) {
                                        $query->where('checkout_type','=','5')
                                            ->orwhere('applicant_status','=','0')
                                            ->whereNotIn('passport_id',$assign_platforms);
                                    })
                                        ->whereDate('expected_date', '<', Carbon::now()->toDateString())
                                        ->get();
                                }else{
                                    $on_board_types = OnBoardStatusType::where(function ($query) use ($assign_platforms) {
                                        $query->where('checkout_type','=','2')
                                            ->where('applicant_status','=','0')
                                            ->whereNotIn('passport_id',$assign_platforms);
                                    })->where(function ($query) use ($assign_platforms) {
                                        $query->where('checkout_type','=','5')
                                            ->orwhere('applicant_status','=','0')
                                            ->whereNotIn('passport_id',$assign_platforms);
                                    })->whereDate('expected_date', '>', Carbon::now()->toDateString())
                                    ->get();
                                }


                }elseif($request->platform!=0 && $request->type==0){

                    $platform_array = AssignPlateform::where('status','=','0')
                                    ->where('plateform','=',$request->platform)
                                    ->orderby('id','desc')
                                    ->get()->pluck('passport_id')->toArray();

                    $on_board_types = OnBoardStatusType::where(function ($query) use ($assign_platforms) {
                        $query->where('checkout_type','=','2')
                            ->where('applicant_status','=','0')
                        ->whereNotIn('passport_id',$assign_platforms);
                    })->where(function ($query) use ($assign_platforms) {
                        $query->where('checkout_type','=','5')
                            ->orwhere('applicant_status','=','0')
                            ->whereNotIn('passport_id',$assign_platforms);
                    })->whereIn('passport_id',$platform_array)
                        ->get();


                }elseif($request->platform!=0 && $request->type!=0){

                    $platform_array = AssignPlateform::where('status','=','0')
                        ->where('plateform','=',$request->platform)
                        ->orderby('id','desc')
                        ->get()->pluck('passport_id')->toArray();

                                    if($request->type=="1"){
                                        $on_board_types = OnBoardStatusType::where(function ($query) use ($assign_platforms) {
                                            $query->where('checkout_type','=','2')
                                                ->where('applicant_status','=','0')
                                                ->whereNotIn('passport_id',$assign_platforms);
                                        })->where(function ($query) use ($assign_platforms) {
                                            $query->where('checkout_type','=','5')
                                                ->orwhere('applicant_status','=','0')
                                                ->whereNotIn('passport_id',$assign_platforms);
                                        })->whereIn('passport_id',$platform_array)
                                            ->whereDate('expected_date', '<', Carbon::now()->toDateString())
                                            ->get();

                                    }else{

                                        $on_board_types = OnBoardStatusType::where(function ($query) use ($assign_platforms) {
                                            $query->where('checkout_type','=','2')
                                                ->where('applicant_status','=','0')
                                            ->whereNotIn('passport_id',$assign_platforms);
                                        })->where(function ($query) use ($assign_platforms) {
                                            $query->where('checkout_type','=','5')
                                                ->orwhere('applicant_status','=','0')
                                                ->whereNotIn('passport_id',$assign_platforms);
                                        })->whereIn('passport_id',$platform_array)
                                            ->whereDate('expected_date', '>', Carbon::now()->toDateString())
                                            ->get();
                                    }




                }

            }else{

                $on_board_types = OnBoardStatusType::where(function ($query) use ($assign_platforms) {
                    $query->where('checkout_type','=','2')
                        ->where('applicant_status','=','0')
                        ->whereNotIn('passport_id',$assign_platforms);
                })->orwhere(function ($query) use ($assign_platforms) {
                    $query->where('checkout_type','=','5')
                        ->where('applicant_status','=','0')
                        ->whereNotIn('passport_id',$assign_platforms);
                })->get();

            }



            return Datatables::of($on_board_types)
                ->editColumn('expected_date', function (OnBoardStatusType $on_board_types) {
                    return '<h4 class="badge badge-success">' . $on_board_types->expected_date . '</h4>';
                })
                ->addColumn('is_expire', function (OnBoardStatusType $on_board_types) {

                     $expected_date = $on_board_types->expected_date;

                    $end_date = new DateTime($expected_date);
                    $current_date = new DateTime();

                    if($current_date > $end_date)
                    {
                      return  "1";
                    }else{
                        return  "0";
                    }


                })
                ->editColumn('checkout_type', function (OnBoardStatusType $on_board_types) {
                    $type_ab = "";
                    $class = "";
                    if($on_board_types->checkout_type=="5"){
                        $type_ab = "Accident";
                        $class = "secondary";
                    }else{
                        $type_ab = "Vacation";
                        $class = "primary";
                    }
                    return '<h4 class="badge badge-'.$class.'">'.$type_ab.'</h4>';
                })
                ->addColumn('name', function (OnBoardStatusType $on_board_types) {
                    return $on_board_types->passport->personal_info->full_name;
                })->addColumn('zds_code', function (OnBoardStatusType $on_board_types) {
                    return $on_board_types->passport->zds_code->zds_code;
                })->addColumn('personal_no', function (OnBoardStatusType $on_board_types) {
                    return isset($on_board_types->passport->personal_info->personal_mob)?$on_board_types->passport->personal_info->personal_mob:"N/A";
                })->addColumn('passport_no', function (OnBoardStatusType $on_board_types) {
                    return $on_board_types->passport->passport_no;
                })->addColumn('action', function (OnBoardStatusType $on_board_types) {
                    $html_ab = "";
                    $html_ab = '<a class="text-success mr-2 edit_cls" id = "' . $on_board_types->id . '" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>';

                    return $html_ab;
                })
                ->rawColumns(['zds_code','personal_no','passport_no','expected_date', 'checkout_type', 'action'])
                ->make(true);
        }

        $plateform = Platform::all();

        return view('admin-panel.on_board.on_board_accident',compact('plateform'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    public function save_training_result(Request $request){


        if(isset($request->multiple_user)){

            $validator = Validator::make($request->all(), [
                'checkbox_array' => 'required',
                'multiple_user' => 'required',
                'training_status' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }
            $selected_user = explode(',',$request->checkbox_array);



            if($request->training_status=="1") {

                foreach($selected_user as $user_id){
                    $onboard = OnBoardStatus::find($user_id);
                    $onboard->is_training = $request->training_status;
                    $onboard->update();

                }
            }else{
                foreach($selected_user as $user_id){

                    $primary_id = $user_id;
                    $onboard = OnBoardStatus::find($primary_id);
                    $onboard->on_board = "0";
                    $onboard->assign_platform = "0";
                    $onboard->interview_status = "0";
                    $onboard->is_training = $request->training_status;
                    $careeer_id = $onboard->career_id;
                    $onboard->update();

                    $career = Career::find($careeer_id);
                    $career->applicant_status = "4";
                    $career->update();

                    $careers = new CareerStatusHistory();
                    // $careers->remarks = "sent to  from onboard";
                    // $careers->company_remarks = "sent to  from onboard";
                    $careers->career_id = $careeer_id;
                    $careers->status = "4";
                    $careers->user_id = Auth::user()->id;
                    $careers->save();

                    CreateInterviews::where('career_id', $careeer_id)->update(array('return_from_onboard' => '1'));


                }


            }



        }else{

            $validator = Validator::make($request->all(), [
                'training_status' => 'required',
                'training_primary_id' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            if($request->training_status=="1") {
                $onboard = OnBoardStatus::find($request->training_primary_id);
                $onboard->is_training = $request->training_status;
                $onboard->update();
            }else{
                $primary_id = $request->training_primary_id;
                $onboard = OnBoardStatus::find($primary_id);
                $onboard->on_board = "0";
                $onboard->assign_platform = "0";
                $onboard->interview_status = "0";
                $onboard->is_training = $request->training_status;
                $careeer_id = $onboard->career_id;
                $onboard->update();

                $career = Career::find($careeer_id);
                $career->applicant_status = "4";
                $career->update();

                $careers = new CareerStatusHistory();
                // $careers->remarks = "sent to  from onboard";
                // $careers->company_remarks = "sent to  from onboard";
                $careers->career_id = $careeer_id;
                $careers->status = "4";
                $careers->user_id = Auth::user()->id;
                $careers->save();

                CreateInterviews::where('career_id', $careeer_id)->update(array('return_from_onboard' => '1'));
            }

        }




        $message = [
            'message' => "Training status has been changes",
            'alert-type' => 'success',
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
            'change_status_id' => 'required',
            'request_type' => 'required',
            'follow_up_status' => 'required',
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }


        if($request->request_type=="1"){ // rejected from onboard normal candidate



            $primary_id = $request->change_status_id;

            $onboard = OnBoardStatus::find($primary_id);
            $onboard->on_board = "0";
            $onboard->assign_platform = "0";
            $onboard->interview_status = "0";

            $careeer_id =  $onboard->career_id;
            $onboard->update();

             $career= Career::find($careeer_id);
             $career->applicant_status = $request->follow_up_status;
             $career->follow_up_remove = "0";
             $career->follow_up_status = "0";
             $career->past_status = "333";
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
            $careers->career_id = $careeer_id;
            $careers->status = $request->follow_up_status;
            $careers->user_id = Auth::user()->id;
            $careers->save();

             CreateInterviews::where('career_id',$careeer_id)->update(array('return_from_onboard' => '1'));


             $passport_exist_or_not = Passport::where('career_id','=',$careeer_id)->first();

             if($passport_exist_or_not != null){

                $passport_id =  $passport_exist_or_not->id;

                $already_reserve_bike = ReserveBike::where('passport_id',$passport_id)->where('assign_status','0')->first();

                if($already_reserve_bike != null){


                    Telecome::where('id','=',$already_reserve_bike->sim_id)->update(['reserve_status'=>'0']);
                    BikeDetail::where('id','=',$already_reserve_bike->bike_id)->update(['reserve_status'=>'0']);

                    $already_reserve_bike->delete();

                }

             }




            $message = [
                'message' => "Rider status has changes successfully",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);

        }elseif($request->request_type=="2"){  // rejected from onboard rejoin guy



            $primary_id = $request->change_status_id;
            $time_stamp = Carbon::now()->toDateTimeString();

            $onboard = OnBoardStatus::find($primary_id);
            $onboard->on_board = "0";
            $onboard->assign_platform = "0";
            $onboard->interview_status = "0";
            $passport_id =  $onboard->passport_id;
            $onboard->update();

            $rejoin_career = RejoinCareer::where('passport_id',$passport_id)
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



            $already_reserve_bike = ReserveBike::where('passport_id',$passport_id)->where('assign_status','0')->first();

            if($already_reserve_bike != null){

                // $message = [
                //     'message' => "Reservation is already done for this rider.!",
                //     'alert-type' => 'error'
                // ];
                // return redirect()->back()->with($message);

                // $bike_reserve = new ReserveBike();
                // $bike_reserve->passport_id = $passport_id;
                // $bike_reserve->bike_id = $request->reserve_bike_id;
                // $bike_reserve->sim_id = $request->reserve_sim_id;
                // $bike_reserve->reserved_by = Auth::user()->id;
                // $bike_reserve->save();

                Telecome::where('id','=',$already_reserve_bike->sim_id)->update(['reserve_status'=>'0']);
                BikeDetail::where('id','=',$already_reserve_bike->bike_id)->update(['reserve_status'=>'0']);

                $already_reserve_bike->delete();

            }







            $rejoin_career->applicant_status =  $request->follow_up_status;
            $rejoin_career->on_board =  "0";
            $rejoin_career->follow_up_status =  "0";

            $data =  json_decode($rejoin_career->history_status,true);
            array_push($data, [$status_to_update => $time_stamp]);
            $rejoin_career->history_status = json_encode($data);
            $rejoin_career->update();


        if($rejoin_career != null){

            $rejoin_history = new RejoinCareerHitory();
            $rejoin_history->passport_id  = $passport_id;
            $rejoin_history->status = "1";
            $rejoin_history->past_status = 33; //means rejected from onboard
            $rejoin_history->user_id = Auth::user()->id;
            $rejoin_history->remarks = "Rejected From onboard";
            $rejoin_history->save();

        }



            $message = [
                'message' => "Rider status has changes successfully",
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);


        }

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
        $board_type = OnBoardStatusType::find($id);
        $board_type->platform_id = json_encode($request->platform);
        $board_type->applicant_status = "1";
        $board_type->update();



        $onboard = OnBoardStatus::where('passport_id','=',$board_type->passport_id)->first();

        if($onboard != null){
            $onboard->interview_status = "0";
             $onboard->on_board = "0";
             $onboard->assign_platform = "0";
             $onboard->update();
        }


            $onboard =   new OnBoardStatus();
            $onboard->passport_id = $board_type->passport_id;
            $onboard->interview_status = "1";
            $onboard->on_board = "1";
            $onboard->assign_platform = "1";
            $onboard->save();
//        }else{
//             $onboard = new OnBoardStatus();
//            $onboard->passport_id = $board_type->passport_id;
//            $onboard->interview_status = 1;
//             $onboard->exist_user = "1";
//             $onboard->on_board = "1";
//             $onboard->assign_platform = "1";
//             $onboard->save();
//         }
//
//            $board_form = new  OnBoardStatusForm();
//            $board_form->passport_id =  $board_type->passport_id;
//            $board_form->on_board_status_types_id =  $id;
//            $board_form->save();



        $message = [
            'message' => "Rider Has been sent to Onboard",
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->back()->with($message);

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
