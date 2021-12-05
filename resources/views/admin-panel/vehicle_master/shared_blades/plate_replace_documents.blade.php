<div class="table-responsive">
    <div class="card-title mb-3 col-12">Selected Request Information</div>
    <table class="table table-sm table-hover table-striped text-11" id="newRequestListTable">
        <thead class="thead-dark">
            <tr>
                <th scope="col"></th>
                <th scope="col">Current Plate No</th>
                <th scope="col">Requested Plate No</th>
                <th scope="col">Reason</th>
                <th scope="col">Remarks</th>
                @if(count($attachment_paths ?? []) > 0)
                <th scope="col">File Name</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td>{{ $replace_request->plate_no ?? "" }}</td>
                <td>{{ $replace_request->new_plate_no ?? "" }}</td>
                <td>{{ $replace_request->reson_of_replacement !== null ? get_plate_replace_reason($replace_request->reson_of_replacement) : ''}}</td>
                <td>{{ $replace_request->remarks ?? "" }}</td>
                    @php 
                        $attachment_paths = json_decode($replace_request->attachment_paths) 
                    @endphp
                    @if(count($attachment_paths ?? []) > 0)
                    <td>
                    @forelse ($attachment_paths as $key => $attachment_path)
                        {{ $replace_request->attachment_labels[$key]->name ?? "" }}
            
                        ( <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a>
                        |
                        <a href="{{ $attachment_paths[$key] ?? asset('assets/images/faces/3.jpg')}}" download="{{ $attachment_paths[$key] }}">Download</a> )<br>
                        @empty
                        
                    @endforelse
                    </td>
                    @endif
                </td>
            </tr> 
        </tbody>
    </table>                        
</div>