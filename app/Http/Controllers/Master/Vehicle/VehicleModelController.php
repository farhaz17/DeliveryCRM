<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleModel;

class VehicleModelController extends Controller
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
        $vehicle_models = VehicleModel::all();
        return view('admin-panel.vehicle_master.model_list', compact('vehicle_models'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-panel.vehicle_master.model_create');
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
            'name' => 'unique:vehicle_models|required'
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
            $vehicle_model = new VehicleModel();
            $vehicle_model->name = $request->name;
            $vehicle_model->save();
            $message = [
                'message' => 'Vehicle Model Added Successfully',
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
     * @param  \App\VehicleModel  $vehicle_model
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleModel $vehicle_model)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VehicleModel  $vehicle_model
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleModel $vehicle_model)
    {
        return view('admin-panel.vehicle_master.model_edit', compact('vehicle_model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VehicleModel  $vehicle_model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleModel $vehicle_model)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vehicle_models,name,'.$vehicle_model->id
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
            $vehicle_model->name = $request->name;
            $vehicle_model->update();
            $message = [
                'message' => 'Vehicle Model updated Successfully',
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
     * @param  \App\VehicleModel  $vehicle_model
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleModel $vehicle_model)
    {
        //
    }
}
