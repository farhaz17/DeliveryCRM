<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddComplaintDateToBikeMissingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_missings', function (Blueprint $table) {
            $table->string('complaint_remarks')->after('process')->nullable();
            $table->date('complaint_date')->after('process')->nullable();
            $table->string('police_station')->after('process')->nullable();
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
            $table->dropColumn(['complaint_remarks', 'complaint_date', 'police_station']);
        });
    }
}
