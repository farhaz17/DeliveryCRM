<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRenewTurnStatusToRenewAgreedAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renew_agreed_amounts', function (Blueprint $table) {
            //
            $table->integer('renew_turn_status')->after('passport_id')->comment('how many times he renew visa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renew_agreed_amounts', function (Blueprint $table) {
            //
        });
    }
}
