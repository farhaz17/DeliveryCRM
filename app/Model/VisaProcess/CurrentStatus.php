<?php

namespace App\Model\VisaProcess;


use App\Model\Master_steps;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class CurrentStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "current_status";
    protected $fillable = ['passport_id', 'current_process_id'];


    public function current()
    {
        return $this->belongsTo(Master_steps::class,'current_process_id');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }


}
