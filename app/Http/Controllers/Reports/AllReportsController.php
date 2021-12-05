<?php

namespace App\Http\Controllers\Reports;

use App\Model\RiderFuel\RiderFuel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AllReportsController extends Controller
{
    //fuel Reports-----------------------------------
    public  function fuel_report(){



        return view('admin-panel.all_reports.fuel_report');
    }

    public function  daily_fuel_report( Request  $request){
       $report_by= $request->input('report_by');
        if($report_by=='1') {

            $daily_date = $request->input('daily_date');
            $fuel_daily_report_pending = RiderFuel::where('status', '0')->whereDate('created_at', $daily_date)->get();
            $fuel_daily_report_approve = RiderFuel::where('status', '1')->whereDate('created_at', $daily_date)->get();
            $fuel_daily_report_rejected = RiderFuel::where('status', '2')->whereDate('created_at', $daily_date)->get();
        }
        elseif ($report_by=='2'){

            $week0= date("Y-m-d");
            $current_date = strtotime(date('y-m-d'));
            $week1 = date("Y-m-d", strtotime("-1 week",$current_date ));

            $week2_date = strtotime($week1);
            $week2 = date("Y-m-d", strtotime("-1 week",$week2_date));

            $week3_date = strtotime($week2);
            $week3 = date("Y-m-d", strtotime("-1 week",$week3_date));
        }
        return view('admin-panel.all_reports.fuel_report', compact('fuel_daily_report_pending','fuel_daily_report_approve','fuel_daily_report_rejected','week0','week1','week2','week3'));
    }

    public  function weekly_fuel_report(){

        $week0= date("Y-m-d");
        $current_date = strtotime(date('y-m-d'));
        $week1 = date("Y-m-d", strtotime("-1 week",$current_date ));

        $week2_date = strtotime($week1);
        $week2 = date("Y-m-d", strtotime("-1 week",$week2_date));

        $week3_date = strtotime($week2);
        $week3 = date("Y-m-d", strtotime("-1 week",$week3_date));

        return view('admin-panel.all_reports.fuel_report',compact('week0','week1','week2','week3'));

    }

    //fuel Report ends here------------------------------------


}
