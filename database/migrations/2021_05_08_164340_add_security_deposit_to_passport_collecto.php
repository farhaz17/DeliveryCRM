<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSecurityDepositToPassportCollecto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passport_delays', function (Blueprint $table) {
            $table->integer('security_deposit_amount')->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passport_delays', function (Blueprint $table) {
            $table->dropColumn('security_deposit_amount');
        });
    }
}
