<?php

namespace App\Http\Controllers\CancelPassport;


use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CancelPassportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passport = Passport::orderby('id','desc')->get();

        return view('admin-panel.cancel_passport.index',compact('passport'));
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
          $pass= Passport::find($id);

          $array  = array(
                'name' => isset($pass->personal_info)? $pass->personal_info->full_name:''
          );

        echo json_encode($array);
        exit;
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
        $passport = Passport::find($id);
        $passport->is_cancel = '1';
        $passport->update();

        $message = [
            'message' => 'Passport has been Cancelled successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('cancel_passport')->with($message);

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
