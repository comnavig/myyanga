<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="icon" type="image/ico" href="{{ asset('assets/img/favicon.ico') }}">
    
    <script src="https://kit.fontawesome.com/47af6e4954.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    
    <link rel="stylesheet" href="{{ asset('assets/css/style/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style/responsive.css') }}">
    
    @stack('styles')
</head>
<body>
    @php 
        $today = date("Y-m-d");
        $ads = App\Ads::where([
            ['status', '=', 'APPROVED'],
            ['expired_at', '>', $today]    
        ])->get();
        
        $settings = App\Settings::whereIn('name', ['logo', 'background_1'])->get()->keyBy('name');
        $logo = $settings->get('logo');
        $background_1 = $settings->get('background_1');
    @endphp
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ $logo->value }}" alt="logo" class="logo-img">
                    </a>

                    <form class="me-auto mb-2 mb-md-0 nav-search d-none d-lg-block" method="get" action="{{ route('search') }}">
                        @csrf
                        <input class="form-control" type="text" value="{{ $keyword ?? old('search') }}" placeholder="Search" aria-label="Search">
                    </form>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mx-auto mb-2 mb-md-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('explore') }}">Explore</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('search.smart') }}">Smart Search</a>
                            </li>
                            <li class="nav-item">
                                <form class="me-auto mb-2 mb-md-0 nav-search d-block d-lg-none">
                                    <input class="form-control" type="text" placeholder="Search" aria-label="Search">
                                </form>
                            </li>
                        </ul>
                        
                        <div class="my-2 d-flex header-login">
                            @guest
                                <p onclick="location.href = '{{ route('login') }}'" class="me-3"><i class="fa-solid fa-user-plus"></i> Login</p>
                                <p onclick="location.href = '{{ route('register') }}'" class=""><i class="fa-solid fa-user"></i> Sign-up</p>
                            @endguest
                            
                            @auth
                                @if(Auth::user()->type == "ADMIN")
                                    <p onclick="location.href = '{{ route('admin.dashboard') }}'" class="me-3"><i class="fa-solid fa-user-plus"></i> Dashboard</p>
                                    <p onclick="event.preventDefault();document.getElementById('logout-form').submit();" class=""><i class="fa-solid fa-user"></i> {{ __('Logout') }}</p> 
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @elseif(Auth::user()->type == "BUSINESS")
                                    <p onclick="location.href = '{{ route('business.dashboard') }}'" class="me-3"><i class="fa-solid fa-user-plus"></i> Dashboard</p>
                                    <p onclick="event.preventDefault();document.getElementById('logout-form').submit();" class=""><i class="fa-solid fa-user"></i> {{ __('Logout') }}</p>  
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @else
                                    <p onclick="location.href = '{{ route('user.profile') }}'" class="me-3"><i class="fa-solid fa-user-plus"></i> Profile</p>
                                    <p onclick="event.preventDefault();document.getElementById('logout-form').submit();" class=""><i class="fa-solid fa-user"></i> {{ __('Logout') }}</p>  
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- hero -->
            <div class="px-4 py-5 text-center hero" style="background-image: url('{{ $background_1->value ?? '' }}'); background-size: cover; background-position: center;">
                <div class="col-lg-6 mx-auto">
                    <form class="me-auto mb-2 mb-md-0" method="get" action="{{ route('search') }}">
                        @csrf
                        <input class="form-control" type="search" name="search" value="{{ $keyword ?? old('search') }}" placeholder="Type in what you are looking for and press enter to search" aria-label="Search">
                    </form>
                </div>
            </div>
            <!-- hero ends -->
        </div>
    </header>
    
    <main class="my-5">
        @yield('content')
    </main>
    
    <!-- Explore! -->
    @include('explore.index')
    
    <footer>
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
                        <li><i class="fa-solid fa-envelope"></i><span> info@myyanga.com</span></li>
                        <li><i class="fa-solid fa-phone"></i> <span>+234 706 242 5945</span></li>
                        <li><i class="fa-solid fa-location-dot"></i> <span> ZonicMe Limited Floor M2, Transcorp Hilton, Abuja</span></li>
                    </ul>
                </div>
                <div class="footer-item col-lg-2 col-12">
                    <ul class="social">
                        <li>
                            <ul class="d-flex justify-content-evenly">
                                <li><i class="fa-brands fa-facebook"></i></li>
                                <li><i class="fa-brands fa-instagram"></i></li>
                                <li><i class="fa-brands fa-linkedin"></i></li>
                            </ul>
                        </li>
                        <li class="text-center my-4 powered">Powered by <span><a href="http://zonicme.com/">ZonicMe.com</a></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
