<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTalabatRiderPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talabat_rider_performances', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->bigInteger('rider_id');
            $table->string('uploaded_file_path');
            $table->string('rider_platform_code');
            $table->bigInteger('passport_id'); // instead of rider name and rider id we will store passport id of that rider
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

            // $table->string('rider_name');
            $table->bigInteger('tenure');
            $table->bigInteger('batch_number');
            $table->timestamp('contract_end_at');
            // $table->string('contract'); // we dont need this column
            $table->timestamp('contract_start_at');
            $table->string('zone_name');
            // $table->string('country_code'); // we dont need this column
            $table->integer('shift_count');
            $table->integer('worked_days');
            $table->integer('no_shows');
            $table->decimal('no_show_percentage');
            $table->integer('late_login_grater_than_five');
            $table->decimal('late_login_greater_than_five_percentage');
            $table->integer('completed_orders');
            $table->integer('cancelled_orders');
            $table->integer('completed_deliveries');
            $table->decimal('cancelations_divided_by_ten_orders');
            $table->decimal('utr');
            $table->decimal('total_working_hours');
            $table->decimal('total_break_hours');
            $table->decimal('attendence_percentage');
            $table->decimal('breaks_percentage');
            $table->integer('notification_count');
            $table->integer('acceptance_count');
            $table->decimal('acceptance_rate');
            $table->decimal('completion_rate_percentage');
            $table->integer('undispatch_count');
            $table->decimal('avg_delivery_time');
            $table->decimal('avg_at_vendor_time');
            $table->decimal('avg_at_customer_time');
            $table->decimal('avg_to_customer_time');
            $table->decimal('avg_to_vendor_time');
            $table->decimal('pick_up_gps_error_percentage');
            $table->decimal('drop_off_gps_error_percentage');
            $table->softDeletes();
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
        Schema::dropIfExists('talabat_rider_performances');
    }
}
