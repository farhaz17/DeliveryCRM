@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="">LPO Master</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Salik Tags</li>
    </ol>
</nav>


<div class="card container m-auto p-3">
    <div class="row">
        <div class="col-md-4">
            <form method="post" action="{{ route('store-salik-tags') }}" enctype="multipart/form-data">
                @csrf
                <label for="repair_category">Salik tag No</label>
                <input id="" name="tag_no" class="form-control" type="text">
                <input type="submit" class="btn btn-primary mt-1" value="Add">
            </form>
        </div>
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <form method="post" action="{{ route('upload-salik-tags') }}" enctype="multipart/form-data">
                @csrf
                <label for="repair_category">Salik Upload</label>
                <input type="file" name="salik_upload" class="form-control-file" id="" required >
                <a href="{{ asset('assets/sample/salik.xlsx') }}" target="_blank" style="float: right;margin-top: -23px;" >
                    (Download Sample File)
                </a>
                <input type="submit" class="btn btn-primary mt-1" value="Upload">
            </form>
        </div>
    </div>
</div>

@if(Session::has('message'))
    <!-- Modal -->
    @php
        $salik_tag = array_filter(explode(',',session()->get('salik_tag')));
    @endphp
    @if($salik_tag)
    <div class="modal fade" id="SalikTagModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="ModalTitle">Salik Already Uploaded</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                    <p class="m-0">{{ count(explode(',',session()->get('salik_tag'))) . " salik are already uploaded. "}}
                    </p>
                    </div>
                    <div class="responsive">
                        <table class="table table-sm table-hover text-10" id="SalikTagdatatable" width='100%'>
                            <thead>
                                <tr>
                                    <td>Tag No</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $salik_tag as $key => $tags)
                                    <tr>
                                        <td>{{ $salik_tag[$key] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
@endsection
@section('js')

<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script type="text/javascript">
    @if(Session::has('message') && ($salik_tag))
        $(window).on('load', function() {
            $('#SalikTagModal').modal('show');
            $('#SalikTagdatatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Missing Riders',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
            });
        });

    @endif
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
