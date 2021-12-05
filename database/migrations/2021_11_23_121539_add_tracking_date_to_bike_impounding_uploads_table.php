<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrackingDateToBikeImpoundingUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_impounding_uploads', function (Blueprint $table) {
            $table->date('tracking_date')->nullable();
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
            $table->dropColumn('tracking_date');
        });
    }
}
