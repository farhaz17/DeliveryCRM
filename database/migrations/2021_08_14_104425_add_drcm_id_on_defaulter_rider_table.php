<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDrcmIdOnDefaulterRiderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->unsignedBigInteger('drcm_id')->before('drc_id');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->dropColumn([
                'drcm_id'
            ]);
        });
    }
}
