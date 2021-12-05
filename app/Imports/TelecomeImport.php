<?php

namespace App\Imports;

use App\Model\Fines;
use App\Model\Telecome;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class TelecomeImport implements ToModel,WithHeadingRow
{

    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

//        $string = 'I am happy today.';
//        $replacement = 'very ';
//
//        echo substr_replace($string, $replacement, 4, 0); // I am very happy today.


        $account_number_array=trim($row['account_number']);
        $firstChar = mb_substr($account_number_array, 0, 1, "UTF-8");
        $zero='0';
        if ($firstChar !='0') {
            $sim = substr_replace($account_number_array, $zero, 0, 0);
        }
        else{
            $sim= $account_number_array=trim($row['account_number']);
        }




        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($sim)));
        if($data_partnumber == ""){
            if ($row['category_types']=="Company"){
                $category_type="1";
            }
            else{
                $category_type="0";
            }
            $account_number_array=$sim;
            $party_id_array=$row['party_id'];
            $product_type_array=$row['product_type'];
            $network_array=$row['network'];

                return new Telecome([
                    'account_number'  => trim($account_number_array),
                    'party_id'  => $party_id_array,
                    'product_type'  => $product_type_array,
                    'network'  => $network_array,
                    'category_types'  => $category_type,
                ]);


        }
        else{

            $account_number=$sim;

            if ($row['category_types']=="Company"){
                $category_type="1";
            }
            else{
                $category_type="0";
            }
//            $firstChar = mb_substr($account_number, 0, 1, "UTF-8");
//            $zero='0';
//
//            if ($firstChar !='0') {
//                $sim = substr_replace($account_number, $zero, 0, 0);
//            }
//            else{
//                $sim= $account_number_array=trim($row['account_number']);
//            }

            $party_id=$row['party_id'];
            $product_type=$row['product_type'];
            $network=$row['network'];
//            dd($account_number);


                $obj = Telecome::find($data_partnumber);

                $obj->account_number = trim($account_number);
                $obj->party_id = $party_id;
                $obj->product_type = $product_type;
                $obj->network = $network;
                $obj->category_types = $category_type;
                $obj->save();
            }
    }

    public function getPartNumberId($account_number){

        $account_id = DB::table('telecomes')->where('account_number', $account_number)->first();

        return optional($account_id)->id;
    }

    public function checkExistData($account_number){

        $query=Telecome::where('id', $account_number)->get()->first();

        $account_id= isset($query->id)?$query->id:"";
        return $account_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}
