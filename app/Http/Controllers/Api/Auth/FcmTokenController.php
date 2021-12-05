<?php

namespace App\Http\Controllers\Api\Auth;

use App\Model\FcmToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FcmTokenController extends Controller
{
    public function storeFcmToken(Request $request){
        $user_id = Auth::user()->id;
        $user = FcmToken::where('user_id', '=', $user_id)->first();
        if ($user === null) {
            $obj=new FcmToken();
            $obj->user_id = Auth::user()->id;
            $obj->fcm_token = $request->input('fcm_token');
            $obj->save();
        }
        else{
            $obj=FcmToken::find($user->id);
            $obj->fcm_token = $request->input('fcm_token');
            $obj->save();
        }




        $response['code'] = 1;
        $response['message'] = "Token Successfully Generated";
        return response()->json($response);
    }
}
