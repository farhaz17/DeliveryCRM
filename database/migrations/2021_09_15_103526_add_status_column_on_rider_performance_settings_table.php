<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusColumnOnRiderPerformanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rider_performance_settings', function (Blueprint $table) {
            $table->boolean('status')->default(1)->comment('same platform setting will be inactive when new setting added');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rider_performance_settings', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
