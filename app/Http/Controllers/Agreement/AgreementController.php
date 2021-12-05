<?php

namespace App\Http\Controllers\Agreement;


use App\Http\Controllers\FourPl\FourPlController;
use App\Model\AdminFees\AdminFees;
use App\Model\Agreement\AgreementArBalance;
use App\Model\Agreement\AgreementCancel;
use App\Model\AgreementAmendment\AgreementAmendment;
use App\Model\AgreementAmountFees\AgreementAmountFees;
use App\Model\ArBalance\ArBalance;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\CodAdjustRequest\CodAdjustRequest;
use App\Model\CodPrevious\CodPrevious;
use App\Model\Cods\CloseMonth;
use App\Model\Cods\Cods;
use App\Model\CodUpload\CodUpload;
use App\Model\CompanyCode;
use App\Model\DiscountName\DiscountName;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Labour_ids\Labour_ids;
use App\Model\LicenseAmount\LicenseAmount;
use App\Model\Master\FourPl;
use App\Model\OnBoardStatus\OnBoardStatus;
//use App\Model\Passport\Passport;
use  App\Model\Passport\Passport;
use App\Model\RiderProfile;
use App\Model\Agreement\Agreement;
use App\Model\Seeder\AgreemtnDesignation;
use App\Model\Seeder\EmployeeType;
use App\Model\Seeder\LivingStatus;
use App\Model\Seeder\Visa_job_requests;
use App\Model\UserCodes\UserCodes;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Seeder\PersonStatus;
use App\Model\Seeder\Company;
use App\Model\Seeder\Designation;
use App\Model\Seeder\MedicalCategory;
use App\Model\Agreement\AgreementCategory;
use App\Model\Agreement\AgreementCategoryTree;
use App\Model\Agreement\TreeAmount;
use App\Model\Agreement\AgreementAmount;
use App\Model\Agreement\AgreemenUpload;
use App\Model\Agreement\DocumentTree;
use App\Model\Master_steps;
use App\Model\VisaProcess\AssigningAmount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Model\Passport\passport_addtional_info;
use DB;
use Mockery\Generator\StringManipulation\Pass\Pass;
use phpDocumentor\Reflection\Types\Null_;

class AgreementController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|agreement-agreement-view', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|agreement-agreement-create', ['only' => ['create']]);
        $this->middleware('role_or_permission:Admin|agreement-agreement-create', ['only' => ['create']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $agreements = Agreement::orderby('id','desc')->get();

        $parents = AgreementCategoryTree::where('parent_id','=','0')->get();
        $parent_name_array = [];

        foreach($parents as $parent){
            $parent_name_array[$parent->id] = $parent->get_parent_name->name_alt;
        }

        $agreements_not_employee = Agreement::where('employee_type_id','=','1')->where('status','=',null)->orderby('id','desc')->get();
        $agreements_taking_visa = Agreement::where('employee_type_id','=','2')->where('status','=',null)->orderby('id','desc')->get();
        $agreements_part_time = Agreement::where('employee_type_id','=','3')->where('status','!=',null)->orderby('id','desc')->get();

        $agreements_cencel = AgreementCancel::orderby('id','desc')->get();

//        AgreementAmendment::where()



     return view('admin-panel.agreement.index',compact('agreements_part_time','agreements_taking_visa','agreements_not_employee','agreements','parent_name_array','agreements_cencel'));

    }

    public  function upload_signed_agreement(Request $request){

        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();

                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => '',
                ];
                return redirect()->route('agreement')->with($message);
            }

            $id = $request->id;

            $current_timestamp = Carbon::now()->timestamp;

            $signed_agreement = "";

            if (!empty($_FILES['image']['name'])) {
                if (!file_exists('./assets/upload/agreement/signed_agreement')) {
                    mkdir('./assets/upload/agreement/signed_agreement', 0777, true);
                }
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/agreement/signed_agreement/' . $file1);
                $signed_agreement = '/assets/upload/agreement/signed_agreement/' . $file1;
            }

             $agreement = Agreement::find($id);
             $agreement->signed_agreement_pic =  $signed_agreement;
              $agreement->update();

            $message = [
                'message' => 'Signed Agreement has been Uploaded Successfully',
                'alert-type' => 'success',
                'error' => '',
            ];
            return redirect()->route('agreement')->with($message);



        }catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('agreement.create')->with($message);
        }


    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


//        $passports = Passport::orderby('id','desc')->where('is_cancel','=','0')
//            ->get();

        $all_passports = Passport::leftjoin('agreements','agreements.passport_id','=','passports.id')
                                    ->select('passports.id as passport_id','passports.passport_no as  passport_number')
                                    ->whereNull('agreements.passport_id')->orWhere('agreements.status','=','1')->where('passports.is_cancel','=','0')->orderby('passports.id','desc')->get()->toArray();

//        dd($all_passports);

        $pending_passports = $all_passports;

//        foreach ($all_passports as $pass){
//            $curent_passport = Agreement::where('passport_id','=',$pass->id)->first();
//            if($curent_passport==null){
//                $gamer = array(
//                    'passport_number' => $pass->passport_no,
//                    'passport_id' => $pass->id,
//                );
//
//                $pending_passports[] = $gamer;
//            }
//
//        }

