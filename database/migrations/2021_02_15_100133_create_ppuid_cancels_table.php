<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpuidCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppuid_cancels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->nullable();
            $table->bigInteger('working_status')->nullable();
            $table->bigInteger('visa_status')->nullable();
            $table->text('working_status_remarks')->nullable();
            $table->text('visa_status_remarks')->nullable();
            $table->bigInteger('id_status')->nullable();
            $table->text('id_status_remarks')->nullable();
            $table->bigInteger('status')->nullable();
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
        Schema::dropIfExists('ppuid_cancels');
    }
}
