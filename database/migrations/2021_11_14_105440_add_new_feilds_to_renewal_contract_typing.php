<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFeildsToRenewalContractTyping extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewal_contract_typings', function (Blueprint $table) {
            //
            $table->bigInteger('renew_expire_status')->nullable();
            $table->bigInteger('renew_turn_status')->nullable();
            $table->bigInteger('renew_agreement_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renewal_contract_typings', function (Blueprint $table) {
            //
        });
    }
}
