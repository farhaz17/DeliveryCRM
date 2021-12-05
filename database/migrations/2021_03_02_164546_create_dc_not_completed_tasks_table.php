<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcNotCompletedTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_not_completed_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('manager_users_id');
            $table->Integer('reason'); //1 = order not completed, 2= attendance not complete, 3= both order and attendance not completed
            $table->dateTime('enable_user_time')->nullable();
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
        Schema::dropIfExists('dc_not_completed_tasks');
    }
}
