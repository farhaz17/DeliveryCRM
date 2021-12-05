<?php

namespace App\Http\Controllers;

use App\Model\BikeDetail;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\LabourUpload;
use App\Model\Seeder\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabourUploadController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|compression-labour-compression', ['only' => ['index','store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin|compression-labour-existing', ['only' => ['labour_exist']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $company = Company::where('type', '=', '1')->get();
         return view('admin-panel.uploading_forms.LabourUpload',compact('company'));
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

    public function labour_exist()
    {
        //
        $ap_electronics_exist = ElectronicPreApproval::select('electronic_pre_approval.*')
            ->get();
        $approval_electronics_exist = array();
        foreach ($ap_electronics_exist as $ab) {

            $gamer = array(
                'person_code' => $ab->person_code,
                'labour_card_no' => $ab->labour_card_no,
                'person_name' => $ab->passport->personal_info->full_name,
                'passport_number' => $ab->passport->passport_no,
                'nation' => $ab->passport->nation->name,
                'expiry_date' => $ab->expiry_date,
                'card_type' => $ab->passport->card_type->card_type_name->name,
                'job' => isset($ab->passport->offer->designation->name)?$ab->passport->offer->designation->name:""
            );

            $approval_electronics_exist [] = $gamer;

        }
//        dd($approval_electronics_exist);


        return view('admin-panel.uploading_forms.labour_upload_existing',compact('approval_electronics_exist'));

    }
}
