<?php

namespace App\Http\Controllers\Master\CustomerSupplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\CustomerSupplier\CustomerSupplierCategory;
use App\Model\Master\CustomerSupplier\CustomerSupplierSubCategory;

class CustomerSupplierSubCategoryController extends Controller
{
    
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|CustomerSupplierManager', ['only' => ['index','create','store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customerSupplierSubCategory = CustomerSupplierSubCategory::with('parent_category')->get();
        return view('admin-panel.customer_suppliers.customer_supplier_sub_category_list', compact('customerSupplierSubCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CustomerSupplierCategory::all();
        return view('admin-panel.customer_suppliers.customer_supplier_sub_category_create', compact('categories'));
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
            'name' => 'unique:customer_supplier_sub_categories|required'
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
            $customer_supplier_category = new CustomerSupplierSubCategory();
            $customer_supplier_category->customer_supplier_category_id = $request->customer_supplier_category_id;
            $customer_supplier_category->name = $request->name;
            $customer_supplier_category->save();

            $message = [
                'message' => 'Customer Supplier Sub Category Added Successfully',
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
     * @param  \App\CustomerSupplierSubCategory  $customerSupplierSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerSupplierSubCategory $customerSupplierSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerSupplierSubCategory  $customerSupplierSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerSupplierSubCategory $customerSupplierSubCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerSupplierSubCategory  $customerSupplierSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerSupplierSubCategory $customerSupplierSubCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerSupplierSubCategory  $customerSupplierSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerSupplierSubCategory $customerSupplierSubCategory)
    {
        //
    }
}
