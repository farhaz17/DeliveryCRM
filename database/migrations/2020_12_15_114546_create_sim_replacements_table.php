<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimReplacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_replacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('assign_sim_id');
            $table->bigInteger('replace_sim_id');
            $table->bigInteger('new_sim_id');
            $table->Integer('type'); // 1 = temporary , 2 = permanent
            $table->Integer('replace_reason')->nullable();
            $table->Integer('status'); // 1 = checkin, 0 = checkout
            $table->text('replace_remarks')->nullable();
            $table->text('replace_taken_remarks')->nullable();
            $table->dateTime('replace_checkin');
            $table->dateTime('replace_checkout')->nullable();
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
        Schema::dropIfExists('sim_replacements');
    }
}
