<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPayrolldedcutamountToAgreedAmount extends Migration
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
            $table->bigInteger('payroll_deduct_amount')->default(null)->after('final_amount');
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
            $table->dropColumn('payroll_deduct_amount');
        });
    }
}
