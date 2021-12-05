<?php

namespace App\Http\Controllers\Master;

use App\Model\Cities;
use App\Model\Platform;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlatformController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|master-platform', ['only' => ['index','edit','destroy','update','store']]);
        $this->middleware('role_or_permission:Admin|master-platform', ['only' => ['index','edit','destroy','update','store']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        $platforms=Platform::all();
        $cities=Cities::all();

        $plaform_code_status_array = ['NO',"YES"];
        $need_training_status_array = ['NO',"YES"];
        $need_reservation_status_array = ['NO',"YES"];




        return view('admin-panel.masters.platform',compact('need_reservation_status_array','need_training_status_array','plaform_code_status_array','platforms','cities'));
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
                'platform_name' => 'required|unique:platforms,name',
                'city_id' => 'required',
                'short_code_name' => 'required|unique:platforms,short_code',
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Platform Already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('mplatform')->with($message);
            }

            $obj=new Platform();
            $obj->name=$request->input('platform_name');
            $obj->platform_category=$request->input('platform_category');
            $obj->city_id=$request->input('city_id');
            $obj->need_platform_code =$request->input('need_notify');
            $obj->need_training =$request->input('need_training');
            $obj->need_reservation =$request->input('need_reservation');
            $obj->short_code =$request->input('short_code_name');
            $obj->save();

            $message = [
                'message' => 'Platform Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('mplatform')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('mplatform')->with($message);
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
        $platforms_data=Platform::find($id);
        $platforms=Platform::all();
        $cities=Cities::all();
        $plaform_code_status_array = ['NO',"YES"];
        $need_training_status_array = ['NO',"YES"];
        $need_reservation_status_array = ['NO',"YES"];
        return view('admin-panel.masters.platform',compact('need_reservation_status_array','need_training_status_array','plaform_code_status_array','platforms_data','platforms','cities'));
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
            'name' => 'unique:platforms,name,'.$id,
            'city_id' => 'required',
            'short_code_name' => 'required|unique:platforms,short_code,'.$id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' =>  $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('mplatform')->with($message);
        }

        try {

            $obj = Platform::find($id);
            $obj->name=$request->input('platform_name');
            $obj->platform_category=$request->input('platform_category');
            $obj->city_id=$request->input('city_id');
            $obj->need_platform_code =$request->input('need_notify');
            $obj->need_training =$request->input('need_training');
            $obj->need_reservation =$request->input('need_reservation');
            $obj->short_code =$request->input('short_code_name');
            $obj->save();

            $message = [
                'message' => 'Platform Updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('mplatform')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('mplatform')->with($message);
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
            $obj = Platform::find($id);
            $obj->delete();
            $message = [
                'message' => 'Platform Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('mplatform')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('mplatform')->with($message);
        }
    }
}
