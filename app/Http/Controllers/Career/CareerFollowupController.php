<?php

namespace App\Http\Controllers\Career;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Career\onboard_followup;
use App\Model\Career\waitlistfollowup;
use App\Model\Career\selected_followup;
use App\Model\Career\frontdesk_followup;

class CareerFollowupController extends Controller
{

    public function frontdesk_follow_up(){

        $names = frontdesk_followup::all();
        return view('admin-panel.career.new_career.front_desk_follow_up',compact("names"));
    }

    public function waitlist_follow_up(){

        $names = waitlistfollowup::all();
        return view('admin-panel.career.new_career.waitlist_follow_up',compact("names"));
    }

    public function selected_follow_up(){

        $names = selected_followup::all();
        return view('admin-panel.career.new_career.selected_follow_up',compact("names"));
    }

    public function onboard_follow_up(){

        $names = onboard_followup::all();
        return view('admin-panel.career.new_career.onboard_follow_up',compact("names"));
    }

    public function frontdesk_follow_up_save(Request $request){

        $abc = new frontdesk_followup();
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function waitlist_follow_up_save(Request $request){

        $abc = new waitlistfollowup();
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function selected_follow_up_save(Request $request){

        $abc = new selected_followup();
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function onboard_follow_up_save(Request $request){

        $abc = new onboard_followup();
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Added successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
    }

    public function frontdesk_follow_up_edit($id){

        $front = frontdesk_followup::find($id);
        $names = frontdesk_followup::all();
        return view('admin-panel.career.new_career.front_desk_follow_up',compact("front","names"));
    }

    public function frontdesk_follow_up_update(Request $request, $id)
    {
        $abc = frontdesk_followup::find($id);
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success'

        ];
        return redirect('frontdesk_follow_up')->with($message);

    }

    public function waitlist_follow_up_edit($id){

        $wait = waitlistfollowup::find($id);
        $names = waitlistfollowup::all();
        return view('admin-panel.career.new_career.waitlist_follow_up',compact("wait","names"));
    }

    public function waitlist_follow_up_update(Request $request, $id)
    {
        $abc = waitlistfollowup::find($id);
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success'

        ];
        return redirect('waitlist_follow_up')->with($message);

    }

    public function selected_follow_up_edit($id){

        $select = selected_followup::find($id);
        $names = selected_followup::all();
        return view('admin-panel.career.new_career.selected_follow_up',compact("select","names"));
    }

    public function selected_follow_up_update(Request $request, $id)
    {
        $abc = selected_followup::find($id);
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Updated Successfully',
            'alert-type' => 'success'

        ];
        return redirect('selected_follow_up')->with($message);

    }

    public function onboard_follow_up_edit($id){

        $onboard = onboard_followup::find($id);
        $names = onboard_followup::all();
        return view('admin-panel.career.new_career.onboard_follow_up',compact("onboard","names"));
    }

    public function onboard_follow_up_update(Request $request, $id){

        $abc = onboard_followup::find($id);
        $abc->name = $request->name;
        $abc->save();

        $message = [
            'message' => 'Updated Successfully',
            'alert-type' => 'sucess'
        ];
        return redirect('onboard_follow_up')->with($message);
    }

    public function active_followup(Request $request){

        if($request->type == "1"){
            $abc = frontdesk_followup::find($request->id);
            $abc->status = $request->status;
            $abc->save();
        }
        elseif($request->type == "2"){
            $abc = waitlistfollowup::find($request->id);
            $abc->status = $request->status;
            $abc->save();
        }elseif($request->type == "3"){
            $abc = selected_followup::find($request->id);
            $abc->status = $request->status;
            $abc->save();
        }elseif($request->type == "4"){
            $abc = onboard_followup::find($request->id);
            $abc->status = $request->status;
            $abc->save();
        }

    }

    public function follow_up_dashboard(){

        return view('admin-panel.career.new_career.follow_up_dashboard');
    }

}
