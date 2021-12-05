<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('repair_id');
            $table->bigInteger('total_item');
            $table->double('total_amount');
            $table->double('discount')->default('0');
            $table->integer('paid_by');
            $table->text('note')->nullable();
            $table->integer('added_by');
            $table->integer('status');
            $table->timestamps();

            //paying by =0 cash
            //paying credit=1
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_payments');
    }
}
