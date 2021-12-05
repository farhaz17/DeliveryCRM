<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parts_id');
//            $table->string('part_add_name')->nullable();
            $table->bigInteger('quantity');
            $table->bigInteger('quantity_balance');
            $table->float('price')->nullable();
//            $table->string('invoice_no');
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
        Schema::dropIfExists('inv_parts');
    }
}
