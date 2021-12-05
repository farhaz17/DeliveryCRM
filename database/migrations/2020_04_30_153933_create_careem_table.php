<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careem', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payment_id')->nullable();
            $table->string('driver_id')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('limo_id')->nullable();
            $table->string('company_name')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('total_driver_base_cost')->nullable();
            $table->string('total_driver_other_cost')->nullable();
            $table->double('total_driver_payment')->nullable();
            $table->double('total_driver_payment_pakistan')->nullable();
            $table->string('payable_amount')->nullable();
            $table->string('combined_payment_company_part')->nullable();
            $table->string('combined_payment_driver_part')->nullable();
            $table->string('country')->nullable();
            $table->string('city_name')->nullable();
            $table->string('currency')->nullable();
            $table->string('pay_date')->nullable();
            $table->string('adj_trip_compensation')->nullable();
            $table->string('adj_device_payment')->nullable();
            $table->string('adj_salik')->nullable();
            $table->string('adj_lost_device')->nullable();
            $table->string('adj_bonus')->nullable();
            $table->string('adj_sim_excess')->nullable();
            $table->double('adj_last_month_adjustment')->nullable();
            $table->string('adj_late_arrival')->nullable();
            $table->string('adj_back_out')->nullable();
            $table->string('adj_arrived_to_early')->nullable();
            $table->string('adj_cash_collection')->nullable();
            $table->string('adj_wrong_guest')->nullable();
            $table->string('adj_cash_per_trip_payment')->nullable();
            $table->string('adj_wire_fees')->nullable();
            $table->double('adj_driver_tip')->nullable();
            $table->string('adj_4h_guarantee')->nullable();
            $table->string('adj_6h_guarantee')->nullable();
            $table->string('adj_trip_referred_user')->nullable();
            $table->string('adj_referred_driver_adjustment')->nullable();
            $table->string('adj_referring_driver_adjustment')->nullable();
            $table->string('adj_trip_by_referred_driver')->nullable();
            $table->string('adj_data_plan_fees')->nullable();
            $table->string('adj_fines')->nullable();
            $table->string('adj_cash_paid_in_from_captain')->nullable();
            $table->string('adj_wrong_amount_entered')->nullable();
            $table->string('adj_health_insurance')->nullable();
            $table->string('adj_items_bought')->nullable();
            $table->string('adj_guarantee')->nullable();
            $table->string('jordan_car_rental')->nullable();
            $table->string('fawry')->nullable();
            $table->string('captain_bonus')->nullable();
            $table->string('referring_driver_trip_target_reward_amount')->nullable();
            $table->string('referred_driver_trip_target_reward_amount')->nullable();
            $table->string('cash_paid_in_by_captain_from_pos')->nullable();
            $table->string('lease_deduction')->nullable();
            $table->string('limo_commissions')->nullable();
            $table->string('trainer_payment')->nullable();
            $table->string('traffic_violation')->nullable();
            $table->string('captain_careem_card')->nullable();
            $table->string('one_time_card_payment')->nullable();
            $table->string('rickshaw_adjustment')->nullable();
            $table->string('card_operator_fees')->nullable();
            $table->string('one_card_commission_deduction')->nullable();
            $table->string('emergency_fund_deduction')->nullable();
            $table->string('vendor_bonus_tax')->nullable();
            $table->string('captain_bonus_tax')->nullable();
            $table->string('uncollected_cash_for_trip')->nullable();
            $table->string('past_trip_earning')->nullable();
            $table->string('easypaisa_cash_collection')->nullable();
            $table->string('captain_loyalty_program')->nullable();
            $table->string('marketing_expenses')->nullable();
            $table->string('packages_cash_collection')->nullable();
            $table->string('madfooatcom_payment')->nullable();
            $table->string('stc_cash_payment')->nullable();
            $table->string('background_check')->nullable();
            $table->string('fine_reimbursement')->nullable();
            $table->string('pooling_trip_earnings')->nullable();
            $table->string('switch_cash_payment')->nullable();
            $table->string('top_up_commission')->nullable();
            $table->string('quality_bonus')->nullable();
            $table->string('midweek_paid_amount')->nullable();
            $table->string('bonus_for_non_cash_trip')->nullable();
            $table->string('refundable_deposit')->nullable();
            $table->string('intercity_pooling_bonus')->nullable();
            $table->string('captain_loyalty_trip_peak_bonus')->nullable();
            $table->string('careempay_captain_debt_payment')->nullable();
            $table->double('transfer_to_careempay')->nullable();
            $table->string('now_cash_refusal')->nullable();
            $table->string('vat_settlement_adjustment')->nullable();
            $table->string('number_of_bank_details')->nullable();
            $table->string('bank_wire_possible')->nullable();
            $table->string('document_number')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->string('file_path');

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
        Schema::dropIfExists('careem');
    }
}

