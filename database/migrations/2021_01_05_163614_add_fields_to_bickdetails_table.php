<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToBickdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->string('engine_no')->after('category_type')->nullable();
            $table->string('seat')->after('engine_no')->nullable();
            $table->string('color')->after('seat')->nullable();
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
            $table->dropColumn(['engine_no','seat','color']);
        });
    }
}
