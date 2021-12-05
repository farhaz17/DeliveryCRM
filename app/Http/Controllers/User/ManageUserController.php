<?php

namespace App\Http\Controllers\User;

use Image;
use App\User;
use App\Model\Ticket;
use App\Model\Platform;
use App\DcLimit\DcLimit;
use App\Model\UserGroups;
use App\Model\Departments;
use App\Model\RiderProfile;
use Illuminate\Http\Request;
use App\Model\MajorDepartment;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|user-manage-user', ['only' => ['index','store','destroy','edit','update']]);
        $this->middleware('role_or_permission:Admin', ['only' => ['ajax_get_user_activities_report','user_activities_audit']]);

    }

    public function index()
    {

        $userGroups=UserGroups::where('id', '!=', 4)->get();
        $users=User::where('user_group_id', 'not like', '%"4"%')->where('user_group_id', 'not like', '%"21"%')->get();
        $issue_departs=Departments::all();
        $platform=Platform::all();
        $major_deps=MajorDepartment::all();
        $userGroupsAR=[];
        $userDepartsAR=[];
        $userPlatsAR=[];
        $userDepartmentAR=[];
        foreach ($userGroups as $userGroup){
            $userGroupsAR[$userGroup->id]=$userGroup->name;
        }
        foreach ($issue_departs as $userDep){
            $userDepartsAR[$userDep->id]=$userDep->name;
        }
        foreach ($platform as $userPlat){
            $userPlatsAR[$userPlat->id]=$userPlat->name;
        }
        foreach ($major_deps as $userMaj){
            $userDepartmentAR[$userMaj->id]=$userMaj->major_department;
        }
        $roles = Role::all();
        return view('admin-panel.user.manage_user',compact('roles','userGroups','users','issue_departs','platform','userGroupsAR','userDepartsAR','userPlatsAR','userDepartmentAR','major_deps'));
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
                'email' => 'unique:users,email',
                'permission_role' => 'required'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Email is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('manage_user')->with($message);
            }
            $obj= new User();
            $obj->name = $request->input('name');
            $obj->email = $request->input('email');
            $obj->user_group_id = json_encode($request->input('role'));
