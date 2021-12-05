<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalabatCodDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talabat_cod_deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('city_id');
            $table->bigInteger('zone_id');
            $table->string('rider_name');
            $table->bigInteger('rider_id');
            $table->string('platform_code');
            $table->integer('rider_status');
            $table->string('vendor');
            $table->double('deduction');
            $table->integer('deposit_status');
            $table->integer('days_delayed');
            $table->date('start_date');
            $table->date('end_date');
            $table->bigInteger('upload_by');
            $table->bigInteger('passport_id');
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
        Schema::dropIfExists('talabat_cod_deductions');
    }
}
