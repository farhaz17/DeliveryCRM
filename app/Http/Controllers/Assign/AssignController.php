<?php

namespace App\Http\Controllers\Assign;

use App\DcLimit\DcLimit;
use App\Model\Agreement\Agreement;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Assign\OfficeSimAssign;
use App\Model\Assign\SimAssignType;
use App\Model\AssingToDc\AssignToDc;
use App\Model\BikeDetail;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\Career\RejoinCareer;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Master\CategoryAssign;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\OwnSimBikeHistory;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Platform;
use App\Model\PlatformCode\PlatformCode;
use App\Model\Referal\Referal;
use App\Model\Referal\ReferralSetting;
use App\Model\ReserveBike\ReserveBike;
use App\Model\Setting\Setting;
use App\Model\SimReplacement\SimReplacement;
use App\Model\Telecome;
//use App\Model\VerificationAssignment\VerificationAssignment;
use App\Model\UserCodes\UserCodes;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\BoxInstall\BoxInstallation;
use App\Model\SimCancel;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\DocBlock\Tags\Covers;
use DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class AssignController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|assignment-sim-assignment-view|assignment-sim-assignment', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|assignment-sim-assignment', ['only' => ['store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|assignment-platform-assignment', ['only' => ['plateform_assign']]);
        $this->middleware('role_or_permission:Admin|assignment-office-sim-assignment', ['only' => ['office_sim_assign']]);
        $this->middleware('role_or_permission:Admin|assignment-bike-assignment', ['only' => ['bike_assign']]);


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $cancel_sim_id  = SimCancel::where('status','=','1')->pluck('sim_id')->toArray();

        $sims=Telecome::whereNotIn('id',$cancel_sim_id)->get();
        $passport=Passport::all();
        $sim = Telecome::select('telecomes.*')
            ->leftjoin('assign_sims', 'assign_sims.sim', '=', 'telecomes.id')
            ->where('assign_sims.status','=',1)
            ->orwhere('telecomes.reserve_status','=',1)
            ->get();
        //getting assinged sim details
        $checkedin = array();
        foreach ($sim as $x) {
            $checkedin [] = $x->id;
        }
        $checked_out = array();
        foreach ($sims as $ab) {
            if (!in_array($ab->id, $checkedin)) {
                $gamer = array(
                    'sim_number' => $ab->account_number,
                    'id' => $ab->id,
                );
                $checked_out [] = $gamer;
            }
        }
        $assign_sim=AssignSim::with(['plateform' => function ($query) {
            $query->where('status', '=', '1');
        }])->get();
        $assign_type=SimAssignType::all();
        if($request->ajax()){
            if($request->filter_by=="1"){
                //passport number
                $searach = '%'.$request->keyword.'%';
                $passport = Passport::where('passport_no','like',$searach)->pluck('id')->toArray();

                $assign_sim=AssignSim::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id',$passport)
                    ->get();

            }elseif($request->filter_by=="2"){
                //name
                $searach = '%'.$request->keyword.'%';
                $passport  = passport_addtional_info::where('full_name','like',$searach)->pluck('passport_id')->toArray();

                $assign_sim=AssignSim::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id',$passport)
                    ->get();

            }elseif($request->filter_by=="3"){
                //ppuid

                $searach = '%'.$request->keyword.'%';
                $passport = Passport::where('pp_uid','like',$searach)->pluck('id')->toArray();

                $assign_sim=AssignSim::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id',$passport)
                    ->get();
            }elseif($request->filter_by=="4"){
                //zds code
                $searach = '%'.$request->keyword.'%';
                $passport = UserCodes::where('zds_code','like',$searach)->pluck('passport_id')->toArray();

                $assign_sim=AssignSim::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id',$passport)
                    ->get();
            }elseif($request->filter_by=="5"){
                //sim number

                $searach = '%'.$request->keyword.'%';
                $sim_ids = Telecome::where('account_number','like',$searach)->pluck('id')->toArray();

                $assign_sim=AssignSim::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('sim',$sim_ids)
                    ->get();

            }elseif($request->filter_by=="6"){
                //platform

                $searach = '%'.$request->keyword.'%';

                $platform_ids = Platform::where('name','like',$searach)->pluck('id')->toArray();
                $passsport = AssignPlateform::whereIn('plateform',$platform_ids)->pluck('passport_id')->toArray();

                $assign_sim=AssignSim::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id',$passsport)
                    ->get();


            }
            elseif($request->filter_by=="7"){
                // Assign To
                $searach = '%'.$request->keyword.'%';

               $assign_type = SimAssignType::where('name','like',$searach)->pluck('id')->toArray();

                $assign_sim=AssignSim::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('assigned_to',$assign_type)
                    ->get();

            }elseif($request->filter_by=="8"){
                // empty the table remove filter

                $assign_sim = [];

            }



            $row_column = [];

            $dt = Datatables::of($assign_sim);

            $dt->addColumn('passport_number', function (AssignSim $sim) {
                return $sim->passport->passport_no;
            });

            $dt->addColumn('ppuid', function (AssignSim $sim) {
                return $sim->passport->pp_uid;
            });

            $dt->addColumn('zds_code', function (AssignSim $sim) {
                return isset($sim->passport->zds_code->zds_code) ? $sim->passport->zds_code->zds_code : "";
            });

            $dt->addColumn('name', function (AssignSim $sim) {
                return $sim->passport->personal_info->full_name;
            });

            $dt->addColumn('sim', function (AssignSim $sim) {
                $sim_number = isset($sim->telecome->account_number) ? $sim->telecome->account_number : "";

                $row_column [] =  'sim';
                return $sim_number;
            });

            $dt->addColumn('platform', function (AssignSim $sim) {
                $ab = '';
                $name = '';
                if(isset($sim->plateform[0])) {
                    $name = $sim->plateform[0]->plateformdetail->name;
                    $ab =  '<span>'.$name.'</span>';
                }else{
                    $ab = '<span>N/A</span>';
                }
                $row_column [] =  'platform';
                return $ab;
            });

            $dt->addColumn('assign_to', function (AssignSim $sim) {

                return isset($sim->assign_to->name) ? $sim->assign_to->name : "";
            });





                $dt->addColumn('action', function (AssignSim $sim) {
                    $disyplay = '';
                    $ab = '';
                    if($sim->status==0){

                        $ab = '<span class="badge badge-success">Checked Out</span>';
                    }else{
                        $route = route('sim_pdf',$sim->id);

                        $ab = '<a  class="text-success mr-2 sim_btn_cls"   id="'.$sim->id.'" href="javascript:void(0)">
                                                    <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>
                                                                <a href="'.$route.'" target="_blank"><i class="fa fa-print"></i></a>
                                                            </a>';

                    }




                    return $ab;

                });


            $dt->rawColumns(['platform','action']);
            return $dt->make(true);
        }
        $assign_sim = AssignSim::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray();
        $pending_passsports = AssignPlateform::where('status','=','1')->whereNotIn('passport_id',$assign_sim)->orderby('updated_at','asc')->get();
        $pending_passsports_to_checkout = AssignSim::where('status','=','1')->orderby('updated_at','asc')->get();
        return view('admin-panel.assigning.sim_assign',compact('passport','assign_sim','assign_type','checked_out','pending_passsports','pending_passsports_to_checkout'));
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

        //sim assignments here


        $sim_detail_already = Telecome::where('id','=',$request->input('sim'))->first();

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
        $sim_detail_already_two = Telecome::where('id','=',$request->input('sim'))->where('status','=','1')->first();

        if($sim_detail_already_two != null){

            if($exist_sim_detail != null){
                $message = [
                    'message' => 'This Sim is already assigned',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

            }
        }

        $sim_own_history = OwnSimBikeHistory::where('passport_id','=',$request->passport_id_selected)->where('own_type','=','1')->where('status','=','1')->first();

        if($sim_own_history != null){

                $message = [
                    'message' => 'This rider have own Sim.',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
        }

//        $bike_reserved = ReserveBike::where('passport_id','=',$request->passport_id_selected)
//            ->where('assign_status','=','0')
//            ->orwhere('sim_assign_status','=','0')->first();
//
//        if($bike_reserved != null){
//
//            $message = [
//                'message' => 'This rider have already one reserved sim.!',
//                'alert-type' => 'error'
//            ];
//            return redirect()->back()->with($message);
//        }





        $request->passport_id_selected;
        $agreement=Agreement::where('passport_id',$request->passport_id_selected)->where('status','1')->first();
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


        $pass_id = $request->passport_id_selected;
        if($request->rider_type=="1"){

                            $assign_plat = AssignPlateform::where('passport_id','=',$pass_id)->where('status','=','1')->first();
                            if($assign_plat==null){
                                $message = [
                                    'message' => 'Platform is not Assigned, please assign platform',
                                    'alert-type' => 'error'
                                ];
                                return redirect()->back()->with($message);
                            }


                            $now_date_time =  date('Y-m-d H:i:s', strtotime($request->checkin));

                            $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $now_date_time);
                            $date2 = Carbon::createFromFormat('Y-m-d H:i:s',  $assign_plat->checkin);

                            $result_date = $date1->eq($date2);

                            if($result_date){
                                $message = [
                                    'message' => 'Bike Checkin date and Time should not Less than platform checkin time',
                                    'alert-type' => 'error'
                                ];
                                return redirect()->back()->with($message);
                            }

        }







        $assign_plat = SimReplacement::where('passport_id','=',$pass_id)->where('status','=','1')->first();
        if($assign_plat!=null){
            $message = [
                'message' => 'Sim Replacement is not checkout yet, please checkout sim replacement',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }



        $pass_id= $pass_id;
        $sim_id=$request->input('sim');
        $assigned_to=$request->input('assigned_to');

        $assigned_id=AssignSim::where('passport_id',$pass_id)->count();
        $checkout_detail=AssignSim::where('passport_id',$pass_id)->latest('created_at')->first();
//        dd($checkout_detail);

      if ($assigned_to=='2' ||$assigned_to=='3'||$assigned_to=='5'){

          $user_id = Auth::user()->id;
          $reserve_bike = ReserveBike::where('sim_id','=',$sim_id)->where('sim_assign_status','=','0')->first();

          if($reserve_bike != null){
              $message = [
                  'message' => 'This sim is reserved for rider',
                  'alert-type' => 'error'
              ];
              return redirect()->back()->with($message);
          }



            $obj = new AssignSim();
            $obj->passport_id = $pass_id;
            $obj->sim = $request->input('sim');
            $obj->assigned_to = $request->input('assigned_to');
            $obj->checkin = $request->input('checkin');
            $obj->rider_type = $request->rider_type;
            $obj->status = '1';
            $obj->save();
             DB::table('telecomes')->where('id',$sim_id)
              ->update(['status' => '1']);



                $message = [
                    'message' => 'SIM Assigned Successfully',
                    'alert-type' => 'success'
                ];
                return back()->with($message);
            }

        else if ($assigned_id >= 1 &&  $checkout_detail->status =='1') {
            $message = [
                'message' => 'Not Checked Out',
                'alert-type' => 'error'
            ];

            return back()->with($message);
        }



    else if ($assigned_id >=1 &&  $checkout_detail->status =='0'){

        $user_id = Auth::user()->id;
        $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('sim_assign_status','=','0')->first();

        if($reserve_bike != null){
            if($reserve_bike->sim_id==$request->input('sim')){
                $reserve_bike->sim_assign_status  = "1";
                $reserve_bike->assigned_by  = $user_id;
                $reserve_bike->update();
            }else{
                $message = [
                    'message' => 'Please assign same sim that reserved For this rider',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
        }


    $obj = new AssignSim();
    $obj->passport_id = $pass_id;
    $obj->sim = $request->input('sim');
    $obj->assigned_to = $request->input('assigned_to');
    $obj->checkin = $request->input('checkin');
    $obj->rider_type = $request->rider_type;
    $obj->status = '1';
    $obj->save();

        DB::table('telecomes')->where('id',$sim_id)
            ->update(['status' => '1']);


//    DB::table('telecomes')->where('account_number', $account_number->account_number)
//        ->update(['status' => '1']);



    $message = [
        'message' => 'SIM Assigned Successfully',
        'alert-type' => 'success'
    ];


        return back()->with($message);

}
else{



    $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('sim_assign_status','=','0')->first();

    $user_id = Auth::user()->id;
    $reserve_bike_check = ReserveBike::where('sim_id','=',$sim_id)->where('sim_assign_status','=','0')->first();

    if($reserve_bike != null){
        if($reserve_bike->sim_id==$request->input('sim')){
            $reserve_bike->sim_assign_status  = "1";
            $reserve_bike->assigned_by  = $user_id;
            $reserve_bike->update();
        }else{
            $message = [
                'message' => 'Please assign same sim that reserved For this rider',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }elseif($reserve_bike_check != null){

        $message = [
            'message' => 'This sim is already reserved for rider',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($message);

    }

    $obj = new AssignSim();
    $obj->passport_id = $pass_id;
    $obj->sim = $request->input('sim');
    $obj->assigned_to = $request->input('assigned_to');
    $obj->checkin = $request->input('checkin');
    $obj->rider_type = $request->rider_type;
    $obj->status = '1';
    $obj->save();

    DB::table('telecomes')->where('id',$sim_id)
        ->update(['status' => '1']);



//
//    DB::table('telecomes')->where('account_number', $account_number->account_number)
//        ->update(['status' => '1']);

    $message = [
        'message' => 'SIM Assigned Successfully',
        'alert-type' => 'success'
    ];


    return back()->with($message);
}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
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
        $checkout=AssignSim::find($id);
        $passport=Passport::all();
        $sim_exists=AssignSim::all();
        $assign_sim=AssignSim::all();
        //$sim=Telecome::all();
        // $sim=Telecome::orWhereNull('status')->get();
        $sim=Telecome::where('status' ,'!=','1')->orWhereNull('status')->get();
        $bikes=BikeDetail::where('status' ,'!=','1')->orWhereNull('status')->get();
        $assign_bike=AssignBike::all();
        $plateform=Platform::all();
        $assign_plateform=AssignPlateform::all();

        return view('admin-panel.assigning.assigning',compact('checkout','passport','sim_exists','assign_sim','sim','bikes','assign_bike','plateform'
            ,'assign_plateform'));
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
        //checkout sim here



        $request->passport_id_selected;
        $agreement=Agreement::where('passport_id',$request->passport_id_selected_checkout)->where('status','1')->first();
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

        $assign_platform = AssignPlateform::where('status','=','1')->where('passport_id','=',$request->passport_id_selected_checkout)->first();

        if($assign_platform!=null){

            $message = [
                'message' => 'Platform is not checkout yet, please checkout the platform',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $assign_replace_sim = SimReplacement::where('passport_id','=',$request->passport_id_selected_checkout)->where('status','=','1')->first();

        if($assign_replace_sim!=null){

            $message = [
                'message' => 'Sim Replacement is not checkout yet, please checkout sim replacement',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $passport_assign = AssignSim::where('passport_id','=',$request->passport_id_selected_checkout)
            ->where('status','=','1')
            ->orderBy('id','desc')
            ->first();

        if($passport_assign == null){

            $message = [
                'message' => 'Sim is not assigned to this rider',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);

        }

       $id = $passport_assign->id;
       $sim_id = $passport_assign->sim;



//        DB::table('assign_sims')->where('id', $id)
//            ->update(['checkout' => '0']);
//
//dd($id);
        $object = AssignSim::find($id);
        $object->checkout=$request->input('checkout');
        $object->remarks=$request->input('remarks');
        $object->status='0';
        $object->checkout_reason = $request->input('checkout_reason');
        $object->save();



        // $sim_id=AssignSim::where('id',$id)->latest('created_at')->first();

        DB::table('telecomes')->where('id', $sim_id)
            ->update(['status' => '0']);

        $message = [
            'message' => ' SIM Checkout Added Successfully',
            'alert-type' => 'success'
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

    public function sim_get_passport(Request $request){
        $pass = Passport::find($request->passport_id);
        $response = $pass->personal_info->full_name."$".'';
        return $response;
    }

    public function bike_assign(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'passport_id_selected' => 'required',
            'rider_type' => 'required',
            'checkin' => 'required'
        ]);

    if ($validator->fails()) {
        $validate = $validator->errors();
        $message = [
            'message' => $validate->first(),
            'alert-type' => 'error',
            'error' => 'df'
        ];
        return redirect()->back()->with($message);
    }

    if($request->checkin=="____/__/__ __:__"){

        $message = [
            'message' => "please select checkin data",
            'alert-type' => 'error',
            'error' => 'df'
        ];
        return redirect()->back()->with($message);

    }




        //for checking the same bike number, if exist will not allow to allocate other rider
//        $bike_detail_already = BikeDetail::where('id','=',$request->input('bike'))->first();
//
//        if($bike_detail_already != null){
//             $exist_bike_detail = BikeDetail::where('plate_no','=',$bike_detail_already->plate_no)->where('status','=','1')->first();
//
//             if($exist_bike_detail != null){
//                 $message = [
//                     'message' => 'This Bike is already assigned to someone',
//                     'alert-type' => 'error'
//                 ];
//                 return redirect()->back()->with($message);
//             }
//        }



        $pass_id = $request->passport_id_selected;

        $checkin_time = $request->input('checkin');

        $now_date_time =  date('Y-m-d H:i:s', strtotime($checkin_time));








       $bike_replacement = BikeReplacement::where('passport_id','=',$pass_id)->where('type','=','1')->where('status','=','1')->first();

       if($bike_replacement != null){

           $message = [
               'message' => 'This Rider have Replace Bike, So checkout that Replace Bike before Assign new Bike',
               'alert-type' => 'error'
           ];
           return redirect()->back()->with($message);
       }


        $bike_own_history = OwnSimBikeHistory::where('passport_id','=',$request->passport_id_selected)->where('own_type','=','2')->where('status','=','1')->first();

        if($bike_own_history != null){

                $message = [
                    'message' => 'This rider have own Bike.',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
        }

//        $bike_reserved = ReserveBike::where('passport_id','=',$request->passport_id_selected)
//                                        ->where('assign_status','=','0')
//                                ->orwhere('sim_assign_status','=','0')->first();
//
//        if($bike_reserved != null){
//
//            $message = [
//                'message' => 'This rider have already one reserved bike.!',
//                'alert-type' => 'error'
//            ];
//            return redirect()->back()->with($message);
//        }




        $request->passport_id_selected;
//        $agreement=Agreement::where('passport_id',$request->passport_id_selected)->where('status','1')->first();
//        if ($agreement!=null) {
//            $agreement_status = $agreement->status;
//            if ($agreement_status == '1') {
//                $message = [
//                    'message' => "Agreement Cancelled, Bike Cannot Assinged",
//                    'alert-type' => 'error',
//                    'error' => 'df'
//                ];
//                return redirect()->back()->with($message);
//            }
//        }



      $sim_assign =  AssignSim::where('passport_id','=',$pass_id)->where('status','=','1')->first();

      $sim_shortage_setting = Setting::where('type','=','sim_shortage')->first();


      if($request->rider_type=="1"){ //skip the valdation for the front line warrior

                if($sim_assign==null && $sim_shortage_setting->status==0){

                    $message = [
                        'message' => 'Sim is not Assigned Yet, please assign sim before assign bike',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }

      }



        $assign_plat = AssignPlateform::where('passport_id','=',$pass_id)->where('status','=','1')->first();


        if($request->rider_type=="1"){ //skip the valdation for the front line warrior

            if($assign_plat==null){

                $message = [
                    'message' => 'Platform is not Assigned, please assign platform',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }else{

                    $isbox_installaed =BoxInstallation::where('bike_id',$request->bike)->where('status','=',6)->first();

                    if($isbox_installaed != null){
                        if($assign_plat->plateform!=$isbox_installaed->platform){
                            $message = [
                                'message' => 'This bike box installed in other platform',
                                'alert-type' => 'error'
                            ];
                            return redirect()->back()->with($message);
                        }
                    }



            }


        }



        if($request->rider_type=="1"){ //skip the valdation for the front line warrior
                        $date1 = Carbon::createFromFormat('Y-m-d H:i:s', $now_date_time);

                        $date2 = Carbon::createFromFormat('Y-m-d H:i:s',  $assign_plat->checkin);


                        $result_date = $date1->eq($date2);

                        if($result_date){

                            $message = [
                                'message' => 'Bike Checkin date and Time should not Less than platform checkin time',
                                'alert-type' => 'error'
                            ];
                            return redirect()->back()->with($message);

                        }
       }





        $bike_id=$request->input('bike');
        $assigned_id=AssignBike::where('passport_id',$pass_id)->count();
        $checkout_detail=AssignBike::where('passport_id',$pass_id)->latest('created_at')->first();

        $plate_number_detail =BikeDetail::where('id','=',$bike_id)->where('status','=','1')->first();

        if($plate_number_detail != null){
            $message = [
                'message' => 'This bike is already taken',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }


        $passport_number=AssignBike::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
        $plate_number=AssignBike::where('bike',$bike_id)->latest('created_at')->first();

        $bike_id=$request->input('bike');

        $passport_number=AssignBike::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
        $plate_number=AssignBike::where('bike',$bike_id)->latest('created_at')->first();

        if($plate_number != null && $passport_number != null ){

            if($passport_number->status!= "1" && $plate_number->status != "1" ){


                $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

                $user_id = Auth::user()->id;
                $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

                if($reserve_bike != null){
                    if($reserve_bike->bike_id==$request->input('bike')){
                        $reserve_bike->assign_status  = "1";
                        $reserve_bike->assigned_by  = $user_id;
                        $reserve_bike->update();
                    }else{
                        $message = [
                            'message' => 'Please assign same bike that reserved For this rider',
                            'alert-type' => 'error'
                        ];
                        return redirect()->back()->with($message);
                    }
                }elseif($reserve_bike_check != null){

                    $message = [
                        'message' => 'This bike is already reserved for rider',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);

                }


                $obj = new AssignBike();
                $obj->passport_id = $pass_id;
                $obj->bike = $request->input('bike');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');
                $obj->rider_type = $request->rider_type;
                $obj->status = '1';
                $obj->save();


                DB::table('bike_details')->where('id',$bike_id)
                ->update(['status' => '1']);

                $message = [
                    'message' => 'Bike Assinged',
                    'alert-type' => 'success'

                ];
                return redirect()->back()->with($message);


//                return "success";
            }else{


                $message = [
                    'message' => 'Bike Already Assigned  Not checkout',
                    'alert-type' => 'error'

                ];
                return redirect()->back()->with($message);

            }

        }elseif($passport_number != null){

            if($passport_number->status!="1"){


                $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

                $user_id = Auth::user()->id;
                $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

                if($reserve_bike != null){
                    if($reserve_bike->bike_id==$request->input('bike')){
                        $reserve_bike->assign_status  = "1";
                        $reserve_bike->assigned_by  = $user_id;
                        $reserve_bike->update();
                    }else{
                        $message = [
                            'message' => 'Please assign same bike that reserved For this rider',
                            'alert-type' => 'error'
                        ];
                        return redirect()->back()->with($message);
                    }
                }elseif($reserve_bike_check != null){

                    $message = [
                        'message' => 'This bike is already reserved for rider',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);

                }

                $obj = new AssignBike();
                $obj->passport_id = $pass_id;
                $obj->bike = $request->input('bike');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');
                $obj->rider_type = $request->rider_type;
                $obj->status = '1';
                $obj->save();
                DB::table('bike_details')->where('id',$bike_id)
                    ->update(['status' => '1']);


                $message = [
                    'message' => 'Bike Assinged',
                    'alert-type' => 'success'

                ];
                return redirect()->back()->with($message);


            }else{


                $message = [
                    'message' => 'Bike Already Assigned  Not checkout',
                    'alert-type' => 'error'

                ];
                return redirect()->back()->with($message);
//                return "success";
            }

        }elseif($plate_number != null){

            if($plate_number->status!="1"){

                $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

                $user_id = Auth::user()->id;
                $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

                if($reserve_bike != null){
                    if($reserve_bike->bike_id==$request->input('bike')){
                        $reserve_bike->assign_status  = "1";
                        $reserve_bike->assigned_by  = $user_id;
                        $reserve_bike->update();
                    }else{
                        $message = [
                            'message' => 'Please assign same bike that reserved For this rider',
                            'alert-type' => 'error'
                        ];
                        return redirect()->back()->with($message);
                    }
                }elseif($reserve_bike_check != null){

                    $message = [
                        'message' => 'This bike is already reserved for rider',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);

                }


                $obj = new AssignBike();
                $obj->passport_id = $pass_id;
                $obj->bike = $request->input('bike');
                $obj->checkin = $request->input('checkin');
                $obj->remarks = $request->input('remarks');
                $obj->rider_type = $request->rider_type;
                $obj->status = '1';
                $obj->save();

                DB::table('bike_details')->where('id',$bike_id)
                    ->update(['status' => '1']);


                $message = [
                    'message' => 'Bike Assinged',
                    'alert-type' => 'success'

                ];
                return redirect()->back()->with($message);
//                return "success";

            }else{



                $message = [
                    'message' => 'Bike Already Assigned  Not checkout',
                    'alert-type' => 'error'

                ];
                return redirect()->back()->with($message);
//                return "success";

            }

        }else{

            $reserve_bike = ReserveBike::where('passport_id','=',$pass_id)->where('assign_status','=','0')->first();

            $user_id = Auth::user()->id;
            $reserve_bike_check = ReserveBike::where('bike_id','=',$bike_id)->where('assign_status','=','0')->first();

            if($reserve_bike != null){
                if($reserve_bike->bike_id==$request->input('bike')){
                    $reserve_bike->assign_status  = "1";
                    $reserve_bike->assigned_by  = $user_id;
                    $reserve_bike->update();
                }else{
                    $message = [
                        'message' => 'Please assign same bike that reserved For this rider',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }
            }elseif($reserve_bike_check != null){

                $message = [
                    'message' => 'This bike is already reserved for rider',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

            }



            $obj = new AssignBike();
            $obj->passport_id =$pass_id;
            $obj->bike = $request->input('bike');
            $obj->checkin = $request->input('checkin');
            $obj->remarks = $request->input('remarks');
            $obj->rider_type = $request->rider_type;
            $obj->status = '1';
            $obj->save();

            DB::table('bike_details')->where('id',$bike_id)
                ->update(['status' => '1']);


            $message = [
                'message' => 'Bike Assinged',
                'alert-type' => 'success'

            ];
            return back()->with($message);
//            return "success";

        }
    }



    public function plateform_assign(Request $request){
        $request->passport_id_selected;
        $agreement=Agreement::where('passport_id',$request->passport_id_selected)->where('status','1')->first();
        $ppuid_cancel=Passport::where('id',$request->passport_id_selected)->first();
        if($ppuid_cancel!=null){
            $ppuid_cancel_status=$ppuid_cancel->cancel_status;
            if ($ppuid_cancel_status=='1'){
                $message = [
                    'message' => "PPUID Cancelled, Platform Cannot Assinged",
                    'alert-type' => 'error',
                    'error' => 'df'
                ];
                return redirect()->back()->with($message);
            }
        }

        if(isset($request->rider_bike)){

            $already_reserve_bike = ReserveBike::where('passport_id',$request->passport_id_selected)->where('assign_status','0')->first();

            if($already_reserve_bike != null){

                $message = [
                    'message' => "Reservation is already done for this rider, you can not select this own bike or Sim",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

        }

        $platform_id=$request->plateform;
        $new_on_board=$request->new_on_board;
        $platform_type_data=Platform::where('id',$platform_id)->first();
        $platform_type= $platform_type_data->platform_category;

        if($request->work_type=="11"){

            $validator = Validator::make($request->all(), [
            'passport_id_selected' => 'required',
            'plateform' => 'required',
            'checkin' => 'required'
            ]);
        }else{

            $validator = Validator::make($request->all(), [
                'passport_id_selected' => 'required',
                'plateform' => 'required',
                'checkin' => 'required',
                'to_dc_id' => 'required'
            ]);

        }



        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => 'df'
            ];
            return redirect()->back()->with($message);
        }
        $pass_id= $request->passport_id_selected;

        $is_platform_code = PlatformCode::where('passport_id','=',$pass_id)->where('platform_id','=',$request->plateform)->first();
        //if platfoem type is restaurant plaform code is not requried
        //of new on booard platform code is not required

        if ($platform_type=='1') {
            if ($new_on_board == '2') {
                if ($is_platform_code == null) {

                    $message = [
                        'message' => "platform code is not exist please enter the platform code",
                        'alert-type' => 'error',
                        'error' => 'df'
                    ];
                    return redirect()->back()->with($message);

                }
            }
        }
        $driving_licence  = DrivingLicense::where('passport_id','=',$pass_id)->first();
        if($driving_licence==null) {
            $message = [
                'message' => "Driving license is not created, please create driving license",
                'alert-type' => 'error',
                'error' => 'df'
            ];
            return redirect()->back()->with($message);
        }

        if($request->work_type=="11"){ //for superviser

        }else{  //for rider

                $total_assigned = AssignToDc::where('status','=','1')->where('user_id','=',$request->to_dc_id)->where('platform_id','=',$request->plateform)->count();
                $total_dc_limit = DcLimit::where('user_id','=',$request->to_dc_id)->first();
                $limit = $total_dc_limit->limit ? $total_dc_limit->limit : 0;
                $total_remain_rider =  $limit-$total_assigned;
                if($total_remain_rider < 1){
                    $message = [
                        'message' => "Limit is completed, please select another DC",
                        'alert-type' => 'error',
                        'error' => 'df'
                    ];
                    return redirect()->back()->with($message);
                }
        }





        $assigned_id=AssignPlateform::where('passport_id',$pass_id)->count();
        $checkout_detail=AssignPlateform::where('passport_id',$pass_id)->latest('created_at')->first();
        if ($assigned_id >= 1 &&  $checkout_detail->status =='1'){
            $message = [
                'message' => 'Not Checked Out',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }elseif($assigned_id >=1 &&  $checkout_detail->status =='0'){
            $obj = new AssignPlateform();
            $obj->passport_id = $pass_id;
            $obj->plateform = $request->input('plateform');
            $obj->checkin = $request->input('checkin');
            $obj->city_id = $request->input('city_id');
            $obj->status ='1';
            $obj->save();
            if(isset($request->rider_bike)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "2";
                $own_bike_sim_obj->platform_id = $request->plateform;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            if(isset($request->rider_sim)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "1";
                $own_bike_sim_obj->platform_id = $request->plateform;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            $career_id = Passport::where('id','=',$pass_id)->first();
            if($career_id != null){
                $onboard = OnBoardStatus::where('career_id','=',$career_id->career_id)->first();
                if($onboard != null){
                    $onboard->on_board = '0';
                    $onboard->interview_status = '0';
                    $onboard->assign_platform = '0';
                    $onboard->update();
                }
            }
            $onboard_pass = OnBoardStatus::where('passport_id','=',$pass_id)->first();
            if($onboard_pass != null){
                $onboard_pass->on_board = '0';
                $onboard_pass->interview_status = '0';
                $onboard_pass->assign_platform = '0';
                $onboard_pass->update();
            }
            $passport_detail=Passport::where('id',$pass_id)->first();
            $passport_no=$passport_detail->passport_no;
            $ref= Referal::where('passport_no','=',$passport_no)->first();
            $ref_set= ReferralSetting::first();
            if ($ref!=null){
                Referal::where('passport_no','=',$passport_no)->update(['status'=>'3','credit_amount'=>$ref_set->amount]);
            }
            $is_already = CategoryAssign::where('passport_id','=',$pass_id)->where('status','=','1')->first();
            if($is_already == null) {
                $obj = new CategoryAssign();
                $obj->passport_id = $pass_id;
                $obj->main_category = 2;
                $obj->sub_category1 = 1;
                $obj->sub_category2 = $request->work_type;
                $obj->status = 1;
                $obj->save();
            }

            if($request->work_type=="11"){ //for superviser

            }else{  //for rider

                $assign_to_dc = new AssignToDc();
                $assign_to_dc->rider_passport_id =  $pass_id;
                $assign_to_dc->user_id =  $request->to_dc_id;
                $assign_to_dc->platform_id =   $request->plateform;
                $assign_to_dc->status =  "1";
                $assign_to_dc->save();

            }



            $career_id = Passport::where('id','=',$pass_id)->first();
            if($career_id != null){
                $onboard = OnBoardStatus::where('career_id','=',$career_id->career_id)->orderby('id','desc')->first();
                if($onboard != null){
                    $onboard->on_board = '0';
                    $onboard->interview_status = '0';
                    $onboard->assign_platform = '0';
                    $onboard->update();
                }
            }
            $onboard_pass = OnBoardStatus::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
            if($onboard_pass != null){
                $onboard_pass->on_board = '0';
                $onboard_pass->interview_status = '0';
                $onboard_pass->assign_platform = '0';
                $onboard_pass->update();

             $rejoin_career = RejoinCareer::where('passport_id','=',$pass_id)->where('on_board','=','1')->where('hire_status','=','0')->first();
             $rejoin_career->hire_status = "1";
             $rejoin_career->update();


            }



            $message = [
                'message' => 'Platform Assigned Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }else{
            $obj = new AssignPlateform();
            $obj->passport_id = $pass_id;
            $obj->plateform = $request->input('plateform');
            $obj->checkin = $request->input('checkin');
            $obj->city_id = $request->input('city_id');
            $obj->status ='1';
            $obj->save();
            if(isset($request->rider_bike)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "2";
                $own_bike_sim_obj->platform_id = $request->plateform;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            if(isset($request->rider_sim)){
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "1";
                $own_bike_sim_obj->platform_id = $request->plateform;
                $own_bike_sim_obj->passport_id = $pass_id;
                $own_bike_sim_obj->checkin = $request->checkin;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();
            }
            $passport_detail=Passport::where('id',$pass_id)->first();
            $passport_no=$passport_detail->passport_no;
            $ref= Referal::where('passport_no',$passport_no)->first();
            $ref_set= ReferralSetting::first();
            if ($ref!=null){
                Referal::where('passport_no','=',$passport_no)
                    ->update(['status'=>'3','credit_status'=>'1','credit_amount'=>$ref_set->amount]);
            }
            $is_already = CategoryAssign::where('passport_id','=',$pass_id)
                ->where('status','=','1')
                ->first();
            if($is_already == null) {
                $obj = new CategoryAssign();
                $obj->passport_id = $pass_id;
                $obj->main_category = 2;
                $obj->sub_category1 = 1;
                $obj->sub_category2 = $request->work_type;
                $obj->status = 1;
                $obj->save();
            }

            if($request->work_type=="11"){ //for superviser

            }else{  //for rider

                $assign_to_dc = new AssignToDc();
                $assign_to_dc->rider_passport_id =  $pass_id;
                $assign_to_dc->user_id =  $request->to_dc_id;
                $assign_to_dc->platform_id =   $request->plateform;
                $assign_to_dc->status =  "1";
                $assign_to_dc->save();


            }

            $career_id = Passport::where('id','=',$pass_id)->first();
            if($career_id != null){
                $onboard = OnBoardStatus::where('career_id','=',$career_id->career_id)->orderby('id','desc')->first();
                if($onboard != null){
                    $onboard->on_board = '0';
                    $onboard->interview_status = '0';
                    $onboard->assign_platform = '0';
                    $onboard->update();
                }
            }
            $onboard_pass = OnBoardStatus::where('passport_id','=',$pass_id)->orderby('id','desc')->first();
            if($onboard_pass != null){
                $onboard_pass->on_board = '0';
                $onboard_pass->interview_status = '0';
                $onboard_pass->assign_platform = '0';
                $onboard_pass->update();

                $rejoin_career = RejoinCareer::where('passport_id','=',$pass_id)->where('on_board','=','1')->where('hire_status','=','0')->first();
                $rejoin_career->hire_status = "1";
                $rejoin_career->update();

            }
            $message = [
                'message' => 'Platform Assigned Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }
  }

  public function platform_checkout(){

        dd("dfsdf");
  }


//      public function verify_sim_rider(Request $request){
//
//          $response = [];
//          $current_timestamp = Carbon::now()->timestamp;
//
//          try {
//              $validator = Validator::make($request->all(), [
//                  'sim_number' => 'required',
//              ]);
//              if ($validator->fails()) {
//                  $response['code'] = 2;
//                  $response['message'] = $validator->errors()->first();
//                  return response()->json($response);
//              }
//
//          $is_already = VerificationAssignment::where('user_id','=',Auth::user()->id)->where('assign_type','=','sim')->where('status','=','2')->first();
//
//      if($is_already == null){
//
//          $verify_assign = new VerificationAssignment();
//
//          $verify_assign->assign_value =  $request->sim_number;
//          $verify_assign->assign_type =  "sim";
//         $verify_assign->user_id =  Auth::user()->id;
//          $verify_assign->status =  '2';
//          $verify_assign->type =  $request->type;
//          $verify_assign->save();
//
//          $response['code'] = 1;
//          $response['message'] = 'Sim verify request submitted';
//          return response()->json($response);
//
//      }else{
//
//          $response['code'] = 2;
//          $response['message'] = 'Your Request Already Submitted, please wait for our response';
//          return response()->json($response);
//      }
//
//
//
//          } catch (\Illuminate\Database\QueryException $e) {
//              $response['code'] = 2;
//              $response['message'] = 'Submission Failed';
//              return response()->json($response);
//          }
//     }


//    public function verify_platform_rider(Request $request){
//
//        $response = [];
//        $current_timestamp = Carbon::now()->timestamp;
//
//        try {
//            $validator = Validator::make($request->all(), [
//                'platform_name' => 'required',
//            ]);
//            if ($validator->fails()) {
//                $response['code'] = 2;
//                $response['message'] = $validator->errors()->first();
//                return response()->json($response);
//            }
//
//
//            $is_already = VerificationAssignment::where('user_id','=',Auth::user()->id)->where('assign_type','=','platform')->where('status','=','2')->first();
//
//            if($is_already == null) {
//
//                $verify_assign = new VerificationAssignment();
//
//                $verify_assign->assign_value = $request->platform_name;
//                $verify_assign->assign_type = "platform";
//            $verify_assign->user_id =  Auth::user()->id;
//                $verify_assign->status = '2';
//                $verify_assign->type = $request->type;
//                $verify_assign->save();
//
//                $response['code'] = 1;
//                $response['message'] = 'PlatForm verify request submitted';
//                return response()->json($response);
//            }else{
//
//                $response['code'] = 2;
//                $response['message'] = 'Your Request Already Submitted, please wait for our response';
//                return response()->json($response);
//            }
//
//
//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = 'Submission Failed';
//            return response()->json($response);
//        }
//    }

//     public function verify_bike_rider(Request $request){
//
//         $response = [];
//         $current_timestamp = Carbon::now()->timestamp;
//
//
//         try {
//             $validator = Validator::make($request->all(), [
//                 'bike_number' => 'required',
////                 'image' => 'required',
//             ]);
//             if ($validator->fails()) {
//                 $response['code'] = 2;
//                 $response['message'] = $validator->errors()->first();
//                 return response()->json($response);
//             }
//
//
//             $is_already = VerificationAssignment::where('user_id','=',Auth::user()->id)->where('assign_type','=','bike')->where('status','=','2')->first();
//
//             if($is_already == null){
//
//                 $file1=null;
//                 if (!empty($_FILES['image']['name'])) {
//                     if (!file_exists('./assets/upload/assignment/verify/assign_bike')) {
//                         mkdir('./assets/upload/assignment/verify/assign_bike', 0777, true);
//                     }
//                     $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
//                     $file1 = $request->input('passport_id').$current_timestamp . '.' . $ext;
//                     move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/assignment/verify/assign_bike/' . $file1);
//                     $file1 = '/assets/upload/assignment/verify/assign_bike/' . $file1;
//                 }
//
//                 $verify_assign = new VerificationAssignment();
//                 $verify_assign->assign_value =  $request->bike_number;
//                 $verify_assign->assign_type =  "bike";
//                 $verify_assign->attachment =  $file1;
//                 $verify_assign->user_id =  Auth::user()->id;
//                 $verify_assign->status =  '2';
//
//                 $verify_assign->type =  $request->type;
//                 $verify_assign->save();
//
//                 $response['code'] = 1;
//                 $response['message'] = 'Bike verify request submitted';
//                 return response()->json($response);
//
//             }else{
//
//                 $response['code'] = 2;
//                 $response['message'] = 'Your Request Already Submitted, please wait for our response';
//                 return response()->json($response);
//             }
//
//
//
//
//
//         } catch (\Illuminate\Database\QueryException $e) {
//             $response['code'] = 2;
//             $response['message'] = 'Submission Failed';
//             return response()->json($response);
//         }
//
//     }




    public function bike_assign_edit($id)
    {
        //

        $bike_checkout =AssignBike::find($id);
        $passport=Passport::all();
        $sim_exists=AssignSim::all();
        $assign_sim=AssignSim::all();
        //$sim=Telecome::all();
        // $sim=Telecome::orWhereNull('status')->get();
        $sim=Telecome::where('status' ,'!=','1')->orWhereNull('status')->get();
        $bikes=BikeDetail::where('status' ,'!=','1')->orWhereNull('status')->get();
        $assign_bike=AssignBike::all();
        $plateform=Platform::all();
        $assign_plateform=AssignPlateform::all();

        return view('admin-panel.assigning.bike_assign',compact('checkout','passport','sim_exists','assign_sim','sim','bikes','assign_bike','plateform'
            ,'assign_plateform','bike_checkout'));
    }


    public function assign_plateform_edit($id)
    {
        //

//        $checkout=AssignSim::find($id);
        $bike_checkout=AssignBike::find($id);
        $plateform_checkout=AssignPlateform::find($id);
        $passport=Passport::all();
        $sim_exists=AssignSim::all();
        $assign_sim=AssignSim::all();


        $sim=Telecome::where('status' ,'!=','1')->orWhereNull('status')->get();
        $bikes=BikeDetail::where('status' ,'!=','1')->orWhereNull('status')->get();
        $assign_bike=AssignBike::all();
        $plateform=Platform::all();
        $assign_plateform=AssignPlateform::all();

        return view('admin-panel.assigning.platform_assign',compact('checkout','passport','sim_exists','assign_sim','sim','bikes','assign_bike','plateform'
            ,'assign_plateform','bike_checkout','plateform_checkout'));
    }



    //get passport

    public function ajax_get_sim_passports(){
        $passport=Passport::all();
        $sim_assign_types = array(2,3,5);
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_sims', 'assign_sims.passport_id', '=', 'passports.id')
            ->where('assign_sims.status','=',1)
            ->whereNotIn('assigned_to',$sim_assign_types)
            ->get();

        $checkedin_pass = array();
        foreach ($passport_detail as $x) {
            $checkedin_pass [] = $x->id;
        }

        $checked_out_pass = array();
        foreach ($passport as $ab) {

            if (!in_array($ab->id, $checkedin_pass)) {
                $gamer = array(
                    'id' => $ab->id,
                    'passport_no' => $ab->passport_no,
                );

                $checked_out_pass [] = $gamer;
            }

        }




        $view = view("admin-panel.assigning.ajax_get_sim_passports",compact('checked_out_pass'))->render();

        return response()->json(['html'=>$view]);
    }


    public function ajax_get_sim_ppuid(){
        $passport=Passport::all();
        $sim_assign_types = array(2,3,5);
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_sims', 'assign_sims.passport_id', '=', 'passports.id')
            ->where('assign_sims.status','=',1)
            ->whereNotIn('assigned_to',$sim_assign_types)
            ->get();

        $checkedin_pass = array();
        foreach ($passport_detail as $xx) {
            $checkedin_pass [] = $xx->id;
        }

        $checked_out_pass = array();
        foreach ($passport as $ab) {

            if (!in_array($ab->id, $checkedin_pass)) {
                $gamer = array(
                    'id' => $ab->id,
                    'passport_no' => $ab->passport_no,
                    'ppuid' => $ab->pp_uid,
                    'zds_code' =>isset($ab->zds_code->zds_code)?$ab->zds_code->zds_code:'' ,
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }




        $view = view("admin-panel.assigning.ajax_get_sim_ppuid",compact('checked_out_pass'))->render();

        return response()->json(['html'=>$view]);
    }

    public function ajax_get_sim_zds(){
        $passport=Passport::all();
        $sim_assign_types = array(2,3,5);
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_sims', 'assign_sims.passport_id', '=', 'passports.id')
            ->where('assign_sims.status','=',1)
            ->whereNotIn('assigned_to',$sim_assign_types)
            ->distinct()
            ->get();

        $checkedin_pass = array();
        foreach ($passport_detail as $xx) {
            $checkedin_pass [] = $xx->id;
        }

        $checked_out_pass = array();
        foreach ($passport as $ab) {

            if (!in_array($ab->id, $checkedin_pass)) {
                $gamer = array(
                    'id' => $ab->id,
                    'passport_no' => $ab->passport_no,
                    'ppuid' => $ab->pp_uid,
                    'zds_code' =>isset($ab->zds_code->zds_code)?$ab->zds_code->zds_code:'' ,
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }




        $view = view("admin-panel.assigning.ajax_get_sim_zds",compact('checked_out_pass'))->render();

        return response()->json(['html'=>$view]);
    }


    public function sim_pdf($id){
        $check_in_detail=AssignSim::find($id);
        $pdf = PDF::loadView('admin-panel.pdf.sim_pdf', compact('check_in_detail'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');

    }

    public function office_sim_pdf($id){

        $check_in_detail=OfficeSimAssign::find($id);


        $pdf = PDF::loadView('admin-panel.pdf.office_sim_pdf', compact('check_in_detail'))
            ->setPaper('a4', 'portrait','UTF-8');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');

    }



    public function office_sim_assign(){


        $cancel_sim_id  = SimCancel::where('status','=','1')->pluck('sim_id')->toArray();

        $id_array = array(1);
        $assign_type=SimAssignType::whereNotIn('id',$id_array)->get();
        $sim = Telecome::where('status','1')->whereNotIn('id',$cancel_sim_id)->get();
        //getting assinged sim details
        $checkedin = array();
        foreach ($sim as $x) {
            $checkedin [] = $x->id;
        }
        $office_checked_in=OfficeSimAssign::all();
        $checked_out=Telecome::select('telecomes.*')->whereNotIn('id',$checkedin)->get();
        return view('admin-panel.assigning.office_sim_assign',compact('assign_type','checked_out','office_checked_in'));

    }


    public function office_sim_checkin(Request $request){
        $sim_id=$request->input('sim_id');
        $obj = new OfficeSimAssign();
        $obj->name = $request->input('name');
        $obj->assigned_to = $request->input('assigned_to');
        $obj->sim_id = $request->input('sim_id');
        $obj->checkin = $request->input('checkin');
        $obj->remarks = $request->input('remarks');
        $obj->status = '1';
        $obj->save();





        DB::table('telecomes')->where('id',$sim_id)
            ->update(['status' => '1']);
        $message = [
            'message' => 'Office SIM Assinged Successfully',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }

    public function office_sim_checkout(Request $request, $id)
    {
        //

        $obj = OfficeSimAssign::find($id);
        $obj->checkout=$request->input('checkout');
        $obj->remarks=$request->input('remarks');
        $obj->status='0';
        $obj->save();
        $sim_id=OfficeSimAssign::where('id',$id)->latest('created_at')->first();
        DB::table('telecomes')->where('id', $sim_id->sim_id)->update(['status' => '0']);
        $message = [
            'message' => 'Checked out Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);
    }

    public function autocomplete_assign_sim_users(Request $request){

        $assign_sims   =AssignSim::where('status','=','1')->where('assigned_to','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;

        $checkin_passsports = AssignPlateform::where('status','=','1')->whereNotIn('passport_id',$assign_sims)->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn("passports.id",$checkin_passsports)
            ->get();


        if(count($passport_data)=='0'){
            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->whereIn("passports.id",$checkin_passsports)
                ->get();

        }

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereIn("passports.id",$checkin_passsports)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->whereIn("passports.id",$checkin_passsports)
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->whereIn("passports.id",$checkin_passsports)
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->whereIn("passports.id",$checkin_passsports)
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
                                ->whereIn("passports.id",$checkin_passsports)
                                ->get();
                            if (count($platform_code)=='0') {
                                $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->whereIn("passports.id",$checkin_passsports)
                                    ->get();
                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->whereIn("passports.id",$checkin_passsports)
                                        ->get();
                                    if (count($drive_lin_data) == '0') {
                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->whereIn("passports.id",$checkin_passsports)
                                            ->get();
                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->whereIn("passports.id",$checkin_passsports)
                                                ->get();
                                            if (count($visa_number) == '0') {
                                                $platno = $request->input('query');
                                                $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->whereIn("passports.id",$checkin_passsports)
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
                'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '' ,
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);
    }


    public function autocomplete_assign_sim_users_to_checkout(Request $request){

        // $checkin_passsports   = AssignPlateform::where('status','=','0')->orwhere('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray();

        $own_sim_history   = OwnSimBikeHistory::where('status','=','1')->where('own_type','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray();





        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereNotIn("passports.id",$own_sim_history)
            // ->whereIn("passports.id",$checkin_passsports)
            ->where('passports.cancel_status','=','0')
            ->get();
        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->whereNotIn("passports.id",$own_sim_history)
                // ->whereIn("passports.id",$checkin_passsports)
                ->where('passports.cancel_status','=','0')
                ->get();

        }

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereNotIn("passports.id",$own_sim_history)
                // ->whereIn("passports.id",$checkin_passsports)
                ->where('passports.cancel_status','=','0')
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->whereNotIn("passports.id",$own_sim_history)
                    // ->whereIn("passports.id",$checkin_passsports)
                    ->where('passports.cancel_status','=','0')
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->whereNotIn("passports.id",$own_sim_history)
                        // ->whereIn("passports.id",$checkin_passsports)
                        ->where('passports.cancel_status','=','0')
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->whereNotIn("passports.id",$own_sim_history)
                            // ->whereIn("passports.id",$checkin_passsports)
                            ->where('passports.cancel_status','=','0')
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
                                ->whereNotIn("passports.id",$own_sim_history)
                                // ->whereIn("passports.id",$checkin_passsports)
                                ->where('passports.cancel_status','=','0')
                                ->get();
                            if (count($platform_code)=='0') {
                                $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->whereNotIn("passports.id",$own_sim_history)
                                    // ->whereIn("passports.id",$checkin_passsports)
                                    ->where('passports.cancel_status','=','0')
                                    ->get();
                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->whereNotIn("passports.id",$own_sim_history)
                                        // ->whereIn("passports.id",$checkin_passsports)
                                        ->where('passports.cancel_status','=','0')
                                        ->get();
                                    if (count($drive_lin_data) == '0') {
                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->whereNotIn("passports.id",$own_sim_history)
                                            // ->whereIn("passports.id",$checkin_passsports)
                                            ->where('passports.cancel_status','=','0')
                                            ->get();
                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->whereNotIn("passports.id",$own_sim_history)
                                                // ->whereIn("passports.id",$checkin_passsports)
                                                ->where('passports.cancel_status','=','0')
                                                ->get();
                                            if (count($visa_number) == '0') {
                                                $platno = $request->input('query');
                                                $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                                $bikes_id = "";
                                                if(!empty($bike_id)){
                                                    $bikes_id =  $bike_id->id;
                                                }

                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')

                                                    ->where("assign_bikes.bike", "LIKE", "%{$bikes_id}%")

                                                    ->where("assign_bikes.status", "1")
                                                    ->whereNotIn("passports.id",$own_sim_history)
                                                    // ->whereIn("passports.id",$checkin_passsports)
                                                    ->where('passports.cancel_status','=','0')
                                                    ->get();
                                                //platnumber response
                                                $pass_array = array();
                                                foreach ($plat_data as $pass) {
                                                    $gamer = array(
                                                        'name' => isset($bike_id->plate_no) ? $bike_id->plate_no  : '',
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



    public function get_asset_checkin_detail(Request $request){

        if($request->ajax()){

            if($request->type=="1"){

                $assign_sim = AssignSim::where('sim','=',$request->selected_id)->where('status','=','1')->first();

                if($assign_sim == null){
                    $assign_sim  = OfficeSimAssign::where('sim_id','=',$request->selected_id)->where('status','=','1')->first();

                }
                $gamer = array(
                    'rider_name' => isset($assign_sim->passport->personal_info->name) ? $assign_sim->passport->personal_info->name : 'error',
                    'checkin_time' => isset($assign_sim->checkin) ? $assign_sim->checkin : '',
                    'platform_name' => isset($assign_sim->passport->assign_platforms_check->name) ? $assign_sim->passport->assign_platforms_check->name : '',
                );

            }else{

                $assign_bike = AssignBike::where('bike','=',$request->selected_id)->where('status','=','1')->first();


                $gamer = array(
                    'rider_name' => isset($assign_bike->passport->personal_info->name) ? $assign_bike->passport->personal_info->name : 'error',
                    'checkin_time' => isset($assign_bike->checkin) ? $assign_bike->checkin : '',
                    'platform_name' => isset($assign_bike->passport->assign_platforms_check->name) ? $assign_bike->passport->assign_platforms_check->name : '',
                );


            }

            echo json_encode($gamer);
            exit;
        }

    }



}
