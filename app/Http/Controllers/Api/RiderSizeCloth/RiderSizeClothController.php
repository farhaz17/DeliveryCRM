<?php

namespace App\Http\Controllers\Api\RiderSizeCloth;

use App\Model\Guest\Career;
use App\Model\RiderClothSize\RiderClothSize;
use App\Model\RiderProfile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RiderSizeClothController extends Controller
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

//        try {
            $user_id = Auth::user()->id;
            $rider = RiderProfile::where('user_id', '=', $user_id)->first();

            $validator = Validator::make($request->all(), [
                'shirt_size' => 'required',
                'jeans_size' => 'required',
                'helmet_size' => 'required',
            ]);
            if ($validator->fails()) {
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $size = RiderClothSize::where('passport_id', '=', $rider->passport_id)->first();

            if ($size == null) {
                $cloth_size = new RiderClothSize();

                $cloth_size->shirt_size = $request->shirt_size;
                $cloth_size->trouser_size = $request->jeans_size;
                $cloth_size->helmet_size = $request->helmet_size;
                $cloth_size->passport_id = $rider->passport_id;
                $cloth_size->save();

                Career::where('passport_no','=',$rider->passport->passport_no)->update(['action_rider'=>'1']);

                $response['code'] = 1;
                $response['message'] = "Submit successfully";
                return response()->json($response);

            } else {

                $response['code'] = 2;
                $response['message'] = "Size Already Submitted";
                return response()->json($response);

            }
//        } catch (\Illuminate\Database\QueryException $e) {
//            $response['code'] = 2;
//            $response['message'] = 'Submission Failed';
//
//            return response()->json($response);
//        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
