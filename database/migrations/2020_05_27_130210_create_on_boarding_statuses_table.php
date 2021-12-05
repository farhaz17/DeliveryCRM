<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnBoardingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_boarding_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('driving_license_status')->nullable();  // 1 for yes, 0 for No
            $table->bigInteger('living_status')->nullable();   // 1 for yes, 0 for No
            $table->bigInteger('passport_handler_status')->nullable(); // 1 for Yes, 0 for No
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
        Schema::dropIfExists('on_boarding_statuses');
    }
}
