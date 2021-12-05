<?php

namespace App\Http\Controllers\Reports\ContractorReport;

use App\Http\Controllers\FourPl\FourPlController;
use App\Imports\SimBillUpload;
use App\Model\Agreement\Agreement;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Attendance\RiderAttendance;
use App\Model\BikeDetail;
use App\Model\FineUpload\FineUpload;
use App\Model\Master\FourPl;
use App\Model\Platform;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\RiderProfile;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Seeder\Company;
use App\Model\SimBills;
use App\Model\Telecome;
use App\Model\Vehicle_salik;
use App\Model\Vehicle_salik_sheet_account;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractorReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {

        $this->middleware('role_or_permission:Admin|report-contractor_report', ['only' => ['contractor_report']]);

    }
    public function index()
    {
        //
//        dd("comtract repot here");
        $fourpl_names=FourPl::where('status','1')->get();
        $agreemnt=Agreement::all();

        $fourpl_names_all=Agreement::where('four_pl_name','!=',null)->count();


//          $fourpl_names_array = FourPl::pluck('id')->toArray();
//
//
//          $agreement_all=Agreement::wherein('four_pl_name',$fourpl_names_array)->get();
//          dd($agreement_all);
//        dd($fourpl_names);
        return view('admin-panel.reports.contractor_report.index',compact('fourpl_names','agreemnt','fourpl_names_all'));
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

        $agreement=Agreement::where('four_pl_name',$id)->get();
        return view('admin-panel.reports.contractor_report.contractor_detail',compact('agreement'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
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
    public  function contract_report_show(request $request){
        $id = $request->id;

        $platform_assign=AssignPlateform::where('passport_id',$id)->get();
        $platform_bike=AssignBike::where('passport_id',$id)->get();
        $platform_sim=AssignSim::where('passport_id',$id)->get();

        $view = view("admin-panel.reports.contractor_report.ajax_get_assign_detail",compact('platform_assign','platform_sim','platform_bike'))->render();
        return response()->json(['html' => $view]);

    }

    public function contractor_all(){
        $fourpl_names_array = FourPl::pluck('id')->toArray();
        $agreement=Agreement::wherein('four_pl_name',$fourpl_names_array)->get();
        return view('admin-panel.reports.contractor_report.contractor_all',compact('agreement'));
    }
    public  function contractor_bike_reporter(){
        $fourpl_names_array = FourPl::pluck('id')->toArray();
        $agreement=Agreement::wherein('four_pl_name',$fourpl_names_array)->get();

        return view('admin-panel.reports.contractor_report.four_pl_bike_report',compact('fourpl_names','agreement','fourpl_names_all'));
    }



    //fourpl contractor

    public  function contract_report_bike_show(request $request){
        $id = $request->id;

        $platform_bike=AssignBike::where('bike',$id)->get();
        $view = view("admin-panel.reports.contractor_report.ajax_get_assign_detail",compact('platform_assign','platform_sim','platform_bike'))->render();
        return response()->json(['html' => $view]);

    }

    public function contractor_bike_report_show(request $request){
        $id= $request->id;
        $platform_bike=AssignBike::where('bike',$id)->get();

        $view = view("admin-panel.reports.contractor_report.ajax_get_bike_assign_detail",compact('platform_assign','platform_sim','platform_bike'))->render();
        return response()->json(['html' => $view]);

    }

    //sim-----------------------



    public  function contractor_sim_reporter(){
        $fourpl_names_array = FourPl::pluck('id')->toArray();
        $agreement=Agreement::wherein('four_pl_name',$fourpl_names_array)->get();
        return view('admin-panel.reports.contractor_report.four_pl_sim_report',compact('fourpl_names','agreement','fourpl_names_all'));
    }

    public  function contractor_sim_report_show(request $request){
        $id = $request->id;
        $sim_deail=AssignSim::where('sim',$id)->get();
        $view = view("admin-panel.reports.contractor_report.ajax_get_sim_assign_detail",compact('platform_assign','sim_deail','platform_bike'))->render();
        return response()->json(['html' => $view]);

    }

    public function contractor_salik(){

        $companies = FourPl::all();

        return view('admin-panel.reports.contractor_report.contracter_salik',compact('fourpl_names','companies','agreement','fourpl_names_all'));

    }


    public function get_4pl_salik_detail(Request $request){
//        dd($request->all_com);

    if ($request->all_com=='1'){

        if($request->ajax()) {

            if(!empty($request->from_date)){
//                $company_id = $request->company_id;

                $company_id=FourPl::pluck('id')->toArray();

                $agreement_pass_ids=Agreement::whereIn('four_pl_name',$company_id)->pluck('passport_id')->toArray();
                $bikes=AssignBike::whereIn('passport_id',$agreement_pass_ids)->where('status','1')->pluck('bike')->toArray();
                $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();



                $data = Vehicle_salik::whereIn('plate',$bike_detail)->whereBetween('trip_date', [$request->from_date, $request->end_date])->orderby('trip_date','desc')->get();

            }else{
                $data = Vehicle_salik::orderby('id','desc')->get();
            }

        }

    }
    else {
        if ($request->ajax()) {

            if (!empty($request->from_date)) {
                $company_id = $request->company_id;
                $agreement_pass_ids = Agreement::where('four_pl_name', $company_id)->pluck('passport_id')->toArray();
                $bikes = AssignBike::whereIn('passport_id', $agreement_pass_ids)->where('status', '1')->pluck('bike')->toArray();
                $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();


                $data = Vehicle_salik::whereIn('plate', $bike_detail)->whereBetween('trip_date', [$request->from_date, $request->end_date])->orderby('trip_date', 'desc')->get();

            } else {
                $data = Vehicle_salik::orderby('id', 'desc')->get();
            }

        }
    }




        $view = view("admin-panel.reports.contractor_report.ajax_salik_detail",compact('data','bikes_detail'))->render();
        return response()->json(['html' => $view]);



    }



    public function salikget_salik_total_amount_ajax(Request $request){


        if ($request->all_com=='1'){

                $company_id=FourPl::pluck('id')->toArray();
                $agreement_pass_ids = Agreement::where('four_pl_name', $company_id)->pluck('passport_id')->toArray();
                $bikes = AssignBike::whereIn('passport_id', $agreement_pass_ids)->where('status', '1')->pluck('bike')->toArray();
               $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();


                $data = Vehicle_salik::whereIn('plate', $bike_detail)->whereBetween('trip_date', [$request->start_date, $request->end_date])->orderby('trip_date', 'desc')->get();


        }
        else {


                if (!empty($request->from_date)) {
                    $company_id = $request->company_id;
                    $agreement_pass_ids = Agreement::where('four_pl_name', $company_id)->pluck('passport_id')->toArray();
                    $bikes = AssignBike::whereIn('passport_id', $agreement_pass_ids)->where('status', '1')->pluck('bike')->toArray();
                    $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();


                    $data = Vehicle_salik::whereIn('plate', $bike_detail)->whereBetween('trip_date', [$request->start_date, $request->end_date])->orderby('trip_date', 'desc')->get();

                }

        }


        $array_to_send = array(
            'total_amount' => $data->sum('amount') ? number_format($data->sum('amount'), 2) : 0,
            'total_rider' => $data->count() ? $data->count() : 0,
        );
        echo json_encode($array_to_send);
        exit;




    }






    public function contractor_fine(){

        $companies = FourPl::all();

        return view('admin-panel.reports.contractor_report.contractor_fine',compact('fourpl_names','companies','agreement','fourpl_names_all'));

    }
    public function fineget_fine_total_amount_ajax_4pl(Request $request){


        if ($request->all_com=='1'){
            $company_id=FourPl::pluck('id')->toArray();

            $agreement_pass_ids=Agreement::whereIn('four_pl_name',$company_id)->pluck('passport_id')->toArray();

            $bikes=AssignBike::whereIn('passport_id',$agreement_pass_ids)->where('status','1')->pluck('bike')->toArray();
            $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();


            $data = FineUpload::whereIn('plate_number',$bike_detail)
                ->whereBetween('ticket_date', [$request->start_date, $request->end_date])
                ->orderby('ticket_date','desc')->get();
        }
        else {

            $company_id = $request->company_id;


            $agreement_pass_ids = Agreement::where('four_pl_name', $company_id)->pluck('passport_id')->toArray();
            $bikes = AssignBike::whereIn('passport_id', $agreement_pass_ids)->where('status', '1')->pluck('bike')->toArray();
            $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();


            $data = FineUpload::whereIn('plate_number', $bike_detail)
                ->whereBetween('ticket_date', [$request->start_date, $request->end_date])
                ->orderby('ticket_date', 'desc')->get();
        }

        $array_to_send = array(
            'total_amount' => $data->sum('ticket_fee') ? number_format($data->sum('ticket_fee'), 2) : 0,
            'total_rider' => $data->count() ? $data->count() : 0,
        );

        echo json_encode($array_to_send);
        exit;




    }


    public function get_4pl_fine_detail(Request $request){

        if ($request->all_com=='1'){
            $company_id=FourPl::pluck('id')->toArray();
            $agreement_pass_ids=Agreement::whereIn('four_pl_name',$company_id)->pluck('passport_id')->toArray();
            $bikes=AssignBike::whereIn('passport_id',$agreement_pass_ids)->where('status','1')->pluck('bike')->toArray();
            $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();


            $data = FineUpload::whereIn('plate_number',$bike_detail)
                ->whereBetween('ticket_date', [$request->from_date, $request->end_date])
                ->orderby('ticket_date','desc')->get();
        }
        else{
            $company_id = $request->company_id;
            $agreement_pass_ids=Agreement::where('four_pl_name',$company_id)->pluck('passport_id')->toArray();
            $bikes=AssignBike::whereIn('passport_id',$agreement_pass_ids)->where('status','1')->pluck('bike')->toArray();
            $bike_detail=BikeDetail::whereIn('id',$bikes)->pluck('plate_no')->toArray();
            $data = FineUpload::whereIn('plate_number',$bike_detail)
                ->whereBetween('ticket_date', [$request->from_date, $request->end_date])
                ->orderby('ticket_date','desc')->get();
        }


        $view = view("admin-panel.reports.contractor_report.ajax_fine_detail",compact('data'))->render();
        return response()->json(['html' => $view]);



    }


    //Contractor sim
    public function contractor_sim(){

        $companies = FourPl::all();

        return view('admin-panel.reports.contractor_report.contractor_sim',compact('fourpl_names','companies','agreement','fourpl_names_all'));

    }
    public function simget_sim_total_amount_ajax_4pl(Request $request){


        if ($request->all_com=='1') {
            $company_id=FourPl::pluck('id')->toArray();
            $agreement_pass_ids=Agreement::whereIn('four_pl_name',$company_id)->pluck('passport_id')->toArray();
            $sim=AssignSim::whereIn('passport_id',$agreement_pass_ids)->where('status','1')->pluck('sim')->toArray();
            $telecom=Telecome::whereIn('id',$sim)->pluck('account_number')->toArray();
            $data = SimBills::whereIn('account_number',$telecom)->whereBetween('invoice_date', [$request->start_date, $request->end_date])->orderby('invoice_date','desc')->get();


        }
        else {

            $company_id = $request->company_id;


            $agreement_pass_ids = Agreement::where('four_pl_name', $company_id)->pluck('passport_id')->toArray();
            $sim = AssignSim::whereIn('passport_id', $agreement_pass_ids)->where('status', '1')->pluck('sim')->toArray();


            $telecom = Telecome::whereIn('id', $sim)->pluck('account_number')->toArray();


            $data = SimBills::whereIn('account_number', $telecom)->whereBetween('invoice_date', [$request->start_date, $request->end_date])->orderby('invoice_date', 'desc')->get();
        }

        $array_to_send = array(
            'total_amount' => $data->sum('billed_amount') ? number_format($data->sum('billed_amount'), 2) : 0,
            'total_rider' => $data->count() ? $data->count() : 0,
        );

        echo json_encode($array_to_send);
        exit;




    }


    public function get_4pl_sim_detail(Request $request){
        if ($request->all_com=='1') {
            $company_id=FourPl::pluck('id')->toArray();

            $agreement_pass_ids=Agreement::whereIn('four_pl_name',$company_id)->pluck('passport_id')->toArray();

            $sim=AssignSim::whereIn('passport_id',$agreement_pass_ids)->where('status','1')->pluck('sim')->toArray();
            $telecom=Telecome::whereIn('id',$sim)->pluck('account_number')->toArray();


            $data = SimBills::whereIn('account_number',$telecom)->whereBetween('invoice_date', [$request->from_date, $request->end_date])->orderby('invoice_date','desc')->get();

        }
        else {
            $company_id = $request->company_id;

            $agreement_pass_ids = Agreement::where('four_pl_name', $company_id)->pluck('passport_id')->toArray();

            $sim = AssignSim::whereIn('passport_id', $agreement_pass_ids)->where('status', '1')->pluck('sim')->toArray();
            $telecom = Telecome::whereIn('id', $sim)->pluck('account_number')->toArray();


            $data = SimBills::whereIn('account_number', $telecom)->whereBetween('invoice_date', [$request->from_date, $request->end_date])->orderby('invoice_date', 'desc')->get();
        }

            $view = view("admin-panel.reports.contractor_report.ajax_sim_detail", compact('data'))->render();
            return response()->json(['html' => $view]);



    }

    public function vendor_dashboard(){
        return view('admin-panel.reports.contractor_report.vendor_dashboard.index');
    }


    public function get_vendor_attenance(Request $request){


        if($request->ajax()){
            $user_platforms=Auth::user()->user_platform_id;
            $platforms=Platform::whereIn('id',$user_platforms)->get();
            $platform_att2 = array();
            foreach ($platforms as $platform_res) {
                $company_id=FourPl::where('status','1')->pluck('id')->toArray();
                $agreement_pass_ids=Agreement::whereIn('four_pl_name',$company_id)->pluck('passport_id')->toArray();
                //all the four pl riders passport ids
                $array_pasport1 = $platform_res->assign_platforms2->pluck('passport_id')->toArray();
                $array_pasport = array_unique($array_pasport1);


                $rider_attendance = RiderAttendance::whereIn('passport_id', $agreement_pass_ids)->whereDate('created_at', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
                $rider_profile = RiderProfile::whereIn('passport_id', $agreement_pass_ids)->pluck('passport_id')->toArray();

                $at = RiderAttendance::whereIn('passport_id', $agreement_pass_ids)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',1)->get();
                $total_leave = RiderAttendance::whereIn('passport_id', $agreement_pass_ids)->whereDate('created_at', '=', Carbon::today()->toDateString())->where('status',2)->count();

                $ab = RiderProfile::whereNotIn('passport_id', $rider_profile)->get();

                $total_platform= AssignPlateform::where('plateform',$platform_res->id)->whereIn('passport_id',$agreement_pass_ids)->where('status','1')->count();
                $total_absent=$total_platform- count($at);
                $yesteday_date=date('Y-m-d H:i:s',strtotime("-1 days"));

                $now_time = Carbon::parse($request->start_date)->startOfDay();
                $end_time = Carbon::parse($request->end_date)->endOfDay();


                $total_orders = RiderOrderDetail::where('platform_id','=','15')
                    ->whereIn('passport_id', $agreement_pass_ids)
                    ->whereDate('start_date_time', '>=', $now_time)
                    ->whereDate('start_date_time', '<=', $end_time)
                    ->sum('total_order');


                // $total_orders=RiderOrderDetail::where('platform_id','15')->whereDate('start_date_time', '=', $yesteday_date)->get();

                // $order_count=RiderOrderDetail::where('platform_id','15')->where('start_date_time','2021-03-11')->get();
                // dd($total_orders);

                $gamer = array(
                    'platform_id' => $platform_res->id,
                    'platform' => $platform_res->name,
                    'present' => count($at),
                    'absent' => $total_absent,
                    'orders' => $total_orders,
                    'total_rider' => $total_platform,
                    'leave' => $total_leave,
                );
                $platform_att2[] = $gamer;
                $platform_att = collect($platform_att2)->sortBy('total_rider')->reverse()->toArray();

            }


            $view = view("admin-panel.reports.contractor_report.vendor_dashboard.ajax_files.get_ajax_attendance", compact('platform_att','platforms'))->render();
            return response()->json(['html' => $view]);
        }




    }

    public function get_vendor_companies(){
        $fourpl_names=FourPl::where('status','=','1')->get();
        $agreemnt=Agreement::all();
        $view = view("admin-panel.reports.contractor_report.vendor_dashboard.ajax_files.get_ajax_companies", compact('agreemnt','fourpl_names'))->render();
        return response()->json(['html' => $view]);
    }


    public  function get_vendor_bike(){
        $fourpl_names_array = FourPl::where('status','1')->pluck('id')->toArray();
        $agreement=Agreement::wherein('four_pl_name',$fourpl_names_array)->get();
        $view = view("admin-panel.reports.contractor_report.vendor_dashboard.ajax_files.get_ajax_bikes", compact('fourpl_names','agreement','fourpl_names_all'))->render();
        return response()->json(['html' => $view]);

    }


    public  function get_vendor_sim(){
        $fourpl_names_array = FourPl::where('status','1')->pluck('id')->toArray();
        $agreement=Agreement::whereIn('four_pl_name',$fourpl_names_array)->get();
        $view = view("admin-panel.reports.contractor_report.vendor_dashboard.ajax_files.get_ajax_sim", compact('fourpl_names','agreement','fourpl_names_all'))->render();
        return response()->json(['html' => $view]);

    }

    // public  function  get_vendor_sim(){                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             (){
    //     $fourpl_names_array = FourPl::pluck('id')->toArray();
    //     $agreement=Agreement::whereIn('four_pl_name',$fourpl_names_array)->get();
    //     $view = view("admin-panel.reports.contractor_report.vendor_dashboard.ajax_files.get_ajax_sim", compact('fourpl_names','agreement','fourpl_names_all'))->render();
    //     return response()->json(['html' => $view]);
    // }



    public  function get_vendor_dc(){
        $company_id=FourPl::pluck('id')->toArray();
        $agreement_pass_ids=Agreement::whereIn('four_pl_name',$company_id)->pluck('passport_id')->toArray();


        $user_info = AssignToDc::select('assign_to_dcs.*',DB::raw('count(*) as total'))
        ->whereIn('rider_passport_id',$agreement_pass_ids)
        ->leftjoin('users', 'assign_to_dcs.user_id', '=', 'users.id')
        ->groupBy('user_id')
        ->get();



        $view = view("admin-panel.reports.contractor_report.vendor_dashboard.ajax_files.get_ajax_dc", compact('user_info'))->render();
        return response()->json(['html' => $view]);
// dd($user_info);
//         $dcs_array = array();

//         foreach($user_info as $info){

//             // $dcs=AssignToDc::whereIn('rider_passport_id',$agreement_pass_ids)->where('user_id',$info->user_id)->get();
//             $user_info1 = DB::table('assign_to_dcs')
//             ->select('user_id', DB::raw('count(*) as total'))
//             ->whereIn('rider_passport_id',$agreement_pass_ids)
//             ->where('user_id',$info->user_id)
//             ->groupBy('user_id')
//             ->get();


//             // $gamer = array(
//             //     'dc_name' => $dcs->user_detail->name,
//             //     'no_of_riders' => count($dcs),
//             // );
//             // $dcs_array[]= $gamer;
//         }
//         dd($user_info1);






    }





}
