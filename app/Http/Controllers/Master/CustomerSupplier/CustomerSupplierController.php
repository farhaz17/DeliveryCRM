<?php

namespace App\Http\Controllers\Master\CustomerSupplier;

use App\Model\Cities;
use Illuminate\Http\Request;
use App\Model\Seeder\Company;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\CustomerSupplier\CustomerSupplier;
use App\Model\Master\CustomerSupplier\CustomerSupplierCategory;
use App\Model\Master\CustomerSupplier\CustomerSupplierDepartment;
use App\Model\Master\CustomerSupplier\CustomerSupplierSubCategory;

class CustomerSupplierController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|CustomerSupplierManager', ['only' => ['index','create','store','edit','update','get_company_info','get_customer_supplier_sub_category']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-panel.customer_suppliers.customer_supplier_list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zone_companies = Company::all();
        $categories = CustomerSupplierCategory::all();
        $states = Cities::all();
        return view('admin-panel.customer_suppliers.customer_supplier_create', compact('zone_companies','categories','states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'zone_company_id' => 'required',
            'contact_type' => 'required',
            'contact_name' => 'required',
            'payment_mode' => 'required',
            'payment_term' => 'required',
            'payment_term_days' => 'required_if:payment_term,2',
        ],
        $messages = [
            'payment_term_days.required_if' => 'Please enter days for Credit Payment Term'
        ]
    );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {        
            DB::beginTransaction();
            $contact = new CustomerSupplier();
            $contact->zone_company_id = json_encode($request->zone_company_id);
            $contact->contact_type = $request->contact_type;
            $contact->contact_category_id = $request->contact_category_id;
            $contact->contact_sub_category_id = $request->contact_sub_category_id;
            $contact->status = $request->status;
            $contact->contact_name = $request->contact_name;
            $contact->contact_licence_no = $request->contact_licence_no;
            $contact->contact_trn = $request->contact_trn;
            $contact->contact_whats_app_no = $request->contact_whats_app_no;
            $contact->contact_telephone_no = $request->contact_telephone_no;
            $contact->contact_mobile_no = $request->contact_mobile_no;
            $contact->contact_website = $request->contact_website;
            $contact->state_id = $request->state_id;
            $contact->contact_address = $request->contact_address;
            $contact->payment_mode = $request->payment_mode;
            $contact->invoicing_days = $request->invoicing_days;
            $contact->payment_term = $request->payment_term;
            $contact->payment_term_days = $request->payment_term_days;
            $contact->save();
            
            // license_attachment upload
            if($request->hasFile('license_attachment')){
                if (!file_exists('../public/assets/upload/contact/license_attachment/')) {
                    mkdir('../public/assets/upload/contact/license_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['license_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["license_attachment"]["tmp_name"], '../public/assets/upload/contact/license_attachment/' . $file_name);
                $file_path = 'assets/upload/contact/license_attachment/' . $file_name;
                $contact->license_attachment ? file_exists($contact->license_attachment) ? unlink($contact->license_attachment) : "" : "";
                $contact->license_attachment = $file_path;
            }
            // vat_attachment upload
            if($request->hasFile('vat_attachment')){
                if (!file_exists('../public/assets/upload/contact/vat_attachment/')) {
                    mkdir('../public/assets/upload/contact/vat_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['vat_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["vat_attachment"]["tmp_name"], '../public/assets/upload/contact/vat_attachment/' . $file_name);
                $file_path = 'assets/upload/contact/vat_attachment/' . $file_name;
                $contact->vat_attachment ? file_exists($contact->vat_attachment) ? unlink($contact->vat_attachment) : "" : "";
                $contact->vat_attachment = $file_path;
            }
            // contract_attachment upload
            if($request->hasFile('contract_attachment')){
                if (!file_exists('../public/assets/upload/contact/contract_attachment/')) {
                    mkdir('../public/assets/upload/contact/contract_attachment/', 0777, true);
                }
                $ext = pathinfo($_FILES['contract_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["contract_attachment"]["tmp_name"], '../public/assets/upload/contact/contract_attachment/' . $file_name);
                $file_path = 'assets/upload/contact/contract_attachment/' . $file_name;
                $contact->contract_attachment ? file_exists($contact->contract_attachment) ? unlink($contact->contract_attachment) : "" : "";
                $contact->contract_attachment = $file_path;
            }
            $contact->update();
            if($request->department_name[0] !== null){
                foreach($request->department_name as $key => $value){
                    $newDepartment = new CustomerSupplierDepartment();
                    $newDepartment->customer_supplier_id = $contact->id;
                    $newDepartment->department_name = $request->department_name[$key];
                    $newDepartment->contact_method = $request->contact_method[$key];
                    $newDepartment->employee_name = $request->employee_name[$key];
                    $newDepartment->employee_designation = $request->employee_designation[$key];
                    $newDepartment->employee_contact = $request->employee_contact[$key];
                    $newDepartment->save();
                }
            }
            DB::commit();
            $message = [
                'message' => 'Customer Supplier Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerSupplier  $customerSupplier
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerSupplier $customerSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerSupplier  $customerSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerSupplier $customerSupplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerSupplier  $customerSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerSupplier $customerSupplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerSupplier  $customerSupplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerSupplier $customerSupplier)
    {
        //
    }

    public function get_company_info()
    {
        $company = Company::find(request()->company_id);
        return  $data = [
            'name' => $company->name ?? '',
            'category' => $company->license_for ?? "",
            'sub_category' => $company->license_for == 'rental' ? $company->rental_type : ""
        ];
    }
    public function get_customer_supplier_sub_category()
    {   $category_id = request()->category_id;
        $sub_categories = CustomerSupplierSubCategory::whereCustomerSupplierCategoryId($category_id)->get();
        $view = view('admin-panel.customer_suppliers.shared_blades.customer_supplier_sub_categories', compact('sub_categories'))->render();
        return response()->json(['html'=>$view]);
    }
}
