<div class="row">
@foreach($fourpl_names as $row)

       <div class="col-lg-3 col-md-3 col-sm-3">
        <div class="card card-companies mb-4 mr-1">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2"><img class="title_imag-icon" src="assets/images/icons/drawable/enterprise.png" alt="icon"></div>
                    <div class="col-sm-10">
                        <p class="ml-4 mt-4" style="color: #003473">{{isset($row->name)?$row->name:""}}
                            <span class="ml-3" style="color:#000000; font-weight:bold; font-size:20px">{{count($agreemnt->where('four_pl_name',$row->id))}}</span> </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- <table class="table tab-border mt-1" id="datatable" width="100%">

                    <thead class="thead-dark">
                    <tr>

                        <th scope="col">4 Pl Name</th>
                        <th scope="col" >Number of riders</th>
                        <th scope="col" >Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($fourpl_names as $row)
                        <tr>
                            <td> {{isset($row->name)?$row->name:""}}</td>
                            <td class="font-weight-bold">{{count($agreemnt->where('four_pl_name',$row->id))}}</td>
                            <td>

                                <a class="btn btn-primary btn-sm mr-2" href="{{route('contractor_report.show',$row->id)}}" target="_blank">
                                  View Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach


                    </tbody>
                    <tfoot>
                    {{-- <tr>
                        <td></td>
                        <td><span class="font-weight-bold">Total Riders={{$fourpl_names_all}}</span></td>
                        <td></td>
                    </tr> --}}
                    {{-- </tfoot>
                </table> --}}
