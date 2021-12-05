<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnassignedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unassigned_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('platform_id');
            $table->integer('no_of_orders');
            $table->date('order_date');
            $table->text('image');
            $table->string('reason');
            $table->text('other_reason')->nullable();
            $table->integer('status')->default(0);  // 0=pending , 1= approved , 2= rejected
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
        Schema::dropIfExists('unassigned_orders');
    }
}
