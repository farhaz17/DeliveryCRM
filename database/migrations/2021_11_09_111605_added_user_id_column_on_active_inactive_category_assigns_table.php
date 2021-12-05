<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddedUserIdColumnOnActiveInactiveCategoryAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('active_inactive_category_assigns', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('passport_id');
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
            $table->dropColumn('user_id');
        });
    }
}
