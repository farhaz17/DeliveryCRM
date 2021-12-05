<?php

namespace App\Http\Controllers\Passport;

use App\Model\Nationality;
use App\Model\Passport\Passport;
use App\Model\Passport\passport_addtional_info;
use App\Model\Passport\PassportAdditional;
use App\Model\Passport\RenewPassport;
use App\Model\Types;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mockery\Generator\StringManipulation\Pass\Pass;

class PassportAddtionalInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $passport=Passport::all();

        //return view('admin-panel.passport.passport_addtional_info_search');
        return view('admin-panel.passport.passport_addtional_info_search',compact('passport'));
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
//        if (!empty($_FILES['file_name']['name'])) {
            if (!file_exists('../public/assets/upload/passport_info_image/')) {
                mkdir('../public/assets/upload/passport_info_image/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/passport_info_image/' . $file_name);
            $file_path = 'assets/upload/passport_info_image/' . $file_name;


            $obj = new Passport();
            $count = $request->input('nation_id');
            $ppuid = IdGenerator::generate(['table' => 'passports', 'field' => 'pp_uid', 'length' => 6, 'prefix' => 'PP1']);
            $obj = new passport_addtional_info();

            $obj->passport_id = $request->input('passport_id');
            $obj->full_name = $request->input('full_name');
            $obj->nat_name = $request->input('nat_name');
            $obj->nat_relation = $request->input('nat_relation');
            $obj->nat_address = $request->input('nat_address');
            $obj->nat_phone = $request->input('nat_phone');
            $obj->nat_whatsapp_no = $request->input('nat_whatsapp_no');
            $obj->nat_email = $request->input('nat_email');

            $obj->inter_name = $request->input('inter_name');
            $obj->inter_relation = $request->input('inter_relation');
            $obj->inter_address = $request->input('inter_address');
            $obj->inter_phone = $request->input('inter_phone');
            $obj->inter_whatsapp_no = $request->input('inter_whatsapp_no');
            $obj->inter_email = $request->input('inter_email');

            $obj->personal_mob = $request->input('personal_mob');
            $obj->personal_email = $request->input('personal_email');
            $obj->personal_image = $file_path;


            $obj->save();
            $message = [
                'message' => 'Additinal Information Added Successfully',
                'alert-type' => 'success'
            ];
//        $nation=Nationality::all();
//        $types=Types::all();
//        return view('admin-panel.passport.country',compact('nation','types'))->with($message);

            return redirect()->route('country')->with($message);
//        }
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
        //dd($id);
          $pass_no=$request->input('passport_no');

          $passport = Passport::where('passport_no', $pass_no)->get();
          $pass2 = Passport::where('passport_no', $pass_no)->first();

          $pass_id=$pass2->id;
          $result = passport_addtional_info::where('passport_id', $pass_id)->get();

        return view('admin-panel.passport.passport_additional_info', compact('passport','result'));
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
        $pass_id=Passport::find($id);
      //  $edit_additional=passport_addtional_info::find($id);


        $edit_additional = passport_addtional_info::where('passport_id', $pass_id->id)->first();

        return view('admin-panel.passport.view_passport',compact('edit_passport','passport','additional','edit_additional'));
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
        if (empty($_FILES['file_name']['name'])) {
            $file_path=$request->input('temp_file');
        }
        else{

            if (!file_exists('../public/assets/upload/passport_info_image/')) {
                mkdir('../public/assets/upload/passport_info_image/', 0777, true);
            }

            $ext = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/passport_info_image/' . $file_name);
            $file_path = 'assets/upload/passport_info_image/' . $file_name;
        }
        $obj = passport_addtional_info::find($id);
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
        $obj->personal_image=$request->input('personal_image');
        $obj->personal_image=$file_path;

        $obj->save();


        $message = [
            'message' => 'Additional Info Saved Successfully',
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


//    public function get_passport_add_info(Request $request){
//
//
//
//        $id = $request->id;
//        $renew = RenewPassport::find($id);
//        $response = $renew->renew_passport_number;
//echo("asdfasdfasd");
//dd();
//            return $response;
//
//
//
//
//    }
}