//        dd($pending_passports);



        $riders = Passport::orderby('id','desc')->get();
        $person_statuses = PersonStatus::all();
        $companies   = Company::where('type','1')->get();
        $desingations = Designation::all();
        $medical_categories = MedicalCategory::all();

        $cat_current_staus = AgreementCategoryTree::where('sub_id','=','1')->where('parent_id','=','0')->first();
       if(isset($cat_current_staus->id)){

           $parent_id = $cat_current_staus->id;
           $current_status_child = AgreementCategoryTree::where('parent_id','=',$parent_id)->get();
       }




        $parents = AgreementCategoryTree::where('parent_id','=','0')->get();
        $childs = AgreementCategoryTree::pluck('sub_id','id')->all();

        $parents_driving_license = AgreementCategoryTree::where('parent_id','=','0')->where('sub_id','=','2')->first();

        $parent_document_process = AgreementCategoryTree::where('parent_id','=','0')->where('sub_id','=','3')->first();

        $parent_emirated_id = AgreementCategoryTree::where('parent_id','=','0')->where('sub_id','=','4')->first();

        $parent_status_change = AgreementCategoryTree::where('parent_id','=','0')->where('sub_id','=','5')->first();

        $parent_case_fine = AgreementCategoryTree::where('parent_id','=','0')->where('sub_id','=','6')->first();

        $parent_rta_permit = AgreementCategoryTree::where('parent_id','=','0')->where('sub_id','=','7')->first();

        $agrement_no = IdGenerator::generate(['table' => 'agreements', 'field' => 'agreement_no',  'length' => 6, 'prefix' => 'AA1']);

        $master_steps = Master_steps::where('id','!=','1')->get();

        $living_statuses = LivingStatus::all();

        $employee_types = EmployeeType::all();

        $visa_job_requests =  Visa_job_requests::all();

        $discount_names = DiscountName::orderby('id','desc')->get();

        $four_pl=FourPl::all();




        return view('admin-panel.agreement.create',compact('discount_names','visa_job_requests','employee_types','pending_passports', 'living_statuses', 'master_steps',   'parent_rta_permit', 'parent_case_fine', 'parent_emirated_id', 'parent_status_change', 'parents', 'parent_document_process', 'parents_driving_license', 'childs','riders', 'agrement_no' ,'person_statuses', 'desingations', 'companies', 'current_status_child', 'medical_categories','four_pl'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        |unique:agreements,passport_id

//
//        $agreement_table=Agreement::where('passport_id',$request->passport_id)->where('status','!=','1')->first();
//
//
//
//        if ($agreement_table!='1')){
//            $message = [
//                'message' => "Agreement Already exist for this Passport Number",
//                'alert-type' => 'error',
//                'error' => '',
//            ];
//
//            return redirect()->back()->with($message);
//        }


        $agrement_no = IdGenerator::generate(['table' => 'agreements', 'field' => 'agreement_no',  'length' => 6, 'prefix' => 'AA1']);


        try{
            $validator = Validator::make($request->all(), [
                'driving_license' => 'required',
                'passport_number' => 'required',
                'working_visa' => 'required',
//                'visa_applying' => 'required',
                'working_designation' => 'required',
                'visa_designation' => 'required',
//                'status_change' => 'required',
                'employee_type' => 'required',
            ]);
            if($validator->fails()) {
                $validate = $validator->errors();

                return $validate->first();
            }

            if($request->current_status=="2"){
                $validator = Validator::make($request->all(), [
                    'visit_entry_date' => 'required',
                    'visit_exit_date' => 'required',
                ]);
                if($validator->fails()) {
                    $validate = $validator->errors();
                    return $validate->first();
                }
            }elseif($request->current_status=="3" || $request->current_status=="4" || $request->current_status=="5"){

                $validator = Validator::make($request->all(), [
                    'transer_exit_date' => 'required'
                ]);
                if($validator->fails()) {
                    $validate = $validator->errors();
                    return $validate->first();
                }
            }

//            if($this->check_zds_code_exist($request->passport_number)){
//
//            }else{
//
//                return "Zds code is not exist, please make zds before create agreement";
//            }


                if($this->check_amount_is_okay_not($request)){

            }else{

                $message = [
                    'message' => "Step Amount is not Equal to total Agreement Amount",
                    'alert-type' => 'error',
                    'error' => '',
                ];

                return "Step Amount is not Equal to total Agreement Amount";
//                return redirect()->route('agreement.create')->with($message);
            }




            $evisa_print = null;
            $inside_visa_type = null;
            $medical_type  = null;
            $emirates_id = null;
            $medical_category = null;
            $visa_pasting = null;
            $case_fine = null;

            $english_test= null;
            $rta_permit_training= null;
            $e_test= null;
            $rta_medical= null;
            $cid_report =  null;
            $rta_card_print =  null;


            if($request->employee_type=="2"){

                $evisa_print  = $request->evisa_print;
                if($evisa_print=="1"){
                    $inside_visa_type = $request->inside_visa_type;
                }
                $medical_type = $request->medical_type;
                if($medical_type=="2"){
                    $medical_category = $request->medical_category;
                }

                $emirates_id = $request->emirates_id;
                $visa_pasting	 = $request->visa_pasting;
                $case_fine = $request->case_fine;

            }else{
                $case_fine =  "0";
            }

            if($request->working_visa=="3" && $request->visa_applying=="3" && $request->working_designation=="1"){


                $english_test =  $request->english_test;
                $rta_permit_training =  $request->rta_permit_training;
                $e_test =  $request->e_test;
                $rta_medical =  $request->rta_medical;
                $cid_report = $request->cid_report;
                $rta_card_print =  $request->rta_card_print;
            }
            $passport_ids =  $request->passport_number;
             DB::table('agreements')->where('passport_id', $passport_ids)
                ->update(['status' => '0']);

            $agreement = new Agreement();

             $json_outside_type = "";

            if($request->ref_type=="2"){

                $data = array(
                    'name' => $request->reference_name,
                    'contact_nubmer' => $request->contact_nubmer,
                    'whatsppnumber' => $request->whatsppnumber,
                    'socialmedia' => $request->socialmedia,
                    'working_place' => $request->wokring_place,
                );
                $json_outside_type = json_encode($data);
            }

            $json_discount_detail = "";
            $now_ar_discount = 0;
            $now_ar_advance_amount = 0;
            $now_ar_agreed_amount = 0;
            $now_ar_deduct_amount = 0;

            if(!empty($request->discount_name) && !empty($request->discount_amount)){

                foreach ($request->discount_amount as $d_amount){
                    $now_ar_discount = $now_ar_discount+$d_amount;
                }

                $data = array(
                    'name' => $request->discount_name,
                    'amount' => $request->discount_amount,
                );
                $json_discount_detail = json_encode($data);
            }

            if(!empty($request->advance_amount)){
                $now_ar_advance_amount =  $request->advance_amount;
            }

            $now_ar_agreed_amount = $this->get_total_agreed_amount($request);
            $now_ar_deduct_amount = $this->get_total_step_amount($request);






            $driving_license_source = null;
            $driving_license_type = null;
            $driving_license_car_type = null;

            $driving_license = $request->driving_license;
            $driving_license_type = $request->license_type;

            if($driving_license_type=="2"){
                $driving_license_car_type =  $request->car_type;
            }


            $start_date = null;
            $end_date = null;

            if(!empty($request->visit_entry_date)) {
//                $start_date = Carbon::createFromFormat('Y-m-d', $request->visit_entry_date)->format('d M Y');
                $start_date =  date('Y-m-d', strtotime($request->visit_entry_date));
                $end_date =  date('Y-m-d', strtotime($request->visit_exit_date));
            }
            elseif(!empty($request->transer_exit_date)){
                 $end_date = date('Y-m-d', strtotime($request->transer_exit_date));

            }
            elseif(!empty($request->expected_date)){

                $end_date =  date('Y-m-d', strtotime($request->expected_date));
            }

            $discount_offer = null;

            if(!empty($request->discount_offer)){
                $discount_offer = $request->discount_offer;
            }


            $agreement->discount  =   $discount_offer;
            $agreement->passport_id = $request->passport_number;
            $agreement->agreement_no = $agrement_no;
            $agreement->reference_type =$request->ref_type;
            if($request->ref_type=="1"){
                $agreement->reference_type_own  = $request->rider_name;
            }elseif($request->ref_type=="2"){
                $agreement->reference_type_outside = $json_outside_type;
            }



            $agreement->current_status_id = $request->current_status;
            $agreement->current_status_start_date = $start_date;
            $agreement->current_status_end_date = $end_date;
            $agreement->working_visa = $request->working_visa;
            $agreement->applying_visa = $request->visa_applying;
            $agreement->four_pl_name = $request->four_pl_name;
            $agreement->working_designation = $request->working_designation;
            $agreement->visa_designation = $request->visa_designation;
            $agreement->driving_licence = $driving_license;
            $agreement->driving_licence_ownership = $driving_license_source;
            $agreement->driving_licence_vehicle =  $driving_license_type;
            $agreement->driving_licence_vehicle_type  =  $driving_license_car_type;

            if($request->employee_type=="2"){
                $agreement->medical_ownership  =  $request->medical_type;
            }

            if($request->medical_type=="2" && $request->employee_type=="2"){
                $agreement->medical_ownership_type = $request->medical_category;
            }
            if(!empty($request->payroll_deduct)){
                $agreement->payroll_deduct = $request->payroll_deduct;
            }

            $agreement->emiratesid_ownership = $request->emirates_id;
            $agreement->status_change = $request->status_change;
            $agreement->fine = $case_fine;
            $agreement->rta_permit = "0";
             $agreement->status_change = "0";
//            $agreement->employee_type_id = $this->get_employee_type($request->current_status);
            $agreement->employee_type_id = $request->employee_type;
            $agreement->living_status_id = "0";
            $agreement->remarks = $request->remark;
            $agreement->advance_amount = $request->advance_amount;
            $agreement->visa_pasting = $visa_pasting;
            $agreement->rta_medical = $rta_medical;
            $agreement->english_test = $english_test;
            $agreement->cid_report = $cid_report;
            $agreement->rta_card_print = $rta_card_print;
            $agreement->rta_permit_training = $rta_permit_training;
            $agreement->e_test = $e_test;
            $agreement->e_visa_print = $evisa_print;
            $agreement->inside_e_visa_type = $inside_visa_type;
            $agreement->discount_details = $json_discount_detail;
            if(!empty($request->admin_amount_field_primary_id)){
                 $admin_ab = AdminFees::find($request->admin_amount_field_primary_id);
                $agreement->admin_fee_id = $admin_ab->amount;
            }
            if(!empty($request->adjustment_amount)){
                $agreement->adjustment_amount = $request->adjustment_amount;
            }
//            $agreement->dummy_id  =  $request->dummy_id;
            if(!empty($request->dummy_id)){
                $agreement->dummy_id = $request->dummy_id;
            }

           $agreement_recent  =   $agreement->save();

           $agreement_id = $agreement->id;
            $passport_id =  $request->passport_number;


            if($this->get_employee_type($request->current_status)=="1"){

              $zmv_code = IdGenerator::generate(['table' => 'company_codes', 'field' => 'company_code', 'length' => 8, 'prefix' => 'ZMV5']);

              $array_gamer = array(
                'passport_id' => $passport_id,
                'company_code' => $zmv_code
              );

              CompanyCode::create($array_gamer);

            }


            $current_status_amount = "";
            $current_status_amount_primary_id = "";

            $driving_license_amount = "";
            $driving_license_amount_primary_id = "";

            $medical_process_amount  = "";
            $medical_process_amount_primary_id  = "";

            $emirats_id_amount = "";
            $emirats_id_amount_primary_id = "";

            $status_change_amount = "";
            $status_change_amount_primary_id = "";

            $case_fine_amount = "";
            $case_fine_amount_primary_id = "";

            $rta_permit_amount = "";
            $rta_permit_amount_primary = "";

            $admin_amount = "";
            $admin_amount_primary = "";





            if(!empty($request->labour_fees_ids) && $request->labour_fees_ids!="0"){
                $array_ids = explode(',',$request->labour_fees_ids);
                foreach ($array_ids as $lab){
                    $labour_fees  = AgreementAmountFees::find($lab);
                    $array_insert = array(
                        'agreement_id' => $agreement_id,
                        'tree_amount_id'  => $lab,
                        'amount' => $labour_fees->amount
                    );
                    AgreementAmount::create($array_insert);
                }
            }




//            if(!empty($request->driving_license_amount_field)){
//                $driving_license_amount = $request->driving_license_amount_field;
//                $driving_license_amount_primary_id = $request->driving_license_amount_primary_id;
//
//                $array_insert = array(
//                    'agreement_id' => $agreement_id,
//                    'tree_amount_id'  => $driving_license_amount_primary_id,
//                    'amount' => $driving_license_amount
//                );
//                AgreementAmount::create($array_insert);
//            }

            if(!empty($request->evisa_print_amount_field)){
                $status_change_amount  = $request->evisa_print_amount_field;
                $evisa_print_amount_primary_id = $request->evisa_print_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $evisa_print_amount_primary_id,
                    'amount' =>  $status_change_amount
                );
                AgreementAmount::create($array_insert);
            }


            if(!empty($request->medical_process_amount_field)){
                $medical_process_amount = $request->medical_process_amount_field;
                $medical_process_amount_primary_id = $request->medical_process_amount_primary_id;
                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $medical_process_amount_primary_id,
                    'amount' => $medical_process_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->emirate_id_amount_field)){
                $emirats_id_amount = $request->emirate_id_amount_field;
                $emirats_id_amount_primary_id = $request->emirate_id_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $emirats_id_amount_primary_id,
                    'amount' => $emirats_id_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->visa_pasting_amount_field)){
                $emirats_id_amount = $request->visa_pasting_amount_field;
                $emirats_id_amount_primary_id = $request->visa_pasting_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $emirats_id_amount_primary_id,
                    'amount' => $emirats_id_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->case_fine_amount_field)){
                $case_fine_amount   = $request->case_fine_amount_field;
                $case_fine_amount_primary_id  = $request->case_fine_amount_primary_id;
                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $case_fine_amount_primary_id,
                    'amount' => $case_fine_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->english_test_amount_field)){
                $rta_permit_amount    = $request->english_test_amount_field;
                $rta_permit_amount_primary   = $request->english_test_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->rta_permint_amount_field)){
                $rta_permit_amount    = $request->rta_permint_amount_field;
                $rta_permit_amount_primary   = $request->rta_permint_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->e_test_amount_field)){
                $rta_permit_amount    = $request->e_test_amount_field;
                $rta_permit_amount_primary   = $request->e_test_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->rta_medical_amount_field)){
                $rta_permit_amount    = $request->rta_medical_amount_field;
                $rta_permit_amount_primary   = $request->rta_medical_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->cid_report_amount_field)){
                $rta_permit_amount    = $request->cid_report_amount_field;
                $rta_permit_amount_primary   = $request->cid_report_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmount::create($array_insert);
            }

            if(!empty($request->rta_print_amount_field)){
                $rta_permit_amount    = $request->rta_print_amount_field;
                $rta_permit_amount_primary   = $request->rta_print_amount_primary_id;

                $array_insert = array(
                    'agreement_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmount::create($array_insert);
            }





            $doc_trees = DocumentTree::all();

            $current_timestamp = Carbon::now()->timestamp;

            foreach($doc_trees as $doc_tree){
                $concat_request  = "agreement_file-".$doc_tree->id;



                $request->$concat_request;
                if(!empty($_FILES[$concat_request]['name'])){

                    $current_timestamp = Carbon::now()->timestamp;
                    $random_num = rand(0,5000000);

                    if (!file_exists('./assets/upload/agreement/documents')) {
                        mkdir('./assets/upload/agreement/documents', 0777, true);
                    }
                    $ext = pathinfo($_FILES[$concat_request]['name'], PATHINFO_EXTENSION);
                    $image = $current_timestamp.''.$random_num.'.'.$ext;
                    move_uploaded_file($_FILES[$concat_request]["tmp_name"], './assets/upload/agreement/documents/' . $image);
                    $image = '/assets/upload/agreement/documents/' . $image;

                    $array_insert = array(
                        'agreement_id' => $agreement_id,
                        'passport_id'  => $passport_id,
                        'document_id' => $doc_tree->id,
                        'image_path' => $image,
                     );
                    AgreemenUpload::create($array_insert);

                }

            }


            //form step store db

        $counter_amount_step = 0;
        foreach($request->select_amount_step as  $step_amount){
            if(!empty($step_amount) && !empty($request->step_amount[$counter_amount_step])){
                $array_insert = array(
                    'amount' => $request->step_amount[$counter_amount_step],
                    'master_step_id' => $step_amount,
                    'passport_id' => $passport_id,
                    'agreement_id' => $agreement_id,
                );
                AssigningAmount::create($array_insert);
            }
            $counter_amount_step =  $counter_amount_step+1;
        }






            $board_status = OnBoardStatus::where('passport_id','=',$passport_id)->first();

        $have_license = 0;
             $driv_lice = DrivingLicense::where('passport_id','=',$passport_id)->first();
             if($driv_lice!=null){
                 $have_license =1;
             }

             if($board_status==null){
                  $now_board = new OnBoardStatus();
                 $now_board->passport_id =  $passport_id;
                 $now_board->agreement_status =  '1';
                 if($have_license!=0){
                     $now_board->driving_license_status =  $have_license;
                 }
                 $now_board->save();
             }else{
                 $board_status->agreement_status = '1';
                 if($have_license!=0){
                     $board_status->driving_license_status =  $have_license;
                 }
                 $board_status->update();
             }

//             if($this->check_ar_balance_exist($passport_id)){
//
//                   $agreement_ar_balance = new  AgreementArBalance();
//                 $agreement_ar_balance->agreement_id =  $agreement_id;
//                 $agreement_ar_balance->ar_agreed_amount = $request->ar_agreed_amount;
//                 $agreement_ar_balance->ar_cash_received_amount = $request->ar_cash_received_amount;
//                 $agreement_ar_balance->ar_discount_amount = $request->ar_discount_amount;
//                 $agreement_ar_balance->total_deduction_amount = $request->ar_deduction_amount;
//                 $agreement_ar_balance->total_addition_amount = $request->ar_addition_amount;
//                 $agreement_ar_balance->current_balance = $request->ar_balance_amount;
//                 $agreement_ar_balance->save();
//
//                 $passport = Passport::find($passport_id);
//
//                 $now_ar_balance = $now_ar_agreed_amount-$now_ar_advance_amount-$now_ar_discount;
//             } else if(empty($request->dummy_id)){
//                 $passport  = Passport::find($passport_id);
//
//                 $now_ar_balance = $now_ar_agreed_amount-$now_ar_advance_amount-$now_ar_discount;
//
//                $ar_balance = new ArBalance();
//                 $ar_balance->zds_code = $passport->zds_code->zds_code;
//                 $ar_balance->name = $passport->personal_info->full_name;
//                 $ar_balance->agreed_amount	 = $now_ar_agreed_amount;
//                 $ar_balance->cash_received	 = $now_ar_advance_amount;
//                 $ar_balance->discount	 = $now_ar_discount;
//                 $ar_balance->deduction	 = "0";
//                 $ar_balance->balance	 = $now_ar_balance;
//                 $ar_balance->source_status	 = "1";
//                 $ar_balance->save();
//             }
            DB::table('rider_profiles')->where('passport_id', $passport_id)
                ->update(['agreement_status' => null]);

//             DB::table('agreements')->where('passport_id', $passport_id)
//                ->update(['status' => '0']);



            $message = [
                'message' => 'Agreement Created Successfully',
                'alert-type' => 'success'
            ];
            return "success";

//            return redirect()->route('agreement.create')->with($message);


        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('agreement.create')->with($message);
        }



    }



    public function check_amount_is_okay_not($request){


      $grand_total_amount  = 0;
      $labour_amount = 0;
      $license_amount = 0;

        $evisa_amount = 0;
        $medical_amount = 0;
        $emirates_id_amount = 0;
        $visa_pasting_amount = 0;
        $case_fine_amount = 0;

        $english_test_amount = 0;
        $rta_permit_training_amount = 0;
        $e_test_amount = 0;
        $rta_medical_amount = 0;
        $cid_report_amount = 0;
        $rta_card_print_amount = 0;


        $company_id  =  $request->visa_applying;
        $employee_id = $request->employee_type;
        $current_status = $request->current_status;





        if(!empty($request->labour_fees_ids)){
        $array_ids = explode(',',$request->labour_fees_ids);
        $labour_fees  = AgreementAmountFees::whereIn('id',$array_ids)->sum('amount');
        $labour_amount = $labour_fees;

        }


        if($employee_id=="2"){


            $evisa_print = $request->evisa_print;
            $inside_visa_type = $request->inside_visa_type;
            $evisa_print_label = "Inside E-visa Print";
            $evisa_array = "";
            if($evisa_print=="2"){

                $evisa_array =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$evisa_print_label)
                    ->where('option_value','=',$evisa_print)
                    ->first();

            }elseif($evisa_print=="1"){
                $evisa_array =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$evisa_print_label)
                    ->where('option_value','=',$evisa_print)
                    ->where('child_option_id','=',$inside_visa_type)
                    ->first();
            }

            if($employee_id=="1"){
                $company_id = NULL;
            }

            if(!empty($inside_visa_type)){
                $inside_visa_type = $inside_visa_type;
            }
