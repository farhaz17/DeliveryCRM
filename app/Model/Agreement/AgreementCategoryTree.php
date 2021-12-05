<?php

namespace App\Model\Agreement;

use App\Model\Agreement;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Agreement\AgreementCategory;

class AgreementCategoryTree extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "agreement_category_trees";
    protected $fillable = ['sub_id',
        'parent_id'
    ];

    public function childs() {
        return $this->hasMany(AgreementCategoryTree::class,'parent_id','id') ;
////        'App\Menu','parent_id','id'
//         return $this->hasMany('App\Model\Agreement\AgreementCategoryTree','parent_id','id') ;
    }


    public function get_parent_name(){

        return $this->belongsTo(AgreementCategory::class,'sub_id') ;
    }





//    public function nation()
//    {
//        return $this->belongsTo(Nationality::class,'nation_id');
//    }


}
