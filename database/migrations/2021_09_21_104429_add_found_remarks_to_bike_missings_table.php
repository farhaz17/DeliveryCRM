<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFoundRemarksToBikeMissingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_missings', function (Blueprint $table) {
            $table->string('found_remarks')->after('process')->nullable();
            $table->integer('found_status')->after('process')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_missings', function (Blueprint $table) {
            $table->dropColumn(['found_remarks', 'found_status']);
        });
    }
}
