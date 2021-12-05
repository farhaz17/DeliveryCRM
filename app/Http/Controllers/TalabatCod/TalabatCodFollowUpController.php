<?php

namespace App\Http\Controllers\TalabatCod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TalabatCod\TalabatCod;
use Illuminate\Support\Facades\Validator;
use App\Model\TalabatCod\TalabatCodFollowUp;

class TalabatCodFollowUpController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passport_id' => 'required',
            'talabat_cod_id' => 'required',
            'feedback_id' => 'required',
        ],
            $messages = [
                'feedback_id.required' => "Please select a feedback"
            ]
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => $validate->first(),
                'status' =>'500'
            ]);
        }
        $talabat_cod_follow_up = TalabatCodFollowUp::create([
            'user_id' => auth()->id(),
            'passport_id' => $request->passport_id,
            'talabat_cod_id' => $request->talabat_cod_id,
            'feedback_id' => $request->feedback_id,
            'remarks' => $request->remarks,
        ]);

        if($talabat_cod_follow_up){
            return response([
                'html' => null,
                'alert-type' => 'success',
                'message' => 'Talabat cod follow Up Added!',
                'status' =>'200'
            ]);
        }else{
            return response([
                'html' => null,
                'alert-type' => 'error',
                'message' => 'Talabat cod follow Up Adding failed!',
                'status' =>'500'
            ]);
        }
    }
    public function talabat_cod_follow_up_calls(Request $request)
    {
        $cod_follow_up_calls = TalabatCod::whereId($request->talabat_cod_id)->with('follow_ups')->first()->follow_ups;
        $view = view('admin-panel.talabat_cod.shared_blades.cod_follow_up_calls',compact('cod_follow_up_calls'))->render();
        return response()->json(['html' => $view]);
    }
}
