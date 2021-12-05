<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoadNumberAndJvNumberToArBalanceSheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ar_balance_sheets', function (Blueprint $table) {
            $table->string('loan_number')->nullable();
            $table->string('jv_number')->nullable();
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
            $table->dropColumn(['loan_number','jv_number']);
        });
    }
}
