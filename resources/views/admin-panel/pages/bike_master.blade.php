@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')

    <!---------Delete Model---------->
    <div class="modal fade bd-example-modal-sm" id="delteForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>

                    <div class="modal-body">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                        Are you sure want to delete the data?
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!---------Delete Model ends-------------------------->
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Bike Master</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Bike Details</div>


<!----------------------------------------------------Upload file ------------------------------------------------------------------>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">File inputs <a href="{{ URL::to( '/assets/sample/Bike_sample.csv')}}" target="_blank">(Download Sample File)</a> </div>
                                <form   action="{{ route('file.upload') }}" aria-label="{{ __('Upload') }}" method="post"  enctype="multipart/form-data">
                                    {!! csrf_field() !!}

                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input class="custom-file-input" required id="inputGroupFile02" accept=".csv" name="file_name" type="file" />
                                        <label class="custom-file-label" for="inputGroupFile02"  aria-describedby="inputGroupFileAddon02">Choose file</label>
                                    </div>
                                    <div class="input-group-append"><button class="btn btn-primary">Upload<span class="fa fa-upload fa-right"></span></button></div>
                                </div>
                                </form>
                            </div>
                        </div>
<!-------------------------------------------------Upload File Ends-------------------------------------------------------------->

                </div>
            </div>
        </div>
    </div>
<!-------------------------------------Data Table------------------------------>
    <div class="row">
        <div class="col-md-12">
            <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
            <table  class="table" id="datatable">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Model</th>
                    <th scope="col">Chasis No</th>
                    <th scope="col">Plate No</th>
                    <th scope="col">Make Year</th>
                    <th scope="col">Company</th>
                    <th scope="col">Registration Valid For</th>
                    <th scope="col">No of fines</th>
                    <th scope="col">Fine Amount</th>
                    <th scope="col">Issue Date</th>
                    <th scope="col">Expiry Date</th>
                    <th scope="col">Inurance Co</th>
                    <th scope="col">Mortaged By</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bike as $row)

                    <tr class="data-row">

                        <td>{{$row['model']}}</td>
                        <td>{{$row['chasis_no']}}</td>
                        <td>{{$row['plate_no']}}</td>
                        <td>{{$row['make_year']}}</td>
                        <td>{{$row['company']}}</td>
                        <td>{{$row['registration_valid']}}</td>
                        <td>{{$row['no_of_fines']}}</td>
                        <td>{{$row['fines_amount']}}</td>
                        <td>{{$row['issue_date']}}</td>
                        <td>{{$row['expiry_date']}}</td>
                        <td>{{$row['insurance_co']}}</td>
                        <td>{{$row['mortaged_by']}}</td>
                        <td>
                            <a class="text-success mr-2" href="{{route('bike.edit',$row['id'])}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                            <a class="text-danger mr-2" onclick="deleteData({{$row['id']}})" data-toggle="modal" data-target=".bd-example-modal-sm" >
                                <i class="nav-icon i-Close-Window font-weight-bold"></i></a>

                        </td>


                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
            </div>
        </div>
    </div>
    </div>
    <!------------------------------Data Table Ends--------------------------------------------->

    <!-------modal to edit form---------------------------------->
    <div class="modal fade" id="form_update" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title">Edit Bike</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="hidden_id" style="display: none">
                    @if(isset($edit_bike_data))

                        {{ $id=$edit_bike_data->id }}

                    </div>

                    <form  action="{{action('BikemasterController@update', $id)}}"  method="post">



                        @endif
                        {!! csrf_field() !!}
                        @if(isset($edit_bike_data))

                        {{ method_field('PUT') }}

                        @endif

                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="recipient-name-2">Model:</label>
                            <input class="form-control" id="id" name="id"  value="{{isset($edit_bike_data)?$edit_bike_data->id:""}}" type="hidden"  />
                            <input class="form-control" id="model" name="model"  value="{{isset($edit_bike_data)?$edit_bike_data->model:""}}" type="text"  />
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Chasis No:</label>
                            <input class="form-control" id="chasis_no" name="chasis_no" value="{{isset($edit_bike_data)?$edit_bike_data->chasis_no:""}}" type="text"  />
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label"  for="message-text-1">Plate No:</label>
                            <input class="form-control" id="plate_no" name="plate_no" value="{{isset($edit_bike_data)?$edit_bike_data->plate_no:""}}" type="text"  />
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Make Year:</label>
                            <input class="form-control" id="make_year" name="make_year" value="{{isset($edit_bike_data)?$edit_bike_data->make_year:""}}" type="text"   />
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Registration Valid For:</label>
                            <input class="form-control" id="registration_valid" name="registration_valid" value="{{isset($edit_bike_data)?$edit_bike_data->registration_valid:""}}" type="text"  />
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label"  for="message-text-1">No of Fines:</label>
                            <input class="form-control" id="no_of_fines" name="no_of_fines" value="{{isset($edit_bike_data)?$edit_bike_data->no_of_fines:""}}" type="text"  />
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Fines Amount:</label>
                            <input class="form-control" id="fines_amount" name="fines_amount" value="{{isset($edit_bike_data)?$edit_bike_data->fines_amount:""}}" type="text" />
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Issue Date:</label>
                            <input class="form-control" id="issue_date" name="issue_date" value="{{isset($edit_bike_data)?$edit_bike_data->issue_date:""}}" type="text"  />
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Expiry Date:</label>
                            <input class="form-control" id="expiry_date" name="expiry_date" value="{{isset($edit_bike_data)?$edit_bike_data->expiry_date:""}}" type="text"  />
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Insurance Co:</label>
                            <input class="form-control" id="insurance_co" name="insurance_co" value="{{isset($edit_bike_data)?$edit_bike_data->insurance_co:""}}" type="text"  />
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="col-form-label" for="message-text-1">Mortaged By:</label>
                            <input class="form-control" id="mortaged_by" name="mortaged_by" value="{{isset($edit_bike_data)?$edit_bike_data->mortaged_by:""}}" type="text"  />
                        </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>




    <!-----------------------Edit Model Ends------------------>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [1],"width": "80%"}
                ],

                "scrollY": false,
            });

        });

            function deleteData(id)
            {
                var id = id;

                var url = '{{ route('bike.destroy', ":id") }}';
                url = url.replace(':id', id);

                $("#deleteForm").attr('action', url);
            }

            function deleteSubmit()
            {
                $("#deleteForm").submit();
            }






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

    <?php
    if(isset($edit_bike_data)){ ?>
    <script>
        $(function(){
            $('#form_update').modal('show')
        });



    </script>
    <?php
    }
    ?>
@endsection
