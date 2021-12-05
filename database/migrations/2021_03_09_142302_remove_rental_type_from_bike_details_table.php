<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveRentalTypeFromBikeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->dropColumn(['rental_type']);
            $table->string('vehicle_mortgage_no')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->Integer('make_id')->nullable();
            $table->string('rental_type')->nullable();
        });
    }
}
