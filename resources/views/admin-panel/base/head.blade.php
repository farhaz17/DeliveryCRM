<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />

<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<title>Zone Multi Solution Provider</title>
<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{asset('assets/css/themes/lite-purple.min.css')}}" rel="stylesheet" />
<link href="{{asset('assets/css/plugins/perfect-scrollbar.min.css')}}" rel="stylesheet" />
<link rel="icon" href="{{asset('assets/images/favicon.ico')}}">
<style>
    .button-icon {
        background-color: #004A7F;
        -webkit-border-radius: 10px;
        border-radius: 15px;
        border: none;
        color: #FFFFFF;
        cursor: pointer;
        /* display: inline-block; */
        /* font-family: Arial; */
        font-size: 14px;
        padding: 5px 10px;
        text-align: center;
        text-decoration: none;
        -webkit-animation: glowing 1500ms infinite;
        -moz-animation: glowing 1500ms infinite;
        -o-animation: glowing 1500ms infinite;
        animation: glowing 1500ms infinite;
    }
    @-webkit-keyframes glowing {
        0% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
        50% { background-color: #FF0000; -webkit-box-shadow: 0 0 40px #FF0000; }
        100% { background-color: #B20000; -webkit-box-shadow: 0 0 3px #B20000; }
    }

    @-moz-keyframes glowing {
        0% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
        50% { background-color: #FF0000; -moz-box-shadow: 0 0 40px #FF0000; }
        100% { background-color: #B20000; -moz-box-shadow: 0 0 3px #B20000; }
    }

    @-o-keyframes glowing {
        0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
        50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
        100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
    }

    @keyframes glowing {
        0% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
        50% { background-color: #FF0000; box-shadow: 0 0 40px #FF0000; }
        100% { background-color: #B20000; box-shadow: 0 0 3px #B20000; }
    }
</style>
{{--<script src="https://js.pusher.com/4.1/pusher.min.js"></script>--}}
<!--{{--<script>--}}-->
<!---->
<!--    {{--var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {--}}-->
<!--        {{--cluster: '{{env("PUSHER_APP_CLUSTER")}}',--}}-->
<!--        {{--encrypted: true--}}-->
<!--    {{--});--}}-->
<!---->
<!--    {{--var channel = pusher.subscribe('notify-channel');--}}-->
<!--    {{--channel.bind('App\\Events\\Notify', function(data) {--}}-->
<!--        {{--alert(data.message);--}}-->
<!--    {{--});--}}-->
<!--{{--</script>--}}-->
