<?php

namespace App\Model\Guest;
use App\Model\Assign\AssignPlateform;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\DiscountName\DiscountName;
use App\Model\Guest\Career;
use App\Model\Master_steps;
use App\Model\Nationality;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\OnBoardStatus\OnBoardStatusForm;
use App\Model\OnBoardStatus\OnBoardStatusType;
use App\Model\Passport\Passport;
use App\Model\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DateTime;
use Carbon\Carbon;

class OnBoardController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|onboard-view|Hiring-pool', ['only' => ['index','store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|onboard-accident-vacation|Hiring-pool', ['only' => ['vacation_accident_rider']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assign_platforms_passport = AssignPlateform::
                                join('passports','assign_plateforms.passport_id','=','passports.id')
                                ->select('passports.id')
                                ->where('assign_plateforms.status','=','1')
                                ->pluck('passports.id')->toArray();

         $career_id = Passport::whereIn('id',$assign_platforms_passport)->pluck('career_id')->toArray();

//         $onboards = CreateInterviews::where('interview_status','=','1')->whereNotIn('career_id',$career_id)->get();

    $onboards = OnBoardStatus::where('interview_status','=','1')->where('assign_platform','=','1')->where('on_board','=','1')->get();

    $employee_type_array = ['','Company','FourPl'];

        $discount_names = DiscountName::orderby('id','desc')->get();
        $master_steps = Master_steps::where('id','!=','1')->get();
        $nationalities = Nationality::all();


         return view('admin-panel.on_board.index',compact('nationalities','master_steps','discount_names','employee_type_array','onboards'));
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

        return view('admin-panel.on_board.index',compact('employee_type_array','onboards'));

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
