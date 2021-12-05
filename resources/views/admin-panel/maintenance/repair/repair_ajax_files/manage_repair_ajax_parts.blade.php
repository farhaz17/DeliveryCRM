

            <form method="post" id="PartsAddForm" action="{{isset($manage_repair_part_data)?route('manage_repair_parts.update',$manage_repair_part_data->id):route('manage_repair_parts.store')}}">
                {!! csrf_field() !!}
                @if(isset($manage_repair_part_data))
                    {{ method_field('PUT') }}
                @endif
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Parts</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">


                    <input type="text" id="id" name="id" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->id:""}}">
                    <input type="text" id="job_id" name="job_id" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->repair_job_id:(isset($repairJob_id)?$repairJob_id:"")}}" >
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Repair Parts</label>
                            @if(isset($manage_repair_part_data))
                                <input type="hidden" id="part_id" name="part_id" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->part_id:""}}">
                            @endif
                            <select id="part_id" name="part_id" class="form-control" {{isset($manage_repair_part_data)?'disabled':""}}>
                                <option value="">Select Part Number</option>
                                @foreach($parts as $part)
                                    @php
                                        $isSelected=(isset($manage_repair_part_data)?$manage_repair_part_data->part_id:"")==$part->id;
                                    @endphp
                                    <option value="{{$part->id}}" {{ $isSelected ? 'selected': '' }}>{{$part->part_number}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Quantity</label>
                            <input class="form-control" id="quantity" name="quantity" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->quantity:""}}" type="text" placeholder="Enter the quantity" required />
                        </div>
                    </div>


                <div class="col-md-12 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="datatable2">
                                    <thead class="table_header">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Part Number</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($manage_repair_parts as $manage_repair_part)
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>{{$manage_repair_part->part->part_number}}</td>
                                            <td>{{$manage_repair_part->quantity}}</td>
                                            <td>
                                                <a class="text-success mr-2" href="{{route('manage_repair_parts.edit',$manage_repair_part->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                <a class="text-danger mr-2" data-toggle="modal" onclick="deleteDataPart({{$manage_repair_part->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary ml-2" type="submit">Save changes</button>
            </div>
            </form>

<script>

    $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                "scrollY": false,
            });
</script>
