@php 
	$settings = App\Settings::where('name', 'logo')->get();
	$logo = $settings->last();
@endphp
	<div class="fixed-top" style="height: 75px;">
		<div class="col-12 float-left dark-grey-bg p-2">
			<a href="{{url('/')}}">
<!--
                    <img src="{{asset('assets/img/logo.svg')}}" width="180px"/>
-->				
					<img src="{{$logo->value}}" width="180px"/>
			</a>
		</div>
	</div>
	<div class="content" style="margin-top: 75px;">	
		<div class="col-12 float-left m-0 p-0">
			<div id="homeShow" class="owl-carousel" >
				@foreach($featuredcategories as $category)
						@foreach($category->featured->sortDesc()->take(1) as $featured)
						@php
							$date_entered = date_create($featured->created_at);
							$timeframe = sprintf("%d Days", $category->expiry_date);
							date_add($date_entered, date_interval_create_from_date_string($timeframe));
							$today_date = date_create('now');
						@endphp
							<div>
								@if ($date_entered > $today_date )
								<div class="today-img" style="background-image: url('{{$featured->product->picture[1]->url }}');">
		<!--
									<img src="{{$featured->product->picture[1]->url }}" class="d-block w-100" alt="...">
		-->
									<div class="col-12 desc clear-black-bg">
										<h5 class="gold font-weight-bold">{{$category->name}} </h5>
										<a class="white link font-weight-bolder" href="{{route('featured.product', ['cat' =>$category->id, 'id' =>$featured->product->id] )}}">{{ ( strlen($featured->product->name) > 20 ? substr($featured->product->name, 0, 15)."..." : $featured->product->name ) }}</a>
										<br/>
										<a class="white link" href="{{route('pages', ['slug' =>$featured->product->listing->slug] )}}">by {{$featured->product->listing->name }}</a>
										<a class="link gold float-right mt-1 mr-2" href="{{route('featured.category', ['cat' =>$category->id ] )}}">See more</a>
									</div>
								</div>
								@endif
							</div>
						@endforeach
					@endforeach
			</div>
		</div>
	</div>
	<div class="fixed-bottom" style="height: 70px;">
		<div class="col-12 float-left main-color-bg" style="padding:10px 0px 20px 0px;">
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
							<a class="nav-link gold font-weight-bolder" href="{{ route('user.dashboard') }}">Profile</a>
						</li>
					@endif
				@endauth
			</ul>
		</div>
	</div>

<!--
<script>
	alert(screen.height);
</script>
-->
