<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LabourCardType extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "labour_card_types";
    protected $fillable = ['name'];
}
