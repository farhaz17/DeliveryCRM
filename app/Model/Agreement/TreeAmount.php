<?php

namespace App\Model\Agreement;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TreeAmount extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "tree_amounts";
    protected $fillable = [
        'tree_path',
        'amount'
    ];
}
