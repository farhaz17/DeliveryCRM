<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableLockerPassportRequestsChangeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('locker_passport_requests', function (Blueprint $table) {
            $table->date('receive_date')->nullable()->change();
            $table->date('return_date')->nullable()->change();
            $table->string('reason')->nullable()->change();
            $table->string('remarks')->nullable()->change();
            $table->bigInteger('status')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locker_passport_requests', function (Blueprint $table) {
            //
        });
    }
}
