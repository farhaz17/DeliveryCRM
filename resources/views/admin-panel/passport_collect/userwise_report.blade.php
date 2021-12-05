@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport Transfer report</a></li>
            <li>Passport Details</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

<div class="col-lg-12 col-md-12">
    <div class="card mb-6">
        <div class="card-body">
            <div class="card-title">Passports</div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card mb-4 sim-card o-hidden">
                        <div class="card-body">
                            <div class="ul-widget__row-v2" style="position: relative;">

                                <div class="ul-widget__content-v2">
                                    <i class="i-Arrow-Forward text-white bg-success rounded-circle p-2 mr-0"></i>
                                    <h4 class="heading mt-3 ml-0">{{ $passports_received }}</h4>
                                    <p class="text-muted m-0 font-weight-bold">Passports Received</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card mb-4 sim-card o-hidden">
                        <div class="card-body">
                            <div class="ul-widget__row-v2" style="position: relative;">

                                <div class="ul-widget__content-v2">
                                    <i class="i-Arrow-Forward text-white bg-danger rounded-circle p-2 mr-0"></i>
                                    <h4 class="heading mt-3 ml-0">{{ $passports_transferred }}</h4>
                                    <p class="text-muted m-0 font-weight-bold">Passports Transferred</p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card mb-4 sim-card o-hidden">
                        <div class="card-body">
                            <div class="ul-widget__row-v2" style="position: relative;">

                                <div class="ul-widget__content-v2">
                                    <i class="i-Arrow-Circle text-white bg-success rounded-circle p-2 mr-0"></i>
                                    <h4 class="heading mt-3 ml-0">{{ $passports_holding }}</h4>
                                    <p class="text-muted m-0 font-weight-bold">Passports Holding</p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

@endsection