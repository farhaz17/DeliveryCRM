<?php

namespace App\Http\Controllers\CashReceive;

use App\Model\Cashreceives\Cashreceives;
use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CashReceiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_passports = Passport::where('is_cancel','=','0')->get();

        $cash_receives = Cashreceives::all();



        return view('admin-panel.cash_receive.index',compact('all_passports','cash_receives'));
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
        $passport_id = null;

        if($request->search_type=="1"){
            $passport_id = $request->ppui_id;
        }elseif($request->search_type=="2"){
            $passport_id = $request->zds_code;
        }else{
            $passport_id = $request->passport_id;
        }

        $obj = new Cashreceives();
        $obj->passport_id = $passport_id;
        $obj->amount = $request->amount;
        $obj->received_by = Auth::user()->id;
        $obj->save();

        $message = [
            'message' => 'COD has been collected successfullly',
            'alert-type' => 'success'

        ];
        return back()->with($message);


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
