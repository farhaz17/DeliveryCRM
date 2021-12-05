<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaCancellationApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_cancellation_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_id');
            $table->text('attachment');
            $table->integer('decline_status')->comment('1 for declined, 2 for Approved');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('visa_cancellation_approvals');
    }
}
