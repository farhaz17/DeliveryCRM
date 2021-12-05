<?php

namespace App\Http\Controllers;

use App\Model\Parts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Spatie\Permission\Models\Role;
class PartsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|master-parts', ['only' => ['index','edit','destroy','update','store']]);
    }


    public function index()
    {
        $parts=Parts::all();
        return view('admin-panel.maintenance.parts.parts_master',compact('parts'));
    }

        public function get_vendor_attenance(){

            $parts=Parts::all();
            $view = view("admin-panel.maintenance.parts.parts_ajax_files.parts_table_ajax",compact('parts'))->render();
            return response()->json(['html' => $view]);
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
                'part_number' => 'unique:parts,part_number'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Part number is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('parts')->with($message);
            }

            $obj=new Parts();
            $obj->part_name=$request->input('part_name');
            $obj->part_number=$request->input('part_number');
            $obj->oem=$request->input('oem');
            $obj->counter_fit=$request->input('counter_fit');
            $obj->super_seed=$request->input('super_seed');
            $obj->other=$request->input('other');
            $obj->category=$request->input('category');
            $obj->save();

            $message = [
                'message' => 'Parts Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('parts')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('parts')->with($message);
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
        $parts_data=Parts::find($id);
        $parts=Parts::all();
        return view('admin-panel.maintenance.parts.parts_master',compact('parts_data','parts'));
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
            'part_number' => 'unique:parts,part_number,'. $id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'Part number is already exist',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('parts')->with($message);
        }

        try {

            $obj = Parts::find($id);
            $obj->part_name=$request->input('part_name');
            $obj->part_number=$request->input('part_number');
            $obj->oem=$request->input('oem');
            $obj->counter_fit=$request->input('counter_fit');
            $obj->super_seed=$request->input('super_seed');
            $obj->other=$request->input('other');
            $obj->category=$request->input('category');
            $obj->save();

            $message = [
                'message' => 'Parts Updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('parts')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('parts')->with($message);
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
            $obj = Parts::find($id);
            $obj->delete();
            $message = [
                'message' => 'Part Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('parts')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('parts')->with($message);
        }
    }
}
