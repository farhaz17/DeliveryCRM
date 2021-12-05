<?php

namespace App\Model\ArBalance;

use App\Model\Passport\Passport;
use App\Model\UserCodes\UserCodes;
use Illuminate\Database\Eloquent\Model;
use App\Model\PlatformCode\PlatformCode;
use OwenIt\Auditing\Contracts\Auditable;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ArBalance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "ar_balances";
    protected $fillable=['zds_code','rider_id','name','agreed_amount', 'cash_received','discount','deduction','balance','source_status','passport_id'];

    public function zds_cods(){

        return $this->belongsTo(UserCodes::class,'zds_code','zds_code');
    }

    public function passport_detail(){

        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function transactions(){
        return $this->hasMany(ArBalanceSheet::class,'zds_code','zds_code');
    }

}
