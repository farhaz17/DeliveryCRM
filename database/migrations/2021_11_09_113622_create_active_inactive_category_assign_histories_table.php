<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActiveInactiveCategoryAssignHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_inactive_category_assign_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment('updated_by');
            $table->unsignedBigInteger('passport_id');
            $table->unsignedBigInteger('main_category');
            $table->unsignedBigInteger('sub_category1');
            $table->unsignedBigInteger('common_status_id');
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
        Schema::dropIfExists('active_inactive_category_assign_histories');
    }
}
