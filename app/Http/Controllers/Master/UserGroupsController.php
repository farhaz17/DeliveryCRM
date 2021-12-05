<?php

namespace App\Http\Controllers\Master;

use App\Model\UserGroups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserGroupsController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|master-user-roles', ['only' => ['index','edit','destroy','update','store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usergroups=UserGroups::all();
        return view('admin-panel.masters.user_groups',compact('usergroups'));
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
        try{

            $validator = Validator::make($request->all(), [
                'name' => 'unique:user_groups,name'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'User Department exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('muser_group')->with($message);
            }

            $obj=new UserGroups();
            $obj->name=$request->input('usergroups_name');
            $obj->save();

            $message = [
                'message' => 'User Department Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('muser_group')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('muser_group')->with($message);
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
        $usergroups_data=UserGroups::find($id);
        $usergroups=UserGroups::all();
        return view('admin-panel.masters.user_groups',compact('usergroups','usergroups_data'));
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
        $validator = Validator::make($request->all(), [
            'name' => 'unique:user_groups,name,'. $id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'User Department is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('muser_group')->with($message);
        }

        try {

            $obj = UserGroups::find($id);
            $obj->name=$request->input('usergroups_name');
            $obj->save();

            $message = [
                'message' => 'User Department Updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('muser_group')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('muser_group')->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $obj = UserGroups::find($id);
            $obj->delete();
            $message = [
                'message' => 'User Department Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('muser_group')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('muser_group')->with($message);
        }
    }
}
