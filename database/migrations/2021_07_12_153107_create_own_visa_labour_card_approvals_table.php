<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnVisaLabourCardApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('own_visa_labour_card_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->nullable();
            $table->text('attachment')->nullable();
            $table->string('labour_card_no')->nullable();
            $table->bigInteger('user_id')->nullable();
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
        Schema::dropIfExists('own_visa_labour_card_approvals');
    }
}
