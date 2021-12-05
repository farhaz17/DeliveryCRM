<?php

namespace App\Http\Controllers\BikeAssignPlatform;

use App\Model\Assign\AssignBike;
use App\Model\BikeAssignPlatform\bike_assing_platforms;
use App\Model\BikeDetail;
use App\Model\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BikeAssignPlatformController extends Controller
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
            $platforms = Platform::where('id','=',7)->get();
            $assign_bike = AssignBike::where('status','=','1')->select('bike')->groupby('bike')->pluck('bike')->toArray();

           $bikes = BikeDetail::whereNotIn('id',$assign_bike)->get();

        return view('admin-panel.bike_assign_platform.create',compact('platforms','bikes'));
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
            'platform_id' => 'required',
            'bike_id' => 'required',
            'checkin' => 'required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => 'df'
            ];
            return redirect()->back()->with($message);
        }

        foreach($request->bike_id as $bike){
             $bike_assign = new bike_assing_platforms();
            $bike_assign->bike_id = $bike;
            $bike_assign->platform_id = $request->platform_id;
            $bike_assign->platform_id = $request->platform_id;
            $bike_assign->status = "1";
            $bike_assign->checkin = $request->checkin;
            $bike_assign->remarks = $request->remarks;
            $bike_assign->save();

             BikeDetail::where('id','=',$bike)->update(['status'=>'1']);
        }

        $message = [
            'message' => "Bikes Assigned Successfully",
            'alert-type' => 'success',
            'error' => 'df'
        ];
        return redirect()->back()->with($message);

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

        $validator = Validator::make($request->all(), [
            'platform_id_checkout' => 'required',
            'bike_id_checkout' => 'required',
            'checkin_checkout' => 'required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => 'df'
            ];
            return redirect()->back()->with($message);
        }

        foreach($request->bike_id_checkout as $gamer){

             $assign_bike = bike_assing_platforms::find($gamer);
             $bike_number_id = $assign_bike->bike_detail->id;
            $assign_bike->status = "0";
            $assign_bike->checkout = $request->checkin_checkout;
            $assign_bike->checkout_remarks = $request->remarks_checkout;
            $assign_bike->update();

            BikeDetail::where('id','=',$bike_number_id)->update(['status'=>'0']);

        }

        $message = [
            'message' => "Bikes Checkout Successfully",
            'alert-type' => 'success',
            'error' => 'df'
        ];
        return redirect()->back()->with($message);


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

    public function ajax_get_bikes_checkin_by_platform(Request $request){

        if($request->ajax()){

            $platform_id = $request->platform_id;

            $bikes = bike_assing_platforms::where('platform_id','=',$platform_id)->where('status','=','1')->get();

            $array_to_send = array();

            foreach($bikes as $bike){

                $gamer = array(
                  'bike_number' => $bike->bike_detail->plate_no,
                  'id' => $bike->id
                );

                $array_to_send [] = $gamer;
            }


            echo json_encode($array_to_send);

            exit;

        }

    }
}
