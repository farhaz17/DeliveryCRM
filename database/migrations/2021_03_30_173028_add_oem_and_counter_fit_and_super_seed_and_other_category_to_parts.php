<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOemAndCounterFitAndSuperSeedAndOtherCategoryToParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parts', function (Blueprint $table) {
            //
            $table->string('oem')->nullable()->after('part_number');
            $table->string('counter_fit')->nullable()->after('oem');
            $table->string('super_seed')->nullable()->after('counter_fit');
            $table->string('other')->nullable()->after('super_seed');
            $table->string('category')->nullable()->after('other');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parts', function (Blueprint $table) {
            //
        });
    }
}
