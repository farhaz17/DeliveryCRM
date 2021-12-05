<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusToSalikTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salik_tags', function (Blueprint $table) {
            $table->bigInteger('status')->after('tag_no')->comment('1=Free, 2=Installed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salik_tags', function (Blueprint $table) {
            //
        });
    }
}
