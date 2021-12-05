<?php

namespace App\Http\Controllers\Reports;

use Crypt;
use App\Bike;
use DataTables;
use Carbon\Carbon;
use App\Model\Telecome;
use App\Model\Cods\Cods;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Model\Seeder\Company;
use App\Model\Cods\CloseMonth;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use App\Model\Passport\Passport;
use App\Model\Agreement\Agreement;
use App\Model\Assign\AssignReport;
use App\Model\CodUpload\CodUpload;
use App\Http\Controllers\Controller;
use App\Model\TalabatCod\TalabatCod;
use Illuminate\Support\Facades\Auth;
use App\Model\Assign\OfficeSimAssign;
use Illuminate\Support\Facades\Storage;
use App\Model\Offer_letter\Offer_letter;
use App\Model\TalabatCod\TalabatCodDeduction;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Model\ElectronicApproval\ElectronicPreApproval;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|report-vehicle-report', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|report-sim-report', ['only' => ['sim_report']]);
        $this->middleware('role_or_permission:Admin|report-assign-report', ['only' => ['assign_report_admin']]);
        $this->middleware('role_or_permission:Admin|report-assign-report-verify', ['only' => ['assign_report']]);
    }

    public function index()
    {
        $total_current_vehilce = BikeDetail::select('bike_details.*')
            ->leftjoin('bike_cencels', 'bike_cencels.bike_id', '=', 'bike_details.id')
            ->whereNull('bike_cencels.bike_id')
            ->get();

        $total_cancel_vehilce = BikeCencel::all();
        $vehilce_in_use = AssignBike::where('status','=',1)->get();
        $freebikes = BikeDetail::select('bike_details.*')
             ->leftjoin('bike_cencels', 'bike_cencels.bike_id', '=', 'bike_details.id')
              ->whereNull('bike_cencels.bike_id')
               ->where('bike_details.status','=','0')
               ->get();

        return view('admin-panel.reports.total_current_vehicle',compact('total_current_vehilce',
            'total_cancel_vehilce','vehilce_in_use','freebikes'));
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

    public function sim_report(){

        $total_current_sim = Telecome::all();

        $office_array = OfficeSimAssign::where('status','=','1')->pluck('sim_id')->toArray();
        $rider_array = AssignSim::where('assigned_to','=','1')->where('status','=','1')->pluck('sim')->toArray();
        $other_array = AssignSim::where('assigned_to','!=','1')->where('status','=','1')->pluck('sim')->toArray();
        $final_office_sim = array_merge($office_array,$other_array);
        $gamer  = array_merge($office_array,$rider_array,$other_array);
        $total_in_use = AssignSim::where('status','=',1)->wherein('sim',$gamer)->get();
        $free_sims = Telecome::where('status','=','0')
            ->get();
        return view('admin-panel.reports.total_sim_vehilce',compact('total_current_sim',
            'total_in_use','free_sims'));
    }

    public function assign_report(Request $request){
        if($request->ajax()){
            // ini_set('max_execution_time', 120); // 120 (seconds) = 2 Minutes
            $passports = Passport::select('id', 'passport_no', 'pp_uid')
            ->latest()
            // ->whereIn('id',[6733,6733,6733,3600,6719,6719,6723,6723,6726,6722,6718,6717,6733,6733,6733,3387,6731])
            ->limit(100)
            ->where(function($passport){
                    // if(request('platform_codes')){
                        //     $passport->with('check_platform_code_exist');
                        // }
                        // if(request('platform_changed')){
                        //     $passport->with('assign_to_dcs');
                        // }
                        // if(request('bike_last_checkin_date')){
                        //     $passport->with('assign_to_dcs');
                        // }
                        // if(request('platform_name')){
                        //     $passport->with('assign_to_dcs.platform');
                        // }
                        // if(request('platform_city')){
                        //     $passport->with('assign_to_dcs.platform.city_name');
                        // }
                        // if(request('current_dc')){
                        //     $passport->with('assign_to_dcs.user_detail');
                        // }
                        // if(request('name') || request('personal_phone') || request('personal_email')){
                        //     $passport->with('personal_info');
                        // }
                        // if(request('passport_no')){
                        //     // no relation needed
                        // }
                        // if(request('zds_code')){
                        //     $passport->with('zds_code');
                        // }
                        // if(request('ppuid')){
                        //     // no relation needed
                        // }
                        // if(request('bike_plate_no')){
                        //     $passport->with('bike_assign.bike_plate_number');
                    // }
                    if(request('bike_changed')){
                        $passport->withCount('bike_assign');
                    }
                    if(request('passport_handler')){
                        $passport->withCount(['passport_locker','passport_with_rider','passport_to_lock']);
                    }
                    if(request('company_phone')){
                        $passport->withCount('sim_assign');
                    }
                    // if(request('sim_checkin_date')){
                    //     $passport->with('sim_assign');
                    // }
                    if(request('sim_card_changed')){
                        $passport->withCount('sim_assign');
                    }
                    // if(request('emirates_id')){
                        //     $passport->with('emirates_id');
                        // }
                        // if(request('temporary_bike')){
                        //     $passport->with('bike_replacement.temporary_plate_number');
                    // }
                    if(request('passport_ticket_count')){
                        $passport->with([
                            'profile' => function($profile){
                                $profile->withCount('passport_ticket');
                            },
                        ]);
                    }
                    // if(request('renew_passport_number')){
                        //     $passport->with('renew_pass');
                        // }
                        // if(request('driving_license')){
                        //     $passport->with('driving_license');
                        // }
                        // if(request('driving_license_city')){
                        //     $passport->with('driving_license.city');
                        // }
                        // if(request('visa_status')){
                        //     $passport->with('career');
                        // }
                        // if(request('visa_profession')){
                        //     $passport->with(['offer.designation']);
                        // }
                        // if(request('visa_company')){
                        //     $passport->with('offer.companies');
                        // }
                        // if(request('assign_category')){
                        //     $passport->with([
                        //         'category_assign.main_cate',
                        //         'category_assign.sub_cate1',
                        //         'category_assign.sub_cate2',
                        //     ]);
                        // }
                        // if(request('common_status')){
                        //     $passport->with('active_inactive_category_assign_histories');
                    // }
                })
            ->get()
            ->filter(function($passport){
                if(request('current_cod')){
                    return $passport->current_cods = $this->get_current_cod($passport);
                }else{
                    return true;
                }
            });
            if(request('name') || request('personal_phone') || request('personal_email')){
                $passports->load('personal_info');
            }
            if(request('platform_codes')){
                $passports->load('check_platform_code_exist');
            }
            if(request('platform_changed') || request('bike_last_checkin_date')){
                $passports->load('assign_to_dcs');
            }
            if(request('platform_name')){
                $passports->load('assign_to_dcs.platform');
            }
            if(request('platform_city')){
                $passports->load('assign_to_dcs.platform.city_name');
            }
            if(request('current_dc')){
                $passports->load('assign_to_dcs.user_detail');
            }
            if(request('passport_no')){
                // no relation needed
            }
            if(request('zds_code')){
                $passports->load('zds_code');
            }
            if(request('ppuid')){
                // no relation needed
            }
            if(request('bike_plate_no')){
                $passports->load('bike_assign.bike_plate_number');
            }
            if(request('bike_changed')){
                $passports->load('bike_assign');
            }
            if(request('passport_handler')){
                $passports->load(['passport_to_lock.receiving_user',]);
            }
            if(request('company_phone') || request('sim_checkin_date') || request('sim_card_changed')){
                $passports->load('sim_assign');
            }
            if(request('emirates_id')){
                $passports->load('emirates_id');
            }
            if(request('temporary_bike')){
                $passports->load('bike_replacement.temporary_plate_number');
            }
            if(request('passport_ticket_count')){
                $passports->load([
                    'profile' => function($profile){
                        $profile->withCount('passport_ticket');
                    },
                ]);
            }
            if(request('renew_passport_number')){
                $passports->load('renew_pass');
            }
            if(request('driving_license')){
                $passports->load('driving_license');
            }
            if(request('driving_license_city')){
                $passports->load('driving_license.city');
            }
            if(request('visa_status')){
                $passports->load('career');
            }
            if(request('visa_profession')){
                $passports->load('offer.designation');
            }
            if(request('visa_company')){
                $passports->load('offer.companies');
            }
            if(request('assign_category')){
                $passports->load([
                    'category_assign.main_cate',
                    'category_assign.sub_cate1',
                    'category_assign.sub_cate2',
                ]);
            }
            if(request('common_status')){
                $passports->load('active_inactive_category_assign_histories');
            }
            $html = view('admin-panel.reports.shared_blades.ajax_assign_report', compact('passports'))->render();
            return response()->json(['html' => $html]);
        }else{
            return view('admin-panel.reports.assign_report');
        }
    }

    public function assign_report_attachment(Request $request)
    {
        $passport = Passport::with(['attach'])->findOrFail(1245);
        $attachments = collect([
            // Storage::temporaryUrl($passport->attach->attachment_name, now()->addMinutes(5)),
            Storage::temporaryUrl($passport->passport_pic, now()->addMinutes(5))
        ]);
        // $attachments->push(['attachment_name' => $passport->attach->attachment_name ?? '']);
        // $attachments->push(['passport_pic' => $passport->passport_pic ?? '']);
        //  $attachments;

        return view('blue-imp-gallery', compact('attachments'));
    }
    private function get_current_cod($passport)
    {
                // $passport = Passport::findOrFail($passport->id);
                // Riders cod balances starts here
                $cod_balances = collect();

                // Deliveroo COD Balance
                $remain_amount = 0;
                $total_pending_amount = 0;
                $total_paid_amount = 0;
                $check_in_platform = $passport->platform_assign->where('status', '=', '1')->pluck(['plateform'])->first();
                $rider_id = $passport->platform_codes->where('platform_id', '=', $check_in_platform)->pluck(['platform_code'])->first();

                if (isset($rider_id)) {
                    $amount =  CodUpload::where('rider_id','=',$rider_id)->where('platform_id','=',$check_in_platform)->selectRaw('sum(amount) as total')->first();
                    $paid_amount =  Cods::where('passport_id',$passport->id)->where('platform_id','=',$check_in_platform)->where('status','1')->selectRaw('sum(amount) as total')->first();
                    $adj_req_t =CodAdjustRequest::where('passport_id','=',$passport->id)->where('status','=','2')->selectRaw('sum(amount) as total')->first();
                    $salary_array = CloseMonth::where('passport_id','=',$passport->id)->selectRaw('sum(close_month_amount) as total')->first();
                    if($adj_req_t != null){
                        $total_paid_amount = $total_paid_amount+$adj_req_t->total;
                    }
                    if(!empty($amount)){
                        $total_pending_amount = $amount->total;
                    }
                    if(!empty($paid_amount)){
                        $total_paid_amount = $paid_amount->total;
                    }
                    if(!empty($salary_array)){
                        $total_paid_amount = $total_paid_amount+$salary_array->total;
                    }
                    $previous_balance =  isset($assign_plat->passport->previous_balance->amount) ? $assign_plat->passport->previous_balance->amount : '0';
                    $now_amount = $total_pending_amount+$previous_balance;
                    $remain_amount =  $now_amount-$total_paid_amount;

                    $deliveroo_cod = collect(['name' => "Deliveroo",'balance' => $remain_amount]);
                    $cod_balances->push($deliveroo_cod);
                }
                // talabat COD Balance
                $last_talabat_cod = TalabatCod::wherePassportId($passport->id)->latest('start_date')->first();
                if($last_talabat_cod){
                    $deductions = TalabatCodDeduction::wherePassportId($passport->id)
                    ->whereMonth('start_date', Carbon::parse($last_talabat_cod->start_date)->month)
                    ->sum('deduction');
                    $talabat_cod = collect(['name' => "Talabat",'balance' => $last_talabat_cod->current_day_balance]); // - $deductions]);
                    $cod_balances->push($talabat_cod);
                }

                // Riders cod balances ends here
                return $cod_balances;
    }

    public function assign_report_admin(Request $request){


        if ($request->ajax()) {

            if(isset($request->company_id)){
                $array = Offer_letter::where('company','=',$request->company_id)->pluck('passport_id')->toArray();
                $data = Passport::WhereIn('id',$array)->latest()->get();
            }elseif(isset($request->labour_company_id)){

                $array = Offer_letter::where('company','=',$request->labour_company_id)->pluck('passport_id')->toArray();
                $total_ab_passport = ElectronicPreApproval::whereIn('passport_id',$array)->pluck('passport_id')->toArray();

                $data = Passport::WhereIn('id',$total_ab_passport)->latest()->get();

            }elseif(isset($request->agreement_company_id)){

              $company_id = $request->agreement_company_id;
              $employee_type = $request->employee_type;

               $passport_array = Agreement::where('applying_visa','=',$company_id)->where('employee_type_id','=',$employee_type)->pluck('passport_id')->toArray();
                $data = Passport::WhereIn('id',$passport_array)->latest()->get();

            }else{
                $data = Passport::latest()->get();
            }

            return Datatables::of($data)
//                ->addIndexColumn()
                ->addColumn('full_name',function(Passport $passport){
                    return isset($passport->personal_info->full_name) ? $passport->personal_info->full_name : 'N/A';
                })
                ->addColumn('passport_no',function(Passport $passport){
                    return isset($passport->passport_no) ? $passport->passport_no:"N/A";
                })
                ->addColumn('zds_code',function(Passport $passport){
                    return isset($passport->zds_code->zds_code)?$passport->zds_code->zds_code:"";

                })->addColumn('pp_uid',function(Passport $passport){
                    return isset($passport->pp_uid) ? $passport->pp_uid : 'N/A';
                })->addColumn('personal_mob',function(Passport $passport){
                    return isset($passport->personal_info->personal_mob)?$passport->personal_info->personal_mob : 'N/A';
                })->addColumn('sim_assign', function(Passport $passport){

                    $result = "";
                    if (!$passport->sim_assign->isEmpty()) {
                           $ab = $passport->sim_assign->where('checkout','is',null)->first();
                        $result = isset($ab->telecome->account_number) ? $ab->telecome->account_number : 'N/A';
                    } else{
                        $result = 'N/A';
                    }
                    return $result;
                })->addColumn('bike_assign',function(Passport $passport){
                    $result = "";
                    if (!$passport->bike_assign->isEmpty()) {
                        $ab =  $passport->bike_assign->where('checkout','is',null)->first();
                        $result  =  isset($ab->bike_plate_number->plate_no) ? $ab->bike_plate_number->plate_no : 'N/A';
                    } else{
                        $result = 'N/A';
                    }
                    return $result;

                })->addColumn('platform_assign',function(Passport $passport){
                    $result = "";
                    if(!$passport->platform_assign->isEmpty()) {
                         $ab = $passport->platform_assign->where('checkout','is',null)->first();
                        $result = isset($ab->plateformdetail->name)? $ab->plateformdetail->name : 'N/A';
                    }else{
                        $result = 'N/A';
                    }
                    return $result;

                })->addColumn('emirates_id',function(Passport $passport){
                    return isset($passport->emirates_id->card_no) ? $passport->emirates_id->card_no : 'N/A';
                })->addColumn('driving_license',function(Passport $passport){
                    return  isset($passport->driving_license->license_number) ? $passport->driving_license->license_number : 'N/A';
                })->addColumn('elect_pre_approval',function(Passport $passport){
                    return  isset($passport->elect_pre_approval->labour_card_no) ? $passport->elect_pre_approval->labour_card_no : 'N/A';
                })->addColumn('company',function(Passport $passport){
                    return isset($passport->offer->companies->name) ? $passport->offer->companies->name : 'N/A';

                })->addColumn('verified',function(Passport $passport) {
                    if (isset($passport->verified->verification_status))
                        return 'Verified';
                    else {
                        return 'Not Verified';
                    }
                })->addColumn('agreement',function(Passport $passport) {
                    $html = '';
                    if(isset($passport->agreement)){
                        $count_a =$passport->agreement->count_amendment() ? $passport->agreement->count_amendment() : '';
                        $html = '<a href="javascript:void(0)"  id="history_agreement-'.$passport->agreement->id.'" class="btn btn-success btn-icon m-1 amendment_modal_cls" type="button"><span class="ul-btn__icon"><i class="i-One-Window"></i>'.$count_a.'</span></a>';
                    }else {
                        $url =  url('agreement/create?id='.$passport->id);
                        $html = '<a href="'.$url.'" target="_blank">Create Agreement</a>';
                    }
                    return $html;

                })
                ->rawColumns(['agreement'])
                ->make(true);

        }


        $company = Company::all();

        $labour_wise_company = array();

        foreach ($company as $comp){

            $array = Offer_letter::where('company','=',$comp->id)->pluck('passport_id')->toArray();
           $total_ab = ElectronicPreApproval::whereIn('passport_id',$array)->count();



            $gamer = array(
             'name' => $comp->name,
             'id' => $comp->id,
             'total' => $total_ab
            );

            $labour_wise_company [] = $gamer;
        }
//        dd($labour_wise_company);



        return view('admin-panel.reports.assign_report_admin',compact('labour_wise_company','company'));
    }

    public function assign_report_admin_ajax_employee(Request $request){

        if($request->ajax()){

             $company =  Company::all();

             $employee_id = $request->employee_id;

            $view= view('admin-panel.reports.ajax_company_vise_employee',compact('employee_id','company'))->render();
            return $view;
        }
    }



    public function verify_report(Request $request){
        $obj=new AssignReport();
        $obj->passport_id= $request->input('primary_id');
        $obj->remarks= $request->input('remarks');
        $obj->status= '1';
        $obj->verification_status= $request->input('verification_status');
        $obj->verified_by= Auth()->user()->id;
        $obj->save();
        $message = [
            'message' => 'Verified',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }
    public function ajax_get_full_time (Request $request){
//        if ($request->ajax()) {
//            $data = Passport::latest()->get();
//            return Datatables::of($data)
////                ->addIndexColumn()
//                ->addColumn('full_name',function(Passport $passport){
//                    return isset($passport->personal_info->full_name) ? $passport->personal_info->full_name : 'N/A';
//                })
//                ->addColumn('passport_no',function(Passport $passport){
//                    return isset($passport->passport_no) ? $passport->passport_no:"N/A";
//                })
//                ->addColumn('zds_code',function(Passport $passport){
//                    return isset($passport->zds_code->zds_code)?$passport->zds_code->zds_code:"";
//
//                })->addColumn('pp_uid',function(Passport $passport){
//                    return isset($passport->pp_uid) ? $passport->pp_uid : 'N/A';
//                })->addColumn('personal_mob',function(Passport $passport){
//                    return isset($passport->personal_info->personal_mob)?$passport->personal_info->personal_mob : 'N/A';
//                })
//                ->addColumn('sim_assign', function(Passport $passport){
//
//                    if (!$passport->sim_assign->isEmpty()) {
//                        foreach ($passport->sim_assign as $rw) {
//                            return isset($rw->telecome->account_number) ? $rw->telecome->account_number : 'N/A';
//                        }
//                    } else{
//                        return  'N/A';
//                    }
//                })->addColumn('bike_assign',function(Passport $passport){
//                    if (!$passport->bike_assign->isEmpty()) {
//                        foreach ($passport->bike_assign as $rw) {
//                            return isset($rw->bike_plate_number->plate_no) ? $rw->bike_plate_number->plate_no : 'N/A';
//                        }
//                    } else{
//                        return  'N/A';
//                    }
//                })->addColumn('platform_assign',function(Passport $passport){
//                    if (!$passport->platform_assign->isEmpty()) {
//                        foreach ($passport->platform_assign as $rw) {
//                            return isset($rw->plateformdetail->name)? $rw->plateformdetail->name : 'N/A';
//                        }
//                    } else{
//                        return  'N/A';
//                    }
//                })->addColumn('emirates_id',function(Passport $passport){
//                    return isset($passport->emirates_id->card_no) ? $passport->emirates_id->card_no : 'N/A';
//                })->addColumn('driving_license',function(Passport $passport){
//                    return  isset($passport->driving_license->license_number) ? $passport->driving_license->license_number : 'N/A';
//                })->addColumn('elect_pre_approval',function(Passport $passport){
//                    return  isset($passport->elect_pre_approval->labour_card_no) ? $passport->elect_pre_approval->labour_card_no : 'N/A';
//                })->addColumn('offer',function(Passport $passport){
//                    return isset($passport->offer->labour_card_no) ? $passport->offer->name : 'N/A';
//                })->addColumn('verified',function(Passport $passport) {
//                    if (isset($passport->verified->verification_status))
//                        return 'Verified';
//                    else {
//                        return 'Not Verified';
//                    }
//                })
//                ->make(true);
//        }


        $passport = Passport::with(array('bike_assign' => function($query){
            $query->where('status', '=', 1)->with('bike_plate_number');
        }))->with(array('sim_assign' => function($query){
            $query->where('status', '=', 1)->with('telecome');
        }))->with(array('platform_assign' => function($query){
            $query->where('status', '=', 1)->with('plateformdetail');
        }))->limit('50')->get();
        $company=Company::where('type','1')->get();
        $view = view("admin-panel.reports.ajax_get_full_time",compact('passport','company'))->render();
        return response()->json(['html'=>$view]);

    }

    public function ajax_get_part_time (Request $request)
    {

        $passport = Passport::with(array('bike_assign' => function($query){
            $query->where('status', '=', 1)->with('bike_plate_number');
        }))->with(array('sim_assign' => function($query){
            $query->where('status', '=', 1)->with('telecome');
        }))->with(array('platform_assign' => function($query){
            $query->where('status', '=', 1)->with('plateformdetail');
        }))->limit('50')->get();
        $company=Company::where('type','1')->get();
        $view = view("admin-panel.reports.ajax_get_part_time",compact('passport','company'))->render();
        return response()->json(['html'=>$view]);

    }

    public function ajax_company (Request $request)
    {
        $companyid=$request->id;

        $passport = Passport::with(array('bike_assign' => function($query){
            $query->where('status', '=', 1)->with('bike_plate_number');
        }))->with(array('sim_assign' => function($query){
            $query->where('status', '=', 1)->with('telecome');
        }))->with(array('platform_assign' => function($query){
            $query->where('status', '=', 1)->with('plateformdetail');
        }))->limit('500')->get();
        $company=Company::where('type','1')->get();
        $view = view("admin-panel.reports.ajax_company",compact('passport','company','companyid'))->render();
        return response()->json(['html'=>$view]);

    }

}
