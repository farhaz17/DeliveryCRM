<?php

namespace App\Http\Controllers;

use App\Model\Agreement\Agreement;
use App\Model\Agreement\AgreementAmount;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Bike_invoice;
use App\Model\BikeCencel;
use App\Model\BikeDetail;
use App\Model\Careem;
use App\Model\Departments;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\LabourCardType;
use App\Model\LabourCardTypeAssign;
use App\Model\MajorDepartment;
use App\Model\Master_steps;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Passport\Passport;
use App\Model\Platform;
use App\Model\Seeder\Company;
use App\Model\Telecome;
use App\Model\Ticket;
use App\Model\TicketMessage;
use App\Model\UserCodes\UserCodes;
use App\Model\VisaProcess\CurrentStatus;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DB;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Storage;
use Image;



class DashboardController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage', ['only' => ['vehicle_wise_dashboard']]);
        $this->middleware('role_or_permission:Admin|SIMManage', ['only' => ['sim_wise_dashboard']]);
        $this->middleware('role_or_permission:Admin|CustomerSupplierManage', ['only' => ['customer_supplier_wise_dashboard']]);
        $this->middleware('role_or_permission:Admin|DC_roll', ['only' => ['dc_wise_dashboard']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->to('user-dashboard');
        $data = array();
        $steps=Master_steps::all();
        $steps->shift(0);
        $Telecom=Telecome::all();
        $tel=count($Telecom);
        $passport=Passport::all();
        $pass=count($passport);
        $agreement=Agreement::all();
        $agree=count($agreement);
        $vehicle=BikeDetail::count();
        $cencel_vehicle=BikeCencel::count();
        $userCodes=Company::where('type', '=', '1')->get();
        $cardTypeAssign=ElectronicPreApproval::count();
        $data_label = "";
        $data_label_values = "";
        foreach ($steps as $step){
            $data_label .= "'$step->step_name'".",";

            $value = CurrentStatus::select('current_process_id', DB::raw('count(id) as total'))->where('current_process_id','=',$step->id)->groupBy('current_process_id')->first();

            if(!empty( $value)){
                $data_label_values .= "{$value->total}".",";
            }else{
                $zero = "0";
                $data_label_values .= "$zero".",";
            }
        }
        $data_label = trim($data_label,",");
        $data_label_values = trim($data_label_values,",");

//--------------------------------------------------------------------------------------
        $data_plateform = "";
        $data_plateform_values = "";
        $concat = "";
        foreach ($userCodes as $userCode){
            $data_plateform = "name:"."'$userCode->name'"."}, ";


            $value2 = Offer_letter::select('company', DB::raw('count(id) as total_plate_form'))->where('company','=',$userCode->id)->groupBy('company')->first();

            if(!empty( $value2)){
                $data_plateform_values = "{ value:"."{$value2->total_plate_form}".",";
            }else{
                $zero2 = "0";
                $data_plateform_values = "{ value:"."$zero2".",";
            }
            $concat .= $data_plateform_values.''.$data_plateform;
            $ab = '.$zero2.'.',';
                 $srting_append = '{value: 335,name: '.$ab.'}';
            }
        $data_plateform = trim($data_plateform,",");

        $data_plateform_values = trim($data_plateform_values,",");

////-----------------------------------------Labour card Type graph---------------------------------------------

        $offer_letters=Offer_letter::where('company','1')->get();

         $companies = Company::all();

         $companies_graphs = array();

         foreach ($companies as $company){
             if(isset($company->offer_letters)){

                 $passport_array = array();
                 foreach ($company->offer_letters as $let){
                     $passport_array [] = $let->passport_id;
                 }

                 $labour_card=LabourCardType::all();
                 $card_type_array = array();
                     foreach($labour_card as $labour){

                         $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->whereIn('passport_id',$passport_array)->groupBy('labour_card_type_id')->first();
                         $card_type_array [] = $value4;
                     }

                 $companies_graphs [] =  $card_type_array ;
             }

         }

        foreach ($offer_letters as $offer){

        $labour_card=LabourCardType::all();

        $data_labour_card = "";
        $data_labour_card_values = "";

                foreach ($labour_card as $labour){
                    $data_labour_card .= "'$labour->name'".",";

                    $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->groupBy('labour_card_type_id')->first();

                    if(!empty( $value4)){
                        $data_labour_card_values .= "{$value4->total}".",";
                    }else{
                        $zero = "0";
                        $data_labour_card_values .= "$zero".",";
                    }
                }
        }

        if (isset($data_labour_card)) {
            $data_labour_card = trim($data_labour_card, ",");
            $data_labour_card_values = trim($data_labour_card_values, ",");

        }

    return view('admin-panel.pages.dashboard',compact('pass','tel','agree','vehicle','data', 'companies_graphs',
            'data_label','data_label_values','data_plateform','data_plateform_values','concat','cardTypeAssign','companies','userCodes','data_labour_card','data_labour_card_values','cencel_vehicle')
        );
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
        if(!empty($select_id)){
            $value2 = Offer_letter::select('company', DB::raw('count(id) as total_company'))->where('company','=',$select_id)->groupBy('company')->first();
            $company = Offer_letter::where('company',$select_id)->first();
            $company_count=Offer_letter::where('company',$select_id)->count();

            if($company != null){
                $gamer = array(
                'company_name' =>$company,
                'emp_count' =>$company_count,
            );

            $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }
    }

    public function get_employee_detail(Request $request){
        $companies=Company::all();

        $data_company = "";
        $data_company_values = "";
        $childe['data'] = [];
        foreach ($companies as $company){
            $data_company = "$company->name";
            $company_id = "$company->id";
            $company_count = Offer_letter::select('company', DB::raw('count(id) as total_company'))->where('company','=',$company->id)->groupBy('company')->first();
            if(!empty( $company_count)){
                $data_company_values = "{$company_count->total_company}";
            }else{
                $zero = "0";
                $data_company_values = "$zero";
            }
            $gamer = array(
                'company_name' => $data_company,
                'company_count' =>$data_company_values,
                'id' =>$company_id,
            );
            $childe['data'] [] = $gamer;
        }
        echo json_encode($childe);
        exit;
    }

    public function get_employee_company(Request $request){

        $company_id = $request->id;
        $companies = Offer_letter::where('company',$company_id)->get();

        $childe['data'] = [];
        foreach ($companies as $company) {
            $passport_id = "$company->passport_id";
            $passport = Passport::where('id', $passport_id)->get();
            foreach ($passport as $pass) {
                $name =  $pass->given_names.' '.$pass->sur_name;
                $gamer = array(
                    'given_names' => $name,
                    'passport_number' =>$pass->passport_no,
                );
                $childe['data'] [] = $gamer;
            }
        }
        echo json_encode($childe);
        exit;
    }

    public function get_employees(Request $request){

        $company_id = $request->id;

        $childe['data'] = [];

        if(!empty($company_id)){

            $all_employee = LabourCardTypeAssign::all();

            if($all_employee != null){
                foreach($all_employee as $emp){
                    $passport = Passport::where('id',$emp->passport_id)->get();
                    foreach($passport as $pass){
                        $gamer = array(
                            'given_name' => $pass->given_names,
                            'sur_name' =>$pass->sur_name,
                            'passport_no' =>$pass->passport_no,
                        );
                        $childe['data'] [] = $gamer;
                    }
                }
            }

            echo json_encode($childe);
            exit;

        }else{

            $childe['data'] = [];
            echo json_encode($childe);
            exit;
        }

    }
    public function dashboard2()
    {

        if(!in_array(8,Auth::user()->user_group_id) && !in_array(1,Auth::user()->user_group_id) ){
            return redirect()->to('dashboard-user');
        }

        $steps=Master_steps::all();
        $steps->shift(0);
        $Telecom=Telecome::all();
        $tel=count($Telecom);
        $passport=Passport::all();
        $pass=count($passport);
        $agreement=Agreement::all();
        $agree=count($agreement);
        $vehicle=BikeDetail::count();
        $userCodes=Company::where('type', '=', '1')->get();
        $cardTypeAssign=LabourCardTypeAssign::count();

        //Tickets
        $pending_tickets=Ticket::where('is_checked','0')->count();
        $closed_tickets=Ticket::where('is_checked','1')->count();
        $in_process_tickets=Ticket::where('is_checked','2')->count();
        $rejected_tickets=Ticket::where('is_checked','3')->count();

        //---------department charts----------------------------------
        //---------department 1----------------------------------
        $pending_depart1=Ticket::where('is_checked','0')->where('department_id','1')->count();
        $closed_depart1=Ticket::where('is_checked','1')->where('department_id','1')->count();
        $in_process_depart1=Ticket::where('is_checked','2')->where('department_id','1')->count();
        $rejected_depart1=Ticket::where('is_checked','3')->where('department_id','1')->count();

        //---------department 2----------------------------------
        $pending_depart2=Ticket::where('is_checked','0')->where('department_id','2')->count();
        $closed_depart2=Ticket::where('is_checked','1')->where('department_id','2')->count();
        $in_process_depart2=Ticket::where('is_checked','2')->where('department_id','2')->count();
        $rejected_depart2=Ticket::where('is_checked','3')->where('department_id','2')->count();

        //---------department 3----------------------------------
        $pending_depart3=Ticket::where('is_checked','0')->where('department_id','3')->count();
        $closed_depart3=Ticket::where('is_checked','1')->where('department_id','3')->count();
        $in_process_depart3=Ticket::where('is_checked','2')->where('department_id','3')->count();
        $rejected_depart3=Ticket::where('is_checked','3')->where('department_id','3')->count();
        //---------department 4----------------------------------
        $pending_depart4=Ticket::where('is_checked','0')->where('department_id','4')->count();
        $closed_depart4=Ticket::where('is_checked','1')->where('department_id','4')->count();
        $in_process_depart4=Ticket::where('is_checked','2')->where('department_id','4')->count();
        $rejected_depart4=Ticket::where('is_checked','3')->where('department_id','4')->count();

        //---------department 5----------------------------------
        $pending_depart5=Ticket::where('is_checked','0')->where('department_id','5')->count();
        $closed_depart5=Ticket::where('is_checked','1')->where('department_id','5')->count();
        $in_process_depart5=Ticket::where('is_checked','2')->where('department_id','5')->count();
        $rejected_depart5=Ticket::where('is_checked','3')->where('department_id','5')->count();
        //---------department 6----------------------------------
        $pending_depart6=Ticket::where('is_checked','0')->where('department_id','6')->count();
        $closed_depart6=Ticket::where('is_checked','1')->where('department_id','6')->count();
        $in_process_depart6=Ticket::where('is_checked','2')->where('department_id','6')->count();
        $rejected_depart6=Ticket::where('is_checked','3')->where('department_id','6')->count();

        //---------department 7----------------------------------
        $pending_depart7=Ticket::where('is_checked','0')->where('department_id','7')->count();
        $closed_depart7=Ticket::where('is_checked','1')->where('department_id','7')->count();
        $in_process_depart7=Ticket::where('is_checked','2')->where('department_id','7')->count();
        $rejected_depart7=Ticket::where('is_checked','3')->where('department_id','7')->count();


        //---------department 8----------------------------------
        $pending_depart8=Ticket::where('is_checked','0')->where('department_id','8')->count();
        $closed_depart8=Ticket::where('is_checked','1')->where('department_id','8')->count();
        $in_process_depart8=Ticket::where('is_checked','2')->where('department_id','8')->count();
        $rejected_depart8=Ticket::where('is_checked','3')->where('department_id','8')->count();
        //---------department 9----------------------------------
        $pending_depart9=Ticket::where('is_checked','0')->where('department_id','9')->count();
        $closed_depart9=Ticket::where('is_checked','1')->where('department_id','9')->count();
        $in_process_depart9=Ticket::where('is_checked','2')->where('department_id','9')->count();
        $rejected_depart9=Ticket::where('is_checked','3')->where('department_id','9')->count();
        //---------department 10----------------------------------
        $pending_depart10=Ticket::where('is_checked','0')->where('department_id','10')->count();
        $closed_depart10=Ticket::where('is_checked','1')->where('department_id','10')->count();
        $in_process_depart10=Ticket::where('is_checked','2')->where('department_id','10')->count();
        $rejected_depart10=Ticket::where('is_checked','3')->where('department_id','10')->count();

        //---------department 11----------------------------------
        $pending_depart11=Ticket::where('is_checked','0')->where('department_id','11')->count();
        $closed_depart11=Ticket::where('is_checked','1')->where('department_id','11')->count();
        $in_process_depart11=Ticket::where('is_checked','2')->where('department_id','11')->count();
        $rejected_depart11=Ticket::where('is_checked','3')->where('department_id','11')->count();


        //---------department 12----------------------------------
        $pending_depart12=Ticket::where('is_checked','0')->where('department_id','12')->count();
        $closed_depart12=Ticket::where('is_checked','1')->where('department_id','12')->count();
        $in_process_depart12=Ticket::where('is_checked','2')->where('department_id','12')->count();
        $rejected_depart12=Ticket::where('is_checked','3')->where('department_id','12')->count();

        //---------department 13----------------------------------
        $pending_depart13=Ticket::where('is_checked','0')->where('department_id','13')->count();
        $closed_depart13=Ticket::where('is_checked','1')->where('department_id','13')->count();
        $in_process_depart13=Ticket::where('is_checked','2')->where('department_id','13')->count();
        $rejected_depart13=Ticket::where('is_checked','3')->where('department_id','13')->count();

        //---------department 14----------------------------------
        $pending_depart14=Ticket::where('is_checked','0')->where('department_id','14')->count();
        $closed_depart14=Ticket::where('is_checked','1')->where('department_id','14')->count();
        $in_process_depart14=Ticket::where('is_checked','2')->where('department_id','14')->count();
        $rejected_depart14=Ticket::where('is_checked','3')->where('department_id','14')->count();


        //---------department 15----------------------------------
        $pending_depart15=Ticket::where('is_checked','0')->where('department_id','15')->count();
        $closed_depart15=Ticket::where('is_checked','1')->where('department_id','15')->count();
        $in_process_depart15=Ticket::where('is_checked','2')->where('department_id','15')->count();
        $rejected_depart15=Ticket::where('is_checked','3')->where('department_id','15')->count();
        //---------department 16----------------------------------
        $pending_depart16=Ticket::where('is_checked','0')->where('department_id','16')->count();
        $closed_depart16=Ticket::where('is_checked','1')->where('department_id','16')->count();
        $in_process_depart16=Ticket::where('is_checked','2')->where('department_id','16')->count();
        $rejected_depart16=Ticket::where('is_checked','3')->where('department_id','16')->count();

        //---------department 17----------------------------------
        $pending_depart17=Ticket::where('is_checked','0')->where('department_id','17')->count();
        $closed_depart17=Ticket::where('is_checked','1')->where('department_id','17')->count();
        $in_process_depart17=Ticket::where('is_checked','2')->where('department_id','17')->count();
        $rejected_depart17=Ticket::where('is_checked','3')->where('department_id','17')->count();

        //--------------------------by plateform----------------
        $data_label = "";
        $data_label_values = "";

        foreach ($steps as $step){
            $data_label .= "'$step->step_name'".",";

            $value = CurrentStatus::select('current_process_id', DB::raw('count(id) as total'))->where('current_process_id','=',$step->id)->groupBy('current_process_id')->first();

            if(!empty( $value)){
                $data_label_values .= "{$value->total}".",";
            }else{
                $zero = "0";
                $data_label_values .= "$zero".",";
            }
        }

       if(isset($data_label)) {
           $data_label = trim($data_label, ",");
           $data_label_values = trim($data_label_values, ",");

       }
        //--------------------------------------------------------------------------------------
        $data_plateform = "";
        $data_plateform_values = "";
        $concat = "";
        foreach ($userCodes as $userCode){
            $data_plateform = "name:"."'$userCode->name'"."}, ";
            $value2 = Offer_letter::select('company', DB::raw('count(id) as total_plate_form'))->where('company','=',$userCode->id)->groupBy('company')->first();
            if(!empty( $value2)){
                $data_plateform_values = "{ value:"."{$value2->total_plate_form}".",";
            }else{
                $zero2 = "0";
                $data_plateform_values = "{ value:"."$zero2".",";

            }
            $concat .= $data_plateform_values.''.$data_plateform;
            $ab = '.$zero2.'.',';
            $srting_append = '{value: 335,name: '.$ab.'}';
        }



        $data_plateform = trim($data_plateform,",");

        $data_plateform_values = trim($data_plateform_values,",");
        ////-----------------------------------------Labour card Type graph---------------------------------------------

        $offer_letters=Offer_letter::where('company','1')->get();

        $companies = Company::all();

        $companies_graphs = array();

        foreach ($companies as $company){
            if(isset($company->offer_letters)){

                $passport_array = array();
                foreach ($company->offer_letters as $let){
                    $passport_array [] = $let->passport_id;
                }

                $labour_card=LabourCardType::all();
                $card_type_array = array();
                foreach($labour_card as $labour){

                    $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->whereIn('passport_id',$passport_array)->groupBy('labour_card_type_id')->first();
                    $card_type_array [] = $value4;
                }

                $companies_graphs [] =  $card_type_array ;
            }

        }

        foreach ($offer_letters as $offer){

            $labour_card=LabourCardType::all();

            $data_labour_card = "";
            $data_labour_card_values = "";

            foreach ($labour_card as $labour){
                $data_labour_card .= "'$labour->name'".",";

                $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->groupBy('labour_card_type_id')->first();

                if(!empty( $value4)){
                    $data_labour_card_values .= "{$value4->total}".",";
                }else{
                    $zero = "0";
                    $data_labour_card_values .= "$zero".",";
                }
            }
        }

    if(isset($data_labour_card)) {
    $data_labour_card = trim($data_labour_card, ",");
    $data_labour_card_values = trim($data_labour_card_values, ",");
        }

        //graph for tickets

        $departments=\App\Model\Departments::all();

        $data_label_tickets = "";
        $data_label_values_tickets = "";

        foreach ($departments as $department){
            $data_label_tickets .= "'$department->name'".",";

            $value = Ticket::select('department_id', DB::raw('count(id) as total'))->where('department_id','=',$department->id)->groupBy('department_id')->first();

            if(!empty( $value)){
                $data_label_values_tickets .= "{$value->total}".",";
            }
        }
        $data_label_tickets = trim($data_label_tickets,",");
        $data_label_values_tickets = trim($data_label_values_tickets,",");

//-----------------------------------------------------------------------
        //departmentwise Pie Chart
        $departments=\App\Model\Departments::all();

        $total_tickets=Ticket::count();

        $data_ticket_per = "";
        $data_ticket_per_values = "";
        $percentage="";
        $concat_depart = "";

        $major_departments = \App\Model\MajorDepartment::all();

        foreach($major_departments as $dept){
            $data_ticket_per = "name:"."'$dept->major_department'"."}, ";
            $issude_ids = Departments::where('major_dept_id','=',$dept->id)->get();

            $gamer_sum = array();
            if(!empty($issude_ids)){
                foreach ($issude_ids as $ab){
                    $value_ab = Ticket::select('department_id', DB::raw('count(id) as total_department'))->where('department_id','=',$ab->id)->groupBy('department_id')->first();
                    if(!empty($value_ab)){
                        $gamer_sum [] = $value_ab->total_department;
                    }
                }
            }

            $sum_total = array_sum($gamer_sum);

            if(!empty($sum_total)){
                    $percentage= $sum_total/$total_tickets*100;
                    $per= round($percentage, 2);
                    $data_ticket_per_values = "{ value:"."{$per}".",";
            }else{
                $zero2 = "0";
                $data_ticket_per_values = "{ value:"."$zero2".",";
            }
            $concat_depart .= $data_ticket_per_values.''.$data_ticket_per;
            $ab = '.$zero2.'.',';
        }

        return view('admin-panel.pages.dashboard2',compact('pass','tel','agree','vehicle','data', 'companies_graphs',
            'data_label','data_label_values','data_plateform','data_plateform_values','concat','cardTypeAssign','companies',
            'userCodes','data_labour_card','data_labour_card_values','pending_tickets','closed_tickets','in_process_tickets',
            'rejected_tickets','data_label_tickets','data_label_values_tickets','concat_depart','departments',
            'pending_depart1','closed_depart1','in_process_depart1','rejected_depart1',
        'pending_depart2','closed_depart2','in_process_depart2','rejected_depart2',
            'pending_depart3','closed_depart3','in_process_depart3','rejected_depart3',
            'pending_depart4','closed_depart4','in_process_depart4','rejected_depart4',
            'pending_depart5','closed_depart5','in_process_depart5','rejected_depart5',
            'pending_depart6','closed_depart6','in_process_depart6','rejected_depart6',
            'pending_depart7','closed_depart7','in_process_depart7','rejected_depart7',
        'pending_depart8','closed_depart8','in_process_depart8','rejected_depart8',
        'pending_depart9','closed_depart9','in_process_depart9','rejected_depart9',
        'pending_depart10','closed_depart10','in_process_depart10','rejected_depart10',
        'pending_depart11','closed_depart11','in_process_depart11','rejected_depart11',
        'pending_depart12','closed_depart12','in_process_depart12','rejected_depart12',
        'pending_depart13','closed_depart13','in_process_depart13','rejected_depart13',
        'pending_depart14','closed_depart14','in_process_depart14','rejected_depart14',
        'pending_depart15','closed_depart15','in_process_depart15','rejected_depart15',
        'pending_depart16','closed_depart16','in_process_depart16','rejected_depart16',
        'pending_depart17','closed_depart17','in_process_depart17','rejected_depart17'
        ));
    }

    public function dashboard3()
    {
        //Tickets counter according to user
        $issue_ids = Departments::whereIn('major_dept_id',auth()->user()->major_department_ids)->get();
        $users_new_array = array();
        foreach ($issue_ids as $abs){
            $users_new_array [] = $abs->id;
        }

        $pending_tickets=Ticket::select('*')
            ->where('is_checked','0')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->count();

        $closed_tickets=Ticket::select('*')
            ->where('is_checked','1')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->count();

        $in_process_tickets=Ticket::select('*')
            ->where('is_checked','2')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->count();

        $rejected_tickets=Ticket::select('*')
            ->where('is_checked','3')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->count();


        //---------department charts----------------------------------
        //---------department 1----------------------------------
        $pending_depart1=Ticket::where('is_checked','0')->where('department_id','1')->count();
        $closed_depart1=Ticket::where('is_checked','1')->where('department_id','1')->count();
        $in_process_depart1=Ticket::where('is_checked','2')->where('department_id','1')->count();
        $rejected_depart1=Ticket::where('is_checked','3')->where('department_id','1')->count();

        //---------department 2----------------------------------
        $pending_depart2=Ticket::where('is_checked','0')->where('department_id','2')->count();
        $closed_depart2=Ticket::where('is_checked','1')->where('department_id','2')->count();
        $in_process_depart2=Ticket::where('is_checked','2')->where('department_id','2')->count();
        $rejected_depart2=Ticket::where('is_checked','3')->where('department_id','2')->count();

        //---------department 3----------------------------------
        $pending_depart3=Ticket::where('is_checked','0')->where('department_id','3')->count();
        $closed_depart3=Ticket::where('is_checked','1')->where('department_id','3')->count();
        $in_process_depart3=Ticket::where('is_checked','2')->where('department_id','3')->count();
        $rejected_depart3=Ticket::where('is_checked','3')->where('department_id','3')->count();
        //---------department 4----------------------------------
        $pending_depart4=Ticket::where('is_checked','0')->where('department_id','4')->count();
        $closed_depart4=Ticket::where('is_checked','1')->where('department_id','4')->count();
        $in_process_depart4=Ticket::where('is_checked','2')->where('department_id','4')->count();
        $rejected_depart4=Ticket::where('is_checked','3')->where('department_id','4')->count();

        //---------department 5----------------------------------
        $pending_depart5=Ticket::where('is_checked','0')->where('department_id','5')->count();
        $closed_depart5=Ticket::where('is_checked','1')->where('department_id','5')->count();
        $in_process_depart5=Ticket::where('is_checked','2')->where('department_id','5')->count();
        $rejected_depart5=Ticket::where('is_checked','3')->where('department_id','5')->count();
        //---------department 6----------------------------------
        $pending_depart6=Ticket::where('is_checked','0')->where('department_id','6')->count();
        $closed_depart6=Ticket::where('is_checked','1')->where('department_id','6')->count();
        $in_process_depart6=Ticket::where('is_checked','2')->where('department_id','6')->count();
        $rejected_depart6=Ticket::where('is_checked','3')->where('department_id','6')->count();

        //---------department 7----------------------------------
        $pending_depart7=Ticket::where('is_checked','0')->where('department_id','7')->count();
        $closed_depart7=Ticket::where('is_checked','1')->where('department_id','7')->count();
        $in_process_depart7=Ticket::where('is_checked','2')->where('department_id','7')->count();
        $rejected_depart7=Ticket::where('is_checked','3')->where('department_id','7')->count();


        //---------department 8----------------------------------
        $pending_depart8=Ticket::where('is_checked','0')->where('department_id','8')->count();
        $closed_depart8=Ticket::where('is_checked','1')->where('department_id','8')->count();
        $in_process_depart8=Ticket::where('is_checked','2')->where('department_id','8')->count();
        $rejected_depart8=Ticket::where('is_checked','3')->where('department_id','8')->count();
        //---------department 9----------------------------------
        $pending_depart9=Ticket::where('is_checked','0')->where('department_id','9')->count();
        $closed_depart9=Ticket::where('is_checked','1')->where('department_id','9')->count();
        $in_process_depart9=Ticket::where('is_checked','2')->where('department_id','9')->count();
        $rejected_depart9=Ticket::where('is_checked','3')->where('department_id','9')->count();
        //---------department 10----------------------------------
        $pending_depart10=Ticket::where('is_checked','0')->where('department_id','10')->count();
        $closed_depart10=Ticket::where('is_checked','1')->where('department_id','10')->count();
        $in_process_depart10=Ticket::where('is_checked','2')->where('department_id','10')->count();
        $rejected_depart10=Ticket::where('is_checked','3')->where('department_id','10')->count();

        //---------department 11----------------------------------
        $pending_depart11=Ticket::where('is_checked','0')->where('department_id','11')->count();
        $closed_depart11=Ticket::where('is_checked','1')->where('department_id','11')->count();
        $in_process_depart11=Ticket::where('is_checked','2')->where('department_id','11')->count();
        $rejected_depart11=Ticket::where('is_checked','3')->where('department_id','11')->count();

        //---------department 12----------------------------------
        $pending_depart12=Ticket::where('is_checked','0')->where('department_id','12')->count();
        $closed_depart12=Ticket::where('is_checked','1')->where('department_id','12')->count();
        $in_process_depart12=Ticket::where('is_checked','2')->where('department_id','12')->count();
        $rejected_depart12=Ticket::where('is_checked','3')->where('department_id','12')->count();

        //---------department 13----------------------------------
        $pending_depart13=Ticket::where('is_checked','0')->where('department_id','13')->count();
        $closed_depart13=Ticket::where('is_checked','1')->where('department_id','13')->count();
        $in_process_depart13=Ticket::where('is_checked','2')->where('department_id','13')->count();
        $rejected_depart13=Ticket::where('is_checked','3')->where('department_id','13')->count();

        //---------department 14----------------------------------
        $pending_depart14=Ticket::where('is_checked','0')->where('department_id','14')->count();
        $closed_depart14=Ticket::where('is_checked','1')->where('department_id','14')->count();
        $in_process_depart14=Ticket::where('is_checked','2')->where('department_id','14')->count();
        $rejected_depart14=Ticket::where('is_checked','3')->where('department_id','14')->count();


        //---------department 15----------------------------------
        $pending_depart15=Ticket::where('is_checked','0')->where('department_id','15')->count();
        $closed_depart15=Ticket::where('is_checked','1')->where('department_id','15')->count();
        $in_process_depart15=Ticket::where('is_checked','2')->where('department_id','15')->count();
        $rejected_depart15=Ticket::where('is_checked','3')->where('department_id','15')->count();
        //---------department 16----------------------------------
        $pending_depart16=Ticket::where('is_checked','0')->where('department_id','16')->count();
        $closed_depart16=Ticket::where('is_checked','1')->where('department_id','16')->count();
        $in_process_depart16=Ticket::where('is_checked','2')->where('department_id','16')->count();
        $rejected_depart16=Ticket::where('is_checked','3')->where('department_id','16')->count();
        //---------department 17----------------------------------
        $pending_depart17=Ticket::where('is_checked','0')->where('department_id','17')->count();
        $closed_depart17=Ticket::where('is_checked','1')->where('department_id','17')->count();
        $in_process_depart17=Ticket::where('is_checked','2')->where('department_id','17')->count();
        $rejected_depart17=Ticket::where('is_checked','3')->where('department_id','17')->count();


        //--------------------------by plateform----------------
        $data_label = "";
        $data_label_values = "";

        if(isset($data_label)) {
            $data_label = trim($data_label, ",");
            $data_label_values = trim($data_label_values, ",");
        }
        //--------------------------------------------------------------------------------------

        $offer_letters=Offer_letter::where('company','1')->get();

        $companies = Company::all();

        $companies_graphs = array();

        foreach ($companies as $company){
            if(isset($company->offer_letters)){

                $passport_array = array();
                foreach ($company->offer_letters as $let){
                    $passport_array [] = $let->passport_id;
                }

                $labour_card=LabourCardType::all();
                $card_type_array = array();
                foreach($labour_card as $labour){

                    $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->whereIn('passport_id',$passport_array)->groupBy('labour_card_type_id')->first();
                    $card_type_array [] = $value4;
                }

                $companies_graphs [] =  $card_type_array ;
            }
        }

        $departments=\App\Model\Departments::whereIn('id',$users_new_array)->get();;
        $data_label_tickets = "";
        $data_label_values_tickets = "";

        foreach ($departments as $department){
            $data_label_tickets .= "'$department->name'".",";
            $value = Ticket::select('department_id', DB::raw('count(id) as total'))->where('department_id','=',$department->id)->groupBy('department_id')->first();

            if(!empty($value)){
                $data_label_values_tickets .= "{$value->total}".",";
            }else{
                $zero = "0";
                $data_label_values_tickets .= "{$zero}".",";
            }
        }

        $data_label_tickets = trim($data_label_tickets,",");
        $data_label_values_tickets = trim($data_label_values_tickets,",");

        //-----------------------------------------------------------------------
        //departmentwise Pie Chart
        $departments=\App\Model\Departments::whereIn('id',$users_new_array)->get();

        $major_departments=\App\Model\MajorDepartment::all();

        $total_tickets=Ticket::count();

        $data_ticket_per = "";
        $data_ticket_per_values = "";
        $percentage="";
        $concat_depart = "";

        foreach ($departments as $department) {
            $data_ticket_per = "name:" . "'$department->name'" . "}, ";
            $value2 = Ticket::select('department_id', DB::raw('count(id) as total_department'))->where('department_id', '=', $department->id)->groupBy('department_id')->first();
            if (!empty($value2)) {
                $percentage = $value2->total_department / $total_tickets * 100;
                $per = round($percentage, 2);
                $data_ticket_per_values = "{ value:" . "{$per}" . ",";
            } else {
                $zero2 = "0";
                $data_ticket_per_values = "{ value:" . "$zero2" . ",";
            }
            $concat_depart .= $data_ticket_per_values . '' . $data_ticket_per;
            $ab = '.$zero2.' . ',';
            $srting_append = '{value: 335,name: ' . $ab . '}';
        }

        $recent_tickets =  Ticket::whereIn('department_id',$users_new_array)->orderby('id','desc')->limit(5)->get();


        $user_tickets = Ticket::select('*')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);
            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })->pluck('id')->toArray();

        $issue_ids = Departments::whereIn('major_dept_id',auth()->user()->major_department_ids)->get();
        $users_new_array_ids = array();
        foreach ($issue_ids as $abs){
            $users_new_array_ids [] = $abs->id;
        }

        $recent_tickets =  Ticket::whereIn('department_id',$users_new_array_ids)->whereIn('platform', auth()->user()->user_platform_id)->orderby('updated_at','desc')->limit(15)->get();

        $message_array = array();

        foreach ($recent_tickets as  $ab){
             $message_array[] = $ab->id;
        }

        $recent_messages =  TicketMessage::whereIn('ticket_id',$message_array)->orderby('updated_at','desc')->limit(15)->get();

        $array_status = array('Pending','Closed','In Process','Rejected');

        $time_24_hours_old = Carbon::now()->subHour(24);
        $time_48_hours_old = Carbon::now()->subHour(48);
        $time_72_hours_old = Carbon::now()->subHour(72);

        $current_time = Carbon::now();

        $in_process_tickets_24_hours = Ticket::select('*')
            ->where('is_checked','2')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->where('created_at','<=',$time_48_hours_old)
            ->where('created_at','>',$time_24_hours_old)
            ->count();

        $in_process_tickets_48_hours = Ticket::select('*')
            ->where('is_checked','2')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->where('created_at','<=',$time_72_hours_old)
            ->where('created_at','<=',$time_48_hours_old)
            ->count();

        $in_process_tickets_72_hours = Ticket::select('*')
            ->where('is_checked','2')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->where('created_at','<',$time_72_hours_old)
            ->count();

        $pending_tickets=Ticket::select('*')
            ->where('is_checked','0')
            ->where(function ($query) {
                $query->whereIn('platform', auth()->user()->user_platform_id);

            })->where(function($query) use ($users_new_array) {
                $query->whereIn('department_id',$users_new_array);
            })
            ->count();

        $concat = "";

        return view('admin-panel.pages.dashboard-user',compact( 'recent_messages','array_status','companies_graphs','recent_tickets',
            'data_label','data_label_values','concat','companies',
            'pending_tickets','closed_tickets','in_process_tickets',
            'rejected_tickets','data_label_tickets','data_label_values_tickets','concat_depart','departments',
            'pending_depart1','closed_depart1','in_process_depart1','rejected_depart1',
            'pending_depart2','closed_depart2','in_process_depart2','rejected_depart2',
            'pending_depart3','closed_depart3','in_process_depart3','rejected_depart3',
            'pending_depart4','closed_depart4','in_process_depart4','rejected_depart4',
            'pending_depart5','closed_depart5','in_process_depart5','rejected_depart5',
            'pending_depart6','closed_depart6','in_process_depart6','rejected_depart6',
            'pending_depart7','closed_depart7','in_process_depart7','rejected_depart7',
            'pending_depart8','closed_depart8','in_process_depart8','rejected_depart8',
            'pending_depart9','closed_depart9','in_process_depart9','rejected_depart9',
            'pending_depart10','closed_depart10','in_process_depart10','rejected_depart10',
            'pending_depart11','closed_depart11','in_process_depart11','rejected_depart11',
            'pending_depart12','closed_depart12','in_process_depart12','rejected_depart12',
            'pending_depart13','closed_depart13','in_process_depart13','rejected_depart13',
            'pending_depart14','closed_depart14','in_process_depart14','rejected_depart14',
            'pending_depart15','closed_depart15','in_process_depart15','rejected_depart15',
            'pending_depart16','closed_depart16','in_process_depart16','rejected_depart16',
            'pending_depart17','closed_depart17','in_process_depart17','rejected_depart17'
        ));
    }

    public  function dashboard_pro(){

        $steps=Master_steps::all();
        $steps->shift(0);
        $Telecom=Telecome::all();
        $tel=count($Telecom);
        $passport=Passport::all();
        $pass=count($passport);
        $agreement=Agreement::all();
        $agree=count($agreement);
        $vehicle=BikeDetail::count();
        $cencel_vehicle=BikeCencel::count();
        $userCodes=Company::where('type', '=', '1')->get();
        $cardTypeAssign=ElectronicPreApproval::count();
        $data_label = "";
        $data_label_values = "";

        foreach ($steps as $step){
            $data_label .= "'$step->step_name'".",";

            $value = CurrentStatus::select('current_process_id', DB::raw('count(id) as total'))->where('current_process_id','=',$step->id)->groupBy('current_process_id')->first();

            if(!empty( $value)){
                $data_label_values .= "{$value->total}".",";
            }else{
                $zero = "0";
                $data_label_values .= "$zero".",";
            }
        }

        $data_label = trim($data_label,",");
        $data_label_values = trim($data_label_values,",");

        //--------------------------------------------------------------------------------------
        $data_plateform = "";
        $data_plateform_values = "";
        $concat = "";
        foreach ($userCodes as $userCode){
            $data_plateform = "name:"."'$userCode->name'"."}, ";

            $value2 = Offer_letter::select('company', DB::raw('count(id) as total_plate_form'))->where('company','=',$userCode->id)->groupBy('company')->first();

            if(!empty( $value2)){
                $data_plateform_values = "{ value:"."{$value2->total_plate_form}".",";
            }else{
                $zero2 = "0";
                $data_plateform_values = "{ value:"."$zero2".",";
            }
            $concat .= $data_plateform_values.''.$data_plateform;
            $ab = '.$zero2.'.',';
            $srting_append = '{value: 335,name: '.$ab.'}';
        }

        $data_plateform = trim($data_plateform,",");

        $data_plateform_values = trim($data_plateform_values,",");


        ////-----------------------------------------Labour card Type graph---------------------------------------------

        $offer_letters=Offer_letter::where('company','1')->get();

        $companies = Company::all();

        $companies_graphs = array();

        foreach ($companies as $company){
            if(isset($company->offer_letters)){

                $passport_array = array();
                foreach ($company->offer_letters as $let){
                    $passport_array [] = $let->passport_id;
                }

                $labour_card=LabourCardType::all();
                $card_type_array = array();
                foreach($labour_card as $labour){

                    $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->whereIn('passport_id',$passport_array)->groupBy('labour_card_type_id')->first();
                    $card_type_array [] = $value4;
                }

                $companies_graphs [] =  $card_type_array ;
            }

        }

        foreach ($offer_letters as $offer){
            $labour_card=LabourCardType::all();
            $data_labour_card = "";
            $data_labour_card_values = "";
            foreach ($labour_card as $labour){
                $data_labour_card .= "'$labour->name'".",";

                $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->groupBy('labour_card_type_id')->first();

                if(!empty( $value4)){
                    $data_labour_card_values .= "{$value4->total}".",";
                }else{
                    $zero = "0";
                    $data_labour_card_values .= "$zero".",";
                }
            }
        }
        if (isset($data_labour_card)) {
            $data_labour_card = trim($data_labour_card, ",");
            $data_labour_card_values = trim($data_labour_card_values, ",");

        }

        return view('admin-panel.pages.dashboard-pro',compact('pass','tel','agree','vehicle','data', 'companies_graphs',
            'data_label','data_label_values','data_plateform','data_plateform_values','concat','cardTypeAssign',
            'companies','userCodes','data_labour_card','data_labour_card_values','cencel_vehicle','agreement'));
    }

    //test dashboard

    public function dashboard_test()
    {
        $steps=Master_steps::all();
        $steps->shift(0);
        $Telecom=Telecome::all();
        $tel=count($Telecom);
        $passport=Passport::all();
        $pass=count($passport);
        $agree=Agreement::count();

        $vehicle=BikeDetail::count();
        $cencel_vehicle=BikeCencel::count();
        $userCodes=Company::where('type', '=', '1')->get();
        $cardTypeAssign=ElectronicPreApproval::count();

        $total_current_vehilce = BikeDetail::select('bike_details.*')
            ->leftjoin('bike_cencels', 'bike_cencels.bike_id', '=', 'bike_details.id')
            ->whereNull('bike_cencels.bike_id')
            ->count();
        $total_cancel_vehilce = BikeCencel::count();
        $vehilce_in_use = AssignBike::where('status','=',1)->count();
        $freebikes = BikeDetail::select('bike_details.*')
            ->leftjoin('bike_cencels', 'bike_cencels.bike_id', '=', 'bike_details.id')
            ->whereNull('bike_cencels.bike_id')
            ->where('bike_details.status','=','0')
            ->count();
        $total_current_sim = Telecome::count();
        $total_in_use = AssignSim::where('status','=',1)->count();
        $free_sims = Telecome::where('status','=','0')
            ->count();

        $data_label = "";
        $data_label_values = "";

        foreach ($steps as $step){
            $data_label .= "'$step->step_name'".",";

            $value = CurrentStatus::select('current_process_id', DB::raw('count(id) as total'))->where('current_process_id','=',$step->id)->groupBy('current_process_id')->first();

            if(!empty( $value)){
                $data_label_values .= "{$value->total}".",";
            }else{
                $zero = "0";
                $data_label_values .= "$zero".",";
            }
        }

        $data_label = trim($data_label,",");
        $data_label_values = trim($data_label_values,",");

        //--------------------------------------------------------------------------------------
        $data_plateform = "";
        $data_plateform_values = "";
        $concat = "";
        foreach ($userCodes as $userCode){
            $data_plateform = "name:"."'$userCode->name'"."}, ";

            $value2 = Offer_letter::select('company', DB::raw('count(id) as total_plate_form'))->where('company','=',$userCode->id)->groupBy('company')->first();

            if(!empty( $value2)){
                $data_plateform_values = "{ value:"."{$value2->total_plate_form}".",";
            }else{
                $zero2 = "0";
                $data_plateform_values = "{ value:"."$zero2".",";
            }
            $concat .= $data_plateform_values.''.$data_plateform;
            $ab = '.$zero2.'.',';
            $srting_append = '{value: 335,name: '.$ab.'}';
        }

        $data_plateform = trim($data_plateform,",");

        $data_plateform_values = trim($data_plateform_values,",");


        ////-----------------------------------------Labour card Type graph---------------------------------------------

        $offer_letters=Offer_letter::where('company','1')->get();

        $companies = Company::all();

        $companies_graphs = array();

        foreach ($companies as $company){
            if(isset($company->offer_letters)){

                $passport_array = array();
                foreach ($company->offer_letters as $let){
                    $passport_array [] = $let->passport_id;
                }

                $labour_card=LabourCardType::all();
                $card_type_array = array();
                foreach($labour_card as $labour){

                    $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->whereIn('passport_id',$passport_array)->groupBy('labour_card_type_id')->first();
                    $card_type_array [] = $value4;
                }

                $companies_graphs [] =  $card_type_array ;
            }

        }

        foreach ($offer_letters as $offer){

            $labour_card=LabourCardType::all();
            $data_labour_card = "";
            $data_labour_card_values = "";
            foreach ($labour_card as $labour){
                $data_labour_card .= "'$labour->name'".",";

                $value4 = LabourCardTypeAssign::select('labour_card_type_id', DB::raw('count(id) as total'))->where('labour_card_type_id','=',$labour->id)->groupBy('labour_card_type_id')->first();

                if(!empty( $value4)){
                    $data_labour_card_values .= "{$value4->total}".",";
                }else{
                    $zero = "0";
                    $data_labour_card_values .= "$zero".",";
                }
            }
        }

        if (isset($data_labour_card)) {
            $data_labour_card = trim($data_labour_card, ",");
            $data_labour_card_values = trim($data_labour_card_values, ",");
        }

        $total_current_sim = Telecome::count();
        $total_in_use = AssignSim::where('status','=',1)->count();
        $free_sims = Telecome::where('status','=','0')->count();
        return view('admin-panel.pages.dashboard_test',compact('pass','tel','agree','vehicle','data', 'companies_graphs',
            'data_label','data_label_values','data_plateform','data_plateform_values','concat','cardTypeAssign',
            'companies','userCodes','data_labour_card','data_labour_card_values','cencel_vehicle','total_current_vehilce',
            'total_cancel_vehilce','vehilce_in_use','freebikes','total_current_sim','total_in_use','free_sims'));
    }

    public function userDashboard()
    {
        $user = Auth::user();
        return view('admin-panel.show_user_dashboard', compact('user'));
    }

    public function update_user(Request $request)
    {
        try {
            $user =  Auth::user();
            $user->name = $request->name;
            // user profile upload
            if($request->hasFile('user_profile_picture')){
                // if (!file_exists('../public/assets/upload/user_profile_picture/')) {
                //     mkdir('../public/assets/upload/user_profile_picture/', 0777, true);
                // }
                // $ext = pathinfo($_FILES['user_profile_picture']['name'], PATHINFO_EXTENSION);
                // $file_name = time() . "_" . $request->date . '.' . $ext;

                // move_uploaded_file($_FILES["user_profile_picture"]["tmp_name"], '../public/assets/upload/user_profile_picture/' . $file_name);
                // $file_path = 'assets/upload/user_profile_picture/' . $file_name;
                // $user->user_profile_picture ? file_exists($user->user_profile_picture) ? unlink($user->user_profile_picture) : "" : "";
                // $user->user_profile_picture = $file_path;
                $profile_pic = $request->file('user_profile_picture');
                $filename = 'assets/upload/user_profile_picture/' .time() . '.' . $profile_pic->getClientOriginalExtension();

                $imageS3 = Image::make($profile_pic)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                $user->user_profile_picture ? Storage::disk('s3')->delete($user->user_profile_picture) : "";
                $user->user_profile_picture = $filename;
                Storage::disk("s3")->put($filename, $imageS3->stream());
            }
            // user profile upload
            $user->save();
            $message = [
                'message' => 'User info updated',
                'alert-type' => 'success'
            ];
            return redirect()->route('userDashboard')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('userDashboard')->with($message);
        }
    }
    public function userDashboardNew()
    {
        return view('admin-panel.show_user_dashboard_new');
    }
    public function company_wise_dashboard()
    {
        return view('admin-panel.company_wise_dashboard');
    }
    public function vehicle_wise_dashboard()
    {
        return view('admin-panel.vehicle_wise_dashboard');
    }
    public function sim_wise_dashboard()
    {
        return view('admin-panel.sim_wise_dashboard');
    }
    public function customer_supplier_wise_dashboard()
    {
        return view('admin-panel.customer_supplier_wise_dashboard');
    }
    public function dc_wise_dashboard()
    {
        $user = Auth::user();

        return view('admin-panel.dc_wise_dashboard',compact('user'));
    }
    public function dc_manager_dashboard_new()
    {
        return view('admin-panel.dc_manager_dashboard_new');
    }
    public function category_dashboard()
    {
        return view('admin-panel.category_dashboard.category_dashboard');
    }
    public function cod_dashboard_new()
    {
        return view('admin-panel.cods.cod_dashboard_new');
    }

    public function visa_dashboard_new()
    {

        return view('admin-panel.visa-master.visa_dashboard.visa_dashboard_new');
    }
}




