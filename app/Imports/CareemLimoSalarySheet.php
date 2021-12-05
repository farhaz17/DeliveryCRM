<?php

namespace App\Imports;

use App\Model\Careem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CareemLimoSalarySheet implements ToModel,WithHeadingRow
{

    use Importable, SkipsErrors;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function __construct($last_id,$careem_limo_sheet_id)
    {
        $this->last_id = $last_id;
        $this->careem_limo_sheet_id = $careem_limo_sheet_id;

    }
    public function model(array $row)
    {


        $path_saved = $this->last_id;
        $careem_limo_sheet_id = $this->careem_limo_sheet_id;





        $driver_id_array = trim($row['driverid']);
        $driver_phone_array = $row['driverphone'];
        $driver_name_array = $row['drivername'];
        $limo_id_array = $row['limoid'];
        $company_name_array = $row['companyname'];
        $payment_method_array = $row['payment_method'];
        $total_driver_base_cost_array = $row['total_driver_base_cost'];
        $total_driver_other_cost_array = $row['total_driver_other_cost'];
        $total_driver_payment_array = $row['total_driver_payment'];
        $payable_amount_array = $row['payable_amount'];
        $combined_payment_company_part_array = $row['combinedpaymentcompanypart'];
        $combined_payment_driver_part_array = $row['combinedpaymentdriverpart'];
        $country_array = $row['country'];
        $city_name_array = $row['cityname'];
        $currency_array = $row['currency'];
        $pay_date_array = $row['pay_date'];
        $adj_tripCompensation_array = $row['adj_tripcompensation'];
        $adj_device_payment_array = $row['adj_devicepayment'];
        $adj_salik_array = $row['adj_salik'];
        $adj_lost_device = $row['adj_lostdevice'];
        $adj_bonus_array = $row['adj_bonus'];
        $adj_sim_excess_array = $row['adj_simexcess'];
        $adj_last_month_adjustment_array = $row['adj_lastmonthadjustment'];//new------------------------
        $adj_late_arrival_array = $row['adj_latearrival'];
        $adj_backout_array = $row['adj_backout'];//new---------------------
        $adj_arrived_to_early_array = $row['adj_arrivedtoearly'];
        $adj_cash_collection_array = $row['adj_cashcollection'];
        $adj_wrong_guest_array = $row['adj_wrongguest'];
        $adj_cash_pertrip_payment_array = $row['adj_cashpertrippayment'];
        $adj_wire_fees_array = $row['adj_wirefees'];
        $adj_drivertip_array = $row['adj_drivertip'];
        $adj_4_h_guarantee_array = $row['adj_4hguarantee'];
        $adj_6_h_Guarantee_array = $row['adj_6hguarantee'];
        $adj_trip_referred_user_array = $row['adj_tripreferreduser'];
        $adj_referred_driver_adjustment_array = $row['adj_referreddriveradjustment'];
        $adj_referring_driver_adjustment_array = $row['adj_referringdriveradjustment'];
        $padj_trip_by_referred_driver_array = $row['adj_tripbyreferreddriver'];
        $adj_data_plan_fees_array = $row['adj_dataplanfees'];
        $adj_fines_array = $row['adj_fines'];
        $adj_cash_paid_in_from_captain_array = $row['adj_cash_paid_in_from_captain'];
        $adj_wrong_amount_entered_array = $row['adj_wrong_amount_entered'];
        $adj_health_Insurance_array = $row['adj_health_insurance'];
        $adj_items_bought_array = $row['adj_itemsbought'];
        $adj_guarantee_array = $row['adj_guarantee'];
        $jordan_car_rental_array = $row['jordan_car_rental'];
        $fawry_details_array = $row['fawry'];
        $captain_bonus_array = $row['captain_bonus'];
        $referring_driver_trip_target_reward_amount_array = $row['referring_driver_trip_target_reward_amount'];
        $referred_driver_trip_target_reward_amount_array = $row['referred_driver_trip_target_reward_amount'];
        $cash_paid_in_by_captain_from_pos_array = $row['cash_paid_in_by_captain_from_pos'];
        $lease_deduction_array = $row['leasededuction'];
        $limo_commissions_array = $row['limocommissions'];
        $trainer_payment_array = $row['trainerpayment'];
        $traffic_violation_array = $row['trafficviolation'];
        $captain_careem_card_array = $row['captain_careem_card'];
        $one_time_card_payment_array = $row['one_time_card_payment'];
        $rickshaw_adjustment_array = $row['rickshaw_adjustment'];
        $card_operator_fees_array = $row['card_operator_fees'];
        $one_card_commission_deduction_array = $row['one_card_commission_deduction'];
        $emergency_fund_deduction_array = $row['emergency_fund_deduction'];
        $vendor_bonus_tax_array = $row['vendor_bonus_tax'];
        $captain_bonus_tax_array = $row['captain_bonus_tax'];
        $uncollected_cash_for_trip_array = $row['uncollected_cash_for_trip'];
        $past_trip_earning_array = $row['past_trip_earning'];
        $easypaisa_cash_collection_array = $row['easypaisa_cash_collection'];
        $captain_loyalty_program_array = $row['captain_loyalty_program'];
        $marketing_expenses_array = $row['marketing_expenses'];
        $packages_cash_collection_array = $row['packages_cash_collection'];
        $madfooatcom_payment_array = $row['madfooatcom_payment'];
        $stc_cash_payment_array = $row['stc_cash_payment'];
        $background_check_array = $row['background_check'];
        $fine_reimbursement_array = $row['fine_reimbursement'];
        $pooling_trip_earnings_array = $row['pooling_trip_earnings'];
        $switch_cash_payment_array = $row['switch_cash_payment'];
        $top_up_commission_array = $row['top_up_commission'];
        $quality_bonus_array = $row['quality_bonus'];
        $midweek_paid_amount_array = $row['midweek_paid_amount'];
        $bonus_for_non_cash_trip_array = $row['bonus_for_non_cash_trip'];
        $refundable_deposit_array = $row['refundable_deposit'];
        $intercity_pooling_bonus_array = $row['intercity_pooling_bonus'];
        $captain_loyalty_trip_peak_bonus_array = $row['captain_loyalty_trip_peak_bonus'];
        $careempay_captain_debt_payment_array = $row['careempay_captain_debt_payment'];
        $transfer_to_careempay_array = $row['transfer_to_careempay'];
        $now_cash_refusal_array = $row['now_cash_refusal'];
        $vat_settlement_adjustment_array = $row['vat_settlement_adjustment'];
        $number_of_bank_details_array = $row['numberofbankdetails'];
        $bank_wire_possible_array = $row['bankwirepossible'];
        $document_number_array = $row['document_number'];
        return new \App\Model\SalarySheet\CareemLimoSalarySheet([
            'driver_id' => $driver_id_array,
            'driver_phone' => $driver_phone_array,
            'driver_name' => $driver_name_array,
            'limo_id' => $limo_id_array,
            'company_name' => $company_name_array,
            'payment_method' => $payment_method_array,
            'total_driver_base_cost' => $total_driver_base_cost_array,
            'total_driver_other_cost' => $total_driver_other_cost_array,
            'total_driver_payment' => $total_driver_payment_array,
            'payable_amount' => $payable_amount_array,
            'combined_payment_company_part' => $combined_payment_company_part_array,
            'combined_payment_driver_part' => $combined_payment_driver_part_array,
            'country' => $country_array,
            'city_name' => $city_name_array,
            'currency' => $currency_array,
            'pay_date' => $pay_date_array,
            'adj_trip_compensation' => $adj_tripCompensation_array,
            'adj_device_payment' => $adj_device_payment_array,
            'adj_salik' => $adj_salik_array,
            'adj_lost_device' => $adj_lost_device,
            'adj_bonus' => $adj_bonus_array,
            'adj_sim_excess' => $adj_sim_excess_array,
            'adj_last_month_adjustment' => $adj_last_month_adjustment_array,//new-----------------------------
            'adj_late_arrival' => $adj_late_arrival_array,
            'adj_backout' => $adj_backout_array,//new-------------------
            'adj_back_out' => $adj_backout_array,
            'adj_arrived_to_early' => $adj_arrived_to_early_array,
            'adj_cash_collection' => $adj_cash_collection_array,
            'adj_wrong_guest' => $adj_wrong_guest_array,
            'adj_cash_per_trip_payment' => $adj_cash_pertrip_payment_array,
            'adj_wire_fees' => $adj_wire_fees_array,
            'adj_driver_tip' => $adj_drivertip_array,//------------new
            'adj_4h_guarantee' => $adj_4_h_guarantee_array,
            'adj_6h_guarantee' => $adj_6_h_Guarantee_array,
            'adj_trip_referred_user' => $adj_trip_referred_user_array,
            'adj_referred_driver_adjustment' => $adj_referred_driver_adjustment_array,
            'adj_referring_driver_adjustment' => $adj_referring_driver_adjustment_array,
            'adj_trip_by_referred_driver' => $padj_trip_by_referred_driver_array,
            'adj_data_plan_fees' => $adj_data_plan_fees_array,
            'adj_fines' => $adj_fines_array,
            'adj_cash_paid_in_from_captain' => $adj_cash_paid_in_from_captain_array,
            'adj_wrong_amount_entered' => $adj_wrong_amount_entered_array,
            'adj_health_insurance' => $adj_health_Insurance_array,
            'adj_items_bought' => $adj_items_bought_array,
            'adj_guarantee' => $adj_guarantee_array,
            'jordan_car_rental' => $jordan_car_rental_array,
            'fawry' => $fawry_details_array,
            'captain_bonus' => $captain_bonus_array,
            'referring_driver_trip_target_reward_amount' => $referring_driver_trip_target_reward_amount_array,
            'referred_driver_trip_target_reward_amount' => $referred_driver_trip_target_reward_amount_array,
            'cash_paid_in_by_captain_from_pos' => $cash_paid_in_by_captain_from_pos_array,
            'lease_deduction' => $lease_deduction_array,
            'limo_commissions' => $limo_commissions_array,
            'trainer_payment' => $trainer_payment_array,
            'traffic_violation' => $traffic_violation_array,
            'captain_careem_card' => $captain_careem_card_array,
            'one_time_card_payment' => $one_time_card_payment_array,
            'rickshaw_adjustment' => $rickshaw_adjustment_array,
            'card_operator_fees' => $card_operator_fees_array,
            'one_card_commission_deduction' => $one_card_commission_deduction_array,
            'emergency_fund_deduction' => $emergency_fund_deduction_array,
            'vendor_bonus_tax' => $vendor_bonus_tax_array,
            'captain_bonus_tax' => $captain_bonus_tax_array,
            'uncollected_cash_for_trip' => $uncollected_cash_for_trip_array,
            'past_trip_earning' => $past_trip_earning_array,
            'easypaisa_cash_collection' => $easypaisa_cash_collection_array,
            'captain_loyalty_program' => $captain_loyalty_program_array,
            'marketing_expenses' => $marketing_expenses_array,
            'packages_cash_collection' => $packages_cash_collection_array,
            'madfooatcom_payment' => $madfooatcom_payment_array,
            'stc_cash_payment' => $stc_cash_payment_array,
            'background_check' => $background_check_array,
            'fine_reimbursement' => $fine_reimbursement_array,
            'pooling_trip_earnings' => $pooling_trip_earnings_array,
            'switch_cash_payment' => $switch_cash_payment_array,
            'top_up_commission' => $top_up_commission_array,
            'quality_bonus' => $quality_bonus_array,
            'midweek_paid_amount' => $midweek_paid_amount_array,
            'bonus_for_non_cash_trip' => $bonus_for_non_cash_trip_array,
            'refundable_deposit' => $refundable_deposit_array,
            'intercity_pooling_bonus' => $intercity_pooling_bonus_array,
            'captain_loyalty_trip_peak_bonus' => $captain_loyalty_trip_peak_bonus_array,
            'careempay_captain_debt_payment' => $careempay_captain_debt_payment_array,
            'transfer_to_careempay' => $transfer_to_careempay_array,
            'now_cash_refusal' => $now_cash_refusal_array,
            'vat_settlement_adjustment' => $vat_settlement_adjustment_array,
            'number_of_bank_details' => $number_of_bank_details_array,
            'bank_wire_possible' => $bank_wire_possible_array,
            'document_number' => $document_number_array,
            'file_path' => $path_saved,
            'sheet_id' => $careem_limo_sheet_id,
        ]);
    }
}
