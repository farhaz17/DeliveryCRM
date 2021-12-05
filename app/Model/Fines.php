<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fines extends Model  implements Auditable
{ 
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable=['traffic_file_no','plate_number','plate_category','plate_code','license_number','license_from','ticket_number','ticket_date','fines_source','ticket_fee','ticket_status','the_terms_of_the_offense
'];
}

