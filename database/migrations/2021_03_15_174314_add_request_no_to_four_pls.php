<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRequestNoToFourPls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('four_pls', function (Blueprint $table) {
            //
            // $table->string('request_no')->nullable();
            // $table->text('address')->nullable();
            // $table->string('company_email_address')->nullable();
            // $table->string('zip_code')->nullable();
            // $table->text('company_address')->nullable();
            // $table->text('bank_name')->nullable();
            // $table->string('benificiary_name')->nullable();
            // $table->string('iban_number')->nullable();
            // $table->string('aurtorized_eid')->nullable();
            // $table->string('passport_expiry')->nullable();
            // $table->string('contatcs_email')->nullable();
            // $table->string('mobile_no')->nullable();
            // $table->string('contacts_telephone_number')->nullable();
            // $table->text('key_accounts_rep')->nullable();
            // $table->text('key_account_email')->nullable();
            // $table->string('key_mobile')->nullable();
            // $table->string('key_telefone')->nullable();
            // $table->string('type_of_business')->nullable();
            // $table->string('company_is')->nullable();
            // $table->string('compnany_est_date')->nullable();
            // $table->text('est_code')->nullable();
            // $table->text('text_id')->nullable();
            // $table->string('trad_license_exp_date')->nullable();
            // $table->integer('legal_structure')->nullable();
            // $table->string('trade_license')->nullable();
            // $table->string('vat_certificate')->nullable();
            // $table->string('owener_passport_copy')->nullable();
            // $table->string('owner_visa_copy')->nullable();
            // $table->string('est_card')->nullable();
            // $table->string('e_signature_card')->nullable();
            // $table->string('company_labour_card')->nullable();
            // $table->string('owener_emirates_id_copy')->nullable();
            // $table->string('other_doc')->nullable();
            // $table->bigInteger('status')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('four_pls', function (Blueprint $table) {

        });
    }
}
