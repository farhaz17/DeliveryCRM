<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ticket_id');
            $table->text('chat_message')->nullable();
            $table->bigInteger('user_id');
            $table->string('voice_message')->nullable();
            $table->string('pdf_file')->nullable();
            $table->string('image_file')->nullable();
            $table->bigInteger('category');
            $table->bigInteger('user_type'); //1 = admin 2=user
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
        Schema::dropIfExists('ticket_messages');
    }
}
