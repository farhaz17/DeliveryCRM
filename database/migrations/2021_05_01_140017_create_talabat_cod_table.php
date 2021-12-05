<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalabatCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talabat_cod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('city');
            $table->string('rider_name');
            $table->string('rider_id');
            $table->string('balance_date_amount');
            $table->string('date_cod_amount');
            $table->string('pending_date_amount');
            $table->string('after_pending_date_column_amount');
            $table->string('cash');
            $table->string('remaining');
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('upload_by');
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
        Schema::dropIfExists('talabat_cod');
    }
}
