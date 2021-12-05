<?php

namespace App\Http\Controllers\Api\FourPl;

use App\Model\Master\FourPl;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use App\Model\Passport\Passport;
use App\Http\Controllers\Controller;
use App\Model\Assign\AssignPlateform;
use Illuminate\Support\Facades\Storage;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Model\VendorRegistration\VendorRiderOnboard;

class RegistrationControlle extends Controller
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
    public function register(Request $request)
    {
        // return $request->all();
        try {

        $request_id = IdGenerator::generate(['table' => 'four_pls', 'field' => 'request_no', 'length' => 7, 'prefix' => 'VEN1']);

        $abc = FourPl::firstOrNew(array('user_id' => $request->user_id));
        // $abc->user_id = $request->user_id;
        if(!$abc->id) {
            $abc->request_no = $request_id;
        }
        $abc->name = $request->company_name;
        $abc->address = $request->address;
        $abc->phone_no = $request->telephone_number;
        $abc->email = $request->email;
        $abc->company_website = $request->company_website;
        $abc->zip_code = $request->zip_code;
        $abc->company_address = $request->company_address;

        $abc->company_rep_name = $request->company_rep_name;
        $abc->company_email_address = $request->company_email_address;
        $abc->mobile_no = $request->mobile_no;
        $abc->contacts_telephone_number = $request->contacts_telephone_number;
        $abc->key_accounts_rep = $request->key_accounts_rep;
        $abc->key_account_email = $request->key_account_email;
        $abc->key_mobile = $request->key_mobile;
        $abc->key_telefone = $request->key_telefone;

        $abc->bank_name = $request->bank_name;
        $abc->account_number = $request->account_number;
        $abc->benificiary_name = $request->benificiary_name;
        $abc->iban_number = $request->iban_number;
        $abc->bank_address = $request->bank_address;
        $abc->aurtorized_eid = $request->aurtorized_eid;

        $abc->type_of_business = $request->type_of_business;
        $abc->compnany_est_date = $request->compnany_est_date;
        $abc->company_is = $request->company_is;
        $abc->est_code = $request->est_code;
        $abc->trade_linces_no = $request->trade_linces_no;
        $abc->trad_license_exp_date = $request->trad_license_exp_date;
        $abc->text_id = $request->text_id;
        $abc->legal_structure = $request->legal_structure;

        if($request->submit_status) {
            $abc->submit_status = $request->submit_status;
            $abc->status = 0;
        }

        if($request->trade_license != null){
            $ext = pathinfo($request->file_name1, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/trade_lin/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->trade_license));
            $abc->trade_license = $imageName;
        }

        if($request->est_card != null){
            // $data = base64_decode($request->est_card);
            $ext = pathinfo($request->file_name2, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/est_card/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->est_card));
            $abc->est_card = $imageName;
        }

        if($request->vat_certificate != null){
            $ext = pathinfo($request->file_name3, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/vat_certificate/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->vat_certificate));
            $abc->vat_certificate = $imageName;
        }

        if($request->e_signature_card != null){
            $ext = pathinfo($request->file_name4, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/e_signature_card/' .  time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->e_signature_card));
            $abc->e_signature_card = $imageName;
        }

        if($request->other_doc != null){
            $ext = pathinfo($request->file_name5, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/other_doc/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->other_doc));
            $abc->other_doc = $imageName;
        }

        if($request->owener_passport_copy != null){
            $ext = pathinfo($request->file_name6, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/owener_passport_copy/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->owener_passport_copy));
            $abc->owener_passport_copy = $imageName;
        }

        if($request->company_labour_card != null){
            $ext = pathinfo($request->file_name7, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/company_labour_card/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->company_labour_card));
            $abc->company_labour_card = $imageName;
        }

        if($request->owner_visa_copy != null){
            $ext = pathinfo($request->file_name8, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/owner_visa_copy/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->owner_visa_copy));
            $abc->owner_visa_copy = $imageName;
        }

        if($request->owener_emirates_id_copy != null){
            $ext = pathinfo($request->file_name9, PATHINFO_EXTENSION);
            $imageName = 'assets/upload/vendor_registration/owener_emirates_id_copy/' . time() . str_random(10).'.'. $ext;
            Storage::disk('s3')->put($imageName, base64_decode($request->owener_emirates_id_copy));
            $abc->owener_emirates_id_copy = $imageName;
        }

        $abc->save();

        $data = [
            'response' => 'success',
            'code' => 200
            ];
        }
        catch(\Exception $e) {
            $data = [
                'response' => $e,
                'code' => 201,
            ];
            $error = sprintf('[%s],[%d] ERROR:[%s]', __METHOD__, __LINE__, json_encode($e->getMessage(), true));
            \Log::channel('fourpl')->info($error);
        }
        return response()->json($data, 200);
    }

    public function add_rider(Request $request)
    {
        // return $request->all();
        // \Log::info($request->all());

        $four_pl_id = FourPl::where('user_id', $request->user_id)->value('id');
        $rider = VendorRiderOnboard::where('passport_no', $request->passport_no)->where('four_pls_id', $four_pl_id)->where('cancel_status', 0)->where('id', '!=', $request->id)->first();
        $passport = Passport::where('passport_no', $request->passport_no)->where('cancel_status', 0)->first();

        if($rider && $passport) {
            $data = [
                'response' => 'Duplicate Data',
                'code' => 202
                ];

            return response()->json($data, 202);
        }


        try {

            $four_pl_id = FourPl::where('user_id', $request->user_id)->value('id');
            $obj = VendorRiderOnboard::firstOrNew(array('id' => $request->id));
            $obj->four_pls_id = $four_pl_id;
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
            $obj->previous_company = $request->previous_company;
            $obj->previous_platform = $request->previous_platform;
            $obj->previous_rider_id = $request->previous_rider_id;
            if($request->submit_status) {
                $obj->status = 0;
            }
            if($request->reapply) {
                $obj->reapply = 1;
                $obj->remarks = '';
            }


            if($request->passport_copy != null){
                $ext = pathinfo($request->file_name1, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/passport_copy/' .  time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->passport_copy));
                $obj->passport_copy = $imageName;
            }
            if($request->visa_copy != null){
                $ext = pathinfo($request->file_name2, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/visa_copy/' .  time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->visa_copy));
                $obj->visa_copy = $imageName;
            }
            if($request->emirates_id_front_side != null){
                $ext = pathinfo($request->file_name3, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/emirates_id_front_side/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->emirates_id_front_side));
                $obj->emirates_id_front_side = $imageName;
            }
            if($request->emirates_id_front_back != null){
                $ext = pathinfo($request->file_name4, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/emirates_id_front_back/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->emirates_id_front_back));
                $obj->emirates_id_front_back = $imageName;
            }
            if($request->driving_license_front != null){
                $ext = pathinfo($request->file_name5, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/driving_license_front/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->driving_license_front));
                $obj->driving_license_front = $imageName;
            }
            if($request->driving_license_back != null){
                $ext = pathinfo($request->file_name6, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/driving_license_back/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->driving_license_back));
                $obj->driving_license_back = $imageName;
            }
            if($request->mulkiya_front != null){
                $ext = pathinfo($request->file_name7, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/mulkiya_front/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->mulkiya_front));
                $obj->mulkiya_front = $imageName;
            }
            if($request->mulkiya_back != null){
                $ext = pathinfo($request->file_name8, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/mulkiya_back/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->mulkiya_back));
                $obj->mulkiya_back = $imageName;
            }
            if($request->health_insurance_card_copy != null){
                $ext = pathinfo($request->file_name9, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/health_insurance_card_copy/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->health_insurance_card_copy));
                $obj->health_insurance_card_copy = $imageName;
            }
            if($request->rider_photo != null){
                $ext = pathinfo($request->file_name10, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/rider_photo/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->rider_photo));
                $obj->rider_photo = $imageName;
            }
            if($request->vaccination_card != null){
                $ext = pathinfo($request->file_name11, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/vaccination_card/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->vaccination_card));
                $obj->vaccination_card = $imageName;
            }
            if($request->box_pic != null){
                $ext = pathinfo($request->file_name12, PATHINFO_EXTENSION);
                $imageName = 'assets/upload/vendor_on_board/box_pic/' . time() . str_random(10).'.'. $ext;
                Storage::disk('s3')->put($imageName, base64_decode($request->box_pic));
                $obj->box_pic = $imageName;
            }


            $obj->save();

            $data = [
                'response' => 'success',
                'code' => 200
                ];
            }
            catch(\Exception $e) {
                $data = [
                    'response' => $e,
                    'code' => 201,
                ];
                $error = sprintf('[%s],[%d] ERROR:[%s]', __METHOD__, __LINE__, json_encode($e->getMessage(), true));
                \Log::channel('fourpl')->info($error);
            }
            return response()->json($data, 200);
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
        //
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
