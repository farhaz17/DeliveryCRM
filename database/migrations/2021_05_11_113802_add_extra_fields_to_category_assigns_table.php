<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraFieldsToCategoryAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_assigns', function (Blueprint $table) {
            $table->date('assign_started_at')->after('sub_category2');
            $table->date('assign_ended_at')->nullable()->after('assign_started_at');
            // $table->text('remarks')->nullable()->after('assign_ended_at');
            $table->integer('status')->default(1)->comment('0 = checked out, 1 = not checked out')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_assigns', function (Blueprint $table) {
            $table->dropColumn([
                'assign_started_at',
                'assign_ended_at',
                // 'remarks'
            ]);
        });
    }
}
