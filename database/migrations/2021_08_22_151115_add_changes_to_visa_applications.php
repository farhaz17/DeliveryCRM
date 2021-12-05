<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChangesToVisaApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_applications', function (Blueprint $table) {
            //
            $table->string('file_number')->nullable()->change();
            $table->string('uid_number')->nullable()->change();
            $table->integer('data_status')->nullable('1 updated or added via visa_process');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_applications', function (Blueprint $table) {
            //
        });
    }
}
