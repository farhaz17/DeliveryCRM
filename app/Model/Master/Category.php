<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function subcategories(){
        return $this->hasMany(SubCategory::class,'main_category');
    }
}
