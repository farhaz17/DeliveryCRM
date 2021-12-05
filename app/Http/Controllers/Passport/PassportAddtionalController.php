<?php

namespace App\Http\Controllers\Passport;

use App\Model\Nationality;
use App\Model\Passport\PassportAdditional;
use App\Model\Types;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PassportAddtionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nation=Nationality::all();
        $types=Types::all();
        return view('admin-panel.passport.passport_addtional',compact('nation','types'));

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

        $obj = new PassportAdditional();

        $obj->nation_id = $request->input('nation_id');
        $obj->additional_name = $request->input('additional_name');
        $obj->additional_name_field = $request->input('additional_name_field');
        $obj->type_id = $request->input('type_id');
        $obj->placeholder = $request->input('placeholder');
        $obj->save();
        $message = [
            'message' => 'Additinal Field Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('addtional_passport')->with($message);
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
