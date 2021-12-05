<div class="card text-left">
    <div class="card-body">
        <h4 class="card-title mb-3">Manage Invoices</h4>
        <div class="table-responsive">
            <table  id="datatable" class="table table-sm table-hover table-striped text-11 data_table_cls" >
                <thead>
                <tr>
                    <th scope="col"> <b> Repair No</b></th>
                    <th scope="col"> <b>Plate No <b></th>
                    <th scope="col"> <b>Chassis No <b></th>
                    <th scope="col"> <b>Name <b></th>
                    <th scope="col"> <b>Status <b></th>
                    <th scope="col"> <b>View Invoice <b> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($manage_parts as $row)
                @php
                $invoice_pdf_route = route('pdfInvoice',$row->id);
                @endphp
                    <tr>
                        <td>{{$row->manage_repair->repair_no}}</td>
                        <td>{{$row->manage_repair->bike->plate_no}}</td>
                        <td>{{$row->manage_repair->bike->chassis_no}}</td>
                        <td> {{$row->manage_repair->passport->personal_info->full_name}}</td>
                    <td>
                        @if($row->status=='0')
                        <span class="badge badge-danger m-2">Pending</span>
                        @elseif($row->status=='1')
                        <span class="badge badge-info m-2">In Progress</span>
                        @else
                        <span class="badge badge-success m-2">Completed</span>
                        @endif
                    </td>
                        <td>
                            <a href="{{$invoice_pdf_route}}" target="_blank" ><i class="fa fa-print mt-2"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
<script>

    $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 5,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    { "width": "30%", "targets": 3 }

                ],
                "scrollY": false,
            });
</script>
