<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Vehicle\VehicleYear;
use Illuminate\Support\Facades\Validator;

class VehicleYearController extends Controller
{    
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicle_years = VehicleYear::all();
        return view('admin-panel.vehicle_master.vehicle_year_list', compact('vehicle_years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.vehicle_master.vehicle_year_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'unique:vehicle_years|required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {        
            $vehicle_year = new VehicleYear();
            $vehicle_year->year = $request->year;
            $vehicle_year->save();

            $message = [
                'message' => 'Vehicle make Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VehicleYear  $vehicleYear
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleYear $vehicleYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleYear  $vehicleYear
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleYear $vehicleYear)
    {
        return view('admin-panel.vehicle_master.vehicle_year_edit', compact('vehicleYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleYear  $vehicleYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleYear $vehicleYear)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|unique:vehicle_years,year,'.$vehicleYear->id,
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {        
            $vehicleYear->year = $request->year;
            $vehicleYear->update();
            $message = [
                'message' => 'Vehicle Updated Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VehicleYear  $vehicleYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleYear $vehicleYear)
    {
        //
    }
}
