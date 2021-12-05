<?php

namespace App\Http\Controllers\Alert;

use App\Model\ContactForm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterAlertsController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|unregistered', ['only' => ['index','edit','destroy','update','store']]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alerts = ContactForm::where('status','=','0')->orderby('id','desc')->get();
        $alerts_solved = ContactForm::where('status','=','1')->orderby('id','desc')->get();

        return view('admin-panel.alerts.alert_register',compact('alerts','alerts_solved'));
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


        try{
            $validator = Validator::make($request->all(), [
                'status' => 'required',
            ]);
            if($validator->fails()) {
                $validate = $validator->errors();

                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('manage_alerts')->with($message);
            }

            $primary_id = $request->id;
            $status = $request->status;

             $contact_form = ContactForm::find($primary_id);


             $contact_form->status = $status;
             $contact_form->update();

            $message = [
                'message' => 'Status has been updated Successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('manage_alerts')->with($message);




        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_alerts')->with($message);
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
