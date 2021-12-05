<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlatformCodeUpdateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platform_code_update_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('platform_code_id');
            $table->bigInteger('user_id');
            $table->string('from')->comment('the previous code');
            $table->string('to')->comment('the updated code');
            $table->string('remarks');
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
        Schema::dropIfExists('platform_code_update_histories');
    }
}
