<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssingPlatformIdToDcRequestForCheckouts extends Migration
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
            $table->integer('assigned_platform_id')->after('checkout_type');
            $table->text('remarks')->change()->nullable();

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
            $table->dropColumn('assigned_platform_id');
            $table->dropColumn('remarks');
        });
    }
}
