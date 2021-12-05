<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleMortgage;
use App\Model\Master\Vehicle\VehicleSalikTag;

class VehicleSalikTagController extends Controller
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
        $vehicle_salik_tags = VehicleSalikTag::all();
        return view('admin-panel.vehicle_master.salik_tag_list', compact('vehicle_salik_tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin-panel.vehicle_master.salik_tag_create', compact('data'));
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
            'tag_no' => 'unique:vehicle_salik_tags|required'
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
            $vehicle_salik_tags = new VehicleSalikTag();
            $vehicle_salik_tags->tag_no = $request->tag_no;
            $vehicle_salik_tags->save();
            $message = [
                'message' => 'Salik Tag Added Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleSalikTag  $vehicle_salik_tag
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleSalikTag $vehicle_salik_tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\VehicleSalikTag  $vehicle_salik_tag
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleSalikTag $vehicle_salik_tag)
    {
        return view('admin-panel.vehicle_master.salik_tag_edit', compact('vehicle_salik_tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Vehicle\VehicleSalikTag  $vehicle_salik_tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleSalikTag $vehicle_salik_tag)
    {
        // return $vehicle_salik_tag;
        $validator = Validator::make($request->all(), [
            'tag_no' => 'required|unique:vehicle_salik_tags,tag_no,'.$vehicle_salik_tag->id,
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
            $vehicle_salik_tag->tag_no = $request->tag_no;
            $vehicle_salik_tag->update();
            $message = [
                'message' => 'Salik Tag Updated Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleSalikTag  $vehicle_salik_tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleSalikTag $vehicle_salik_tag)
    {
        //
    }
}
