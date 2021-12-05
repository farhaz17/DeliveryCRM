<?php

namespace App\Http\Controllers\Master\Sim;

use App\Model\Telecome;
use App\SimCardReplace;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SimCardReplaceController extends Controller
{    
    function __construct()
    {
        $this->middleware('role_or_permission:Admin|SIMManager', ['only' => ['index','create','store','edit','update','sim_replace_history']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sim_cards = Telecome::whereHas('replaces_history')->with('replaces_history')->get();
        return view('admin-panel.sim_master.sim_card_replace_list', compact('sim_cards')); // Only sim which have history
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sims  = Telecome::all();
        return view('admin-panel.sim_master.sim_card_replace_create', compact('sims'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'sim_id' => 'required'
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
            // fetch sim information
            $old_sim = Telecome::find($request->sim_id);
            // Store old Sim history
            $SimCardReplace = new SimCardReplace();
            $SimCardReplace->sim_id = $old_sim->id;
            $SimCardReplace->user_id = auth()->user()->id;
            $SimCardReplace->sim_sl_no = $old_sim->sim_sl_no; // add old sim card serial
            $SimCardReplace->paid_by = $request->paid_by;
            $SimCardReplace->reason = $request->reason;
            $SimCardReplace->amount = $request->amount;
            $SimCardReplace->save();
            // update new sim info
            $old_sim->sim_sl_no = $request->sim_sl_no;
            $old_sim->update();

            $message = [
                'message' => 'Sim Card Replace Added Successfully',
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
     * @param  \App\SimCardReplace  $simCardReplace
     * @return \Illuminate\Http\Response
     */
    public function show(SimCardReplace $simCardReplace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SimCardReplace  $simCardReplace
     * @return \Illuminate\Http\Response
     */
    public function edit(SimCardReplace $simCardReplace)
    {
        return view('admin-panel.sim_master.sim_card_replace_edit', compact('sim_package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SimCardReplace  $simCardReplace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SimCardReplace $simCardReplace)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sim_card_replaces,name,' . $SimCardReplace->id,
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
            $SimCardReplace->name = $request->name;
            $SimCardReplace->update();
            $message = [
                'message' => 'Sim Card Replace Updated Successfully',
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
     * @param  \App\SimCardReplace  $simCardReplace
     * @return \Illuminate\Http\Response
     */
    public function destroy(SimCardReplace $simCardReplace)
    {
        //
    }

    public function sim_replace_history()
    {
        $sim_card_history = SimCardReplace::where('sim_id', request()->sim_id)->get();
        $view = view('admin-panel.sim_master.shared_blades.sim_replace_history', compact('sim_card_history'))->render();
        return response()->json(['html'=>$view]);
    }
}
