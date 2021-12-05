<?php

namespace App\Model\ArBalance;

use App\Model\Platform;
use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SalaryPaymentHistroy extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "salary_payment_histroys";
    protected $fillable=['platform_id_name',
        'platform_id',
        'zds_code',
        'on_board',
        'off_board',
        'name',
        'date_from',
        'date_to',
        'balance_type',
        'amount',
        'status',
        'net_payment',
        'amount_paid',
        'balance',
    ];

    public  function zds_cods(){

        return $this->belongsTo(UserCodes::class,'zds_code','zds_code');
    }

    public  function balance_name(){
        return $this->belongsTo(BalanceTypeHistory::class,'balance_type');
    }
    public  function platform_name(){
        return $this->belongsTo(Platform::class,'platform_id_name');
    }
}


//
//protected $fillable=['platform_id_name',
//    'date_from',
//    'date_to',
//    'platform_id',
//    'zds_code',
//    'name',
//    'prebal',
//    'gross_pay',
//    'add',
//    'penalty_return',
//    'adjustment',
//    'bike_rent',
//    'sim_charge',
//    'salik',
//    'fine',
//    'advance',
//    'fuel',
//    'loss_damage',
//    'cod_penalty',
//    'platform_penalty',
//    'hours_deduction',
//    'loan_deduction',
//    'sim_excess',
//    'others',
//    'cod_deduction',
//    'sub',
//    'net_payment',
//    'amount_paid',
//    'balance',];
//}
