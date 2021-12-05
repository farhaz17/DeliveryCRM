<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToPassportToLockersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passport_to_lockers', function (Blueprint $table) {
            $table->bigInteger('from_locker')->nullable();
            $table->bigInteger('passport_flow')->nullable(); //1-incoming    2-outgoing
            $table->bigInteger('with_rider')->nullable();
            $table->bigInteger('user_request')->nullable(); //1- if request from user
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passport_to_lockers', function (Blueprint $table) {
            $table->dropColumn(['from_locker','passport_flow','with_rider','user_request']);
        });
    }
}
