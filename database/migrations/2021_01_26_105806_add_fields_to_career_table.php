<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCareerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->string('belong_city_name')->nullable();
            $table->integer('passport_status')->nullable();
            $table->integer('pak_licence_status')->nullable();
            $table->integer('source_type')->nullable()->comment('1 = data from app, 2 = data form call, 3 = data walking candidate');
            $table->bigInteger('user_id')->nullable();
            $table->string('social_media_id_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn(['belong_city_name','passport_status','pak_licence_status','source_type','user_id','social_media_id_name']);
        });
    }
}
