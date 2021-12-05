<?php

namespace App\Imports;
use App\Model\Careem;
use App\Model\Employee_list;
use App\Model\UberEats;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;


class CareemImport  implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function __construct($last_id,$careem_sheet_id)
    {

        $this->last_id = $last_id;
        $this->careem_sheet_id = $careem_sheet_id;

    }

    public function model(array $row)
    {

//        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['driver_id'])));


//        dd($data_partnumber);
//         $part_number_array=array();
//        $part_quantity_array=array();
//        $part_quantity_balance_array=array();
//        $part_amount_array=array();
//
//        if($data_partnumber == ""){

        $path_saved = $this->last_id;
        $careem_sheet_id = $this->careem_sheet_id;




        $payment_id_array = trim($row['paymentid']);
        $driver_id_array = trim($row['driverid']);
        $driver_phone_array = $row['driverphone'];
        $driver_name_array = $row['drivername'];
        $limo_id_array = $row['limoid'];
        $company_name_array = $row['companyname'];
        $payment_method_array = $row['payment_method'];
        $total_driver_base_cost_array = $row['total_driver_base_cost'];
        $total_driver_other_cost_array = $row['total_driver_other_cost'];
        $total_driver_payment_array = $row['total_driver_payment'];
        $total_driver_payment_pakistan_array = $row['total_driver_payment_pakistan'];
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
        return new Careem([

            'payment_id' => $payment_id_array,
            'driver_id' => $driver_id_array,
            'driver_phone' => $driver_phone_array,
            'driver_name' => $driver_name_array,
            'limo_id' => $limo_id_array,
            'company_name' => $company_name_array,
            'payment_method' => $payment_method_array,
            'total_driver_base_cost' => $total_driver_base_cost_array,
            'total_driver_other_cost' => $total_driver_other_cost_array,
            'total_driver_payment' => $total_driver_payment_array,
            'total_driver_payment_pakistan' => $total_driver_payment_pakistan_array,
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
            'sheet_id' => $careem_sheet_id,

        ]);
    }
}
//        else{
//
////            $quantitySet=$this->getQuantityBalance($data_partnumber);
////            $current_quantity=0;
////            $current_quantity_balance=0;
//
//
//
//
//            $driver_id=trim($row['driver_id']);
//            $driver_phone=$row['driver_phone'];
//            $driver_name=$row['driver_name'];
//            $limo_id=$row['limo_id'];
//            $company_name=$row['company_name'];
//            $payment_method=$row['payment_method'];
//            $total_driver_base_cost=$row['total_driver_base_cost'];
//            $total_driver_other_cost=$row['total_driver_other_cost'];
//            $total_driver_payment=$row['total_driver_payment'];
//            $payable_amount=$row['payable_amount'];
//            $combined_payment_company_part=$row['combined_payment_company_part'];
//            $country=$row['country'];
//            $city_name=$row['city_name'];
//            $currency=$row['currency'];
//            $pay_date=$row['pay_date'];
//            $adj_tripCompensation=$row['adj_trip_compensation'];
//            $adj_device_payment=$row['adj_device_payment'];
//            $adj_salik=$row['adj_salik'];
//            $adj_lost=$row['adj_lost_device'];
//            $adj_bonus=$row['adj_bonus'];
//            $adj_sim_excess=$row['adj_sim_excess'];
//            $adj_late_arrival=$row['adj_late_arrival'];
//            $adj_back_out=$row['adj_back_out'];
//            $adj_arrived_to_early=$row['adj_arrived_to_early'];
//            $adj_cash_collection=$row['adj_cash_collection'];
//            $adj_wrong_guest=$row['adj_wrong_guest'];
//            $adj_cash_pertrip_payment=$row['adj_cash_per_trip_payment'];
//            $adj_wire_fees=$row['adj_wire_fees'];
//            $adj_4_h_guarantee=$row['adj_4h_guarantee'];
//            $adj_6_h_Guarantee=$row['adj_6h_guarantee'];
//            $adj_trip_referred_user=$row['adj_trip_referred_user'];
//            $adj_referred_driver_adjustment=$row['adj_referred_driver_adjustment'];
//            $adj_referring_driver_adjustment=$row['adj_referring_driver_adjustment'];
//            $adj_trip_by_referred_driver=$row['adj_trip_by_referred_driver'];
//            $adj_data_plan_fees=$row['adj_data_plan_fees'];
//            $adj_fines=$row['adj_fines'];
//            $adj_cash_paid_in_from_captain=$row['adj_cash_paid_in_from_captain'];
//            $adj_wrong_amount_entered=$row['adj_wrong_amount_entered'];
//            $adj_health_Insurance=$row['adj_health_insurance'];
//            $adj_items_bought=$row['adj_items_bought'];
//            $adj_guarantee=$row['adj_guarantee'];
//            $jordan_car_rental=$row['jordan_car_rental'];
//            $fawry_details=$row['fawry'];
//            $captain_bonus=$row['captain_bonus'];
//            $referring_driver_trip_target_reward_amount=$row['referring_driver_trip_target_reward_amount'];
//            $referred_driver_trip_target_reward_amount=$row['referred_driver_trip_target_reward_amount'];
//            $cash_paid_in_by_captain_from_pos=$row['cash_paid_in_by_captain_from_pos'];
//            $lease_deduction=$row['lease_deduction'];
//            $limo_commissions=$row['limo_commissions'];
//            $trainer_payment=$row['trainer_payment'];
//            $traffic_violation=$row['traffic_violation'];
//            $captain_careem_card=$row['captain_careem_card'];
//            $one_time_card_payment=$row['one_time_card_payment'];
//            $rickshaw_adjustment=$row['rickshaw_adjustment'];
//            $card_operator_fees=$row['card_operator_fees'];
//            $one_card_commission_deduction=$row['one_card_commission_deduction'];
//            $emergency_fund_deduction=$row['emergency_fund_deduction'];
//            $vendor_bonus_tax=$row['vendor_bonus_tax'];
//            $captain_bonus_tax=$row['captain_bonus_tax'];
//            $uncollected_cash_for_trip=$row['uncollected_cash_for_trip'];
//            $past_trip_earning=$row['past_trip_earning'];
//            $easypaisa_cash_collection=$row['easypaisa_cash_collection'];
//            $captain_loyalty_program=$row['captain_loyalty_program'];
//            $marketing_expenses=$row['marketing_expenses'];
//            $packages_cash_collection=$row['packages_cash_collection'];
//            $madfooatcom_payment=$row['madfooatcom_payment'];
//            $stc_cash_payment=$row['stc_cash_payment'];
//            $background_check=$row['background_check'];
//            $fine_reimbursement=$row['fine_reimbursement'];
//            $pooling_trip_earnings=$row['pooling_trip_earnings'];
//            $switch_cash_payment=$row['switch_cash_payment'];
//            $top_up_commission=$row['top_up_commission'];
//            $quality_bonus=$row['quality_bonus'];
//            $midweek_paid_amount=$row['midweek_paid_amount'];
//            $bonus_for_non_cash_trip=$row['bonus_for_non_cash_trip'];
//            $refundable_deposit=$row['refundable_deposit'];
//            $intercity_pooling_bonus=$row['intercity_pooling_bonus'];
//            $captain_loyalty_trip_peak_bonus=$row['captain_loyalty_trip_peak_bonus'];
//            $number_of_bank_details=$row['number_of_bank_details'];
//            $bank_wire_possible=$row['bank_wire_possible'];
//            $document_number=$row['document_number'];
//
//            $obj = Careem::find($data_partnumber);
//
//            $obj->driver_id=$driver_id;
//            $obj->driver_phone=$driver_phone;
//            $obj->driver_name=$driver_name;
//            $obj->limo_id=$limo_id;
//            $obj->company_name=$company_name;
//            $obj->payment_method=$payment_method;
//            $obj->total_driver_base_cost=$total_driver_base_cost;
//            $obj->total_driver_other_cost=$total_driver_other_cost;
//            $obj->total_driver_payment=$total_driver_payment;
//            $obj->payable_amount=$payable_amount;
//            $obj->combined_payment_company_part=$combined_payment_company_part;
//            $obj->country=$country;
//            $obj->city_name=$city_name;
//            $obj->currency=$currency;
//            $obj->pay_date=$pay_date;
//            $obj->adj_trip_compensation=$adj_tripCompensation;
//            $obj->adj_device_payment=$adj_device_payment;
//            $obj->adj_salik=$adj_salik;
//            $obj->adj_lost_device=$adj_lost;
//            $obj->adj_bonus=$adj_bonus;
//            $obj->adj_sim_excess=$adj_sim_excess;
//            $obj->adj_late_arrival=$adj_late_arrival;
//            $obj->adj_back_out=$adj_back_out;
//            $obj->adj_arrived_to_early=$adj_arrived_to_early;
//            $obj->adj_cash_collection=$adj_cash_collection;
//            $obj->adj_wrong_guest=$adj_wrong_guest;
//            $obj->adj_cash_per_trip_payment=$adj_cash_pertrip_payment;
//            $obj->adj_wire_fees=$adj_wire_fees;
//            $obj->adj_4h_guarantee=$adj_4_h_guarantee;
//            $obj->adj_6h_guarantee=$adj_6_h_Guarantee;
//            $obj->adj_trip_referred_user=$adj_trip_referred_user;
//            $obj->adj_referred_driver_adjustment=$adj_referred_driver_adjustment;
//            $obj->adj_referring_driver_adjustment=$adj_referring_driver_adjustment;
//            $obj->adj_trip_by_referred_driver=$adj_trip_by_referred_driver;
//            $obj->adj_data_plan_fees=$adj_data_plan_fees;
//            $obj->adj_fines=$adj_fines;
//            $obj->adj_cash_paid_in_from_captain=$adj_cash_paid_in_from_captain;
//            $obj->adj_wrong_amount_entered=$adj_wrong_amount_entered;
//            $obj->adj_health_insurance=$adj_health_Insurance;
//            $obj->adj_guarantee=$adj_guarantee;
//            $obj->adj_items_bought=$adj_items_bought;
//            $obj->jordan_car_rental=$jordan_car_rental;
//            $obj->fawry=$fawry_details;
//            $obj->captain_bonus=$captain_bonus;
//            $obj->referring_driver_trip_target_reward_amount=$referring_driver_trip_target_reward_amount;
//            $obj->referred_driver_trip_target_reward_amount=$referred_driver_trip_target_reward_amount;
//            $obj->cash_paid_in_by_captain_from_pos=$cash_paid_in_by_captain_from_pos;
//            $obj->lease_deduction=$lease_deduction;
//            $obj->limo_commissions=$limo_commissions;
//            $obj->trainer_payment=$trainer_payment;
//            $obj->traffic_violation=$traffic_violation;
//            $obj->captain_careem_card=$captain_careem_card;
//            $obj->one_time_card_payment=$one_time_card_payment;
//            $obj->rickshaw_adjustment=$rickshaw_adjustment;
//            $obj->card_operator_fees=$card_operator_fees;
//            $obj->one_card_commission_deduction=$one_card_commission_deduction;
//            $obj->emergency_fund_deduction=$emergency_fund_deduction;
//            $obj->vendor_bonus_tax=$vendor_bonus_tax;
//            $obj->captain_bonus_tax=$captain_bonus_tax;
//            $obj->uncollected_cash_for_trip=$uncollected_cash_for_trip;
//            $obj->past_trip_earning=$past_trip_earning;
//            $obj->easypaisa_cash_collection=$easypaisa_cash_collection;
//            $obj->marketing_expenses=$marketing_expenses;
//            $obj->packages_cash_collection=$packages_cash_collection;
//            $obj->captain_loyalty_program=$captain_loyalty_program;
//            $obj->madfooatcom_payment=$madfooatcom_payment;
//            $obj->stc_cash_payment=$stc_cash_payment;
//            $obj->background_check=$background_check;
//            $obj->fine_reimbursement=$fine_reimbursement;
//            $obj->pooling_trip_earnings=$pooling_trip_earnings;
//            $obj->background_check=$background_check;
//            $obj->switch_cash_payment=$switch_cash_payment;
//            $obj->top_up_commission=$top_up_commission;
//            $obj->quality_bonus=$quality_bonus;
//            $obj->midweek_paid_amount=$midweek_paid_amount;
//            $obj->bonus_for_non_cash_trip=$bonus_for_non_cash_trip;
//            $obj->refundable_deposit=$refundable_deposit;
//            $obj->intercity_pooling_bonus=$intercity_pooling_bonus;
//            $obj->number_of_bank_details=$number_of_bank_details;
//            $obj->captain_loyalty_trip_peak_bonus=$captain_loyalty_trip_peak_bonus;
//            $obj->bank_wire_possible=$bank_wire_possible;
//            $obj->document_number=$document_number;
//
//
//
//
////dd($obj);
//
//            $obj->save();

//            $message = [
//                'message' => 'Updated Successfully',
//                'alert-type' => 'success'
//
//            ];
//            return redirect()->route('form_upload')->with($message);
//        }

//
//    }
//
//    public function getPartNumberId($driver_id){
//
//        $trans_id = DB::table('careem')->where('driver_id', $driver_id)->first();
//
//        return optional($trans_id)->id;
//    }
//
//    public function checkExistData($driver_id){
//
//        $query=Careem::where('id', $driver_id)->get()->first();
//
//        $trans_id= isset($query->id)?$query->id:"";
//        return $trans_id;
//    }
//
//
//    public function onError(Throwable $e)
//    {
//        // TODO: Implement onError() method.
//    }

//}
