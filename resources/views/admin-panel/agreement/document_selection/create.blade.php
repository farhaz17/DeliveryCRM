@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Category</a></li>
            <li>Set Agreement Documents</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Add Selection For Master</div>
                    <form method="post" action="{{ route('document_selection.store')  }}">
                        {!! csrf_field() !!}


                        <div class="row ">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Select Parent</label>
                                <select class="form-control  main_category" name="category[]" id="category" >
                                    <option value="">select an option</option>
                                    @foreach($parents as $parent)

                                        <option value="{{ $parent->id  }}">{{ $parent->get_parent_name->name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row class_selection append_cls">

                        </div>

                        <div class="row amount">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Name of Document</label>
                                <input type="text" name="name" id="name" class="form-control" required >
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Is Mandatory or Not</label>
                                <select class="form-control" name="is_mandatory"  required >
                                    <option value="" disabled selected>Selected option please</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>

                            </div>

                        </div>




                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary pull-right" type="submit">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cateogry</th>
                            <th scope="col">Sub Category Names</th>
                            <th scope="col">Is Mandatory</th>
                        </tr>
                        </thead>
                        <tbody>




                        @foreach($array_to_send as $ab)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ $ab['parent_name'] }}</td>
                                <td>
                                    <?php $count = 0; ?>
                                    @foreach($ab['childs'] as $childs)
                                        @if($count=="0")
                                        @else
                                            {{ $childs->get_parent_name->name_alt."," }}
                                        @endif
                                        <?php  $count = $count+1; ?>
                                    @endforeach
                                </td>
                                <td>{{ ($ab['is_mandatory']=="1") ? "YES" : "NO"   }}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

            $('#category').select2({
                placeholder: 'Select an option'
            });

        });


        // $('.class_selection').on('change', '.category_change', function() {

        $(".main_category").change(function () {

            $(".append_html").remove();

            var ids = $(this).val();

            // alert(ids);


            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_render_child') }}",
                method: 'POST',
                dataType: 'json',
                data: {parent_id: ids, _token:token},
                success: function(response) {

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }
                    var options = "";
                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                            var id = response['data'][i].id;
                            var name = response['data'][i].name;



                            //  options = "<option value='"+id+"'>"+name+"</option>";
                            // $("#testing_select").append(options);
                            options += "<option value='"+id+"'>"+name+"</option>";

                        }






                        $(".append_cls").append(html_select_render(options,1));
                    }

                }
            });




        });


        var count_ab = 2;

        $('.class_selection').on('change', '.category_change', function() {

            var ids = $(this).val();

            var ids_now = $(this).attr('id');

            var id_number_now = ids_now.split('-')

            // var start_loop = parseInt(id_number_now[1])+1;
            //
            // for(var i=start_loop; i<60; i++){
            //     $("#"+i).remove();
            // }

            var clear_id = parseInt(id_number_now[1])+1;

            $('.append_html').filter(function(i) {
                return (this.id >= clear_id);
            }).remove();


            // alert(ids);




            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_render_child') }}",
                method: 'POST',
                dataType: 'json',
                data: {parent_id: ids, _token:token},
                success: function(response) {

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }else{

                    }

                    var options = "";
                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                            var id = response['data'][i].id;
                            var name = response['data'][i].name;



                            //  options = "<option value='"+id+"'>"+name+"</option>";
                            // $("#testing_select").append(options);
                            options += "<option value='"+id+"'>"+name+"</option>";

                        }




                        count_ab = count_ab+1;

                        $(".append_cls").append(html_select_render(options,count_ab));
                    }






                }
            });




        });



        function html_select_render(options,div_id){

            var html = '<div class="col-md-3 form-group mb-3 append_html" id="'+div_id+'"><label for="repair_category">Select Parent</label><select class="form-control category_change" name="category[]" id="abcd-'+div_id+'" ><option value="">select an option</option>'+options+'</select></div>';
            return html;
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

@endsection
