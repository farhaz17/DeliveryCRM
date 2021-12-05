<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveExtraColumnsFromCustomerSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_suppliers', function (Blueprint $table) {
            $table->dropColumn([
                'customer_supplier_category_id',
                'customer_supplier_sub_category_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_suppliers', function (Blueprint $table) {
           //
        });
    }
}
