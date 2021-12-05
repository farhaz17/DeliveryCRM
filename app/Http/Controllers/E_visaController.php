<?php

namespace App\Http\Controllers;

use App\Model\E_visa;
use App\Model\Eid_registration;
use App\Model\Work_permit;
use Illuminate\Http\Request;

class E_visaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result=E_visa::all();
        return view('admin-panel.masters.e-visa',compact('result'));
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
        $obj = new E_visa();
        $obj->employment = $request->input('employment');
        $obj->entry_permit_number = $request->input('entry_permit_number');
        $obj->date_of_issue = $request->input('date_of_issue');
        $obj->place_of_issue = $request->input('place_of_issue');
        $obj->valid_until = $request->input('valid_until');
        $obj->uid_no = $request->input('uid_no');
        $obj->full_name = $request->input('full_name');
        $obj->nationality = $request->input('nationality');
        $obj->place_of_birth = $request->input('place_of_birth');
        $obj->passport_number = $request->input('passport_number');
        $obj->profession = $request->input('profession');
        $obj->sponser_name = $request->input('sponser_name');
        $obj->entry_date = $request->input('entry_date');
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
