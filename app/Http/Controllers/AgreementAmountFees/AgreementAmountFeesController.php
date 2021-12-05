<?php

namespace App\Http\Controllers\AgreementAmountFees;

use App\Model\Agreement\AgreementCategoryTree;
use App\Model\AgreementAmountFees\AgreementAmountFees;
use App\Model\Seeder\Company;
use App\Model\Seeder\EmployeeType;
use App\Model\Seeder\LabourFeesOption;
use App\Model\Seeder\MedicalCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AgreementAmountFeesController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|agreement-agreement-fees-amount', ['only' => ['index','store','destroy','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $employee_types = EmployeeType::all();

        $cat_current_staus = AgreementCategoryTree::where('sub_id','=','1')->where('parent_id','=','0')->first();
        $parent_id = $cat_current_staus->id;
        $current_status = AgreementCategoryTree::where('parent_id','=',$parent_id)->get();

        $companies = Company::all();
         $labour_options = LabourFeesOption::all();

        $medical_categories = MedicalCategory::all();

         $agreement_amounts = AgreementAmountFees::orderby('id','DESC')->get();



        return view('admin-panel.agreement_amount_fees.index',compact('agreement_amounts','companies','employee_types','current_status','labour_options','medical_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_type_id' => 'required',
            'current_staus_id' => 'required',
            'option_value' => 'required',
            'option_label' => 'required',
//            'admin_amount' => 'required',
            'amount' => 'required'
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();

            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('agreement_amount_fees')->with($message);
        }


    $child_option_value = NULL;
        if($request->option_label=="Medical" && $request->option_value=="2"){
            $child_option_value = $request->medical_company_id;
        }

        if($request->option_label=="Inside E-visa Print" && $request->option_value=="1"){
            $child_option_value = $request->inside_evisa;
        }



        $option_value = NULL;
        if($request->option_label=="Labor Fees"){
                $option_value = $request->labour_option_id;
        }elseif($request->option_label=="Other Fee" || $request->option_label=="Admin Fee"){
                $option_value = NULL;
        }else{
                $option_value =  $request->option_value;
        }

        $company_id = NULL;

        if($request->employee_type_id!="1"){
            $company_id = $request->employee_type_id;
        }


         $exist_amount = AgreementAmountFees::where('employee_type_id','=',$company_id)
                            ->where('company_id','=',$request->working_company)
                            ->where('current_status_id','=',$request->current_staus_id)
                            ->where('option_value','=',$option_value)
                            ->where('child_option_id','=',$child_option_value)
                            ->where('option_label','=',$request->option_label)
                            ->first();

        if($exist_amount != null){

            $message = [
                'message' => 'For this Selection Amount Already Exist',
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->route('agreement_amount_fees')->with($message);

        }


        $agreement_amount = new AgreementAmountFees();
        $agreement_amount->employee_type_id = $request->employee_type_id;
        $agreement_amount->company_id = $request->working_company;
        $agreement_amount->current_status_id = $request->current_staus_id;
        $agreement_amount->option_value = $option_value;
        $agreement_amount->option_label = $request->option_label;
        $agreement_amount->child_option_id = $child_option_value;
        $agreement_amount->amount = $request->amount;
//        $agreement_amount->admin_amount = $request->admin_amount;
        $agreement_amount->save();


        $message = [
            'message' => 'Amount has been saved successfully',
            'alert-type' => 'success',
            'error' => '',
        ];
        return redirect()->route('agreement_amount_fees')->with($message);



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
        $validator = Validator::make($request->all(), [
            'edit_amount' => 'required'
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();

            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('agreement_amount_fees')->with($message);
        }

         $amount = AgreementAmountFees::find($id);
         $amount->amount =  $request->edit_amount;
//         $amount->admin_amount =  $request->edit_admin_amount;
         $amount->update();


        $message = [
            'message' => 'Amount has been Updated Successfully',
            'alert-type' => 'success',
            'error' => ''
        ];
        return redirect()->route('agreement_amount_fees')->with($message);



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

    public function ajax_get_edit_detail(Request $request){
          $id =  $request->primary_id;
            $amount = AgreementAmountFees::find($id);

            $child_option = "";
            $option_value_now = "";
                                if($amount->option_label=="Medical" && $amount->option_value=="1") {
                                    $option_value_now = "Own";
                                }elseif($amount->option_label=="Medical" && $amount->option_value=="2"){
                                   $child_option = "Medical";
                                    $option_value_now =  "Company";
                                 }elseif($amount->option_label=="Labor Fees"){
                                    $option_value_now =   $amount->get_labor_option->name;
                                 }elseif($amount->option_label=="Inside E-visa Print" && $amount->option_value=="1"){
                                           $child_option = "inside_evisa";
                                    $option_value_now =  "Inside E-visa Print ";
                                 }elseif($amount->option_label=="Inside E-visa Print" && $amount->option_value=="2"){
                                             $child_option = "outside_evisa";
                                    $option_value_now = "Outside E-visa Print";
                                  }elseif($amount->option_label=="Visa Pasting"){
                                            $child_option = "else";
                                    $option_value_now = ($amount->option_value=="1") ? 'Normal':'Urgent';
                                  }elseif($amount->option_label=="Other Fee" || $amount->option_label=="Admin Fee"){
                                            $child_option = "else";
                                    $option_value_now = "N/A";
                                  }else{
                                    $option_value_now = ($amount->option_value=="1") ?  'Own' : 'Company';
                                 }

                                    $child_option_label = "";
                                if($child_option=="Medical"){
                                 $child_option_label =  $amount->get_medical_company->name;
                                }elseif($child_option=="inside_evisa"){
                                 $child_option_label = ($amount->child_option_id=="1") ? 'Inside Status Change' : 'OutSide status change';
                                }else{
                                 $child_option_label = "";
                                }

            $gamer = array(
                    'id' => $amount->id,
                  'employee_type' => $amount->get_employee_type->name,
                  'company_name' => $amount->get_company_name->name,
                  'current_status' => $amount->get_current_status->get_parent_name->name_alt,
                  'option_label' => $amount->option_label,
                  'option_label_value' => $option_value_now,
                  'child_option' =>  $child_option_label,
                  'amount' => $amount->amount,
                  'admin_amount' =>  $amount->admin_amount
            );

          return $gamer;
    }


    public function ajax_amounts_labour_fees(Request $request){

        $employee_id = $request->employee_id;
        $company_id = $request->company_id;
        $option_label = $request->option_label;
        $current_status = $request->current_status;

        $amount = AgreementAmountFees::where('employee_type_id','=',$employee_id)
            ->where('current_status_id','=',$current_status)
            ->where('company_id','=',$company_id)
            ->where('option_label','=',$option_label)
            ->get();

        echo json_encode($amount);
        exit;

    }



    public function  ajax_amounts_agreement(Request $request){
        $child_value = NUll;
         $option_value = $request->option_value;
         $employee_id = $request->employee_id;
         $company_id = $request->company_id;
         $option_label = $request->option_label;
         $current_status = $request->current_status;

         if($employee_id=="1"){
           $company_id = NULL;
         }

         if(!empty($request->child_now)){
             $child_value = $request->child_now;
         }
         $amount =  AgreementAmountFees::where('employee_type_id','=',$employee_id)
                                        ->where('current_status_id','=',$current_status)
                                        ->where('company_id','=',$company_id)
                                        ->where('option_label','=',$option_label)
                                        ->where('option_value','=',$option_value)
                                        ->where('child_option_id','=',$child_value)
                                        ->first();

         if($amount!=null){

             $gamer = array(
                 'amount' => $amount->amount
             );
            return $amount->amount."-".$amount->id;

         }else{
             return "0"."-"."0";
         }
    }

}
