<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmployeeTypeToCareers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->integer('employee_type')->default(null)->after('source_type')->comment('1 = company,2=four pl');
            $table->integer('four_pl_name_id')->default(null)->after('employee_type');
            $table->integer('vendor_fourpl_pk_id')->default(null)->after('four_pl_name_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('careers', function (Blueprint $table) {
            $table->dropColumn([
                'employee_type',
                'four_pl_name_id',
                'vendor_fourpl_pk_id'
            ]);
        });
    }
}
