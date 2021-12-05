<?php

namespace App\Http\Controllers\ReserveBike;

use App\Model\CreateInterviews\CreateInterviews;
use App\Model\InterviewBatch\InterviewBatch;
use App\Model\Passport\Passport;
use App\Model\BikeDetail;
use App\Model\ReserveBike\ReserveBike;
use App\Model\Telecome;
use App\Model\UserCodes\UserCodes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReserveBikeController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|reserve-reserve-bike', ['only' => ['index','store','destroy','edit','update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $batches = InterviewBatch::where('is_complete','=','0')->get();
       $batches_complete = InterviewBatch::where('is_complete','=','1')->get();

        return view('admin-panel.reserve_bike.create',compact('batches_complete','batches'));
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
        try {
            $validator = Validator::make($request->all(), [
                'bike_value' => 'required',
                'sim_value' => 'required',
                'passport_id' => 'required|unique:reserve_bikes,passport_id',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                return $validate->first();
            }

            $reserve_bike = new ReserveBike();
            $reserve_bike->passport_id =$request->passport_id;
            $reserve_bike->bike_id =$request->bike_value;
            $reserve_bike->sim_id =$request->sim_value;
            $reserve_bike->reserved_by = Auth::user()->id;
            $reserve_bike->batch_id = $request->batch_id;
            $reserve_bike->save();

            $total_r = ReserveBike::where('batch_id', '=', $request->batch_id)->get();
            $total_batch = CreateInterviews::where('interviewbatch_id', '=', $request->batch_id)->get();


            if($total_r->count()==$total_batch->count()){

                InterviewBatch::where('id', '=', $request->batch_id)->update(['is_complete'=>'1']);
            }

            $bike = BikeDetail::find($request->bike_value);
            $bike->reserve_status =  '1';
            $bike->update();

            $sim = Telecome::find($request->sim_value);
            $sim->reserve_status = "1";
            $sim->update();

            return "success";


        }catch (\Illuminate\Database\QueryException $e){
            return "Error Occured";
         }

    }

    public function check_bike_reserve_ajax(Request $request){
        if($request->ajax()){
                $passport_id = $request->passport_id;
                 $res_bike = ReserveBike::where('passport_id','=',$passport_id)
                                            ->where('assign_status','=','0')->first();
                 if($res_bike != null){

                     return  $res_bike->bike_id;
                 }else{
                     return "false";
                 }
        }
    }

    public function check_sim_reserve_ajax(Request $request){

        if($request->ajax()){
            $passport_id = $request->passport_id;
            $res_bike = ReserveBike::where('passport_id','=',$passport_id)
                ->where('sim_assign_status','=','0')->first();
            if($res_bike != null){

                return  $res_bike->sim_id;
            }else{
                return "false";
            }
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
}
