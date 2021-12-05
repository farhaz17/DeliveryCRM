<?php

namespace App\Http\Controllers;

use App\Model\Labour_approval;
use Illuminate\Http\Request;

class LabourApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result=Labour_approval::all();
        return view('admin-panel.masters.labour_approval_app',compact('result'));
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
        $obj = new Labour_approval();
        $obj->app_number = $request->input('app_number');
        $obj->company_name = $request->input('company_name');
        $obj->name = $request->input('name');
        $obj->nationality = $request->input('nationality');
        $obj->labour_personal_no = $request->input('labour_personal_no');
        $obj->passport_number = $request->input('passport_number');
        $obj->offer_latter = $request->input('offer_latter');
        $obj->work_permit_no = $request->input('work_permit_no');
        $obj->issue_date = $request->input('issue_date');
        $obj->expiry_date = $request->input('expiry_date');
        $obj->profession_visa = $request->input('profession_visa');
        $obj->profession_working = $request->input('profession_working');
        $obj->company_visa = $request->input('company_visa');
        $obj->company_working = $request->input('company_working');
        $obj->save();
        $message = [
            'message' => 'Added Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->route('labour_approval')->with($message);
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
}
