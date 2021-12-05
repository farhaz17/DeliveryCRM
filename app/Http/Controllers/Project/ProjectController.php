<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Project\Project;
use App\Model\Seeder\Company;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|ProjectManage', ['only' => ['index','prview','store','edit','update_status','update']]);
    }

    public function index()
    {
       $company=Company::all();
       $projects=Project::all();
        return view('admin-panel.Project.Project',compact('company','projects'));
    }

    public function prview()
    {

       $company=Company::all();
       $projects=Project::all();

        return view('admin-panel.Project.project_view',compact('company','projects'));

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


        $validator = Validator::make($request->all(), [
            'project_name' => 'nullable|unique:projects,project_name',

        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj=new Project();


        $pro = IdGenerator::generate(['table' => 'projects', 'field' => 'project_number', 'length' => 7, 'prefix' => 'PRO1']);

            $obj->company=$request->input('company');
            $obj->project_name=$request->input('project_name');
            $obj->project_number=$pro;
            $obj->save();

            $message = [
                'message' => 'Projects Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('project')->with($message);
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
        $company=Company::all();
        $projects_data=Project::find($id);
        $projects=Project::all();
        return view('admin-panel.Project.Project',compact('projects_data','projects','company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_status(Request $request)
    {
        $obj = Project::find($request->id);
        $obj->status=$request->input('status');
        $obj->save();
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'project_name' => 'nullable|unique:projects,project_name,'.$id,

        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        $obj = Project::find($id);
        $obj->company=$request->input('company');
        $obj->project_name=$request->input('project_name');
        $obj->save();

        $message = [
            'message' => 'project Updated Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->route('project')->with($message);


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
