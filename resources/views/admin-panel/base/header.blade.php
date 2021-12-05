<div class="main-header">
    <div class="logo">
        <img src="{{asset('assets/images/logo.png')}}" alt="">
    </div>
    <a href="{{url('/user-dashboard')}}">
        <i class="i-Home1 headrer-icon" style="font-size: 1.5em"></i>
    </a> &nbsp; &nbsp; &nbsp;
    <a href="{{url('/user-dashboard-new')}}">
        <i class="i-Dashboard headrer-icon" style="font-size: 1.5em"></i>
    </a>
    {{-- <div class="menu-toggle">
        <div></div>
        <div></div>
        <div></div>
    </div> --}}



    {{--<div class="d-flex align-items-center">--}}
        <!-- Mega menu -->
        {{--<div class="dropdown mega-menu d-none d-md-block">--}}
            {{--<a href="#" class="btn text-muted dropdown-toggle mr-3" id="dropdownMegaMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mega Menu</a>--}}
            {{--<div class="dropdown-menu text-left" aria-labelledby="dropdownMenuButton">--}}
                {{--<div class="row m-0">--}}
                    {{--<div class="col-md-4 p-4 bg-img">--}}
                        {{--<h2 class="title">Mega Menu <br> Sidebar</h2>--}}
                        {{--<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores natus laboriosam fugit, consequatur.--}}
                        {{--</p>--}}
                        {{--<p class="mb-4">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Exercitationem odio amet eos dolore suscipit placeat.</p>--}}
                        {{--<button class="btn btn-lg btn-rounded btn-outline-warning">Learn More</button>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 p-4">--}}
                        {{--<p class="text-primary text--cap border-bottom-primary d-inline-block">Features</p>--}}
                        {{--<div class="menu-icon-grid w-auto p-0">--}}
                            {{--<a href="#"><i class="i-Shop-4"></i> Home</a>--}}
                            {{--<a href="#"><i class="i-Library"></i> UI Kits</a>--}}
                            {{--<a href="#"><i class="i-Drop"></i> Apps</a>--}}
                            {{--<a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a>--}}
                            {{--<a href="#"><i class="i-Checked-User"></i> Sessions</a>--}}
                            {{--<a href="#"><i class="i-Ambulance"></i> Support</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="col-md-4 p-4">--}}
                        {{--<p class="text-primary text--cap border-bottom-primary d-inline-block">Components</p>--}}
                        {{--<ul class="links">--}}
                            {{--<li><a href="accordion.html">Accordion</a></li>--}}
                            {{--<li><a href="alerts.html">Alerts</a></li>--}}
                            {{--<li><a href="buttons.html">Buttons</a></li>--}}
                            {{--<li><a href="badges.html">Badges</a></li>--}}
                            {{--<li><a href="carousel.html">Carousels</a></li>--}}
                            {{--<li><a href="lists.html">Lists</a></li>--}}
                            {{--<li><a href="popover.html">Popover</a></li>--}}
                            {{--<li><a href="tables.html">Tables</a></li>--}}
                            {{--<li><a href="datatables.html">Datatables</a></li>--}}
                            {{--<li><a href="modals.html">Modals</a></li>--}}
                            {{--<li><a href="nouislider.html">Sliders</a></li>--}}
                            {{--<li><a href="tabs.html">Tabs</a></li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <!-- / Mega menu -->
        {{--<div class="search-bar">--}}
            {{--<input type="text" placeholder="Search">--}}
            {{--<i class="search-icon text-muted i-Magnifi-Glass1"></i>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div style="margin: auto">
        {{-- <marquee><a href="{{ route('birthday-wishes') }}" target="_blank">Happy Birthday Ma'am Mehreen</a></marquee> --}}
    </div>
    <div class="header-part-right">
        <!-- Full screen toggle -->

        @if(!in_array(4, Auth::user()->user_group_id))
         <i class="i-Support header-icon d-none d-sm-inline-block" data-toggle="modal" data-target="#it_support"></i>
        @endif


        <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>




        <!-- Grid menu Dropdown -->
        {{--<div class="dropdown">--}}
            {{--<i class="i-Safe-Box text-muted header-icon" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>--}}
            {{--<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
                {{--<div class="menu-icon-grid">--}}
                    {{--<a href="#"><i class="i-Shop-4"></i> Home</a>--}}
                    {{--<a href="#"><i class="i-Library"></i> UI Kits</a>--}}
                    {{--<a href="#"><i class="i-Drop"></i> Apps</a>--}}
                    {{--<a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a>--}}
                    {{--<a href="#"><i class="i-Checked-User"></i> Sessions</a>--}}
                    {{--<a href="#"><i class="i-Ambulance"></i> Support</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <!-- Notificaiton -->
        <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{--<span class="badge badge-primary">{{count($invItems)}}</span>--}}
                {{--@if(isset($notification))--}}
                {{--<span class="badge badge-primary">--}}
                        {{--{{count($notification)}}--}}
                {{--</span>--}}
                {{--@else--}}
                    <span class="badge badge-primary" id="output">
                        {{count($notification)}}
                </span>
                    {{--@endif--}}
                <i class="i-Bell text-muted header-icon"></i>
            </div>
            <!-- Notification dropdown -->
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                <div id="notification_card">
                    @include('admin-panel.base.notification')
                {{--@foreach($invItems as $invItem)--}}
                {{--@foreach(auth()->user()->unreadNotifications as $notification)--}}

                        {{--<div class="dropdown-item d-flex">--}}
                            {{--<div class="notification-icon">--}}
                                {{--<i class="i-Empty-Box text-danger mr-1"></i>--}}
                            {{--</div>--}}
                            {{--<div class="notification-details flex-grow-1">--}}

                                {{--<a onclick="updateNotification({{$notification->idd}})">--}}
                                    {{--<p class="m-0 d-flex align-items-center">--}}
                                        {{--<span>{{$notification->data['ticket']['message']}}</span>--}}
                                        {{--<span class="badge badge-pill badge-danger ml-1 mr-1">{{$invItem->quantity_balance}}</span>--}}
                                        {{--<span class="badge badge-pill badge-danger ml-1 mr-1">{{$notification->data['ticket']['ticket_id']}}</span>--}}
                                        {{--<span class="flex-grow-1"></span>--}}
                                    {{--</p>--}}
                                {{--</a>--}}

                                {{--<form action="" id="notificationForm" method="post">--}}
                                    {{--{{ csrf_field() }}--}}
                                    {{--{{ method_field('PUT') }}--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        {{--</div>--}}


                {{--@endforeach--}}
                </div>

            </div>










        </div>

        <!-- Notificaiton 2 -->
        @if(!in_array(1,Auth::user()->user_group_id))
        <div class="dropdown">
            <div class="badge-top-container" role="button" id="dropdownNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            @if(is_array($notification3))
                @if(count($notification3) == '0')
                <span class="badge badge-danger" id="output">
                        {{count($notification3)}}
                </span>
                @endif
                @if(count($notification3) >= '1')
                    <i class="button-icon  header-icon2">  {{count($notification3)}} </i>
                @else
                    <i class="i-Close-Window text-muted header-icon "></i>
                @endif
                @else
                    <i class="i-Close-Window text-muted header-icon "></i>
                @endif
            </div>
            <div class="dropdown-menu dropdown-menu-right notification-dropdown rtl-ps-none" aria-labelledby="dropdownNotification" data-perfect-scrollbar data-suppress-scroll-x="true">
                <div id="notification_card">
                    @include('admin-panel.base.visa_notifications')
                </div>
            </div>
        </div>
        @endif






{{--        <a href="{{url('/logout')}}"> <i class="i-Power-2 header-icon d-none d-sm-inline-block" ></i></a>--}}
        <!-- Notificaiton End -->
        <!-- User avatar dropdown -->
        <div class="dropdown">
            <div class="user col align-self-end">
                <img src="{{asset('assets/images/admin_avatar.png')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <strong>
                        <i class="i-Lock-User mr-1"></i> {{auth()->user()->name}}
                        </strong>
                    </div>
{{--                    @if(auth()->user()->designation_type=="3")--}}
{{--                        <a class="dropdown-item" href="javascript:void(0)" id="logout_btn_designation"> Logout</a>--}}
{{--                    @else--}}
                    <a class="dropdown-item" href="{{url('/logout')}}"> Logout</a>
{{--                        @endif--}}
                </div>
            </div>
        </div>

{{--        <div class="dropdown">--}}
{{--            <div class="user col align-self-end">--}}
{{--                <img src="{{asset('assets/images/admin_avatar.png')}}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">--}}
{{--                    <div class="dropdown-header">--}}
{{--                        <i class="i-Lock-User mr-1"></i> {{auth()->user()->name}}--}}
{{--                    </div>--}}
{{--                    <a class="dropdown-item" href="{{url('/logout')}}"> Logout</a>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div--}}

    </div>
</div>

<div class="modal fade" id="it_support" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                To IT Support
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" action="{{route('it_ticket.store')}}">
                    {!! csrf_field() !!}
{{--                    @if(isset($parts_data))--}}
{{--                        {{ method_field('PUT') }}--}}
{{--                    @endif--}}
                    {{--                        @foreach($passport as $pass)--}}
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Name</label>
                            <input class="form-control "  value="{{auth()->user()->name}}"  type="text" placeholder="Enter the  name" readonly />
                            <input class="form-control " id="user_id" name="user_id" value="{{auth()->user()->id}}"  type="hidden"  />

                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Message</label>
                            <textarea class="form-control" required name="message" id="" cols="30" rows="5"></textarea>

                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Add Image</label>
                            <div class="custom-file">
                                <input class="custom-file-input" id="message" type="file" name="img" aria-describedby="inputGroupFileAddon01"/>
                                <label class="custom-file-label" for="select_file">Choose Image</label>
                            </div>
                        </div>

                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Attach File</label>
                            <div class="custom-file">
                                <input class="custom-file-input" id="img" type="file" accept="application/pdf, application/vnd.ms-excel"  name="file_name" aria-describedby="inputGroupFileAddon01"/>
                                <label class="custom-file-label" for="select_file">Choose File</label>
                            </div>
                        </div>




                        <div class="modal-footer">
{{--                            <a type="submit" class="btn btn-success success">Send</a>--}}
                            <button class="btn btn-primary"> Send</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        </div>
                    </div>
                    {{--                        @endforeach--}}
                </form>
            </div>

        </div>
    </div>
</div>
<script>
    function updateNotification(id)
    {
        var id = id;
        var url = '{{ route('read_done', ":id") }}';
        url = url.replace(':id', id);

        $("#notificationForm").attr('action', url).submit();

    }
</script>

<script>
    function updateNotification2(id)
    {
        var id = id;
        var url = '{{ route('read_done2', ":id") }}';
        url = url.replace(':id', id);

        $("#notificationForm").attr('action', url).submit();

    }
</script>

<script src="https://js.pusher.com/4.2/pusher.min.js"></script>
<!-- Alert whenever a new notification is pusher to our Pusher Channel -->

<script>


    var pusher = new Pusher('528cdceee8181ca31807', {
        cluster: 'ap2',
        encrypted: true
    });

    var channel = pusher.subscribe('manage_notification');
    channel.bind('notify-event', function(msg) {
        {{--toastr.info("{{ 'New Ticket Created'  }}");--}}
        {{--var myJSON = JSON.stringify(msg);--}}
        {{--// var obj = $.parseJSON(myJSON);--}}
        {{--console.log(msg.idd);--}}
        // alert(myJSON);
        $.ajax({
            type: 'get',
            url: "{{ route('get_updated_notification') }}",
            cache: false,
            success: function (result) {
                if (result.response) {
                    // alert("dsfsdf"+result.count);
                    $('#output').trigger("reset");
                    $('#output').text(result.count);
                    $('#notification_card').empty();
                    $('#notification_card').append(result.data);
                    // write(result.data);
                    // $("#notification_card").append(' <a onclick="updateNotification()">\n' +
                    //     '                                    <p class="m-0 d-flex align-items-center">\n' +
                    //     '                                        <span>123</span>\n' +
                    //     '                                        <span class="badge badge-pill badge-danger ml-1 mr-1"></span>\n' +
                    //     '                                        <span class="flex-grow-1"></span>\n' +
                    //     '                                    </p>\n' +
                    //     '                                </a>');

                }
            }
        });

        {{--var count = {{count($notification)}};--}}
     {{--var count = {!! count(auth()->user()->unreadNotifications) !!};--}}
     //    document.getElementById('output').innerHTML = count++;


    });

    function write(arr) {
        var i;
        var out = '<div>';
        for(i = 0; i < arr.length; i++) {
            out += '<div class="dropdown-item d-flex">';
            out += '                            <div class="notification-icon">';
            out += '                                <i class="i-Empty-Box text-danger mr-1"></i>';
            out += '                            </div>';
            out += '                            <div class="notification-details flex-grow-1">';
            out += '                                <a>';
            out += '                                    <p class="m-0 d-flex align-items-center">';
            out += '                                        <span>'+arr[i].idd+'</span>';
            out += '                                        {{--<span class="badge badge-pill badge-danger ml-1 mr-1">{{$invItem->quantity_balance}}</span>--}}';
            out += '                                        <span class="badge badge-pill badge-danger ml-1 mr-1">dsfsd</span>';
            out += '                                        <span class="flex-grow-1"></span>';
            out += '                                    </p>';
            out += '                                </a>';
            out += '                                <form action="" id="notificationForm" method="post">';
            out += '                                    {{ csrf_field() }}';
            out += '                                    {{ method_field('PUT') }}';
            out += '                                </form>';
            out += '                            </div>';
            out += '                        </div>';
        }
        out += '</div>';

        $( "#notification_card" ).empty();
        $("#notification_card").append(out);
        // document.getElementById('#notification_card').innerHTML = inn;
        // $('#notification_card').innerHTML = "";
        // $('#notification_card').innerHTML = out;
        // console.log(out);
    }
</script>

