<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Middleware\Rider;
use App\Model\ArBalance\ArBalance;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\Attendance\RiderAttendance;
use App\Model\CodUpload\CodUpload;
use App\Http\Controllers\VisaProcess\ElectronicPreApprovalController;
use App\Model\Agreement\Agreement;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Assign\OfficeSimAssign;
use App\Model\BikeDetail;
use App\Model\BikesTracking\BikesTracking;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\Cods\Cods;
use App\Model\ContactForm;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\Departments;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\Guest\Career;
use App\Model\InterviewBatch\InterviewBatch;
use App\Model\MajorDepartment;
use App\Model\Nationality;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Passport\Passport;
use App\Model\Performance\DeliverooPerformance;
use App\Model\Performance\DeliverooSetting;
use App\Model\Platform;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\RiderProfile;
use App\Model\Seeder\Company;
use App\Model\Telecome;
use App\Model\Ticket;
use App\Model\UserCodes\UserCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Quotation;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        //passport section code

        $passport=Passport::all();
        $sims=Telecome::all();
        $assigned_sims=AssignSim::all();
        $company_assign=OfficeSimAssign::all();
        $bikes=BikeDetail::all();
        $assigned_bikes=AssignBike::all();
        $tracking_bikes=BikesTracking::all();
        $agreement=Agreement::all();
        $elec_pre_app=ElectronicPreApproval::all();
        $tickets=Ticket::all();
        $maj_dep=MajorDepartment::all();
        $issue_dep=Departments::all();
        $reg_fail=ContactForm::all();
        $zds_code=UserCodes::all();
        $driving_license=DrivingLicense::all();
        $hiring_pool=Career::all();
        $platforms=Platform::all();
        $cod_uploads=CodUpload::all();
        $cod=Cods::all();
        $adj = CodAdjustRequest::all();
        $interview_batches= InterviewBatch::all();
        $last_five_batches= InterviewBatch::orderBy('id', 'desc')->take(5)->get();
        $create_interview= CreateInterviews::all();
        $assign_platform=AssignPlateform::all();
        $nation=Nationality::all();
        //over all average reating
        $companies=Company::all();
        $passport2 = Passport::join('driving_licenses','driving_licenses.passport_id','=','passports.id')
            ->get()
            ->pluck('passport_no')
            ->toArray();
        $short_list = Career::whereNotIn('passport_no',$passport2)
            ->where('applicant_status','=','2')
            ->orderBy('updated_at','desc')->get();
        $first_priority =  Career::select('careers.*')
            ->where('licence_status','=','1')   // driving license = yes
            ->where('company_visa','=','1')  // taking visa company =yes
            ->where(function ($q) {       // visa status  = cancel / visit visa
                $q->where('visa_status', '=', '1')->orWhere('visa_status', '=', '2');
            })
            ->where('applicant_status','=','0')
            ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
            ->orderBy('careers.id','desc')
            ->get();


        $second_priority = Career::select('careers.*')
            ->where('licence_status','=','1') // driving license = yes
            ->where('company_visa','=','1')  // taking visa company =yes
            ->where('visa_status','=','3') // own
            ->where('applicant_status','=','0')
            ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
            ->orderBy('careers.id','desc')
            ->get();

        $third_priority = Career::select('careers.*')
            ->where(function ($q) {
                $q->where('licence_status', '!=', '1')->orWhere('company_visa', '!=', '1')->orWhere('visa_status', '=', '0')
                ;
            })
            ->where('applicant_status','=','0')
            ->leftjoin('passports','passports.passport_no','=','careers.passport_no')->whereNull('passports.passport_no')
            ->orderBy('careers.id','desc')
            ->get();
        $total_hiring_pending=count($first_priority)+count($second_priority)+count($third_priority);


        $del_setting = DeliverooSetting::first();
        $averrage_rating = DeliverooPerformance::selectRaw('rider_id,AVG(attendance) as attendance,AVG(unassigned) as unassigned,AVG(wait_time_at_customer) as wait_time_at_customer')
            ->groupBy('rider_id')->get();

        $overall_rating=array();
        $counter_good=0;
        $counter_bad=0;
        $counter_criticle=0;
