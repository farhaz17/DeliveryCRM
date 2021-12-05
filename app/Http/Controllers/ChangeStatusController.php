<?php

namespace App\Http\Controllers;

use App\Model\Change_status;
use Illuminate\Http\Request;

class ChangeStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result=Change_status::all();
        return view('admin-panel.masters.change_status',compact('result'));
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
        $obj = new Change_status();
        $obj->new_file_number = $request->input('new_file_number');
        $obj->previous_file_number = $request->input('previous_file_number');
        $obj->uid_no = $request->input('uid_no');
        $obj->submission_date = $request->input('submission_date');
        $obj->approval_date = $request->input('approval_date');
        $obj->name = $request->input('name');
        $obj->nationality = $request->input('nationality');
        $obj->passport_number = $request->input('passport_number');
        $obj->profession_visa = $request->input('profession_visa');
        $obj->profession_working = $request->input('profession_working');
        $obj->company_visa = $request->input('company_visa');
        $obj->company_working = $request->input('company_working');
        $obj->sponser_name = $request->input('sponser_name');
        $obj->note = $request->input('note');
        $obj->save();
        $message = [
            'message' => 'Added Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->route('e_visa')->with($message);
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
