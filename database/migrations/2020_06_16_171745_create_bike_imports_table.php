<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plate_no');
            $table->string('plate_code');
            $table->string('model');
            $table->string('make_year');
            $table->string('chassis_no');
            $table->string('mortgaged_by')->nullable();
            $table->string('insurance_co');
            $table->date('expiry_date');
            $table->date('issue_date');
            $table->bigInteger('traffic_file');
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
        Schema::dropIfExists('bike_imports');
    }
}
