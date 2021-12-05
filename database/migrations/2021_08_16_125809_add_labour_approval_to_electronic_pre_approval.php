<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLabourApprovalToElectronicPreApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electronic_pre_approval', function (Blueprint $table) {
            //
            $table->integer('labour_approval')->nullable()->comment('0 for No 1 for yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electronic_pre_approval', function (Blueprint $table) {
            //
        });
    }
}
