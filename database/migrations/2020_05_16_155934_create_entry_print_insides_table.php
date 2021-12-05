<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryPrintInsidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_print_insides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->string('visa_number');
            $table->string('uid_no');
            $table->string('visa_issue_date');
            $table->string('visa_expiry_date');
            $table->string('payment_amount');
            $table->string('payment_type');
            $table->string('transaction_no');
            $table->string('transaction_date_time');
            $table->string('vat');
            $table->bigInteger('attachment_id')->nullable();;
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
        Schema::dropIfExists('entry_print_insides');
    }
}
