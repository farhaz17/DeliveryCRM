<?php

namespace App\Http\Controllers\VendorRegistration;

use Image;
use DataTables;
use Carbon\Carbon;
use App\Mail\VendorAccept;
use App\Model\Nationality;
use App\Model\Guest\Career;
use App\Imports\RiderImport;
use App\Model\Master\FourPl;
use Illuminate\Http\Request;
use App\Imports\VendorImport;
use App\Exports\VendorsExport;
use App\Model\Passport\Passport;
use App\Model\Career\RejoinCareer;
use App\Model\FourPl_rider_history;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Assign\AssignPlateform;
use App\Model\Passport\RenewPassport;
use App\Model\PpuidCancel\PpuidCancel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Model\OnBoardStatus\OnBoardStatus;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\VendorRegistration\VendorRegistration;
use App\Model\VendorRegistration\VendorRiderOnboard;
use App\Model\DcRequestForCheckout\DcRequestForCheckout;


class VendorRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //"192.168.0.155"

        $vendor_new=FourPl::where('status','0')->get();
        $vendor_accept=FourPl::where('status','1')->get();
        $vendor_reject=FourPl::where('status','2')->get();


        return view('admin-panel.vendor_registration.index',compact('vendor_new','vendor_accept','vendor_reject'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $edit_fourpl=FourPl::find($id);
        $nation=Nationality::all();

        return view('admin-panel.vendor_registration.edit_fourpl',compact('edit_fourpl','nation','id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $obj = FourPl::find($id);
        $obj->name = $request->input('company_name');
        $obj->address = $request->input('address');
        $obj->phone_no = $request->input('telephone_number');
        $obj->email = $request->input('company_email_address');
        $obj->company_website = $request->input('company_website');
        $obj->zip_code = $request->input('zip_code');
        $obj->company_address = $request->input('company_address');
        $obj->bank_name = $request->input('bank_name');
        $obj->account_number = $request->input('account_number');
        $obj->benificiary_name = $request->input('benificiary_name');
        $obj->iban_number = $request->input('iban_number');
        $obj->bank_address = $request->input('bank_address');
        $obj->aurtorized_eid = $request->input('aurtorized_eid');
        $obj->passport_expiry = $request->input('passport_expiry');
        $obj->contatcs_email = $request->input('contatcs_email');
        $obj->mobile_no = $request->input('mobile_no');
        $obj->company_rep_name = $request->input('company_rep_name');
        $obj->contatcs_email = $request->input('contatcs_email');
        $obj->contacts_telephone_number = $request->input('contacts_telephone_number');
        $obj->key_accounts_rep = $request->input('key_accounts_rep');
        $obj->key_account_email = $request->input('key_account_email');
        $obj->key_mobile = $request->input('key_mobile');
        $obj->key_account_email = $request->input('key_account_email');
        $obj->key_telefone = $request->input('key_telefone');
        $obj->type_of_business = $request->input('type_of_business');
        $obj->company_is = $request->input('company_is');
        $obj->compnany_est_date = $request->input('compnany_est_date');
        $obj->est_code = $request->input('est_code');
        $obj->trade_linces_no = $request->input('trade_linces_no');
        $obj->text_id = $request->input('text_id');
        $obj->trad_license_exp_date = $request->input('trad_license_exp_date');
        $obj->legal_structure = $request->input('legal_structure');

        if($request->trade_license != null){
            $img = $request->file('trade_license');
            $imageName = 'assets/upload/vendor_registration/trade_lin/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->trade_license = $imageName;
        }

        if($request->est_card != null){
            $img = $request->file('est_card');
            $imageName = 'assets/upload/vendor_registration/est_card/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->est_card = $imageName;
        }

        if($request->vat_certificate != null){
            $img = $request->file('vat_certificate');
            $imageName = 'assets/upload/vendor_registration/vat_certificate/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->vat_certificate = $imageName;
        }

        if($request->e_signature_card != null){
            $img = $request->file('e_signature_card');
            $imageName = 'assets/upload/vendor_registration/e_signature_card/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->e_signature_card = $imageName;
        }

        if($request->other_doc != null){
            $img = $request->file('other_doc');
            $imageName = 'assets/upload/vendor_registration/other_doc/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->other_doc = $imageName;
        }

        if($request->owener_passport_copy != null){
            $img = $request->file('owener_passport_copy');
            $imageName = 'assets/upload/vendor_registration/owener_passport_copy/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->owener_passport_copy = $imageName;
        }

        if($request->company_labour_card != null){
            $img = $request->file('company_labour_card');
            $imageName = 'assets/upload/vendor_registration/company_labour_card/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->company_labour_card = $imageName;
        }

        if($request->owner_visa_copy != null){
            $img = $request->file('owner_visa_copy');
            $imageName = 'assets/upload/vendor_registration/owner_visa_copy/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->owner_visa_copy = $imageName;
        }

        if($request->owener_emirates_id_copy != null){
            $img = $request->file('owener_emirates_id_copy');
            $imageName = 'assets/upload/vendor_registration/owener_emirates_id_copy/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->owener_emirates_id_copy = $imageName;
        }

        $obj->save();

        $message = [
            'message' => 'Updated Successfully!!',
            'alert-type' => 'success'
        ];

        return redirect()->route('vendor_portal')->with($message);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




     public function vender_accept(Request $request, $id)
    {

        try {



            $obj = FourPl::find($id);
            $obj->status ='1';
            $obj->save();


            Mail::to($obj->email)->send(new VendorAccept($obj));

            $message = [
                'message' => 'Request Accepted Successfully and Email Sent to Vendor!!',
                'alert-type' => 'success'

            ];


            return redirect()->back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }


    public function vendor_reject(Request $request)
    {

        try {

            $obj = FourPl::find($request->vendor_id);

            $obj->status ='2';
            $obj->remarks = $request->remarks;
            $obj->save();

            $message = [
                'message' => 'Request Rejected Successfully!!',
                'alert-type' => 'success'

            ];


            return redirect()->back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }

    public function vendor_upload(Request $request) {
        return view('admin-panel.vendor_registration.upload');
    }

    public function post_vendor_upload(Request $request) {

        Excel::import(new VendorImport, request()->file('file'));

        $message = [
            'message' => 'Upload Success',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }

    public function rider_upload(Request $request) {
        return view('admin-panel.vendor_registration.rider-upload');
    }

    public function post_rider_upload(Request $request) {
        Excel::import(new RiderImport, request()->file('file'));

        $message = [
            'message' => 'Upload Success',
            'alert-type' => 'success'
        ];
        return back()->with($message);
    }


    public function apply(Request $request)
    {


        if ($request->token == "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq") {


            if (!file_exists('../public/assets/upload/vendor_registration/trade_lin/')) {
                mkdir('../public/assets/upload/vendor_registration/trade_lin/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_registration/vat_certificate/')) {
                mkdir('../public/assets/upload/vendor_registration/vat_certificate/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_registration/owener_passport_copy/')) {
                mkdir('../public/assets/upload/vendor_registration/owener_passport_copy/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_registration/owner_visa_copy/')) {
                mkdir('../public/assets/upload/vendor_registration/owner_visa_copy/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_registration/e_signature_card/')) {
                mkdir('../public/assets/upload/vendor_registration/e_signature_card/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_registration/company_labour_card/')) {
                mkdir('../public/assets/upload/vendor_registration/company_labour_card/', 0777, true);
            }

              if (!file_exists('../public/assets/upload/vendor_registration/owener_emirates_id_copy/')) {
                            mkdir('../public/assets/upload/vendor_registration/owener_emirates_id_copy/', 0777, true);
                        }


            if (!file_exists('../public/assets/upload/vendor_registration/other_doc/')) {
                mkdir('../public/assets/upload/vendor_registration/other_doc/', 0777, true);
            }

            if (!file_exists('../public/assets/upload/vendor_registration/est_card/')) {
                mkdir('../public/assets/upload/vendor_registration/est_card/', 0777, true);
            }





            // if(!isset($_FILES['trade_license']['name'])) {

            //     $ext = pathinfo($_FILES["trade_license"]['name'], PATHINFO_EXTENSION);
            //     $file_name = time() . "_" . $request->date . '.' . $ext;

            //     move_uploaded_file($_FILES["trade_license"]["tmp_name"], '../public/assets/upload/vendor_registration/trade_lin/' . $file_name);
            //     $trade_lin = 'assets/upload/vendor_registration/trade_lin/' . $file_name;
            // }
            // else{
            //     $trade_lin=null;
            // }



            if(!empty($_FILES['trade_license']['name'])) {
                $ext = pathinfo($_FILES['trade_license']['name'], PATHINFO_EXTENSION);
                $file_name = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["trade_license"]["tmp_name"], '../public/assets/upload/vendor_registration/trade_lin/' . $file_name);
                $trade= 'assets/upload/vendor_registration/trade_lin/' . $file_name;
                }
                else{
                    $trade=null;
                }


            //---------------------------

            // if(!isset($_FILES['vat_certificate']['name'])) {
            // $ext = pathinfo($_FILES['vat_certificate']['name'], PATHINFO_EXTENSION);
            // $file_name2 = time() . "_" . $request->date . '.' . $ext;

            // move_uploaded_file($_FILES["vat_certificate"]["tmp_name"], '../public/assets/upload/vendor_registration/vat_certificate/' . $file_name2);
            // $vat_certificate= 'assets/upload/vendor_registration/vat_certificate/' . $file_name2;
            // }
            // else{
            //     $vat_certificate=null;
            // }

            if(!empty($_FILES['vat_certificate']['name'])) {
                $ext = pathinfo($_FILES['vat_certificate']['name'], PATHINFO_EXTENSION);
                $file_name2 = time() . "_" . $request->date . '.' . $ext;

                move_uploaded_file($_FILES["vat_certificate"]["tmp_name"], '../public/assets/upload/vendor_registration/vat_certificate/' . $file_name2);
                $vat_cer= 'assets/upload/vendor_registration/vat_certificate/' . $file_name;
                }
                else{
                    $vat_cer=null;
                }
            //---------------------------
            if(!empty($_FILES['owener_passport_copy']['name'])) {
            $ext = pathinfo($_FILES['owener_passport_copy']['name'], PATHINFO_EXTENSION);
            $file_name3 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["owener_passport_copy"]["tmp_name"], '../public/assets/upload/vendor_registration/owener_passport_copy/' . $file_name3);
            $owener_passport_copy = 'assets/upload/vendor_registration/owener_passport_copy/' . $file_name3;
            }
            else{
                $owener_passport_copy=null;
            }
            //---------------------------
            if(!empty($_FILES['owner_visa_copy']['name'])) {
            $ext = pathinfo($_FILES['owner_visa_copy']['name'], PATHINFO_EXTENSION);
            $file_name4 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["owner_visa_copy"]["tmp_name"], '../public/assets/upload/vendor_registration/owner_visa_copy/' . $file_name4);
            $owner_visa_copy = 'assets/upload/vendor_registration/owner_visa_copy/' . $file_name4;
            }
            else{
                $owner_visa_copy=null;
            }
            //---------------------------
            if(!empty($_FILES['est_card']['name'])) {
            $ext = pathinfo($_FILES['est_card']['name'], PATHINFO_EXTENSION);
            $file_name5 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["est_card"]["tmp_name"], '../public/assets/upload/vendor_registration/est_card/' . $file_name5);
            $est_card = 'assets/upload/vendor_registration/est_card/' . $file_name5;
            }
            else{
                $est_card=null;
            }
            //---------------------------
            if(!empty($_FILES['e_signature_card']['name'])) {
            $ext = pathinfo($_FILES['e_signature_card']['name'], PATHINFO_EXTENSION);
            $file_name6 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["e_signature_card"]["tmp_name"], '../public/assets/upload/vendor_registration/e_signature_card/' . $file_name6);
            $e_signature_card = 'assets/upload/vendor_registration/e_signature_card/' . $file_name6;
            }
            else{
                $e_signature_card=null;
            }

            //---------------------------
            if(!empty($_FILES['company_labour_card']['name'])) {
            $ext = pathinfo($_FILES['company_labour_card']['name'], PATHINFO_EXTENSION);
            $file_name7 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["company_labour_card"]["tmp_name"], '../public/assets/upload/vendor_registration/company_labour_card/' . $file_name7);
            $company_labour_card= 'assets/upload/vendor_registration/company_labour_card/' . $file_name7;
            }
            else{
                $company_labour_card=null;
            }
//-----------------------
                if(!empty($_FILES['owener_emirates_id_copy']['name'])) {

            $ext = pathinfo($_FILES['owener_emirates_id_copy']['name'], PATHINFO_EXTENSION);
            $file_name8 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["owener_emirates_id_copy"]["tmp_name"], '../public/assets/upload/vendor_registration/owener_emirates_id_copy/' . $file_name8);
            $owener_emirates_id_copy= 'assets/upload/vendor_registration/owener_emirates_id_copy/' . $file_name8;
                }
                else{
                    $owener_emirates_id_copy=null;
                }
            //---------------------------
            if(!empty($_FILES['other_doc']['name'])) {
             $ext = pathinfo($_FILES['other_doc']['name'], PATHINFO_EXTENSION);
            $file_name9 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["other_doc"]["tmp_name"], '../public/assets/upload/vendor_registration/other_doc/' . $file_name9);
            $other_doc= 'assets/upload/vendor_registration/other_doc/' . $file_name9;
            }
            else{
                $other_doc=null;
            }
            //---------------------------
            $request_id = IdGenerator::generate(['table' => 'four_pls', 'field' => 'request_no', 'length' => 7, 'prefix' => 'VEN1']);


            $obj = new FourPl();
            $obj->request_no = $request_id;
            $obj->name = $request->input('company_name');
            $obj->address = $request->input('address');
            $obj->phone_no = $request->input('telephone_number');
            $obj->email = $request->input('company_email_address');
            $obj->company_website = $request->input('company_website');
            $obj->zip_code = $request->input('zip_code');
            $obj->company_address = $request->input('company_address');
            $obj->bank_name = $request->input('bank_name');
            $obj->account_number = $request->input('account_number');
            $obj->benificiary_name = $request->input('benificiary_name');
            $obj->iban_number = $request->input('iban_number');
            $obj->bank_address = $request->input('bank_address');
            $obj->aurtorized_eid = $request->input('aurtorized_eid');
            $obj->passport_expiry = $request->input('passport_expiry');
            $obj->contatcs_email = $request->input('contatcs_email');
            $obj->mobile_no = $request->input('mobile_no');
            $obj->company_rep_name = $request->input('company_rep_name');
            $obj->contatcs_email = $request->input('contatcs_email');
            $obj->contacts_telephone_number = $request->input('contacts_telephone_number');
            $obj->key_accounts_rep = $request->input('key_accounts_rep');
            $obj->key_account_email = $request->input('key_account_email');
            $obj->key_mobile = $request->input('key_mobile');
            $obj->key_account_email = $request->input('key_account_email');
            $obj->key_telefone = $request->input('key_telefone');
            $obj->type_of_business = $request->input('type_of_business');
            $obj->company_is = $request->input('company_is');
            $obj->compnany_est_date = $request->input('compnany_est_date');
            $obj->est_code = $request->input('est_code');
            $obj->trade_linces_no = $request->input('trade_linces_no');
            $obj->text_id = $request->input('text_id');
            $obj->trad_license_exp_date = $request->input('trad_license_exp_date');
            $obj->legal_structure = $request->input('legal_structure');
            $obj->trade_license =$trade;
            $obj->vat_certificate =$vat_cer;
            $obj->owener_passport_copy =$owener_passport_copy;
            $obj->owner_visa_copy =$owner_visa_copy;
            $obj->est_card =$est_card;
            $obj->e_signature_card =$e_signature_card;
            $obj->company_labour_card =$company_labour_card;
            $obj->owener_emirates_id_copy =$owener_emirates_id_copy;
            $obj->other_doc = $other_doc;
            $obj->status ='0';
            $obj->save();

            return response()->json([
                'code' => "100"
            ]);
        }
        else {
            $message = [
                'message' => "Something went wrong try again",
                'alert-type' => 'error',
                'error' => ''
            ];
            return response()->json([
                'code' => "101",
                'message' => $message,
            ]);

        }
    }

    public function vendor_on_board(Request $request){
            // dd($request->input('applying_for'));


        if ($request->token == "p2lbgWkFrykA4QyUmpHihzmc5BNzIABq") {
            $validator = Validator::make($request->all(), [
                'contacts_email' => 'unique:vendor_rider_onboards,contacts_email',

            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";

                foreach ($validate->all() as $error){
                    $message_error .= $error;
                }

                $validate = $validator->errors();
                $message = [
                    'message' => "You Have Already Applied",
                    'alert-type' => 'error',
                    'error' => ''
                ];
                return response()->json([
                    'code' => "102",
                    'message' => $message,
                ]);
            }






            if (!file_exists('../public/assets/upload/vendor_on_board/passport_copy/')) {
                mkdir('../public/assets/upload/vendor_on_board/passport_copy/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_on_board/visa_copy/')) {
                mkdir('../public/assets/upload/vendor_on_board/visa_copy/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_on_board/emirates_id_front_side/')) {
                mkdir('../public/assets/upload/vendor_on_board/emirates_id_front_side/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_on_board/emirates_id_front_back/')) {
                mkdir('../public/assets/upload/vendor_on_board/emirates_id_front_back/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_on_board/driving_license_front/')) {
                mkdir('../public/assets/upload/vendor_on_board/driving_license_front/', 0777, true);
            }


            if (!file_exists('../public/assets/upload/vendor_on_board/driving_license_back/')) {
                mkdir('../public/assets/upload/vendor_on_board/driving_license_back/', 0777, true);
            }

              if (!file_exists('../public/assets/upload/vendor_on_board/mulkiya_front/')) {
                            mkdir('../public/assets/upload/vendor_on_board/mulkiya_front/', 0777, true);
                        }


            if (!file_exists('../public/assets/upload/vendor_on_board/mulkiya_back/')) {
                mkdir('../public/assets/upload/vendor_on_board/mulkiya_back/', 0777, true);
            }

            if (!file_exists('../public/assets/upload/vendor_on_board/health_insurance_card_copy/')) {
                mkdir('../public/assets/upload/vendor_on_board/health_insurance_card_copy/', 0777, true);
            }
            if (!file_exists('../public/assets/upload/vendor_on_board/rider_photo/')) {
                mkdir('../public/assets/upload/vendor_on_board/rider_photo/', 0777, true);
            }





            $ext = pathinfo($_FILES['passport_copy']['name'], PATHINFO_EXTENSION);
            $file_name = time() . "_" . $request->date . '.' . $ext;


            move_uploaded_file($_FILES["passport_copy"]["tmp_name"], '../public/assets/upload/vendor_on_board/passport_copy/' . $file_name);
            $passport_copy = 'assets/upload/vendor_on_board/passport_copy/' . $file_name;


            //---------------------------

            $ext = pathinfo($_FILES['visa_copy']['name'], PATHINFO_EXTENSION);
            $file_name2 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["visa_copy"]["tmp_name"], '../public/assets/upload/vendor_on_board/visa_copy/' . $file_name2);
            $visa_copy= 'assets/upload/vendor_on_board/visa_copy/' . $file_name2;

            //---------------------------

            $ext = pathinfo($_FILES['emirates_id_front_side']['name'], PATHINFO_EXTENSION);
            $file_name3 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["emirates_id_front_side"]["tmp_name"], '../public/assets/upload/vendor_on_board/emirates_id_front_side/' . $file_name3);
            $emirates_id_front_side = 'assets/upload/vendor_on_board/emirates_id_front_side/' . $file_name3;

            //---------------------------

            $ext = pathinfo($_FILES['emirates_id_front_back']['name'], PATHINFO_EXTENSION);
            $file_name4 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["emirates_id_front_back"]["tmp_name"], '../public/assets/upload/vendor_on_board/emirates_id_front_back/' . $file_name4);
            $emirates_id_front_back = 'assets/upload/vendor_on_board/emirates_id_front_back/' . $file_name4;

            //---------------------------

            $ext = pathinfo($_FILES['driving_license_front']['name'], PATHINFO_EXTENSION);
            $file_name5 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["driving_license_front"]["tmp_name"], '../public/assets/upload/vendor_on_board/driving_license_front/' . $file_name5);
            $driving_license_front = 'assets/upload/vendor_on_board/driving_license_front/' . $file_name5;

            //---------------------------

            $ext = pathinfo($_FILES['driving_license_back']['name'], PATHINFO_EXTENSION);
            $file_name6 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["driving_license_back"]["tmp_name"], '../public/assets/upload/vendor_on_board/driving_license_back/' . $file_name6);
            $driving_license_back = 'assets/upload/vendor_on_board/driving_license_back/' . $file_name6;


            //---------------------------

            $ext = pathinfo($_FILES['driving_license_front']['name'], PATHINFO_EXTENSION);
            $file_name7 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["driving_license_front"]["tmp_name"], '../public/assets/upload/vendor_on_board/driving_license_front/' . $file_name7);
            $driving_license_front= 'assets/upload/vendor_on_board/driving_license_front/' . $file_name7;



            $ext = pathinfo($_FILES['driving_license_back']['name'], PATHINFO_EXTENSION);
            $file_name8 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["driving_license_back"]["tmp_name"], '../public/assets/upload/vendor_on_board/driving_license_back/' . $file_name8);
            $driving_license_back= 'assets/upload/vendor_on_board/driving_license_back/' . $file_name8;

            //---------------------------


 //---------------------------

            $ext = pathinfo($_FILES['mulkiya_back']['name'], PATHINFO_EXTENSION);
            $file_name11 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["mulkiya_back"]["tmp_name"], '../public/assets/upload/vendor_on_board/mulkiya_back/' . $file_name11);
            $mulkiya_back= 'assets/upload/vendor_on_board/mulkiya_back/' . $file_name7;



            $ext = pathinfo($_FILES['mulkiya_front']['name'], PATHINFO_EXTENSION);
            $file_name12 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["mulkiya_front"]["tmp_name"], '../public/assets/upload/vendor_on_board/mulkiya_front/' . $file_name12);
            $mulkiya_front= 'assets/upload/vendor_on_board/mulkiya_front/' . $file_name8;

            //---------------------------





             $ext = pathinfo($_FILES['health_insurance_card_copy']['name'], PATHINFO_EXTENSION);
            $file_name9 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["health_insurance_card_copy"]["tmp_name"], '../public/assets/upload/vendor_on_board/health_insurance_card_copy/' . $file_name9);
            $health_insurance_card_copy= 'assets/upload/vendor_on_board/health_insurance_card_copy/' . $file_name9;

            //---------------------------


            $ext = pathinfo($_FILES['rider_photo']['name'], PATHINFO_EXTENSION);
            $file_name10 = time() . "_" . $request->date . '.' . $ext;

            move_uploaded_file($_FILES["rider_photo"]["tmp_name"], '../public/assets/upload/vendor_on_board/rider_photo/' . $file_name10);
            $rider_photo= 'assets/upload/vendor_on_board/rider_photo/' . $file_name10;

            //---------------------------




            $request_id = IdGenerator::generate(['table' => 'vendor_registrations', 'field' => 'request_no', 'length' => 7, 'prefix' => 'VEN1']);


            $obj = new VendorRiderOnboard();

            $obj->rider_first_name = $request->input('rider_first_name');
            $obj->rider_last_name = $request->input('rider_last_name');
            $obj->contact_official = $request->input('contact_official');
            $obj->contacts_personal = $request->input('contacts_personal');
            $obj->contacts_email = $request->input('contacts_email');
            $obj->four_pl_name = $request->input('four_pl_name');
            $obj->four_pl_code = $request->input('four_pl_code');
            $obj->emirates_id_no = $request->input('emirates_id_no');
            $obj->passport_no = $request->input('passport_no');
            $obj->driving_license_no = $request->input('driving_license_no');
            $obj->plate_no = $request->input('plate_no');
            $obj->nationality = $request->input('nationality');
            $obj->dob = $request->input('dob');
            $obj->city = $request->input('city');
            $obj->address = $request->input('address');
            $obj->passport_copy =$passport_copy;
            $obj->visa_copy =$visa_copy;
            $obj->emirates_id_front_side =$emirates_id_front_side;
            $obj->emirates_id_front_back =$emirates_id_front_back;
            $obj->driving_license_front =$driving_license_front;
            $obj->driving_license_back =$driving_license_back;
            $obj->health_insurance_card_copy = $health_insurance_card_copy;
            $obj->mulkiya_front =$mulkiya_front;
            $obj->mulkiya_back =$mulkiya_back;
            $obj->rider_photo = $rider_photo;
            $obj->status ='0';
            // $obj->applying_for = $request->input('applying_for');
            $obj->vaccine =$request->input('vaccine');
            // $obj->vaccine_dose =$request->input('vaccine_dose');
            $obj->save();

            return response()->json([
                'code' => "100"
            ]);
        }
        else {
            $message = [
                'message' => "Something went wrong try again",
                'alert-type' => 'error',
                'error' => ''
            ];
            return response()->json([
                'code' => "101",
                'message' => $message,
            ]);

        }
    }
    //vendor 4pl riders page load
  public function vendor_onboard()
    {

        //
        $vendor_new=VendorRiderOnboard::with('vendor')->where('vendor_rider_onboards.status','0')
                    ->orderBy('created_at', 'DESC')
                    ->select('vendor_rider_onboards.*')->where('reapply', NULL)->get();

        $vendor_accept=VendorRiderOnboard::where('status','1')->orderBy('created_at', 'DESC')->get();
        $vendor_reject=VendorRiderOnboard::where('status','2')->orderBy('created_at', 'DESC')->get();
        $vendor_reapply=VendorRiderOnboard::where('status','0')->orderBy('created_at', 'DESC')->where('reapply','1')->get();
        $vendor_rejoin = VendorRiderOnboard::where('vendor_rider_onboards.status','0')
                        ->orderBy('created_at', 'DESC')
                        ->leftJoin('passports', 'passports.passport_no', 'vendor_rider_onboards.passport_no')
                        ->where('passports.cancel_status', 1)
                        ->select('vendor_rider_onboards.*')->get();

        return view('admin-panel.vendor_registration.vendor_rider_onboard',compact('vendor_new','vendor_accept','vendor_reject', 'vendor_reapply', 'vendor_rejoin'));
    }

    public function vendor_onboard_accept_recject(Request $request){

        if($request->ajax()){
            $status = $request->request_type;

            $vendor_new=VendorRiderOnboard::with('vendor')->where('vendor_rider_onboards.status','0')
                    ->orderBy('created_at', 'DESC')
                    ->select('vendor_rider_onboards.*')->where('reapply', NULL)->get();

            $vendor_accept=VendorRiderOnboard::where('status','1')->orderBy('created_at', 'DESC')->get();
            $vendor_reject=VendorRiderOnboard::where('status','2')->orderBy('created_at', 'DESC')->get();
            $vendor_reapply=VendorRiderOnboard::where('status','0')->orderBy('created_at', 'DESC')->where('reapply','1')->get();
            $vendor_rejoin = VendorRiderOnboard::where('vendor_rider_onboards.status','0')
                        ->orderBy('created_at', 'DESC')
                        ->select('vendor_rider_onboards.*')
                        ->leftJoin('passports', 'passports.passport_no', 'vendor_rider_onboards.passport_no')
                        ->where('passports.cancel_status', 1)->get();

           $view = view('admin-panel.vendor_registration.vendor_onboard_accept',compact('vendor_accept','status','vendor_reject','vendor_reapply', 'vendor_rejoin', 'vendor_new'))->render();

            return response()->json(['html'=>$view]);
        }

    }




    public function vendor_onboard_accept(Request $request, $id)
    {

        try{
            $obj = VendorRiderOnboard::find($id);

            $passport_already = Passport::where('passport_no','=',$obj->passport_no)->first();



            if($passport_already != null ){ //if passport number exist but ppuid is not created

                if($passport_already->cancel_status != "1"){

                    $message = [
                        'message' => "Passport number already exist, please cancel his ppuid to accept this rider",
                        'alert-type' => 'error'
                    ];

                }else{

                    $message = [
                        'message' => "Passport number already exist",
                        'alert-type' => 'error'
                    ];

                }


                return redirect()->back()->with($message);

             }

            $career = Career::where('passport_no','=',$obj->passport_no)->first();

            if($career != null){
                $message = [
                    'message' => "This rider is already in career",
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

            $first_seven_digit_passport =  substr($obj->passport_no, 0, 7);

            // $career_five_digit_passport_no = Career::where('passport_no','Like',$first_seven_digit_passport."%")->first();
            // dd($career_five_digit_passport_no);

            // if($career_five_digit_passport_no != null){
            //     $message = [
            //         'message' => "First Seven digit of passport no is already exist",
            //         'alert-type' => 'error'
            //     ];
            //     return redirect()->back()->with($message);
            // }



            // $check_five_passport = Passport::where('passport_no','Like',$first_seven_digit_passport."%")->first();
            // if($check_five_passport != null){
            //     $message = [
            //         'message' => "First Seven digit of passport no is already exist",
            //         'alert-type' => 'error'
            //     ];
            //     return redirect()->back()->with($message);
            // }

            $passport_already_renew = RenewPassport::where('renew_passport_number','=',$obj->passport_no)->first();

            if($passport_already_renew != null){ //if renew passport number exist but ppuid is not created
                             $message = [
                                 'message' => 'This Rider already in renewal passport',
                                 'alert-type' => 'error'
                             ];
             return redirect()->back()->with($message);
             }





             $name = $obj->rider_first_name;
             $last_name = $obj->rider_last_name;
             $phone  = $obj->contacts_personal;
             $passport_no  = $obj->passport_no;
             $license_no   = $obj->driving_license_no;
             $vehicle_type   = $obj->applying_for;
             if($vehicle_type==null){
                 $vehicle_type='1';
             }
             $obj->status ='1';
             $obj->save();


            //  $four_pl_history = new FourPl_rider_history();
            //  $four_pl_history->passport_id = $passport_already->id;
            //  $four_pl_history->employee_type = "2";
            //  $four_pl_history->vendor_fourpl_pk_id = $id;
            //  $four_pl_history->save();

            $career = new Career();
            $career->name = $name." ".$last_name;
            $career->phone =  $phone;
            $career->passport_no =  $passport_no;
            $career->licence_no =  $license_no;
            $career->employee_type =  "2";
            $career->licence_status =  "1";
            $career->vendor_fourpl_pk_id =  $id;
            $career->applicant_status =  "5";
            $career->vehicle_type = $vehicle_type;
            $career->save();

            $message = [
                'message' => '4PL Rider Accepted Successfully!!',
                'alert-type' => 'success'
            ];



            $four_pl_history = new FourPl_rider_history();
            $four_pl_history->career_id = $career->id;
            $four_pl_history->employee_type = "2";
            $four_pl_history->vendor_fourpl_pk_id = $id;
            $four_pl_history->save();



            return redirect()->back()->with($message);
        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured'.$e,
                'alert-type' => 'error'
            ];


            return redirect()->back()->with($message);
        }
    }



    public function vendor_onboard_accept_rejoin(Request $request)
    {

        try{
            $id = $request->primary_id;
            $obj = VendorRiderOnboard::find($id);





            $passport_already = Passport::where('passport_no',$obj->passport_no)->first();

            if($passport_already==null){

                $message = [
                    'message' => 'passport number not found,contact admin',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

            }

             $ppuid_canceled = PpuidCancel::where('passport_id','=',$passport_already->id)->where('status','=','1')->first();

             if($ppuid_canceled == null){

                $message = [
                    'message' => 'ppuid is not cancelled.!',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);

             }


            $obj->status = "1";
            $obj->update();

             $four_pl_history = new FourPl_rider_history();
             $four_pl_history->passport_id = $passport_already->id;
             $four_pl_history->employee_type = "2";
             $four_pl_history->vendor_fourpl_pk_id = $id;
             $four_pl_history->save();



             $current_timestamp = Carbon::now();

              $ppuid_cancel = PpuidCancel::where('passport_id','=',$passport_already->id)
                         ->where('status','=','1')->first();

            if($ppuid_cancel!=null){
                $ppuid_cancel->reactivate_date_time = $current_timestamp;
                $ppuid_cancel->reactivate_remarks = $request->reactivate_remarks;
                $ppuid_cancel->status = "0";
                $ppuid_cancel->save();
            }


                $rejoin = new RejoinCareer();
                $rejoin->passport_id = $passport_already->id;
                $is_ready_array  = array(['1' => $current_timestamp]);
                $rejoin->history_status = json_encode($is_ready_array);
                $rejoin->applicant_status = 5;
                $rejoin->save();


                $passport_already->cancel_status ="0";
                $passport_already->update();


            $message = [
                'message' => '4PL Rider Accepted Successfully!!',
                'alert-type' => 'success'
            ];



            return redirect()->back()->with($message);
        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured'.$e,
                'alert-type' => 'error'
            ];


            return redirect()->back()->with($message);
        }
    }

    public function cancellation_ppuid_ajax(Request $request){


        if($request->ajax()){
            $id = $request->primary_id;

            $obj = VendorRiderOnboard::find($id);



             $passport = Passport::where('passport_no',$obj->passport_no)->first();



           $pppuid_cancel_detail = PpuidCancel::where('passport_id','=',$passport->id)->where('status','=','1')->first();

            $html = view('admin-panel.vendor_registration.cancellatin_info_ajax_detail',compact('pppuid_cancel_detail','id'))->render();

            return response()->json(['html'=>$html]);

        }

    }



    public function vendor_onboard_reject(Request $request)
    {
        try {

            $obj = VendorRiderOnboard::find($request->vendor_id);
            $obj->status ='2';
            $obj->remarks = $request->remarks;
            $obj->save();
            $message = [
                'message' => '4PL Rider Rejected Successfully!!',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }

    public function vendor_onboard_pending($id){
    try {

        $obj = VendorRiderOnboard::find($id);

        $obj->status ='0';
        $obj->save();

        $message = [
            'message' => '4PL Rider Moved to Pending Successfully!!',
            'alert-type' => 'success'

        ];


        return redirect()->back()->with($message);
    } catch (\Illuminate\Database\QueryException $e) {
        $message = [
            'message' => 'Error Occured',
            'alert-type' => 'error'
        ];
        return redirect()->back()->with($message);
    }
}

    public function vendor_report()
    {
        $vendor_accept=FourPl::where('status','1')->get();
        return view('admin-panel.vendor_registration.vendor_report',compact('vendor_accept'));
    }

    public function vendor_cancel()
    {
        $vendor_accept=FourPl::where('status','1')->get();
        return view('admin-panel.vendor_registration.vendor-cancel', compact('vendor_accept'));
    }

    public function post_vendor_cancel(Request $request)
    {
        $vendor = VendorRiderOnboard::with('platform_report')
                    ->select('vendor_rider_onboards.rider_first_name', 'vendor_rider_onboards.rider_last_name', 'passports.passport_no', 'passports.id as passport_id')
                    ->join('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                    ->join('passports', 'passports.career_id', 'careers.id')
                    ->where('vendor_rider_onboards.cancel_status', 0)
                    ->where('vendor_rider_onboards.four_pls_id', $request->id)
                    ->get();

        $assigned_platform = 0;
        $assigned_sim = 0;
        $assigned_bike = 0;
        foreach($vendor as $ven) {
            if($ven->assign_platform_check()) {
                $assigned_platform += 1;
            }
            if($ven->assign_bike_check()) {
                $assigned_bike += 1;
            }
            if($ven->assign_sim_check()) {
                $assigned_sim += 1;
            }
        }

        if( $assigned_platform == 0 && $assigned_bike==0 && $assigned_sim == 0) {

            \DB::beginTransaction();

            try {

                foreach($vendor as $ven) {
                    Passport::where('id', $ven->passport_id)->update([ 'cancel_status' => 1]);
                }

                FourPl::where('id', $request->id)->update(['status' => 3]);

                \DB::commit();

                $message = [
                    'message' => 'Cancelled Successfully!!',
                    'alert-type' => 'success'
                ];
                // all good
            } catch (\Exception $e) {
                \DB::rollback();
                // something went wrong
                $message = [
                    'message' => 'Something Failed!!',
                    'alert-type' => 'error'
                ];
            }



            return back()->with($message);
        }

        $message = [
            'message' => 'Something went wrong!!',
            'alert-type' => 'error'
        ];

        return back()->with($message);
    }

    public function ajax_vendor_cancel(Request $request)
    {
        $vendor = VendorRiderOnboard::with('platform_report')
                    ->select('vendor_rider_onboards.rider_first_name', 'vendor_rider_onboards.rider_last_name', 'passports.passport_no', 'passports.id as passport_id')
                    ->join('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                    ->where('vendor_rider_onboards.cancel_status', 0)
                    ->join('passports', 'passports.career_id', 'careers.id');
        if($request->id){
            $vendor = $vendor->where('vendor_rider_onboards.four_pls_id', $request->id);
        }
        $vendor = $vendor->get();

        $table = Datatables::of($vendor)
                ->editColumn('assign_platform', function($vendor){
                    if($vendor->assign_platform_check()) {
                        return 'Yes';
                    }
                    return 'No';
                })
                ->editColumn('assign_bike', function($vendor){
                    if($vendor->assign_bike_check()) {
                        return 'Yes';
                    }
                    return 'No';
                })
                ->editColumn('assign_sim', function($vendor){
                    if($vendor->assign_sim_check()) {
                        return 'Yes';
                    }
                    return 'No';
                });
        return $table->make(true);
    }

    public function ajax_vendor_assigned_count(Request $request)
    {
        $vendor = VendorRiderOnboard::with('platform_report')
                    ->select('vendor_rider_onboards.rider_first_name', 'vendor_rider_onboards.rider_last_name', 'passports.passport_no', 'passports.id as passport_id')
                    ->join('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                    ->join('passports', 'passports.career_id', 'careers.id')
                    ->where('vendor_rider_onboards.four_pls_id', $request->id)
                    ->get();

        $assigned_platform = 0;
        $assigned_sim = 0;
        $assigned_bike = 0;
        foreach($vendor as $ven) {
            if($ven->assign_platform_check()) {
                $assigned_platform += 1;
            }
            if($ven->assign_bike_check()) {
                $assigned_bike += 1;
            }
            if($ven->assign_sim_check()) {
                $assigned_sim += 1;
            }
        }

        $count = [
            'assigned_platform' => $assigned_platform,
            'assigned_sim' => $assigned_sim,
            'assigned_bike' => $assigned_bike,
        ];

        return response()->json($count, 200);
    }

    public function ajax_vendor_rider(Request $request)
    {

            $vendor_accept = VendorRiderOnboard::with('platform', 'interview', 'onboard')
                            ->select('vendor_rider_onboards.rider_first_name', 'vendor_rider_onboards.rider_last_name',
                            'vendor_rider_onboards.passport_no', 'vendor_rider_onboards.contacts_email',
                            'vendor_rider_onboards.contact_official', 'vendor_rider_onboards.contacts_personal', 'vendor_rider_onboards.four_pls_id',
                            'vendor_rider_onboards.rider_last_name','careers.applicant_status', 'passports.id', 'passports.pp_uid',
                            'rejoin_careers.hire_status', 'careers.id as career_id')
                            ->where('vendor_rider_onboards.status', 1);
                            if($request->id){
                                $vendor_accept = $vendor_accept->where('vendor_rider_onboards.four_pls_id', $request->id);
                            }
            $vendor_accept = $vendor_accept->leftJoin('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                            // ->leftJoin('create_interviews', 'careers.id', 'create_interviews.career_id')
                            // ->leftJoin('create_interviews', function($query) {
                            //     $query->on('careers.id', 'create_interviews.career_id')
                            //             ->groupBy('create_interviews.career_id');
                            //         // ->whereRaw('comments.id IN (select MAX(a2.id) from comments as a2 join articles as u2 on u2.id = a2.article_id group by u2.id)');
                            // })
                            ->where('careers.deleted_at', NULL)
                            ->with('vendor:id,name')
                            // ->leftJoin('on_boarding_statuses', 'careers.id', 'on_boarding_statuses.career_id')
                            ->leftJoin('passports', 'passports.career_id', 'careers.id')
                            ->leftJoin('rejoin_careers', 'rejoin_careers.passport_id', 'passports.id')
                            // ->groupBy('vendor_rider_onboards.id')
                            ->get();


            $table = Datatables::of($vendor_accept)
                    ->editColumn('status', function($vendor_accept){
                        if(!count($vendor_accept['platform']) == 0){
                            $working = 0;
                            $offboard = 0;
                            foreach($vendor_accept['platform'] as $platform){
                                if($platform->status == 1){
                                    $working++;
                                    $checkin = $platform->checkin;
                                }
                                if($platform->status == 0){
                                    $offboard++;
                                }
                            }
                            if($working > 0){
                                return 'Actively Working';
                            }elseif($vendor_accept->hire_status === 0){
                                return 'Waiting To Onboard (Rejoin)';
                            }
                            elseif($offboard > 0){
                                return 'Offboarded';
                            }
                        }
                        elseif($vendor_accept->applicant_status == 1){
                            return 'Rejected';
                        }elseif($vendor_accept->applicant_status == 5){
                            return 'Waitlisted';
                        }
                        // elseif($vendor_accept->applicant_status == 4){
                            if($vendor_accept->interview) {
                                if($vendor_accept->interview->interview_status == 1) {
                                    return 'Interview Passed';
                                }
                                elseif($vendor_accept->interview->interview_status == 2) {
                                    return 'Interview Failed';
                                }
                                elseif($vendor_accept->interview->interview_status == 3) {
                                    return 'Interview Rejected';
                                }
                            }

                            elseif($vendor_accept->applicant_status == 4) {
                                return 'Selected';
                            }

                        // }
                        elseif($vendor_accept->applicant_status == 5 || $vendor_accept->applicant_status == 4 || $vendor_accept->applicant_status === 0 ){
                            return 'Waiting To Onboard';
                        }
                        if($vendor_accept->onboard) {
                            if($vendor_accept->onboard->interview_status == 1 && $vendor_accept->onboard->assign_platform == 1 && $vendor_accept->onboard->on_board == 1) {
                                return 'Waiting To Onboard';
                            }
                        }

                    })
                    ->editColumn('vendor', function($vendor_accept){
                            if($vendor_accept->vendor) {
                                return $vendor_accept->vendor->name;
                            }
                            return 'N/A';
                        })
                    ->editColumn('checkin', function($vendor_accept){
                        foreach($vendor_accept['platform'] as $platform){
                            if($platform->status == 1) {
                                if($platform->checkin) {
                                    return $platform->checkin;
                                }else{
                                    return 'Error';
                                }
                            }
                        }
                        return 'N/A';

                    });
            return $table->make(true);
    }

    public function ajax_vendor_rider_cod(Request $request)
    {

            $vendor_accept = VendorRiderOnboard::with('platform', 'interview', 'onboard')
                            ->select('vendor_rider_onboards.rider_first_name', 'vendor_rider_onboards.rider_last_name',
                            'vendor_rider_onboards.passport_no', 'vendor_rider_onboards.contacts_email',
                            'vendor_rider_onboards.contact_official', 'vendor_rider_onboards.contacts_personal', 'vendor_rider_onboards.four_pls_id',
                            'vendor_rider_onboards.rider_last_name','careers.applicant_status', 'passports.id', 'passports.pp_uid',
                            'rejoin_careers.hire_status', 'careers.id as career_id', 'talabat_cod.current_day_balance', 'talabat_cod.current_day_cod','talabat_cod.start_date',
                            'talabat_cod.previous_day_balance', 'talabat_cod.current_day_cash_deposit', 'talabat_cod.previous_day_pending')
                            ->where('vendor_rider_onboards.status', 1);
                            if($request->id){
                                $vendor_accept = $vendor_accept->where('vendor_rider_onboards.four_pls_id', $request->id);
                            }
            $vendor_accept = $vendor_accept->leftJoin('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                            // ->leftJoin('create_interviews', 'careers.id', 'create_interviews.career_id')
                            // ->leftJoin('create_interviews', function($query) {
                            //     $query->on('careers.id', 'create_interviews.career_id')
                            //             ->groupBy('create_interviews.career_id');
                            //         // ->whereRaw('comments.id IN (select MAX(a2.id) from comments as a2 join articles as u2 on u2.id = a2.article_id group by u2.id)');
                            // })
                            ->where('careers.deleted_at', NULL)
                            ->with('vendor:id,name')
                            // ->leftJoin('on_boarding_statuses', 'careers.id', 'on_boarding_statuses.career_id')
                            ->leftJoin('passports', 'passports.career_id', 'careers.id')
                            ->leftJoin('rejoin_careers', 'rejoin_careers.passport_id', 'passports.id');
                            if($request->date) {
                                $vendor_accept =  $vendor_accept->join('talabat_cod', 'talabat_cod.passport_id', 'passports.id');
                            }
                            else{
                                $vendor_accept->join('talabat_cod', function($query)
                                {
                                    $query->on('talabat_cod.passport_id','=','passports.id')
                                    ->whereRaw('talabat_cod.id IN (select MAX(t2.id) from talabat_cod as t2 join passports as p2 on p2.id = t2.passport_id group by t2.passport_id)');
                                });
                            }
                            if($request->date) {
                                $vendor_accept =  $vendor_accept->whereDate('talabat_cod.start_date', $request->date);
                            }
                            // ->groupBy('vendor_rider_onboards.id')
                            $vendor_accept =  $vendor_accept->get();


            $table = Datatables::of($vendor_accept)
                    ->editColumn('status', function($vendor_accept){
                        if(!count($vendor_accept['platform']) == 0){
                            $working = 0;
                            $offboard = 0;
                            foreach($vendor_accept['platform'] as $platform){
                                if($platform->status == 1){
                                    $working++;
                                    $checkin = $platform->checkin;
                                }
                                if($platform->status == 0){
                                    $offboard++;
                                }
                            }
                            if($working > 0){
                                return 'Actively Working';
                            }elseif($vendor_accept->hire_status === 0){
                                return 'Waiting To Onboard (Rejoin)';
                            }
                            elseif($offboard > 0){
                                return 'Offboarded';
                            }
                        }
                        elseif($vendor_accept->applicant_status == 1){
                            return 'Rejected';
                        }elseif($vendor_accept->applicant_status == 5){
                            return 'Waitlisted';
                        }
                        // elseif($vendor_accept->applicant_status == 4){
                            if($vendor_accept->interview) {
                                if($vendor_accept->interview->interview_status == 1) {
                                    return 'Interview Passed';
                                }
                                elseif($vendor_accept->interview->interview_status == 2) {
                                    return 'Interview Failed';
                                }
                                elseif($vendor_accept->interview->interview_status == 3) {
                                    return 'Interview Rejected';
                                }
                            }

                            elseif($vendor_accept->applicant_status == 4) {
                                return 'Selected';
                            }

                        // }
                        elseif($vendor_accept->applicant_status == 5 || $vendor_accept->applicant_status == 4 || $vendor_accept->applicant_status === 0 ){
                            return 'Waiting To Onboard';
                        }
                        if($vendor_accept->onboard) {
                            if($vendor_accept->onboard->interview_status == 1 && $vendor_accept->onboard->assign_platform == 1 && $vendor_accept->onboard->on_board == 1) {
                                return 'Waiting To Onboard';
                            }
                        }

                    })
                    ->editColumn('vendor', function($vendor_accept){
                            if($vendor_accept->vendor) {
                                return $vendor_accept->vendor->name;
                            }
                            return 'N/A';
                        })
                    ->editColumn('checkin', function($vendor_accept){
                        foreach($vendor_accept['platform'] as $platform){
                            if($platform->status == 1) {
                                if($platform->checkin) {
                                    return $platform->checkin;
                                }else{
                                    return 'Error';
                                }
                            }
                        }
                        return 'N/A';

                    });
            return $table->make(true);
    }

    public function vendor_onboard_edit($id) {

        $obj = VendorRiderOnboard::find($id);
        $nationalities = Nationality::all();
        return view('admin-panel.vendor_registration.edit_onboard', compact('obj', 'nationalities'));

    }

    public function vendor_onboard_update(Request $request, $id) {

        $obj = VendorRiderOnboard::find($id);
        $obj->rider_first_name = $request->rider_first_name;
        $obj->rider_last_name = $request->rider_last_name;
        $obj->contact_official = $request->contact_official;
        $obj->contacts_personal = $request->contacts_personal;
        $obj->contacts_email = $request->contacts_email;
        $obj->emirates_id_no = $request->emirates_id_no;
        $obj->passport_no = $request->passport_no;
        $obj->driving_license_no = $request->driving_license_no;
        $obj->plate_no = $request->plate_no;
        $obj->dob = $request->dob;
        $obj->city = $request->city;
        $obj->address = $request->address;
        $obj->passport_expiry = $request->passport_expiry;
        $obj->visa_expiry = $request->visa_expiry;
        $obj->emirates_expiry = $request->emirates_expiry;
        $obj->driving_license_expiry = $request->driving_license_expiry;
        $obj->mulkiya_expiry = $request->mulkiya_expiry;
        $obj->insurance_expiry = $request->insurance_expiry;
        $obj->vaccine = $request->vaccine;
        $obj->applying_for = $request->applying_for;
        $obj->nationality = $request->nationality;

        if($request->passport_copy != null){

            $img = $request->file('passport_copy');
            $imageName = 'assets/upload/vendor_on_board/passport_copy/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->passport_copy = $imageName;

        }
        if($request->visa_copy != null){

            $img = $request->file('visa_copy');
            $imageName = 'assets/upload/vendor_on_board/visa_copy/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->visa_copy = $imageName;
        }

        if($request->emirates_id_front_side != null){
            $img = $request->file('emirates_id_front_side');
            $imageName = 'assets/upload/vendor_on_board/emirates_id_front_side/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->emirates_id_front_side = $imageName;
        }
        if($request->emirates_id_front_back != null){
            $img = $request->file('emirates_id_front_back');
            $imageName = 'assets/upload/vendor_on_board/emirates_id_front_back/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->emirates_id_front_back = $imageName;
        }

        if($request->driving_license_front != null){
            $img = $request->file('driving_license_front');
            $imageName = 'assets/upload/vendor_on_board/driving_license_front/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->driving_license_front = $imageName;
        }
        if($request->driving_license_back != null){
            $img = $request->file('driving_license_back');
            $imageName = 'assets/upload/vendor_on_board/driving_license_back/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->driving_license_back = $imageName;
        }
        if($request->mulkiya_front != null){
            $img = $request->file('mulkiya_front');
            $imageName = 'assets/upload/vendor_on_board/mulkiya_front/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->mulkiya_front = $imageName;
        }

        if($request->mulkiya_back != null){
            $img = $request->file('mulkiya_back');
            $imageName = 'assets/upload/vendor_on_board/mulkiya_back/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->mulkiya_back = $imageName;
        }

        if($request->health_insurance_card_copy != null){
            $img = $request->file('health_insurance_card_copy');
            $imageName = 'assets/upload/vendor_on_board/health_insurance_card_copy/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->health_insurance_card_copy = $imageName;
        }

        if($request->rider_photo != null){
            $img = $request->file('rider_photo');
            $imageName = 'assets/upload/vendor_on_board/rider_photo/' . time() . '.' . $img ->getClientOriginalExtension();
            Storage::disk("s3")->put($imageName, file_get_contents($img));
            $obj->rider_photo = $imageName;
        }

        $obj->save();

        $message = [
            'message' => 'Updated Successfully!!',
            'alert-type' => 'success'
        ];

        return redirect()->route('vendor_onboard')->with($message);

    }

}
