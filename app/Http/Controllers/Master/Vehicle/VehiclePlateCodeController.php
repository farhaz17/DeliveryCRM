<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Vehicle\VehiclePlateCode;
use Illuminate\Support\Facades\Validator;

class VehiclePlateCodeController extends Controller
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
        $vehicle_plate_codes = VehiclePlateCode::all();
        return view('admin-panel.vehicle_master.plate_code_list', compact('vehicle_plate_codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin-panel.vehicle_master.plate_code_create', compact('data'));
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
            'plate_code' => 'unique:vehicle_plate_codes|required'
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
            $vehicle_plate_code = new VehiclePlateCode();
            $vehicle_plate_code->plate_code = $request->plate_code;
            $vehicle_plate_code->save();
            $message = [
                'message' => 'Plate Code Added Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehiclePlateCode  $vehicle_plate_code
     * @return \Illuminate\Http\Response
     */
    public function show(VehiclePlateCode $vehicle_plate_code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\VehiclePlateCode  $vehicle_plate_code
     * @return \Illuminate\Http\Response
     */
    public function edit(VehiclePlateCode $vehicle_plate_code)
    {
        return view('admin-panel.vehicle_master.plate_code_edit', compact('vehicle_plate_code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Vehicle\VehiclePlateCode  $vehicle_plate_code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehiclePlateCode $vehicle_plate_code)
    {
        $validator = Validator::make($request->all(), [
            'plate_code' => 'required|unique:vehicle_plate_codes,plate_code,'.$vehicle_plate_code->id,
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
            $vehicle_plate_code->plate_code = $request->plate_code;
            $vehicle_plate_code->update();
            $message = [
                'message' => 'Plate Code updated Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehiclePlateCode  $vehicle_plate_code
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehiclePlateCode $vehicle_plate_code)
    {
        //
    }
}
