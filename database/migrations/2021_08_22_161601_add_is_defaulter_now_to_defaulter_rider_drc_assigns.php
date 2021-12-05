<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsDefaulterNowToDefaulterRiderDrcAssigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaulter_rider_drc_assigns', function (Blueprint $table) {
            //
            $table->integer('is_defaulter_now')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defaulter_rider_drc_assigns', function (Blueprint $table) {
            //
        });
    }
}
