<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerSupplierSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_supplier_sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_supplier_category_id');
            $table->string('name');
            $table->softDeletes();
            $table->timestamps();
        });
        DB::table('customer_supplier_categories')->insert([
            'name' => 'Rental'
            ]);
        DB::table('customer_supplier_sub_categories')->insert([
            'customer_supplier_category_id' => 1,
            'name' => 'Rental Sub Category 1'
        ]);
        DB::table('customer_supplier_sub_categories')->insert([
            'customer_supplier_category_id' => 1,
            'name' => 'Rental Sub Category 2'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_supplier_sub_categories');
    }
}
