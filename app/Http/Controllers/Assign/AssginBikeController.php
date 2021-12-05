<?php

namespace App\Http\Controllers\Assign;

use App\Exports\AllUsedBikesExport;
use App\Exports\AssignDashboardExport;
use App\Exports\CodRiderLog;
use App\Exports\CompanyBikesExport;
use App\Exports\CompanyCancelBikesExport;
use App\Exports\CompanyFreeBikesExport;
use App\Exports\FreeLeaseBikesExport;
use App\Exports\LeaseBikeExport;
use App\Exports\LeaseCancelBikesExport;
use App\Exports\TotalSimsExport;
use App\Exports\TotalSimsFreeExport;
use App\Exports\TotalSimsOfficeExport;
use App\Exports\TotalSimsRiderExport;
use App\Exports\UsedBikeExport;
use App\Model\Agreement\Agreement;
use App\Model\Agreement\AgreementCategoryTree;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Assign\OfficeSimAssign;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use App\Model\BikeDetailHistory;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\OwnSimBikeHistory;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Platform;
use App\Model\ReserveBike\ReserveBike;
use App\Model\SimReplacement\SimReplacement;
use App\Model\Telecome;
use App\Model\UserCodes\UserCodes;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use function foo\func;

class AssginBikeController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|assignment-bike-assignment|assignment-bike-assignment-view', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|assignment-bike-assignment', ['only' => ['store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|assignment-assign-dashboard', ['only' => ['assign_dashboard']]);
    }

    public function index(Request $request)
    {


        // $assign_bike = [];
        // $bike_data = [];
        // $checked_out_pass = [];
        // $bikes = BikeDetail::all();
        // $passport = Passport::all();
        // $bikes_detail = BikeDetail::select('bike_details.*')
        //     ->leftjoin('assign_bikes', 'assign_bikes.bike', '=', 'bike_details.id')
        //     ->where('assign_bikes.status', '=', 1)
        //     ->orwhere('bike_details.reserve_status', '=', 1)
        //     ->distinct()
        //     ->get();
        // $checkedin = array();
        // foreach ($bikes_detail as $x) {
        //     $checkedin [] = $x->id;
        // }
        // $checked_out = array();
        // foreach ($bikes as $ab) {
        //     if (!in_array($ab->id, $checkedin)) {
        //         $gamer = array(
        //             'id' => $ab->id,
        //             'bike' => $ab->plate_no,
        //             'cencel' => isset($ab->bike_cancel->plate_no) ? $ab->bike_cancel->plate_no : "",
        //             'plate_code' => $ab->plate_code,
        //         );
        //         $checked_out [] = $gamer;
        //     }
        // }
        if ($request->ajax()) {
            if ($request->filter_by == "1") {
                //passport number
                $searach = '%' . $request->keyword . '%';
                $passport = Passport::where('passport_no', 'like', $searach)->pluck('id')->toArray();

                $assign_bike = AssignBike::with(['plateform' => function ($query) {
                    $query->where('status', '=', '1');
                }])->whereIn('passport_id', $passport)
                    ->orderby('updated_at', 'desc')
                    ->get();
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
                $assign_bike = [];
            }
            $row_column = [];
            $dt = Datatables::of($assign_bike);
            $dt->addColumn('passport_number', function (AssignBike $bike) {
                return $bike->passport->passport_no;
            });

            $dt->addColumn('ppuid', function (AssignBike $bike) {
                return $bike->passport->pp_uid;
            });

            $dt->addColumn('zds_code', function (AssignBike $bike) {
                return isset($bike->passport->zds_code->zds_code) ? $bike->passport->zds_code->zds_code : "";
            });

            $dt->addColumn('name', function (AssignBike $bike) {
                return $bike->passport->personal_info->full_name;
            });

            $dt->addColumn('plate_no', function (AssignBike $bike) {
                $plat_number = isset($bike->bike_plate_number->plate_no) ? $bike->bike_plate_number->plate_no : "";
                if ($bike->bike_plate_number->category_type == '0') {
                    $ab = '';
                } elseif ($bike->bike_plate_number->category_type == '1') {
                    $ab = '/L';
                } elseif ($bike->bike_plate_number->category_type == '2') {
                    $ab = '/CD';
                } elseif ($bike->bike_plate_number->category_type == '3') {
                    $ab = '/D';
                } else {
                    $ab = '';
                }

                if (isset($bike->bike_plate_number->bike_tracking->bike_id) ? $bike->bike_plate_number->bike_tracking->bike_id : "") {
                    $track = "/T";
                } else {
                    $track = "";
                }
                $row_column[] = 'plate_no';
                return $plat_number . $ab . $track;
            });
            $dt->addColumn('platform', function (AssignBike $res_bike) {
                $ab = '';
                $name = '';
                if (isset($res_bike->plateform[0])) {
                    $name = $res_bike->plateform[0]->plateformdetail->name;
                    $ab = '<span>' . $name . '</span>';
                } else {
                    $ab = '<span>N/A</span>';
                }
                $row_column [] = 'platform';
                return $ab;
            });

            $dt->addColumn('image', function (AssignBike $res_bike) {
                $ab = '';
                if (isset($res_bike->bike_images)) {
                    $now_url = url($res_bike->bike_images);
                    $ab = '<a href = "' . $now_url . '" target = "_blank" ><span class="badge badge-info" > Check Images </span ></a>';
                } else {
                    $ab = '<span class="badge badge-info">No Images</span>';
                }

                $row_column [] = 'image';
                return $ab;
            });
            $dt->addColumn('action', function (AssignBike $res_bike) {
                    $disyplay = '';
                    $ab = '';
                    if ($res_bike->status == 0) {
                       $ab = '<span class="badge badge-success">Checked Out</span>';
                    }else{
                        $route = route('bike_pdf', $res_bike->id);
                        $ab = '<a  class="text-success mr-2 bik_btn_cls"   id="' . $res_bike->id . '" href="javascript:void(0)">
                                                    <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>
                                                                <a href="' . $route . '" target="_blank"><i class="fa fa-print"></i></a>
                                                            </a>';
                    }
                    return $ab;
                });


            $dt->rawColumns(['platform', 'image', 'action']);
            return $dt->make(true);
        }

        // $check_in_passports = AssignBike::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get();

        $working_bikes = BikeDetail::whereStatus(2)->get();
        // dd($checked_out);
        return view('admin-panel.assigning.bike_assign', compact( 'working_bikes'));
    }


    public function get_latest_bike_time(Request $request){

        if($request->ajax()){

            $bike_id = $request->bike_id;

            if($request->type="bike"){

                $assign_bike = AssignBike::where('bike','=',$bike_id)->orderby('checkout','DESC')->first();
                if($assign_bike!=null){

                    $date_array  = explode(' ',$assign_bike->checkout);
                $gamer = array(
                    'latest_date' =>  $date_array[0]
                );
                echo json_encode($gamer);
                exit;

                }else{

                    $gamer = array(
                        'latest_date' =>  ""
                    );
                    echo json_encode($gamer);
                    exit;

                }


            }elseif($request->type="sim"){

                $assign_bike = AssignSim::where('sim','=',$bike_id)->orderby('checkout','DESC')->first();
                $date_array  = explode(' ',$assign_bike->checkout);

                if($date_array != null){

                    $gamer = array(
                        'latest_date' =>  $date_array[0]
                    );
                    echo json_encode($gamer);
                    exit;

                }else{

                    $gamer = array(
                        'latest_date' =>  ""
                    );
                    echo json_encode($gamer);
                    exit;

                }


            }


        }

    }




    public function get_passport_name_detail(Request $request){

        $searach = '%'.$request->passport_id.'%';
        $passport = Passport::where('passport_no', 'like', $searach)->first();

        $name = "";
        if(!empty($passport)){
            $name = $passport->personal_info->full_name;
        }
        if($request->type=="replace_checkout"){

             $bike_replace = BikeReplacement::where('passport_id','=',$passport->id)->where('status','=','1')->where('type','=','1')->first();

             $bike_old = "";
             $primary_id ="";
             $checkin_bike = "";


             if(!empty($bike_replace)){
                  $bike_detail = BikeDetail::where('id','=',$bike_replace->replace_bike_id)->first();
                 $bike_detail_checkin = BikeDetail::where('id','=',$bike_replace->new_bike_id)->first();

                 $bike_old  = $bike_detail->plate_no;
                 $primary_id  = $bike_replace->id;
                 $checkin_bike = $bike_detail_checkin->plate_no;
             }

            $gamer = array(
                'name' => $name,
                'id' => $passport->id,
                'platform_name' => isset($passport->assign_platforms_check()->plateformdetail->name) ? ($passport->assign_platforms_check()->plateformdetail->name) : '',
                'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : '',
                'bike_number' => $checkin_bike,
                'old_bike' => $bike_old,
                'replacement_primary_id' => $primary_id,
                'zds_code' => isset($passport->zds_code->zds_code) ? $passport->zds_code->zds_code : '',
            );

        }elseif($request->type=="replace_checkout_sim" ||  $request->type=="checkin"){

            $sim_replace = SimReplacement::where('passport_id','=',$passport->id)->where('status','=','1')->where('type','=','1')->first();

            $primary_id ="";
            $old_sim ="";

            $checkin_sim = "";


            if(!empty($sim_replace)){
                $sim_tel = Telecome::where('id','=',$sim_replace->replace_sim_id)->first();
                $old_sim  = $sim_tel->account_number;
                $primary_id  = $sim_replace->id;

                if($request->type=="checkin"){
                    $checkin_sim = isset($passport->sim_checkin()->telecome->account_number) ? ($passport->sim_checkin()->telecome->account_number) : '';
                }else{
                    $sim_tel_checkin = Telecome::where('id','=',$sim_replace->new_sim_id)->first();
                    $checkin_sim = $sim_tel_checkin->account_number;
                }
            }else{
                    $checkin_sim = isset($passport->sim_checkin()->telecome->account_number) ? ($passport->sim_checkin()->telecome->account_number) : '';
              }


            $gamer = array(
                'name' => $name,
                'id' => $passport->id,
                'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : '',
                'current_sim' => $checkin_sim,
                'bike_number' => isset($passport->bike_checkin()->bike_plate_number->plate_no) ? ($passport->bike_checkin()->bike_plate_number->plate_no) : '',
                'old_sim' => $old_sim,
                'replacement_primary_id' => $primary_id,
                'zds_code' => isset($passport->zds_code->zds_code) ? $passport->zds_code->zds_code : '',
            );



        }else{

            $platform_status=isset($passport->assign_platforms_check()->plateformdetail->name)?$passport->assign_platforms_check()->plateformdetail->name:'N/A';
            if ($platform_status!="N/A"){
                $check_status='Platform Not Checked Out';
                $last_check_out_time='Platform Not Checked Out';
            }
            else{
                $check_status= isset($passport->assign_platforms_checkout()->plateformdetail->name) ? ($passport->assign_platforms_checkout()->plateformdetail->name) : '';
                $last_check_out_time= isset($passport->assign_platforms_checkout()->checkout) ? ($passport->assign_platforms_checkout()->checkout) : 'N/A';
            }

            //4 pl status
//            $passport
        $agreement_detail=Agreement::where('passport_id',$passport->id)->first();
            $four_pl_status=isset($agreement_detail->four_pl_name)?$agreement_detail->four_pl_name:"N/A";
            if ($four_pl_status!='N/A'){
                $four_pl='1';
            }
            else{
                $four_pl='2';
            }
            $gamer = array(
                'name' => $name,
                'id' => $passport->id,
                'platform_name' => isset($passport->assign_platforms_check()->plateformdetail->name)?$passport->assign_platforms_check()->plateformdetail->name:'N/A',
                'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : 'N/A',
                'bike_number' => isset($passport->bike_checkin()->bike_plate_number->plate_no) ? ($passport->bike_checkin()->bike_plate_number->plate_no) : 'N/A',
                'checkin_time' => isset($passport->assign_platforms_check()->checkin) ? ($passport->assign_platforms_check()->checkin) : 'N/A',
                'checkin_sim_number' => isset($passport->sim_checkin()->telecome->account_number) ? ($passport->sim_checkin()->telecome->account_number) : 'N/A',
                'last_platform' => $check_status,
                'last_platform_checkout' => $last_check_out_time,
                'four_pl_status' => $four_pl,
                'zds_code' => isset($passport->zds_code->zds_code) ? $passport->zds_code->zds_code : '',
            );
        }
        echo json_encode($gamer);
        exit;
    }

    public function temp_assign_bike()
    {


        return view('admin-panel.assigning.temp_bike_assign');
    }
