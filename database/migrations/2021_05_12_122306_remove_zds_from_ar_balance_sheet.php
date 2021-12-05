<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveZdsFromArBalanceSheet extends Migration
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
            Schema::table('ar_balance_sheets', function (Blueprint $table) {
                $table->dropColumn([
                    'zds_code'
                ]);
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ar_balance_sheet', function (Blueprint $table) {
            //
        });
    }
}
