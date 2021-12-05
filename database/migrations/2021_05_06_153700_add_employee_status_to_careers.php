<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeStatusToCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->bigInteger('employee_status_id')->nullable();
            $table->text('physical_document')->nullable();
            $table->date('nic_expiry')->nullable();
            $table->integer('referal_status_reward')->nullable();
            $table->bigInteger('referal_reward_amount')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn('employee_status_id');
            $table->dropColumn('physical_document');
            $table->dropColumn('nic_expiry')->nullable();
            $table->dropColumn('referal_status_reward')->nullable();
            $table->dropColumn('referal_reward_amount')->nullable();
        });
    }
}
