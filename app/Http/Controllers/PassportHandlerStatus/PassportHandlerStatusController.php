<?php

namespace App\Http\Controllers\PassportHandlerStatus;

use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\Passport;
use App\Model\PassportHandlerStatus\PassportHandlerStatus;
use App\Model\Seeder\LivingStatus;
use App\Model\Seeder\PassportHandler;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PassportHandlerStatusController extends Controller
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
        $passports = Passport::all();
        $passport_handlers = PassportHandler::all();
         $passport_statuses = PassportHandlerStatus::orderby('id','desc')->get();

       return  view('admin-panel.passport-handler-status.create',compact('passports','passport_handlers','passport_statuses'));

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
            return redirect()->route('passport_handler')->with($message);
        }
        $array_insert = array(
            'passport_id' => $request->passport_id,
            'passport_handler_id' => $request->status_id,
            'remarks' => $request->remarks,
        );

       PassportHandlerStatus::create($array_insert);

       $board_status = OnBoardStatus::where('passport_id','=',$request->passport_id)->first();

       if(!empty($board_status)){
           if($request->status_id=="2"){
               $board_status->passport_handler_status = "1";
               $board_status->living_status = "1";
               $board_status->update();
           }else{
               $board_status->passport_handler_status = "0";
               $board_status->living_status = "0";
               $board_status->update();
           }
       }else{
           $array_insert = array(
               'passport_id' => $request->passport_id
           );
           $board_status  = OnBoardStatus::create($array_insert);

           if($request->status_id=="2"){
               $board_status->passport_handler_status = "1";
               $board_status->living_status = "1";
               $board_status->update();
           }else{
               $board_status->passport_handler_status = "0";
               $board_status->living_status = "0";
               $board_status->update();
           }

       }



        $message = [
            'message' => 'Status has been created Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('passport_handler.create')->with($message);

   }
   catch (\Illuminate\Database\QueryException $e){
       $message = [
           'message' => 'Error Occured',
           'alert-type' => 'error'
       ];
       return redirect()->route('passport_handler.create')->with($message);
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

    public function ajax_get_current_passport_status(Request $request){

        $passport_id = $request->passport_id;

        $passport_status = PassportHandlerStatus::where('passport_id','=',$passport_id)->orderby('id','desc')->first();

        $status = "";

        if(!empty($passport_status)){
            $status = $passport_status->passport_handler_id;
        }

        return $status;
    }

}
