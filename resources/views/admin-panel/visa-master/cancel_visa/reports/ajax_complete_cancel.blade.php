

    <div class="col-lg-12  mb-2">

                <h4 class="card-title mb-3"> <span class="badge badge-info m-2"> Visa Cancellation Complete</span></h4>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active show" id="typing-basic-tab" data-toggle="tab" href="#typingBasic" role="tab" aria-controls="typingBasic" aria-selected="true">Visa Cancellation Typing	</a></li>
                    <li class="nav-item"><a class="nav-link" id="submission-basic-tab" data-toggle="tab" href="#submissionBasic" role="tab" aria-controls="submissionBasic" aria-selected="false">Visa Cancellation Submission</a></li>
                    <li class="nav-item"><a class="nav-link" id="cancel-basic-tab" data-toggle="tab" href="#cancelBasic" role="tab" aria-controls="cancelBasic" aria-selected="false">Visa Cancellation</a></li>
                    <li class="nav-item"><a class="nav-link" id="approval-basic-tab" data-toggle="tab" href="#approvalBasic" role="tab" aria-controls="approvalBasic" aria-selected="false">Visa Cancellation Approval</a></li>
                    <li class="nav-item"><a class="nav-link" id="decline-basic-tab" data-toggle="tab" href="#declineBasic" role="tab" aria-controls="declineBasic" aria-selected="false">Visa Cancellation Decline</a></li>

                </ul>


                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade active show" id="typingBasic" role="tabpanel" aria-labelledby="typing-basic-tab">
                        <h4 class="card-title mb-3"> <span class="badge badge-primary m-2">Visa Cancel Typing</span></h4>
                        <table class="display table table-striped table-bordered table-sm text-10" id="datatable-5" width="100%">
                            <thead>
                            <tr>

                                <th scope="col">Name</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">PPUID</th>
                                <th scope="col">Cancellation Date & Time</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($visa_cancel_typing as $row)
                                <tr>
                                    <td> {{$row->passport->personal_info->full_name}}</td>
                                    <td> {{$row->passport->passport_no}}</td>
                                    <td> {{$row->passport->pp_uid}}</td>
                                    <td> {{$row->created_at}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm start-visa" href="{{ url('cancel_visa') }}?passport_id={{ $row->passport->passport_no }}" target="_blank">Cancel Process</a>
                                    </td>
                                </tr>

                            @endforeach



                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="submissionBasic" role="tabpanel" aria-labelledby="submission-basic-tab">
                        <div class="submissionBasic_div"></div>
                    </div>

                    <div class="tab-pane fade" id="cancelBasic" role="tabpanel" aria-labelledby="cancel-basic-tab">
                        <div class="cancelBasic_div"></div>
                    </div>

                    <div class="tab-pane fade" id="approvalBasic" role="tabpanel" aria-labelledby="approval-basic-tab">
                        <div class="approvalBasic_div"></div>
                    </div>

                    <div class="tab-pane fade" id="declineBasic" role="tabpanel" aria-labelledby="decline-basic-tab">
                        <div class="declineBasic_div"></div>
                    </div>


        </div>

    </div>





      {{-- --------------------------------------------------------- --}}





    </div>
    <div class="overlay"></div>



    <script>
        $(document).on('click', '#submission-basic-tab', function(){

                         var token = $("input[name='_token']").val();
                         var url = '{{ route('visa_cancel_submission') }}';
                          $.ajax({
                            url: url,
                              method: 'POST',
                              dataType: 'json',
                              data:{_token:token},
                              beforeSend: function () {
                                  $("body").addClass("loading");
                          },
                              success: function (response) {
                                  $('.submissionBasic_div').empty();
                                  $('.submissionBasic_div').append(response.html);
                                  $('.submissionBasic_div').show();
                                  $("body").removeClass("loading");
                                  var table1 = $('#datatable-submission').DataTable({
                                    "autoWidth": true,
                                });
                                table1.columns.adjust().draw();
                              }
                          });
                      });
          </script>


<script>
    $(document).on('click', '#cancel-basic-tab', function(){

                     var token = $("input[name='_token']").val();
                     var url = '{{ route('visa_cancel_cancellation_report') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.cancelBasic_div').empty();
                              $('.cancelBasic_div').append(response.html);
                              $('.cancelBasic_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-cancel').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>


<script>
    $(document).on('click', '#approval-basic-tab', function(){

                     var token = $("input[name='_token']").val();
                     var url = '{{ route('visa_cancel_approval') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.approvalBasic_div').empty();
                              $('.approvalBasic_div').append(response.html);
                              $('.approvalBasic_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-approval').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>

<script>
    $(document).on('click', '#decline-basic-tab', function(){

                     var token = $("input[name='_token']").val();
                     var url = '{{ route('visa_cancel_decline') }}';
                      $.ajax({
                        url: url,
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.declineBasic_div').empty();
                              $('.declineBasic_div').append(response.html);
                              $('.declineBasic_div').show();
                              $("body").removeClass("loading");
                              var table1 = $('#datatable-decline').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
                  });
      </script>
