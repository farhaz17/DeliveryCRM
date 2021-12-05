<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class LabourUpload extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['person_code','person_name','job','passport','nationality','labour_card','labour_card_expiry','card_type','class','company_no'];
}
