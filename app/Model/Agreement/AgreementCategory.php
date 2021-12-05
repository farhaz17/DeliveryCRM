<?php

namespace App\Model\Agreement;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Agreement\AgreementCategoryTree;

class AgreementCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "agreement_categories";
    protected $fillable = [
        'name',
        'name_alt'
    ];
    public  function get_sub(){

        return $this->belongsTo(AgreementCategoryTree::class,'sub_id','id') ;
    }


}
