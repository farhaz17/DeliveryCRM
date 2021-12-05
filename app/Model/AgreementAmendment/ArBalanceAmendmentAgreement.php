<?php

namespace App\Model\AgreementAmendment;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ArBalanceAmendmentAgreement extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
