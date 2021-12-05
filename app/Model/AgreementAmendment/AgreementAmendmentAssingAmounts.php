<?php

namespace App\Model\AgreementAmendment;

use App\Model\Master_steps;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AgreementAmendmentAssingAmounts extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "agreement_amendment_assing_amounts";

    protected $guarded = [];

    protected $fillable = [ 'amount',
        'master_step_id',
        'passport_id',
        'amendmentagreement_id',
    ];

    public function master()
    {
        return $this->belongsTo(Master_steps::class,'master_step_id');
    }
}
