<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletionRatePercentageFieldOnTalabatPerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_rider_performances', function (Blueprint $table) {
            $table->decimal('completion__rate__percentage')->nullable();
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
            $table->dropColumn('completion__rate__percentage');
        });
    }
}
