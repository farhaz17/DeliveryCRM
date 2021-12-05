<?php

namespace App\Http\Controllers\OwnSimBike;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\OwnSimBikeHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OwnSimBikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $bike_sim_history =  OwnSimBikeHistory::where('status','=','1')->orderby('id','desc')->get();
        $own_type_array = array('','Sim','Bike');

        return view('admin-panel.own_bike_sim.index',compact('bike_sim_history','own_type_array'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin-panel.own_bike_sim.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(empty($request->passport_id_selected_checkout_input)){

            $message = [
                'message' => "Please select rider",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);

        }
        if(!isset($request->rider_sim) && !isset($request->rider_bike)){

            $message = [
                'message' => "please check at lease one checkbox",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }
        $checkin_two_check = false;
        if(isset($request->rider_sim) && isset($request->rider_bike)){
            $checkin_two_check = true;
        }
        $sim_done = false;
        $sim_error = false;

        $passport_id_selected = $request->passport_id_selected_checkout_input;

        $assigned_id = AssignPlateform::where('passport_id',$passport_id_selected)->where('status','=','1')->first();

        $current_platform_id = "";

        if($assigned_id == null){

            $message = [
                'message' => "Platform is not assigned",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }else{
            $current_platform_id =   $assigned_id->plateform;
        }
        if(isset($request->rider_sim)){
            $assign_sim = AssignSim::where('passport_id',$passport_id_selected)->where('status','=','1')->first();
            $sim_already_own = OwnSimBikeHistory::where('passport_id',$passport_id_selected)->where('own_type','=','1')->where('status','=','1')->first();

            if($assign_sim != null || $sim_already_own != null){

                $sim_done = false;
                $sim_error = true;

            }else{
                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "1";
                $own_bike_sim_obj->platform_id = $current_platform_id;
                $own_bike_sim_obj->passport_id = $passport_id_selected;
                $own_bike_sim_obj->checkin = $request->checkin;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();

                $sim_done = true;
            }
        }

        if(isset($request->rider_bike)){
            $assign_bike = AssignBike::where('passport_id',$passport_id_selected)->where('status','=','1')->first();
            $bike_already_own = OwnSimBikeHistory::where('passport_id',$passport_id_selected)->where('own_type','=','2')->where('status','=','1')->first();
            if($assign_bike != null || $bike_already_own != null){
                if($sim_done){
                    $message = [
                        'message' => "Sim own is done successfully, But bike is already assigned to this Rider",
                        'alert-type' => 'success',
                        'error' => ''
                    ];
                    return redirect()->back()->with($message);

                }else{
                    $message = [
                        'message' => "Bike  and sim  is already assigned",
                        'alert-type' => 'error',
                        'error' => ''
                    ];
                    return redirect()->back()->with($message);
                }

            }else{

                $own_bike_sim_obj = new OwnSimBikeHistory();
                $own_bike_sim_obj->own_type = "2";
                $own_bike_sim_obj->platform_id = $current_platform_id;
                $own_bike_sim_obj->passport_id = $passport_id_selected;
                $own_bike_sim_obj->checkin = $request->checkin;
                $own_bike_sim_obj->status = "1";
                $own_bike_sim_obj->save();

                if($sim_done){
                    $message = [
                        'message' => "Bike and Sim is own successfully",
                        'alert-type' => 'success',
                        'error' => ''
                    ];
                    return redirect()->back()->with($message);
                }elseif($sim_error){

                    $message = [
                        'message' => "Bike is own successfully, but Sim is already assigned",
                        'alert-type' => 'success',
                        'error' => ''
                    ];
                    return redirect()->back()->with($message);

                }else{
                    $message = [
                        'message' => "Bike is own successfully",
                        'alert-type' => 'success',
                        'error' => ''
                    ];
                    return redirect()->back()->with($message);

                }


            }
        }

        if($sim_done){
            $message = [
                'message' => "Sim is own successfully, But bike is already assigned to this Rider",
                'alert-type' => 'success',
                'error' => ''
            ];
            return redirect()->back()->with($message);

        }



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
         $ownhistory = OwnSimBikeHistory::find($id);
         $ownhistory->status = "0";
         $ownhistory->checkout = $request->checkout;
         $ownhistory->save();

        $message = [
            'message' => 'Status has been update successfully',
            'alert-type' => 'success'
        ];

        return back()->with($message);

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
