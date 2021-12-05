<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('license_type')->nullable();
            $table->string('license_for')->nullable();
            $table->integer('license_category')->nullable();
            $table->integer('rent_for')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('uuns')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('dcci')->nullable();
            $table->json('member_ids')->nullable();
            $table->json('member_role')->nullable();
            $table->json('member_no')->nullable();
            $table->json('member_share')->nullable();
            $table->json('partner_ids')->nullable();
            $table->json('partner_no')->nullable();
            $table->json('partner_share')->nullable();
            $table->json('license_activity')->nullable();
            $table->string('tax')->nullable();
            $table->string('state_id')->nullable();
            $table->string('license_attachment')->nullable();
            $table->string('tax_attachment')->nullable();
            $table->string('contract_attachment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['license_type','license_for','license_category','rent_for','trade_license_no','issue_date','expiry_date','uuns','registration_no','dcci','member_ids','member_role','member_no','member_share','partner_ids','partner_no','partner_share','license_activity','tax','state_id','license_attachment','tax_attachment','contract_attachment']);
        });
    }
}
