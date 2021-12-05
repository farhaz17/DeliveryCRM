<?php

namespace App\Model\Career;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class frontdesk_followup extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
