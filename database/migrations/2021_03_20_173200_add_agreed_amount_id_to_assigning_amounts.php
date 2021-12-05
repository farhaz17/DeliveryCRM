<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAgreedAmountIdToAssigningAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assigning_amounts', function (Blueprint $table) {
            $table->bigInteger('agreed_amount_id')->null();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigning_amounts', function (Blueprint $table) {
            $table->dropColumn(['agreed_amount_id']);
        });
    }
}
