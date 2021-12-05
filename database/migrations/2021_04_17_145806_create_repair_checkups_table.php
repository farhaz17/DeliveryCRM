<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairCheckupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_checkups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('manage_repair_id');
            $table->text('checkup_points');
            $table->text('remarks')->nullable();
            $table->string('days_hours')->nullable();
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('repair_checkups');
    }
}
