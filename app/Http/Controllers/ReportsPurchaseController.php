<?php

namespace App\Http\Controllers;

use App\Model\Bike_invoice;
use App\Model\Manage_bike_purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bike_inv=Bike_invoice::all();
//        return view('admin-panel.reports.purchase_report',compact('bikes'));
        return view('admin-panel.reports.purchase_report',compact('bike_inv'));
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
        //

        $vendor_name = $request->input('vendor_name');
        $invoice_number = $request->input('invoice_number');

//get values here
        $query= DB::table('bike_invoices')->where('vendor_name',$vendor_name)->where('invoice_number',$invoice_number)->get();
        $bike_inv=Bike_invoice::all();


        return view('admin-panel.reports.purchase_report',compact('query','bike_inv'));
    }



    public function showReport(Request $request)
    {

        $start = $request->input('start-date');
        $end = $request->input('end-date');


        $query= DB::table('bike_invoices')->whereBetween('created_at',[$start, $end])->get();
        $bike_inv=Bike_invoice::all();
        $query1= DB::table('manage_bike_purchases')->get();

        return view('admin-panel.reports.purchase_report',compact('query','bike_inv','query1'));

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


    public function showDetail()
    {

        $query1= DB::table('manage_bike_purchases')->get();

        return view('admin-panel.reports.purchase_report',compact('query1'));

    }
}
