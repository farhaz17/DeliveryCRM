<?php

namespace App\Http\Controllers\RiderLog;

use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Guest\Career;
use App\Model\logStatus\LogStatus;
use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RiderLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin-panel.rider_step_log.index');

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
        //
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

    public function rider_log_show_ajax(Request $request){
        if($request->ajax()){
            $searach = '%' . $request->keyword . '%';
            $passport = Passport::where('passport_no', 'like', $searach)->first();
            $found_log = $passport->after_ppuid_status->pluck('log_status_id')->toArray();
            $not_found_log = LogStatus::whereNotIn('id',$found_log)->where('id','!=','1')->get();
            $career_id = Career::where('passport_no','=',$passport->passport_no)->first();
            $c_id = 0;
            if($career_id != null){
                $c_id = $career_id->id;
            }
            $histories =  CareerStatusHistory::where('career_id','=',$c_id)->orderby('id','desc')->get();
            $view = view("admin-panel.rider_step_log.ajax_result", compact('passport','not_found_log','histories'))->render();
            return response()->json(['html' => $view]);
        }
    }
}
