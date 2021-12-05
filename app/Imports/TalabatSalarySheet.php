<?php

namespace App\Imports;

use App\Model\Performance\DeliverooPerformance;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TalabatSalarySheet implements  ToModel,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function  __construct($last_id,$talabat_sheet_id)
    {

        $this->last_id = $last_id;
        $this->talabat_sheet_id = $talabat_sheet_id;

    }

    public function model(array $row)
    {
        try {



//getting date ragnes

            $path_saved = $this->last_id;
            $talabat_sheet_id = $this->talabat_sheet_id;
            $rider_id = trim($row['rider_id']);
            if($rider_id !="") {
            $rider_id_array = trim($row['rider_id']);
            $rider_name_array = $row['rider_name'];
            $vendor_array = $row['vendor'];
            $city_array = trim($row['city']);
            $deliveries_array = $row['deliveries'];
            $hours_array = $row['hours'];
            $pay_hour_array = $row['pay_hour'];
            $pay_deliveries_array = $row['pay_deliveries'];
            $pay_per_hour_payment_array = $row['pay_per_hour_payment'];
            $pay_per_order_payment_array = $row['pay_per_order_payment'];
            $total_pay_array = $row['rider_total_pay'];
            $zomato_tip_array = $row['zomato_tip'];
            $talabat_tip_array = $row['talabat_tip'];
            $total_tip_array = $row['total_tip'];
            $incetive_array = $row['incetive'];
            $total_payment_array = $row['rider_total_payment'];

            return new \App\Model\SalarySheet\TalabatSalarySheet([

                'rider_id' => $rider_id_array,
                'rider_name' => $rider_name_array,
                'vendor' => $vendor_array,
                'city' => $city_array,
                'deliveries' =>     $deliveries_array,
                'hours' => $hours_array,
                'pay_hour' => $pay_hour_array,
                'pay_deliveries' => $pay_deliveries_array,
                'pay_per_hour_payment' => $pay_per_hour_payment_array,
                'pay_per_order_payment' => $pay_per_order_payment_array,
                'total_pay' => $total_pay_array,
                'zomato_tip' => $zomato_tip_array,
                'talabat_tip' => $talabat_tip_array,
                'total_tip' => $total_tip_array,
                'incetive' => $incetive_array,
                'total_payment' => $total_payment_array,
                'file_path' => $path_saved,
                'sheet_id' => $talabat_sheet_id,
            ]);
            }
            else{
                return  null;
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $message = [
                'error' => $e->getMessage()
            ];
            return redirect()->back()->with($message);
        }

    }
}
