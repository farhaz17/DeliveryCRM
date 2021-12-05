@extends('admin-panel.base.main')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">


<style>
    .title-heading {
        white-space: nowrap;
    }
    .card-icon-bg .card-body .content {
        margin: auto;
        display: block;
        flex-direction: column;
        align-items: flex-start;
        max-width: 123px;
    }
    a {
        color: inherit;
    }
    .odd-card {
        background: #e6e6e6;
    }
</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Masters</a></li>

    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">

                <div class="row">

                        <div class="col-md-12">

                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Passport Details</strong></h6>

                               <form action ="{{ route('offer_letter.store') }}" method="POST" >
                                   {!! csrf_field() !!}
                                   <div class="row">

                                       <div class="col-md-3 form-group mb-3">
                                           <label for="repair_category">Passport Number</label>
                                           <select id="passport_number" name="passport_number" class="form-control form-control-rounded">
                                               <option value=""  >Select option</option>
                                               @foreach($passport as $pas)
                                                   <option value="{{ $pas->id }}">{{ $pas->passport_no  }}</option>
                                               @endforeach

                                           </select>
                                       </div>

                                       <div class="col-md-3 form-group mb-3 text-center" id="unique_div" style="display: none;">
                                           <label for="repair_category">Name</label>
                                           <p><p>
                                           <h4><span id="sur_name" ></span>  <span id="given_names" ></span></h4>
                                       </div>

                                       <div class="col-md-3 form-group mb-3 text-center" id="pic_div" style="display: none;">
                                           <label for="repair_category">Picture</label>
                                           <p><p>

                                               <a href="" id="passport_image" target="_blank">View Picture</a>
                                       </div>

                                       <div class="col-md-3 form-group mb-3 text-center" id="exp_div" style="display: none;">
                                           <label for="repair_category">Expiry Days Left</label>
                                           <p><p>

                                           <h4 id="exp_days"></h4>
                                                                                     </div>

                                  </div>
                               </form>
                                   </div>

                                </div>

                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Offer Letter</strong></h6>
                                    <form action ="{{ route('offer_letter.store') }}" method="POST" enctype="multipart/form-data" aria-label="{{ __('Upload') }}">
                                        {!! csrf_field() !!}
                                   <div class="row">

                                    <div class="col-md-3">
                                        <label for="repair_category">ST No</label>
                                        <input class="form-control form-control" id="st_no" name="st_no"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Date & Time</label>
                                        <input class="form-control form-control" id="date_and_time" name="date_and_time"  type="date" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Payment Amount</label>
                                        <input class="form-control form-control" id="payment_amount" name="payment_amount"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Payment Type</label>
                                        <input class="form-control form-control" id="payment_type" name="payment_type"  type="text" placeholder="Enter Country Code" required />
                                    </div>


                                  </div>


                                        <div class="row">

                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Number</label>
                                                <input class="form-control form-control" id="transaction_no" name="transaction_no"  type="text" placeholder="Enter Country Code" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Transaction Date & Time</label>
                                                <input class="form-control form-control" id="transaction_date_time" name="transaction_date_time"  type="datetime-local" placeholder="Enter Country Code" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Vat</label>
                                                <input class="form-control form-control" id="vat" name="vat"  type="text" placeholder="Enter Country Code" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Invoice Attachment</label>
                                                <input class="form-control form-control" id="file_name" name="file_name"  type="file" placeholder="Enter Country Code" required />
                                            </div>


                                        </div>
                                        <div class="row">

                                            <div class="col-md-12 form-group">


                                                <button class="btn btn-primary">Save</button>
                                            </div>


                                        </div>

                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Offer Letter Submission</strong></h6>
                                    <form action ="{{ route('offer_letter_sub.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">MB Number</label>
                                        <input class="form-control form-control" id="mb_no" name="mb_no"  type="text" placeholder="Enter MB Number" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Date & Time</label>
                                        <input class="form-control form-control" id="date_and_time" name="date_and_time"  type="date"  required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Attachment</label>
                                        <input class="form-control form-control" id="file_name" name="file_name"  type="file"  required />
                                    </div>
                                    <div class="col-md-3">

                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Electronic Pre Approval</strong></h6>
                                    <form action ="{{ route('electronic_pre_app.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="repair_category">MB Number</label>
                                                <input class="form-control form-control" id="mb_no" name="mb_no"  type="text" placeholder="Enter MB Number" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Labour Card Number</label>
                                                <input class="form-control form-control" id="labour_card_no" name="labour_card_no"  type="text"  required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Issue Date</label>
                                                <input class="form-control form-control" id="issue_date" name="issue_date"  type="date"  required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Expiry Date</label>
                                                <input class="form-control form-control" id="expiry_date" name="expiry_date"  type="date"  required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"></label>
                                                <button class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Electronic Pre Approval Payment</strong></h6>
                                    <form action ="{{ route('electronic_pre_app.store') }}" method="POST" enctype="multipart/form-data">
                                        {!! csrf_field() !!}

                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="repair_category">Payment Number</label>
                                                <input class="form-control form-control" id="payment_number" name="payment_number"  type="text" placeholder="Enter MB Number" required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">La</label>
                                                <input class="form-control form-control" id="payment_type" name="payment_type"  type="text"  required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Issue Date</label>
                                                <input class="form-control form-control" id="issue_date" name="issue_date"  type="date"  required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category">Expiry Date</label>
                                                <input class="form-control form-control" id="expiry_date" name="expiry_date"  type="date"  required />
                                            </div>
                                            <div class="col-md-3">
                                                <label for="repair_category"></label>
                                                <button class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Entry Print Visa Inside</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Entry Print Visa Outside</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                             <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Status Change</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>In-Out Status Change</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Entry Date</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (Normal)</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (48 Hours)</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (24 Hours)</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Medical (VIP)</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Fit - Unfit</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                              <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Emirates ID Apply</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Emirates ID Finger Print(Yes/No)</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>New Contract Application Typing</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Tawjeeh Class</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>New Country Submission</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Labour Card Print</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Visa Stampiy Application(Urgent/Normal)</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Waiting For Approval(Urgent/Normal)</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Waiting For Zajed</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Visa Pasted</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>


                            <div class="card mb-4 odd-card">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Unique Email ID Received</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-3"><strong>Unique Email ID Handover</strong></h6>
                                    <form>

                                   <div class="row">
                                    <div class="col-md-3">
                                        <label for="repair_category">Label</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label2</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                        <div class="col-md-3">
                                        <label for="repair_category">Label3</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="repair_category">Label4</label>
                                        <input class="form-control form-control" id="country_code" name="country_code"  type="text" placeholder="Enter Country Code" required />
                                    </div>
                                  </div>
                                    </form>
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
                    <script>

                        // $(".select2-container").css('width','100%');


                        $("#passport_number").change(function () {
                            $("#unique_div").css('display','block');
                            var passport_id = $(this).val();
                            var token = $("input[name='_token']").val();
                            $.ajax({
                                url: "{{ route('ajax_get_passport') }}",
                                method: 'POST',
                                data: {passport_id: passport_id, _token:token},
                                success: function(response) {

                                    var res = response.split('$');
                                    $("#sur_name").html(res[0]);
                                    $("#given_names").html(res[1]);
                                    $("#passport_image").attr('href',res[2]);
                                    $("#exp_days").html(res[3]);

                                    $("#pic_div").show();
                                    $("#exp_div").show();


                                }
                            });

                        });
                        </script>
                        <script>
                        $(document).ready(function () {


                            $('#passport_number').select2({
                                placeholder: 'Select an option'
                            });

                            tail.DateTime("#date_and_time",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#date_and_time",{
                                    dateStart: $('#date_and_time').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });


                            tail.DateTime("#issue_date",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#issue_date",{
                                    dateStart: $('#issue_date').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });
                            tail.DateTime("#expiry_date",{
                                dateFormat: "YYYY-mm-dd",
                                timeFormat: false,

                            }).on("change", function(){
                                tail.DateTime("#expiry_date",{
                                    dateStart: $('#expiry_date').val(),
                                    dateFormat: "YYYY-mm-dd",
                                    timeFormat: false

                                }).reload();

                            });


                        });



                    </script>
                    <script type="text/javascript">
                        function submitform() {   document.myform.submit(); }
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
