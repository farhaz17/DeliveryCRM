<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNoOfDaysToBikeReplacements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_replacements', function (Blueprint $table) {
            $table->bigInteger('no_of_days')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_replacements', function (Blueprint $table) {
            $table->dropColumn('no_of_days');
        });
    }
}
