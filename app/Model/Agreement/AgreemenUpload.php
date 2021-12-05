<?php

namespace App\Model\Agreement;

use App\Model\Agreement\DocumentTree;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AgreemenUpload extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "agreement_uploads";
    protected $fillable = [
        'agreement_id',
        'passport_id',
        'passport_id',
        'document_id',
        'image_path',
    ];


    public function doc_name(){

        return $this->belongsTo(DocumentTree::class,'document_id');
    }

}
