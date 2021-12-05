<?php

namespace App\Http\Controllers\VisaApplication;

use App\Model\Cities;
use App\Model\Passport\Passport;
use App\Model\Seeder\Company;
use App\Model\Seeder\Designation;
use App\Model\VisaApplication;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Emirates_id_cards;
use App\Model\Offer_letter\Offer_letter;
use App\Model\VisaProcess\EntryPrintOutside;
use App\Model\VisaProcess\VisaPasted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class VisaApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function index()
    {
        $visas=VisaApplication::all();
        $states=Cities::all();
        $companies=Company::all();
        $passports = Passport::all();
        $professions = Designation::all();
        return view('admin-panel.visa-application.index',compact('visas','states','companies','passports','professions'));
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

//        try{
            $validator = Validator::make($request->all(), [
                'uid_num' => 'unique:visa_applications,uid_number',
                'file_number' => 'unique:visa_applications,file_number',
                'passport_id' => 'unique:visa_applications,passport_id',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Data is already existed',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('visa_application')->with($message);
            }


            // user profile upload

                // if (!file_exists('../public/assets/upload/visa_application/')) {
                //     mkdir('../public/assets/upload/visa_application/', 0777, true);
                // }
//                $ext = pathinfo($_FILES['visa_attachment']['name'], PATHINFO_EXTENSION);
//                $file_name = time() . "_" . $request->date . '.' . $ext;
//
//                move_uploaded_file($_FILES["visa_attachment"]["tmp_name"], '../public/assets/upload/visa_application/' . $file_name);
//                $file_path = 'assets/upload/visa_application/' . $file_name;




            // $ext = pathinfo($_FILES['visa_attachment']['name'], PATHINFO_EXTENSION);
            // $file_name = time()."_". $request->date . $ext;
            // move_uploaded_file($_FILES["visa_attachment"]["tmp_name"], '../public/assets/upload/visa_application/' . $file_name);
            // $file_path = 'assets/upload/visa_application/' . $file_name;

            if($request->hasfile('visa_attachment'))
            {
                foreach($request->file('visa_attachment') as $file)
                {
                    $name =rand(100,200000).'.'.time().'.'.$file->extension();
                    $filePath = '/assets/upload/visa_application/' . $name;
                   Storage::disk('s3')->put($filePath, file_get_contents($file));
                    $data[] = $name;
                }
            }

            $obj=new VisaApplication();
            $obj->uid_number = $request->input('uid_num');
            $obj->file_number = $request->input('file_number');
            $obj->eid_number=$request->input('eid_num');
            $obj->issue_date = $request->input('date_issue');
            $obj->expiry_date = $request->input('date_expiry');
            $obj->state_id = $request->input('state_id');
            $obj->passport_id = $request->input('passport_id');
            $obj->visa_profession_id = $request->input('visa_profession_id');
            $obj->visa_company_id = $request->input('visa_company');
            $obj->user_id = Auth::user()->id;

            if(isset($data)){
                $obj->attachment =json_encode($data);
            }



            // user profile upload

            $obj->save();
            $message = [
                'message' => 'Visa added Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('visa_application')->with($message);
//        }
//        catch (\Illuminate\Database\QueryException $e){
//            $message = [
//                'message' => 'Error Occured',
//                'alert-type' => 'error'
//            ];
//            return redirect()->route('visa_application')->with($message);
//        }
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
        $visa_application_data=VisaApplication::find($id);
        $states=Cities::all();
        $visas=VisaApplication::all();
        $companies=Company::all();
        $passports = Passport::all();
        $professions = Designation::all();
        return view('admin-panel.visa-application.index',compact('visa_application_data','states','visas','companies','passports','professions'));
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
                'uid_num' => 'unique:visa_applications,uid_number,'.$id,
                'file_number' => 'unique:visa_applications,file_number,'.$id,
                'passport_id' => 'unique:visa_applications,passport_id,'.$id,
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => 'Data is already existed',
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->route('visa_application')->with($message);
            }
            $obj=VisaApplication::find($id);

            $obj->uid_number=$request->input('uid_num');
            $obj->eid_number=$request->input('eid_num');
            $obj->file_number = $request->input('file_number');
            $obj->issue_date = $request->input('date_issue');
            $obj->expiry_date = $request->input('date_expiry');
            $obj->state_id = $request->input('state_id');
            $obj->passport_id = $request->input('passport_id');
            $obj->visa_profession_id = $request->input('visa_profession_id');
            $obj->visa_company_id = $request->input('visa_company');
            $obj->user_id = Auth::user()->id;

            // user profile upload
            if($request->hasFile('visa_attachment')){
                if (!file_exists('../public/assets/upload/visa_application/')) {
                    mkdir('../public/assets/upload/visa_application/', 0777, true);
                }
                $ext = pathinfo($_FILES['visa_attachment']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["visa_attachment"]["tmp_name"], '../public/assets/upload/visa_application/' . $file_name);
                $file_path = 'assets/upload/visa_application/' . $file_name;
                $obj->attachment = $file_path;
            }
            // user profile upload

            $obj->save();
            $message = [
                'message' => 'Visa Updated Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('visa_application')->with($message);
//        }
//        catch (\Illuminate\Database\QueryException $e){
//            $message = [
//                'message' => 'Error Occured',
//                'alert-type' => 'error'
//            ];
//            return redirect()->route('visa_application')->with($message);
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


        public function ajax_get_visa_app(Request $request)
        {

            //attachment
            $pass=Passport::where('passport_no',$request->keyword)->first();
            $passport_id=$pass->id;

            //uid
            $print_visa=EntryPrintOutside::where('passport_id',$passport_id)->first();
            if(isset($print_visa)){
                $uid=$print_visa->uid_no;
                //file_no, visa number is the file no
                $file_no=$print_visa->visa_number;
            }
            $uid="";
            $file_no="";

            //eid
            $emirates_id=Emirates_id_cards::where('passport_id',$passport_id)->first();

            if(isset($emirates_id)){
                $eid=$emirates_id->card_no;
            }
            else{
                $eid="";
            }


            //issue date from visa pasted
            //expiry date from visa pasted
            $visa_pasted= VisaPasted::where('passport_id',$passport_id)->first();

            if(isset($visa_pasted)){
                $issue_date=$visa_pasted->issue_date;
                $expiry_date=$visa_pasted->expiry_date;
            }else{
            $issue_date="";
            $expiry_date="";
            }

            //state from company and offer letter
            $offer_letter= Offer_letter::where('passport_id',$passport_id)->first();

            if(isset($offer_letter)){
                $state=isset($offer_letter->companies)?$offer_letter->companies->state->name:"";
                $profession=isset($offer_letter->designation->name)?$offer_letter->designation->name:"";
            }
            else{
            $state="";
            $profession="";
            }

            return response()->json([
                'code' => "100",
                'passport_id' => $passport_id,
                'uid' => $uid,
                'eid'=>$eid,
                'file_no'=>$file_no,
                'issue_date'=>$issue_date,
                'expiry_date'=>$expiry_date,
                'state'=>$state,
                'profession'=>$profession,


            ]);

            //   $response = $passport_id."$".$uid."$".$eid."$".$file_no."$".$issue_date."$".$expiry_date."$".$state."$".$profession;


            // return $response;

        }

        public function ajax_get_visa_app_att(Request $request){

        $id=$request->id;
        $visa_app=VisaApplication::where('id',$id)->first();

        $view = view("admin-panel.visa-application.attachments_slider", compact('visa_app'))->render();
    return response()->json(['html' => $view]);


        }
}
