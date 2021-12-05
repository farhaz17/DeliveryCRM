<?php

namespace App\Http\Controllers\Master\Career;

use App\Model\Career\CareerHeardAboutUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CareerHeardAboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $heard_about_uses = CareerHeardAboutUs::all();
        return view('admin-panel.masters.career.heard_about_us',compact('heard_about_uses'));
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


        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:career_heard_about_us,name'
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }

        try {

            $obj = new CareerHeardAboutUs();
            $obj->name=$request->input('name');
            $obj->save();

            $message = [
                'message' => 'Document Name Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
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
        //
        $heard_about_uses = CareerHeardAboutUs::all();
        $doc = CareerHeardAboutUs::find($id);
        return view('admin-panel.masters.career.heard_about_us',compact('doc','heard_about_uses'));
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

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:career_heard_about_us,name,'.$id
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }

        try {

            $obj = CareerHeardAboutUs::find($id);
            $obj->name=$request->input('name');
            $obj->update();

            $message = [
                'message' => 'Name updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect('career_heard_about_us')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
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
    }
}
