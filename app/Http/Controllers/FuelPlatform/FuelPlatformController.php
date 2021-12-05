<?php

namespace App\Http\Controllers\FuelPlatform;

use App\Model\Cities;
use App\Model\Platform;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Model\FuelPlatform\FuelPlatform;
use Illuminate\Support\Facades\Validator;

class FuelPlatformController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|rider-fuel-platform', ['only' => ['index']]);
        $this->middleware('role_or_permission:Admin|rider-fuel-platform-add', ['only' => ['create','edit','update','store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fuelplatforms = FuelPlatform::all();
        foreach($fuelplatforms as $fuelplatform){
            $fuelplatform->cities = Cities::whereIn('id', json_decode($fuelplatform->cities_ids))->get();
        }
        return view('admin-panel.fuel_platform.index', compact('fuelplatforms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = Cities::all();
        $platforms  = Platform::all();
        return view('admin-panel.fuel_platform.create', compact('cities','platforms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $validator = Validator::make($request->all(), [
                'platform_id' => [
                'required',
                Rule::unique('fuel_platforms')->where(function ($query) {
                    return $query->whereNull('checkout');
                }),
                ],
                'cities_ids' => 'required',
                'status' => 'required',
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' =>  $validate->first(), //'Part number is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }
            $obj=new FuelPlatform();
            $obj->platform_id=$request->platform_id;
            $obj->status=$request->status;
            $obj->cities_ids = json_encode($request->cities_ids);
            $obj->checkin = date('Y-m-d').'T'.date('H:i');
            $obj->save();
            $message = [
                'message' => 'Fuel Platform Added Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => $e->getMessage(), //'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FuelPlatform  $fuelPlatform
     * @return \Illuminate\Http\Response
     */
    public function show(FuelPlatform $fuelPlatform)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FuelPlatform  $fuelPlatform
     * @return \Illuminate\Http\Response
     */
    public function edit(FuelPlatform $fuelPlatform)
    {
        $cities = Cities::all();
        $platforms  = Platform::all();
        return view('admin-panel.fuel_platform.edit', compact('cities','platforms','fuelPlatform'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FuelPlatform  $fuelPlatform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FuelPlatform $fuelPlatform)
    {
        try{

            $validator = Validator::make($request->all(), [
                'cities_ids' => 'required',
                'status' => 'required',
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' =>  $validate->first(), //'Part number is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }
            if($fuelPlatform->status != $request->status){
                $fuelPlatform->status = $request->status;
                $fuelPlatform->checkout= date('Y-m-d').'T'.date('H:i');
            }
            if($fuelPlatform->cities_ids != json_encode($request->cities_ids)){
                $fuelPlatform->cities_ids = json_encode($request->cities_ids);
            }
            $fuelPlatform->cities_ids = json_encode($request->cities_ids);
            $fuelPlatform->update();
            $message = [
                'message' => 'Fuel Platform Updated Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('fuel_platform.index')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => $e->getMessage(), //'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FuelPlatform  $fuelPlatform
     * @return \Illuminate\Http\Response
     */
    public function destroy(FuelPlatform $fuelPlatform)
    {
        //
    }
}
