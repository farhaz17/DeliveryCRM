<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignToDcIdOnDefaulterRidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->bigInteger('previous_assign_to_dc_id')->comment('to track previous dc row')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->dropColumn([
                'previous_assign_to_dc_id'
            ]);
        });
    }
}
