<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id');
            $table->bigInteger('assigned_from');
            $table->bigInteger('assigned_to');
            $table->text('message_note');
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
        Schema::dropIfExists('ticket_activities');
    }
}
