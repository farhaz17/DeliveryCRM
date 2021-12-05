@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
    <style>
        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="card col-12"> {{-- DC Wise Rider Orders Analysis --}}
            <div class="card-header text-white text-11 bg-secondary p-2 m-0">DC Leaderboard ( <span id="timer"></span> )</div>
            <div class="card-body row">
                <div class="col-2">
                    <div class="card-body row m-auto pt-1">
                        <b class="item-name">Date Range</b>
                        <div class="row">
                            <div class="col-12 mb-1">
                                <div class="bg-{{ request('date_range') == 'today' ? 'success' :  'primary' }}">
                                    <a href="{{ route('dc_leaderboard',['date_range' => 'today']) }}"
                                        class="btn btn-sm btn-block text-left text-white">
                                        <span class="item-name">Today</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 mb-1">
                                <div class="bg-{{ request('date_range') == 'last_week' ? 'success' :  'primary' }}">
                                    <a href="{{ route('dc_leaderboard',['date_range' => 'last_week']) }}"
                                        class="btn btn-sm btn-block text-left text-white">
                                        <span class="item-name">Last Week</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 mb-1">
                                <div class="bg-{{ request('date_range') == 'last_two_weeks' ? 'success' :  'primary' }}">
                                    <a href="{{ route('dc_leaderboard',['date_range' => 'last_two_weeks']) }}"
                                        class="btn btn-sm btn-block text-left text-white">
                                        <span class="item-name">Last Two Weeks</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 mb-1">
                                <div class="bg-{{ request('date_range') == 'last_month' ? 'success' :  'primary' }}">
                                    <a href="{{ route('dc_leaderboard',['date_range' => 'last_month']) }}"
                                        class="btn btn-sm btn-block text-left text-white">
                                        <span class="item-name">Last Month</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th style="width:1rem">Rank</th>
                                <th>Profile</th>
                                <th style="width:1rem">Scale</th>
                                <th>Progress</th>
                                <th style="width:1rem">Scores</th>
                                {{-- <th>Stars</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dcs as $dc)
                            @php $progress_bar_bg = 'danger'  @endphp
                                <tr>
                                    <td class="text-center align-middle">
                                        @if ($loop->iteration == 1)
                                            @php $progress_bar_bg = 'success'  @endphp
                                            <img class="profile-picture avatar-sm rounded-circle img-fluid"
                                                src="assets/images/crowns/first_position.png" alt=""><br>
                                            {{ $loop->iteration }}
                                        @elseif($loop->iteration == 2)
                                        @php $progress_bar_bg = 'warning'  @endphp
                                            <img class="profile-picture avatar-sm rounded-circle img-fluid"
                                                src="assets/images/crowns/second_position.png" alt=""><br>
                                            {{ $loop->iteration }}
                                        @elseif($loop->iteration == 3)
                                        @php $progress_bar_bg = 'secondary'  @endphp
                                            <img class="profile-picture avatar-sm rounded-circle img-fluid"
                                                src="assets/images/crowns/third_position.png" alt=""><br>
                                            {{ $loop->iteration }}
                                        @else
                                            {{ $loop->iteration }}
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid"
                                            src="{{ asset($dc->user_profile_picture ?? 'assets/upload/user_profile_picture/avatar.jpg') }}"
                                            alt=""> {{ $dc->name }}
                                    </td>
                                    <td class="text-center align-middle">100</td>
                                    <td class="text-center align-middle">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $progress_bar_bg }}"
                                                role="progressbar" style="width: {{ $dc->score }}%" aria-valuenow="{{ $dc->score }}" aria-valuemin="0"
                                                aria-valuemax="100">{{ $dc->score }}%</div>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">{{ $dc->score }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td>No record found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/toastr.min.js') }}"></script>
    <script>
        // setInterval(function(){
        //     location.reload();
        // }, 1000*60)
    </script>
@endsection
