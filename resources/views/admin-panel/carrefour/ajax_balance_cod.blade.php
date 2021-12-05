<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<ul class="nav nav-tabs small" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="AllCodsTab" data-toggle="tab" href="#AllCods" role="tab" aria-controls="AllCods" aria-selected="true">All Cods</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="ActiveRiderCodsTab" data-toggle="tab" href="#ActiveRiderCods" role="tab" aria-controls="ActiveRiderCods" aria-selected="true">All Active Rider Cods</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="ExRiderCodsTab" data-toggle="tab" href="#ExRiderCods" role="tab" aria-controls="ExRiderCods" aria-selected="true">All Ex Rider Cods</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="NoRiderCodsTab" data-toggle="tab" href="#NoRiderCods" role="tab" aria-controls="NoRiderCods" aria-selected="true">All No Carrefour / No DC Rider Cods</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="AllCods" role="tabpanel" aria-labelledby="AllCodsTab">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-11" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">Rider Name</th>
                        <th scope="col">Rider id</th>
                        <th scope="col">DC Name</th>
                        <th scope="col">Remain COD</th>
                        <th scope="col">Last Deposit Amount</th>
                        <th scope="col">Last Deposit Type</th>
                        <th scope="col">Last Deposit Date</th>
                        <th scope="col">Follow</th>
                        <th scope="col">Ups</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riderProfile as $rider)
                        @include('admin-panel.carrefour.balance_cod_column')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="ActiveRiderCods" role="tabpanel" aria-labelledby="ActiveRiderCodsTab">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-11" id="datatable1" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Rider Name</th>
                        <th scope="col">Rider id</th>
                        <th scope="col">DC Name</th>
                        <th scope="col">Remain COD</th>
                        <th scope="col">Last Deposit Amount</th>
                        <th scope="col">Last Deposit Type</th>
                        <th scope="col">Last Deposit Date</th>
                        <th scope="col">Follow</th>
                        <th scope="col">Ups</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($active_rider_cods as $rider)
                        @include('admin-panel.carrefour.balance_cod_column')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="ExRiderCods" role="tabpanel" aria-labelledby="ExRiderCodsTab">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-11" id="datatable2" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Rider Name</th>
                        <th scope="col">Rider id</th>
                        <th scope="col">DC Name</th>
                        <th scope="col">Remain COD</th>
                        <th scope="col">Last Deposit Amount</th>
                        <th scope="col">Last Deposit Type</th>
                        <th scope="col">Last Deposit Date</th>
                        <th scope="col">Follow</th>
                        <th scope="col">Ups</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ex_rider_cods as $rider)
                        @include('admin-panel.carrefour.balance_cod_column')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane fade" id="NoRiderCods" role="tabpanel" aria-labelledby="NoRiderCodsTab">
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered text-11" id="datatable3" style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Rider Name</th>
                        <th scope="col">Rider id</th>
                        <th scope="col">DC Name</th>
                        <th scope="col">Remain COD</th>
                        <th scope="col">Last Deposit Amount</th>
                        <th scope="col">Last Deposit Type</th>
                        <th scope="col">Last Deposit Date</th>
                        <th scope="col">Follow</th>
                        <th scope="col">Ups</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($no_rider_cods as $rider)
                        @include('admin-panel.carrefour.balance_cod_column')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal add Follow ups -->
<div class="modal fade" id="CODFollowUpAddModalCenter"  role="dialog" aria-labelledby="CODFollowUpAddModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form>
            <div class="modal-header">
            <h5 class="modal-title" id="CODFollowUpAddModalCenterTitle">Rider COD Follow Up Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <p>Rider Information</p>
                <table class="table table-sm table-striped text-11">
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td colspan="4" id="rider_name"></td>
                    </tr>
                    <tr>
                        <td>RiderId</td>
                        <td>:</td>
                        <td id="rider_id"></td>
                        <td>PPUID</td>
                        <td>:</td>
                        <td id="rider_ppuid"></td>
                    </tr>
                    <tr>
                        <td>ZDS</td>
                        <td>:</td>
                        <td id="rider_zds"></td>
                        <td>Phone</td>
                        <td>:</td>
                        <td id="rider_phone"></td>
                    </tr>
                </table>
                <p>COD Follow Up form</p>
                <input type="hidden" name="passport_id" id="passport_id">
                <input type="hidden" name="carrefour_upload_id" id="carrefour_upload_id">
                <div class="form-group">
                    <label for="feedback_id" class="text-left d-block">Call feedback</label>
                    <select class="form-control form-control" name="feedback_id" id="feedback_id">
                        <option value="">Select A Call feedback</option>
                        <option value="1">Will deposit today</option>
                        <option value="2">Will deposit tomorrow</option>
                        <option value="3">N/A messaged on whatsapp</option>
                        <option value="4">Paid</option>
                        <option value="5">Others specify</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="remarks" class="d-block text-left">Remarks</label>
                    <textarea class="form-control" placeholder="Enter follow up remarks" id="remarks" name="remarks" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-sm btn-primary" id="follow_up_save_btn">Save Follow Up</button>
            </div>
        </form>
    </div>
    </div>
