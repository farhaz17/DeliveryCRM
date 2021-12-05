<?php

namespace App\Http\Controllers\Passport;

use App\Bike;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\BikeDetail;
use App\Model\Guest\Career;
use App\Model\Master\Category;
use App\Model\Master\CategoryAssign;
use App\Model\Master\SubCategory;
use App\Model\Nationality;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\Passport\AttachmentTypes;
use App\Model\Passport\Passport;
use App\Model\Passport\Passport_add_values;
use App\Model\Passport\passport_addtional_info;
use App\Model\Passport\PassportAdditional;
use App\Model\Passport\Ppuid;
use App\Model\Passport\PpuidIssue;
use App\Model\Passport_Add_Value;
use App\Model\PassportAttachment\PassportAttachment;
use App\Model\Platform;
use App\Model\Referal\Referal;
use App\Model\Telecome;
use App\Model\Types;
use App\Model\UserCodes\UserCodes;
use Carbon\Carbon;
use http\Client\Curl\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VisaProcess\OwnVisa\OwnVisaCurrentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Mockery\Generator\StringManipulation\Pass\Pass;
use phpDocumentor\Reflection\Types\Null_;
use function GuzzleHttp\Promise\all;

class PassportController extends Controller
{


    function __construct()
    {

        $this->middleware('role_or_permission:Admin|master-ppuids', ['only' => ['ppuid']]);
        $this->middleware('role_or_permission:Admin|passport-passport-create', ['only' => ['store','index']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function passport_dashboard(){

    return  view('admin-panel.passport.dashboard.index');
    }

    public function index()
    {

        $nation=Nationality::all();
        $passport=Passport::all();
        $types=Types::all();
        $attachment=AttachmentTypes::all();

        $all_passports = Career::where('applicant_status','=','4')->get();

        $pending_passports = array();

        foreach ($all_passports as $pass){
            $curent_passport = Passport::where('passport_no','=',$pass->passport_no)->first();
            if($curent_passport==null){
                $gamer = array(
                    'passport_number' => $pass->passport_no,
                );

                $pending_passports[] = $gamer;
            }

        }

        $category_assigns  = SubCategory::whereIn('main_category',[1,2])->get();

        return view('admin-panel.passport.passport',compact('category_assigns','nation','types','passport','pending_passports','attachment'));
    }

    public function get_the_designation_by_subcategory(Request  $request){

        if($request->ajax()){

            $primay_id = $request->primary_id;

            $desginations = SubCategory::where('sub_category',$primay_id)->get();


            echo json_encode($desginations);

            exit;

        }

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $passport_no = $request->input('passport_no');

        $validator = Validator::make($request->all(), [
             'passport_no' => 'nullable|unique:passports,passport_no',
             'dob' => 'nullable|date',
             'date_issue' => 'nullable|date',
             'date_expiry' => 'nullable|date',
             'designation_id' => 'required',
             'designation_category' => 'required',
             'visa_status' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        $first_five_digit_passport =  substr($request->passport_no, 0, 5);

        $check_five_passport = Passport::where('passport_no','Like',$first_five_digit_passport."%")->first();

        if($check_five_passport != null){

                $message = [
                    'message' => "First Five digit of passport no is already exist",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
        }


        $obj = new Passport();

        if(!empty($request->input('visa_status'))){
            $obj->visa_status = trim($request->input('visa_status'));
        }

        if($request->input('visa_status')=="1"){
            $validator = Validator::make($request->all(), [
                'visit_visa_status' => 'required',
                'visit_exit_date' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
            $obj->visa_status_visit = trim($request->input('visit_visa_status'));
            $obj->exit_date = trim($request->visit_exit_date);

        }elseif($request->input('visa_status')=="2"){
            $validator = Validator::make($request->all(), [
                'cancel_visa_status' => 'required',
                'cancel_fine_date' => 'required'
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

            }
            $obj->visa_status_cancel = trim($request->input('cancel_visa_status'));
            $obj->exit_date = trim($request->cancel_fine_date);

        }elseif($request->input('visa_status')=="3"){
            $validator = Validator::make($request->all(), [
                'own_visa_status' => 'required'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

            }
            $obj->visa_status_own = trim($request->input('own_visa_status'));
        }


        if (!file_exists('../public/assets/upload/passport_pic/')) {
            mkdir('../public/assets/upload/passport_pic/', 0777, true);
        }

        $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $request->date . '.' . $ext;

        move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/passport_pic/' . $file_name);
        $file_path = 'assets/upload/passport_pic/' . $file_name;

//   ---------------------attachment file saving--------------------

        if (!file_exists('../public/assets/upload/passport_attachment/')) {
            mkdir('../public/assets/upload/passport_attachment/', 0777, true);
        }

        $ext1 = pathinfo($_FILES['attachment_file']['name'], PATHINFO_EXTENSION);
        $file_name1 = time() . "_" . $request->date . '.' . $ext1;

        move_uploaded_file($_FILES["attachment_file"]["tmp_name"], '../public/assets/upload/passport_attachment/' . $file_name1);
        $file_path1 = 'assets/upload/passport_attachment/' . $file_name1;




//            $obj = new Passport();
            $count = $request->input('nation_id');

            $ppuid = IdGenerator::generate(['table' => 'passports', 'field' => 'pp_uid', 'length' => 7, 'prefix' => 'PP5']);


            $obj->passport_category = $request->input('passport_category');
            $obj->nation_id = $request->input('nation_id');
            $obj->pp_uid = $ppuid;
            $obj->country_code = $request->input('country_code');
            $obj->passport_no = $request->input('passport_no');
            $obj->sur_name = $request->input('sur_name');
            $obj->given_names = $request->input('given_names');
            $obj->father_name = $request->input('father_name');
            $obj->dob =  date('Y-m-d', strtotime($request->input('dob')));
            $obj->place_birth = $request->input('place_birth');
            $obj->place_issue = $request->input('place_issue');
            $obj->date_issue = date('Y-m-d', strtotime($request->input('date_issue')));
            $obj->date_expiry = date('Y-m-d', strtotime($request->input('date_expiry')));
            $obj->passport_pic = $file_path;

            $obj->citizenship_no = $request->input('citizenship_no');
            $obj->personal_address = $request->input('personal_address');
            $obj->permanant_address = $request->input('permanant_address');
            $obj->booklet_number = $request->input('booklet_number');
            $obj->tracking_number = $request->input('tracking_number');
            $obj->name_of_mother = $request->input('name_of_mother');
            $obj->relationship = $request->input('relationship');
            $obj->middle_name = $request->input('middle_name');

            $career  = Career::where('passport_no','=',$request->input('passport_no'))->first();

            if($career != null){
                $obj->career_id = $career->id;
            }

            $obj->employee_category = $request->designation_id;
            $obj->save();
            $passport_id = $obj->id;
            $sir_name=$request->input('sur_name');
            $given_name=$request->input('given_names');
            $father_name=$request->input('father_name');
            if ($sir_name==null){
                $full_name=$given_name." ".$father_name;
            }
            else{
                $full_name=$given_name." ".$sir_name." ".$father_name;
            }


        $is_already = CategoryAssign::where('passport_id','=',$passport_id)->first();
        if($is_already == null) {

            $category_assign = new CategoryAssign();
            $category_assign->passport_id = $passport_id;
            $category_assign->assign_started_at = Carbon::now();
            $category_assign->main_category = 1 ; // main category Office = 1
            $category_assign->sub_category1 = $request->designation_category ;
            $category_assign->sub_category2 = $request->designation_id;
            $category_assign->save();

        }




            //Aditional information
         if (!file_exists('../public/assets/upload/passport_info_image/')) {
            mkdir('../public/assets/upload/passport_info_image/', 0777, true);
         }
        $ext2 = pathinfo($_FILES['file_name2']['name'], PATHINFO_EXTENSION);
        $file_name2 = time() . "_" . $request->date . '.' . $ext2;
        move_uploaded_file($_FILES["file_name2"]["tmp_name"], '../public/assets/upload/passport_info_image/' . $file_name2);
        $file_path2 = 'assets/upload/passport_info_image/' . $file_name2;
            $pass_id = Passport::where('passport_no', $passport_no)->first();
            $obj2 = new passport_addtional_info();
            $obj2->passport_id = $pass_id->id;
            $obj2->full_name = $full_name;
            $obj2->nat_name = $request->input('nat_name');
            $obj2->nat_relation = $request->input('nat_relation');
            $obj2->nat_address = $request->input('nat_address');
            $obj2->nat_phone = $request->input('nat_phone');
            $obj2->nat_whatsapp_no = $request->input('nat_whatsapp_no');
            $obj2->nat_email = $request->input('nat_email');
            $obj2->inter_name = $request->input('inter_name');
            $obj2->inter_relation = $request->input('inter_relation');
            $obj2->inter_address = $request->input('inter_address');
            $obj2->inter_phone = $request->input('inter_phone');
            $obj2->inter_whatsapp_no = $request->input('inter_whatsapp_no');
            $obj2->inter_email = $request->input('inter_email');
            $obj2->personal_mob = $request->input('personal_mob');
            $obj2->personal_email = $request->input('personal_email');
            $obj2->personal_image = $file_path2;
            $obj2->save();
        $obj3 = new PassportAttachment();
        $obj3->attachment_name = $file_path1;
        $obj3->table_id = $obj->id;
        $obj3->save();
        DB::table('passports')->where('id', $obj->id)
         ->update(['attachment_id' =>$obj3->id,'attachment_name'=>$request->input('attachment_name')]);
          $career = Career::where('passport_no','=',$request->input('passport_no'))->first();
        if($career != null){

        /*    $onboard = new OnBoardStatus();
            $0->passport_id = $obj->id;
            $onboard->save();*/
        }
        $passport_number = $request->input('passport_no');

        $ref= Referal::where('passport_no',$passport_no)->first();
        if ($ref!=null){
            Referal::where('passport_no','=',$passport_number)
                ->update(['status'=>'2']);
        }

            $message = [
                'message' => 'Passport Saved Successfully',
                'alert-type' => 'success',

            ];
            return redirect()->back()->with($message);


    }

    public function rider_dont_have_visa(){
        $rider_not_visas = Passport::where('career_id','=','0')->whereNull('visa_status')->orderby('id','desc')->get();
        return view('admin-panel.passport.rider_dont_have_visa',compact('rider_not_visas'));
    }



    public function passport_update_only_visa_status(Request  $request){

        if($request->ajax()){


            $validator = Validator::make($request->all(), [
                'visa_status' => 'required',
                'primary_id_selected' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();

                return $validate->first();
            }


            $obj = Passport::find($request->primary_id_selected);

            if(!empty($request->input('visa_status'))){
                $obj->visa_status = trim($request->input('visa_status'));
            }

            if($request->input('visa_status')=="1"){
                $validator = Validator::make($request->all(), [
                    'visit_visa_status' => 'required',
                    'visit_exit_date' => 'required',
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                }
                $obj->visa_status_visit = trim($request->input('visit_visa_status'));
                $obj->exit_date = trim($request->visit_exit_date);

            }elseif($request->input('visa_status')=="2"){
                $validator = Validator::make($request->all(), [
                    'cancel_visa_status' => 'required',
                    'cancel_fine_date' => 'required'
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                }
                $obj->visa_status_cancel = trim($request->input('cancel_visa_status'));
                $obj->exit_date = trim($request->cancel_fine_date);

            }elseif($request->input('visa_status')=="3"){
                $validator = Validator::make($request->all(), [
                    'own_visa_status' => 'required'
                ]);
                if ($validator->fails()) {
                    return $validator->errors()->first();
                }
                $obj->visa_status_own = trim($request->input('own_visa_status'));
            }

            $obj->update();

            return "success";



        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
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

        $validator = Validator::make($request->all(), [
            'passport_no' => 'unique:passports,passport_no,'.$id,
            'dob' => 'nullable|date',
            'date_issue' => 'nullable|date',
            'date_expiry' => 'nullable|date',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message_error = "";

            foreach ($validate->all() as $error){
                $message_error .= $error;
            }

            $validate = $validator->errors();
            $message = [
                'message' => $message_error,
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

        if (empty($_FILES['file_name']['name'])) {
            $file_path=$request->input('file_name');
            }
        else{

        if (!file_exists('../public/assets/upload/passport_pic/')) {
            mkdir('../public/assets/upload/passport_pic/', 0777, true);
        }

        $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $request->date . '.' . $ext;

        move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/passport_pic/' . $file_name);
        $file_path = 'assets/upload/passport_pic/' . $file_name;
        }

        $obj = Passport::find($id);
        $obj->nation_id=$request->input('nationality');
        $obj->country_code=$request->input('country_code');
        $obj->country_code=$request->input('country_code');
        $obj->passport_no=$request->input('passport_no');
        $obj->sur_name=$request->input('sur_name');
        $obj->given_names=$request->input('given_names');
        $obj->father_name=$request->input('father_name');
        $obj->dob=$request->input('dob');
        $obj->place_birth=$request->input('place_birth');
        $obj->place_issue=$request->input('place_issue');
        $obj->date_issue=$request->input('date_issue');
        $obj->date_expiry=$request->input('date_expiry');
        $obj->date_issue=$request->input('date_issue');
        $obj->passport_pic=$file_path;
        $obj->citizenship_no = $request->input('citizenship_no');
        $obj->personal_address = $request->input('personal_address');
        $obj->permanant_address = $request->input('permanant_address');
        $obj->booklet_number = $request->input('booklet_number');
        $obj->tracking_number = $request->input('tracking_number');
        $obj->name_of_mother = $request->input('name_of_mother');
        $obj->relationship = $request->input('relationship');
        $obj->middle_name = $request->input('middle_name');
        $obj->next_of_kin = $request->input('next_of_kin');
        $obj->attachment_name = $request->input('attachment_name');
        $obj->save();




        //update Passport Additional Info



        $add_id=$request->input('additional_id');
        if (empty($_FILES['file_name2']['name'])) {
            $file_path=$request->input('temp_file');
        }
        else{

            if (!file_exists('../public/assets/upload/passport_info_image/')) {
                mkdir('../public/assets/upload/passport_info_image/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name2']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name2"]["tmp_name"], '../public/assets/upload/passport_info_image/' . $file_name);
            $file_path = 'assets/upload/passport_info_image/' . $file_name;
        }


        $sir_name=$request->input('sur_name');
        $given_name=$request->input('given_names');
        $father_name=$request->input('father_name');
        if ($sir_name==null){
            $full_name=$given_name." ".$father_name;
        }
        else{
            $full_name=$given_name." ".$sir_name." ".$father_name;
        }


        $obj = passport_addtional_info::find($add_id);
        $obj->full_name=$full_name;
        $obj->nat_name=$request->input('nat_name');
        $obj->nat_relation=$request->input('nat_relation');
        $obj->nat_address=$request->input('nat_address');
        $obj->nat_phone=$request->input('nat_phone');
        $obj->nat_whatsapp_no=$request->input('nat_whatsapp_no');
        $obj->nat_email=$request->input('nat_email');
        $obj->inter_name=$request->input('inter_name');
        $obj->inter_relation=$request->input('inter_relation');
        $obj->inter_address=$request->input('inter_address');
        $obj->inter_phone=$request->input('inter_phone');
        $obj->inter_email=$request->input('inter_email');
        $obj->inter_phone=$request->input('inter_phone');
        $obj->personal_mob=$request->input('personal_mob');
        $obj->personal_email=$request->input('personal_email');
        $obj->personal_image=$file_path;

        $obj->save();


        $att_id=$request->input('attachment_id');

        if ($att_id != null){
        if (empty($_FILES['file_name3']['name'])) {
            $file_path = $request->input('temp_file2');
        }
        else {
            if (!file_exists('../public/assets/upload/passport_attachment/')) {
                mkdir('../public/assets/upload/passport_attachment/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name3']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name3"]["tmp_name"], '../public/assets/upload/passport_attachment/' . $file_name);
            $file_path = 'assets/upload/passport_attachment/' . $file_name;
        }




        $obj = PassportAttachment::find($att_id);
        $obj->attachment_name = $file_path;
        $obj->save();
    }
        else{

//            $pass_att = PassportAttachment::find($att_id);
//           if ($pass_att==null){


            if (!file_exists('../public/assets/upload/passport_attachment/')) {
                mkdir('../public/assets/upload/passport_attachment/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name3']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name3"]["tmp_name"], '../public/assets/upload/passport_attachment/' . $file_name);
            $file_path = 'assets/upload/passport_attachment/' . $file_name;

               $obj3 = new PassportAttachment();
               $obj3->attachment_name = $file_path;
               $obj3->table_id = $obj->id;
               $obj3->save();

               DB::table('passports')->where('id', $id)
                   ->update(['attachment_id' =>$obj3->id,'attachment_name'=>$request->input('attachment_name')]);

//           }

        }
        // dd($obj, $obj2, $obj3);
        $message = [
            'message' => 'Passport Upadated Successfully',
            'alert-type' => 'success'

        ];

        return redirect()->route('view_passport')->with($message);
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

    public function ppuid()
    {

        $match_id = DB::select( DB::raw("SELECT b.passport_id
                                                from passports a,ppuids b
                                                where a.id = b.passport_id ") );
        $msp_id = array();
        foreach ($match_id as $aa){
            $msp_id [] = $aa->passport_id;
        }
        $sheet_missing_id = Ppuid::whereNotIn('passport_id', $msp_id)->get();
        $sheet_exist_id = Ppuid::whereIn('passport_id', $msp_id)->get();


        $match_pp_uid = DB::select( DB::raw("SELECT b.passport_id
                                                      from passports a,ppuids b
                                                      where a.pp_uid = b.ppuid
                                                      AND a.id = b.passport_id") );
        $msp_pp_uid = array();
        foreach ($match_pp_uid as $aa){
            $msp_pp_uid [] = $aa->passport_id;
        }
        $sheet_missing_ppuid = Ppuid::whereNotIn('passport_id', $msp_pp_uid)->get();
        $sheet_exist_ppuid = Ppuid::whereIn('passport_id', $msp_pp_uid)->get();


        $match_zds = DB::select( DB::raw("SELECT b.passport_id
                                                        from passports a,ppuids b,user_codes c
                                                        where a.id = b.passport_id
                                                        AND a.pp_uid = b.ppuid
                                                        AND a.id = c.passport_id
                                                        AND c.zds_code = b.zds_code  ") );
        $msp_zdscode = array();
        foreach ($match_zds as $aa){
            $msp_zdscode [] = $aa->passport_id;
        }
        $sheet_missing_zdscode = Ppuid::whereNotIn('passport_id', $msp_zdscode)->get();
        $sheet_exist_zdscode = Ppuid::whereIn('passport_id', $msp_zdscode)->get();

        $match_passportNum = DB::select( DB::raw("SELECT b.passport_id
                                                                from passports a,ppuids b,user_codes c
                                                                where a.id = b.passport_id
                                                                AND a.pp_uid = b.ppuid
                                                                AND a.id = c.passport_id
                                                                AND c.zds_code = b.zds_code
                                                                AND a.passport_no = b.passport_number  ") );
        $msp_passportNum = array();
        foreach ($match_passportNum as $aa){
            $msp_passportNum [] = $aa->passport_id;
        }
        $sheet_missing_passportNum = Ppuid::whereNotIn('passport_id', $msp_passportNum)->get();
        $sheet_exist_passportNum = Ppuid::whereIn('passport_id', $msp_passportNum)->get();





        $match_riderName = DB::select( DB::raw("SELECT b.passport_id
                                                        from passports a,passport_additional_info d,ppuids b,user_codes c
                                                        where a.id = b.passport_id
                                                        AND a.pp_uid = b.ppuid
                                                        AND a.id = c.passport_id
                                                        AND c.zds_code = b.zds_code
                                                        AND a.passport_no = b.passport_number
                                                        AND a.id = d.passport_id
                                                        AND d.full_name = b.rider_name  ") );
        $msp_ridername = array();
        foreach ($match_riderName as $aa){
            $msp_ridername [] = $aa->passport_id;
        }
        $sheet_missing_riderName = Ppuid::whereNotIn('passport_id', $msp_ridername)->get();
        $sheet_exist_riderName = Ppuid::whereIn('passport_id', $msp_ridername)->get();


        $match_platform = DB::select( DB::raw("SELECT b.passport_id
                                                  from passports a,passport_additional_info d,ppuids b,user_codes c,platforms f,assign_plateforms e
                                                  where a.id = b.passport_id
                                                  AND a.pp_uid = b.ppuid
                                                  AND a.id = c.passport_id
                                                  AND c.zds_code = b.zds_code
                                                  AND a.passport_no = b.passport_number
                                                  AND a.id = d.passport_id
                                                  AND d.full_name = b.rider_name
                                                  AND a.id = e.passport_id
                                                  AND f.id = e.plateform
                                                  AND f.name = b.platform
                                                  AND e.status = 1") );

        $msp_platform = array();
        foreach ($match_platform as $aa){
            $msp_platform [] = $aa->passport_id;
        }
        $sheet_missing_platform = Ppuid::whereNotIn('passport_id', $msp_platform)->get();
        $sheet_exist_platform = Ppuid::whereIn('passport_id', $msp_platform)->get();


        $match_bikes = DB::select( DB::raw("SELECT b.passport_id
                                                  from passports a,passport_additional_info d,ppuids b,user_codes c,bike_details f,assign_bikes e
                                                  where a.id = b.passport_id
                                                  AND a.pp_uid = b.ppuid
                                                  AND a.id = c.passport_id
                                                  AND c.zds_code = b.zds_code
                                                  AND a.passport_no = b.passport_number
                                                  AND a.id = d.passport_id
                                                  AND d.full_name = b.rider_name
                                                  AND a.id = e.passport_id
                                                  AND f.id = e.bike
                                                  AND f.plate_no = b.bike_number
                                                  AND e.status = 1") );

        $msp_bikes = array();
        foreach ($match_bikes as $aa){
            $msp_bikes [] = $aa->passport_id;
        }
        $sheet_missing_bikes = Ppuid::whereNotIn('passport_id', $msp_bikes)->get();
        $sheet_exist_bikes = Ppuid::whereIn('passport_id', $msp_bikes)->get();


        $match_sims = DB::select( DB::raw("SELECT b.passport_id
                                                    from passports a,passport_additional_info d,ppuids b,user_codes c,assign_sims e,telecomes f
                                                        where a.id = b.passport_id
                                                        AND a.pp_uid = b.ppuid
                                                        AND a.id = c.passport_id
                                                        AND c.zds_code = b.zds_code
                                                        AND a.passport_no = b.passport_number
                                                        AND a.id = d.passport_id
                                                        AND d.full_name = b.rider_name
                                                        AND a.id = e.passport_id
                                                        AND f.id = e.sim
                                                            AND f.account_number = b.sim_number
                                                            AND e.status = 1") );
//        dd($match_sims);
        $msp_sims = array();
        foreach ($match_sims as $aa){
            $msp_sims [] = $aa->passport_id;
        }
        $sheet_missing_sims = Ppuid::whereNotIn('passport_id', $msp_sims)->get();
        $sheet_exist_sims = Ppuid::whereIn('passport_id', $msp_sims)->get();


        $match_all = DB::select( DB::raw("SELECT b.passport_id
                                                    from passports a,passport_additional_info d,ppuids b,user_codes c,assign_sims e,telecomes f,platforms g,assign_plateforms h,bike_details i,assign_bikes j
                                                        where a.id = b.passport_id
                                                        AND a.pp_uid = b.ppuid
                                                        AND a.id = c.passport_id
                                                        AND c.zds_code = b.zds_code
                                                        AND a.passport_no = b.passport_number
                                                        AND a.id = d.passport_id
                                                        AND d.full_name = b.rider_name
                                                        AND a.id = e.passport_id
                                                        AND f.id = e.sim
                                                            AND f.account_number = b.sim_number
                                                            AND e.status = 1
                                                        AND a.id = h.passport_id
                                                        AND g.id = h.plateform
                                                            AND g.name = b.platform
                                                            AND h.status = 1
                                                        AND a.id = j.passport_id
                                                        AND i.id = j.bike
                                                            AND i.plate_no = b.bike_number
                                                            AND j.status = 1") );
        $msp_matched = array();
        foreach ($match_all as $aa){
            $msp_matched [] = $aa->passport_id;
        }
        $sheet_matched_all = Ppuid::whereIn('passport_id', $msp_matched)->get();

        return view('admin-panel.passport.ppuid',compact('sheet_missing_id','sheet_exist_id','sheet_missing_ppuid','sheet_exist_ppuid',
            'sheet_missing_zdscode','sheet_exist_zdscode','sheet_missing_passportNum','sheet_exist_passportNum',
            'sheet_missing_riderName','sheet_exist_riderName','sheet_missing_bikes','sheet_exist_bikes','sheet_missing_sims','sheet_exist_sims',
            'sheet_missing_platform','sheet_exist_platform','sheet_matched_all'));
    }


    public function getPlatformId(int $id){
        $platformName= Platform::select('name')
            ->where('id', '=', $id)
            ->first();
        return $platformName;
    }

    public function ppuid_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ppuid' => 'unique:ppuids,passport_id'
        ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'already exists',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        $obj = new Ppuid();
        $obj->passport_id=$request->input('ppuid');
        $obj->ppuid_issue_id=$request->input('ppuid_issue_id');
        $obj->save();
        $message = [
            'message' => 'PPUID Issue Saved Successfully!',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }

    public function ppuid_edit($id)
    {



        $ppuid=Passport::all();
        $issue=PpuidIssue::all();
        $ppuid_issues=Ppuid::all();
        $ppuid_edit=Ppuid::find($id);




        return view('admin-panel.passport.ppuid',compact('ppuid','issue','ppuid_issues','ppuid_edit'));
    }



    public function ppuid_update(Request $request, $id)
    {
        //


         $validator = Validator::make($request->all(), [
        'ppuid' => 'unique:ppuids,passport_id,'. $id
    ]);

//        dd($validator);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => 'already exists',
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return back()->with($message);
        }

        try {

            $obj = Ppuid::find($id);


            $obj->passport_id=$request->input('ppuid');
            $obj->ppuid_issue_id=$request->input('ppuid_issue_id');
            $obj->save();

            $message = [
                'message' => 'Updated Successfully',
                'alert-type' => 'success'

            ];
            return back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }






}
