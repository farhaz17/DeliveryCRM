<?php

namespace App\Http\Controllers\Cods;

use DB;
use App\User;
use DateTime;
use DataTables;
use Carbon\Carbon;
use App\Model\Cities;
use App\Model\Platform;
use App\Model\CareemCod;
use App\Model\Cods\Cods;
use App\Model\Guest\Career;
use App\Model\RiderProfile;
use App\Exports\CodRiderLog;
use App\Http\Middleware\Cod;
use App\Model\Manager_users;
use Illuminate\Http\Request;
use App\Model\Cods\CodDelete;
use App\Http\Middleware\Rider;
use App\Model\Cods\CloseMonth;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use App\Model\CodUpload\CodUpload;
use App\Model\UserCodes\UserCodes;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Cods\CodActionHistory;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Assign\AssignPlateform;
use App\Model\Cods\DeliverooFollowUp;
use App\Model\CodPrevious\CodPrevious;
use App\Model\Passport\PassportLocker;
use Illuminate\Support\Facades\Storage;
use App\Model\Passport\PassportToLocker;
use App\Model\PlatformCode\PlatformCode;
use App\Model\Passport\PassportWithRider;
use App\Model\RiderReport\RiderFollowUps;
use Illuminate\Support\Facades\Validator;
use App\Model\SimReplacement\SimReplacement;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\RiderReport\RiderReportFollowup;
use App\Model\Passport\passport_addtional_info;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\Riders\RiderPerformance\TalabatRiderPerformance;

class CodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|cod-missing-rider', ['only' => ['missing_rider_id']]);
        $this->middleware('role_or_permission:Admin|Cod|deliveroo_cod', ['only' => [
            'cod_dashboard','index','cod_detail','cash_paid_detail','bank_paid_detail','cod_rider_log','cod_bank','cod_bank_issue','rider_cod','cod_adjust','cod_uploads','uploaded_data','cod_close_month','add_cod_bank_request','add_cod_cash_request','close_month_report','ajax_close_month_report'
        ]]);
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {

            if($request->verify){

                if(!empty($request->from_date))
                {
                    $data = Cods::where('type','=','0')->where('platform_id','=',$request->platform)->where('status','=','1')->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','0')->where('status','=','1')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status','<h4 class="badge badge-primary">Approved</h4>')
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-success">'.$name.'</h4>';
                    })
                    ->addColumn('name',function(Cods $cod){

                        return $cod->passport->personal_info->full_name;

                    })->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                         $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })
                    ->editColumn('amount',function(Cods $cod){


                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->addColumn('action',function(Cods $cod) {
                        $html_ab = "";

                            $html_ab = '
                            <a class="text-danger mr-2 delete_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Close-Window font-weight-bold" ></i ></a>
                            ';

                        return  $html_ab;
                    })
                    ->rawColumns(['status','verify_by','action','amount'])
                    ->make(true);
            }elseif($request->not_verify){

                if(!empty($request->from_date))
                {

                    $data = Cods::where('type','=','0')->where('platform_id','=',$request->platform)->where('status','=','0')->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','0')->where('status','=','0')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<h4 class="badge badge-primary"></h4>Pending</h4>';
                        }elseif($cod->status == "2"){
                            $html_ab = '<h4 class="badge badge-primary">Rejected</h4>';
                        }else{
                              $html_ab = '<h4 class="badge badge-primary">Approved</h4>>';
                        }
                        return  $html_ab;
                    })
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-primary">'.$name.'</h4>';
                    })
                    ->addColumn('name',function(Cods $cod){
                        return $cod->passport->personal_info->full_name;

                    })
                    ->editColumn('amount',function(Cods $cod){


                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })
                    ->addColumn('action',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';
                        }elseif($cod->status == "2"){
                            $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>';
                        }
                        return  $html_ab;
                    })->rawColumns(['status','verify_by','action','amount'])
                    ->make(true);

            }elseif($request->rejected){

                if(!empty($request->from_date))
                {

                    $data = Cods::where('type','=','0')->where('platform_id','=',$request->platform)->where('status','=','2')->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','0')->where('status','=','2')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<h4 class="badge badge-primary"></h4>Pending</h4>';
                        }elseif($cod->status == "2"){
                            $html_ab = '<h4 class="badge badge-danger">Rejected</h4>';
                        }else{
                            $html_ab = '<h4 class="badge badge-primary">Approved</h4>>';
                        }
                        return  $html_ab;
                    })
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-primary">'.$name.'</h4>';
                    })
                    ->editColumn('amount',function(Cods $cod){


                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->addColumn('name',function(Cods $cod){

                        return $cod->passport->personal_info->full_name;

                    })->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })
                    ->addColumn('action',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';
                        }elseif($cod->status == "2"){
                            $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>';
                        }
                        return  $html_ab;
                    })->rawColumns(['status','verify_by','action','amount'])
                    ->make(true);

            }

        }


