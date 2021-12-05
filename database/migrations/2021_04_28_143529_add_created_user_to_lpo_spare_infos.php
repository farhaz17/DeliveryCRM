<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedUserToLpoSpareInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lpo_spare_infos', function (Blueprint $table) {
            $table->integer('created_user_id')->after('quantity_received')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lpo_spare_infos', function (Blueprint $table) {
            $table->dropColumn('created_user_id');
        });
    }
}
