<?php

namespace App\Http\Controllers\ArBalance;

use App\Imports\ArBalanceHistory;
use App\Imports\ArBalanceHistoryImport;
use App\Imports\ArBalanceImport;
use App\Imports\ArBalanceSheetAddImport;
use App\Imports\ArSheetImport;
use App\Imports\DeliverooPerformanceImport;
use App\Imports\FormsUploadImport;
use App\Model\ArBalance\ArBalance;
use App\Model\ArBalance\ArBalanceAlready;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\ArBalance\BalanceType;
use App\Model\ArBalance\SalaryPaymentHistroy;
use App\Model\Assign\AssignPlateform;
use App\Model\Cities;
use App\Model\Passport\Passport;
use App\Model\Performance\DeliverooPerformance;
use App\Model\Platform;
use App\Model\PlatformCode\PlatformCode;
use App\Model\SalarySheet\SalarySheetPath;
use App\Model\UserCodes\UserCodes;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\MasterStepsController;
use App\Model\AgreedAmount;
use App\Model\AgreementAmountFees\AgreementAmountFees;
use App\Model\Guest\Career;
use App\Model\Master_steps;
use App\Model\VisaProcess\RenewVisaSteps;
use App\Model\VisaProcess\AssigningAmount;
use App\Model\VisaProcess\VisaPaymentOptions;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Mockery\Generator\StringManipulation\Pass\Pass;
use PhpParser\Node\Stmt\DeclareDeclare;
use Redirect;