//        $not_verified = Cods::where('type','=','0')->where('status','=','0')->get();
//        $verified = Cods::where('type','=','0')->where('status','=','1')->get();
//        $rejected = Cods::where('type','=','0')->where('status','=','2')->get();


        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }


        return view('admin-panel.cods.index',compact('platforms'));

    }
    public function cod_amount_delete(Request $request){
        $id=  $request->id;
        $cod = Cods::find($id);
        $cod->delete();

        $message = [
            'message' => 'Deleted Successfully!!',
            'alert-type' => 'success',

        ];
        return redirect()->back()->with($message);
    }


    public function cod_dashboard(){

        $first_date[] = CodUpload::oldest()->first()->start_date ?? Carbon::today()->format('Y-m-d');
        $first_date[] = Cods::oldest()->first()->date ?? Carbon::today()->format('Y-m-d');
        $first_date[] = CodAdjustRequest::oldest()->first()->order_start_date ?? Carbon::today()->format('Y-m-d');
        $first_date[] = CloseMonth::oldest()->first()->date ?? Carbon::today()->format('Y-m-d');

        $start_dates[] = min($first_date);
        $end_dates = CloseMonth::distinct('date')->pluck('date')->toArray();
        $start_dates = array_merge($start_dates, $end_dates);
        $date_range = [
            'start_dates' => $start_dates,
            'end_dates' => $end_dates
        ];
        $last_closing_date = CloseMonth::latest('date')->first()->date ?? CodUpload::oldest('start_date')->first()->start_date ?? Carbon::today();
        $today = Carbon::today()->format('Y-m-d');
        $toal_cod = CodUpload::whereBetween('start_date', [$last_closing_date, $today])->sum('amount');
        $cods = Cods::select('type', 'amount')->whereStatus(1)->whereBetween('date', [$last_closing_date, $today])->get();
        $total_received_cod = $cods->sum('amount');
        $total_adjustment_received = CodAdjustRequest::whereBetween('order_date', [$last_closing_date, $today])->whereStatus(2)->sum('amount');
        $close_month = CloseMonth::whereDate('date', $last_closing_date )->sum('close_month_amount');
        $total_remain = $toal_cod - ($total_received_cod + $total_adjustment_received);
        $total_cash_received = $cods->where('type',0)->sum('amount');
        $total_bank_received = $cods->where('type',1)->sum('amount');
        return view('admin-panel.cods.dashboard',
            compact(
                'total_remain',
                'total_cash_received',
                'total_bank_received',
                'total_adjustment_received',
                'toal_cod',
                'close_month',
                'last_closing_date',
                'date_range'
            ));
    }

    public function ajax_cod_dashboard(){
        if(request('date_range') == 'latest'){
            $start_date = CloseMonth::latest('date')->first()->date ??
            CodUpload::oldest('start_date')->first()->start_date ??
            Carbon::today();
            $start_date = Carbon::parse($start_date)->addDay(1)->format('Y-m-d');
            $end_date = Carbon::today()->format('Y-m-d');
        }else{
            $date_range = request('date_range') ? explode('_', request('date_range')) : [];
            $start_date = Carbon::parse($date_range[0])->format('Y-m-d');//->addDay(1);
            $end_date = Carbon::parse($date_range[1])->format('Y-m-d');
        }
        $uploaded_cods = CodUpload::with(['passport.personal_info'])->whereBetween('start_date', [$start_date, $end_date])->get();
        $toal_cod = $uploaded_cods->sum('amount');
        $cods = Cods::with(['passport.check_platform_code_exist', 'passport.personal_info'])->whereStatus(1)->whereBetween('date', [$start_date, $end_date])->get();
        $total_received_cod = $cods->sum('amount');
        $all_adjustments = CodAdjustRequest::whereBetween('order_date', [$start_date, $end_date])->whereStatus(2)->get();
        $total_adjustment_received = $all_adjustments->sum('amount');
        $close_month = CloseMonth::whereDate('date', request('date_range') == 'latest' ? $start_date : $end_date )->sum('close_month_amount');
        $total_remain = $toal_cod - ($total_received_cod + $total_adjustment_received + (request('date_range') == 'latest' ? 0 : $close_month));
        $total_cash_received = $cods->where('type',0)->sum('amount');
        $total_bank_received = $cods->where('type',1)->sum('amount');
        $view = view('admin-panel.cods.shared_blades.ajax_deliveroo_report',
            compact(
                'cods',
                'total_remain',
                'total_cash_received',
                'total_bank_received',
                'all_adjustments',
                'total_adjustment_received',
                'uploaded_cods',
                'toal_cod',
                'close_month',
                'start_date',
                'end_date'
            ))->render();
            return response([
                'html' => $view
            ]);
    }

    public function cod_total(Request $request){

        $data = Cods::where('type','=','1')->where('platform_id','=',$request->plat)->where('status','=','1')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }
    public function cod_total_not(Request $request){

        $data = Cods::where('type','=','1')->where('platform_id','=',$request->plat)->where('status','=','0')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }
    public function cod_total_reject(Request $request){

        $data = Cods::where('type','=','1')->where('platform_id','=',$request->plat)->where('status','=','2')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }

    public  function  cod_bank(Request $request){

        if($request->ajax()){

            if($request->verify){

                if(!empty($request->from_date))
                {
                    $data = Cods::where('type','=','1')->where('platform_id','=',$request->platform)->where('status','=','1')->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','1')->where('status','=','1')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status','<h4 class="badge badge-primary">Approved</h4>')
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-success">'.$name.'</h4>';
                    })
                    ->editColumn('message',function(Cods $cod){
                        $id = $cod->id;
                        if(isset($cod->message)){
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        }else{
                            $mg ='<span class="badge badge-info">No Message</span>';
                        }
                        return $mg;
                    })
                    ->editColumn('picture',function(Cods $cod){
                        $btn = "";
                        if(isset($cod->picture)){
                            $url = Storage::temporaryUrl($cod->picture, now()->addMinutes(5));
                            $btn = '<a href="'.$url.'" target="_blank">
                                            See image
                                        </a>';
                        }else{
                            $btn = '<span class="badge badge-info">No Image</span> ';
                        }
                        return $btn;
                    })
                    ->editColumn('amount',function(Cods $cod){


                        return $cod->amount . ' <span class="badge badge-success">AED</span>';

                    })
                    ->addColumn('name',function(Cods $cod){

                        return $cod->passport->personal_info->full_name;

                    }) ->addColumn('transaction_type',function(Cods $cod){
                        if($cod->transaction_type=='0')
                        {
                            $html_trans='Application';
                        }
                        else{
                            $html_trans='Web';
                        }
                        return $html_trans;

                        return $cod->passport->personal_info->full_name;

                    })->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })
                    ->addColumn('action',function(Cods $cod) {
                        $html_ab = "";
                        $html_ab = '
                                    <a class="text-success mr-2 add_img" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="fa fa-upload" style="font-size:15px;cursor: pointer;"></i></a>
                                    <a class="text-danger mr-2 delete_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Close-Window font-weight-bold" ></i ></a>';

                        return  $html_ab;
                    })
                    ->addColumn('edit',function(Cods $cod) {
                        $html_edit = "";
                        $url = url('cod_edit',$cod->id);
                        $html_edit = '<a class="text-success mr-2"  href = "'.$url.'" target="_blank" >Edit</a>';
                        return  $html_edit;
                    })
                    ->rawColumns(['status','verify_by','action','picture','message','edit','transaction_type','amount'])
                    ->make(true);
            }elseif($request->not_verify){



                if(!empty($request->from_date))
                {
                    $data = Cods::where('type','=','1')->where('platform_id','=',$request->platform)->where('status','=','0')->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','1')->where('status','=','0')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<h4 class="badge badge-primary"></h4>Pending</h4>';
                        }elseif($cod->status == "2"){
                            $html_ab = '<h4 class="badge badge-primary">Rejected</h4>';
                        }else{
                            $html_ab = '<h4 class="badge badge-primary">Approved</h4>>';
                        }
                        return  $html_ab;
                    })
                    ->editColumn('message',function(Cods $cod){
                        $id = $cod->id;
                        if(isset($cod->message)){
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        }else{
                            $mg ='<span class="badge badge-info">No Message</span>';
                        }
                        return $mg;
                    })
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-primary">'.$name.'</h4>';
                    })
                    ->editColumn('amount',function(Cods $cod){


                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->editColumn('picture',function(Cods $cod){
                        $btn = "";
                        if(isset($cod->picture)){
                            $url = url($cod->picture);
                            $btn = '<a href="'.$url.'" target="_blank">
                                            See image
                                        </a>';
                        }else{
                            $btn = '<span class="badge badge-info">No Image</span>';
                        }
                        return $btn;
                    })->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })->addColumn('name',function(Cods $cod){
                        return $cod->passport->personal_info->full_name;
                    })->addColumn('action',function(Cods $cod) {
                        $html_ab = "";


                        $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>'.'
                        <a class="text-success mr-2 add_img" id = "'.$cod->id.'" href = "javascript:void(0)" >
                            <i class="fa fa-upload" style="font-size:15px;cursor: pointer;"></i></a>';

                        return  $html_ab;
                    })
                    ->rawColumns(['status','verify_by','action','picture','message','amount'])
                    ->make(true);

            }elseif($request->rejected){

                if(!empty($request->from_date))
                {

                    $data = Cods::where('type','=','1')->where('platform_id','=',$request->platform)->where('status','=','2')->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','1')->where('status','=','2')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<h4 class="badge badge-primary"></h4>Pending</h4>';
                        }elseif($cod->status == "2"){
                            $html_ab = '<h4 class="badge badge-danger">Rejected</h4>';
                        }else{
                            $html_ab = '<h4 class="badge badge-primary">Approved</h4>>';
                        }
                        return  $html_ab;
                    })
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-primary">'.$name.'</h4>';
                    })
                    ->editColumn('picture',function(Cods $cod){
                        $btn = "";
                        if(isset($cod->picture)){
                            $url = url($cod->picture);
                            $btn = '<a href="'.$url.'" target="_blank">
                                            See image
                                        </a>';
                        }else{
                            $btn = '<span class="badge badge-info">No Image</span>';
                        }
                        return $btn;
                    })
                    ->editColumn('message',function(Cods $cod){
                        $id = $cod->id;
                        if(isset($cod->message)){
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        }else{
                            $mg ='<span class="badge badge-info">No Message</span>';
                        }
                        return $mg;
                    })->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })
                    ->editColumn('amount',function(Cods $cod){


                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->addColumn('name',function(Cods $cod){
                        return $cod->passport->personal_info->full_name;
                    })->addColumn('action',function(Cods $cod) {
                        $html_ab = "";

                        $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>'.'
                        <a class="text-success mr-2 add_img" id = "'.$cod->id.'" href = "javascript:void(0)" >
                            <i class="fa fa-upload" style="font-size:15px;cursor: pointer;"></i></a>';

                        return  $html_ab;
                    })->addColumn('edit',function(Cods $cod) {
                        $html_edit = "";
                        $url = url('cod_edit',$cod->id);
//                        $url = "ghgf";
                        $html_edit = '<a class="text-success mr-2"  href = "'.$url.'" target="_blank" >Edit</a>';



                        return  $html_edit;
                    })
                    ->editColumn('rejected_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->reject_by->name)){
                            $name =  $cod->reject_by->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-primary">'.$name.'</h4>';
                    })
                    ->rawColumns(['status','rejected_by','action','picture','message','edit','amount'])
                    ->make(true);

            }
        }

        $not_verified = Cods::where('type','=','1')->where('status','=','0')->get();
        $verified = Cods::where('type','=','1')->where('status','=','1')->get();;
        $rejected = Cods::where('type','=','1')->where('status','=','2')->get();

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

        return view('admin-panel.cods.bank_cod',compact('platforms','not_verified','verified','rejected'));
    }

    public  function cod_bank_issue(Request $request){


        if($request->ajax()){

            if($request->verify){

                if(!empty($request->from_date))
                {
                    $data = Cods::where('type','=','3')->where('platform_id','=',$request->platform)->where('status','=','1')->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','3')->where('status','=','1')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status','<h4 class="badge badge-primary">Approved</h4>')
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-success">'.$name.'</h4>';
                    })
                    ->editColumn('picture',function(Cods $cod){
                        $btn = "";
                        if(isset($cod->picture)){
                            $url = url($cod->picture);
                            $btn = '<a href="'.$url.'" target="_blank">
                                            See image
                                        </a>';
                        }else{
                            $btn = '<span class="badge badge-info">No Image</span>';
                        }
                        return $btn;
                    })
                    ->editColumn('message',function(Cods $cod){
                        $id = $cod->id;
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        return $mg;
                    })->addColumn('name',function(Cods $cod){

                        return $cod->passport->personal_info->full_name;

                    })
                    ->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })
                    ->editColumn('amount',function(Cods $cod){


                        return '<span class="badge badge-success">AED</span> '.$cod->amount;

                    })
                    ->addColumn('action',function(Cods $cod) {
                        $html_ab = "";


                        $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>';

                        return  $html_ab;
                    })
                    ->rawColumns(['status','verify_by','action','picture','message','amount'])
                    ->make(true);
            }elseif($request->not_verify){

                if(!empty($request->from_date))
                {

                    $data = Cods::where('type','=','3')->where('status','=','0')->where('platform_id','=',$request->platform)->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','3')->where('status','=','0')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<h4 class="badge badge-primary"></h4>Pending</h4>';
                        }elseif($cod->status == "2"){
                            $html_ab = '<h4 class="badge badge-primary">Rejected</h4>';
                        }else{
                            $html_ab = '<h4 class="badge badge-primary">Approved</h4>>';
                        }
                        return  $html_ab;
                    })
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-primary">'.$name.'</h4>';
                    })
                    ->editColumn('picture',function(Cods $cod){
                        $btn = "";
                        if(isset($cod->picture)){
                            $url = url($cod->picture);
                            $btn = '<a href="'.$url.'" target="_blank">
                                            See image
                                        </a>';
                        }else{
                            $btn = '<span class="badge badge-info">No Image</span>';
                        }
                        return $btn;
                    })
                    ->editColumn('amount',function(Cods $cod){


                        return '<span class="badge badge-success">AED</span> '.$cod->amount;

                    })
                    ->editColumn('message',function(Cods $cod){
                        $id = $cod->id;
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        return $mg;
                    })->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })->addColumn('name',function(Cods $cod){

                        return $cod->passport->personal_info->full_name;

                    })->addColumn('action',function(Cods $cod) {
                        $html_ab = "";
                        $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>';

                        return  $html_ab;
                    })
                    ->rawColumns(['status','verify_by','action','picture','message','amount'])
                    ->make(true);

            }elseif($request->rejected){

                if(!empty($request->from_date))
                {

                    $data = Cods::where('type','=','3')->where('status','=','2')->where('platform_id','=',$request->platform)->whereBetween('date', [$request->from_date, $request->end_date])->orderby('id','desc')->get();
                }else{
                    $data = Cods::where('type','=','3')->where('status','=','2')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status',function(Cods $cod) {
                        $html_ab = "";

                        if($cod->status == "0"){
                            $html_ab = '<h4 class="badge badge-primary"></h4>Pending</h4>';
                        }elseif($cod->status == "2"){
                            $html_ab = '<h4 class="badge badge-danger">Rejected</h4>';
                        }else{
                            $html_ab = '<h4 class="badge badge-primary">Approved</h4>>';
                        }
                        return  $html_ab;
                    })
                    ->editColumn('verify_by',function(Cods $cod){
                        $name = "";
                        if(!empty($cod->verifyby->name)){
                            $name =  $cod->verifyby->name;
                        }else{
                            $name =  "N/A";
                        }
                        return '<h4 class="badge badge-primary">'.$name.'</h4>';
                    })->addColumn('rider_id',function(Cods $cod){

                        $platform_id = $cod->platform_id;

                        $rider_id = isset($cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$cod->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A";

                        return $rider_id;

                    })->editColumn('message',function(Cods $cod){
                        $id = $cod->id;
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        return $mg;
                    })
                    ->editColumn('picture',function(Cods $cod){
                        $btn = "";
                        if(isset($cod->picture)){
                            $url = url($cod->picture);
                            $btn = '<a href="'.$url.'" target="_blank">
                                            See image
                                        </a>';
                        }else{
                            $btn = '<span class="badge badge-info">No Image</span>';
                        }
                        return $btn;
                    })
                    ->editColumn('amount',function(Cods $cod){


                        return '<span class="badge badge-success">AED</span> '.$cod->amount;

                    })

                    ->addColumn('name',function(Cods $cod){

                        return $cod->passport->personal_info->full_name;

                    })->addColumn('action',function(Cods $cod) {
                        $html_ab = "";


                        $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a>';

                        return  $html_ab;
                    })
                    ->rawColumns(['status','verify_by','action','picture','message','amount'])
                    ->make(true);

            }
        }

        $not_verified = Cods::where('type','=','3')->where('status','=','0')->get();
        $verified = Cods::where('type','=','3')->where('status','=','1')->get();;
        $rejected = Cods::where('type','=','3')->where('status','=','2')->get();

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

        return view('admin-panel.cods.cod_bank_issue',compact('not_verified','verified','rejected','platforms'));


    }

    public function cod_close_month(Request $request){

        $riderProfile = CodUpload::select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
         $cods = Cods::get();
        $codadjust = CodAdjustRequest::get();
        $close_month = CloseMonth::all();

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

        return view('admin-panel.cods.close_month',compact('platforms','riderProfile','cods','codadjust','close_month'));
    }

    public function cod_close_month_ajax(Request $request){

        $riderProfile = CodUpload::with('close_month','cods','codadjust','rider_profile','passport.personal_info',
                        'passport.check_platform_code_exist')->select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();

        $view = view('admin-panel.cods.ajax_close_month',compact('riderProfile'))->render();
        return $view;
    }

    public function close_month_report(){

        $dates_batch = CloseMonth::distinct()->Orderby('id','desc')->get('date');
        return view('admin-panel.cods.close_month_report',compact('dates_batch'));
    }

    public function ajax_close_month_report(Request $request){

        if(!empty($request->batch_date)){
            $close_month = CloseMonth::where('date','=',$request->batch_date)->get();
        }
        else{
            $close_month = CloseMonth::whereBetween('date', [$request->start_date, $request->end_date])->get();
        }

        return Datatables::of($close_month)
        ->addColumn('name', function (CloseMonth $close) {
            $name = "";
            if(!empty($close->passport->personal_info->full_name)){
                $name =  $close->passport->personal_info->full_name;
            }else{
                $name =  "N/A";
            }
            return $name;
        })
        ->addColumn('created_at', function (CloseMonth $close) {
            return $close->created_at->format('Y-m-d');
        })
        ->make(true);
    }
    public function ajax_total_close_month(Request $request){

        if(!empty($request->batch_date)){
            $total_amount = CloseMonth::select(DB::raw('sum(close_month_amount) as total_amount'))
                            ->where('date', $request->batch_date)->first();
            $total_rider = CloseMonth::where('date', $request->batch_date)->distinct()->get(['platform_code'])->count();
        }
        else{
            $total_amount = CloseMonth::select(DB::raw('sum(close_month_amount) as total_amount'))
                            ->whereBetween('date', [$request->start_date, $request->end_date])->first();
            $total_rider = CloseMonth::whereBetween('date', [$request->start_date, $request->end_date])->distinct()->get(['platform_code'])->count();
        }

                $array_to_send = array(
                    'total_amount' => isset($total_amount->total_amount) ? number_format($total_amount->total_amount, 2) : 0,
                    'total_rider' => isset($total_rider) ? $total_rider : 0,
                );

                echo json_encode($array_to_send);
                exit;
    }


    public function view_balance_cod(){
        return view('admin-panel.cods.view_balance_cod');
    }

    public function ajax_balance_cod(Request $request){

        $user = Auth::user();
        $cods = Cods::where('platform_id','=',$request->platform)->get();
        $codadjust = CodAdjustRequest::where('platform_id','=',$request->platform)->get();
        $close_month = CloseMonth::all();
        $amt = $request->amt;

        if($user->hasRole(['DC_roll'])){
            $riderProfile = CodUpload::whereHas('rider_code.passport.dc_detail', function($q) use($user) {
                $q->where('user_id','=', $user->id);
            })->where('platform_id','=',$request->platform)->select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();

            $view = view('admin-panel.cods.ajax_balance_cod',compact('amt','riderProfile','cods','codadjust','close_month'))->render();
            return $view;
        }elseif($user->hasRole(['Admin']) || $user->hasRole(['deliveroo_cod'])){
            $riderProfile = CodUpload::where('platform_id','=',$request->platform)->select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
            $view = view('admin-panel.cods.ajax_balance_cod',compact('amt','riderProfile','cods','codadjust','close_month'))->render();
            return $view;
        }
    }

    public function follow_up_calls(Request $request)
    {
        $follow_up_calls = CodUpload::whereId($request->deliveroo_upload_id)->with('follow_ups')->first()->follow_ups;
        $view = view('admin-panel.cods.follow_up_calls',compact('follow_up_calls'))->render();
        return response()->json(['html' => $view]);
    }


    public function cod_save_close_month(Request $request){

// return $request->all();
        $validator = Validator::make($request->all(), [
            'details' => 'required',
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'minimum one rider should checked to close the month',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        foreach($request->details as $key => $value) {
            if(isset($request->details[$key]['rider_ids']) && isset($request->details[$key]['passport_id'])) {
                $close_month = new CloseMonth();
                $close_month->passport_id = $request->details[$key]['passport_id'];
                $close_month->platform_code = $request->details[$key]['rider_ids'];
                $close_month->close_month_amount = $request->details[$key]['amount'];
                $close_month->date = $request->start_date;
                $close_month->save();
            }
        }


        // $riderProfile = CodUpload::select('rider_id', DB::raw('sum(amount) as total'))->whereIn('rider_id',$request->rider_ids)->groupBy('rider_id')->get();
        // $cods = Cods::get();
        // $codadjust = CodAdjustRequest::get();
        // $close_month = CloseMonth::all();

        // foreach($riderProfile as $rider){
        //     $total_pending_amount = 0;
        //     $total_paid_amount = 0;
        //     $total_previous_amount = 0;
        //     $close_m = 0;
        //     $total_pending_amount = $rider->total;
        //     if(!empty($rider->rider_code->passport->profile->user_id)){
        //         $now_cod = $cods->where('passport_id',$rider->rider_code->passport->id)->where('status','1')->sum('amount');
        //         $adj_req_t = $codadjust->where('passport_id','=',$rider->rider_code->passport->id)->where('status','=','2')->sum('amount');
        //         $close_m = $close_month->where('passport_id','=',$rider->rider_code->passport_id)->sum('close_month_amount');
        //     }
        //     if($now_cod != null){
        //         $total_paid_amount = $now_cod;
        //     }
        //     if($close_m != null){
        //         $total_paid_amount = $total_paid_amount+$close_m;
        //     }

        //     $pre_amount = isset($rider->rider_code->passport->previous_balance) ? $rider->rider_code->passport->previous_balance : 0;
        //     $total_pending_amount = $total_pending_amount+$pre_amount;

        //     if($adj_req_t != null){
        //         $total_paid_amount = $total_paid_amount+$adj_req_t;
        //     }
        //     $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');

        //     if(!empty($rider->rider_code->platform_name->name) && !empty($rider->rider_code->passport->id)){
        //         if($remain_amount < 0){

        //         }else{

        //             $close_month = new CloseMonth();
        //             $close_month->passport_id = $rider->rider_code->passport->id;
        //             $close_month->platform_code = $rider->rider_code->platform_code;
        //             $close_month->close_month_amount = $remain_amount;
        //             $close_month->save();
        //         }
        //     }

        // }

        $message = [
            'message' => 'Month has been Closed Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('cod_close_month')->with($message);

    }
    public function cod_rider_log($id){

  $rider_profile = RiderProfile::find($id);
  $check_in_platform = $rider_profile->passport->platform_assign->pluck(['plateform'])->toArray();
  $rider_platform_code = $rider_profile->passport->platform_codes->whereIn('platform_id',$check_in_platform)->pluck('platform_code')->toArray();
     $array_to_send = array();
    $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->orderby('id','asc')->first();
    if(!empty($cod_uploads->created_at)){
        $start_date = explode(" ",$cod_uploads->created_at);
        $start_date = $start_date[0];
    }else{
        $start_date = date("Y-m-d");
    }
    $end_date = date("Y-m-d");

    $begin = new DateTime($start_date);
    $end   = new DateTime($end_date);

    $array_to_send = array();
    $total_debit = 0;
    $total_credit = 0;
    $total_balance = 0;







        for($i = $begin; $i <= $end; $i->modify('+1 day')){

            $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();
                foreach($cod_uploads as $upload){
                    $gamer = array(
                            'cod_amount' => $upload->amount,
                            'cod_date' => $upload->start_date,
                            'type' => 'upload sheet',
                            'cod_type' => "uploads",
                    );
                    $array_to_send [] = $gamer;
                    $total_credit = $total_credit+$upload->amount;

                    $total_balance = $total_balance+$upload->amount;
                }


            $cods = $cods = Cods::where('passport_id','=',$rider_profile->passport_id)->where('status','=','1')->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
            foreach($cods as $cod){
                if($cod->type=="0"){
                    $gamer = array(
                        'cod_amount' => $cod->amount,
                        'cod_date' => $cod->created_at->toDateString(),
                        'type' => 'cash cod',
                        'cod_type' => 'cods',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$cod->amount;
                    $total_balance = $total_balance-$cod->amount;
                }elseif($cod->type=="1"){
                    $gamer = array(
                        'cod_amount' => $cod->amount,
                        'cod_date' => $cod->created_at->toDateString(),
                        'type' => 'bank cod',
                        'cod_type' => 'cods',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$cod->amount;
                    $total_balance = $total_balance-$cod->amount;
                }elseif($cod->type=="3"){
                    $gamer = array(
                        'cod_amount' => $cod->amount,
                        'cod_date' => $cod->created_at->toDateString(),
                        'type' => 'bank issue cod',
                        'cod_type' => 'cods',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$cod->amount;
                    $total_balance = $total_balance-$cod->amount;
                }
            }


             $cods_adjust = CodAdjustRequest::where('passport_id','=',$rider_profile->passport_id)
                                             ->where('status','=','2')
                                             ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
            foreach($cods_adjust as $adj){

                    $gamer = array(
                        'cod_amount' => $adj->amount,
                        'cod_date' => $adj->created_at->toDateString(),
                        'type' => 'adjust cod',
                        'cod_type' => 'adjust',
                    );
                    $array_to_send [] = $gamer;
                $total_debit = $total_debit+$adj->amount;
                $total_balance = $total_balance-$adj->amount;
            }


            $cods_close_month = CloseMonth::where('passport_id','=',$rider_profile->passport->id)
                ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
            foreach($cods_close_month as $close_month){
                $gamer = array(
                    'cod_amount' => $close_month->close_month_amount,
                    'cod_date' => $close_month->created_at->toDateString(),
                    'type' => 'close month',
                    'cod_type' => 'close_month',
                );
                $array_to_send [] = $gamer;
                $total_debit = $total_debit+$close_month->close_month_amount;
                $total_balance = $total_balance-$close_month->close_month_amount;
            }



        }

        $full_name = $rider_profile->passport->personal_info->full_name;

         $prev_amount = isset($rider_profile->passport->previous_balance->amount) ? $rider_profile->passport->previous_balance->amount : '0';
         $prev_amount_date = isset($rider_profile->passport->previous_balance->updated_at) ? $rider_profile->passport->previous_balance->updated_at : 'N/A';



        $total_credit = $total_credit+$prev_amount;
        $total_balance = $total_balance+$prev_amount;
         return view('admin-panel.cods.rider_cod_log',compact('array_to_send','full_name','prev_amount','prev_amount_date','total_credit','total_debit','total_balance'));
    }

    public  function cod_rider_log_ajax(Request $request){

        if($request->ajax()){

            $id = $request->rider_id;

            $rider_profile = RiderProfile::find($id);

            $check_in_platform = $rider_profile->passport->platform_assign->pluck(['plateform'])->toArray();
            $rider_platform_code = $rider_profile->passport->platform_codes->whereIn('platform_id',$check_in_platform)->pluck('platform_code')->toArray();

            $array_to_send = array();

            $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->orderby('id','asc')->first();

            if(!empty($cod_uploads->created_at)){
                $start_date = explode(" ",$cod_uploads->created_at);
                $start_date = $start_date[0];
            }else{
                $start_date = date("Y-m-d");
            }

            $end_date = date("Y-m-d");

            if(!empty($request->start_date) && !empty($request->end_date)){

                $begin = new DateTime($request->start_date);
                $end   = new DateTime($request->end_date);

            }else{
                $begin = new DateTime($start_date);
                $end   = new DateTime($end_date);

            }



            $array_to_send = array();
            $total_debit = 0;
            $total_credit = 0;
            $total_balance = 0;


            for($i = $begin; $i <= $end; $i->modify('+1 day')){

                if($request->start_date=='clear_filter'){
                    $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();
                }else{
                    $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->where('start_date','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();
                }

                foreach($cod_uploads as $upload){
                    $gamer = array(
                        'cod_amount' => $upload->amount,
                        'cod_date' => $upload->start_date,
                        'type' => 'upload sheet',
                        'cod_type' => "uploads",
                    );
                    $array_to_send [] = $gamer;
                    $total_credit = $total_credit+$upload->amount;

                    $total_balance = $total_balance+$upload->amount;
                }


                $cods = $cods = Cods::where('passport_id','=',$rider_profile->passport_id)->where('status','=','1')->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods as $cod){
                    if($cod->type=="0"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'cash cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }elseif($cod->type=="1"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'bank cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }elseif($cod->type=="3"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'bank issue cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }
                }


                $cods_adjust = CodAdjustRequest::where('passport_id','=',$rider_profile->passport_id)
                    ->where('status','=','2')
                    ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods_adjust as $adj){

                    $gamer = array(
                        'cod_amount' => $adj->amount,
                        'cod_date' => $adj->created_at->toDateString(),
                        'type' => 'adjust cod',
                        'cod_type' => 'adjust',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$adj->amount;
                    $total_balance = $total_balance-$adj->amount;
                }


                $cods_close_month = CloseMonth::where('passport_id','=',$rider_profile->passport->id)
                    ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods_close_month as $close_month){
                    $gamer = array(
                        'cod_amount' => $close_month->close_month_amount,
                        'cod_date' => $close_month->created_at->toDateString(),
                        'type' => 'close month',
                        'cod_type' => 'close_month',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$close_month->close_month_amount;
                    $total_balance = $total_balance-$close_month->close_month_amount;
                }



            }

            $full_name = $rider_profile->passport->personal_info->full_name;

            $prev_amount = isset($riderProfile->user->profile->passport->previous_balance->amount) ? $riderProfile->user->profile->passport->previous_balance->amount : '0';
            $prev_amount_date = isset($riderProfile->user->profile->passport->previous_balance->updated_at) ? $riderProfile->user->profile->passport->previous_balance->updated_at : '0';

            $total_credit = $total_credit+$prev_amount;
            $total_balance = $total_balance+$prev_amount;

            $view = view("admin-panel.cods.rider_cod_log_ajax",compact('array_to_send','full_name','prev_amount','prev_amount_date','total_credit','total_debit','total_balance'))->render();

            return response()->json(['html'=>$view]);
        }

    }


    public  function download_rider_log(Request $request){



            $id = $request->rider_id;

            $rider_profile = RiderProfile::find($id);

            $check_in_platform = $rider_profile->passport->platform_assign->pluck(['plateform'])->toArray();
            $rider_platform_code = $rider_profile->passport->platform_codes->whereIn('platform_id',$check_in_platform)->pluck('platform_code')->toArray();

            $array_to_send = array();

            $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->orderby('id','asc')->first();

            if(!empty($cod_uploads->created_at)){
                $start_date = explode(" ",$cod_uploads->created_at);
                $start_date = $start_date[0];
            }else{
                $start_date = date("Y-m-d");
            }

             $end_date = date("Y-m-d");

            if(!empty($request->start_date) && !empty($request->end_date)){

                $begin = new DateTime($request->start_date);
                $end   = new DateTime($request->end_date);

            }else{
                $begin = new DateTime($start_date);
                $end   = new DateTime($end_date);
            }

            $array_to_send = array();
            $total_debit = 0;
            $total_credit = 0;
            $total_balance = 0;


            for($i = $begin; $i <= $end; $i->modify('+1 day')){

                if($request->start_date=='clear_filter'){
                    $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();
                }else{
                    $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->where('start_date','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();
                }

                foreach($cod_uploads as $upload){
                    $gamer = array(
                        'cod_amount' => $upload->amount,
                        'cod_date' => $upload->start_date,
                        'type' => 'upload sheet',
                        'cod_type' => "uploads",
                    );
                    $array_to_send [] = $gamer;
                    $total_credit = $total_credit+$upload->amount;

                    $total_balance = $total_balance+$upload->amount;
                }


                $cods = $cods = Cods::where('passport_id','=',$rider_profile->passport_id)->where('status','=','1')->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods as $cod){
                    if($cod->type=="0"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'cash cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }elseif($cod->type=="1"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'bank cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }elseif($cod->type=="3"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'bank issue cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }
                }


                $cods_adjust = CodAdjustRequest::where('passport_id','=',$rider_profile->passport_id)
                    ->where('status','=','2')
                    ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods_adjust as $adj){

                    $gamer = array(
                        'cod_amount' => $adj->amount,
                        'cod_date' => $adj->created_at->toDateString(),
                        'type' => 'adjust cod',
                        'cod_type' => 'adjust',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$adj->amount;
                    $total_balance = $total_balance-$adj->amount;
                }


                $cods_close_month = CloseMonth::where('passport_id','=',$rider_profile->passport->id)
                    ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods_close_month as $close_month){
                    $gamer = array(
                        'cod_amount' => $close_month->close_month_amount,
                        'cod_date' => $close_month->created_at->toDateString(),
                        'type' => 'close month',
                        'cod_type' => 'close_month',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$close_month->close_month_amount;
                    $total_balance = $total_balance-$close_month->close_month_amount;
                }



            }

            $full_name = $rider_profile->passport->personal_info->full_name;

            $prev_amount = isset($riderProfile->user->profile->passport->previous_balance->amount) ? $riderProfile->user->profile->passport->previous_balance->amount : '0';
            $prev_amount_date = isset($riderProfile->user->profile->passport->previous_balance->updated_at) ? $riderProfile->user->profile->passport->previous_balance->updated_at : '0';

            $total_credit = $total_credit+$prev_amount;
            $total_balance = $total_balance+$prev_amount;



            $num_r = rand(0,1000);
            return Excel::download(new CodRiderLog('admin-panel.cods.rider_cod_log_table',$array_to_send, $full_name, $prev_amount, $prev_amount_date, $total_credit,$total_debit,$total_balance), "rider_cod_log{$num_r}.xlsx");




    }



    public function cod_rider_log_balance_ajax(Request $request){

        if($request->ajax()){

            $id = $request->rider_id;

            $rider_profile = RiderProfile::find($id);

            $check_in_platform = $rider_profile->passport->platform_assign->pluck(['plateform'])->toArray();
            $rider_platform_code = $rider_profile->passport->platform_codes->whereIn('platform_id',$check_in_platform)->pluck('platform_code')->toArray();

            $array_to_send = array();

            $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->orderby('id','asc')->first();

            if(!empty($cod_uploads->created_at)){
                $start_date = explode(" ",$cod_uploads->created_at);
                $start_date = $start_date[0];
            }else{
                $start_date = date("Y-m-d");
            }

            $end_date = date("Y-m-d");

            if(!empty($request->start_date) && !empty($request->end_date)){

                $begin = new DateTime($request->start_date);
                $end   = new DateTime($request->end_date);

            }else{
                $begin = new DateTime($start_date);
                $end   = new DateTime($end_date);

            }



            $array_to_send = array();
            $total_debit = 0;
            $total_credit = 0;
            $total_balance = 0;


            for($i = $begin; $i <= $end; $i->modify('+1 day')){

                if($request->start_date=='clear_filter'){
                    $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();
                }else{
                    $cod_uploads = CodUpload::whereIn('cod_uploads.rider_id',$rider_platform_code)->where('start_date','LIKE','%'.$i->format("Y-m-d").'%')->orderby('id','asc')->get();
                }

                foreach($cod_uploads as $upload){
                    $gamer = array(
                        'cod_amount' => $upload->amount,
                        'cod_date' => $upload->start_date,
                        'type' => 'upload sheet',
                        'cod_type' => "uploads",
                    );
                    $array_to_send [] = $gamer;
                    $total_credit = $total_credit+$upload->amount;

                    $total_balance = $total_balance+$upload->amount;
                }


                $cods = $cods = Cods::where('passport_id','=',$rider_profile->passport_id)->where('status','=','1')->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods as $cod){
                    if($cod->type=="0"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'cash cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }elseif($cod->type=="1"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'bank cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }elseif($cod->type=="3"){
                        $gamer = array(
                            'cod_amount' => $cod->amount,
                            'cod_date' => $cod->created_at->toDateString(),
                            'type' => 'bank issue cod',
                            'cod_type' => 'cods',
                        );
                        $array_to_send [] = $gamer;
                        $total_debit = $total_debit+$cod->amount;
                        $total_balance = $total_balance-$cod->amount;
                    }
                }


                $cods_adjust = CodAdjustRequest::where('passport_id','=',$rider_profile->passport_id)
                    ->where('status','=','2')
                    ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods_adjust as $adj){

                    $gamer = array(
                        'cod_amount' => $adj->amount,
                        'cod_date' => $adj->created_at->toDateString(),
                        'type' => 'adjust cod',
                        'cod_type' => 'adjust',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$adj->amount;
                    $total_balance = $total_balance-$adj->amount;
                }


                $cods_close_month = CloseMonth::where('passport_id','=',$rider_profile->passport->id)
                    ->where('created_at','LIKE','%'.$i->format("Y-m-d").'%')->get();
                foreach($cods_close_month as $close_month){
                    $gamer = array(
                        'cod_amount' => $close_month->close_month_amount,
                        'cod_date' => $close_month->created_at->toDateString(),
                        'type' => 'close month',
                        'cod_type' => 'close_month',
                    );
                    $array_to_send [] = $gamer;
                    $total_debit = $total_debit+$close_month->close_month_amount;
                    $total_balance = $total_balance-$close_month->close_month_amount;
                }



            }

            $full_name = $rider_profile->passport->personal_info->full_name;

            $prev_amount = isset($riderProfile->user->profile->passport->previous_balance->amount) ? $riderProfile->user->profile->passport->previous_balance->amount : '0';
            $prev_amount_date = isset($riderProfile->user->profile->passport->previous_balance->updated_at) ? $riderProfile->user->profile->passport->previous_balance->updated_at : '0';

            $total_credit = $total_credit+$prev_amount;
            $total_balance = $total_balance+$prev_amount;

            $gamer = array(
                'total_debit' => $total_debit,
                'total_credit' => $total_credit,
                'total_balance' => number_format($total_balance,2),
            );

            echo json_encode($gamer);
            exit;

        }

    }




    public function rider_cod(Request $request)
    {
        $riders = CodUpload::with('close_month',
            'cods','codadjust','rider_profile',
            'passport.personal_info','passport.check_platform_code_exist')
            ->select('id','passport_id', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
        return view('admin-panel.cods.rider_cod',compact('riders'));
    }

    public function cod_detail($id){

        $plaforms = Platform::all();

        $rider = RiderProfile::find($id);


        return view('admin-panel.cods.cod_detail',compact('plaforms','rider'));
    }

    public function cash_paid_detail(Request $request,$id){


        $rider = RiderProfile::find($id);
        $user_id = $rider->user_id;


        if ($request->ajax()){

            if(!empty($request->from_date))
            {
                $data = Cods::where('passport_id','=',$rider->passport_id)
                            ->where('type','=','0')
                            ->where('status','=','1')
                            ->whereBetween('date', [$request->from_date, $request->end_date])
                            ->latest()->get();

                return Datatables::of($data)
                    ->addColumn('name',function(Cods $cod){
                        return isset($cod->passport->personal_info->full_name) ? $cod->passport->personal_info->full_name : 'N/A';
                    })
                    ->addColumn('status',function(Cods $cod){
                        return "Approved";
                    })
                    ->make(true);

            }else{

                $data = Cods::where('passport_id','=',$rider->passport_id)->where('type','=','0')->where('status','=','1')->latest()->get();
                return Datatables::of($data)
                    ->addColumn('name',function(Cods $cod){
                        return isset($cod->user->passport->personal_info->full_name) ? $cod->user->passport->personal_info->full_name : 'N/A';
                    })
                    ->addColumn('status',function(Cods $cod){
                        return "Approved";
                    })
                    ->make(true);
            }

        }

        return view('admin-panel.cods.rider_cash_paid');
    }

        public function bank_paid_detail(Request $request,$id){


        $rider = RiderProfile::find($id);
        $user_id = $rider->user_id;

         $ab = Cods::where('passport_id','=',$rider->passport_id)->where('type','=','1')->where('status','=','1')->latest()->get();


        if($request->ajax()){

            if(!empty($request->from_date)) {

                $data = Cods::where('passport_id', '=', $rider->passport_id)
                              ->where('type', '=', '1')
                                ->where('status', '=', '1')
                                ->whereBetween('date', [$request->from_date, $request->end_date])
                                ->latest()->get();
                return Datatables::of($data)
                    ->addColumn('name', function (Cods $cod) {
                        return isset($cod->passport->personal_info->full_name) ? $cod->passport->personal_info->full_name : 'N/A';
                    })
                    ->addColumn('status', function (Cods $cod) {
                        return "Approved";
                    })
                    ->editColumn('picture', function (Cods $cod) {
                        $btn = "";
                        if (!empty($cod->picture)) {
                            $url = url($cod->picture);

                            $btn = '<a href="' . $url . '" target="_blank">
                                            <img class="rounded-circle m-0 avatar-sm-table" src="' . $url . '" alt="">
                                        </a>';
                        } else {
                            $btn = '<span class="badge badge-info">No Image</span>';
                        }
                        return $btn;

                    })
                    ->rawColumns(['picture'])
                    ->make(true);
            }else{

                $data = Cods::where('passport_id', '=',$rider->passport_id)->where('type', '=', '1')->where('status', '=', '1')->latest()->get();
                return Datatables::of($data)
                    ->addColumn('name', function (Cods $cod) {
                        return isset($cod->passport->personal_info->full_name) ? $cod->passport->personal_info->full_name : 'N/A';
                    })
                    ->addColumn('status', function (Cods $cod) {
                        return "Approved";
                    })
                    ->editColumn('picture', function (Cods $cod) {
                        $btn = "";
                        if (!empty($cod->picture)) {
                            $url = url($cod->picture);

                            $btn = '<a href="' . $url . '" target="_blank">
                                            <img class="rounded-circle m-0 avatar-sm-table" src="' . $url . '" alt="">
                                        </a>';
                        } else {
                            $btn = '<span class="badge badge-info">No Image</span>';
                        }
                        return $btn;

                    })
                    ->rawColumns(['picture'])
                    ->make(true);

            }
        }

        return view('admin-panel.cods.rider_bank_paid');
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

        try{
            $validator = Validator::make($request->all(), [
                'status' => 'required',
            ]);
            if($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                foreach ($validate->all() as $error){
                    $message_error .= $error;
                }
                $message = [
                    'message' => $message_error,
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return back()->with($message);

            }
            $id = $request->id;
            $status = $request->status;

            $cods = Cods::find($id);
            if($status=="1"){
                $cods->verify_by = Auth::user()->id;
            }else{
                $cods->reject_by = Auth::user()->id;
            }
            $cods->status = $status;
            $cods->update();


            $cod_action_history = new CodActionHistory();
            $cod_action_history->cod_id = $id;
            $cod_action_history->status = $status;
            $cod_action_history->action_by = Auth::user()->id;
            $cod_action_history->save();


            $message = [
                'message' => 'Status has been updated Successfully',
                'alert-type' => 'success'
            ];

//            return redirect()->route('cods')->with($message);
            return back()->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
//            return redirect()->route('cods')->with($message);
            return back()->with($message);
        }

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

    public function ajax_cod_history(Request $request){

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if(!empty($end_date) && !empty($start_date) && !empty($request->platform_id)) {
            $rider_id = $request->rider_id;

             $rider = RiderProfile::find($rider_id);
              $platform_code = PlatformCode::where('passport_id','=',$rider->passport_id)->where('platform_id','=',$request->platform_id)->first();
            $cod_uploads = array();
              if(!empty($platform_code)){
                  $cod_uploads = CodUpload::whereBetween('start_date', [$start_date, $end_date])
                      ->where('platform_id','=',$request->platform_id)
                      ->where('rider_id','=',$platform_code->platform_code)
                      ->orderBy('id', 'desc')
                      ->get();
              }
        }elseif(!empty($end_date) && !empty($start_date) && empty($request->platform_id)){

            $rider_id = $request->rider_id;

            $rider = RiderProfile::find($rider_id);

            $ab = $rider->passport->platform_codes->pluck(['platform_code']);
            $array_ab = $ab->toArray();

            $cod_uploads = CodUpload::whereBetween('order_date', [$start_date, $end_date])
                ->whereIn('rider_id',$array_ab)
                ->orderBy('id', 'desc')
                ->get();

        }

        $view = view("admin-panel.cods.ajax_order_history",compact('cod_uploads'))->render();
        return response()->json(['html'=>$view]);

    }
    public function ajax_view_cod_message(Request $request){

        if(isset($request->type)){

            $id = $request->primary_id;
            $cod = CodAdjustRequest::find($id);

            return $cod->message;

        }else{

            $id = $request->primary_id;
            $cod = Cods::find($id);

            return $cod->message;

        }


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
    public function image_cod(Request $request)
    {
        if (!file_exists('../public/assets/upload/cods/')) {
            mkdir('../public/assets/upload/cods/', 0777, true);
        }
        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $request->date . '.' . $ext;
        move_uploaded_file($_FILES["picture"]["tmp_name"], '../public/assets/upload/cods/' . $file_name);
        $file_path = 'assets/upload/cods/' . $file_name;

        $id = $request->id;

        $cods = Cods::find($id);
        $cods->picture = $file_path;
        $cods->update();

        $message = [
            'message' => 'Image Uploaded Successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);
    }
    public function add_cod_bank_request(){
        $platforms=AssignPlateform::where('status','1')->pluck('passport_id')->toArray();
        $rider_ids = PlatformCode::where('platform_id','=','4')->get();

        $zds_code=UserCodes::whereIn('passport_id',$platforms)->get();

        $platforms = Platform::all();

        return view('admin-panel.cods.add_cod_bank_request',compact('zds_code','platforms','rider_ids'));
    }
    public function add_cod_bank_store(Request $request){
//        $validator = Validator::make($request->all(), [
//
//            'machine_number' => 'digits:cods,machine_number',
//            'slip_number' => 'digits:cods,slip_number',
//            'amount' => 'digits:cods,amount',
//        ]);
//        if ($validator->fails()) {
////                $validate->first()
//            $validate = $validator->errors();
//            $message = [
//                'message' => $validate->first(),
//                'alert-type' => 'error',
//                'error' => $validate->first()
//            ];
//            return redirect()->back()->with($message);
//        }

        if($request->picture != null){
        if (!file_exists('../public/assets/upload/cods/')) {
            mkdir('../public/assets/upload/cods/', 0777, true);
        }
        $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $request->date . '.' . $ext;
        // move_uploaded_file($_FILES["picture"]["tmp_name"], '../public/assets/upload/cods/' . $file_name);
        $file_path = 'assets/upload/cods/' . $file_name;
        Storage::disk('s3')->put($file_path, file_get_contents($request->picture));
    }

//        $zds_code=UserCodes::where('id',$request->zds_code)->first();
//        $passport_id=$zds_code->passport_id;


        // $platform=AssignPlateform::where('passport_id',$request->zds_code)->where('status','1')->first();
        // $platform=$platform->plateform;
        $user_id = Auth::user()->id;
        $obj= new Cods();
        // $obj->slip_number = trim($request->input('slip_number'));
        $obj->machine_number = trim($request->input('machine_number'));
        $obj->location_at_machine = trim($request->input('location_at_machine'));
        $obj->date = $request->input('date');
        $obj->time = $request->input('time');
        $obj->amount = trim($request->input('amount'));
        if($request->picture != null){
        $obj->picture = $file_path;}
        $obj->platform_id = '4';
        $obj->message = $request->message;
        $obj->passport_id = $request->zds_code;
        $obj->status = '1';
        $obj->type = '1';
        $obj->transaction_type = '1';
        $obj->verify_by = $user_id;
        // $obj->engine_no =  $request->engine_no;
        $obj->save();

        $message = [
            'message' => 'Added Successfully!!',
            'alert-type' => 'success',

        ];
        return redirect()->back()->with($message);
    }


    public function add_cod_cash_request(){
        $platforms=AssignPlateform::where('status','1')->pluck('passport_id')->toArray();

        $zds_code=UserCodes::whereIn('passport_id',$platforms)->get();

        $platforms = Platform::all();

        return view('admin-panel.cods.add_cod_cash_request',compact('zds_code','platforms'));
    }

    public function ajax_total_cod_cash(Request $request){

        $data = Cods::where('type','=','0')->where('platform_id','=',$request->plat)->where('status','=','1')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }

    public function ajax_total_cod_cash_not(Request $request){

        $data = Cods::where('type','=','0')->where('platform_id','=',$request->plat)->where('status','=','0')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }

    public function ajax_total_cod_cash_reject(Request $request){

        $data = Cods::where('type','=','0')->where('platform_id','=',$request->plat)->where('status','=','2')->whereBetween('date', [$request->start, $request->end])->orderby('id','desc')->get();
        return $data;
    }

    public function store_cod_cash_request(Request $request){



        try{
            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'time' => 'required',
                'amount' => 'required',
            ]);

            if($validator->fails()){

                $message = [
                    'message' => $validator->errors()->first(),
                    'alert-type' => 'error',

                ];
                return redirect()->back()->with($message);
            }




            // $check_in_platform = AssignPlateform::where('passport_id',$request->zds_code)->where('status','1')->first();

            // if($check_in_platform != null){

                $id = Auth::user()->id;

//                    print_r($request->date);
//                dd($request->time.":00");
                $obj = new Cods();
                $obj->date = $request->date;
                $obj->time = $request->time.":00";
                $obj->amount = $request->amount;
                $obj->passport_id = $request->zds_code;
                $obj->platform_id = '4';
                $obj->type = 0;
                $obj->status = 1;
                $obj->transaction_type = 1;
                $obj->verify_by = $id;
                $obj->save();

                $message = [
                    'message' => 'Cod Submitted Successful',
                    'alert-type' => 'success',

                ];
                return redirect()->back()->with($message);

            // }else{

            //     $message = [
            //         'message' => "platform is not assigned",
            //         'alert-type' => 'error',

            //     ];
            //     return redirect()->back()->with($message);

            // }



        }catch(\Illuminate\Database\QueryException $e) {

            $message = [
                'message' => 'Submission Failed',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }

    }


    public function cod_get_passport_detail(Request $request){
        $user_code = UserCodes::where('passport_id',$request->zds_code)->first();
        $response = $user_code->passport->personal_info->full_name."$".'';
        return $response;
    }
    public  function cod_edit($id){

        $platforms=AssignPlateform::where('status','1')->pluck('passport_id')->toArray();
        $zds_code=UserCodes::whereIn('passport_id',$platforms)->get();
        $cods= Cods::find($id);



        return view('admin-panel.cods.add_cod_bank_request',compact('zds_code','cods'));

    }


    public  function edit_cod_bank(Request $request ,$id){
        if (empty($_FILES['picture']['name'])) {
            $file_path=$request->input('picture2');
        }
        else {
            if (!file_exists('../public/assets/upload/cods/')) {
                mkdir('../public/assets/upload/cods/', 0777, true);
            }
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;
            move_uploaded_file($_FILES["picture"]["tmp_name"], '../public/assets/upload/cods/' . $file_name);
            $file_path = 'assets/upload/cods/' . $file_name;


        }
        $platform = AssignPlateform::where('passport_id', $request->zds_code)->where('status', '1')->first();
        $platform = $platform->plateform;



        $obj= Cods::find($id);
        $obj->slip_number = trim($request->input('slip_number'));
        $obj->machine_number = trim($request->input('machine_number'));
        $obj->location_at_machine = trim($request->input('location_at_machine'));
        $obj->date = $request->input('date');
        $obj->time = $request->input('time');
        $obj->amount = trim($request->input('amount'));
        $obj->picture = $file_path;
        $obj->platform_id = $platform;
        $obj->message = $request->message;
        $obj->passport_id = $request->zds_code;
        $obj->type = '1';
        $obj->save();


        $message = [
            'message' => 'Updated Successfully!!',
            'alert-type' => 'success',

        ];
        return redirect()->back()->with($message);

    }

    public function  get_rider_id_by_platform(Request $request){

         $rider_ids = PlatformCode::where('platform_id','=',$request->platform_id)->get();
           echo json_encode($rider_ids);
            exit;
    }

    public function delete_cod_by_date()
    {
        return view('admin-panel.cods.delete_cod');
    }

    public function get_delete_cods(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(),[
            'date' => 'required',
            'cod_type' => 'required',
        ]);

        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return response()->json(['code' => "100",'message'=>$message]);
        }

        if($request->cod_type == 1){
            $cods = Cods::with('passport.personal_info')->where('date',$request->date)->where('type',0)->where('status',1)->get();
            $view = view('admin-panel.cods.cods_by_date', compact('cods'))->render();
            return response()->json(['code' => "101",'type' => '1','date' => $request->date,'html' => $view]);
        }elseif($request->cod_type == 2){
            $cods = Cods::with('passport.personal_info')->where('date',$request->date)->where('type',1)->where('status',1)->get();
            $view = view('admin-panel.cods.cods_by_date', compact('cods'))->render();
            return response()->json(['code' => "101",'type' => '2','date' => $request->date,'html' => $view]);
        }elseif($request->cod_type == 3){
            $cods = CodAdjustRequest::with('passport.personal_info')->where('order_date',$request->date)->where('status',2)->get();
            $view = view('admin-panel.cods.cods_by_date', compact('cods'))->render();
            return response()->json(['code' => "101",'type' => '3','date' => $request->date,'html' => $view]);
        }
    }

    public function delete_cods_by_date(Request $request)
    {
        if($request->type == 1){
            $counts = Cods::where('date',$request->dates)->where('type',0)->where('status',1)->count();
            $cod = Cods::where('date',$request->dates)->where('type',0)->where('status',1)->delete();
        }elseif($request->type == 2){
            $counts = Cods::where('date',$request->dates)->where('type',1)->where('status',1)->count();
            $cod = Cods::where('date',$request->dates)->where('type',1)->where('status',1)->delete();
        }elseif($request->type == 3){
            $counts = CodAdjustRequest::where('order_date',$request->dates)->where('status',2)->count();
            $cod = CodAdjustRequest::where('order_date',$request->dates)->where('status',2)->delete();
        }

        $obj = new CodDelete();
        $obj->user_id = Auth::user()->id;
        $obj->type = $request->type;
        $obj->cod_date = $request->dates;
        $obj->cod_count = $counts;
        $obj->save();

        $message = [
            'message' => 'Deleted Successfully!!',
            'alert-type' => 'success',

        ];
        return redirect()->back()->with($message);
    }

    public function rider_wise_cod_deliveroo()
    {
       return view('admin-panel.cods.rider_wise_cod');
    }

    public function get_rider_list_deliveroo(Request $request)
    {
        $search_text = $request->get('query');
        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->where('employee_category', 0)
            ->get();
        if(count($passport_data)=='0'){
            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->where('employee_category', 0)
                ->get();
        }
        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->where('employee_category', 0)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->where('employee_category', 0)
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->where('employee_category', 0)
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->where('employee_category', 0)
                            ->get();

                        if (count($mobile_data)=='0')
                        {
                            $platform_code =Passport::select('platform_codes.platform_code','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('platform_codes', 'platform_codes.passport_id', '=', 'passports.id')
                                ->where("platform_codes.platform_code","LIKE","%{$request->input('query')}%")
                                ->where('employee_category', 0)
                                ->get();
                        if (count($platform_code)=='0') {
                            $emirates_code = Passport::select('emirates_id_cards.card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                ->where('employee_category', 0)
                                ->get();
                            if (count($emirates_code) == '0') {
                                $drive_lin_data = Passport::select('driving_licenses.license_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                    ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                    ->where('employee_category', 0)
                                    ->get();
                                if (count($drive_lin_data) == '0') {
                                    $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                        ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                        ->where('employee_category', 0)
                                        ->get();
                                    if( count($labour_card_data)=='0') {
                                        $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                            ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                            ->where('employee_category', 0)
                                            ->get();
                                        if (count($visa_number) == '0') {
                                            $platno = $request->input('query');
                                            $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                            if($bike_id != null){
                                                $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid')
                                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                    ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                    ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                    ->where("assign_bikes.status", "1")
                                                    ->where('employee_category', 0)
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

    public function ajax_rider_report_deliveroo(Request $request)
    {
        if(isset($request->keyword)){
        $searach = '%' . $request->keyword . '%';
        $passport_id = Passport::where('passport_no', 'like', $searach)->first()->id;
        }else{
            $passport_id = $request->ids;
        }
        $plateforms = PlatformCode::where('passport_id',$passport_id)->where('platform_id','=','4')->get();
        $upload = CodUpload::where('passport_id',$passport_id)->where('platform_id','=','4')->get();
        if(count($upload) != '0'){
        $codss = Cods::where('passport_id',$passport_id)->where('platform_id','=','4')->where('status','=','1')->get();
        $codadjustment = CodAdjustRequest::where('passport_id',$passport_id)->where('platform_id','=','4')->where('status','=','2')->get();
        $closemonth = CloseMonth::where('passport_id',$passport_id)->get();

        $merged = $upload->concat($codss)->concat($codadjustment)->concat($closemonth);
        $transactions = $merged->all();
        $keys = array_column($transactions, 'created_at');
        array_multisort($keys, SORT_ASC, $transactions);

        $cods = Cods::where('platform_id','=','4')->where('passport_id',$passport_id)->get();
        $codadjust = CodAdjustRequest::where('platform_id','=','4')->where('passport_id',$passport_id)->get();
        $close_month = CloseMonth::where('passport_id',$passport_id)->get();
        $riderProfile = CodUpload::where('passport_id',$passport_id)->where('platform_id','=','4')->select('*', DB::raw('sum(amount) as total'))->groupBy('passport_id')->get();
        $array_id_profile = array();
            foreach($riderProfile as $rider){

                $total_pending_amount = 0;
                $total_paid_amount = 0;
                $total_previous_amount = 0;
                $now_cod = 0;
                $close_m = 0;
                $adj_req_t = 0;

                $total_pending_amount = $rider->total;
                // if(!empty($rider->rider_code->passport->profile->user_id)){
                    $now_cod = $cods->where('passport_id',$rider->passport_id)->where('status','1')->sum('amount');
                    $adj_req_t = $codadjust->where('passport_id','=',$rider->passport_id)->where('status','=','2')->sum('amount');
                    $close_m = $close_month->where('passport_id','=',$rider->passport_id)->sum('close_month_amount');
                // }
                if($now_cod != null){
                    $total_paid_amount = $now_cod;
                }
                if($close_m != null){
                    $total_paid_amount = $total_paid_amount+$close_m;
                }
                // $pre_amount = isset($rider->rider_code->passport->previous_balance->amount) ? $rider->rider_code->passport->previous_balance->amount : 0;
                // $total_pending_amount = $total_pending_amount+$pre_amount;

                if($adj_req_t != null){
                    $total_paid_amount = $total_paid_amount+$adj_req_t;
                }
                $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
            }
            $plate = passport_addtional_info::where('passport_id',$passport_id)->first();
            // dd($abc);
            // $plate = $abc[0];
            $record = 'abc';
            $view = view('admin-panel.cods.ajax_deliveroo_rider_report', compact('transactions','plate','plateforms','record','upload','codss','codadjustment','closemonth','remain_amount'))->render();
            return response()->json(['html' => $view]);
        }else{
            $record = 'no records';
            $view = view('admin-panel.cods.ajax_deliveroo_rider_report', compact('record'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function active_rider_report()
    {
        $followup = RiderReportFollowup::where('status',0)->get();
        $platforms = Platform::all();
        return view('admin-panel.cods.active_rider_report',compact('followup','platforms'));
    }

    public function render_riders()
    {
        $dc_rider_passport_ids = collect();
        $all_dc_riders = AssignToDc::latest()->get();
            if(auth()->user()->hasRole(['DC_roll'])) {
                $dc_rider_passport_ids = $all_dc_riders->where('user_id', auth()->id())
                ->where('status',1)
                ->unique('rider_passport_id')
                ->pluck('rider_passport_id')->toArray();
            }elseif(auth()->user()->hasRole(['manager_dc'])){

                $manager_members_ids = Manager_users::whereManagerUserId(auth()->id())
                ->whereStatus(1)
                ->pluck('member_user_id')
                ->toArray();
                $dc_rider_passport_ids = $all_dc_riders->whereIn('user_id', $manager_members_ids)
                ->where('status',1)
                ->unique('rider_passport_id')
                ->pluck('rider_passport_id')->toArray();
            }
         $riders = AssignPlateform::with(
            'rider_passport.personal_info:passport_id,full_name',
            'rider_passport:id,pp_uid,passport_no',
            'rider_passport.zds_code:passport_id,zds_code',
            'rider_passport.rider_dc_detail.user_detail:id,name',
            'plateformdetail:id,name',
            'rider_passport.rider_bike_replacement.temporary_bike:id,plate_no',
            'rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
            'rider_passport.check_platform_code_exist',
            'rider_passport.passport_in_locker:id,passport_id',
            'rider_passport.passport_with_rider:id,passport_id',
            'rider_passport.passport_to_lock:id,passport_id',
            'rider_passport.visa_pasted',
            'cod_upload',
            'close_month',
            'cods',
            'codadjust',
            'talabat_cod',
            'carrefour_upload',
            'carrefour_cod',
            'carrefour_close',
            'careem_upload',
            'careem_cod',
            'careem_close',
            'talabat_orders')
            ->where(function($report)use($dc_rider_passport_ids){
                if(auth()->user()->hasRole(['DC_roll', 'manager_dc'])){
                    $report->whereIn('passport_id',$dc_rider_passport_ids);
                }
            })
            ->where('status','1')
            // ->limit(100)
            ->get();

        $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
        return $view;
    }

    public function filter_rider_report(Request $request)
    {
        if($request->category == '1' && $request->status == '1'){
            if($request->platform == '1' || $request->platform == '32'){
                $pass = AssignPlateform::with('careem_upload','careem_cod','careem_close')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    $total_pending_amount = 0;
                    $total_paid_amount = 0;

                    if(isset($rider->careem_upload)){
                        $total_pending_amount = $rider->careem_upload->total;
                    }else {
                        $total_pending_amount = 0;
                    }
                    if(isset($rider->careem_cod)){
                        $now_cod = $rider->careem_cod->cod_total;
                    }else {
                        $now_cod = 0;
                    }
                    if(isset($rider->careem_close)){
                        $close_m = $rider->careem_close->close_total;
                    }else {
                        $close_m = 0;
                    }
                    if($now_cod != null){
                        $total_paid_amount = $now_cod;
                    }
                    if($close_m != null){
                        $total_paid_amount = $total_paid_amount+$close_m;
                    }
                    $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('careem_cod_filter')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }elseif($request->platform == '38'){
                $pass = AssignPlateform::with('carrefour_upload','carrefour_cod','carrefour_close')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    $total_pending_amount = 0;
                    $total_paid_amount = 0;

                    if(isset($rider->carrefour_upload)){
                        $total_pending_amount = $rider->carrefour_upload->total;
                    }else {
                        $total_pending_amount = 0;
                    }
                    if(isset($rider->carrefour_cod)){
                        $now_cod = $rider->carrefour_cod->cod_total;
                    }else {
                        $now_cod = 0;
                    }
                    if(isset($rider->carrefour_close)){
                        $close_m = $rider->carrefour_close->close_total;
                    }else {
                        $close_m = 0;
                    }
                    if($now_cod != null){
                        $total_paid_amount = $now_cod;
                    }
                    if($close_m != null){
                        $total_paid_amount = $total_paid_amount+$close_m;
                    }
                    $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('carrefour_cod_filter')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }elseif($request->platform == '4'){
                $pass = AssignPlateform::with('cod_upload','cods','codadjust','close_month')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    $total_pending_amount = 0;
                    $total_paid_amount = 0;

                    if(isset($rider->cod_upload)){
                        $total_pending_amount = $rider->cod_upload->total;
                    }else {
                        $total_pending_amount = 0;
                    }
                    if(isset($rider->cods)){
                        $now_cod = $rider->cods->cod_total;
                    }else {
                        $now_cod = 0;
                    }
                    if(isset($rider->codadjust)){
                        $adj_req_t = $rider->codadjust->adj_req_total;
                    }else {
                        $adj_req_t = 0;
                    }
                    if(isset($rider->close_month)){
                        $close_m = $rider->close_month->close_total;
                    }else {
                        $close_m = 0;
                    }
                    if($now_cod != null){
                        $total_paid_amount = $now_cod;
                    }
                    if($close_m != null){
                        $total_paid_amount = $total_paid_amount+$close_m;
                    }
                    if($adj_req_t != null){
                        $total_paid_amount = $total_paid_amount+$adj_req_t;
                    }
                    $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('deliveroo_cods')->doesntHave('deliveroo_codadjust')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }elseif($request->platform == '15' || $request->platform == '34'){
                $pass = AssignPlateform::with('talabat_cod')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    if(isset($rider->talabat_cod->current_day_balance)){
                        $remain_amount = $rider->talabat_cod->current_day_balance;
                    }else {
                        $remain_amount = 0;
                    }
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('talabat_cods')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }else{
                $message = [
                    'message' => 'No Information Available!!',
                    'alert-type' => 'error',
                ];
                return $message;
            }
        }elseif($request->category == '1' && $request->status == '2'){
            if($request->platform == '1' || $request->platform == '32'){
                $pass = AssignPlateform::with('careem_upload','careem_cod','careem_close')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    $total_pending_amount = 0;
                    $total_paid_amount = 0;

                    if(isset($rider->careem_upload)){
                        $total_pending_amount = $rider->careem_upload->total;
                    }else {
                        $total_pending_amount = 0;
                    }
                    if(isset($rider->careem_cod)){
                        $now_cod = $rider->careem_cod->cod_total;
                    }else {
                        $now_cod = 0;
                    }
                    if(isset($rider->careem_close)){
                        $close_m = $rider->careem_close->close_total;
                    }else {
                        $close_m = 0;
                    }
                    if($now_cod != null){
                        $total_paid_amount = $now_cod;
                    }
                    if($close_m != null){
                        $total_paid_amount = $total_paid_amount+$close_m;
                    }
                    $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('careem_cod_filter_week')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }elseif($request->platform == '38'){
                $pass = AssignPlateform::with('carrefour_upload','carrefour_cod','carrefour_close')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    $total_pending_amount = 0;
                    $total_paid_amount = 0;

                    if(isset($rider->carrefour_upload)){
                        $total_pending_amount = $rider->carrefour_upload->total;
                    }else {
                        $total_pending_amount = 0;
                    }
                    if(isset($rider->carrefour_cod)){
                        $now_cod = $rider->carrefour_cod->cod_total;
                    }else {
                        $now_cod = 0;
                    }
                    if(isset($rider->carrefour_close)){
                        $close_m = $rider->carrefour_close->close_total;
                    }else {
                        $close_m = 0;
                    }
                    if($now_cod != null){
                        $total_paid_amount = $now_cod;
                    }
                    if($close_m != null){
                        $total_paid_amount = $total_paid_amount+$close_m;
                    }
                    $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('carrefour_cod_filter_week')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }elseif($request->platform == '4'){
                $pass = AssignPlateform::with('cod_upload','cods','codadjust','close_month')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    $total_pending_amount = 0;
                    $total_paid_amount = 0;

                    if(isset($rider->cod_upload)){
                        $total_pending_amount = $rider->cod_upload->total;
                    }else {
                        $total_pending_amount = 0;
                    }
                    if(isset($rider->cods)){
                        $now_cod = $rider->cods->cod_total;
                    }else {
                        $now_cod = 0;
                    }
                    if(isset($rider->codadjust)){
                        $adj_req_t = $rider->codadjust->adj_req_total;
                    }else {
                        $adj_req_t = 0;
                    }
                    if(isset($rider->close_month)){
                        $close_m = $rider->close_month->close_total;
                    }else {
                        $close_m = 0;
                    }
                    if($now_cod != null){
                        $total_paid_amount = $now_cod;
                    }
                    if($close_m != null){
                        $total_paid_amount = $total_paid_amount+$close_m;
                    }
                    if($adj_req_t != null){
                        $total_paid_amount = $total_paid_amount+$adj_req_t;
                    }
                    $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('deliveroo_cods_week')->doesntHave('deliveroo_codadjust_week')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }elseif($request->platform == '15' || $request->platform == '34'){
                $pass = AssignPlateform::with('talabat_cod')->where('plateform',$request->platform)->where('status','1')->get();
                $passport_ids = array();
                foreach($pass as $rider) {
                    if(isset($rider->talabat_cod->current_day_balance)){
                        $remain_amount = $rider->talabat_cod->current_day_balance;
                    }else {
                        $remain_amount = 0;
                    }
                    if($remain_amount>500){
                        $passport_ids [] = $rider->passport_id;
                    }
                }
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->doesntHave('talabat_cods_week')->where('plateform',$request->platform)->whereIn('passport_id', $passport_ids)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }else{
                $message = [
                    'message' => 'No Information Available!!',
                    'alert-type' => 'error',
                ];
                return $message;
            }
        }elseif($request->category == '2' && $request->status == '1'){
            if($request->platform == '15' || $request->platform == '34'){
                $a = TalabatRiderPerformance::groupBy('start_date')->latest('start_date')->pluck('start_date')->first();
                $date = date('Y-m-d', strtotime($a . ' -2 day'));
                // $date = Carbon::now()->subDays(2)->startOfDay()->toDateString();
                $passport_id = TalabatRiderPerformance::where('start_date','>=' ,$date)->where('completed_orders','>','10')->groupBy('passport_id')->pluck('passport_id')->toArray();
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->where('plateform',$request->platform)->whereNotIn('passport_id', $passport_id)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }else{
                $message = [
                    'message' => 'No Information Available!!',
                    'alert-type' => 'error',
                ];
                return $message;
            }
        }elseif($request->category == '2' && $request->status == '2'){
            if($request->platform == '15' || $request->platform == '34'){
                $a = TalabatRiderPerformance::groupBy('start_date')->latest('start_date')->pluck('start_date')->first();
                $date = date('Y-m-d', strtotime($a . ' -7 day'));
                // $date = Carbon::now()->subDays(7)->startOfDay()->toDateString();
                $passport_id = TalabatRiderPerformance::where('start_date','>=' ,$date)->where('completed_orders','>','10')->groupBy('passport_id')->pluck('passport_id')->toArray();
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->where('plateform',$request->platform)->whereNotIn('passport_id', $passport_id)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }else{
                $message = [
                    'message' => 'No Information Available!!',
                    'alert-type' => 'error',
                ];
                return $message;
            }
        }elseif($request->category == '3' && $request->status == '1'){
            if($request->platform == '15' || $request->platform == '34'){
                $a = TalabatRiderPerformance::groupBy('start_date')->latest('start_date')->pluck('start_date')->first();
                $date = date('Y-m-d', strtotime($a . ' -2 day'));
                // $date = Carbon::now()->subDays(2)->startOfDay()->toDateString();
                $passport_id = TalabatRiderPerformance::where('start_date','>=' ,$date)->where('worked_days','!=','0')->groupBy('passport_id')->pluck('passport_id')->toArray();
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->where('plateform',$request->platform)->whereNotIn('passport_id', $passport_id)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }else{
                $message = [
                    'message' => 'No Information Available!!',
                    'alert-type' => 'error',
                ];
                return $message;
            }
        }elseif($request->category == '3' && $request->status == '2'){
            if($request->platform == '15' || $request->platform == '34'){
                $a = TalabatRiderPerformance::groupBy('start_date')->latest('start_date')->pluck('start_date')->first();
                $date = date('Y-m-d', strtotime($a . ' -7 day'));
                // $date = Carbon::now()->subDays(7)->startOfDay()->toDateString();
                $passport_id = TalabatRiderPerformance::where('start_date','>=' ,$date)->where('worked_days','!=','0')->groupBy('passport_id')->pluck('passport_id')->toArray();
                $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
                'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
                ->where('plateform',$request->platform)->whereNotIn('passport_id', $passport_id)->where('status','1')->get();
                $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
                return $view;
            }else{
                $message = [
                    'message' => 'No Information Available!!',
                    'alert-type' => 'error',
                ];
                return $message;
            }
        }elseif($request->category == '4'){
            $passport_id = PassportWithRider::groupBy('passport_id')->pluck('passport_id')->toArray();
            $riders = AssignPlateform::with('rider_passport.personal_info:passport_id,full_name','rider_passport:id,pp_uid,passport_no','rider_passport.zds_code:passport_id,zds_code','rider_passport.rider_dc_detail.user_detail:id,name','plateformdetail:id,name','rider_passport.rider_bike_replacement.temporary_bike:id,plate_no','rider_passport.rider_sim_assign.telecome:id,account_number','rider_passport.rider_attendance',
            'rider_passport.rider_orders','rider_passport.check_platform_code_exist','rider_passport.passport_in_locker:id,passport_id','rider_passport.passport_with_rider:id,passport_id','rider_passport.passport_to_lock:id,passport_id','cod_upload','close_month','cods','codadjust','talabat_cod','carrefour_upload','carrefour_cod','carrefour_close','careem_upload','careem_cod','careem_close')
            ->where('plateform',$request->platform)->whereIn('passport_id', $passport_id)->where('status','1')->get();
            $view =  view('admin-panel.cods.rider_report.rider_report',compact('riders'))->render();
            return $view;
        }else{
            $message = [
                'message' => 'No Information Available!!',
                'alert-type' => 'error',
            ];
            return $message;
        }
    }

    public function add_rider_followup()
    {
        $followup = RiderReportFollowup::all();
        return view('admin-panel.cods.rider_report.active_rider_followup',compact('followup'));
    }

    public function rider_followup_edit($id)
    {
        $edit = RiderReportFollowup::find($id);
        $followup = RiderReportFollowup::all();
        return view('admin-panel.cods.rider_report.active_rider_followup',compact('followup','edit'));
    }

    public function rider_followup_update(Request $request,$id)
    {
        $edit = RiderReportFollowup::find($id);
        $edit->name = $request->name;
        $edit->save();

        $message = [
            'message' => 'Updated Successfully!!',
            'alert-type' => 'success',
        ];
        return redirect('add_rider_followup')->with($message);
    }

    public function save_followup_rider(Request $request)
    {
        $follow = new RiderReportFollowup();
        $follow->name = $request->name;
        $follow->save();

        $message = [
            'message' => 'Added Successfully!!',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }

    public function change_status_follow(Request $request)
    {
        $change = RiderReportFollowup::find($request->id);
        $change->status = $request->status;
        $change->save();
    }

    public function add_remark_rider(Request $request)
    {
        $abc = new RiderFollowUps();
        $abc->user_id = Auth::user()->id;
        $abc->passport_id = $request->passport_id;
        $abc->remarks = $request->note;
        $abc->followup_id = $request->follow_up_status;
        $abc->save();

        $message = [
            'message' => 'Added Successfully!!',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }

    public function get_rider_followups(Request $request)
    {
        $follow = RiderFollowUps::where('passport_id',$request->passport_id)->get();
        $view = view('admin-panel.cods.rider_report.rider_followups',compact('follow'))->render();
        return response()->json(['html' => $view]);
    }

    public function rider_sim_bike_report()
    {
        $sim_replace_ids = SimReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
        $sim_checkins = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_sims.passport_id', $sim_replace_ids)->where('assign_plateforms.status', '1')->count();
        $sim_checkouts = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->count();
        $sim_replace_checkins = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->count();
        $sim_replace_checkouts = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->count();
        $sim_actives = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->where('assign_sims.status', '1')->where('assign_plateforms.status', '1')->count();

        $bike_replace_ids = BikeReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
        $bike_checkins = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.passport_id', $bike_replace_ids)->where('assign_plateforms.status', '1')->count();
        $bike_replace_ids = BikeReplacement::whereDate('replace_checkout', '=', Carbon::today()->toDateString())->pluck('assign_bike_id')->toArray();
        $bike_checkouts = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkout', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.id', $bike_replace_ids)->where('assign_plateforms.status', '1')->count();
        $bike_replace_checkins = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->count();
        $bike_replace_checkouts = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->count();
        $bike_actives = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->where('assign_bikes.status', '1')->where('assign_plateforms.status', '1')->count();

        $platform_checkins = AssignPlateform::whereDate('checkin', '=', Carbon::today()->toDateString())->count();
        $platform_checkouts = AssignPlateform::whereDate('checkout', '=', Carbon::today()->toDateString())->count();
        $platform_actives = AssignPlateform::where('status', '1')->count();

        return view('admin-panel.cods.rider_bike_sim_report',compact('sim_checkins','sim_checkouts','sim_replace_checkins','sim_replace_checkouts','sim_actives','bike_checkins','bike_checkouts','bike_replace_checkins','bike_replace_checkouts','bike_actives','platform_checkins','platform_checkouts','platform_actives'));
    }

    public function get_city_button(Request $request)
    {
        $button = $request->btnValue;
        $cities = Cities::get(['id','city_code']);
        if($button == 'PlatformCheckin'){
            $platforms = AssignPlateform::whereDate('checkin', '=', Carbon::today()->toDateString())->get();
            return view('admin-panel.cods.rider_report.city_button',compact('cities','platforms'));
        }elseif($button == 'PlatformCheckout'){
            $platforms = AssignPlateform::whereDate('checkout', '=', Carbon::today()->toDateString())->get();
            return view('admin-panel.cods.rider_report.city_button_chekout',compact('cities','platforms'));
        }elseif($button == 'ActivelyWorkingPlatform'){
            $platforms = AssignPlateform::where('status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_active',compact('cities','platforms'));
        }elseif($button == 'SimCheckin'){
            $sim_replace_ids = SimReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $sims = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_sims.passport_id', $sim_replace_ids)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','sims'));
        }elseif($button == 'SimCheckout'){
            $sims_checkout = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','sims_checkout'));
        }elseif($button == 'ActivelyWorikingSim'){
            $sims_active = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->where('assign_sims.status', '1')->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','sims_active'));
        }elseif($button == 'SimReplacementCheckin'){
            $sim_replace_checkins = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','sim_replace_checkins'));
        }elseif($button == 'SimReplacementCheckout'){
            $sim_replace_checkouts = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','sim_replace_checkouts'));
        }elseif($button == 'BikeCheckin'){
            $bike_replace_ids = BikeReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $bike_checkins = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.passport_id', $bike_replace_ids)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','bike_checkins'));
        }elseif($button == 'BikeCheckout'){
            $bike_replace_ids = BikeReplacement::whereDate('replace_checkout', '=', Carbon::today()->toDateString())->pluck('assign_bike_id')->toArray();
            $bike_checkouts = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkout', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.id', $bike_replace_ids)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','bike_checkouts'));
        }elseif($button == 'ActivelyWorkingBike'){
            $active_bike = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->where('assign_bikes.status', '1')->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','active_bike'));
        }elseif($button == 'BikeReplacementCheckin'){
            $bike_replace_checkin = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','bike_replace_checkin'));
        }elseif($button == 'BikeReplacementCheckout'){
            $bike_replace_checkout = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.city_button_sim',compact('cities','bike_replace_checkout'));
        }
    }

    public function get_platforms(Request $request)
    {
        $platforms = AssignPlateform::whereDate('checkin', '=', Carbon::today()->toDateString())->where('city_id',$request->btnValue)->groupBy('plateform')->get(['id','city_id', 'plateform']);
        $platformss = AssignPlateform::whereDate('checkin', '=', Carbon::today()->toDateString())->where('city_id',$request->btnValue)->get(['id','city_id', 'plateform']);
        return view('admin-panel.cods.rider_report.platform_button',compact('platforms','platformss'));
    }

    public function get_platforms_checkout(Request $request)
    {
        $platforms = AssignPlateform::whereDate('checkout', '=', Carbon::today()->toDateString())->where('city_id',$request->btnValue)->groupBy('plateform')->get(['id','city_id', 'plateform']);
        $platformss = AssignPlateform::whereDate('checkout', '=', Carbon::today()->toDateString())->where('city_id',$request->btnValue)->get(['id','city_id', 'plateform']);
        return view('admin-panel.cods.rider_report.platform_button_checkout',compact('platforms','platformss'));
    }

    public function get_platforms_active(Request $request)
    {
        $platforms = AssignPlateform::where('status', '1')->where('city_id',$request->btnValue)->groupBy('plateform')->get(['id','city_id', 'plateform']);
        $platformss = AssignPlateform::where('status', '1')->where('city_id',$request->btnValue)->get(['id','city_id', 'plateform']);
        return view('admin-panel.cods.rider_report.platform_button_active',compact('platforms','platformss'));
    }

    public function get_sim_checkin(Request $request)
    {
        if(isset($request->btnValue)){
            if($request->btnValue == '0'){
                $city = null;
            }else{
                $city = $request->btnValue;
            }
            $sim_replace_ids = SimReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $sims = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_sims.passport_id', $sim_replace_ids)->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $simss = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_sims.passport_id', $sim_replace_ids)->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('sims','simss'));
        }elseif(isset($request->btnValues)){
            if($request->btnValues == '0'){
                $city = null;
            }else{
                $city = $request->btnValues;
            }
            $sims_checkout = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $sims_checkouts = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->whereDate('assign_sims.checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('sims_checkout','sims_checkouts'));
        }elseif(isset($request->btnValu)){
            if($request->btnValu == '0'){
                $city = null;
            }else{
                $city = $request->btnValu;
            }
            $sims_active = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->where('assign_sims.status', '1')->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $sims_actives = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->where('assign_sims.status', '1')->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('sims_active','sims_actives'));
        }elseif(isset($request->btn)){
            if($request->btn == '0'){
                $city = null;
            }else{
                $city = $request->btn;
            }
            $sim_replace_checkin = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $sim_replace_checkins = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('sim_replace_checkin','sim_replace_checkins'));
        }elseif(isset($request->btns)){
            if($request->btns == '0'){
                $city = null;
            }else{
                $city = $request->btns;
            }
            $sim_replace_checkout = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $sim_replace_checkouts = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->whereDate('sim_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('sim_replace_checkout','sim_replace_checkouts'));
        }elseif(isset($request->bikecheckin)){
            if($request->bikecheckin == '0'){
                $city = null;
            }else{
                $city = $request->bikecheckin;
            }
            $bike_replace_ids = BikeReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $bike_checkins = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.passport_id', $bike_replace_ids)->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $bike_checkinss = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.passport_id', $bike_replace_ids)->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('bike_checkinss','bike_checkins'));
        }elseif(isset($request->bikecheckout)){
            if($request->bikecheckout == '0'){
                $city = null;
            }else{
                $city = $request->bikecheckout;
            }
            $bike_replace_ids = BikeReplacement::whereDate('replace_checkout', '=', Carbon::today()->toDateString())->pluck('assign_bike_id')->toArray();
            $bike_checkouts = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->whereNotIn('assign_bikes.id', $bike_replace_ids)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $bike_checkoutss = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->whereDate('assign_bikes.checkout', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.id', $bike_replace_ids)->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('bike_checkoutss','bike_checkouts'));
        }elseif(isset($request->bikeactive)){
            if($request->bikeactive == '0'){
                $city = null;
            }else{
                $city = $request->bikeactive;
            }
            $bike_actives = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->where('assign_bikes.status', '1')->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $bike_activess = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->where('assign_bikes.status', '1')->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('bike_actives','bike_activess'));
        }elseif(isset($request->bikereplacecheckin)){
            if($request->bikereplacecheckin == '0'){
                $city = null;
            }else{
                $city = $request->bikereplacecheckin;
            }
            $bike_replace_checkins = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $bike_replace_checkinss = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('bike_replace_checkins','bike_replace_checkinss'));
        }elseif(isset($request->bikereplacecheckout)){
            if($request->bikereplacecheckout == '0'){
                $city = null;
            }else{
                $city = $request->bikereplacecheckout;
            }
            $bike_replace_checkouts = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->groupBy('assign_plateforms.plateform')->get();
            $bike_replace_checkoutss = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->whereDate('bike_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $city)->where('assign_plateforms.status', '1')->get();
            return view('admin-panel.cods.rider_report.platform_button_sim',compact('bike_replace_checkouts','bike_replace_checkoutss'));
        }
    }

    public function get_platforms_checkin(Request $request)
    {
        $platform_checkins = AssignPlateform::whereDate('checkin', '=', Carbon::today()->toDateString())->where('city_id',$request->city_id)->where('plateform',$request->platform)->get();
        $view = view('admin-panel.cods.rider_report.platform_checkin',compact('platform_checkins'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_platforms_checkouts(Request $request)
    {
        $platform_checkouts = AssignPlateform::whereDate('checkout', '=', Carbon::today()->toDateString())->where('city_id',$request->city_id)->where('plateform',$request->platform)->get();
        $view = view('admin-panel.cods.rider_report.platform_checkout',compact('platform_checkouts'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_platforms_actives(Request $request)
    {
        $actives = AssignPlateform::where('status', '1')->where('city_id',$request->city_id)->where('plateform',$request->platform)->get();
        $view = view('admin-panel.cods.rider_report.active_platform',compact('actives'))->render();
        return response()->json(['html' => $view]);
    }

    public function get_platforms_sim(Request $request)
    {
        if($request->type == 'checkin'){
            $sim_replace_ids = SimReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $sim_checkins = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->select('*', DB::raw('sim as assignsim,assign_sims.checkin as assigncheckin'))->whereDate('assign_sims.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_sims.passport_id', $sim_replace_ids)->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.sim_checkin',compact('sim_checkins'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'checkout'){
            $sim_checkouts = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->select('*', DB::raw('sim as assignsim,assign_sims.checkout as assigncheckout'))->whereDate('assign_sims.checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.sim_checkout',compact('sim_checkouts'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'active'){
            $actives = AssignSim::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_sims.passport_id')->select('*', DB::raw('sim as assignsim,assign_sims.checkin as assigncheckin'))->where('assign_sims.status', '1')->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.active_sim',compact('actives'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'replace_checkin'){
            $sim_replace_checkins = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->select('*', DB::raw('sim_replacements.replace_checkin as assigncheckin'))->whereDate('sim_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.sim_replace_checkin',compact('sim_replace_checkins'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'replace_checkout'){
            $sim_replace_checkouts = SimReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'sim_replacements.passport_id')->select('*', DB::raw('sim_replacements.replace_checkout as assigncheckout'))->whereDate('sim_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.sim_replace_checkout',compact('sim_replace_checkouts'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'bike_checkin'){
            $bike_replace_ids = BikeReplacement::whereDate('replace_checkin', '=', Carbon::today()->toDateString())->pluck('passport_id')->toArray();
            $bike_checkins = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->select('*', DB::raw('assign_bikes.checkin as assigncheckin'))->whereDate('assign_bikes.checkin', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.passport_id', $bike_replace_ids)->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.bike_checkin',compact('bike_checkins'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'bike_checkout'){
            $bike_replace_ids = BikeReplacement::whereDate('replace_checkout', '=', Carbon::today()->toDateString())->pluck('assign_bike_id')->toArray();
            $bike_checkouts = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->select('*', DB::raw('assign_bikes.checkout as assigncheckout'))->whereDate('assign_bikes.checkout', '=', Carbon::today()->toDateString())->whereNotIn('assign_bikes.id', $bike_replace_ids)->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.bike_checkout',compact('bike_checkouts'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'bike_active'){
            $bike_actives = AssignBike::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'assign_bikes.passport_id')->select('*', DB::raw('assign_bikes.checkin as assigncheckin'))->where('assign_bikes.status', '1')->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.active_bike',compact('bike_actives'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'bike_replace_checkin'){
            $bike_replace_checkins = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->select('*', DB::raw('bike_replacements.replace_checkin as assigncheckin'))->whereDate('bike_replacements.replace_checkin', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.bike_replace_checkin',compact('bike_replace_checkins'))->render();
            return response()->json(['html' => $view]);
        }elseif($request->type == 'bike_replace_checkout'){
            $bike_replace_checkouts = BikeReplacement::join('assign_plateforms', 'assign_plateforms.passport_id', '=', 'bike_replacements.passport_id')->select('*', DB::raw('bike_replacements.replace_checkout as assigncheckout'))->whereDate('bike_replacements.replace_checkout', '=', Carbon::today()->toDateString())->where('assign_plateforms.city_id','=', $request->city_id)->where('assign_plateforms.plateform','=', $request->platform)->where('assign_plateforms.status','1')->get();
            $view = view('admin-panel.cods.rider_report.bike_replace_checkout',compact('bike_replace_checkouts'))->render();
            return response()->json(['html' => $view]);
        }
    }

}
