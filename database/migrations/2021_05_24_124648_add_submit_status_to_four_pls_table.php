<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubmitStatusToFourPlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('four_pls', function (Blueprint $table) {
            $table->integer('submit_status')->nullable()->comment = '1=submitted';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('four_pls', function (Blueprint $table) {
            $table->dropColumn('submit_status');
        });
    }
}
