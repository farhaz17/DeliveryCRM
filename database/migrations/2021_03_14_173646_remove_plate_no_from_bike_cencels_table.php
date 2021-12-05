<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePlateNoFromBikeCencelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_cencels', function (Blueprint $table) {
            $table->dropColumn(['plate_no']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_cencels', function (Blueprint $table) {
            $table->string('plate_no')->nullable();
        });
    }
}
