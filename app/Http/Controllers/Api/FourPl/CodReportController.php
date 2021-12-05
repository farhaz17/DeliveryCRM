<?php

namespace App\Http\Controllers\Api\FourPl;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\TalabatCod\TalabatCod;
use App\Model\VendorRegistration\VendorRiderOnboard;

class CodReportController extends Controller
{
    public function cod_report(Request $request) {

        $last_cod_date = TalabatCod::latest('start_date')->first()->start_date;
        // $data = TalabatCod::with(['passport.personal_info', 'passport.sim.telecome', 'passport.zds_code', 'passport.assign_to_dcs.user_detail'])
        // ->whereDate('start_date', $last_cod_date)
        // ->join('passports', 'passports.id', 'talabat_cod.passport_id')
        // ->join('careers', 'careers.id', 'passports.career_id')
        // ->join('vendor_rider_onboards', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
        // ->join('four_pls', 'four_pls.id', 'vendor_rider_onboards.four_pls_id')
        // ->where('four_pls.user_id', $request->id)
        // ->get();

        $data = VendorRiderOnboard::with('platform', 'interview', 'nation')
                // ->select('vendor_rider_onboard.*', 'talabat_cod.start_date')
                ->join('careers', 'vendor_rider_onboards.id', 'careers.vendor_fourpl_pk_id')
                ->join('passports', 'passports.career_id', 'careers.id');
                if($request->date) {
                    $data =  $data->join('talabat_cod', 'talabat_cod.passport_id', 'passports.id');
                } else{
                    $data =  $data->join('talabat_cod', function($query)
                    {
                        $query->on('talabat_cod.passport_id','=','passports.id')
                        ->whereRaw('talabat_cod.id IN (select MAX(t2.id) from talabat_cod as t2 join passports as p2 on p2.id = t2.passport_id group by t2.passport_id)');
                    });
                }
                //

                $data =  $data->join('four_pls', 'four_pls.id', 'vendor_rider_onboards.four_pls_id')
                ->where('four_pls.user_id', $request->id);
                if($request->date) {
                    $data =  $data->whereDate('start_date', $request->date);
                }

                $data =  $data->get();


        $data = [
            'data' => $data,
            'response' => 'success',
            'code' => 200,
        ];

        // \Log::channel('fourpl')->info($data);

        return $data;
    }
}
