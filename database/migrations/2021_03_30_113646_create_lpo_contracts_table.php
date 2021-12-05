<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpoContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpo_contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('supplier_category_id')->nullable(); //1-rental, 2-lease to own
            $table->integer('supplier_id')->nullable();
            $table->text('contract_no')->nullable();
            $table->text('quantity')->nullable();
            $table->text('state')->nullable();
            $table->date('create_date')->nullable();
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
        Schema::dropIfExists('lpo_contracts');
    }
}
