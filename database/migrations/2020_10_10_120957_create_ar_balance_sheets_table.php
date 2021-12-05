<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArBalanceSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_balance_sheets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zds_code');
            $table->string('passport_id')->nullable();
            $table->date('date_saved');
            $table->bigInteger('balance_type');
            $table->double('balance');
            $table->string('remarks')->nullable();
            $table->integer('status');

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
        Schema::dropIfExists('ar_balance_sheets');
    }
}
