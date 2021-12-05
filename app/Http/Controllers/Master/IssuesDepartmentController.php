<?php

namespace App\Http\Controllers\Master;

use App\Model\Departments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class IssuesDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|master-issue-department', ['only' => ['index','edit','destroy','update','store']]);
    }

    public function index()
    {
        $issueDepartments=Departments::all();
        return view('admin-panel.masters.issue_department',compact('issueDepartments'));
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
                'name' => 'unique:departments,name'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Issue Department exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('missue_department')->with($message);
            }

            $obj=new Departments();
            $obj->name=$request->input('department_name');
            $obj->save();

            $message = [
                'message' => 'Issue Department Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('missue_department')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('missue_department')->with($message);
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
        $departments_data=Departments::find($id);
        $issueDepartments=Departments::all();
        return view('admin-panel.masters.issue_department',compact('issueDepartments','departments_data'));
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
            'name' => 'unique:departments,name,'. $id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Department is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('missue_department')->with($message);
        }

        try {

            $obj = Departments::find($id);
            $obj->name=$request->input('department_name');
            $obj->save();

            $message = [
                'message' => 'Department Updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('missue_department')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('missue_department')->with($message);
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
            $obj = Departments::find($id);
            $obj->delete();
            $message = [
                'message' => 'Issue Department Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('missue_department')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('missue_department')->with($message);
        }
    }

    public function update_issue_dep(Request $request){



        $obj = Departments::find($request->id);
        $obj->status=$request->input('status');
        $obj->save();
        return json_encode(array('statusCode'=>200));



    }


}
