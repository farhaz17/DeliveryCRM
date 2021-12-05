<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangeDataToMedical48s extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical48s', function (Blueprint $table) {
            //
            $table->renameColumn('attachment_id', 'other_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical48s', function (Blueprint $table) {
            //
        });
    }
}
