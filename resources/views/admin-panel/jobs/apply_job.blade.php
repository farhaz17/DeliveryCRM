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
            <li>Apply Job</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row mb-4">

            <div class="col-md-3 mb-4">
            </div>

            <div class="col-md-6 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Apply</h4>

                    <form method="post" enctype="multipart/form-data" aria-label="{{ __('Upload') }}" action="{{route('apply_store')}}">
                        {!! csrf_field() !!}

                                <div class="row">


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">First Name</label>
                                        <input class="form-control form-control" id="first_name" name="first_name"  type="text" placeholder="Enter FirstName Code" required />
                                        <input id="id" name="id"  type="hidden" value="{{$id}}" />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Last Name</label>
                                        <input class="form-control form-control" id="last_name" name="last_name"  type="text" placeholder="Enter Last Name Code" required />
                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Email Address</label>
                                        <input class="form-control form-control" id="email_address" name="email_address"  type="email" placeholder="Enter Email Address" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Phone</label>
                                        <input class="form-control form-control" id="phone_no" name="phone_no"  type="number" placeholder="Enter Phone number" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Education (Add Multiple)</label>
                                        <input class="form-control form-control" id="education" name="education"  type="text" placeholder="Enter Education" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">CV(Uplaod)</label>
                                        <input class="form-control form-control" id="file_name" name="file_name"  type="file" placeholder="Upload CV" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Cover Letter(upload Optional)</label>
                                        <input class="form-control form-control" id="cover_letter" name="cover_letter"  type="text" placeholder="Add Cover Letter" required />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Last Company You Worked For</label>
                                        <input class="form-control form-control" id="last_company" name="last_company"  type="text" placeholder="Enter Last Company You Worked For"  />
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Comments</label>
                                        <input class="form-control form-control" id="comments" name="comments"  type="text" placeholder="Add Any Comments"  />
                                    </div>

                                    <div class="col-md-10 form-group mb-3">
                                        <label for="repair_category">Question</label>
                                        <input class="form-control form-control" id="question" name="question[]"  type="text" placeholder="Ask Any Question"  />
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-icon m-1" id="btn_add_discount_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon">Ask More?</span></button>
                                    </div>
                                    <div class="col-md-12 append_discount_row"></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>

                                    <div class="col-md-10 form-group mb-3">
                                        <label for="repair_category">Reference</label>
                                        <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label for="repair_category">Name</label>
                                            <input class="form-control form-control" id="ref_name" name="ref_name[]"  type="text" placeholder="Add Reference Name"  />
                                        </div>

                                        <div class="col-md-6 form-group mb-3">
                                            <label for="repair_category">Phone Number</label>
                                            <input class="form-control form-control" id="ref_no" name="ref_no[]"  type="number" placeholder="Add Phone Number"  />
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-info btn-icon  mt-4" id="btn_add_ref_row" type="button"><span class="ul-btn__icon">Add More?</span></button>
                                    </div>
                                    <div class="col-md-12 append_ref_row"></div>


                                    <div class="col-md-12 form-group mb-3">
                                            <button type="submit" class="btn btn-primary">Apply Now</button>
                                    </div>
                    </form>

                    </div>


                <div class="col-md-3 mb-4">
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

        function add_new_ref_row(id){
            var html2 = '<div class="row ref_div-'+id+'"><div class="col-md-10 form-group mb-3"><label for="repair_category">Reference</label><div class="row"><div class="col-md-6 form-group mb-3"><label for="repair_category">Name</label><input class="form-control form-control" id="ref_name" name="ref_name[]"  type="text" placeholder="Add Reference Name"  /></div><div class="col-md-6 form-group mb-3"><label for="repair_category">Phone Number</label><input class="form-control form-control" id="ref_no" name="ref_no[]"  type="text" placeholder="Add Phone Number"  /></div></div></div><div class="col-md-2"><button class="btn btn-danger btn-icon m-1 remove_ref_row" id="btn_remove_ref-'+id+'"   type="button"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div></div>';
            return html2;
        }

        var count_ref_ab = 50001
                $("#btn_add_ref_row").click(function () {
                    count_ref_ab = parseInt(count_ref_ab)+1
                    var id_now2 =  count_ref_ab;

                    var html2 =  add_new_ref_row(id_now2);
                    $(".append_ref_row").append(html2);

                });

        </script>
<script>
    $('.append_ref_row').on('click', '.remove_ref_row', function() {

var ids = $(this).attr('id');
var now = ids.split("-");

$(".ref_div-"+now[1]).remove();



});
</script>





{{-- add new row  for quetion--}}
<script>

function add_new_discount_row(id){
    var html = '<div class="row discunt_div-'+id+'"><div class="col-md-10"><input class="form-control form-control" id="question" name="question[]"  type="text" placeholder="Ask Any Question" required /></div><div  class="col-md-2 ><div discunt_div-'+id+'"><button class="btn btn-danger btn-icon m-1 remove_discount_row" id="btn_remove_discount-'+id+'"   type="button"><span class="ul-btn__icon"><i class="i-Remove"></i></span></button></div></div>';
    return html;
}

var count_discount_ab = 50001
        $("#btn_add_discount_row").click(function () {
            count_discount_ab = parseInt(count_discount_ab)+1
            var id_now =  count_discount_ab;

            var html =  add_new_discount_row(id_now);
            $(".append_discount_row").append(html);

            // $("#discount_amount-"+id_now).prop('required',true);
            // $("#discount_name-"+id_now).prop('required',true);

        });

</script>
{{-- delete row for question --}}
<script>
    $('.append_discount_row').on('click', '.remove_discount_row', function() {

var ids = $(this).attr('id');
var now = ids.split("-");

$(".discunt_div-"+now[1]).remove();



});
</script>

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
