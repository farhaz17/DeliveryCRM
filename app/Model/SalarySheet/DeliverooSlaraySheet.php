<?php

namespace App\Model\SalarySheet;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DeliverooSlaraySheet extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "deliveroo_slaray_sheets";
    //
    protected $fillable=[
        'rider_id',
        'rider_name',
        'agency',
        'city',
        'pay_group',
        'email_address',
        'total_orders_delivered',
        'stacked_orders_delivered',
        'hours_worked_within_schedule',
        'rider_drop_fees',
        'rider_guarantee',
        'tips',
        'non_order_related_work_1',
        'past_queries_adjustment_1',
        'bonus',
        'surge',
        'fuel',
        'rider_training_fees',
        'total_rider_earnings',//(Not Incl Tips)
        'agency_drop_fees',
        'agency_guarantees',
        'rider_insurance',
        'non_order_related_work_2',
        'past_queries_adjustment_2',
        'agency_training_fees',
        'past_queries_adjustment',
        'early_departure_fee',
        'rider_kit',
        'phone_installments',
        'excessive_sim_plan_usage',
        'salik_charges',// (Deliveroo Provided Bikes)
        'bike_insurance',// (Deliveroo Provided Bikes)
        'traffic_fines',// (Deliveroo Provided Bikes)
        'bike_repair_charges',// (Deliveroo Provided Bikes)
        'total_agency_earnings',
        'rider_earnings',
        'rider_tips',
        'agency_earnings',
        'total',
        'date_from',
        'date_to',
        'file_path',
        'sheet_id'

    ];




}
