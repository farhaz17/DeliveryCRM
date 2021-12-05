<?php

namespace App\Imports;

use DateTime;
use Throwable;
use App\Model\BikeDetail;
use App\Model\BikeImports;
use App\Model\BikeDetailHistory;
use Illuminate\Support\Facades\DB;
use App\Model\Master\Company\Traffic;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\Master\Vehicle\VehicleMake;
use App\Model\Master\Vehicle\VehicleYear;
use App\Model\Master\Vehicle\VehicleModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use App\Model\Master\Vehicle\VehicleCategory;
use App\Model\Master\Vehicle\VehicleMortgage;
use App\Model\Master\Vehicle\VehicleInsurance;
use App\Model\Master\Vehicle\VehiclePlateCode;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Model\Master\Vehicle\VehicleSubCategory;

class BikesImport implements ToModel,WithHeadingRow
{
    use Importable, SkipsErrors;
    public function model(array $row){

        // DB::beginTransaction();
        // try {
            $traffic_exist = Traffic::whereTrafficFileNo($row['traffic_file'])->first();
            if(empty($traffic_exist) || empty(trim($row['chassis_no']))) return;
            $bike_exist = BikeDetail::whereChassisNo(trim($row['chassis_no']))->first();
            if(empty($bike_exist)){
                $excel_date = $row['expiry_date']; //here is that value 41621 or 41631
                $unix_date = ($excel_date - 25569) * 86400;
                $excel_date = 25569 + ($unix_date / 86400);
                $unix_date = ($excel_date - 25569) * 86400;

                $excel_date2 = $row['issue_date'];; //here is that value 41621 or 41631
                $unix_date2 = ($excel_date2 - 25569) * 86400;
                $excel_date2 = 25569 + ($unix_date2 / 86400);
                $unix_date2 = ($excel_date2 - 25569) * 86400;

                $excel_date3 = $row['insurance_issue_date'];; //here is that value 41621 or 41631
                $unix_date3 = ($excel_date3 - 25569) * 86400;
                $excel_date3 = 25569 + ($unix_date3 / 86400);
                $unix_date3 = ($excel_date3 - 25569) * 86400;

                $excel_date4 = $row['insurance_expiry_date'];; //here is that value 41621 or 41631
                $unix_date4 = ($excel_date4 - 25569) * 86400;
                $excel_date4 = 25569 + ($unix_date4 / 86400);
                $unix_date4 = ($excel_date4 - 25569) * 86400;

                $plate_code = null;
                if(!empty(trim($row['plate_code']))){
                    $plate_code_exist = VehiclePlateCode::where('plate_code',trim($row['plate_code']))->first();
                    $plate_code = isset($plate_code_exist) ? $plate_code_exist->id : VehiclePlateCode::create(['plate_code' => trim($row['plate_code'])])->id;
                }

                $make_year = null;
                if(!empty($row['make_year'])){
                    $make_year_exist = VehicleYear::where('year',$row['make_year'])->first();
                    $make_year = isset($make_year_exist) ? $make_year_exist->id : VehicleYear::create(['year' => $row['make_year']])->id;
                }
                $make_id = null;
                if(!empty($row['make'])){
                    $make_exist = VehicleMake::whereName($row['make'])->first();
                    $make_id = isset($make_exist) ? $make_exist->id : VehicleMake::create(['name' => $row['make']])->id;
                }
                $model = null;
                if(!empty($row['model'])){
                    $model_exist = VehicleModel::whereName($row['model'])->first();
                    $model = isset($model_exist) ? $model_exist->id : VehicleModel::create(['name' => $row['model']])->id;
                }
                $chassis_no = trim($row['chassis_no']);
                $mortgaged_by = null;
                if(!empty($row['mortgaged_by'])){
                    $mortgage_exist = VehicleMortgage::whereName($row['mortgaged_by'])->first();
                    $mortgaged_by = $mortgage_exist ? $mortgage_exist->id : VehicleMortgage::create(['name' => $row['mortgaged_by']])->id;
                }
                $insurance_co = null;
                if(!empty($row['insurance_co'])){
                    $insurance_co = VehicleInsurance::firstOrCreate(['name' => $row['insurance_co']],['name' => $row['insurance_co'], 'type' => 3])->id;
                }
                $expiry_date= $unix_date;

                $issue_date= $unix_date2;

                $traffic_file = $traffic_exist->id;

                $category_type = $vehicle_sub_category_id = null;
                if(!empty($row['vehicle_main_category'])){
                    $category_type = VehicleCategory::firstOrCreate(['name' => $row['vehicle_main_category']])->id;
                    if(!empty($row['vehicle_sub_category'])){
                        $vehicle_sub_category_id = VehicleSubCategory::firstOrCreate(['name' => $row['vehicle_sub_category']],['vehicle_category_id' => $category_type])->id;
                    }
                }
                $engine_no = trim($row['engine_no']);
                $seat = trim($row['seat']);
                $color = trim($row['color']);
                $insurance_no = trim($row['insurance_no']);
                $insurance_issue_date = $unix_date3;
                $insurance_expiry_date = $unix_date4;
                $vehicle_mortgage_no = trim($row['vehicle_mortgage_no']);

                return $new_bike = BikeDetail::create([
                    'plate_no' => trim($row['plate_no']),
                    'plate_code'  => $plate_code,
                    'make_year'  => $make_year,
                    'make_id'  => $make_id,
                    'model'  => $model,
                    'chassis_no'  => $chassis_no,
                    'mortgaged_by'  => $mortgaged_by,
                    'insurance_co'  =>$insurance_co,
                    'expiry_date'  => gmdate("Y-m-d", $unix_date),
                    'issue_date'  => gmdate("Y-m-d", $unix_date2),
                    'traffic_file'  => $traffic_exist->id,
                    'category_type'  => $category_type,
                    'vehicle_sub_category_id'  => $vehicle_sub_category_id,
                    'engine_no'  => $engine_no,
                    'seat' =>  $seat,
                    'color' => $color,
                    'insurance_no' => $insurance_no,
                    'insurance_issue_date' => gmdate("Y-m-d", $insurance_issue_date),
                    'insurance_expiry_date' => gmdate("Y-m-d", $insurance_expiry_date),
                    'vehicle_mortgage_no' => $vehicle_mortgage_no,
                ]);
            }else{

                $excel_date = $row['expiry_date'];; //here is that value 41621 or 41631
                $unix_date = ($excel_date - 25569) * 86400;
                $excel_date = 25569 + ($unix_date / 86400);
                $unix_date = ($excel_date - 25569) * 86400;

                $excel_date2 = $row['issue_date'];; //here is that value 41621 or 41631
                $unix_date2 = ($excel_date2 - 25569) * 86400;
                $excel_date2 = 25569 + ($unix_date2 / 86400);
                $unix_date2 = ($excel_date2 - 25569) * 86400;

                $excel_date3 = $row['insurance_issue_date'];; //here is that value 41621 or 41631
                $unix_date3 = ($excel_date3 - 25569) * 86400;
                $excel_date3 = 25569 + ($unix_date3 / 86400);
                $unix_date3 = ($excel_date3 - 25569) * 86400;

                $excel_date4 = $row['insurance_expiry_date'];; //here is that value 41621 or 41631
                $unix_date4 = ($excel_date4 - 25569) * 86400;
                $excel_date4 = 25569 + ($unix_date4 / 86400);
                $unix_date4 = ($excel_date4 - 25569) * 86400;

                $bike_exist->plate_code = trim($row['plate_code']);
                if(!empty($row['plate_code'])){
                    $plate_code_exist = VehiclePlateCode::wherePlateCode($row['plate_code'])->first();
                    $bike_exist->plate_code = isset($plate_code_exist) ? $plate_code_exist->id : VehiclePlateCode::create(['plate_code' => $row['plate_code']])->id;
                }

                if(!empty($row['make_year'])){
                    $make_year_exist = VehicleYear::where('year',$row['make_year'])->first();
                    $bike_exist->make_year = isset($make_year_exist) ? $make_year_exist->id : VehicleYear::create(['year' => $row['make_year']])->id;
                }
                if(!empty($row['make'])){
                    $make_exist = VehicleMake::whereName($row['make'])->first();
                    $bike_exist->make_id = isset($make_exist) ? $make_exist->id : VehicleMake::create(['name' => $row['make']])->id;
                }
                if(!empty($row['model'])){
                    $model_exist = VehicleModel::whereName($row['model'])->first();
                    $bike_exist->model = isset($model_exist) ? $model_exist->id : VehicleModel::create(['name' => $row['model']])->id;
                }
                if(!empty($row['mortgaged_by'])){
                    $mortgage_exist = VehicleMortgage::whereName($row['mortgaged_by'])->first();
                    $bike_exist->mortgaged_by = $mortgage_exist ? $mortgage_exist->id : VehicleMortgage::create(['name' => $row['mortgaged_by']])->id;
                }
                if(!empty($row['insurance_co'])){
                    $insurance_co_exist = VehicleInsurance::whereName($row['insurance_co'])->first();
                    $bike_exist->insurance_co = $insurance_co_exist ? $insurance_co_exist->id : VehicleInsurance::create(['name' => $row['insurance_co'], 'type' => 3])->id;
                }
                $bike_exist->expiry_date= gmdate("Y-m-d", $unix_date);

                $bike_exist->issue_date= gmdate("Y-m-d", $unix_date2);

                $bike_exist->traffic_file = $traffic_exist->id;


                if(!empty($row['vehicle_main_category'])){
                    $category_type_exist = VehicleCategory::whereName($row['vehicle_main_category'])->first();
                    $bike_exist->category_type = $category_type_exist ? $category_type_exist->id : VehicleCategory::create(['name' => $row['vehicle_main_category']])->id;
                    if(!empty($row['vehicle_sub_category'])){
                        $category_type_exist = VehicleSubCategory::whereName($row['vehicle_sub_category'])->first();
                        $bike_exist->vehicle_sub_category_id = $category_type_exist ? $category_type_exist->id : VehicleSubCategory::create(['vehicle_category_id' => $bike_exist->category_type ,'name' => $row['vehicle_sub_category']])->id;
                    }
                }

                $bike_exist->engine_no = trim($row['engine_no']);
                $bike_exist->seat = trim($row['seat']);
                $bike_exist->color = trim($row['color']);
                $bike_exist->insurance_no = trim($row['insurance_no']);
                $bike_exist->insurance_issue_date = gmdate("Y-m-d", $unix_date3);
                $bike_exist->insurance_expiry_date = gmdate("Y-m-d", $unix_date4);
                $bike_exist->vehicle_mortgage_no = trim($row['vehicle_mortgage_no']);
                $bike_exist->update();
            }
            // DB::commit();
        // } catch (\Throwable $e) {
        //     DB::rollback();
        //     $message = $e->getMessage();
        //     return redirect()->back()->with($message);
        // }
    }
}
