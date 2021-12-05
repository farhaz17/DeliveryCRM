<?php

namespace App\Imports;

use App\Model\Lpo\LpoSpareInfo;
use App\Model\Parts;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LpoSpareImport implements ToCollection, WithHeadingRow
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
            $model_id = Parts::where('part_name', 'like', "%$model%")->value('id');
            if($model_id) {
                LpoSpareInfo::create([
                    'lpo_id'  => $this->lpo_id,
                    'parts_id'  => $model_id,
                    'created_user_id'  => Auth::user()->id,
                    'quantity' => $row['quantity'],
                ]);
            }
            else{
                $obj = new Parts();
                $obj->part_name = $model;
                $obj->save();

                LpoSpareInfo::create([
                    'lpo_id'  => $this->lpo_id,
                    'parts_id'  => $obj->id,
                    'created_user_id'  => Auth::user()->id,
                    'quantity' => $row['quantity'],
                ]);
            }

        }
    }
}
