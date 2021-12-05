<?php

namespace App\Http\Controllers\Profile;

use App\Model\Assign\AssignBike;
use App\Model\BikeDetail;
use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\VehicleSalik;
use App\Model\Fines;
use App\Model\FineUpload\FineUpload;
use App\Model\Vehicle_salik;
use Illuminate\Database\Eloquent\Model;

class BikeProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('admin-panel.profile.bike_profile.index');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function autocomplete_bike(Request $request)
    {
        $bike_data = BikeDetail::select('bike_details.plate_no','bike_details.chassis_no')
            ->where("bike_details.plate_no", "LIKE", "%{$request->input('query')}%")
            ->get();
        if (count($bike_data)=='0'){
            $chessis_data = BikeDetail::select('bike_details.chassis_no','bike_details.plate_no')
                ->where("bike_details.chassis_no", "LIKE", "%{$request->input('query')}%")
                ->get();
            $pass_array = array();
            foreach ($chessis_data as $row) {
                $gamer = array(
                    'name' => $row->chassis_no,
                    'bike_plate_no' => $row->plate_no,

                    'type' => '1',
                );
                $pass_array[] = $gamer;
            }
            return response()->json($pass_array);

        }
        $pass_array = array();
        foreach ($bike_data as $row) {
            $gamer = array(
                'name' => $row->plate_no,
                'chasis' => $row->chassis_no,
                'type' => '0',
            );
            $pass_array[] = $gamer;
        }
        return response()->json($pass_array);
    }

//    public function (Request $request)
//    {
//        $searach = '%' . $request->keyword . '%';
//        $BikeDetail = BikeDetail::where('plate_no', 'like', $searach)->first();
//        $assgin_bike=AssignBike::where('bike',$BikeDetail->id)->get();
//        $assined_to=AssignBike::where('bike',$BikeDetail->id)->where('status','1')->first();
//        $fine = FineUpload::where('plate_number','like',$searach)->get();
//        $salik=Vehicle_salik ::where('plate','like',$searach)->get();
//
//
//        $view = view("admin-panel.profile.bike_profile.ajax_get_bike_detail", compact('BikeDetail','assgin_bike','assined_to','fine','salik'))->render();
//        return response()->json(['html' => $view]);
//
//    }
}
