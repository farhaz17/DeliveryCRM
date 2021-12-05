<?php

namespace App\Http\Controllers\DiscountName;

use App\Model\DiscountName\DiscountName;
use App\Model\Seeder\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DiscountNameController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|agreement-agreement-discount-name', ['only' => ['index','store','destroy','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        echo  route('discount_name');
//        dd(route('discount_name.edit',2));
         $discount_names = DiscountName::all();

      return  view('admin-panel.discount_name.discount_name',compact('discount_names'));
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
            'name' => 'required|unique:discount_names,names,'
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => 'error'
            ];
            return back()->with($message);
        }

        try{

            $obj = new DiscountName();
            $obj->names = $request->input('name');
            $obj->save();

            $message = [
                'message' => 'Discount Name Added Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
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
        $name_ab = DiscountName::find($id);
        $gamer = array(
            'name' => $name_ab->names,
             'id' => $name_ab->id,
        );

        return $gamer;
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
            'edit_name' => 'required|unique:discount_names,names,'.$id
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => 'error'
            ];
            return back()->with($message);
        }

        try{

            $obj = DiscountName::find($id);
            $obj->names = $request->edit_name;
            $obj->update();

            $message = [
                'message' => 'Discount Name Updated Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
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
