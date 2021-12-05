<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFourPlUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('four_pl_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('company_name')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->text('password')->nullable();
            $table->text('otp')->nullable();
            $table->boolean('activated')->nullable();
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
        Schema::dropIfExists('four_pl_users');
    }
}
