<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFourPlRiderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('four_pl_rider_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->default(0);
            $table->bigInteger('career_id')->default(0);
            $table->integer('employee_type');
            $table->bigInteger('vendor_fourpl_pk_id');
            $table->integer('hire_status')->default(0);
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
        Schema::dropIfExists('four_pl_rider_histories');
    }
}
