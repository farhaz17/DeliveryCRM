<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareemLimoSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careem_limo_salaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payment_id');
            $table->string('driver_id')->nullable();
            $table->bigInteger('driver_phone')->nullable();
            $table->string('driver_name')->nullable();
            $table->bigInteger('limo_id')->nullable();
            $table->string('company_name')->nullable();
            $table->double('payment_method')->nullable();
            $table->double('total_driver_base_cost')->nullable();
            $table->double('total_driver_other_cost')->nullable();
            $table->double('total_driver_payment')->nullable();
            $table->double('total_driver_payment_pakistan')->nullable();
            $table->double('payable_amount')->nullable();
            $table->double('combined_payment_company_part')->nullable();
            $table->double('combined_payment_driver_part')->nullable();
            $table->double('country')->nullable();
            $table->double('city_name')->nullable();
            $table->double('currency')->nullable();
            $table->double('pay_date')->nullable();
            $table->double('adj_trip_compensation')->nullable();
            $table->double('adj_device_payment')->nullable();
            $table->double('adj_salik')->nullable();
            $table->double('adj_lost_device')->nullable();
            $table->double('adj_bonus')->nullable();
            $table->double('adj_sim_excess')->nullable();
            $table->double('adj_last_month_adjustment')->nullable();
            $table->double('adj_late_arrival')->nullable();
            $table->double('adj_back_out')->nullable();
            $table->double('adj_arrived_to_early')->nullable();
            $table->double('adj_cash_collection')->nullable();
            $table->double('adj_wrong_guest')->nullable();
            $table->double('adj_cash_per_trip_payment')->nullable();
            $table->double('adj_driver_tip')->nullable();
            $table->double('adj_wire_fees')->nullable();
            $table->double('adj_4h_guarantee')->nullable();
            $table->double('adj_6h_guarantee')->nullable();
            $table->double('adj_trip_referred_user')->nullable();
            $table->double('adj_referred_driver_adjustment')->nullable();
            $table->double('adj_referring_driver_adjustment')->nullable();
            $table->double('adj_trip_by_referred_driver')->nullable();
            $table->double('adj_data_plan_fees')->nullable();
            $table->double('adj_fines')->nullable();
            $table->double('adj_cash_paid_in_from_captain')->nullable();
            $table->double('adj_wrong_amount_entered')->nullable();
            $table->double('adj_health_insurance')->nullable();
            $table->double('adj_items_bought')->nullable();
            $table->double('adj_guarantee')->nullable();
            $table->double('jordan_car_rental')->nullable();
            $table->double('fawry')->nullable();
            $table->double('captain_bonus')->nullable();
            $table->double('referring_driver_trip_target_reward_amount')->nullable();
            $table->double('referred_driver_trip_target_reward_amount')->nullable();
            $table->double('cash_paid_in_by_captain_from_pos')->nullable();
            $table->double('lease_deduction')->nullable();
            $table->double('limo_commissions')->nullable();
            $table->double('trainer_payment')->nullable();
            $table->double('traffic_violation')->nullable();
            $table->double('captain_careem_card')->nullable();
            $table->double('one_time_card_payment')->nullable();
            $table->double('rickshaw_adjustment')->nullable();
            $table->double('card_operator_fees')->nullable();
            $table->double('one_card_commission_deduction')->nullable();
            $table->double('emergency_fund_deduction')->nullable();
            $table->double('vendor_bonus_tax')->nullable();
            $table->double('captain_bonus_tax')->nullable();
            $table->double('uncollected_cash_for_trip')->nullable();
            $table->double('past_trip_earning')->nullable();
            $table->double('easypaisa_cash_collection')->nullable();
            $table->double('captain_loyalty_program')->nullable();
            $table->double('marketing_expenses')->nullable();
            $table->double('packages_cash_collection')->nullable();
            $table->double('madfooatcom_payment')->nullable();
            $table->double('stc_cash_payment')->nullable();
            $table->double('background_check')->nullable();
            $table->double('fine_reimbursement')->nullable();
            $table->double('pooling_trip_earnings')->nullable();
            $table->double('switch_cash_payment')->nullable();
            $table->double('top_up_commission')->nullable();
            $table->double('quality_bonus')->nullable();
            $table->double('midweek_paid_amount')->nullable();
            $table->double('bonus_for_non_cash_trip')->nullable();
            $table->double('refundable_deposit')->nullable();
            $table->double('intercity_pooling_bonus')->nullable();
            $table->double('captain_loyalty_trip_peak_bonus')->nullable();
            $table->double('careempay_captain_debt_payment')->nullable();
            $table->double('transfer_to_careempay')->nullable();
            $table->double('now_cash_refusal')->nullable();
            $table->double('vat_settlement_adjustment')->nullable();
            $table->double('number_of_bank_details')->nullable();
            $table->double('bank_wire_possible')->nullable();
            $table->double('document_number')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->bigInteger('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('careem_limo_salaries');
    }
}
