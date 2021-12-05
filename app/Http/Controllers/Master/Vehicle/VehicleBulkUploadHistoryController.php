<?php

namespace App\Http\Controllers\Master\Vehicle;

use App\Model\BikeDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Vehicle\VehicleBulkUploadHistory;

class VehicleBulkUploadHistoryController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage', ['only' => ['index','create','store','edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle_upload_histories = VehicleBulkUploadHistory::all();
        return view('admin-panel.vehicle_master.vehicle_upload_history_list', compact('vehicle_upload_histories'));
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
     * @param  \App\VehicleBulkUploadHistory  $vehicleBulkUploadHistory
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleBulkUploadHistory $vehicleBulkUploadHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleBulkUploadHistory  $vehicleBulkUploadHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleBulkUploadHistory $vehicleBulkUploadHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleBulkUploadHistory  $vehicleBulkUploadHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleBulkUploadHistory $vehicleBulkUploadHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleBulkUploadHistory  $vehicleBulkUploadHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleBulkUploadHistory $vehicleBulkUploadHistory)
    {
        //
    }

    public function get_ajax_vehicle_upload_history(Request $request)
    {
        $get_uploaded_vehicles = VehicleBulkUploadHistory::find($request->upload_history_id)->get_uploaded_vehicles();
        $view = view('admin-panel.vehicle_master.shared_blades.get_uploaded_vehicles', compact('get_uploaded_vehicles'))->render();
        return response()->json(['html' => $view]);
    }
}
