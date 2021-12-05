<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommonStatusIdOnActiveInactiveCategoryAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('active_inactive_category_assigns', function (Blueprint $table) {
            $table->unsignedBigInteger('common_status_id')->after('sub_category1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('active_inactive_category_assigns', function (Blueprint $table) {
            $table->dropColumn('common_status_id');
        });
    }
}
