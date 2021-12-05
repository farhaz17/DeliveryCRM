<?php

namespace App\Http\Controllers\Master;

use App\Model\InvParts;
use App\Model\Master_steps;
use App\Model\Parts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterStepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $steps=Master_steps::all();

        return view('admin-panel.masters.master_steps',compact('steps'));

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
        $obj = new Master_steps();
        $obj->step_name = $request->input('step_name');
        $obj->save();


        $message = [
            'message' => 'Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('master_steps')->with($message);

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
        $result=Master_steps::find($id);
        $steps=Master_steps::all();
        return view('admin-panel.masters.master_steps',compact('steps','result'));
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
        try {

                $obj = Master_steps::find($id);
                $obj->step_name=$request->input('step_name');
                $obj->save();

                $message = [
                    'message' => 'Step Name Updated Successfully',
                    'alert-type' => 'success'

                ];
            return redirect()->route('master_steps')->with($message);



        }
        catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('master_steps')->with($message);
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
        //
        try {
            $obj = Master_steps::find($id);
            $obj->delete();
            $message = [
                'message' => 'Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('master_steps')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('master_steps')->with($message);
        }
    }
}
