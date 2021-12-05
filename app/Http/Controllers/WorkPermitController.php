<?php

namespace App\Http\Controllers;

use App\Model\Bike_invoice;
use App\Model\Work_permit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorkPermitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $result=Work_permit::all();
        return view('admin-panel.masters.view_permit',compact('result'));


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
        if (!empty($_FILES['file_name']['name'])) {
            if (!file_exists('../public/assets/upload/work_permit/')) {
                mkdir('../public/assets/upload/work_permit/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/work_permit/' . $file_name);
            $file_path = 'assets/upload/work_permit/' . $file_name;

            $obj = new Work_permit();
            $obj->name = $request->input('name');
            $obj->work_permit_issue_date = $request->input('work_permit_issue_date');
            $obj->work_permit_expiry_date = $request->input('work_permit_expiry_date');
            $obj->personal_number = $request->input('personal_number');
            $obj->profession_visa = $request->input('profession_visa');
            $obj->working_visa = $request->input('working_visa');
            $obj->nationality = $request->input('nationality');
            $obj->working_company = $request->input('working_company');
            $obj->visa_company = $request->input('visa_company');
            $obj->working_company = $request->input('working_company');
            $obj->offer_letter_no = $request->input('offer_letter_no');
            $obj->transaction_no = $request->input('transaction_no');
            $obj->passport_number = $request->input('passport_number');
            $obj->labour_card_permit_no = $request->input('labour_card_permit_no');
            $obj->employment = $request->input('employment');
            $obj->work_permit_copy = $file_path;
            $obj->visa = $request->input('visa');
            $obj->status = '1';


            $obj->save();
            $message = [
                'message' => 'Added Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->back()->with($message);
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
