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
	
    <!-- Styles -->
<!--
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
-->
    <link rel="stylesheet" href="{{ asset('assets/css/mobile-phone-view.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pattern.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}"> 
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css')}}">

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
        <nav class="navbar navbar-expand-md navbar-light p-0 {{ (url()->current() == url('/') ? ' bg-white' : 'dark-grey-bg') }}">

            <div class="landingpage-navigationbar">
                <span class="landingpage-text13">LOG-IN</span>
                <span class="landingpage-text14">EXPLORE</span>
                <span class="landingpage-text15">HOME</span>
                <span class="landingpage-text16">SHOP</span>
                <span class="landingpage-text17">SMART SEARCH</span>
                <span class="landingpage-text18">SIGN-UP</span>
                <img
                  alt="Rectangle34675244258"
                  src="/playground_assets/c559a87e-5914-4233-a6ec-972792d79877-kid-200h.png"
                  class="landingpage-rectangle3467524"
                />
                <div class="landingpage-search">
                  <span class="landingpage-text19">Search</span>
                  <img
                    alt="Rectangle34675264263"
                    src="/playground_assets/e7e2cc52-b95b-4bcb-85a0-9baf703be22c-3t6-400w.png"
                    class="landingpage-rectangle3467526"
                  />
                  <img
                    alt="Vector4270"
                    src="/playground_assets/3d22ea93-cbf3-4a88-9d2f-d23512bb84c7-aj7.svg"
                    class="landingpage-svg03"
                  />
                </div>
                <img
                  alt="Vector4278"
                  src="/playground_assets/61076016-ae85-4c3f-aed1-d8cc4f975d7e-b6gv.svg"
                  class="landingpage-svg04"
                />
                <img
                  alt="Vector712"
                  src="/playground_assets/863dbbcb-57e7-46d9-81fa-1a13b1f1b154-6sqq.svg"
                  class="landingpage-svg05"
                />
                <img
                  alt="Ellipse2713"
                  src="/playground_assets/34173937-88f8-4d45-bbb4-1b2e10fc3b38-jxwf.svg"
                  class="landingpage-svg06"
                />
                <img
                  alt="Line1714"
                  src="/playground_assets/76f76e92-7df7-4265-8620-2737b48d8d03-6zrp.svg"
                  class="landingpage-svg07"
                />
                <img
                  alt="personcircle140906"
                  src="/playground_assets/868ff1ca-3f8a-490a-bee8-c2427189c0fb-1ek6.svg"
                  class="landingpage-personcircle"
                />
              </div>
              
			{{-- <a class="navbar-brand py-2" href="{{ url('/') }}">
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
	<!--
							<a class="nav-link" href="{{ route('explore') }}">Explore</a>
	-->
							<a class="nav-link gold " data-toggle="collapse" href="#exploreMenu" role="button" aria-expanded="false" aria-controls="exploreMenu">Explore</a>
						</li>
						
						<li class="nav-item">
							<a class="nav-link gold " href="{{ route('shop') }}">Shop</a>
						</li>
						
					</ul>

					<!-- Right Side Of Navbar -->
					<ul class="navbar-nav flex-grow-1 text-uppercase">
						<form class="form-inline" method="get" action="{{route('search') }}" style="width: 89%;">
							@csrf
							<input class="form-control mr-sm-2" type="search" name="search" value="{{ $keyword ?? old('search')}}" placeholder="Type in what you are looking for and press enter to search" aria-label="Search" style="width:80%;" required />
							<button class="btn main-color-bg my-2 mr-2 my-sm-0" type="submit"><i class="bi bi-search"></i></button>
							<a class="nav-link gold " href="{{ route('search.smart') }}">Smart Search</a>
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
			</div> --}}
		
        </nav>
	</header>
	
	<div class="col-12 float-left content p-0">
		@yield('content')
		
	</div>
	<!-- Explore! -->
    @include('explore.index')
    
<div class="d-none d-sm-none d-lg-block">
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
					<a class="btn btn-md float-right" href="https://www.instagram.com/officialmyyanga_"><i class="bi bi-instagram"></i></a>
					<a class="btn btn-md float-right" href="https://www.linkedin.com/in/myyanga-africa-1083a012b/"><i class="bi bi-linkedin"></i></a>
				</div>
			</div>
		</div>
    </footer>
</div>

<div class="fixed-bottom d-block d-sm-block d-lg-none white-bg mobile-menu">
	<div class=" py-3 main-color-bg" >
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

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
	<script src="{{ asset('assets/js/all.js') }}"></script>
	<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
		
	
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
        <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H7N95N3X84"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-H7N95N3X84');
    </script>
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
