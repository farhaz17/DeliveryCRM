<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnBoardStatusTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('on_board_status_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->integer('checkout_type'); // 1= shuffle platform, 2= vacation, 3=terminated by platform, 4= terminated by Company, 5=accident,6=absconded, 7= demised, 8 = cancellation
            $table->date('expected_date')->nullable();
            $table->string('platform_id')->nullable();
            $table->integer('applicant_status')->default(0); //0 = new added row, 1= hire
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
        Schema::dropIfExists('on_board_status_types');
    }
}
