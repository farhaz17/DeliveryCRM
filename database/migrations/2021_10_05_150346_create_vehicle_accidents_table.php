<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleAccidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_accidents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rider_passport_id');
            $table->bigInteger('bike_id');
            $table->bigInteger('status')->comment('1=waiting_checkout,2=checkout_completed,3=rejected,4=doc_uploaded,5=claim,9=completed');
            $table->dateTime('accident_date');
            $table->string('location')->nullable();
            $table->bigInteger('rider_condition');
            $table->bigInteger('checkout_type');
            $table->bigInteger('police_report');
            $table->text('police_report_attachment')->nullable();
            $table->string('remark')->nullable();
            $table->bigInteger('user_id');
            $table->double('salary');
            $table->bigInteger('police_report_received')->comment('0=not_received, 1=received');
            $table->bigInteger('emiratesid')->comment('0=not_received, 1=received');
            $table->bigInteger('driving_license')->comment('0=not_received, 1=received');
            $table->bigInteger('passport_received')->comment('0=not_received, 1=received');
            $table->date('claim_date')->nullable();
            $table->string('claim_remark')->nullable();
            $table->text('claim_file')->nullable();
            $table->text('claim_number')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('garage')->nullable();
            $table->string('concerned_person')->nullable();
            $table->string('contact')->nullable();
            $table->bigInteger('loss_or_repair')->comment('1=loss, 2=repair');
            $table->text('offer_letter')->nullable();
            $table->text('transfer_letter')->nullable();
            $table->date('receive_date')->nullable();
            $table->string('person')->nullable();
            $table->string('condition')->nullable();
            $table->date('loss_claim_date')->nullable();
            $table->string('loss_claim_remark')->nullable();
            $table->text('loss_claim_file')->nullable();
            $table->date('cancelled_date')->nullable();
            $table->string('cancelled_remark')->nullable();
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
        Schema::dropIfExists('vehicle_accidents');
    }
}
