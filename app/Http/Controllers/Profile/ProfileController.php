<?php

namespace App\Http\Controllers\Profile;

use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\Departments;
use App\Model\RiderProfile;
use App\Model\Ticket;
use App\Model\VerificationForm;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('admin-panel.unique_profile.detail');
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
          $user = RiderProfile::find($id);
          $bike_assign = AssignBike::where('passport_id','=',$user->passport->id)->orderby('status','DESC')->get();
          $bike_sim = AssignSim::where('passport_id','=',$user->passport->id)->orderby('status','DESC')->get();
          $platform_assign = AssignPlateform::where('passport_id','=',$user->passport->id)->orderby('status','DESC')->get();

        $admin_tickets = Ticket::select('*')
            ->where('user_id','=',$user->user_id)
            ->orderBy('id', 'DESC')
            ->get();

        $issue_ids = Departments::whereIn('major_dept_id',auth()->user()->major_department_ids)->get();
        $users_new_array = array();
        foreach ($issue_ids as $abs){
            $users_new_array [] = $abs->id;
        }
        $departments=Departments::all();

        $verified =  VerificationForm::where('user_id','=',$user->user_id)->where('status','=','1')->first();

        return view('admin-panel.unique_profile.detail',compact('verified','departments','admin_tickets','user','bike_assign','bike_sim','platform_assign'));
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
