     @extends('admin-panel.base.main')
     @section('css')
         <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
         <style>
             .submenu{
                 display: none;
             }
         </style>
     @endsection
     @section('content')
         <nav aria-label="breadcrumb">
             <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
                <li class="breadcrumb-item"><a href="{{ route('career_dashboard.index',['active'=>'reports-menu-items']) }}">Hiring Reports</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hiring Pool Dashboard</li>
             </ol>
         </nav>
        <div class="row mb-4">
            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Total Applications ( {{ $careers->count() ?? 0 }} ) </b></div>
                        <div id="basicArea-chart" style="min-height: 100px;">
                            <canvas id="totalApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Tiktok Applications ( {{ $all_applications['Tiktok'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="TiktokApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Facebook Applications ( {{ $all_applications['Facebook'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="facebookApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Youtube Applications ( {{ $all_applications['Youtube'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="youtubeApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Website Applications ( {{ $all_applications['Website'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="websiteApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Instagram Applications ( {{ $all_applications['Instagram'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="instagramApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Friend Applications ( {{ $all_applications['Friend'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="friendApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Other Applications ( {{ $all_applications['Other'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="otherApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Radio Applications ( {{ $all_applications['Radio'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="radioApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-lg-3">
                <div class="card mb-4 o-hidden">
                    <div class="card-body ul-card__widget-chart" style="position: relative;">
                        <div class="m-2"><b>Restaurant Applications ( {{ $all_applications['Restaurant'] }} ) </b></div>
                        <div id="basicArea-chart2" style="min-height: 100px;">
                            <canvas id="restaurantApplicationsChart" width="400" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     @endsection

     @section('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Labels for all Applications
            var labels = [
                    'Tiktok ({{ $all_applications["Tiktok"] }})',
                    'Facebook ({{ $all_applications["Facebook"] }})',
                    'Youtube ({{ $all_applications["Youtube"] }})',
                    'Website ({{ $all_applications["Website"] }})',
                    'Instagram ({{ $all_applications["Instagram"] }})',
                    'Friend ({{ $all_applications["Friend"] }})',
                    'Other ({{ $all_applications["Other"] }})',
                    'Radio ({{ $all_applications["Radio"] }})',
                    'Restaurant ({{ $all_applications["Restaurant"] }})'
                    ]
            var data = [
                    {{ $all_applications['Tiktok'] }},
                    {{ $all_applications['Facebook'] }},
                    {{ $all_applications['Youtube'] }},
                    {{ $all_applications['Website'] }},
                    {{ $all_applications['Instagram'] }},
                    {{ $all_applications['Friend'] }},
                    {{ $all_applications['Other'] }},
                    {{ $all_applications['Radio'] }},
                    {{ $all_applications['Restaurant'] }}
            ]
        </script>
        <script src="{{ asset('js/custom_js/hiring_dashboard_charts.js')}}"></script>
     @endsection