//            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
//                ->where('current_status_id','=',$current_status)
//                ->where('company_id','=',$company_id)
//                ->where('option_label','=',$evisa_print_label)
//                ->where('option_value','=',$evisa_print)
//                ->where('child_option_id','=',$inside_visa_type)
//                ->first();
            if($evisa_array != null){
                $evisa_amount  = $evisa_array->amount;
            }



            $medical_type = $request->medical_type;
            $medical_company = $request->medical_category;
            $medical_label = "Medical";

            if($medical_type=="1"){
                $medical_company = NULL;
            }

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$medical_label)
                ->where('option_value','=',$medical_type)
                ->where('child_option_id','=',$medical_company)
                ->first();
            if($amount != null){
                $medical_amount  = $amount->amount;
            }



            $emirates_id = $request->emirates_id;
            $emirate_id_label = "Emirates Id";

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$emirate_id_label)
                ->where('option_value','=',$emirates_id)
                ->first();
            if($amount != null){
                $emirates_id_amount  = $amount->amount;
            }




            $visa_pasting = $request->visa_pasting;
            $visa_pasting_label = "Visa Pasting";

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$visa_pasting_label)
                ->where('option_value','=',$visa_pasting)
                ->first();
            if($amount != null){
                $visa_pasting_amount  = $amount->amount;
            }



            $case_fine = $request->case_fine;
            $case_fine_label  = "In Case Fine";

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$case_fine_label)
                ->where('option_value','=',$case_fine)
                ->first();
            if($amount != null) {
                $case_fine_amount = $amount->amount;
            }



            if($request->working_visa=="3" && $request->visa_applying=="3" && $request->working_designation=="1"){

                $english_test = $request->english_test;
                $english_test_label  = "English Language Test";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$english_test_label)
                    ->where('option_value','=',$english_test)
                    ->first();
                if($amount != null) {
                    $english_test_amount = $amount->amount;
                }

                $rta_permit_training = $request->rta_permit_training;
                $rta_permit_training_label  = "RTA Permit Training";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$rta_permit_training_label)
                    ->where('option_value','=',$rta_permit_training)
                    ->first();
                if($amount != null) {
                    $rta_permit_training_amount = $amount->amount;
                }



                $e_test = $request->e_test;
                $e_test_label  = "E Test";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$e_test_label)
                    ->where('option_value','=',$e_test)
                    ->first();
                if($amount != null) {
                    $e_test_amount = $amount->amount;
                }



                $rta_medical = $request->rta_medical;
                $rta_medical_label  = "RTA Medical";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$rta_medical_label)
                    ->where('option_value','=',$rta_medical)
                    ->first();
                if($amount != null) {
                    $rta_medical_amount = $amount->amount;
                }



                $cid_report = $request->cid_report;
                $cid_report_label  = "CID Report";


                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$cid_report_label)
                    ->where('option_value','=',$cid_report)
                    ->first();
                if($amount != null) {
                    $cid_report_amount = $amount->amount;
                }



                $rta_card_print = $request->rta_card_print;
                $rta_card_print_label  = "RTA Card Print";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$rta_card_print_label)
                    ->where('option_value','=',$rta_card_print)
                    ->first();
                if($amount != null) {
                    $rta_card_print_amount = $amount->amount;
                }


            }


            }


        $driving_license = $request->driving_license;
        $license_type = $request->license_type;
        $car_type = $request->car_type;
        $license_label = "";

        if($driving_license=="1"){
            if($license_type=="1"){
                $license_label  = "Bike";
                $car_type = null;
            }else if($license_type=="2"){
                $license_label  = "Car";
            }else if($license_type=="3"){
                $license_label  = "Both";
            }
            if(isset($car_type)){
                $amount_now  =   LicenseAmount::where('employee_type_id','=',$employee_id)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$license_label)
                    ->where('option_value','=',$car_type)
                    ->where('current_status_id','=',$current_status)
                    ->first();
            }else{
                $amount_now  =   LicenseAmount::where('employee_type_id','=',$employee_id)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$license_label)
                    ->where('current_status_id','=',$current_status)
                    ->first();
           }
            if($amount_now != null){
                $license_amount =  $amount_now->amount+$amount_now->admin_amount;
            }
        }

        //admin amount

        $admin_amount = 0;

         $admin_array = AdminFees::where('employee_id','=',$employee_id)
                                    ->where('current_status_id','=',$current_status)
                                    ->where('company_id','=',$company_id)->first();

        if($admin_array != null){
            $admin_amount =  $admin_array->amount;
        }
