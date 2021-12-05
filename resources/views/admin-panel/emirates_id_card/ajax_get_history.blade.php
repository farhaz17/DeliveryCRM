<h5 class="modal-title" id="exampleModalCenterTitle">Emirates ID History</h5>
<div class="table-responsive">
    <table class="display table table-striped table-sm text-11" id="datatable">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">PPUID</th>
            <th scope="col">Passport Number</th>
            <th scope="col">ZDS</th>
            <th scope="col">Id Number</th>
            <th scope="col">Expire Date</th>
            <th scope="col">Emirates Front Pic</th>
            <th scope="col">Emirates Back Pic</th>
            <th scope="col">Enter By</th>

        </tr>
        </thead>
        <tbody>
        @foreach($emirates_ids as $id)
            <tr>
                <td scope="row"> </td>
                <td>{{ $id->passport ? $id->passport->personal_info->full_name : 'N/A' }}</td>
                <td>{{  $id->passport ? $id->passport->pp_uid : 'N/A' }}</td>
                <td>{{ $id->passport ? $id->passport->passport_no : 'N/A' }}</td>
                <td>{{ isset($id->passport->zds_code->zds_code) ? $id->passport->zds_code->zds_code : 'N/A' }}</td>
                <td>{{ $id->card_no  }}</td>
                <td>{{ $id->expire_date  }}</td>
                <td> <?php if(!empty($id->card_front_pic)){ ?>   <a href="{{Storage::temporaryUrl($id->card_front_pic, now()->addMinutes(5))}}" target="_blank" >Front Pic</a> <?php }else{ echo "N/A"; } ?> </td>
                <td><?php if(!empty($id->card_back_pic)){ ?> <a href="{{Storage::temporaryUrl($id->card_back_pic, now()->addMinutes(5))}}" target="_blank" >Back Pic</a> <?php }else{ echo "N/A"; } ?> </td>
                <td>{{ $id->user->name }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
