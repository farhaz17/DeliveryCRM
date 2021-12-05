<?php

namespace App\Http\Controllers\Api\FourPL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\FourPlRegisterEmail;
use App\Model\FourPl\FourPlUser;
use App\User;
use App\Model\Master\FourPl;
use App\Model\VendorRegistration\VendorRiderOnboard;
use Mail;
use Hash;
use Auth;


class ManageRiderController extends Controller
{

    public function get_rider_list(Request $request) {
        $id = FourPl::where('user_id', $request->id)->value('id');
        $data = VendorRiderOnboard::with('nation')->where('four_pls_id', $id)->get();
        $approved = VendorRiderOnboard::where('four_pls_id', $id)->where('status', 1)->select((\DB::raw('status, count(*) as count')))->first();
        $rejected = VendorRiderOnboard::where('four_pls_id', $id)->where('status', 2)->select((\DB::raw('status, count(*) as count')))->first();
        $submitted = VendorRiderOnboard::where('four_pls_id', $id)->where('status', 'LIKE' , 0)->select((\DB::raw('status, count(*) as count')))->first();
        $draft = VendorRiderOnboard::where('four_pls_id', $id)->where('status', '')->select((\DB::raw('status, count(*) as count')))->first();
        $count = [
            'approved' => $approved,
            'rejected' => $rejected,
            'submitted' => $submitted,
            'draft' => $draft,
        ];
        $data = [
            'data' => $data,
            'count' => $count,
            'response' => 'success',
            'code' => 200,
        ];
        // \Log::info('---------Data----------');
        // \Log::info($submitted);
        return $data;
    }

    public function approved_rider_status(Request $request) {
        $id = FourPl::where('user_id', $request->id)->value('id');
        $data = VendorRiderOnboard::with('platform', 'interview', 'nation', 'onboard')
                ->select('vendor_rider_onboards.rider_first_name', 'vendor_rider_onboards.rider_last_name',
                'vendor_rider_onboards.passport_no', 'vendor_rider_onboards.contacts_email',
                'vendor_rider_onboards.contact_official', 'vendor_rider_onboards.contacts_personal',
                'vendor_rider_onboards.rider_last_name','careers.applicant_status', 'passports.id', 'passports.pp_uid',
                'rejoin_careers.hire_status', 'careers.id as career_id', 'vendor_rider_onboards.driving_license_no', 'vendor_rider_onboards.nationality')
                ->where('vendor_rider_onboards.status', 1)
                ->where('vendor_rider_onboards.four_pls_id', $id)
                ->leftJoin('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                ->where('careers.deleted_at', NULL)
                // ->leftJoin('on_boarding_statuses', 'careers.id', 'on_boarding_statuses.career_id')
                ->leftJoin('passports', 'passports.career_id', 'careers.id')
                ->leftJoin('rejoin_careers', 'rejoin_careers.passport_id', 'passports.id')
                // ->groupBy('vendor_rider_onboards.id')
                ->get();
        $data = [
            'data' => $data,
            'response' => 'success',
            'code' => 200,
        ];

        return $data;
    }

    public function edit_rider(Request $request) {
        $four_pl_id = FourPl::where('user_id', $request->user_id)->value('id');
        $data = VendorRiderOnboard::where('id', $request->id)->whereIn('status', ['',2])->first();
        // \Log::info($four_pl_id);
        if($four_pl_id == $data->four_pls_id) {
            $data = [
                'data' => $data,
                'response' => 'success',
                'code' => 200,
            ];
        } else{
            $data = [
                'data' => 'Permission Denied',
                'response' => 'success',
                'code' => 201,
            ];
        }

        return $data;
    }

}
