<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpoBypassToDrivingLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driving_licenses', function (Blueprint $table) {
            $table->integer('expo_bypass')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driving_licenses', function (Blueprint $table) {
            $table->dropColumn('expo_bypass');
        });
    }
}
