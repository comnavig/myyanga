@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
@endphp
    <header class="  {{ (url()->current() == url('/') ? ' ' : 'dark-grey-bg') }}">
        <nav class="navbar navbar-expand-md navbar-light p-0 {{ (url()->current() == url('/') ? ' bg-white' : 'dark-grey-bg') }}">
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
									<a class="nav-link gold " href="{{ route('user.dashboard') }}">Profile</a>
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
	
	<div class="col-12 float-left p-0" style="margin-bottom: 50px;">
		@php 
			$settings = App\Settings::where('name', 'background_1')->get();
			$background = $settings->last();
		@endphp
		<div class="col-12 float-left p-0">
			<div class="dark-ap-2 col-12 d-flex justify-content-center align-items-center" style="min-height: 220px; background-image:url('{{$background->value}}');">
				<h3 class="text-center white font-weight-bolder welcome-greeting" >
					Discover and connect with the best <br/>of African fashion and creativity, <br/>all in one spot.
					<br/><br/><a class="btn btn-lg golden-btn" href="{{route('tour')}}">Slide Tour</a>
					<br/>
				</h3>
				
			</div>
		</div>
		
		<div class="col-12 float-left p-0">
			<div class="row">
				@foreach($featuredcategories as $category)
					
					<div class="col-lg-4 col-md-12 col-sm-12 float-left" style="margin-top: 3%;">
						<h5 class="main-color font-weight-bold">{{$category->name}} </h5>
						@foreach($category->featured->sortDesc()->take(1) as $featured)
						@php
							$date_entered = date_create($featured->created_at);
							$timeframe = sprintf("%d Days", $category->expiry_date);
							date_add($date_entered, date_interval_create_from_date_string($timeframe));
							$today_date = date_create('now');
						@endphp
							<div class="lg-product-item">
								@if ($date_entered > $today_date )
									<a class="link" href="{{route('featured.product', ['cat' =>$category->id, 'id' =>$featured->product->id] )}}">
										<div class="img"  style="background-position: top center; background-size:cover; background-image: url('{{$featured->product->picture[1]->url }}');">
			<!--
											<img src="{{$featured->product->picture[1]->url }}" width="100%" />
			-->
										</div>
										{{ ( strlen($featured->product->name) > 20 ? substr($featured->product->name, 0, 15)."..." : $featured->product->name ) }}
										<a class="link btn btn-sm btn-link float-right main-color mt-1" href="{{route('featured.category', ['cat' =>$category->id ] )}}">See more</a>
									</a>
									<div class="brand">
										<a class="link" href="{{route('pages', ['slug' =>$featured->product->listing->slug] )}}">{{$featured->product->listing->name }}</a>
									</div>
								@endif
							</div>
						@endforeach
					</div>
				@endforeach
				
			</div>
		</div>
		
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
