<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateColumnOnCarreforCloseMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carrefor_close_months', function (Blueprint $table) {
            $table->date('date')->after('close_month_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carrefor_close_months', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }
}
