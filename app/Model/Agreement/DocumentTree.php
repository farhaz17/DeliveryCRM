<?php

namespace App\Model\Agreement;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DocumentTree extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "document_trees";
    protected $fillable = [
        'name',
        'is_mandatory',
        'tree_path',
    ];



}
