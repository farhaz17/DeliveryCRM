<?php

namespace App\Http\Controllers\DrivingLicenseStep;

use App\Model\DrivingLicenseStatuses\DrivingLicenseStatuses;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\Passport;
use App\Model\Seeder\DrivingLicenseSteps;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DrivingLicenseStepController extends Controller
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
         $driving_steps = DrivingLicenseSteps::all();
          $passports = Passport::all();

         $save_steps= DrivingLicenseStatuses::all();

        return view('admin-panel.driving_license_step.create',compact('driving_steps','passports','save_steps'));
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
                'passport_id' => 'required',
                'status_id' => 'required',
                'remarks' => 'required',
            ]);

            if($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('driving_license_step.create')->with($message);
            }
            $array_insert = array(
                'passport_id' => $request->passport_id,
                'driving_license_step_id' => $request->status_id,
                'remarks' => $request->remarks,
            );

            DrivingLicenseStatuses::create($array_insert);

// whole code is commited bcz of checkin onboardstatus update issue
                // $board_status = OnBoardStatus::where('passport_id','=',$request->passport_id)->first();

                // if(!empty($board_status)){
                //     if($request->status_id=="3"){
                //         $board_status->driving_license_status = "1";
                //         $board_status->update();
                //     }else{
                //         $board_status->driving_license_status = "0";
                //         $board_status->update();
                //     }
                // }else{
                //     $array_insert = array(
                //         'passport_id' => $request->passport_id
                //     );
                //    $board_status  = OnBoardStatus::create($array_insert);

                //     if($request->status_id=="3"){
                //         $board_status->driving_license_status = "1";
                //         $board_status->update();
                //     }else{
                //         $board_status->driving_license_status = "0";
                //         $board_status->update();
                //     }

                // }



            $message = [
                'message' => 'Driving license step has been updated successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('driving_license_step.create')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('driving_license_step.create')->with($message);
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

    public  function ajax_get_driving_current_status(Request $request){

         $passport_id = $request->passport_id;

         $license_status = DrivingLicenseStatuses::where('passport_id','=',$passport_id)->orderby('id','desc')->first();

         $status = "";

         if(!empty($license_status)){
             $status = $license_status->driving_license_step_id;
         }

         return $status;
    }

}
