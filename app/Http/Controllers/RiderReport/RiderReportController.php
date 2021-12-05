<?php

namespace App\Http\Controllers\RiderReport;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\SimReplacement\SimReplacement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;

class RiderReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|rider-report', ['only' => ['index','search_report_rider']]);
        $this->middleware('role_or_permission:Admin|temporary_bike_to_collect|Temporary-bike-to-collect-roll', ['only' => ['temporary_bike_to_collect','temporary_bike_to_collect_history_gamer']]);
        $this->middleware('role_or_permission:Admin|temporary_sim_to_collect', ['only' => ['temporary_sim_to_collect']]);
    }

    public function index()
    {
        return  view('admin-panel.rider_report.index');
    }

    public function search_report_rider(Request $request)
    {
        if($request->ajax()){

            $total_bikes = AssignBike::where('passport_id','=',$request->passport_id)->distinct()->get(['bike'])->count();
            $total_sim = AssignSim::where('passport_id','=',$request->passport_id)->distinct()->get(['sim'])->count();



        $platforms =  AssignPlateform::where('passport_id','=',$request->passport_id)->orderby('id','desc')->get();

        $total_working_days = 0;
        foreach($platforms as $plat){
            $last_day_date = "";
            $first_day_date = "";
            if($plat->checkin != null){
                $f_dat = explode(" ",$plat->checkin);
                $first_day_date =  $f_dat[0];
            }else{
                $first_day_date = date("Y-m-d");
            }

            if($plat->checkout != null){
                $l_dat = explode(" ",$plat->checkout);
                $last_day_date =  $l_dat[0];
            }else{
                $last_day_date = date("Y-m-d");
            }

            $datetime1= new \DateTime($first_day_date);
            $datetime2= new \DateTime($last_day_date);

            $difference = $datetime1->diff($datetime2);

            $f_days= $difference->days ? $difference->days+1 : '0';
            $total_working_days = $total_working_days+$f_days;

        }

            $telecom = AssignSim::select('*')->groupBy('sim')->where('passport_id','=',$request->passport_id)->orderby('id','desc')->get();
            $bikes = AssignBike::select('*')->groupBy('bike')->where('passport_id','=',$request->passport_id)->orderby('id','desc')->get();

            $view = view("admin-panel.rider_report.report_search_result", compact('bikes','telecom','platforms','total_working_days','total_bikes','total_sim'))->render();
            return response()->json(['html' => $view]);

        }


    }

    public function temporary_bike_to_collect(){

       $bike_replacements =  BikeReplacement::where('status','=','1')->where('type','=','1')->get();

        return view('admin-panel.rider_report.temporary_bike_replacement',compact('bike_replacements'));
    }

    public function temporary_bike_to_collect_history_gamer(){

       $bike_replacements =  BikeReplacement::where('status','=','0')->where('type','=','1')->get();

        return view('admin-panel.rider_report.temporary_bike_replacement_history',compact('bike_replacements'));
    }

    public function ajax_view_remarks_bike_replacement(Request $request){

        if($request->ajax()){
            $type=  $request->type;
            if($type=="1"){
                $id = $request->primary_id;
                $career = BikeReplacement::find($id);
                return $career->replace_remarks;
            }else{

                $id = $request->primary_id;
                $career = BikeReplacement::find($id);
                return $career->replace_taken_remarks;
            }

        }


    }
    public function temporary_sim_to_collect(){

        $sim_replacements =  SimReplacement::where('status','=','1')->where('type','=','1')->get();

        return view('admin-panel.rider_report.temporary_sim_replacement',compact('sim_replacements'));

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
}
