<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpoMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpo_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('inventory_type')->nullable(); // 1-Vehicle, 2-Spare
            $table->integer('purchase_type')->nullable(); // 1-Rental, 2-Lease to own, 3-Company
            $table->integer('contract_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('amount')->nullable();
            $table->date('start_date')->nullable();
            $table->text('lpo_no')->nullable();
            $table->text('lpo_attachment')->nullable();
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
        Schema::dropIfExists('lpo_masters');
    }
}
