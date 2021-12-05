<?php

namespace App\Model\OnBoardStatus;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OnBoardStatusForm extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
