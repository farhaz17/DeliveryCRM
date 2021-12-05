<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToAssigningAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assigning_amounts', function (Blueprint $table) {
            $table->integer('rn_visa_process_status')->nullable()->comment('1 its rewnew visa, Null for not pay');
            $table->integer('rn_step_id')->nullable();
            $table->integer('rn_pay_status')->nullable()->comment('1 for pay, Null for not pay');

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
            $table->dropColumn([
                'rn_visa_process_status',
                'rn_step_id',
                'rn_pay_status'
            ]);
        });
    }
}
