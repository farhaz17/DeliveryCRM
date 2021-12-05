<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBetweenVisaCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('between_visa_cancels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->text('attachment');
            $table->double('payment_amount')->nullable();
            $table->bigInteger('payment_type')->nullable();
            $table->string('transaction_number')->nullable();
            $table->date('transaction_date')->nullable();
            $table->double('vat')->nullable();
            $table->text('other_attachment')->nullable();
            $table->integer('status')->default('1')->comment('1 for visa canelled, 2 for visa cancel disabled');
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
        Schema::dropIfExists('between_visa_cancels');
    }
}
