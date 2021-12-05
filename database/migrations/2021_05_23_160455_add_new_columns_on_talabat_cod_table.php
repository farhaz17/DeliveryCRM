<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnsOnTalabatCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_cod', function (Blueprint $table) {
            $table->bigInteger('city_id')->nullable();
            $table->string('rider_name')->nullable()->change();
            $table->integer('platform_code')->nullable();
            $table->bigInteger('zone_id')->nullable()->after('city_id');
            $table->string('rider_status')->nullable()->after('platform_code');
            $table->string('vendor')->nullable()->after('rider_status');
            $table->string('previous_day_pending')->nullable()->after('vendor');
            $table->string('current_day_cash_deposit')->nullable()->after('previous_day_pending');
            $table->string('previous_day_balance')->nullable()->after('current_day_cash_deposit');
            $table->string('current_day_adjustment')->nullable()->after('previous_day_balance');
            $table->string('current_day_cod')->nullable()->after('current_day_adjustment');
            $table->string('current_day_balance')->nullable()->after('current_day_cod');
            $table->string('deposit_status')->nullable()->after('current_day_balance');
            $table->integer('days_delayed')->nullable()->after('deposit_status');

            $table->dropColumn([
                // droping unused columns
                'balance_date_amount',
                'date_cod_amount',
                'pending_date_amount',
                'after_pending_date_column_amount',
                'cash',
                'remaining',
                'city',
                'rider_id'
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
        Schema::table('talabat_cod', function (Blueprint $table) {
            $table->dropColumn([
                'zone_id',
                'rider_status',
                'vendor',
                'previous_day_pending',
                'current_day_cash_deposit',
                'previous_day_balance',
                'current_day_adjustment',
                'current_day_cod',
                'current_day_balance',
                'deposit_status',
                'days_delayed',
            ]);
        });
    }
}
