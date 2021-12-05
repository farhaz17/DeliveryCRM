<?php

namespace App\Model\TalabatCod;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\TalabatCod\TalabatCodInternal;

class TalabatCodInternal extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'city_id',
        'upload_by',
        'start_date',
        'end_date',
        'passport_id',
        'courier_name',
        'uploaded_file_path',
        'cash',
        'bank'];
}
