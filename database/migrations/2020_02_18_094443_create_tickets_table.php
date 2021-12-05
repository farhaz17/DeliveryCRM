<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->String('ticket_id');
            $table->bigInteger('platform');
            $table->string('platform_id')->nullable();
            $table->text('message')->nullable();
            $table->bigInteger('department_id');
            $table->bigInteger('processing_by');
            $table->string('image_url')->nullable();
            $table->string('voice_message')->nullable();
            $table->tinyInteger('is_checked')->default(0);
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
        Schema::dropIfExists('tickets');
    }
}
