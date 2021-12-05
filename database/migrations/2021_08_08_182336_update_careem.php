<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCareem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careem', function (Blueprint $table) {
            $table->dropColumn('driver_phone');
            $table->dropColumn('driver_name');
            $table->dropColumn('limo_id');
            $table->dropColumn('company_name');
            $table->dropColumn('payment_method');
            $table->dropColumn('total_driver_payment_pakistan');
            $table->dropColumn('payable_amount');
            $table->dropColumn('combined_payment_company_part');
            $table->dropColumn('combined_payment_driver_part');
            $table->dropColumn('country');
            $table->dropColumn('city_name');
            $table->dropColumn('currency');
            $table->dropColumn('pay_date');
            $table->dropColumn('adj_trip_compensation');
            $table->dropColumn('adj_device_payment');
            $table->dropColumn('adj_salik');
            $table->dropColumn('adj_lost_device');
            $table->dropColumn('adj_bonus');
            $table->dropColumn('adj_sim_excess');
            $table->dropColumn('adj_last_month_adjustment');
            $table->dropColumn('adj_late_arrival');
            $table->dropColumn('adj_back_out');
            $table->dropColumn('adj_arrived_to_early');
            $table->dropColumn('adj_cash_collection');
            $table->dropColumn('adj_wrong_guest');
            $table->dropColumn('adj_cash_per_trip_payment');
            $table->dropColumn('adj_wire_fees');
            $table->dropColumn('adj_driver_tip');
            $table->dropColumn('adj_4h_guarantee');
            $table->dropColumn('adj_6h_guarantee');
            $table->dropColumn('adj_trip_referred_user');
            $table->dropColumn('adj_referred_driver_adjustment');
            $table->dropColumn('adj_referring_driver_adjustment');
            $table->dropColumn('adj_trip_by_referred_driver');
            $table->dropColumn('adj_data_plan_fees');
            $table->dropColumn('adj_fines');
            $table->dropColumn('adj_cash_paid_in_from_captain');
            $table->dropColumn('adj_wrong_amount_entered');
            $table->dropColumn('adj_health_insurance');
            $table->dropColumn('adj_items_bought');
            $table->dropColumn('adj_guarantee');
            $table->dropColumn('jordan_car_rental');
            $table->dropColumn('fawry');
            $table->dropColumn('captain_bonus');
            $table->dropColumn('referring_driver_trip_target_reward_amount');
            $table->dropColumn('referred_driver_trip_target_reward_amount');
            $table->dropColumn('cash_paid_in_by_captain_from_pos');
            $table->dropColumn('lease_deduction');
            $table->dropColumn('limo_commissions');
            $table->dropColumn('trainer_payment');
            $table->dropColumn('traffic_violation');
            $table->dropColumn('captain_careem_card');
            $table->dropColumn('one_time_card_payment');
            $table->dropColumn('rickshaw_adjustment');
            $table->dropColumn('card_operator_fees');
            $table->dropColumn('one_card_commission_deduction');
            $table->dropColumn('emergency_fund_deduction');
            $table->dropColumn('vendor_bonus_tax');
            $table->dropColumn('captain_bonus_tax');
            $table->dropColumn('uncollected_cash_for_trip');
            $table->dropColumn('past_trip_earning');
            $table->dropColumn('easypaisa_cash_collection');
            $table->dropColumn('captain_loyalty_program');
            $table->dropColumn('marketing_expenses');
            $table->dropColumn('packages_cash_collection');
            $table->dropColumn('madfooatcom_payment');
            $table->dropColumn('stc_cash_payment');
            $table->dropColumn('background_check');
            $table->dropColumn('fine_reimbursement');
            $table->dropColumn('pooling_trip_earnings');
            $table->dropColumn('switch_cash_payment');
            $table->dropColumn('top_up_commission');
            $table->dropColumn('quality_bonus');
            $table->dropColumn('midweek_paid_amount');
            $table->dropColumn('bonus_for_non_cash_trip');
            $table->dropColumn('refundable_deposit');
            $table->dropColumn('intercity_pooling_bonus');
            $table->dropColumn('captain_loyalty_trip_peak_bonus');
            $table->dropColumn('careempay_captain_debt_payment');
            $table->dropColumn('transfer_to_careempay');
            $table->dropColumn('now_cash_refusal');
            $table->dropColumn('vat_settlement_adjustment');
            $table->dropColumn('number_of_bank_details');
            $table->dropColumn('bank_wire_possible');
            $table->dropColumn('file_path');
            $table->dropColumn('deleted_at');
            $table->dropColumn('sheet_id');
        });
        Schema::table('careem', function (Blueprint $table) {
            $table->date('start_date');
            $table->date('end_date');
            $table->string('passport_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
