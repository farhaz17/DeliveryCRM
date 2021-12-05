<?php

namespace App\Http\Controllers\TalabatCod;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TalabatCodDeductionFilePath;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Imports\TalabatCodDeductionImport;
use App\Model\TalabatCod\TalabatCodDeduction;

class TablabatCodDeductionController extends Controller
{
    function __construct(){
        $this->middleware('role_or_permission:Admin|DC_roll|talabat_cod|Cod', [
            'only' => [
                'talabat_cod_deduction'
            ]]);
    }
    public function talabat_cod_deduction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        if($request->upload_or_delete == "delete"){
            $start_date = $request->start_date;

            $cod_exits = TalabatCodDeduction::where('start_date', $start_date)->delete();

            if($cod_exits){
                $file_exists = TalabatCodDeductionFilePath::whereDate('upload_start_date', $request->start_date )->first();
                $file_exists->file_path ? Storage::disk('s3')->delete($file_exists->file_path) : "";
                $message = [
                    'message' => "Cod on " . $start_date . " deleted successfully.",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }else{
                $message = [
                    'message' => "Cod deduction not found on " . $start_date,
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
        }elseif($request->upload_or_delete == "upload"){
            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx',
                'start_date' => 'unique:talabat_cod_deductions,start_date',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
            $is_already = TalabatCodDeduction::whereDate('start_date',$request->start_date )->first();
            if($is_already){
                $message = [
                    'message' => 'For this Date Range is Already Uploaded',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }
            $rows_to_be_updated = head(Excel::toArray(new \App\Imports\TalabatCodDeductionImport($request->start_date,$request->end_date), request()->file('select_file')));
            unset($rows_to_be_updated[0]);
            $missing_rider_names = [];
            $missing_rider_ids = [];
            $missing_cities = [];
            // dd($rows_to_be_updated );
            foreach($rows_to_be_updated as $key => $row){
                if($row[0] != "Total" && trim($row[4]) != "" ){
                $riderid_exists  = PlatformCode::whereIn('platform_id',[15,34,41])->wherePlatformCode($row[4])->first();
                    if(!$riderid_exists){
                        $missing_rider_names[] = $row[3];
                        $missing_rider_ids[] = $row[4];
                        $missing_cities[] = $row[1];
                    }
                }
            }
            if(count($missing_rider_ids) > 0){
                $message = [
                    'message' => "Talabat Excel Upload failed",
                    'alert-type' => 'error',
                    'missing_rider_ids' => implode(',' , $missing_rider_ids),
                    'missing_cities' => implode(',' , $missing_cities),
                    'missing_rider_names' => implode(',' , $missing_rider_names)
                ];
                return redirect()->back()->with($message);
            }else{
                Excel::import(new TalabatCodDeductionImport($request->start_date,$request->start_date), request()->file('select_file'));
                if (!file_exists('../public/assets/upload/excel_file/talabat_cod_deduction')) {
                    mkdir('../public/assets/upload/excel_file/talabat_cod_deduction', 0777, true);
                }
                if(!empty($_FILES['select_file']['name'])) {
                    $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                    $file_path_image = 'assets/upload/talabat_cod_deduction/' . date("Y-m-d") . '/';
                    $fileName = $file_path_image . time().'.'.$request->select_file->extension();
                    Storage::disk('s3')->put($fileName, file_get_contents($request->select_file));
                    $excel_path = new TalabatCodDeductionFilePath();
                    $excel_path->upload_start_date = $request->start_date;
                    $excel_path->file_path = $fileName;
                    $excel_path->save();
                }
                $message = [
                    'message' => 'Uploaded Successfully',
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }
        }else{
            $message = [
                'message' => 'Operation failed',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
    }
}
