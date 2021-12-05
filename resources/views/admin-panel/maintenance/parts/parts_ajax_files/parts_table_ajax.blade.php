


<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <table class="display table table-striped table-bordered" id="datatable">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Part Name</th>
                        <th scope="col">Part Number</th>
                        <th scope="col">OEM</th>
                        <th scope="col">Counter Fit</th>
                        <th scope="col">Super Seed </th>
                        <th scope="col">Other</th>
                        <th scope="col">Category</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($parts as $part)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{$part->part_name}}</td>
                            <td>{{$part->part_number}}</td>
                            <td>{{$part->oem}}</td>
                            <td>{{$part->counter_fit}}</td>
                            <td>{{$part->super_seed}}</td>
                            <td>{{$part->other}}</td>
                            <td>{{$part->category}}</td>
                            <td>
                                <a class="text-success mr-2" href="{{route('parts.edit',$part->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                {{--<a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$part->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a></td>--}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
      $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

        });
</script>
