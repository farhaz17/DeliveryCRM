
<h5>Visa Details</h5>
<table class="table table-bordered table-striped">
    <tr>
        <th>Company</th>
        <td><span >{{  $gamer2['company']  }}</span></td>
    </tr>
    <tr>
        <th>Profession</th>
        <td><span>{{ $gamer2['job']  }}</span></td>
    </tr>
    <tr>
        <th>Expiry Dare</th>
        <td><span>{{ $gamer2['expiry_date']  }}</span></td>
    </tr>


    {{-- <tr>
        <th>St no</th>
        <td><span>{{ $gamer2['st_no']  }}</span></td>
    </tr> --}}

{{--
    <tr>
        <th>MB No</th>
        <td><span>{{ $gamer2['mb_no']  }}</span></td>
    </tr> --}}
    {{-- <tr>
        <th>Visa No</th>
        <td><span>{{ $gamer2['visa_no']  }}</span></td>
    </tr> --}}

    {{-- <tr>
        <th>UID no</th>
        <td><span>{{ $gamer2['uid_no']  }}</span></td>
    </tr> --}}

    {{-- <tr>
        <th>Medical Type</th>
        <td><span>{{ $gamer2['medical_type']  }}</span></td>
    </tr>
    <tr>
        <th>Medical Application ID</th>
        <td><span>{{ $gamer2['medical_app_id'] }}</span></td>
    </tr>

    <tr>
        <th>Fit/Unfit</th>
        <td><span>{{ $gamer2['fit_unfit_status']  }}</span></td>
    </tr>

    <tr>
        <th>Tawjeeh Status</th>
        <td><span>{{ $gamer2['tawjeeh_status']  }}</span></td>
    </tr>

    <tr>
        <th>Labour Card No</th>
        <td>{{ $gamer2['labour_card_no']  }}</td>
    </tr>
    <tr>
        <th>Person Code</th>
        <td>{{ $gamer2['person_code']  }}</td>
    </tr> --}}


</table>

<div class="col-md-12">

        <?php
        $str1 = $visa_pasted->visa_attachment;
        $formate= substr($str1, -5, 3);


        ?>
        {{-- <p>{{$formate}}</p> --}}
    @if ($formate != 'pdf')
        {{-- <h1 class="ml-4">{{$formate}}</h1> --}}
        @foreach (json_decode($visa_pasted->visa_attachment) as $visa_attach)
        {{-- <p>1 {{$visa_attach}}</p> --}}
        <img src="{{Storage::temporaryUrl('assets/upload/VisaPasted/'.$visa_attach, now()->addMinutes(5))}}" class="slider_img img-fluid" width="50%" height="30%">
        @endforeach
    @else

        @foreach (json_decode($visa_pasted->visa_attachment) as $visa_attach)
        {{-- <p>{{$visa_attach}}</p> --}}
        <embed src="{{Storage::temporaryUrl('assets/upload/VisaPasted/'.$visa_attach, now()->addMinutes(5))}}" class="slider_img img-fluid" width="100%" height="60%">
        @endforeach
    @endif

</div>






