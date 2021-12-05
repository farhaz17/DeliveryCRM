<div class="table-responsive">
    <table class="display table table-striped table-sm text-10 " id="search_result_table">
        <thead>
        <tr>

            <th scope="col">Name</th>
            <th scope="col">Passport Number</th>
            <th scope="col">Phone</th>
            <th scope="col">Platform</th>
            <th scope="col">Nationality</th>
            <th scope="col">Batch Name</th>
            <th scope="col">Interview Remarks</th>
            <th scope="col">Action</th>

        </tr>
        </thead>
        <tbody>

            @foreach ($create_interviews as $interview)
            <tr>
               <td>
                   <?php
                   $name =  isset($interview->passport) ? $interview->passport->personal_info->full_name : '' ;
                        if(empty($name)){
                            $name =  isset($interview->career_detail) ? $interview->career_detail->name : '' ;
                        }
                    ?>
                    {{ $name  }}
               </td>
               <td>
                   <?php
                    $passport_no =  isset($interview->passport->passport_no) ? $interview->passport->passport_no : '' ;
                    if(empty($passport_no)){
                        $passport_no =  isset($interview->career_detail) ? $interview->career_detail->passport_no : '' ;
                    }
                     ?>
                {{ $passport_no  }}
               </td>
               <td>
                   @php
                          $phone =  isset($interview->passport->personal_info->personal_mob) ? $interview->passport->personal_info->personal_mob : "";
                            if(empty($phone)){
                                $phone =  isset($interview->career_detail) ? $interview->career_detail->phone : '' ;
                            }
                   @endphp
                {{ $phone }}
               </td>
               <td>
                   {{ isset($interview->batch_info) ? $interview->batch_info->platform->name : '' }}
               </td>
               <td>
                   @php
                        $nation = isset($interview->passport) ? $interview->passport->nation->name : '';
                        if(empty($nation)){
                            $nation =  isset($interview->career_detail->country_name) ? $interview->career_detail->country_name->name : '' ;
                        }
                   @endphp
                   {{ $nation  }}
               </td>
               <td>  {{ isset($interview->batch_info) ? $interview->batch_info->reference_number : '' }}</td>
               <td>
                   @php
                          $status = "";
                        $class = "";
                        if($interview->interview_status=="0"){
                            $status = "Pending";
                            $class = "primary";
                        }elseif($interview->interview_status=="1"){
                            $status = "Pass";
                            $class = "success";
                        }elseif($interview->interview_status=="2"){
                            $status = "Fail";
                            $class = "danger";
                         }elseif($interview->interview_status=="3"){
                            $status = "Absent";
                            $class = "info";
                        }
                   @endphp
                   <h4 class="badge badge-{{ $class }}">{{ $status }}</h4></td>
               <td>
                   @if($status=="Pending")
                <a class="text-primary mr-2 action_change_status" id="{{ $interview->id }}"  href="javascript:void(0)">
                    <i class="nav-icon i-Pen-4 font-weight-bold"></i>
                </a>
                @else
                <h4 class="badge badge-success">No Action required</h4></td>
                @endif
               </td>
            </tr>

            @endforeach

        </tbody>
    </table>
</div>
