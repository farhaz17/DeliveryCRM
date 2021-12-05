<?php

namespace App\Http\Controllers\Agreement;

use App\Model\AdminFees\AdminFees;
use App\Model\Agreement\Agreement;
use App\Model\Agreement\AgreementAmount;
use App\Model\Agreement\AgreementCategoryTree;
use App\Model\Agreement\AgreemenUpload;
use App\Model\Agreement\DocumentTree;
use App\Model\AgreementAmendment\AgreementAmendment;
use App\Model\AgreementAmendment\AgreementAmendmentAmounts;
use App\Model\AgreementAmendment\AgreementAmendmentAssingAmounts;
use App\Model\AgreementAmendment\ArBalanceAmendmentAgreement;
use App\Model\AgreementAmountFees\AgreementAmountFees;
use App\Model\ArBalance\ArBalance;
use App\Model\CompanyCode;
use App\Model\DiscountName\DiscountName;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\LicenseAmount\LicenseAmount;
use App\Model\Master_steps;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Seeder\AgreemtnDesignation;
use App\Model\Seeder\Company;
use App\Model\Seeder\Designation;
use App\Model\Seeder\EmployeeType;
use App\Model\Seeder\LivingStatus;
use App\Model\Seeder\MedicalCategory;
use App\Model\Seeder\PersonStatus;
use App\Model\Seeder\Visa_job_requests;
use App\Model\VisaProcess\AssigningAmount;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AmendmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                'driving_license' => 'required',
//                'passport_number' => 'required|unique:agreements,passport_id',
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

                $message_error = "";
                foreach ($validate->all() as $error){
                    $message_error .= $error;
                }
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

            if($this->check_zds_code_exist($request->passport_id)){

            }else{

                return "Zds code is not exist, please make zds before create agreement";
            }





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


            $agreement = new AgreementAmendment();
            $agreement->agreement_id = $request->agreement_id;
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
            $agreement->passport_id = $request->passport_id;
            $agreement->agreement_no = $request->agreement_no;
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

            $agreement_recent  =   $agreement->save();

            $agreement_id = $agreement->id;
            $passport_id =  $request->passport_id;


//            if($this->get_employee_type($request->current_status)=="1"){
//
//                $zmv_code = IdGenerator::generate(['table' => 'company_codes', 'field' => 'company_code', 'length' => 8, 'prefix' => 'ZMV5']);
//
//                $array_gamer = array(
//                    'passport_id' => $passport_id,
//                    'company_code' => $zmv_code
//                );
//
//                CompanyCode::create($array_gamer);
//
//            }


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
                        'agreement_amendment_id' => $agreement_id,
                        'tree_amount_id'  => $lab,
                        'amount' => $labour_fees->amount
                    );
                    AgreementAmendmentAmounts::create($array_insert);
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
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $evisa_print_amount_primary_id,
                    'amount' =>  $status_change_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }


            if(!empty($request->medical_process_amount_field)){
                $medical_process_amount = $request->medical_process_amount_field;
                $medical_process_amount_primary_id = $request->medical_process_amount_primary_id;
                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $medical_process_amount_primary_id,
                    'amount' => $medical_process_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->emirate_id_amount_field)){
                $emirats_id_amount = $request->emirate_id_amount_field;
                $emirats_id_amount_primary_id = $request->emirate_id_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $emirats_id_amount_primary_id,
                    'amount' => $emirats_id_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->visa_pasting_amount_field)){
                $emirats_id_amount = $request->visa_pasting_amount_field;
                $emirats_id_amount_primary_id = $request->visa_pasting_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $emirats_id_amount_primary_id,
                    'amount' => $emirats_id_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->case_fine_amount_field)){
                $case_fine_amount   = $request->case_fine_amount_field;
                $case_fine_amount_primary_id  = $request->case_fine_amount_primary_id;
                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $case_fine_amount_primary_id,
                    'amount' => $case_fine_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->english_test_amount_field)){
                $rta_permit_amount    = $request->english_test_amount_field;
                $rta_permit_amount_primary   = $request->english_test_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->rta_permint_amount_field)){
                $rta_permit_amount    = $request->rta_permint_amount_field;
                $rta_permit_amount_primary   = $request->rta_permint_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->e_test_amount_field)){
                $rta_permit_amount    = $request->e_test_amount_field;
                $rta_permit_amount_primary   = $request->e_test_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->rta_medical_amount_field)){
                $rta_permit_amount    = $request->rta_medical_amount_field;
                $rta_permit_amount_primary   = $request->rta_medical_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->cid_report_amount_field)){
                $rta_permit_amount    = $request->cid_report_amount_field;
                $rta_permit_amount_primary   = $request->cid_report_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
            }

            if(!empty($request->rta_print_amount_field)){
                $rta_permit_amount    = $request->rta_print_amount_field;
                $rta_permit_amount_primary   = $request->rta_print_amount_primary_id;

                $array_insert = array(
                    'agreement_amendment_id' => $agreement_id,
                    'tree_amount_id'  => $rta_permit_amount_primary,
                    'amount' => $rta_permit_amount
                );
                AgreementAmendmentAmounts::create($array_insert);
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
                        'amendmentagreement_id' => $agreement_id,
                    );
                    AgreementAmendmentAssingAmounts::create($array_insert);
                }
                $counter_amount_step =  $counter_amount_step+1;
            }






