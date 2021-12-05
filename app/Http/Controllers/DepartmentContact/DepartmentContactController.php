<?php

namespace App\Http\Controllers\DepartmentContact;

use App\Model\DepartmentContact\DepartmentContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DepartmentContactController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|setting-department-info', ['only' => ['index','store','destroy','edit','update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $contacts = DepartmentContact::orderby('id','desc')->get();

        return view('admin-panel.department_contact.index',compact('contacts'));
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

    public  function ajax_edit_contact(Request $request){

          if(!empty($request->primary_id)){
               $contact = DepartmentContact::find($request->primary_id);

              return  json_encode($contact);
          }else{
              $ab = array();
              return  json_encode($ab);
          }



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
            'email' => 'email|required|unique:department_contacts,email',
            'phone_number' => 'required|unique:department_contacts,phone',
            'whatsapp_number' => 'required|unique:department_contacts,whatsapp',
            'name'  => 'required|unique:department_contacts,name',
        ]);
        if($validator->fails()) {
            $validate = $validator->errors();

            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('department_contact')->with($message);
        }

        $obj =  new  DepartmentContact();

        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->phone = $request->phone_number;
        $obj->whatsapp = $request->whatsapp_number;
        $obj->save();

        $message = [
            'message' => "Contact Information Has been saved successfully",
            'alert-type' => 'success',
            'error' => '',
        ];
        return redirect()->route('department_contact')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('department_contact')->with($message);
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
//        try{
            $validator = Validator::make($request->all(), [
                'email' => 'email|required|unique:department_contacts,email,'.$id,
                'phone_number' => 'required|unique:department_contacts,phone,'.$id,
                'whatsapp_number' => 'required|unique:department_contacts,whatsapp,'.$id,
                'name'  => 'required|unique:department_contacts,name,'.$id,
            ]);
            if($validator->fails()) {
                $validate = $validator->errors();

                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('department_contact')->with($message);
            }

            $obj =  DepartmentContact::find($id);

            $obj->name = $request->name;
            $obj->email = $request->email;
            $obj->phone = $request->phone_number;
            $obj->whatsapp = $request->whatsapp_number;
            $obj->update();

            $message = [
                'message' => "Contact Information Has been Updated successfully",
                'alert-type' => 'success',
                'error' => '',
            ];
            return redirect()->route('department_contact')->with($message);

//        }
//        catch (\Illuminate\Database\QueryException $e){
//            $message = [
//                'message' => 'Error Occured',
//                'alert-type' => 'error'
//            ];
//            return redirect()->route('department_contact')->with($message);
//        }

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
