<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDcIdColumnOnRiderDefaulterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('defaulter_riders', function (Blueprint $table) {
            $table->unsignedInteger('dc_id')->nullable()->after('defaulter_details');
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
            $table->dropColumn('dc_id');
        });
    }
}
