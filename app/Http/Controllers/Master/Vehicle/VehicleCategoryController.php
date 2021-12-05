<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Vehicle\VehicleCategory;
use Illuminate\Support\Facades\Validator;

class VehicleCategoryController extends Controller
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
        $vehicle_categories = VehicleCategory::all();
        return view('admin-panel.vehicle_master.vehicle_category_list', compact('vehicle_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.vehicle_master.vehicle_category_create');
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
            'name' => 'unique:vehicle_categories|required'
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
            $VehicleCategory = new VehicleCategory();
            $VehicleCategory->name = $request->name;
            $VehicleCategory->save();
            $message = [
                'message' => 'Vehicle Category Added Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleCategory  $vehicleCategory
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleCategory $vehicleCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\VehicleCategory  $vehicleCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleCategory $vehicleCategory)
    {
        return view('admin-panel.vehicle_master.vehicle_category_edit', compact('vehicleCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Vehicle\VehicleCategory  $vehicleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleCategory $vehicleCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vehicle_categories,name,' . $vehicleCategory->id,
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
            $vehicleCategory->name = $request->name;
            $vehicleCategory->update();
            $message = [
                'message' => 'Vehicle Category Updated Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleCategory  $vehicleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleCategory $vehicleCategory)
    {
        //
    }
}
