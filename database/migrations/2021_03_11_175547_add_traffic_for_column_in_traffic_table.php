<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrafficForColumnInTrafficTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('traffic', function (Blueprint $table) {
            $table->integer('traffic_for')->nullable()->after('company_id')->comment('Traffic no for 1 = zone companies, 2 = Personal, 3 = Customer | Supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('traffic', function (Blueprint $table) {
            $table->dropColumn(['traffic_for']);
        });
    }
}
