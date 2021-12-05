<?php

namespace App\Http\Controllers\Api\Guest;

use App\CareerRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CareerRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile_no' => 'required|unique:career_requests',
            'whatsapp_no' => 'required|unique:career_requests',
            'email_address' => 'email|nullable|unique:career_requests',
            'passport_no' => 'unique:career_requests|nullable',
            'license_no' => 'nullable|unique:career_requests',
        ],
        $messages = [
            'name.required' => "Please Enter your name",
            'mobile_no.required' => "Please Enter your mobile No",
            'whatsapp_no.required' => "Please Enter your whatsapp No"
            ]
        );
        if($request->passport_status == 1){
            $validator = Validator::make($request->all(),
                ["passport_no" => "required"], $messages =
                ["passport_no.required" => "Please Enter Passport No"]
            );
        }else if($request->uae_license_status == 1){
            $validator = Validator::make($request->all(),
                ["license_no" => "required"], $messages =
                ["license_no.required" => "Please Enter License No"]
            );
        }
        if($validator->fails()){
            $response['code'] = 2;
            $response['message'] = $validator->errors()->first();
            return response()->json($response);
        }
        try {
            $obj = new CareerRequest();
            $obj->country_name = $request->country_name;
            $obj->city_name = $request->city_name;
            $obj->name = $request->name;
            $obj->mobile_no = $request->mobile_no;
            $obj->whatsapp_no = $request->whatsapp_no;
            $obj->email_address = $request->email_address;
            $obj->passport_status = $request->passport_status;
            $obj->passport_no =  $request->passport_no;
            $obj->pak_license_status = $request->pak_license_status;
            $obj->uae_license_status = $request->uae_license_status;
            $obj->license_no = $request->license_no;
            $obj->save();

            $response['code'] = 1;
            $response['message'] = "Submission Successful~";
            return response()->json($response);

        }catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 3;
            $response['message'] = $e->getMessage();

            return response()->json($response);
        }
     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CareerRequest  $careerRequest
     * @return \Illuminate\Http\Response
     */
    public function show(CareerRequest $careerRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CareerRequest  $careerRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(CareerRequest $careerRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CareerRequest  $careerRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CareerRequest $careerRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CareerRequest  $careerRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(CareerRequest $careerRequest)
    {
        //
    }
}
