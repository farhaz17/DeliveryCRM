<?php

namespace App\Http\Controllers\DrivingLicense;

use App\Model\Agreement\Agreement;
use App\Model\Cities;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\Guest\Career;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mockery\Generator\StringManipulation\Pass\Pass;
use Illuminate\Support\Facades\Storage;
use Image;

class DrivingLicenseController extends Controller
{



    function __construct()
    {
        $this->middleware('role_or_permission:Admin|driving-license', ['only' => ['index','store','destroy','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $passports = Passport::select('passports.*')->leftjoin('driving_licenses','driving_licenses.passport_id','=','passports.id')->whereNull('driving_licenses.passport_id')->get();

        $driving_license = DrivingLicense::with(array('passport' => function($query){
            $query->select(['id','passport_no'])->with('personal_info:id,passport_id,full_name');
        }))->orderby('id','desc')->get();

        // $all_passports = Passport::where('is_cancel','=','0')->get();

        // $career_array = Career::where('licence_status','=','1')->whereNotNull('passport_no')->pluck('passport_no')->toArray();

//        $passport_ids = Passport::whereIn('passport_no',$career_array)->pluck('id')->toArray();

        // $already_driving_licence = DrivingLicense::pluck('passport_id')->toArray();

    //    $passport_pending = Passport::whereIn('passport_no',$career_array)->whereNotIn('id',$already_driving_licence)->pluck('passport_no')->toArray();

//       $passport_pending = $career_array;

        return view('admin-panel.driving_license.index',compact('driving_license'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            $cities  = Cities::all();

        return view('admin-panel.driving_license.create',compact('cities'));
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
             $passport_with_career_id = Passport::where('id','=',$request->user_passport_id)->first();

             if($passport_with_career_id->career_id>0){
                  $career = Career::where('id','=',$passport_with_career_id->career_id)
                                    ->where('applicant_status','!=','5')
                                    ->where('employee_type','=','1')
                                    ->where('licence_status','=','2')
                                    ->whereNUll('career_bypass')
                                    ->first();

                    if($career != null){

                        $message = [
                            'message' => "For this rider create driving licence from  NEED TO TAKE LICNECE tab ",
                            'alert-type' => 'error'
                        ];
                        return redirect()->back()->with($message);

                    }

             }


            $validator = Validator::make($request->all(), [
                'user_passport_id' => 'unique:driving_licenses,passport_id',
                'license_number' => 'required',
                'issue_date' => 'required',
                'license_type' => 'required',
                'expire_date' => 'required',
                'place_issue' => ['required'],
                'image' => 'mimes:jpeg,jpg,png,gif',
                'image_back' => 'mimes:jpeg,jpg,png,gif'

            ]);

             $driving_licences = DrivingLicense::where('license_number','=',$request->license_number)
                                                 ->where('place_issue','=',$request->place_issue)->first();
              if($driving_licences != null) {
                $message = [
                    'message' => "licence number already be taken",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
              }

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }


            $passport_id = $request->user_passport_id;









            if(!empty($_FILES['image']['name'])) {

                // $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                // $file_name = time() . "_" . $request->date . '.' . $ext;

                // move_uploaded_file($_FILES["image"]["tmp_name"], '../public/assets/upload/driving_licence_img/front/' . $file_name);
                // $file_path_image = 'assets/upload/driving_licence_img/front/' . $file_name;
                $img = $request->file('image');
                $file_path_image = 'assets/upload/driving_licence_img/front/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_image, $imageS3->stream());
            }



            // if(!file_exists('../public/assets/upload/driving_licence_img/back')) {
            //     mkdir('../public/assets/upload/driving_licence_img/back', 0777, true);
            // }

            if(!empty($_FILES['image_back']['name'])) {

                // $ext = pathinfo($_FILES['image_back']['name'], PATHINFO_EXTENSION);
                // $file_name = time() . "_" . $request->date . '.' . $ext;

                // move_uploaded_file($_FILES["image_back"]["tmp_name"], '../public/assets/upload/driving_licence_img/back/' . $file_name);
                // $file_path_image_back = 'assets/upload/driving_licence_img/back/' . $file_name;
                $img = $request->file('image_back');
                $file_path_image_back = 'assets/upload/driving_licence_img/back/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_image_back, $imageS3->stream());
            }


            $driving_license = new DrivingLicense();

            $driving_license->passport_id = $passport_id;
            $driving_license->license_number = $request->license_number;
            $driving_license->issue_date = date('Y-m-d', strtotime($request->issue_date));
            $driving_license->expire_date = date('Y-m-d', strtotime($request->expire_date));
            $driving_license->place_issue = $request->place_issue;
            $driving_license->traffic_code = $request->traffic_cod;
            $driving_license->license_type = $request->license_type;
            if(!empty($file_path_image)){
                $driving_license->image =   $file_path_image;
            }
            if(!empty($file_path_image_back)){
                $driving_license->back_image =   $file_path_image_back;
            }


            if($request->license_type > 1){
                $driving_license->car_type = $request->car_type;
            }
            $driving_license->save();



            $agreement_status = 0;
            $agreement = Agreement::where('passport_id','=',$passport_id)->first();

            if($agreement != null){
                $agreement_status = '1';
            }





            $message = [
                'message' => 'License has been saved successfully',
                'alert-type' => 'success',
            ];
            return redirect()->back()->with($message);


        }
        catch (\Illuminate\Database\QueryException $e){
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


        try {
        $validator = Validator::make($request->all(), [
            'edit_license_number' => 'required',
            'edit_traffic_cod' => 'required|unique:driving_licenses,traffic_code,'.$id,
            'edit_place_issue' => 'required',
            'edit_issue_date' => 'required',
            'edit_expire_date' => 'required',
            'image_update' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'image_back_update' => 'mimes:jpeg,jpg,png,gif|max:10000'

        ]);

        $driving_licences = DrivingLicense::where('license_number','=',$request->edit_license_number)
        ->where('place_issue','=',$request->place_issue)->where('id','!=',$id)->first();

        if($driving_licences != null) {
                    $message = [
                    'message' => "licence number already be taken",
                    'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
         }



        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->route('driving_license')->with($message);
        }

        // if (!file_exists('../public/assets/upload/driving_licence_img/front')) {
        //     mkdir('../public/assets/upload/driving_licence_img/front', 0777, true);
        // }

        if(!empty($_FILES['image_update']['name'])) {

            // $ext = pathinfo($_FILES['image_update']['name'], PATHINFO_EXTENSION);
            // $file_name = time() . "_" . $request->date . '.' . $ext;

            // move_uploaded_file($_FILES["image_update"]["tmp_name"], '../public/assets/upload/driving_licence_img/front/' . $file_name);
            // $file_path_image = 'assets/upload/driving_licence_img/front/' . $file_name;
            $img = $request->file('image_update');
            $file_path_image = 'assets/upload/driving_licence_img/front/' .time() . '.' . $img ->getClientOriginalExtension();

            $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                            $constraint->aspectRatio();
                        });

            Storage::disk("s3")->put($file_path_image, $imageS3->stream());
        }

        if (!file_exists('../public/assets/upload/driving_licence_img/back')) {
            mkdir('../public/assets/upload/driving_licence_img/back', 0777, true);
        }

        if(!empty($_FILES['image_back_update']['name'])) {

            // $ext = pathinfo($_FILES['image_back_update']['name'], PATHINFO_EXTENSION);
            // $file_name = time() . "_" . $request->date . '.' . $ext;

            // move_uploaded_file($_FILES["image_back_update"]["tmp_name"], '../public/assets/upload/driving_licence_img/back/' . $file_name);
            // $file_path_image_back = 'assets/upload/driving_licence_img/back/' . $file_name;
            $img = $request->file('image_back_update');
            $file_path_image_back = 'assets/upload/driving_licence_img/back/' .time() . '.' . $img ->getClientOriginalExtension();

            $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                            $constraint->aspectRatio();
                        });

            Storage::disk("s3")->put($file_path_image_back, $imageS3->stream());
        }





        $driving_license  =  DrivingLicense::find($id);

        $driving_license->license_number = $request->edit_license_number;
        $driving_license->issue_date = date('Y-m-d', strtotime($request->edit_issue_date));
        $driving_license->expire_date =  date('Y-m-d', strtotime($request->edit_expire_date));
        $driving_license->place_issue = $request->edit_place_issue;
        $driving_license->traffic_code = $request->edit_traffic_cod;

        $driving_license->license_type =  $request->edit_license_type;
        if($request->edit_license_type=="1"){
            $driving_license->car_type =  null;
        }else{
            $driving_license->car_type =  $request->edit_car_type;
        }


        if(!empty($file_path_image)){
            $driving_license->image =  $file_path_image;
        }
        if(!empty($file_path_image_back)){
            $driving_license->back_image =  $file_path_image_back;
        }

        $driving_license->update();


        $message = [
            'message' => 'License has been Updated successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('driving_license')->with($message);


        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('driving_license')->with($message);
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

    public function ajax_driving_license_detail(Request $request){

        $id = $request->primary_id;
        $dirve = DrivingLicense::find($id);

        $issue_date = explode(" ",$dirve->issue_date);
        $expire_date = explode(" ",$dirve->expire_date);
        $gamer= array(
            'passport_id' => $dirve->passport_id,
            'passport_no' => $dirve->passport->passport_no,
            'place_issue' => $dirve->place_issue,
            'issue_date' => $issue_date[0],
            'expire_date' => $expire_date[0],
            'license_number' => $dirve->license_number,
            'traffic_code' => $dirve->traffic_code,
            'license_type' => $dirve->license_type,
            'car_type' => $dirve->car_type,
        );

        echo json_encode($gamer);
        exit;

    }



        public function autocomplete_driving_passport_passport(Request $request){


            $already_driving_passports = DrivingLicense::pluck('passport_id')->toArray();

            $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
                ->whereNotIn('passports.id',$already_driving_passports)
                ->get();

            if (count($passport_data)=='0')
            {
                // return "pp";
                $puid_data =Passport::select('passports.pp_uid','passports.passport_no')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                    ->whereNotIn('passports.id',$already_driving_passports)
                    ->get();
                if (count($puid_data)=='0')
                {
                    $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->whereNotIn('passports.id',$already_driving_passports)
                        ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                        ->get();
                    if (count($full_data)=='0')
                    {
                        $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->whereNotIn('passports.id',$already_driving_passports)
                            ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                            ->get();

                        //zds code response
                        $pass_array=array();
                        foreach ($zds_data as $pass){
                            $gamer = array(
                                'name' => isset($pass->zds_code) ? $pass->zds_code : '',
                                'passport' => $pass->passport_no,
                                'ppuid' => $pass->pp_uid,
                                'full_name' => $pass->full_name,
                                'type'=>'3',
                            );
                            $pass_array[]= $gamer;
                        }
                        return response()->json($pass_array);

                    }

                    //full name response
                    $pass_array=array();
                    foreach ($full_data as $pass){
                        $gamer = array(
                            'name' => $pass->full_name,
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
                            'type'=>'2',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);

                }
                //ppuid response

                $pass_array=array();
                foreach ($puid_data as $pass){
                    $gamer = array(
                        'name' => $pass->pp_uid,
                        'passport' => $pass->passport_no,
                        'full_name' => $pass->full_name,
                        'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
                        'type'=>'1',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);
            }


            //passport number response
            $pass_array=array();
            foreach ($passport_data as $pass){
                $gamer = array(
                    'name' => $pass->passport_no,
                    'ppuid' => $pass->pp_uid,
                    'full_name' => $pass->full_name,
                    'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
                    'type'=>'0',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);

        }



}
