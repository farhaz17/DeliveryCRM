<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_supplier_category_id');
            $table->bigInteger('customer_supplier_sub_category_id');

            // Zone Group Information
            $table->integer('contact_type'); // Customer Or Supplier Or Both
            $table->text('zone_company_id');
            $table->integer('state_id');

             // Customer Supplier 
             $table->string('contact_name');
             $table->string('contact_licence_no');
             $table->string('contact_trn');
             $table->string('contact_whats_app_no');
             $table->string('contact_telephone_no');
             $table->string('contact_mobile_no');
             $table->string('contact_website');
             $table->string('contact_address');

             $table->integer('contact_category_id');
             $table->integer('contact_sub_category_id');
             $table->integer('status');
             $table->string('remarks')->nullable();

            // Transaction Details
            $table->integer('payment_mode');
            $table->integer('payment_term');
            $table->integer('payment_term_days')->nullable();
            $table->integer('invoicing_days')->nullable();

            // Customer Supplier attachments
            $table->string('license_attachment')->nullable();
            $table->string('vat_attachment')->nullable();
            $table->string('contract_attachment')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('customer_suppliers');
    }
}
