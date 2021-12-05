<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileToTicketMessages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ticket_messages', function (Blueprint $table) {
            //
            $table->tinyInteger('is_read')->default(0); // 0 means = read , 1 = means not read
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ticket_messages', function (Blueprint $table) {
            //
        });
    }
}
