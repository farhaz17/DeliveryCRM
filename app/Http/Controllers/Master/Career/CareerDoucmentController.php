<?php

namespace App\Http\Controllers\Master\Career;

use App\Model\Career\CareerDocumentName;
use App\Model\Seeder\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CareerDoucmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $documents = CareerDocumentName::all();
        return view('admin-panel.masters.career.document_name',compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {



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
            'name' => 'required|unique:career_document_names,name'
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

            $obj = new CareerDocumentName();
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
        $documents = CareerDocumentName::all();
        $doc = CareerDocumentName::find($id);
        return view('admin-panel.masters.career.heard_about_us',compact('doc','documents'));
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
            'name' => 'required|unique:career_document_names,name,'.$id
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

            $obj = CareerDocumentName::find($id);
            $obj->name=$request->input('name');
            $obj->update();

            $message = [
                'message' => 'Document Name updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect('career_document_name')->with($message);
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
