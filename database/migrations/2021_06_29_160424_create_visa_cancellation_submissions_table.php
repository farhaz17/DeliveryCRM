<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaCancellationSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_cancellation_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_id');
            $table->text('attachment');
            $table->double('payment_amount')->nullable();
            $table->bigInteger('payment_type')->nullable();
            $table->string('transaction_number')->nullable();
            $table->date('transaction_date')->nullable();
            $table->double('vat')->nullable();
            $table->text('other_attachment')->nullable();
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
        Schema::dropIfExists('visa_cancellation_submissions');
    }
}
