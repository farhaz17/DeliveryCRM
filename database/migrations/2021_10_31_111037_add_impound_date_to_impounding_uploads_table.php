<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImpoundDateToImpoundingUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_impounding_uploads', function (Blueprint $table) {
            $table->integer('fine_or_impound')->default(0);
            $table->date('impound_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_impounding_uploads', function (Blueprint $table) {
            $table->dropColumn(['fine_or_impound', 'impound_date']);
        });
    }
}
