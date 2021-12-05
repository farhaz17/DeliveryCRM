<?php

namespace App\Http\Controllers\AssignToDc;

use App\DcLimit\DcLimit;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Manager_users;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class BulkAssignToDcController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|add-to-assign-dc', ['only' => ['index','store']]);
    }
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
        $users = User::where('designation_type','=','3')->get();
        return  view('admin-panel.assign_rider_to_dc.bulk_assign_to_dc',compact('users'));
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
            'select_file' => 'required',
            'dc_id' => 'required',
            'platform_id' => 'required',
            'quantity' => 'required',
        ]);
        if ($validator->fails()) {

            $response['message'] = $validator->errors()->first();
            $message = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }

        $dc_id = $request->dc_id;

        $total_assigned = AssignToDc::where('status','=','1')->where('platform_id','=',$request->platform_id)->where('user_id','=',$dc_id)->count();
        $total_dc_limit = DcLimit::where('user_id','=',$dc_id)->first();
        $limit = $total_dc_limit->limit ? $total_dc_limit->limit : 0;

        $remain_limit = $limit-$total_assigned;
        $total_user_selected = $request->quantity;



        if($total_user_selected > $remain_limit){
            $message = [
                'message' => "you are exceeded from the DC limit.!",
                'alert-type' => 'error',
                'error' => ''
            ];
            return redirect()->back()->with($message);
        }


//        dd($request);
        Excel::import(new \App\Imports\AssignToDCImport($dc_id,$request->platform_id), request()->file('select_file'));

        $message = [
            'message' => 'Rider Assigned Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);


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
