<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToAssigningAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assigning_amounts', function (Blueprint $table) {
            $table->integer('pay_status')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('unpaid_status')->nullable();
            $table->integer('pay_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigning_amounts', function (Blueprint $table) {
            $table->dropColumn([
                'pay_status',
                'remarks',
                'unpaid_status',
                'pay_at',
            ]);
        });
    }
}
