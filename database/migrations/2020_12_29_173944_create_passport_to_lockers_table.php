<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassportToLockersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport_to_lockers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('received_from');
            $table->bigInteger('received_user');
            $table->text('remarks')->nullable();
            $table->text('reason')->nullable();
            $table->bigInteger('manager_id')->nullable();
            $table->dateTime('transfer_time')->nullable();
            $table->boolean('accept_status')->nullable();
            $table->boolean('locker')->nullable();
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
        Schema::dropIfExists('passport_to_lockers');
    }
}
