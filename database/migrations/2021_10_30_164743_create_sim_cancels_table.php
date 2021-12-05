<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sim_cancels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sim_id');
            $table->integer('reason_type')->comment('1=lost,2=cancel,3=broken'); //1=lost, 2= cancel, 3= broken
            $table->text('remarks')->nullable();
            $table->integer('status')->comment('1=canceled,0=sim active'); //1= canceled, 0 = active
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
        Schema::dropIfExists('sim_cancels');
    }
}
