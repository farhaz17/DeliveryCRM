<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSubCategory2FieldFromActiveInactiveCategoryAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('active_inactive_category_assigns', function (Blueprint $table) {
            $table->dropColumn('sub_category2');
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
            $table->string('sub_category2')->nullable();
        });
    }
}
