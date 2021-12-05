<?php

namespace App\Http\Controllers;

use App\Imports\InvPartsImport;
use App\Imports\PartsImport;
use App\Model\Parts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ImportPartsExcelController extends Controller
{
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'select_file'  => 'required|mimes:xls,xlsx'
        ]);
        if ($validator->fails()) {

            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->route('inv_parts')->with($message);
        }
        else{
            Excel::import(new PartsImport,request()->file('select_file'));

            Excel::import(new InvPartsImport,request()->file('select_file'));

            $message = [
                'message' => 'Parts Uploaded Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->route('inv_parts')->with($message);
        }

    }

}
