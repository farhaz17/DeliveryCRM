@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        tr {
            white-space: nowrap;
            font-size: 12px;
        }
        #datatable .table th, .table td{
        border-top : unset !important;
    }
    /* .table th, .table td{
        padding: 0px !important;
    } */
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
    }
    .table td{
        padding: 6px;
        font-size: 12px;
        height: 20px;
        width: 20px;
        text-align: center;
        vertical-align: middle;
    }
    /* .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
    } */
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Passport</a></li>
            <li>Status</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">New Requests ({{count($vendor_new)}})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Accepted Requests({{count($vendor_accept)}})</a></li>
                    <li class="nav-item"><a class="nav-link" id="zds-basic-tab" data-toggle="tab" href="#zdsBasic" role="tab" aria-controls="zdsBasic" aria-selected="false">Rejected Requests( {{count($vendor_reject)}} )</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <h2>New Requests</h2>
                        <table class="display table table-striped table-bordered" id="datatable1" style="width: 100%" >
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Date & Time Applied</th>
                                    <th scope="col">Reqest No</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Telephone</th>
                                    <th scope="col">Company Email Address</th>
                                    <th scope="col">Company Website</th>
                                    <th scope="col">ZIP Code</th>
                                    <th scope="col">Company Address</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Account No</th>
                                    <th scope="col">Benificiary name</th>
                                    <th scope="col">IBAN No</th>
                                    <th scope="col">Bank Address</th>
                                    <th scope="col">Aurtorized E.I.D</th>
                                    <th scope="col">Passport Expiry</th>
                                    <th scope="col">Company Represetative</th>
                                    <th scope="col">Contatcs Email</th>
                                    <th scope="col">Mobile No</th>
                                    <th scope="col">Contatcs Email</th>
                                    <th scope="col">Contacts Telephone No</th>
                                    <th scope="col">Key Accounts Rep</th>
                                    <th scope="col">Key Account Email</th>
                                    <th scope="col">Key Mobile</th>
                                    <th scope="col">Key Account Email</th>
                                    <th scope="col">Key Telefone</th>
                                    <th scope="col">Type Of Business</th>
                                    <th scope="col">Company Is</th>
                                    <th scope="col">Compnany Est. Date</th>
                                    <th scope="col">Est Code</th>
                                    <th scope="col">Trade License No</th>
                                    <th scope="col">TAX ID</th>
                                    <th scope="col">Trad License Expory</th>
                                    <th scope="col">Legal Structure</th>

                                    <th scope="col">Trade License</th>
                                    <th scope="col">VAT Certificate</th>
                                    <th scope="col">Owener Passport Copy</th>
                                    <th scope="col">Owner Visa Copy</th>
                                    <th scope="col">Owner Emirates ID Copy</th>
                                    <th scope="col">Est. card</th>
                                    <th scope="col">E-signature Card</th>
                                    <th scope="col">Company Labour Card</th>
                                    <th scope="col">Other</th>
                                    <th scope="col">Action</th>
                                </tr>

                            </thead>
                            <tbody>
                            @foreach($vendor_new as $row)
                            <tr>
                                <td>
                                    <a class="text-success mr-2" href="{{route('vendor_portal.edit',$row->id)}}">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                </td>
                                <td>{{ date('d-m-Y-h:m:s', strtotime($row->created_at))}} </td>
                                <td> {{isset($row->request_no)?$row->request_no:"N/A"}}</td>
                                <td> {{isset($row->name)?$row->name:"N/A"}}</td>
                                <td> {{isset($row->address)?$row->address:"N/A"}}</td>
                                <td> {{isset($row->phone_no)?$row->phone_no:"N/A"}}</td>
                                <td> {{isset($row->email)?$row->email:"N/A"}}</td>
                                <td> {{isset($row->company_website)?$row->company_website:"N/A"}}</td>
                                <td> {{isset($row->zip_code)?$row->zip_code:"N/A"}}</td>
                                <td> {{isset($row->company_address)?$row->company_address:"N/A"}}</td>
                                <td> {{isset($row->bank_name)?$row->bank_name:"N/A"}}</td>
                                <td> {{isset($row->account_number)?$row->account_number:"N/A"}}</td>
                                <td> {{isset($row->benificiary_name)?$row->benificiary_name:"N/A"}}</td>
                                <td> {{isset($row->iban_number)?$row->iban_number:"N/A"}}</td>
                                <td> {{isset($row->bank_address)?$row->bank_address:"N/A"}}</td>
                                <td> {{isset($row->aurtorized_eid)?$row->aurtorized_eid:"N/A"}}</td>
                                <td> {{isset($row->passport_expiry)?$row->passport_expiry:"N/A"}}</td>
                                <td> {{isset($row->company_rep_name)?$row->company_rep_name:"N/A"}}</td>
                                <td> {{isset($row->contatcs_email)?$row->contatcs_email:"N/A"}}</td>
                                <td> {{isset($row->mobile_no)?$row->mobile_no:"N/A"}}</td>
                                <td> {{isset($row->contatcs_email)?$row->contatcs_email:"N/A"}}</td>
                                <td> {{isset($row->contacts_telephone_number)?$row->contacts_telephone_number:"N/A"}}</td>
                                <td> {{isset($row->key_accounts_rep)?$row->key_accounts_rep:"N/A"}}</td>
                                <td> {{isset($row->key_account_email)?$row->key_account_email:"N/A"}}</td>
                                <td> {{isset($row->key_mobile)?$row->key_mobile:"N/A"}}</td>
                                <td> {{isset($row->key_account_email)?$row->key_account_email:"N/A"}}</td>
                                <td> {{isset($row->key_telefone)?$row->key_telefone:"N/A"}}</td>
                                <td> {{isset($row->type_of_business)?$row->type_of_business:"N/A"}}</td>
                                @if(isset($row->company_is))
                                    @if($row->company_is=='1')
                                        <td>Licensed</td>
                                    @else

                                        <td>Inssured</td>
                                    @endif
                                    @else
                                    <td>N/A</td>
                                @endif
                                <td> {{isset($row->compnany_est_date)?$row->compnany_est_date:"N/A"}}</td>
                                <td> {{isset($row->est_code)?$row->est_code:"N/A"}}</td>
                                <td> {{isset($row->trade_linces_no)?$row->trade_linces_no:"N/A"}}</td>
                                <td> {{isset($row->text_id)?$row->text_id:"N/A"}}</td>
                                <td> {{isset($row->trad_license_exp_date)?$row->trad_license_exp_date:"N/A"}}</td>


                                @if(isset($row->legal_structure))
                                    @if($row->legal_structure=='1')
                                        <td>Sole Proprietor</td>
                                        @elseif($row->legal_structure=='2')
                                        <td>Partenership</td>
                                        @elseif($row->legal_structure=='3')
                                        <td>Private Limited</td>
                                        @elseif($row->legal_structure=='4')
                                        <td>Public Limited</td>
                                        @elseif($row->legal_structure=='5')
                                        <td>Public Sector</td>
                                        @elseif($row->legal_structure=='6')
                                        <td>LLC</td>
                                        @else
                                        <td>Legal Agent</td>
                                    @endif
                                    @else
                                    <td>N/A</td>

                                    @endif


                                    @if(isset($row->trade_license))
                                   <td>
                                       <a class="attachment_display" href="{{ isset($row->trade_license) ? Storage::temporaryUrl($row->trade_license, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Trade License</strong></a></td>
                                    </td>
                                       @else
                                    <td>
                                        N/A
                                    </td>
                                    @endif


                                    @if(isset($row->vat_certificate))
                                    <td>
                                        <a class="attachment_display" href="{{ isset($row->vat_certificate) ? Storage::temporaryUrl($row->vat_certificate, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Vat Certificate</strong></a></td>
                                 </td>
                                        @else
                                     <td>
                                         N/A
                                     </td>
                                     @endif

                                     @if(isset($row->owener_passport_copy))
                                     <td>
                                         <a class="attachment_display" href="{{ isset($row->owener_passport_copy) ? Storage::temporaryUrl( $row->owener_passport_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Passport Copy</strong></a></td>
                                  </td>
                                         @else
                                      <td>
                                          N/A
                                      </td>
                                      @endif


                                      @if(isset($row->owner_visa_copy))
                                      <td>
                                          <a class="attachment_display" href="{{ isset($row->owner_visa_copy) ? Storage::temporaryUrl($row->owner_visa_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Owner visa Copy</strong></a></td>
                                   </td>
                                          @else
                                       <td>
                                           N/A
                                       </td>
                                       @endif


                                       @if(isset($row->owener_emirates_id_copy))
                                       <td>
                                           <a class="attachment_display" href="{{ isset($row->owener_emirates_id_copy) ? Storage::temporaryUrl($row->owener_emirates_id_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Owner Emirates ID</strong></a></td>
                                    </td>
                                           @else
                                        <td>
                                            N/A
                                        </td>
                                        @endif


                                        @if(isset($row->est_card))
                                        <td>
                                            <a class="attachment_display" href="{{ isset($row->est_card) ? Storage::temporaryUrl($row->est_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Estabishment Card</strong></a></td>
                                     </td>
                                            @else
                                         <td>
                                             N/A
                                         </td>
                                         @endif

                                         @if(isset($row->e_signature_card))
                                         <td>
                                          <a class="attachment_display" href="{{ isset($row->e_signature_card) ? Storage::temporaryUrl($row->e_signature_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View E Signature Card</strong></a>
                                        </td>
                                             @else
                                          <td>
                                              N/A
                                          </td>
                                          @endif


                                          @if(isset($row->company_labour_card))

                                            <td>  <a class="attachment_display" href="{{ isset($row->company_labour_card) ? Storage::temporaryUrl($row->company_labour_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Labour Card</strong></a></td>

                                              @else
                                           <td>
                                               N/A
                                           </td>
                                           @endif

                                           @if(isset($row->other_doc))

                                           <td>  <a class="attachment_display" href="{{ isset($row->other_doc) ? Storage::temporaryUrl($row->other_doc, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">Other</strong></a></td>

                                             @else
                                          <td>
                                              N/A
                                          </td>
                                          @endif


                                    <td>
                                        <button class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="vendor_req_accept({{$row->id}})" type="button">Accept</button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="vendor_req_reject({{$row->id}})" type="button">Reject</button>

                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>


                    </div>

                    {{--                    tab2--}}
                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


                        <h2>Accepted Requests</h2>
                        <table class="display table table-striped table-bordered" id="datatable3" style="width: 100%" >
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Edit</th>

                                    <th scope="col">Date & Time Applied</th>
                                    <th scope="col">Reqest No</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Telephone</th>
                                    <th scope="col">Company Email Address</th>
                                    <th scope="col">Company Website</th>
                                    <th scope="col">ZIP Code</th>
                                    <th scope="col">Company Address</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Account No</th>
                                    <th scope="col">Benificiary name</th>
                                    <th scope="col">IBAN No</th>
                                    <th scope="col">Bank Address</th>
                                    <th scope="col">Aurtorized E.I.D</th>
                                    <th scope="col">Passport Expiry</th>
                                    <th scope="col">Company Represetative</th>
                                    <th scope="col">Contatcs Email</th>
                                    <th scope="col">Mobile No</th>
                                    <th scope="col">Contatcs Email</th>
                                    <th scope="col">Contacts Telephone No</th>
                                    <th scope="col">Key Accounts Rep</th>
                                    <th scope="col">Key Account Email</th>
                                    <th scope="col">Key Mobile</th>
                                    <th scope="col">Key Account Email</th>
                                    <th scope="col">Key Telefone</th>
                                    <th scope="col">Type Of Business</th>
                                    <th scope="col">Company Is</th>
                                    <th scope="col">Compnany Est. Date</th>
                                    <th scope="col">Est Code</th>
                                    <th scope="col">Trade License No</th>
                                    <th scope="col">TAX ID</th>
                                    <th scope="col">Trad License Expory</th>
                                    <th scope="col">Legal Structure</th>

                                    <th scope="col">Trade License</th>
                                    <th scope="col">VAT Certificate</th>
                                    <th scope="col">Owener Passport Copy</th>
                                    <th scope="col">Owner Visa Copy</th>
                                    <th scope="col">Owner Emirates ID Copy</th>
                                    <th scope="col">Est. card</th>
                                    <th scope="col">E-signature Card</th>
                                    <th scope="col">Company Labour Card</th>
                                    <th scope="col">Other</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($vendor_accept as $row)
                            <tr>
                                <td>
                                    <a class="text-success mr-2" href="{{route('vendor_portal.edit',$row->id)}}">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                </td>
                                <td>{{ date('d-m-Y-h:m:s', strtotime($row->created_at))}} </td>
                                <th> {{isset($row->request_no)?$row->request_no:"N/A"}}</th>
                                <td> {{isset($row->name)?$row->name:"N/A"}}</td>
                                <td> {{isset($row->address)?$row->address:"N/A"}}</td>
                                <td> {{isset($row->phone_no)?$row->phone_no:"N/A"}}</td>
                                <td> {{isset($row->email)?$row->email:"N/A"}}</td>
                                <td> {{isset($row->company_website)?$row->company_website:"N/A"}}</td>
                                <td> {{isset($row->zip_code)?$row->zip_code:"N/A"}}</td>
                                <td> {{isset($row->company_address)?$row->company_address:"N/A"}}</td>
                                <td> {{isset($row->bank_name)?$row->bank_name:"N/A"}}</td>
                                <td> {{isset($row->account_number)?$row->account_number:"N/A"}}</td>
                                <td> {{isset($row->benificiary_name)?$row->benificiary_name:"N/A"}}</td>
                                <td> {{isset($row->iban_number)?$row->iban_number:"N/A"}}</td>
                                <td> {{isset($row->bank_address)?$row->bank_address:"N/A"}}</td>
                                <td> {{isset($row->aurtorized_eid)?$row->aurtorized_eid:"N/A"}}</td>
                                <td> {{isset($row->passport_expiry)?$row->passport_expiry:"N/A"}}</td>
                                <td> {{isset($row->company_rep_name)?$row->company_rep_name:"N/A"}}</td>
                                <td> {{isset($row->contatcs_email)?$row->contatcs_email:"N/A"}}</td>
                                <td> {{isset($row->mobile_no)?$row->mobile_no:"N/A"}}</td>
                                <td> {{isset($row->contatcs_email)?$row->contatcs_email:"N/A"}}</td>
                                <td> {{isset($row->contacts_telephone_number)?$row->contacts_telephone_number:"N/A"}}</td>
                                <td> {{isset($row->key_accounts_rep)?$row->key_accounts_rep:"N/A"}}</td>
                                <td> {{isset($row->key_account_email)?$row->key_account_email:"N/A"}}</td>
                                <td> {{isset($row->key_mobile)?$row->key_mobile:"N/A"}}</td>
                                <td> {{isset($row->key_account_email)?$row->key_account_email:"N/A"}}</td>
                                <td> {{isset($row->key_telefone)?$row->key_telefone:"N/A"}}</td>
                                <td> {{isset($row->type_of_business)?$row->type_of_business:"N/A"}}</td>
                                @if(isset($row->company_is))
                                    @if($row->company_is=='1')
                                        <td>Licensed</td>
                                    @else

                                        <td>Inssured</td>
                                    @endif
                                    @else
                                    <td>N/A</td>
                                @endif
                                <td> {{isset($row->compnany_est_date)?$row->compnany_est_date:"N/A"}}</td>
                                <td> {{isset($row->est_code)?$row->est_code:"N/A"}}</td>
                                <td> {{isset($row->trade_linces_no)?$row->trade_linces_no:"N/A"}}</td>
                                <td> {{isset($row->text_id)?$row->text_id:"N/A"}}</td>
                                <td> {{isset($row->trad_license_exp_date)?$row->trad_license_exp_date:"N/A"}}</td>


                                @if(isset($row->legal_structure))
                                    @if($row->legal_structure=='1')
                                        <td>Sole Proprietor</td>
                                        @elseif($row->legal_structure=='2')
                                        <td>Partenership</td>
                                        @elseif($row->legal_structure=='3')
                                        <td>Private Limited</td>
                                        @elseif($row->legal_structure=='4')
                                        <td>Public Limited</td>
                                        @elseif($row->legal_structure=='5')
                                        <td>Public Sector</td>
                                        @elseif($row->legal_structure=='6')
                                        <td>LLC</td>
                                        @else
                                        <td>Legal Agent</td>
                                    @endif
                                    @else
                                    <td>N/A</td>

                                    @endif


                                    @if(isset($row->trade_license))
                                   <td>
                                    <a class="attachment_display" href="{{ isset($row->trade_license) ? Storage::temporaryUrl($row->trade_license, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Trade License</strong></a>
                                </td>
                                       @else
                                    <td>
                                        N/A
                                    </td>
                                    @endif


                                    @if(isset($row->vat_certificate))
                                    <td>
                                        <a class="attachment_display" href="{{ isset($row->vat_certificate) ? Storage::temporaryUrl($row->vat_certificate, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Vat Certificate</strong></a>
                                 </td>
                                        @else
                                     <td>
                                         N/A
                                     </td>
                                     @endif

                                     @if(isset($row->owener_passport_copy))
                                     <td>
                                        <a class="attachment_display" href="{{ isset($row->owener_passport_copy) ? Storage::temporaryUrl($row->owener_passport_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Passport Copy</strong></a>
                                  </td>
                                         @else
                                      <td>
                                          N/A
                                      </td>
                                      @endif


                                      @if(isset($row->owner_visa_copy))
                                      <td>
                                        <a class="attachment_display" href="{{ isset($row->owner_visa_copy) ? Storage::temporaryUrl($row->owner_visa_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Owner visa Copy</strong></a>
                                   </td>
                                          @else
                                       <td>
                                           N/A
                                       </td>
                                       @endif


                                       @if(isset($row->owener_emirates_id_copy))
                                       <td>
                                        <a class="attachment_display" href="{{ isset($row->owener_emirates_id_copy) ? Storage::temporaryUrl($row->owener_emirates_id_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Owner Emirates ID</strong></a>
                                    </td>
                                           @else
                                        <td>
                                            N/A
                                        </td>
                                        @endif


                                        @if(isset($row->est_card))
                                        <td>
                                            <a class="attachment_display" href="{{ isset($row->est_card) ? Storage::temporaryUrl($row->est_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Estabishment Card</strong></a>
                                     </td>
                                            @else
                                         <td>
                                             N/A
                                         </td>
                                         @endif

                                         @if(isset($row->e_signature_card))
                                         <td>
                                            <a class="attachment_display" href="{{ isset($row->e_signature_card) ? Storage::temporaryUrl($row->e_signature_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View E Signature Card</strong></a>
                                        </td>
                                             @else
                                          <td>
                                              N/A
                                          </td>
                                          @endif


                                          @if(isset($row->company_labour_card))

                                            <td>  <a class="attachment_display" href="{{ isset($row->company_labour_card) ? Storage::temporaryUrl($row->company_labour_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Labour Card</strong></a>

                                              @else
                                           <td>
                                               N/A
                                           </td>
                                           @endif

                                           @if(isset($row->other_doc))

                                           <td>  <a class="attachment_display" href="{{ isset($row->other_doc) ? Storage::temporaryUrl($row->other_doc, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">Other</strong></a>

                                             @else
                                          <td>
                                              N/A
                                          </td>
                                          @endif

                                    <td>
                                        <button class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="vendor_req_accept({{$row->id}})" type="button">Accept</button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="vendor_req_reject({{$row->id}})" type="button">Reject</button>

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>


                    </div>

                    {{--                    tab3--}}
                    <div class="tab-pane fade show" id="zdsBasic" role="tabpanel" aria-labelledby="zds-basic-tab" >


                        <h2>Rejected Requests</h2>
                        <table class="display table table-striped table-bordered" id="datatable4" style="width: 100%" >
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Edit</th>
                                    <th scope="col">Date & Time Applied</th>
                                    <th scope="col">Reqest No</th>
                                    <th scope="col">Company Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Telephone</th>
                                    <th scope="col">Company Email Address</th>
                                    <th scope="col">Company Website</th>
                                    <th scope="col">ZIP Code</th>
                                    <th scope="col">Company Address</th>
                                    <th scope="col">Bank Name</th>
                                    <th scope="col">Account No</th>
                                    <th scope="col">Benificiary name</th>
                                    <th scope="col">IBAN No</th>
                                    <th scope="col">Bank Address</th>
                                    <th scope="col">Aurtorized E.I.D</th>
                                    <th scope="col">Passport Expiry</th>
                                    <th scope="col">Company Represetative</th>
                                    <th scope="col">Contatcs Email</th>
                                    <th scope="col">Mobile No</th>
                                    <th scope="col">Contatcs Email</th>
                                    <th scope="col">Contacts Telephone No</th>
                                    <th scope="col">Key Accounts Rep</th>
                                    <th scope="col">Key Account Email</th>
                                    <th scope="col">Key Mobile</th>
                                    <th scope="col">Key Account Email</th>
                                    <th scope="col">Key Telefone</th>
                                    <th scope="col">Type Of Business</th>
                                    <th scope="col">Company Is</th>
                                    <th scope="col">Compnany Est. Date</th>
                                    <th scope="col">Est Code</th>
                                    <th scope="col">Trade License No</th>
                                    <th scope="col">TAX ID</th>
                                    <th scope="col">Trad License Expory</th>
                                    <th scope="col">Legal Structure</th>

                                    <th scope="col">Trade License</th>
                                    <th scope="col">VAT Certificate</th>
                                    <th scope="col">Owener Passport Copy</th>
                                    <th scope="col">Owner Visa Copy</th>
                                    <th scope="col">Owner Emirates ID Copy</th>
                                    <th scope="col">Est. card</th>
                                    <th scope="col">E-signature Card</th>
                                    <th scope="col">Company Labour Card</th>
                                    <th scope="col">Other</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($vendor_reject as $row)
                            <tr>
                                <td>
                                    <a class="text-success mr-2" href="{{route('vendor_portal.edit',$row->id)}}">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                </td>
                                <td>{{ date('d-m-Y-h:m:s', strtotime($row->created_at))}} </td>>
                                <td> {{isset($row->request_no)?$row->request_no:"N/A"}}</td>
                                <td> {{isset($row->name)?$row->name:"N/A"}}</td>
                                <td> {{isset($row->address)?$row->address:"N/A"}}</td>
                                <td> {{isset($row->phone_no)?$row->phone_no:"N/A"}}</td>
                                <td> {{isset($row->email)?$row->email:"N/A"}}</td>
                                <td> {{isset($row->company_website)?$row->company_website:"N/A"}}</td>
                                <td> {{isset($row->zip_code)?$row->zip_code:"N/A"}}</td>
                                <td> {{isset($row->company_address)?$row->company_address:"N/A"}}</td>
                                <td> {{isset($row->bank_name)?$row->bank_name:"N/A"}}</td>
                                <td> {{isset($row->account_number)?$row->account_number:"N/A"}}</td>
                                <td> {{isset($row->benificiary_name)?$row->benificiary_name:"N/A"}}</td>
                                <td> {{isset($row->iban_number)?$row->iban_number:"N/A"}}</td>
                                <td> {{isset($row->bank_address)?$row->bank_address:"N/A"}}</td>
                                <td> {{isset($row->aurtorized_eid)?$row->aurtorized_eid:"N/A"}}</td>
                                <td> {{isset($row->passport_expiry)?$row->passport_expiry:"N/A"}}</td>
                                <td> {{isset($row->company_rep_name)?$row->company_rep_name:"N/A"}}</td>
                                <td> {{isset($row->contatcs_email)?$row->contatcs_email:"N/A"}}</td>
                                <td> {{isset($row->mobile_no)?$row->mobile_no:"N/A"}}</td>
                                <td> {{isset($row->contatcs_email)?$row->contatcs_email:"N/A"}}</td>
                                <td> {{isset($row->contacts_telephone_number)?$row->contacts_telephone_number:"N/A"}}</td>
                                <td> {{isset($row->key_accounts_rep)?$row->key_accounts_rep:"N/A"}}</td>
                                <td> {{isset($row->key_account_email)?$row->key_account_email:"N/A"}}</td>
                                <td> {{isset($row->key_mobile)?$row->key_mobile:"N/A"}}</td>
                                <td> {{isset($row->key_account_email)?$row->key_account_email:"N/A"}}</td>
                                <td> {{isset($row->key_telefone)?$row->key_telefone:"N/A"}}</td>
                                <td> {{isset($row->type_of_business)?$row->type_of_business:"N/A"}}</td>
                                @if(isset($row->company_is))
                                    @if($row->company_is=='1')
                                        <td>Licensed</td>
                                    @else

                                        <td>Inssured</td>
                                    @endif
                                    @else
                                    <td>N/A</td>
                                @endif
                                <td> {{isset($row->compnany_est_date)?$row->compnany_est_date:"N/A"}}</td>
                                <td> {{isset($row->est_code)?$row->est_code:"N/A"}}</td>
                                <td> {{isset($row->trade_linces_no)?$row->trade_linces_no:"N/A"}}</td>
                                <td> {{isset($row->text_id)?$row->text_id:"N/A"}}</td>
                                <td> {{isset($row->trad_license_exp_date)?$row->trad_license_exp_date:"N/A"}}</td>


                                @if(isset($row->legal_structure))
                                    @if($row->legal_structure=='1')
                                        <td>Sole Proprietor</td>
                                        @elseif($row->legal_structure=='2')
                                        <td>Partenership</td>
                                        @elseif($row->legal_structure=='3')
                                        <td>Private Limited</td>
                                        @elseif($row->legal_structure=='4')
                                        <td>Public Limited</td>
                                        @elseif($row->legal_structure=='5')
                                        <td>Public Sector</td>
                                        @elseif($row->legal_structure=='6')
                                        <td>LLC</td>
                                        @else
                                        <td>Legal Agent</td>
                                    @endif
                                    @else
                                    <td>N/A</td>

                                    @endif


                                    @if(isset($row->trade_license))
                                   <td>
                                    <a class="attachment_display" href="{{ isset($row->trade_license) ? Storage::temporaryUrl($row->trade_license, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Trade License</strong></a>
                                </td>
                                       @else
                                    <td>
                                        N/A
                                    </td>
                                    @endif


                                    @if(isset($row->vat_certificate))
                                    <td>
                                        <a class="attachment_display" href="{{ isset($row->vat_certificate) ? Storage::temporaryUrl($row->vat_certificate, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Vat Certificate</strong></a>
                                 </td>
                                        @else
                                     <td>
                                         N/A
                                     </td>
                                     @endif

                                     @if(isset($row->owener_passport_copy))
                                     <td>
                                        <a class="attachment_display" href="{{ isset($row->owener_passport_copy) ? Storage::temporaryUrl($row->owener_passport_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Passport Copy</strong></a>
                                    </td>
                                         @else
                                      <td>
                                          N/A
                                      </td>
                                      @endif


                                      @if(isset($row->owner_visa_copy))
                                      <td>
                                        <a class="attachment_display" href="{{ isset($row->owner_visa_copy) ? Storage::temporaryUrl($row->owner_visa_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Owner visa Copy</strong></a>
                                   </td>
                                          @else
                                       <td>
                                           N/A
                                       </td>
                                       @endif


                                       @if(isset($row->owener_emirates_id_copy))
                                       <td>
                                        <a class="attachment_display" href="{{ isset($row->owener_emirates_id_copy) ? Storage::temporaryUrl($row->owener_emirates_id_copy, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Owner Emirates ID</strong></a>
                                    </td>
                                           @else
                                        <td>
                                            N/A
                                        </td>
                                        @endif


                                        @if(isset($row->est_card))
                                        <td>
                                            <a class="attachment_display" href="{{ isset($row->est_card) ? Storage::temporaryUrl($row->est_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Estabishment Card</strong></a>
                                     </td>
                                            @else
                                         <td>
                                             N/A
                                         </td>
                                         @endif

                                         @if(isset($row->e_signature_card))
                                         <td>
                                            <a class="attachment_display" href="{{ isset($row->e_signature_card) ? Storage::temporaryUrl($row->e_signature_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View E Signature Card</strong></a>
                                        </td>
                                             @else
                                          <td>
                                              N/A
                                          </td>
                                          @endif


                                          @if(isset($row->company_labour_card))

                                            <td>  <a class="attachment_display" href="{{ isset($row->company_labour_card) ? Storage::temporaryUrl($row->company_labour_card, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">View Labour Card</strong></a>

                                              @else
                                           <td>
                                               N/A
                                           </td>
                                           @endif

                                           @if(isset($row->other_doc))

                                           <td>  <a class="attachment_display" href="{{ isset($row->other_doc) ? Storage::temporaryUrl($row->other_doc, now()->addMinutes(5)) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">Other</strong></a></td>

                                             @else
                                          <td>
                                              N/A
                                          </td>
                                          @endif

                                    <td>{{$row->remarks}}</td>
                                    <td>
                                        <button class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal-sm" onclick="vendor_req_accept({{$row->id}})" type="button">Accept</button>
                                        <button class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm-1" onclick="vendor_req_reject({{$row->id}})" type="button">Reject</button>

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




    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="updateForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Vendor Request Accept</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Are You Sure Want To Accept The  Vendor Request</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-success ml-2" type="submit" onclick="accept_vendor()">Accept</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-sm-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ route('vendor_reject') }}" id="updateForm-1" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Vendor Request Rejection</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('GET') }}
                        <label for="repair_category">Remarks</label>
                        <input type="hidden" name="vendor_id" value="" id="vendorId">
                        <input type="text" class="form-control" required name="remarks" >
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" type="submit">Reject</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        function vendor_req_accept(id,)
        {
            var id = id;

            var url = '{{ route('vender_accept', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);
        }

        function accept_vendor()
        {
            $("#updateForm").submit();

        }
    </script>


    <script>
        function vendor_req_reject(id)
        {
            var id = id;


            var url = '{{ route('vendor_reject', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm-1").attr('action', url);

            $('#vendorId').val(id);
        }

        function reject_vendor()
        {
            $("#updateForm-1").submit();

        }
    </script>
    <script>
        $(document).ready(function () {
            'use strict';



            $('#datatable1,#datatable2,#datatable3,#datatable33,#datatable4,datatable44,#datatable6,#datatable66,#datatable5,#datatable7,#datatable77,#datatable8,#datatable88,#datatable9,#datatable99,#datatable10,#datatable55').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'PPUID Detail',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
            });
        });



    </script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable1').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }

                else if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable33').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else if(split_ab=="zds-basic-tab"){
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable44').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="passport-basic-tab"){
                    var table = $('#datatable5').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable55').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="name-basic-tab"){
                    var table = $('#datatable6').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable66').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


                }
                else if(split_ab=="allBasic"){

                    window.location.href = "{{URL::to('visa_process_report')}}"
                }

                else if(split_ab=="sim-basic-tab"){
                    var table = $('#datatable8').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable88').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else if(split_ab=="bike-basic-tab"){
                    var table = $('#datatable9').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                    var table = $('#datatable99').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }



                else{
                    var table = $('#datatable10').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


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