//        $wait_rating=0;
        foreach ($averrage_rating as $avg) {

            if ($avg->attendance < $del_setting->attendance_critical_value) {
                $att_rating = 1;
            } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
                $att_rating = 2;
            } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
                $att_rating = 3;
            } elseif ($avg->attendance >= $del_setting->attendance_bad_value) {
                $att_rating = 4;
            }
            //unassigned
            if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
                $un_ass_rating = 1;
            } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
                $un_ass_rating = 2;
            } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
                $un_ass_rating = 3;
            } elseif ($avg->unassigned <= $del_setting->unassigned_good_value) {
                $un_ass_rating = 4;
            }
            //wait at customer

            if($avg->wait_time_at_customer >= $del_setting->wait_critical_value){
                $wait_rating = 1;
            }
            elseif($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value ){
                $wait_rating = 2;
            }

            elseif($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value ){
                $wait_rating = 3;
            }

            elseif($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value){
                $wait_rating = 3;
            }


            elseif($avg->wait_time_at_customer <= $del_setting->wait_bad_value)
            {
                $wait_rating = 4;
            }


//            if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
//                $wait_rating = 1;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
//                $wait_rating = 2;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
//                $wait_rating = 3;
//            } elseif ($avg->wait_time_at_customer <= $del_setting->unassigned_good_value) {
//                $wait_rating = 4;
//            }


//-----------------rating calculation--------------

            $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
            $final_avg = $avg_rating / 3;
            $final_rating = ($final_avg / 4) * 5;
            if ($avg->attendance == 0) {
                $rating = 0.00;
                $overall_rating[]=$rating;
            } else {
                $rating = number_format($final_rating, 2);

            }

            if($rating < 2){
                $counter_criticle++;

            }
            if($rating >=2 && $rating <3){
                $counter_bad++;
            }

            if($rating >=3 ){
                $counter_good++;
            }

        }

        $overall_per=$counter_criticle+$counter_bad+$counter_good;


        if($counter_good !=0){
            $good_per=$counter_good/$overall_per*100;
        }
        else{
            $good_per=0;
        }
        if ($counter_bad != 0){
            $bad_per=$counter_bad/$overall_per*100;
        }
        else{
            $bad_per=0;
        }
        if ($counter_criticle !=0){
            $cricticle_per=$counter_criticle/$overall_per*100;
        }
        else{
            $cricticle_per=0;
        }





        //last two weeks perforamce



        $date_ranges = DB::table('deliveroo_performances')
            ->select('date_to','date_from')
            ->distinct('date_to')
            ->orderBy('date_to', 'desc')
            ->limit('2')
            ->get();

        $last_two_weeks=array();
        foreach ($date_ranges as $dates) {
            $res = array(
                "date_from" => $dates->date_from,
            );
            $last_two_weeks[]= $res;
        }


        $from=$last_two_weeks;
        $del_setting = DeliverooSetting::first();

        $averrage_rating = DeliverooPerformance::selectRaw('rider_id,AVG(attendance) as attendance,AVG(unassigned) as unassigned,AVG(wait_time_at_customer) as wait_time_at_customer')
            ->whereIn('date_from',$from)
            ->groupBy('rider_id')->get();
        $two_counter_good=0;
        $two_counter_bad=0;
        $two_counter_criticle=0;

        foreach ($averrage_rating as $avg) {

            if ($avg->attendance < $del_setting->attendance_critical_value) {
                $att_rating = 1;
            } elseif ($avg->attendance >= $del_setting->attendance_critical_value && $avg->attendance < $del_setting->attendance_bad_value) {
                $att_rating = 2;
            } elseif ($avg->attendance >= $del_setting->attendance_bad_value && $avg->attendance < $del_setting->attendance_good_value) {
                $att_rating = 3;
            } elseif ($avg->attendance >= $del_setting->unassigned_good_value) {
                $att_rating = 4;
            }
            //unassigned
            if ($avg->unassigned >= $del_setting->unassigned_critical_value) {
                $un_ass_rating = 1;
            } elseif ($avg->unassigned <= $del_setting->unassigned_critical_value && $avg->unassigned > $del_setting->unassigned_bad_value) {
                $un_ass_rating = 2;
            } elseif ($avg->unassigned <= $del_setting->unassigned_bad_value && $avg->unassigned > $del_setting->unassigned_good_value) {
                $un_ass_rating = 3;
            } elseif ($avg->unassigned <= $del_setting->unassigned_good_value) {
                $un_ass_rating = 4;
            }
            //wait at customer


            if ($avg->wait_time_at_customer >= $del_setting->wait_critical_value) {
                $wait_rating = 1;
            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_critical_value && $avg->wait_time_at_customer > $del_setting->wait_bad_value) {
                $wait_rating = 2;
            } elseif ($avg->wait_time_at_customer <= $del_setting->wait_bad_value && $avg->wait_time_at_customer > $del_setting->wait_good_value) {
                $wait_rating = 3;
            } elseif ($avg->wait_time_at_customer <= $del_setting->unassigned_good_value) {
                $wait_rating = 4;
            }

//-----------------rating calculation--------------

            $avg_rating = $att_rating + $un_ass_rating + $wait_rating;
            $final_avg = $avg_rating / 3;
            $final_rating = ($final_avg / 4) * 5;
            if ($avg->attendance == 0) {
                $rating = 0.00;
            } else {
                $rating = number_format($final_rating, 2);
            }



            if($rating < 2){
                $two_counter_criticle++;

            }
            if($rating >=2 && $rating <3){
                $two_counter_bad++;
            }

            if($rating >=3 ){
                $two_counter_good++;
            }



        }


        $overall_per_two=$two_counter_criticle+$two_counter_bad+$two_counter_good;

        if ($two_counter_good){
            $good_per_two=$two_counter_good/$overall_per_two*100;
        }
        else{
            $good_per_two=0;
        }
        if ($two_counter_bad !=0){
            $bad_per_two=$two_counter_bad/$overall_per_two*100;
        }
        else{
            $bad_per_two=0;
        }
        if ($two_counter_criticle){
            $cricticle_per_two=$two_counter_criticle/$overall_per_two*100;
        }
        else{
            $cricticle_per_two=0;
        }





        $last_two_week = strtotime("-2 week +1 day");
        $cod_date=date("Y-m-d",$last_two_week);
        $cod_gen_date=date("Y-m-d",$last_two_week);

