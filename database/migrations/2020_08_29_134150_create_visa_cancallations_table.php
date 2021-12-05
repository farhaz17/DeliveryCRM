<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaCancallationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_cancallations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('cancallation_type');
            $table->bigInteger('resignation_type')->nullable();
            $table->text('remarks')->nullable();
            $table->date('date_until_works')->nullable();
            $table->date('start_cancel_date')->nullable();
            $table->bigInteger('approval_status')->nullable();
            $table->bigInteger('hold_status')->nullable();
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
        Schema::dropIfExists('visa_cancallations');
    }
}
