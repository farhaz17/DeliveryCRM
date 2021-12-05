<?php

namespace App\Http\Controllers\Passport;

use App\Model\Assign\AssignBike;
use App\Model\Nationality;
use App\Model\Passport\AttachmentTypes;
use App\Model\Passport\CorrectPassport;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Passport\PassportAdditional;
use App\Model\Passport\RenewPassport;
use App\Model\Types;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Assign\AssignPlateform;
use Illuminate\Support\Facades\Validator;

class ViewPassportController extends Controller
{

    function __construct()
    {

        $this->middleware('role_or_permission:Admin|passport-passport-view', ['only' => ['index','store','destroy']]);
        $this->middleware('role_or_permission:Admin|passport-passport-edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Admin|passport-passport-history', ['only' => ['passport_history']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $passport=Passport::where('canceL_status','=','0')->with(['personal_info','zds_code', 'nation', 'renew_pass', 'wrong_pass'])->latest()->get();
        $cancel_passport=Passport::where('canceL_status','=','1')->get();
        $remain_additional_info = Passport::whereNull('dob')
                                               ->whereNull('place_birth')
                                               ->whereNull('place_issue')
                                               ->whereNull('date_issue')
                                               ->whereNull('date_expiry')
                                               ->whereNull('passport_pic')
                                                ->count();
        return view('admin-panel.passport.view_passport',compact('remain_additional_info','passport','cancel_passport'));
    }

    public function rider_no_platform(){

        $assignmnet_ids = AssignPlateform::where('status','=','1')->pluck('passport_id')->toArray();


        $passport=Passport::where('canceL_status','=','0')->whereNotIn('id',$assignmnet_ids)->with(['personal_info','zds_code'])->latest()->get();

        return view('admin-panel.assigning.assign_report.rider_not_platform',compact('passport'));

    }


    public function ajax_additional_info_remains(){

        $passport = Passport::whereNull('dob')
            ->whereNull('place_birth')
            ->whereNull('place_issue')
            ->whereNull('date_issue')
            ->whereNull('date_expiry')
            ->whereNull('passport_pic')
            ->get();

          $view = view('admin-panel.passport.ajax_additional_info_remains',compact('passport'))->render();

        return response()->json(['html' => $view]);
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
        //

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
        $passport=Passport::all();
        $edit_passport=Passport::find($id);
        $additional =PassportAdditional::where('nation_id',$edit_passport->nation_id)->get();
        $attachment=AttachmentTypes::all();
        $edit_additional = passport_addtional_info::where('passport_id',$id)->first();
        $nation=Nationality::all();
        return view('admin-panel.passport.passport_edit',compact('edit_passport','passport','additional','attachment','edit_additional','nation','id'));
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

        if ($request->input('correct_passport_number')==null) {
            $passport_no = $request->input('renew_passport_number');


            $validator = Validator::make($request->all(), [
                'renew_passport_number' => 'unique:renew_passports,renew_passport_number',
                'renew_passport_issue_date' => 'required:renew_passports,renew_passport_issue_date',
                'renew_passport_expiry_date' => 'required:renew_passports,renew_passport_expiry_date'
            ]);
            if ($validator->fails()) {
//                $validate->first()
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            //passport number validation

            $passport_num = Passport::where('passport_no', $passport_no)->first();

            if ($passport_num != null) {
                $message = [
                    'message' => 'Passport number is already exist',
                    'alert-type' => 'error',

                ];
                return redirect()->back()->with($message);
            }


            if (!file_exists('../public/assets/upload/passport_renew_attachment/')) {
                mkdir('../public/assets/upload/passport_renew_attachment/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/passport_renew_attachment/' . $file_name);
            $file_path = 'assets/upload/passport_renew_attachment/' . $file_name;


            $passport = Passport::where('id', $id)->first();
            $passport_id = $passport->id;
            $old_passport_no=$passport->passport_no;
            $old_pass_expiry=$passport->date_expiry;
            $old_pass_issue=$passport->date_expiry;
            $old_pass_pic=$passport->passport_pic;

            //Add older passport details into renew passport table  as history


            $obj = new RenewPassport();
            $obj->passport_id = $id;
            $obj->renew_passport_number = $old_passport_no;
            $obj->renew_passport_issue_date = $old_pass_issue;
            $obj->renew_passport_expiry_date = $old_pass_expiry;
            $obj->attachment = $old_pass_pic;
            $obj->save();
            //update passport table with renew passport details
            $obj = Passport::find($id);
            $obj->passport_no = $request->input('renew_passport_number');
            $obj->date_issue = $request->input('renew_passport_issue_date');
            $obj->date_expiry = $request->input('renew_passport_expiry_date');
            $obj->passport_pic = $file_path;
            $obj->save();
            $message = [
                'message' => 'Renew Passport Details  Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
        }

        else{

            $validator = Validator::make($request->all(), [


                'correct_passport_number' => 'unique:correct_passports,passport_number',

            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }


            $passport = Passport::where('id', $id)->first();
            $passport_id = $passport->id;
            $old_passport_no=$passport->passport_no;


            //save older or wrong passport number into this table as history
            $obj= new CorrectPassport();
            $obj->passport_id = $passport_id;
            $obj->passport_number = $old_passport_no;

            $obj->save();

            //update passport table with correct passport details
            $obj = Passport::find($id);
            $obj->passport_no = $request->input('correct_passport_number');
            $obj->save();

            $message = [
                'message' => 'Correct Passport Number Added Successfully',
                'alert-type' => 'success'
            ];
            return back()->with($message);
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


    public function edit_get_passport(Request $request){
        $pass = Passport::find($request->passport_id);
        $response = $pass->sur_name."$".$pass->given_names;
        return $response;

    }


    public function ajax_passport_edit(Request $request){


        $id = $request->id;
        $edit_passport = Passport::where('id',$id)->first();
        $edit_additional = passport_addtional_info::where('passport_id',$id)->first();
        $attachment=AttachmentTypes::all();

        $view = view("admin-panel.passport.ajax_passport_edit",compact('edit_passport','id','edit_additional','attachment'))->render();

        return response()->json(['html'=>$view]);


    }

    public function passport_history(){
        //
        $passport=Passport::where('is_cancel','=','0')->get();
        $cancel_passport=Passport::where('is_cancel','=','1')->get();
        $id_array = array(17,18,19,20);
        $nationality=Nationality::whereIn('id',$id_array)->get();

        $renew=RenewPassport::all();
        $correct=CorrectPassport::all();


        return view('admin-panel.passport.passport_history',compact('passport','nationality','cancel_passport','renew','correct'));

    }




    //update older code


//    public function update(Request $request, $id)
//
//    {
//
//
//        if ($request->input('nation')==null && $request->input('correct_passport_number')==null) {
//            $passport_no = $request->input('renew_passport_number');
//
//
//            $validator = Validator::make($request->all(), [
//                'renew_passport_number' => 'unique:renew_passports,renew_passport_number',
//                'renew_passport_issue_date' => 'required:renew_passports,renew_passport_issue_date',
//                'renew_passport_expiry_date' => 'required:renew_passports,renew_passport_expiry_date'
//            ]);
//            if ($validator->fails()) {
////                $validate->first()
//                $validate = $validator->errors();
//                $message = [
//                    'message' => "Fill Required Fields",
//                    'alert-type' => 'error',
//                    'error' => $validate->first()
//                ];
//                return redirect()->back()->with($message);
//            }
//
//            //passport number validation
//
//            $passport_num = Passport::where('passport_no', $passport_no)->first();
//
//            if ($passport_num != null) {
//                $message = [
//                    'message' => 'Passport number is already exist',
//                    'alert-type' => 'error',
//
//                ];
//                return redirect()->back()->with($message);
//            }
//
//
//            if (!file_exists('../public/assets/upload/passport_renew_attachment/')) {
//                mkdir('../public/assets/upload/passport_renew_attachment/', 0777, true);
//            }
//
//            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
//            $file_name = time() . "_" . $request->date . '.' . $ext;
//
//            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/passport_renew_attachment/' . $file_name);
//            $file_path = 'assets/upload/passport_renew_attachment/' . $file_name;
//
//
////            $passport = Passport::where('id', $id)->first();
////            $passport_id = $passport->id;
//
//            $obj = new RenewPassport();
//
//            $obj->passport_id = $id;
//            $obj->renew_passport_number = $request->input('renew_passport_number');
//            $obj->renew_passport_issue_date = $request->input('renew_passport_issue_date');
//            $obj->renew_passport_expiry_date = $request->input('renew_passport_expiry_date');
//            $obj->attachment = $file_path;
//            $obj->save();
//            $message = [
//                'message' => 'Renew Passport  Added Successfully',
//                'alert-type' => 'success'
//            ];
//            return back()->with($message);
//        }
//
//        elseif($request->input('correct_passport_number')==null){
//
//            $validator = Validator::make($request->all(), [
//
//                'nation' => 'required:passports,nation_id',
//
//            ]);
//            if ($validator->fails()) {
//
//                $validate = $validator->errors();
//                $message = [
//                    'message' => "Fill Required Fields",
//                    'alert-type' => 'error',
//                    'error' => $validate->first()
//                ];
//                return redirect()->back()->with($message);
//            }
//
//            $obj = Passport::find($id);
//            $obj->nation_id=$request->input('nation');
//            $obj->save();
//            $message = [
//                'message' => 'Nationality Updated!!',
//                'alert-type' => 'success'
//            ];
//            return back()->with($message);
//
//        }
//        else{
//
//            $validator = Validator::make($request->all(), [
//
//
//                'correct_passport_number' => 'unique:correct_passports,passport_number',
//
//            ]);
//            if ($validator->fails()) {
//
//                $validate = $validator->errors();
//                $message = [
//                    'message' => $validate->first(),
//                    'alert-type' => 'error',
//                    'error' => $validate->first()
//                ];
//                return redirect()->back()->with($message);
//            }
//
//            $obj= new CorrectPassport();
//            $obj->passport_id = $id;
//            $obj->passport_number = $request->input('correct_passport_number');
//            $obj->save();
//
//
//            $message = [
//                'message' => 'Correct Passport Number Added Successfully',
//                'alert-type' => 'success'
//            ];
//            return back()->with($message);
//        }
//    }
}
