<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPassportToCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->integer('have_passport')->default(null)->after('passport_status');
            $table->string('shirt_size')->default(null)->after('passport_status');
            $table->string('waist_size')->default(null)->after('passport_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn('have_passport');
            $table->dropColumn('shirt_size');
            $table->dropColumn('waist_size');
        });
    }
}
