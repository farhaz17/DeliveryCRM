<?php

namespace App\Imports;

use App\Model\Parts;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use phpDocumentor\Reflection\Types\Null_;
use Throwable;

class PartsImport implements ToModel,WithHeadingRow,SkipsOnError
{
    use Importable, SkipsErrors;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        $data_partnumber=$this->checkExistData($row['part_number']);
        $part_array=array();
        $part_name_array=array();

        if($data_partnumber == ""){
            $part_array=$row['part_number'];
            $part_name_array=$row['part_name'];
        }

        return new Parts([
            'part_number'  => $part_array,
            'part_name'  => $part_name_array
        ]);
    }

//    public function rules(): array
//    {
//        return [
////
//            'part_number' => Rule::in(['unique:parts,part_number']),
//
//        ];
//    }

//    public function checkExistData($part_number){
//        $part_id = DB::table('parts')->where()->first()->id;
//        return $part_id;
//    }

    public function checkExistData($part_number){

        $query=Parts::where('part_number', $part_number)->get()->first();

        $part_id= isset($query->id)?$query->id:"";
        return $part_id;


    }

    /**
     * @param Throwable $e
     */
    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}
