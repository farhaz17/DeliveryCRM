<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_number');
            $table->string('party_id');
            $table->string('product_type');
            $table->text('invoice_number');
            $table->string('invoice_date');
            $table->string('service_rental');
            $table->string('usage_charge');
            $table->string('one_time_charges');
            $table->string('other_credit_and_charges');
            $table->string('vat_on_taxable_services');
            $table->string('billed_amount');
            $table->string('total_amount_due');
            $table->string('amount_to_pay');
            $table->bigInteger('sim_bill_upload_path_id');
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
        Schema::dropIfExists('sim_bills');
    }
}
