<?php

namespace App\Http\Controllers;

use App\Bike;
use App\Model\ManageRepair;
use Illuminate\Http\Request;

class ReportsBikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bikes=Bike::all();
        return view('admin-panel.reports.report_bike_usage',compact('bikes'));
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
//        $id = $request->input('plate_id');
//        $start = $request->input('start-date');
//        $end = $request->input('end-date');
//        $query=$this->getRepairBikes($id,$start,$end);
//        dd($query);
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

    public function showBikes(Request $request)
    {
        $id = $request->input('plate_id');
        $start = $request->input('start-date');
        $end = $request->input('end-date');
        $query=$this->getRepairBikes($id,$start,$end);
        $bikes=Bike::all();

//        dd($query);
        return view('admin-panel.reports.report_bike_usage',compact('query','bikes'));

    }

    public function getRepairBikes($id,$start,$end){
        $start = $start;
        $end = $end;

        $data=ManageRepair::where('chassis_no',$id)->whereBetween('created_at',[$start, $end])
            ->with('bike')
            ->with('repairParts')
            ->get();
        return $data;
    }
}
