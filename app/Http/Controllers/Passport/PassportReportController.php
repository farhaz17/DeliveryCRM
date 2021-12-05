<?php

namespace App\Http\Controllers\Passport;

use App\Model\Offer_letter\Offer_letter;
use App\Model\Passport\Passport;
use App\Model\Seeder\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PassportReportController extends Controller
{

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|verification-request-passport-report', ['only' => ['index','store','destroy','edit','update']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     $not_register_passports = Passport::select('passports.*')
         ->leftjoin('rider_profiles','rider_profiles.passport_id','=','passports.id')
         ->whereNull('rider_profiles.passport_id')
         ->get();

        $register_passports = Passport::select('passports.*')->join('rider_profiles','rider_profiles.passport_id','=','passports.id')
            ->get();

//     $register_passports_bycompany = Passport::select('passports.*')
//         ->join('offer_letters','offer_letters.passport_id','=','passports.id')
//         ->join('rider_profiles','rider_profiles.passport_id','=','passports.id')
//         ->where('offer_letters.company','=',1)
//         ->get();

        $register_passports_without_company = Passport::select('passports.*')
            ->leftjoin('offer_letters','offer_letters.passport_id','=','passports.id')
            ->join('rider_profiles','rider_profiles.passport_id','=','passports.id')
            ->whereNull('offer_letters.passport_id')
            ->get();

        $not_register_passports_without_company = Passport::select('passports.*')
            ->leftjoin('offer_letters','offer_letters.passport_id','=','passports.id')
            ->leftjoin('rider_profiles','rider_profiles.passport_id','=','passports.id')
            ->whereNull('offer_letters.passport_id')
            ->whereNull('rider_profiles.passport_id')
            ->get();

//     dd($not_register_passports_without_company);


     $company_wise_passport = Offer_letter::where('company','=',2)->get();

   $companies_passports = array();

        $companies = Company::all();
      foreach($companies as $company){

         $gamer  = Passport::select('passports.*')
              ->join('offer_letters','offer_letters.passport_id','=','passports.id')
              ->join('rider_profiles','rider_profiles.passport_id','=','passports.id')
              ->where('offer_letters.company','=',$company->id)
              ->get();
          $companies_passports [] = $gamer;

      }


        $companies_passports_alt = array();
        foreach($companies as $company){

            $gamer_alt  = Passport::select('passports.*')
                ->join('offer_letters','offer_letters.passport_id','=','passports.id')
                ->leftjoin('rider_profiles','rider_profiles.passport_id','=','passports.id')
                ->whereNull('rider_profiles.passport_id')
                ->where('offer_letters.company','=',$company->id)
                ->get();
            $companies_passports_alt [] = $gamer_alt;

        }




     return view('admin-panel.passport_report.index',compact( 'companies_passports_alt','companies_passports', 'not_register_passports_without_company', 'not_register_passports','register_passports','companies','register_passports_without_company'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
