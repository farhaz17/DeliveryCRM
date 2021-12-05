<?php

namespace App\Imports;



use App\Model\Fuel;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Throwable;

class FuelImport implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['rid']==""){
            $message = [
                'message' => "Please Upload Correct File",
                'alert-type' => 'error'
            ];
            return redirect()->route('upload_form')->with($message);
        }

        $data_partnumber=$this->checkExistData($this->getPartNumberId(trim($row['rid'])));



        if($data_partnumber == ""){
            $rid_array=trim($row['rid']);

            $vehicl_plate_number_array=$row['vehicle_plate_number'];
            $license_plate_nr_array=$row['license_plate_nr'];
            $sale_end_array=$row['sale_end'];
            $unit_price_array=$row['unit_price'];
            $volume_array=$row['volume'];
            $total_array=$row['total'];
            $product_name_array=$row['product_name'];
            $receipt_nr_array=$row['receipt_nr'];
            $odometer_array=$row['odometer'];
            $id_unit_code_array=$row['id_unit_code'];
            $station_name_array=$row['station_name'];
            $station_code_array=$row['station_code'];
            $fleet_name_array=$row['fleet_name'];
            $p_product_name_array=$row['p_product_name'];
            $group_name_array=$row['group_name'];
            $vehicle_code_array=$row['vehicle_code'];
            $city_code_array=$row['city_code'];
            $cost_center_array=$row['cost_center'];
            $vat_rate_array=$row['vat_rate'];
            $vat_amount_array=$row['vat_amount'];
            $actual_amount_array=$row['actual_amount'];
            return new Fuel([
                'rid'  => $rid_array,
                'vehicle_plate_number'  => $vehicl_plate_number_array,
                'license_plate_nr'  => $license_plate_nr_array,
                'sale_end'  => $sale_end_array,
                'unit_price'  => $unit_price_array,
                'volume'  => $volume_array,
                'total'  => $total_array,
                'product_name'  => $product_name_array,
                'receipt_nr'  => $receipt_nr_array,
                'odometer'  => $odometer_array,
                'id_unit_code'  => $id_unit_code_array,
                'station_name'  => $station_name_array,
                'station_code'  => $station_code_array,
                'fleet_name'  => $fleet_name_array,
                'p_product_name'  => $p_product_name_array,
                'group_name'  => $group_name_array,
                'vehicle_code'  => $vehicle_code_array,
                'city_code'  => $city_code_array,
                'cost_center'  => $cost_center_array,
                'vat_rate'  => $vat_rate_array,
                'vat_amount'  => $vat_amount_array,
                'actual_amount'  => $actual_amount_array,
            ]);
        }
        else{

//            $quantitySet=$this->getQuantityBalance($data_partnumber);
//            $current_quantity=0;
//            $current_quantity_balance=0;



            $rid=trim($row['rid']);
            $vehicl_plate_number=$row['vehicle_plate_number'];
            $license_plate_nr=$row['license_plate_nr'];
            $sale_end=$row['sale_end'];
            $unit_price=$row['unit_price'];
            $volume=$row['volume'];
            $total=$row['total'];
            $product_name=$row['product_name'];
            $receipt_nr=$row['receipt_nr'];
            $odometer=$row['odometer'];
            $id_unit_code=$row['id_unit_code'];
            $station_name=$row['station_name'];
            $station_code=$row['station_code'];
            $fleet_name=$row['fleet_name'];
            $p_product_name=$row['p_product_name'];
            $group_name=$row['group_name'];
            $vehicle_code=$row['vehicle_code'];
            $city_code=$row['city_code'];
            $cost_center=$row['cost_center'];
            $vat_rate=$row['vat_rate'];
            $vat_amount=$row['vat_amount'];
            $actual_amount=$row['actual_amount'];

            $obj = Fuel::find($data_partnumber);

            $obj->rid=$rid;
            $obj->vehicle_plate_number=$vehicl_plate_number;
            $obj->license_plate_nr=$license_plate_nr;
            $obj->sale_end=$sale_end;
            $obj->unit_price=$unit_price;
            $obj->volume=$volume;
            $obj->total=$total;
            $obj->product_name=$product_name;
            $obj->receipt_nr=$receipt_nr;
            $obj->odometer=$odometer;
            $obj->id_unit_code=$id_unit_code;
            $obj->station_name=$station_name;
            $obj->station_code=$station_code;
            $obj->fleet_name=$fleet_name;
            $obj->p_product_name=$p_product_name;
            $obj->group_name=$group_name;
            $obj->vehicle_code=$vehicle_code;
            $obj->city_code=$city_code;
            $obj->cost_center=$cost_center;
            $obj->vat_rate=$vat_rate;
            $obj->vat_amount=$vat_amount;
            $obj->actual_amount=$actual_amount;

//dd($obj);

            $obj->save();

//            $message = [
//                'message' => 'Updated Successfully',
//                'alert-type' => 'success'
//
//            ];
//            return redirect()->route('form_upload')->with($message);
        }


    }

    public function getPartNumberId($rid){

        $trans_id = DB::table('fuels')->where('rid', $rid)->first();
        return optional($trans_id)->id;
    }

    public function checkExistData($rid){

        $query=Fuel::where('id', $rid)->get()->first();

        $trans_id= isset($query->id)?$query->id:"";
        return $trans_id;
    }


    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

}
