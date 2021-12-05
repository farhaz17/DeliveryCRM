<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubcategoryIdToPpuidCancels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppuid_cancels', function (Blueprint $table) {
            //
            $table->bigInteger('cancel_cateogry_ppuid_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppuid_cancels', function (Blueprint $table) {
            //
            $table->dropColumn('cancel_cateogry_ppuid_id');
        });
    }
}
