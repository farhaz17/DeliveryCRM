<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkPermitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_permits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('work_permit_issue_date');
            $table->string('work_permit_expiry_date');
            $table->string('personal_number');
            $table->string('profession_visa');
            $table->string('working_visa');
            $table->string('nationality');
            $table->string('working_company');
            $table->string('visa_company');
            $table->string('offer_letter_no');
            $table->string('transaction_no');
            $table->string('passport_number');
            $table->string('labour_card_permit_no');
            $table->string('employment');
            $table->string('visa');
            $table->string('visa_print')->nullable();
            $table->string('work_permit_copy');
            $table->string('status');


            $table->string('deleted_at')->nullable();
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
        Schema::dropIfExists('work_permits');
    }
}
