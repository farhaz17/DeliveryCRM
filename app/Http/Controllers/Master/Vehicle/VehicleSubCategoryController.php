<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleCategory;
use App\Model\Master\Vehicle\VehicleSubCategory;

class VehicleSubCategoryController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|vehicle_subcategory_create', ['only' => ['index','create','store','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $vehicle_sub_categories = VehicleSubCategory::all();
        return view('admin-panel.vehicle_master.vehicle_sub_category_list', compact('vehicle_sub_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehicle_categories = VehicleCategory::all();
        return view('admin-panel.vehicle_master.vehicle_sub_category_create', compact('vehicle_categories'));
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
            'name' => 'unique:vehicle_sub_categories|required',
            'vehicle_category_id' => 'required'
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
            $VehicleSubCategory = new VehicleSubCategory();
            $VehicleSubCategory->name = $request->name;
            $VehicleSubCategory->vehicle_category_id = $request->vehicle_category_id;
            $VehicleSubCategory->save();
            $message = [
                'message' => 'Vehicle Sub Category Added Successfully',
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
     * @param  \App\VehicleSubCategory  $vehicleSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleSubCategory $vehicleSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleSubCategory  $vehicleSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleSubCategory $vehicleSubCategory)
    {

        $vehicle_categories = VehicleCategory::all();
        return view('admin-panel.vehicle_master.vehicle_sub_category_edit', compact('vehicleSubCategory','vehicle_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleSubCategory  $vehicleSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleSubCategory $vehicleSubCategory)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vehicle_sub_categories,name,' . $vehicleSubCategory->id,
            'vehicle_category_id' => 'required'
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
            $vehicleSubCategory->name = $request->name;
            $vehicleSubCategory->vehicle_category_id = $request->vehicle_category_id;
            $vehicleSubCategory->update();
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
     * @param  \App\VehicleSubCategory  $vehicleSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleSubCategory $vehicleSubCategory)
    {
        //
    }
}
