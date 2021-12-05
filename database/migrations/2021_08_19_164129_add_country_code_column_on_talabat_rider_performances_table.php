<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCountryCodeColumnOnTalabatRiderPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_rider_performances', function (Blueprint $table) {
            $table->string('country_code')->nullable();
            $table->string('contract')->nullable();
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
            $table->dropColumn(
                ['country_code', 'contract']
            );
        });
    }
}
