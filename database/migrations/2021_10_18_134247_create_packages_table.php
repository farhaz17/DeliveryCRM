<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('package_no');
            $table->string('package_name');
            $table->bigInteger('platform');
            $table->bigInteger('state');
            $table->integer('limitation')->comment('0 for limted, 1 for unlimited');
            $table->double('qty')->nullable();
            $table->double('salary_package')->nullable();
            $table->text('file_attachments')->nullable();
            $table->text('amendment')->nullable()->comment('0 for yes, 1 for no');
            $table->text('amendment_times')->nullable();
            $table->integer('status')->default('0')->comment('0 for active, 1 for deactive');
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
