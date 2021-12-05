<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpoChequesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpo_cheques', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('bank_name')->nullable();
            $table->text('account_no')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('amount')->nullable();
            $table->text('cheque_no')->nullable();
            $table->date('pdc_date')->nullable();
            $table->integer('cheque_type')->nullable(); // 1-PDC, 2-CDC, 3-Guaranty
            $table->integer('category')->nullable(); // 1-purchase, 2-category
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
        Schema::dropIfExists('lpo_cheques');
    }
}
