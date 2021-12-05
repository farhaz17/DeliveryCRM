<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpoSpareInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpo_spare_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lpo_id')->nullable();
            $table->integer('parts_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('quantity_received')->default('0')->nullable();
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
        Schema::dropIfExists('lpo_spare_infos');
    }
}
