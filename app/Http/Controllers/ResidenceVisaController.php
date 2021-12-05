<?php

namespace App\Http\Controllers;

use App\Model\Residence_visa;
use Illuminate\Http\Request;

class ResidenceVisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result=Residence_visa::all();
        return view('admin-panel.masters.residence_visa',compact('result'));
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
        $obj = new Residence_visa();
        $obj->uid_no = $request->input('uid_no');
        $obj->file_no = $request->input('file_no');
        $obj->passport_no = $request->input('passport_no');
        $obj->name = $request->input('name');
        $obj->profession_visa = $request->input('profession_visa');
        $obj->profession_working = $request->input('profession_working');
        $obj->company_visa = $request->input('company_visa');
        $obj->company_working = $request->input('company_working');
        $obj->work_permit_no = $request->input('work_permit_no');
        $obj->place_of_issue = $request->input('place_of_issue');
        $obj->issue_date = $request->input('issue_date');
        $obj->expiry_date = $request->input('expiry_date');
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
