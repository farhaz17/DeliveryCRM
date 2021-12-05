<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManageBikeInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manage_bike_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('part_number');
            $table->string('invoice_number');
            $table->string('part_name');
            $table->string('part_des');
            $table->string('part_qty');
            $table->string('amount');
            $table->string('vat');
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
        Schema::dropIfExists('manage_bike_invoices');
    }
}
