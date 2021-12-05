<?php

namespace App\Http\Controllers;

use App\Model\Eid_registration;
use Illuminate\Http\Request;

class EidRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result=Eid_registration::all();
        return view('admin-panel.masters.emirates_id',compact('result'));
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
        $obj = new Eid_registration();
        $obj->id_number = $request->input('id_number');
        $obj->name = $request->input('name');
        $obj->nationality = $request->input('nationality');
        $obj->date_of_birth = $request->input('date_of_birth');
        $obj->card_number = $request->input('card_number');
        $obj->expiry_date = $request->input('expiry_date');
        $obj->receipt_no = $request->input('receipt_no');
        $obj->app_no = $request->input('app_no');
        $obj->registered_mob_no = $request->input('registered_mob_no');
        $obj->emirates_id = $request->input('emirates_id');
        $obj->residency_no = $request->input('residency_no');
        $obj->uid_no = $request->input('uid_no');

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
