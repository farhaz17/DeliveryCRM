<?php

namespace App\Http\Controllers\Profile;

use DB;
use App\Quotation;
use Carbon\Carbon;
use App\Model\Ticket;
use App\Model\Platform;
use App\Model\Telecome;
use App\Model\Cods\Cods;
use App\Model\BikeDetail;
use App\Model\Departments;
use App\Model\Nationality;
use App\Model\AgreedAmount;
use App\Model\Guest\Career;
use App\Model\RiderProfile;
use App\Model\TicketMessage;
use Illuminate\Http\Request;
use App\Model\Cods\CloseMonth;
use App\Model\Referal\Referal;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use App\Model\Emirates_id_cards;
use App\Model\OwnSimBikeHistory;
use App\Model\Passport\Passport;
use App\Model\VendorRiderOnboard;
use App\Model\Agreement\Agreement;
use App\Model\ArBalance\ArBalance;
use App\Model\CodUpload\CodUpload;
use App\Model\UserCodes\UserCodes;
use Barryvdh\DomPDF\Facade as PDF;
use App\Model\Assign\SimAssignType;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\TalabatCod\TalabatCod;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\AssignPlateform;
use App\Model\Passport\PassportDelay;
use App\Model\VisaProcess\VisaPasted;
use function GuzzleHttp\Psr7\uri_for;
use Validator,Redirect,Response,File;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\BikeHandling\BikeHandling;
use App\Model\Passport\PassportToLocker;
use App\Model\PlatformCode\PlatformCode;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\Attendance\RiderAttendance;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Performance\DeliverooSetting;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\SimReplacement\SimReplacement;
use App\Model\VisaProcess\EntryPrintOutside;
use App\Model\VisaProcess\RenewAgreedAmount;
use App\Model\TalabatCod\TalabatCodDeduction;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\Passport\passport_addtional_info;
use App\Model\Performance\DeliverooPerformance;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\VisaProcess\RenewalEmiratesIdTyping;
use App\Model\BikeHandling\UploadHandlingAgreement;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Model\Ticket_assign_logs\Ticket_assign_logs;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\ElectronicApproval\ElectronicPreApproval;

