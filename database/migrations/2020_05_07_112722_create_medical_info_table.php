<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('app_id_number');
            $table->string('medical_date');
            $table->string('name');
            $table->string('urgency_type');
            $table->string('medical_center');
            $table->string('passport_number');
            $table->string('emirates_id');
            $table->string('email');
            $table->string('sponser_name');
            $table->string('residency_number');
            $table->string('medical_status');

            $table->string('deleted_at')->nullable();
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
        Schema::dropIfExists('medical_infos');
    }
}