//            $board_status = OnBoardStatus::where('passport_id','=',$passport_id)->first();
//
//            $have_license = 0;
//            $driv_lice = DrivingLicense::where('passport_id','=',$passport_id)->first();
//            if($driv_lice!=null){
//                $have_license =1;
//            }
//
//            if($board_status==null){
//                $now_board = new OnBoardStatus();
//                $now_board->passport_id =  $passport_id;
//                $now_board->agreement_status =  '1';
//                if($have_license!=0){
//                    $now_board->driving_license_status =  $have_license;
//                }
//                $now_board->save();
//            }else{
//                $board_status->agreement_status = '1';
//                if($have_license!=0){
//                    $board_status->driving_license_status =  $have_license;
//                }
//                $board_status->update();
//            }

            if($this->check_ar_balance_exist($passport_id)){

                $agreement_ar_balance = new  ArBalanceAmendmentAgreement();
                $agreement_ar_balance->agreement_amendment_id =  $agreement_id;
                $agreement_ar_balance->ar_agreed_amount = $request->ar_agreed_amount;
                $agreement_ar_balance->ar_cash_received_amount = $request->ar_cash_received_amount;
                $agreement_ar_balance->ar_discount_amount = $request->ar_discount_amount;
                $agreement_ar_balance->total_deduction_amount = $request->ar_deduction_amount;
                $agreement_ar_balance->total_addition_amount = $request->ar_addition_amount;
                $agreement_ar_balance->current_balance = $request->ar_balance_amount;
                $agreement_ar_balance->save();


                $passport = Passport::find($passport_id);

                $now_ar_balance = $now_ar_agreed_amount-$now_ar_advance_amount-$now_ar_discount;

                $ar_balance = ArBalance::where('zds_code','=',$passport->zds_code->zds_code)->first();

                $ar_balance->agreed_amount = $now_ar_agreed_amount;
                $ar_balance->cash_received = $now_ar_advance_amount;
                $ar_balance->discount = $now_ar_discount;
                $ar_balance->deduction = "0";
                $ar_balance->balance = $now_ar_balance;
                $ar_balance->update();


            }else{
                $passport  = Passport::find($passport_id);

                $now_ar_balance = $now_ar_agreed_amount-$now_ar_advance_amount-$now_ar_discount;

                $ar_balance = new ArBalance();
                $ar_balance->zds_code = $passport->zds_code->zds_code;
                $ar_balance->name = $passport->personal_info->full_name;
                $ar_balance->agreed_amount	 = $now_ar_agreed_amount;
                $ar_balance->cash_received	 = $now_ar_advance_amount;
                $ar_balance->discount	 = $now_ar_discount;
                $ar_balance->deduction	 = "0";
                $ar_balance->balance	 = $now_ar_balance;
                $ar_balance->source_status	 = "1";
                $ar_balance->save();
            }



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
            return $e;
