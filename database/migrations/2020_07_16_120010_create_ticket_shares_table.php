<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_shares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id');
            $table->bigInteger('assigned_from');
            $table->bigInteger('internal_dep_assign');
            $table->text('message_note')->nullable();
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
        Schema::dropIfExists('ticket_shares');
    }
}
