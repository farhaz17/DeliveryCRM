<?php

namespace App\Http\Controllers;

use App\Model\Form_upload;
use App\Model\Nationality;
use App\Model\Passport;
use App\Model\Work_permit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StarController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|passport-passport-visa-process', ['only' => ['index','store','update','edit','destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $passport=Passport\Passport::where('career_id','!=','0')->orWhere('career_id','!=','NULL')->get();
        $passport=Passport\Passport::all();
        return view('admin-panel.masters.star',compact('passport'));
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

        $passport2=DB::table('passports')->where('passport_no',$passport_no)->first();

        if ($passport2==null)
        {
            $message = [
                'message' => 'Passport Not Availabale',
                'alert-type' => 'error'
            ];

            return redirect()->back()->with($message);
        }

        $passport=Passport\Passport::where('passport_no',$passport_no)->get();
        $work_permit=Work_permit::where('passport_number',$passport_no)->get();
        $result=Work_permit::all();
        $result2=count($work_permit);
        $nationality=Nationality::first();

      //return view('admin-panel.masters.view_permit',compact('passport','result','nationality'));
        return view('admin-panel.masters.star_menu',compact('passport','work_permit','nationality','result2','result'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

        //return view('admin-panel.masters.star_menu',compact('passport','work_permit','nationality','result2','result'));
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
