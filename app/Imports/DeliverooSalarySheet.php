<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class DeliverooSalarySheet implements ToModel,WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function __construct($last_id,$del_sheet_id)
    {

        $this->last_id = $last_id;
        $this->del_sheet_id = $del_sheet_id;

    }

    public function model(array $row)
    {
        try {
//getting date ragnes

            $path_saved = $this->last_id;
            $del_sheet_id = $this->del_sheet_id;
            $rider_id = trim($row['rider_id']);


            if($rider_id !="") {
                $rider_id_array = trim($row['rider_id']);
                $rider_name_array = trim($row['rider_name']);
                $agency_array = $row['agency'];
                $city_array = trim($row['city']);
                $pay_group_array = $row['pay_group'];
                $email_address_array = $row['email_address'];
                $total_orders_delivered_array = $row['total_orders_delivered'];
                $stacked_orders_delivered_array = $row['stacked_orders_delivered'];
                $hours_worked_within_schedule_array = $row['hours_worked_within_schedule'];
                $rider_drop_fees_array = $row['rider_drop_fees'];
                $rider_guarantee_array = $row['rider_guarantee'];
                $tips_array = $row['tips'];
                $non_order_related_work_1_array = $row['non_order_related_work_1'];
                $past_queries_adjustment_1_array = $row['past_queries_adjustment_1'];
                $bonus_array = $row['bonus'];
                $surge_array = $row['surge'];
                $fuel_array = $row['fuel'];
                $rider_training_fees_array = $row['rider_training_fees'];
                $total_rider_earnings_array = $row['total_rider_earnings_not_incl_tips'];
                $agency_drop_fees_array = $row['agency_drop_fees'];
                $agency_guarantees_array = $row['agency_guarantees'];
                $rider_insurance_array = $row['rider_insurance'];
                $non_order_related_work_2_array = $row['non_order_related_work_2'];
                $past_queries_adjustment_2_array = $row['past_queries_adjustment_2'];
                $agency_training_fees_array = $row['agency_training_fees'];
                $early_departure_fee_array = $row['early_departure_fee'];
                $rider_kit_array = $row['rider_kit'];
                $phone_installments_array = $row['phone_installments'];
                $excessive_sim_plan_usage_array = $row['excessive_sim_plan_usage'];
                $salik_charges_array = $row['salik_charges_deliveroo_provided_bikes'];
                $bike_insurance_array = $row['bike_insurance_deliveroo_provided_bikes'];
                $traffic_fines_array = $row['traffic_fines_deliveroo_provided_bikes'];
                $bike_repair_charges_array = $row['bike_repair_charges_deliveroo_provided_bikes'];
                $total_agency_earnings_array = $row['total_agency_earnings'];
                $rider_earnings_array = $row['rider_earnings'];
                $rider_tips_array = $row['rider_tips'];
                $agency_earnings_array = $row['agency_earnings'];
                $total_array = $row['total'];

                return new \App\Model\SalarySheet\DeliverooSlaraySheet([
                    'rider_id' => $rider_id_array,
                    'rider_name' => $rider_name_array,
                    'agency' => $agency_array,
                    'city' => $city_array,
                    'pay_group' => $pay_group_array,
                    'email_address' => $email_address_array,
                    'total_orders_delivered' => $total_orders_delivered_array,
                    'stacked_orders_delivered' => $stacked_orders_delivered_array,
                    'hours_worked_within_schedule' => $hours_worked_within_schedule_array,
                    'rider_drop_fees' => $rider_drop_fees_array,
                    'rider_guarantee' => $rider_guarantee_array,
                    'tips' => $tips_array,
                    'non_order_related_work_1' => $non_order_related_work_1_array,
                    'past_queries_adjustment_1' => $past_queries_adjustment_1_array,
                    'bonus' => $bonus_array,
                    'surge' => $surge_array,
                    'fuel' => $fuel_array,
                    'rider_training_fees' => $rider_training_fees_array,
                    'total_rider_earnings' => $total_rider_earnings_array,
                    'agency_drop_fees' => $agency_drop_fees_array,
                    'agency_guarantees' => $agency_guarantees_array,
                    'rider_insurance' => $rider_insurance_array,
                    'non_order_related_work_2' => $non_order_related_work_2_array,
                    'past_queries_adjustment_2' => $past_queries_adjustment_2_array,
                    'agency_training_fees' => $agency_training_fees_array,
                    'early_departure_fee' => $early_departure_fee_array,
                    'rider_kit' => $rider_kit_array,
                    'phone_installments' => $phone_installments_array,
                    'excessive_sim_plan_usage' => $excessive_sim_plan_usage_array,
                    'salik_charges' => $salik_charges_array,
                    'bike_insurance' => $bike_insurance_array,
                    'traffic_fines' => $traffic_fines_array,
                    'bike_repair_charges' => $bike_repair_charges_array,
                    'total_agency_earnings' => $total_agency_earnings_array,
                    'rider_earnings' => $rider_earnings_array,
                    'rider_tips' => $rider_tips_array,
                    'agency_earnings' => $agency_earnings_array,
                    'total' => $total_array,
                    'file_path' => $path_saved,
                    'sheet_id' => $del_sheet_id,
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
    public function headingRow()
    {
        return 3;
    }
}
