<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('package_id');
            $table->bigInteger('salary_package')->nullable;
            $table->text('signed_file');
            $table->integer('electronic_sign')->nullable()->comments('null for no, 1 for yes');
            $table->integer('ammentment_package')->nullable()->comments('null for Not req, 0 for no, 1 for yes');
            $table->integer('ammentment_package_sign')->nullable()->comments('null for Not req, 0 for no, 1 for yes');
            $table->bigInteger('user_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_assignments');
    }
}
