<?php

namespace App\Model\SalarySheet;

use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TalabatSalarySheet extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "talabat_salary_sheets";
    //
    protected $fillable=['rider_id',
        'rider_name',
        'vendor',
        'city',
        'deliveries',
        'hours',
        'pay_hour',
        'pay_deliveries',
        'pay_per_hour_payment',
        'pay_per_order_payment',
        'total_pay',
        'zomato_tip',
        'talabat_tip',
        'total_tip',
        'incetive',
        'total_payment',
        'date_from',
        'date_to',
        'file_path',
        'sheet_id'
    ];

    public function salary_path(){
        return $this->hasMany(SalarySheetPath::class, 'file_path', 'id');
    }




}
