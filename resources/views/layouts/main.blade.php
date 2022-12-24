<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@section('title') {{ env('APP_NAME') }}</title>

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Rubik:400,500,700&subset=latin-ext" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/responsive.css') }}" />
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon"/>
    <style>
        .page-title{
            min-height: 120px;
        }
        .campaign-detail .campaign-image {
            width: 50%;
            float: left;
            padding-right: 15px;
        }
        .btn-primary.active, .btn-primary:active, .show>.btn-primary.dropdown-toggle {
            background-color: #00a6eb;
            background-image: none;
            border-color: #00a6eb;
            color: #fff;
        }
        .dropdown-menu {
            line-height: 14px;
        }
        .dropdown-menu a.dropdown-item{
            font-size: 10pt;
            text-align: right;
        }
        @media screen and (max-width: 992px){
            .staff-picks-item a.staff-picks-image, .project-love-item a.project-love-image, .campaign-big-item a.campaign-big-image {
                width: 100% !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="@yield('classbody')">
<div id="wrapper">
    <header id="header" class="site-header">
        <div class="container">
            <div class="site-brand">
                <a href="{{ route('/') }}"><img src="{{ asset('images/logo.png') }}" alt="" style="height: 50px;width: auto;"></a>
            </div>
            <div class="right-header">
                <nav class="main-menu">
                    <button class="c-hamburger c-hamburger--htx"><span></span></button>
                    <ul>
                        <li>
                            <a href="{{ route('/') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('campaign') }}">Data Bantuan</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}">Tentang</a>
                        </li>
                        <li>
                            <a href="{{ route('faq') }}">FAQ</a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}">Hubungi</a>
                        </li>
                    </ul>
                </nav>
                <div class="search-icon">
                    <a href="#" class="ion-ios-search-strong"></a>
                    <div class="form-search"></div>
                    <form action="{{ route('campaign.search_menu') }}" method="get" id="searchForm">
                        @csrf
                        <input type="text" name="search" placeholder="Search..." required />
                        <button type="submit" value=""><span class="ion-ios-search-strong"></span></button>
                    </form>
                </div>

                <div class="login login-button">
                    @guest
                        <a href="{{ route('login') }}" class="btn-primary" style="padding: 0 20px;">Join with Us</a>
                    @else
                        @if(Auth::user()->user_level != 'user')
                            <a href="{{ route('admin') }}" class="btn-primary" style="padding: 0 20px;">Admin Page</a>
                        @else
                            <div class="login login-button dropdown">
                                <a class="btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding: 0 20px;">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                    <hr class="mt-1 mb-1">
                                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                </div>
                            </div>
                        @endif
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <main id="main" class="site-main">
        @include('_tools.alert')
        @yield('content')
    </main>

    <footer id="footer" class="site-footer">
        <div class="footer-menu">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-12">
                        <div class="footer-menu-item newsletter" style="text-align: center;">
                            <div class="follow">
                                <h3>Follow us</h3>
                                <ul>
                                    <li class="facebook"><a target="_Blank" href="https://www.facebook.com"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li class="instagram"><a target="_Blank" href="https://www.instagram.com"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <p class="copyright">2020 Developed by Renandatta.</p>
                <a href="#" class="back-top">Back to top<span class="ion-android-arrow-up"></span></a>
            </div>
        </div>
    </footer>
</div>

@stack('modals')

<script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('libs/popper/popper.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('libs/jquery.countdown/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('libs/wow/wow.min.js') }}"></script>
<script src="{{ asset('libs/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('libs/bxslider/jquery.bxslider.min.js') }}"></script>
<script src="{{ asset('libs/magicsuggest/magicsuggest-min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('assets/js/autoNumeric.js') }}"></script>
<script>
    function add_commas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
    function remove_commas(nStr) {
        nStr = nStr.replace(/\./g,'');
        return nStr;
    }
    $('.autonumeric').attr('data-a-sep','.');
    $('.autonumeric').attr('data-a-dec',',');
    $('.autonumeric').autoNumeric({mDec: '0',vMax:'9999999999999999999999999'});
    $('.autonumeric-decimal').attr('data-a-sep','.');
    $('.autonumeric-decimal').attr('data-a-dec',',');
    $('.autonumeric-decimal').autoNumeric({mDec: '2',vMax:'999'});
</script>
@stack('scripts')
</body>
</html>
