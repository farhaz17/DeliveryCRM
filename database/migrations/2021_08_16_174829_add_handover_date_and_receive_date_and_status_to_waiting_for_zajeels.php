<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHandoverDateAndReceiveDateAndStatusToWaitingForZajeels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waiting_for_zajeels', function (Blueprint $table) {
            //
            $table->date('handover_date')->nullable();
            $table->date('receive_date')->nullable();
            $table->integer('status')->nullable()->comment('1 for handover 2 for receive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waiting_for_zajeels', function (Blueprint $table) {
            //
        });
    }
}
