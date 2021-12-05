<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ActiveInactiveCategoryMain extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['name'];
    public function active_inactive_subcategories(){
        return $this->hasMany(ActiveInactiveSubCategory::class,'main_category');
    }
}
