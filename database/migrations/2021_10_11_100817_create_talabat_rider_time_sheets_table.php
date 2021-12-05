<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalabatRiderTimeSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talabat_rider_time_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('uploaded_file_path')->nullable();
            $table->string('platform_code');
            $table->bigInteger('passport_id');

            $table->string('contact')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->integer('orders')->nullable();
            $table->integer('deliveries')->nullable();
            $table->double('rider_ppd', [2, 2])->nullable();
            $table->double('three_p_l_ppd', [2, 2])->nullable();
            $table->double('distance', [2, 2])->nullable();
            $table->double('rider_delivery_pay', [2, 2])->nullable();
            $table->double('rider_distance_pay', [2, 2])->nullable();
            $table->double('fp_delivery_pay', [2, 2])->nullable();
            $table->double('total_delivery_pay', [2, 2])->nullable();
            $table->double('monthly_incentive', [2, 2])->nullable();
            $table->double('booster', [2, 2])->nullable();
            $table->double('new_hire_benefit', [2, 2])->nullable();
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
        Schema::dropIfExists('talabat_rider_time_sheets');
    }
}
