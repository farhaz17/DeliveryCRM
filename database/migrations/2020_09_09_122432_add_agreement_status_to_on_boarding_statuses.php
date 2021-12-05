<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgreementStatusToOnBoardingStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('on_boarding_statuses', function (Blueprint $table) {
            $table->Integer('agreement_status')->nullable();
            $table->Integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('on_boarding_statuses', function (Blueprint $table) {
            //
        });
    }
}
