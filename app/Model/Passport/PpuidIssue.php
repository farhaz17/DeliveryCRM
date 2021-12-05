<?php

namespace App\Model\Passport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PpuidIssue extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "ppuid_issues";
    protected $fillable = ['name'];

    public function pass()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
    public function issues()
    {
        return $this->belongsTo(PpuidIssue::class,'passport_id');
    }
}
