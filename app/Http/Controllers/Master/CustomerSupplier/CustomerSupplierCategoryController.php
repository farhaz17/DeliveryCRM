<?php

namespace App\Http\Controllers\Master\CustomerSupplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\CustomerSupplier\CustomerSupplierCategory;
use App\Model\Master\CustomerSupplier\CustomerSupplierSubCategory;

class CustomerSupplierCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|CustomerSupplierManager', ['only' => ['index','create','store','edit','update']]);

    }
    public function index()
    {
        $customerSupplierCategory = CustomerSupplierCategory::all();
        return view('admin-panel.customer_suppliers.customer_supplier_category_list', compact('customerSupplierCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customerSupplierCategory = CustomerSupplierCategory::all();
        $customerSupplierSubCategory = CustomerSupplierSubCategory::all();
        return view('admin-panel.customer_suppliers.customer_supplier_category_create', compact('customerSupplierCategory','customerSupplierSubCategory'));
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
            'name' => 'unique:customer_supplier_categories|required'
        ]);
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
            $customer_supplier_category = new CustomerSupplierCategory();
            $customer_supplier_category->name = $request->name;
            $customer_supplier_category->save();

            $message = [
                'message' => 'Customer Supplier Category Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
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
     * @param  \App\CustomerSupplierCategory  $customerSupplierCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerSupplierCategory $customerSupplierCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerSupplierCategory  $customerSupplierCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerSupplierCategory $customerSupplierCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerSupplierCategory  $customerSupplierCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerSupplierCategory $customerSupplierCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerSupplierCategory  $customerSupplierCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerSupplierCategory $customerSupplierCategory)
    {
        //
    }
}
