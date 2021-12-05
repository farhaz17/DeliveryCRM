<?php

namespace App\Imports;

use DB;
use App\User;
use App\Model\Guest\Career;
use App\Model\Passport\Passport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Model\VendorRegistration\VendorRiderOnboard;

class RiderImport implements ToCollection, WithHeadingRow
{

    public function headingRow(): int
    {
        return 1;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
            foreach ($rows as $row) {
                \Log::info("\n \n \n \n NEW ENTRY");
                \Log::info($row['passport']);

                $vendor_onboard = VendorRiderOnboard::where('passport_no', 'LIKE', '%' . $row['passport'] . '%')->where('status', 1)->first();

                $duplicate = DB::table('vendor_rider_onboards')
                ->select('*')
                ->groupBy('passport_no')
                ->where('status', 1)
                ->where('passport_no', 'LIKE', '%'. $row['passport'] .'%')
                ->having(DB::raw('COUNT(*)'), '>', 1)
                ->first();

                if($vendor_onboard) {

                    if($duplicate) {
                        \Log::info("Duplicate" . print_r($duplicate, true));
                        continue;
                    }

                    if($vendor_onboard->four_pls_id) {
                        \Log::info("fourpl already added $vendor_onboard->four_pls_id");
                        continue;
                    }

                    $rider_updated = VendorRiderOnboard::where('id', $vendor_onboard->id)
                    ->update(['four_pls_id' => $row['fourpl']]);

                    \Log::info("updated rider fourpl" . print_r($rider_updated, true));

                    $rider_career = Career::where('vendor_fourpl_pk_id', $vendor_onboard->id)->first();
                    if(!$rider_career) {
                        $career_id = Career::create([
                                        'name'  => $row['courier_name'],
                                        'vehicle_type'  => 1,
                                        'license_status' => 1,
                                        'passport_no' => $row['passport'],
                                        'applicant_status' => 5,
                                        'refer_type' => 5,
                                        'have_passport' => 0,
                                        'employee_type' => 2,
                                        'four_pl_name_id' => 0,
                                        'vendor_fourpl_pk_id' => $vendor_onboard->id,
                                        'new_taken_licence' => 0,
                                        'follow_up_status' => 0,
                                        'career_bypass' => 1,
                                    ]);

                        \Log::info("created career" . print_r($career_id, true));

                        $rider_passport = Passport::where('passport_no', $row['passport'])->first();
                        if($rider_passport) {
                            $passports = Passport::where('passport_no', $row['passport'])->update(['career_id' => $career_id->id]);
                            \Log::info("updated passports" . print_r($passports, true));
                        }
                    }
                    else{
                        $rider_passport = Passport::where('passport_no', $row['passport'])->first();
                        if($rider_passport) {
                            $passports = Passport::where('passport_no', $row['passport'])->update(['career_id' => $rider_career->id]);
                            \Log::info("updated passports" . print_r($passports, true));
                        }
                    }
                }
                else{
                    $new_rider_onboard = VendorRiderOnboard::create([
                        'four_pls_id'  => $row['fourpl'],
                        'rider_first_name'  => $row['courier_name'],
                        'passport_no' => $row['passport'],
                        'status' => 1,
                    ]);

                    \Log::info("Added $new_rider_onboard");

                    $career_id = Career::create([
                        'name'  => $row['courier_name'],
                        'vehicle_type'  => 1,
                        'license_status' => 1,
                        'passport_no' => $row['passport'],
                        'applicant_status' => 5,
                        'refer_type' => 5,
                        'have_passport' => 0,
                        'employee_type' => 2,
                        'four_pl_name_id' => 0,
                        'vendor_fourpl_pk_id' => $new_rider_onboard->id,
                        'new_taken_licence' => 0,
                        'follow_up_status' => 0,
                        'career_bypass' => 1,
                    ]);

                    \Log::info("created career" . print_r($career_id, true));

                    $rider_passport = Passport::where('passport_no', $row['passport'])->first();
                        if($rider_passport) {
                            $passports = Passport::where('passport_no', $row['passport'])->update(['career_id' => $career_id->id]);
                            \Log::info("updated passports" . print_r($passports, true));
                        }
                }


            }
    }
}
