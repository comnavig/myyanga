@extends('layouts.app')
@section('title', 'Home')

@section('content')
@php 
	$settings = App\Settings::where('name', 'background_1')->get();
	$premium_page = App\Page::where('slug', 'premium')->get()->first();
	$background = $settings->last();
@endphp

<div class=" d-none d-sm-none d-lg-block" >
	<div class=" col-12 d-flex justify-content-center align-items-center" style="min-height: 220px; background-image:url('{{$background->value}}');">
		<h3 class="text-center white font-weight-bolder welcome-greeting" >
			Discover and connect with the best <br/>of African fashion and creativity, <br/>all in one spot.
			<br/><br/><a class="btn btn-lg golden-btn" href="{{route('tour')}}">Slide Tour</a>
			<br/>
		</h3>
		
	</div>
</div>

@auth
	@php
		$user = auth()->user();
	@endphp
	@if($user->type == "INDIVIDUAL")
		<div class="collapse show" id="closePCollapse">
			<div class="fixed-top d-flex justify-content-center align-items-center" style="height:100%; background-color: rgba(21,21,21, .45);">
				<div class="col-lg-3 col-md-4 col-sm-10 mx-4 white-bg">
					<div style="width: 20px; height: 20px; position: absolute; top: -15px; right: -21px;">
						<a class="btn-link main-color" data-toggle="collapse" href="#closePCollapse" role="button" aria-expanded="false" aria-controls="closeCollapse">
							<i class="bi bi-x-circle-fill"></i>
						</a>	
					</div>
					
					
					<div class="col-12 p-4">
						<center><p>{!!$premium_page->description!!}</p></center>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 m-0 p-1">
							@auth
							<a  class="btn main-color-bg btn-block rounded-0" href="{{route('premiums')}}">
								View Premium
							</a>
							@endauth
							@guest
							<a  class="btn main-color-bg btn-block rounded-0" href="{{route('login', ['redirect' => route('premiums') ] )}}">
								View Premium
							</a>
							@endguest
						</div>
						
					</div>
					 
				</div>
			</div>
		</div>
	@endif
@endauth
@guest
	<div class="collapse show" id="closePCollapse">
		<div class="fixed-top d-flex justify-content-center align-items-center" style="height:100%; background-color: rgba(21,21,21, .45);">
			<div class="col-lg-3 col-md-4 col-sm-10 mx-4 white-bg">
				<div style="width: 20px; height: 20px; position: absolute; top: -15px; right: -21px;">
					<a class="btn-link main-color" data-toggle="collapse" href="#closePCollapse" role="button" aria-expanded="false" aria-controls="closeCollapse">
						<i class="bi bi-x-circle-fill"></i>
					</a>	
				</div>
				
				
				<div class="col-12 p-4">
					<center><p>{!!$premium_page->description!!}</p></center>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 m-0 p-1">
						@auth
						<a  class="btn main-color-bg btn-block rounded-0" href="{{route('premiums')}}">
							View Premium
						</a>
						@endauth
						@guest
						<a  class="btn main-color-bg btn-block rounded-0" href="{{route('login', ['redirect' => route('premiums') ] )}}">
							View Premium
						</a>
						@endguest
					</div>
					
				</div>
				 
			</div>
		</div>
	</div>
@endguest

<div class="col-12 mt-4 d-none d-sm-none d-lg-block">
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
								<div class="img">
									<img src="{{$featured->product->picture[1]->url }}" width="100%" />
								</div>
								{{ ( strlen($featured->product->name) > 20 ? substr($featured->product->name, 0, 15)."..." : $featured->product->name ) }}
								<a class="link btn btn-sm float-right main-color btn-link mt-1" href="{{route('featured.category', ['cat' =>$category->id ] )}}">See more</a>
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

@php
 $fc = $featuredcategories->last();
 $last = $fc->featured->sortDesc()->take(1);
 $last = $last->last();
 
@endphp
<div class="col-12 p-0 m-0 d-block d-sm-block d-lg-none" style="background-image: url('{{$last->product->picture[1]->url }}'); background-size: cover; background-position: top center;">
	<div class="clear-blacker-bg d-flex justify-content-center align-items-center" style="height: 85vh;">
		<h3 class="text-center white font-weight-bolder welcome-greeting" >
			Discover and connect with the best <br/>of African fashion and creativity, <br/>all in one spot.
			<br/><br/><a class="btn btn-lg golden-btn" href="{{route('tour')}}">Slide Tour</a>
			<br/><br/><a class="btn btn-link white" href="{{route('today')}}">Enter</a>
		</h3>
	</div>
</div>

</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/owl.theme.default.min.css')}}">
	<style>
		.brand {color: #000000; height: 16px; letter-spacing: .2px; line-height: 16px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.brand .link {color: #000000; font-size: 11px; letter-spacing: .2px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.link {color: #000000; font-size: 14px; letter-spacing: .2px; line-height: 20px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.link:hover, .brand .link:hover {color: #85000b;}

		.gp-tabs { margin-bottom: 10px!important; border: 0px;}
		
		.gp-tabs .active{ color: #E1232B!important; border-radius: 0px; border: 0px; border-right: 2px solid #000000!important;}
		.gp-tabs .nav-item .nav-link{font-size: 18px; font-weight: bold; color: #000000; padding: 0rem 1rem!important;}
		.gp-tabs .nav-item .nav-link{ border-radius: 0px; border: 0px; border-right: 2px solid #000000;}
		.no-border{ border-radius: 0px;  border: 0px!important;}
		
		.gp-tabs .nav-link:hover{color: #E1232B}
		
		.tab-pane {padding:6px 0px; border-top: 2px solid #000000; border-bottom: 2px solid #000000;}
		
		.fade:not(.show) {
    display: none;
}
	</style>
@endpush
@push('scripts')
     <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
     <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
    <script>
		$(document).ready(function() {	
			$(".owl-carousel").owlCarousel({
				items:4,
				loop:true,
				margin:10,
				autoplay:true,
			});
			
		});

		new Splide( '.splide', {
				autoplay : true,
				type : 'loop',
				arrows : false,
				pagination : false,
			}).mount();
			
		function hideAndShow(hide, show)
		{
			var h = document.getElementById(hide);
			h.style.display = "none";
			
			var s = document.getElementById(show);
			s.style.display = "block";
			
		}
	</script>
@endpush