//last 2 weeks COD Over-all
        $cod_last_two_week = DB::table('cods')
            ->select('date')
            ->where("date",">=",$cod_date)
          ->groupBy('date')
            ->get();
//last 2 weeks cod with cash
        $cod_last_two_week_cash = DB::table('cods')
            ->select('date')
            ->where("date",">=",$cod_date)
            ->where("type","=",'0')
            ->groupBy('date')
            ->get();
//last 2 weeks cod by Bank
        $cod_last_two_week_bank = DB::table('cods')
            ->select('date')
            ->where("date",">=",$cod_date)
            ->where("type","=",'1')
            ->groupBy('date')
            ->get();
//last 2 weeks COD Generated

        $cod_generated = DB::table('cod_uploads')
            ->select(DB::raw('start_date','end_date'))
            ->where("start_date",">=",$cod_gen_date)
            ->groupBy('start_date')
            ->get();
        $cod_gen_all=array();
        $index=0;
        foreach($cod_generated as $cod_last_two) {
            $cod_gen_all[] = $cod_generated[$index]->start_date;
            $index++;
        }
    $cod_gen_final=CodUpload::whereIn('start_date',$cod_gen_all)->get();







        $data_label = "";
        $data_label_values = "";
        $data_label_cash = "";
        $data_label_values_cash = "";
        $data_label_bank = "";
        $data_label_values_bank = "";
         $data_label_gen = "";
        $data_label_values_gen = "";



        //over all graph cod
        $i=0;
        foreach($cod_last_two_week as $cod_last_two){
            $data_label .= "'{$cod_last_two_week[$i]->date}'".",";
            $value = Cods::select('date', DB::raw('sum(amount) as total_amount'))->where('date','=',$cod_last_two_week[$i]->date)->groupBy('date')->first();
            $data_label_values .= "{$value->total_amount}".",";
            $i++;
        }
         $data_label = trim($data_label,",");
        $data_label_values = trim($data_label_values,",");



