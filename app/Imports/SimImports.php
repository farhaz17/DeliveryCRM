<?php

namespace App\Imports;

use App\Model\Telecome;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class SimImports implements ToModel,WithHeadingRow
{

    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['account_number'])));
        if($data_partnumber == ""){
            $account_number_array=trim($row['account_number']);
            $party_id_array=$row['party_id'];
            $product_type_array=$row['product_type'];
            $network_array=$row['network'];

            return new \App\Model\SimImports([
                'account_number'  => $account_number_array,
                'party_id'  => $party_id_array,
                'product_type'  => $product_type_array,
                'network'  => $network_array,
            ]);
        }
        else{

            $account_number=trim($row['account_number']);
            $party_id=$row['party_id'];
            $product_type=$row['product_type'];
            $network=$row['network'];
            $obj = \App\Model\SimImports::find($data_partnumber);

            $obj->account_number=  $account_number;
            $obj->party_id=$party_id;
            $obj->product_type=$product_type;
            $obj->network=$network;

//dd($obj);

            $obj->save();


        }


    }

    public function getPartNumberId($account_number){

        $account_id = DB::table('sim_imports')->where('account_number', $account_number)->first();

        return optional($account_id)->id;
    }

    public function checkExistData($account_number){

        $query=\App\Model\SimImports::where('id', $account_number)->get()->first();

        $account_id= isset($query->id)?$query->id:"";
        return $account_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}