//            $obj->user_issue_dep_id = json_encode($request->input('department'));
            $obj->user_platform_id = json_encode($request->input('platform'));
            $obj->major_department_ids = json_encode($request->input('major_department_ids'));
            $obj->password = bcrypt($request->input('password'));
            if(!empty($request->input('designation_type'))){
                $obj->designation_type = $request->input('designation_type');


            }
            // user profile upload
            if($request->hasFile('user_profile_picture')){
            //   if (!file_exists('../public/assets/upload/user_profile_picture/')) {
            //         mkdir('../public/assets/upload/user_profile_picture/', 0777, true);
            //     }
            //     $ext = pathinfo($_FILES['user_profile_picture']['name'], PATHINFO_EXTENSION);
            //     $file_name = time() . "_" . $request->date . '.' . $ext;

            //     move_uploaded_file($_FILES["user_profile_picture"]["tmp_name"], '../public/assets/upload/user_profile_picture/' . $file_name);
            //     $file_path = 'assets/upload/user_profile_picture/' . $file_name;
            //     $obj->user_profile_picture = $file_path;

                    $profile_pic = $request->file('user_profile_picture');
                    $filename = 'assets/upload/user_profile_picture/' .time() . '.' . $profile_pic->getClientOriginalExtension();

                    $imageS3 = Image::make($profile_pic)->resize(null, 500, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                    $obj->user_profile_picture = $filename;
                    Storage::disk("s3")->put($filename, $imageS3->stream());
            }
            // user profile upload

            $obj->save();


            if($request->input('designation_type')=="3" && !empty($request->input('designation_type'))){
                $dclimit = new DcLimit();
                $dclimit->user_id =  $obj->id;
                $dclimit->limit =  $request->dc_limit;
                $dclimit->save();
            }

            $obj->assignRole($request->input('permission_role'));
            $message = [
                'message' => 'User Created Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('manage_user')->with($message);
        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_user')->with($message);
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
//        $userGroups=UserGroups::all();
        $userGroups=UserGroups::where('id', '!=', 4)->get();
        $userData=User::find($id);
        $users=User::where('user_group_id', 'not like', '%"4"%')->get();

        $issue_departs=Departments::all();
        $platform=Platform::all();
        $major_deps=MajorDepartment::all();
        $userGroupsAR=[];
        $userDepartsAR=[];
        $userPlatsAR=[];
        $userDepartmentAR=[];
        foreach ($userGroups as $userGroup){
            $userGroupsAR[$userGroup->id]=$userGroup->name;
        }
        foreach ($issue_departs as $userDep){
            $userDepartsAR[$userDep->id]=$userDep->name;
        }
        foreach ($platform as $userPlat){
            $userPlatsAR[$userPlat->id]=$userPlat->name;
        }
        foreach ($major_deps as $userMaj){
            $userDepartmentAR[$userMaj->id]=$userMaj->major_department;
        }



        $roles = Role::all();

        $userRole = $userData->roles->pluck('name','name')->all();

        return view('admin-panel.user.manage_user',compact('userRole','roles','userGroups','userData','users','issue_departs','platform','userGroupsAR','userDepartsAR','userPlatsAR','userDepartmentAR','major_deps'));
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
        try{
//            dd(json_encode($request->input('role')));
//
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email,'.$id,
                'permission_role' => 'required'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Email is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('manage_user')->with($message);
            }
           $password= $request->input('password');
            if ($password==null){
                $obj1 = User::find($id);
                $obj1->user_group_id = null;
                $obj1->user_issue_dep_id = null;
                $obj1->user_platform_id = null;
                $obj1->major_department_ids = null;
                $obj1->save();

                $obj = User::find($id);
                $obj->name = $request->input('name');
                $obj->email = $request->input('email');
                $obj->user_group_id = json_encode($request->input('role'));
//            $obj->user_issue_dep_id = json_encode($request->input('department'));
                $obj->major_department_ids = json_encode($request->input('major_department_ids'));
                $obj->user_platform_id = json_encode($request->input('platform'));
                if(!empty($request->input('designation_type'))){
                    $obj->designation_type = $request->input('designation_type');
                }
                 // user profile upload
                if($request->hasFile('user_profile_picture')){
                    // if (!file_exists('../public/assets/upload/user_profile_picture/')) {
                    //     mkdir('../public/assets/upload/user_profile_picture/', 0777, true);
                    // }
                    // $ext = pathinfo($_FILES['user_profile_picture']['name'], PATHINFO_EXTENSION);
                    // $file_name = time() . "_" . $request->date . '.' . $ext;

                    // move_uploaded_file($_FILES["user_profile_picture"]["tmp_name"], '../public/assets/upload/user_profile_picture/' . $file_name);
                    // $file_path = 'assets/upload/user_profile_picture/' . $file_name;
                    // $obj->user_profile_picture ? unlink($obj->user_profile_picture) : "";

                    $profile_pic = $request->file('user_profile_picture');
                    $filename = 'assets/upload/user_profile_picture/' .time() . '.' . $profile_pic->getClientOriginalExtension();

                    $imageS3 = Image::make($profile_pic)->resize(null, 500, function ($constraint) {
                                    $constraint->aspectRatio();
                                });
                    $obj->user_profile_picture ? Storage::disk('s3')->delete($obj->user_profile_picture) : "";
                    $obj->user_profile_picture = $filename;
                    Storage::disk("s3")->put($filename, $imageS3->stream());

                    }
                // user profile upload
                $obj->save();

                if($request->input('designation_type')=="3" && !empty($request->input('designation_type'))){
//                    $dclimit =  DcLimit::where('user_id','=',$obj->id)->first();
//                    $dclimit->limit =  $request->dc_limit;
//                    $dclimit->update();
                    $dclimit =  DcLimit::firstOrCreate(['user_id' => $obj->id]);
                    $dclimit->limit = $request->dc_limit;
                    $dclimit->save();
                }


                DB::table('model_has_roles')->where('model_id',$id)->delete();
                $obj->assignRole($request->input('permission_role'));


                $message = [
                    'message' => 'User Updated Successfully',
                    'alert-type' => 'success'

                ];
                return redirect()->route('manage_user')->with($message);
            }
        else {

            $obj1 = User::find($id);
            $obj1->user_group_id = null;
            $obj1->user_issue_dep_id = null;
            $obj1->user_platform_id = null;
            $obj1->major_department_ids = null;
            $obj1->save();

            $obj = User::find($id);
            $obj->name = $request->input('name');
            $obj->email = $request->input('email');
            $obj->user_group_id = json_encode($request->input('role'));

        //$obj->user_issue_dep_id = json_encode($request->input('department'));

            $obj->major_department_ids = json_encode($request->input('major_department_ids'));
            $obj->user_platform_id = json_encode($request->input('platform'));
            $obj->password = bcrypt($request->input('password'));
            if (!empty($request->input('designation_type'))) {
                $obj->designation_type = $request->input('designation_type');
            }
            $obj->save();

            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $obj->assignRole($request->input('permission_role'));


            $message = [
                'message' => 'User Updated Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('manage_user')->with($message);
        }
        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_user')->with($message);
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

        try {
            $obj = User::find($id);
            $obj->delete();

            $message = [
                'message' => 'User Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('manage_user')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_user')->with($message);
        }
    }

    public function get_user_department_wise(Request $request){

        $array_to_send = array();
        $string_ab = "";
        $platform_id = "";
         $platform = Ticket::where('id','=',$request->ticket_id)->first();
         if(!empty($platform)){
             $platform_id = $platform->platform;
         }
        if(isset($request->department_id)){

            foreach ($request->department_id as  $ab){
                $users = User::where('major_department_ids','LIKE','%'.$ab.'%')->where('user_platform_id','LIKE','%'.$platform_id.'%')->pluck('name')->toArray();

                if(!empty($users)){
                    $string_ab.= "".implode(',',$users);
                }
            }
            if($string_ab!=""){
                $array_to_send = explode(',',$string_ab);
                $array_to_send = array_unique($array_to_send);
            }
            $view  = view('admin-panel.user.department_name_user',compact('array_to_send'))->render();
            return response()->json(['html'=>$view]);
        }

     }

     public function get_user_internal_department_wise(Request $request){

         $array_to_send = array();
         $string_ab = "";
         if(isset($request->department_id)){

             foreach ($request->department_id as  $ab){
                 $users = User::where('major_department_ids','LIKE','%'.$ab.'%')->pluck('id')->toArray();

                 if(!empty($users)){
                     $string_ab.= "".implode(',',$users);
                 }
             }
             if($string_ab!=""){
                 $array_to_send = explode(',',$string_ab);
                 $array_to_send = array_unique($array_to_send);
             }

             $users = User::whereIn('id',$array_to_send)->get();

             echo json_encode($users);
             exit;

         }

     }

     public function getUserinfo()
     {
        $userGroup =        UserGroups::whereIn('id',User::find(request()->user_id)->user_group_id)->get();
        $permissions =      User::find(request()->user_id)->roles;

        $major_department = MajorDepartment::whereIn('id',User::find(request()->user_id)->major_department_ids)->get();
        $userPlatform =     Platform::whereIn('id',User::find(request()->user_id)->user_platform_id)->get();
        $view  = view('admin-panel.user.userdata',compact('userGroup','major_department','userPlatform','permissions'))->render();
        return response()->json(['html'=>$view]);
     }
     public function user_activities_audit(Request $request)
     {
         $users = User::get()->filter(function($user){
             return (in_array(4, $user->user_group_id ?? []) || in_array(21, $user->user_group_id ?? [])) ? false : true;
         });
         return view('admin-panel.user_activities_audit.index', compact('users'));
     }

     public function ajax_get_user_activities_report(Request $request)
     {
        $audits = Audit::with('user')->where(function($audit){
            if(request('user_id')){
                $audit->where('user_id', request('user_id'));
            }
        })
        ->whereBetween('created_at', [$request->start_date, $request->end_date])
        ->latest()
        ->get()
        ->take(3000);
        $audit_reports = view('admin-panel.user_activities_audit.shared_blades.audit_report', compact('audits'))->render();
        return response([
            'audit_reports' => $audit_reports
        ]);
     }
}
