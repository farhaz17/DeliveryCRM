<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Vehicle\VehicleMake;
use Illuminate\Support\Facades\Validator;

class VehicleMakeController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|RTAManage', ['only' => ['index','create','store','edit','update']]);
    }
    public function index()
    {
        $makes = VehicleMake::all();
        return view('admin-panel.vehicle_master.vehicle_make_list', compact('makes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.vehicle_master.vehicle_make_create');
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
            'name' => 'unique:vehicle_makes|required'
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
            $vehicle_make = new VehicleMake();
            $vehicle_make->name = $request->name;
            $vehicle_make->save();

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
     * @param  \App\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleMake $vehicleMake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleMake $vehicleMake)
    {
        return view('admin-panel.vehicle_master.vehicle_make_edit', compact('vehicleMake'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleMake $vehicleMake)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vehicle_makes,name,'.$vehicleMake->id
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
            $vehicleMake->name = $request->name;
            $vehicleMake->update();
            $message = [
                'message' => 'Vehicle Make updated Successfully',
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
     * @param  \App\VehicleMake  $vehicleMake
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleMake $vehicleMake)
    {
        //
    }
}
