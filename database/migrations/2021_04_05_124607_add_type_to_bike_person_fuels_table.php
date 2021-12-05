<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToBikePersonFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_person_fuels', function (Blueprint $table) {
            $table->integer('bike_type_from')->comment('1=assign_bike, 2=bike_replacement')->after('checkout');
            $table->integer('primary_id_from')->comment('primary id of assign bike table  or bike replace')->after('bike_type_from');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_person_fuels', function (Blueprint $table) {
            $table->dropColumn(['bike_type_from']);
            $table->dropColumn(['primary_id_from']);
        });
    }
}
