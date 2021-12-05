@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .hide_cls{
            display:none;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passports</a></li>
            <li>Passport Reports</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">



                <div class="card text-left">
                    <div class="card-body">
                        {{--                            <h4 class="card-title mb-3">Basic Tab With Icon</h4>--}}
                        <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#not_employee" role="tab" aria-controls="not_employee" aria-selected="true"><i class="nav-icon i-Remove-User mr-1"></i>Registered Passport ({{ $register_passports->count() }})</a></li>
                            <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#taking_visa" role="tab" aria-controls="taking_visa" aria-selected="false"><i class="nav-icon i-Visa mr-1"></i>Not Registered Passport ({{ $not_register_passports->count() }})</a></li>
                            <li  class="nav-item hide_cls"><a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#part_time" role="tab" aria-controls="part_time" aria-selected="false"><i class="nav-icon i-Over-Time-2 mr-1"></i>Part Time (2)</a></li>
                        </ul>
                        <div class="tab-content" id="myIconTabContent">
                            <div class="tab-pane fade show active" id="not_employee" role="tabpanel" aria-labelledby="home-icon-tab">

                                <ul class="nav nav-pills" id="myIconTab_two" role="tablist">
                                    <?php $counter = 0; ?>
                                @foreach($companies as $company)

                        <li class="nav-item"><a class="nav-link {{ ($counter=="0") ? 'active' : ''  }}" id="label-{{ $company->id }}" data-toggle="tab" href="#ids-{{ $company->id }}" role="tab" aria-controls="ids-{{ $company->id }}" aria-selected="true"><i class="nav-icon i-Remove-User mr-1"></i>{{ $company->name }} ( {{ $companies_passports[$counter] ? $companies_passports[$counter]->count() : '0'  }}  ) </a></li>
                                            <?php $counter = $counter+1; ?>
                                @endforeach
                     <li class="nav-item"><a class="nav-link" id="label-other_tab" data-toggle="tab" href="#ids-other_tab" role="tab" aria-controls="ids-other_tab" aria-selected="true"><i class="nav-icon i-Remove-User mr-1"></i>OTHER PASSPORTS ( {{ $register_passports_without_company ? $register_passports_without_company->count() : '0' }})</a></li>

                                </ul>
                                <?php $counter = 0; ?>
                                <div class="tab-content" id="myIconTab_twoContent">
                                    @foreach($companies as $company)

                                    <div class="tab-pane fade  {{ ($counter=="0") ? ' show active' : ''  }}" id="ids-{{ $company->id }}" role="tabpanel" aria-labelledby="label-{{ $company->id }}">
                                      {{ $company->name }}

                                        <div class="table-responsive" >
                                            <table class="display table table-striped table-bordered data_table_cls" id="datatable_ids-{{ $company->id  }}" >
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Company</th>
                                                    <th scope="col">Passport Number</th>
                                                    <th scope="col">Full Name</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @if(isset($company))

                                                @foreach($companies_passports[$counter] as $letter)
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <th scope="row">{{ $company->name }}</th>
                                                        <td>{{ $letter->passport_no }}</td>
                                                        <td>{{ $letter->personal_info ? $letter->personal_info->full_name: 'N/A'  }}</td>
                                                    </tr>
                                                @endforeach

                                                @endif



                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                        <?php $counter = $counter+1; ?>
                                    @endforeach


                                        <div class="tab-pane fade  " id="ids-other_tab" role="tabpanel" aria-labelledby="label-other_tab">
                                          Other Passports
                                            <div class="table-responsive" >
                                                <table class="display table table-striped table-bordered data_table_cls" id="datatable_ids-other_tab" >
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Company</th>
                                                        <th scope="col">Passport Number</th>
                                                        <th scope="col">Full Name</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($register_passports_without_company as $letter)
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <th scope="row">{{ $company->name }}</th>
                                                                <td>{{ $letter->passport_no }}</td>
                                                                <td>{{ $letter->personal_info ? $letter->personal_info->full_name: 'N/A'  }}</td>
                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>





                                </div>




                            </div>

                            <div class="tab-pane fade" id="taking_visa" role="tabpanel" aria-labelledby="profile-icon-tab">

                                <ul class="nav nav-pills" id="myIconTab_three" role="tablist">
                                    <?php $counter = 0; ?>
                                    @foreach($companies as $company)

                                        <li class="nav-item"><a class="nav-link {{ ($counter=="0") ? 'active' : ''  }}" id="label-{{ $company->id }}-2" data-toggle="tab" href="#ids-{{ $company->id }}-2" role="tab" aria-controls="ids-{{ $company->id }}-2" aria-selected="true"><i class="nav-icon i-Remove-User mr-1"></i>{{ $company->name }} ( {{ $companies_passports_alt[$counter] ? $companies_passports_alt[$counter]->count() : '0'  }}  ) </a></li>
                                        <?php $counter = $counter+1; ?>
                                    @endforeach
                                    <li class="nav-item"><a class="nav-link" id="label-other_tab_2" data-toggle="tab" href="#ids-other_tab_2" role="tab" aria-controls="ids-other_tab" aria-selected="true"><i class="nav-icon i-Remove-User mr-1"></i>OTHER PASSPORTS ( {{ $not_register_passports_without_company ? $not_register_passports_without_company->count() : '0' }})</a></li>

                                </ul>
                                <?php $counter = 0; ?>


                                <div class="tab-content" id="myIconTab_threeContent">
                                    @foreach($companies as $company)

                                        <div class="tab-pane fade  {{ ($counter=="0") ? ' show active' : ''  }}" id="ids-{{ $company->id }}-2" role="tabpanel" aria-labelledby="label-{{ $company->id }}-2"   @if($counter=="0") style="width: 100% !important;" @endif >
                                            {{ $company->name }}

                                            <div class="table-responsive" >
                                                <table class="display table table-striped table-bordered data_table_cls" id="datatable_ids-{{ $company->id  }}-2" >
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Company</th>
                                                        <th scope="col">Passport Number</th>
                                                        <th scope="col">Full Name</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @if(isset($company))

                                                        @foreach($companies_passports_alt[$counter] as $letter)
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <th scope="row">{{ $company->name }}</th>
                                                                <td>{{ $letter->passport_no }}</td>
                                                                <td>{{ $letter->personal_info ? $letter->personal_info->full_name: 'N/A'  }}</td>
                                                            </tr>
                                                        @endforeach

                                                    @endif



                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <?php $counter = $counter+1; ?>
                                    @endforeach


                                    <div class="tab-pane fade  " id="ids-other_tab_2" role="tabpanel" aria-labelledby="label-other_tab_2">
                                        Other Passports
                                        <div class="table-responsive" >
                                            <table class="display table table-striped table-bordered data_table_cls" id="datatable_ids-other_tab_2" >
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Company</th>
                                                    <th scope="col">Passport Number</th>
                                                    <th scope="col">Full Name</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($not_register_passports_without_company as $letter)
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <th scope="row">{{ $company->name }}</th>
                                                        <td>{{ $letter->passport_no }}</td>
                                                        <td>{{ $letter->personal_info ? $letter->personal_info->full_name: 'N/A'  }}</td>
                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>





                                </div>





                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use-strict'

            $('table.data_table_cls').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],

                dom: 'Bfrtip',

                buttons: [
                    {
                        extend: 'print',
                        title: 'Passport Summary',
                        text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Passport Summary',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Passport Summary',
                        text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
                select: true,

                scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
            });
        });



        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                 // alert(split_ab[1]);




                var table = $('#datatable_'+split_ab[1]).DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();


                var table = $("#datatable_ids-1-2").DataTable();
                $('#container').css( 'display', 'block' );
                $(".data_table_cls .thead-dark").css('width','100% !important');
                table.columns.adjust().draw();

            }) ;




        });






    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>


@endsection
