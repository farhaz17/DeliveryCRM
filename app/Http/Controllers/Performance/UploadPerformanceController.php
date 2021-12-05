<?php

namespace App\Http\Controllers\Performance;

use App\Imports\DeliverooPerformanceImport;
use App\Imports\FormsUploadImport;
use App\Model\Performance\DeliverooPerformance;
use App\Model\Performance\DeliverooSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UploadPerformanceController extends Controller
{
    //
    public function import(Request $request)
    {



            $validator = Validator::make($request->all(), [
                'select_file' => 'required|mimes:xls,xlsx'
            ]);
            if ($validator->fails()) {

                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error'
                ];
                return redirect()->route('performance')->with($message);
            } else {


                //getting date ranges
                $from=$request->from;
                $to=$request->to;



                $date_from = Carbon::createFromFormat('Y-m-d', $from);
                $sub_days = 1;
                $date_from = $date_from->subDays($sub_days);
                $res_from=$date_from->format('Y-m-d');




                $date_to = Carbon::createFromFormat('Y-m-d', $to);
                $daysToAdd = 3;
                $date_to = $date_to->addDays($daysToAdd);
                $res_to=$date_to->format('Y-m-d');




                $dilveroo=DeliverooPerformance::where('date_from', '>=', $res_from)
                    ->where('date_to', '<=', $res_to)->first();


                if ($dilveroo==null){
                    Excel::import(new DeliverooPerformanceImport($from,$to), request()->file('select_file'));

                    $message = [
                        'message' => 'Deliveroo Performance Sheet Uploaded Successfully',
                        'alert-type' => 'success'
                    ];

                    return redirect()->route("performance")->with($message);
                }
                else{
                    $message = [
                        'message' => 'Performance Sheet These Dates Already Uploaded',
                        'alert-type' => 'error'
                    ];

                    return redirect()->route("performance")->with($message);
                }






            }
        }
    }
