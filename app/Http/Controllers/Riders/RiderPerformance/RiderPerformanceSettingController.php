<?php

namespace App\Http\Controllers\Riders\RiderPerformance;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Validator;
use App\Model\Riders\RiderPerformance\RiderPerformanceSetting;

class RiderPerformanceSettingController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin', ['only' => [
            'create_rider_performance_settings',
            'ajax_load_selected_platform_columns',
            'ajax_rider_performance_platform_columns_setting',
            'ajax_profitablity_indicator_wise_setting_inputs',
            'store_rider_performance_settings',
            'generate_rider_performances_form',
            'load_selected_performance_setting_details',
            'rider_performances_generate',
        ]]);
        $this->middleware('role_or_permission:Admin|manager_dc|DC_roll', ['only' => [
            'rider_performance_report_generate_create',
            'rider_performance_report_generate_details',
            'rider_performance_report_generate_load',
        ]]);
    }
    public function create_rider_performance_settings()
    {
        $platforms = config('rider_performance_config');
        return view('admin-panel.riders.rider_performances.rider_performance_settings', compact('platforms'));
    }
    public function ajax_load_selected_platform_columns(Request $request)
    {
        if($request->ajax()){
            $platform_columns = config('rider_performance_config');
            $selected_platform =  $platform_columns->where('platform_id', $request->platform_id)->first();
            $view = view('admin-panel.riders.rider_performances.shared_blades.selected_platform_columns', compact('selected_platform'))->render();
            return response([
                'html' => $view
            ]);
        }
    }
    public function ajax_rider_performance_platform_columns_setting(Request $request)
    {
        if($request->ajax()){
            $platform_columns = config('rider_performance_config');
            $columns = collect($platform_columns
                    ->where('platform_id', $request->selected_platform_id)
                    ->first()['columns'])
                    ->filter(function($column){
                        return in_array($column['name'], request('columns'));
                    });
            $view = view('admin-panel.riders.rider_performances.shared_blades.ajax_rider_performance_platform_columns_setting', compact('columns'))->render();
            return response([
                'html' => $view
            ]);
        }
    }
    public function ajax_profitablity_indicator_wise_setting_inputs(Request $request)
    {
        if($request->ajax()){
            $profitablity_indicator =  request('profitablity_indicator');
            $column_name =  request('column_name');
            $view = view('admin-panel.riders.rider_performances.shared_blades.ajax_profitablity_indicator_wise_setting_inputs', compact('profitablity_indicator','column_name'))->render();
            return response([
                'html' => $view
            ]);
        }
    }
    public function store_rider_performance_settings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'setting_name' => 'required',
            'column_settings' => 'required|array',
            'platform_id' => 'required',
            'setting_description' => 'required',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }
        $rider_performance_settings = RiderPerformanceSetting::create([
            'setting_name' => $request->setting_name,
            'platform_id' => $request->platform_id,
            'column_settings' => $request->column_settings,
            'setting_description' => $request->setting_description,
            'performance_model' => $request->performance_model,
            'date_column_name' => $request->date_column_name
        ]);
        $message = [
            'message' => "Rider Performance Settings Registered" ,
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }
    public function rider_performance_report_generate_create(Request $request)
    {
        $performance_settings = RiderPerformanceSetting::whereStatus(1)->get()->filter(function($performance_setting){
            if(!auth()->user()->hasRole(['DC_roll'])){
                return true;
            }else{
                return in_array($performance_setting->platform_id, auth()->user()->user_platform_id);
            }
        });
        return view('admin-panel.riders.rider_performances.rider_performance_report_generate', compact('performance_settings'));
    }
    public function rider_performance_report_generate_details(Request $request)
    {
        if($request->ajax()){

            $performance_setting = RiderPerformanceSetting::find($request->rider_performance_settings_id);
            $column_settings = view('admin-panel.riders.rider_performances.shared_blades.rider_performance_report_generate_details', compact('performance_setting'))->render();
            $config = config('rider_performance_config')->where('platform_id', $performance_setting->platform_id)->first();
            $rider_performances = $performance_setting->performance_model::distinct($performance_setting->date_column_name)->latest()->groupBy($performance_setting->date_column_name)->get(['id', $performance_setting->date_column_name]);
            $performance_dropdowns = view('admin-panel.riders.rider_performances.shared_blades.rider_performance_report_generate_dropdowns', compact('rider_performances'))->render();

            return response([
                'column_settings' => $column_settings,
                'performance_dropdowns' => $performance_dropdowns
            ]);
        }else{
            return redirect()->back();
        }
    }
    public function rider_performance_report_generate_load(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rider_performance_settings_id' => 'required',
            'columns' => 'required|array',
            'start_date' => 'required',
            'end_date' => 'required',
        ],
            $messages = [
                'rider_performance_settings_id.required' => "Please select performance settings",
                'performance_id.required' => "Please select performance date",
            ]
        );
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return response([
                'performance_table' => '',
                'message' => $validate->first(),
                'alert-type' => 'error',
                'status' => '500'
            ]);
        }
        $performance_setting = RiderPerformanceSetting::find($request->rider_performance_settings_id);

        $all_dc_riders = AssignToDc::latest()->get();

        $dc_rider_passport_ids = collect();
        if(auth()->user()->hasRole(['DC_roll'])) {
            $dc_rider_passport_ids = $all_dc_riders->where('user_id', auth()->id())
            ->unique('rider_passport_id')
            ->pluck('rider_passport_id')->toArray();
        }
        $selected_date_wise_performances = $performance_setting->performance_model::with(['passport.personal_info'])
        ->whereBetween($performance_setting->date_column_name, [$request->start_date, $request->end_date])
        ->get()
        ->filter(function($performances) use($dc_rider_passport_ids){
            if(auth()->user()->hasRole(['DC_roll'])){
                return in_array($performances->passport_id, $dc_rider_passport_ids);
            }else{
                return true;
            }
        });

        $performance_table = view('admin-panel.riders.rider_performances.shared_blades.performance_table', compact('performance_setting','selected_date_wise_performances'))->render();
        return response([
            'performance_table' => $performance_table,
            'message' => "Performance Report Loaded",
            'alert-type' => 'success',
            'status' => '200'
        ]);
    }
}
