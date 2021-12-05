<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageBikePurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_bike_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('part_number');
            $table->string('invoice_number');
            $table->string('part_name');
            $table->string('part_des');
            $table->string('part_qty');
            $table->string('part_qty_balance');
            $table->string('amount');
            $table->string('vat');
            $table->string('date_created');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manage_bike_purchases');
    }
}
