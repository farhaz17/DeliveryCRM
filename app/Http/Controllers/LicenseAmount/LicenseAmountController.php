<?php

namespace App\Http\Controllers\LicenseAmount;

use App\Model\Agreement\AgreementCategoryTree;
use App\Model\LicenseAmount\LicenseAmount;
use App\Model\Seeder\Company;
use App\Model\Seeder\EmployeeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LicenseAmountController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|agreement-driving-license-amount', ['only' => ['index','store','destroy','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
               $employee_types = EmployeeType::orderby('id','desc')->get();
               $companies = Company::where('type','=',1)->get();

               $license_amounts  = LicenseAmount::orderby('id','desc')->get();

        $cat_current_staus = AgreementCategoryTree::where('sub_id','=','1')->where('parent_id','=','0')->first();
        $parent_id = $cat_current_staus->id;
        $current_status = AgreementCategoryTree::where('parent_id','=',$parent_id)->get();

        return view('admin-panel.driving_license_amount.index',compact('license_amounts','employee_types','companies','current_status'));
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
            'employee_type_id' => 'required',
            'company_id' => 'required',
            'license_type' => 'required',
            'current_status' => 'required',
            'amount' => 'required',
            'option_label' => 'required',
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();

            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('driving_license_amount')->with($message);
        }



        $option_value = NULL;
        if($request->license_type!="1"){
            $option_value = $request->car_type;
        }

  $exit_amount  = LicenseAmount::where('employee_type_id','=',$request->employee_type_id)
                ->where('company_id','=',$request->company_id)
                ->where('option_label','=',$request->option_label)
                ->where('current_status_id','=',$request->current_status)
                ->where('option_value','=',$option_value)->first();

        if(!empty($exit_amount)){

            $message = [
                'message' => "For this Selection Amount Already Exist",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->route('driving_license_amount')->with($message);

        }

            $license_amount = new  LicenseAmount();
           $license_amount->employee_type_id = $request->employee_type_id;
           $license_amount->company_id = $request->company_id;
           $license_amount->option_label = $request->option_label;
           $license_amount->option_value = $option_value;
           $license_amount->amount = $request->amount;
           $license_amount->current_status_id = $request->current_status;
           $license_amount->admin_amount = $request->admin_amount;
           $license_amount->save();

            $message = [
                'message' => "Amount has been saved Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->route('driving_license_amount')->with($message);

               }
                catch (\Illuminate\Database\QueryException $e){
                $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
                ];
                return redirect()->route('driving_license_amount')->with($message);

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

        try {
            $validator = Validator::make($request->all(), [
                'edit_amount' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();

                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('driving_license_amount')->with($message);
            }

            $license_amount = LicenseAmount::find($id);
            $license_amount->amount = $request->edit_amount;
            $license_amount->admin_amount = $request->admin_edit_amount;
            $license_amount->update();

            $message = [
                'message' => "Amount has been updated Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->route('driving_license_amount')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('driving_license_amount')->with($message);

        }


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

    public function ajax_get_license_amount(Request $request)
    {

        $option_value = $request->option_value;
        $company_id = $request->company_id;
        $option_label = $request->option_label;
        $employee_id = $request->employee_id;
        $car_type = $request->car_type;
        $current_status = $request->current_status;

        $amount_now = array();

        if($option_value == "1"){
            if (isset($car_type)) {
                $amount_now = LicenseAmount::where('employee_type_id', '=', $employee_id)
                    ->where('company_id', '=', $company_id)
                    ->where('option_label', '=', $option_label)
                    ->where('option_value', '=', $car_type)
                    ->where('current_status_id','=', $current_status)
                    ->first();
            } else {
                $amount_now = LicenseAmount::where('employee_type_id', '=', $employee_id)
                    ->where('company_id', '=', $company_id)
                    ->where('option_label', '=', $option_label)
                    ->where('current_status_id','=', $current_status)
                    ->first();
            }
      }

            if($amount_now != null){
//                $total_amount = $amount_now->amount+$amount_now->admin_amount;
                return  $amount_now->amount."-".$amount_now->id;
            }else{
                return  "0"."-"."0";
            }

    }


    public function ajax_admin_license_amount(Request $request)
    {


        $option_value = $request->option_value;
        $company_id = $request->company_id;
        $option_label = $request->option_label;
        $employee_id = $request->employee_id;
        $car_type = $request->car_type;
        $current_status = $request->current_status;
        $amount_now = array();
        if ($option_value == "1"){
            if (isset($car_type)) {
                $amount_now = LicenseAmount::where('employee_type_id', '=', $employee_id)
                    ->where('company_id', '=', $company_id)
                    ->where('option_label', '=', $option_label)
                    ->where('option_value', '=', $car_type)
                    ->where('current_status_id','=', $current_status)
                    ->first();
            } else {
                $amount_now = LicenseAmount::where('employee_type_id', '=', $employee_id)
                    ->where('company_id', '=', $company_id)
                    ->where('option_label', '=', $option_label)
                    ->where('current_status_id','=', $current_status)
                    ->first();
            }
    }

        if($amount_now != null){
            return  $amount_now->admin_amount."-".$amount_now->id;
        }else{
            return  "0"."-"."0";
        }




    }



    public function ajax_driving_license_selection_amount(Request $request){

        $id = $request->primary_id;
         $amounts = LicenseAmount::find($id);

         $car_type = "";

        if(isset($amounts->option_value)){
            $car_type =  ($amounts->option_value=="1") ? 'Automatic Car' : 'Manual Car';
        }

         $gamer = array(
             'employee' => $amounts->get_employee_type->name,
             'company_name' => $amounts->get_company->name,
             'option_label' => $amounts->option_label,
             'current_status' => isset($amounts->get_current_status->get_parent_name->name_alt) ? $amounts->get_current_status->get_parent_name->name_alt : 'N/A',
             'car_type' =>  $car_type,
             'amount' => $amounts->amount,
             'admin_amount' => $amounts->admin_amount,
         );

        return $gamer;

    }

}
