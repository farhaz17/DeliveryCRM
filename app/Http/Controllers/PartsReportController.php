<?php

namespace App\Http\Controllers;

use App\Model\InvParts;
use App\Model\Manage_bike_invoice;
use App\Model\Parts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartsReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $parts=Parts::all();

//        dd($parts);
        return view('admin-panel.pages.parts_report',compact('parts'));
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
    public function show(Request $request)
    {
        $part_name= $request->get('part_name');
        $date=$request->get('search_date');

        $parts=Parts::all();
        $result = DB::table('parts')->whereDate('created_at',$date)->Where('part_name',$part_name)->get();
        $result_show=parts::all();
//        dd($result);
        return view('admin-panel.pages.parts_report',compact('result','result_show','parts'));
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
