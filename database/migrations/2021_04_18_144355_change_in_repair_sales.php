<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeInRepairSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repair_sales', function (Blueprint $table) {
            //
            $table->dropColumn(['repair_no', 'bike_id']);
            $table->bigInteger('manage_repair_id');
            $table->string('entry_no');
            $table->text('data')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repair_sales', function (Blueprint $table) {
            //
        });
    }
}
