<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:image" content="{{ asset('assets/img/favicon.png') }}">
    <meta property="og:image:secure_url" content="{{ asset('assets/img/favicon.png') }}">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="600">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title'){{ env('APP_NAME') }}</title>

    <link href="{{ asset('assets/lib/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/typicons.font/typicons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/select2/css/select2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/azia.css') }}">
    <style>
        .az-header{
            background-color: #fff;
        }
        .az-content-breadcrumb span a{
            color: #969dab;
        }
        .az-content-breadcrumb span:last-child a{
            color: #70737c;
        }
        .az-body-sidebar .az-content-header{
            padding: 15px 20px;
        }
        .az-content-breadcrumb{
            margin-bottom: 0;
        }
        .az-header-menu-icon span::before, .az-header-menu-icon span::after{
            background-color: #000;
        }
        .az-header-menu-icon span{
            background-color: #000;
        }
        .az-header-message > a, .az-header-notification > a{
            color: #fff;
        }
        a{
            color: #70737c;
        }
        .select2-container{
            width: 100%!important;
        }
        .ui-datepicker-year{
            border: 0;
            font-weight: bold;
        }
        .ui-datepicker .ui-datepicker-calendar .ui-datepicker-today a, .ui-datepicker .ui-datepicker-calendar .ui-datepicker-today a:hover, .ui-datepicker .ui-datepicker-calendar .ui-datepicker-today a:focus{
            background-color: transparent;
            color: #000;
        }
        .ui-datepicker .ui-datepicker-calendar td span, .ui-datepicker .ui-datepicker-calendar td a.ui-state-active{
            background-color: #007bff;
            color: #fff;
        }
        @media (min-width: 992px) {
            .custom-width{
                max-width: calc(100vw - 240px);
            }
            .normal-width{
                max-width: 100vw;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="az-body az-body-sidebar">
<div class="az-sidebar">
    <div class="az-sidebar-loggedin pt-3">
        <div class="az-img-user online"><img src="{{ asset('assets/img/user.png') }}" alt=""></div>
        <div class="media-body">
            <h6>{{ Auth::user()->name }}</h6>
            <span>{{ Auth::user()->user_level }}</span>
        </div>
    </div>
    <div class="az-sidebar-body">
        <ul class="nav">
            <li class="nav-label">Main Menu</li>
            @php
                $modules = Auth::user()->modulAvailable();
            @endphp
            @foreach ($modules as $module)
                @if($module->url != '#')
                    <li class="nav-item @if(Session::get('menu_active') == $module->url) active show @endif">
                        <a @if(Route::has($module->url)) href="{{ route($module->url) }}" @endif class="nav-link"><i class="{{ $module->icon }}"></i>{{ $module->caption }}</a>
                    </li>
                @else
                    <li class="nav-item @if(Session::get('menu_active') == $module->url) active show @endif">
                        <a href="javascript:void(0)" class="nav-link with-sub"><i class="la la-shield"></i>{{ $module->caption }}</a>
                        <nav class="nav-sub">
                            @if(count($module->sub_modules) > 0)
                                @foreach($module->sub_modules as $subModule)
                                    <a @if(Route::has($subModule->url)) href="{{ route($subModule->url) }}" @endif class="nav-sub-link @if(Session::get('menu_active') == $subModule->url) active show @endif">{{ $subModule->caption }}</a>
                                @endforeach
                            @endif
                        </nav>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
<div class="az-content az-content-dashboard-two custom-width">
    <div class="az-header">
        <div class="container-fluid">
            <div class="az-header-left">
                <a href="" id="azSidebarToggle" class="az-header-menu-icon"><span></span></a>
            </div>
            <div class="az-header-center text-center">
                <img src="{{ asset('images/logo.png') }}" alt="" class="img-fluid" style="height: 3rem;">
            </div>
            <div class="az-header-right">
{{--                <div class="dropdown az-header-notification">--}}
{{--                    <a href="" class="new"><i class="typcn typcn-bell"></i></a>--}}
{{--                    <div class="dropdown-menu">--}}
{{--                        <div class="az-dropdown-header mg-b-20 d-sm-none">--}}
{{--                            <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>--}}
{{--                        </div>--}}
{{--                        <h6 class="az-notification-title">Notifications</h6>--}}
{{--                        <p class="az-notification-text">You have 0 unread notification</p>--}}
{{--                        <div class="az-notification-list">--}}
{{--                            <div class="media new">--}}
{{--                                <div class="media-body">--}}
{{--                                    <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>--}}
{{--                                    <span>Mar 15 12:32pm</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="dropdown-footer"><a href="">View All Notifications</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="dropdown az-profile-menu">
                    <a href="" class="az-img-user"><img src="{{ asset('assets/img/user.png') }}" alt=""></a>
                    <div class="dropdown-menu">
                        <div class="az-dropdown-header d-sm-none">
                            <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                        </div>
                        <div class="az-header-profile">
                            <div class="az-img-user">
                                <img src="{{ asset('assets/img/user.png') }}" alt="">
                            </div>
                            <h6>{{ Auth::user()->name }}</h6>
                            <span>{{ Auth::user()->user_level }}</span>
                        </div>

                        <a href="{{ route('logout') }}" class="dropdown-item"><i class="typcn typcn-power-outline"></i> Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('_tools.alert')
    @yield('content')
    <div class="az-footer">
        <div class="container-fluid">
            <span>&copy; {{ date('Y') }} beriberbagi.id</span>
            <span>Designed by the hand of <i class="la la-code"></i> Epic</span>
        </div>
    </div>
</div>
@stack('modals')

<script src="{{ asset('assets/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/lib/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/lib/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/lib/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/autoNumeric.js') }}"></script>

<script src="{{ asset('assets/js/azia.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function(){
        'use strict';

        $('.az-sidebar .with-sub').on('click', function(e){
            e.preventDefault();
            $(this).parent().toggleClass('show');
            $(this).parent().siblings().removeClass('show');
        });

        $(document).on('click touchstart', function(e){
            e.stopPropagation();

            // closing of sidebar menu when clicking outside of it

            if(!$(e.target).closest('.az-header-menu-icon').length) {
                var sidebarTarg = $(e.target).closest('.az-sidebar').length;
                if(!sidebarTarg) {
                    $('body').removeClass('az-sidebar-show');
                }
            }
        });


        $('#azSidebarToggle').on('click', function(e){
            e.preventDefault();

            $('.az-content-dashboard-two').removeAttr('style');
            if(window.matchMedia('(min-width: 992px)').matches) {
                $('body').toggleClass('az-sidebar-hide');
                $('.az-content-dashboard-two').toggleClass('custom-width normal-width');
            } else {
                $('body').toggleClass('az-sidebar-show');
            }
        });

        $('.select2').select2();
        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy',
            showOtherMonths: true,
            selectOtherMonths: true,
            changeYear: true
        });
        $('.autonumeric').attr('data-a-sep','.');
        $('.autonumeric').attr('data-a-dec',',');
        $('.autonumeric').autoNumeric({mDec: '0',vMax:'9999999999999999999999999'});
        $('.autonumeric-decimal').attr('data-a-sep','.');
        $('.autonumeric-decimal').attr('data-a-dec',',');
        $('.autonumeric-decimal').autoNumeric({mDec: '2',vMax:'999'});
    });
</script>
@stack('scripts')
</body>
</html>
