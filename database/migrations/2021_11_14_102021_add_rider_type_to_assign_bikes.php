<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRiderTypeToAssignBikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_bikes', function (Blueprint $table) {
            //
            $table->integer('rider_type')->default(1)->comment('1=rider,2 front line warrior');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_bikes', function (Blueprint $table) {
            //
            $table->dropColumn('rider_type');
        });
    }
}