//            return redirect()->route('agreement.create')->with($message);
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


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $all_passports = Passport::join('agreements','agreements.passport_id','=','passports.id')
            ->select('passports.id as passport_id','passports.passport_no as  passport_number','passports.pp_uid')
            ->where('agreements.id','=',$id)
            ->where('passports.is_cancel','=','0')->orderby('passports.id','desc')->get()->toArray();

        $pending_passports = $all_passports;


        $pass =  Passport::find($all_passports[0]['passport_id']);

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

        $master_steps = Master_steps::where('id','!=','1')->get();

        $living_statuses = LivingStatus::all();

        $employee_types = EmployeeType::all();

        $visa_job_requests =  Visa_job_requests::all();

        $discount_names = DiscountName::orderby('id','desc')->get();

        $agreement = Agreement::find($id);



        $designation_type = $agreement->working_designation;
        $employee_type =  $agreement->employee_type_id;

        $designation_array = array();
        if($designation_type=="1"){
            $designation_array = array(1,2,3);
        }elseif($designation_type=="2"){
            if($employee_type=="1"){
                $designation_array = array(4);
            }elseif($employee_type=="2"){
                $designation_array = array(6);
            }elseif($employee_type=="3"){
                $designation_array = array(5);
            }else{
                $designation_array = array(4,5,6);
            }

        }elseif($designation_type=="3"){
            if($employee_type=="1"){
                $designation_array = array(7);
            }elseif($employee_type=="2"){
                $designation_array = array(9);
            }elseif($employee_type=="3"){
                $designation_array = array(8);
            }else{
                $designation_array = array(7,8,9);
            }

        }elseif($designation_type=="4"){
            $designation_array = array(10,11,12,13);
        }elseif($designation_type=="5"){
            $designation_array = array(14,15);
        }elseif($designation_type=="6"){
            $designation_array = array(16,17,18);
        }elseif($designation_type=="7"){
            $designation_array = array(19);
        }elseif($designation_type=="8"){
            $designation_array = array(20,21,22,23);
        }

        $desginations = AgreemtnDesignation::whereIn('id',$designation_array)->get();

        $labour_fees_array = array('0','Quota','Offer letter','Offer Letter Submission','Labor Fees','New Contract Typing','New Contract Submission');

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

       $ar_balance =  $this->get_ar_balance_agreement($all_passports[0]['passport_id']);
        $remain_days = $this->ajax_get_remain_days_passport($all_passports[0]['passport_id']);
        $amendment_count = AgreementAmendment::where('agreement_id','=',$id)->count();


            $next_amendment = isset($amendment_count) ? $amendment_count+1 : '1';

        return view('admin-panel.agreement.amendement.amendement',compact('next_amendment','remain_days','ar_balance','driving_license_amount','labour_fees_array','desginations','pass','agreement','discount_names','visa_job_requests','employee_types','pending_passports', 'living_statuses', 'master_steps',   'parent_rta_permit', 'parent_case_fine', 'parent_emirated_id', 'parent_status_change', 'parents', 'parent_document_process', 'parents_driving_license', 'childs','riders', 'agrement_no' ,'person_statuses', 'desingations', 'companies', 'current_status_child', 'medical_categories'));

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


    public function get_ar_balance_agreement($passport_id){



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
            }

            return $array_to_send;


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

    public function amendment_complete_pdf($id){

        $agreement = AgreementAmendment::find($id);

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

        $amendment_ab = AgreementAmendment::find($id);

         $now_count = AgreementAmendment::where('agreement_id','=',$amendment_ab->agreement_id)->where('id','<=',$id)->count();

        $number_amendment = isset($now_count) ? $now_count: '0';

        $pdf = PDF::loadView('admin-panel.pdf.complete_amendment_pdf', compact('number_amendment','driving_license_amount','driving_license_amount','rta_card_array','cid_report_array','rta_medical_array','e_test_array','english_test_array','visa_pasting_array','e_visa_print_inside','e_visa_print','labour_fees_array','rta_permit_training_array','fine_array','status_change_array','emiratesid_ownership_array','medical_ownership_array','driving_license_verhicle_type_array','driving_license_verhicle_array','driving_license_ownership_array','driving_license_array','reference_type_array','agreement','parent_name_array'))
            ->setPaper('a4', 'portrait');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->stream('amendment_agreement.pdf');

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


    public function ajax_get_remain_days_passport($passport_id){


        $pass = Passport::find($passport_id);


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


        return $remain_days;
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

    public function get_amendment_history_ajax(Request $request){

        $agreement_id = $request->agreement_id;

         $amendments = AgreementAmendment::where('agreement_id','=',$agreement_id)->orderby('id','asc')->get();

         $view = view('admin-panel.agreement.amendement.ajax_amendment_history',compact('agreement_id','amendments'))->render();

         return $view;
    }




}
