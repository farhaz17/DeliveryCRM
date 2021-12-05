<?php

namespace App\Model\CodUpload;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ExcelFilePath extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
