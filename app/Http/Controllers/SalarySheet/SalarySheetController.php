<?php

namespace App\Http\Controllers\SalarySheet;

use App\Imports\CareemLimoSalarySheet;
use App\Imports\DeliverooPerformanceImport;
use App\Model\Assign\AssignSim;
use App\Model\Careem;
use App\Model\Performance\DeliverooPerformance;
use App\Model\Platform;
use App\Model\SalarySheet\DeliverooSlaraySheet;
use App\Model\SalarySheet\SalarySheetPath;
use App\Model\SalarySheet\TalabatSalarySheet;
use App\Model\SalarySheet\UberLimo;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class SalarySheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $platform= Platform::all();


        $user_platforms=Auth::user()->user_platform_id;

        $platform=Platform::whereIn('id',$user_platforms)->get();

        $talabat_sheet=DB::table('talabat_salary_sheets')->orderBy('sheet_id', 'desc')->first();
        $del_sheet=DB::table('deliveroo_slaray_sheets')->orderBy('sheet_id', 'desc')->first();
        $careem_sheet=DB::table('careem')->orderBy('sheet_id', 'desc')->first();
        $uber_sheet=DB::table('uber_limos')->orderBy('sheet_id', 'desc')->first();
        $careem_limo_sheet=DB::table('careem_limo_salaries')->orderBy('sheet_id', 'desc')->first();


        return view('admin-panel.salary_sheet.index',compact('platform','talabat_sheet','talabat_salary_sheet','total_talabat_sheet',
            'salary_path','talabat_file','del_file','del_sheet','careem_file','careem_sheet','uber_sheet','uber_file','careem_limo_file','careem_limo_sheet'));
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


    public function import(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx,'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->route('salary_sheet')->with($message);
        } else {
            //getting date ranges


            $from=$request->date_from;
            $to=$request->date_to;
            $platform=$request->platform_id;

            if ($platform=='15') {
                $date_from = Carbon::createFromFormat('Y-m-d', $from);
                $sub_days = 1;
                $date_from = $date_from->subDays($sub_days);
                $res_from = $date_from->format('Y-m-d');
                $date_to = Carbon::createFromFormat('Y-m-d', $to);
                $daysToAdd = 3;
                $date_to = $date_to->addDays($daysToAdd);
                $res_to = $date_to->format('Y-m-d');
                $tal = SalarySheetPath::where('date_from', '>=', $res_from)
                    ->where('date_to', '<=', $res_to)->where('platform_id','15')->first();
                if ($tal == null) {
                    $path_saved = "";
                    $last_id = "";

                    $talabat_sheet_id = IdGenerator::generate(['table' => 'talabat_salary_sheets', 'field' => 'sheet_id', 'length' => 7, 'prefix' => 'TAL1']);
                    if (!file_exists('../public/assets/upload/talabat_salary/')) {
                        mkdir('../public/assets/upload/talabat_salary/', 0777, true);
                    }
                    if (!empty($_FILES['select_file']['name'])) {
                        $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                        $file_name = $talabat_sheet_id.'-'.$from."_".$to. $request->date .'-orignal'."." . $ext;
                        move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/talabat_salary/' . $file_name);
                        $file_path = 'assets/upload/talabat_salary/' . $file_name;
                        $obj = new SalarySheetPath();
                        $obj->path = $file_path;
                        $obj->platform_id = $platform;
                        $obj->date_from = $from;
                        $obj->date_to = $to;
                        $obj->sheet_id = $talabat_sheet_id;
                        $obj->save();
                        $path_saved = public_path($file_path);
                        $last_id = $obj->id;
                    }



                    Excel::import(new \App\Imports\TalabatSalarySheet($last_id,$talabat_sheet_id), $path_saved);

                    $message = [
                        'message' => 'Talabat Sheet Uploaded Successfully',
                        'alert-type' => 'success'
                    ];

                    return redirect()->route("salary_sheet")->with($message);
                } else {
                    $message = [
                        'message' => 'Talabat Salary Sheet These Dates Already Uploaded',
                        'alert-type' => 'error'
                    ];

                    return redirect()->route("salary_sheet")->with($message);
                }


            }
            elseif($platform=='4'){
                //delivero here

                $date_from = Carbon::createFromFormat('Y-m-d', $from);
                $sub_days = 1;
                $date_from = $date_from->subDays($sub_days);
                $res_from = $date_from->format('Y-m-d');
                $date_to = Carbon::createFromFormat('Y-m-d', $to);
                $daysToAdd = 3;
                $date_to = $date_to->addDays($daysToAdd);
                $res_to = $date_to->format('Y-m-d');
                $tal = SalarySheetPath::where('date_from', '>=', $res_from)
                    ->where('date_to', '<=', $res_to)->where('platform_id','15')->first();

                if ($tal == null) {
                    $path_saved = "";
                    $last_id = "";
                    $del_sheet_id = IdGenerator::generate(['table' => 'deliveroo_slaray_sheets', 'field' => 'sheet_id', 'length' => 7, 'prefix' => 'DEL1']);

                    if (!file_exists('../public/assets/upload/deliveroo_salary/')) {
                        mkdir('../public/assets/upload/deliveroo_salary/', 0777, true);
                    }
                    if (!empty($_FILES['select_file']['name'])) {
                        $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                        $file_name = $del_sheet_id.'-'.$from."_".$to. $request->date .'-orignal'."." . $ext;

                        move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/deliveroo_salary/' . $file_name);
                        $file_path = 'assets/upload/deliveroo_salary/' . $file_name;
                        $obj = new SalarySheetPath();
                        $obj->path = $file_path;
                        $obj->platform_id = $platform;
                        $obj->date_from = $from;
                        $obj->date_to = $to;
                        $obj->sheet_id = $del_sheet_id;
                        $obj->save();
                        $path_saved = public_path($file_path);
                        $last_id = $obj->id;
                    }


                    Excel::import(new \App\Imports\DeliverooSalarySheet($last_id,$del_sheet_id), $path_saved);


                    $message = [
                        'message' => 'Deliveroo Sheet Uploaded Successfully',
                        'alert-type' => 'success'
                    ];

                    return redirect()->route("salary_sheet")->with($message);
                } else {
                    $message = [
                        'message' => 'Deliveroo Salary Sheet These Dates Already Uploaded',
                        'alert-type' => 'error'
                    ];

                    return redirect()->route("salary_sheet")->with($message);
                }

            }

            elseif($platform=='1'){
                //delivero here
                $date_from = Carbon::createFromFormat('Y-m-d', $from);
                $sub_days = 1;
                $date_from = $date_from->subDays($sub_days);
                $res_from = $date_from->format('Y-m-d');
                $date_to = Carbon::createFromFormat('Y-m-d', $to);
                $daysToAdd = 3;
                $date_to = $date_to->addDays($daysToAdd);
                $res_to = $date_to->format('Y-m-d');
                $tal = SalarySheetPath::where('date_from', '>=', $res_from)
                    ->where('date_to', '<=', $res_to)->where('platform_id','1')->first();
                if ($tal == null) {
                    $path_saved = "";
                    $last_id = "";
                    $careem_sheet_id = IdGenerator::generate(['table' => 'careem', 'field' => 'sheet_id', 'length' => 7, 'prefix' => 'CAR1']);
                    if (!file_exists('../public/assets/upload/careem/')) {
                        mkdir('../public/assets/upload/careem/', 0777, true);
                    }
                    if (!empty($_FILES['select_file']['name'])) {
                        $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                        $file_name = $careem_sheet_id.'-'.$from."_".$to. $request->date .'-orignal'."." . $ext;
                        move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/careem/' . $file_name);
                        $file_path = 'assets/upload/careem/' . $file_name;
                        $obj = new SalarySheetPath();
                        $obj->path = $file_path;
                        $obj->platform_id = $platform;
                        $obj->date_from = $from;
                        $obj->date_to = $to;
                        $obj->sheet_id = $careem_sheet_id;
                        $obj->save();
                        $path_saved = public_path($file_path);
                        $last_id = $obj->id;
                    }
                    Excel::import(new \App\Imports\CareemImport($last_id,$careem_sheet_id), $path_saved);
                    $message = [
                        'message' => 'Creem Sheet Uploaded Successfully',
                        'alert-type' => 'success'
                    ];
                    return redirect()->route("salary_sheet")->with($message);
                } else {
                    $message = [
                        'message' => 'Careem Salary Sheet These Dates Already Uploaded',
                        'alert-type' => 'error'
                    ];
                    return redirect()->route("salary_sheet")->with($message);
                }
            }
            elseif($platform=='32'){
                //delivero here
                $date_from = Carbon::createFromFormat('Y-m-d', $from);
                $sub_days = 1;
                $date_from = $date_from->subDays($sub_days);
                $res_from = $date_from->format('Y-m-d');
                $date_to = Carbon::createFromFormat('Y-m-d', $to);
                $daysToAdd = 3;
                $date_to = $date_to->addDays($daysToAdd);
                $res_to = $date_to->format('Y-m-d');
                    $tal = SalarySheetPath::where('date_from', '>=', $res_from)
                    ->where('date_to', '<=', $res_to)->where('platform_id','32')->first();
                if ($tal == null) {
                    $path_saved = "";
                    $last_id = "";
                    $careem_limo_sheet_id = IdGenerator::generate(['table' => 'careem_limo_salaries', 'field' => 'sheet_id', 'length' => 7, 'prefix' => 'CRL1']);
                    if (!file_exists('../public/assets/upload/careem_limo_salary/')) {
                        mkdir('../public/assets/upload/careem_limo_salary/', 0777, true);
                    }
                    if (!empty($_FILES['select_file']['name'])) {
                        $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                        $file_name = $careem_limo_sheet_id.'-'.$from."_".$to. $request->date .'-orignal'."." . $ext;
                        move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/careem_limo_salary/' . $file_name);
                        $file_path = 'assets/upload/careem_limo_salary/' . $file_name;
                        $obj = new SalarySheetPath();
                        $obj->path = $file_path;
                        $obj->platform_id = $platform;
                        $obj->date_from = $from;
                        $obj->date_to = $to;
                        $obj->sheet_id = $careem_limo_sheet_id;
                        $obj->save();
                        $path_saved = public_path($file_path);
                        $last_id = $obj->id;
                    }
                    $careem_limo_sheet_id = IdGenerator::generate(['table' => 'careem_limo_salaries', 'field' => 'sheet_id', 'length' => 7, 'prefix' => 'CRL1']);
                    Excel::import(new \App\Imports\CareemLimoSalarySheet($last_id,$careem_limo_sheet_id), $path_saved);
                    $message = [
                        'message' => 'Careeem Limo Sheet Uploaded Successfully',
                        'alert-type' => 'success'
                    ];
                    return redirect()->route("salary_sheet")->with($message);
                } else {
                    $message = [
                        'message' => 'Careeem Limo Salary Sheet These Dates Already Uploaded',
                        'alert-type' => 'error'
                    ];
                    return redirect()->route("salary_sheet")->with($message);
                }
            }
            elseif ($platform == '31') {

                $date_from = Carbon::createFromFormat('Y-m-d', $from);
                $sub_days = 1;
                $date_from = $date_from->subDays($sub_days);
                $res_from = $date_from->format('Y-m-d');

                $date_to = Carbon::createFromFormat('Y-m-d', $to);
                $daysToAdd = 3;
                $date_to = $date_to->addDays($daysToAdd);
                $res_to = $date_to->format('Y-m-d');


                $uberLimo = SalarySheetPath::where('date_from', '>=', $res_from)
                    ->where('date_to', '<=', $res_to)->where('platform_id','31')->first();


                if ($uberLimo == null) {
                    $path_saved = "";
                    $last_id = "";
                    $uber_limo_sheet_id = IdGenerator::generate(['table' => 'uber_limos', 'field' => 'sheet_id', 'length' => 7, 'prefix' => 'UBL1']);
                    if (!file_exists('../public/assets/upload/uber_limo/')) {
                        mkdir('../public/assets/upload/uber_limo/', 0777, true);
                    }
                    if (!empty($_FILES['select_file']['name']))
                    {
                        $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                        $file_name = $uber_limo_sheet_id.'-'.$from."_".$to. $request->date .'-orignal'."." . $ext;
                        move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/uber_limo/' . $file_name);
                        $file_path = 'assets/upload/uber_limo/' . $file_name;
                        $obj = new SalarySheetPath();
                        $obj->path = $file_path;
                        $obj->platform_id = $platform;
                        $obj->date_from = $from;
                        $obj->date_to = $to;
                        $obj->sheet_id = $uber_limo_sheet_id;
                        $obj->save();
                        $path_saved = public_path($file_path);
                        $last_id = $obj->id;
                    }
//uber eats has been reused as uber limo. Consider ubereats imports file as uber limp
                    $uber_limo_sheet_id = IdGenerator::generate(['table' => 'uber_limos', 'field' => 'sheet_id', 'length' => 7, 'prefix' => 'UBL1']);
                    Excel::import(new \App\Imports\Uber_Eats_Import($last_id,$uber_limo_sheet_id), $path_saved);

                    $message = [
                        'message' => 'Uber Limo Sheet Uploaded Successfully',
                        'alert-type' => 'success'
                    ];

                    return redirect()->route("salary_sheet")->with($message);
                } else {
                    $message = [
                        'message' => 'Uber Limo Salary Sheet These Dates Already Uploaded',
                        'alert-type' => 'error'
                    ];

                    return redirect()->route("salary_sheet")->with($message);
                }
            }





            else{

                $message = [
                    'message' => 'This Platform Salary Sheet Upload Not Available',
                    'alert-type' => 'error'
                ];

                return redirect()->route("salary_sheet")->with($message);

            }



        }

    }
    public function talabat_salary_pdf($id){

        $total_talabat_sheet=TalabatSalarySheet::all();
        $talabat_salary_sheet = DB::table('talabat_salary_sheets')
            ->select('rider_id','rider_name','vendor','city','deliveries','hours','pay_hour','pay_deliveries'
                ,'pay_per_hour_payment','pay_per_order_payment','total_pay','zomato_tip','talabat_tip','total_tip','incetive','date_to','date_from')
            ->where('date_from',$id)
            ->distinct('date_to')
            ->orderBy('date_to', 'desc')
            ->get();
//        $salary_path=SalarySheetPath::all();

        $talabat_file = array();
        $count=1;
        foreach($talabat_salary_sheet as $row){


            $gamer = array(
                'sr' => $count,
                'rider_id' => $row->rider_id,
                'rider_name' => $row->rider_name,
                'vendor' =>  $row->vendor,
                'city' =>  $row->city,
                'deliveries' =>  $row->deliveries,
                'hours' =>  $row->hours,
                'pay_hour' =>  $row->pay_hour,
                'pay_deliveries' =>  $row->pay_deliveries,
                'pay_per_hour_payment' =>  $row->pay_per_hour_payment,
                'pay_per_order_payment' =>  $row->pay_per_order_payment,
                'total_pay' =>  $row->total_pay,
                'zomato_tip' =>  $row->zomato_tip,
                'talabat_tip' =>  $row->talabat_tip,
                'total_tip' =>  $row->total_tip,
                'incetive' =>  $row->incetive,
                'date_to' =>  $row->date_to,
                'date_from' =>  $row->date_from,
            );
            $talabat_file [] = $gamer;
            $count++;
        }


        $pdf = PDF::loadView('admin-panel.pdf.talabat_salary_pdf', compact('talabat_file'))
            ->setPaper('a3', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');

    }
    public function download_actual_talabat($id){
        $all_bikes = TalabatSalarySheet::where('date_from',$id)->get();
        return Excel::download(new AssignDashboardExport('admin-panel.assigning.all_bikes_download',$all_bikes), "admin_dashboard_all_bikes.xlsx");
    }

    public function del_salary_pdf($id){

        $del_salary_sheet = DB::table('deliveroo_slaray_sheets')
            ->select('rider_id',
                'rider_name',
                'agency',
                'city',
                'pay_group',
                'email_address',
                'total_orders_delivered',
                'stacked_orders_delivered',
                'hours_worked_within_schedule',
                'rider_drop_fees',
                'rider_guarantee',
                'tips',
                'non_order_related_work',
                'past_queries_adjustment',
                'bonus',
                'surge',
                'fuel',
                'rider_training_fees',
                'total_rider_earnings',//(Not Incl Tips)
                'agency_drop_fees',
                'agency_guarantees',
                'rider_insurance',
                'agency_training_fees',
                'past_queries_adjustment',
                'early_departure_fee',
                'rider_kit',
                'phone_installments',
                'excessive_sim_plan_usage',
                'salik_charges',// (Deliveroo Provided Bikes)
                'bike_insurance',// (Deliveroo Provided Bikes)
                'traffic_fines',// (Deliveroo Provided Bikes)
                'bike_repair_charges',// (Deliveroo Provided Bikes)
                'total_agency_earnings',
                'rider_earnings',
                'rider_tips',
                'agency_earnings',
                'total',
                'date_from',
                'date_to',
                'file_path')
            ->distinct('date_to')
            ->where('date_from',$id)
            ->orderBy('date_to', 'desc')
            ->get();
//        $salary_path=SalarySheetPath::all();

        $del_file = array();
        $count=1;
        foreach($del_salary_sheet as $row){
            $gamer1 = array(
                'sr'=>$count,
                'rider_id'=>$row->rider_id,
                'rider_name'=>$row->rider_name,
                'agency'=>$row->agency,
                'city'=>$row->city,
                'pay_group'=>$row->pay_group,
                'email_address'=>$row->email_address,
                'total_orders_delivered'=>$row->total_orders_delivered,
                'stacked_orders_delivered'=>$row->stacked_orders_delivered,
                'hours_worked_within_schedule'=>$row->hours_worked_within_schedule,
                'rider_drop_fees'=>$row->rider_drop_fees,
                'rider_guarantee'=>$row->rider_guarantee,
                'tips'=>$row->tips,
                'non_order_related_work'=>$row->non_order_related_work,
                'bonus'=>$row->bonus,
                'surge'=>$row->surge,
                'fuel'=>$row->fuel,
                'rider_training_fees'=>$row->rider_training_fees,
                'total_rider_earnings'=>$row->total_rider_earnings,
                'agency_drop_fees'=>$row->agency_drop_fees,
                'agency_guarantees'=>$row->agency_guarantees,
                'rider_insurance'=>$row->rider_insurance,
                'agency_training_fees'=>$row->agency_training_fees,
                'past_queries_adjustment'=>$row->past_queries_adjustment,
                'early_departure_fee'=>$row->early_departure_fee,
                'rider_kit'=>$row->rider_kit,
                'phone_installments'=>$row->phone_installments,
                'excessive_sim_plan_usage'=>$row->excessive_sim_plan_usage,
                'salik_charges'=>$row->salik_charges,
                'bike_insurance'=>$row->bike_insurance,
                'traffic_fines'=>$row->traffic_fines,
                'bike_repair_charges'=>$row->bike_repair_charges,
                'total_agency_earnings'=>$row->total_agency_earnings,
                'rider_earnings'=>$row->rider_earnings,
                'rider_tips'=>$row->rider_tips,
                'agency_earnings'=>$row->agency_earnings,
                'total'=>$row->total,
            );
            $del_file [] = $gamer1;
            $count++;
        }

        $pdf = PDF::loadView('admin-panel.pdf.del_salary_pdf', compact('del_file'))
            ->setPaper('a3', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');

    }
    public  function  salary_sheet_search(Request $request){

        $from=$request->date_from;
        $to=$request->date_to;
        $platform=$request->platform_name;


//
        $date_from = Carbon::createFromFormat('Y-m-d', $from);
        $sub_days = 1;
        $date_from = $date_from->subDays($sub_days);
        $res_from = $date_from->format('Y-m-d');

        $date_to = Carbon::createFromFormat('Y-m-d', $to);
        $daysToAdd = 3;
        $date_to = $date_to->addDays($daysToAdd);
        $res_to = $date_to->format('Y-m-d');


        if ($platform=='15'){
//            level_rank::where('min_pv', '>=', $pv)->where('max_pv', '<=', $pv)->first();

            $talabat = TalabatSalarySheet::where('date_from', '>=', $res_from)->where('date_to', '<=', $res_to)->get();
            return view('admin-panel.salary_sheet.talabat_salary_search',compact('talabat'));
        }
        if ($platform=='4'){
            $del_file = DeliverooSlaraySheet::where('date_from', '>=', $res_from)->where('date_to', '<=', $res_to)->get();
            return view('admin-panel.salary_sheet.del_salary_search',compact('del_file'));
        }

        if ($platform=='1'){
            $careem_file = Careem::where('date_from', '>=', $res_from)->where('date_to', '<=', $res_to)->get();
            return view('admin-panel.salary_sheet.careem_salary_search',compact('careem_file'));
        }

        if ($platform=='31'){

            $uber_limo_file =\App\Model\SalarySheet\UberLimo::where('date_from', '>=', $res_from)->where('date_to', '<=', $res_to)->get();
            return view('admin-panel.salary_sheet.uber_limo_salary_search',compact('uber_limo_file'));
        }
        if ($platform=='32'){

            $careem_limo_file =\App\Model\SalarySheet\CareemLimoSalarySheet::where('date_from', '>=', $res_from)->where('date_to', '<=', $res_to)->get();

            return view('admin-panel.salary_sheet.careem_limo_salary_search',compact('careem_limo_file'));
        }
        else{
            $message = [
                'message' => 'This Platform Salary Sheet Upload Not Available',
                'alert-type' => 'error'
            ];

            return redirect()->route("salary_sheet")->with($message);

        }






    }

//uber limo pdf
    public function uber_limo_salary_pdf($id){

        $total_uber_sheet=UberLimo::all();
        $uber_sheet = DB::table('uber_limos')
            ->select('driver_u_uid','trip_u_uid','first_name','last_name','amount','timestamp','item_type','description'
                ,'disclaimer','date_from','date_to')
            ->where('date_from',$id)
            ->distinct('date_to')
            ->orderBy('date_to', 'desc')
            ->get();
//        $salary_path=SalarySheetPath::all();

        $uber_limo_file = array();
        $count=1;
        foreach($uber_sheet as $row){
            $gamer = array(
                'sr' => $count,
                'driver_u_uid' => $row->driver_u_uid,
                'trip_u_uid' => $row->trip_u_uid,
                'first_name' =>  $row->first_name,
                'last_name' =>  $row->last_name,
                'amount' =>  $row->amount,
                'timestamp' =>  $row->timestamp,
                'item_type' =>  $row->item_type,
                'description' =>  $row->description,
                'disclaimer' =>  $row->disclaimer,
                'date_from' =>  $row->date_from,
                'date_to' =>  $row->date_to,
            );
            $uber_limo_file [] = $gamer;
            $count++;
        }
        $pdf = PDF::loadView('admin-panel.pdf.uber_limo_salary_pdf', compact('uber_limo_file'))
            ->setPaper('a3', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');

    }

    public function talabat_table(){
        $user_platforms=Auth::user()->user_platform_id;

        $platform=Platform::whereIn('id',$user_platforms)->get();


        $total_talabat_sheet=TalabatSalarySheet::all();

//        $talabat_salary_sheet = DB::table('talabat_salary_sheets')
//            ->select('date_to','date_from','file_path','sheet_id')
//            ->distinct('date_to')
//            ->orderBy('date_to', 'desc')
//            ->limit(5)
//            ->get();
        $talabat_salary_sheet=TalabatSalarySheet::all();

        $talabat_salary_sheet_data=SalarySheetPath::where('platform_id','15')->where('sheet_id','!=','')->get();

        $talabat_file = array();
        foreach($talabat_salary_sheet_data as $row){
//            $salary_path=SalarySheetPath::where('id',$row->file_path)->first();

            $rout=route('talabat_salary_pdf',$row->id);
//            $date_to = Carbon::createFromFormat('Y-m-d', $row->date_to);
//            $daysToAdd = 1;
//            $date_to = $date_to->addDays($daysToAdd);
//            $res_to = $date_to->format('Y-m-d');
//            $final = date("Y-m-d", strtotime($date_to."+1 month"));

            $gamer = array(

                'date_from' => $row->date_from,
                'date_to' => $row->date_to,
                'total_riders' => count($talabat_salary_sheet->where('sheet_id',$row->sheet_id)),
                'total_eaning' => $talabat_salary_sheet->where('sheet_id',$row->sheet_id)->sum('total_pay'),
                'path'=>isset($row->path)?$row->path:"",
                'pdf_route'=>$rout,
                'tal_sheet_id'=>$row->sheet_id,
                'status'=>isset($row->status)?$row->status:"",
            );
            $talabat_file [] = $gamer;
        }

         $view = view("admin-panel.salary_sheet.salary_tables.talabat_table", compact('talabat_file'))->render();
         return response()->json(['html' => $view]);
    }

    public function deliveroo_table(){

        $total_del_sheet=DeliverooSlaraySheet::all();

        $del_salary_sheet_data=SalarySheetPath::where('platform_id','4')->where('sheet_id','!=','')->get();

        $del_file = array();
        foreach($del_salary_sheet_data as $row){
            $rout1=route('del_salary_pdf',$row->id);
            $gamer1 = array(

                'date_from' => $row->date_from,
                'date_to' => $row->date_to,
                'total_riders' => count($total_del_sheet->where('sheet_id',$row->sheet_id)),
                'total_eaning' => $total_del_sheet->where('sheet_id',$row->sheet_id)->sum('total'),
                'path'=>isset($row->path)?$row->path:'',
                'pdf_route'=>$rout1,
                'del_sheet_id'=>$row->sheet_id,
                'status'=>isset($row->status)?$row->status:"",
            );
            $del_file [] = $gamer1;
        }
        $view = view("admin-panel.salary_sheet.salary_tables.deliveroo_table", compact('del_file'))->render();
        return response()->json(['html' => $view]);
    }

    public function careem_table(){

        $total_careem_sheet=Careem::all();

        $careem_salary_sheet_data=SalarySheetPath::where('platform_id','1')->where('sheet_id','!=','')->get();

        $careem_file = array();
        foreach($careem_salary_sheet_data as $row){
            $rout2=route('del_salary_pdf',$row->id);

            $gamer2 = array(
                'date_from' => $row->date_from,
                'date_to' => $row->date_to,
                'total_riders' => count($total_careem_sheet->where('sheet_id',$row->sheet_id)),
                'total_eaning' =>  $total_careem_sheet->where('sheet_id',$row->sheet_id)->sum('total_driver_base_cost'),
                'path'=> isset($row->path)?$row->path:"",
                'pdf_route'=>$rout2,
                'careem_sheet_id'=>$row->sheet_id,
                'status'=> isset($row->status)?$row->status:"",
            );
            $careem_file [] = $gamer2;
        }
        $view = view("admin-panel.salary_sheet.salary_tables.careem_table", compact('careem_file'))->render();
        return response()->json(['html' => $view]);

    }

    public function careem_limo_table(){
        $total_careem_limo_sheet=\App\Model\SalarySheet\CareemLimoSalarySheet::all();

//        $careem_limo_salary_sheet = DB::table('careem_limo_salaries')
//            ->select('date_to','date_from','file_path','sheet_id')
//            ->distinct('date_to')
//            ->orderBy('date_to', 'desc')
//            ->get();
//        $salary_path=SalarySheetPath::all();

        $careem_salary_sheet_data=SalarySheetPath::where('platform_id','32')->where('sheet_id','!=','')->get();

        $careem_limo_file = array();
        foreach($careem_salary_sheet_data as $row){
            $salary_path_careem_limo=SalarySheetPath::where('id',$row->file_path)->first();
            $rout5=route('del_salary_pdf',$row->id);
//
//            $date_to = Carbon::createFromFormat('Y-m-d', $row->date_to);
//            $daysToAdd = 1;
//            $date_to = $date_to->addDays($daysToAdd);
//            $res_to = $date_to->format('Y-m-d');
//            $final = date("Y-m-d", strtotime($date_to."+1 month"));
            $gamer5 = array(
                'date_from' => $row->date_from,
                'date_to' => $row->date_to,
                'total_riders' => count($total_careem_limo_sheet->where('sheet_id',$row->sheet_id)),
                'total_eaning' => $total_careem_limo_sheet->where('sheet_id',$row->sheet_id)->sum('total_driver_base_cost'),
                'path'=>isset($row->path)?$row->path:"",
                'pdf_route'=>$rout5,
                'careem_limo_sheet_id'=>$row->sheet_id,
                'status'=>isset($row->status)?$row->status:"",
            );
            $careem_limo_file [] = $gamer5;
        }

        $view = view("admin-panel.salary_sheet.salary_tables.careem_limo_table", compact('careem_limo_file'))->render();
        return response()->json(['html' => $view]);
    }
    public function uber_limo_table(){

        $total_uber_sheet=UberLimo::all();

//        $uber_salary_sheet = DB::table('uber_limos')
//            ->select('sheet_id')
//            ->get();
        $uber_salary_sheet=UberLimo::all();
//        $salary_path=SalarySheetPath::all();
//        $uber_salary_sheet_data=SalarySheetPath::where('platform_id','31')->get();


        $uber_salary_sheet_data = DB::table('salary_sheet_paths')
            ->select('id','path','platform_id','status','date_from','date_to','sheet_id','created_at')
            ->where('platform_id','31')
            ->where('sheet_id','!=','')
            ->distinct('sheet_id')
            ->orderBy('created_at', 'desc')

            ->limit(2)
            ->get();

        $uber_file = array();
        foreach($uber_salary_sheet_data as $row){

            $rout3=route('uber_limo_salary_pdf',$row->id);

            $gamer3 = array(
                'date_from' => $row->date_from,
                'date_to' => $row->date_to,
                'total_riders' => count($uber_salary_sheet->where('sheet_id',$row->sheet_id)),
                'total_eaning' => $uber_salary_sheet->where('sheet_id',$row->sheet_id)->sum('amount'),
                'path'=> isset($row->path)?$row->path:"",
                'pdf_route'=>$rout3,
                'uber_limo_sheet_id'=>$row->sheet_id,
                'status'=> isset($row->status)?$row->status:""
            );
            $uber_file [] = $gamer3;

        }


        $view = view("admin-panel.salary_sheet.salary_tables.uber_limo_table", compact('uber_file'))->render();
        return response()->json(['html' => $view]);
    }






}
