<div class="row">
    <div class="col-md-4 form-group mb-3 ">
        <label for="repair_category" >Batch</label>
        <h5 id="batch_quantity">{{isset($box->batch)?$box->batch->reference_number:""}}</h5>
    </div>
    <div class="col-md-4 form-group mb-3 batch_detail_cls ">
        <label for="repair_category">Platform</label>
        <h5   id="platform_name" >{{isset($box->batch)?$box->batch->platform->name:""}}</h5>
    </div>
    <div class="col-md-4 form-group mb-3  ">
        <label for="repair_category">Date</label>
        <h5 id="batch_date" >{{isset($box->batch)?$box->batch->date:""}}</h5>
    </div>
    <div class="col-md-4 form-group mb-3 ">
        <label for="repair_category" >Location</label>
        <h5 id="batch_location">{{isset($box->batch)?$box->batch->location:""}}</h5>
    </div>
    <div class="col-md-4 form-group mb-3 ">
        <label for="repair_category" >Bike Quantity</label>
        <h5 id="batch_quantity">{{isset($box->batch)?$box->batch->bike_quantity:""}}</h5>
    </div>
</div>
