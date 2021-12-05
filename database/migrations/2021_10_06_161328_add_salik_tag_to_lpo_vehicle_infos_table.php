<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSalikTagToLpoVehicleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lpo_vehicle_infos', function (Blueprint $table) {
            $table->integer('salik_tag_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lpo_vehicle_infos', function (Blueprint $table) {
            $table->dropColumn('salik_tag_id');
        });
    }
}
