<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToPackageAssignments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('package_assignments', function (Blueprint $table) {
            //
            $table->dateTime('checkin_time')->after('salary_package')->nullable();
            $table->dateTime('checkout_time')->after('salary_package')->nullable();
            $table->integer('status')->after('user_id')->default('0')->comment('0 for checkin 1 for checkout');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_assignments', function (Blueprint $table) {
            //
        });
    }
}
