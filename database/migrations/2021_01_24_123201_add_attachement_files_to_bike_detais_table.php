<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttachementFilesToBikeDetaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->string('attachment_reg_front')->nullable();
            $table->string('attachment_reg_back')->nullable();
            $table->string('attachment_insurance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->dropColumn('attachment_reg_front','attachment_reg_back','attachment_insurance');
        });
    }
}
