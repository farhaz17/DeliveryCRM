<?php

namespace App\Imports;

use App\Model\Cities;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Model\Riders\RiderTimeSheet\TalabatRiderTimeSheet;


class TalabatRiderTimeSheetImport implements  ToModel, WithStartRow
{
    use Importable, SkipsErrors;
    private  $start_date;
    private  $end_date;
    private  $uploaded_file_path;
    public function __construct($start_date, $end_date, $uploaded_file_path){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->uploaded_file_path = $uploaded_file_path;
    }

    public function model(array $row)
    {
        $platform = PlatformCode::with('passport.personal_info')->whereIn('platform_id', [15,34,41])->wherePlatformCode($row[0])->first();
        if($platform ){
            return new TalabatRiderTimeSheet([
                'platform_code' => $platform->platform_code, // Logistics Riders Rider ID
                'passport_id' => $platform->passport_id, // Rider Name
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'uploaded_file_path' => $this->uploaded_file_path,

                'contact' =>  $row[2], // Contract Name
                'city_id' =>  Cities::firstOrCreate([
                    'name' => $row[3]
                ])->id, // City
                'orders' =>  $row[4], // Orders
                'deliveries' =>  $row[5], // Deliveries
                'rider_ppd' =>  $row[6], // Rider PPD
                'three_p_l_ppd' =>  $row[7], // 3PL PPD
                'distance' =>  $row[8], // Distance
                'rider_delivery_pay' =>  $row[9], // Rider Delivery Pay
                'rider_distance_pay' =>  $row[10], // Rider Distance Pay
                'fp_delivery_pay' =>  $row[11], // FP Delivery Pay
                'total_delivery_pay' =>  $row[12], // Total Delivery Pay
                'monthly_incentive' =>  $row[13], // Monthly Incentive
                'booster' =>  $row[14], // Booster
                'new_hire_benefit' =>  $row[15], // New Hire Benefit
            ]);
        }else{
            return;
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
