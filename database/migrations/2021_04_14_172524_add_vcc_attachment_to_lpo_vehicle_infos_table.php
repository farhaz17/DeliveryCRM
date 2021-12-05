<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVccAttachmentToLpoVehicleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lpo_vehicle_infos', function (Blueprint $table) {
            $table->integer('insurance_id')->nullable();
            $table->integer('insurance_no')->nullable();
            $table->text('vcc_attachment')->nullable();
            $table->integer('received')->nullable();
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
            //
        });
    }
}
