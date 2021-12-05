<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckinCheckoutColumnsOnAssignToDcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_to_dcs', function (Blueprint $table) {
            $table->timestamp('checkout')->nullable()->after('user_id');
            $table->timestamp('checkin')->nullable()->after('user_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_to_dcs', function (Blueprint $table) {
            $table->dropColumn([
                'checkin',
                'checkout'
            ]);
        });
    }
}
