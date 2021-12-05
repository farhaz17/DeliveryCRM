<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaClearancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_clearances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('cancallation_id');
            $table->bigInteger('passport_id');
            $table->bigInteger('payroll_status')->nullable();
            $table->text('payroll_remarks')->nullable();
            $table->bigInteger('maintenance_status')->nullable();
            $table->text('maintenance_remarks')->nullable();
            $table->bigInteger('operation_status')->nullable();
            $table->text('operation_remarks')->nullable();
            $table->bigInteger('pro_status')->nullable();
            $table->text('pro_remarks')->nullable();
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
        Schema::dropIfExists('visa_clearances');
    }
}
