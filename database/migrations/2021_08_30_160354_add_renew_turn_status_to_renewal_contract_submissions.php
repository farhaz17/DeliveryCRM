<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRenewTurnStatusToRenewalContractSubmissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renewal_contract_submissions', function (Blueprint $table) {
            //
            $table->integer('renew_turn_status')->after('passport_id')->comment('how many times he renew visa');
            $table->integer('renew_expire_status')->nullable()->comment('1 for expire, null not not expire');
            $table->integer('renew_agreement_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renewal_contract_submissions', function (Blueprint $table) {
            //
        });
    }
}
