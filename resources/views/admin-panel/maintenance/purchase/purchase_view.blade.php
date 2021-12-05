@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        i.fa.fa-check {
    color: green;
}
i.i-Restore-Window {
    font-weight: bold;
    font-size: 16px;
    color: blue;
}
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Purchase</a></li>
        <li class="breadcrumb-item"><a href="#">All Purhcases</a></li>
        <li class="breadcrumb-item active" aria-current="page">Purchase  List</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
    <div class="ajax_table_load"></div>
</div>

{{-- ---------------modal strts--------------- --}}





{{-- ---------------modal ends--------------- --}}




@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $( document ).ready(function() {
            $.ajax({
                    url: "{{ route('get_purchase_view_table') }}",
                    dataType: 'json',
                    success: function (response) {
                        $(".ajax_table_load").empty();
                        $('.ajax_table_load').append(response.html);
                    }
                });
});
</script>

<script>
    function vendor_req_accept(id)
    {
        var id = id;
        var url = '{{ route('verify_purchase', ":id") }}';
        var token = $("input[name='_token']").val();
        $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: {id: id, _token: token},
                    success: function (response) {
                        $(".veri").empty();
                        $('.veri').html(response.html);
                        $(".veri").show();
                        $('.bd-example-modal-lg-1').modal('show');
                    }
                });
    }
</script>

<script>
    function return_purchase(id)
    {
        var id = id;
        var url = '{{ route('return_purchase', ":id") }}';
        var token = $("input[name='_token']").val();
        $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: {id: id, _token: token},
                    success: function (response) {
                        $(".ajax_table_load").empty();
                        $('.ajax_table_load').append(response.html);
                    }
                });
    }

</script>




<script>

      $('.veri').on('click', '.part_checkbox', function() {
          if($(this).prop("checked") == true){
              var data_id = $(this).attr('id');
              var splt_v = data_id.split("-");

              $("#qty-"+splt_v[1]).prop("checked",true);
              $("#price-"+splt_v[1]).prop("checked",true);


          }
          else if($(this).prop("checked") == false){

              var data_id = $(this).attr('id');
              var splt_v = data_id.split("-");

              $("#qty-"+splt_v[1]).prop("checked",false);
              $("#price-"+splt_v[1]).prop("checked",false);

          }

      });

      $('datatable_ver').DataTable( {
          "aaSorting": [[0, 'desc']],
          "pageLength": 10,
          "columnDefs": [
              {"targets": [0],"visible": true},
          ],


          select: true,
          scrollY: 300,
          responsive: true,
          // scrollX: true,
          // scroller: true
      });





  </script>



<script>


$(document).on("click", "#presentBulkSubmit", function (e) {



        var part_id =   $("input[name='checked[]']:checked").map(function(){
                                return this.value;
                            }).get();

        var qty =   $("input[name='checkeds[]']:checked").map(function(){
                                return this.value;
                            }).get();


                            var price =   $("input[name='checked-price[]']:checked").map(function(){
                                return this.value;
                            }).get();


         var purchase_id = $("input[name='purchase_id']").val();



                $.ajax({
                    type: 'post',
                    url: "{{ route('very_purchase') }}",
                    data: {_token: "{{ csrf_token() }}", part_id:part_id, qty:qty,price:price,purchase_id:purchase_id},
                    success: function (response) {
                        $(".veri").empty();
                        $('.bd-example-modal-lg-1').modal('hide');
                        $(".ajax_table_load").empty();
                        $('.ajax_table_load').append(response.html);
                        toastr.success("Purhcased Verified");
                    },

        });
});

</script>







<script>
    $('select').select2();
</script>

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>

@endsection
