{{-- <!doctype html>
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

    <!-- Scripts -->
<!--
    <script src="{{ asset('js/app.js') }}" defer></script>
-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css2?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet"> 
	
    <!-- Styles -->
<!--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
-->
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    @stack('styles')
</head>
@php 
	$today = date("Y-m-d");
	$ads = App\Ads::where([
								['status','=', 'APPROVED'],
								['expired_at','>',$today]	
								])->get();
	
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
	
	$settings2 = App\Settings::where('name', 'background_1')->get();
	$background = $settings2->last();
@endphp
<body style="background-image:url('{{$background->value}}');">
	
    <header class="col-12 float-left" style="background-color: rgba(21,21,21, 0.75);">
		<a class="navbar-brand" href="{{ url('/') }}">
<!--
                    <img src="{{asset('assets/img/logo.svg')}}" width="180px"/>
-->				
					<img src="{{$logo->value}}" width="180px"/>
		</a>
     </header>
	
	<div class="col-12 float-left" style="min-height: 85vh;">
		@yield('content')
	</div>
    

    <footer class="col-12"  style="float: left; min-height: 60px;  background-color: rgba(21,21,21,.68);">
		<div class="container">
			<div class="row">
				<div class="col p-2">
					<p class="white">Powered by <a class="white btn-link" href="http://www.zonicme.com" target="_blank">ZonicMe</a> 
						| <a class="white btn-link" href="{{ route('pages', ['slug' => 'about']) }}">About us</a> 
						| <a class="white btn-link" href="{{route('pages', ['slug' => 'privacy_policy'])}}">Privacy Policy</a>
						| <a class="white btn-link" href="{{route('pages', ['slug' => 'terms'])}}">Terms</a>
						| <a class="white btn-link" href="{{route('pages', ['slug' => 'contact'])}}">Contact us</a>
					</p>
				</div>
				<div class="col p-2">
					<a class="btn white btn-md float-right" href="https://www.facebook.com/MyYangaAfrica/?ref=pages_you_manage"><i class="bi bi-facebook"></i></a>
					<a class="btn white btn-md float-right" href="https://www.instagram.com/myyanga_backup/"><i class="bi bi-instagram"></i></a>
					<a class="btn white btn-md float-right" href="https://www.linkedin.com/in/myyanga-africa-1083a012b/"><i class="bi bi-linkedin"></i></a>
				</div>
			</div>
		</div>
    </footer>
    

    
     <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
	
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->

    @stack('scripts')
</body>
</html> --}}


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

  <!-- Scripts -->
<!--
  <script src="{{ asset('js/app.js') }}" defer></script>
-->

    <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href='https://fonts.googleapis.com/css2?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	
    <!-- Styles -->
