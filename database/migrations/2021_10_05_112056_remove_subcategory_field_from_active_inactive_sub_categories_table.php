<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveSubcategoryFieldFromActiveInactiveSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('active_inactive_sub_categories', function (Blueprint $table) {
            $table->dropColumn('sub_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('active_inactive_sub_categories', function (Blueprint $table) {
            $table->string('sub_category')->nullable()->after('main_category');
        });
    }
}
