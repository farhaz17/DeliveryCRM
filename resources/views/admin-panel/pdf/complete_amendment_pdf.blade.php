<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Agreement</title>
    <link rel="stylesheet" href="style.css" media="all" />
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }

        body {
            position: relative;
            width: 18cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
        }

        #logo img {
            width: 90px;
        }

        h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: #5D6975;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url(dimension.png);
        }

        #project {
            float: left;
        }

        #project span {
            color: #5D6975;
            text-align: right;
            width: 52px;
            margin-right: 10px;
            display: inline-block;
            font-size: 0.8em;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div,
        #company div {
            white-space: nowrap;
            vertical-align: bottom;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
            border: 1px solid #C1CED9;

        }

        table tr:nth-child(2n-1) td {
            background: #F5F5F5;

        }

        table th,
        table td {
            text-align: center;
            border: 1px solid #C1CED9;
        }

        table th {
            padding: 5px 05px;
            color: #5D6975;
            border: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
        }
        .label_color{
            color: #5D6975;
            float:right
        }
        .heading_color{
            color:#001028;
        }

        table .service,
        table .desc {
            text-align: left;
        }

        table td {
            padding: 05px;
            text-align: right;
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<header class="clearfix">
    {{--    <div id="logo">--}}
    {{--        <img src="https://s3-eu-west-1.amazonaws.com/htmlpdfapi.production/free_html5_invoice_templates/example1/logo.png">--}}
    {{--    </div>--}}
    <h1>AGREEMENT {{ $agreement->agreement_no  }} / {{ $number_amendment }}</h1>

    <div id="project" >
        <div><span>PASSPORT ID</span> {{ $agreement->passport->pp_uid  }}</div>
        <div><span>PASSPORT NUMBER</span> {{ $agreement->passport->passport_no  }}</div>
        <div><span>GIVEN NAME</span> {{ $agreement->passport->personal_info->full_name  }}</div>
        <div><span>FATHER NAME</span> {{ $agreement->passport->father_name }}</div>
        <div><span>COUNTRY</span> {{ $agreement->passport->country_code }}</div>

    </div>
    <div style="float:right" >
        <img style="width: 90px;" src="{{ $agreement->passport->personal_info->personal_image? $agreement->passport->personal_info->personal_image : 'https://via.placeholder.com/150'  }}">
    </div>


</header>
<main>
    <table>
        <thead>
        <tr>
            <th class="service" width="20%">EMPLOYEE TYPE</th>
            <td class="desc" width="80%">{{ $agreement->employee_types->name }}</td>
        </tr>


        <tr>
            <?php $walk_in_option = false; ?>
            <th class="service" width="20%">REFERENCE</th>
            @if($agreement->reference_type=="1")
                <td class="desc" width="80%">Own</td>
                <?php $walk_in_option = true; ?>
            @elseif($agreement->reference_type=="2")
                <td class="desc" width="80%">outside</td>
                <?php $walk_in_option = true; ?>
            @else
                <td class="desc" width="80%">Walk in Candidate</td>

            @endif


        </tr>

        @if($walk_in_option)
            <tr>
                @if($agreement->reference_type=="1")
                    <th class="service" width="20%">RIDER NAME</th>
                @else
                    <th class="service" width="20%">REFERENCE DETAIL</th>
                @endif

                <td class="desc" width="80%"><?php   if(!empty($agreement->reference_type_own)){
                        echo $agreement->reference_type_user ? $agreement->reference_type_user->personal_info->full_name : "No Name";
                    }else{
                        $array_json = json_decode($agreement->reference_type_outside,true);
                        $count = 0;
                        foreach( (array) $array_json['name'] as $values){

                            echo "name: ".$values."<br>";
                            echo "Contact number: ".$array_json['contact_nubmer'][$count]."<br>";
                            echo "whats app number: ".$array_json['whatsppnumber'][$count]."<br>";
                            echo "links: ".$array_json['socialmedia'][$count]."<br>";
                            echo "Working Place: ".$array_json['working_place'][$count]."<br>";
                            echo "<br>";
                            echo "<br>";
                            $count = $count+1;
                        }
                    }

                    ?></td>
            </tr>
        @endif


        <tr>
            <th class="service" width="20%">CURRENT STATUS</th>
            <td class="desc" width="80%">{{ $agreement->get_current_status->get_parent_name->name_alt  }}

                @if($agreement->get_current_status->get_parent_name->name_alt=="Visit")
                    <?php $entry_date  =  explode(" ",$agreement->current_status_start_date); ?>
                    <?php $exit_date  =  explode(" ",$agreement->current_status_end_date); ?>
                    <span class="label_color" style="width:30%;">EXIT DATE : <span class="heading_color">{{ date('d-m-Y', strtotime($exit_date[0])) }}</span> </span>
                    <span class="label_color" style="width:30%;">ENTRY DATE : <span class="heading_color">{{ date('d-m-Y', strtotime($entry_date[0]))  }}</span> </span>

                @elseif($agreement->get_current_status->get_parent_name->name_alt=="Transfer to transfer")
                    <?php $exit_date  =  explode(" ",$agreement->current_status_end_date); ?>
                    <span class="label_color">EXIT DATE : <span class="heading_color">{{ date('d-m-Y', strtotime($exit_date[0])) }}</span> </span>
                @elseif($agreement->get_current_status->get_parent_name->name_alt=="Free Zone/Local Visa")

                    <?php if(!empty($agreement->current_status_end_date)){
                        $exit_date  =  explode(" ",$agreement->current_status_end_date);
                    }
                    ?>
                    <span class="label_color">EXIT DATE : <span class="heading_color">{{ isset($exit_date[0]) ? date('d-m-Y', strtotime($exit_date[0])) : 'N/A' }}</span> </span>
                @elseif($agreement->get_current_status->get_parent_name->name_alt=="Waiting for old sponsor cancellation")
                    <?php $exit_date  =  explode(" ",$agreement->current_status_end_date); ?>
                    <span class="label_color">EXPECTED DATE : <span class="heading_color">{{ date('d-m-Y', strtotime($exit_date[0])) }}</span> </span>
                @else

                @endif

            </td>

        </tr>
        <tr>
            <th class="service" width="20%">WORKING VISA</th>
            <td class="desc" width="80%">{{ $agreement->get_working_visa->name ?  $agreement->get_working_visa->name: '' }}</td>
        </tr>
        @if($agreement->employee_type_id=="2")
            <tr>
                <th class="service" width="20%">VISA APPLYING</th>
                <td class="desc" width="80%">{{ $agreement->get_applying_visa->name ? $agreement->get_applying_visa->name: '' }}</td>
            </tr>
        @endif

        <?php
        $working_designation = array(
            '1' => 'Limo Driver',
            '2' => 'Rider',
            '3' => 'Driver',
            '4' => 'Service',
            '5' => 'Body Shop',
            '6' => 'Garage',
            '7' => 'Office',
            '8' => 'Bike Work shop',
        )
        ?>
        <tr>
            <th class="service" width="20%">WORKING DESIGNATION</th>
            <td class="desc" width="80%"> {{  $working_designation[$agreement->working_designation] }}</td>
        </tr>
        <tr>
            <th class="service" width="20%">VISA DESIGNATION</th>
            <td class="desc" width="80%">{{ $agreement->get_agreement_designation->other_jobs ?  $agreement->get_agreement_designation->other_jobs : '' }}</td>
        </tr>
        <tr>
            <th class="service" width="20%">DRIVING LICENSE</th>
            <td class="desc" width="80%"><?php if($agreement->driving_licence=="1"){ echo 'Need New License'; }elseif($agreement->driving_licence=="2") { echo 'Already have'; }else{ echo 'Not Required License';   } ?></td>
        </tr>

        @if($agreement->driving_licence!="3")
            <tr>
                <th class="service" width="20%">DRIVING LICENSE VEHICLE</th>
                <td class="desc" width="80%"><?php if($agreement->driving_licence_vehicle=="1"){ echo 'Bike'; }elseif($agreement->driving_licence_vehicle=="2") { echo 'Car'; }elseif($agreement->driving_licence_vehicle=="3"){ echo 'Both';   } ?></td>
            </tr>
        @endif

        <?php if($agreement->driving_licence_vehicle=="2") { ?>
        <tr>
            <th class="service" width="20%">DRIVING LICENSE CAR TYPE</th>
            <td class="desc" width="80%"><?php if($agreement->driving_licence_vehicle_type=="1"){ echo 'Automatic Car'; }elseif($agreement->driving_licence_vehicle_type=="2") { echo 'Manual Car'; }?></td>
        </tr>
        <?php } ?>



        @if($agreement->employee_type_id=="2")

            <tr>
                <th class="service" width="20%">E-VISA PRINT</th>
                <td class="desc" width="80%"><?php  if($agreement->e_visa_print=="1") { echo 'Inside E-visa Print'; }elseif($agreement->e_visa_print=="2"){ echo 'OutSide Visa'; } ?></td>
            </tr>
            @if($agreement->e_visa_print=="1")
                <tr>
                    <th class="service" width="20%">INSIDE E-VISA PRINT</th>
                    <td class="desc" width="80%"><?php  if($agreement->inside_e_visa_type=="1") { echo 'Inside Status Change'; }elseif($agreement->inside_e_visa_type=="2"){ echo 'OutSide Status Change'; } ?></td>
                </tr>
            @endif

            <tr>
                <th class="service" width="20%">MEDICAL TYPE</th>
                <td class="desc" width="80%"><?php  if($agreement->medical_ownership=="1") { echo 'Own'; }elseif($agreement->medical_ownership=="2"){ echo 'Company'; } ?></td>
            </tr>

            @if(($agreement->medical_ownership=="2"))
                <tr>
                    <th class="service" width="20%">MEDICAL COMPANY NAME</th>
                    <td class="desc" width="80%">{{ isset($agreement->medical_ownership_cat->name) ? $agreement->medical_ownership_cat->name: ''  }}</td>
                </tr>
            @endif


            <tr>
                <th class="service" width="20%">EMIRATES ID</th>
                <td class="desc" width="80%"><?php  if($agreement->emiratesid_ownership=="1") { echo 'Own'; }elseif($agreement->emiratesid_ownership=="2"){ echo 'Company'; } ?></td>
            </tr>

            <tr>
                <th class="service" width="20%">VISA PASTING</th>
                <td class="desc" width="80%"><?php  if($agreement->visa_pasting=="1") { echo 'Normal'; }elseif($agreement->visa_pasting=="2"){ echo 'Urgent'; } ?></td>
            </tr>

            <tr>
                <th class="service" width="20%">IN CASE FINE</th>
                <td class="desc" width="80%"><?php  if($agreement->fine=="1") { echo 'Own'; }elseif($agreement->fine=="2"){ echo 'Company'; } ?></td>
            </tr>

        @endif

        @if($agreement->working_visa=="3" && $agreement->applying_visa=="3" && $agreement->working_designation=="1"  )
            <tr>
                <th class="service" width="20%">ENGLISH LANGUAGE TEST</th>
                <td class="desc" width="80%"> <?php if($agreement->english_test=="1"){ echo "Own"; }elseif($agreement->english_test=="2"){ echo "Company";  } ?></td>
            </tr>
            <tr>
                <th class="service" width="20%">RTA PERMIT TRAINING</th>
                <td class="desc" width="80%"> <?php if($agreement->rta_permit_training=="1"){ echo "Own"; }elseif($agreement->rta_permit_training=="2"){ echo "Company";  } ?></td>
            </tr>
            <tr>
                <th class="service" width="20%">E TEST</th>
                <td class="desc" width="80%"> <?php if($agreement->e_test=="1"){ echo "Own"; }elseif($agreement->e_test=="2"){ echo "Company";  } ?></td>
            </tr>

            <tr>
                <th class="service" width="20%">RTA MEDICAL</th>
                <td class="desc" width="80%"> <?php if($agreement->rta_medical=="1"){ echo "Own"; }elseif($agreement->rta_medical=="2"){ echo "Company";  } ?></td>
            </tr>

            <tr>
                <th class="service" width="20%">CID REPORT</th>
                <td class="desc" width="80%"> <?php if($agreement->cid_report=="1"){ echo "Own"; }elseif($agreement->cid_report=="2"){ echo "Company";  } ?></td>
            </tr>

            <tr>
                <th class="service" width="20%">RTA CARD PRINT</th>
                <td class="desc" width="80%"> <?php if($agreement->rta_card_print=="1"){ echo "Own"; }elseif($agreement->rta_card_print=="2"){ echo "Company";  } ?></td>
            </tr>
        @endif
        </thead>
    </table>

    <table>
        <thead>
        <tr>
            <th class="service">Option Label</th>
            <th class="desc">Option Selected</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        <?php $g_total = 0 ;?>
        @if(isset($agreement->amounts))

            @foreach($agreement->amounts as $ab)
                @if($ab->get_fees_lebel->option_label=="Labor Fees")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($labour_fees_array[$ab->get_fees_lebel->option_value]) ? $labour_fees_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}</td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="Emirates Id")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($emiratesid_ownership_array[$ab->get_fees_lebel->option_value]) ? $emiratesid_ownership_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}</td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="Inside E-visa Print")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($e_visa_print[$ab->get_fees_lebel->option_value]) ? $e_visa_print[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                            @if($ab->get_fees_lebel->option_value=="1")
                                <span style="float: right;">( {{ isset($e_visa_print_inside[$ab->get_fees_lebel->child_option_id]) ? $e_visa_print_inside[$ab->get_fees_lebel->child_option_id] : 'N/A' }} )</span>
                            @endif
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="Medical")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($medical_ownership_array[$ab->get_fees_lebel->option_value]) ? $medical_ownership_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                            @if($ab->get_fees_lebel->option_value=="0")
                                <span style="float: right;">( {{ isset($medical_ownership_array[$ab->get_fees_lebel->child_option_id]) ? $medical_ownership_array[$ab->get_fees_lebel->child_option_id] : 'N/A' }} )</span>
                            @endif
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="Emirates Id")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($emiratesid_ownership_array[$ab->get_fees_lebel->option_value]) ? $emiratesid_ownership_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="Visa Pasting")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($visa_pasting_array[$ab->get_fees_lebel->option_value]) ? $visa_pasting_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="In Case Fine")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($fine_array[$ab->get_fees_lebel->option_value]) ? $fine_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="English Language Test")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($english_test_array[$ab->get_fees_lebel->option_value]) ? $english_test_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="RTA Permit Training")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($rta_permit_training_array[$ab->get_fees_lebel->option_value]) ? $rta_permit_training_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="E Test")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($e_test_array[$ab->get_fees_lebel->option_value]) ? $e_test_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="RTA Medical")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($rta_medical_array[$ab->get_fees_lebel->option_value]) ? $rta_medical_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="CID Report")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($cid_report_array[$ab->get_fees_lebel->option_value]) ? $cid_report_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @elseif($ab->get_fees_lebel->option_label=="RTA Card Print")
                    <tr>
                        <td class="service">{{ isset($ab->get_fees_lebel->option_label) ? $ab->get_fees_lebel->option_label : 'N/A' }} </td>
                        <td class="desc">{{ isset($rta_card_array[$ab->get_fees_lebel->option_value]) ? $rta_card_array[$ab->get_fees_lebel->option_value] : 'N/A'  }}
                        </td>
                        <td class="unit">${{ isset($ab->amount) ? $ab->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($ab->amount) ? $ab->amount : '0' ?>
                    </tr>
                @endif
            @endforeach


            @if($agreement->driving_licence=="1")

                @if(!empty($driving_license_amount))
                    <tr>
                        <td class="service">Need New License</td>
                        <td class="desc">{{ $driving_license_verhicle_array[$agreement->driving_licence_vehicle] }}
                            @if(!empty($agreement->driving_licence_vehicle_type))
                                <span style="float: right;">( {{ $driving_license_verhicle_type_array[$agreement->driving_licence_vehicle_type] }} )</span>
                            @endif
                        </td>
                        <td class="unit">${{ isset($driving_license_amount->amount) ? $driving_license_amount->amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($driving_license_amount->amount) ? $driving_license_amount->amount : '0' ?>
                    </tr>
                @endif
            @endif

            @if($agreement->driving_licence=="1")

                @if(!empty($driving_license_amount->admin_amount))
                    <tr>
                        <td class="service">Admin Driving License Amount</td>
                        <td class="desc">N/A
                        </td>
                        <td class="unit">${{ isset($driving_license_amount->admin_amount) ? $driving_license_amount->admin_amount : 'N/A'   }}</td>
                        <?php  $g_total +=  isset($driving_license_amount->admin_amount) ? $driving_license_amount->admin_amount : '0' ?>
                    </tr>
                @endif
            @endif

            @if($agreement->admin_fee_id!="0")
                <tr>
                    <td class="service">Admin Amount</td>
                    <td class="desc">N/A
                    </td>
                    <td class="unit">${{ isset($agreement->admin_fee_id) ? $agreement->admin_fee_id : 'N/A'   }}</td>
                    <?php  $g_total +=  isset($agreement->admin_fee_id) ? $agreement->admin_fee_id : '0' ?>
                </tr>
            @endif


        @endif

        <tr>
            <td colspan="2">TOTAL</td>
            <td class="total">${{ $g_total }}</td>
        </tr>
        <?php $discount_amount = 0; ?>
        @if(!empty($agreement->discount_details))
            <?php
            $array_json = json_decode($agreement->discount_details,true);
            $count = 0;
            foreach( (array) $array_json['name'] as $values){ ?>
            <tr>
                <td colspan="2">DISCOUNT ({{ $array_json['name'][$count] }})</td>
                <td class="total">${{ $array_json['amount'][$count] }}</td>
            </tr>
            <?php $discount_amount += $array_json['amount'][$count]; ?>
            <?php
            $count = $count+1;
            }
            ?>
        @endif

        @if(!empty($agreement->advance_amount))
            <tr>
                <td colspan="2" >ADVANCE AMOUNT</td>
                <td class="total">${{  $agreement->advance_amount  }}</td>
                <?php $discount_amount += $agreement->advance_amount; ?>
            </tr>
        @endif

        @if(!empty($agreement->adjustment_amount))
            <tr>
                <td colspan="2" >ADJUSTMENT AMOUNT</td>
                <td class="total">{{  $agreement->adjustment_amount  }}</td>
                <?php $discount_amount += $agreement->adjustment_amount; ?>
            </tr>
        @endif


        <tr>
            <td colspan="2" class="grand total">TOTAL AGREEMENT AMOUNT</td>
            <?php  $super_total = $g_total-$discount_amount; ?>
            <td class="grand total">${{ $super_total  }}</td>
        </tr>

        @if(isset($agreement->step_amounts))
            @foreach($agreement->step_amounts as $step)
                <tr>
                    <td  class="service total">Step Name</td>
                    <td class="desc">{{ $step->master->step_name }}
                    </td>
                    <td class="unit">${{ $step->amount }}</td>
                </tr>
            @endforeach
        @endif

        @if(isset($agreement->payroll_deduct))
            <tr>
                <td  class="service total">Step Name</td>
                <td class="desc">Payroll Deduct
                </td>
                <td class="unit">${{ $agreement->payroll_deduct }}</td>
            </tr>
        @endif

        </tbody>
    </table>

    @if(!empty($agreement->get_ar_balance))
        <table>
            <thead>
            <tr>
                <th class="service" width="20%">AR AGREED AMOUNT</th>
                <td class="desc" width="80%">{{ $agreement->get_ar_balance->ar_agreed_amount }}</td>
            </tr>
            <tr>
                <th class="service" width="20%">AR CASH RECEIVED AMOUNT</th>
                <td class="desc" width="80%">{{ $agreement->get_ar_balance->ar_cash_received_amount }}</td>
            </tr>

            <tr>
                <th class="service" width="20%">AR DISCOUNT AMOUNT</th>
                <td class="desc" width="80%">{{ $agreement->get_ar_balance->ar_discount_amount }}</td>
            </tr>

            <tr>
                <th class="service" width="20%">AR DEDUCTION AMOUNT</th>
                <td class="desc" width="80%">{{ $agreement->get_ar_balance->total_deduction_amount }}</td>
            </tr>
            <tr>
                <th class="service" width="20%">AR ADDITION AMOUNT</th>
                <td class="desc" width="80%">{{ $agreement->get_ar_balance->total_addition_amount }}</td>
            </tr>

            <tr>
                <th class="service" width="20%">AR CURRENT BALANCE</th>
                <td class="desc" width="80%">{{ $agreement->get_ar_balance->current_balance }}</td>
            </tr>
            </thead>
        </table>
    @endif

    {{--    <div id="notices">--}}
    {{--        <div>NOTICE:</div>--}}
    {{--        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>--}}
    {{--    </div>--}}
</main>
<footer>
    Agreement was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>