//        echo "e visa amount=".$evisa_amount."<br>";

        $grand_total_amount =  $english_test_amount+$rta_permit_training_amount+$e_test_amount+$rta_medical_amount+$cid_report_amount+$rta_card_print_amount+$license_amount+$labour_amount+$evisa_amount+$medical_amount+$emirates_id_amount+$visa_pasting_amount+$case_fine_amount+$admin_amount;

        $total_discount_amount = array_sum($request->discount_amount);

        $advance_amount = $request->advance_amount;
        if(empty($advance_amount)){
            $advance_amount = 0;
        }


        $payroll_deduct = 0;

        if(!empty($request->payroll_deduct)){
            $payroll_deduct = $request->payroll_deduct;
        }






        $total_step_amount = array_sum($request->step_amount)+$payroll_deduct;

//        echo "<br> discount amount= ".$total_discount_amount."<br>";
//        echo "<br> advaance amount=".$advance_amount;
//        echo "<br> step amount=".$total_step_amount;
//        echo "<br> Grand total amount=".$grand_total_amount;


        $adjustment_amount = 0;
        if(!empty($request->adjustment_amount)){
            $adjustment_amount = $request->adjustment_amount;
        }


        $now_total =  $grand_total_amount-$total_discount_amount-$advance_amount-$adjustment_amount;

        if($now_total==$total_step_amount){
            return true;
        }else{
            return false;
        }

    }

    public function get_total_step_amount($request){

        $payroll_deduct = 0;

        if(!empty($request->payroll_deduct)){
            $payroll_deduct = $request->payroll_deduct;
        }

        $total_step_amount = array_sum($request->step_amount)+$payroll_deduct;

        return $total_step_amount;

    }




    public function get_total_agreed_amount($request){


        $grand_total_amount  = 0;
        $labour_amount = 0;
        $license_amount = 0;

        $evisa_amount = 0;
        $medical_amount = 0;
        $emirates_id_amount = 0;
        $visa_pasting_amount = 0;
        $case_fine_amount = 0;

        $english_test_amount = 0;
        $rta_permit_training_amount = 0;
        $e_test_amount = 0;
        $rta_medical_amount = 0;
        $cid_report_amount = 0;
        $rta_card_print_amount = 0;


        $company_id  =  $request->visa_applying;
        $employee_id = $request->employee_type;
        $current_status = $request->current_status;





        if(!empty($request->labour_fees_ids)){
            $array_ids = explode(',',$request->labour_fees_ids);
            $labour_fees  = AgreementAmountFees::whereIn('id',$array_ids)->sum('amount');
            $labour_amount = $labour_fees;

        }


        if($employee_id=="2"){


            $evisa_print = $request->evisa_print;
            $inside_visa_type = $request->inside_visa_type;
            $evisa_print_label = "Inside E-visa Print";
            $evisa_array = "";
            if($evisa_print=="2"){

                $evisa_array =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$evisa_print_label)
                    ->where('option_value','=',$evisa_print)
                    ->first();

            }elseif($evisa_print=="1"){
                $evisa_array =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$evisa_print_label)
                    ->where('option_value','=',$evisa_print)
                    ->where('child_option_id','=',$inside_visa_type)
                    ->first();
            }

            if($employee_id=="1"){
                $company_id = NULL;
            }

            if(!empty($inside_visa_type)){
                $inside_visa_type = $inside_visa_type;
            }
