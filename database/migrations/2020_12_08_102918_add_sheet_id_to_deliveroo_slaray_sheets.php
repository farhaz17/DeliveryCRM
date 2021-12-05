<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSheetIdToDeliverooSlaraySheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deliveroo_slaray_sheets', function (Blueprint $table) {
            //
            $table->string('sheet_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliveroo_slaray_sheets', function (Blueprint $table) {
            //
        });
    }
}
