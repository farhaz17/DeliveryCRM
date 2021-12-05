<?php

namespace App\Http\Controllers\Ticket;

use App\Model\Passport\Passport;
use App\Model\RiderProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Crypt;
use DataTables;

class ProfileRiderController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|user-manage-riders', ['only' => ['index','edit','update']]);
        $this->middleware('role_or_permission:Admin', ['only' => ['store']]);
        $this->middleware('role_or_permission:Admin|user-delete-rider', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



$profile_data=RiderProfile::with(['passport:id,passport_no','passport.personal_info','user:id,email','passport.zds_code'])->latest()->get();

return view('admin-panel.user.manage_rider_profile',compact('profile_data'));

// dd ($x);

//         if ($request->ajax()) {
//             $data = RiderProfile::latest()->get();
//             return Datatables::of($data)
// //                ->addIndexColumn()
//                 ->addColumn('name',function(RiderProfile $riderProfile){
//                     return $riderProfile->user->profile->passport->personal_info->full_name ? $riderProfile->user->profile->passport->personal_info->full_name : 'N/A';
//                 })
//                 ->addColumn('email',function(RiderProfile $riderProfile){
//                     return $riderProfile->user->email ? $riderProfile->user->email : 'N/A';
//                 })
//                 ->addColumn('zds_code',function(RiderProfile $riderProfile){
//                     return $riderProfile->passport->zds_code->zds_code ? $riderProfile->passport->zds_code->zds_code : 'N/A';

//                 })->addColumn('passport',function(RiderProfile $riderProfile){
//                     return $riderProfile->user->profile->passport->passport_no ? $riderProfile->user->profile->passport->passport_no  : 'N/A';
//                 })->addColumn('image',function(RiderProfile $riderProfile){
//                     $btn = "";
//                     if(isset($user->image)){
//                         $url = url($user->image);
//                             $btn = '<a href="'.$url.'" target="_blank">
//                                             <img class="rounded-circle m-0 avatar-sm-table" src="'.$url.'" alt="">
//                                         </a>';
//                     }else{
//                         $btn = '<span class="badge badge-info">No Image</span>';
//                     }
//                     return $btn;
//                 })
//                 ->addColumn('action', function($riderProfile){
//                     $url = route('rider_profile.edit',$riderProfile->id);

// //                    <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData('.$url.')" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>

//                    $btn = '<a class="text-success mr-2" href="'.$url.'"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>';
//                     return $btn;
//                 })
//                 ->rawColumns(['action','image'])
//                 ->make(true);
//         }
//         $riderProfile=RiderProfile::all();

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
        $current_timestamp = Carbon::now()->timestamp;

        try {

            $master_data=Passport::where('passport_no', '=',  $request->input('passport'))
                ->first();

            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email',
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => 'Email is already exist',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('rider_profile')->with($message);
            }

            $image=null;
            if (!empty($_FILES['image']['name'])) {
                if (!file_exists('./assets/upload/profile/images')) {
                    mkdir('./assets/upload/profile/images', 0777, true);
                }
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = $request->input('name'). $current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/profile/images/' . $image);
                $imageResized=Image::make('./assets/upload/profile/images/' . $image)->resize(250,250);
                $imageResized->save();
                $image = '/assets/upload/profile/images/' . $image;

            }

            if($master_data != null){

                $passport_data=RiderProfile::where('passport_id', '=',  $master_data->id)
                    ->first();

                if($passport_data == null){

                    $obj=new User();
                    $obj->name = $master_data->personal_info->full_name;
                    $obj->email = $request->input('email');
                    $obj->user_group_id = json_encode(["4"]);
                    $obj->password = bcrypt($request->input('password'));
                    $obj->save();


                    $obj1 = new RiderProfile();
//                $obj1->zds_code = $request->input('zds_code');
                    $obj1->passport_id = $master_data->id;
//                $obj1->passport = $request->input('passport');
                    $obj1->address = $request->input('address');
                    $obj1->contact_no = $request->input('contact_no');
                    $obj1->whatsapp = $request->input('whatsapp');
                    $obj1->user_id = $obj->id;
                    $image?$obj1->image = $image:"";
                    $obj1->save();

                    $message = [
                        'message' => 'Rider inserted Successfully',
                        'alert-type' => 'success'

                    ];
                    return redirect()->route('rider_profile')->with($message);
                }
                else{
                    $message = [
                        'message' => 'Duplicate Passport Number',
                        'alert-type' => 'error'

                    ];
                    return redirect()->route('rider_profile')->with($message);

                }



            }
            else{
                $message = [
                    'message' => 'Passport not exist in system',
                    'alert-type' => 'error'

                ];
                return redirect()->route('rider_profile')->with($message);
            }


        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'error' => $e->getMessage()
            ];
            return redirect()->route('rider_profile')->with($message);
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
        $riderProfile=RiderProfile::all();
        $riderProfileData=RiderProfile::find($id);
        
        $profile_data=RiderProfile::with(['passport:id,passport_no','passport.personal_info','user:id,email','passport.zds_code'])->latest()->get();

        return view('admin-panel.user.manage_rider_profile',compact('riderProfile','riderProfileData','profile_data'));
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


        $current_timestamp = Carbon::now()->timestamp;


        try {

            $master_data=Passport::where('passport_no', '=',  $request->input('passport'))
                ->first();

            if($master_data != null){
                $obj1 = RiderProfile::find($id);
                $validator = Validator::make($request->all(), [
                    'email' => 'unique:users,email,'.$obj1->user->id,
                ]);
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->route('rider_profile')->with($message);
                }

                $image=null;
                if (!empty($_FILES['image']['name'])) {
                    if (!file_exists('./assets/upload/profile/images')) {
                        mkdir('./assets/upload/profile/images', 0777, true);
                    }
                    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    $image = $request->input('name'). $current_timestamp . '.' . $ext;
                    move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/profile/images/' . $image);
                    $imageResized=Image::make('./assets/upload/profile/images/' . $image)->resize(250,250);
                    $imageResized->save();
                    $image = '/assets/upload/profile/images/' . $image;
                }

//                $obj1->zds_code = $request->input('zds_code');
                $obj1->address = $request->input('address');
                $obj1->contact_no = $request->input('contact_no');
                $obj1->whatsapp = $request->input('whatsapp');
                $image?$obj1->image = $image:"";
                $obj1->update();


                $obj=User::find($obj1->user->id);
                $obj->email = $request->input('email');
                $obj->update();

                if (!empty($request->password)) {
                    $obj=User::find($obj1->user->id);
                    $obj->password = bcrypt($request->input('password'));
                    $obj->update();
                }



                $message = [
                    'message' => 'Rider Updated Successfully',
                    'alert-type' => 'success'
                ];

                return redirect()->route('rider_profile')->with($message);
            }
            else{

                $message = [
                    'message' => 'Passport is wrong',
                    'alert-type' => 'error'

                ];
                return redirect()->route('rider_profile')->with($message);

            }


        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'error' => $e->getMessage()
            ];
            return redirect()->route('rider_profile')->with($message);
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
            $obj = RiderProfile::find($id);
            $obj->delete();


            $obj1 = User::find($obj->user->id);
            $obj1->delete();
            $message = [
                'message' => 'Rider Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('rider_profile')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('rider_profile')->with($message);
        }
    }

    public function getProfile()
    {
        $id = Auth::user()->id;

        $user = User::where('id',$id)
            ->with('profile.passport.personal_info')
            ->first();

        return response()->json(['data'=>$user], 200, [], JSON_NUMERIC_CHECK);
    }

    public function updateProfile(Request $request,$id){

        $response = [];

        $current_timestamp = Carbon::now()->timestamp;

        try {
            $obj1 = RiderProfile::find($id);
            $validator = Validator::make($request->all(), [
                'email' => 'unique:users,email,'. $obj1->user->id,
            ]);
            if ($validator->fails()) {

                $response['error'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }

            $image=null;
            if (!empty($_FILES['image']['name'])) {
                if (!file_exists('./assets/upload/profile/images')) {
                    mkdir('./assets/upload/profile/images', 0777, true);
                }
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $image = $request->input('name'). $current_timestamp.'.'.$ext;
                move_uploaded_file($_FILES["image"]["tmp_name"], './assets/upload/profile/images/' . $image);
                $imageResized=Image::make('./assets/upload/profile/images/'.$image)->resize(250,250);
                $imageResized->save();
                $image = '/assets/upload/profile/images/'.$image;

            }


            $obj1->address = $request->input('address');
            $obj1->contact_no = $request->input('contact_no');
            $obj1->whatsapp = $request->input('whatsapp');
            $image?$obj1->image = $image:"";
            $obj1->save();


            $obj=User::find($obj1->user->id);
            $obj->email = $request->input('email');
            $obj->save();



            $response['success'] = 1;
            $response['message'] = "Profile Updated Successfully";
            return response()->json($response);


        } catch (\Illuminate\Database\QueryException $e) {
            $response['error'] = 1;
            $response['message'] = $e->getMessage();
            return response()->json($response);
        }

    }
}
