<?php

namespace App\Http\Controllers\Assign;

use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //



        $passport = Passport::with(array('bike_assign' => function($query){
            $query->where('status', '=', 1)->with('bike_plate_number');
        }))->with(array('sim_assign' => function($query){
            $query->where('status', '=', 1)->with('telecome');
        }))->with(array('platform_assign' => function($query){
            $query->where('status', '=', 1)->with('plateformdetail');
        }))->get();


        return view('admin-panel.assigning.assign_report.all_assign_report',compact('passport'));


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