class ArBalanceController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|arbalance-arbalance', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|arbalance-arbalance-upload', ['only' => ['import']]);
        $this->middleware('role_or_permission:Admin|arbalance-arbalance-save', ['only' => ['store']]);
        $this->middleware('role_or_permission:Admin|arbalance-arbalance-edit', ['only' => ['edit','update']]);

        $this->middleware('role_or_permission:Admin|arbalance-addition-dedication-balance', ['only' => ['ar_balance_sheet']]);
        $this->middleware('role_or_permission:Admin|arbalance-arbalance-report', ['only' => ['ar_balance_report']]);



    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //

        // $ar_zds_code_array = ArBalance::pluck('zds_code')->toArray();

        // $zds_code=UserCodes::whereNotIn('zds_code',$ar_zds_code_array)->get();
        // $rider_id=PlatformCode::all();
        // $ar_balance=ArBalance::all();
        // $ar_zds=ArBalance::all();
        // $balance_types=BalanceType::all();
        // $balance_exists=ArBalanceAlready::all();


        $ar_balance= AgreedAmount::all();

        return view('admin-panel.ar_balance.index',compact('ar_balance'));
        // return view('admin-panel.ar_balance.index',compact('zds_code','rider_id','ar_zds','ar_balance','balance_types','balance_exists'));
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
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|agreed_amounts,rider_id',
        //     'agreed_amount' => 'numeric:agreed_amounts,agreed_amount',
        //     'advance_amount' => 'nullable|numeric:agreed_amounts,advance_amount',
        //     'discount_details' => 'nullable|numeric:agreed_amounts,discount_details',
        //     'final_amount' => 'nullable|numeric:agreed_amounts,final_amount',
        // ]);
        // if ($validator->fails()) {
        //     $validate = $validator->errors();
        //     $message = [
        //         'message' => $validate->first(),
        //         'alert-type' => 'error',
        //         'error' => $validate->first()
        //     ];
        //     return redirect()->back()->with($message);
        // }
                $passport=Passport::where('passport_no', $request->passport_number)->first();
                $passport_id=$passport->id;

                $existing_data=AgreedAmount::where('passport_id',$passport_id)->first();

                if($existing_data!=null){
                $message = [
                'message' => 'A/R balance already exists',
                'alert-type' => 'error',
                    ];
                   return redirect()->back()->with($message);
                }
                if($request->input('final_amount')<'0'){
                    $message = [
                        'message' => 'Final amount cannot be less than 0',
                        'alert-type' => 'error',
                            ];
                           return redirect()->back()->with($message);
                }



        $obj = new AgreedAmount();

        $obj->passport_id = $passport_id;
        $obj->agreed_amount = $request->input('agreed_amount');
        $obj->advance_amount = $request->input('advance_amount');
        $obj->discount_details = $request->input('discount_details');
        $obj->final_amount = $request->input('final_amount');


        $obj->save();
        $message = [
            'message' => 'AR Balance Added Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
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
        $ar_bal_edit=ArBalanceSheet::find($id);


        $zds_code=UserCodes::all();
        $rider_id=PlatformCode::all();
        $ar_balance_sheet=ArBalanceSheet::orderBy('id', 'desc')->take(50)->get();
        $ar_zds=ArBalance::all();
        $balance_types_sub=BalanceType::where('category','1')->get();
        $balance_types_add=BalanceType::where('category','2')->get();


        return view('admin-panel.ar_balance.ar_balance_sheet',compact('zds_code','rider_id','ar_zds','ar_balance_sheet','balance_types_sub','balance_types_add','ar_bal_edit'));
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
        $ar_edit=ArBalance::find($id);




        //
        $zds_code=UserCodes::all();
        $rider_id=PlatformCode::all();
        $ar_balance=ArBalance::all();
        $ar_zds=ArBalance::all();
        $balance_types=BalanceType::all();
        $balance_exists=ArBalanceAlready::all();

        return view('admin-panel.ar_balance.index',compact('zds_code','rider_id','ar_zds','ar_balance','balance_types','balance_exists','ar_edit'));
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
        $obj = ArBalance::find($id);
        $obj->zds_code = $request->input('zds_code');
        $obj->rider_id = $request->input('rider_id');
        $obj->name = $request->input('name');
        $obj->agreed_amount = $request->input('agreed_amount');
        $obj->cash_received = $request->input('cash_received');
        $obj->discount = $request->input('discount');
        $obj->deduction = $request->input('deduction');
        $obj->balance = $request->input('balance');

        $obj->save();
        $message = [
            'message' => 'AR Balance Updated Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
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

       // $ar_edit=ArBalance::find($id);
    }

    public function ar_balance_add_balance(Request $request){

        $validator = Validator::make($request->all(), [
            'balance' => 'numeric:ar_balance_sheets,balance',
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



        $passport_id=Passport::where('passport_no' ,$request->input('passport_number'))->first();
        $pass_id= $passport_id->id;

         $current_balance=AgreedAmount::where('passport_id',$pass_id)->first();

            if($current_balance==null){
                $message = [
                    'message' => 'A/R Balance is not available',
                    'alert-type' => 'error',
                ];
                return redirect()->back()->with($message);
            }

         $current_balance_val= $current_balance->final_amount;
         $current_id= $current_balance->id;
         $balance=$request->input('balance');


//        get platform
//        get rider id
            $platform_detail=AssignPlateform::where('passport_id',$pass_id)->where('status','1')->first();
            $platform_id=$platform_detail->plateform;
//            $passport_detail=Passport::where('id',$pass_id)->first();
//            $rider_id= $passport_detail->get_the_rider_id_by_platform($platform_id)->platform_code;



        $obj = new ArBalanceSheet();
        $obj->passport_id =$pass_id;
        $obj->date_saved = $request->input('date_save');
        $obj->balance_type = $request->input('balance_type');
        $obj->balance = $balance;
        $obj->status = '0';
        $obj->platform_id=$platform_id;

        $obj->save();
//        status=0 for addition


        $new_balance=$current_balance_val+$balance;
//
//        DB::table('ar_balances')->where('id', $current_id)
//            ->update(['balance' => $new_balance]);

        $message = [
            'message' => 'AR Balance Added Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
    }

    public function ar_balance_sub_balance(Request $request){
        $validator = Validator::make($request->all(), [
            'balance' => 'numeric:ar_balance_sheets,balance',
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

        $passport_id=Passport::where('passport_no' ,$request->input('passport_number'))->first();
        $pass_id= $passport_id->id;
        $current_balance=AgreedAmount::where('passport_id' ,$pass_id)->first();
        if($current_balance==null){
            $message = [
                'message' => 'A/R Balance is not available',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }
        $current_balance_val= $current_balance->balance;
        $current_id= $current_balance->id;
        $balance=$request->input('balance');



        //        get platform
//        get rider id
        $platform_detail=AssignPlateform::where('passport_id',$pass_id)->where('status','1')->first();
        $platform_id=$platform_detail->plateform;
//        $passport_detail=Passport::where('id',$pass_id)->first();
//        $rider_id= $passport_detail->get_the_rider_id_by_platform($platform_id)->platform_code;


        $obj = new ArBalanceSheet();
        $obj->passport_id =$pass_id;
        $obj->date_saved = $request->input('date_save');
        $obj->balance_type = $request->input('balance_type');
        $obj->balance = $request->input('balance');
        $obj->remarks = $request->input('remarks');
        $obj->loan_number = $request->input('loan_number');
        $obj->jv_number = $request->input('jv_number');
        //status 1 for substraction
        $obj->status = '1';
        $obj->platform_id=$platform_id;
        $obj->save();
        $new_balance=$current_balance_val-$balance;


        $message = [
            'message' => 'AR Balance Substracted Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
    }
    public  function ar_balance_sheet(){

        $zds_code=UserCodes::all();
        $rider_id=PlatformCode::all();
        $ar_balance_sheet=ArBalanceSheet::orderBy('id', 'desc')->take(50)->get();
        foreach ($ar_balance_sheet as $res){
            $passport_detail=Passport::where('id',$res->passport_id)->first();
            $rider_id= isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code)?$passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code:'N/A';
            $gamer1 = array(
                'ppuid' => $res->passport->pp_uid,
                'platform_code' => $rider_id,
                'platform'=>$res->platform_id,
                'name' => $res->passport->personal_info->full_name,
                'date'=>$res->date_saved,
                'description'=>$res->balance_name,
                'amount'=>$res->balance,
                'status'=>$res->status,
            );
            $statement [] = $gamer1;
        }

        $ar_zds=ArBalance::all();
        $balance_types_sub=BalanceType::where('category','1')->get();
        $balance_types_add=BalanceType::where('category','2')->get();
        $platforms=Platform::all();

        //---------assging amounts

        // $visa_steps_amount=  AssigningAmount::all();

        $visa_steps=  Master_steps::all();
        $visa_steps->shift(0);




        return view('admin-panel.ar_balance.ar_balance_sheet',compact('zds_code','rider_id','platforms','ar_zds','balance_types_add','balance_types_sub','ar_balance_sheet','statement','visa_steps'));

    }


    public function import(Request $request)
    {


            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];

                return redirect()->route('ar_balance')->with($message);
            }
            else
                {

                        $not_exist = false;

                            $last_id = Excel::toArray(new \App\Imports\ArBalanceImport(), request()->file('select_file'));
                            $data = collect(head($last_id));
                            $gamer_array = array();
                            $count = 0;
                            foreach ( $data as $res){
                                $check_ppuid = $this->check_the_ppuid($res['pp_uid']);

                                if($check_ppuid['passport_id']==""){
                                    $not_exist = true;
                                    $count = $count+1;

                                }
                                $gamer_array [] = $check_ppuid;
                            }
                            if ($count==count($data)){
                                Excel::import(new ArBalanceImport(), request()->file('select_file'));
                                $message = [
                                    'message' => ' AR Balance Sheet Uploaded Successfully',
                                    'alert-type' => 'success'
                                ];
                                return redirect()->back()->with($message);
                            }
                            else{
                                $zds_code=UserCodes::all();
                                $rider_id=PlatformCode::all();
                                $ar_balance=ArBalance::all();
                                $ar_zds=ArBalance::all();
                                $balance_types=BalanceType::all();
                                $balance_exists=ArBalanceAlready::all();
                                return view('admin-panel.ar_balance.index',
                                    compact('zds_code','rider_id','ar_zds','ar_balance',
                                        'balance_types','balance_exists','gamer_array'));

                            }



                }

            }



    public function get_last_id_traffic_code($gamer){

        $zds_code = ArBalance::where('zds_code','=',$gamer)->first();
        $gamer =array(
            'zds_code' => isset($zds_code->zds_code)?$zds_code->zds_code:"",
            'rider_id'=>isset($zds_code->rider_id)?$zds_code->rider_id:"",
            'name'=>isset($zds_code->name)?$zds_code->name:"",
            'agreed_amount'=>isset($zds_code->agreed_amount)?$zds_code->agreed_amount:"",
            'cash_received'=>isset($zds_code->cash_received)?$zds_code->cash_received:"",
            'discount'=> isset($zds_code->discount)?$zds_code->discount:"",
            'deduction'=>isset($zds_code->deduction)?$zds_code->deduction:"",
            'balance'=>isset($zds_code->balance)?$zds_code->balance:"",
        );
        return $gamer;
    }

    public function check_the_ppuid($gamer){

         $passport = Passport::where('pp_uid','=',$gamer)->first();

         if($passport != null){

             $zds_code = ArBalance::where('passport_id','=',$passport->id)->first();
             $gamer =array(
                 'passport_id' => isset($zds_code->passport_id)?$zds_code->passport_id:"",
                 'rider_id'=>isset($zds_code->rider_id)?$zds_code->rider_id:"",
                 'name'=>isset($zds_code->name)?$zds_code->name:"",
                 'agreed_amount'=>isset($zds_code->agreed_amount)?$zds_code->agreed_amount:"",
                 'cash_received'=>isset($zds_code->cash_received)?$zds_code->cash_received:"",
                 'discount'=> isset($zds_code->discount)?$zds_code->discount:"",
                 'deduction'=>isset($zds_code->deduction)?$zds_code->deduction:"",
                 'balance'=>isset($zds_code->balance)?$zds_code->balance:"",
             );

         }else{

             $gamer =array(
                 'passport_id' => isset($zds_code->passport_id)?$zds_code->passport_id:"",
                 'rider_id'=>isset($zds_code->rider_id)?$zds_code->rider_id:"",
                 'name'=>isset($zds_code->name)?$zds_code->name:"",
                 'agreed_amount'=>isset($zds_code->agreed_amount)?$zds_code->agreed_amount:"",
                 'cash_received'=>isset($zds_code->cash_received)?$zds_code->cash_received:"",
                 'discount'=> isset($zds_code->discount)?$zds_code->discount:"",
                 'deduction'=>isset($zds_code->deduction)?$zds_code->deduction:"",
                 'balance'=>isset($zds_code->balance)?$zds_code->balance:"",
             );

         }


        return $gamer;
    }







    public function import2(Request $request)
    {

        $platform_id=  $request->platform_id;
            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),

                ];

                return redirect()->back()->with($message);

//                return view('admin-panel.ar_balance.ar_balance_sheet',compact('zds_code','rider_id','ar_zds','ar_balance_sheet','balance_types','msg'));

            } else {

                $last_id = Excel::toArray(new \App\Imports\ArSheetImport($platform_id), request()->file('select_file'));





                $data = collect(head($last_id));
                $gamer_array = array();
                $count = 0;
                foreach ( $data as $res){
                    $id_traffic_code = $this->get_last_id_balance_sheet($res['zds_code']);

                    if($id_traffic_code['zds_code']!=""){
                        $count = $count+1;
                    }
                    $zds_codes = ArBalance::where('zds_code','=',$res['zds_code'])->first();
                    if ($zds_codes==null){
                        $gamer_array[] = $res['zds_code'];
                    }
                }
                if ($count==count($data)){
                    Excel::import(new ArSheetImport($platform_id), request()->file('select_file'));
                    $message = [
                        'message' => 'Uploaded Successfully',
                        'alert-type' => 'success'
                    ];
                    return redirect()->back()->with($message);



                }

                else{
                    return redirect()->back()->with(['gamer_array'=>$gamer_array]);

                }


            }

    }

    public function get_last_id_balance_sheet($gamer){

        $zds_code = ArBalance::where('zds_code','=',$gamer)->first();
        $gamer =array(
            'zds_code' => isset($zds_code->zds_code)?$zds_code->zds_code:"",
        );
        return $gamer;

    }

            public function ar_balance_sheet_name(Request $request){
                $zds_code=UserCodes::where('zds_code',$request->zds_code)->first();
                $pass = Passport::find($zds_code->passport_id);
                $response = $pass->personal_info->full_name."$".'';
                return $response;
            }
            public function ar_balance_sheet_detail(Request $request){


                  $passport=$request->keyword;
                  $passport_detail=Passport::where('passport_no',$passport)->first();
                  $passport_id=$passport_detail->id;
                //   $zds_code_detail=UserCodes::where('passport_id',$passport_id)->first();
                //   $zds_code=$zds_code_detail->zds_code;

                   $rout_first=route('ar_balance_first_pdf',$passport_id);




                $bal_detail=ArBalanceSheet::where('passport_id',$passport_id)->get();
                $visa_payment_option=VisaPaymentOptions::where('passport_id',$passport_id)->get();



                // $joined =ArBalanceSheet::select('ar_balance_sheets.passport_id','ar_balance_sheets.date_saved','ar_balance_sheets.balance_type',
                // 'ar_balance_sheets.balance','ar_balance_sheets.status', 'visa_payment_options.passport_id','visa_payment_options.visa_process_step_id',
                // 'visa_payment_options.payment_amount')
                // ->join('visa_payment_options', 'visa_payment_options.passport_id', '=', 'ar_balance_sheets.passport_id')
                // ->where("ar_balance_sheets.passport_id",$passport_id)
                // ->get();
                // dd($joined);



                $first_balance=AgreedAmount::where('passport_id',$passport_id)->first();

                $current_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
                $opening_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
                if (count($bal_detail)=='0'){

                    $myVariable = '<div class="col-md-4"></div><div class="col-md-4"><b class="text-center">Data not available for this Platform</b></div><div class="col-md-4"></div>';
                    return response()->json(['html' => $myVariable]);
//                return redirect()->back()->with($message);
                }

                foreach ($bal_detail as $res) {
                    $passport_detail = Passport::where('id', $res->passport_id)->first();
                    $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';


                    if ($res->status == '0')
                    {

                        $current_balance = $current_balance + $res->balance;
                    }
                    else
                    {
                        $current_balance = $current_balance - $res->balance;
                    }
                    if ($res->status == '0')
                    {
                        $add = $res->balance;
                        $sub="";
                    }
                    else
                    {
                        $add = "";
                        $sub=$res->balance;
                    }

                    if($res->balance_name->id=='65'){
                        // renew_visa_process_step

                            if($res->visa_process_step_id==null){
                                $des='Renew Visa Process-'.$res->renewal_visa_process_step->step_name;

                            }
                            else{
                                $des=$res->visa_process_step->step_name;
                            }

                          }
                          else{
                              $des=$res->balance_name->name;
                          }
                    $gamer1 = array(
                        'ppuid' => $res->passport->pp_uid,
                        'platform'=>isset($res->platform_name->name)?$res->platform_name->name:"N/A",
                        'name' => $res->passport->personal_info->full_name,
                        'date'=>$res->date_saved,
                        'description'=>$des,
                        'amount'=>$res->balance,
                        'addition'=>isset($add)?$add:'',
                        'subs'=>isset($sub)?$sub:"",
                        'balance'=>$current_balance,
                    );
                    $statement [] = $gamer1;


                }
                $current_bal = $current_balance;
                $name=$res->passport->personal_info->full_name;

                $ppuid= $res->passport->pp_uid;






                $view = view("admin-panel.ar_balance.ajax_get_balance", compact('bal_detail','first_balance','statement','opening_balance','current_bal','name','zds_code','ppuid','rider_id','rout_first'))->render();
                return response()->json(['html' => $view]);
            }


        public  function ar_balance_report()
        {
            $ar_balance = ArBalance::all();
            $ar_balance_sheet = ArBalanceSheet::all();
            $platforms = Platform::all();
//            $balance_date = ArBalance::select('created_at', DB::raw('sum(balance) as total_balance'))->groupBy('created_at')->get();

            $balance_date = DB::table('ar_balances')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(balance) as total_balance'))
                ->groupBy('date')
                ->get();


            $all_passport_ids = array();
            $platform_balance2 = array();

//            $other_platform=0;
            foreach ($platforms as $platform_res) {
                $array_pasport1 = $platform_res->assign_platforms2->pluck('passport_id')->toArray();
                $array_pasport = array_unique($array_pasport1);
                $user_codes = UserCodes::whereIn('passport_id', $array_pasport)->pluck('zds_code')->toArray();
                $ab = ArBalance::whereIn('passport_id', $array_pasport)->sum('balance');
                $agreed = ArBalance::whereIn('passport_id', $array_pasport)->sum('agreed_amount');
                $cash_rec = ArBalance::whereIn('passport_id', $array_pasport)->sum('cash_received');
                $dis = ArBalance::whereIn('passport_id', $array_pasport)->sum('discount');
                $ded = ArBalance::whereIn('passport_id', $array_pasport)->sum('deduction');
                $balance_added = ArBalanceSheet::whereIn('passport_id', $array_pasport)->where('status','0')->sum('balance');
                $balance_sub = ArBalanceSheet::whereIn('passport_id', $array_pasport)->where('status','1')->sum('balance');
                $first_balance = ArBalance::whereIn('passport_id', $array_pasport)->sum('balance');

                 $current_balance=$first_balance+$balance_added;
                 $current_balance=$first_balance-$balance_sub;
//                $total_balance = ArBalance::sum('balance')






                $gamer =array(
                    'platform' => $platform_res->name,
                    'balance' => $ab,
                    'agreed_amount' => $agreed,
                    'cash_received' => $cash_rec,
                    'discount' => $dis,
                    'deduction' => $ded,
                    'current_balance' => $current_balance,
                );
                $platform_balance2 [] = $gamer;
            }

            $platform_balance = collect($platform_balance2)->sortBy('balance')->reverse()->toArray();



            $total_balance_sheet = ArBalanceSheet::get();
            $ar_balance_details=  ArBalance::get();
            $current_balance_sheet=$ar_balance_details->sum('balance');

            foreach ($total_balance_sheet as $ar_res) {
                if ($ar_res->status == '0') {
                    $current_balance_sheet = $current_balance_sheet + $ar_res->balance;
                } else {
                    $current_balance_sheet = $current_balance_sheet - $ar_res->balance;
                }
            }

//dd($current_balance_sheet);






//            dd($others);
            return view('admin-panel.ar_balance.ar_balance_report',
                compact(
                    'platform_balance',
                'platforms',
                    'all_passport_ids',
                    'balance_date',
                'ar_balance',
                    'ar_balance_sheet',
                    'others',
                    'current_balance_sheet'
                ));

}
public function ajax_ar_balance_edit(Request $request){
     $id=$request->id;
 $ar_balance_value=ArBalance::where('id',$id)->get();
    $view = view("admin-panel.ar_balance.ajax_ar_balance_edit", compact('ar_balance_value'))->render();
    return response()->json(['html' => $view]);
}

public function ar_balance_sheet_edit(Request $request){
     $id=$request->id;
    $ar_bal_edit=ArBalanceSheet::where('id',$id)->first();
    $balance_types_sub=BalanceType::where('category','1')->get();
    $balance_types_add=BalanceType::where('category','2')->get();
    $view = view("admin-panel.ar_balance.ajax_ar_balance_edit", compact('ar_bal_edit','balance_types_sub','balance_types_add'))->render();
    return response()->json(['html' => $view]);
}

public function ar_balance_edit_add_balance(Request $request){


    $passport_id=UserCodes::where('zds_code' ,$request->input('zds_code_balance'))->first();
    $pass_id= $passport_id->passport_id;

    $obj=ArBalanceSheet::find($request->id);
    $obj->zds_code = $request->input('zds_code_balance');
    $obj->passport_id =$pass_id;
    $obj->date_saved = $request->input('date_save');
    $obj->balance_type = $request->input('balance_type');
    $obj->balance = $request->input('balance');
    $obj->status = $request->input('status_type');



    $obj->save();
    $message = [
        'message' => 'Updated Successfully',
        'alert-type' => 'success'

    ];
    return redirect()->back()->with($message);
}




    public function import3(Request $request)
    {
        $platform_id=  $request->platform_id;

        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx'
        ]);


        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
            ];
            return redirect()->back()->with($message);
        } else {

            $last_id = Excel::toArray(new \App\Imports\ArBalanceSheetAddImport($platform_id), request()->file('select_file'));




            $data = collect(head($last_id));
            $gamer_array = array();
            $count = 0;
            foreach ( $data as $res){
                $id_traffic_code = $this->get_last_id_balance_sheet2($res['zds_code']);

                if($id_traffic_code['zds_code']!=""){
                    $count = $count+1;
                }
                $zds_codes = ArBalance::where('zds_code','=',$res['zds_code'])->first();
                if ($zds_codes==null){
                    $gamer_array[] = $res['zds_code'];
                }
            }
            if ($count==count($data)){
                Excel::import(new ArBalanceSheetAddImport($platform_id),request()->file('select_file'));
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
            else{
                return redirect()->back()->with(['gamer_array'=>$gamer_array]);
            }
        }

    }

    public function get_last_id_balance_sheet2($gamer){

        $zds_code = ArBalance::where('zds_code','=',$gamer)->first();
        $gamer =array(
            'zds_code' => isset($zds_code->zds_code)?$zds_code->zds_code:"",
        );
        return $gamer;

    }

    public function ar_balance_between_search(Request $request){

        $date_to=$request->input('date_to_search');
        $date_from=$request->input('date_from_search');
        $platform=$request->input('platform_id_search');

        if (isset($platform) && $date_to==null && $date_from==null){
            $date_between=ArBalanceSheet::where('platform_id',$platform)->get();

            if (count($date_between)=='0'){
                $message = [
                    'message' => 'Agreement Has Been Cancelled Successfully',
                    'alert-type' => 'success'
                ];
                $myVariable = '<div class="col-md-4"></div><div class="col-md-4"><b class="text-center">Data not available for this Platform</b></div><div class="col-md-4"></div>';
                return response()->json(['html' => $myVariable]);
//                return redirect()->back()->with($message);
            }

            foreach ($date_between as $res) {


                $passport_detail = Passport::where('id', $res->passport_id)->first();
                $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';

                $first_balance=AgreedAmount::where('passport_id',$res->passport_id)->first();
                $current_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;

                if ($res->status == '0')
                {
                    $current_balance = $current_balance + $res->balance;
                }
                else
                {
                    $current_balance = $current_balance - $res->balance;
                }

                if ($res->status == '0')
                {
                    $add = $res->balance;
                    $sub="";
                }
                else
                {
                    $add = "";
                    $sub=$res->balance;
                }

                $gamer1 = array(

                    'ppuid' => $res->passport->pp_uid,
                    'platform'=>isset($res->platform_name->name)?$res->platform_name->name:"N/A",
                    'name' => isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:"N/A",
                    'date'=>$res->date_saved,
                    'description'=>isset($res->balance_name->name)?$res->balance_name->name:"N/A",
                    'amount'=>$res->balance,
                    'addition'=>isset($add)?$add:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$current_balance,
                );
                $statement [] = $gamer1;

            }





            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between",
                compact('date_between',
                    'statement','date_from','date_to'))->render();
            return response()->json(['html' => $view]);

        }


        if (isset($platform)){


            $date_between=ArBalanceSheet::whereBetween('date_saved', [$date_from, $date_to])->where('platform_id',$platform)->get();
            foreach ($date_between as $res) {
                $passport_detail = Passport::where('id', $res->passport_id)->first();
                $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';
                $first_balance=AgreedAmount::where('passport_id',$res->passport_id)->first();
                $current_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
                if ($res->status == '0')
                {
                    $current_balance = $current_balance + $res->balance;
                }
                else
                {
                    $current_balance = $current_balance - $res->balance;
                }
                if ($res->status == '0')
                {
                    $add = $res->balance;
                    $sub="";
                }
                else
                {
                    $add = "";
                    $sub=$res->balance;
                }
                $gamer1 = array(
                    'ppuid' => $res->passport->pp_uid,
                    'platform'=>isset($res->platform_name->name)?$res->platform_name->name:"N/A",
                    'name' => isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:"N/A",
                    'date'=>$res->date_saved,
                    'description'=>isset($res->balance_name->name)?$res->balance_name->name:"N/A",
                    'amount'=>$res->balance,
                    'addition'=>isset($add)?$add:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$current_balance,
                );
                $statement [] = $gamer1;

            }





            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between",
                compact('date_between',
                    'statement','date_from','date_to'))->render();
            return response()->json(['html' => $view]);
        }
        else{






        $date_between=ArBalanceSheet::whereBetween('date_saved', [$date_from, $date_to])->get();



        foreach ($date_between as $res) {

            $passport_detail = Passport::where('id', $res->passport_id)->first();
            $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';

            $first_balance=ArBalance::where('zds_code',$res->zds_code)->first();
            $current_balance = isset($first_balance->balance) ? $first_balance->balance : 0;
            if ($res->status == '0')
            {
                $current_balance = $current_balance + $res->balance;
            }
            else
            {
                $current_balance = $current_balance - $res->balance;
            }

            if ($res->status == '0')
            {
                $add = $res->balance;
                $sub="";
            }
            else
            {
                $add = "";
                $sub=$res->balance;
            }

            $gamer1 = array(
                'zds_code' => $res->zds_code,
                'ppuid' => $res->zds_cods->passport->pp_uid,
                'platform_code' => $rider_id,
                'platform'=>isset($res->platform_name->name)?$res->platform_name->name:"N/A",
                'name' => isset($res->zds_cods->passport->personal_info->full_name)?$res->zds_cods->passport->personal_info->full_name:"N/A",
                'date'=>$res->date_saved,
                'description'=>isset($res->balance_name->name)?$res->balance_name->name:"N/A",
                'amount'=>$res->balance,
                'addition'=>isset($add)?$add:'',
                'subs'=>isset($sub)?$sub:"",
                'balance'=>$current_balance,
            );
            $statement [] = $gamer1;

        }




        $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between",
            compact('date_between',
            'statement','date_from','date_to'))->render();
        return response()->json(['html' => $view]);
        }

    }

    public function ar_balance_between_user(Request $request){


        $pass_no=$request->input('passport_number');
        $passport_detail=Passport::where('passport_no',$pass_no)->first();
        $pass_id=$passport_detail->id;
        $date_to=$request->input('date_to_user');
        $date_from=$request->input('date_from_user');
        $rider_id="N/A";
        $date_between=ArBalanceSheet::whereBetween('date_saved', [$date_from, $date_to])->where('passport_id',$pass_id)->get();

        $first_balance=AgreedAmount::where('passport_id',$pass_id)->first();
        $current_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
        $opening_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;

        if (count($date_between)=='0'){

//            if no AR Balance is available then it should show the empty row
            $current_bal = $current_balance;
            $name=isset($res->zds_cods->passport->personal_info->full_name)?$res->zds_cods->passport->personal_info->full_name:"N/A";
            $zds_code=isset($res->zds_code)?$res->zds_code:"N/A";
            $ppuid= isset($res->zds_cods->passport->pp_uid)?$res->zds_cods->passport->pp_uid:"N/A";

            $statement=$date_between;

            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_user", compact('statement','opening_balance','current_bal',
                'name','zds_code','ppuid','rider_id','date_to','date_from'))->render();
            return response()->json(['html' => $view]);


        }
        else{
            foreach ($date_between as $res) {

                $passport_detail = Passport::where('id', $res->passport_id)->first();
                if ($res->status == '0')
                {
                    $current_balance = $current_balance + $res->balance;
                }
                else
                {
                    $current_balance = $current_balance - $res->balance;
                }

                if ($res->status == '0')
                {
                    $add = $res->balance;
                    $sub="";
                }
                else
                {
                    $add = "";
                    $sub=$res->balance;
                }
                $gamer1 = array(
                    'ppuid' => $res->passport->pp_uid,
                    'platform'=>isset($res->platform_name->name)?$res->platform_name->name:"N/A",
                    'name' => $res->passport->personal_info->full_name,
                    'date'=>$res->date_saved,
                    'description'=>$res->balance_name->name,
                    'amount'=>$res->balance,
                    'addition'=>isset($add)?$add:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$current_balance,
                );
                $statement [] = $gamer1;
            }
            $current_bal = $current_balance;
            $name=isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:"N/A";
            $ppuid= isset($res->passport->pp_uid)?$res->passport->pp_uid:"N/A";


            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_user", compact('date_between','statement','opening_balance','current_bal',
                'name','zds_code','ppuid','rider_id','date_to','date_from'))->render();
            return response()->json(['html' => $view]);
        }





    }

    public function ar_balance_first_pdf($id){

        $passport_id=$id;
        $bal_detail=ArBalanceSheet::where('passport_id',$passport_id)->get();
        $first_balance=AgreedAmount::where('passport_id',$passport_id)->first();
        $current_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
        $opening_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
        foreach ($bal_detail as $res) {
            $passport_detail = Passport::where('id', $res->passport_id)->first();

            $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';
            if ($res->status == '0')
            {
                $current_balance = $current_balance + $res->balance;
            }
            else
            {
                $current_balance = $current_balance - $res->balance;
            }
            if ($res->status == '0')
            {
                $add = $res->balance;
                $sub="";
            }
            else
            {
                $add = "";
                $sub=$res->balance;
            }
            if($res->balance_name->id=='65'){
                $des=$res->renewal_visa_process_step->step_name;
                  }
                  else{
                      $des=$res->balance_name->name;
                  }
            $gamer1 = array(
                'ppuid' => $res->passport->pp_uid,
                'platform'=>isset($res->platform_name->name)?$res->platform_name->name:"N/A",
                'name' => $res->passport->personal_info->full_name,
                'date'=>$res->date_saved,
                'description'=>$des,
                'amount'=>$res->balance,
                'addition'=>isset($add)?$add:'',
                'subs'=>isset($sub)?$sub:"",
                'balance'=>$current_balance,
            );
            $statement [] = $gamer1;


        }
        $current_bal = $current_balance;
        $name=$res->passport->personal_info->full_name;
        $ppuid= $res->passport->pp_uid;


        $pdf = PDF::loadView('admin-panel.pdf.ar_balance_pdf.ar_balance_pdf1', compact('statement','current_bal','name','zds_code','ppuid','rider_id','bal_detail','opening_balance'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');
    }

    public function ar_balance_second_pdf($date_from,$date_to){
        $date_between=ArBalanceSheet::whereBetween('date_saved', [$date_from, $date_to])->get();

        foreach ($date_between as $res) {

            $passport_detail = Passport::where('id', $res->passport_id)->first();
            $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';

            $first_balance=ArBalance::where('zds_code',$res->zds_code)->first();
            $current_balance = isset($first_balance->balance) ? $first_balance->balance : 0;
            if ($res->status == '0')
            {
                $current_balance = $current_balance + $res->balance;
            }
            else
            {
                $current_balance = $current_balance - $res->balance;
            }

            if ($res->status == '0')
            {
                $add = $res->balance;
                $sub="";
            }
            else
            {
                $add = "";
                $sub=$res->balance;
            }

            $gamer1 = array(
                'zds_code' => $res->zds_code,
                'ppuid' => $res->zds_cods->passport->pp_uid,
                'platform_code' => $rider_id,
                'platform'=>isset($res->platform_name->name)?$res->platform_name->name:"N/A",
                'name' => $res->zds_cods->passport->personal_info->full_name,
                'date'=>$res->date_saved,
                'description'=>$res->balance_name->name,
                'amount'=>$res->balance,
                'addition'=>isset($add)?$add:'',
                'subs'=>isset($sub)?$sub:"",
                'balance'=>$current_balance,
            );
            $statement [] = $gamer1;

        }


        $pdf = PDF::loadView('admin-panel.pdf.ar_balance_pdf.ar_balance_pdf2', compact('statement','current_bal','name','zds_code','ppuid','rider_id','bal_detail','opening_balance'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');
    }


    public function ar_balance_third_pdf($date_from,$date_to,$zds_code)
    {

        $date_between=ArBalanceSheet::whereBetween('date_saved', [$date_from, $date_to])->where('zds_code',$zds_code)->get();





        $first_balance=ArBalance::where('zds_code',$zds_code)->first();
        $current_balance = isset($first_balance->balance) ? $first_balance->balance : 0;
        $opening_balance = isset($first_balance->balance) ? $first_balance->balance : 0;


        foreach ($date_between as $res) {

            $passport_detail = Passport::where('id', $res->passport_id)->first();
            $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';


            if ($res->status == '0')
            {
                $current_balance = $current_balance + $res->balance;
            }
            else
            {
                $current_balance = $current_balance - $res->balance;
            }

            if ($res->status == '0')
            {
                $add = $res->balance;
                $sub="";
            }
            else
            {
                $add = "";
                $sub=$res->balance;
            }

            $gamer1 = array(
                'zds_code' => $res->zds_code,
                'ppuid' => $res->zds_cods->passport->pp_uid,
                'platform_code' => $rider_id,
                'platform'=>$res->platform_name->name,
                'name' => $res->zds_cods->passport->personal_info->full_name,
                'date'=>$res->date_saved,
                'description'=>$res->balance_name->name,
                'amount'=>$res->balance,
                'addition'=>isset($add)?$add:'',
                'subs'=>isset($sub)?$sub:"",
                'balance'=>$current_balance,
            );
            $statement [] = $gamer1;
        }
        $current_bal = $current_balance;
        $name=$res->zds_cods->passport->personal_info->full_name;
        $zds_code=$res->zds_code;
        $ppuid= $res->zds_cods->passport->pp_uid;
        $pdf = PDF::loadView('admin-panel.pdf.ar_balance_pdf.ar_balance_pdf3',  compact('date_between','statement','opening_balance','current_bal',
            'name','zds_code','ppuid','rider_id','date_to','date_from'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');
    }



    public function ar_balance_history()
    {
        $zds_code=UserCodes::all();
        $rider_id=PlatformCode::all();
        $ar_balance_sheet=ArBalanceSheet::orderBy('id', 'desc')->take(50)->get();

        $platforms=Platform::all();
        return view('admin-panel.ar_balance.ar_balance_history',compact('platforms','zds_code'));

    }
    public function import4(Request $request)
    {

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        $salary_sheet = SalaryPaymentHistroy::where('date_from', '>=', $date_from)
            ->where('date_to', '<=', $date_to)->first();
        if ($salary_sheet==null) {
            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                ];
                return redirect()->back()->with($message);
            } else {
                Excel::import(new ArBalanceHistoryImport($date_from, $date_to), request()->file('select_file'));
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
        }
        else{
        $message = [
            'message' => 'Data for these dates has already been uploaded',
            'alert-type' => 'error'

        ];
        return redirect()->back()->with($message);

    }
    }

    //history_detail_code


    public function ar_balance_sheet_detail_history(Request $request){

        $passport=$request->keyword;
        $passport_detail=Passport::where('passport_no',$passport)->first();
        $passport_id=$passport_detail->id;
        $zds_code_detail=UserCodes::where('passport_id',$passport_id)->first();
        $zds_code=$zds_code_detail->zds_code;
        $rout_first_history=route('ar_balance_history_first_pdf',$zds_code);
        $bal_detail=SalaryPaymentHistroy::where('zds_code',$zds_code)->get();

        $count_balance = DB::table('salary_payment_histroys')
            ->select('balance_type')
            ->where('zds_code',$zds_code)
            ->where('balance_type','1')
            ->count();
if ($count_balance=='1') {
    $pre_bal_detail=SalaryPaymentHistroy::where('zds_code', $zds_code)->where('balance_type','1')->first();
    $clos_bal=$pre_bal_detail->balance;
    $open_bal=isset($pre_bal_detail->amount)?$pre_bal_detail->amount:"0";
}

else{
    $pre_bal_detail2=SalaryPaymentHistroy::where('zds_code', $zds_code)
        ->orderBy('created_at', 'desc')
        ->first();
    $open_bal=$pre_bal_detail2->balance;
    $clos_bal=$pre_bal_detail2->amount;
}
        foreach ($bal_detail as $res) {

            if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
            {
                $add = $res->amount;
                $sub="";
                $adj='';
                $other="";
            }
            elseif($res->status=='0' && $res->balance_type=='5'){
                $adj=$res->amount;
                $add="";
                $sub="";
                $other="";
            }
            elseif($res->status=='1' && $res->balance_type=='18'){
                $adj="";
                $add="";
                $sub="";
                $other=$res->amount;
            }
            elseif ($res->status=='1')
            {
                $add = "";
                $adj='';
                $sub=$res->amount;
                $other="";
            }


            $gamer1 = array(
                'zds_code' => $res->zds_code,
                'platform_code' => $res->platform_id,
                'platform'=>$res->platform_id_name,
                'name' => $res->name,
                'date_from'=>$res->date_from,
                'date_to'=>$res->date_to,
                'description'=>$res->balance_name->name,
                'amount'=>$res->amount,
                'addition'=>isset($add)?$add:'',
                'adjustment'=>isset($adj)?$adj:'',
                'other'=>isset($other)?$other:'',
                'subs'=>isset($sub)?$sub:"",
                'balance'=>$res->balance,
                'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
            );
            $statement [] = $gamer1;
        }

//opening balance
        //closing balance

//if ($count_bal=='1'){
//    $opening_balance=$res->amount
//}

        $rider_id = $res->platform_id;
        $name=$res->name;
        $zds_code=$res->zds_code;
        $opening_balance=$open_bal;
        $closing_balance = $clos_bal;


        $view = view("admin-panel.ar_balance.ajax_files.ajax_get_balance_history", compact('bal_detail','first_balance','statement','opening_balance','current_bal','name','zds_code','ppuid','rider_id','rout_first','closing_balance','rout_first_history'))->render();
        return response()->json(['html' => $view]);
    }




    public function ar_balance_between_search_history(Request $request){
        $date_to=$request->input('date_to_search');
        $date_from=$request->input('date_from_search');
        $platform=$request->input('platform_id_search');







//
        if ($platform!=null && $date_to==null && $date_from==null){
            $date_between=SalaryPaymentHistroy::where('platform_id_name',$platform)->get();
            if (count($date_between)=='0'){
                $statement=$date_between;
                $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_history",
                    compact('date_between', 'statement','date_from','date_to'))->render();
                return response()->json(['html' => $view]);
            }







            foreach ($date_between as $res) {

                if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
                {
                    $add = $res->amount;
                    $sub="";
                    $adj='';
                    $other="";
                }
                elseif($res->status=='0' && $res->balance_type=='5'){
                    $adj=$res->amount;
                    $add="";
                    $sub="";
                    $other="";
                }
                elseif($res->status=='1' && $res->balance_type=='18'){
                    $adj="";
                    $add="";
                    $sub="";
                    $other=$res->amount;
                }
                elseif ($res->status=='1')
                {
                    $add = "";
                    $adj='';
                    $sub=$res->amount;
                    $other="";
                }
                $gamer1 = array(
                    'zds_code' => $res->zds_code,
                    'platform_code' => $res->platform_id,
                    'platform'=>$res->platform_id_name,
                    'name' => $res->name,
                    'date_from'=>$res->date_from,
                    'date_to'=>$res->date_to,
                    'description'=>$res->balance_name->name,
                    'amount'=>$res->amount,
                    'addition'=>isset($add)?$add:'',
                    'adjustment'=>isset($adj)?$adj:'',
                    'other'=>isset($other)?$other:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$res->balance,
                    'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
                );
                $statement [] = $gamer1;

            }






            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_history",
                compact('date_between', 'statement','date_from','date_to'))->render();
            return response()->json(['html' => $view]);

        }
//
//        $salary_sheet = SalaryPaymentHistroy::where('date_from', '>=', $date_from)
//            ->where('date_to', '<=', $date_to)->first();


        if ($platform!=null){
            $date_between=SalaryPaymentHistroy::where('date_from', '>=', $date_from)->where('date_to', '<=', $date_to)->where('platform_id_name',$platform)->get();
            if (count($date_between)=='0'){
                $statement=$date_between;
                $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_history",
                    compact('date_between', 'statement','date_from','date_to'))->render();
                return response()->json(['html' => $view]);
            }
            foreach ($date_between as $res) {
                if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
                {
                    $add = $res->amount;
                    $sub="";
                    $adj='';
                    $other="";
                }
                elseif($res->status=='0' && $res->balance_type=='5'){
                    $adj=$res->amount;
                    $add="";
                    $sub="";
                    $other="";
                }
                elseif($res->status=='1' && $res->balance_type=='18'){
                    $adj="";
                    $add="";
                    $sub="";
                    $other=$res->amount;
                }
                elseif ($res->status=='1')
                {
                    $add = "";
                    $adj='';
                    $sub=$res->amount;
                    $other="";
                }
                $gamer1 = array(
                    'zds_code' => $res->zds_code,
                    'platform_code' => $res->platform_id,
                    'platform'=>$res->platform_id_name,
                    'name' => $res->name,
                    'date_from'=>$res->date_from,
                    'date_to'=>$res->date_to,
                    'description'=>$res->balance_name->name,
                    'amount'=>$res->amount,
                    'addition'=>isset($add)?$add:'',
                    'adjustment'=>isset($adj)?$adj:'',
                    'other'=>isset($other)?$other:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$res->balance,
                    'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
                );
                $statement [] = $gamer1;

            }






            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_history",
                compact('date_between', 'statement','date_from','date_to'))->render();
            return response()->json(['html' => $view]);
        }
        else{

            $date_between=SalaryPaymentHistroy::where('date_from', '>=', $date_from)->where('date_to', '<=', $date_to)->get();
            if (count($date_between)=='0'){
                $statement=$date_between;
                $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_history",
                    compact('date_between', 'statement','date_from','date_to'))->render();
                return response()->json(['html' => $view]);
            }
            foreach ($date_between as $res) {
                if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
                {
                    $add = $res->amount;
                    $sub="";
                    $adj='';
                    $other="";
                }
                elseif($res->status=='0' && $res->balance_type=='5'){
                    $adj=$res->amount;
                    $add="";
                    $sub="";
                    $other="";
                }
                elseif($res->status=='1' && $res->balance_type=='18'){
                    $adj="";
                    $add="";
                    $sub="";
                    $other=$res->amount;
                }
                elseif ($res->status=='1')
                {
                    $add = "";
                    $adj='';
                    $sub=$res->amount;
                    $other="";
                }
                $gamer1 = array(
                    'zds_code' => $res->zds_code,
                    'platform_code' => $res->platform_id,
                    'platform'=>$res->platform_id_name,
                    'name' => $res->name,
                    'date_from'=>$res->date_from,
                    'date_to'=>$res->date_to,
                    'description'=>$res->balance_name->name,
                    'amount'=>$res->amount,
                    'addition'=>isset($add)?$add:'',
                    'adjustment'=>isset($adj)?$adj:'',
                    'other'=>isset($other)?$other:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$res->balance,
                    'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
                );
                $statement [] = $gamer1;
            }
            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_history",
                compact('date_between', 'statement','date_from','date_to'))->render();
            return response()->json(['html' => $view]);
        }
    }




    public function ar_balance_between_user_history(Request $request){
        $zds_code_user=$request->input('zds_code_user');
        $date_to=$request->input('date_to_user');
        $date_from=$request->input('date_from_user');
        $platform_id_search_user=$request->input('platform_id_search_user');




        $rider_id="N/A";
        $date_between=SalaryPaymentHistroy::where('date_from', '>=', $date_from)->where('date_to', '<=',$date_to)->where('zds_code',$zds_code_user)->get();


        $count_balance = DB::table('salary_payment_histroys')
            ->select('balance_type')
            ->where('zds_code',$zds_code_user)
            ->where('balance_type','1')
            ->count();


        if ($count_balance=='1') {
            $pre_bal_detail=SalaryPaymentHistroy::where('zds_code', $zds_code_user)->where('balance_type','1')->first();
            $clos_bal=$pre_bal_detail->balance;
            $open_bal=isset($pre_bal_detail->amount)?$pre_bal_detail->amount:"0";
        }

        else{
            $pre_bal_detail2=SalaryPaymentHistroy::where('zds_code', $zds_code_user)
                ->orderBy('created_at', 'desc')
                ->first();
            $open_bal=$pre_bal_detail2->balance;
            $clos_bal=$pre_bal_detail2->amount;

        }


        if (count($date_between)=='0'){

//            if no AR Balance is available then it should show the empty row
            $current_bal = "N/A";
            $name=isset($res->zds_cods->passport->personal_info->full_name)?$res->zds_cods->passport->personal_info->full_name:"N/A";
            $zds_code=isset($res->zds_code)?$res->zds_code:"N/A";
            $ppuid= isset($res->zds_cods->passport->pp_uid)?$res->zds_cods->passport->pp_uid:"N/A";
            $opening_balance= "N/A";
            $closing_balance= "N/A";

            $statement=$date_between;

            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_user_history", compact('statement','opening_balance','current_bal',
                'name','zds_code','ppuid','rider_id','date_to','date_from','closing_balance'))->render();
            return response()->json(['html' => $view]);


        }

        elseif ($platform_id_search_user!=null){

            $date_between2=SalaryPaymentHistroy::where('date_from', '>=', $date_from)->where('date_to', '<=',$date_to)
                ->where('zds_code',$zds_code_user)
                ->where('platform_id_name',$platform_id_search_user)
                ->get();
            foreach ($date_between as $res) {
                if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
                {
                    $add = $res->amount;
                    $sub="";
                    $adj='';
                    $other="";
                }
                elseif($res->status=='0' && $res->balance_type=='5'){
                    $adj=$res->amount;
                    $add="";
                    $sub="";
                    $other="";
                }
                elseif($res->status=='1' && $res->balance_type=='18'){
                    $adj="";
                    $add="";
                    $sub="";
                    $other=$res->amount;
                }
                elseif ($res->status=='1')
                {
                    $add = "";
                    $adj='';
                    $sub=$res->amount;
                    $other="";
                }
                $gamer1 = array(
                    'zds_code' => $res->zds_code,
                    'platform_code' => $res->platform_id,
                    'platform'=>$res->platform_id_name,
                    'name' => $res->name,
                    'date_from'=>$res->date_from,
                    'date_to'=>$res->date_to,
                    'description'=>$res->balance_name->name,
                    'amount'=>$res->amount,
                    'addition'=>isset($add)?$add:'',
                    'adjustment'=>isset($adj)?$adj:'',
                    'other'=>isset($other)?$other:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$res->balance,
                    'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
                );
                $statement [] = $gamer1;


            }



            $rider_id = $res->platform_id;
            $name=$res->name;
            $zds_code=$res->zds_code;
            $opening_balance=$open_bal;
            $closing_balance = $clos_bal;


            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_user_history", compact('date_between','statement','opening_balance','current_bal',
                'name','zds_code','ppuid','rider_id','date_to','date_from','closing_balance'))->render();
            return response()->json(['html' => $view]);

        }

        else{
            foreach ($date_between as $res) {
                if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
                {
                    $add = $res->amount;
                    $sub="";
                    $adj='';
                    $other="";
                }
                elseif($res->status=='0' && $res->balance_type=='5'){
                    $adj=$res->amount;
                    $add="";
                    $sub="";
                    $other="";
                }
                elseif($res->status=='1' && $res->balance_type=='18'){
                    $adj="";
                    $add="";
                    $sub="";
                    $other=$res->amount;
                }
                elseif ($res->status=='1')
                {
                    $add = "";
                    $adj='';
                    $sub=$res->amount;
                    $other="";
                }
                $gamer1 = array(
                    'zds_code' => $res->zds_code,
                    'platform_code' => $res->platform_id,
                    'platform'=>$res->platform_id_name,
                    'name' => $res->name,
                    'date_from'=>$res->date_from,
                    'date_to'=>$res->date_to,
                    'description'=>$res->balance_name->name,
                    'amount'=>$res->amount,
                    'addition'=>isset($add)?$add:'',
                    'adjustment'=>isset($adj)?$adj:'',
                    'other'=>isset($other)?$other:'',
                    'subs'=>isset($sub)?$sub:"",
                    'balance'=>$res->balance,
                    'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
                );
                $statement [] = $gamer1;


            }



            $rider_id = $res->platform_id;
            $name=$res->name;
            $zds_code=$res->zds_code;
            $opening_balance=$open_bal;
            $closing_balance = $clos_bal;


            $view = view("admin-panel.ar_balance.ajax_files.ajax_date_between_user_history", compact('date_between','statement','opening_balance','current_bal',
                'name','zds_code','ppuid','rider_id','date_to','date_from','closing_balance'))->render();
            return response()->json(['html' => $view]);
        }

    }

