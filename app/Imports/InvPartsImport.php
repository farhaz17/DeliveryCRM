<?php

namespace App\Imports;

use App\Model\InvParts;
use App\Model\Parts;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InvPartsImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data_partnumber=$this->checkExistData($this->getPartNumberId($row['part_number']));

//        dd($data_partnumber);
//        $part_number_array=array();
//        $part_quantity_array=array();
//        $part_quantity_balance_array=array();
//        $part_amount_array=array();

        if($data_partnumber == ""){

//            dd($row['part_number']);
            $part_number_array=$row['part_number'];
            $part_quantity_array=$row['quantity'];
            $part_quantity_balance_array=$row['quantity'];
            $part_amount_array=$row['amount'];
//            dd($this->getPartNumberId($part_number_array));
            return new InvParts([

//                dd($part_quantity_array),
                'parts_id'  => $this->getPartNumberId($part_number_array),
                'quantity'  => $part_quantity_array,
                'quantity_balance'  => $part_quantity_balance_array,
                'price'  => $part_amount_array,
            ]);
        }
        else{

            $quantitySet=$this->getQuantityBalance($data_partnumber);
            $current_quantity=0;
            $current_quantity_balance=0;


            $part_quantity=$row['quantity'];
            $part_amount=$row['amount'];



            foreach ($quantitySet as $item) {
                $current_quantity+=$item->quantity ;
                $current_quantity_balance+=$item->quantity_balance ;
            }

            $actual_quantity_balance = $part_quantity + $current_quantity_balance;
            $actual_quantity = $part_quantity+ $current_quantity ;

            $obj = InvParts::find($data_partnumber);
            $obj->parts_id=$data_partnumber;
//            $obj->part_add_name=$request->input('part_add_name');
            $obj->quantity=$actual_quantity;
            $obj->quantity_balance=$actual_quantity_balance;
            $obj->price=$part_amount;
            $obj->save();

//            $message = [
//                'message' => 'Inventory Parts Updated Successfully',
//                'alert-type' => 'success'
//
//            ];
//            return redirect()->route('inv_parts')->with($message);
        }

//        return new InvParts([
//            'parts_id'  => $this->getPartNumberId($part_number_array),
//            'quantity'  => $part_quantity_array,
//            'quantity_balance'  => $part_quantity_balance_array,
//            'price'  => $part_amount_array,
//        ]);
    }

    public function getPartNumberId($part_number){
        $part_id = DB::table('parts')->where('part_number', $part_number)->first();
//        dd($part_id);
        return optional($part_id)->id;
    }

    public function checkExistData($part_number){

        $query=InvParts::where('parts_id', $part_number)->get()->first();

        $part_id= isset($query->id)?$query->id:"";
        return $part_id;


    }

    public function getQuantityBalance($id){
        $quantity_bal = DB::table('inv_parts')->where('id', $id)->get(['quantity','quantity_balance']);
        return $quantity_bal;
    }
}
