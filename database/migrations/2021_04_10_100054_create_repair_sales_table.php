<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('repair_no');
            $table->bigInteger('bike_id');
            $table->string('data');
            $table->integer('status');
//status =0 current repair
//status 2= repair complete
//status status =1 repair hold
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
        Schema::dropIfExists('repair_sales');
    }
}
