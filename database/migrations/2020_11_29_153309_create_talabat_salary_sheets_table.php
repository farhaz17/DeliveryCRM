<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalabatSalarySheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talabat_salary_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('rider_id');
            $table->string('rider_name')->nullable();
            $table->string('vendor')->nullable();
            $table->string('city')->nullable();
            $table->double('deliveries')->nullable();
            $table->double('hours')->nullable();
            $table->double('pay_hour')->nullable();
            $table->double('pay_deliveries')->nullable();
            $table->double('pay_per_hour_payment')->nullable();
            $table->double('pay_per_order_payment')->nullable();
            $table->double('total_pay')->nullable();
            $table->double('zomato_tip')->nullable();
            $table->double('talabat_tip')->nullable();
            $table->double('total_tip')->nullable();
            $table->double('incetive')->nullable();
            $table->double('total_payment')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->string('file_path');
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
        Schema::dropIfExists('talabat_salary_sheets');
    }
}
