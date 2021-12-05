<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eid_registration extends Model  implements Auditable
{   
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    protected $fillable=['id_number','name','nationality','date_of_birth','card_number','expiry_date','receipt_no',
        'app_no','registered_mob_no','emirates_id','residency_no','uid_no'];

}
