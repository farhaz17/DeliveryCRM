<?php

namespace App\Http\Controllers;

use App\Model\Form_upload;
use Illuminate\Http\Request;

class UploadCategoryController extends Controller
{

    function __construct()
    {

        $this->middleware('role_or_permission:Admin|upload-form-upload-category', ['only' => ['index','store','destroy','edit','update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin-panel.uploading_forms.upload_category');
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

        if (!empty($_FILES['file_name']['name'])) {
            if (!file_exists('../public/assets/sample_forms/')) {
                mkdir('../public/assets/sample_forms/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/sample_forms/' . $file_name);
            $file_path='assets/sample_forms/' . $file_name;





        $obj=new Form_upload();
        $obj->form_name=$request->input('category_name');
        $obj->sample_file=$file_path;
        $obj->save();

            $message = [
                'message' => 'Added Successfully',
                'alert-type' => 'success',
            ];

            return redirect()->route('upload_category')->with($message);

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
