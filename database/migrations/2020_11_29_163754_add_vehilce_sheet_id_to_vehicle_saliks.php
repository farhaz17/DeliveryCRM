<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVehilceSheetIdToVehicleSaliks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_saliks', function (Blueprint $table) {
            $table->bigInteger('vehicle_salik_sheet_account_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_saliks', function (Blueprint $table) {
            //
        });
    }
}
