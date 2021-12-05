<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToArBalanceSheetsSecond extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_balance_sheets', function (Blueprint $table) {
            //
            $table->bigInteger('renew_visa_process_step')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_balance_sheets', function (Blueprint $table) {
            //
        });
    }
}
