<?php

namespace App\Http\Controllers;

use App\Model\Repair_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RepairCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repair_categories=Repair_category::all();
        return view('admin-panel.pages.repair_category',compact('repair_categories'));
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
                'repair_category' => 'unique:repair_categories,repair_category'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Name is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('repair_category')->with($message);
            }

            $obj=new Repair_category();
            $obj->repair_category=$request->input('repair_category');
            $obj->save();

            $message = [
                'message' => 'Category Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('repair_category')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('repair_category')->with($message);
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
        $repair_category_data=Repair_category::find($id);
        $repair_categories=Repair_category::all();
        return view('admin-panel.pages.repair_category',compact('repair_category_data','repair_categories'));
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
        try {
            $validator = Validator::make($request->all(), [
                'repair_category' => 'unique:repair_categories,repair_category'.$id
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Name is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('repair_category')->with($message);
            }

            $obj = Repair_category::find($id);
            $obj->repair_category = $request->input('repair_category');
            $obj->save();

            $message = [
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('repair_category')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('repair_category')->with($message);
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
            $obj = Repair_category::find($id);
            $obj->delete();
            $message = [
                'message' => 'Category Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('repair_category')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('repair_category')->with($message);
        }
    }
}
