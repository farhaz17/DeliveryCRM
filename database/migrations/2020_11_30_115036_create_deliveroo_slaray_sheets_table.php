<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverooSlaraySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('deliveroo_slaray_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rider_id');
            $table->string('rider_name');
            $table->string('agency');
            $table->string('city');
            $table->string('pay_group');
            $table->string('email_address');
            $table->double('total_orders_delivered');
            $table->double('stacked_orders_delivered');
            $table->double('hours_worked_within_schedule');
            $table->double('rider_drop_fees');
            $table->double('rider_guarantee');
            $table->double('tips');
            $table->double('past_queries_adjustment');
            $table->double('bonus');
            $table->double('surge');
            $table->double('fuel');
            $table->double('rider_training_fees');
            $table->double('total_rider_earnings');
            $table->double('agency_drop_fees');
            $table->double('agency_guarantees');
            $table->double('rider_insurance');
            $table->string('non_order_related_work_2');
            $table->string('past_queries_adjustment_2');
            $table->double('agency_training_fees');
            $table->double('early_departure_fee');
            $table->double('rider_kit');
            $table->double('phone_installments');
            $table->double('excessive_sim_plan_usage');
            $table->double('salik_charges');
            $table->double('bike_insurance');
            $table->double('traffic_fines');
            $table->double('bike_repair_charges');
            $table->double('total_agency_earnings');
            $table->double('rider_earnings');
            $table->double('rider_tips');
            $table->double('agency_earnings');
            $table->double('total');
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
        Schema::dropIfExists('deliveroo_slaray_sheets');
    }
}
