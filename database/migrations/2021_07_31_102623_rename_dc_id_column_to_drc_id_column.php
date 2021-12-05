<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDcIdColumnToDrcIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->renameColumn('dc_id', 'drc_id');
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
            $table->renameColumn('drc_id', 'dc_id');
        });
    }
}
