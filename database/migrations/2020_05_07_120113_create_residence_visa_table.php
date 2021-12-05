<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResidenceVisaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residence_visas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uid_no');
            $table->string('file_no');
            $table->string('passport_no');
            $table->string('name');
            $table->string('profession_visa');
            $table->string('profession_working');
            $table->string('company_visa');
            $table->string('company_working');
            $table->string('work_permit_no');
            $table->string('place_of_issue');
            $table->string('issue_date');
            $table->string('expiry_date');
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
        Schema::dropIfExists('residence_visas');
    }
}
