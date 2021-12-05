<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('name' => 'Admin'),
            array('name' => 'Repair'),
            array('name' => 'Ticket'),
            array('name' => 'Rider'), //4
            array('name' => 'Mechanic'),
            array('name' => 'PRO'),
            array('name' => 'Account'),
            array('name' => 'Management'),
            array('name' => 'Performance'),
            array('name' => 'Hiring'),
            array('name' => 'Verification'),
            array('name' => 'Alerts'),
            array('name' => 'Office'),//13
            array('name' => 'Checkin'),
            array('name' => 'Maintenance'),
            array('name' => 'Sim Inventory'),
            array('name' => 'Cod'),
            array('name' => 'Four PL Company'),
            array('name' => 'Four PL Agent'),
            array('name' => 'Passport Manager'),
        );
        \App\Model\UserGroups::truncate();
        DB::table('user_groups')->insert($data);


        //Ticket Problems
        $data = array(
            array('name' => 'Accounts Issues'),
            array('name' => 'Visa Issues'),
            array('name' => 'Bike/Sim Issues'),
            array('name' => 'Operation'),
            array('name' => 'Insurance Issues'),
            array('name' => 'COD Issues'),
            array('name' => 'Hiring'),
        );
        \App\Model\TicketProblem\TicketProblem::truncate();
        DB::table('ticket_problems')->insert($data);


        //department issues
        $data = array(
            array('name' => 'Payment', 'major_dept_id'=>'1','ticket_problem_id'=>'1'),
            array('name' => 'Salary Issue', 'major_dept_id'=>'1','ticket_problem_id'=>'1'),
            array('name' => 'AR Issue'  ,'major_dept_id'=>'1','ticket_problem_id'=>'1'),
            array('name' => 'Advance', 'major_dept_id'=>'1','ticket_problem_id'=>'1'),
            array('name' => 'Vacation/Advance', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Platform Issue', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Meet Management', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Visa Status', 'major_dept_id'=>'5','ticket_problem_id'=>'2'),
            array('name' => 'Bike Maintenance', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'Sick Leave', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Accident', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Emergency Leave', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Passport Renewal', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Sim Issue', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'Insurance Information', 'major_dept_id'=>'6','ticket_problem_id'=>'5'),
            array('name' => 'New Hiring', 'major_dept_id'=>'7','ticket_problem_id'=>'7'),
            array('name' => 'Transfer Issue', 'major_dept_id'=>'7','ticket_problem_id'=>'7'),
            array('name' => 'Platform Change', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Visa Renewal', 'major_dept_id'=>'5','ticket_problem_id'=>'2'),
            array('name' => 'Visa Cancellation', 'major_dept_id'=>'5','ticket_problem_id'=>'2'),
            array('name' => 'Bike Service', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'Bike Replacement', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'Bike Impound', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'New Sim', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'Sim Replacement', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'Sim Lost', 'major_dept_id'=>'4','ticket_problem_id'=>'3'),
            array('name' => 'Noc Letter', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'Emirates id Lost', 'major_dept_id'=>'3','ticket_problem_id'=>'4'),
            array('name' => 'COD Adjustment', 'major_dept_id'=>'9','ticket_problem_id'=>'6'),

        );

        \App\Model\Departments::truncate();
        DB::table('departments')->insert($data);


        //major departments seeder
        $data = array(
            array('major_department' => 'Accounts'),
            array('major_department' => 'Management'),
            array('major_department' => 'Operation'),
            array('major_department' => 'Maintenance'),
            array('major_department' => 'PRO'),
            array('major_department' => 'Insurance'),
            array('major_department' => 'Recruitment'),
            array('major_department' => 'Sim Inventory'),
            array('major_department' => 'COD'),
        );

        \App\Model\MajorDepartment::truncate();
        DB::table('major_departments')->insert($data);

//        job visa requests , usage in Agreement

        $data = array(
            array('name' => 'Sales'),
            array('name' => 'Supervisor'),
            array('name' => 'Office'),
            array('name' => 'Rider'),
        );

        \App\Model\Seeder\Visa_job_requests::truncate();
        DB::table('visa_job_requests')->insert($data);


        $data = array(
            array('name' => 'Careem','platform_category' => '1'), //1
            array('name' => 'Zomato','platform_category' => '1'), //2
            array('name' => 'Uber Eats' ,'platform_category' => '1'), //3
            array('name' => 'Deliveroo','platform_category' => '1'), //4
            array('name' => 'Swan' ,'platform_category' => '1'), //5
            array('name' => 'BNK' ,'platform_category' => '1'), //6
            array('name' => 'Sumi Shushi' ,'platform_category' => '1'), //7
            array('name' => 'Hey Carry' ,'platform_category' => '1'),//8
            array('name' => 'Leading Bakeries' ,'platform_category' => '1'),//9
            array('name' => 'Healthy Mind' ,'platform_category' => '1'),//10
            array('name' => 'I Mile','platform_category' => '1'),//11
            array('name' => 'Spicy Club' ,'platform_category' => '1'),//12
            array('name' => 'Other' ,'platform_category' => '1'),//13
            array('name' => 'Orgami' ,'platform_category' => '1'),//14
            array('name' => 'Talabat' ,'platform_category' => '1'),//15
            array('name' => 'Trot Drive' ,'platform_category' => '1'),//16
            array('name' => 'Chocomelt Restaurant' ,'platform_category' => '2'),//17
            array('name' => 'Erish Restaurant' ,'platform_category' => '2'),//18
            array('name' => 'The Kabab Shop' ,'platform_category' => '2'),//19
            array('name' => 'Asian Eats' ,'platform_category' => '2'),//20
            array('name' => 'Thai Wok' ,'platform_category' => '2'),//21
            array('name' => 'Aster Al Qusais' ,'platform_category' => '1'),//22
            array('name' => 'MedCare Al Safa' ,'platform_category' => '1'),//23
            array('name' => 'MedCare Women & Children' ,'platform_category' => '1'),//24
            array('name' => 'Instashop DMCC' ,'platform_category' => '1'),//25
            array('name' => 'Daily Fresh' ,'platform_category' => '1'),//26
            array('name' => 'Medi Link Pharmacy' ,'platform_category' => '1'),//27
            array('name' => 'Now Now' ,'platform_category' => '1'),//28
            array('name' => 'Sushi Sushi' ,'platform_category' => '2'),//29
            array('name' => 'LatestON' ,'platform_category' => '1'),//30
            array('name' => 'Uber Limo' ,'platform_category' => '1'),//31
            array('name' => 'Careem Limo' ,'platform_category' => '1'),//32
        );
        \App\Model\Platform::truncate();
        DB::table('platforms')->insert($data);

        $data = array(
            array('form_name' => 'Vehicle Salik','sample_file'=>'assets/sample/VehicleSalik_Sample/Vehicle Salik.xlsx'),
            array('form_name' => 'Fines','sample_file'=>'assets/sample/Fines_Sample/Fines.xlsx'),
            array('form_name' => 'Fuel','sample_file'=>'assets/sample/Fuel_Sample/Fuel.xlsx'),
            array('form_name' => 'RTA Vehicle','sample_file'=>'assets/sample/RTAVehcles_Sample/RTA Vehicle.xlsx'),
            array('form_name' => 'UberEats','sample_file'=>'assets/sample/UberEats_Sample/UberEats.xls'),
            array('form_name' => 'EmployeeList','sample_file'=>'assets/sample/EmployeeList_Sample/Employee_list.xlsx'),
            array('form_name' => 'Uber','sample_file'=>'assets/sample/Uber_Sample/Uber.xlsx'),
            array('form_name' => 'Careem','sample_file'=>'assets/sample/Careem_Sample/careem.xlsx'),
            array('form_name' => 'Telecom','sample_file'=>'assets/sample/Telecome_Sample/telecome.xlsx'),
            array('form_name' => 'Bikes','sample_file'=>'assets/sample/Bike_Sample/bikes.xlsx'),
        );
        \App\Model\Form_upload::truncate();
        DB::table('form_uploads')->insert($data);


        //type seeder
        $data = array(
            array('type_name' => 'text'),
            array('type_name' => 'date'),
            array('type_name' => 'number'),

        );
        \App\Model\Types::truncate();
        DB::table('types')->insert($data);

        //Nationality Seeder
        $data = array(
            array('name' => 'PAKISTAN'), //1
            array('name' => 'INDIA'), //2
            array('name' => 'BANGLADESH'), //3
            array('name' => 'AFGANISTAN'), //4
            array('name' => 'CAMEROON'), //5
            array('name' => 'PHILIPPINES'), //6
            array('name' => 'OGANDA'), //7
            array('name' => 'ATHYUOBYA'), //8
            array('name' => 'EMIRATES'), //9
            array('name' => 'GAMBYA'), //10
            array('name' => 'GHANA'), //11
            array('name' => 'JORDAN'), //12
            array('name' => 'NIGERYA'), //13
            array('name' => 'NIPAL'), //14
            array('name' => 'ROWANDA'), //15
            array('name' => 'SIRELANKA'), //16
            array('name' => 'NOT WORK'), //17
            array('name' => 'NOC WORK'), //18
            array('name' => 'LEFT'), //19
            array('name' => 'WRONG'), //20
            array('name' => 'KENYA'), //21
            array('name' => 'EGYPT'), //22
            array('name' => 'SUDAN'), //23
            array('name' => 'SENEGAL'), //24
            array('name' => 'SYRIA'), //25

        );
        \App\Model\Nationality::truncate();
        DB::table('nationalities')->insert($data);


        //Labour Fees Options
        $data = array(
            array('name' => 'Quota'),
            array('name' => 'Offer Letter'),
            array('name' => 'Offer Letter Submission'),
            array('name' => 'Labor Fees'),
            array('name' => 'New Contract Typing'),
            array('name' => 'New Contract Submission'),
        );
        \App\Model\Seeder\LabourFeesOption::truncate();
        DB::table('labour_fees_options')->insert($data);




        //Person Status
        //Usage : In generating agreement
        $data = array(
            array('name' => 'Transfer to transfer'),
            array('name' => 'Visit'),
            array('name' => 'Outside'),
            array('name' => 'Renew'),
            array('name' => 'Part Time'),
            array('name' => 'Waiting for old sponsor cancellation'),
            array('name' => 'Contractor'),
            array('name' => 'Own Visa'),

        );
        \App\Model\Seeder\PersonStatus::truncate();
        DB::table('person_statuses')->insert($data);

        //company
        //Usage : In generating agreement
        $data = array(
            array('name' => 'ZONE DELIVERY SERVICES LLC','type'=>'1'),
            array('name' => 'ELITE ZONE DELIVERY SERVICES LLC','type'=>'1'),
            array('name' => 'HEY VIP LUXURY CAR TRANSPORT LLC','type'=>'1'),
            array('name' => 'ZONE AUTO CARE','type'=>'1'),
            array('name' => 'TROT DRIVE TECHNOLOGY SERVICES','type'=>'1'),
            array('name' => 'ZONE AUTO ELECTRIC REPAIRING','type'=>'1'),
            array('name' => 'ZONE AUTO SPARE PARTS LLC','type'=>'1'),
            array('name' => 'ELITE ZONE DELIVERY SERVICES LLC SHARJAH','type'=>'1'),
            array('name' => 'NAJMAT AL GHAFIAH SPARE PARTS TRD','type'=>'1'),
            array('name' => 'ADH AL KHALEEJ AUTO MAINT WORKSHOP','type'=>'1'),
            array('name' => 'SHAHID NADEEM IMAM DIN','type'=>'2'),
            array('name' => 'AHMED NAQASH IMAM DIN','type'=>'2'),
            array('name' => 'IMAM DIL ALLAH DITA','type'=>'2'),

        );
        \App\Model\Seeder\Company::truncate();
        DB::table('companies')->insert($data);

        //company information start

        $data = array(
            array('company_id' => '1',
                  'trade_license_no'=>'571698',
                   'establishment_card' => '2/1/121801',
                   'labour_card'=>'566593',
                   'salik_acc'=>'32190028',
                   'traffic_fle_no' => '50060728',
                   'etisalat_party_id' => '37423426',
                    'du_acc'=> '6.173626'),
            array('company_id' => '2',
                'trade_license_no'=>'838194',
                'establishment_card' => '2/1/708907',
                'labour_card'=>'1031660',
                'salik_acc'=>'35012656',
                'traffic_fle_no' => '50200297',
                'etisalat_party_id' => '',
                'du_acc'=> '6.180859'),
            array('company_id' => '3',
                'trade_license_no'=>'651795',
                'establishment_card' => '2/1/186842',
                'labour_card'=>'720131',
                'salik_acc'=>'33428638',
                'traffic_fle_no' => '50102369',
                'etisalat_party_id' => '30414490',
                'du_acc'=> ''),
            array('company_id' => '4',
                'trade_license_no'=>'120432',
                'establishment_card' => '2/1/033522',
                'labour_card'=>'183629',
                'salik_acc'=>'33634750',
                'traffic_fle_no' => '50009925',
                'etisalat_party_id' => '20420741',
                'du_acc'=> ''),

            array('company_id' => '5',
                'trade_license_no'=>'864657',
                'establishment_card' => '2/1/727990',
                'labour_card'=>'1074046',
                'salik_acc'=>'',
                'traffic_fle_no' => '',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

            array('company_id' => '6',
                'trade_license_no'=>'126238',
                'establishment_card' => '2/1/033524',
                'labour_card'=>'183628',
                'salik_acc'=>'',
                'traffic_fle_no' => '',
                'etisalat_party_id' => '20420972',
                'du_acc'=> ''),

            array('company_id' => '7',
                'trade_license_no'=>'129616',
                'establishment_card' => '2/1/048702',
                'labour_card'=>'183632',
                'salik_acc'=>'34329769',
                'traffic_fle_no' => '',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

            array('company_id' => '8',
                'trade_license_no'=>'773324',
                'establishment_card' => '247679/6/301',
                'labour_card'=>'',
                'salik_acc'=>'35138658',
                'traffic_fle_no' => '3200005954',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

            array('company_id' => '9',
                'trade_license_no'=>'720559',
                'establishment_card' => '178078/6',
                'labour_card'=>'794830',
                'salik_acc'=>'',
                'traffic_fle_no' => '',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

            array('company_id' => '10',
                'trade_license_no'=>'721450',
                'establishment_card' => '178666/6',
                'labour_card'=>'794827',
                'salik_acc'=>'',
                'traffic_fle_no' => '',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

            array('company_id' => '11',
                'trade_license_no'=>'',
                'establishment_card' => '',
                'labour_card'=>'',
                'salik_acc'=>'32189986',
                'traffic_fle_no' => '10496120',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

            array('company_id' => '12',
                'trade_license_no'=>'',
                'establishment_card' => '',
                'labour_card'=>'',
                'salik_acc'=>'35033262',
                'traffic_fle_no' => '11678776',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

            array('company_id' => '13',
                'trade_license_no'=>'',
                'establishment_card' => '',
                'labour_card'=>'',
                'salik_acc'=>'32190007',
                'traffic_fle_no' => '',
                'etisalat_party_id' => '',
                'du_acc'=> ''),
            array('company_id' => '14',
                'trade_license_no'=>'',
                'establishment_card' => '',
                'labour_card'=>'',
                'salik_acc'=>'',
                'traffic_fle_no' => '50106607',
                'etisalat_party_id' => '',
                'du_acc'=> ''),

        );
        \App\Model\Seeder\CompanyInformation::truncate();
        DB::table('company_informations')->insert($data);


        //company information end here

        //Designation
        //Usage : In generating agreement
        $data = array(
            array('name' => 'ACCOUNTANT'), //1
            array('name' => 'ACCOUNTANT GENERAL'), //2
            array('name' => 'ADMINISTRATIVE OFFICER'), //3
            array('name' => 'ARCHIVES CLERK'), //4
            array('name' => 'BICYCLE MECHANIC'), //5
            array('name' => 'CAR A/C MECHANIC'), //6
            array('name' => 'CAR ELECTRICIAN ASSISTANT'), //7
            array('name' => 'CAR WASHER'), //8
            array('name' => 'CENTRAL A/C EQUIPMENT MECHANIC'), //9
            array('name' => 'CLEANER'), //10
            array('name' => 'CLEANER / CARPET'),//11
            array('name' => 'CLEANING WORKER'),//12
            array('name' => 'CLINTS SURVICES CLERK'),//13
            array('name' => 'COMPUTER NETWORKING SUPERVISOR'),//14
            array('name' => 'COMPUTER OPERATOR'),//15
            array('name' => 'CONCRETE MASON'),//16
            array('name' => 'CRANE OPERATOR ASSISTANT'),//17
            array('name' => 'DIESEL ENGINE OPERATOR'),//18
            array('name' => 'Filing Clerk'),//19
            array('name' => 'FINANCE MANAGER'),//20
            array('name' => 'FOLLOW UP CLERK'),//21
            array('name' => 'GARDENER'),//22
            array('name' => 'LABOUR SUPERVISOR'),//23
            array('name' => 'LIGHT VEHICLE DRIVER'),//24
            array('name' => 'LOADING AND UNLOADING WORKER'),//25
            array('name' => 'MARKETING MANAGER'),//26
            array('name' => 'Mechanic Assistant'),//27
            array('name' => 'Messenger'),//28
            array('name' => 'MOTORCYCLE DRIVER'),//29
            array('name' => 'MOTORCYCLE MECHANIC'),//30
            array('name' => 'Motorcyclist'),//31
            array('name' => 'Office Manager'),//32
            array('name' => 'Office Supervisor'),//33
            array('name' => 'Operations Manager'),//34
            array('name' => 'ORDINARY LABOURER'),//35
            array('name' => 'Public Relations Officer'),//36
            array('name' => 'Radiator Mechanic'),//37
            array('name' => 'SALES'),//38
            array('name' => 'SALES EXECUTIVE'),//39
            array('name' => 'Sales Manager'),//40
            array('name' => 'SALES REPRESENTATIVE'),//41
            array('name' => 'SEWAGE CLEANING WORKER'),//42
            array('name' => 'SHOP/STORE WORKER'),//43
            array('name' => 'Stall and Market Salesperson'),//44
            array('name' => 'TRUCK DRIVER'),//45
            array('name' => 'TYRE REPAIRER'),//46
            array('name' => 'VEHICLE BODY REPAIRER'),//47
            array('name' => 'VEHICLE CHASSIS WELDER'),//48
            array('name' => 'Vehicle Cleaner'),//49
            array('name' => 'Vehicle Mechanic'),//50
            array('name' => 'VEHICLE MECHANIC ASSISTANT'),//51
            array('name' => 'VEHICLE WASHING GREASING WORKE'),//52
            array('name' => 'WAITER'),//53
            array('name' => 'PIPE FITTER'),//54
            array('name' => 'STREAM PRESS MACHINE OPERATOR'),//55
            array('name' => 'WELDER ASSISTANT'),//56
            array('name' => 'EXHAUST SYS MECHANIC'),//57
            array('name' => 'Office Clerk'),//58
            array('name' => 'Cashier'),//59

        );
        \App\Model\Seeder\Designation::truncate();
        DB::table('designations')->insert($data);


        //Only Agreement Designation
        //Usage : In generating agreement
        $data = array(
            array('limo_jobs' => 'Limo 1st Driver','other_jobs' => 'Limo 1st Driver'), //1
            array('limo_jobs' => 'Limo 2nd Driver','other_jobs' => 'Limo 2nd Driver'), //2
            array('limo_jobs' => 'Limo Free Lancer','other_jobs' => 'Limo Free Lancer'), //3
            array('limo_jobs' => '','other_jobs' => 'NOC Rider'), //4
            array('limo_jobs' => '','other_jobs' => 'PART Time Rider'), //5
            array('limo_jobs' => '','other_jobs' => 'Full Time Rider'), //6
            array('limo_jobs' => '','other_jobs' =>  'NOC Driver'), //7
            array('limo_jobs' => '','other_jobs' => 'PART Time Driver'), //8
            array('limo_jobs' => '','other_jobs' => 'Full Time Driver'), //9
            array('limo_jobs' => '','other_jobs' => 'Washer'), //10
            array('limo_jobs' => '','other_jobs' => 'Cleaner'), //11
            array('limo_jobs' => '','other_jobs' => 'Lube'), //12
            array('limo_jobs' => '','other_jobs' => 'Detailing'), //13
            array('limo_jobs' => '','other_jobs' => 'Denter'), //14
            array('limo_jobs' => '','other_jobs' => 'Painter'), //15
            array('limo_jobs' => '','other_jobs' => 'Mechanic'), //16
            array('limo_jobs' => '','other_jobs' => 'Electrical'), //17
            array('limo_jobs' => '','other_jobs' => 'Lath'), //18
            array('limo_jobs' => '','other_jobs' => 'Staff'), //19
            array('limo_jobs' => '','other_jobs' => 'Bike Mechanic'), //20
            array('limo_jobs' => '','other_jobs' => 'Bike Mechanic'), //21
            array('limo_jobs' => '','other_jobs' => 'Bike Store'), //22
            array('limo_jobs' => '','other_jobs' => 'Box Painter'), //23

        );
        \App\Model\Seeder\AgreemtnDesignation::truncate();
        DB::table('agreement_designations')->insert($data);




        //Medical Categories
        //Usage : In generating agreement
        $data = array(
            array('name' => 'Normal'),
            array('name' => 'VIP'),
            array('name' => '24 Hours'),
            array('name' => '48 Hours'),

        );
        \App\Model\Seeder\MedicalCategory::truncate();
        DB::table('medical_categories')->insert($data);


         //Master Steps

        $data = array(
            array('step_name' => 'Passport Details'),
            array('step_name' => 'Offer Letter'),
            array('step_name' => 'Offer Letter Submission'),
            array('step_name' => 'Electronic Pre Approval'),
            array('step_name' => 'Electronic Pre Approval Payment'),
            array('step_name' => 'Entry Print E-visa Inside'),
            array('step_name' => 'Entry Print E-visa Outside'),
            array('step_name' => 'Status Change'),
            array('step_name' => 'In-Out Status Change'),
            array('step_name' => 'Entry Date'),
            array('step_name' => 'Medical (Normal)'),
            array('step_name' => 'Medical (48 Hours)'),
            array('step_name' => 'Medical (24 Hours)'),
            array('step_name' => 'Medical (VIP)'),
            array('step_name' => 'Fit - Unfit'),
            array('step_name' => 'Emirates ID Apply'),
            array('step_name' => 'Emirates ID Finger Print(Yes/No)'),
            array('step_name' => 'New Contract Application Typing'),
            array('step_name' => 'Tawjeeh Class'),
            array('step_name' => 'New Country Submission'),
            array('step_name' => 'Labour Card Print'),
            array('step_name' => 'Visa Stampiy Application(Urgent/Normal)'),
            array('step_name' => 'Waiting For Approval(Urgent/Normal)'),
            array('step_name' => 'Waiting For Zajeel'),
            array('step_name' => 'Visa Pasted'),
            array('step_name' => 'Unique Emirates ID Received'),
            array('step_name' => 'Unique Emirates ID Handover'),


        );
        \App\Model\Master_steps::truncate();
        DB::table('master_steps')->insert($data);


        //Agreement Categories
        //Usage : In generating agreement
        $data = array(
            array('name' => 'Current Status','name_alt'=>'Current Status'),
            array('name' => 'Driving Licence','name_alt'=>'Driving Licence'),
            array('name' => 'Medical Process','name_alt'=>'Document Process'),
            array('name' => 'Emirates ID','name_alt'=>'Emirates ID'),
            array('name' => 'Status Change','name_alt'=>'Status Change'),
            array('name' => 'In Case of Fine','name_alt'=>'In Case of Fine'),
            array('name' => 'RTA Permit','name_alt'=>'RTA Permit'),
            array('name' => 'Visa Pasting','name_alt'=>'Visa Pasting'),
            array('name' => 'Transfer to transfer','name_alt'=>'Transfer to transfer'),
            array('name' => 'Visit','name_alt'=>'Visit'),
            array('name' => 'Outside','name_alt'=>'Outside'),
            array('name' => 'Renew','name_alt'=>'Renew'),
            array('name' => 'Part Time','name_alt'=>'Part Time'),
            array('name' => 'Waiting for cancellation','name_alt'=>'Waiting for cancellation'),
            array('name' => 'Contractor','name_alt'=>'Contractor'),
            array('name' => 'Own Visa','name_alt'=>'Own Visa'),
            array('name' => 'Noc Letter Only (Current Status)','name_alt'=>'Noc Letter Only'),
            array('name' => 'Driving Licence(Yes)','name_alt'=>'Yes'),
            array('name' => 'Driving Licence(No)','name_alt'=>'Already Have'),
            array('name' => 'Driving Licence(Own)','name_alt'=>'Own'),
            array('name' => 'Driving Licence(Company)','name_alt'=>'Company'),
            array('name' => 'Driving Licence(Car)','name_alt'=>'Car'),
            array('name' => 'Driving Licence(Bike)','name_alt'=>'Bike'),
            array('name' => 'Driving Licence(Both)','name_alt'=>'Both'),
            array('name' => 'Driving Licence(Manual)','name_alt'=>'Manual'),
            array('name' => 'Driving Licence(Automatic)','name_alt'=>'Automatic'),
            array('name' => 'Medical Process(Own)','name_alt'=>'Own'),
            array('name' => 'Medical Process(Company)','name_alt'=>'Company'),
            array('name' => 'Medical Process(Normal)','name_alt'=>'Normal'),
            array('name' => 'Medical Process(VIP)','name_alt'=>'VIP'),
            array('name' => 'Medical Process(24 hour)','name_alt'=>'24 hour'),
            array('name' => 'Medical Process(48 hour)','name_alt'=>'48 hour'),
            array('name' => 'Emirates ID(Own)','name_alt'=>'Own'),
            array('name' => 'Emirates ID(Company)','name_alt'=>'Company'),
            array('name' => 'Status Change(Own)','name_alt'=>'Own'),
            array('name' => 'Status Change(Company)','name_alt'=>'Company'),
            array('name' => 'In Case of Fine(Own)','name_alt'=>'Own'),
            array('name' => 'In Case of Fine(Company)','name_alt'=>'Company'),
            array('name' => 'RTA Permit(Own)','name_alt'=>'Own'),
            array('name' => 'RTA Permit(Company)','name_alt'=>'Company'),
            array('name' => 'Visa Pasting(Normal)','name_alt'=>'Normal'),
            array('name' => 'Visa Pasting(Urgent)','name_alt'=>'Urgent'),
            array('name' => 'Normal Standard Visa(Current Status)','name_alt'=>'Normal Standard Visa'),
            array('name' => 'Free Zone/Local Visa(Current Status)','name_alt'=>'Free Zone/Local Visa'),

        );
        \App\Model\Agreement\AgreementCategory::truncate();
        DB::table('agreement_categories')->insert($data);

        //Experience
        //Usage : In career application
        $data = array(
            array('name' => '1 year'),
            array('name' => '2 year'),
            array('name' => '3 year'),
            array('name' => '4 year'),
            array('name' => 'More'),
            array('name' => '0 Year'),

        );
        \App\Model\Guest\Experience::truncate();
        DB::table('experiences')->insert($data);

        //Experience Months
        //Usage : In career application
        $data = array(
            array('name' => '1 month'),
            array('name' => '2 month'),
            array('name' => '3 month'),
            array('name' => '4 month'),
            array('name' => '5 month'),
            array('name' => '6 month'),
            array('name' => '7 month'),
            array('name' => '8 month'),
            array('name' => '9 month'),
            array('name' => '10 month'),
            array('name' => '11 month'),

        );
        \App\Model\exprience_month::truncate();
        DB::table('exprience_months')->insert($data);


        //Cities
        //Usage : In career application
        $data = array(
            array('name' => 'Dubai'),
            array('name' => 'Abu Dhabi'),
            array('name' => 'Sharjah'),
            array('name' => 'Ajman'),
            array('name' => 'Al Ain'),
            array('name' => 'Fujairah'),
            array('name' => 'Umm ul Quwain'),
            array('name' => 'Ras al Khaimah')
        );
        \App\Model\Cities::truncate();
        DB::table('cities')->insert($data);

       //Emplolyee Type
       //Usage: In Agreement Type

        $data = array(
            array('name' => 'Not Employee'),
            array('name' => 'Full Time Employee'),
            array('name' => 'Part Time'),

        );
        \App\Model\Seeder\EmployeeType::truncate();
        DB::table('employee_types')->insert($data);

//        Passport handler
//        Usage: In Agreement Passport Status

        $data = array(
            array('name' => 'Issue'),
            array('name' => 'Collected'),
        );
        \App\Model\Seeder\PassportHandler::truncate();
        DB::table('passport_handlers')->insert($data);

//        Lving Status
//        Usage: In Agreement Living Status

        $data = array(
            array('name' => 'Inside'),
            array('name' => 'Outside'),
        );
        \App\Model\Seeder\LivingStatus::truncate();
        DB::table('living_statuses')->insert($data);

        // Driving License Steps
        // Usage: driving license status

        $data = array(
            array('name' => 'Went for driving school'),
            array('name' => 'Pass the test'),
            array('name' => 'Got driving license'),
        );
        \App\Model\Seeder\DrivingLicenseSteps::truncate();
        DB::table('driving_license_steps')->insert($data);


        //Labour card type
        //Usage: In pro process flow

        $data = array(
            array('name' => 'Labour card for Part Time'), // part time
            array('name' => 'National And GCC Labour Card'), // part time only for emirati
            array('name' => 'New Labour Card'), // visit and transfer to transfer
            array('name' => 'New Labour Card Under Cancellation'),
            array('name' => 'Renew Labour Card'),
            array('name' => 'Renew Labour Card Under Cancellation'),
            array('name' => 'Renewal National And GCC Labour Card'),
            array('name' => 'Work Permit'),
            array('name' => 'Labour Card for Temporary Labour Card for Temporary'),

        );
        \App\Model\LabourCardType::truncate();
        DB::table('labour_card_types')->insert($data);




        $data = array(
            array('payment_type' => 'Cash'),
            array('payment_type' => 'Credit'),
            array('payment_type' => 'E-Dirham'),
            array('payment_type' => 'Naqoodi'),

        );
        \App\Model\PaymentType::truncate();
        DB::table('payment_types')->insert($data);

        //User current Status
        //Usage: User Current Statuses

        $data = array(
            array('name' => 'Vacation'),
            array('name' => 'Working'),
            array('name' => 'Absconded'),
            array('name' => 'Accident'),
        );
        \App\Model\Seeder\UserCurrentStatus::truncate();
        DB::table('user_current_statuses')->insert($data);

        //attachment seeder
        $data = array(
            array('name' => 'ID Card'),
        );

        \App\Model\Passport\AttachmentTypes::truncate();
        DB::table('attachment_types')->insert($data);

        //sim assingment types

        $data = array(
            array('name' => 'Rider'),
            array('name' => 'Office'),
            array('name' => 'Admin'),
            array('name' => 'Workshop'),
            array('name' => 'Home'),
        );

        \App\Model\Assign\SimAssignType::truncate();
        DB::table('sim_assign_types')->insert($data);



        $data = array(
            array('name' => 'Control ZDS Not Matched'),
            array('name' => 'Control Passport Not Matched'),
            array('name' => 'Control Name Not Mathced'),
            array('name' => 'Control Not Matched'),
            array('name' => 'Control Sim Not Matched'),
            array('name' => 'MSP ZDS Not Matched'),
            array('name' => 'MSP Passport Not Mtahced'),
            array('name' => 'MSP Name Not Mathced'),
            array('name' => 'MSP Not Matched'),
            array('name' => 'MSP Sim Not Matched'),
            array('name' => 'All Matched'),
            array('name' => 'Control Platform Not Matched'),
            array('name' => 'MSP Platform Not Matched'),

        );

        \App\Model\Passport\PpuidIssue::truncate();
        DB::table('ppuid_issues')->insert($data);


//visa cencallation satuss
        $data = array(
            array('name' => 'Normal'),//1
            array('name' => 'Death'),//2
            array('name' => 'Medical Unfit'),//3
            array('name' => 'Outside Cancellation'), //4
            array('name' => 'Abscounting Cancellation by Company'),//4
            array('name' => 'Abscounting Cancellation by Employee'),//5
            array('name' => 'Incomplete Process Cancellation'),//6

        );
        \App\Model\VisaProcess\VisaCancellStatus::truncate();
        DB::table('visa_cancell_statuses')->insert($data);

        //balance types
        $data = array(
            array('name' => 'Rent','category'=>'1'),//1
            array('name' => 'SIM Charge','category'=>'1'),//2
            array('name' => 'Salik','category'=>'1'),//3
            array('name' => 'fine','category'=>'1'), //4
            array('name' => 'Advance Deduction','category'=>'1'),//5
            array('name' => 'A/R Deduction','category'=>'1'),//6
            array('name' => 'SIM Excess','category'=>'1'),//7
            array('name' => 'Others','category'=>'1'),//8
            array('name' => 'FUEL USED','category'=>'1'),//9
            array('name' => 'SALIK USED','category'=>'1'),//10
            array('name' => 'ADVANCE','category'=>'1'),//11
            array('name' => 'SIM EXCESS','category'=>'1'),//12
            array('name' => 'TRAFFICE FINE','category'=>'1'),//13
            array('name' => 'PENALTIES BY PLATFORM','category'=>'1'),//14
            array('name' => 'COD PENALTY','category'=>'1'),//15
            array('name' => 'COD DED BY AGENCY','category'=>'1'),//16
            array('name' => 'COD DED BY PLATFORM','category'=>'1'),//17
            array('name' => 'HOUR DEDUCTION','category'=>'1'),//18
            array('name' => 'HEALTH INSURANCE','category'=>'1'),//19
            array('name' => 'SIM LOST','category'=>'1'),//20
            array('name' => 'ACCIDENTAL INSURANCE EXCESS','category'=>'1'),//121
            array('name' => 'LOSS AND DAMAGES','category'=>'1'),//22
            array('name' => 'DELIVEROO KIT','category'=>'1'),//23
            array('name' => 'NO PLATE CHARGES','category'=>'1'),//24
            array('name' => 'OTHER DEDUCTION','category'=>'1'),//25
            array('name' => 'EMIRATES ID LOST','category'=>'1'),//26
            array('name' => 'OVER STAY FINE','category'=>'1'),//27
            array('name' => 'LABOUR FINE','category'=>'1'),//28
            array('name' => 'URGENT VISA PASTING','category'=>'1'),//29
            array('name' => 'URGENT MEDICAL','category'=>'1'),//30
            array('name' => 'TRIP DEDUCTION','category'=>'1'),//31
              array('name' => 'TOTAL HOURS','category'=>'2'),//32
              array('name' => 'ORDERS','category'=>'2'),//33
              array('name' => 'RIDER DISTANCE','category'=>'2'),//34
              array('name' => 'STACKED ORDER','category'=>'2'),//35
              array('name' => 'WORKING DAYS','category'=>'2'),//36
              array('name' => 'MONTHLY SALARY','category'=>'2'),//37
              array('name' => 'PAYOUT AGAINST ORDERS','category'=>'2'),//38
              array('name' => 'PAYOUT AGAINST STACKED ORDER','category'=>'2'),//39
              array('name' => 'ZONE BLOCK INCENTIVE','category'=>'2'),//40
              array('name' => 'ZONE BONUS','category'=>'2'),//41
              array('name' => 'MONTLY BONUS','category'=>'2'),//42
              array('name' => 'PLATFORM  INCENTIVE','category'=>'2'),//43
              array('name' => 'REFERAL CASH','category'=>'2'),//44
              array('name' => 'FUEL FEE','category'=>'2'),//45
              array('name' => 'RIDER GUARANTEE','category'=>'2'),//46
              array('name' => 'TIPS','category'=>'2'),//47
              array('name' => 'PAST QUERIES ADJUSTMENT','category'=>'2'),//48
              array('name' => 'BONUS','category'=>'2'),//49
              array('name' => 'SURGE','category'=>'2'),//50
              array('name' => 'RIDER TRAINING FEE','category'=>'2'),//51
              array('name' => 'COD PENALTY RETURN','category'=>'2'),//52
              array('name' => 'A/R DISCOUNT','category'=>'2'),//53
              array('name' => 'TRAFFIC FINE DISCOUNT','category'=>'2'),//54
              array('name' => 'SALIK ALLOWANCE','category'=>'2'),//55
              array('name' => 'O.T','category'=>'2'),//56
              array('name' => 'GUARANTEE TRIPS','category'=>'2'),//57
              array('name' => 'FUEL ALLOWNCE','category'=>'2'),//58
              array('name' => 'OTHER ADJUSMENT','category'=>'2'),//59

        );
        \App\Model\ArBalance\BalanceType::truncate();
        DB::table('balance_types')->insert($data);



        //shortlisted statuses
        $data = array(
            array('name' => 'Courier Driver','parent_id'=>'0'),//1
            array('name' => 'Rider','parent_id'=>'0'),//2
            array('name' => 'Limo Driver','parent_id'=>'0'),//3
            array('name' => 'New Visa','parent_id'=>'0'), //4
            array('name' => 'Freelance Visa','parent_id'=>'0'),//5
            array('name' => 'Four PL/Contractor','parent_id'=>'0'),//6
            array('name' => 'Ready to take visa','parent_id'=>'4'),//7
            array('name' => 'Waiting for cancellation','parent_id'=>'4'),//8
            array('name' => 'Transfer to transfer','parent_id'=>'4'),//9
            array('name' => 'Visit visa','parent_id'=>'4'),//10
            array('name' => 'NOC','parent_id'=>'5'),//11
            array('name' => 'Without visa','parent_id'=>'5'),//12

        );
        \App\Model\shortlisted_statuses::truncate();
        DB::table('shortlisted_statuses')->insert($data);

        //log statuses

        $data = array(
            array('name' => 'PPUID Created'),//1
            array('name' => 'Agreed Amount'),//2
            array('name' => 'Interview Failed'),//3
            array('name' => 'Interview Passed'),//4
            array('name' => 'Interview Absent'),//5
        );
        \App\Model\logStatus\LogStatus::truncate();
        DB::table('log_statuses')->insert($data);


        //follow statuses

        $data = array(
            array('name' => 'Rejected'),//1
            array('name' => 'Document Pending'),//2
            array('name' => 'Short Listed'),//3
            array('name' => 'Selected'),//4
            array('name' => 'Wait List'),//5
            array('name' => 'Interested'),//6
            array('name' => 'Call me tomorrow'),//7
            array('name' => 'No response'),//8
            array('name' => 'Not Interested'),//9
            array('name' => 'Interview Sent'),//10
            array('name' => 'Interview Pass'),//11
            array('name' => 'Interview Failed'),//12
        );
        \App\Model\Seeder\followup_statuses::truncate();
        DB::table('followup_statuses')->insert($data);









        //permission for all

//
//        DB::table("model_has_roles")->truncate();
//        \Spatie\Permission\Models\Role::truncate();
//
//        \Spatie\Permission\Models\Permission::truncate();
//
//        $permissions = [
//            'permission-list',
//            'permission-create',
//            'permission-edit',
//            'permission-delete'
//        ];
//        foreach ($permissions as $permission) {
//            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
//        }
//        $user = \App\User::where('email','=','sabhan@zonemultiverse.com')->first();
//        $role = \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
//        $permissions = \Spatie\Permission\Models\Permission::pluck('id','id')->all();
//        $role->syncPermissions($permissions);
//        $user->assignRole([$role->id]);
    }
}
