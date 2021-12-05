<?php

namespace App\Model\Passport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Ppuid extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "ppuids";
    protected $fillable = ['passport_id', 'ppuid','zds_code','passport_number','rider_name','platform','sim_number',
        'bike_number','visa_status','control_status','msp_status','platform_rider_id'];

    public function pass()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function issues()
    {
        return $this->belongsTo(PpuidIssue::class,'ppuid_issue_id' );
    }
}
