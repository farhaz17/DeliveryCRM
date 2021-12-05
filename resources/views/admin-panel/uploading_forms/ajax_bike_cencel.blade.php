

    @if(isset($bike_cencel->bike_id)==$id)

        <table class="table" style="width: 700px">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Chessis No</th>
                <th scope="col">Plate No</th>
                <th scope="col">Remarks</th>
                <th scope="col">Updated At</th>
            </tr>
            </thead>

            <tr>
                <td>{{$bike_cencel->chassis_number->chassis_no}}</td>
                <td>{{$bike_cencel->plate_no}}</td>
                <td>{{$bike_cencel->remarks}}</td>
                <td>{{$bike_cencel->date_and_time}}</td>


            </tr>
        </table>

    @else
        <form   action="{{url('cencel_plate_no_store')}}"   method="post">

            {!! csrf_field() !!}


            <div class="row">


                <div class="col-md-12 form-group mb-3">
                    <label class="col-form-label" for="recipient-name-2"> Plate No</label>
                    <input class="form-control" id="bike_id" name="bike_id" value="{{$id}}"   type="hidden" />
                    <input class="form-control" id="plate_no" name="plate_no" value="{{$plate_no}}"   type="text" readonly/>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <label class="col-form-label" for="message-text-1">Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="5"></textarea>
                </div>

                <div class="col-md-12 form-group mb-3">
                    <label class="col-form-label"  for="message-text-1">Date & Time</label>
                    <input class="form-control" id="date_and_time" name="date_and_time"  type="datetime-local" required />
                </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Save</button>
            </div>


            </div>
        </form>


        @endif


