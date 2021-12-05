<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTimestampColumnOnTalabatRiderPerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_rider_performances', function (Blueprint $table) {
            $table->datetime('start_date')->default('0000-00-00 00:00:00')->change();
            $table->datetime('end_date')->default('0000-00-00 00:00:00')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talabat_rider_performances', function (Blueprint $table) {
            //
        });
    }
}
