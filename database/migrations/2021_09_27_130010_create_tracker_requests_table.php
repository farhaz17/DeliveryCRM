<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackerRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bike_id');
            $table->bigInteger('user_id');
            $table->date('date');
            $table->bigInteger('status')->comment("1=dc, 2=rta");
            $table->bigInteger('type')->comment("0=pending, 1=installed, 2=removed");
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
        Schema::dropIfExists('tracker_requests');
    }
}
