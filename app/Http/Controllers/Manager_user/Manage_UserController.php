<?php

namespace App\Http\Controllers\Manager_user;

use App\Model\Manager_users;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Manage_UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $user_current =   Auth::user();


        if($user_current->hasRole('Admin')) {
            $managers = User::select('users.name','users.id')->leftjoin('manager_users','manager_users.manager_user_id','=','users.id')
            ->whereNull('manager_users.manager_user_id')
            ->where('designation_type','=','1')
            ->get();

            $manage_users = Manager_users::groupBy('manager_user_id')->get();
        }else{
            $managers = User::select('users.name','users.id')->leftjoin('manager_users','manager_users.manager_user_id','=','users.id')
            ->whereNull('manager_users.manager_user_id')
            ->where('designation_type','=','1')
            ->get();

            $manage_users = Manager_users::groupBy('manager_user_id')->where('manager_user_id','=',$user_id)->get();

        }



        $users = User::where('designation_type','=','3')->get();




        return view('admin-panel.manager_user.manager_user',compact('managers','users','manage_users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $managers = User::select('users.name','users.id')->leftjoin('manager_users','manager_users.manager_user_id','=','users.id')
                                ->whereNull('manager_users.manager_user_id')
                                ->where('designation_type','=','1')->get();

        $users = User::where('designation_type','=','3')->get();

        $manage_users = Manager_users::groupBy('manager_user_id')->get();


        return view('admin-panel.manager_user.create',compact('managers','users','manage_users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        try {

            $validator = Validator::make($request->all(), [
                'manager_user_id' => 'required',
                'users' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => 'df'
                ];


                return redirect()->back()->with($message);
            }



             $manage_use = Manager_users::where('manager_user_id','=',$request->manager_user_id)->first();

            if($manage_use!=null){

                $message = [
                    'message' => "Manager is already exist .!",
                    'alert-type' => 'error',
                    'error' => 'df'
                ];
                return redirect()->back()->with($message);

            }


            foreach($request->users as $ab){
                $manage_user = new Manager_users();
                $manage_user->manager_user_id = $request->manager_user_id;
                $manage_user->member_user_id = $ab;
                $manage_user->status = "1";
                $manage_user->save();
            }

            $message = [
                'message' => 'User added For Manager Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);



        }catch(\Illuminate\Database\QueryException $e){
                $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
                ];
            return redirect()->back()->with($message);
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
        $manage_user = Manager_users::find($id);

        $managers = User::where('designation_type','=','1')->where('id','=',$manage_user->manager_user_id)->get();

        $users = User::where('designation_type','=','3')->get();

        return  view('admin-panel.manager_user.edit',compact('manage_user','users','managers'));
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



        if($request->ajax()){
            $id = $request->id;
            $manager_user = Manager_users::find($id);
            $manager_user->status = $request->status;
            $manager_user->save();
            return  "success";

        }else{

            try {
                $validator = Validator::make($request->all(), [//
                    'manager_id' => 'required',
                    'users' => 'required',
                ]);
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error',
                        'error' => 'df'
                    ];
                    return redirect()->back()->with($message);
                }





                foreach($request->users as $ab){
                    $matchThese = ['manager_user_id'=>$request->manager_id,'member_user_id'=>$ab];
                    $manage_user = Manager_users::updateOrCreate(
                        $matchThese,
                        ['manager_user_id'=>$request->manager_id],
                        ['member_user_id'=>$ab],
                        ['status'=>'1']
                    );
                    $manage_user->save();
                }

                $message = [
                    'message' => 'User added For Manager Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);



            }catch(\Illuminate\Database\QueryException $e){
                $message = [
                    'message' => 'Error Occured',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

        }
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

    public function ajax_user_member(Request $request){

        if($request->ajax()){

             $primary_id = $request->primary_id;

            $manager_user = Manager_users::find($primary_id);

            $view = view('admin-panel.manager_user.ajax_user_member_status',compact('manager_user'))->render();

            return response()->json(['html'=>$view]);

        }

    }
}
