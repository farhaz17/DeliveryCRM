<?php

namespace App\Http\Controllers\PpuidCancel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\PpuidCancel\CancelCateogryPpuid;
use Illuminate\Support\Facades\Validator;

class CancelCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $main_category = CancelCateogryPpuid::where('parent_id','=','0')->with('childrenCategories')->get();



        return view('admin-panel.cancel_passport.cancel_category',compact('main_category'));
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
        if($request->type=="1"){ //save  main category
            $validator = Validator::make($request->all(), [
                'main_category' => 'required|unique:cancel_cateogry_ppuids,name'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }

            $cancel_category = new CancelCateogryPpuid();
            $cancel_category->name =  $request->main_category;
            $cancel_category->save();

            $message = [
                'message' => "Main Category Submitted Successfully",
                'alert-type' => 'success'
            ];
            return back()->with($message);


        }else{  //save sub category

            $validator = Validator::make($request->all(), [
                'sub_category' => 'required|unique:cancel_cateogry_ppuids,name',
                'category_id' => 'required'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return back()->with($message);
            }


            $cancel_category = new CancelCateogryPpuid();
            $cancel_category->parent_id =  $request->category_id;
            $cancel_category->name =  $request->sub_category;
            $cancel_category->save();


            $message = [
                'message' => "Sub Category Submitted Successfully",
                'alert-type' => 'success'
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
