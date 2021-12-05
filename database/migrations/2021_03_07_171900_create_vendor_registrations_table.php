<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_no');
            $table->text('company_name');
            $table->text('address');
            $table->bigInteger('telephone_number');
            $table->string('company_email_address');
            $table->string('company_website');
            $table->string('zip_code');
            $table->text('company_address');
            $table->text('bank_name');
            $table->string('account_number');
            $table->string('benificiary_name');
            $table->string('iban_number');
            $table->string('aurtorized_eid');
            $table->date('passport_expiry');
            $table->string('contatcs_email');
            $table->string('mobile_no');
            $table->string('contacts_telephone_number');
            $table->string('key_accounts_rep');
            $table->string('key_account_email');
            $table->string('key_mobile');
            $table->string('key_telefone');
            $table->string('type_of_business');
            $table->integer('company_is');
            $table->date('compnany_est_date');
            $table->string('est_code');
            $table->string('text_id');
            $table->string('trad_license_exp_date');
            $table->integer('legal_structure');
            $table->string('vat_certificate');
            $table->string('owener_passport_copy');
            $table->string('owner_visa_copy');
            $table->string('est_card');
            $table->string('e_signature_card');
            $table->string('company_labour_card');
            $table->string('owener_emirates_id_copy');
            $table->string('other_doc');
            $table->bigInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_registrations');
    }
}
