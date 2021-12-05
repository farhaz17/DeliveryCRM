<?php

namespace App\Http\Controllers\Master\Sim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\Sim\SimPackage;
use Illuminate\Support\Facades\Validator;

class SimPackageController extends Controller
{
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|SIMManager', ['only' => ['index','create','store','edit','update']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sim_packages = SimPackage::all();
        return view('admin-panel.sim_master.sim_package_list', compact('sim_packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        return view('admin-panel.sim_master.sim_package_create', compact('data'));
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
            'name' => 'unique:sim_packages|required'
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {        
            $simPackage = new SimPackage();
            $simPackage->name = $request->name;
            $simPackage->save();
            $message = [
                'message' => 'Sim Package Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Master\Sim\SimPackage  $simPackage
     * @return \Illuminate\Http\Response
     */
    public function show(SimPackage $simPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Master\Sim\SimPackage  $simPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(SimPackage $sim_package)
    {
        return view('admin-panel.sim_master.sim_package_edit', compact('sim_package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Master\Sim\SimPackage  $simPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SimPackage $simPackage)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sim_packages,name,' . $simPackage->id,
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }
        try {        
            $simPackage->name = $request->name;
            $simPackage->update();
            $message = [
                'message' => 'Sim Packages Updated Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Master\Sim\SimPackage  $simPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(SimPackage $simPackage)
    {
        //
    }
}
