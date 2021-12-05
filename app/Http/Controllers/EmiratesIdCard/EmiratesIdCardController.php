<?php

namespace App\Http\Controllers\EmiratesIdCard;


use App\Model\AdminFees\AdminFees;
use App\Model\Emirates_id_cards;
use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Agreement\Agreement;
use App\Model\BikeDetail;
use App\Model\BikeReplacement\BikeReplacement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;
use App\Model\Passport\passport_addtional_info;
use App\Model\SimReplacement\SimReplacement;
use App\Model\Telecome;
use DB;

class EmiratesIdCardController extends Controller
{


    function __construct()
    {
        $this->middleware('role_or_permission:Admin|add-emirates-id', ['only' => ['index','store','destroy','edit','update']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_passports = Passport::where('is_cancel','=','0')->get();
        $emirates_ids = Emirates_id_cards::where('status','1')->orWhere('status',null)->with(['passport.personal_info','passport.zds_code','user'])->get();
        return view('admin-panel.emirates_id_card.index',compact('all_passports','emirates_ids'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $all_passports = Passport::where('is_cancel','=','0')->get();



        return view('admin-panel.emirates_id_card.create',compact('all_passports'));
        //
    }

    public function renew_emirates_id(){

        $all_passports = Passport::where('is_cancel','=','0')->get();



        return view('admin-panel.emirates_id_card.renew_eid',compact('all_passports'));

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
                'user_passport_id' => 'required',
                'card_no' => 'required',
                'expire_date' => 'required',
                'front_pic' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'back_pic' => 'mimes:jpeg,jpg,png,gif|max:10000'

            ]);
            if($validator->fails()) {
                $validate = $validator->errors();

                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            $exit_amount  = Emirates_id_cards::
            where('passport_id','=',$request->passport_id)
                ->orwhere('card_no','=',$request->card_no)
                ->first();

            if(!empty($exit_amount)){
                $message = [
                    'message' => "Id Number Or passport number Already Exist",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return redirect()->back()->with($message);
            }

            // if (!file_exists('../public/assets/upload/emirates_id_card/front')) {
            //     mkdir('../public/assets/upload/emirates_id_card/front', 0777, true);
            // }

            if(!empty($_FILES['front_pic']['name'])){

                // $ext = pathinfo($_FILES['front_pic']['name'], PATHINFO_EXTENSION);
                // $file_name = time() . "_" . $request->date . '.' . $ext;

                // move_uploaded_file($_FILES["front_pic"]["tmp_name"], '../public/assets/upload/emirates_id_card/front/' . $file_name);
                // $file_path_front = 'assets/upload/emirates_id_card/front/' . $file_name;
                $img = $request->file('front_pic');
                $file_path_front = 'assets/upload/emirates_id_card/front/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_front, $imageS3->stream());

            }




            // if (!file_exists('../public/assets/upload/emirates_id_card/back')) {
            //     mkdir('../public/assets/upload/emirates_id_card/back', 0777, true);
            // }

            if(!empty($_FILES['back_pic']['name'])){

                // $ext = pathinfo($_FILES['back_pic']['name'], PATHINFO_EXTENSION);
                // $file_name = time() . "_" . $request->date . '.' . $ext;

                // move_uploaded_file($_FILES["back_pic"]["tmp_name"], '../public/assets/upload/emirates_id_card/back/' . $file_name);
                // $file_path_back = 'assets/upload/emirates_id_card/back/' . $file_name;

                $img = $request->file('back_pic');
                $file_path_back = 'assets/upload/emirates_id_card/back/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_back, $imageS3->stream());

            }



            // $passport_id = null;

            // if($request->search_type=="1"){
            //     $passport_id = $request->ppui_id;
            // }elseif($request->search_type=="2"){
            //     $passport_id = $request->zds_code;
            // }else{
            //     $passport_id = $request->passport_id;
            // }


            $card = new Emirates_id_cards();
            $card->passport_id = $request->user_passport_id;
            $card->card_no = $request->card_no;
            $card->expire_date = $request->expire_date;
            if(!empty($file_path_front)){
                $card->card_front_pic = $file_path_front;
            }
            if(!empty($file_path_back)){
                $card->card_back_pic = $file_path_back;
            }
            $card->enter_by = Auth::user()->id;
            $card->save();

            $message = [
                'message' => "Emirates Id Has been saved Successfully",
                'alert-type' => 'success',
                'error' => ''
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

        $card = Emirates_id_cards::find($id);

        $gamer= array(
            'passport_number' => $card->passport->passport_no,
            'card_no' => $card->card_no,
            'expire_date' => $card->expire_date,
        );

        echo json_encode($gamer);
        exit;

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
                'passport_id' => 'required|unique:emirates_id_cards,passport_id,'.$id,
                'edit_id_number' => 'required|unique:emirates_id_cards,card_no,'.$id,
                'edit_expire_date' => 'required',
                'front_pic' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'back_pic' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('emirates_id_card')->with($message);
            }

            // if (!file_exists('../public/assets/upload/emirates_id_card/front')) {
            //     mkdir('../public/assets/upload/emirates_id_card/front', 0777, true);
            // }

            if(!empty($_FILES['front_pic']['name'])){
                // $ext = pathinfo($_FILES['front_pic']['name'], PATHINFO_EXTENSION);
                // $file_name = time() . "_" . $request->date . '.' . $ext;
                // move_uploaded_file($_FILES["front_pic"]["tmp_name"], '../public/assets/upload/emirates_id_card/front/' . $file_name);
                // $file_path_front = 'assets/upload/emirates_id_card/front/' . $file_name;
                $img = $request->file('front_pic');
                $file_path_front = 'assets/upload/emirates_id_card/front/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_front, $imageS3->stream());
            }

            // if (!file_exists('../public/assets/upload/emirates_id_card/back')) {
            //     mkdir('../public/assets/upload/emirates_id_card/back', 0777, true);
            // }

            if(!empty($_FILES['back_pic']['name'])){
                // $ext = pathinfo($_FILES['back_pic']['name'], PATHINFO_EXTENSION);
                // $file_name = time() . "_" . $request->date . '.' . $ext;
                // move_uploaded_file($_FILES["back_pic"]["tmp_name"], '../public/assets/upload/emirates_id_card/back/' . $file_name);
                // $file_path_back = 'assets/upload/emirates_id_card/back/' . $file_name;
                $img = $request->file('back_pic');
                $file_path_back = 'assets/upload/emirates_id_card/back/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_back, $imageS3->stream());
            }

            $card =  Emirates_id_cards::find($id);
            $card->card_no = $request->edit_id_number;
            $card->expire_date = $request->edit_expire_date;
            if(!empty($file_path_front)){
                $card->card_front_pic = $file_path_front;
            }
            if(!empty($file_path_back)){
                $card->card_back_pic = $file_path_back;
            }
            $card->update();


            $message = [
                'message' => 'Emirates Id has been Updated successfully',
                'alert-type' => 'success',
            ];
            return redirect()->route('emirates_id_card')->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('emirates_id_card')->with($message);
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

    public function autocomplete_passport(Request $request){

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->get();

        if (count($passport_data)=='0')
        {
            // return "pp";
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->get();

                    //zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => $pass->zds_code,
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
                        'zds_code' => $pass->zds_code,
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
                    'zds_code' => $pass->zds_code,
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
            'zds_code' => $pass->zds_code,
            'type'=>'0',
        );
        $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }


    public function eid_get_unique_passport(Request $request){


        $eid=Emirates_id_cards::where('passport_id',$request->passport_id)->where('status','1')->orWhere('status',null)->first();

        $expiry_date=$eid->expire_date;

        $curr_date=date('Y-m-d');

        if($expiry_date > $curr_date){

            $gamer = array(
                'id' => 'mxp098',
            );
            echo json_encode($gamer);
            exit;

        }
        else{

            $searach = '%'.$request->passport_id.'%';
            $passport = Passport::where('passport_no', 'like', $searach)->first();

            $name = "";
            if(!empty($passport)){
                $name = $passport->personal_info->full_name;
            }
            if($request->type=="replace_checkout"){

                 $bike_replace = BikeReplacement::where('passport_id','=',$passport->id)->where('status','=','1')->where('type','=','1')->first();

                 $bike_old = "";
                 $primary_id ="";
                 $checkin_bike = "";


                 if(!empty($bike_replace)){
                      $bike_detail = BikeDetail::where('id','=',$bike_replace->replace_bike_id)->first();
                     $bike_detail_checkin = BikeDetail::where('id','=',$bike_replace->new_bike_id)->first();

                     $bike_old  = $bike_detail->plate_no;
                     $primary_id  = $bike_replace->id;
                     $checkin_bike = $bike_detail_checkin->plate_no;
                 }

                $gamer = array(
                    'name' => $name,
                    'id' => $passport->id,
                    'platform_name' => isset($passport->assign_platforms_check()->plateformdetail->name) ? ($passport->assign_platforms_check()->plateformdetail->name) : '',
                    'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : '',
                    'bike_number' => $checkin_bike,
                    'old_bike' => $bike_old,
                    'replacement_primary_id' => $primary_id,
                    'zds_code' => isset($passport->zds_code->zds_code) ? $passport->zds_code->zds_code : '',
                );

            }elseif($request->type=="replace_checkout_sim" ||  $request->type=="checkin"){

                $sim_replace = SimReplacement::where('passport_id','=',$passport->id)->where('status','=','1')->where('type','=','1')->first();

                $primary_id ="";
                $old_sim ="";

                $checkin_sim = "";


                if(!empty($sim_replace)){
                    $sim_tel = Telecome::where('id','=',$sim_replace->replace_sim_id)->first();
                    $old_sim  = $sim_tel->account_number;
                    $primary_id  = $sim_replace->id;

                    if($request->type=="checkin"){
                        $checkin_sim = isset($passport->sim_checkin()->telecome->account_number) ? ($passport->sim_checkin()->telecome->account_number) : '';
                    }else{
                        $sim_tel_checkin = Telecome::where('id','=',$sim_replace->new_sim_id)->first();
                        $checkin_sim = $sim_tel_checkin->account_number;
                    }
                }else{
                        $checkin_sim = isset($passport->sim_checkin()->telecome->account_number) ? ($passport->sim_checkin()->telecome->account_number) : '';
                  }


                $gamer = array(
                    'name' => $name,
                    'id' => $passport->id,
                    'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : '',
                    'current_sim' => $checkin_sim,
                    'bike_number' => isset($passport->bike_checkin()->bike_plate_number->plate_no) ? ($passport->bike_checkin()->bike_plate_number->plate_no) : '',
                    'old_sim' => $old_sim,
                    'replacement_primary_id' => $primary_id,
                    'zds_code' => isset($passport->zds_code->zds_code) ? $passport->zds_code->zds_code : '',
                );



            }else{

                $platform_status=isset($passport->assign_platforms_check()->plateformdetail->name)?$passport->assign_platforms_check()->plateformdetail->name:'N/A';
                if ($platform_status!="N/A"){
                    $check_status='Platform Not Checked Out';
                    $last_check_out_time='Platform Not Checked Out';
                }
                else{
                    $check_status= isset($passport->assign_platforms_checkout()->plateformdetail->name) ? ($passport->assign_platforms_checkout()->plateformdetail->name) : '';
                    $last_check_out_time= isset($passport->assign_platforms_checkout()->checkout) ? ($passport->assign_platforms_checkout()->checkout) : 'N/A';
                }

                //4 pl status
    //            $passport
            $agreement_detail=Agreement::where('passport_id',$passport->id)->first();
                $four_pl_status=isset($agreement_detail->four_pl_name)?$agreement_detail->four_pl_name:"N/A";
                if ($four_pl_status!='N/A'){
                    $four_pl='1';
                }
                else{
                    $four_pl='2';
                }
                $gamer = array(
                    'name' => $name,
                    'id' => $passport->id,
                    'platform_name' => isset($passport->assign_platforms_check()->plateformdetail->name)?$passport->assign_platforms_check()->plateformdetail->name:'N/A',
                    'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : 'N/A',
                    'bike_number' => isset($passport->bike_checkin()->bike_plate_number->plate_no) ? ($passport->bike_checkin()->bike_plate_number->plate_no) : 'N/A',
                    'checkin_time' => isset($passport->assign_platforms_check()->checkin) ? ($passport->assign_platforms_check()->checkin) : 'N/A',
                    'checkin_sim_number' => isset($passport->sim_checkin()->telecome->account_number) ? ($passport->sim_checkin()->telecome->account_number) : 'N/A',
                    'last_platform' => $check_status,
                    'last_platform_checkout' => $last_check_out_time,
                    'four_pl_status' => $four_pl,
                    'zds_code' => isset($passport->zds_code->zds_code) ? $passport->zds_code->zds_code : '',
                );
            }
            echo json_encode($gamer);
            exit;
}
    }




    public function renew_store(Request $request)
    {
            // dd($request->all());
        try{
            $validator = Validator::make($request->all(), [
                'user_passport_id' => 'required',
                'card_no' => 'required',
                'expire_date' => 'required',
                'front_pic' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'back_pic' => 'mimes:jpeg,jpg,png,gif|max:10000'

            ]);
            if($validator->fails()) {
                $validate = $validator->errors();

                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }

            $exit_amount  = Emirates_id_cards::
            where('passport_id','=',$request->passport_id)
                ->orwhere('card_no','=',$request->card_no)
                ->first();

            if(!empty($exit_amount)){
                $message = [
                    'message' => "Id Number Or passport number Already Exist",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return redirect()->back()->with($message);
            }

            if(!empty($_FILES['front_pic']['name'])){
                $img = $request->file('front_pic');
                $file_path_front = 'assets/upload/emirates_id_card/front/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_front, $imageS3->stream());

            }




            if(!empty($_FILES['back_pic']['name'])){



                $img = $request->file('back_pic');
                $file_path_back = 'assets/upload/emirates_id_card/back/' .time() . '.' . $img ->getClientOriginalExtension();

                $imageS3 = Image::make($img)->resize(null, 500, function ($constraint) {
                                $constraint->aspectRatio();
                            });

                Storage::disk("s3")->put($file_path_back, $imageS3->stream());

            }

            //update ths status of previos the data
            DB::table('emirates_id_cards')->where('passport_id', $request->user_passport_id)->where('status','1')
            ->update(['status' => '2']);

            DB::table('emirates_id_cards')->where('passport_id', $request->user_passport_id)->where('status',null)
            ->update(['status' => '2']);


            $card = new Emirates_id_cards();
            $card->passport_id = $request->user_passport_id;
            $card->card_no = $request->card_no;
            $card->expire_date = $request->expire_date;
            if(!empty($file_path_front)){
                $card->card_front_pic = $file_path_front;
            }
            if(!empty($file_path_back)){
                $card->card_back_pic = $file_path_back;
            }
            $card->enter_by = Auth::user()->id;
            $card->status = '1';
            $card->save();



            $message = [
                'message' => "Renew Emirates Id Has been saved successfully",
                'alert-type' => 'success',
                'error' => ''
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

    public function emirates_id_history(Request $request){

    $id=$request->id;
    $eid=Emirates_id_cards::where('id',$id)->first();
    $pass_id=$eid->passport_id;
    $emirates_ids=Emirates_id_cards::where('passport_id',$pass_id)->where('status','2')->get();
   

    $view = view("admin-panel.emirates_id_card.ajax_get_history", compact('emirates_ids'))->render();

    return response()->json(['html' => $view]);
}


}