//    ar balance history pdf
    public function ar_balance_history_first_pdf($id){

        $zds_code=$id;
        $bal_detail=SalaryPaymentHistroy::where('zds_code',$zds_code)->get();


        $count_balance = DB::table('salary_payment_histroys')
            ->select('balance_type')
            ->where('zds_code',$zds_code)
            ->where('balance_type','1')
            ->count();


        if ($count_balance=='1') {
            $pre_bal_detail=SalaryPaymentHistroy::where('zds_code', $zds_code)->where('balance_type','1')->first();
            $clos_bal=$pre_bal_detail->balance;
            $open_bal=isset($pre_bal_detail->amount)?$pre_bal_detail->amount:"0";
        }

        else{
            $pre_bal_detail2=SalaryPaymentHistroy::where('zds_code', $zds_code)
                ->orderBy('created_at', 'desc')
                ->first();
            $open_bal=$pre_bal_detail2->balance;
            $clos_bal=$pre_bal_detail2->amount;

        }








        foreach ($bal_detail as $res) {

            if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
            {
                $add = $res->amount;
                $sub="";
                $adj='';
                $other="";
            }
            elseif($res->status=='0' && $res->balance_type=='5'){
                $adj=$res->amount;
                $add="";
                $sub="";
                $other="";
            }
            elseif($res->status=='1' && $res->balance_type=='18'){
                $adj="";
                $add="";
                $sub="";
                $other=$res->amount;
            }
            elseif ($res->status=='1')
            {
                $add = "";
                $adj='';
                $sub=$res->amount;
                $other="";
            }
            $gamer1 = array(
                'zds_code' => $res->zds_code,
                'platform_code' => $res->platform_id,
                'platform'=>$res->platform_id_name,
                'name' => $res->name,
                'date_from'=>$res->date_from,
                'date_to'=>$res->date_to,
                'description'=>$res->balance_name->name,
                'amount'=>$res->amount,
                'addition'=>isset($add)?$add:'',
                'adjustment'=>isset($adj)?$adj:'',
                'other'=>isset($other)?$other:'',
                'subs'=>isset($sub)?$sub:"",
                'balance'=>$res->balance,
                'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
            );
            $statement [] = $gamer1;
        }

//opening balance
        //closing balance

//if ($count_bal=='1'){
//    $opening_balance=$res->amount
//}

        $rider_id = $res->platform_id;
        $name=$res->name;
        $zds_code=$res->zds_code;
        $opening_balance=$open_bal;
        $closing_balance = $clos_bal;


        $pdf = PDF::loadView('admin-panel.pdf.ar_balance_pdf.ar_balance_pdf1_history', compact('statement','current_bal','name','zds_code','ppuid','rider_id','bal_detail','opening_balance','closing_balance'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');

    }

    public function ar_balance_history_second_pdf($date_from,$date_to){
        $date_between=SalaryPaymentHistroy::where('date_from', '>=', $date_from)->where('date_to', '<=', $date_to)->get();

        foreach ($date_between as $res) {
            if ($res->status == '0' && $res->balance_type!='5' && $res->balance_type!='18' && $res->balance_type!='1')
            {
                $add = $res->amount;
                $sub="";
                $adj='';
                $other="";
            }
            elseif($res->status=='0' && $res->balance_type=='5'){
                $adj=$res->amount;
                $add="";
                $sub="";
                $other="";
            }
            elseif($res->status=='1' && $res->balance_type=='18'){
                $adj="";
                $add="";
                $sub="";
                $other=$res->amount;
            }
            elseif ($res->status=='1')
            {
                $add = "";
                $adj='';
                $sub=$res->amount;
                $other="";
            }
            $gamer1 = array(
                'zds_code' => $res->zds_code,
                'platform_code' => $res->platform_id,
                'platform'=>$res->platform_id_name,
                'name' => $res->name,
                'date_from'=>$res->date_from,
                'date_to'=>$res->date_to,
                'description'=>$res->balance_name->name,
                'amount'=>$res->amount,
                'addition'=>isset($add)?$add:'',
                'adjustment'=>isset($adj)?$adj:'',
                'other'=>isset($other)?$other:'',
                'subs'=>isset($sub)?$sub:"",
                'balance'=>$res->balance,
                'amount_paid'=>isset($res->amount_paid)?$res->amount_paid:"0",
            );
            $statement [] = $gamer1;
        }

        $pdf = PDF::loadView('admin-panel.pdf.ar_balance_pdf.ar_balance_pdf2_history', compact('statement','current_bal','name','zds_code','ppuid','rider_id','bal_detail','opening_balance','closing_balance'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');
    }
 // $obj->remarks = $request->input('remarks');
    public function add_assigning_amount(Request $request){


        $passport= Passport::where('passport_no',$request->passport_number)->first();
        $passport_id=$passport->id;
        $agreed_amounts= AgreedAmount::where('passport_id', $passport_id)->first();
        $AssigningAmount= AssigningAmount::where('passport_id',$passport_id)->where('master_step_id',$request->visa_step)->first();
        if(empty($AssigningAmount)){
            $AssigningAmount= AssigningAmount::where('passport_id',$passport_id)->where('rn_step_id',$request->visa_step)->first();
        }






//------------------for amount payment--------------------------
//------------------for amount payment--------------------------
            if($request->input('pay_status')== '1' ){
                    $obj = AssigningAmount::find($AssigningAmount->id);
                    $obj->pay_status ='1';
//if any partial amount
                    $obj->partial_amount_status =$request->pay_option_partial;
                    $obj->partial_amount_step =$request->visa_step_amount_partial;
                    $obj->partial_amount =$request->parital_amount;

                    $object= new ArBalanceSheet();
                    $object->passport_id=$passport->id;
                    $object->date_saved=date("Y-m-d");
                    $object->balance_type='65';
                    $object->balance=$obj->amount;
                    $object->visa_process_step_id=$obj->master_step_id;
                    $object->status='1';
                    $object->save();

                    $obj->save();
                    return response()->json([
                        'code' => "100",
                    ]);
            }

//----------------------for amount unpaid----------------
//----------------------for amount unpaid----------------
//----------------------for amount unpaid----------------

            if($request->input('pay_status')== '2'  &&  $request->input('pay_option')=='1'){

                $obj = AssigningAmount::find($AssigningAmount->id);
                $obj->pay_status ='2';
                $obj->unpaid_status='1';
                $obj->pay_at = $request->input('visa_step_amount_pay_at');
                $obj->remarks = $request->input('remarks');
                $obj->save();




                return response()->json([
                    'code' => "100",
                ]);
            }
                            //---for payroll deduction
            if($request->input('pay_status')== '2'  &&  $request->input('pay_option')=='2'){

                $obj = AssigningAmount::find($AssigningAmount->id);
                $obj->pay_status ='2';
                $obj->unpaid_status='2';
                $obj->remarks = $request->input('remarks');
                $obj->save();
                return response()->json([
                    'code' => "100",
                ]);
            }


//-----------------------for payrolldeduction------------
//-----------------------for payrolldeduction------------
//-----------------------for payrolldeduction------------

        // if(empty($AssigningAmount) && $request->pay_status=='1' ){
        //             $obj = new AssigningAmount();
        //             $obj->amount = $request->input('amount');
        //             $obj->master_step_id = $request->visa_step;
        //             $obj->passport_id = $passport_id;
        //             $obj->agreed_amount_id = isset($agreed_amounts)?$agreed_amounts->id:'';
        //             $obj->pay_status = $request->input('pay_status');
        //             $obj->save();
        //             return response()->json([
        //                 'code' => "100",
        //             ]);
        //         }
        //         elseif(empty($AssigningAmount) && $request->pay_status=='2' ){
        //             $obj = new AssigningAmount();
        //             $obj->master_step_id = $request->visa_step;
        //             $obj->passport_id = $passport_id;
        //             $obj->agreed_amount_id = isset($agreed_amounts)?$agreed_amounts->id:'';
        //             $obj->pay_status = $request->input('pay_status');
        //             $obj->unpaid_status = $request->input('pay_option');
        //             $obj->pay_at = $request->input('visa_step_amount_pay_at');
        //             $obj->remarks = $request->input('remarks');
        //             $obj->save();
        //             return response()->json([
        //                 'code' => "100",
        //             ]);
        //         }
        //         else{
        //             $obj = AssigningAmount::find($AssigningAmount->id);
        //             $obj->amount = $request->input('amount');
        //             $obj->pay_status = $request->input('pay_status');
        //             $obj->unpaid_status = $request->input('pay_option');
        //             $obj->pay_at = $request->input('visa_step_amount_pay_at');
        //             $obj->remarks = $request->input('remarks');
        //             $obj->save();
        //             return response()->json([
        //                 'code' => "100",
        //             ]);
        //         }

        // if step amount already exists updatenew
        // else
        // addnew





    }

    public function assigning_detail(Request $request){
            $visa_steps=null;
            $visa_steps2=null;

           $passport_no= $request->keyword;
           $passport=Passport::where('passport_no',$passport_no)->first();
           $passport_id=$passport->id;
           $assgin_amount=AssigningAmount::where('passport_id',$passport_id)->get();
           $assgin_amount_array=AssigningAmount::where('passport_id',$passport_id)->where('pay_status','=','1')->get();
           $process_array = array();
           $pay_roll_deduct=AgreedAmount::where('passport_id',$passport_id)->first();
           $pay_roll=isset($pay_roll_deduct->payroll_deduct_amount)?$pay_roll_deduct->payroll_deduct_amount:'';
           foreach ($assgin_amount_array as $let){
               $process_array [] = $let->master_step_id;
           }
        //    dd($process_array);

           $name=$passport->personal_info->full_name;
           $ppuid=isset($passport->pp_uid)?$passport->pp_uid:'N/A';

           $assigned_detail=AssigningAmount::where('passport_id',$passport_id)
           ->where('pay_status',null)
           ->where('rn_step_id',null)
           ->pluck('master_step_id')
           ->toArray();

           if (sizeof($assigned_detail)=='0'){


            $renew_visa_assign=AssigningAmount::where('passport_id',$passport_id)->where('rn_pay_status',null)->pluck('rn_step_id')->toArray();

            $visa_steps2=  RenewVisaSteps::whereIn('id',$renew_visa_assign)->get();
           }
           else{
           $visa_steps=  Master_steps::whereIn('id',$assigned_detail)->get();
           }
        //    dd($visa_steps);
        //    $visa_steps->shift(0);



            $view2 = view("admin-panel.ar_balance.ajax_files.steps_detail",
            compact('visa_steps','visa_steps2'))->render();

            $view = view("admin-panel.ar_balance.ajax_files.assign_amount_detail",
            compact('assgin_amount','passport_no','name','ppuid','pay_roll'))->render();

           return response()->json(['html' => $view,'html2'=>$view2]);

    }
    public function get_assign_amount(Request $request){

        $passport_number=$request->passport_number;
        $step=$request->textval;

        $passport=Passport::where('passport_no',$passport_number)->first();
        $passport_id=$passport->id;

        $amount=AssigningAmount::where('passport_id',$passport_id)->where('master_step_id',$step)->first();

        if(!empty($amount)){
            $step_amount=$amount->amount;

        }
        else{
            $step_amount='';
        }




        return response()->json(['data' => $step_amount]);

    }


public function show_visa_expense(){

    return view('admin-panel.ar_balance.visa_process_expense');
}


public function ar_balance_visa_expense(Request $request){

    $passport=$request->keyword;

    $passport_detail=Passport::where('passport_no',$passport)->first();

    $passport_id=$passport_detail->id;


     $rout_first=route('ar_balance_first_pdf',$passport_id);




//   $bal_detail=ArBalanceSheet::where('passport_id',$passport_id)->get();
  $bal_detail=VisaPaymentOptions::where('passport_id',$passport_id)->get();





  $first_balance=AgreedAmount::where('passport_id',$passport_id)->first();

  $current_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
  $opening_balance = isset($first_balance->final_amount) ? $first_balance->final_amount : 0;
  if (count($bal_detail)=='0'){

      $myVariable = '<div class="col-md-4"></div><div class="col-md-4"><b class="text-center">Data not available for this Platform</b></div><div class="col-md-4"></div>';
      return response()->json(['html' => $myVariable]);
//                return redirect()->back()->with($message);
  }

  foreach ($bal_detail as $res) {
      $passport_detail = Passport::where('id', $res->passport_id)->first();
      $rider_id = isset($passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code) ? $passport_detail->get_the_rider_id_by_platform($res->platform_id)->platform_code : 'N/A';


      if ($res->status == '0')
      {

          $current_balance = $current_balance + $res->balance;
      }
      else
      {
          $current_balance = $current_balance - $res->balance;
      }


      if ($res->visa_process_step_id == null)
      {

          $des ='Own Visa '.$res->master_own->step_name;
      }
      else
      {
          $des = $res->master->step_name;
      }



      $gamer1 = array(
          'ppuid' => $res->passport->pp_uid,
          'name' => $res->passport->personal_info->full_name,
          'date'=>$res->created_at,
          'description'=>$des,
          'amount'=>$res->payment_amount,

      );
      $statement [] = $gamer1;


  }
  $current_bal = $current_balance;
  $name=$res->passport->personal_info->full_name;

  $ppuid= $res->passport->pp_uid;


  $view = view("admin-panel.ar_balance.ajax_files.get_visa_expense", compact('bal_detail','first_balance','statement','opening_balance','current_bal','name','ppuid','rider_id','rout_first'))->render();
  return response()->json(['html' => $view]);
}



}