class ProfileShowController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|profile-view-profile', ['only' => ['index']]);

        $this->middleware('role_or_permission:Admin|profile-sim-checkin', ['only' => ['profile_sim_assign']]);
        $this->middleware('role_or_permission:Admin|profile-sim-checkout', ['only' => ['profile_sim_checkout']]);

        $this->middleware('role_or_permission:Admin|profile-bike-checkin', ['only' => ['profile_bike_assign']]);
        $this->middleware('role_or_permission:Admin|profile-bike-checkout', ['only' => ['profile_bike_checkout']]);

        $this->middleware('role_or_permission:Admin|profile-platform-checkin', ['only' => ['profile_plateform_assign']]);
        $this->middleware('role_or_permission:Admin|profile-platform-checkout', ['only' => ['profile_plat_checkout']]);

        $this->middleware('role_or_permission:Admin|profile-bike-handling', ['only' => ['bike_handling_new']]);

    }

    /**
     * Display a listing of the resource.

     * @return \Illuminate\Http\Response
     */
    public function index(){

        return view('admin-panel.profile.index');
    }
    /**
     * Display a listing of the resource.
     * AssignBike,ArBalance,ArBalanceSheet,AssignPlateform,AgreedAmount,AssigningAmount,Agreement,AgreemenUpload,AssignReport,AssignSim,BikePersonFuel,BikeReplacement,CompanyCode,Cods,CloseMonth,CodPrevious,CodAdjustRequest,CareerStatusHistory,CreateInterviews,DrivingLicense,Emirates_id_cards,LabourCardTypeAssign,LogAfterPpuid,PassportAddtionalInfo,PassportRequest,RiderOrderDetail,RiderAttendance,RiderProfile,RenewPassport,Referal,RiderClothSize,ManageRepair,OnBoardStatus,UserCodes,WpsPaymentDetail*
     *
     */

    public function rider_life_cycle(){
        $all_rider_histories = [];
        if(request('passport_id') !== null){
            $passport_id = request('passport_id');
            $count_history = count($all_rider_histories);
            // Application submissioin table date
            foreach(Career::wherePassportNo(Passport::find($passport_id)->passport_no ?? "")->with('user')->oldest()->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Form Submission';
                $all_rider_histories[$count_history]['event_type'] = 'Application Submitted';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate <span class='badge badge-lg badge-danger text-white'>Submitted Application </span> on"  . date(" F j, Y, g:i a " ,strtotime($history['created_at']));
                if($history['user'] !== null){
                    $event_desctiption .= "recorded by <span class='badge badge-lg badge-info text-white'>"
                    . $history['user']['name'] . "</span>";
                }
                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };

            // Passport Created log
            foreach(Passport::whereId($passport_id)->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Passport Registration';
                $all_rider_histories[$count_history]['event_type'] = 'Passport Registration';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate <span class='badge badge-lg badge-success text-white'>Passport Created </span> on"  . date(" F j, Y, g:i a " ,strtotime($history['created_at']));
                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };

            // Logging Agreed Amount
            foreach(AgreedAmount::wherePassportId($passport_id)->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Passport Registration';
                $all_rider_histories[$count_history]['event_type'] = 'Financial Records';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate agreed to pay <span class='badge badge-lg badge-success text-white'> "
                . number_format($history['agreed_amount'],2)
                . " AED </span> paid in advance <span class='badge badge-lg badge-success text-white'> "
                . number_format($history['advance_amount'],2)
                . " AED </span> provided discount <span class='badge badge-lg badge-success text-white'> "
                . number_format((int)$history['discount_details'],2)
                . " AED </span> on "
                . date(" F j, Y, g:i a " ,strtotime($history['created_at']))
                . ". <br> <span class='badge badge-lg badge-success text-white'>" . number_format($history['payroll_deduct_amount'],2) . " AED </span> will be deducted from salary.";

                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };

            // Logging Passport delay Handling
            foreach(PassportDelay::wherePassportId($passport_id)->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Passport Operation';
                $all_rider_histories[$count_history]['event_type'] = 'Passport Delyed';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate <span class='badge badge-lg badge-success text-white'> delayed  </span> to provide passport to company on "  . date(" F j, Y, g:i a " ,strtotime($history['created_at']));
                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };

            // Logging Passport Handling
            foreach(PassportToLocker::wherePassportId($passport_id)->with(['user','receiving_user'])->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Passport Operation';
                $all_rider_histories[$count_history]['event_type'] = 'Passport Transfer';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate passport transfered to <span class='badge badge-lg badge-success text-white'> ". $history['receiving_user']['name']  . " </span> on "  . date(" F j, Y, g:i a " ,strtotime($history['created_at']));
                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };

            // Application updates
            $career_id = Career::wherePassportNo(Passport::find($passport_id)->passport_no ?? "")->oldest()->first()->id ?? null;
            foreach(CareerStatusHistory::whereCareerId($career_id)->whereNotIn('status',[0])->oldest()->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Career Operation';
                $all_rider_histories[$count_history]['event_type'] = 'Candidate Application Updated';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate application <span class='badge badge-lg badge-success text-white'> Send to " . get_followup_statuses_name($history["status"]) .
                " </span> on" .
                date(" F j, Y, g:i a " ,strtotime($history['created_at'])) ;
                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };

            // Selected Candidate for Interview
            foreach(CreateInterviews::whereCareerId($career_id)->oldest()->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Interview Operation';
                $all_rider_histories[$count_history]['event_type'] = 'Candidate Application Updated';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate application <span class='badge badge-lg badge-primary text-white'> Send to Interview </span> on" .
                date(" F j, Y, g:i a " ,strtotime($history['created_at'])) ;
                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };

            // results of Candidates for Interview
            foreach(CreateInterviews::whereCareerId($career_id)->oldest()->get()->toArray() as $history){
                if($history['created_at'] !== $history['updated_at']){
                    $all_rider_histories[$count_history]['event_name'] = 'Carrer Update';
                    $all_rider_histories[$count_history]['event_type'] = 'Candidate Application Updated';
                    $event_desctiption = '';
                    $event_desctiption .= "The Candidate selected and send to <span class='badge badge-lg badge-info text-white'>" . get_interview_statuses_name($history['interview_status']) . "</span> on" .
                    date(" F j, Y, g:i a " ,strtotime($history['created_at'])) ;
                    $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                    $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                    $count_history++;
                }
            };

            // Onboarded Candidates from Interview
            foreach(OnBoardStatus::whereCareerId($career_id)->oldest()->get()->toArray() as $history){
                $all_rider_histories[$count_history]['event_name'] = 'Sent to On Board';
                $all_rider_histories[$count_history]['event_type'] = 'On Boarding';
                $event_desctiption = '';
                $event_desctiption .= "The Candidate passed interview and sent to  <span class='badge badge-lg badge-success text-white'> OnBoarding " .
                " </span> on" .
                date(" F j, Y, g:i a " ,strtotime($history['created_at'])) ;
                $all_rider_histories[$count_history]['event_desctiption'] = $event_desctiption;
                $all_rider_histories[$count_history]['date_time'] = $history['created_at'];
                $count_history++;
            };
        }
        $all_rider_histories = collect($all_rider_histories)->sortBy('date_time')->values()->all();
        $all_riders = Passport::with(['personal_info'])->get();
        return view('admin-panel.vehicle_master.rider_life_cycle', compact('all_rider_histories','all_riders'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( Request $request)
    {
        if($request->ajax()) {

            if ($request->filter_by == "1") {
                //passport number
                $searach = '%' . $request->keyword . '%';
                $passport= Passport::where('passport_no', 'like', $searach)->first();
                $passport_id=$passport->id;

                $view = view("admin-panel.profile.ajax_get_passport.blade",compact('passport_id'))->render();
                return response()->json(['html'=>$view]);


            } elseif ($request->filter_by == "2") {
                //name
                $searach = '%' . $request->keyword . '%';
                $passport = passport_addtional_info::where('full_name', 'like', $searach)->pluck('passport_id')->toArray();

                $assign_bike = AssignBike::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id', $passport)
                    ->orderby('updated_at', 'desc')
                    ->get();
            } elseif ($request->filter_by == "3") {
                //ppuid

                $searach = '%' . $request->keyword . '%';
                $passport = Passport::where('pp_uid', 'like', $searach)->pluck('id')->toArray();

                $assign_bike = AssignBike::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id', $passport)
                    ->orderby('updated_at', 'desc')
                    ->get();
            } elseif ($request->filter_by == "4") {
                //zds code
                $searach = '%' . $request->keyword . '%';
                $passport = UserCodes::where('zds_code', 'like', $searach)->pluck('passport_id')->toArray();

                $assign_bike = AssignBike::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id', $passport)
                    ->orderby('updated_at', 'desc')
                    ->get();
            } elseif ($request->filter_by == "5") {
                //plate number

                $searach = '%' . $request->keyword . '%';
                $bike_ids = BikeDetail::where('plate_no', 'like', $searach)->pluck('id')->toArray();

                $assign_bike = AssignBike::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('bike', $bike_ids)
                    ->orderby('updated_at', 'desc')
                    ->get();
            } elseif ($request->filter_by == "6") {
                //platform

                $searach = '%' . $request->keyword . '%';

                $platform_ids = Platform::where('name', 'like', $searach)->pluck('id')->toArray();
                $passsport = AssignPlateform::whereIn('plateform', $platform_ids)->pluck('passport_id')->toArray();

                $assign_bike = AssignBike::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id', $passsport)
                    ->orderby('updated_at', 'desc')
                    ->get();
            } elseif ($request->filter_by == "7") {
                //nothing

                $assign_bike = [];

            }
            return view('admin-panel.profile.index',compact('passport_id'));
        }
    }
    public function profile_show(Request $request)
    {
        $checked_out = '';
        $ticket_history = '';
        $average_rating = '';
        $current_ar_balance = '';
        //passport number
        $searach = '%' . $request->keyword . '%';
        $passport = Passport::where('passport_no', 'like', $searach)->first();

        $passport_id = $passport->id;
        $dc = AssignToDc::where('rider_passport_id',$passport_id)->where('status','1')->first();
        $visa_number=EntryPrintOutside::where('passport_id',$passport_id)->first();
        $labour_card_number=ElectronicPreApproval::where('passport_id',$passport_id)->first();
        $user = RiderProfile::where('passport_id', $passport_id)->first();
        if ($user == null || empty($user)) {
            $user = 'null';
        }
        $full_name = passport_addtional_info::where('passport_id', $passport_id)->first();
        $assign_bike = AssignBike::where('passport_id', $passport_id)->where('status', '=', '1')->first();
        $temporary_bike = BikeReplacement::where('passport_id','=',$passport_id)->where('status','=','1')->first();
        $assign_sim = AssignSim::where('passport_id', $passport_id)->where('status', '=', '1')->first();
        $temporary_sim = SimReplacement::where('passport_id','=',$passport_id)->where('status','=','1')->first();
        $assign_plat = AssignPlateform::where('passport_id', $passport_id)->where('status', '=', '1')->first();
        $emirates_id = Emirates_id_cards::where('passport_id', $passport_id)->first();
        $driving_license = DrivingLicense::where('passport_id', $passport_id)->first();
        $user_code = UserCodes::where('passport_id', $passport_id)->first();

        //Fourpl Vendor fetch
        $vendor_rider = VendorRiderOnboard::with('vendor')->where('passport_no', $passport->passport_no)->where('status', 1)->where('cancel_status', 0)->first();
        // print_r($vendor_rider); exit;
        // $fourpl_vendor = FourPl::where('id', $vendor_rider->fourpls_id)->first();

        // Riders cod balances starts here
        $cod_balances = collect();

        // Deliveroo COD Balance
        $remain_amount = 0;
        $total_pending_amount = 0;
        $total_paid_amount = 0;
        $check_in_platform = $passport->platform_assign->where('status', '=', '1')->pluck(['plateform'])->first();
        $rider_id = $passport->platform_codes->where('platform_id', '=', $check_in_platform)->pluck(['platform_code'])->first();

        if (isset($rider_id)) {
            $amount =  CodUpload::where('rider_id','=',$rider_id)->where('platform_id','=',$check_in_platform)->selectRaw('sum(amount) as total')->first();
            $paid_amount =  Cods::where('passport_id',$passport_id)->where('platform_id','=',$check_in_platform)->where('status','1')->selectRaw('sum(amount) as total')->first();
            $adj_req_t =CodAdjustRequest::where('passport_id','=',$passport_id)->where('status','=','2')->selectRaw('sum(amount) as total')->first();
            $salary_array = CloseMonth::where('passport_id','=',$passport_id)->selectRaw('sum(close_month_amount) as total')->first();
            if($adj_req_t != null){
                $total_paid_amount = $total_paid_amount+$adj_req_t->total;
            }
            if(!empty($amount)){
                $total_pending_amount = $amount->total;
            }
            if(!empty($paid_amount)){
                $total_paid_amount = $paid_amount->total;
            }
            if(!empty($salary_array)){
                $total_paid_amount = $total_paid_amount+$salary_array->total;
            }
            $previous_balance =  isset($assign_plat->passport->previous_balance->amount) ? $assign_plat->passport->previous_balance->amount : '0';
            $now_amount = $total_pending_amount+$previous_balance;
            $remain_amount =  $now_amount-$total_paid_amount;

            $deliveroo_cod = collect(['name' => "Deliveroo",'balance' => $remain_amount]);
            $cod_balances->push($deliveroo_cod);
        }
        // talabat COD Balance
        $last_talabat_cod = TalabatCod::wherePassportId($passport_id)->latest('start_date')->first();
        if($last_talabat_cod){
            $deductions = TalabatCodDeduction::wherePassportId($passport_id)
            ->whereMonth('start_date', Carbon::parse($last_talabat_cod->start_date)->month)
            ->sum('deduction');
            $talabat_cod = collect(['name' => "Talabat",'balance' => $last_talabat_cod->current_day_balance]); // - $deductions]);
            $cod_balances->push($talabat_cod);
        }

        // Riders cod balances ends here

        //user overall performance
        $platform_code = PlatformCode::where('passport_id', '=', $passport_id)->first();
        //if there is no rider id in the database

        if ($platform_code != null || !empty($platform_code)) {
            $del_setting = DeliverooSetting::first();
            if (isset($assign_plat->plateform) == '4') {
                $ratings = DeliverooPerformance::where('rider_id', $platform_code->platform_code)->get();

                    foreach ($ratings as $rate) {

                        if ($rate->attendance < $del_setting->attendance_critical_value) {
                            $att_rating = 1;
                        } elseif ($rate->attendance >= $del_setting->attendance_critical_value && $rate->attendance < $del_setting->attendance_bad_value) {
                            $att_rating = 2;
                        } elseif ($rate->attendance >= $del_setting->attendance_bad_value && $rate->attendance < $del_setting->attendance_good_value) {
                            $att_rating = 3;
                        } elseif ($rate->attendance >= $del_setting->attendance_good_value) {
                            $att_rating = 4;
                        }
                        //unassigned
                        if ($rate->unassigned >= $del_setting->unassigned_critical_value) {
                            $un_ass_rating = 1;
                        } elseif ($rate->unassigned <= $del_setting->unassigned_critical_value && $rate->unassigned > $del_setting->unassigned_bad_value) {
                            $un_ass_rating = 2;
                        } elseif ($rate->unassigned <= $del_setting->unassigned_bad_value && $rate->unassigned > $del_setting->unassigned_good_value) {
                            $un_ass_rating = 3;
                        } elseif ($rate->unassigned <= $del_setting->unassigned_good_value) {
                            $un_ass_rating = 4;
                        }
                        //wait at customer
                        if ($rate->wait_time_at_customer >= $del_setting->wait_critical_value) {
                            $wait_rating = 1;
                        } elseif ($rate->wait_time_at_customer <= $del_setting->wait_critical_value && $rate->wait_time_at_customer > $del_setting->wait_bad_value) {
                            $wait_rating = 2;
                        } elseif ($rate->wait_time_at_customer <= $del_setting->wait_bad_value && $rate->wait_time_at_customer > $del_setting->wait_good_value) {
                            $wait_rating = 3;
                        } elseif ($rate->wait_time_at_customer <= $del_setting->wait_good_value) {
                            $wait_rating = 4;
                        }
//-----------------rating calculation--------------
                        $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
                        $final_avg = $avg_rating / 3;
                        $final_rating = ($final_avg / 4) * 5;
                        if ($rate->attendance == 0) {
                            $rating = 0.00;
                        } else {
                            $rating = number_format($final_rating, 2);
                        }
                $array_rating[] = $rating;
                $total_ratings = count($array_rating);
                $average_rating = array_sum($array_rating) / $total_ratings;
                }
            }

            if (isset($platform_code->platform_code)) {
                $user_performance_dates = FacadesDB::table('deliveroo_performances')
                    ->select('date_to', 'date_from')
                    ->where('rider_id', $platform_code->platform_code)
                    ->distinct('date_to')
                    ->orderBy('date_to', 'desc')
                    ->limit('5')
                    ->get();
            }

        } else {
            $average_rating = "6";
            $user_performance_dates = '1';
        }

        $bikes = AssignBike::where('passport_id', $passport_id)
            ->orderBy('checkin', 'desc')
            ->get();
        $temp_bikes = BikeReplacement::where('passport_id','=',$passport_id)->where('type', 1)->orderBy('replace_checkin', 'desc')->get();
        $telecom = AssignSim::where('passport_id', $passport_id)
            ->orderBy('checkin', 'desc')
            ->get();
        $temp_sims = SimReplacement::where('passport_id', $passport_id)
            ->orderBy('replace_checkin', 'desc')
            ->get();
        $platforms = AssignPlateform::where('passport_id', $passport_id)
            ->orderBy('checkin', 'desc')
            ->get();
        $bike_handling = BikeHandling::where('passport_id', $passport_id)->first();
        $bike_handlings = BikeHandling::where('passport_id', $passport_id)->get();
        $bike_handling_upload = UploadHandlingAgreement::where('passport_id', $passport_id)->get();

        $bike_checkout = BikeDetail::where('status', '0')->get();
        $sim_checkout = Telecome::where('status', '0')->get();
        $assign_type=SimAssignType::all();
        $platforms_names=Platform::all();
        if( isset($bike_handling)){
            $bike_handle_route = route('bike_handle_pdf',$bike_handling->id);
        }
        else{
            $bike_handle_route='null';
        }
        $nation=Nationality::all();
        //check current balance of the user
        if(isset($user_code->passport_id)){
            $bal_detail=ArBalanceSheet::where('passport_id', $passport_id)->get();
        }else{
            $bal_detail= array();
        }

        if(isset($user_code->passport_id)){
            $first_balance=AgreedAmount::where('passport_id',$passport_id)->first();
        }else{
            $first_balance= array();
        }
        if(isset($user_code->passport_id)){
            $ar_balance_sheet=ArBalanceSheet::where('passport_id',$passport_id)->get();
        }else{
            $ar_balance_sheet= array();
        }

        $rider_orders=RiderOrderDetail::where('passport_id',$passport_id)->orderBy('id', 'desc')->take(10)->get();
        $attendance = RiderAttendance::where('passport_id', $passport_id)->whereDate('created_at', '=', Carbon::today()->toDateString())->first();
        $attendance_detail = RiderAttendance::where('passport_id', $passport_id)->get();
        $user_agreement = Agreement::where('passport_id', $passport_id)->first();

        if( isset($user_agreement)){
            $agreement_route = route('agreement_pdf',$user_agreement->id);
        }else{
            $agreement_route='null';
        }
         $referal=Referal::where('passport_id',$passport_id)->get();
         $riderProfile = RiderProfile::where('passport_id', '=', $passport_id)->first();

        if ($riderProfile == !null || !empty($riderProfile)) {
            $pending_tickets = Ticket::where('user_id', '=', $riderProfile->user_id)->where('is_checked', '0')->count();
            $in_process_tickets = Ticket::where('user_id', '=', $riderProfile->user_id)->where('is_checked', '2')->count();
            $closed_tickets = Ticket::where('user_id', '=', $riderProfile->user_id)->where('is_checked', '1')->count();
            $rejected_tickets = Ticket::where('user_id', '=', $riderProfile->user_id)->where('is_checked', '3')->count();
            $ticket_history = Ticket::where('user_id', $riderProfile->user_id)->get();
        }else{
            $pending_tickets='0';
            $in_process_tickets='0';
            $closed_tickets='0';
            $rejected_tickets='0';

        }
        if ($riderProfile == !null || !empty($riderProfile)) {
            $pending_tickets1 = Ticket::where('user_id','=',$riderProfile->user_id)
                ->where('is_checked', '0')
                ->orderBy('created_at', 'DESC')
                ->get();
            $in_process_tickets1 = Ticket::where('user_id', '=', $riderProfile->user_id)
                ->where('is_checked', '2')
                ->orderBy('created_at', 'DESC')
                ->get();
            $closed_tickets1 = Ticket::where('user_id', '=', $riderProfile->user_id)
                ->where('is_checked', '1')
                ->orderBy('created_at', 'DESC')
                ->get();
            $rejected_tickets1 = Ticket::where('user_id', '=', $riderProfile->user_id)
                ->where('is_checked', '3')
                ->orderBy('created_at', 'DESC')
                ->get();
        }else{
            $pending_tickets1='null';
            $in_process_tickets1='null';
            $closed_tickets1='null';
            $rejected_tickets1='null';
        }
        $user_codes = PlatformCode::with('update_histories')->where('passport_id','=',$passport_id)->get();

        //-------------visa process details--------------------------;
        $first_visa= CurrentStatus::where('passport_id',$passport_id)->first();
        $second_visa= RenewAgreedAmount::where('passport_id',$passport_id)->first();
        $second_visa_count= RenewAgreedAmount::where('passport_id',$passport_id)->count();
        $visa_pasted='0';




        if($first_visa==null){
            $visa_msg='Visa Record Not Found';
        }elseif($first_visa->current_process_id!='27'){
            if($first_visa->current_process_id=='25'){
                $visa_pasted= VisaPasted::where('passport_id',$passport_id)->first();
            }
            $visa_msg="Visa Process at". $first_visa->current !== null ? $first_visa->current->step_name ?? "NA" : "NA";
        }elseif($first_visa->current_process_id=='27'){
            if($second_visa==null){
                $visa_msg='On First Visa';
                $visa_pasted= VisaPasted::where('passport_id',$passport_id)->first();

            }
            elseif($second_visa!=null && $second_visa->current_status<'7'){
            $visa_msg='Second Visa at'.$second_visa->renew_visa_step->step_name;
            }
            elseif($second_visa->current_status=='7' && $second_visa_count=='0'){
                $visa_msg='On second Visa';
                $visa_pasted= RenewalEmiratesIdTyping::where('passport_id',$passport_id)->first();



            }else{
                $visa_msg='Visa Record Not Found';
            }

        }
        else{
            $visa_msg='Visa Record Not Found';
        }

        // dd($user->passport->passport_pic);
        //-----------visa process details ends
        $view = view("admin-panel.profile.ajax_get_passport", compact('user_codes','passport_id', 'assign_bike', 'assign_sim', 'assign_plat', 'cod_balances',
            'passport', 'emirates_id', 'driving_license', 'user_code', 'user', 'full_name', 'remain_amount'
            ,'average_rating', 'user_performance_dates', 'pending_tickets', 'in_process_tickets', 'closed_tickets', 'rejected_tickets',
            'ticket_history', 'checked_out','bikes','telecom','platforms','bike_handling','bike_handle_route','nation',
            'bike_handlings','bike_handling_upload','bike_checkout','sim_checkout','assign_type','platforms_names','platform_code','visa_number',
            'labour_card_number','current_ar_balance','ar_balance_sheet','rider_orders','attendance','attendance_detail','agreement_route','bal_detail',
            'first_balance','referal','pending_tickets1','in_process_tickets1','closed_tickets1','rejected_tickets1','dc', 'vendor_rider','visa_msg','visa_pasted',
            'temporary_bike', 'temp_bikes', 'temporary_sim', 'temp_sims'))->render();
        return response()->json(['html' => $view]);


    }




            public  function get_profile_detail( Request $request)
            {
                $pass_id = $request->pass_id;
                $type = $request->type;

                if ($type == '1') {
                    $childe['data'] = [];
                    if (!empty($pass_id)) {
                        $bikes = AssignBike::where('passport_id', $pass_id)
                            ->orderBy('checkin', 'desc')
                            ->get();
                        foreach ($bikes as $bike) {

                            $gamer = array(
                                'id' => $bike->id ? $bike->id : '',
                                'passport_id' => $bike->passport_id ? $bike->passport_id : '',
                                'plate_no' => $bike->bike_plate_number->plate_no ? $bike->bike_plate_number->plate_no : '',
                                'checkin' => isset($bike->checkin) ? $bike->checkin : 'N/A',
                                'checkout' => isset($bike->checkout) ? $bike->checkout : 'N/A',
                                'remakrs' => isset($bike->remarks) ? $bike->remarks : 'N/A',
                                'status' => $bike->status,

                            );
                            $childe['data'] [] = $gamer;
                        }
                        echo json_encode($childe);
                        exit;
                    } else {
                        $childe['data'] = [];
                        echo json_encode($childe);
                        exit;
                    }
                }
                elseif ($type == '2') {
                    $childe['data'] = [];
                    if (!empty($pass_id)) {
                        $sims = AssignSim::where('passport_id', $pass_id)->get();
                        foreach ($sims as $sim) {
                            $gamer = array(
                                'id' => $sim->id ? $sim->id : '',
                                'sim_number' => $sim->telecome->account_number ? $sim->telecome->account_number : 'N/A',
                                'checkin' => isset($sim->checkin) ? $sim->checkin : 'N/A',
                                'checkout' => isset($sim->checkout) ? $sim->checkout : 'N/A',
                                'remakrs' => isset($sim->remarks) ? $sim->remarks : 'N/A',
                                'status' => $sim->status,
                            );
                            $childe['data'] [] = $gamer;
                        }
                        echo json_encode($childe);
                        exit;
                    } else {
                        $childe['data'] = [];
                        echo json_encode($childe);
                        exit;
                    }
                }
                elseif ($type == '3') {
                    $childe['data'] = [];
                    if (!empty($pass_id)) {
                        $platforms = AssignPlateform::where('passport_id', $pass_id)->get();
                        foreach ($platforms as $platform) {
                            $gamer = array(
                                'id' => $platform->id ? $platform->id : 'N/A',
                                'platform' => $platform->plateformdetail->name ? $platform->plateformdetail->name : 'N/A',
                                'checkin' => isset($platform->checkin) ? $platform->checkin : 'N/A',
                                'checkout' => isset($platform->checkout) ? $platform->checkout : 'N/A',
                                'remakrs' => isset($platform->remarks) ? $platform->remarks : 'N/A',
                                'status' => $platform->status,
                            );
                            $childe['data'] [] = $gamer;
                        }
                        echo json_encode($childe);
                        exit;
                    } else {
                        $childe['data'] = [];
                        echo json_encode($childe);
                        exit;
                    }
                }

            }

    public function ajax_performance_info(Request $request){

        $pass_id = $request->pass_id;
        $type = $request->type;
        $date_from = $request->date_from;

//        -----------------rating calculation--------
        $platform_code=PlatformCode::where('passport_id','=',$pass_id)->first();
        $per_detail = DeliverooPerformance::where('date_from',$date_from)->where('rider_id',$platform_code->platform_code)->first();
        $del_setting = DeliverooSetting::first();
            $ratings = DeliverooPerformance::where('date_from',$date_from)->where('rider_id',$platform_code->platform_code)->get();
            foreach ($ratings as $rate){

                if ($rate->attendance < $del_setting->attendance_critical_value) {
                    $att_rating = 1;
                } elseif ($rate->attendance >= $del_setting->attendance_critical_value && $rate->attendance < $del_setting->attendance_bad_value) {
                    $att_rating = 2;
                } elseif ($rate->attendance >= $del_setting->attendance_bad_value && $rate->attendance < $del_setting->attendance_good_value) {
                    $att_rating = 3;
                } elseif ($rate->attendance >= $del_setting->attendance_good_value) {
                    $att_rating = 4;
                }
                //unassigned
                if ($rate->unassigned >= $del_setting->unassigned_critical_value) {
                    $un_ass_rating = 1;
                } elseif ($rate->unassigned <= $del_setting->unassigned_critical_value && $rate->unassigned > $del_setting->unassigned_bad_value) {
                    $un_ass_rating = 2;
                } elseif ($rate->unassigned <= $del_setting->unassigned_bad_value && $rate->unassigned > $del_setting->unassigned_good_value) {
                    $un_ass_rating = 3;
                } elseif ($rate->unassigned <= $del_setting->unassigned_good_value) {
                    $un_ass_rating = 4;
                }
                //wait at customer
                if ($rate->wait_time_at_customer >= $del_setting->wait_critical_value) {
                    $wait_rating = 1;
                } elseif ($rate->wait_time_at_customer <= $del_setting->wait_critical_value && $rate->wait_time_at_customer > $del_setting->wait_bad_value) {
                    $wait_rating = 2;
                } elseif ($rate->wait_time_at_customer <= $del_setting->wait_bad_value && $rate->wait_time_at_customer > $del_setting->wait_good_value) {
                    $wait_rating = 3;
                } elseif ($rate->wait_time_at_customer <= $del_setting->wait_good_value) {
                    $wait_rating = 4;
                }

//-----------------rating calculation--------------
                $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
                $final_avg = $avg_rating / 3;
                $final_rating = ($final_avg / 4) * 5;
                if ($rate->attendance == 0) {
                    $rating = 0.00;
                } else {
                    $rating = number_format($final_rating, 2);
                }
                $array_rating[]=$rating;
            }

            $total_ratings=count($array_rating);
            $average_rating=array_sum($array_rating)/$total_ratings;

        $childe['data'] = [];
            $gamer = array(
            'hours_scheduled' => $per_detail->hours_scheduled ? $per_detail->hours_scheduled : '',
            'hours_worked' => isset($per_detail->hours_worked) ? $per_detail->hours_worked : 'N/A',
            'attendance' => isset($per_detail->attendance) ? $per_detail->attendance : 'N/A',
            'no_of_orders_delivered' => isset($per_detail->no_of_orders_delivered) ? $per_detail->no_of_orders_delivered : 'N/A',
            'no_of_orders_unassignedr' => isset($per_detail->no_of_orders_unassignedr) ? $per_detail->no_of_orders_unassignedr : 'N/A',
            'unassigned' => isset($per_detail->unassigned) ? $per_detail->unassigned : 'N/A',
            'wait_time_at_customer' => isset($per_detail->wait_time_at_customer) ? $per_detail->wait_time_at_customer : 'N/A',
            'rating' => $average_rating,


                );
                $childe['data'] [] = $gamer;

          echo json_encode($childe);
        exit;

//        return response()->json(['html'=>$view]);

    }

    public function full_cod_history(Request $request){


        $pass_id = $request->pass_id;
        $type = $request->type;
            $riderProfile  = RiderProfile::where('passport_id','=',$pass_id)->first();
            $cod_full_history = Cods::where('user_id',$riderProfile->user_id)->get();
            $adj_history =  CodAdjustRequest::where('user_id','=',$riderProfile->user_id)->get();






        $view = view("admin-panel.profile.ajax_get_cod_detail",compact('cod_full_history','adj_history','type'))->render();

        return response()->json(['html'=>$view]);




    }


    public function ajax_ticket_info2(Request $request){

        $id = $request->id;
        $all_ticket = Ticket::where('id',$id)->get();
        $ticket_chat = TicketMessage::where('ticket_id',$id)->get();

        $view = view("admin-panel.ticket.ajax_ticket_info",compact('all_ticket', 'ticket_chat'))->render();

        return response()->json(['html'=>$view]);

    }

    public function profile_bike_checkout(Request $request){

        $checkout= $request->input('checkout');
        $remarks=$request->input('remarks');
        $id=$request->input('bike_primary_id');
        $obj = AssignBike::find($id);
        $obj->checkout=$checkout;
        $obj->remarks=$remarks;
        $obj->status='0';
        $obj->save();
        $bike_id=AssignBike::where('id',$id)->latest('created_at')->first();
        DB::table('bike_details')->where('id', $bike_id->bike)
            ->update(['status' => '0']);
        return "success";
    }

    public function profile_sim_checkout(Request $request)
    {
        //
        $id=$request->input('sim_primary_id');
        $obj = AssignSim::find($id);
        $obj->checkout=$request->input('checkout');
        $obj->remarks=$request->input('remarks');
        $obj->status='0';
        $obj->save();
        $sim_id=AssignSim::where('id',$id)->latest('created_at')->first();

        DB::table('telecomes')->where('id', $sim_id->sim)
            ->update(['status' => '0']);

        return "success";
    }




    public function profile_bike_assign(Request $request)
    {

        $bike_id=$request->input('bike');
        $pass_id=  $request->input('passport_id');
        $passport_number=AssignBike::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
        $plate_number=AssignBike::where('bike',$bike_id)->latest('created_at')->first();

        if($plate_number != null && $passport_number != null ){

            if($passport_number->status!= "1" && $plate_number->status != "1" ){


                $obj = new AssignBike();
                $obj->passport_id = $request->input('passport_id');
                $obj->bike = $request->input('bike');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');
                $obj->status = '1';
                $obj->save();


                DB::table('bike_details')->where('id',$bike_id)
                    ->update(['status' => '1']);

                $message = [
                    'message' => 'Bike Assinged',
                    'alert-type' => 'success'

                ];


                return "success";


//                return "success";
            }else{


                $message = [
                    'message' => 'Bike Already Assigned  Not checkout',
                    'alert-type' => 'error'

                ];
                return "Bike Already Assigned  Not checkout";

            }

        }elseif($passport_number != null){

            if($passport_number->status!="1"){
                $obj = new AssignBike();
                $obj->passport_id = $request->input('passport_id');
                $obj->bike = $request->input('bike');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');

                $obj->status = '1';
                $obj->save();
                DB::table('bike_details')->where('id',$bike_id)
                    ->update(['status' => '1']);

                $message = [
                    'message' => 'Bike Assinged',
                    'alert-type' => 'success'

                ];
               return "success";


            }else{


                $message = [
                    'message' => 'Bike Already Assigned  Not checkout',
                    'alert-type' => 'error'

                ];
                return "Bike Already Assigned  Not checkout";
//                return "success";
            }

        }elseif($plate_number != null){

            if($plate_number->status!="1"){

                $obj = new AssignBike();
                $obj->passport_id = $request->input('passport_id');
                $obj->bike = $request->input('bike');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');

                $obj->status = '1';
                $obj->save();

                DB::table('bike_details')->where('id',$bike_id)
                    ->update(['status' => '1']);


                $message = [
                    'message' => 'Bike Assinged',
                    'alert-type' => 'success'

                ];

                return "success";

            }else{



                $message = [
                    'message' => 'Bike Already Assigned  Not checkout',
                    'alert-type' => 'error'

                ];
                return "Bike Already Assigned  Not checkout";
//                return "success";

            }

        }else{

            $obj = new AssignBike();
            $obj->passport_id = $request->input('passport_id');
            $obj->bike = $request->input('bike');
            $obj->checkin = $request->input('checkin');
            $obj->remarks = $request->input('remarks');
            $obj->status = '1';
            $obj->save();

            DB::table('bike_details')->where('id',$bike_id)
                ->update(['status' => '1']);


            $message = [
                'message' => 'Bike Assinged',
                'alert-type' => 'success'

            ];



            return "success";

        }
    }


    public function profile_sim_assign(Request $request)
    {
        $pass_id= $request->input('passport_id');
        $sim_id=$request->input('sim');
        $assigned_to=$request->input('assigned_to');
        $assigned_id=AssignSim::where('passport_id',$pass_id)->count();
        $checkout_detail=AssignSim::where('passport_id',$pass_id)->latest('created_at')->first();
        if ($assigned_to=='2' ||$assigned_to=='3'||$assigned_to=='5'){
            $obj = new AssignSim();
            $obj->passport_id = $request->input('passport_id');
            $obj->sim = $request->input('sim');
            $obj->assigned_to = $request->input('assigned_to');
            $obj->checkin = $request->input('checkin');
            $obj->status = '1';
            $obj->save();
            DB::table('telecomes')->where('id',$sim_id)
                ->update(['status' => '1']);
            return "success";
        }
        else if ($assigned_id >= 1 &&  $checkout_detail->status =='1') {
            return "error";
        }



        else if ($assigned_id >=1 &&  $checkout_detail->status =='0'){


            $obj = new AssignSim();
            $obj->passport_id = $request->input('passport_id');
            $obj->sim = $request->input('sim');
            $obj->assigned_to = $request->input('assigned_to');
            $obj->checkin = $request->input('checkin');
            $obj->status = '1';
            $obj->save();

            DB::table('telecomes')->where('id',$sim_id)
                ->update(['status' => '1']);
            return "success";

        }
        else{


            $obj = new AssignSim();
            $obj->passport_id = $request->input('passport_id');
            $obj->sim = $request->input('sim');
            $obj->assigned_to = $request->input('assigned_to');
            $obj->checkin = $request->input('checkin');
            $obj->status = '1';
            $obj->save();

            DB::table('telecomes')->where('id',$sim_id)
                ->update(['status' => '1']);





            return "success";
        }
    }


    public function profile_plateform_assign(Request $request)
    {
        //
        $pass_id= $request->input('passport_id');
        $assigned_id=AssignPlateform::where('passport_id',$pass_id)->count();
        $checkout_detail=AssignPlateform::where('passport_id',$pass_id)->latest('created_at')->first();

        if ($assigned_id >= 1 &&  $checkout_detail->status =='1'){
            return "error";
        }
        else if ($assigned_id >=1 &&  $checkout_detail->status =='0'){

            $obj = new AssignPlateform();
            $obj->passport_id = $request->input('passport_id');
            $obj->plateform = $request->input('plateform');
            $obj->checkin = $request->input('checkin');
            $obj->status ='1';
            $obj->save();



            return "success";

        }
        else{

            $obj = new AssignPlateform();
            $obj->passport_id = $request->input('passport_id');
            $obj->plateform = $request->input('plateform');
            $obj->checkin = $request->input('checkin');
            $obj->status ='1';
            $obj->save();
            return "success";
        }

    }



    public function profile_plat_checkout(Request $request)
    {
        //

        $id=$request->input('id');


           $obj = AssignPlateform::find($id);
            $obj->checkout=$request->input('checkout');
            $obj->remarks=$request->input('remarks');
            $obj->status='0';
            $obj->save();

            $passport_id = $obj->passport_id;

        OwnSimBikeHistory::where('passport_id','=',$passport_id)
            ->where('status','=','1')
            ->update(array('status' => "0", 'checkout'=>$request->input('checkout') ));

        AssignToDc::where('rider_passport_id','=',$passport_id)
            ->where('status','=','1')
            ->update(array('status' => "0"));

            return "success";




    }


     public function autocomplete(Request $request)
    {

        $search_text = $request->get('query');

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->get();


        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->get();

        }



        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->get();

                        if (count($mobile_data)=='0')
                        {
//                            $drive_lin_data =Passport::select('driving_licenses.license_number','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
//                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
//                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
//                                ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                                ->where("driving_licenses.license_number","LIKE","%{$request->input('query')}%")
//                                ->get();
//                            $platform=$request->input('query');
//                            $plaform_code_id=PlatformCode::where('platform_code',$platform)->first();

                            $platform_code =Passport::select('platform_codes.platform_code','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('platform_codes', 'platform_codes.passport_id', '=', 'passports.id')
                                ->where("platform_codes.platform_code","LIKE","%{$request->input('query')}%")
                                ->get();
                          if (count($platform_code)=='0') {
                              $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                  ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                  ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                  ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                  ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                  ->get();
                              if (count($emirates_code) == '0') {
                                  $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                      ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                      ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                      ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                      ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                      ->get();
                                  if (count($drive_lin_data) == '0') {
                                      $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                          ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                          ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                          ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                          ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                          ->get();
                                      if( count($labour_card_data)=='0') {
                                          $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                              ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                              ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                              ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                              ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                              ->get();
                                          if (count($visa_number) == '0') {
                                              $platno = $request->input('query');
                                              $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                              if($bike_id != null){
                                                  $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                      ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                      ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                      ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                      ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                      ->where("assign_bikes.status", "1")
                                                      ->get();
                                                  //platnumber response
                                                  $pass_array = array();
                                                  foreach ($plat_data as $pass) {
                                                      $gamer = array(
                                                          'name' => $bike_id->plate_no,
                                                          'zds_code' => $pass->zds_code,
                                                          'passport' => $pass->passport_no,
                                                          'ppuid' => $pass->pp_uid,
                                                          'full_name' => $pass->full_name,
                                                          'type' => '5',
                                                      );
                                                      $pass_array[] = $gamer;
                                                      return response()->json($pass_array);
                                                  }
                                              }

                                          }

                                          //visa number search
                                          $pass_array = array();
                                          foreach ($visa_number as $pass) {
                                              $gamer = array(
                                                  'name' => $pass->visa_number,
                                                  'zds_code' => $pass->zds_code,
                                                  'passport' => $pass->passport_no,
                                                  'ppuid' => $pass->pp_uid,
                                                  'full_name' => $pass->full_name,
                                                  'type' => '10',
                                              );
                                              $pass_array[] = $gamer;
                                              return response()->json($pass_array);
                                          }



                                      }


                                      $pass_array = array();
                                      foreach ($labour_card_data as $pass) {
                                          $gamer = array(
                                              'name' => $pass->labour_card_no,
                                              'zds_code' => $pass->zds_code,
                                              'passport' => $pass->passport_no,
                                              'ppuid' => $pass->pp_uid,
                                              'full_name' => $pass->full_name,
                                              'type' => '9',
                                          );
                                          $pass_array[] = $gamer;
                                          return response()->json($pass_array);
                                      }



                                  }

                                  //platnumber response
                                  $pass_array = array();
                                  foreach ($drive_lin_data as $pass) {
                                      $gamer = array(
                                          'name' => (string)$pass->license_number,
                                          'zds_code' => $pass->zds_code,
                                          'passport' => $pass->passport_no,
                                          'ppuid' => $pass->pp_uid,
                                          'full_name' => $pass->full_name,
                                          'type' => '8',
                                      );
                                      $pass_array[] = $gamer;

                                      return response()->json($pass_array);
                                  }
                              }


                                  //emirates ID response
                                  $pass_array = array();
                                  foreach ($emirates_code as $pass) {
                                      $gamer = array(

                                          'name' => $pass->card_no,
                                          'zds_code' => $pass->zds_code,
                                          'passport' => $pass->passport_no,
                                          'ppuid' => $pass->pp_uid,
                                          'full_name' => $pass->full_name,
                                          'type' => '7',
                                      );
                                      $pass_array[] = $gamer;

                                  }
                                  return response()->json($pass_array);
                              }

                          //platform code  response

                            $pass_array=array();
                            foreach ($platform_code as $pass){
                                $gamer = array(
                                    'name' => $pass->platform_code,
                                    'zds_code' => $pass->zds_code,
                                    'passport' => $pass->passport_no,
                                    'ppuid' => $pass->pp_uid,
                                    'full_name' => $pass->full_name,
                                    'type'=>'6',
                                );
                                $pass_array[]= $gamer;
                            }

                            return response()->json($pass_array);
                        }
                        //mobile number response
                        $pass_array=array();
                        foreach ($mobile_data as $pass){
                            $gamer = array(
                                'name' => $pass->personal_mob,
                                'zds_code' => $pass->zds_code,
                                'passport' => $pass->passport_no,
                                'ppuid' => $pass->pp_uid,
                                'full_name' => $pass->full_name,
                                'type'=>'5',
                            );
                            $pass_array[]= $gamer;
                        }
                        return response()->json($pass_array);
                    }

//zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => $pass->zds_code,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'full_name' => $pass->full_name,
                            'type'=>'3',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);

                }

                //full name response
                $pass_array=array();
                foreach ($full_data as $pass){
                    $gamer = array(
                        'name' => $pass->full_name,
                        'passport' => $pass->passport_no,
                        'ppuid' => $pass->pp_uid,
                        'zds_code' => $pass->zds_code,
                        'type'=>'2',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);

            }
            //ppuid response

            $pass_array=array();
            foreach ($puid_data as $pass){
                $gamer = array(
                    'name' => $pass->pp_uid,
                    'passport' => $pass->passport_no,
                    'full_name' => $pass->full_name,
                    'zds_code' => $pass->zds_code,
                    'type'=>'1',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);
        }


//passport number response
        $pass_array=array();

        foreach ($passport_data as $pass){
            $gamer = array(
                'name' => $pass->passport_no,
                'ppuid' => $pass->pp_uid,
                'full_name' => $pass->full_name,
                'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }
    public function bike_handling(Request $request)
    {

if ($request->input('id')=='hand_id'){

        $obj= new BikeHandling();
        $obj->full_name=$request->input('full_name');
        $obj->passport_id=$request->input('passport_id');
        $obj->nationality=$request->input('nationality');
        $obj->dob=$request->input('dob');
        $obj->emirates_id=$request->input('emirates_id');
        $obj->emirates_issue_date=$request->input('emirates_issue_date');
        $obj->expiry_date=$request->input('expiry_date');
        $obj->mobile_number=$request->input('mobile_number');
        $obj->email=$request->input('email');
        $obj->license_number=$request->input('license_number');
        $obj->place_issue=$request->input('place_issue');
        $obj->issue_date=$request->input('issue_date');
        $obj->expire_date=$request->input('expire_date');
        $obj->company=$request->input('company');
        $obj->model_year=$request->input('model_year');
        $obj->type=$request->input('type');
        $obj->plate_no=$request->input('plate_no');
        $obj->color=$request->input('color');
        $obj->location=$request->input('location');
        $obj->dep_date=$request->input('dep_date');
        $obj->exp_date=$request->input('exp_date');
        $obj->save();

        return "success";

    }
    else{

        $id=$request->input('id');
        $obj = BikeHandling::find($id);
        $obj->full_name=$request->input('full_name');
        $obj->passport_id=$request->input('passport_id');
        $obj->nationality=$request->input('nationality');
        $obj->dob=$request->input('dob');
        $obj->emirates_id=$request->input('emirates_id');
        $obj->emirates_issue_date=$request->input('emirates_issue_date');
        $obj->expiry_date=$request->input('expiry_date');
        $obj->expiry_date=$request->input('expiry_date');
        $obj->mobile_number=$request->input('mobile_number');
        $obj->email=$request->input('email');
        $obj->license_number=$request->input('license_number');
        $obj->place_issue=$request->input('place_issue');
        $obj->issue_date=$request->input('issue_date');
        $obj->company=$request->input('company');
        $obj->model_year=$request->input('model_year');
        $obj->type=$request->input('type');
        $obj->plate_no=$request->input('plate_no');
        $obj->color=$request->input('color');
        $obj->location=$request->input('location');
        $obj->dep_date=$request->input('dep_date');
        $obj->exp_date=$request->input('exp_date');
        $obj->save();

        return "success";
    }

}


    public function bike_handling_new(Request $request)
    {
            $obj= new BikeHandling();
            $obj->full_name=$request->input('full_name');
            $obj->passport_id=$request->input('passport_id');
            $obj->nationality=$request->input('nationality');
            $obj->dob=$request->input('dob');
            $obj->emirates_id=$request->input('emirates_id');
            $obj->emirates_issue_date=$request->input('emirates_issue_date');
            $obj->expiry_date=$request->input('expiry_date');
            $obj->expiry_date=$request->input('expiry_date');
            $obj->mobile_number=$request->input('mobile_number');
            $obj->email=$request->input('email');
            $obj->license_number=$request->input('license_number');
            $obj->place_issue=$request->input('place_issue');
            $obj->issue_date=$request->input('issue_date');
            $obj->expire_date=$request->input('expire_date');
            $obj->company=$request->input('company');
            $obj->model_year=$request->input('model_year');
            $obj->type=$request->input('type');
            $obj->plate_no=$request->input('plate_no');
            $obj->color=$request->input('color');
            $obj->location=$request->input('location');
            $obj->dep_date=$request->input('dep_date');
            $obj->exp_date=$request->input('exp_date');
            $obj->save();
            return "success";
    }
    public function bike_handle_pdf($id){
        $bike_handle_detail=BikeHandling::find($id);
        $mpdf = new \Mpdf\Mpdf();
        $view = view("admin-panel.pdf.bike_handle_pdf", compact('bike_handle_detail'))->render();
        $mpdf->WriteHTML($view);
        $mpdf->Output();
    }
    public function upload_bike_handle(Request $request){
        $current_timestamp = Carbon::now()->timestamp;
        if (!empty($_FILES['file_name']['name'])) {
            if (!file_exists('./assets/upload/bike_hadling_agreement')) {
                mkdir('./assets/upload/bike_hadling_agreement', 0777, true);
            }
            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file1 = $request->input('file_name').$current_timestamp . '.' . $ext;
            move_uploaded_file($_FILES["file_name"]["tmp_name"], './assets/upload/bike_hadling_agreement/' . $file1);
            $file_path = '/assets/upload/bike_hadling_agreement/' . $file1;
            $obj = new UploadHandlingAgreement();
            $obj->passport_id = $request->input('passport_id');
            $obj->file_path = $file_path;
            $obj->remarks = $request->input('remarks');
            $obj->save();
            return "success";
        }

    }



    public function autocomplete_eid_handover(Request $request)
    {

        $search_text = $request->get('query');

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->get();


        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->get();

        }



        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->get();

//zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => $pass->zds_code,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'full_name' => $pass->full_name,
                            'type'=>'3',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);

                }

                //full name response
                $pass_array=array();
                foreach ($full_data as $pass){
                    $gamer = array(
                        'name' => $pass->full_name,
                        'passport' => $pass->passport_no,
                        'ppuid' => $pass->pp_uid,
                        'zds_code' => $pass->zds_code,
                        'type'=>'2',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);

            }
            //ppuid response

            $pass_array=array();
            foreach ($puid_data as $pass){
                $gamer = array(
                    'name' => $pass->pp_uid,
                    'passport' => $pass->passport_no,
                    'full_name' => $pass->full_name,
                    'zds_code' => $pass->zds_code,
                    'type'=>'1',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);
        }


//passport number response
        $pass_array=array();

        foreach ($passport_data as $pass){
            $gamer = array(
                'name' => $pass->passport_no,
                'ppuid' => $pass->pp_uid,
                'full_name' => $pass->full_name,
                'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }



}


