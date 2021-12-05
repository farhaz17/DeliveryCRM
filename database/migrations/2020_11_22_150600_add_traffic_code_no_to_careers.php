<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrafficCodeNoToCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->string('traffic_file_no')->nullable();
            $table->text('licence_attach_back')->nullable();
            $table->string('experience_month')->nullable();
            $table->bigInteger('refer_by')->nullable(); // passport id will save here
            $table->integer('refer_type')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            //
        });
    }
}