//cash graph
        $x=0;
        foreach($cod_last_two_week_cash as $cod_last_two){
            $data_label_cash .= "'{$cod_last_two_week_cash[$x]->date}'".",";
            $value = Cods::select('date', DB::raw('sum(amount) as total_amount'))
                ->where('date','=',$cod_last_two_week_cash[$x]->date)
                ->where('type','=','0')
                ->groupBy('date')->first();
            $data_label_values_cash .= "{$value->total_amount}".",";
            $x++;
        }
        $data_label_cash = trim($data_label_cash,",");
        $data_label_values_cash = trim($data_label_values_cash,",");
     //by bank graph
        $y=0;
        foreach($cod_last_two_week_bank as $cod_last_two){
            $data_label_bank .= "'{$cod_last_two_week_bank[$y]->date}'".",";
            $value = Cods::select('date', DB::raw('sum(amount) as total_amount'))
                ->where('date','=',$cod_last_two_week_bank[$y]->date)
                ->where('type','=','1')
                ->groupBy('date')->first();
            $data_label_values_bank .= "{$value->total_amount}".",";
            $y++;
        }
        $data_label_bank = trim($data_label_bank,",");
        $data_label_values_bank = trim($data_label_values_bank,",");
        //graph cod generated

        foreach($cod_gen_final as $cod_last_two){
            $data_label_gen .= "'{$cod_last_two->start_date}-{$cod_last_two->end_date}'".",";
            $value = CodUpload::select('start_date', DB::raw('sum(amount) as total_amount'))
                ->where('start_date','=',$cod_last_two->start_date)
                ->groupBy('start_date')->first();
            $data_label_values_gen .= "{$value->total_amount}".",";

        }
        $data_label_gen= trim($data_label_gen,",");
        $data_label_values_gen = trim($data_label_values_gen,",");




        //cod counter

        $cod_count_array=array();
        $i=0;
        foreach($cod_last_two_week as $cod_last_two){
            $cod_count_array[]=$cod_last_two_week[$i]->date;
            $i++;
        }


        $cod_counter=Cods::whereIn('date',$cod_count_array)->get();
        $cod_counter1=count($cod_counter->where("amount",'<','500'));
        $cod_counter2=count($cod_counter->where("amount",'>=','500')->where("amount",'<','750'));
        $cod_counter3=count($cod_counter->where("amount",'>=','750')->where("amount",'<','1000'));
        $cod_counter4=count($cod_counter->where("amount",'>','1000'));

        $employees_by_com=array();
        foreach ($companies as $company){
            $data_company = "$company->name";
            $company_id = "$company->id";


//            $company_count = Offer_letter::select('company', DB::raw('count(offer_letters.id) as total_company'))
//                ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.id')
//                ->where('company','=',$company->id)->groupBy('company')->first();
//
//            dd($company_count);

            $company_count =Offer_letter::select('offer_letters.company', DB::raw('count(offer_letters.id) as total_company'))
                ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'offer_letters.passport_id')
                 ->where('offer_letters.company','=',$company->id)
                ->groupBy('offer_letters.company')
                ->first();



            if(!empty( $company_count))
            {
                $data_company_values = "{$company_count->total_company}";
            }
            else
              {
                $zero = "0";
                $data_company_values = "$zero";
            }
            $gamer = array(
                'company_name' => $data_company,
                'company_count' =>$data_company_values,
                'id' =>$company_id,
            );
            $employees_by_com[]=$gamer;
        }

        $ar_balance=ArBalance::all();
        $ar_balance_sheet=ArBalanceSheet::all();
        $balance_date = ArBalance::select('created_at', DB::raw('sum(balance) as total_balance'))->groupBy('created_at')->get();
        $all_passport_ids = array();
        $platform_balance = array();

        foreach ($platforms as $platform_res) {
            $array_pasport1 = $platform_res->assign_platforms->pluck('passport_id')->toArray();
            $array_pasport=array_unique($array_pasport1);
            $user_codes = UserCodes::whereIn('passport_id',$array_pasport)->pluck('zds_code')->toArray();
            $ab = ArBalance::whereIn('zds_code',$user_codes)->sum('balance');
//            numbers of riders in a platform with ar_balance
            $rider_qty=count($user_codes);

            $agreed = ArBalance::whereIn('zds_code',$user_codes)->sum('agreed_amount');
            $cash_rec = ArBalance::whereIn('zds_code',$user_codes)->sum('cash_received');
            $dis = ArBalance::whereIn('zds_code',$user_codes)->sum('discount');
            $ded = ArBalance::whereIn('zds_code',$user_codes)->sum('deduction');
            $total_riders_platform = ArBalance::whereIn('zds_code',$user_codes)->get();
            $rider_qty=count($total_riders_platform);
            $ded2 = ArBalanceSheet::whereIn('zds_code',$user_codes)->where('status','1')->sum('balance');
            $total_add = ArBalanceSheet::whereIn('zds_code',$user_codes)->where('status','0')->sum('balance');
            $total_deduction_plat=$ded+$ded2;
            $gamer =array(
                'platform' => $platform_res->name,
                'balance' => $ab,
                'agreed_amount' => $agreed,
                'cash_received' => $cash_rec,
                'discount' => $dis,
                'deduction' => $total_deduction_plat,
                'addition'=>$total_add,
                'rider_qty'=> $rider_qty,
            );
            $platform_balance [] = $gamer;
        }

        $x=$ar_balance->sum('deduction');
        $y=$ar_balance_sheet->where('status','1')->sum('balance');
        $total_deduction=$x+$y;
        return view('admin-panel.admin-dashboard.admin_dashboard' ,compact('passport','sims','assigned_sims','bikes','assigned_bikes',
            'tracking_bikes','agreement','elec_pre_app','tickets','maj_dep','issue_dep','reg_fail','zds_code','driving_license','platforms', 'hiring_pool',
            'cod_uploads','cod','adj','interview_batches','create_interview','last_five_batches','counter_criticle','counter_bad','counter_good',
            'two_counter_criticle','two_counter_bad','two_counter_good','overall_per_two','good_per_two','bad_per_two',
            'cricticle_per_two','overall_per','good_per','bad_per','cricticle_per','data_label','data_label_values','data_label_cash','data_label_values_cash',
            'data_label_bank','data_label_values_bank','data_label_gen','data_label_values_gen','cod_counter','cod_counter1','cod_counter2','cod_counter3'
            ,'cod_counter4','company_assign','assign_platform','nation','employees_by_com','short_list','total_hiring_pending','ar_balance','ar_balance_sheet',
            'balance_date','platform_balance','total_deduction'
        ));
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
    public function show(Request $request)
    {










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


    public function dashboard_show(Request $request)
    {
        $platforms=Platform::all();
        $platform_att2 = array();
        foreach ($platforms as $platform_res) {
            $array_pasport1 = $platform_res->assign_platforms2->pluck('passport_id')->toArray();

            $array_pasport = array_unique($array_pasport1);
            $rider_attendance = RiderAttendance::whereIn('passport_id', $array_pasport)->whereDate('created_at', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();

            $rider_profile = RiderProfile::whereIn('passport_id', $array_pasport)->pluck('passport_id')->toArray();
            $at = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',1)->count();
            $total_leave = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',2)->count();


            $ab = RiderProfile::whereNotIn('passport_id', $rider_profile)->get();
            $total_platform= AssignPlateform::where('status','1')->where('plateform',$platform_res->id)->count();

                $total_absent=$total_platform - $at;
                $yesteday_date=date('Y-m-d',strtotime("-1 days"));
                $total_orders=RiderOrderDetail::where('platform_id',$platform_res->id)->whereDate('start_date_time', '=',
                    $yesteday_date)->count();

            $gamer = array(
                'platform_id' => $platform_res->id,
                'platform' => $platform_res->name,
                'present' => $at,
                'absent' => $total_absent,
                'orders' => $total_orders,
                'total_rider' => $total_platform,
                'leave' => $total_leave,
        );
            $platform_att2[] = $gamer;



            $platform_att = collect($platform_att2)->sortBy('total_rider')->reverse()->toArray();
        }



        return view('admin-panel.admin-dashboard.dashboard_show',compact('platform_att'));

    }
    public function dashboard_show_refresh(){
        $platforms=Platform::all();
        $platform_att2 = array();
        foreach ($platforms as $platform_res) {
            $array_pasport1 = $platform_res->assign_platforms2->pluck('passport_id')->toArray();

            $array_pasport = array_unique($array_pasport1);
            $rider_attendance = RiderAttendance::whereIn('passport_id', $array_pasport)->whereDate('created_at', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();

            $rider_profile = RiderProfile::whereIn('passport_id', $array_pasport)->pluck('passport_id')->toArray();
            $at = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',1)->count();
            $total_leave = RiderAttendance::whereIn('passport_id', $rider_attendance)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',2)->count();


            $ab = RiderProfile::whereNotIn('passport_id', $rider_profile)->get();
            $total_platform= AssignPlateform::where('status','1')->where('plateform',$platform_res->id)->count();

            $total_absent=$total_platform - $at;
            $yesteday_date=date('Y-m-d',strtotime("-1 days"));
            $total_orders=RiderOrderDetail::where('platform_id',$platform_res->id)->whereDate('start_date_time', '=',
                $yesteday_date)->count();

            $gamer = array(
                'platform_id' => $platform_res->id,
                'platform' => $platform_res->name,
                'present' => $at,
                'absent' => $total_absent,
                'orders' => $total_orders,
                'total_rider' => $total_platform,
                'leave' => $total_leave,
            );
            $platform_att2[] = $gamer;



            $platform_att = collect($platform_att2)->sortBy('total_rider')->reverse()->toArray();
        }
        $view = view("admin-panel.admin-dashboard.ajax_dashboard_show", compact('platform_att'))->render();
        return response()->json(['html' => $view]);
    }

}
