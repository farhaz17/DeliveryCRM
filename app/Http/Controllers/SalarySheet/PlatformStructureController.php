<?php

namespace App\Http\Controllers\SalarySheet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlatformStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin-panel.salary_sheet.master.platform_structure');
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

    public function company_rate()
    {
        return view('admin-panel.salary_sheet.master.company_rate');
    }
    public function rider_rate()
    {
        return view('admin-panel.salary_sheet.master.rider_rate');
    }
    public function four_pl_company_rate()
    {
        return view('admin-panel.salary_sheet.master.four_pl_company_rate');
    }
    public function four_pl_rider_rate()
    {
        return view('admin-panel.salary_sheet.master.four_pl_rider_rate');
    }
}
