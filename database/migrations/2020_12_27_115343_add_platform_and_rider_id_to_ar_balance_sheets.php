<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlatformAndRiderIdToArBalanceSheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_balance_sheets', function (Blueprint $table) {
            $table->bigInteger('platform_id')->nullable();
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
            $table->dropColumn(['platform_id']);
        });
    }
}
