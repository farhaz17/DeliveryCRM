<?php

namespace App\Model\ArBalance;

use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ArBalanceAlready extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "ar_balance_alreadies";
    protected $fillable=['zds_code','rider_id','name','agreed_amount', 'cash_received','discount','deduction','balance'];
    public function zds_cods(){
        return $this->belongsTo(UserCodes::class,'zds_code','zds_code');
    }
}
