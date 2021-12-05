<?php

namespace App\Http\Controllers\Api\PassportRequest;

use App\Model\Passport\PassportRequest;
use App\Model\Referal\Referal;
use App\Model\RiderProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PassportRequestApiContoller extends Controller
{
    //
    public function get_passport_request(Request $request)
    {
        $riderProfile = User::find(Auth::user()->id);
        $riderProfile = RiderProfile::where('user_id', '=', Auth::user()->id)->first();
        $user_passport_id = $riderProfile->passport_id;
        $pass_req_detail=PassportRequest::where('passport_id',$user_passport_id)->where('status','!=','2')->count();

        if ($pass_req_detail>=1){
            $response['code'] = 2;
            $response['message'] = "This Passport Request Already In Process!";
            return response()->json($response);
        }

        $response = [];
        try {
            $validator = Validator::make($request->all(), [
                'receive_date' => 'required',
                'return_date' => 'required',
                'reason' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $response['code'] = 2;
                $response['message'] = $validate->first();
                return response()->json($response);
            }


            $obj = new PassportRequest();
            $obj->passport_id = $user_passport_id;
            $obj->receive_date = $request->input('receive_date');
            $obj->return_date = $request->input('return_date');
            $obj->reason = $request->input('reason');
            $obj->save();
            $response['code'] = 1;
            $response['message'] = 'Passport Request Added Successfully!';
            return response()->json($response);
        }
        catch (\Illuminate\Database\QueryException $e) {
            $response['code'] = 2;
            $response['message'] = 'Some thing went wrong';
            return response()->json($response);
        }

    }

    public  function get_passport_request_detail(){

        $riderProfile = RiderProfile::where('user_id', '=', Auth::user()->id)->first();
        $user_passport_id = $riderProfile->passport_id;
        $pass_req=PassportRequest::where('passport_id',$user_passport_id)->get();

        foreach ($pass_req as $row) {
            $pass_params = array(
                'passport_no' => $row->passport_id,
                'receive_date' => $row->receive_date,
                'return_date' => $row->return_date,
                'reason' => $row->reason,
                'status' => $row->status,


            );

            $pass_array [] = $pass_params;

        }
        return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
    }
}
