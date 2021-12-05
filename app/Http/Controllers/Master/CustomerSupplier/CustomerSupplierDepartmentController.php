<?php

namespace App\Http\Controllers\Master\CustomerSupplier;

use App\CustomerSupplierDepartment;
use Illuminate\Http\Request;

class CustomerSupplierDepartmentController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|CustomerSupplierManager', ['only' => ['index','create','store','edit','update']]);
    }
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerSupplierDepartment  $customerSupplierDepartment
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerSupplierDepartment $customerSupplierDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerSupplierDepartment  $customerSupplierDepartment
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerSupplierDepartment $customerSupplierDepartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerSupplierDepartment  $customerSupplierDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerSupplierDepartment $customerSupplierDepartment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerSupplierDepartment  $customerSupplierDepartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerSupplierDepartment $customerSupplierDepartment)
    {
        //
    }
}
