@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .hide_cls{
            display: none;
        }
        </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Jobs</a></li>
            <li>Create Job</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row mb-4">

            <div class="col-md-2 mb-4">
            </div>

            <div class="col-md-8 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Create Job</h4>

                    <form method="post" enctype="multipart/form-data" aria-label="{{ __('Upload') }}" action="{{isset($parts_data)?route('jobs.update',$parts_data->id):route('jobs.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
                                <div class="row">
                                    <div class="col-md-6  mb-3">
                                        <label for="repair_category">Company</label>
                                        <select id="company" name="company" class="form-control" required>
                                            <option selected disabled>Select option</option>
                                            <option value="100">CONFIDENTIAL</option>
                                            @foreach($company as $row)
                                                <option value="{{ $row->id }}">{{ $row->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Job Title</label>
                                        <input class="form-control form-control" id="job_title" name="job_title"  type="text" placeholder="Enter Country Code" required />
                                    </div>


                                    <div class="col-md-6  mb-3">
                                        <label for="repair_category">State</label>
                                        <select id="state" name="state" class="form-control">
                                            <option selected disabled>Select option</option>

                                            @foreach($states as $row)
                                                <option value="{{ $row->id }}">{{ $row->name  }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Qualification</label>
                                        <input class="form-control form-control" id="qualification" name="qualification" type="text" placeholder="Enter Given Name" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Experience</label>
                                        <input class="form-control form-control" id="experience" name="experience" type="text" placeholder="Enter Father_name"  />
                                    </div>

                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Job Description</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <textarea class="ckeditor form-control form-control-sm" rows="4" id="job_description" name="job_description" required></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Start Date</label>
                                        <input class="form-control form-control" id="start_date" name="start_date" type="date" placeholder="Enter Date of Birth" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">End Date</label>
                                        <input class="form-control form-control" id="end_date" autocomplete="off" name="end_date" type="date" placeholder="Enter Place Of Birth" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                            <button type="submit" name="submit" class="btn btn-primary">Create Job</button>
                                    </div>
                    </form>

                    </div>


                <div class="col-md-2 mb-4">
                </div>
            </div>




        </div>





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/plugins/ckeditor/ckeditor.js')}}"></script>





<script>
     $('#company').select2({
        placeholder: 'Select an option'
    });
    $('#state').select2({
        placeholder: 'Select an option'
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
