<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" type="image/ico" href="{{ asset('assets/img/favicon.ico') }}">
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	

	
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style/responsive.css') }}">
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-phone-view.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pattern.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    @stack('styles')

    <style>
        /* Custom form styles */
        .mc4wp-custom-subscription-form {
            max-width: 400px;
            margin: 2rem auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            background: #ffffff;
            font-family: Arial, sans-serif;
        }

        .mc4wp-custom-subscription-form h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .mc4wp-custom-input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .mc4wp-custom-input-group input {
            width: 100%;
            padding: 10px 10px 10px 40px;
            border: 2px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 1em;
        }

        .mc4wp-custom-input-group .fa {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #888;
        }

        .mc4wp-custom-submit-button {
            width: 100%;
            padding: 10px;
            background-color: #2f3e46;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        .mc4wp-custom-submit-button:hover {
            background-color: #354b57;
        }
        
        .footer-text04 {
            color: rgba(148, 0, 14, 1);
        }
       
    </style>
</head>
<body>
    @php 
        $today = date("Y-m-d");
        $ads = App\Ads::where([
            ['status', '=', 'APPROVED'],
            ['expired_at', '>', $today]    
        ])->get();
        
        $settings = App\Settings::where('name', 'logo')->get();
        $logo = $settings->last();
    @endphp

    <header class="header {{ (url()->current() == url('/') ? ' ' : 'dark-grey-bg') }}">
        <nav class="navbar navbar-expand-md navbar-light p-0 {{ (url()->current() == url('/') ? ' bg-white' : 'dark-grey-bg') }}">
            <a class="navbar-brand py-2" href="{{ url('/') }}">
                <img src="{{$logo->value}}" width="180px"/>
            </a>
            @if(count($cart) > 0)
                <div class="d-block d-sm-block d-lg-none">
                    <li class="nav-item">
                        <a class="btn btn-link gold " href="{{ route('shop.cart') }}">{{count($cart)}}<i class="bi bi-cart-fill"></i></a>
                    </li>
                </div>
            @endif

            <div class="my-navbar-collapse">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav text-uppercase">
                        <li class="nav-item">
                            <a class="nav-link gold " data-toggle="collapse" href="#exploreMenu" role="button" aria-expanded="false" aria-controls="exploreMenu">Explore</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link gold " href="{{ route('shop') }}">Shop</a>
                        </li>
                        @if(count($cart) > 0)
                            <li class="nav-item">
                                <a class="nav-link gold " href="{{ route('shop.cart') }}">{{count($cart)}}<i class="bi bi-cart-fill"></i></a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav flex-grow-1 text-uppercase">
                        <a class="nav-link gold " style="white-space: nowrap;" href="{{ route('search.smart') }}">Smart Search</a>
                        <form class="form-inline" method="get" action="{{route('search') }}" style="width: 70%;">
                            @csrf
                            <input class="form-control mr-sm-2" type="search" name="search" value="{{ $keyword ?? old('search')}}" placeholder="Type in what you are looking for and press enter to search" aria-label="Search" style="width:60%;" required />
                            <button class="btn main-color-bg my-2 mr-2 my-sm-0" type="submit"><i class="bi bi-search"></i></button>
                        </form>
                        <li class="nav-item">
                            
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link gold " href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link gold " href="{{ route('register') }}">Register</a>
                            </li>
                        @endguest
                        @auth
                            @if(Auth::user()->type == "ADMIN")
                                <li class="nav-item">
                                    <a class="nav-link gold " href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link gold " href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                 </li>
                            @elseif(Auth::user()->type == "BUSINESS")
                                <li class="nav-item">
                                    <a class="nav-link gold " href="{{ route('business.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link gold " href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                 </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link gold " href="{{ route('user.profile') }}">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link gold " href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                 </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="col-12 content p-0">
        @if(Session::has('message'))
            <div class="collapse show" id="closeCollapse">
                <div class="fixed-top d-flex justify-content-center align-items-center" style="height:100%; background-color: rgba(21,21,21, .9);">
                    <div class="col-lg-3 col-md-4 col-sm-10 mx-3 white-bg" style="max-width: 400px; width: 400px;">
                        <div class="col-12 p-4">
                            <p class="text-center" style="width: auto;">{{ Session::get('message') }}</p>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 m-0 p-1">
                                <a class="btn main-color-bg btn-block rounded-0" href="{{route('shop.cart')}}">
                                    View Cart
                                </a>
                            </div>
                            <div class="col-md-6 col-sm-12 m-0 p-1">
                                <a class="btn main-color-bg btn-block rounded-0 continue-btn" data-toggle="collapse" href="#closeCollapse" role="button" aria-expanded="false" aria-controls="closeCollapse">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger">
            <div class="container">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        @yield('content')
    </div>
    <!-- Explore! -->
    @include('explore.index')
    
    <footer class="d-none d-sm-none d-lg-block mt-5">
        <div class="container p-5">
            <div class="row" id="cards">
                <div class="footer-item col">
                    <h4>More Info</h4>
                    <ul class="row-li">
                        <li onclick="location.href='{{ route('pages', ['slug' => 'about']) }}'">About Us</li>
                        <li onclick="location.href='{{ route('pages', ['slug' => 'privacy_policy']) }}'">Privacy Policy</li>
                        <li onclick="location.href='{{ route('pages', ['slug' => 'terms']) }}'">Terms</li>
                        <li onclick="location.href='{{ route('pages', ['slug' => 'contact']) }}'">Contact</li>
                    </ul>
                </div>
                <div class="footer-item col">
                    <h4>Contact Us</h4>
                    <ul class="row-li row-li-2">
                        <ul>
                          <li><i class="fa-solid fa-envelope"></i><a href="mailto:info@myyanga.com" class="footer-text04"> info@myyanga.com</a></li>
                          <li><i class="fa-solid fa-phone"></i> <a href="tel:+2347062425945" class="footer-text04"> +234 706 242 5945</a></li>

                        <li>
                            <i class="fa-solid fa-location-dot"></i> <span> ZonicMe Limited
                                Floor M2, Transcorp Hilton, Abuja</span>
                        </li>
                    </ul>
    
                </div>
                <div class="footer-item col-lg-2 col-12">
                    <ul class="social">
                        <li>
                            <ul class="d-flex justify-content-between">
                                <li><i class="fa-brands fa-facebook"></i></li>
                                <li><i class="fa-brands fa-instagram"></i></li>
                                <li><i class="fa-brands fa-linkedin"></i></li>
                            </ul>
                        </li>
                        <li class="text-left my-4 powered">Powered by <span><a href="http://zonicme.com/">ZonicMe.com
                            </span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


    <div class="fixed-bottom d-block d-sm-block d-lg-none white-bg mobile-menu">
        <div class=" py-3 main-color-bg">
            <ul class="nav d-flex justify-content-around text-uppercase">
                <li class="nav-item">
                    <a class="nav-link gold font-weight-bolder" data-toggle="collapse" href="#exploreMenu" role="button" aria-expanded="false" aria-controls="exploreMenu">Explore</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link gold font-weight-bolder" href="{{route('search') }}">Search</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link gold font-weight-bolder" href="{{ route('login') }}">Login</a>
                    </li>
                @endguest
                @auth
                    @if(Auth::user()->type == "ADMIN")
                        <li class="nav-item">
                            <a class="nav-link gold font-weight-bolder" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                    @elseif(Auth::user()->type == "BUSINESS")
                        <li class="nav-item">
                            <a class="nav-link gold font-weight-bolder" href="{{ route('business.dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link gold font-weight-bolder" href="{{ route('user.profile') }}">Profile</a>
                        </li>
                    @endif
                @endauth
            </ul>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
    <script src="{{ asset('assets/js/all.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>

    <script>
        $(document).ready(function() {    
            $(".adts").owlCarousel({
                items: 1,
                loop: true,
                margin: 10,
                autoplay: true,
            });
        });

        new Splide('.splide', {
            autoplay: true,
            type: 'loop',
            arrows: false,
            pagination: false,
            autoWidth: true,
        }).mount();
    </script>
    @stack('scripts')
</body>
</html>
