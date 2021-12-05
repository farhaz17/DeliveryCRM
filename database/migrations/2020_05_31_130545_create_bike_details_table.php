<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plate_no');
            $table->string('plate_code')->nullable();
            $table->string('model')->nullable();
            $table->string('make_year')->nullable();
            $table->string('chassis_no');
            $table->string('mortgaged_by')->nullable();
            $table->string('insurance_co')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->bigInteger('traffic_file')->nullable();
            $table->bigInteger('category_type')->default('0');
            $table->bigInteger('status')->default('0');
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
        Schema::dropIfExists('bike_details');
    }
}
