<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntryPrintOutsidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entry_print_inside_outside', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_id');
            $table->string('type')->nullable();//Either this visa type is inside or outside, 0 for inside 1 for outside
            $table->string('visa_number')->nullable();
            $table->string('uid_no')->nullable();
            $table->string('visa_issue_date')->nullable();
            $table->string('visa_expiry_date')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('transaction_date_time')->nullable();
            $table->string('vat')->nullable();
            $table->string('final_amount')->nullable();
            $table->string('outside_expiry')->nullable();
            $table->bigInteger('visa_type')->nullable();
            $table->bigInteger('attachment_id')->nullable();
            $table->string('is_complete')->default('0');

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
        Schema::dropIfExists('entry_print_inside_outside');
    }
}
