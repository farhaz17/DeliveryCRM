<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications_msgs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plateform_id');
            $table->text('text_notif')->nullable();
            $table->string('voice_notif')->nullable();
            $table->string('img_notif')->nullable();
            $table->string('file_notif')->nullable();
            $table->string('status')->default('0');
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
        Schema::dropIfExists('notifications_msgs');
    }
}
