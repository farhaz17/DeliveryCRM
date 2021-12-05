<?php

namespace App\Imports;

use App\User;
use App\Model\Master\FourPl;
use App\Model\FourPl\FourPlUser;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DB;

class VendorImport implements ToCollection, WithHeadingRow
{

    public function headingRow(): int
    {
        return 1;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        DB::beginTransaction();
        try {
            foreach ($rows as $row) {

                $user = User::create([
                    'email'  => $row['email'],
                    'password'  => bcrypt($row['password']),
                    'user_group_id'  => json_encode(["21"]),
                ]);

                FourPlUser::create([
                    'company_name'  => $row['vendor'],
                    'activated'  => 1,
                    'user_id' => $user->id,
                ]);

                FourPl::where('request_no', 'LIKE', '%' . $row['request_no'] . '%')
                            ->update(['user_id' => $user->id, 'submit_status' => 1]);


            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