<!--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
-->
  <link rel="stylesheet" href="{{ asset('assets/css/style/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style/main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style/responsive.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/mobile-phone-view.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/pattern.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}"> 
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css')}}">
    
    <!-- /* FOOTER STYLES */ -->

    @stack('styles')
    <style>
      .footer-text04 {
        color: rgba(148, 0, 14, 1);
      }
      .footer-auth {
        width: 100%;
        height: 384px;
        display: flex;
        padding: 0;
        overflow: hidden;
        position: relative;
        align-self: auto;
        box-sizing: border-box;
        align-items: flex-start;
        flex-shrink: 1;
        border-color: transparent;
        border-style: none;
        border-width: 0;
        margin-right: 0;
        border-radius: 0px 0px 0px 0px;
        margin-bottom: 0;
        flex-direction: row;
        justify-content: flex-start;
        background-color: rgba(217, 217, 217, 0.5);
      }
    </style>
    
	
	<style>
    .footer-footer {
      width: 100%;
      height: 384px;
      display: flex;
      padding: 0;
      overflow: hidden;
      position: relative;
      align-self: auto;
      box-sizing: border-box;
      align-items: flex-start;
      flex-shrink: 1;
      border-color: transparent;
      border-style: none;
      border-width: 0;
      margin-right: 0;
      border-radius: 0px 0px 0px 0px;
      margin-bottom: 0;
      flex-direction: row;
      justify-content: flex-start;
      background-color: rgba(217, 217, 217, 0.5);
    }
    .footer-text {
      top: 208px;
      left: 66% !important;
      color: rgba(0, 0, 0, 1);
      width: 234px;
      height: auto;
      position: absolute;
      font-size: 15px;
      align-self: auto;
      font-style: Regular;
      text-align: center;
      font-family: Garamond;
      font-weight: 400;
      line-height: normal;
      font-stretch: normal;
      text-decoration: none;
    }
    .footer-text01 {
      color: rgba(0, 0, 0, 1);
      left: 66% !important;
      font-weight: 400;
    }
    .footer-text02 {
      color: rgba(136, 0, 11, 1);
      font-weight: 700;
    }
    .footer-vector {
      top: 131px;
      left: 70%;
      width: 40px;
      height: 40px;
      position: absolute;
      box-sizing: border-box;
    }
    .footer-vector1 {
      top: 132px;
      left: 75%;
      width: 40px;
      height: 40px;
      position: absolute;
      box-sizing: border-box;
    }
    .footer-vector2 {
      top: 131px;
      left: 80%;
      width: 40px;
      height: 40px;
      position: absolute;
      box-sizing: border-box;
    }
    .footer-text03 {
      top: 85px;
      left: 77px;
      color: rgba(148, 0, 14, 1);
      width: 150px;
      height: auto;
      position: absolute;
      font-size: 13px;
      align-self: auto;
      font-style: Regular;
      text-align: left;
      font-family: Garamond;
      font-weight: 400;
      line-height: 251.49998664855957%;
      font-stretch: normal;
      text-decoration: none;
    }
    .footer-text04 {
      color: rgba(148, 0, 14, 1);
    }
    .footer-text08 {
      color: rgba(146, 0, 13, 1);
    }
    .footer-text12 {
      color: rgba(136, 0, 11, 1);
    }
    .footer-text16 {
      color: rgba(146, 0, 13, 1);
    }
    .footer-text18 {
      top: 85px;
      left: 33%;
      color: rgba(0, 0, 0, 1);
      height: auto;
      position: absolute;
      font-size: 13px;
      align-self: auto;
      font-style: Bold;
      text-align: left;
      font-family: Garamond;
      font-weight: 700;
      line-height: 148.00000190734863%;
      font-stretch: normal;
      text-decoration: none;
    }
    .footer-text19 {
      color: rgba(0, 0, 0, 1);
      font-weight: 700;
    }
    .footer-text23 {
      color: rgba(146, 0, 13, 1);
      font-weight: 400;
    }
    .footer-text27 {
      color: rgba(0, 0, 0, 1);
      font-weight: 700;
    }
    .footer-text31 {
      color: rgba(146, 0, 13, 1);
      font-weight: 400;
    }
    .footer-text35 {
      color: rgba(0, 0, 0, 1);
      font-weight: 700;
    }
    .footer-text43 {
      top: 27px;
      left: 33%;
      color: rgba(0, 0, 0, 1);
      width: 195px;
      height: auto;
      position: absolute;
      font-size: 28px;
      align-self: auto;
      font-style: Bold;
      text-align: left;
      font-family: Garamond;
      font-weight: 700;
      line-height: 175%;
      font-stretch: normal;
      text-decoration: none;
    }
    .footer-text45 {
      top: 27px;
      left: 77px;
      color: rgba(0, 0, 0, 1);
      width: 171px;
      height: auto;
      position: absolute;
      font-size: 28px;
      align-self: auto;
      font-style: Bold;
      text-align: left;
      font-family: Garamond;
      font-weight: 700;
      line-height: 175%;
      font-stretch: normal;
      text-decoration: none;
    }
      
      
	</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="{{ asset('assets/js/sharer.js') }}"></script>

    @stack('styles')
</head>
<body class="">
	@php 
		$today = date("Y-m-d");
		$ads = App\Ads::where([
									['status','=', 'APPROVED'],
									['expired_at','>',$today]	
									])->get();
		
		$settings = App\Settings::where('name', 'logo')->get();
		$logo = $settings->last();
	@endphp
    <header class="header  {{ (url()->current() == url('/') ? ' ' : 'dark-grey-bg') }}">
        <nav class="navbar navbar-expand-md navbar-light p-0 bg-white px-3 py-0">
			<a class="navbar-brand py-2" href="{{ url('/') }}">
<!--
				<img src="{{asset('assets/img/logo.svg')}}" width="180px"/>
-->
				<img src="{{$logo->value}}" width="180px"/>
			</a>
			
<!--
			<button class="navbar-toggler main-color-bg btn-lg" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
				<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="2em" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
				  <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
				</svg>
			</button>
