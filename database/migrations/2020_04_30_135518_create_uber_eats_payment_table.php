<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUberEatsPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uber_eats_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('driver_u_uid');
            $table->string('trip_u_uid');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('amount');
            $table->string('timestamp');
            $table->string('item_type');
            $table->string('description');
            $table->string('disclaimer')->nullable();

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
        Schema::dropIfExists('uber_eats_payment');
    }
}