</div>
<!-- Modal Follow ups list -->
<div class="modal fade" id="CODFollowUpListModalCenter"  role="dialog" aria-labelledby="CODFollowUpListModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form>
            <div class="modal-header">
            <h5 class="modal-title" id="CODFollowUpListModalCenterTitle">Rider COD Follow Up List</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <p>Rider Information</p>
                <table class="table table-sm table-striped text-11">
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td colspan="4" id="follow_up_rider_name"></td>
                    </tr>
                    <tr>
                        <td>RiderId</td>
                        <td>:</td>
                        <td id="follow_up_rider_id"></td>
                        <td>PPUID</td>
                        <td>:</td>
                        <td id="follow_up_rider_ppuid"></td>
                    </tr>
                    <tr>
                        <td>ZDS</td>
                        <td>:</td>
                        <td id="follow_up_rider_zds"></td>
                        <td>Phone</td>
                        <td>:</td>
                        <td id="follow_up_rider_phone"></td>
                    </tr>
                </table>
                <p>COD Follow Up List</p>
                <div class="table-responsive" id="followUpCallListHolder">
                    followUpCallListHolder
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            {{-- <button type="button" class="btn btn-sm btn-primary" id="follow_up_save_btn">Save Follow Up</button> --}}
            </div>
        </form>
    </div>
    </div>
</div>

<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script>
    $('.follow_up_add_btn').click(function() {
        $('#rider_id').text($(this).attr('data-rider_id'))
        $('#rider_name').text($(this).attr('data-rider_name'))
        $('#rider_ppuid').text($(this).attr('data-rider_ppuid'))
        $('#rider_zds').text($(this).attr('data-rider_zds'))
        $('#rider_phone').text($(this).attr('data-rider_phone'))
        $('#passport_id').val($(this).attr('data-passport_id'))
        $('#carrefour_upload_id').val($(this).attr('data-carrefour_upload_id'))
    });
</script>
<script>
    $('.follow_up_list_btn').click(function(){
        $('#follow_up_rider_id').text($(this).attr('data-rider_id'))
        $('#follow_up_rider_name').text($(this).attr('data-rider_name'))
        $('#follow_up_rider_ppuid').text($(this).attr('data-rider_ppuid'))
        $('#follow_up_rider_zds').text($(this).attr('data-rider_zds'))
        $('#follow_up_rider_phone').text($(this).attr('data-rider_phone'))
        var carrefour_upload_id = $(this).attr('data-carrefour_upload_id')
        var url = "{{ route('carrefour_follow_up_calls') }}";
        $.ajax({
            url,
            method: 'GET',
            data: { carrefour_upload_id },
            success: function(response){
                $('#followUpCallListHolder').empty()
                $('#followUpCallListHolder').append(response.html)
                $('#CODFollowUpListModalCenter').modal('show')
            }
        });
    });
</script>
<script>
    $('#follow_up_save_btn').click(function(){
        var passport_id = $('#passport_id').val();
        var carrefour_upload_id = $('#carrefour_upload_id').val();
        var feedback_id = $('#feedback_id').val();
        var remarks = $('#remarks').val();
        var _token = "{{ csrf_token() }}";
        var url = "{{ route('save_carrefour_followup') }}";
        $.ajax({
            url,
            method: 'POST',
            data: { _token, passport_id, carrefour_upload_id, feedback_id, remarks },
            success: function(response){
                tostr_display(response['alert-type'], response['message'])
                if(response['status'] == 200){
                    $('#passport_id').val("")
                    $('#careem_upload_id').val("")
                    $('#feedback_id').val("")
                    $('#remarks').val("")
                    $('#CODFollowUpAddModalCenter').modal('hide')
                }
            }
        });
    });
</script>
<script>
    var table = $('#datatable,#datatable1,#datatable2,#datatable3').DataTable();
    table.columns.adjust().draw();
</script>
<script>
    function tostr_display(type, message){
        switch(type){
            case 'info':
                toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                break;
            case 'warning':
                toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                break;
            case 'success':
                toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                break;
            case 'error':
                toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
    }
</script>
