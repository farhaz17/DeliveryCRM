<?php

namespace App\Http\Controllers\Passport;

use App\Model\Passport\Passport;
use App\Model\Passport\PassportRequest;
use App\Model\Referal\Referal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PassportsRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pass_request =PassportRequest::all();
        return view('admin-panel.passport.passports_request',compact('pass_request'));
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

        $id=$request->input('req_id');
        $update_status=$request->input('update_status');


        if ($update_status=='1') {
        PassportRequest::where('id','=',$id)
            ->update(['status'=>'1']);
            $message = [
                'message' => 'Passport Status Changed to Received!!',
                'alert-type' => 'success'

            ];
            return redirect()->back()->with($message);
            $obj->save();
        }
        else{
            PassportRequest::where('id','=',$id)
                ->update(['status'=>'2']);
            $message = [
                'message' => 'Passport Status Changed to Returned!!',
                'alert-type' => 'success'

            ];
            return redirect()->back()->with($message);
            $obj->save();
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
