<?php

namespace App\Model\Master\Company;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LabourCard extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $table = 'master_labour_cards';
    public function company()
    {
        return $this->belongsTo('App\Model\Seeder\Company');
    }
}
