@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    </style>
@endsection
@section('content')

<div class="col-12">
    <div class="card col-md-12 mb-2">
        <form action="{{route('project.update_status')}}" method="post">
            <div class="card-body row">
                <div class="col">
                    @csrf
                    <input type="hidden" name="status_change_to" id="status_change_to">
                    <div class="card-title mb-3 col-12">Project Status</div>
                    <div class="row">
                        <div class="col-md-4  mb-3">
                            <label for="repair_category">Project Name</label>
                            <select id="nation_id" name="project_name" class="form-control" required>
                                <option value=""  >Select option</option>
                                @foreach($project as $pro)
                                @php
                                $isSelected=(isset($projects_data)?$projects_data->company:"")==$pro->id;
                            @endphp
                                    <option value="{{ $pro->id }}" {{ $isSelected ? 'selected': '' }}>{{ $pro->project_name  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4  mb-3">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                        <input type="hidden" id="id" name="id" value="">

                    </div>
                    <button class="btn btn-primary submit-btn"> Inactive</button>
                    <button class="btn btn-primary submit-btn"> Close</button>


                    <div id="attachment_holder"></div>
                </div>

            </div>
        </form>
    </div>
@endsection

@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('select.select2').select2({
            allowClear: true,
        });
    });
</script>

<script>
    $(document).ready(function(){
      $("select").change(function(){
        var name = $('#nation_id').val();
        $("#id").val(name);
      });
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
<script>
    // Add remove loading class on body element depending on Ajax request status
    $(document).on({
        ajaxStart: function(){
            $("body").addClass("loading");
        },
        ajaxStop: function(){
            $("body").removeClass("loading");
        }
    });
</script>
@endsection
