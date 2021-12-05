<?php

namespace App\Http\Controllers;

use App\Model\Medical_info;
use Illuminate\Http\Request;

class MedicalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result=Medical_info::all();
        return view('admin-panel.masters.medical_information',compact('result'));
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

        $obj = new Medical_info();
        $obj->app_id_number = $request->input('app_id_number');
        $obj->medical_date = $request->input('medical_date');
        $obj->name = $request->input('name');
        $obj->urgency_type = $request->input('urgency_type');
        $obj->medical_center = $request->input('medical_center');
        $obj->passport_number = $request->input('passport_number');
        $obj->emirates_id = $request->input('emirates_id');
        $obj->email = $request->input('email');
        $obj->sponser_name = $request->input('sponser_name');
        $obj->passport_number = $request->input('passport_number');
        $obj->residency_number = $request->input('residency_number');
        $obj->medical_status = $request->input('medical_status');

        $obj->save();
        $message = [
            'message' => 'Added Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->route('medical_info')->with($message);
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
