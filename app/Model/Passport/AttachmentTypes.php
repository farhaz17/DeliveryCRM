<?php

namespace App\Model\Passport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AttachmentTypes extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
