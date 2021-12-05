<?php

namespace App\Imports;

use App\Model\Lpo\LpoVehicleInfo;
use App\Model\Master\Vehicle\VehicleModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LpoVehicleInfoImport implements ToCollection, WithHeadingRow
{
    protected $lpo_id;
    public function __construct($lpo_id)
    {
        $this->lpo_id = $lpo_id;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $model = $row['model'];
            $model = trim($model);
            $model_id = VehicleModel::where('name', 'like', "%$model%")->value('id');
            if($model_id) {
                LpoVehicleInfo::create([
                    'lpo_id'  => $this->lpo_id,
                    'model_id'  => $model_id,
                    'created_user_id'  => Auth::user()->id,
                    'make_year' => $row['make_year'],
                    'chassis_no' => $row['chassis_no'],
                    'engine_no' => $row['engine_no'],
                ]);
            }
            else{
                $obj = new VehicleModel();
                $obj->name = $model;
                $obj->save();

                LpoVehicleInfo::create([
                    'lpo_id'  => $this->lpo_id,
                    'model_id'  => $obj->id,
                    'created_user_id'  => Auth::user()->id,
                    'make_year' => $row['make_year'],
                    'chassis_no' => $row['chassis_no'],
                    'engine_no' => $row['engine_no'],
                ]);
            }

        }
    }
}
