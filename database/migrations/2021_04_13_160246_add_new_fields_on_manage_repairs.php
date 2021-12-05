<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsOnManageRepairs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manage_repairs', function (Blueprint $table) {
            //
            $table->bigInteger('repair_no')->after('id');
            $table->bigInteger('bike_id')->after('repair_no');
            $table->bigInteger('rider_passport_id')->after('bike_id');
            $table->integer('reason')->after('rider_passport_id')->nullable();
            $table->text('remarks')->after('reason')->nullable();
            $table->bigInteger('advised_by')->after('remarks')->nullable();
            $table->bigInteger('inspected_by')->after('advised_by')->nullable();
            $table->bigInteger('inspection_result')->after('inspected_by')->nullable();
            $table->bigInteger('requested_from')->after('inspection_result')->nullable();
            $table->timestamp('duration')->after('requested_from')->nullable();
            $table->timestamp('company_or_own')->after('duration')->nullable();
            $table->bigInteger('status')->after('company_or_own')->default('0');
        });
    }

    //company_or_own =0means its company bike

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manage_repairs', function (Blueprint $table) {
            //
                $table->dropColumn('chassis_no');
                $table->dropColumn('zds_code');
                $table->dropColumn('name');
                $table->dropColumn('ckm');
                $table->dropColumn('nkm');
                $table->dropColumn('discount');
                $table->dropColumn('company');
        });
    }
}



