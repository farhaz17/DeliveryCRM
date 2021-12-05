<?php

namespace App\Http\Controllers\Api\Verification;

use App\Model\BikeDetail;
use App\Model\Telecome;
use App\Model\VerificationForm;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class VerificationFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

        $sim_number = Telecome::where('account_number', '=', trim($request->input('simcard_no')))->first();
        $plate_number = BikeDetail::where('plate_no','=',trim($request->input('plate_no')))->first();



        if($sim_number != null && $plate_number != null){

            $validator = Validator::make($request->all(), [
                'platform_id' => 'required',
                'platform_code' => 'required|unique:verification_forms,platform_code',
                'plate_no' => 'required|unique:verification_forms,plate_no',
                'bike_pic' => 'required',
                'mulkiya_pic' => 'required',
                'emirates_pic' => 'required',
                'selfie_pic' => 'required',
                'mulkiya_back' => 'required',
                'emirates_back' => 'required',
                'simcard_no' => 'required|unique:verification_forms,simcard_no',
            ]);
            if ($validator->fails()) {
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }


            $is_exist = VerificationForm::where('platform_code','=',$request->platform_code)->first();

//            $what_to_do_code = "";
//
//            if($is_exist->status=="2"){
//                $what_to_do_code = "update";
//            }else{
//                $what_to_do_code = "new";
//            }

            $current_timestamp = Carbon::now()->timestamp;

            if (!empty($_FILES['bike_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/bike_pic')) {
                    mkdir('./assets/upload/verification/bike_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['bike_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["bike_pic"]["tmp_name"], './assets/upload/verification/bike_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/bike_pic/' . $file1);
                $img->save('./assets/upload/verification/bike_pic/' . $file1,25);

                $bike_pic = '/assets/upload/verification/bike_pic/' . $file1;
            }

            if (!empty($_FILES['mulkiya_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/mulkiya_pic')) {
                    mkdir('./assets/upload/verification/mulkiya_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['mulkiya_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["mulkiya_pic"]["tmp_name"], './assets/upload/verification/mulkiya_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/mulkiya_pic/'.$file1);
                $img->save('./assets/upload/verification/mulkiya_pic/'.$file1,25);

                $file_mulkiya = '/assets/upload/verification/mulkiya_pic/' . $file1;
            }

            if(!empty($_FILES['emirates_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/emirates_pic')) {
                    mkdir('./assets/upload/verification/emirates_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['emirates_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["emirates_pic"]["tmp_name"], './assets/upload/verification/emirates_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/emirates_pic/'.$file1);
                $img->save('./assets/upload/verification/emirates_pic/'.$file1,25);


                $file_emirate = '/assets/upload/verification/emirates_pic/' . $file1;
            }

            if(!empty($_FILES['emirates_back']['name'])) {
                if (!file_exists('./assets/upload/verification/emirates_back')) {
                    mkdir('./assets/upload/verification/emirates_back', 0777, true);
                }
                $ext = pathinfo($_FILES['emirates_back']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["emirates_back"]["tmp_name"], './assets/upload/verification/emirates_back/' . $file1);

                $img = Image::make('./assets/upload/verification/emirates_back/'.$file1);
                $img->save('./assets/upload/verification/emirates_back/'.$file1,25);

                $file_emirate_back = '/assets/upload/verification/emirates_back/' . $file1;
            }

            if(!empty($_FILES['mulkiya_back']['name'])) {
                if (!file_exists('./assets/upload/verification/mulkiya_back')) {
                    mkdir('./assets/upload/verification/mulkiya_back', 0777, true);
                }
                $ext = pathinfo($_FILES['mulkiya_back']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["mulkiya_back"]["tmp_name"], './assets/upload/verification/mulkiya_back/' . $file1);

                $img = Image::make('./assets/upload/verification/mulkiya_back/'.$file1);
                $img->save('./assets/upload/verification/mulkiya_back/'.$file1,25);


                $file_mulkiya_back = '/assets/upload/verification/mulkiya_back/' . $file1;
            }



            if(!empty($_FILES['selfie_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/selfie_pic')) {
                    mkdir('./assets/upload/verification/selfie_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['selfie_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["selfie_pic"]["tmp_name"], './assets/upload/verification/selfie_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/selfie_pic/'.$file1);
                $img->save('./assets/upload/verification/selfie_pic/'.$file1,25);

                $file_selfie = '/assets/upload/verification/selfie_pic/' . $file1;
            }


             $ver_ob = new VerificationForm();

             $ver_ob->platform_id = trim($request->platform_id);
             $ver_ob->platform_code = trim($request->platform_code);
             $ver_ob->plate_no = trim($request->plate_no);
             $ver_ob->bike_pic =  trim($bike_pic);
             $ver_ob->mulkiya_pic = trim($file_mulkiya);
             $ver_ob->emirates_pic =  trim($file_emirate);
             $ver_ob->selfie_pic = trim($file_selfie);
             $ver_ob->simcard_no  = trim($request->simcard_no);
             $ver_ob->mulkiya_back =  trim($file_mulkiya_back);
             $ver_ob->emirates_id_back =  trim($file_emirate_back);
            $ver_ob->user_id   =  Auth::user()->id;
             $ver_ob->save();

            $response['code'] = 1;
            $response['message'] = 'Form is Successfully Submitted';

            return response()->json($response);




        }else{

            $response['code'] = 3;
            $response['message'] = 'Provided Information wrong';
            return response()->json($response);
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


    public function get_verify_form(){

        $id = Auth::user()->id;
        $user_verify_form = VerificationForm::where('user_id','=',$id)
            ->with('platform')
            ->first();

        return response()->json(['data'=>$user_verify_form], 200, [], JSON_NUMERIC_CHECK);
    }

    public function update(Request $request, $id)
    {

        $sim_number =Telecome::where('account_number', '=',trim($request->input('simcard_no')))->first();
        $plate_number = BikeDetail::where('plate_no','=',trim($request->input('plate_no')))->first();



        if($sim_number != null && $plate_number != null){

            $validator = Validator::make($request->all(), [
                'platform_id' => 'required',
                'platform_code' => 'required|unique:verification_forms,platform_code,'. $id,
                'plate_no' => 'required|unique:verification_forms,plate_no,'. $id,
                'bike_pic' => 'required',
                'mulkiya_pic' => 'required',
                'emirates_pic' => 'required',
                'selfie_pic' => 'required',
                'mulkiya_back' => 'required',
                'emirates_back' => 'required',
                'simcard_no' => 'required|unique:verification_forms,simcard_no,'. $id,
            ]);
            if ($validator->fails()) {
                $response['code'] = 2;
                $response['message'] = $validator->errors()->first();
                return response()->json($response);
            }


            $is_exist = VerificationForm::where('platform_code','=',$request->platform_code)->first();

            $current_timestamp = Carbon::now()->timestamp;

            if (!empty($_FILES['bike_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/bike_pic')) {
                    mkdir('./assets/upload/verification/bike_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['bike_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["bike_pic"]["tmp_name"], './assets/upload/verification/bike_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/bike_pic/'.$file1);
                $img->save('./assets/upload/verification/bike_pic/'.$file1,25);

                $bike_pic = '/assets/upload/verification/bike_pic/' . $file1;
            }

            if (!empty($_FILES['mulkiya_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/mulkiya_pic')) {
                    mkdir('./assets/upload/verification/mulkiya_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['mulkiya_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["mulkiya_pic"]["tmp_name"], './assets/upload/verification/mulkiya_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/mulkiya_pic/'.$file1);
                $img->save('./assets/upload/verification/mulkiya_pic/'.$file1,25);

                $file_mulkiya = '/assets/upload/verification/mulkiya_pic/' . $file1;
            }

            if(!empty($_FILES['emirates_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/emirates_pic')) {
                    mkdir('./assets/upload/verification/emirates_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['emirates_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["emirates_pic"]["tmp_name"], './assets/upload/verification/emirates_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/emirates_pic/'.$file1);
                $img->save('./assets/upload/verification/emirates_pic/'.$file1,25);

                $file_emirate = '/assets/upload/verification/emirates_pic/' . $file1;
            }

            if(!empty($_FILES['emirates_back']['name'])) {
                if (!file_exists('./assets/upload/verification/emirates_back')) {
                    mkdir('./assets/upload/verification/emirates_back', 0777, true);
                }
                $ext = pathinfo($_FILES['emirates_back']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["emirates_back"]["tmp_name"], './assets/upload/verification/emirates_back/' . $file1);

                $img = Image::make('./assets/upload/verification/emirates_back/'.$file1);
                $img->save('./assets/upload/verification/emirates_back/'.$file1,25);

                $file_emirate_back = '/assets/upload/verification/emirates_back/' . $file1;
            }

            if(!empty($_FILES['mulkiya_back']['name'])) {
                if (!file_exists('./assets/upload/verification/mulkiya_back')) {
                    mkdir('./assets/upload/verification/mulkiya_back', 0777, true);
                }
                $ext = pathinfo($_FILES['mulkiya_back']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["mulkiya_back"]["tmp_name"], './assets/upload/verification/mulkiya_back/' . $file1);

                $img = Image::make('./assets/upload/verification/mulkiya_back/'.$file1);
                $img->save('./assets/upload/verification/mulkiya_back/'.$file1,25);

                $file_mulkiya_back = '/assets/upload/verification/mulkiya_back/' . $file1;
            }



            if(!empty($_FILES['selfie_pic']['name'])) {
                if (!file_exists('./assets/upload/verification/selfie_pic')) {
                    mkdir('./assets/upload/verification/selfie_pic', 0777, true);
                }
                $ext = pathinfo($_FILES['selfie_pic']['name'], PATHINFO_EXTENSION);
                $file1 = $request->input('name').$current_timestamp . '.' . $ext;
                move_uploaded_file($_FILES["selfie_pic"]["tmp_name"], './assets/upload/verification/selfie_pic/' . $file1);

                $img = Image::make('./assets/upload/verification/selfie_pic/'.$file1);
                $img->save('./assets/upload/verification/selfie_pic/'.$file1,25);

                $file_selfie = '/assets/upload/verification/selfie_pic/' . $file1;
            }


            $ver_ob = VerificationForm::find($id);

            $ver_ob->platform_id = trim($request->platform_id);
            $ver_ob->platform_code = trim($request->platform_code);
            $ver_ob->plate_no = trim($request->plate_no);
            $ver_ob->bike_pic =  trim($bike_pic);
            $ver_ob->mulkiya_pic = trim($file_mulkiya);
            $ver_ob->emirates_pic =  trim($file_emirate);
            $ver_ob->selfie_pic = trim($file_selfie);
            $ver_ob->simcard_no  = trim($request->simcard_no);
            $ver_ob->mulkiya_back =  trim($file_mulkiya_back);
            $ver_ob->emirates_id_back =  trim($file_emirate_back);
//             $ver_ob->user_id   =  Auth::user()->id;
            $ver_ob->status = "0";
            $ver_ob->save();



            $response['code'] = 1;
            $response['message'] = 'Form is Successfully Submitted';

            return response()->json($response);




        }else{

            $response['code'] = 3;
            $response['message'] = 'Provided Information wrong';
            return response()->json($response);
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
}
