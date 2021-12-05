<?php

namespace App\Http\Controllers;

use App\Model\Nationality;
use App\Model\Work_permit;
use Illuminate\Http\Request;
use App\Model\Passport;


class StarMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $passport=Passport\Passport::all();
        return view('admin-panel.masters.star_menu',compact('passport'));
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
        $passport_no= $request->input('passport_no');

        $passport=Passport\Passport::where('passport_no',$passport_no)->get();
        $work_permit=Work_permit::where('passport_number',$passport_no)->get();
        $result=Work_permit::all();
        $result2=count($work_permit);
        $nationality=Nationality::first();

        return view('admin-panel.masters.view_permit',compact('passport','work_permit','nationality','result2','result'));
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
    public function ajax_get_passport(Request $request){



        $pass = Passport\Passport::find($request->passport_id);


        $expiry_date=$pass->date_expiry;
        $curr_date=date('Y-m-d');
        $date1 = strtotime($curr_date);
        $date2 = strtotime($expiry_date);
        $diff = abs($date2 - $date1);

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)
            / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 -
                $months*30*60*60*24)/ (60*60*24));

     $remain_days= $years." years ".$months." months ".$days." days";

        $response = $pass->sur_name."$".$pass->given_names."$".$pass->passport_pic."$".$remain_days;


        return $response;


    }

}
