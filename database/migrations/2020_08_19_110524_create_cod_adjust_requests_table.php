<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodAdjustRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_adjust_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('message');
            $table->string('order_id')->nullable();
            $table->date('order_date')->nullable();
            $table->bigInteger('passport_id');
            $table->text('images')->nullable();
            $table->bigInteger('amount');
            $table->integer('status')->default(0);
            $table->bigInteger('verify_by')->nullable();
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
        Schema::dropIfExists('cod_adjust_requests');
    }
}
