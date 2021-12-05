<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalikOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salik_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bike_id');
            $table->bigInteger('salik_id');
            $table->bigInteger('status')->comment('1=Installed, 2=Removed');
            $table->bigInteger('type')->comment('1=Installed, 2=Removed, 3=shuffle');
            $table->bigInteger('user_id');
            $table->date('checkin')->nullable();
            $table->date('checkout')->nullable();
            $table->bigInteger('new_shuffled_salik_id')->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('salik_operations');
    }
}
