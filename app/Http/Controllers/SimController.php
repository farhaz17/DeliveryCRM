<?php

namespace App\Http\Controllers;

use App\Model\Seeder\Company;
use Illuminate\Http\Request;

class SimController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|compression-sim-compression', ['only' => ['index','store','destroy','edit','update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $company = Company::where('type','=','1')->get();
        // $person_code = ElectronicPreApproval::all();

//         $ab = ElectronicPreApproval::leftjoin('labour_uploads','labour_uploads.person_code','=','electronic_pre_approval.person_code')->whereNUll('labour_uploads.person_code')->get();

//        $approval_electronics = ElectronicPreApproval::select('electronic_pre_approval.*')
//            ->leftjoin('labour_uploads','labour_uploads.person_code','=','electronic_pre_approval.person_code')
//            ->whereNull('labour_uploads.person_code')
//            ->get();

        //   return view('admin-panel.uploading_forms.LabourUpload',compact('person_code','approval_electronics'));
        return view('admin-panel.uploading_forms.sims_upload',compact('company'));
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
