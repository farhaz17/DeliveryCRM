<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveTypeToPpuidCancels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ppuid_cancels', function (Blueprint $table) {
            //
            $table->integer('reactive_type')->nullable()->comment('1=company,2=Fourpl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ppuid_cancels', function (Blueprint $table) {
            //
            $table->dropColumn('reactive_type');
        });
    }
}
