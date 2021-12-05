@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>

    </style>
@endsection
@section('content')
<form method="post" action="{{ route('s3-demo') }}" enctype="multipart/form-data">
    @csrf
    <div class="col-md-6">
        <label for="repair_category">Title</label>
        <input  name="title" class="form-control" type="text">
    </div>
    <div class="col-md-6">
        <label>Attachment</label>
        <div class="custom-file mb-3">
        <input type="file" class="custom-file-input" id="customFile" name="image">
        <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
    <div class="col-md-6 text-center">
        <input type="submit" class="btn btn-primary" value="Submit">
    </div>
</form>

{{-- @foreach ($images as $item) --}}
    <img src="{{Storage::temporaryUrl('assets/upload/riderorder/2021-05-01/2786881619824915.jpg', now()->addMinutes(5))}}" width="100"/>
{{-- @endforeach --}}

@endsection

@section('js')


@endsection
