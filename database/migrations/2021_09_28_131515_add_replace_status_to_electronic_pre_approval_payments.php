<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReplaceStatusToElectronicPreApprovalPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electronic_pre_approval_payments', function (Blueprint $table) {
            //
            $table->bigInteger('replace_status')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electronic_pre_approval_payments', function (Blueprint $table) {
            //
        });
    }
}