//            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
//                ->where('current_status_id','=',$current_status)
//                ->where('company_id','=',$company_id)
//                ->where('option_label','=',$evisa_print_label)
//                ->where('option_value','=',$evisa_print)
//                ->where('child_option_id','=',$inside_visa_type)
//                ->first();
            if($evisa_array != null){
                $evisa_amount  = $evisa_array->amount;
            }



            $medical_type = $request->medical_type;
            $medical_company = $request->medical_category;
            $medical_label = "Medical";

            if($medical_type=="1"){
                $medical_company = NULL;
            }

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$medical_label)
                ->where('option_value','=',$medical_type)
                ->where('child_option_id','=',$medical_company)
                ->first();
            if($amount != null){
                $medical_amount  = $amount->amount;
            }



            $emirates_id = $request->emirates_id;
            $emirate_id_label = "Emirates Id";

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$emirate_id_label)
                ->where('option_value','=',$emirates_id)
                ->first();
            if($amount != null){
                $emirates_id_amount  = $amount->amount;
            }




            $visa_pasting = $request->visa_pasting;
            $visa_pasting_label = "Visa Pasting";

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$visa_pasting_label)
                ->where('option_value','=',$visa_pasting)
                ->first();
            if($amount != null){
                $visa_pasting_amount  = $amount->amount;
            }



            $case_fine = $request->case_fine;
            $case_fine_label  = "In Case Fine";

            $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                ->where('current_status_id','=',$current_status)
                ->where('company_id','=',$company_id)
                ->where('option_label','=',$case_fine_label)
                ->where('option_value','=',$case_fine)
                ->first();
            if($amount != null) {
                $case_fine_amount = $amount->amount;
            }



            if($request->working_visa=="3" && $request->visa_applying=="3" && $request->working_designation=="1"){

                $english_test = $request->english_test;
                $english_test_label  = "English Language Test";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$english_test_label)
                    ->where('option_value','=',$english_test)
                    ->first();
                if($amount != null) {
                    $english_test_amount = $amount->amount;
                }

                $rta_permit_training = $request->rta_permit_training;
                $rta_permit_training_label  = "RTA Permit Training";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$rta_permit_training_label)
                    ->where('option_value','=',$rta_permit_training)
                    ->first();
                if($amount != null) {
                    $rta_permit_training_amount = $amount->amount;
                }



                $e_test = $request->e_test;
                $e_test_label  = "E Test";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$e_test_label)
                    ->where('option_value','=',$e_test)
                    ->first();
                if($amount != null) {
                    $e_test_amount = $amount->amount;
                }



                $rta_medical = $request->rta_medical;
                $rta_medical_label  = "RTA Medical";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$rta_medical_label)
                    ->where('option_value','=',$rta_medical)
                    ->first();
                if($amount != null) {
                    $rta_medical_amount = $amount->amount;
                }



                $cid_report = $request->cid_report;
                $cid_report_label  = "CID Report";


                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$cid_report_label)
                    ->where('option_value','=',$cid_report)
                    ->first();
                if($amount != null) {
                    $cid_report_amount = $amount->amount;
                }



                $rta_card_print = $request->rta_card_print;
                $rta_card_print_label  = "RTA Card Print";

                $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                    ->where('current_status_id','=',$current_status)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$rta_card_print_label)
                    ->where('option_value','=',$rta_card_print)
                    ->first();
                if($amount != null) {
                    $rta_card_print_amount = $amount->amount;
                }


            }


        }


        $driving_license = $request->driving_license;
        $license_type = $request->license_type;
        $car_type = $request->car_type;
        $license_label = "";

        if($driving_license=="1"){
            if($license_type=="1"){
                $license_label  = "Bike";
                $car_type = null;
            }else if($license_type=="2"){
                $license_label  = "Car";
            }else if($license_type=="3"){
                $license_label  = "Both";
            }
            if(isset($car_type)){
                $amount_now  =   LicenseAmount::where('employee_type_id','=',$employee_id)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$license_label)
                    ->where('option_value','=',$car_type)
                    ->where('current_status_id','=',$current_status)
                    ->first();
            }else{
                $amount_now  =   LicenseAmount::where('employee_type_id','=',$employee_id)
                    ->where('company_id','=',$company_id)
                    ->where('option_label','=',$license_label)
                    ->where('current_status_id','=',$current_status)
                    ->first();
            }
            if($amount_now != null){
                $license_amount =  $amount_now->amount+$amount_now->admin_amount;
            }
        }

        //admin amount

        $admin_amount = 0;

        $admin_array = AdminFees::where('employee_id','=',$employee_id)
            ->where('current_status_id','=',$current_status)
            ->where('company_id','=',$company_id)->first();

        if($admin_array != null){
            $admin_amount =  $admin_array->amount;
        }
