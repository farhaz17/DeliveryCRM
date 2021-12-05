<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSendDirectCheckoutToDcRequestForCheckouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc_request_for_checkouts', function (Blueprint $table) {
            //
            $table->integer('send_direct_checkout')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_request_for_checkouts', function (Blueprint $table) {
            //
            $table->dropColumn('send_direct_checkout');
        });
    }
}
