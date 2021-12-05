<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCityIdZoneIdAndPlatformCodeOnTalabatCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_cod', function (Blueprint $table) {
            $table->bigInteger('city_id');
            $table->bigInteger('zone_id');
            $table->string('platform_code');
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
