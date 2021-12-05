<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPlatcategoryToFineUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fine_uploads', function (Blueprint $table) {
            $table->string('plate_cateogry');
            $table->string('plate_code');
            $table->string('license_number')->nullable();
            $table->string('license_from')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fine_uploads', function (Blueprint $table) {
            //
        });
    }
}
