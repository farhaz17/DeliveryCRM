<?php

namespace App\Http\Controllers\AdminFee;

use App\Model\AdminFees\AdminFees;
use App\Model\Agreement\AgreementCategoryTree;
use App\Model\LicenseAmount\LicenseAmount;
use App\Model\Seeder\Company;
use App\Model\Seeder\EmployeeType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminFeeController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|agreement-agreement-admin-amount', ['only' => ['index','store','destroy','edit','update']]);
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

        $cat_current_staus = AgreementCategoryTree::where('sub_id','=','1')->where('parent_id','=','0')->first();
        $parent_id = $cat_current_staus->id;
        $current_status = AgreementCategoryTree::where('parent_id','=',$parent_id)->get();

        $admin_fees  = AdminFees::orderby('id','desc')->get();

        return view('admin-panel.admin_fee.index',compact('companies','current_status','employee_types','admin_fees'));
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
                'current_staus_id' => 'required',
                'amount' => 'required',
                'company_id' => 'required',

            ]);
            if($validator->fails()) {
                $validate = $validator->errors();

                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('admin_fee')->with($message);
            }

            $exit_amount  = AdminFees::
                where('employee_id','=',$request->employee_type_id)
                ->where('current_status_id','=',$request->current_staus_id)
                ->where('company_id','=',$request->company_id)
                ->first();

            if(!empty($exit_amount)){

                $message = [
                    'message' => "For this Selection Amount Already Exist",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return redirect()->route('admin_fee')->with($message);

            }


            $admin_fee = new AdminFees();
            $admin_fee->employee_id = $request->employee_type_id;
            $admin_fee->current_status_id = $request->current_staus_id;
            $admin_fee->amount = $request->amount;
            $admin_fee->company_id = $request->company_id;
            $admin_fee->save();

            $message = [
                'message' => "Amount has been saved Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->route('admin_fee')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('admin_fee')->with($message);

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

        $name_ab = AdminFees::find($id);

                $gamer = array(
                    'employee_name' => $name_ab->get_employee_type->name,
                    'current_status_name' => $name_ab->get_current_status->get_parent_name->name_alt,
                    'company_name' => isset($name_ab->get_company->name) ? $name_ab->get_company->name : 'N/A',
                    'amount' => $name_ab->amount,
                     'id' => $name_ab->id,
                );

                return $gamer;

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
        try{
            $validator = Validator::make($request->all(), [
                'edit_amount' => 'required',
            ]);
            if($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('admin_fee')->with($message);
            }

            $admin_fee =AdminFees::find($id);
            $admin_fee->amount = $request->edit_amount;
            $admin_fee->update();

            $message = [
                'message' => "Amount has been Updated Successfully",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->route('admin_fee')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('admin_fee')->with($message);

        }

    }

    public function admin_fees_ajax(Request $request){


        $current_status =  $request->current_status;
        $employee_id =  $request->employee_id;
        $company_id =  $request->company_id;

        $amount_now = AdminFees::where('employee_id','=',$employee_id)
            ->where('current_status_id','=',$current_status)
            ->where('company_id','=',$company_id)
            ->first();


        if($amount_now != null){
            return  $amount_now->amount."-".$amount_now->id;
        }else{
            return  "0"."-"."0";
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
}
