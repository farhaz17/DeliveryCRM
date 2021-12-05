<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabourApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labour_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_number');
            $table->string('company_name');
            $table->string('name');
            $table->string('nationality');
            $table->string('labour_personal_no');
            $table->string('passport_number');
            $table->string('offer_latter');
            $table->string('work_permit_no');
            $table->string('issue_date');
            $table->string('expiry_date');
            $table->string('profession_visa');
            $table->string('profession_working');
            $table->string('company_visa');
            $table->string('company_working');
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
        Schema::dropIfExists('labour_approvals');
    }
}
