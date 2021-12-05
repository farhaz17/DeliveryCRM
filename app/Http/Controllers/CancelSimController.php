<?php

namespace App\Http\Controllers;

use App\Model\Assign\AssignSim;
use App\Model\SimCancel;
use Illuminate\Http\Request;
use App\Model\Telecome;
use Illuminate\Support\Facades\Validator;



class CancelSimController extends Controller
{
    //

    public function all_cancel_sim(Request $request){

        $cancel_sims  = SimCancel::where('status','=','1')->get();

        $checkout_type_array  = array('','Lost','Cancel','Broken');

        return view('admin-panel.sim_cancel.index',compact('cancel_sims','checkout_type_array'));

    }

    public function create(){


    $cancel_sim_ids  = SimCancel::where('status','=','1')->pluck('sim_id')->toArray();


        $sims=Telecome::whereNotIn('id',$cancel_sim_ids)->get();
        $sim = Telecome::select('telecomes.*')
            ->leftjoin('assign_sims', 'assign_sims.sim', '=', 'telecomes.id')
            ->where('assign_sims.status','=',1)
            ->orwhere('telecomes.reserve_status','=',1)
            ->get();
        //getting assinged sim details
        $checkedin = array();
        foreach ($sim as $x) {
            $checkedin [] = $x->id;
        }
        $checked_out = array();
        foreach ($sims as $ab) {
            if (!in_array($ab->id, $checkedin)) {
                $gamer = array(
                    'sim_number' => $ab->account_number,
                    'id' => $ab->id,
                );
                $checked_out [] = $gamer;
            }
        }

        return view('admin-panel.sim_cancel.create',compact('checked_out'));
    }


    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'sim_id' => 'required',
            'checkout_type' => 'required'
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }


         $assign_sim = AssignSim::where('sim','=',$request->sim_id)->where('status','=','1')->first();
         if($assign_sim != null){
            $message = [
                'message' => "Sim Already checkin.!",
                'alert-type' => 'error',
            ];
         }

         $reserve = Telecome::where('id','=',$request->sim_id)->where('reserve_status','=','1')->first();
         if($reserve != null){
            $message = [
                'message' => "Sim Already Reserved.!",
                'alert-type' => 'error',
            ];
         }


          $sim_cancel = new SimCancel();
          $sim_cancel->sim_id = $request->sim_id;
          $sim_cancel->reason_type = $request->checkout_type;
          $sim_cancel->remarks = $request->remarks;
          $sim_cancel->status = "1";
          $sim_cancel->save();


          $message = [
            'message' => "Sim has been canceled successfully",
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);



    }


    public function update_cancel_status(Request $request){

        $validator = Validator::make($request->all(), [
            'primary_id' => 'required'
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();

            return $validate->first();
        }

            $id =  $request->primary_id;
            $sim_cancel = SimCancel::find($id);
            $sim_cancel->status  = "0";
            $sim_cancel->update();


            return "success";

    }




    public function ajax_cancel_sim_detail(Request $request){

        if($request->ajax()){

             $primary_id = $request->id_primary;
             $sim_cancel = SimCancel::where('id',$primary_id)->first();
             $checkout_type_array  = array('','Lost','Cancel','Broken');
             $view  = view('admin-panel.sim_cancel.ajax_detail_sim',compact('checkout_type_array','sim_cancel'))->render();
            return response()->json(['html'=>$view]);

        }

    }



}
