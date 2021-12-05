<?php

namespace App\Model\VisaProcess\VisaCencel;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReplacementVisaCancel extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "replacement_visa_cancels";
    protected $fillable = ['passport_id', 'replaced_passport_id','stop_and_resume_id','visa_process_id','user_id','remarks','status'];
    public function passport(){
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function replace_passport(){
        return $this->belongsTo(Passport::class,'replaced_passport_id');
    }
}
