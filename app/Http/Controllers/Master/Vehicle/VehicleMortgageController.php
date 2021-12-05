<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleMortgage;

class VehicleMortgageController extends Controller
{    
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|vehicle_make_create', ['only' => ['index','create','store','edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mortgages = VehicleMortgage::all();
        return view('admin-panel.vehicle_master.mortgage_list', compact('mortgages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin-panel.vehicle_master.mortgage_create', compact('data'));
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
            'name' => 'unique:vehicle_mortgages|required'
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
            $vehicle_mortgage = new VehicleMortgage();
            $vehicle_mortgage->name = $request->name;
            $vehicle_mortgage->save();
            $message = [
                'message' => 'Vehicle Mortgage Added Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleMortgage  $vehicle_mortgage
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleMortgage $vehicle_mortgage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\VehicleMortgage  $vehicle_mortgage
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleMortgage $vehicle_mortgage)
    {
        return view('admin-panel.vehicle_master.mortgage_edit', compact('vehicle_mortgage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Vehicle\VehicleMortgage  $vehicle_mortgage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleMortgage $vehicle_mortgage)
    {
        
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:vehicle_mortgages,name,'.$vehicle_mortgage->id
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
            $vehicle_mortgage->name = $request->name;
            $vehicle_mortgage->update();
            $message = [
                'message' => 'Vehicle Mortgage Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleMortgage  $vehicle_mortgage
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleMortgage $vehicle_mortgage)
    {
        //
    }
}