//    public function basicLaratableData()
//    {
//        return Laratables::recordsOf(AssignBike::class);
//    }
    public function getBikeData()
    {


//        $bikeData = AssignBike::get();
//        $childe['data'] = [];
//        foreach($bikeData as $plt){
//
//                $gamer = array(
//                    'passport_no' => $plt->passport ?$plt->passport->passport_no:'',
//                    'ppuid' => $plt->passport ?$plt->passport->pp_uid:'',
//                    'zds_code' => isset($plt->passport->zds_code->zds_code) ? $plt->passport->zds_code->zds_code : '',
//                    'full_name' => isset($plt->passport->personal_info->full_name) ? $plt->passport->personal_info->full_name : '',
//                    'plate_no' => isset($plt->bike_plate_number->plate_no) ? $plt->bike_plate_number->plate_no : '',
//                    'checkin' => $plt->checkin,
//                    'checkout' => $plt->checkout,
//                    'remarks' => $plt->remarks,
//                );
//                $childe['data'] [] = $gamer;
//            }
//        echo json_encode($childe);


        $bikeData = AssignBike::get();
        return json_encode(array('data' => $bikeData));


    }


//        $bikeData = AssignBike::get();
//        return json_encode(array('data'=>$bikeData));


//    public function getBikeData(){
//        $bikeData = AssignBike::get();
//        $childe['data'] = [];
//        foreach($bikeData as $plt){
//
//                $gamer = array(
//                    'passport_no' => $plt->passport ?$plt->passport->passport_no:'',
//                    'ppuid' => $plt->passport ?$plt->passport->pp_uid:'',
//                    'zds_code' => isset($plt->passport->zds_code->zds_code) ? $plt->passport->zds_code->zds_code : '',
//                    'full_name' => isset($plt->passport->personal_info->full_name) ? $plt->passport->personal_info->full_name : '',
//                    'plate_no' => isset($plt->bike_plate_number->plate_no) ? $plt->bike_plate_number->plate_no : '',
//                    'checkin' => $plt->checkin,
//                    'checkout' => $plt->checkout,
//                    'remarks' => $plt->remarks,
//                );
//                $childe['data'] [] = $gamer;
//            }
//        echo json_encode($childe);
//
//
//    }

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $assign_platform = AssignPlateform::where('status','=','1')->where('passport_id','=',$request->passport_id_selected_checkout)->first();

        if($assign_platform!=null){

            $message = [
                'message' => 'Platform is not checkout yet, please checkout the platform',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $assign_sim = AssignSim::where('status','=','1')->where('passport_id','=',$request->passport_id_selected_checkout)->first();

        if($assign_sim!=null){

            $message = [
                'message' => 'Sim is not checkout yet, please checkout the sim before checkout Bike',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $passport_id = $request->passport_id_selected_checkout;


        $bike_replacement = BikeReplacement::where('passport_id','=',$passport_id)->where('type','=','1')->where('status','=','1')->first();

        if($bike_replacement != null){

            $message = [
                'message' => 'This Rider have Replace Bike, So checkout that Replace Bike before Assign new Bike',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

        $obj = AssignBike::where('passport_id','=',$passport_id)->where('status','=','1')->first();
        $obj->checkout = $request->input('checkout');
        $obj->remarks = $request->input('remarks');
        $obj->checkout_reason = $request->input('checkout_reason');
        $obj->status = '0';
        $obj->save();
        $assign_id  = $obj->id;
        $bike_id = AssignBike::where('id', $assign_id)->latest('created_at')->first();

        DB::table('bike_details')->where('id', $bike_id->bike)
            ->update([
                'status' => $request->checkout_reason == 4 ? 2 : 0
                ]);

        $message = [
            'message' => 'Checkout Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function bike_pdf($id)
    {

        $check_in_detail = AssignBike::find($id);


        $pdf = PDF::loadView('admin-panel.pdf.bike_pdf', compact('check_in_detail'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('bike.pdf');

    }

    public function ajax_get_passports()
    {
        $passport = Passport::all();
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
            ->where('assign_bikes.status', '=', 1)
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
                    'zds_code' => isset($ab->zds_code->zds_code) ? $ab->zds_code->zds_code : '',
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }


        $view = view("admin-panel.assigning.ajax_get_passport", compact('checked_out_pass'))->render();

        return response()->json(['html' => $view]);
    }


    public function ajax_get_ppuid()
    {
        $passport = Passport::all();
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
            ->where('assign_bikes.status', '=', 1)
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
                    'zds_code' => isset($ab->zds_code->zds_code) ? $ab->zds_code->zds_code : '',
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }


        $view = view("admin-panel.assigning.ajax_get_ppuid", compact('checked_out_pass'))->render();

        return response()->json(['html' => $view]);
    }

    public function ajax_get_ppuid_platform()
    {
        $passport = Passport::all();
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_plateforms', 'assign_plateforms.passport_id', '=', 'passports.id')
            ->where('assign_plateforms.status', '=', 1)
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
                    'zds_code' => isset($ab->zds_code->zds_code) ? $ab->zds_code->zds_code : '',
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }


        $view = view("admin-panel.assigning.ajax_get_ppuid", compact('checked_out_pass'))->render();

        return response()->json(['html' => $view]);
    }


    public function ajax_get_zds()
    {
        $passport = Passport::all();
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
            ->where('assign_bikes.status', '=', 1)
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
                    'zds_code' => isset($ab->zds_code) ? $ab->zds_code->zds_code : '',
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }
        $view = view("admin-panel.assigning.ajax_get_zds", compact('checked_out_pass'))->render();

        return response()->json(['html' => $view]);
    }
    public function ajax_get_zds_platform()
    {
        $passport = Passport::all();
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_plateforms', 'assign_plateforms.passport_id', '=', 'passports.id')
            ->where('assign_plateforms.status', '=', 1)
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
                    'zds_code' => isset($ab->zds_code) ? $ab->zds_code->zds_code : '',
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }
        $view = view("admin-panel.assigning.ajax_get_zds", compact('checked_out_pass'))->render();

        return response()->json(['html' => $view]);
    }


    public function bike_detail(Request $request)
    {
        $id = $request->id;
        $bike_detail = BikeDetail::where('id', $id)->with(['tracking' => function ($query) {
            $query->orderby('id', 'desc');
        }])->get();
        $view = view("admin-panel.assigning.ajax_bike_detail", compact('bike_detail'))->render();
        return response()->json(['html' => $view]);

    }

    public function assign_dashboard(){

       $cancel_bike = BikeCencel::count();
       $cancel_bike_array = BikeCencel::pluck('bike_id')->toArray();

        $all_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->count();
        $lease_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')->count();
        $company_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')->count();

        $lease_free_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')->where('status','=','0')->whereNotIn('id',$cancel_bike_array)->count();
        $lease_used_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')->where('status','=','1')->whereNotIn('id',$cancel_bike_array)->count();
        $lease_cancel_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')->whereIn('id',$cancel_bike_array)->count();

        $company_free_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')->where('status','=','0')->whereNotIn('id',$cancel_bike_array)->count();
        $company_used_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')->where('status','=','1')->whereNotIn('id',$cancel_bike_array)->count();
        $company_cancel_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')->whereIn('id',$cancel_bike_array)->count();


        //sim detail
         $office_array = OfficeSimAssign::where('status','=','1')->pluck('sim_id')->toArray();

         $rider_array = AssignSim::where('assigned_to','=','1')->where('status','=','1')->pluck('sim')->toArray();
         $other_array = AssignSim::where('assigned_to','!=','1')->where('status','=','1')->pluck('sim')->toArray();


         $final_office_sim = array_merge($office_array,$other_array);

         $sim_replacement = SimReplacement::where('status','=','1')->where('type','=','1')->pluck('new_sim_id')->toArray();

//         echo "<pre>",print_r($rider_array),"</pre>";
//dd($rider_array);

         $total_sim = Telecome::count();
         $office_sim = Telecome::whereIn('id',$final_office_sim)->wherenotIn('id',$rider_array)->count();

         $rider_sim = Telecome::where('status','=','1')->whereIn('id',$rider_array)->wherenotin('id',$final_office_sim)->count();



         $free_sim = Telecome::where('status','=','0')->count();


         //checkin detail counting start


        $today_date  = date("Y-m-d");

        $now_time = Carbon::parse($today_date)->startOfDay();
        $end_time = Carbon::parse($today_date)->endOfDay();

        $today_sim_checkin = AssignSim::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();

        $today_office_checkin = OfficeSimAssign::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();

        $total_today_sim = $today_sim_checkin+$today_office_checkin;

        $total_today_bike =  AssignBike::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();

        $total_today_platform = AssignPlateform::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->count();
        //checkout work start

        $today_sim_checkout = AssignSim::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();

        $today_office_checkout = OfficeSimAssign::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();

        $total_today_sim_checkout = $today_sim_checkout+$today_office_checkout;

        $total_today_bike_checkout =  AssignBike::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();

        $total_today_platform_checkout = AssignPlateform::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->count();

        $platforms = Platform::all();


        $total_today_platform_checkout_detail = AssignPlateform::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->get();
        //-------------
        $total_today_platform_checkin_detail = AssignPlateform::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->get();

        //---------------


        $today_sim_checkout_get = AssignSim::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->get();


        $total_today_bike_checkout_detail =  AssignBike::whereDate('updated_at', '>=', $now_time)
            ->whereDate('updated_at', '<=', $end_time)
            ->where('status','=','0')
            ->get();



        $today_sim_checkin_detail = AssignSim::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->get();


        $total_today_bike_detail =  AssignBike::whereDate('created_at', '>=', $now_time)
            ->whereDate('created_at', '<=', $end_time)
            ->where('status','=','1')
            ->get();

        return view('admin-panel.assigning.assign_dashboard',compact('total_today_platform_checkout','total_today_bike_checkout','total_today_sim_checkout','platforms','total_today_platform','total_today_bike','total_today_sim','free_sim','rider_sim','office_sim','total_sim','company_cancel_bike','company_used_bike','company_free_bike','lease_cancel_bike','lease_used_bike','lease_free_bike','company_bike','lease_bike','all_bike','cancel_bike','total_today_platform_checkout_detail','today_sim_checkout_get','total_today_bike_checkout_detail','total_today_platform_checkin_detail','today_sim_checkin_detail','total_today_bike_detail'));
    }






    public function ajax_get_passports_platform()
    {


        $passport = Passport::all();
        $passport_detail = Passport::select('passports.*')
            ->leftjoin('assign_plateforms', 'assign_plateforms.passport_id', '=', 'passports.id')
            ->where('assign_plateforms.status', '=', 1)
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
                    'zds_code' => isset($ab->zds_code->zds_code) ? $ab->zds_code->zds_code : '',
//                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
                );

                $checked_out_pass [] = $gamer;
            }

        }


//
//        $passport = Passport::all();
//        $passport_detail = Passport::select('passports.*')
//            ->leftjoin('assign_plateforms', 'assign_plateforms.passport_id', '=', 'passports.id')
//            ->where('assign_plateforms.status', '=', 1)
//            ->distinct()
//            ->get();
//
//        $checkedin_pass = array();
//        foreach ($passport_detail as $xx) {
//            $checkedin_pass [] = $xx->id;
//        }
//
//        $checked_out_pass = array();
//        foreach ($passport as $ab) {
//
//            if (!in_array($ab->id, $checkedin_pass)) {
//                $gamer = array(
//                    'id' => $ab->id,
//                    'passport_no' => $ab->passport_no,
//                    'ppuid' => $ab->pp_uid,
//                    'zds_code' => isset($ab->zds_code->zds_code) ? $ab->zds_code->zds_code : '',
////                    'cencel' => isset($ab->bike_cancel->plate_no)?$ab->bike_cancel->plate_no:"",
//                );
//
//                $checked_out_pass [] = $gamer;
//            }
//
//        }

        $view = view("admin-panel.assigning.ajax_get_passport", compact('checked_out_pass'))->render();

        return response()->json(['html' => $view]);
    }

    public function download_total_bikes(){
        $all_bikes = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->get();
        return Excel::download(new AssignDashboardExport('admin-panel.assigning.all_bikes_download',$all_bikes), "admin_dashboard_all_bikes.xlsx");
    }
    public function download_lease_bikes(){
        $lease_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')->get();
        return Excel::download(new LeaseBikeExport('admin-panel.assigning.all_lease_bikes_download',$lease_bike), "admin_dashboard_lease_bikes.xlsx");
    }

    public function download_used_bikes(){
        $cancel_bike_array = BikeCencel::pluck('bike_id')->toArray();



        $lease_used_bike=BikeDetail::with(array('assign_bike' => function($query){
           $query->where('status',1)->with('passport');
        }))->where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')
            ->where('status','=',1)
            ->whereNotIn('id',$cancel_bike_array)
            ->get();




        return Excel::download(new UsedBikeExport('admin-panel.assigning.all_used_bikes_download',$lease_used_bike), "all_lease_used_bikes_download.blade.xlsx");
    }

    public function download_company_bikes(){
        $company_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')->get();
        return Excel::download(new CompanyBikesExport('admin-panel.assigning.all_company_download',$company_bike), "all_company_download.xlsx");
    }
    public function download_lease_free_bikes(){
        $cancel_bike_array = BikeCencel::pluck('bike_id')->toArray();
        $lease_free_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')->where('status','=','0')->whereNotIn('id',$cancel_bike_array)->get();
        return Excel::download(new FreeLeaseBikesExport('admin-panel.assigning.all_lease_free_download',$lease_free_bike), "all_free_lease_download.xlsx");
    }


    public function download_cancel_bikes(){
        $cancel_bike_array = BikeCencel::pluck('bike_id')->toArray();

        $lease_cancel_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','!=','0')->whereIn('id',$cancel_bike_array)->get();
        return Excel::download(new LeaseCancelBikesExport('admin-panel.assigning.all_lease_cancel_download',$lease_cancel_bike), "all_cancel_lease_download.xlsx");
    }

    public function download_company_used_bikes(){
         $cancel_bike_array = BikeCencel::pluck('bike_id')->toArray();
//        $company_used_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')
//            ->where('status','=','1')->whereNotIn('id',$cancel_bike_array)->get();




        $company_used_bike=BikeDetail::with(array('assign_bike' => function($query){
            $query->where('status',1)->with('passport');
        }))->where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')
            ->where('status','=',1)
            ->whereNotIn('id',$cancel_bike_array)
            ->get();

        return Excel::download(new AllUsedBikesExport('admin-panel.assigning.all_company_used_download',$company_used_bike), "all_company_used_download.xlsx");
    }
    public function download_company_free_bikes(){
         $cancel_bike_array = BikeCencel::pluck('bike_id')->toArray();
        $company_free_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')->where('status','=','0')->whereNotIn('id',$cancel_bike_array)->get();
        return Excel::download(new CompanyFreeBikesExport('admin-panel.assigning.all_company_free_download',$company_free_bike), "all_company_free_download.xlsx");
    }
    public function download_company_cancel_bikes(){
         $cancel_bike_array = BikeCencel::pluck('bike_id')->toArray();
        $company_cancel_bike = BikeDetail::where('plate_code','LIKE','%Motorcycle 1%')->where('category_type','=','0')->whereIn('id',$cancel_bike_array)->get();
        return Excel::download(new CompanyCancelBikesExport('admin-panel.assigning.all_company_cencel_download',$company_cancel_bike), "all_company_cencel_download.xlsx");
    }
    public function download_total_sims(){
         $total_sim = Telecome::get();
        return Excel::download(new TotalSimsExport('admin-panel.assigning.total_sim_download',$total_sim), "total_sim_download.xlsx");
    }
    public function download_total_rider_sims(){
        $office_array = OfficeSimAssign::where('status','=','1')->pluck('sim_id')->toArray();
        $other_array = AssignSim::where('assigned_to','!=','1')->where('status','=','1')->pluck('sim')->toArray();
        $rider_array = AssignSim::where('assigned_to','=','1')->where('status','=','1')->pluck('sim')->toArray();

        $final_office_sim = array_merge($office_array,$other_array);

        $telecom_sim_ids = Telecome::where('status','=','1')->whereIn('id',$rider_array)->wherenotin('id',$final_office_sim)->pluck('id')->toArray();

        $rider_sim=AssignSim::where('status','=','1')->where('assigned_to','=','1')->wherein('sim',$telecom_sim_ids)->with('plateform')->get();
        return Excel::download(new TotalSimsRiderExport('admin-panel.assigning.total_sim_rider_download',$rider_sim), "total_sim_rider_download.xlsx");
    }
    public function download_total_office_sims(){

//        $office_array = OfficeSimAssign::where('status','=','1')->pluck('sim_id')->toArray();
//        $other_array = AssignSim::where('assigned_to','!=','1')->where('status','=','1')->pluck('sim')->toArray();
//        $final_office_sim = array_merge($office_array,$other_array);
//        $office_sim = Telecome::whereIn('id',$final_office_sim)->get();



        $office_sim=OfficeSimAssign::where('status','=','1')->get();


        return Excel::download(new TotalSimsOfficeExport('admin-panel.assigning.total_sim_office_download',$office_sim), "total_sim_office_download.xlsx");
    }
    public function download_total_free_sims(){

        $rider_array = AssignSim::where('assigned_to','=','1')->where('status','=','1')->pluck('sim')->toArray();

        $free_sim = Telecome::where('status','=','0')->get();
        return Excel::download(new TotalSimsFreeExport('admin-panel.assigning.total_sim_free_download',$free_sim), "total_sim_office_download.xlsx");
    }

    public function autocomplete_assign_bike_users(Request $request){

          $assign_bikes   =AssignBike::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray();
          $own_bike_history   = OwnSimBikeHistory::where('status','=','1')->where('own_type','=','2')->select('passport_id')->groupBy('passport_id')->get()->toArray();

        // $checkin_passsports = AssignPlateform::where('status','=','1')->whereNotIn('passport_id',$assign_bikes)->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereNotIn("passports.id",$own_bike_history)
            // ->whereIn("passports.id",$checkin_passsports)
            ->where('passports.cancel_status','=','0')
            ->get();

        if(count($passport_data)=='0'){

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->whereNotIn("passports.id",$own_bike_history)
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
                ->whereNotIn("passports.id",$own_bike_history)
                // ->whereIn("passports.id",$checkin_passsports)
                ->where('passports.cancel_status','=','0')
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->whereNotIn("passports.id",$own_bike_history)
                    // ->whereIn("passports.id",$checkin_passsports)
                    ->where('passports.cancel_status','=','0')
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->whereNotIn("passports.id",$own_bike_history)
                        // ->whereIn("passports.id",$checkin_passsports)
                        ->where('passports.cancel_status','=','0')
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where('passports.cancel_status','=','0')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->whereNotIn("passports.id",$own_bike_history)
                            // ->whereIn("passports.id",$checkin_passsports)

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
                                ->where('passports.cancel_status','=','0')
                                ->whereNotIn("passports.id",$own_bike_history)
                                // ->whereIn("passports.id",$checkin_passsports)
                                ->get();
                            if (count($platform_code)=='0') {
                                $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->whereNotIn("passports.id",$own_bike_history)
                                    // ->whereIn("passports.id",$checkin_passsports)
                                    ->get();
                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->whereNotIn("passports.id",$own_bike_history)
                                        // ->whereIn("passports.id",$checkin_passsports)
                                        ->get();
                                    if (count($drive_lin_data) == '0') {
                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->whereNotIn("passports.id",$own_bike_history)
                                            // ->whereIn("passports.id",$checkin_passsports)
                                            ->get();
                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->whereNotIn("passports.id",$own_bike_history)
                                                // ->whereIn("passports.id",$checkin_passsports)
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
                                                    ->whereNotIn("passports.id",$own_bike_history)
                                                    // ->whereIn("passports.id",$checkin_passsports)
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
                'zds_code' => $pass->zds_code,
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }




    public function autocomplete_checkin_bikes(Request $request){

        $assign_bikes = AssignBike::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;

        $checkin_passsports = AssignPlateform::where('status','=','1')->whereNotIn('passport_id',$assign_bikes)->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


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

                                                $bike_ids_no = isset($bike_id->id) ? $bike_id->id : '0';
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_ids_no}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->whereIn("passports.id",$checkin_passsports)
                                                    ->get();
                                                //platnumber response
                                                $pass_array = array();
                                                foreach ($plat_data as $pass) {
                                                    $gamer = array(
                                                        'name' => isset($bike_id->plate_no) ? $bike_id->plate_no : '',
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



    public function autocomplete_checkin_bikes_only(Request $request){

        $checkin_passsports = AssignBike::where('status','=','1')->select('passport_id')->groupBy('passport_id')->get()->toArray() ;

//        $checkin_passsports = AssignPlateform::where('status','=','1')->whereIn('passport_id',$assign_bikes)->select('passport_id')->groupBy('passport_id')->get()->toArray() ;


        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn("passports.id",$checkin_passsports)
            ->get();

        if(count($passport_data) =='0'){

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

                                                $bike_ids_no = isset($bike_id->id) ? $bike_id->id : '0';
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_ids_no}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->whereIn("passports.id",$checkin_passsports)
                                                    ->get();
                                                //platnumber response
                                                $pass_array = array();
                                                foreach ($plat_data as $pass) {
                                                    $gamer = array(
                                                        'name' => isset($bike_id->plate_no) ? $bike_id->plate_no : '',
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


}
