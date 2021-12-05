<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnFormatOfTalabatCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_cod', function (Blueprint $table) {
            $table->string('previous_day_pending')->unsigned()->change();
            $table->string('current_day_cash_deposit')->unsigned()->change();
            $table->string('previous_day_balance')->unsigned()->change();
            $table->string('current_day_adjustment')->unsigned()->change();
            $table->string('current_day_cod')->unsigned()->change();
            $table->string('current_day_balance')->unsigned()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talabat_cod', function (Blueprint $table) {
            //
        });
    }
}
