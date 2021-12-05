<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToEmiratesIdCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emirates_id_cards', function (Blueprint $table) {
            //
            $table->integer('status')->nullable()->comment('1=active, 0=deactive ,2=previous active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emirates_id_cards', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
