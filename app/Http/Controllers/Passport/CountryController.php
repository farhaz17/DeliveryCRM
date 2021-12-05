<?php

namespace App\Http\Controllers\Passport;

use App\Model\Guest\Career;
use App\Model\Nationality;
use App\Model\Passport\Passport;
use App\Model\Passport\PassportAdditional;
use App\Model\Types;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function Matrix\add;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nation=Nationality::all();
        $types=Types::all();
        $all_passports = Career::where('applicant_status','=','4')->get();

        $pending_passports = array();

        foreach ($all_passports as $pass){
             $curent_passport = Passport::where('passport_no','=',$pass->passport_no)->first();
             if($curent_passport==null){
                 $gamer = array(
                     'passport_number' => $pass->passport_no,
                 );

                 $pending_passports[] = $gamer;
             }

        }

        return view('admin-panel.passport.country',compact('nation','types','pending_passports'));
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


        $types=Types::all();
        $count=$request->input('nation_id');
        $passport=Passport::all();
        $country=PassportAdditional::find($count);
        $nation=Nationality::find($count);
        $additional =PassportAdditional::where('nation_id',$count)->get();


        return view('admin-panel.passport.passport',compact('nation','types','country','additional','passport'));
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
