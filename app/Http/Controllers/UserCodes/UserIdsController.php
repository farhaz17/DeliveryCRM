<?php

namespace App\Http\Controllers\UserCodes;

use App\Model\UserCodes\UserIds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Passport;
use Illuminate\Support\Facades\Validator;

class UserIdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $passport=Passport\Passport::all();

        return view('admin-panel.user_codes.user_ids_passport',compact('passport'));
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

        $validator = Validator::make($request->all(), [
            'passport_id' => 'unique:user_ids,passport_id',
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'User IDs have  Already Assigned',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }


        $validator2 = Validator::make($request->all(), [
            'labour_card_no' => 'unique:user_ids,labour_card_no'
        ]);
        if ($validator2->fails()) {

            $validate2 = $validator2->errors();
            $message = [
                'message' => 'Labour Card Already Assigned',
                'alert-type' => 'error',
                'error' => $validate2->first()
            ];
            return redirect()->back()->with($message);
        }
        $obj = new UserIds();
        $obj->passport_id = $request->input('passport_id');
        $obj->zds_id1 = $request->input('zds_id1');
        $obj->zds_id2 = $request->input('zds_id2');
        $obj->labour_card_no = $request->input('labour_card_no');


        $obj->save();
        $message = [
            'message' => 'Added Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->back()->with($message);

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



    public function userids_passport(Request $request)
{
        $pass_no=$request->input('passport_number');

        $pass2=Passport\Passport::where('id',$pass_no)->first();

        $passport_id=$pass2->id;
        $ids=UserIds::all();


       return view('admin-panel.user_codes.user_ids',compact('passport_id','ids'));

    }
}