//        echo "e visa amount=".$evisa_amount."<br>";

        $grand_total_amount =  $english_test_amount+$rta_permit_training_amount+$e_test_amount+$rta_medical_amount+$cid_report_amount+$rta_card_print_amount+$license_amount+$labour_amount+$evisa_amount+$medical_amount+$emirates_id_amount+$visa_pasting_amount+$case_fine_amount+$admin_amount;

        $total_discount_amount = array_sum($request->discount_amount);

        $advance_amount = $request->advance_amount;
        if(empty($advance_amount)){
            $advance_amount = 0;
        }


        $payroll_deduct = 0;

        if(!empty($request->payroll_deduct)){
            $payroll_deduct = $request->payroll_deduct;
        }

        $total_step_amount = array_sum($request->step_amount)+$payroll_deduct;

        return $grand_total_amount;

    }



    public function get_employee_type($current_status_id){

        $tree_cat = AgreementCategoryTree::find($current_status_id);

         $category_id = $tree_cat->get_parent_name->id;

         $not_employee = array('16','17');
         $taking_visa = array('9','10','11','14');
         $part_time = array('13','15');

         $employee_type_id = "";

        if(in_array($category_id, $not_employee)){
            $employee_type_id = "1";

        }elseif(in_array($category_id, $taking_visa)){
            $employee_type_id = "2";

        }elseif(in_array($category_id, $part_time)){
            $employee_type_id = "3";
        }

     return $employee_type_id;

    }



    public function category(){

         $main_categories = AgreementCategory::orderby('id','desc')->get();
         $agreement_trees = AgreementCategoryTree::all();

        return view('admin-panel.agreement.category.create',compact('main_categories','agreement_trees'));
    }

    public function save_category(Request $request){

        $validator = Validator::make($request->all(), [
            'sub_category' => 'required',
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
            return redirect()->route('category')->with($message);
        }


         $agree_tree = AgreementCategoryTree::where('parent_id','=',$request->category)->orderby('id','desc')->first();

         $sub_cat = 0;
        $parnet_id = "0";

         if(empty($request->category)){
             $parnet_id = $request->category;

             $array_insert_two  = array(
                 'sub_id' => $request->sub_category,
                 'parent_id' => "0",
             );

         }
         else{


             $array_insert_two  = array(
                 'sub_id' => $request->sub_category,
                 'parent_id' => $request->category,
             );




         }

        AgreementCategoryTree::create($array_insert_two);

        $message = [
            'message' => 'Category Created Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('category')->with($message);


    }

    public function  testing_blade(){

        $cats = AgreementCategoryTree::where('parent_id','=','0')->get();
        $allMenus = AgreementCategoryTree::pluck('sub_id','id')->all();

        return view('admin-panel.agreement.category.testing',compact('cats'));


    }

    public function agreement_selection(){

        $parents = AgreementCategoryTree::where('parent_id','=','0')->get();
        $all_options = AgreementCategoryTree::pluck('sub_id','id')->all();

         $tree_amount = TreeAmount::orderby('id','desc')->get();

         $array_to_send = array();

        foreach($tree_amount as $ab){
            $arraay_set = explode(',',$ab->tree_path);

             $parnet_name = AgreementCategoryTree::find($arraay_set[0]);

             $names = AgreementCategoryTree::whereIn('id',$arraay_set)->get();

             $gamer = array(
               'parent_name' => $parnet_name->get_parent_name->name,
               'childs' => $names,
               'amount' => $ab->amount,
               'id' => $ab->id,
             );
            $array_to_send [] = $gamer;

        }

        return view('admin-panel.agreement.agreement_selection.create',compact('parents','all_options','array_to_send'));

    }

    public function  save_agreement_selection(Request $request){

        try{

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('agreement_selection')->with($message);
        }

        $path_tree = implode(',',$request->category);
            $path_tree = rtrim($path_tree,',');

           $is_exist =  TreeAmount::where('tree_path','=',$path_tree)->first();

           if($is_exist == null){

               $array_insert = array(
                   'amount' => $request->amount,
                   'tree_path' => $path_tree,
               );

               TreeAmount::create($array_insert);
               $message = [
                   'message' => 'Agreement Amount has been created Successfully',
                   'alert-type' => 'success',
               ];
               return redirect()->route('agreement_selection')->with($message);

           }else{

               $message = [
                   'message' =>  "Selection Already Exist",
                   'alert-type' => 'error',
                   'error' => ''
               ];
               return redirect()->route('agreement_selection')->with($message);

           }



        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('agreement_selection')->with($message);
        }


    }

    public  function update_amount_agreement(Request $request){

        try{

            $validator = Validator::make($request->all(), [
                'edit_amount' => 'required',
            ]);
            if($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('agreement_selection')->with($message);
            }

             $tree_amount = TreeAmount::find($request->id);
             $tree_amount->amount = $request->edit_amount;
             $tree_amount->update();

            $message = [
                'message' => 'Agreement Amount has been Updated Successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('agreement_selection')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('agreement_selection')->with($message);
        }


    }


    public function get_employee_types_options($id){

        $not_employee_array = array('14','15','16','17');
        $full_time_employee_array = array('9','10','43','44');
        $part_time = array('13');


        if($id=="1"){
             $options  = AgreementCategoryTree::whereIn('sub_id',$not_employee_array)->get();
        }elseif($id=="2"){
            $options = AgreementCategoryTree::whereIn('sub_id',$full_time_employee_array)->get();
        }elseif($id=="3"){
            $options = AgreementCategoryTree::whereIn('sub_id',$part_time)->get();
        }

        $array_to_send = array();

        foreach($options as $opt){

            $gamer = array(
                    'id' => $opt->id,
                    'name' => $opt->get_parent_name->name_alt,
            );

            $array_to_send [] = $gamer;
        }

        return  $array_to_send;

    }


    public function ajax_employee_type(Request $request){

         $id  = $request->primary_id;

          $gamer = $this->get_employee_types_options($id);

          $child['data'] = $gamer;
           echo json_encode($child);
        exit;
    }


    public function  ajax_edit_amount_agreement(Request $request){

        $ab =  TreeAmount::find($request->primary_id);

        $arraay_set = explode(',',$ab->tree_path);

        $parnet_name = AgreementCategoryTree::find($arraay_set[0]);


        $now_childs = array_shift($arraay_set);


        $childs_db = AgreementCategoryTree::whereIn('id',$arraay_set)->get();


        $childs = "";

        foreach ($childs_db as $name){
            $childs .= $name->get_parent_name->name_alt.",";
        }

        $gamer = array(
            'parent_name' => $parnet_name->get_parent_name->name,
            'childs' => $childs,
            'amount' => $ab->amount,
            'id' => $ab->id,
        );
        echo  json_encode($gamer);
        exit;

    }



    public function ajax_check_amount_current_status(Request $request){

        if(!empty($request->current_status)){

            $cat_tree = AgreementCategoryTree::where('sub_id','=','1')->where('parent_id','=','0')->first();
            $parent_id = $cat_tree->id;

            $path_now = $parent_id.','.$request->current_status;

            $path_now = rtrim($path_now,',');

            $amount =  TreeAmount::where('tree_path','like','%'.$path_now.'%')->first();

            if(!empty($amount)){
                return $amount->amount."-".$amount->id;
            }else{
                return "0"."-"."0";
            }

        }else{
            return "0"."-"."0";
        }



    }

    public function ajax_check_amount_driving_license(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','2')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $path_now = $parent_id.','.$request->current_status;

         $selected_val =  $request->items;

         $path_now = implode(',',$selected_val);

        $path_now = $parent_id.','.$path_now;

        $path_now = rtrim($path_now,',');

        $amount =  TreeAmount::where('tree_path','=',$path_now)->first();

        if(!empty($amount)){
            return $amount->amount."-".$amount->id;
        }else{
            return "0"."-"."0";
        }

    }



    public function ajax_render_child(Request $request)
    {

        $select_id = $request->parent_id;

        $parent = AgreementCategoryTree::find($select_id);

        if(count($parent->childs)) {

            foreach($parent->childs as $child){
                    $child->get_parent_name->name;
                    $gamer = array(
                        'id' => $child->id,
                        'parent_id' => $child->parent_id,
                        'name' => $child->get_parent_name->name
                    );

                $childe['data'] [] = $gamer;
            }


            echo json_encode($childe);
            exit;
        }

    }

    public function ajax_check_child_driving_license(Request $request){

        $select_id = $request->parent_id;

        $parent = AgreementCategoryTree::find($select_id);

        if(count($parent->childs)) {
            foreach($parent->childs as $child){
                $child->get_parent_name->name;

                $gamer = array(
                    'id' => $child->id,
                    'parent_id' => $child->parent_id,
                    'name' => $child->get_parent_name->name_alt,
                    'value' => $child->parent_id,
                );

                $childe['data'] [] = $gamer;
            }

            echo json_encode($childe);
            exit;
        }
    }

    public function ajax_check_child_medical_company(Request $request){

        $select_id = $request->parent_id;

        if(!empty($select_id)){

            $parent = AgreementCategoryTree::find($select_id);

            if(count($parent->childs)) {
                foreach($parent->childs as $child){
                    $child->get_parent_name->name;

                    $gamer = array(
                        'id' => $child->id,
                        'parent_id' => $child->parent_id,
                        'name' => $child->get_parent_name->name_alt,
                        'value' => $child->parent_id,
                    );

                    $childe['data'] [] = $gamer;
                }

                echo json_encode($childe);
                exit;
            }

        }else{

            $childe['data'] = [];
            echo json_encode($childe);
            exit;
        }



    }

    public function  ajax_check_amount_medical_amount(Request $request){
        $cat_tree = AgreementCategoryTree::where('sub_id','=','3')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;
        $path_now = $parent_id.','.$request->current_status;
        $selected_val =  $request->items;
        $path_now = implode(',',$selected_val);
        $path_now = $parent_id.','.$path_now;

         $path_now = rtrim($path_now,',');

        $amount =  TreeAmount::where('tree_path','=',$path_now)->first();
        if(!empty($amount)){
            return $amount->amount."-".$amount->id;
        }else{
            return "0"."-"."0";
        }
    }

    public function ajax_check_amount_emirates_id(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','4')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $path_now = $parent_id.','.$request->items;

        $path_now = rtrim($path_now,',');
        $amount =  TreeAmount::where('tree_path','=',$path_now)->first();
        if(!empty($amount)){
            return $amount->amount."-".$amount->id;
        }else{
            return "0"."-"."0";
        }
    }

    public function  ajax_check_amount_status_change(Request $request){
        $cat_tree = AgreementCategoryTree::where('sub_id','=','5')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;

        $selected_val =  $request->items;

        $path_now = $parent_id.','.$selected_val;
        $path_now = rtrim($path_now,',');
        $amount =  TreeAmount::where('tree_path','=',$path_now)->first();
        if(!empty($amount)){
            return $amount->amount."-".$amount->id;
        }else{
            return "0"."-"."0";
        }
    }

    public function  ajax_check_amount_case_fine(Request $request){
        $cat_tree = AgreementCategoryTree::where('sub_id','=','6')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;
        $selected_val =  $request->items;
        $path_now = $parent_id.','.$selected_val;

        $path_now = rtrim($path_now,',');

        $amount =  TreeAmount::where('tree_path','=',$path_now)->first();
        if(!empty($amount)){
            return $amount->amount."-".$amount->id;
        }else{
            return "0"."-"."0";
        }
    }

    public function ajax_check_amount_rta_permit(Request $request){

        $cat_tree = AgreementCategoryTree::where('sub_id','=','7')->where('parent_id','=','0')->first();
        $parent_id = $cat_tree->id;
        $selected_val =  $request->items;
        $path_now = $parent_id.','.$selected_val;

        $path_now = rtrim($path_now,',');

        $amount =  TreeAmount::where('tree_path','=',$path_now)->first();
        if(!empty($amount)){
            return $amount->amount."-".$amount->id;
        }else{
            return "0"."-"."0";
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

    public function agreement_pdf($id){

        $agreement = Agreement::find($id);

        $parents = AgreementCategoryTree::where('parent_id','=','0')->get();
        $parent_name_array = [];

        foreach($parents as $parent){
            $parent_name_array[$parent->id] = $parent->get_parent_name->name_alt;
        }
        $driving_licence_label = "";
        $driving_option_value = NULL;

        if($agreement->driving_licence_vehicle=="1"){
            $driving_licence_label = "Bike";
        }elseif($agreement->driving_licence_vehicle=="2"){
            $driving_licence_label = "Car";
        }elseif($agreement->driving_licence_vehicle=="3"){
            $driving_licence_label = "Both";
            $driving_option_value = $agreement->driving_licence_vehicle_type;
        }


        if(!empty($driving_option_value)){
            $driving_license_amount = LicenseAmount::where('employee_type_id','=',$agreement->employee_type_id)
                ->where('company_id','=',$agreement->applying_visa)
                ->where('option_label','=',$driving_licence_label)
                ->where('option_value','=',$driving_option_value)->first();
        }else{
            $driving_license_amount = LicenseAmount::where('employee_type_id','=',$agreement->employee_type_id)
                ->where('company_id','=',$agreement->applying_visa)
                ->where('option_label','=',$driving_licence_label)->first();

        }

//            dd($driving_license_amount);

        $reference_type_array =  array('Own','Outside');
        $driving_license_array =  array('0','Yes','No');
        $driving_license_ownership_array =  array('Company','Own');
        $driving_license_verhicle_array =  array('0','Bike','Car','Both');
        $driving_license_verhicle_type_array =  array('0','Automatic Car','Manual Car');
        $medical_ownership_array =  array('Company','Own');
        $emiratesid_ownership_array =  array('0','Own','Company');
        $visa_pasting_array =  array('0','Normal','Urgent');
        $status_change_array =  array('Inside','in-out');
        $fine_array =  array('0','Own','Company');
        $rta_permit_array =  array('Company','Own');
        $labour_fees_array = array('0','Quota','Offer letter','Offer Letter Submission','Labor Fees','New Contract Typing','New Contract Submission');
        $e_visa_print = array('0','Inside E-visa Print','Outside E-visa Print');
        $e_visa_print_inside = array('0','Inside Status Change','Outside Status Change');

        $english_test_array = array('0','Own','Company');
        $rta_permit_training_array = array('0','Own','Company');
        $e_test_array = array('0','Own','Company');
        $rta_medical_array = array('0','Own','Company');
        $cid_report_array = array('0','Own','Company');
        $rta_card_array = array('0','Own','Company');

        $pdf = PDF::loadView('admin-panel.pdf.agreement_pdf', compact('driving_license_amount','driving_license_amount','rta_card_array','cid_report_array','rta_medical_array','e_test_array','english_test_array','visa_pasting_array','e_visa_print_inside','e_visa_print','labour_fees_array','rta_permit_training_array','fine_array','status_change_array','emiratesid_ownership_array','medical_ownership_array','driving_license_verhicle_type_array','driving_license_verhicle_array','driving_license_ownership_array','driving_license_array','reference_type_array','agreement','parent_name_array'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('agreement.pdf');

    }
    public  function  agreement_complete_pdf($id){

        $agreement = Agreement::find($id);

        $parents = AgreementCategoryTree::where('parent_id','=','0')->get();
        $parent_name_array = [];

        foreach($parents as $parent){
            $parent_name_array[$parent->id] = $parent->get_parent_name->name_alt;
        }

        $driving_licence_label = "";
        $driving_option_value = NULL;

        if($agreement->driving_licence_vehicle=="1"){
            $driving_licence_label = "Bike";
        }elseif($agreement->driving_licence_vehicle=="2"){
            $driving_licence_label = "Car";
        }elseif($agreement->driving_licence_vehicle=="3"){
            $driving_licence_label = "Both";
            $driving_option_value = $agreement->driving_licence_vehicle_type;
        }


        if(!empty($driving_option_value)){
            $driving_license_amount = LicenseAmount::where('employee_type_id','=',$agreement->employee_type_id)
                ->where('company_id','=',$agreement->applying_visa)
                ->where('option_label','=',$driving_licence_label)
                ->where('option_value','=',$driving_option_value)->first();
        }else{
            $driving_license_amount = LicenseAmount::where('employee_type_id','=',$agreement->employee_type_id)
                ->where('company_id','=',$agreement->applying_visa)
                ->where('option_label','=',$driving_licence_label)->first();

        }

//            dd($driving_license_amount);

        $reference_type_array =  array('Own','Outside');
        $driving_license_array =  array('0','Yes','No');
        $driving_license_ownership_array =  array('Company','Own');
        $driving_license_verhicle_array =  array('0','Bike','Car','Both');
        $driving_license_verhicle_type_array =  array('0','Automatic Car','Manual Car');
        $medical_ownership_array =  array('Company','Own');
        $emiratesid_ownership_array =  array('0','Own','Company');
        $visa_pasting_array =  array('0','Normal','Urgent');
        $status_change_array =  array('Inside','in-out');
        $fine_array =  array('0','Own','Company');
        $rta_permit_array =  array('Company','Own');
        $labour_fees_array = array('0','Quota','Offer letter','Offer Letter Submission','Labor Fees','New Contract Typing','New Contract Submission');
        $e_visa_print = array('0','Inside E-visa Print','Outside E-visa Print');
        $e_visa_print_inside = array('0','Inside Status Change','Outside Status Change');

        $english_test_array = array('0','Own','Company');
        $rta_permit_training_array = array('0','Own','Company');
        $e_test_array = array('0','Own','Company');
        $rta_medical_array = array('0','Own','Company');
        $cid_report_array = array('0','Own','Company');
        $rta_card_array = array('0','Own','Company');

        $pdf = PDF::loadView('admin-panel.pdf.complete_agreement_pdf', compact('driving_license_amount','driving_license_amount','rta_card_array','cid_report_array','rta_medical_array','e_test_array','english_test_array','visa_pasting_array','e_visa_print_inside','e_visa_print','labour_fees_array','rta_permit_training_array','fine_array','status_change_array','emiratesid_ownership_array','medical_ownership_array','driving_license_verhicle_type_array','driving_license_verhicle_array','driving_license_ownership_array','driving_license_array','reference_type_array','agreement','parent_name_array'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('agreement.pdf');


    }

    public  function  agreement_testing_pdf(){

        $agreement = Agreement::find("2");

        $parents = AgreementCategoryTree::where('parent_id','=','0')->get();
        $parent_name_array = [];

        foreach($parents as $parent){
            $parent_name_array[$parent->id] = $parent->get_parent_name->name_alt;
        }

        $pdf = PDF::loadView('admin-panel.pdf.testing_file_pdf',compact('agreement','parent_name_array'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('agreement.pdf');

    }

    public function get_agreement_designation(Request $request){

        $designation_type = $request->primary_id;
        $employee_type = $request->employee_type;

        $gamer = array();
        if($designation_type=="1"){
            $gamer = array(1,2,3);
        }elseif($designation_type=="2"){
            if($employee_type=="1"){
                $gamer = array(4);
            }elseif($employee_type=="2"){
                $gamer = array(6);
            }elseif($employee_type=="3"){
                $gamer = array(5);
            }else{
                $gamer = array(4,5,6);
            }

        }elseif($designation_type=="3"){
            if($employee_type=="1"){
                $gamer = array(7);
            }elseif($employee_type=="2"){
                $gamer = array(9);
            }elseif($employee_type=="3"){
                $gamer = array(8);
            }else{
                $gamer = array(7,8,9);
            }

        }elseif($designation_type=="4"){
            $gamer = array(10,11,12,13);
        }elseif($designation_type=="5"){
            $gamer = array(14,15);
        }elseif($designation_type=="6"){
            $gamer = array(16,17,18);
        }elseif($designation_type=="7"){
            $gamer = array(19);
        }elseif($designation_type=="8"){
            $gamer = array(20,21,22,23);
        }

        $desginations = AgreemtnDesignation::whereIn('id',$gamer)->get();


         echo json_encode($desginations);

         exit;

    }





    public function ajax_get_unique_passport(Request $request){


        $pass = Passport::find($request->passport_id);


        $expiry_date=$pass->date_expiry;
        $curr_date=date('Y-m-d');
        $date1 = strtotime($curr_date);
        $date2 = strtotime($expiry_date);
        $diff = abs($date2 - $date1);

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)
            / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 -
                $months*30*60*60*24)/ (60*60*24));

        if($years=="0" && $months=="0"){
            $remain_days = $days." days";
        }elseif($years=="0" && $months!="0"){
            $remain_days = $months." months ".$days." days";
        }else{
            $remain_days = $years." years ".$months." months ".$days." days";
        }

        if(empty($pass->date_expiry)){
            $remain_days  = "No Expiry Date Found";
        }

         $additional_info = passport_addtional_info::find($request->passport_id);


        if(!empty($additional_info)){
            $email = $additional_info->personal_email ? $additional_info->personal_email : '';
            $phone = $additional_info->personal_mob ? $additional_info->personal_mob : '';
        }else{
            $email = "Not Found";
            $phone = "Not Found";
        }

        $full_name ="";

        if(isset($pass->personal_info->full_name)){
            $full_name =   $pass->personal_info->full_name;
        }else{
            $full_name = "Not Found";
        }



       if(!empty($pass->date_expiry)){
           $date_expire =  explode(' ',$pass->date_expiry);
       }else{
           $date_expire = "Not Found";
       }
       $passport_pic = "";
       if(!empty($pass->passport_pic)){
           $passport_pic = url($pass->personal_info->personal_image);
       }



        // $x= $pass->pp_uid.'$'.$full_name.'$'.$passport_pic.'$'.$email.'$'.$phone.'$'.$remain_days;
        // dd($x);
        return $pass->pp_uid.'$'.$full_name;
    }

    public function ajax_get_driving_license(Request $request){

        $passport_id = $request->passport_id;

        $passport = DrivingLicense::where('passport_id','=',$passport_id)->first();

        if(!empty($passport)){

            $expiry_date = explode(" ",$passport->expire_date);

            $expiry_date = $expiry_date[0];

            $curr_date=date('Y-m-d');
            $date1 = strtotime($curr_date);
            $date2 = strtotime($expiry_date);
            $diff = abs($date2 - $date1);

            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24)
                / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 -
                    $months*30*60*60*24)/ (60*60*24));

            if($years=="0" && $months=="0"){
                $remain_days = $days." days";
            }elseif($years=="0" && $months!="0"){
                $remain_days = $months." months ".$days." days";
            }else{
                $remain_days = $years." years ".$months." months ".$days." days";
            }

            if(empty($passport->expire_date)){
                $remain_days  = "No Expiry Date Found";
            }


            $issue_date = explode(" ",$passport->issue_date);

            $ab = array(
                'car_type' =>  $passport->car_type,
                'expire_date' =>  $expiry_date,
                'issue_date' =>  $issue_date[0],
                'license_number' => $passport->license_number,
                'license_type' => $passport->license_type,
                'place_issue' => $passport->place_issue,
                'traffic_code' => $passport->traffic_code,
                'remain_days' =>  $remain_days,
            );


            echo json_encode($ab);

            exit;

        }else{
            $ab = array();

            echo json_encode($passport);

            exit;


        }

    }

    public function get_ar_balance_agreement(Request $request){

        if($request->ajax()){
            $passport_id = $request->passport_id;

            $passport = Passport::find($passport_id);
            $zds_code = isset($passport->zds_code->zds_code)  ? $passport->zds_code->zds_code : '' ;

            $ar_balance = ArBalance::where('zds_code','=',$zds_code)->first();

            $array_to_send = array();

            if(!empty($ar_balance)){

                $current_balance = $ar_balance->balance;
                $total_addition = 0;
                $total_deducation = 0;
                foreach ($ar_balance->transactions as $ab) {
                    if($ab->status=="0"){
                        $current_balance = $current_balance+$ab->balance;
                    }else{
                        $current_balance = $current_balance-$ab->balance;
                    }
                }
                if(!empty($ar_balance->transactions)){
                    $total_addition = $ar_balance->transactions->where('status','=','0')->sum('balance');
                }

                if(!empty($ar_balance->transactions)){
                    $total_deducation = $ar_balance->transactions->where('status','=','1')->sum('balance');
                    $total_deducation = $total_deducation+$ar_balance->deduction;
                }else{
                    $total_deducation =  $ar_balance->deduction;
                }



                $array_to_send = array(
                  'agreed_amount' =>  $ar_balance->agreed_amount,
                  'cash_received' =>  $ar_balance->cash_received,
                  'discount' =>  $ar_balance->discount,
                  'deduction' =>  $total_deducation,
                  'total_addition' =>  $total_addition,
                  'balance' =>  $current_balance,
                );
            }else{
                $array_to_send = array(
                    'agreed_amount' =>  'no',
                    'cash_received' =>  'no',
                    'discount' =>  'no',
                    'deduction' =>  'no',
                    'balance' =>  'no',
                );
            }

            echo json_encode($array_to_send);
            exit;
        }
    }

    public function check_ar_balance_exist($passport_id){

        $passport = Passport::find($passport_id);
        $zds_code = isset($passport->zds_code->zds_code)  ? $passport->zds_code->zds_code : '' ;

        $ar_balance = ArBalance::where('zds_code','=',$zds_code)->first();

        if($ar_balance != null){
            return true;
        }else{
            return false;
        }



    }


    public function check_zds_code_exist($passport_id){

        $passport = Passport::find($passport_id);
        $zds_code = isset($passport->zds_code->zds_code)  ? $passport->zds_code->zds_code : '' ;

        if(!empty($zds_code)){
            return true;
        }else{
            return false;
        }
    }

    public  function ajax_agreement_cancel(Request $request)
    {
        $agreement=Agreement::where('id',$request->id)->first();
        $passport_id=$agreement->passport_id;
        $passport=Passport::where('id',$passport_id)->first();
        $bike= isset($passport->bike_checkin()->bike_plate_number->plate_no) ? ($passport->bike_checkin()->bike_plate_number->plate_no) : 'N/A';
        $sim = isset($passport->sim_checkin()->telecome->account_number) ? ($passport->sim_checkin()->telecome->account_number) : 'N/A';
        $platform = isset($passport->assign_platforms_check()->plateformdetail->name) ? ($passport->assign_platforms_check()->plateformdetail->name) : 'N/A';
        $id = $request->id;




//        $riderProfile  = RiderProfile::where('passport_id','=',$passport_id)->first();
        $remain_amount = 0;
        $total_pending_amount = 0;
        $total_paid_amount = 0;
        $total_salary_amount = 0;

//        $user_passport_id = $riderProfile->passport_id;

        if(isset($riderProfile->passport->platform_codes)){
            $check_in_platform = null;
            $check_in_platform = $riderProfile->passport->platform_assign->where('status','=','1')->pluck(['plateform'])->first();
            $rider_id = $riderProfile->passport->platform_codes->where('platform_id','=',$check_in_platform)->pluck(['platform_code'])->first();

            $amount =  CodUpload::where('rider_id','=',$rider_id)
                ->where('platform_id','=',$check_in_platform)
                ->selectRaw('sum(amount) as total')->first();

            $paid_amount =  Cods::where('passport_id',$passport_id)->where('platform_id','=',$check_in_platform)->where('status','1')->selectRaw('sum(amount) as total')->first();
            $salary_array = CloseMonth::where('passport_id','=',$riderProfile->passport->id)->selectRaw('sum(close_month_amount) as total')->first();

            if(!empty($amount)){
                $total_pending_amount = $amount->total;
            }
            if(!empty($paid_amount)){
                $total_paid_amount = $paid_amount->total;
            }
            if(!empty($salary_array)){
                $total_paid_amount = $total_paid_amount+$salary_array->total;
            }


        }

        $prev_array = CodPrevious::where('passport_id','=',$passport_id)->first();
        if($prev_array != null){
            $pre_amount = $prev_array->amount;

            $total_pending_amount = $total_pending_amount+$pre_amount;
        }

        $adj_req_t =CodAdjustRequest::where('passport_id','=',$passport_id)->where('status','=','2')->selectRaw('sum(amount) as total')->first();

        if($adj_req_t != null){
            $total_paid_amount = $total_paid_amount+$adj_req_t->total;
        }

        $remain_amount = number_format((float)$total_pending_amount-$total_paid_amount, 2, '.', '');

//ar balance
        $date_between=ArBalanceSheet::where('passport_id', $passport_id)->get();
       if(count($date_between)!='0')
        {
            foreach ($date_between as $res) {
                $first_balance = ArBalance::where('zds_code', $res->zds_code)->first();
                $current_balance = isset($first_balance->balance) ? $first_balance->balance : 0;
                if ($res->status == '0') {
                    $current_balance = $current_balance + $res->balance;
                } else {
                    $current_balance = $current_balance - $res->balance;
                }
            }
        }
       else{
           $current_balance="0";
       }






        $view = view("admin-panel.agreement.ajax_agreement.ajax_get_agreement_cancel", compact('bike','sim','platform','id','remain_amount','current_balance'))->render();

        return response()->json(['html' => $view]);

    }
    public function agreement_cancel_save(Request  $request){


        $passport=Agreement::where('id',$request->id)->first();

        $obj=new AgreementCancel();
        $obj->agrement_id=$request->id;
        $obj->cancel_reason=$request->cancel_reason;
        $obj->remarks=$request->remarks;
        $obj->cancel_date=$request->cancel_date;
        $obj->save();
//update at agreements table
        DB::table('agreements')->where('id', $request->id)
            ->update(['status' => '1']);
//        //update at passports table
        DB::table('rider_profiles')->where('passport_id', $passport->passport_id)
            ->update(['agreement_status' => '1']);

        $message = [
            'message' => 'Agreement Has Been Cancelled Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }





}