-->
			<div class=" my-navbar-collapse">
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
				
					<!-- Left Side Of Navbar -->
					<ul class="navbar-nav text-uppercase">
						<li class="nav-item">

							<form class="form-inline" method="get" action="{{route('search') }}">
								@csrf
								<div class="input-group col-lg-12">
								  <div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-magnifying-glass"></i></span>
								  </div>
								  <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" value="{{ $keyword ?? old('search')}}" aria-label="Search">
								</div>
							  </form>

	<!--
							<a class="nav-link" href="{{ route('explore') }}">Explore</a>
	-->
						</li>
						
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav text-uppercase ml-auto">
						{{-- <form class="form-inline" method="get" action="{{route('search') }}" style="width: 89%;">
							@csrf
							<input class="form-control mr-sm-2" type="search" name="search" value="{{ $keyword ?? old('search')}}" placeholder="Type in what you are looking for and press enter to search" aria-label="Search" style="width:80%;" required />
							<button class="btn main-color-bg my-2 mr-2 my-sm-0" type="submit"><i class="bi bi-search"></i></button> --}}
							
						{{-- </form> --}}
						<li class="nav-item">
							<a class="nav-link gold " href="{{ route('home') }}">Home</a>
						</li>

						<li class="nav-item">
							<a class="nav-link gold " data-toggle="collapse" href="#exploreMenu" role="button" aria-expanded="false" aria-controls="exploreMenu">Explore</a>
						</li>

						<li class="nav-item">
							<a class="nav-link gold " href="{{ route('shop') }}">Shop</a>
						</li>
						<li class="nav-item">
							<a class="nav-link gold " href="{{ route('search.smart') }}">Smart Search</a>
						</li>
						@guest
							<li class="nav-item">
								<a class="nav-link black " href="{{ route('register') }}"><b><i class="fa-solid fa-user-plus"></i> Sign-up</b></a>
							</li>
							<li class="nav-item">
								<a class="nav-link black " href="{{ route('login') }}"><b><i class="fa-solid fa-user-large"></i> Login</b></a>
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
									<form id="logout-form-admin" action="{{ route('logout') }}" method="POST" class="d-none">
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
									<form id="logout-form-business" action="{{ route('logout') }}" method="POST" class="d-none">
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
									<form id="logout-form-user" action="{{ route('logout') }}" method="POST" class="d-none">
										@csrf
									</form>
								 </li>
							@endif
						@endauth

						<li class="nav-item">
							&nbsp;
						</li>
							
						
					</ul>
				</div>
			</div>
		
        </nav>
	</header>
	
	<div class="col-12 float-left content p-0">
		@yield('content')
		
	</div>
	<!-- Explore! -->
    @include('explore.index')
    
<!-- <div class="d-none d-sm-none d-lg-block">
    <footer class="col-12"  style="float: left; height: 60px;">
		<div class="container">
			<div class="row">
				<div class="col p-2">
					<p class="">Powered by <a class="main-color btn-link" href="http://www.zonicme.com" target="_blank">ZonicMe</a> 
						| <a class="main-color btn-link" href="{{ route('pages', ['slug' => 'about']) }}">About us</a> 
						| <a class="main-color btn-link" href="{{route('pages', ['slug' => 'privacy_policy'])}}">Privacy Policy</a>
						| <a class="main-color btn-link" href="{{route('pages', ['slug' => 'terms'])}}">Terms</a>
						| <a class="main-color btn-link" href="{{route('pages', ['slug' => 'contact'])}}">Contact us</a>
					</p>
				</div>
				<div class="col p-2">
					<a class="btn btn-md float-right" href="https://www.facebook.com/MyYangaAfrica/?ref=pages_you_manage"><i class="bi bi-facebook"></i></a>
					<a class="btn btn-md float-right" href="https://www.instagram.com/myyanga_backup/"><i class="bi bi-instagram"></i></a>
					<a class="btn btn-md float-right" href="https://www.linkedin.com/in/myyanga-africa-1083a012b/"><i class="bi bi-linkedin"></i></a>
				</div>
			</div>
		</div>
    </footer>
</div> -->

    <footer class="d-none d-sm-none d-lg-block footer-auth">
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
	<div class=" py-3 main-color-bg" >
		<ul class="nav d-flex justify-content-around text-uppercase">
			<li class="nav-item">
				<a class="nav-link gold font-weight-bolder" data-toggle="collapse" href="#exploreMenu" role="button" aria-expanded="false" aria-controls="exploreMenu">Enter</a>
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

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/js/all.min.js" integrity="sha512-8pHNiqTlsrRjVD4A/3va++W1sMbUHwWxxRPWNyVlql3T+Hgfd81Qc6FC5WMXDC+tSauxxzp1tgiAvSKFu1qIlA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="{{ asset('assets/js/all.js') }}"></script>
	<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		
	
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
    <script>
		
		$(document).ready(function() {	
			$(".adts").owlCarousel({
				items: 1,
				loop:true,
				margin:10,
				autoplay:true,
			});
			
			//~ var timg = document.getElementsByClassName('today-img');
		
			//~ for (var i = 0; i < timg.length; i++)
			//~ {
				//~ timg[i].style.height = screen.height+"px";
			//~ }
				
		});
		new Splide( '.splide', {
				autoplay : true,
				type : 'loop',
				arrows : false,
				pagination : false,
				autoWidth: true,
			}).mount();
	</script>
    @stack('scripts')
</body>
</html>
