<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMedicalTypeToMedicalNormals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_normals', function (Blueprint $table) {
            //
            $table->integer('medical_type')->after('id')->comment('1 for normal, 2 for 48hours, 3 for 24hours 4 for VIP ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_normals', function (Blueprint $table) {
            //
        });
    }
}
