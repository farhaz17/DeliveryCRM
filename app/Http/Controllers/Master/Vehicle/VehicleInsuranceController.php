<?php

namespace App\Http\Controllers\Master\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Model\Master\Vehicle\VehicleInsurance;
use App\Model\Vehicle\InsuranceNetworkType;

class VehicleInsuranceController extends Controller
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
        $insurances = VehicleInsurance::all();
        return view('admin-panel.vehicle_master.insurance__list', compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $insurance_company=VehicleInsurance::all();
        return view('admin-panel.vehicle_master.insurance_create', compact('data','insurance_company'));
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
            'name' => 'unique:vehicle_insurances|required'
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
            $vehicle_insurance = new VehicleInsurance();
            $vehicle_insurance->name = $request->name;
            $vehicle_insurance->type = $request->type;
            $vehicle_insurance->save();
            $message = [
                'message' => 'Tracking Inventory Added Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleInsurance  $vehicle_insurance
     * @return \Illuminate\Http\Response
     */
    public function show(VehicleInsurance $vehicle_insurance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Vehicle\VehicleInsurance  $vehicle_insurance
     * @return \Illuminate\Http\Response
     */
    public function edit(VehicleInsurance $vehicle_insurance)
    {
        return view('admin-panel.vehicle_master.insurance_edit', compact('vehicle_insurance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Vehicle\VehicleInsurance  $vehicle_insurance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VehicleInsurance $vehicle_insurance)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:vehicle_insurances|required'
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
            $vehicle_insurance->name = $request->name;
            $vehicle_insurance->type = $request->type;
            $vehicle_insurance->update();
            $message = [
                'message' => 'Vahicle Insurance Updated Successfully',
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
     * @param  \App\Model\Master\Vehicle\VehicleInsurance  $vehicle_insurance
     * @return \Illuminate\Http\Response
     */
    public function destroy(VehicleInsurance $vehicle_insurance)
    {
        //
    }


    public function insurance_network_type_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'insurance_company' => 'required',
            'network_type' => 'required'
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
            $vehicle_insurance = new InsuranceNetworkType();
            $vehicle_insurance->insurance_company = $request->insurance_company;
            $vehicle_insurance->network_type = $request->network_type;
            $vehicle_insurance->added_by = auth()->user()->id;
            $vehicle_insurance->save();
            $message = [
                'message' => 'Insurance Network Type Added Successfully',
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


    public function get_nested_network_data(Request $request){
        // dd($request->all());
        $network=InsuranceNetworkType::where('insurance_company',$request->id)->get();

        $view = view("admin-panel.vehicle_master.ajax_insurance_network_type", compact('network'))->render();
        return response()->json(['html' => $view]);
    }
}
