<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgreedAmountStatusToAgreedAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agreed_amounts', function (Blueprint $table) {
            //
            $table->integer('agreed_amount_status')->default(1)->comment('1=means curent agreed amount, 0=means old agreed amount');
            //1=means curent agreed amount, 0=means old agreed amount
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agreed_amounts', function (Blueprint $table) {
            //
            $table->dropColumn('agreed_amount_status');
        });
    }
}
