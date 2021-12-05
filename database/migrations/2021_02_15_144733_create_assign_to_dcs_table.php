<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignToDcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_to_dcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rider_passport_id');
            $table->bigInteger('platform_id');
            $table->bigInteger('user_id');
            $table->bigInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assign_to_dcs');
    }
}
