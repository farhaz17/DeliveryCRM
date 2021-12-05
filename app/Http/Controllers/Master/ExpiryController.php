<?php

namespace App\Http\Controllers\Master;

use App\Http\Middleware\Passport;
use App\Model\BikeDetail;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Emirates_id_cards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpiryController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|master-expiry', ['only' => ['index','edit','destroy','update','store']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $years_months = array(
            '0'=>'',
            '01'=> 'January',
            '02'=>'Feburary',
            '03'=>'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' =>'September',
            '10' => 'October',
            '11' =>  'November',
            '12' => 'December',
        );

//        dd($years_months);


        $time = strtotime(date('y-m-d'));

        $final = date("m", strtotime("+1 month",$time ));
        $month = date("m", strtotime("+0 month",$time ));

        $two = date("m", strtotime("+2 month",$time ));
        $three = date("m", strtotime("+3 month",$time ));
        $four = date("m", strtotime("+4 month",$time ));
        $five = date("m", strtotime("+5 month",$time ));



       $current_month = $years_months[$month];
       $first_month = $years_months[$final];
       $second_month = $years_months[$two];
       $third_month = $years_months[$three];
       $fourth_month = $years_months[$four];
       $fifth_month = $years_months[$five];
        $current = date("Y-m", strtotime("+0 month",$time ));
        $first_month_date = date("Y-m", strtotime("+1 month",$time ));
        $second_month_date = date("Y-m", strtotime("+2 month",$time ));
        $third_month_date = date("Y-m", strtotime("+3 month",$time ));
        $fourth_month_date = date("Y-m", strtotime("+4 month",$time ));
        $fifth_month_date = date("Y-m", strtotime("+5 month",$time ));

        //current  month
        $passport_expiry=\App\Model\Passport\Passport::where("date_expiry",'like','%'.$current.'%')->get();
        $driving_licese_expiry=DrivingLicense::where("expire_date",'like','%'.$current.'%')->get();
        $bike_expiry=BikeDetail::where("expiry_date",'like','%'.$current.'%')->get();
        $emirates_id_expiry=Emirates_id_cards::where("expire_date",'like','%'.$current.'%')->get();

        //2nd  month

        $passport_first_month=\App\Model\Passport\Passport::where("date_expiry",'like','%'.$first_month_date.'%')->get();
        $driving_first_month=DrivingLicense::where("expire_date",'like','%'.$first_month_date.'%')->get();
        $bike_first_month=BikeDetail::where("expiry_date",'like','%'.$first_month_date.'%')->get();
        $emirates_id_first_month=Emirates_id_cards::where("expire_date",'like','%'.$first_month_date.'%')->get();


        //3rd month

        $passport_sec_month=\App\Model\Passport\Passport::where("date_expiry",'like','%'.$second_month_date.'%')->get();
        $driving_sec_month=DrivingLicense::where("expire_date",'like','%'.$second_month_date.'%')->get();
        $bike_sec_month=BikeDetail::where("expiry_date",'like','%'.$second_month_date.'%')->get();
        $emirates_id_sec_month=Emirates_id_cards::where("expire_date",'like','%'.$second_month_date.'%')->get();
//4th
        $passport_third_month=\App\Model\Passport\Passport::where("date_expiry",'like','%'.$third_month_date.'%')->get();
        $driving_third_month=DrivingLicense::where("expire_date",'like','%'.$third_month_date.'%')->get();
        $bike_third_month=BikeDetail::where("expiry_date",'like','%'.$third_month_date.'%')->get();
        $emirates_third_month=Emirates_id_cards::where("expire_date",'like','%'.$third_month_date.'%')->get();

//        5th

        $passport_fourth_month=\App\Model\Passport\Passport::where("date_expiry",'like','%'.$fourth_month_date.'%')->get();
        $driving_fourth_month=DrivingLicense::where("expire_date",'like','%'.$fourth_month_date.'%')->get();
        $bike_fourth_month=BikeDetail::where("expiry_date",'like','%'.$fourth_month_date.'%')->get();
        $emirates_fourth_month=Emirates_id_cards::where("expire_date",'like','%'.$fourth_month_date.'%')->get();


//6th month from the first
        $passport_fifth_month=\App\Model\Passport\Passport::where("date_expiry",'like','%'.$fifth_month_date.'%')->get();
        $driving_fifth_month=DrivingLicense::where("expire_date",'like','%'.$fifth_month_date.'%')->get();
        $bike_fifth_month=BikeDetail::where("expiry_date",'like','%'.$fifth_month_date.'%')->get();
        $emirates_fifth_month=Emirates_id_cards::where("expire_date",'like','%'.$fifth_month_date.'%')->get();













        return view('admin-panel.masters.expiry',
            compact("current_month","first_month","second_month","third_month","fourth_month","fifth_month",
        "passport_expiry","driving_licese_expiry","bike_expiry","emirates_id_expiry",
        "passport_first_month","driving_first_month","bike_first_month","emirates_id_first_month",
        "passport_sec_month","driving_sec_month","bike_sec_month","emirates_id_sec_month",
        "passport_third_month","driving_third_month","bike_third_month","emirates_third_month",
        "passport_fourth_month","driving_fourth_month","bike_fourth_month","emirates_fourth_month",
        "passport_fifth_month","driving_fifth_month","bike_fifth_month","emirates_fifth_month"
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

//
//$month = date('m');
//
//
////current month calculation
//if ($month=='01'){
//    $current_month="January";
//    $next1="February";
//    $next2="March";
//    $next3="April";
//    $next4="May";
//    $next5="June";
//}
//elseif ($month=='02'){
//    $current_month="February";
//
//    $next1="March";
//    $next2="April";
//    $next3="May";
//    $next4="May";
//    $next5="June";
//}
//elseif ($month=='03'){
//    $current_month="March";
//
//    $next1="April";
//    $next2="May";
//    $next3="June";
//    $next4="July";
//    $next5="August";
//}
//elseif ($month=='04'){
//    $current_month="April";
//
//    $next1="May";
//    $next2="June";
//    $next3="July";
//    $next4="August";
//    $next5="September";
//}
//elseif ($month=='05'){
//    $current_month="May";
//
//    $next1="June";
//    $next2="July";
//    $next3="August";
//    $next4="September";
//    $next5="October";
//}
//elseif ($month=='06'){
//    $current_month="June";
//
//    $next1="July";
//    $next2="August";
//    $next3="September";
//    $next4="October";
//    $next5="November";
//}
//elseif ($month=='07'){
//    $current_month="July";
//
//    $next1="August";
//    $next2="September";
//    $next3="October";
//    $next4="November";
//    $next5="December";
//}
//elseif ($month=='08'){
//    $current_month="August";
//
//    $next1="September";
//    $next2="October";
//    $next3="November";
//    $next4="December";
//    $next5="January";
//}
//elseif ($month=='09'){
//    $current_month="September";
//
//    $next1="October";
//    $next2="November";
//    $next3="December";
//    $next4="January";
//    $next5="February";
//}
//elseif ($month=='10'){
//    $current_month="October";
//
//    $next1="November";
//    $next2="December";
//    $next3="January";
//    $next4="February";
//    $next5="March";
//}
//elseif ($month=='11'){
//    $current_month="November";
//
//
//    $next1="December";
//    $next2="January";
//    $next3="February";
//    $next4="March";
//    $next5="April";
//}
//else {
//
//    $current_month = "December";
//
//    $next1="January";
//    $next2="February";
//    $next3="March";
//    $next4="April";
//    $next5="May";
//
//}
//
//
//
//
//
////       if ($next1 > '12'){
////           $x=17-12;
////       }
////       dd($x);

