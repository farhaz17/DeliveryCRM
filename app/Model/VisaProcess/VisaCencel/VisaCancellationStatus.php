<?php

namespace App\Model\VisaProcess\VisaCencel;

use App\Model\Master_steps;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCancellationStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    protected $fillable = ['passport_id','current_status'];

    public function current()
    {
        return $this->belongsTo(Master_steps::class,'current_status');
    }

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
