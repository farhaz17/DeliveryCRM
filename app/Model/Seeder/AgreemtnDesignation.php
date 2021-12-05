<?php

namespace App\Model\Seeder;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AgreemtnDesignation extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "agreement_designations";
}
