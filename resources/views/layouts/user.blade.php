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
	
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css2?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet"> 

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.css') }}"> 
    @stack('styles')
</head>

<body>
	@php 
		$today = date("Y-m-d");
		$ads = App\Ads::where([
									['status','=', 'APPROVED'],
									['expired_at','>',$today]	
									])->get();
		
		$settings = App\Settings::where('name', 'logo')->get();
		$logo = $settings->last();
	@endphp
    <header>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
<!--
                    <img src="{{asset('assets/img/logo.svg')}}" width="180px"/>
-->				
					<img src="{{$logo->value}}" width="180px"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto d-block d-sm-none">
						<li class="nav-item">
							<a class="nav-link main-color " href="{{ route('user.profile') }}"><i class="bi bi-briefcase-fill"></i> My Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link main-color " href="{{ route('user.notifications') }}"><i class="bi bi-bell-fill"></i> My Notifications</a>
						</li>
						<li class="nav-item">
							<a class="nav-link main-color " href="{{ route('user.favourites') }}"><i class="bi bi-heart-fill"></i> My Favourites</a>
						</li>
						<li class="nav-item">
							<a class="nav-link main-color " href="{{ route('user.orders') }}"><i class="bi bi-cart-fill"></i> My Orders</a>
						</li>
						<li class="nav-item">
							<a class="nav-link main-color " href="{{ route('user.following') }}"><i class="bi bi-heart-fill"></i> Following</a>
						</li>
						<li class="nav-item">
							<a class="nav-link main-color " href="{{ route('user.pyls') }}"><i class="fas fa-file-image"></i> My PYL Stats</a>
						</li>
						<li class="nav-item">
							<a class="nav-link main-color " href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form-user').submit();"> <i class="bi bi-power"></i> Logout</a>
							
							<form id="logout-form-user" action="{{ route('logout') }}" method="POST" class="d-none">
								@csrf
							</form>
						</li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto d-none d-sm-block">
                        <!-- Authentication Links -->
                             <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
									<a class="dropdown-item" href="{{ route('user.profile') }}"><i class="bi bi-briefcase-fill"></i> My Profile</a>
									<a class="dropdown-item" href="{{ route('user.favourites') }}"><i class="bi bi-heart-fill"></i> My Favourites</a>
									<a class="dropdown-item" href="{{ route('user.notifications') }}"><i class="bi bi-bell-fill"></i> My Notifications</a>
									<a class="dropdown-item" href="{{ route('user.orders') }}"><i class="bi bi-cart-fill"></i> My Orders</a>
									<a class="dropdown-item" href="{{ route('user.following') }}"><i class="bi bi-heart-fill"></i> Following</a>
									<a class="dropdown-item" href="{{ route('user.pyls') }}"><i class="fas fa-file-image"></i> My PYL Stats</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form-user').submit();"> <i class="bi bi-power"></i> Logout</a>
                                    
                                    <form id="logout-form-user" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>
		
		<div class="main-color-bg" style="height: 100px; display: flex; flex-direction: row; flex-wrap: wrap; align-items: center;">
			<div class="container">
				<h2 class="font-weight-bold">@yield('page.title')</h2>
			</div>
		</div>
	<header>

	<div style="margin-bottom: 20%;">
		@if(Session::has('message'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<div class="container">
					{{ Session::get('message') }}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
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
    
    <footer class="main-color-bg fixed-bottom" style="height: 60px;">
		<div class="container">
			<div class="row">
				<div class="col p-2">
					<p class="">Powered by <a class="gold btn-link" href="http://www.zonicme.com" target="_blank">ZonicMe</a> 
						| <a class="gold btn-link" href="{{ route('pages', ['slug' => 'about']) }}">About us</a> 
						| <a class="gold btn-link" href="{{route('pages', ['slug' => 'privacy_policy'])}}">Privacy Policy</a>
						| <a class="gold btn-link" href="{{route('pages', ['slug' => 'terms'])}}">Terms</a>
						| <a class="gold btn-link" href="{{route('pages', ['slug' => 'contact'])}}">Contact us</a>
					</p>
				</div>
			</div>
		</div>
    </footer>
     <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
	<script src="{{ asset('assets/js/all.js') }}"></script>
	
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    -->
    @stack('scripts')
</body>
</html>
