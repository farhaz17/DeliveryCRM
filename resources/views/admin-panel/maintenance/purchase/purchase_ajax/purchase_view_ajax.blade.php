 <div class="card-body">
    <div class="card-title mb-3 col-12"></div>
        <div class="row">
            <table class="table table-sm table-hover table-striped text-11 data_table_cls" >
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Purchase Number</th>
                        <th>Supplier</th>
                        <th>Date</th>
                        <th width="5%">View Invoice</th>
                        <th width="5%">Verify Purchase</th>
                        <th width="5%">Return Purchase</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchase as $row)

                    @php
                    $purchase_pdf_route = route('purchase_pdf',$row->id);
                @endphp
                    <tr>
                        <td>&nbsp;</td>
                        <td> {{ $row->purchase_no ?? '' }} </td>
                        <td> {{ $row->suppliers->contact_name ?? '' }} </td>
                        <td> {{ $row->created_at->format('d-m-Y') ?? '' }} </td>
                        <td>
                            <a href="{{$purchase_pdf_route}}" target="_blank"><i class="fa fa-print"></i></a>
                        </td>
                        <td>
                            @if($row->status=='1')
                            <a class="badge badge-success m-2" href="#">Verified</a>
                            @else
                            <button class="btn text-success"  onclick="vendor_req_accept({{$row->id}})" type="button"><i class="fa fa-check"></i></button>
                                @endif

                        </td>
                        <td>
                            @if($row->return_status=='1')
                            <a class="badge badge-info m-2" href="#">Returned</a>
                            @else
                            <button class="btn text-success"  onclick="return_purchase({{$row->id}})" type="button"><i class="i-Restore-Window"></i></button>
                            @endif
                        </td>
                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <script>
    $(document).ready(function () {
        'use-strict'
        $('.data_table_cls').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'All Purhcases Summary',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'All Purhcases Summary',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'All Purhcases Summary',
                    text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ],
            select: true,
            scrollY: 300,
            responsive: true,
            // scrollX: true,
            // scroller: true
        });
    });





</script>
