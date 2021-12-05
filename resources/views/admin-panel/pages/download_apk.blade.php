
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Zone Delivery App</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--<link rel="shortcut icon" href="favicon.ico">--}}

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:700|Roboto:400,400i,700&display=swap" rel="stylesheet">

    <!-- FontAwesome JS-->
    <script defer src="{{asset('assets/static/assets/fontawesome/js/all.min.js')}}"></script>

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="{{asset('assets/static/assets/css/theme.css')}}">

</head>

<body>

<header class="header">
    <div class="branding">
        <div class="container-fluid position-relative py-3">
            {{--<div class="logo-wrapper">--}}
                {{--<div class="site-logo"><a class="navbar-brand" href="index.html"><img class="logo-icon mr-2" src="assets/images/site-logo.svg" alt="logo" ><span class="logo-text">DevBook</span></a></div>--}}
            {{--</div><!--//docs-logo-wrapper-->--}}

        </div><!--//container-->
    </div><!--//branding-->
</header><!--//header-->

<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-7 pt-5 mb-5 align-self-center">
                <div class="promo pr-md-3 pr-lg-5">
                    <h1 class="headline mb-3">
                        Zone Delivery Services
                    </h1><!--//headline-->
                    <div class="subheadline mb-4">
                        Welcome to zone delivery digital services.

                    </div><!--//subheading-->

                    <div class="cta-holder">
                        <a class="btn btn-primary mr-lg-2" href="{{route('apk-download')}}">Download Here</a>
                        {{--<a class="btn btn-secondary scrollto" href="#benefits-section">Learn More</a>--}}

                    </div><!--//cta-holder-->

                    {{--<div class="hero-quotes mt-5">--}}
                        {{--<div id="quotes-carousel" class="quotes-carousel carousel slide carousel-fade mb-5" data-ride="carousel" data-interval="8000">--}}
                            {{--<ol class="carousel-indicators">--}}
                                {{--<li data-target="#quotes-carousel" data-slide-to="0" class="active"></li>--}}
                                {{--<li data-target="#quotes-carousel" data-slide-to="1"></li>--}}
                                {{--<li data-target="#quotes-carousel" data-slide-to="2"></li>--}}
                            {{--</ol>--}}

                            {{--<div class="carousel-inner">--}}
                                {{--<div class="carousel-item active">--}}
                                    {{--<blockquote class="quote p-4 theme-bg-light">--}}
                                        {{--"Excellent Book! Add your book reviews here consectetur adipiscing elit. Aliquam euismod nunc porta urna facilisis tempor. Praesent mauris neque, viverra quis erat vitae, auctor imperdiet nisi."--}}
                                    {{--</blockquote><!--//item-->--}}
                                    {{--<div class="source media flex-column flex-md-row align-items-center">--}}
                                        {{--<img class="source-profile mr-md-3" src="assets/images/profiles/profile-1.png" alt="image" >--}}
                                        {{--<div class="source-info media-body text-center text-md-left">--}}
                                            {{--<div class="source-name">James Doe</div>--}}
                                            {{--<div class="soure-title">Co-Founder, Startup Week</div>--}}
                                        {{--</div>--}}
                                    {{--</div><!--//source-->--}}
                                {{--</div><!--//carousel-item-->--}}
                                {{--<div class="carousel-item">--}}
                                    {{--<blockquote class="quote p-4 theme-bg-light">--}}
                                        {{--"Highly recommended consectetur adipiscing elit. Proin et auctor dolor, sed venenatis massa. Vestibulum ullamcorper lobortis nisi non placerat praesent mauris neque"--}}
                                    {{--</blockquote><!--//item-->--}}
                                    {{--<div class="source media flex-column flex-md-row align-items-center">--}}
                                        {{--<img class="source-profile mr-md-3" src="assets/images/profiles/profile-2.png" alt="image" >--}}
                                        {{--<div class="source-info media-body text-center text-md-left">--}}
                                            {{--<div class="source-name">Jean Doe</div>--}}
                                            {{--<div class="soure-title">Senior Developer, Ipsum Company</div>--}}
                                        {{--</div>--}}
                                    {{--</div><!--//source-->--}}
                                {{--</div><!--//carousel-item-->--}}
                                {{--<div class="carousel-item">--}}
                                    {{--<blockquote class="quote p-4 theme-bg-light">--}}
                                        {{--"Awesome! Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam euismod nunc porta urna facilisis tempor. Praesent mauris neque, viverra quis erat vitae."--}}
                                    {{--</blockquote><!--//item-->--}}
                                    {{--<div class="source media flex-column flex-md-row align-items-center">--}}
                                        {{--<img class="source-profile mr-md-3" src="assets/images/profiles/profile-3.png" alt="image" >--}}
                                        {{--<div class="source-info media-body text-center text-md-left">--}}
                                            {{--<div class="source-name">Andy Doe</div>--}}
                                            {{--<div class="soure-title">Frontend Developer, Company Lorem</div>--}}
                                        {{--</div>--}}
                                    {{--</div><!--//source-->--}}
                                {{--</div><!--//carousel-item-->--}}
                            {{--</div><!--//carousel-inner-->--}}
                        {{--</div><!--//quotes-carousel-->--}}

                    {{--</div><!--//hero-quotes-->--}}
                </div><!--//promo-->
            </div><!--col-->
            <div class="col-12 col-md-5 mb-5 align-self-center">
                <div class="book-cover-holder">
                    <img class="img-fluid book-cover" src="{{'assets/static/assets/images/Capture.png'}}" alt="book cover" >
                    {{--<div class="book-badge d-inline-block shadow">--}}
                        {{--New<br>Release--}}
                    {{--</div>--}}
                </div><!--//book-cover-holder-->
                {{--<div class="text-center"><a class="theme-link scrollto" href="#reviews-section">See all book reviews</a></div>--}}
            </div><!--col-->
        </div><!--//row-->
    </div><!--//container-->
</section><!--//hero-section-->

<!-- Javascript -->
<script src="{{asset('assets/static/assets/plugins/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/static/assets/plugins/popper.min.js')}}"></script>
<script src="{{asset('assets/static/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/static/assets/plugins/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('assets/static/assets/plugins/back-to-top.js')}}"></script>

<script src="{{asset('assets/static/assets/js/main.js')}}"></script>

</body>
</html>

