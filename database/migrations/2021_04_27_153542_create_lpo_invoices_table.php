<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpo_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lpo_id')->nullable();
            $table->text('invoice_no')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('vat')->nullable();
            $table->integer('quantity')->nullable();
            $table->date('invoice_date')->nullable();
            $table->text('created_user_id')->nullable();
            $table->text('attachment')->nullable();
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
        Schema::dropIfExists('lpo_invoices');
    }
}
