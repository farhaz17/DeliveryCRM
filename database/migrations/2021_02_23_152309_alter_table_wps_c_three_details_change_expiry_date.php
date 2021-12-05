<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableWpsCThreeDetailsChangeExpiryDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wps_c_three_details', function (Blueprint $table) {
            $table->dropColumn('expiry');
        });

        Schema::table('wps_c_three_details', function (Blueprint $table) {
            $table->date('expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wps_c_three_details', function (Blueprint $table) {
            $table->dropColumn(['expiry']);
        });
    }
}
