<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnOnDefaulterRiderDrcAssigns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaulter_rider_drc_assigns', function (Blueprint $table) {
            $table->integer('status')->default(1)->comment('1 = active');
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
            $table->dropColumn(['status']);
        });
    }
}
