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
	
	<div class="col-12 float-left" style="min-height: 80vh;">
		@yield('content')
	</div>
    

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
</html>
